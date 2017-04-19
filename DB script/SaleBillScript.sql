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

/*Table structure for table `sale_bill_details` */

DROP TABLE IF EXISTS `sale_bill_details`;

CREATE TABLE `sale_bill_details` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `salebillmasterid` int(20) DEFAULT NULL,
  `productpacketid` int(20) DEFAULT NULL,
  `packingbox` double(10,2) DEFAULT NULL,
  `packingnet` double(10,2) DEFAULT NULL,
  `quantity` double(10,2) DEFAULT NULL,
  `rate` double(10,2) DEFAULT NULL,
  `amount` double(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_salebill_master` (`salebillmasterid`),
  KEY `fk_product_packet_id` (`productpacketid`),
  CONSTRAINT `fk_product_packet_id` FOREIGN KEY (`productpacketid`) REFERENCES `product_packet` (`id`),
  CONSTRAINT `fk_salebill_master` FOREIGN KEY (`salebillmasterid`) REFERENCES `sale_bill_master` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8;

/*Table structure for table `sale_bill_master` */

DROP TABLE IF EXISTS `sale_bill_master`;

CREATE TABLE `sale_bill_master` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `salebillno` varchar(255) DEFAULT NULL,
  `salebilldate` datetime DEFAULT NULL,
  `customerId` int(20) DEFAULT NULL,
  `taxinvoiceno` varchar(255) DEFAULT NULL,
  `taxinvoicedate` datetime DEFAULT NULL,
  `duedate` datetime DEFAULT NULL,
  `taxrateType` enum('C','V') DEFAULT NULL COMMENT 'C=CST,V=VAT',
  `taxrateTypeId` int(20) DEFAULT NULL,
  `taxamount` double(10,2) DEFAULT NULL,
  `discountRate` double(10,2) DEFAULT NULL,
  `discountAmount` double(10,2) DEFAULT NULL,
  `totalpacket` double(10,2) DEFAULT NULL,
  `totalquantity` double(10,2) DEFAULT NULL,
  `totalamount` double(10,2) DEFAULT NULL,
  `roundoff` double(10,2) DEFAULT NULL,
  `grandtotal` double(10,2) DEFAULT NULL,
  `yearid` int(20) DEFAULT NULL,
  `companyid` int(20) DEFAULT NULL,
  `creationdate` int(20) DEFAULT NULL,
  `userid` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_customer` (`customerId`),
  CONSTRAINT `fk_customer` FOREIGN KEY (`customerId`) REFERENCES `customer` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
