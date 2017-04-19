/*
SQLyog Ultimate v10.00 Beta1
MySQL - 5.6.33-cll-lve : Database - teasamrat
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`teasamrat` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `teasamrat`;

/* Procedure structure for procedure `sp_autoVoucherInsertSL` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_autoVoucherInsertSL` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`samrat`@`localhost` PROCEDURE `sp_autoVoucherInsertSL`()
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
		VALUES(@voucherId,238,VAToutputAmount,'N') ;
	END IF;
	
	SET @voucherId:=0;
	
	-- SELECT voucherNumber,voucherDate,companyId,yearId,purchaseMasterId,vendorAccountAmount,vendorAccId,purchaseAccountAmount,VATinputAmount;
	 END LOOP get_purchase;
 CLOSE cursor_sale;
	
    END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_closingbalancetransfer` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_closingbalancetransfer` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`samrat`@`localhost` PROCEDURE `sp_closingbalancetransfer`(
		CompanyId INT,
		YearId INT,
		fromDate DATETIME,
		toDate DATETIME,
		fiscalstartdate DATETIME,
		toyearId INT
		
)
BEGIN
#variable declaration
  DECLARE totdebit DECIMAL(12,2);
  DECLARE totcredit DECIMAL(12,2);
  DECLARE AccountId INT;
  DECLARE AccountName VARCHAR(50);
  DECLARE OpeningBalance DECIMAL(12,2);
  DECLARE ClosingBalance DECIMAL(12,2);
  DECLARE amount DECIMAL(12,2);
  DECLARE isdebit BIT;
  DECLARE balance DECIMAL(12,2);
  DECLARE ismaster BIT;
  
  DECLARE totdebit_String VARCHAR(50);
  DECLARE totcredit_String VARCHAR(50);
  DECLARE balance_String DECIMAL(12,2);
  DECLARE opbal DECIMAL(12,2);
  -- closing balance variable 01-12-2016
    DECLARE debitBalance DECIMAL(12,2);
	DECLARE creditBalance DECIMAL(12,2);
  -- closing balance variable 01-12-2016
  DECLARE exit_loop BOOLEAN;
-- account id fetch with opening
DECLARE MYCURSOR CURSOR FOR
        SELECT AM.account_name, IFNULL(account_opening_master.opening_balance,0) AS opening,AM.id
        FROM account_master AM
        LEFT JOIN account_opening_master 
        ON  AM.id = account_opening_master.account_master_id AND account_opening_master.financialyear_id =YearId
        INNER JOIN group_master ON AM.`group_master_id` = group_master.`id`
        INNER JOIN   group_category  ON   group_master.`group_category_id` =  group_category.`id` 
	   INNER JOIN   group_name ON group_name.`id` = group_category.`group_name_id` 
        WHERE AM.company_id=CompanyId AND group_name.`id` =3
        ORDER BY AM.account_name;
        
-- set exit_loop flag to true if there are no more rows
DECLARE CONTINUE HANDLER FOR NOT FOUND SET exit_loop = TRUE;
   
DROP TEMPORARY TABLE IF EXISTS finaltab;
CREATE TEMPORARY TABLE IF NOT EXISTS finaltab
( 
_AccountId INT(20),
_totalOpening DECIMAL(12,2),
_totalTransDebit DECIMAL(12,2),
_totalTransCredit DECIMAL(12,2),
_totalClosingDebit DECIMAL(12,2),
_totalClosingCredit DECIMAL(12,2),
_AccountName VARCHAR(100)
);

DELETE FROM `account_opening_master` WHERE `account_opening_master`.`company_id`=CompanyId 
AND `account_opening_master`.`financialyear_id`=toyearId ;
   
OPEN MYCURSOR;
account_master: LOOP
FETCH  MYCURSOR INTO AccountName,OpeningBalance,AccountId;
  SET balance :=OpeningBalance;
  SET opbal := OpeningBalance;
  
   IF fromDate > fiscalstartdate THEN
      SET totdebit:=  (SELECT  IFNULL(SUM(VD.voucher_amount ),0) 
					FROM voucher_detail VD
					INNER JOIN voucher_master VM
					ON VD.voucher_master_id =VM.id
					AND VD.is_debit ='Y' AND VD.account_master_id =AccountId
					AND VM.voucher_date >= fiscalstartdate AND VM.voucher_date < fromDate
					AND VM.company_id =CompanyId
					AND VM.year_id =YearId);
      
      SET totcredit:=  (SELECT  IFNULL(SUM(VD.voucher_amount),0) 
					FROM voucher_detail VD
					INNER JOIN voucher_master VM
					ON VD.voucher_master_id =VM.id
					AND VD.is_debit ='N' AND VD.account_master_id =AccountId
					AND VM.voucher_date >= fiscalstartdate AND VM.voucher_date < fromDate
					AND VM.company_id =CompanyId
					AND VM.year_id =YearId);
          
          SET balance := balance + totdebit - totcredit;
					SET totcredit:=0;
					SET totdebit:=0;
      
   
   END IF;
   
   SET totdebit:=  (SELECT  IFNULL(SUM(VD.voucher_amount),0) 
					FROM voucher_detail VD
					INNER JOIN voucher_master VM
					ON VD.voucher_master_id =VM.id
					AND VD.is_debit ='Y' AND VD.account_master_id =AccountId
					AND VM.voucher_date  BETWEEN fromDate AND toDate
					AND VM.company_id =CompanyId
					AND VM.year_id =YearId);
          
     SET totcredit:=  (SELECT  IFNULL(SUM(VD.voucher_amount),0) 
					FROM voucher_detail VD
					INNER JOIN voucher_master VM
					ON VD.voucher_master_id =VM.id
					AND VD.is_debit ='N' AND VD.account_master_id =AccountId
					AND VM.voucher_date  BETWEEN fromDate AND toDate
					AND VM.company_id =CompanyId
					AND VM.year_id =YearId);      
          
    SET balance:= balance + totdebit - totcredit;
    IF exit_loop THEN
         CLOSE MYCURSOR;
         LEAVE account_master;
     END IF;
	 
	 
    
			
  INSERT INTO `account_opening_master`
            (`account_master_id`,`opening_balance`,`company_id`,`financialyear_id`)
  VALUES (AccountId, balance,CompanyId,toyearId);   
	   
	   SET totcredit:=0;
	   SET totdebit:=0;
        SET balance:=0;
   
   
    
END LOOP account_master;

  
END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_GetStockWithCostRangeWise` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_GetStockWithCostRangeWise` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`samrat`@`localhost` PROCEDURE `sp_GetStockWithCostRangeWise`(
IN fromcost DECIMAL(10,2),
IN tocost DECIMAL(10,2),
IN companyId INT 
)
BEGIN	
DECLARE cursor_finish INTEGER DEFAULT 0;
DECLARE m_numofpurchaseBag DECIMAL(10,2)DEFAULT 0;
DECLARE m_purchasedKg DECIMAL(10,2)DEFAULT 0;
DECLARE m_purBagDtlId INTEGER DEFAULT 0;
DECLARE m_purchaseInvoiceDetailId INTEGER DEFAULT 0;
DECLARE stockCursor CURSOR FOR 
SELECT purchase_bag_details.`actual_bags`, 
(purchase_bag_details.`net` * purchase_bag_details.`actual_bags`) AS PurchasedKg,
purchase_bag_details.`id` AS PurchaseBagDtlId,purchase_invoice_detail.`id` AS purchaseInvoiceDtlId
FROM 
purchase_invoice_detail
INNER JOIN
purchase_bag_details
ON purchase_invoice_detail.`id`= purchase_bag_details.`purchasedtlid`
INNER JOIN `purchase_invoice_master`
ON `purchase_invoice_master`.id=purchase_invoice_detail.`purchase_master_id`
INNER JOIN
`do_to_transporter`
ON purchase_invoice_detail.`id` = do_to_transporter.`purchase_inv_dtlid`
WHERE  do_to_transporter.`in_Stock`='Y' AND (purchase_invoice_detail.`cost_of_tea` BETWEEN fromcost AND tocost) 
AND purchase_invoice_master.`company_id`= companyId;
 -- declare NOT FOUND handler
 DECLARE CONTINUE HANDLER 
 FOR NOT FOUND SET cursor_finish = 1;
DROP TEMPORARY TABLE IF EXISTS StockTable;
 
 #temptable creation
 CREATE TEMPORARY TABLE IF NOT EXISTS  StockTable
(
	purchaseBagDtlId INT,
	purchasedBag NUMERIC(10,2),
	purchasedKg  NUMERIC(10,2),
	blendedBag NUMERIC(10,2),
	blendedKg NUMERIC(10,2),
	stockOutBag NUMERIC(10,2),
	stockOutKgs NUMERIC(10,2),
	saleOutBag NUMERIC(10,2),
	saleOutKgs NUMERIC(10,2),
	stockBag  NUMERIC(10,2),
	stockKg   NUMERIC(10,2),
	purchaseInvoiceDetailId INT
	
);
 #temptable creation
 OPEN stockCursor ;
 get_stock : LOOP
 
 FETCH stockCursor INTO m_numofpurchaseBag,m_purchasedKg,m_purBagDtlId,m_purchaseInvoiceDetailId;
 
 IF cursor_finish = 1 THEN 
 LEAVE get_stock;
 END IF; 
 
 
/* Blending  bag query*/ 
#SET @m_numberofBlndBag:=0;
#SET @m_BlndKg:=0;
		#Blend bag
		SET @m_numberofBlndBag:=(SELECT IFNULL(SUM(blending_details.`number_of_blended_bag`),0) AS belendedBag 
		 FROM blending_details 
		WHERE blending_details.`purchasebag_id`= m_purBagDtlId
		GROUP BY blending_details.`purchasebag_id`);
		#Blend Bag
		#Blend Kgs
		SET @m_BlndKg:=(SELECT IFNULL(SUM(blending_details.`qty_of_bag` * blending_details.`number_of_blended_bag`),0) AS blendkg 
		 FROM blending_details 
		WHERE blending_details.`purchasebag_id`= m_purBagDtlId
		GROUP BY blending_details.`purchasebag_id`);
		#Blend Kg
IF(@m_numberofBlndBag IS NULL)THEN
	SET @m_numberofBlndBag:=0;
END IF;
IF(@m_BlndKg IS NULL) THEN
SET @m_BlndKg:=0;
END IF;
	#Stock Out bag
	SET @m_numberofStockOutBag:=(SELECT IFNULL(SUM(stocktransfer_out_detail.`num_of_stockout_bag`),0) AS stockoutBag 
		 FROM stocktransfer_out_detail 
		WHERE stocktransfer_out_detail.`purchase_bag_id`= m_purBagDtlId
		GROUP BY stocktransfer_out_detail.`purchase_bag_id`);
	#Stock Out bag
		
	#Stock Out Kgs
	SET @m_StockOutKg:=(SELECT IFNULL(SUM(stocktransfer_out_detail.`qty_stockout_kg` * stocktransfer_out_detail.`num_of_stockout_bag`),0) AS stockOutKgs 
		 FROM stocktransfer_out_detail 
		WHERE stocktransfer_out_detail.`purchase_bag_id`= m_purBagDtlId
		GROUP BY stocktransfer_out_detail.`purchase_bag_id`);
	#Stock Out Kgs
IF(@m_numberofStockOutBag IS NULL)THEN
	SET @m_numberofStockOutBag:=0;
END IF;
IF(@m_StockOutKg IS NULL) THEN
SET @m_StockOutKg:=0;
END IF;
		#Raw Tea Sale Bag
		SET @m_numberofSaleOutBag:=(SELECT IFNULL(SUM(rawteasale_detail.`num_of_sale_bag`),0) AS saleBag 
		 FROM rawteasale_detail 
		WHERE rawteasale_detail.`purchase_bag_id`= m_purBagDtlId
		GROUP BY rawteasale_detail.`purchase_bag_id`);
		#Raw Tea Sale Bag
		
		#Raw Tea Sale Kgs
		SET @m_SaleOutKg:=(SELECT IFNULL(SUM(rawteasale_detail.`qty_of_sale_bag` * rawteasale_detail.`num_of_sale_bag`),0) AS SaleKgs 
		 FROM rawteasale_detail 
		WHERE rawteasale_detail.`purchase_bag_id`= m_purBagDtlId
		GROUP BY rawteasale_detail.`purchase_bag_id`);
		#Raw Tea Sale Kgs
		
IF(@m_numberofSaleOutBag IS NULL)THEN
	SET @m_numberofSaleOutBag:=0;
END IF;
IF(@m_SaleOutKg IS NULL) THEN
SET @m_SaleOutKg:=0;
END IF;
SET @m_StockBag:=(m_numofpurchaseBag - (@m_numberofBlndBag+@m_numberofStockOutBag+@m_numberofSaleOutBag));
SET @m_StockKg:=(m_purchasedKg - (@m_BlndKg+@m_StockOutKg+@m_SaleOutKg));
INSERT INTO StockTable
(
	purchaseBagDtlId ,
	purchasedBag ,
	purchasedKg ,
	blendedBag ,
	blendedKg ,
	stockOutBag,
	stockOutKgs,
	saleOutBag,
	saleOutKgs,
	stockBag  ,
	stockKg  ,purchaseInvoiceDetailId 	
)VALUES(m_purBagDtlId,m_numofpurchaseBag,m_purchasedKg,@m_numberofBlndBag,@m_BlndKg,@m_numberofStockOutBag,@m_StockOutKg,@m_numberofSaleOutBag,@m_SaleOutKg,@m_StockBag,@m_StockKg,m_purchaseInvoiceDetailId);
 END LOOP get_stock;
 CLOSE stockCursor;
#Stock Print Start
SELECT StockTable.purchaseInvoiceDetailId,
StockTable.purchaseBagDtlId,
 StockTable.stockBag AS NumberOfStockBag,StockTable.stockKg AS StockBagQty,
 StockTable.purchasedBag AS PurchasedBags,StockTable.purchasedKg AS PurchasedKgs,
 StockTable.blendedBag AS BlendedBags,StockTable.blendedKg AS BlendedKgs,
 StockTable.stockOutBag AS StockOutBag,StockTable.stockOutKgs AS StockOutKgs,
 StockTable.saleOutBag AS SaleOutBag,StockTable.saleOutKgs AS SaleOutKgs,
 `garden_master`.`garden_name`,`purchase_invoice_detail`.`invoice_number`,`purchase_invoice_detail`.`lot`,
 `teagroup_master`.`group_code`,`purchase_invoice_master`.`sale_number`,`grade_master`.`grade`,
 `purchase_invoice_master`.`purchase_invoice_date`,`purchase_invoice_master`.`purchase_invoice_number`,
 `purchase_invoice_detail`.`cost_of_tea`,`location`.`location`,purchase_bag_details.`net` AS netKgs,
 `purchase_invoice_detail`.`price` AS rate
 FROM StockTable
INNER JOIN  `purchase_invoice_detail` ON StockTable.purchaseInvoiceDetailId=`purchase_invoice_detail`.`id`
INNER JOIN  `purchase_invoice_master` ON `purchase_invoice_detail`.`purchase_master_id` = `purchase_invoice_master`.`id`
INNER JOIN `garden_master` ON `purchase_invoice_detail`.`garden_id` = `garden_master`.`id`
INNER JOIN `teagroup_master` ON `purchase_invoice_detail`.`teagroup_master_id` = `teagroup_master`.`id`
INNER JOIN `grade_master` ON `purchase_invoice_detail`.`grade_id` = `grade_master`.`id`
INNER JOIN `purchase_bag_details` ON StockTable.purchaseBagDtlId = `purchase_bag_details`.`id`
INNER JOIN `do_to_transporter` ON StockTable.purchaseInvoiceDetailId= do_to_transporter.`purchase_inv_dtlid`
INNER JOIN `location` ON `do_to_transporter`.`locationId` = `location`.`id`
GROUP BY StockTable.purchaseBagDtlId
ORDER BY `purchase_invoice_detail`.`teagroup_master_id`,StockTable.purchaseInvoiceDetailId;
#Stock Print END
 END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_GetStockWithGroupAndCost` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_GetStockWithGroupAndCost` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`samrat`@`localhost` PROCEDURE `sp_GetStockWithGroupAndCost`(
IN teagroupId INT,
IN fromcost DECIMAL(10,2),
IN tocost DECIMAL(10,2),
IN companyId INT 
)
BEGIN	
DECLARE cursor_finish INTEGER DEFAULT 0;
DECLARE m_numofpurchaseBag DECIMAL(10,2)DEFAULT 0;
DECLARE m_purchasedKg DECIMAL(10,2)DEFAULT 0;
DECLARE m_purBagDtlId INTEGER DEFAULT 0;
DECLARE m_purchaseInvoiceDetailId INTEGER DEFAULT 0;
DECLARE stockCursor CURSOR FOR 
SELECT purchase_bag_details.`actual_bags`, 
(purchase_bag_details.`net` * purchase_bag_details.`actual_bags`) AS PurchasedKg,
purchase_bag_details.`id` AS PurchaseBagDtlId,purchase_invoice_detail.`id` AS purchaseInvoiceDtlId
FROM 
purchase_invoice_detail
INNER JOIN
purchase_bag_details
ON purchase_invoice_detail.`id`= purchase_bag_details.`purchasedtlid`
INNER JOIN `purchase_invoice_master`
ON `purchase_invoice_master`.id=purchase_invoice_detail.`purchase_master_id`
INNER JOIN
`do_to_transporter`
ON purchase_invoice_detail.`id` = do_to_transporter.`purchase_inv_dtlid`
WHERE purchase_invoice_detail.`teagroup_master_id`= teagroupId
AND do_to_transporter.`in_Stock`='Y' AND (purchase_invoice_detail.`cost_of_tea` BETWEEN fromcost AND tocost)
AND purchase_invoice_master.`company_id`= companyId;
 -- declare NOT FOUND handler
 DECLARE CONTINUE HANDLER 
 FOR NOT FOUND SET cursor_finish = 1;
DROP TEMPORARY TABLE IF EXISTS StockTable;
 
#temptable creation
 CREATE TEMPORARY TABLE IF NOT EXISTS  StockTable
