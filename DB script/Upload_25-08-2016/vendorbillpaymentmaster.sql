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

/*Table structure for table `vendorbillpaymentmaster` */

DROP TABLE IF EXISTS `vendorbillpaymentmaster`;

CREATE TABLE `vendorbillpaymentmaster` (
  `vendorPaymentId` int(20) NOT NULL AUTO_INCREMENT,
  `dateofpayment` datetime NOT NULL,
  `vendorid` int(20) NOT NULL,
  `totalpaidamount` decimal(10,2) DEFAULT NULL,
  `voucherId` int(20) NOT NULL,
  `typeofpayment` enum('T','O') DEFAULT NULL COMMENT 'T=Teabill,O=Others',
  PRIMARY KEY (`vendorPaymentId`),
  KEY `FK_Voucher_bill_pay` (`voucherId`),
  KEY `FK_Vendor_bill_pay` (`vendorid`),
  CONSTRAINT `FK_Vendor_bill_pay` FOREIGN KEY (`vendorid`) REFERENCES `account_master` (`id`),
  CONSTRAINT `FK_Voucher_bill_pay` FOREIGN KEY (`voucherId`) REFERENCES `voucher_master` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
