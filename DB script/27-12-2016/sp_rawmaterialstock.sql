DELIMITER $$

CREATE
    
    PROCEDURE `sp_rawmaterialstock`()
   
    BEGIN
    DECLARE cursor_finish INTEGER DEFAULT 0;
    DECLARE m_productPacketId INT;
    DECLARE m_numberofpacket DECIMAL(12,2);
    
    DECLARE rawmaterialConsumptionCursor CURSOR FOR 
    SELECT  
	    SUM(finished_product_dtl.`numberof_packet`) AS numofpacket,
	    finished_product_dtl.`product_packet` AS productpacketid
    FROM `finished_product_dtl`
	INNER JOIN `product_packet` ON finished_product_dtl.`product_packet` = product_packet.`id`
	INNER JOIN `product` ON `product`.`id`= `product_packet`.`productid`
	INNER JOIN `packet` ON `packet`.`id` = `product_packet`.`packetid`
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

SELECT * FROM tempRawMaterialConsumption;



END$$ 

DELIMITER ;

#call sp_rawmaterialstock