(
	purchaseBagDtlId INT,
	purchasedBag NUMERIC(10,2),
	purchasedKg  NUMERIC(10,2),
	blendedBag NUMERIC(10,2),
	blendedKg NUMERIC(10,2),
	stockOutBag NUMERIC(10,2),
	stockOutKgs NUMERIC(10,2),
	saleOutBag NUMERIC(10,2),
	saleOutKgs NUMERIC(10,2),
	stockBag  NUMERIC(10,2),
	stockKg   NUMERIC(10,2),
	purchaseInvoiceDetailId INT
	
);
 #temptable creation
 OPEN stockCursor ;
 get_stock : LOOP
 
 FETCH stockCursor INTO m_numofpurchaseBag,m_purchasedKg,m_purBagDtlId,m_purchaseInvoiceDetailId;
 
 IF cursor_finish = 1 THEN 
 LEAVE get_stock;
 END IF; 
 
 
/* Blending  bag query*/ 
#SET @m_numberofBlndBag:=0;
#SET @m_BlndKg:=0;
		#Blend bag
		SET @m_numberofBlndBag:=(SELECT IFNULL(SUM(blending_details.`number_of_blended_bag`),0) AS belendedBag 
		 FROM blending_details 
		WHERE blending_details.`purchasebag_id`= m_purBagDtlId
		GROUP BY blending_details.`purchasebag_id`);
		#Blend Bag
		#Blend Kgs
		SET @m_BlndKg:=(SELECT IFNULL(SUM(blending_details.`qty_of_bag` * blending_details.`number_of_blended_bag`),0) AS blendkg 
		 FROM blending_details 
		WHERE blending_details.`purchasebag_id`= m_purBagDtlId
		GROUP BY blending_details.`purchasebag_id`);
		#Blend Kg
IF(@m_numberofBlndBag IS NULL)THEN
	SET @m_numberofBlndBag:=0;
END IF;
IF(@m_BlndKg IS NULL) THEN
SET @m_BlndKg:=0;
END IF;
	#Stock Out bag
	SET @m_numberofStockOutBag:=(SELECT IFNULL(SUM(stocktransfer_out_detail.`num_of_stockout_bag`),0) AS stockoutBag 
		 FROM stocktransfer_out_detail 
		WHERE stocktransfer_out_detail.`purchase_bag_id`= m_purBagDtlId
		GROUP BY stocktransfer_out_detail.`purchase_bag_id`);
	#Stock Out bag
		
	#Stock Out Kgs
	SET @m_StockOutKg:=(SELECT IFNULL(SUM(stocktransfer_out_detail.`qty_stockout_kg` * stocktransfer_out_detail.`num_of_stockout_bag`),0) AS stockOutKgs 
		 FROM stocktransfer_out_detail 
		WHERE stocktransfer_out_detail.`purchase_bag_id`= m_purBagDtlId
		GROUP BY stocktransfer_out_detail.`purchase_bag_id`);
	#Stock Out Kgs
IF(@m_numberofStockOutBag IS NULL)THEN
	SET @m_numberofStockOutBag:=0;
END IF;
IF(@m_StockOutKg IS NULL) THEN
SET @m_StockOutKg:=0;
END IF;
		#Raw Tea Sale Bag
		SET @m_numberofSaleOutBag:=(SELECT IFNULL(SUM(rawteasale_detail.`num_of_sale_bag`),0) AS saleBag 
		 FROM rawteasale_detail 
		WHERE rawteasale_detail.`purchase_bag_id`= m_purBagDtlId
		GROUP BY rawteasale_detail.`purchase_bag_id`);
		#Raw Tea Sale Bag
		
		#Raw Tea Sale Kgs
		SET @m_SaleOutKg:=(SELECT IFNULL(SUM(rawteasale_detail.`qty_of_sale_bag` * rawteasale_detail.`num_of_sale_bag`),0) AS SaleKgs 
		 FROM rawteasale_detail 
		WHERE rawteasale_detail.`purchase_bag_id`= m_purBagDtlId
		GROUP BY rawteasale_detail.`purchase_bag_id`);
		#Raw Tea Sale Kgs
		
IF(@m_numberofSaleOutBag IS NULL)THEN
	SET @m_numberofSaleOutBag:=0;
END IF;
IF(@m_SaleOutKg IS NULL) THEN
SET @m_SaleOutKg:=0;
END IF;
SET @m_StockBag:=(m_numofpurchaseBag - (@m_numberofBlndBag+@m_numberofStockOutBag+@m_numberofSaleOutBag));
SET @m_StockKg:=(m_purchasedKg - (@m_BlndKg+@m_StockOutKg+@m_SaleOutKg));
INSERT INTO StockTable
(
	purchaseBagDtlId ,
	purchasedBag ,
	purchasedKg ,
	blendedBag ,
	blendedKg ,
	stockOutBag,
	stockOutKgs,
	saleOutBag,
	saleOutKgs,
	stockBag  ,
	stockKg  ,purchaseInvoiceDetailId 	
)VALUES(m_purBagDtlId,m_numofpurchaseBag,m_purchasedKg,@m_numberofBlndBag,@m_BlndKg,@m_numberofStockOutBag,@m_StockOutKg,@m_numberofSaleOutBag,@m_SaleOutKg,@m_StockBag,@m_StockKg,m_purchaseInvoiceDetailId);
 END LOOP get_stock;
 CLOSE stockCursor;
#Stock Print Start
SELECT StockTable.purchaseInvoiceDetailId,
StockTable.purchaseBagDtlId,
 StockTable.stockBag AS NumberOfStockBag,StockTable.stockKg AS StockBagQty,
 StockTable.purchasedBag AS PurchasedBags,StockTable.purchasedKg AS PurchasedKgs,
 StockTable.blendedBag AS BlendedBags,StockTable.blendedKg AS BlendedKgs,
 StockTable.stockOutBag AS StockOutBag,StockTable.stockOutKgs AS StockOutKgs,
 StockTable.saleOutBag AS SaleOutBag,StockTable.saleOutKgs AS SaleOutKgs,
 `garden_master`.`garden_name`,`purchase_invoice_detail`.`invoice_number`,`purchase_invoice_detail`.`lot`,
 `teagroup_master`.`group_code`,`purchase_invoice_master`.`sale_number`,`grade_master`.`grade`,
 `purchase_invoice_master`.`purchase_invoice_date`,`purchase_invoice_master`.`purchase_invoice_number`,
 `purchase_invoice_detail`.`cost_of_tea`,`location`.`location`,purchase_bag_details.`net` AS netKgs,
 `purchase_invoice_detail`.`price` AS rate
 FROM StockTable
INNER JOIN  `purchase_invoice_detail` ON StockTable.purchaseInvoiceDetailId=`purchase_invoice_detail`.`id`
INNER JOIN  `purchase_invoice_master` ON `purchase_invoice_detail`.`purchase_master_id` = `purchase_invoice_master`.`id`
INNER JOIN `garden_master` ON `purchase_invoice_detail`.`garden_id` = `garden_master`.`id`
INNER JOIN `teagroup_master` ON `purchase_invoice_detail`.`teagroup_master_id` = `teagroup_master`.`id`
INNER JOIN `grade_master` ON `purchase_invoice_detail`.`grade_id` = `grade_master`.`id`
INNER JOIN `purchase_bag_details` ON StockTable.purchaseBagDtlId = `purchase_bag_details`.`id`
INNER JOIN `do_to_transporter` ON StockTable.purchaseInvoiceDetailId= do_to_transporter.`purchase_inv_dtlid`
INNER JOIN `location` ON `do_to_transporter`.`locationId` = `location`.`id`
GROUP BY StockTable.purchaseBagDtlId
ORDER BY `purchase_invoice_detail`.`teagroup_master_id`,StockTable.purchaseInvoiceDetailId;
#Stock Print END
 END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_GetStockWithGroupWise` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_GetStockWithGroupWise` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`samrat`@`localhost` PROCEDURE `sp_GetStockWithGroupWise`(
IN teagroupId INT,
IN companyId INT 
)
BEGIN	
DECLARE cursor_finish INTEGER DEFAULT 0;
DECLARE m_numofpurchaseBag DECIMAL(10,2)DEFAULT 0;
DECLARE m_purchasedKg DECIMAL(10,2)DEFAULT 0;
DECLARE m_purBagDtlId INTEGER DEFAULT 0;
DECLARE m_purchaseInvoiceDetailId INTEGER DEFAULT 0;
DECLARE stockCursor CURSOR FOR 
SELECT purchase_bag_details.`actual_bags`, 
(purchase_bag_details.`net` * purchase_bag_details.`actual_bags`) AS PurchasedKg,
purchase_bag_details.`id` AS PurchaseBagDtlId,purchase_invoice_detail.`id` AS purchaseInvoiceDtlId
FROM 
purchase_invoice_detail
INNER JOIN
purchase_bag_details
ON purchase_invoice_detail.`id`= purchase_bag_details.`purchasedtlid`
INNER JOIN `purchase_invoice_master`
ON `purchase_invoice_master`.id=purchase_invoice_detail.`purchase_master_id`
INNER JOIN
`do_to_transporter`
ON purchase_invoice_detail.`id` = do_to_transporter.`purchase_inv_dtlid`
WHERE purchase_invoice_detail.`teagroup_master_id`= teagroupId
AND do_to_transporter.`in_Stock`='Y'
AND purchase_invoice_master.`company_id`= companyId;
 -- declare NOT FOUND handler
 DECLARE CONTINUE HANDLER 
 FOR NOT FOUND SET cursor_finish = 1;
DROP TEMPORARY TABLE IF EXISTS StockTable;
 
#temptable creation
 CREATE TEMPORARY TABLE IF NOT EXISTS  StockTable
(
	purchaseBagDtlId INT,
	purchasedBag NUMERIC(10,2),
	purchasedKg  NUMERIC(10,2),
	blendedBag NUMERIC(10,2),
	blendedKg NUMERIC(10,2),
	stockOutBag NUMERIC(10,2),
	stockOutKgs NUMERIC(10,2),
	saleOutBag NUMERIC(10,2),
	saleOutKgs NUMERIC(10,2),
	stockBag  NUMERIC(10,2),
	stockKg   NUMERIC(10,2),
	purchaseInvoiceDetailId INT
	
);
 #temptable creation
 OPEN stockCursor ;
 get_stock : LOOP
 
 FETCH stockCursor INTO m_numofpurchaseBag,m_purchasedKg,m_purBagDtlId,m_purchaseInvoiceDetailId;
 
 IF cursor_finish = 1 THEN 
 LEAVE get_stock;
 END IF; 
 
 
/* Blending  bag query*/ 
#SET @m_numberofBlndBag:=0;
#SET @m_BlndKg:=0;
		#Blend bag
		SET @m_numberofBlndBag:=(SELECT IFNULL(SUM(blending_details.`number_of_blended_bag`),0) AS belendedBag 
		 FROM blending_details 
		WHERE blending_details.`purchasebag_id`= m_purBagDtlId
		GROUP BY blending_details.`purchasebag_id`);
		#Blend Bag
		#Blend Kgs
		SET @m_BlndKg:=(SELECT IFNULL(SUM(blending_details.`qty_of_bag` * blending_details.`number_of_blended_bag`),0) AS blendkg 
		 FROM blending_details 
		WHERE blending_details.`purchasebag_id`= m_purBagDtlId
		GROUP BY blending_details.`purchasebag_id`);
		#Blend Kg
IF(@m_numberofBlndBag IS NULL)THEN
	SET @m_numberofBlndBag:=0;
END IF;
IF(@m_BlndKg IS NULL) THEN
SET @m_BlndKg:=0;
END IF;
	#Stock Out bag
	SET @m_numberofStockOutBag:=(SELECT IFNULL(SUM(stocktransfer_out_detail.`num_of_stockout_bag`),0) AS stockoutBag 
		 FROM stocktransfer_out_detail 
		WHERE stocktransfer_out_detail.`purchase_bag_id`= m_purBagDtlId
		GROUP BY stocktransfer_out_detail.`purchase_bag_id`);
	#Stock Out bag
		
	#Stock Out Kgs
	SET @m_StockOutKg:=(SELECT IFNULL(SUM(stocktransfer_out_detail.`qty_stockout_kg` * stocktransfer_out_detail.`num_of_stockout_bag`),0) AS stockOutKgs 
		 FROM stocktransfer_out_detail 
		WHERE stocktransfer_out_detail.`purchase_bag_id`= m_purBagDtlId
		GROUP BY stocktransfer_out_detail.`purchase_bag_id`);
	#Stock Out Kgs
IF(@m_numberofStockOutBag IS NULL)THEN
	SET @m_numberofStockOutBag:=0;
END IF;
IF(@m_StockOutKg IS NULL) THEN
SET @m_StockOutKg:=0;
END IF;
		#Raw Tea Sale Bag
		SET @m_numberofSaleOutBag:=(SELECT IFNULL(SUM(rawteasale_detail.`num_of_sale_bag`),0) AS saleBag 
		 FROM rawteasale_detail 
		WHERE rawteasale_detail.`purchase_bag_id`= m_purBagDtlId
		GROUP BY rawteasale_detail.`purchase_bag_id`);
		#Raw Tea Sale Bag
		
		#Raw Tea Sale Kgs
		SET @m_SaleOutKg:=(SELECT IFNULL(SUM(rawteasale_detail.`qty_of_sale_bag` * rawteasale_detail.`num_of_sale_bag`),0) AS SaleKgs 
		 FROM rawteasale_detail 
		WHERE rawteasale_detail.`purchase_bag_id`= m_purBagDtlId
		GROUP BY rawteasale_detail.`purchase_bag_id`);
		#Raw Tea Sale Kgs
		
IF(@m_numberofSaleOutBag IS NULL)THEN
	SET @m_numberofSaleOutBag:=0;
END IF;
IF(@m_SaleOutKg IS NULL) THEN
SET @m_SaleOutKg:=0;
END IF;
SET @m_StockBag:=(m_numofpurchaseBag - (@m_numberofBlndBag+@m_numberofStockOutBag+@m_numberofSaleOutBag));
SET @m_StockKg:=(m_purchasedKg - (@m_BlndKg+@m_StockOutKg+@m_SaleOutKg));
INSERT INTO StockTable
(
	purchaseBagDtlId ,
	purchasedBag ,
	purchasedKg ,
	blendedBag ,
	blendedKg ,
	stockOutBag,
	stockOutKgs,
	saleOutBag,
	saleOutKgs,
	stockBag  ,
	stockKg  ,purchaseInvoiceDetailId 	
)VALUES(m_purBagDtlId,m_numofpurchaseBag,m_purchasedKg,@m_numberofBlndBag,@m_BlndKg,@m_numberofStockOutBag,@m_StockOutKg,@m_numberofSaleOutBag,@m_SaleOutKg,@m_StockBag,@m_StockKg,m_purchaseInvoiceDetailId);
 END LOOP get_stock;
 CLOSE stockCursor;
#Stock Print Start
SELECT StockTable.purchaseInvoiceDetailId,
StockTable.purchaseBagDtlId,
 StockTable.stockBag AS NumberOfStockBag,StockTable.stockKg AS StockBagQty,
 StockTable.purchasedBag AS PurchasedBags,StockTable.purchasedKg AS PurchasedKgs,
 StockTable.blendedBag AS BlendedBags,StockTable.blendedKg AS BlendedKgs,
 StockTable.stockOutBag AS StockOutBag,StockTable.stockOutKgs AS StockOutKgs,
 StockTable.saleOutBag AS SaleOutBag,StockTable.saleOutKgs AS SaleOutKgs,
 `garden_master`.`garden_name`,`purchase_invoice_detail`.`invoice_number`,`purchase_invoice_detail`.`lot`,
 `teagroup_master`.`group_code`,`purchase_invoice_master`.`sale_number`,`grade_master`.`grade`,
 `purchase_invoice_master`.`purchase_invoice_date`,`purchase_invoice_master`.`purchase_invoice_number`,
 `purchase_invoice_detail`.`cost_of_tea`,`location`.`location`,purchase_bag_details.`net` AS netKgs,
 `purchase_invoice_detail`.`price` AS rate
 FROM StockTable
INNER JOIN  `purchase_invoice_detail` ON StockTable.purchaseInvoiceDetailId=`purchase_invoice_detail`.`id`
INNER JOIN  `purchase_invoice_master` ON `purchase_invoice_detail`.`purchase_master_id` = `purchase_invoice_master`.`id`
INNER JOIN `garden_master` ON `purchase_invoice_detail`.`garden_id` = `garden_master`.`id`
INNER JOIN `teagroup_master` ON `purchase_invoice_detail`.`teagroup_master_id` = `teagroup_master`.`id`
INNER JOIN `grade_master` ON `purchase_invoice_detail`.`grade_id` = `grade_master`.`id`
INNER JOIN `purchase_bag_details` ON StockTable.purchaseBagDtlId = `purchase_bag_details`.`id`
INNER JOIN `do_to_transporter` ON StockTable.purchaseInvoiceDetailId= do_to_transporter.`purchase_inv_dtlid`
INNER JOIN `location` ON `do_to_transporter`.`locationId` = `location`.`id`
GROUP BY StockTable.purchaseBagDtlId
ORDER BY `purchase_invoice_detail`.`teagroup_master_id`,StockTable.purchaseInvoiceDetailId;
#Stock Print END
 END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_GetStockWithoutGroupAndCost` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_GetStockWithoutGroupAndCost` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`samrat`@`localhost` PROCEDURE `sp_GetStockWithoutGroupAndCost`(
IN companyId INT 
)
BEGIN	
DECLARE cursor_finish INTEGER DEFAULT 0;
DECLARE m_numofpurchaseBag DECIMAL(10,2)DEFAULT 0;
DECLARE m_purchasedKg DECIMAL(10,2)DEFAULT 0;
DECLARE m_purBagDtlId INTEGER DEFAULT 0;
DECLARE m_purchaseInvoiceDetailId INTEGER DEFAULT 0;
DECLARE stockCursor CURSOR FOR 
SELECT purchase_bag_details.`actual_bags`, 
(purchase_bag_details.`net` * purchase_bag_details.`actual_bags`) AS PurchasedKg,
purchase_bag_details.`id` AS PurchaseBagDtlId,purchase_invoice_detail.`id` AS purchaseInvoiceDtlId
FROM 
purchase_invoice_detail
INNER JOIN
purchase_bag_details
ON purchase_invoice_detail.`id`= purchase_bag_details.`purchasedtlid`
INNER JOIN `purchase_invoice_master`
ON `purchase_invoice_master`.id=purchase_invoice_detail.`purchase_master_id`
INNER JOIN
`do_to_transporter`
ON purchase_invoice_detail.`id` = do_to_transporter.`purchase_inv_dtlid`
WHERE 
 do_to_transporter.`in_Stock`='Y' AND purchase_invoice_master.`company_id`= companyId;
 -- declare NOT FOUND handler
 DECLARE CONTINUE HANDLER 
 FOR NOT FOUND SET cursor_finish = 1;
