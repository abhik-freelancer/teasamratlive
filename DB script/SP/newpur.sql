/*
SQLyog Ultimate v10.00 Beta1
MySQL - 5.6.11 : Database - teasamrat
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

/*Table structure for table `purchase_finishproductdetail` */

DROP TABLE IF EXISTS `purchase_finishproductdetail`;

CREATE TABLE `purchase_finishproductdetail` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `purchase_finishmasterId` int(20) DEFAULT NULL,
  `productpacketid` int(20) DEFAULT NULL,
  `packingbox` decimal(12,2) DEFAULT NULL,
  `packingnet` decimal(12,2) DEFAULT NULL,
  `quantity` decimal(12,2) DEFAULT NULL,
  `rate` decimal(12,2) DEFAULT NULL,
  `amount` decimal(12,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_finish_purchase_master` (`purchase_finishmasterId`),
  CONSTRAINT `fk_finish_purchase_master` FOREIGN KEY (`purchase_finishmasterId`) REFERENCES `purchase_finishproductmaster` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

/*Data for the table `purchase_finishproductdetail` */

LOCK TABLES `purchase_finishproductdetail` WRITE;

insert  into `purchase_finishproductdetail`(`id`,`purchase_finishmasterId`,`productpacketid`,`packingbox`,`packingnet`,`quantity`,`rate`,`amount`) values (5,5,50,'12.00','30.00','360.00','142.86','51429.60'),(6,3,70,'1.00','30.00','30.00','180.95','5428.50'),(19,4,59,'12.00','28.00','336.00','200.00','67200.00'),(20,4,58,'1.00','28.00','28.00','200.00','5600.00'),(21,4,40,'12.00','28.00','336.00','190.48','64001.28'),(22,6,59,'10.00','28.00','280.00','200.00','56000.00');

UNLOCK TABLES;

/*Table structure for table `purchase_finishproductmaster` */

DROP TABLE IF EXISTS `purchase_finishproductmaster`;

CREATE TABLE `purchase_finishproductmaster` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `srl_no` int(20) NOT NULL,
  `purchasebillno` varchar(255) DEFAULT NULL,
  `purchasebilldate` datetime DEFAULT NULL,
  `vendorId` int(20) DEFAULT NULL,
  `voucher_master_id` int(20) DEFAULT NULL,
  `vehicleno` varchar(255) DEFAULT NULL,
  `taxrateType` char(1) DEFAULT NULL,
  `taxtRateTypeId` int(20) DEFAULT NULL,
  `taxAmount` decimal(12,2) DEFAULT NULL,
  `discountRate` decimal(12,2) DEFAULT NULL,
  `discountAmount` decimal(12,2) DEFAULT NULL,
  `deliverycharges` decimal(12,2) DEFAULT NULL,
  `totalpacket` decimal(12,2) DEFAULT NULL,
  `totalquantity` decimal(12,2) DEFAULT NULL,
  `totalamount` decimal(12,2) DEFAULT NULL,
  `roundoff` decimal(12,2) DEFAULT NULL,
  `grandtotal` decimal(12,2) DEFAULT NULL,
  `yearid` int(20) DEFAULT NULL,
  `companyid` int(20) DEFAULT NULL,
  `creationdate` datetime DEFAULT NULL,
  `userid` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_vendorId` (`vendorId`),
  KEY `FK_VoucherMasterId` (`voucher_master_id`),
  CONSTRAINT `FK_vendorId` FOREIGN KEY (`vendorId`) REFERENCES `vendor` (`id`),
  CONSTRAINT `FK_VoucherMasterId` FOREIGN KEY (`voucher_master_id`) REFERENCES `voucher_master` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `purchase_finishproductmaster` */

LOCK TABLES `purchase_finishproductmaster` WRITE;

insert  into `purchase_finishproductmaster`(`id`,`srl_no`,`purchasebillno`,`purchasebilldate`,`vendorId`,`voucher_master_id`,`vehicleno`,`taxrateType`,`taxtRateTypeId`,`taxAmount`,`discountRate`,`discountAmount`,`deliverycharges`,`totalpacket`,`totalquantity`,`totalamount`,`roundoff`,`grandtotal`,`yearid`,`companyid`,`creationdate`,`userid`) values (3,1,'TS/001233','2017-04-05 00:00:00',84,3181,NULL,'V',12,'0.00','0.00','0.00',NULL,'1.00','30.00','5428.50','0.00','5455.64',7,3,'2017-04-05 00:00:00',2),(4,1,'TS/00004/16-17','2017-04-05 00:00:00',84,3182,NULL,'V',12,'684.01','0.00','0.00',NULL,'25.00','700.00','136801.28','0.00','137485.29',7,3,'2017-04-05 00:00:00',2),(5,1,'TEST/0002121','2017-04-05 00:00:00',84,3183,NULL,'V',12,'257.15','0.00','0.00',NULL,'12.00','360.00','51429.60','0.00','51686.75',7,3,'2017-04-05 00:00:00',2),(6,1,'TS/00010/17-18','2017-04-06 00:00:00',84,3194,NULL,'V',11,'2800.00','0.00','0.00',NULL,'10.00','280.00','56000.00','0.00','58800.00',7,3,'2017-04-06 00:00:00',2);

UNLOCK TABLES;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
