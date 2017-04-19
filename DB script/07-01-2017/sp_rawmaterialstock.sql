DELIMITER $$

USE `teasamrat`$$

DROP PROCEDURE IF EXISTS `sp_rawmaterialstock`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_rawmaterialstock`()
BEGIN
    DECLARE cursor_finish INTEGER DEFAULT 0;
    DECLARE cursor_finish_rawmaterial INTEGER DEFAULT 0;
    DECLARE m_productPacketId INT;
    DECLARE m_numberofpacket DECIMAL(12,2);
    DECLARE m_OpeningStockRawMaterial decimal(12,2); #06-01-2017
    DECLARE m_PurchaseOfRawMaterial decimal(12,2); #06-01-2017
	DECLARE m_rawMaterialId INT;
	DECLARE m_rawMaterialDesc VARCHAR(256);
	DECLARE m_rawMaterialStockIn decimal(12,2);
    #cursor for consumption
    DECLARE rawmaterialConsumptionCursor CURSOR FOR 
    SELECT  
	    SUM(finished_product_dtl.`numberof_packet`) AS numofpacket,
	    finished_product_dtl.`product_packet` AS productpacketid
    FROM `finished_product_dtl`
	INNER JOIN `product_packet` ON finished_product_dtl.`product_packet` = product_packet.`id`
	INNER JOIN `product` ON `product`.`id`= `product_packet`.`productid`
	INNER JOIN `packet` ON `packet`.`id` = `product_packet`.`packetid`
	GROUP BY finished_product_dtl.`product_packet`;
  
  #cursor for opeining and purchase
  DECLARE rawmaterialCursor cursor for
  SELECT 
      `raw_material_master`.`id`, 
      `raw_material_master`.`product_description`,
      IFNULL(`raw_material_opening`.`opening`,0) as openingQty
      FROM `raw_material_master`
      LEFT JOIN
      `raw_material_opening` ON `raw_material_master`.`id`=`raw_material_opening`.`rawmaterialId`
      AND `raw_material_opening`.`companyid`=1 AND `raw_material_opening`.`yearid`=6;
  #end cursor
	
DECLARE CONTINUE HANDLER  FOR NOT FOUND SET cursor_finish = 1;
DECLARE CONTINUE HANDLER  FOR NOT FOUND SET cursor_finish_rawmaterial = 1;
DROP TEMPORARY TABLE IF EXISTS tempRawMaterialConsumption;
CREATE TEMPORARY TABLE IF NOT EXISTS  tempRawMaterialConsumption
(
	rawmaterialId INT,
	rawmaterial VARCHAR(256),
	consumption NUMERIC(12,2)
);
#Stock in temp table
DROP TEMPORARY TABLE IF EXISTS tempRawMaterialStockIn;
CREATE TEMPORARY TABLE IF NOT EXISTS  tempRawMaterialStockIn
(
	rawmaterialId INT,
	rawmaterial VARCHAR(256),
	stockIn NUMERIC(12,2)
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

#new cursor loop 07-01-2017
OPEN rawmaterialCursor;

get_rawmaterialStockIn: LOOP
FETCH rawmaterialCursor INTO m_rawMaterialId,m_rawMaterialDesc,m_OpeningStockRawMaterial;
SET m_PurchaseOfRawMaterial=(
SELECT 
ifnull( SUM(`rawmaterial_purchasedetail`.`quantity`) ,0)AS purchaseQty
 FROM `rawmaterial_purchasedetail`
INNER JOIN `rawmaterial_purchase_master` 
ON `rawmaterial_purchase_master`.`id` = `rawmaterial_purchasedetail`.`rawmat_purchase_masterId`
WHERE `rawmaterial_purchasedetail`.`productid`=m_rawMaterialId AND 
`rawmaterial_purchase_master`.`companyid`=1 AND `rawmaterial_purchase_master`.`yearid`=6
GROUP BY
  `rawmaterial_purchasedetail`.`productid`);
  
  set m_rawMaterialStockIn = (m_OpeningStockRawMaterial + m_PurchaseOfRawMaterial);
  

Insert INTO tempRawMaterialStockIn(rawmaterialId,rawmaterial,stockIn) 
Values(m_rawMaterialId,m_rawMaterialDesc,m_rawMaterialStockIn);


END LOOP get_rawmaterialStockIn;
CLOSE rawmaterialCursor;
SELECT * FROM tempRawMaterialStockIn;



END$$

DELIMITER ;