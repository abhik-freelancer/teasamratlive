DELIMITER $$

CREATE PROCEDURE `sp_autoVoucherInsertRAWPUR`()
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
	`rawmaterial_purchase_master`.`invoice_no`,
	`rawmaterial_purchase_master`.`invoice_date`,
	`rawmaterial_purchase_master`.`companyid`,
	`rawmaterial_purchase_master`.`yearid` ,`rawmaterial_purchase_master`.`id` AS purchaseMasterId,
	(IFNULL(`rawmaterial_purchase_master`.`invoice_value`,0)) AS totalCreditAmountForVendor,
	vendor.`account_master_id` AS vendorAccountId,
	( IFNULL(`rawmaterial_purchase_master`.`item_amount`,0)
		+IFNULL(`rawmaterial_purchase_master`.`excise_amount`,0)
		+IFNULL(`rawmaterial_purchase_master`.`round_off`,0)
		) AS totalDebitPurchaseAC,
		(IFNULL(`rawmaterial_purchase_master`.`taxamount`,0)
		) AS totalDebitVATinput
	FROM `rawmaterial_purchase_master`
	INNER JOIN vendor ON `rawmaterial_purchase_master`.`vendor_id` = vendor.`id`;
	
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
	VALUES (voucherNumber,voucherDate,'Raw-Purchase-Auto','RP',2,companyId,yearId);
	
	SET @voucherId := LAST_INSERT_ID();
	-- update purchase master with voucherId
	UPDATE `rawmaterial_purchase_master`
	SET rawmaterial_purchase_master.`voucher_id` = @voucherId
	WHERE rawmaterial_purchase_master.`id`= purchaseMasterId;
	
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
 #CALL sp_autoVoucherInsertRAWPUR();