DROP TEMPORARY TABLE IF EXISTS StockTable;
 
 #temptable creation
 CREATE TEMPORARY TABLE IF NOT EXISTS  StockTable
(
	purchaseBagDtlId INT,
	purchasedBag NUMERIC(10,2),
	purchasedKg  NUMERIC(10,2),
	blendedBag NUMERIC(10,2),
	blendedKg NUMERIC(10,2),
	stockOutBag NUMERIC(10,2),
	stockOutKgs NUMERIC(10,2),
	saleOutBag NUMERIC(10,2),
	saleOutKgs NUMERIC(10,2),
	stockBag  NUMERIC(10,2),
	stockKg   NUMERIC(10,2),
	purchaseInvoiceDetailId INT
	
);
 #temptable creation
 OPEN stockCursor ;
 get_stock : LOOP
 
 FETCH stockCursor INTO m_numofpurchaseBag,m_purchasedKg,m_purBagDtlId,m_purchaseInvoiceDetailId;
 
 IF cursor_finish = 1 THEN 
 LEAVE get_stock;
 END IF; 
 
 
/* Blending  bag query*/ 
#SET @m_numberofBlndBag:=0;
#SET @m_BlndKg:=0;
		#Blend bag
		SET @m_numberofBlndBag:=(SELECT IFNULL(SUM(blending_details.`number_of_blended_bag`),0) AS belendedBag 
		 FROM blending_details 
		WHERE blending_details.`purchasebag_id`= m_purBagDtlId
		GROUP BY blending_details.`purchasebag_id`);
		#Blend Bag
		#Blend Kgs
		SET @m_BlndKg:=(SELECT IFNULL(SUM(blending_details.`qty_of_bag` * blending_details.`number_of_blended_bag`),0) AS blendkg 
		 FROM blending_details 
		WHERE blending_details.`purchasebag_id`= m_purBagDtlId
		GROUP BY blending_details.`purchasebag_id`);
		#Blend Kg
IF(@m_numberofBlndBag IS NULL)THEN
	SET @m_numberofBlndBag:=0;
END IF;
IF(@m_BlndKg IS NULL) THEN
SET @m_BlndKg:=0;
END IF;
	#Stock Out bag
	SET @m_numberofStockOutBag:=(SELECT IFNULL(SUM(stocktransfer_out_detail.`num_of_stockout_bag`),0) AS stockoutBag 
		 FROM stocktransfer_out_detail 
		WHERE stocktransfer_out_detail.`purchase_bag_id`= m_purBagDtlId
		GROUP BY stocktransfer_out_detail.`purchase_bag_id`);
	#Stock Out bag
		
	#Stock Out Kgs
	SET @m_StockOutKg:=(SELECT IFNULL(SUM(stocktransfer_out_detail.`qty_stockout_kg` * stocktransfer_out_detail.`num_of_stockout_bag`),0) AS stockOutKgs 
		 FROM stocktransfer_out_detail 
		WHERE stocktransfer_out_detail.`purchase_bag_id`= m_purBagDtlId
		GROUP BY stocktransfer_out_detail.`purchase_bag_id`);
	#Stock Out Kgs
IF(@m_numberofStockOutBag IS NULL)THEN
	SET @m_numberofStockOutBag:=0;
END IF;
IF(@m_StockOutKg IS NULL) THEN
SET @m_StockOutKg:=0;
END IF;
		#Raw Tea Sale Bag
		SET @m_numberofSaleOutBag:=(SELECT IFNULL(SUM(rawteasale_detail.`num_of_sale_bag`),0) AS saleBag 
		 FROM rawteasale_detail 
		WHERE rawteasale_detail.`purchase_bag_id`= m_purBagDtlId
		GROUP BY rawteasale_detail.`purchase_bag_id`);
		#Raw Tea Sale Bag
		
		#Raw Tea Sale Kgs
		SET @m_SaleOutKg:=(SELECT IFNULL(SUM(rawteasale_detail.`qty_of_sale_bag` * rawteasale_detail.`num_of_sale_bag`),0) AS SaleKgs 
		 FROM rawteasale_detail 
		WHERE rawteasale_detail.`purchase_bag_id`= m_purBagDtlId
		GROUP BY rawteasale_detail.`purchase_bag_id`);
		#Raw Tea Sale Kgs
		
IF(@m_numberofSaleOutBag IS NULL)THEN
	SET @m_numberofSaleOutBag:=0;
END IF;
IF(@m_SaleOutKg IS NULL) THEN
SET @m_SaleOutKg:=0;
END IF;
SET @m_StockBag:=(m_numofpurchaseBag - (@m_numberofBlndBag+@m_numberofStockOutBag+@m_numberofSaleOutBag));
SET @m_StockKg:=(m_purchasedKg - (@m_BlndKg+@m_StockOutKg+@m_SaleOutKg));
INSERT INTO StockTable
(
	purchaseBagDtlId ,
	purchasedBag ,
	purchasedKg ,
	blendedBag ,
	blendedKg ,
	stockOutBag,
	stockOutKgs,
	saleOutBag,
	saleOutKgs,
	stockBag  ,
	stockKg  ,purchaseInvoiceDetailId 	
)VALUES(m_purBagDtlId,m_numofpurchaseBag,m_purchasedKg,@m_numberofBlndBag,@m_BlndKg,@m_numberofStockOutBag,@m_StockOutKg,@m_numberofSaleOutBag,@m_SaleOutKg,@m_StockBag,@m_StockKg,m_purchaseInvoiceDetailId);
 END LOOP get_stock;
 CLOSE stockCursor;
#Stock Print Start
SELECT StockTable.purchaseInvoiceDetailId,
StockTable.purchaseBagDtlId,
StockTable.stockBag AS NumberOfStockBag,StockTable.stockKg AS StockBagQty,
 StockTable.purchasedBag AS PurchasedBags,StockTable.purchasedKg AS PurchasedKgs,
 StockTable.blendedBag AS BlendedBags,StockTable.blendedKg AS BlendedKgs,
 StockTable.stockOutBag AS StockOutBag,StockTable.stockOutKgs AS StockOutKgs,
 StockTable.saleOutBag AS SaleOutBag,StockTable.saleOutKgs AS SaleOutKgs,
 `garden_master`.`garden_name`,`purchase_invoice_detail`.`invoice_number`,`purchase_invoice_detail`.`lot`,
 `teagroup_master`.`group_code`,`purchase_invoice_master`.`sale_number`,`grade_master`.`grade`,
 `purchase_invoice_master`.`purchase_invoice_date`,`purchase_invoice_master`.`purchase_invoice_number`,
 `purchase_invoice_detail`.`cost_of_tea`,`location`.`location`,purchase_bag_details.`net` AS netKgs,
 `purchase_invoice_detail`.`price` AS rate
 FROM StockTable
INNER JOIN  `purchase_invoice_detail` ON StockTable.purchaseInvoiceDetailId=`purchase_invoice_detail`.`id`
INNER JOIN  `purchase_invoice_master` ON `purchase_invoice_detail`.`purchase_master_id` = `purchase_invoice_master`.`id`
INNER JOIN `garden_master` ON `purchase_invoice_detail`.`garden_id` = `garden_master`.`id`
INNER JOIN `teagroup_master` ON `purchase_invoice_detail`.`teagroup_master_id` = `teagroup_master`.`id`
INNER JOIN `grade_master` ON `purchase_invoice_detail`.`grade_id` = `grade_master`.`id`
INNER JOIN `purchase_bag_details` ON StockTable.purchaseBagDtlId = `purchase_bag_details`.`id`
INNER JOIN `do_to_transporter` ON StockTable.purchaseInvoiceDetailId= do_to_transporter.`purchase_inv_dtlid`
INNER JOIN `location` ON `do_to_transporter`.`locationId` = `location`.`id`
GROUP BY StockTable.purchaseBagDtlId
ORDER BY `purchase_invoice_detail`.`teagroup_master_id`,StockTable.purchaseInvoiceDetailId;
#Stock Print END
 END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_groupwise_stock` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_groupwise_stock` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`samrat`@`localhost` PROCEDURE `sp_groupwise_stock`(
 IN teagroup INT(10)
)
BEGIN	
SELECT PID.`id` AS purchaseDtl,PBD.`id` AS purchaseBagDtlId,
`blending_details`.`id`,
PID.`teagroup_master_id`,PID.`invoice_number`,PID.`lot`,PIM.`sale_number`,garden_master.`garden_name`,grade_master.`grade`,location.`location`,teagroup_master.`group_code`,
PID.`price`,PID.`cost_of_tea`,PBD.`actual_bags`,PBD.`net`,PBD.`shortkg`,`blending_details`.`number_of_blended_bag`,`blending_details`.`qty_of_bag`,
(IF(PBD.`actual_bags` IS NULL, 0,PBD.`actual_bags`) -
 IF(`blending_details`.`number_of_blended_bag` IS NULL,0,`blending_details`.`number_of_blended_bag`)) AS NumberOfStockBag,
((
IF(PBD.`actual_bags`IS NULL,0,PBD.`actual_bags`)* IF(PBD.net IS NULL,0,PBD.net))-
(IF(`blending_details`.`number_of_blended_bag`IS NULL,0,`blending_details`.`number_of_blended_bag`)*
IF(`blending_details`.`qty_of_bag`IS NULL,0,`blending_details`.`qty_of_bag`))) AS StockBagQty
FROM `purchase_invoice_detail` PID 
INNER JOIN 
`purchase_bag_details` PBD ON PID.`id` =PBD.`purchasedtlid`
INNER JOIN `purchase_invoice_master` PIM ON PID.`purchase_master_id`=PIM.`id`
INNER JOIN 
do_to_transporter DOT ON PID.`id`= DOT.`purchase_inv_dtlid` AND DOT.`in_Stock`='Y'
LEFT JOIN `blending_details` ON PBD.`id` = `blending_details`.`purchasebag_id`
INNER JOIN garden_master ON PID.`garden_id` = garden_master.`id`
INNER JOIN grade_master ON PID.`grade_id` = grade_master.`id`
INNER JOIN `location` ON DOT.`locationId`=`location`.`id`  
INNER JOIN `teagroup_master` ON PID.`teagroup_master_id` = `teagroup_master`.`id`
WHERE PID.`teagroup_master_id`=teagroup;
END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_groupwise_sum_stock` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_groupwise_sum_stock` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`samrat`@`localhost` PROCEDURE `sp_groupwise_sum_stock`(IN teagroup INT(10))
BEGIN
SELECT 
PID.`teagroup_master_id`,teagroup_master.`group_code`,
SUM((IF(PBD.`actual_bags` IS NULL, 0,PBD.`actual_bags`) -
 IF(`blending_details`.`number_of_blended_bag` IS NULL,0,`blending_details`.`number_of_blended_bag`)) )AS NumberOfStockBag,
SUM((
IF(PBD.`actual_bags`IS NULL,0,PBD.`actual_bags`)* IF(PBD.net IS NULL,0,PBD.net))-
(IF(`blending_details`.`number_of_blended_bag`IS NULL,0,`blending_details`.`number_of_blended_bag`)*
IF(`blending_details`.`qty_of_bag`IS NULL,0,`blending_details`.`qty_of_bag`))) AS StockBagQty
FROM `purchase_invoice_detail` PID 
INNER JOIN 
`purchase_bag_details` PBD ON PID.`id` =PBD.`purchasedtlid`
INNER JOIN 
do_to_transporter DOT ON PID.`id`= DOT.`purchase_inv_dtlid` AND DOT.`in_Stock`='Y'
LEFT JOIN `blending_details` ON PBD.`id` = `blending_details`.`purchasebag_id`
INNER JOIN garden_master ON PID.`garden_id` = garden_master.`id`
INNER JOIN grade_master ON PID.`grade_id` = grade_master.`id`
INNER JOIN `location` ON DOT.`locationId`=`location`.`id`  
INNER JOIN `teagroup_master` ON PID.`teagroup_master_id` = `teagroup_master`.`id`
GROUP BY PID.`teagroup_master_id`
HAVING 
PID.`teagroup_master_id`=teagroup;
END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_grp_nd_pricewise` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_grp_nd_pricewise` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`samrat`@`localhost` PROCEDURE `sp_grp_nd_pricewise`(
	IN teagroup INT(10),
	IN fromPrice DECIMAL(10,2),
	IN toPrice DECIMAL(10,2)
)
BEGIN
SELECT PID.`id` AS purchaseDtl,PBD.`id` AS purchaseBagDtlId,
`blending_details`.`id`,
PID.`teagroup_master_id`,PID.`invoice_number`,PID.`lot`,PIM.`sale_number`,garden_master.`garden_name`,grade_master.`grade`,location.`location`,teagroup_master.`group_code`,
PID.`price`,PID.`cost_of_tea`,PBD.`actual_bags`,PBD.`net`,PBD.`shortkg`,`blending_details`.`number_of_blended_bag`,`blending_details`.`qty_of_bag`,
(IF(PBD.`actual_bags` IS NULL, 0,PBD.`actual_bags`) -
 IF(`blending_details`.`number_of_blended_bag` IS NULL,0,`blending_details`.`number_of_blended_bag`)) AS NumberOfStockBag,
((
IF(PBD.`actual_bags`IS NULL,0,PBD.`actual_bags`)* IF(PBD.net IS NULL,0,PBD.net))-
(IF(`blending_details`.`number_of_blended_bag`IS NULL,0,`blending_details`.`number_of_blended_bag`)*
IF(`blending_details`.`qty_of_bag`IS NULL,0,`blending_details`.`qty_of_bag`))) AS StockBagQty
FROM `purchase_invoice_detail` PID 
INNER JOIN 
`purchase_bag_details` PBD ON PID.`id` =PBD.`purchasedtlid`
INNER JOIN `purchase_invoice_master` PIM ON PID.`purchase_master_id`=PIM.`id`
INNER JOIN 
do_to_transporter DOT ON PID.`id`= DOT.`purchase_inv_dtlid` AND DOT.`in_Stock`='Y'
LEFT JOIN `blending_details` ON PBD.`id` = `blending_details`.`purchasebag_id`
INNER JOIN garden_master ON PID.`garden_id` = garden_master.`id`
INNER JOIN grade_master ON PID.`grade_id` = grade_master.`id`
INNER JOIN `location` ON DOT.`locationId`=`location`.`id`  
INNER JOIN `teagroup_master` ON PID.`teagroup_master_id` = `teagroup_master`.`id`
WHERE PID.`teagroup_master_id`=teagroup AND (PID.`price` BETWEEN fromPrice AND toPrice); 
END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_pricewise_allgrp` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_pricewise_allgrp` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`samrat`@`localhost` PROCEDURE `sp_pricewise_allgrp`(IN fromPrice DECIMAL(10,2),IN toPrice DECIMAL(10,2))
BEGIN
SELECT PID.`id` AS purchaseDtl,PBD.`id` AS purchaseBagDtlId,
`blending_details`.`id`,
PID.`teagroup_master_id`,PID.`invoice_number`,PID.`lot`,PIM.`sale_number`,garden_master.`garden_name`,grade_master.`grade`,location.`location`,teagroup_master.`group_code`,
PID.`price`,PID.`cost_of_tea`,PBD.`actual_bags`,PBD.`net`,PBD.`shortkg`,`blending_details`.`number_of_blended_bag`,`blending_details`.`qty_of_bag`,
(IF(PBD.`actual_bags` IS NULL, 0,PBD.`actual_bags`) -
 IF(`blending_details`.`number_of_blended_bag` IS NULL,0,`blending_details`.`number_of_blended_bag`)) AS NumberOfStockBag,
((
IF(PBD.`actual_bags`IS NULL,0,PBD.`actual_bags`)* IF(PBD.net IS NULL,0,PBD.net))-
(IF(`blending_details`.`number_of_blended_bag`IS NULL,0,`blending_details`.`number_of_blended_bag`)*
IF(`blending_details`.`qty_of_bag`IS NULL,0,`blending_details`.`qty_of_bag`))) AS StockBagQty
FROM `purchase_invoice_detail` PID 
INNER JOIN 
`purchase_bag_details` PBD ON PID.`id` =PBD.`purchasedtlid`
INNER JOIN `purchase_invoice_master` PIM ON PID.`purchase_master_id`=PIM.`id`
INNER JOIN 
do_to_transporter DOT ON PID.`id`= DOT.`purchase_inv_dtlid` AND DOT.`in_Stock`='Y'
LEFT JOIN `blending_details` ON PBD.`id` = `blending_details`.`purchasebag_id`
INNER JOIN garden_master ON PID.`garden_id` = garden_master.`id`
INNER JOIN grade_master ON PID.`grade_id` = grade_master.`id`
INNER JOIN `location` ON DOT.`locationId`=`location`.`id`  
INNER JOIN `teagroup_master` ON PID.`teagroup_master_id` = `teagroup_master`.`id`
WHERE (PID.`price` BETWEEN fromPrice AND toPrice); 
END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_rawmaterialStockCalcultion` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_rawmaterialStockCalcultion` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`samrat`@`localhost` PROCEDURE `sp_rawmaterialStockCalcultion`(IN companyId INT,IN yearId INT)
BEGIN
  #main begin
 DECLARE cursor_finish INTEGER DEFAULT 0 ;
  DECLARE cursor_finish_rawmaterial INTEGER DEFAULT 0 ;
  DECLARE m_productPacketId INT ;
  DECLARE m_numberofpacket DECIMAL (12, 2) ;
  DECLARE m_OpeningStockRawMaterial DECIMAL (12, 2) ;
  #06-01-2017
 DECLARE m_PurchaseOfRawMaterial DECIMAL (12, 2) ;
  #06-01-2017
 DECLARE m_rawMaterialId INT ;
  DECLARE m_rawMaterialDesc VARCHAR (256) ;
  DECLARE m_rawMaterialStockIn DECIMAL (12, 2) ;
  #Consumption of raw material
  BLOCK1 : BEGIN
  DECLARE rawmaterialConsumptionCursor CURSOR FOR 
  SELECT  
	    SUM(finished_product_dtl.`numberof_packet`) AS numofpacket,
	    finished_product_dtl.`product_packet` AS productpacketid
  FROM `finished_product_dtl`
  INNER JOIN `finished_product` ON `finished_product`.id=`finished_product_dtl`.`finishProductId`
  INNER JOIN `product_packet` ON finished_product_dtl.`product_packet` = product_packet.`id`
  INNER JOIN `product` ON `product`.`id`= `product_packet`.`productid`
  INNER JOIN `packet` ON `packet`.`id` = `product_packet`.`packetid`
  WHERE `finished_product`.`company_id` = companyId AND `finished_product`.`year_id`=yearId
  GROUP BY finished_product_dtl.`product_packet`;
  
  DECLARE CONTINUE HANDLER  FOR NOT FOUND SET cursor_finish = 1;

  DROP TEMPORARY TABLE IF EXISTS tempRawMaterialConsumption;
