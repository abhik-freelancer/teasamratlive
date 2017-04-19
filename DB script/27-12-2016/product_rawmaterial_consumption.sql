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

/*Table structure for table `product_rawmaterial_consumption` */

DROP TABLE IF EXISTS `product_rawmaterial_consumption`;

CREATE TABLE `product_rawmaterial_consumption` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `rawmaterialid` int(20) DEFAULT NULL,
  `quantity_required` decimal(10,2) DEFAULT NULL,
  `product_packetId` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_rawmaterialid` (`rawmaterialid`),
  KEY `fk_product_packet` (`product_packetId`),
  CONSTRAINT `fk_product_packet` FOREIGN KEY (`product_packetId`) REFERENCES `product_packet` (`id`),
  CONSTRAINT `fk_rawmaterialid` FOREIGN KEY (`rawmaterialid`) REFERENCES `raw_material_master` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
