DELIMITER $$

USE `teasamrat`$$

DROP PROCEDURE IF EXISTS `sp_GetStockWithCostRangeWise`$$

CREATE DEFINER=`samrat`@`localhost` PROCEDURE `sp_GetStockWithCostRangeWise`(
IN fromcost DECIMAL(10,2),
IN tocost DECIMAL(10,2)
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
INNER JOIN
`do_to_transporter`
ON purchase_invoice_detail.`id` = do_to_transporter.`purchase_inv_dtlid`
WHERE  do_to_transporter.`in_Stock`='Y' AND (purchase_invoice_detail.`cost_of_tea` BETWEEN fromcost AND tocost) ;
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
SET @m_StockBag:=(m_numofpurchaseBag - @m_numberofBlndBag);
SET @m_StockKg:=(m_purchasedKg - @m_BlndKg);

INSERT INTO StockTable
(
	purchaseBagDtlId ,
	purchasedBag ,
	purchasedKg ,
	blendedBag ,
	blendedKg ,
	stockBag  ,
	stockKg  ,purchaseInvoiceDetailId 	
)VALUES(m_purBagDtlId,m_numofpurchaseBag,m_purchasedKg,@m_numberofBlndBag,@m_BlndKg,@m_StockBag,@m_StockKg,m_purchaseInvoiceDetailId);

 END LOOP get_stock;
 CLOSE stockCursor;
#Stock Print Start
SELECT StockTable.purchaseInvoiceDetailId,
 StockTable.stockBag AS NumberOfStockBag,StockTable.stockKg AS StockBagQty,
 StockTable.purchasedBag AS PurchasedBags,StockTable.purchasedKg AS PurchasedKgs,
 StockTable.blendedBag AS BlendedBags,StockTable.blendedKg AS BlendedKgs,
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
LEFT JOIN `location` ON `purchase_invoice_detail`.`location_id` = `location`.`id`
INNER JOIN `purchase_bag_details` ON StockTable.purchaseBagDtlId = `purchase_bag_details`.`id`;
#Stock Print END
 END$$

DELIMITER ;