CREATE TEMPORARY TABLE IF NOT EXISTS  tempRawMaterialConsumption
(
	rawmaterialId INT,
	rawmaterial VARCHAR(256),
	consumption NUMERIC(12,2)
);	

OPEN rawmaterialConsumptionCursor;
get_rawmaterialconsumption: LOOP

FETCH rawmaterialConsumptionCursor INTO  m_numberofpacket,m_productPacketId;

IF cursor_finish = 1 THEN 
	LEAVE get_rawmaterialconsumption;
END IF; 

INSERT INTO tempRawMaterialConsumption (rawmaterialId,rawmaterial,consumption)

SELECT product_rawmaterial_consumption.`rawmaterialid`,raw_material_master.`product_description`,
(product_rawmaterial_consumption.`quantity_required` * m_numberofpacket) AS consume
FROM `product_rawmaterial_consumption` 
INNER JOIN raw_material_master ON product_rawmaterial_consumption.`rawmaterialid` = raw_material_master.`id`
WHERE product_rawmaterial_consumption.`product_packetId`= m_productPacketId;
 

 
END LOOP get_rawmaterialconsumption;
CLOSE rawmaterialConsumptionCursor;

 #SELECT * FROM tempRawMaterialConsumption; 
 
  END BLOCK1 ;
  #End consumption of raw material
  
  BLOCK2: BEGIN
	DECLARE rawmaterialCursor CURSOR FOR
  SELECT 
      `raw_material_master`.`id`, 
      `raw_material_master`.`product_description`,
      IFNULL(`raw_material_opening`.`opening`,0) AS openingQty
      FROM `raw_material_master`
      LEFT JOIN
      `raw_material_opening` ON `raw_material_master`.`id`=`raw_material_opening`.`rawmaterialId`
      AND `raw_material_opening`.`companyid`=companyId AND `raw_material_opening`.`yearid`=yearId;
  #end cursor
DECLARE CONTINUE HANDLER  FOR NOT FOUND SET cursor_finish_rawmaterial = 1;

#Stock in temp table
DROP TEMPORARY TABLE IF EXISTS tempRawMaterialStockIn;
CREATE TEMPORARY TABLE IF NOT EXISTS  tempRawMaterialStockIn
(
	rawmaterialId INT,
	rawmaterial VARCHAR(256),
	stockIn NUMERIC(12,2)
);

#new cursor loop 07-01-2017
OPEN rawmaterialCursor;

get_rawmaterialStockIn: LOOP
FETCH rawmaterialCursor INTO m_rawMaterialId,m_rawMaterialDesc,m_OpeningStockRawMaterial;

IF cursor_finish_rawmaterial = 1 THEN 
	LEAVE get_rawmaterialStockIn;
END IF; 

SET m_PurchaseOfRawMaterial=(
SELECT 
IFNULL( SUM(`rawmaterial_purchasedetail`.`quantity`) ,0)AS purchaseQty
 FROM `rawmaterial_purchasedetail`
INNER JOIN `rawmaterial_purchase_master` 
ON `rawmaterial_purchase_master`.`id` = `rawmaterial_purchasedetail`.`rawmat_purchase_masterId`
WHERE `rawmaterial_purchasedetail`.`productid`=m_rawMaterialId AND 
`rawmaterial_purchase_master`.`companyid`=1 AND `rawmaterial_purchase_master`.`yearid`=6
GROUP BY
  `rawmaterial_purchasedetail`.`productid`);
  
  SET m_rawMaterialStockIn = (m_OpeningStockRawMaterial + m_PurchaseOfRawMaterial);
  

INSERT INTO tempRawMaterialStockIn(rawmaterialId,rawmaterial,stockIn) 
VALUES(m_rawMaterialId,m_rawMaterialDesc,m_rawMaterialStockIn);


END LOOP get_rawmaterialStockIn;
CLOSE rawmaterialCursor;

#SELECT * FROM tempRawMaterialStockIn;
  
END BLOCK2;
  SELECT tempRawMaterialStockIn.rawmaterialId,
  tempRawMaterialStockIn.rawmaterial,`unitmaster`.`unitName` AS unitofmeasurement,
  IFNULL(tempRawMaterialStockIn.stockIn,0) AS StockIn,
  IFNULL(tempRawMaterialConsumption.consumption,0) AS StockOut,
(IFNULL(tempRawMaterialStockIn.stockIn,0)- IFNULL(tempRawMaterialConsumption.consumption,0)) AS CuurentStock
   FROM
  tempRawMaterialStockIn
  LEFT JOIN
  tempRawMaterialConsumption 
  ON 
  tempRawMaterialStockIn.rawmaterialId = tempRawMaterialConsumption.rawmaterialId
  INNER JOIN `raw_material_master` ON `raw_material_master`.`id`= tempRawMaterialStockIn.rawmaterialId
  INNER JOIN  `unitmaster` ON `raw_material_master`.`unitid` = `unitmaster`.`unitid`
  ORDER BY tempRawMaterialStockIn.rawmaterial;
  
  
 
END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_sundrydebtorAndCreditortrial` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_sundrydebtorAndCreditortrial` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`samrat`@`localhost` PROCEDURE `sp_sundrydebtorAndCreditortrial`(
		CompanyId INT,
		YearId INT,
		fromDate DATETIME,
		toDate DATETIME,
		fiscalstartdate DATETIME,
		groupid INT
)
BEGIN
#variable declaration
  DECLARE totdebit DECIMAL(12,2);
  DECLARE totcredit DECIMAL(12,2);
  DECLARE AccountId INT;
  DECLARE AccountName VARCHAR(50);
  DECLARE OpeningBalance DECIMAL(12,2);
  DECLARE ClosingBalance DECIMAL(12,2);
  DECLARE amount DECIMAL(12,2);
  DECLARE isdebit BIT;
  DECLARE balance DECIMAL(12,2);
  DECLARE ismaster BIT;
  
  DECLARE totdebit_String VARCHAR(50);
  DECLARE totcredit_String VARCHAR(50);
  DECLARE balance_String DECIMAL(12,2);
  DECLARE opbal DECIMAL(12,2);
  -- closing balance variable 01-12-2016
    DECLARE debitBalance DECIMAL(12,2);
	DECLARE creditBalance DECIMAL(12,2);
  -- closing balance variable 01-12-2016
  DECLARE exit_loop BOOLEAN;
-- account id fetch with opening
DECLARE MYCURSOR CURSOR FOR
        SELECT AM.account_name, IFNULL(account_opening_master.opening_balance,0) AS opening,AM.id
        FROM account_master AM
        LEFT JOIN account_opening_master ON  AM.id = account_opening_master.account_master_id 
        AND account_opening_master.financialyear_id =YearId
        WHERE AM.company_id=CompanyId AND AM.group_master_id=groupid
        ORDER BY AM.account_name;
        
-- set exit_loop flag to true if there are no more rows
DECLARE CONTINUE HANDLER FOR NOT FOUND SET exit_loop = TRUE;
   
DROP TEMPORARY TABLE IF EXISTS finaltab;
CREATE TEMPORARY TABLE IF NOT EXISTS finaltab
( 
_totalOpening DECIMAL(12,2),
_totalTransDebit DECIMAL(12,2),
_totalTransCredit DECIMAL(12,2),
_totalClosingDebit DECIMAL(12,2),
_totalClosingCredit DECIMAL(12,2),
_AccountName VARCHAR(100)
);
 
   
OPEN MYCURSOR;
account_master: LOOP
FETCH  MYCURSOR INTO AccountName,OpeningBalance,AccountId;
  SET balance :=OpeningBalance;
  SET opbal := OpeningBalance;
  
   IF fromDate > fiscalstartdate THEN
      SET totdebit:=  (SELECT  IFNULL(SUM(VD.voucher_amount ),0) 
					FROM voucher_detail VD
					INNER JOIN voucher_master VM
					ON VD.voucher_master_id =VM.id
					AND VD.is_debit ='Y' AND VD.account_master_id =AccountId
					AND VM.voucher_date >= fiscalstartdate AND VM.voucher_date < fromDate
					AND VM.company_id =CompanyId
					AND VM.year_id =YearId);
      
      SET totcredit:=  (SELECT  IFNULL(SUM(VD.voucher_amount),0) 
					FROM voucher_detail VD
					INNER JOIN voucher_master VM
					ON VD.voucher_master_id =VM.id
					AND VD.is_debit ='N' AND VD.account_master_id =AccountId
					AND VM.voucher_date >= fiscalstartdate AND VM.voucher_date < fromDate
					AND VM.company_id =CompanyId
					AND VM.year_id =YearId);
          
          SET balance := balance + totdebit - totcredit;
					SET totcredit:=0;
					SET totdebit:=0;
      
   
   END IF;
   
   SET totdebit:=  (SELECT  IFNULL(SUM(VD.voucher_amount),0) 
					FROM voucher_detail VD
					INNER JOIN voucher_master VM
					ON VD.voucher_master_id =VM.id
					AND VD.is_debit ='Y' AND VD.account_master_id =AccountId
					AND VM.voucher_date  BETWEEN fromDate AND toDate
					AND VM.company_id =CompanyId
					AND VM.year_id =YearId);
          
     SET totcredit:=  (SELECT  IFNULL(SUM(VD.voucher_amount),0) 
					FROM voucher_detail VD
					INNER JOIN voucher_master VM
					ON VD.voucher_master_id =VM.id
					AND VD.is_debit ='N' AND VD.account_master_id =AccountId
					AND VM.voucher_date  BETWEEN fromDate AND toDate
					AND VM.company_id =CompanyId
					AND VM.year_id =YearId);      
          
    SET balance:= balance + totdebit - totcredit;
    IF exit_loop THEN
         CLOSE MYCURSOR;
         LEAVE account_master;
     END IF;
	 
	 
    IF balance < 0
	THEN
				SET creditBalance:= (balance) *(-1);
				SET debitBalance:=0 ;
	ELSE
			
				SET debitBalance:= balance;
				SET creditBalance:=0;
    END IF;
		INSERT INTO finaltab (_AccountName,_totalOpening ,_totalTransDebit,_totalTransCredit ,_totalClosingDebit,_totalClosingCredit)
		VALUES(AccountName,OpeningBalance,totdebit,totcredit,debitBalance,creditBalance);
			
		SET totcredit:=0;
		SET totdebit:=0;
        SET balance:=0;
   
   
    
END LOOP account_master;
SELECT finaltab._AccountName AS Account,finaltab._totalOpening AS Opening,
		finaltab._totalTransDebit AS Debit,finaltab._totalTransCredit AS Credit,finaltab._totalClosingDebit AS closingDebit,
		finaltab._totalClosingCredit AS closingCredit
FROM finaltab
WHERE (finaltab._totalOpening <> 0 OR finaltab._totalTransDebit<>0 OR finaltab._totalTransCredit<>0 OR finaltab._totalClosingDebit <>0
OR finaltab._totalClosingCredit<>0);
  
END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_UpdateCustomerBillMaster` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_UpdateCustomerBillMaster` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`samrat`@`localhost` PROCEDURE `sp_UpdateCustomerBillMaster`()
BEGIN
    DECLARE m_taxInvoiceId INTEGER DEFAULT 0;
    DECLARE m_taxInvoiceDate DATETIME;
    DECLARE m_TaxBillAmount DECIMAL(10,2) DEFAULT 0;
    DECLARE m_customerAccountId INTEGER ;
    DECLARE m_companyId INTEGER;
    DECLARE m_yearId INTEGER;
	#cursor finish variable declare
	DECLARE cursor_finish INTEGER DEFAULT 0;
	
	#cursor declaration 
	DECLARE CursorSaleBill CURSOR FOR
	SELECT 
sale_bill_master.id AS InvoiceId ,
sale_bill_master.salebilldate,
sale_bill_master.grandtotal,
account_master.id,
sale_bill_master.yearid,
sale_bill_master.companyid
FROM sale_bill_master
INNER JOIN customer ON sale_bill_master.customerId = customer.id
INNER JOIN account_master ON customer.account_master_id  = account_master.id;
  
	#declare cursor handler
	DECLARE CONTINUE HANDLER 
	FOR NOT FOUND SET cursor_finish = 1;
    
     OPEN CursorSaleBill ;
     get_bill: LOOP	
     
     FETCH CursorSaleBill INTO m_taxInvoiceId,m_taxInvoiceDate,m_TaxBillAmount,m_customerAccountId
     ,m_yearId,m_companyId;
     
     IF cursor_finish=1 THEN
      LEAVE get_bill;
     END IF;
     #insertion to bill master
     INSERT INTO customerbillmaster(
   billdate
  ,billamount
  ,invoicemasterid
  ,saletype
  ,customeraccountid
  ,companyid
  ,yearid
) VALUES (
   m_taxInvoiceDate 
  ,m_TaxBillAmount
  ,m_taxInvoiceId
  ,'T'  
  ,m_customerAccountId
  ,m_companyId
  ,m_yearId
);
     
     END LOOP get_bill;
	CLOSE CursorSaleBill; 
END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_UpdateCustomerRawBill` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_UpdateCustomerRawBill` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`samrat`@`localhost` PROCEDURE `sp_UpdateCustomerRawBill`()
BEGIN
    DECLARE m_taxInvoiceId INTEGER DEFAULT 0;
    DECLARE m_taxInvoiceDate DATETIME;
    DECLARE m_TaxBillAmount DECIMAL(10,2) DEFAULT 0;
    DECLARE m_customerAccountId INTEGER ;
    DECLARE m_companyId INTEGER;
    DECLARE m_yearId INTEGER;
	#cursor finish variable declare
	DECLARE cursor_finish INTEGER DEFAULT 0;
	
	#cursor declaration 
	DECLARE CursorSaleBill CURSOR FOR
	SELECT 
rawteasale_master.id AS InvoiceId,
rawteasale_master.sale_date AS salebilldate,
rawteasale_master.grandtotal,
account_master.id,
rawteasale_master.year_id,
rawteasale_master.company_id
FROM rawteasale_master
INNER JOIN customer ON rawteasale_master.customer_id = customer.id
INNER JOIN account_master ON account_master.id = customer.account_master_id;
  
	#declare cursor handler
	DECLARE CONTINUE HANDLER 
	FOR NOT FOUND SET cursor_finish = 1;
    
     OPEN CursorSaleBill ;
     get_bill: LOOP	
     
     FETCH CursorSaleBill INTO m_taxInvoiceId,m_taxInvoiceDate,m_TaxBillAmount,m_customerAccountId
     ,m_yearId,m_companyId;
     
     IF cursor_finish=1 THEN
      LEAVE get_bill;
     END IF;
     #insertion to bill master
     INSERT INTO customerbillmaster(
   billdate
  ,billamount
  ,invoicemasterid
  ,saletype
  ,customeraccountid
  ,companyid
  ,yearid
) VALUES (
   m_taxInvoiceDate 
  ,m_TaxBillAmount
  ,m_taxInvoiceId
  ,'R'  
  ,m_customerAccountId
  ,m_companyId
  ,m_yearId
);
     
     END LOOP get_bill;
	CLOSE CursorSaleBill; 
END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_UpdateVendorBillMaster` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_UpdateVendorBillMaster` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`samrat`@`localhost` PROCEDURE `sp_UpdateVendorBillMaster`()
BEGIN
    DECLARE m_purchaseInvoiceId INTEGER DEFAULT 0;
    DECLARE m_purchaseInvoiceDate DATETIME;
    DECLARE m_purchaseBillAmount DECIMAL(10,2) DEFAULT 0;
    DECLARE m_vendorAccountId INTEGER ;
    DECLARE m_companyId INTEGER;
    DECLARE m_yearId INTEGER;
	#cursor finish variable declare
	DECLARE cursor_finish INTEGER DEFAULT 0;
	
	#cursor declaration 
	DECLARE CursorpurchaseBill CURSOR FOR
	SELECT purchase_invoice_master.`id` AS invoiceId,purchase_invoice_master.`purchase_invoice_date`,
		  purchase_invoice_master.`total`,`account_master`.`id`,
		  purchase_invoice_master.`year_id`,purchase_invoice_master.`company_id`
	FROM 
		  purchase_invoice_master
	INNER JOIN`vendor` ON `purchase_invoice_master`.`vendor_id` = vendor.`id`
	INNER JOIN`account_master` ON `vendor`.`account_master_id` = `account_master`.`id` ;
	#declare cursor handler
	DECLARE CONTINUE HANDLER 
	FOR NOT FOUND SET cursor_finish = 1;
    
     OPEN CursorpurchaseBill ;
     get_bill: LOOP	
     
     FETCH CursorpurchaseBill INTO m_purchaseInvoiceId,m_purchaseInvoiceDate,m_purchaseBillAmount,m_vendorAccountId
     ,m_yearId,m_companyId;
     
     IF cursor_finish=1 THEN
      LEAVE get_bill;
     END IF;
     #insertion to bill master
     INSERT INTO `vendorbillmaster`
            (
             `billDate`,
             `billAmount`,
             `invoiceMasterId`,
             `purchaseType`,
             `vendorAccountId`,
             `companyId`,
             `yearId`)
	VALUES (
        m_purchaseInvoiceDate,
        m_purchaseBillAmount,
        m_purchaseInvoiceId,
        'T',
        m_vendorAccountId,
        m_companyId,
        m_yearId);
     
     END LOOP get_bill;
	CLOSE CursorpurchaseBill; 
