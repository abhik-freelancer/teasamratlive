DELIMITER $$

USE `tea_samrat`$$

DROP PROCEDURE IF EXISTS `sp_groupwise_sum_stock`$$

CREATE  PROCEDURE `sp_groupwise_sum_stock`(
 IN teagroup INT(10)
)
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
END$$

DELIMITER ;