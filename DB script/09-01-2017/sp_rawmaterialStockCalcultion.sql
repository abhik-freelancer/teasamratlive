DELIMITER $$

CREATE PROCEDURE `teasamrat`.`sp_rawmaterialStockCalcultion` (IN companyId INT,IN yearId INT) 
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
  
  
 
END $$

 #main end

DELIMITER ;