END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_UpdateVendorBillMasterByRawPurchase` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_UpdateVendorBillMasterByRawPurchase` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`samrat`@`localhost` PROCEDURE `sp_UpdateVendorBillMasterByRawPurchase`()
BEGIN
    DECLARE m_purchaseInvoiceId INTEGER DEFAULT 0;
    DECLARE m_purchaseInvoiceDate DATETIME;
    DECLARE m_purchaseBillAmount DECIMAL(10,2) DEFAULT 0;
    DECLARE m_vendorAccountId INTEGER ;
    DECLARE m_companyId INTEGER;
    DECLARE m_yearId INTEGER;
	#cursor finish variable declare
	DECLARE cursor_finish INTEGER DEFAULT 0;
	
	#cursor declaration 
	DECLARE CursorpurchaseBill CURSOR FOR
	
	SELECT 
		  rawmaterial_purchase_master.`id` AS invoiceId,rawmaterial_purchase_master.`invoice_date`,
		  rawmaterial_purchase_master.`invoice_value`,`account_master`.`id`,
		  `rawmaterial_purchase_master`.`yearid`,`rawmaterial_purchase_master`.`companyid`
		  
	FROM 
		  rawmaterial_purchase_master
	INNER JOIN`vendor` ON `rawmaterial_purchase_master`.`vendor_id` = vendor.`id`
	INNER JOIN`account_master` ON `vendor`.`account_master_id` = `account_master`.`id` ;
	#declare cursor handler
	DECLARE CONTINUE HANDLER 
	FOR NOT FOUND SET cursor_finish = 1;
    
     OPEN CursorpurchaseBill ;
     get_bill: LOOP	
     
     FETCH CursorpurchaseBill INTO m_purchaseInvoiceId,m_purchaseInvoiceDate,m_purchaseBillAmount,m_vendorAccountId
     ,m_yearId,m_companyId;
     
     IF cursor_finish=1 THEN
      LEAVE get_bill;
     END IF;
     #insertion to bill master
     INSERT INTO `vendorbillmaster`
            (
             `billDate`,
             `billAmount`,
             `invoiceMasterId`,
             `purchaseType`,
             `vendorAccountId`,
             `companyId`,
             `yearId`)
	VALUES (
        m_purchaseInvoiceDate,
        m_purchaseBillAmount,
        m_purchaseInvoiceId,
        'O',
        m_vendorAccountId,
        m_companyId,
        m_yearId);
     
     END LOOP get_bill;
	CLOSE CursorpurchaseBill; 
END */$$
DELIMITER ;

/* Procedure structure for procedure `usp_CreditorDue` */

/*!50003 DROP PROCEDURE IF EXISTS  `usp_CreditorDue` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`samrat`@`localhost` PROCEDURE `usp_CreditorDue`(
yearId INT,
companyId INT,
fromdate DATE,
todate DATE)
BEGIN
DECLARE fiscalStartDate DATE;
DECLARE accountId INT;
DECLARE accountDesc VARCHAR(255);
DECLARE openingBal DECIMAL(12,2);
DECLARE totalDebit DECIMAL(12,2);
DECLARE totalCredit DECIMAL(12,2);
DECLARE closingBal DECIMAL(12,2);
DECLARE balanceTag VARCHAR(10);
DECLARE PreviousBillAmt DECIMAL(12,2);
DECLARE CompanyName VARCHAR(255);
DECLARE Period VARCHAR(255);
#cursor handler variable
DECLARE finished INTEGER DEFAULT 0;
#cursor declaration
DECLARE cursor_accountId CURSOR FOR 
        SELECT `account_master`.id,`account_master`.account_name
        FROM account_master
        WHERE `account_master`.group_master_id=2 ORDER BY `account_master`.account_name;
DECLARE CONTINUE HANDLER FOR NOT FOUND SET finished = 1;
DROP TEMPORARY TABLE IF EXISTS TEMPTABLE;
CREATE TEMPORARY TABLE TEMPTABLE
(
	id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
	AccountId INT,
	AccountDescription VARCHAR(255),
	Opening DECIMAL(12,2),
	DebitAmount DECIMAL(12,2),
  CreditAmount DECIMAL(12,2),
	Balance DECIMAL(12,2),
	BalanceTag VARCHAR(10)
);
#fiscal start date set
SET fiscalStartDate:=(
SELECT 
  financialyear.`start_date` 
FROM
  `financialyear` 
WHERE financialyear.id =  yearId);
OPEN cursor_accountId;
account_loop : LOOP
FETCH NEXT FROM cursor_accountId INTO accountId,accountDesc;
 IF finished = 1 THEN 
   LEAVE account_loop;
 END IF;
 
 SET closingBal:= 0;
	SET @openingBal :=0;
	SET @totalDebit :=0;
	SET @totalCredit :=0;
 
 
 #opening balance fetch of account
 SET openingBal:=(
 SELECT IFNULL(`account_opening_master`.`opening_balance`,0)  FROM `account_opening_master` 
  WHERE `account_opening_master`.`account_master_id` = accountId
  AND `account_opening_master`.`company_id` = companyId AND account_opening_master.`financialyear_id`= yearId);
 
 #if fromdate not equals to start date.
 #select fromdate,fiscalStartDate;
 
 IF fromdate > fiscalStartDate 	THEN
	# debit
  SET totalDebit :=(
	SELECT  IFNULL(SUM(VD.`voucher_amount`),0)  FROM 
	voucher_detail VD 
	INNER JOIN voucher_master VM ON VM.id = VD.voucher_master_id	WHERE VD.is_debit = 'Y' 
	AND VM.`voucher_date` >= fiscalStartDate
	AND VM.voucher_date < fromdate
	AND VM.`company_id` =companyId
	AND VD.`account_master_id` =accountId);
  # credit
  SET totalCredit:=(
  SELECT  IFNULL(SUM(VD.`voucher_amount`),0)  FROM 
	voucher_detail VD 
	INNER JOIN voucher_master VM ON VM.id = VD.voucher_master_id	WHERE VD.is_debit = 'N' 
	AND VM.`voucher_date` >= fiscalStartDate
	AND VM.voucher_date < fromdate
	AND VM.`company_id` =companyId
	AND VD.`account_master_id` =accountId);
  
		SET openingBal := IFNULL(openingBal,0) + IFNULL(totalDebit,0) - IFNULL(totalCredit,0);
END IF;
 
 
 
 # debit
 SET totalDebit :=(
	SELECT  IFNULL(SUM(VD.`voucher_amount`),0)  FROM 
	voucher_detail VD 
	INNER JOIN voucher_master VM ON VM.id = VD.voucher_master_id	WHERE VD.is_debit = 'Y' 
	AND VM.`voucher_date` BETWEEN fromdate AND todate
	AND VM.`company_id` = companyId
	AND VD.`account_master_id` = accountId);
  
  #credit
  SET totalCredit:=(
  SELECT  IFNULL(SUM(VD.`voucher_amount`),0) FROM 
	voucher_detail VD 
	INNER JOIN voucher_master VM ON VM.id = VD.voucher_master_id	WHERE VD.is_debit = 'N' 
	AND VM.`voucher_date` BETWEEN fromdate AND todate
	AND VM.`company_id` =companyId
	AND VD.`account_master_id` =accountId);
  
  SET closingBal := (openingBal + IFNULL(totalDebit,0))-(IFNULL(totalCredit,0));
  
  #if closingBal < 0 THEN
  #set closingBal := (-1)*closingBal; 
 # END if;
 
 
 IF(closingBal>0) THEN
  	  SET balanceTag ='DR';
  ELSE
	   SET balanceTag ='CR';
  END IF; 
 
IF (openingBal<>0 OR totalDebit <> 0 OR totalCredit <> 0) THEN
INSERT INTO TEMPTABLE(AccountId,	AccountDescription,Opening ,DebitAmount , CreditAmount ,Balance ,BalanceTag)
	VALUES(accountId,accountDesc,openingBal,totalDebit,totalCredit,closingBal,balanceTag);
END IF;
END LOOP account_loop;
CLOSE cursor_accountId;
  
SELECT * FROM TEMPTABLE WHERE Balance<>0 ORDER BY AccountDescription  ;
  
  
END */$$
DELIMITER ;

/* Procedure structure for procedure `usp_DebtorsDue` */

/*!50003 DROP PROCEDURE IF EXISTS  `usp_DebtorsDue` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`samrat`@`localhost` PROCEDURE `usp_DebtorsDue`(
yearId INT,
companyId INT,
fromdate DATE,
todate DATE)
BEGIN
DECLARE fiscalStartDate DATE;
DECLARE accountId INT;
DECLARE accountDesc VARCHAR(255);
DECLARE openingBal DECIMAL(12,2);
DECLARE totalDebit DECIMAL(12,2);
DECLARE totalCredit DECIMAL(12,2);
DECLARE closingBal DECIMAL(12,2);
DECLARE balanceTag VARCHAR(10);
DECLARE PreviousBillAmt DECIMAL(12,2);
DECLARE CompanyName VARCHAR(255);
DECLARE Period VARCHAR(255);
#cursor handler variable
DECLARE finished INTEGER DEFAULT 0;
#cursor declaration
DECLARE cursor_accountId CURSOR FOR 
        SELECT `account_master`.id,`account_master`.account_name
        FROM account_master
        WHERE `account_master`.group_master_id=1 ORDER BY `account_master`.account_name;
DECLARE CONTINUE HANDLER FOR NOT FOUND SET finished = 1;
DROP TEMPORARY TABLE IF EXISTS TEMPTABLE;
CREATE TEMPORARY TABLE TEMPTABLE
(
	id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
	AccountId INT,
	AccountDescription VARCHAR(255),
	Opening DECIMAL(12,2),
	DebitAmount DECIMAL(12,2),
  CreditAmount DECIMAL(12,2),
	Balance DECIMAL(12,2),
	BalanceTag VARCHAR(10)
);
#fiscal start date set
SET fiscalStartDate:=(
SELECT 
  financialyear.`start_date` 
FROM
  `financialyear` 
WHERE financialyear.id =  yearId);
OPEN cursor_accountId;
account_loop : LOOP
FETCH NEXT FROM cursor_accountId INTO accountId,accountDesc;
 IF finished = 1 THEN 
   LEAVE account_loop;
 END IF;
 
 
 
 
 #opening balance fetch of account
 SET openingBal:=(
 SELECT IFNULL(`account_opening_master`.`opening_balance`,0)  FROM `account_opening_master` 
  WHERE `account_opening_master`.`account_master_id` = accountId
  AND `account_opening_master`.`company_id` = companyId AND account_opening_master.`financialyear_id`= yearId);
 
 #if fromdate not equals to start date.
 #select fromdate,fiscalStartDate;
 
 IF fromdate > fiscalStartDate 	THEN
	# debit
  SET totalDebit :=(
	SELECT  IFNULL(SUM(VD.`voucher_amount`),0)  FROM 
	voucher_detail VD 
	INNER JOIN voucher_master VM ON VM.id = VD.voucher_master_id	WHERE VD.is_debit = 'Y' 
	AND VM.`voucher_date` >= fiscalStartDate
	AND VM.voucher_date < fromdate
	AND VM.`company_id` =companyId
	AND VD.`account_master_id` =accountId);
  # credit
  SET totalCredit:=(
  SELECT  IFNULL(SUM(VD.`voucher_amount`),0)  FROM 
	voucher_detail VD 
	INNER JOIN voucher_master VM ON VM.id = VD.voucher_master_id	WHERE VD.is_debit = 'N' 
	AND VM.`voucher_date` >= fiscalStartDate
	AND VM.voucher_date < fromdate
	AND VM.`company_id` =companyId
	AND VD.`account_master_id` =accountId);
		
  SET openingBal := IFNULL(openingBal,0) + IFNULL(totalDebit,0) - IFNULL(totalCredit,0);
 
END IF;
 
 
 # debit
 SET totalDebit :=(
	SELECT  IFNULL(SUM(VD.`voucher_amount`),0)  FROM 
	voucher_detail VD 
	INNER JOIN voucher_master VM ON VM.id = VD.voucher_master_id	WHERE VD.is_debit = 'Y' 
	AND VM.`voucher_date` BETWEEN fromdate AND todate
	AND VM.`company_id` = companyId
	AND VD.`account_master_id` = accountId);
  
  #credit
  SET totalCredit:=(
  SELECT  IFNULL(SUM(VD.`voucher_amount`),0) FROM 
	voucher_detail VD 
	INNER JOIN voucher_master VM ON VM.id = VD.voucher_master_id	WHERE VD.is_debit = 'N' 
	AND VM.`voucher_date` BETWEEN fromdate AND todate
	AND VM.`company_id` =companyId
	AND VD.`account_master_id` =accountId);
  
  SET closingBal := (openingBal + IFNULL(totalDebit,0))-(IFNULL(totalCredit,0));
  
 
 
 IF(closingBal>0) THEN
  	  SET balanceTag ='DR';
  ELSE
	   SET balanceTag ='CR';
  END IF; 
 
IF (openingBal<>0 OR totalDebit <> 0 OR totalCredit <> 0) THEN
INSERT INTO TEMPTABLE(AccountId,	AccountDescription,Opening ,DebitAmount , CreditAmount ,Balance ,BalanceTag)
	VALUES(accountId,accountDesc,openingBal,totalDebit,totalCredit,closingBal,balanceTag);
END IF;
END LOOP account_loop;
CLOSE cursor_accountId;
  
SELECT * FROM TEMPTABLE WHERE Balance<>0 ORDER BY AccountDescription  ;
  
  
END */$$
DELIMITER ;

/* Procedure structure for procedure `usp_generalLedger` */

