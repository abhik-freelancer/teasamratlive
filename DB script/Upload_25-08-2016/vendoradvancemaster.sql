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

/*Table structure for table `vendoradvancemaster` */

DROP TABLE IF EXISTS `vendoradvancemaster`;

CREATE TABLE `vendoradvancemaster` (
  `advanceId` int(20) NOT NULL AUTO_INCREMENT,
  `advanceDate` datetime DEFAULT NULL,
  `voucherId` int(20) DEFAULT NULL,
  `advanceAmount` decimal(10,2) DEFAULT NULL,
  `vendorId` int(20) DEFAULT NULL,
  `isFullAdjusted` enum('Y','N') DEFAULT NULL,
  `companyId` int(20) DEFAULT NULL,
  `yearId` int(20) DEFAULT NULL,
  PRIMARY KEY (`advanceId`),
  KEY `FK_VOUCHER` (`voucherId`),
  KEY `FK_VENDOR` (`vendorId`),
  CONSTRAINT `FK_VENDOR` FOREIGN KEY (`vendorId`) REFERENCES `account_master` (`id`),
  CONSTRAINT `FK_VOUCHER` FOREIGN KEY (`voucherId`) REFERENCES `voucher_master` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
