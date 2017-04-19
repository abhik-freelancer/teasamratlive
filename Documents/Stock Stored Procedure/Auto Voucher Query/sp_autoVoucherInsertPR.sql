DELIMITER $$

CREATE PROCEDURE `sp_autoVoucherInsertPR`()
    BEGIN
	DECLARE cursor_finish INTEGER DEFAULT 0;
	DECLARE voucherNumber VARCHAR(100);
	DECLARE voucherDate DATETIME;
	DECLARE narration VARCHAR(100);
	DECLARE transactionType VARCHAR(100);
	DECLARE companyId INTEGER DEFAULT 0;
	DECLARE yearId INTEGER DEFAULT 0;
	DECLARE vendorAccountAmount DECIMAL(10,2);
	DECLARE vendorAccId INTEGER DEFAULT 0;
	DECLARE purchaseAccountAmount DECIMAL(10,2);
	DECLARE VATinputAmount DECIMAL(10,2);
	DECLARE purchaseMasterId INTEGER DEFAULT 0;
	#cursor declare
	DECLARE cursor_purchase CURSOR FOR 
	SELECT 
	`purchase_invoice_master`.`purchase_invoice_number`,
	`purchase_invoice_master`.`purchase_invoice_date`,
	`purchase_invoice_master`.`company_id`,
	`purchase_invoice_master`.`year_id` ,`purchase_invoice_master`.`id` AS purchaseMasterId,
	(IFNULL(`purchase_invoice_master`.`total`,0)) AS totalCreditAmountForVendor,
	vendor.`account_master_id` AS vendorAccountId,
	( IFNULL(`purchase_invoice_master`.`tea_value`,0)
		+IFNULL(`purchase_invoice_master`.`brokerage`,0)
		+IFNULL(`purchase_invoice_master`.`service_tax`,0)
		+IFNULL(`purchase_invoice_master`.`stamp`,0)
		+IFNULL(`purchase_invoice_master`.`other_charges`,0)
		+IFNULL(`purchase_invoice_master`.`round_off`,0)
		+IFNULL(`purchase_invoice_master`.`total_cst`,0)
		) AS totalDebitPurchaseAC,
		(IFNULL(`purchase_invoice_master`.`total_vat`,0)
		) AS totalDebitVATinput
	FROM `purchase_invoice_master` 
	INNER JOIN vendor ON `purchase_invoice_master`.`vendor_id` = vendor.`id`
	WHERE `purchase_invoice_master`.`from_where`<>'OP' AND `purchase_invoice_master`.`from_where`<>'STI';
	
	-- declare NOT FOUND handler
	DECLARE CONTINUE HANDLER 
	FOR NOT FOUND SET cursor_finish = 1;
	
	OPEN cursor_purchase;
	get_purchase :LOOP
	
	FETCH  cursor_purchase INTO voucherNumber,voucherDate,companyId,yearId,purchaseMasterId,vendorAccountAmount,
	vendorAccId,purchaseAccountAmount,VATinputAmount;
	
	IF cursor_finish = 1 THEN 
		LEAVE get_purchase;
	END IF; 	
	-- insertion section
	INSERT INTO `voucher_master`(`voucher_number`,`voucher_date`,`narration`,`transaction_type`,`created_by`,`company_id`,`year_id`)
	VALUES (voucherNumber,voucherDate,'Purchase-Auto','PR',2,companyId,yearId);
	
	SET @voucherId := LAST_INSERT_ID();
	-- update purchase master with voucherId
	UPDATE purchase_invoice_master 
	SET purchase_invoice_master.`voucher_master_id` = @voucherId
	WHERE purchase_invoice_master.`id`= purchaseMasterId;
	
	INSERT INTO `voucher_detail` (`voucher_master_id`,`account_master_id`, `voucher_amount`, `is_debit`)
	VALUES(@voucherId,vendorAccId,vendorAccountAmount,'N') ; -- vendor account
	
	INSERT INTO `voucher_detail` (`voucher_master_id`,`account_master_id`, `voucher_amount`, `is_debit`)
	VALUES(@voucherId,6,purchaseAccountAmount,'Y') ; -- Purchase Account

	IF VATinputAmount >0 THEN
		INSERT INTO `voucher_detail` (`voucher_master_id`,`account_master_id`, `voucher_amount`, `is_debit`)
		VALUES(@voucherId,5,VATinputAmount,'Y') ;
	END IF;
	
	SET @voucherId:=0;
	
	-- SELECT voucherNumber,voucherDate,companyId,yearId,purchaseMasterId,vendorAccountAmount,vendorAccId,purchaseAccountAmount,VATinputAmount;
	 END LOOP get_purchase;
 CLOSE cursor_purchase;
	
    END$$

DELIMITER ;
# CALL sp_autoVoucherInsertPR();