/*!50003 DROP PROCEDURE IF EXISTS  `usp_generalLedger` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`samrat`@`localhost` PROCEDURE `usp_generalLedger`(companyId INT,yearId INT,accountId INT,fromDate DATE,todate DATE,fiscalstart DATE)
BEGIN
DECLARE m_voucherId INT;
DECLARE m_voucheramount DECIMAL(10,2);
DECLARE m_isDebit CHAR(1);
#-------------#
DECLARE v_totalsum DECIMAL(10,2);
#-------18-09-2016-------------#
DECLARE v_amount DECIMAL(12,2);
DECLARE v_accountname VARCHAR(100);
DECLARE v_voucherdate DATETIME;
DECLARE v_isdebit CHAR(1);
DECLARE v_counter INT;
DECLARE v_pagenumber INT;
DECLARE v_debitbalance DECIMAL(12,2);
DECLARE v_creditbalance DECIMAL(12,2);
DECLARE v_narration VARCHAR(1500);
DECLARE v_trantype VARCHAR(50);
DECLARE v_vouchernumber VARCHAR(50);
DECLARE v_voucherid INT;
DECLARE v_openingbalance DECIMAL(12,2);
DECLARE v_openingdebitbalance DECIMAL(12,2);
DECLARE v_openingcreditbalance DECIMAL(12,2);
DECLARE v_ismaster char(1);
DECLARE v_vouchernumber_temp VARCHAR(50);
DECLARE v_vouchernumberforsorting VARCHAR(50);
DECLARE v_prev_vch_number_part VARCHAR(10);
DECLARE v_prev_vch_last_part VARCHAR(20);
DECLARE v_chequeNumber VARCHAR(50);
DECLARE v_chequeDate DATETIME;
DECLARE v_chequeText VARCHAR(50);
#--------------------#
DECLARE v_debitcount INT;
DECLARE v_creditcount INT;
DECLARE v_dummyvar INT;
DECLARE v_debitcnt INT;
DECLARE v_creditcnt INT;
DECLARE v_dummy_var INT;
#--------18-09-2016--------------#
DECLARE finished INTEGER DEFAULT 0;
#cursor finish variable#
DECLARE v_finish INTEGER DEFAULT 0;
DECLARE MYCURSOR CURSOR FOR
SELECT _voucherDate,_isdebit,_accountname,_narration,_amount,_trantype,_voucherNumber,_chequeNumber,_chequeDate
FROM TempTable1 ORDER BY _voucherDate;
#
#main cursor
# 
DECLARE  CURSOR_1 CURSOR FOR(
                              SELECT vm.id,vd.`voucher_amount`,vd.is_debit 
                              FROM voucher_master vm 
                              INNER JOIN voucher_detail vd ON vm.`id`=vd.`voucher_master_id` 
                              WHERE 
                              vd.`account_master_id` =accountId
                              AND vm.`company_id`=companyId  
                              AND vm.`year_id`=yearId
                              AND vm.`voucher_date` BETWEEN fromDate AND todate
                              ORDER BY  vm.`voucher_date`,vm.id
                              );
#temporary table for store transaction
DROP TEMPORARY TABLE IF EXISTS TempTable1;
CREATE TEMPORARY TABLE TempTable1
(
	_voucherDate DATETIME,
	_voucher_masterid INT,
	_payto INT,
	_isdebit CHAR(1),
  _detailid INT,
	_accountname VARCHAR(250),
	_accountid INT,
	_trantype VARCHAR(50),
	_narration VARCHAR(1500),
	_amount DECIMAL(12,2),
	_voucherNumber VARCHAR(100),
	_chequeNumber VARCHAR(50),
	_chequeDate DATETIME
);
#temporary table for store transaction end
BEGIN
DECLARE CONTINUE HANDLER FOR NOT FOUND SET v_finish=1;
OPEN CURSOR_1;
get_acc : LOOP
FETCH CURSOR_1 INTO m_voucherId,m_voucheramount,m_isDebit;
IF v_finish = 1 THEN
  LEAVE get_acc;
END IF;
              #select m_voucherId, m_voucheramount, m_isDebit;
              IF m_isDebit='Y' THEN #if transaction debit or credit
                
                      SELECT SUM(vd.voucher_amount) INTO v_totalsum 
                      FROM voucher_master vm 
                      INNER JOIN voucher_detail vd ON vm.id = vd.voucher_master_id
                      WHERE  vd.voucher_master_id = m_voucherId AND vd.is_debit='N' 
                      GROUP BY vd.voucher_master_id;
                
                
                        	IF (v_totalsum=m_voucheramount) THEN
                              #credit transaction insertion on temporay table#
                              INSERT INTO TempTable1 (_voucherDate,_voucher_masterid,_payto,_isdebit,_detailid,_accountname,_accountid,_trantype,_narration,_amount,_voucherNumber,_chequeNumber,_chequeDate) 
                              SELECT DISTINCT   vm.`voucher_date`, vm.id,0,vd.`is_debit`,vd.`id`,am.`account_name`,am.`id`,
                                            CASE
                                              WHEN vm.`transaction_type` = 'PY' 
                                              THEN 'Payment' 
                                              WHEN vm.transaction_type = 'SL' 
                                              THEN 'Sales' 
                                              WHEN vm.transaction_type = 'PR' 
                                              THEN 'Purchase' 
                                              WHEN vm.transaction_type = 'RC' 
                                              THEN 'Receipt' 
                                              WHEN vm.transaction_type = 'CN' 
                                              THEN 'Contra' 
                                              WHEN vm.transaction_type = 'JV' 
                                              THEN 'Journal' 
                                              WHEN vm.transaction_type = 'GV' 
                                              THEN 'General' 
                                              WHEN vm.transaction_type = 'RP' 
                                              THEN 'Purchase' 
                                              WHEN vm.transaction_type = 'RS' 
                                              THEN 'Sales' 
                                              WHEN vm.transaction_type = 'VADV' 
                                              THEN 'Advance' 
                                              WHEN vm.transaction_type = 'CADV' 
                                              THEN 'Advance' 
                                            END AS trantype,
                                            IFNULL(vm.`narration`, '') AS narration,
                                            vd.`voucher_amount`,
                                            vm.`voucher_number`,
                                            vm.`cheque_number`,
                                            vm.`cheque_date` 
                                          FROM
                                            voucher_detail vd 
                                            INNER JOIN account_master am 
                                              ON vd.`account_master_id` = am.id 
                                            INNER JOIN voucher_master vm 
                                              ON vm.id = vd.`voucher_master_id` 
                                            INNER JOIN 
                                              (SELECT 
                                                vm.id 
                                              FROM
                                                voucher_master vm 
                                                INNER JOIN voucher_detail vd 
                                                  ON vm.id = vd.`voucher_master_id` 
                                              WHERE vd.account_master_id IN 
                                                (SELECT 
                                                  M.id 
                                                FROM
                                                  account_master M 
                                                  INNER JOIN account_master C 
                                                    ON M.id = C.id 
                                                    AND C.id = accountId) 
                                                AND vm.`voucher_date` BETWEEN fromDate AND todate
                                                AND vm.`company_id` = companyId 
                                                AND vm.`year_id` = yearId) B 
                                              ON vm.id = B.id 
                                          WHERE vm.id = m_voucherId 
                                            AND vd.`is_debit` = 'N' ;
                          ELSEIF v_totalsum > m_voucheramount THEN
                           #insertion on temp table#
                           #to do
                           INSERT INTO TempTable1 (_voucherDate,_voucher_masterid,_payto,_isdebit,_detailid,_accountname,_accountid,_trantype,_narration,_amount,_voucherNumber,_chequeNumber,_chequeDate) 
                           SELECT DISTINCT vm.`voucher_date`,vm.id,0,vd.`is_debit`,vd.`id`,am.`account_name`,am.`id`,
                    							CASE 
                    							   WHEN vm.`transaction_type`='PY' THEN 'Payment'
                    								 WHEN vm.transaction_type='SL' THEN 'Sales'
                    								 WHEN vm.transaction_type='PR' THEN 'Purchase'
                    								 WHEN vm.transaction_type='RC' THEN 'Receipt'
                    								 WHEN vm.transaction_type='CN' THEN 'Contra'
                    								 WHEN vm.transaction_type='JV' THEN 'Journal'
                    								 WHEN vm.transaction_type='GV' THEN 'General'
                    								 WHEN vm.transaction_type ='RP'THEN 'Purchase'
                    								 WHEN vm.transaction_type='RS' THEN 'Sales'
                    								 WHEN vm.transaction_type='VADV' THEN 'Advance'
                    								 WHEN vm.transaction_type='CADV' THEN 'Advance'
                    							END AS trantype
                    							 ,IFNULL(vm.`narration`,'')AS narration,m_voucheramount AS amount,vm.`voucher_number`
                    							 ,vm.`cheque_number`,vm.`cheque_date`
                    							FROM voucher_detail vd
                    							INNER JOIN account_master am
                    							ON vd.`account_master_id`=am.id
                    							INNER JOIN voucher_master vm
                    							ON vm.id=vd.`voucher_master_id` 
                    							INNER JOIN (
                    										SELECT vm.`id`
                    										FROM voucher_master vm
                    										INNER JOIN voucher_detail vd
                    										ON vm.id=vd.`voucher_master_id` 
                    										WHERE vd.`account_master_id` =accountId
                    										AND vm.`voucher_date` BETWEEN fromDate AND todate
                    										AND vm.`company_id`=companyId 
                    										AND vm.`year_id`=yearId
                    										) B
                    							ON vm.id= B.id
                    							WHERE vm.id=m_voucherId  
                    							AND vd.`is_debit`='N';
                          
                          END IF;
                
                
              ELSEIF m_isDebit='N' THEN #credit transaction of this account
                
                SELECT SUM(vd.`voucher_amount`) INTO v_totalsum 
                FROM voucher_master vm 
                INNER JOIN voucher_detail vd ON vm.`id`=vd.`voucher_master_id`
                WHERE  vd.`voucher_master_id`= m_voucherId AND vd.`is_debit`='Y' 
                GROUP BY vd.`voucher_master_id`;
                
                 IF(v_totalsum = m_voucheramount)	THEN
                  #to do
                  INSERT INTO TempTable1 (_voucherDate,_voucher_masterid,_payto,_isdebit,_detailid,_accountname,_accountid,_trantype,_narration,_amount,_voucherNumber,_chequeNumber,_chequeDate) 
                  SELECT DISTINCT  vm.`voucher_date`, vm.id, 0,vd.`is_debit`, vd.`id`, am.account_name, am.id,
                  CASE
			      WHEN vm.`transaction_type` = 'PY' 
                              THEN 'Payment'
                              WHEN vm.transaction_type = 'SL' 
                              THEN 'Sales' 
                              WHEN vm.transaction_type = 'PR' 
                              THEN 'Purchase' 
                              WHEN vm.transaction_type = 'RC' 
                              THEN 'Receipt' 
                              WHEN vm.transaction_type = 'CN' 
                              THEN 'Contra' 
                              WHEN vm.transaction_type = 'JV' 
                              THEN 'Journal' 
                              WHEN vm.transaction_type = 'GV' 
                              THEN 'General' 
                              WHEN vm.transaction_type = 'RP' 
                              THEN 'Purchase' 
                              WHEN vm.transaction_type = 'RS' 
                              THEN 'Sales' 
                              WHEN vm.transaction_type = 'VADV' 
                              THEN 'Advance' 
                              WHEN vm.transaction_type = 'CADV' 
                              THEN 'Advance' 
                            END AS trantype,
                            IFNULL(vm.`narration`, '') AS narration, vd.`voucher_amount`, vm.`voucher_number`, vm.`cheque_number`,vm.`cheque_date` 
                            FROM voucher_detail vd INNER JOIN account_master am ON vd.`account_master_id` = am.id 
                            INNER JOIN voucher_master vm  ON vm.id = vd.`voucher_master_id` 
                            INNER JOIN 
                            (SELECT 
                              vm.`id` 
                              FROM
                              voucher_master vm 
                              INNER JOIN voucher_detail vd 
                              ON vm.id = vd.`voucher_master_id` 
                              WHERE vd.`account_master_id` =  accountId
                              AND vm.`voucher_date` BETWEEN fromDate AND todate 
                              AND vm.`company_id` = companyId 
                              AND vm.`year_id` = yearId) B 
                              ON vm.id = B.id WHERE vm.id =m_voucherId  
                              AND vd.`is_debit` = 'Y' ;
                 ELSEIF (v_totalsum > m_voucheramount) THEN
                  #to do
                  #companyId int,yearId int,accountId int,fromDate date,todate date,fiscalstart date
                   INSERT INTO TempTable1 (_voucherDate,_voucher_masterid,_payto,_isdebit,_detailid,_accountname,_accountid,_trantype,_narration,_amount,_voucherNumber,_chequeNumber,_chequeDate) 
                    SELECT DISTINCT  vm.`voucher_date`, vm.id, 0,vd.`is_debit`,vd.id,am.account_name,am.id,
                    CASE
				  WHEN vm.`transaction_type` = 'PY' 
                                  THEN 'Payment'
                                  WHEN vm.transaction_type = 'SL' 
                                  THEN 'Sales' 
                                  WHEN vm.transaction_type = 'PR' 
                                  THEN 'Purchase' 
                                  WHEN vm.transaction_type = 'RC' 
                                  THEN 'Receipt' 
                                  WHEN vm.transaction_type = 'CN' 
                                  THEN 'Contra' 
                                  WHEN vm.transaction_type = 'JV' 
                                  THEN 'Journal' 
                                  WHEN vm.transaction_type = 'GV' 
                                  THEN 'General' 
                                  WHEN vm.transaction_type = 'RP' 
                                  THEN 'Purchase' 
                                  WHEN vm.transaction_type = 'RS' 
                                  THEN 'Sales' 
                                  WHEN vm.transaction_type = 'VADV' 
                                  THEN 'Advance' 
                                  WHEN vm.transaction_type = 'CADV' 
                                  THEN 'Advance' 
                      END AS trantype,
                      IFNULL(vm.`narration`, '') AS narration, m_voucheramount,vm.`voucher_number`,vm.`cheque_number`,vm.`cheque_date` 
                      FROM
                      voucher_detail vd 
                      INNER JOIN account_master am 
                      ON vd.`account_master_id` = am.id 
                      INNER JOIN voucher_master vm 
                      ON vm.id = vd.`voucher_master_id` 
                      INNER JOIN 
                        (SELECT 
                          vm.id 
                        FROM
                          voucher_master vm 
                          INNER JOIN voucher_detail vd 
                          ON vm.id = vd.`voucher_master_id` 
                          WHERE vd.`account_master_id` = accountId
                          AND vm.`voucher_date` BETWEEN fromDate AND todate
                          AND vm.`company_id` = companyId  
                          AND vm.`year_id` =yearId ) B 
                        ON vm.id = B.id 
                    WHERE vm.id = m_voucherId 
                      AND vd.is_debit = 'Y' ;
               
                 END IF;
                
              
              END IF;#if transaction debit or credit end
              
END LOOP get_acc;
CLOSE CURSOR_1;
END;
#select * from TempTable1;
DROP TEMPORARY TABLE IF EXISTS FinalTable;
CREATE TEMPORARY TABLE FinalTable
(
	_accountName VARCHAR(250),
	_debitamount DECIMAL(12,2),
	_creditamount DECIMAL(12,2),
	_voucherdate DATETIME,
	_acctag VARCHAR(3),
	_trantype VARCHAR(50),
	_grandtotaldebit DECIMAL(12,2),
	_grandtotalcredit DECIMAL(12,2),
	_narration VARCHAR(1500),
	_vouchernumber VARCHAR(50),
	_pagenumber INT,
	_voucherdatecopy DATETIME,
	_vouchernumberforsorting VARCHAR(50)
);
#----------------------
SET v_counter=0;
SET v_pagenumber=1;
SET v_debitbalance=0;
SET v_creditbalance =0;
SET v_openingbalance=0;
SET v_openingdebitbalance=0;
SET v_openingcreditbalance=0;
SET v_openingbalance=(
SELECT SUM(IFNULL(`opening_balance`,0)) 
FROM `account_opening_master`
WHERE `account_master_id` IN (
					 SELECT M.`id` 
					FROM account_master M 
					INNER JOIN `account_opening_master` C
					ON M.id= C.`account_master_id`
					AND C.`account_master_id`=accountId
					)
AND `account_opening_master`.`financialyear_id`=yearId
AND `account_opening_master`.`company_id`=companyId);
IF fromDate > fiscalstart THEN
SELECT SUM(IFNULL(vd.`voucher_amount`,0)) INTO v_openingdebitbalance
	FROM voucher_detail vd
	INNER JOIN voucher_master vm
	ON vm.id=vd.`voucher_master_id` 
	WHERE vd.`account_master_id` =accountId AND (vm.`voucher_date`>=fiscalstart AND vm.`voucher_date` < fromDate)
	AND vm.`company_id` = companyId AND vm.`year_id` = yearId AND vd.`is_debit` ='Y'
	GROUP BY vd.`account_master_id` ORDER BY vd.`account_master_id`;
	
SELECT SUM(IFNULL(vd.`voucher_amount`,0)) INTO v_openingcreditbalance
	FROM voucher_detail vd
	INNER JOIN voucher_master vm
	ON vm.id=vd.`voucher_master_id` 
	WHERE vd.`account_master_id` =accountId AND (vm.`voucher_date`>=fiscalstart AND vm.`voucher_date` < fromDate)
	AND vm.`company_id` = companyId AND vm.`year_id` = yearId AND vd.`is_debit` ='N'
	GROUP BY vd.`account_master_id` ORDER BY vd.`account_master_id`;
END IF;
#opening balance
SET v_openingbalance = v_openingbalance + v_openingdebitbalance - v_openingcreditbalance; 
#opening insertion on final table
IF(v_openingbalance > 0)
  THEN
 
  INSERT INTO FinalTable(_voucherdate,_acctag,_accountName,_debitamount,_creditamount,_grandtotaldebit,_grandtotalcredit,_pagenumber) 
  VALUES (DATE_ADD(fromDate,INTERVAL -1 DAY) ,'Cr.','Opening Balance',v_openingbalance,0,v_openingbalance,0,1);
  SET v_creditbalance = v_creditbalance + v_openingbalance;
  
ELSE
 
   SET v_openingbalance = v_openingbalance * -1;
   
   INSERT INTO FinalTable(_voucherdate,_acctag,_accountName,_debitamount,_creditamount,_grandtotaldebit,_grandtotalcredit,_pagenumber) 
   VALUES ( DATE_ADD(fromDate,INTERVAL -1 DAY),'Dr.','Opening Balance',0,v_openingbalance,0,v_openingbalance,1);
   
    SET v_debitbalance= v_debitbalance + v_openingbalance;
	
 
 END IF; 
 #second cursor
 BEGIN
 DECLARE CONTINUE HANDLER FOR NOT FOUND SET finished = 1;
 OPEN MYCURSOR ;
 get_loop: LOOP
 
 FETCH  MYCURSOR INTO v_voucherdate,v_isdebit,v_accountname,v_narration,v_amount,v_trantype,v_vouchernumber,v_chequeNumber,v_chequeDate ;
 
 IF finished = 1 THEN 
	LEAVE get_loop;
 END IF;
 
 IF(IFNULL(v_chequeNumber,'') = '')
	THEN
		SET v_chequeText='';
	ELSE
		SET v_chequeText=CONCAT(' Cheque no. ' , v_chequeNumber , '. Cheque date ' , DATE_FORMAT (v_chequeDate, '%d/%m/%Y'));
	END IF;
  
 IF v_isdebit = 'Y' THEN
      IF NOT EXISTS(SELECT * FROM FinalTable WHERE _vouchernumber = v_vouchernumber)
			THEN
			INSERT INTO FinalTable(_voucherdate,_acctag,_accountName,_narration,_trantype,_vouchernumber,_debitamount,_creditamount,_grandtotaldebit,_grandtotalcredit,_pagenumber,_vouchernumberforsorting) 
			VALUES (v_voucherdate,'Dr.',v_accountname,CONCAT(v_narration,v_chequeText),v_trantype,v_vouchernumber,0,v_amount,0,v_amount,v_pagenumber,v_vouchernumber);
			SET v_creditbalance= v_creditbalance + v_amount;
		ELSE
				
				SELECT COUNT(vd.`is_debit`) INTO v_creditcount
				FROM voucher_master vm
				INNER JOIN voucher_detail vd
				ON vm.id = vd.`voucher_master_id` 
				WHERE vm.id=v_voucherid  
				AND vd.`is_debit` = 'N'; 
				SELECT COUNT(vd.is_Debit) INTO v_debitcount
				FROM voucher_master vm
				INNER JOIN voucher_detail vd
				ON vm.id = vd.`voucher_master_id` 
				WHERE vm.id=v_voucherid  
				AND vd.`is_debit` = 'Y'; 
				IF (v_debitcount > 1 AND v_creditcount > 1)
				THEN
					
					SET v_dummyvar = 1;
				ELSE
					INSERT INTO FinalTable(_voucherdate,_acctag,_accountName,_narration,_trantype,_vouchernumber,_debitamount,_creditamount,_grandtotaldebit,_grandtotalcredit,_pagenumber,_vouchernumberforsorting) 
					VALUES (v_voucherdate,'Dr.',v_accountname,CONCAT(v_narration,v_chequeText),v_trantype,v_vouchernumber,0,v_amount,0,v_amount,v_pagenumber,v_vouchernumber);
					SET v_creditbalance= v_creditbalance + v_amount;
				END IF;
			END IF;
		
      
      
 ELSE
 -- - NEW ADDITION -- REMOVE DUPLICATE VOUCHER NUMBER
		   IF NOT EXISTS(SELECT * FROM FinalTable WHERE _vouchernumber = v_vouchernumber)
			THEN
			INSERT INTO FinalTable(_voucherdate,_acctag,_accountName,_narration,_trantype,_vouchernumber,_debitamount,_creditamount,_grandtotaldebit,_grandtotalcredit,_pagenumber,_vouchernumberforsorting) VALUES
			(v_voucherdate,'Cr.',v_accountname,CONCAT(v_narration,v_chequeText),v_trantype,v_vouchernumber,v_amount,0,v_amount,0,v_pagenumber,v_vouchernumber);
			SET v_debitbalance= v_debitbalance + v_amount;
		   ELSE
				
				SELECT COUNT(vd.`is_debit`) INTO v_creditcnt
				FROM voucher_master vm
				INNER JOIN voucher_detail vd
				ON vm.id = vd.`voucher_master_id` 
				WHERE vm.id=v_voucherid  -- vm.VoucherNumber = @vouchernumber
				AND vd.is_Debit = 'N'; 
				SELECT COUNT(vd.`is_debit`) INTO v_debitcnt
				FROM voucher_master vm
				INNER JOIN voucher_detail vd
				ON vm.id = vd.`voucher_master_id` 
				WHERE vm.id=v_voucherid  
				AND vd.`is_debit` = 'Y'; 
				IF (v_creditcnt > 1 AND v_debitcnt > 1)
					THEN
						SET v_dummy_var = 1;
				ELSE
						INSERT INTO FinalTable(_voucherdate,_acctag,_accountName,_narration,_trantype,_vouchernumber,_debitamount,_creditamount,_grandtotaldebit,_grandtotalcredit,_pagenumber,_vouchernumberforsorting) 
						VALUES (v_voucherdate,'Cr.',v_accountname,CONCAT(v_narration,v_chequeText),v_trantype,v_vouchernumber,v_amount,0,v_amount,0,v_pagenumber,v_vouchernumber);
						SET v_debitbalance= v_debitbalance + v_amount;
					END IF;
			END IF;	
 
 END IF;
 
 END LOOP get_loop;
 CLOSE MYCURSOR;
 END;
SELECT * FROM FinalTable;
END */$$
DELIMITER ;

