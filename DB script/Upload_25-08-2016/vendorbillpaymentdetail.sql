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

/*Table structure for table `vendorbillpaymentdetail` */

DROP TABLE IF EXISTS `vendorbillpaymentdetail`;

CREATE TABLE `vendorbillpaymentdetail` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `vendorpaymentid` int(20) DEFAULT NULL,
  `vendorBillMaster` int(20) DEFAULT NULL,
  `paidAmount` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Vendor_payment_master` (`vendorpaymentid`),
  KEY `FK_Vendor_Bill_Master` (`vendorBillMaster`),
  CONSTRAINT `FK_Vendor_Bill_Master` FOREIGN KEY (`vendorBillMaster`) REFERENCES `vendorbillmaster` (`vendorBillMasterId`),
  CONSTRAINT `FK_Vendor_payment_master` FOREIGN KEY (`vendorpaymentid`) REFERENCES `vendorbillpaymentmaster` (`vendorPaymentId`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=latin1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
