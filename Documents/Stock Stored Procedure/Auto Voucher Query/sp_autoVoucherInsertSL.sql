DELIMITER $$

CREATE PROCEDURE `sp_autoVoucherInsertSL`()
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
	DECLARE salesMasterId INTEGER DEFAULT 0;
	#cursor declare
	DECLARE cursor_sale CURSOR FOR 
	SELECT 
	`sale_bill_master`.`taxinvoiceno`,
	`sale_bill_master`.`taxinvoicedate`,
	`sale_bill_master`.`companyid`,
	`sale_bill_master`.`yearid`,`sale_bill_master`.`id` AS SaleMasterId,
	(IFNULL(`sale_bill_master`.`grandtotal`,0)) AS totalDebitAmountForCustomer,
	`customer`.`account_master_id` AS customerAccountId,
		(IFNULL(`sale_bill_master`.`totalamount`,0)
			-(IFNULL(`sale_bill_master`.`discountAmount`,0)
			+IFNULL(`sale_bill_master`.`deliverychgs`,0)
			+IFNULL(`sale_bill_master`.`roundoff`,0))
		) AS totalCreditSaleAC,
		(IFNULL(`sale_bill_master`.`taxamount`,0)
		) AS totalCreditVAToutput
	FROM `sale_bill_master` 
	INNER JOIN `customer` ON `sale_bill_master`.`customerId` = `customer`.`id`
	ORDER BY `sale_bill_master`.`taxinvoiceno`;
	
	-- declare NOT FOUND handler
	DECLARE CONTINUE HANDLER 
	FOR NOT FOUND SET cursor_finish = 1;
	
	OPEN cursor_sale;
	get_purchase :LOOP
	
	FETCH  cursor_sale INTO voucherNumber,voucherDate,companyId,yearId,salesMasterId,CustomerAccountAmount,
	CustomerAccId,SalesAccountAmount,VAToutputAmount;
	
	IF cursor_finish = 1 THEN 
		LEAVE get_purchase;
	END IF; 	
	-- insertion section
	INSERT INTO `voucher_master`(`voucher_number`,`voucher_date`,`narration`,`transaction_type`,`created_by`,`company_id`,`year_id`)
	VALUES (voucherNumber,voucherDate,'SALE-Auto','SL',2,companyId,yearId);
	
	SET @voucherId := LAST_INSERT_ID();
	-- update purchase master with voucherId
	UPDATE sale_bill_master 
	SET `sale_bill_master`.`voucher_master_id` = @voucherId
	WHERE sale_bill_master.`id`= salesMasterId;
	
	INSERT INTO `voucher_detail` (`voucher_master_id`,`account_master_id`, `voucher_amount`, `is_debit`)
	VALUES(@voucherId,CustomerAccId,CustomerAccountAmount,'Y') ; -- vendor account
	
	INSERT INTO `voucher_detail` (`voucher_master_id`,`account_master_id`, `voucher_amount`, `is_debit`)
	VALUES(@voucherId,7,SalesAccountAmount,'Y') ; -- Sale Account

	IF VAToutputAmount >0 THEN
		INSERT INTO `voucher_detail` (`voucher_master_id`,`account_master_id`, `voucher_amount`, `is_debit`)
		VALUES(@voucherId,201,VAToutputAmount,'Y') ;
	END IF;
	
	SET @voucherId:=0;
	
	-- SELECT voucherNumber,voucherDate,companyId,yearId,purchaseMasterId,vendorAccountAmount,vendorAccId,purchaseAccountAmount,VATinputAmount;
	 END LOOP get_purchase;
 CLOSE cursor_sale;
	
    END$$

DELIMITER ;
# CALL sp_autoVoucherInsertSL();



/*------------Correction-----------*/


DELIMITER $$
CREATE PROCEDURE `sp_autoVoucherInsertSL`()
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
	DECLARE salesMasterId INTEGER DEFAULT 0;
	#cursor declare
	DECLARE cursor_sale CURSOR FOR 
	SELECT 
	`sale_bill_master`.`taxinvoiceno`,
	`sale_bill_master`.`taxinvoicedate`,
	`sale_bill_master`.`companyid`,
	`sale_bill_master`.`yearid`,`sale_bill_master`.`id` AS SaleMasterId,
	(IFNULL(`sale_bill_master`.`grandtotal`,0)) AS totalDebitAmountForCustomer,
	`customer`.`account_master_id` AS customerAccountId,
	((IFNULL(`sale_bill_master`.`totalamount`,0)
	+IFNULL(`sale_bill_master`.`deliverychgs`,0)
	+IFNULL(`sale_bill_master`.`roundoff`,0))
	-IFNULL(`sale_bill_master`.`discountAmount`,0)) AS totalCreditSaleAC,
	(IFNULL(`sale_bill_master`.`taxamount`,0)
		) AS totalCreditVAToutput
	FROM `sale_bill_master` 
	INNER JOIN `customer` ON `sale_bill_master`.`customerId` = `customer`.`id`
	ORDER BY `sale_bill_master`.`taxinvoiceno`;
	
	-- declare NOT FOUND handler
	DECLARE CONTINUE HANDLER 
	FOR NOT FOUND SET cursor_finish = 1;
	
	OPEN cursor_sale;
	get_purchase :LOOP
	
	FETCH  cursor_sale INTO voucherNumber,voucherDate,companyId,yearId,salesMasterId,CustomerAccountAmount,
	CustomerAccId,SalesAccountAmount,VAToutputAmount;
	
	IF cursor_finish = 1 THEN 
		LEAVE get_purchase;
	END IF; 	
	-- insertion section
	INSERT INTO `voucher_master`(`voucher_number`,`voucher_date`,`narration`,`transaction_type`,`created_by`,`company_id`,`year_id`)
	VALUES (voucherNumber,voucherDate,'SALE-Auto','SL',2,companyId,yearId);
	
	SET @voucherId := LAST_INSERT_ID();
	-- update purchase master with voucherId
	UPDATE sale_bill_master 
	SET `sale_bill_master`.`voucher_master_id` = @voucherId
	WHERE sale_bill_master.`id`= salesMasterId;
	
	INSERT INTO `voucher_detail` (`voucher_master_id`,`account_master_id`, `voucher_amount`, `is_debit`)
	VALUES(@voucherId,CustomerAccId,CustomerAccountAmount,'Y') ; -- vendor account
	
	INSERT INTO `voucher_detail` (`voucher_master_id`,`account_master_id`, `voucher_amount`, `is_debit`)
	VALUES(@voucherId,7,SalesAccountAmount,'N') ; -- Sale Account

	IF VAToutputAmount >0 THEN
		INSERT INTO `voucher_detail` (`voucher_master_id`,`account_master_id`, `voucher_amount`, `is_debit`)
		VALUES(@voucherId,201,VAToutputAmount,'N') ;
	END IF;
	
	SET @voucherId:=0;
	
	-- SELECT voucherNumber,voucherDate,companyId,yearId,purchaseMasterId,vendorAccountAmount,vendorAccId,purchaseAccountAmount,VATinputAmount;
	 END LOOP get_purchase;
 CLOSE cursor_sale;
	
    END$$

DELIMITER ;