/* Procedure structure for procedure `usp_TrialBalance` */

/*!50003 DROP PROCEDURE IF EXISTS  `usp_TrialBalance` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`samrat`@`localhost` PROCEDURE `usp_TrialBalance`(
		CompanyId INT,
		YearId INT,
		fromDate DATETIME,
		toDate DATETIME,
		fiscalstartdate DATETIME
		
)
BEGIN
#variable declaration
  DECLARE totdebit DECIMAL(12,2);
  DECLARE totcredit DECIMAL(12,2);
  DECLARE AccountId INT;
  DECLARE AccountName VARCHAR(50);
  DECLARE OpeningBalance DECIMAL(12,2);
  DECLARE ClosingBalance DECIMAL(12,2);
  DECLARE amount DECIMAL(12,2);
  DECLARE isdebit BIT;
  DECLARE balance DECIMAL(12,2);
  DECLARE ismaster BIT;
  
  DECLARE totdebit_String VARCHAR(50);
  DECLARE totcredit_String VARCHAR(50);
  DECLARE balance_String DECIMAL(12,2);
  DECLARE opbal DECIMAL(12,2);
  -- closing balance variable 01-12-2016
    DECLARE debitBalance DECIMAL(12,2);
	DECLARE creditBalance DECIMAL(12,2);
  -- closing balance variable 01-12-2016
  DECLARE exit_loop BOOLEAN;
-- account id fetch with opening
DECLARE MYCURSOR CURSOR FOR
        SELECT AM.account_name, IFNULL(account_opening_master.opening_balance,0) AS opening,AM.id
        FROM account_master AM
        LEFT JOIN account_opening_master ON  AM.id = account_opening_master.account_master_id 
        AND account_opening_master.financialyear_id =YearId
        WHERE AM.company_id=CompanyId 
        ORDER BY AM.account_name;
        
-- set exit_loop flag to true if there are no more rows
DECLARE CONTINUE HANDLER FOR NOT FOUND SET exit_loop = TRUE;
   
DROP TEMPORARY TABLE IF EXISTS finaltab;
CREATE TEMPORARY TABLE IF NOT EXISTS finaltab
( 
_totalOpening DECIMAL(12,2),
_totalTransDebit DECIMAL(12,2),
_totalTransCredit DECIMAL(12,2),
_totalClosingDebit DECIMAL(12,2),
_totalClosingCredit DECIMAL(12,2),
_AccountName VARCHAR(100)
);
 
   
OPEN MYCURSOR;
account_master: LOOP
FETCH  MYCURSOR INTO AccountName,OpeningBalance,AccountId;
  SET balance :=OpeningBalance;
  SET opbal := OpeningBalance;
  
   IF fromDate > fiscalstartdate THEN
      SET totdebit:=  (SELECT  IFNULL(SUM(VD.voucher_amount ),0) 
					FROM voucher_detail VD
					INNER JOIN voucher_master VM
					ON VD.voucher_master_id =VM.id
					AND VD.is_debit ='Y' AND VD.account_master_id =AccountId
					AND VM.voucher_date >= fiscalstartdate AND VM.voucher_date < fromDate
					AND VM.company_id =CompanyId
					AND VM.year_id =YearId);
      
      SET totcredit:=  (SELECT  IFNULL(SUM(VD.voucher_amount),0) 
					FROM voucher_detail VD
					INNER JOIN voucher_master VM
					ON VD.voucher_master_id =VM.id
					AND VD.is_debit ='N' AND VD.account_master_id =AccountId
					AND VM.voucher_date >= fiscalstartdate AND VM.voucher_date < fromDate
					AND VM.company_id =CompanyId
					AND VM.year_id =YearId);
          
          SET balance := balance + totdebit - totcredit;
					SET totcredit:=0;
					SET totdebit:=0;
      
   
   END IF;
   
   SET totdebit:=  (SELECT  IFNULL(SUM(VD.voucher_amount),0) 
					FROM voucher_detail VD
					INNER JOIN voucher_master VM
					ON VD.voucher_master_id =VM.id
					AND VD.is_debit ='Y' AND VD.account_master_id =AccountId
					AND VM.voucher_date  BETWEEN fromDate AND toDate
					AND VM.company_id =CompanyId
					AND VM.year_id =YearId);
          
     SET totcredit:=  (SELECT  IFNULL(SUM(VD.voucher_amount),0) 
					FROM voucher_detail VD
					INNER JOIN voucher_master VM
					ON VD.voucher_master_id =VM.id
					AND VD.is_debit ='N' AND VD.account_master_id =AccountId
					AND VM.voucher_date  BETWEEN fromDate AND toDate
					AND VM.company_id =CompanyId
					AND VM.year_id =YearId);      
          
    SET balance:= balance + totdebit - totcredit;
    IF exit_loop THEN
         CLOSE MYCURSOR;
         LEAVE account_master;
     END IF;
	 
	 
    IF balance < 0
	THEN
				SET creditBalance:= (balance) *(-1);
				SET debitBalance:=0 ;
	ELSE
			
				SET debitBalance:= balance;
				SET creditBalance:=0;
    END IF;
		INSERT INTO finaltab (_AccountName,_totalOpening ,_totalTransDebit,_totalTransCredit ,_totalClosingDebit,_totalClosingCredit)
		VALUES(AccountName,OpeningBalance,totdebit,totcredit,debitBalance,creditBalance);
			
		SET totcredit:=0;
		SET totdebit:=0;
        SET balance:=0;
   
   
    
END LOOP account_master;
SELECT finaltab._AccountName AS Account,finaltab._totalOpening AS Opening,
		finaltab._totalTransDebit AS Debit,finaltab._totalTransCredit AS Credit,finaltab._totalClosingDebit AS closingDebit,
		finaltab._totalClosingCredit AS closingCredit
FROM finaltab
WHERE (finaltab._totalOpening <> 0 OR finaltab._totalTransDebit<>0 OR finaltab._totalTransCredit<>0 OR finaltab._totalClosingDebit <>0
OR finaltab._totalClosingCredit<>0);
  
END */$$
DELIMITER ;

/* Procedure structure for procedure `usp_TrialBalance_old` */

/*!50003 DROP PROCEDURE IF EXISTS  `usp_TrialBalance_old` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`samrat`@`localhost` PROCEDURE `usp_TrialBalance_old`(
    CompanyId INT,
		YearId INT,
		fromDate DATETIME,
		toDate DATETIME,
		fiscalstartdate DATETIME
)
BEGIN
#variable declaration
  DECLARE totdebit DECIMAL(12,2);
  DECLARE totcredit DECIMAL(12,2);
  DECLARE AccountId INT;
  DECLARE AccountName VARCHAR(50);
  DECLARE OpeningBalance DECIMAL(12,2);
  DECLARE ClosingBalance DECIMAL(12,2);
  DECLARE amount DECIMAL(12,2);
  DECLARE isdebit BIT;
  DECLARE balance DECIMAL(12,2);
  DECLARE ismaster BIT;
  #declare refaccountId int;
  DECLARE totdebit_String VARCHAR(50);
  DECLARE totcredit_String VARCHAR(50);
  DECLARE balance_String DECIMAL(12,2);
  DECLARE opbal DECIMAL(12,2);
  DECLARE exit_loop BOOLEAN;
-- account id fetch with opening
DECLARE MYCURSOR CURSOR FOR
        SELECT AM.account_name, IFNULL(account_opening_master.opening_balance,0) AS opening,AM.id
        FROM account_master AM
        LEFT JOIN account_opening_master ON 
        AM.id = account_opening_master.account_master_id 
        AND account_opening_master.financialyear_id =6
        WHERE AM.company_id=1
        ORDER BY AM.account_name;
        
-- set exit_loop flag to true if there are no more rows
DECLARE CONTINUE HANDLER FOR NOT FOUND SET exit_loop = TRUE;
   
DROP TEMPORARY TABLE IF EXISTS finaltab;
CREATE TEMPORARY TABLE IF NOT EXISTS finaltab
( 
 
_totalDebit DECIMAL(12,2),
_totalCredit DECIMAL(12,2),
_AccountName VARCHAR(50)
);
 
   
OPEN MYCURSOR;
account_master: LOOP
FETCH  MYCURSOR INTO AccountName,OpeningBalance,AccountId;
  SET balance :=OpeningBalance;
  SET opbal := OpeningBalance;
  
   IF fromDate > fiscalstartdate THEN
      SET totdebit:=  (SELECT  IFNULL(SUM(VD.voucher_amount ),0) 
					FROM voucher_detail VD
					INNER JOIN voucher_master VM
					ON VD.voucher_master_id =VM.id
					AND VD.is_debit ='Y' AND VD.account_master_id =AccountId
					AND VM.voucher_date >= fiscalstartdate AND VM.voucher_date < fromDate
					AND VM.company_id =CompanyId
					AND VM.year_id =YearId);
      
      SET totcredit:=  (SELECT  IFNULL(SUM(VD.voucher_amount),0) 
					FROM voucher_detail VD
					INNER JOIN voucher_master VM
					ON VD.voucher_master_id =VM.id
					AND VD.is_debit ='N' AND VD.account_master_id =AccountId
					AND VM.voucher_date >= fiscalstartdate AND VM.voucher_date < fromDate
					AND VM.company_id =CompanyId
					AND VM.year_id =YearId);
          
          SET balance:= balance + totdebit - totcredit;
					SET totcredit:=0;
					SET totdebit:=0;
      
   
   END IF;
   
   SET totdebit:=  (SELECT  IFNULL(SUM(VD.voucher_amount),0) 
					FROM voucher_detail VD
					INNER JOIN voucher_master VM
					ON VD.voucher_master_id =VM.id
					AND VD.is_debit ='Y' AND VD.account_master_id =AccountId
					AND VM.voucher_date  BETWEEN fromDate AND toDate
					AND VM.company_id =CompanyId
					AND VM.year_id =YearId);
          
     SET totcredit:=  (SELECT  IFNULL(SUM(VD.voucher_amount),0) 
					FROM voucher_detail VD
					INNER JOIN voucher_master VM
					ON VD.voucher_master_id =VM.id
					AND VD.is_debit ='N' AND VD.account_master_id =AccountId
					AND VM.voucher_date  BETWEEN fromDate AND toDate
					AND VM.company_id =CompanyId
					AND VM.year_id =YearId);      
          
    SET balance:= balance + totdebit - totcredit;
    
    IF balance < 0
			THEN
				SET balance = balance * -1;
				SET balance_String =balance;# CAST( balance as char)  ;
				IF opbal<>0 OR totdebit<>0 OR totcredit<>0 THEN 
				INSERT INTO finaltab (_AccountName,_totalCredit,_totalDebit) VALUES (AccountName,balance_String,0);
        END IF;
		ELSE
			
				 SET balance_String = balance ; #CAST( balance as char); 
				 IF opbal<>0 OR totdebit<>0 OR totcredit<>0  THEN
				 INSERT INTO finaltab (_AccountName,_totalCredit,_totalDebit) VALUES (AccountName,0,balance_String);
         END IF;
			END IF;
		
			
		SET totcredit:=0;
		SET totdebit:=0;
   
   
   
    IF exit_loop THEN
         CLOSE MYCURSOR;
         LEAVE account_master;
     END IF;
END LOOP account_master;
SELECT * FROM finaltab;
  
END */$$
DELIMITER ;

/* Procedure structure for procedure `usp_trialDetail` */

