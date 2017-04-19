DELIMITER $$
CREATE PROCEDURE `sp_autoVoucherInsertRS`()
BEGIN
	DECLARE cursor_finish INTEGER DEFAULT 0;
	DECLARE voucherNumber VARCHAR(100);
	DECLARE voucherDate DATETIME;
	DECLARE narration VARCHAR(100);
	DECLARE transactionType VARCHAR(100);
	DECLARE companyId INTEGER DEFAULT 0;
	DECLARE yearId INTEGER DEFAULT 0;
	DECLARE CustomerAccountAmount DECIMAL(10,2);
	DECLARE CustomerAccId INTEGER DEFAULT 0;
	DECLARE SalesAccountAmount DECIMAL(10,2);
	DECLARE VAToutputAmount DECIMAL(10,2);
	DECLARE rawteasaleMasterId INTEGER DEFAULT 0;
	#cursor declare
	DECLARE cursor_sale CURSOR FOR 
	SELECT 
	`rawteasale_master`.`invoice_no`,
	`rawteasale_master`.`sale_date`,
	`rawteasale_master`.`company_id`,
	`rawteasale_master`.`year_id`,`rawteasale_master`.`id` AS rawTeasalemasterId,
	(IFNULL(`rawteasale_master`.`grandtotal`,0)) AS totalDebitAmountForCustomer,
	`customer`.`account_master_id` AS customerAccountId,
	((IFNULL(`rawteasale_master`.`totalamount`,0)
	+IFNULL(`rawteasale_master`.`deliverychgs`,0)
	+IFNULL(`rawteasale_master`.`roundoff`,0))
	-IFNULL(`rawteasale_master`.`discountAmount`,0)) AS totalCreditSaleAC,
	(IFNULL(`rawteasale_master`.`taxamount`,0)
		) AS totalCreditVAToutput
	FROM `rawteasale_master` 
	INNER JOIN `customer` ON `rawteasale_master`.`customer_id` = `customer`.`id`
	ORDER BY `rawteasale_master`.`invoice_no`;
	
	-- declare NOT FOUND handler
	DECLARE CONTINUE HANDLER 
	FOR NOT FOUND SET cursor_finish = 1;
	
	OPEN cursor_sale;
	get_purchase :LOOP
	
	FETCH  cursor_sale INTO voucherNumber,voucherDate,companyId,yearId,rawteasaleMasterId,CustomerAccountAmount,
	CustomerAccId,SalesAccountAmount,VAToutputAmount;
	
	IF cursor_finish = 1 THEN 
		LEAVE get_purchase;
	END IF; 	
	-- insertion section
	INSERT INTO `voucher_master`(`voucher_number`,`voucher_date`,`narration`,`transaction_type`,`created_by`,`company_id`,`year_id`)
	VALUES (voucherNumber,voucherDate,'RAWSALE-Auto','RS',2,companyId,yearId);
	
	SET @voucherId := LAST_INSERT_ID();
	-- update purchase master with voucherId
	UPDATE rawteasale_master 
	SET `rawteasale_master`.`voucher_master_id` = @voucherId
	WHERE rawteasale_master.`id`= rawteasaleMasterId;
	
	INSERT INTO `voucher_detail` (`voucher_master_id`,`account_master_id`, `voucher_amount`, `is_debit`)
	VALUES(@voucherId,CustomerAccId,CustomerAccountAmount,'Y') ; -- vendor account
	
	INSERT INTO `voucher_detail` (`voucher_master_id`,`account_master_id`, `voucher_amount`, `is_debit`)
	VALUES(@voucherId,7,SalesAccountAmount,'N') ; -- Sale Account
	IF VAToutputAmount >0 THEN
		INSERT INTO `voucher_detail` (`voucher_master_id`,`account_master_id`, `voucher_amount`, `is_debit`)
		VALUES(@voucherId,238,VAToutputAmount,'N') ;
	END IF;
	
	SET @voucherId:=0;
	
	-- SELECT voucherNumber,voucherDate,companyId,yearId,purchaseMasterId,vendorAccountAmount,vendorAccId,purchaseAccountAmount,VATinputAmount;
	 END LOOP get_purchase;
 CLOSE cursor_sale;
	
    END$$

DELIMITER ;