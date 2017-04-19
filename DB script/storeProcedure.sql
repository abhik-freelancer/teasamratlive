/*
SQLyog Ultimate v10.00 Beta1
MySQL - 5.6.16 : Database - tea_samrat
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`tea_samrat` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `tea_samrat`;

/* Procedure structure for procedure `sp_allgroup_stock` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_allgroup_stock` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_allgroup_stock`()
BEGIN
SELECT PID.`id` AS purchaseDtl,PBD.`id` AS purchaseBagDtlId,
`blending_details`.`id`,
PID.`teagroup_master_id`,PID.`invoice_number`,garden_master.`garden_name`,grade_master.`grade`,location.`location`,teagroup_master.`group_code`,
PID.`price`,PBD.`actual_bags`,PBD.`net`,PBD.`shortkg`,`blending_details`.`number_of_blended_bag`,`blending_details`.`qty_of_bag`,
(IF(PBD.`actual_bags` IS NULL, 0,PBD.`actual_bags`) -
 IF(`blending_details`.`number_of_blended_bag` IS NULL,0,`blending_details`.`number_of_blended_bag`)) AS NumberOfStockBag,
((
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
INNER JOIN `teagroup_master` ON PID.`teagroup_master_id` = `teagroup_master`.`id`;
END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_allgroup_sum_stock` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_allgroup_sum_stock` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_allgroup_sum_stock`()
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
GROUP BY PID.`teagroup_master_id`;
END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_groupwise_stock` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_groupwise_stock` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_groupwise_stock`(
 IN teagroup INT(10)
)
BEGIN	
SELECT PID.`id` AS purchaseDtl,PBD.`id` AS purchaseBagDtlId,
`blending_details`.`id`,
PID.`teagroup_master_id`,PID.`invoice_number`,garden_master.`garden_name`,grade_master.`grade`,location.`location`,teagroup_master.`group_code`,
PID.`price`,PBD.`actual_bags`,PBD.`net`,PBD.`shortkg`,`blending_details`.`number_of_blended_bag`,`blending_details`.`qty_of_bag`,
(IF(PBD.`actual_bags` IS NULL, 0,PBD.`actual_bags`) -
 IF(`blending_details`.`number_of_blended_bag` IS NULL,0,`blending_details`.`number_of_blended_bag`)) AS NumberOfStockBag,
((
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
WHERE PID.`teagroup_master_id`=teagroup;
END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_groupwise_sum_stock` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_groupwise_sum_stock` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_groupwise_sum_stock`(
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
END */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