/*!50003 DROP PROCEDURE IF EXISTS  `usp_trialDetail` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`samrat`@`localhost` PROCEDURE `usp_trialDetail`(
    p_CompanyId INT,
		p_YearId INT,
		p_fromDate DATETIME,
		p_toDate DATETIME,
		p_fiscalstartdate DATETIME
)
BEGIN#main begin
#variable declaration
DECLARE v_accountname VARCHAR(255);
DECLARE v_openingbalance DECIMAL(12,2);
DECLARE v_accountId INTEGER;
DECLARE v_balance DECIMAL(12,2);
DECLARE v_opbal DECIMAL(12,2);
DECLARE v_totdebit DECIMAL(12,2);
DECLARE v_totcredit DECIMAL(12,2);
DECLARE v_creditBalance DECIMAL(12,2);
DECLARE v_debitBalance DECIMAL(12,2);
#variable declaration
DECLARE finished INTEGER DEFAULT 0;
DECLARE MYCURSOR CURSOR FOR
SELECT 
account_master.account_name,
IFNULL(account_opening_master.opening_balance,0) AS opeing,
account_master.id
FROM account_master 
LEFT JOIN account_opening_master 
ON account_master.id=account_opening_master.account_master_id AND account_opening_master.financialyear_id= p_yearId
WHERE 
account_master.company_id =p_CompanyId 
AND account_master.group_master_id NOT IN (1,2) ORDER BY account_master.account_name;
#Sundry drebtor cursor
DECLARE SUNDRY_DEBTOR_CURSOR CURSOR FOR
SELECT 
account_master.account_name,
IFNULL(account_opening_master.opening_balance,0) AS opeing,
account_master.id
FROM account_master 
LEFT JOIN account_opening_master 
ON account_master.id=account_opening_master.account_master_id AND account_opening_master.financialyear_id= p_yearId
WHERE 
account_master.company_id = p_CompanyId 
AND account_master.group_master_id =1 ORDER BY account_master.account_name;
#Sundry creditor cursor
DECLARE SUNDRY_CREDITOR_CURSOR CURSOR FOR
SELECT 
account_master.account_name,
IFNULL(account_opening_master.opening_balance,0) AS opeing,
account_master.id
FROM account_master 
LEFT JOIN account_opening_master 
ON account_master.id=account_opening_master.account_master_id AND account_opening_master.financialyear_id= p_yearId
WHERE 
account_master.company_id = p_CompanyId 
AND account_master.group_master_id =2 ORDER BY account_master.account_name;
	
DECLARE CONTINUE HANDLER 
FOR NOT FOUND SET finished = 1;
DROP TEMPORARY TABLE IF EXISTS finaltab;
CREATE TEMPORARY TABLE IF NOT EXISTS finaltab(
_totalOpening DECIMAL(12,2),
_totalTransDebit DECIMAL(12,2),
_totalTransCredit DECIMAL(12,2),
_totalClosingDebit DECIMAL(12,2),
_totalClosingCredit DECIMAL(12,2),
_AccountName VARCHAR(100)
);
  
  
  
OPEN MYCURSOR ;
get_account : LOOP
FETCH MYCURSOR INTO v_accountname,v_openingbalance,v_accountId;
SET v_opbal = v_openingbalance;
SET v_balance = v_openingbalance;
IF p_fromDate > p_fiscalstartdate THEN
    
 SET v_totdebit:=(
    SELECT IFNULL(SUM(voucher_detail.voucher_amount),0) AS totalDebit
      FROM voucher_detail 
      INNER JOIN voucher_master ON voucher_master.id = voucher_detail.voucher_master_id
      WHERE voucher_master.voucher_date BETWEEN p_fiscalstartdate AND p_fromDate
      AND voucher_master.company_id =p_CompanyId AND voucher_master.year_id=p_YearId AND voucher_detail.is_debit ='Y'
      GROUP BY voucher_detail.account_master_id
      HAVING voucher_detail.account_master_id = v_accountId);
      
  SET v_totcredit :=(
  SELECT IFNULL(SUM(voucher_detail.voucher_amount),0) AS totalDebit
      FROM voucher_detail 
      INNER JOIN voucher_master ON voucher_master.id = voucher_detail.voucher_master_id
      WHERE voucher_master.voucher_date BETWEEN p_fiscalstartdate AND p_fromDate
      AND voucher_master.company_id =p_CompanyId AND voucher_master.year_id=p_YearId AND voucher_detail.is_debit ='N'
      GROUP BY voucher_detail.account_master_id
      HAVING voucher_detail.account_master_id =v_accountId
  );    
          SET v_balance= v_balance + v_totdebit - v_totcredit;
					SET v_totcredit=0;
					SET v_totdebit=0;  
END IF;
# normal
SET v_totdebit:=(
    SELECT IFNULL(SUM(voucher_detail.voucher_amount),0) AS totalDebit
      FROM voucher_detail 
      INNER JOIN voucher_master ON voucher_master.id = voucher_detail.voucher_master_id
      WHERE voucher_master.voucher_date BETWEEN  p_fromDate AND p_toDate
      AND voucher_master.company_id =p_CompanyId AND voucher_master.year_id=p_YearId AND voucher_detail.is_debit ='Y'
      GROUP BY voucher_detail.account_master_id
      HAVING voucher_detail.account_master_id =v_accountId);
      
  SET v_totcredit :=(
  SELECT IFNULL(SUM(voucher_detail.voucher_amount),0) AS totalDebit
      FROM voucher_detail 
      INNER JOIN voucher_master ON voucher_master.id = voucher_detail.voucher_master_id
      WHERE voucher_master.voucher_date BETWEEN p_fromDate AND p_toDate
      AND voucher_master.company_id =p_CompanyId AND voucher_master.year_id=p_YearId AND voucher_detail.is_debit ='N'
      GROUP BY voucher_detail.account_master_id
      HAVING voucher_detail.account_master_id = v_accountId
  );    
SET v_balance= v_balance + v_totdebit - v_totcredit;
  IF v_balance < 0 THEN
		
			SET v_creditBalance = v_balance * -1;
			SET v_debitBalance =0; 
		
		ELSE
		
			SET v_debitBalance = v_balance;
			SET v_creditBalance =0;
			
		END IF;
# normal
INSERT INTO finaltab (_AccountName,_totalOpening ,_totalTransDebit,_totalTransCredit ,_totalClosingDebit,_totalClosingCredit)
		VALUES(v_accountname,v_openingbalance,v_totdebit,v_totcredit,v_debitBalance,v_creditBalance);
		
			
		SET v_totcredit=0;
		SET v_totdebit=0;
		SET v_debitBalance =0;
		SET v_creditBalance =0;
IF finished=1 THEN
  LEAVE get_account;
END IF;
END LOOP get_account;  
CLOSE MYCURSOR;
#account id Sundry Debtors,Sundry Creditors  
#SUNDRY_DEBTOR_CURSOR
OPEN SUNDRY_DEBTOR_CURSOR;
  BEGIN
      DECLARE exit_flag INT DEFAULT 0;
      DECLARE v_accountname VARCHAR(255);
      DECLARE v_openingbalance DECIMAL(12,2);
      DECLARE v_accountId INTEGER;
      DECLARE v_balance DECIMAL(12,2);
      DECLARE v_opbal DECIMAL(12,2);
      DECLARE v_totdebit DECIMAL(12,2);
      DECLARE v_totcredit DECIMAL(12,2);
      DECLARE v_creditBalance DECIMAL(12,2);
      DECLARE v_debitBalance DECIMAL(12,2);
      DECLARE CONTINUE HANDLER FOR SQLSTATE '02000' SET exit_flag = 1;
      
      
      #temp table
      DROP TEMPORARY TABLE IF EXISTS Debtortab;
CREATE TEMPORARY TABLE IF NOT EXISTS Debtortab(
_totalOpening DECIMAL(12,2),
_totalTransDebit DECIMAL(12,2),
_totalTransCredit DECIMAL(12,2),
_totalClosingDebit DECIMAL(12,2),
_totalClosingCredit DECIMAL(12,2),
_AccountName VARCHAR(100)
);
      
      
      
      
      SUNDRY_DEBTOR_CURSOR_LOOP: LOOP
        FETCH SUNDRY_DEBTOR_CURSOR INTO v_accountname,v_openingbalance,v_accountId;
        SET v_opbal = v_openingbalance;
        SET v_balance = v_openingbalance;
        
            IF exit_flag THEN LEAVE SUNDRY_DEBTOR_CURSOR_LOOP; 
            END IF;
           
           IF p_fromDate > p_fiscalstartdate THEN
    
 SET v_totdebit:=(
    SELECT IFNULL(SUM(voucher_detail.voucher_amount),0) AS totalDebit
      FROM voucher_detail 
      INNER JOIN voucher_master ON voucher_master.id = voucher_detail.voucher_master_id
      WHERE voucher_master.voucher_date BETWEEN p_fiscalstartdate AND p_fromDate
      AND voucher_master.company_id =p_CompanyId AND voucher_master.year_id=p_YearId AND voucher_detail.is_debit ='Y'
      GROUP BY voucher_detail.account_master_id
      HAVING voucher_detail.account_master_id = v_accountId);
      
  SET v_totcredit :=(
  SELECT IFNULL(SUM(voucher_detail.voucher_amount),0) AS totalDebit
      FROM voucher_detail 
      INNER JOIN voucher_master ON voucher_master.id = voucher_detail.voucher_master_id
      WHERE voucher_master.voucher_date BETWEEN p_fiscalstartdate AND p_fromDate
      AND voucher_master.company_id =p_CompanyId AND voucher_master.year_id=p_YearId AND voucher_detail.is_debit ='N'
      GROUP BY voucher_detail.account_master_id
      HAVING voucher_detail.account_master_id =v_accountId
  );    
          SET v_balance= v_balance + v_totdebit - v_totcredit;
					SET v_totcredit=0;
					SET v_totdebit=0;  
END IF;
# normal
SET v_totdebit:=(
    SELECT IFNULL(SUM(voucher_detail.voucher_amount),0) AS totalDebit
      FROM voucher_detail 
      INNER JOIN voucher_master ON voucher_master.id = voucher_detail.voucher_master_id
      WHERE voucher_master.voucher_date BETWEEN  p_fromDate AND p_toDate
      AND voucher_master.company_id =p_CompanyId AND voucher_master.year_id=p_YearId AND voucher_detail.is_debit ='Y'
      GROUP BY voucher_detail.account_master_id
      HAVING voucher_detail.account_master_id =v_accountId);
      
  SET v_totcredit :=(
  SELECT IFNULL(SUM(voucher_detail.voucher_amount),0) AS totalDebit
      FROM voucher_detail 
      INNER JOIN voucher_master ON voucher_master.id = voucher_detail.voucher_master_id
      WHERE voucher_master.voucher_date BETWEEN p_fromDate AND p_toDate
      AND voucher_master.company_id =p_CompanyId AND voucher_master.year_id=p_YearId AND voucher_detail.is_debit ='N'
      GROUP BY voucher_detail.account_master_id
      HAVING voucher_detail.account_master_id = v_accountId
  );    
SET v_balance= v_balance + v_totdebit - v_totcredit;
  IF v_balance < 0 THEN
		
			SET v_creditBalance = v_balance * -1;
			SET v_debitBalance =0; 
		
		ELSE
		
			SET v_debitBalance = v_balance;
			SET v_creditBalance =0;
			
		END IF;
# normal
INSERT INTO Debtortab (_AccountName,_totalOpening ,_totalTransDebit,_totalTransCredit ,_totalClosingDebit,_totalClosingCredit)
		VALUES(v_accountname,v_openingbalance,v_totdebit,v_totcredit,v_debitBalance,v_creditBalance);
		
			
		SET v_totcredit=0;
		SET v_totdebit=0;
		SET v_debitBalance =0;
		SET v_creditBalance =0;
           
      
      
      END LOOP;
  END;
  CLOSE SUNDRY_DEBTOR_CURSOR;
INSERT INTO finaltab(_AccountName,_totalOpening ,_totalTransDebit,_totalTransCredit ,_totalClosingDebit,_totalClosingCredit)
SELECT  'Sundry Debtor',SUM(_totalOpening) AS opening,SUM(_totalTransDebit)AS trnsDr,SUM(_totalTransCredit) AS transCr,
SUM(_totalClosingDebit)AS closeDr,SUM(_totalClosingCredit)AS CloseCr
FROM Debtortab;
#SUNDRY_CREDITOR_CURSOR;
OPEN SUNDRY_CREDITOR_CURSOR;
  BEGIN
      DECLARE exit_flag INT DEFAULT 0;
      DECLARE v_accountname VARCHAR(255);
      DECLARE v_openingbalance DECIMAL(12,2);
      DECLARE v_accountId INTEGER;
      DECLARE v_balance DECIMAL(12,2);
      DECLARE v_opbal DECIMAL(12,2);
      DECLARE v_totdebit DECIMAL(12,2);
      DECLARE v_totcredit DECIMAL(12,2);
      DECLARE v_creditBalance DECIMAL(12,2);
      DECLARE v_debitBalance DECIMAL(12,2);
      DECLARE CONTINUE HANDLER FOR SQLSTATE '02000' SET exit_flag = 1;
      
      
      #temp table
      DROP TEMPORARY TABLE IF EXISTS Creditortab;
CREATE TEMPORARY TABLE IF NOT EXISTS Creditortab(
_totalOpening DECIMAL(12,2),
_totalTransDebit DECIMAL(12,2),
_totalTransCredit DECIMAL(12,2),
_totalClosingDebit DECIMAL(12,2),
_totalClosingCredit DECIMAL(12,2),
_AccountName VARCHAR(100)
);
      
      
      
      
      SUNDRY_CREDITOR_CURSOR_LOOP: LOOP
        FETCH SUNDRY_CREDITOR_CURSOR INTO v_accountname,v_openingbalance,v_accountId;
        SET v_opbal = v_openingbalance;
        SET v_balance = v_openingbalance;
        
            IF exit_flag THEN LEAVE SUNDRY_CREDITOR_CURSOR_LOOP; 
            END IF;
           
           IF p_fromDate > p_fiscalstartdate THEN
    
 SET v_totdebit:=(
    SELECT IFNULL(SUM(voucher_detail.voucher_amount),0) AS totalDebit
      FROM voucher_detail 
      INNER JOIN voucher_master ON voucher_master.id = voucher_detail.voucher_master_id
      WHERE voucher_master.voucher_date BETWEEN p_fiscalstartdate AND p_fromDate
      AND voucher_master.company_id =p_CompanyId AND voucher_master.year_id=p_YearId AND voucher_detail.is_debit ='Y'
      GROUP BY voucher_detail.account_master_id
      HAVING voucher_detail.account_master_id = v_accountId);
      
  SET v_totcredit :=(
  SELECT IFNULL(SUM(voucher_detail.voucher_amount),0) AS totalDebit
      FROM voucher_detail 
      INNER JOIN voucher_master ON voucher_master.id = voucher_detail.voucher_master_id
      WHERE voucher_master.voucher_date BETWEEN p_fiscalstartdate AND p_fromDate
      AND voucher_master.company_id =p_CompanyId AND voucher_master.year_id=p_YearId AND voucher_detail.is_debit ='N'
      GROUP BY voucher_detail.account_master_id
      HAVING voucher_detail.account_master_id =v_accountId
  );    
          SET v_balance= v_balance + v_totdebit - v_totcredit;
					SET v_totcredit=0;
					SET v_totdebit=0;  
END IF;
# normal
SET v_totdebit:=(
    SELECT IFNULL(SUM(voucher_detail.voucher_amount),0) AS totalDebit
      FROM voucher_detail 
      INNER JOIN voucher_master ON voucher_master.id = voucher_detail.voucher_master_id
      WHERE voucher_master.voucher_date BETWEEN  p_fromDate AND p_toDate
      AND voucher_master.company_id =p_CompanyId AND voucher_master.year_id=p_YearId AND voucher_detail.is_debit ='Y'
      GROUP BY voucher_detail.account_master_id
      HAVING voucher_detail.account_master_id =v_accountId);
      
  SET v_totcredit :=(
  SELECT IFNULL(SUM(voucher_detail.voucher_amount),0) AS totalDebit
      FROM voucher_detail 
      INNER JOIN voucher_master ON voucher_master.id = voucher_detail.voucher_master_id
      WHERE voucher_master.voucher_date BETWEEN p_fromDate AND p_toDate
      AND voucher_master.company_id =p_CompanyId AND voucher_master.year_id=p_YearId AND voucher_detail.is_debit ='N'
      GROUP BY voucher_detail.account_master_id
      HAVING voucher_detail.account_master_id = v_accountId
  );    
SET v_balance= v_balance + v_totdebit - v_totcredit;
  IF v_balance < 0 THEN
		
			SET v_creditBalance = v_balance * -1;
			SET v_debitBalance =0; 
		
		ELSE
		
			SET v_debitBalance = v_balance;
			SET v_creditBalance =0;
			
		END IF;
# normal
INSERT INTO Creditortab (_AccountName,_totalOpening ,_totalTransDebit,_totalTransCredit ,_totalClosingDebit,_totalClosingCredit)
		VALUES(v_accountname,v_openingbalance,v_totdebit,v_totcredit,v_debitBalance,v_creditBalance);
		
			
		SET v_totcredit=0;
		SET v_totdebit=0;
		SET v_debitBalance =0;
		SET v_creditBalance =0;
           
      
      
      END LOOP;
  END;
  CLOSE SUNDRY_CREDITOR_CURSOR;
#select * from Creditortab;
INSERT INTO finaltab(_AccountName,_totalOpening ,_totalTransDebit,_totalTransCredit ,_totalClosingDebit,_totalClosingCredit)
SELECT  'Sundry Creditor',SUM(_totalOpening) AS opening,SUM(_totalTransDebit)AS trnsDr,SUM(_totalTransCredit) AS transCr,
SUM(_totalClosingDebit)AS closeDr,SUM(_totalClosingCredit)AS CloseCr
FROM Creditortab;
#SELECT * FROM finaltab;
SELECT 
finaltab._AccountName AS Account,
finaltab._totalOpening AS Opening,
finaltab._totalTransDebit AS Debit,
finaltab._totalTransCredit AS Credit,
CASE
WHEN ((IFNULL(finaltab._totalOpening,0) + IFNULL(finaltab._totalTransDebit,0)) -(IFNULL(finaltab._totalTransCredit,0)))>0 THEN
	((IFNULL(finaltab._totalOpening,0) + IFNULL(finaltab._totalTransDebit,0)) -(IFNULL(finaltab._totalTransCredit,0)))
ELSE NULL
END AS closingDebit,
CASE
WHEN ((IFNULL(finaltab._totalOpening,0) + IFNULL(finaltab._totalTransDebit,0)) -(IFNULL(finaltab._totalTransCredit,0)))<0 THEN
	((IFNULL(finaltab._totalOpening,0) + IFNULL(finaltab._totalTransDebit,0)) -(IFNULL(finaltab._totalTransCredit,0))) * (-1)
ELSE NULL
END AS closingCredit
#finaltab._totalClosingDebit AS closingDebit,
#finaltab._totalClosingCredit AS closingCredit
FROM finaltab
WHERE (finaltab._totalOpening <> 0 OR finaltab._totalTransDebit<>0 OR finaltab._totalTransCredit<>0 OR finaltab._totalClosingDebit <>0
OR finaltab._totalClosingCredit<>0);
END */$$
DELIMITER ;

/* Procedure structure for procedure `voucher_check` */

/*!50003 DROP PROCEDURE IF EXISTS  `voucher_check` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`samrat`@`localhost` PROCEDURE `voucher_check`(
IN companyId INT(20),
IN yearId INT(20)
)
BEGIN
DECLARE mVoucherNumber VARCHAR(255) DEFAULT NULL;
DECLARE mVoucherType VARCHAR(50) DEFAULT NULL;
DECLARE mCreditAmount DECIMAL(10,2) DEFAULT 0;
DECLARE mDebitAmount DECIMAL(10,2) DEFAULT 0;
DECLARE mVoucherMasterId INTEGER DEFAULT 0;
DECLARE diff DECIMAL(10,2) ;
DECLARE cursor_finish INTEGER DEFAULT 0;
#cursor declaration 
DECLARE cursorvoucher CURSOR FOR
SELECT voucher_master.voucher_number,voucher_master.id,voucher_master.transaction_type
FROM voucher_master WHERE voucher_master.company_id = companyId AND voucher_master.year_id=yearId
ORDER BY voucher_master.id;
#declare cursor handler
	DECLARE CONTINUE HANDLER 
	FOR NOT FOUND SET cursor_finish = 1;
  
  DROP TEMPORARY TABLE IF EXISTS debitCreditTable;
 
 #temptable creation
 CREATE TEMPORARY TABLE IF NOT EXISTS  debitCreditTable
(
	vouchermasterid INT,
	vouchernumber VARCHAR(255),
	vouchertype VARCHAR(50),
	creditamount DECIMAL(10,2),
	debitamount DECIMAL(10,2),
	diff DECIMAL(10,2)
);
    
     OPEN cursorvoucher ;
     get_bill: LOOP	
     
     FETCH cursorvoucher INTO mVoucherNumber,mVoucherMasterId,mVoucherType;
     IF cursor_finish=1 THEN
      LEAVE get_bill;
     END IF;
 #credit amount
SET @m_creditAmount:=(SELECT 
                        IFNULL(SUM(voucher_detail.voucher_amount),0) AS CreditAmount
                    FROM voucher_master
                    INNER JOIN
                    voucher_detail ON voucher_master.id = voucher_detail.voucher_master_id 
                    AND voucher_detail.is_debit='N'
                    GROUP BY voucher_master.id, voucher_master.voucher_number
                    HAVING  voucher_master.id = mVoucherMasterId);
#debit_amount
SET @m_debitAmount:=(SELECT 
                        IFNULL(SUM(voucher_detail.voucher_amount),0) AS debitamount
                    FROM voucher_master
                    INNER JOIN
                    voucher_detail ON voucher_master.id = voucher_detail.voucher_master_id 
                    AND voucher_detail.is_debit='Y'
                    GROUP BY voucher_master.id, voucher_master.voucher_number
                    HAVING  voucher_master.id = mVoucherMasterId);
SET diff = @m_debitAmount -  @m_creditAmount;
IF diff<>0 THEN
INSERT INTO debitCreditTable
(
	vouchermasterid ,
	vouchernumber ,
  vouchertype ,
	creditamount,
  debitamount ,diff
)VALUES(mVoucherMasterId,mVoucherNumber,mVoucherType,@m_creditAmount,@m_debitAmount,diff);
END IF;  
  
  END LOOP get_bill;
	CLOSE cursorvoucher; 
SELECT * FROM debitCreditTable ORDER BY vouchertype;
	
END */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
