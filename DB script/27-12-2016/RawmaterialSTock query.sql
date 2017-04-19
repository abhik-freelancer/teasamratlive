SELECT 
`finished_product_dtl`.`id`,
`finished_product_dtl`.`numberof_packet`  AS Number_of_Bags,
`finished_product_dtl`.`product_packet`,
CONCAT(`product`.`product`,'',`packet`.`packet`) AS productPacket,
`packet`.`PacketQty`,`packet`.`qtyinBag`
FROM 
finished_product_dtl 
INNER JOIN 
`product_packet` ON `finished_product_dtl`.`product_packet`=product_packet.`id`
INNER JOIN
`product` ON product_packet.`productid`=product.`id`
INNER JOIN
`packet` ON `product_packet`.`packetid` = `packet`.`id`
WHERE finished_product_dtl.`product_packet` =40
/***************************************************************/

SELECT 
#`finished_product_dtl`.`id`,
SUM(`finished_product_dtl`.`numberof_packet`) AS totalBags , 
`finished_product_dtl`.`product_packet`,
CONCAT(`product`.`product`,'',`packet`.`packet`) AS productPacket,
#`packet`.`PacketQty`,
(SUM(`finished_product_dtl`.`numberof_packet`)*`packet`.`qtyinBag`) AS totalQtyInBag
FROM 
finished_product_dtl 
INNER JOIN 
`product_packet` ON `finished_product_dtl`.`product_packet`=product_packet.`id`
INNER JOIN
`product` ON product_packet.`productid`=product.`id`
INNER JOIN
`packet` ON `product_packet`.`packetid` = `packet`.`id`
#WHERE finished_product_dtl.`product_packet` =51
GROUP BY finished_product_dtl.`product_packet`
#-----
SELECT
 product_rawmaterial_consumption.`id`,
  `rawmaterialid`,`raw_material_master`.`product_description`,
  `quantity_required`,
  `product_packetId`
FROM `teasamrat`.`product_rawmaterial_consumption`
INNER JOIN `raw_material_master` ON `product_rawmaterial_consumption`.`rawmaterialid` = `raw_material_master`.`id`
WHERE product_rawmaterial_consumption.`product_packetId` =51



