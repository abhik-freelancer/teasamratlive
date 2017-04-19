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

/*Table structure for table `vendorbillmaster` */

DROP TABLE IF EXISTS `vendorbillmaster`;

CREATE TABLE `vendorbillmaster` (
  `vendorBillMasterId` int(20) NOT NULL AUTO_INCREMENT,
  `billDate` datetime NOT NULL,
  `billAmount` decimal(10,2) NOT NULL,
  `invoiceMasterId` int(20) NOT NULL,
  `purchaseType` enum('T','O') DEFAULT NULL COMMENT 'T=Tea O=Others',
  `vendorAccountId` int(20) NOT NULL,
  `companyId` int(20) NOT NULL,
  `yearId` int(20) NOT NULL,
  PRIMARY KEY (`vendorBillMasterId`),
  KEY `FK_vendor_acc_id` (`vendorAccountId`),
  CONSTRAINT `FK_vendor_acc_id` FOREIGN KEY (`vendorAccountId`) REFERENCES `account_master` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=389 DEFAULT CHARSET=utf8;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
