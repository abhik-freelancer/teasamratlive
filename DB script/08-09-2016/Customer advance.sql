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

/*Table structure for table `customeradvance` */

DROP TABLE IF EXISTS `customeradvance`;

CREATE TABLE `customeradvance` (
  `advanceId` int(20) NOT NULL AUTO_INCREMENT,
  `dateofadvance` datetime NOT NULL,
  `voucherid` int(20) NOT NULL,
  `advanceamount` decimal(10,2) NOT NULL,
  `customeraccountid` int(20) NOT NULL,
  `isfulladjusted` enum('Y','N') DEFAULT 'N',
  `companyid` int(20) NOT NULL,
  `yearid` int(20) NOT NULL,
  PRIMARY KEY (`advanceId`),
  KEY `fk_customer_account` (`customeraccountid`),
  CONSTRAINT `fk_customer_account` FOREIGN KEY (`customeraccountid`) REFERENCES `account_master` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Table structure for table `customeradvanceadadjustment` */

DROP TABLE IF EXISTS `customeradvanceadadjustment`;

CREATE TABLE `customeradvanceadadjustment` (
  `adjustmentid` int(20) NOT NULL AUTO_INCREMENT,
  `adjustmentrefno` varchar(255) NOT NULL,
  `dateofadjustment` datetime DEFAULT NULL,
  `customeraccid` int(20) NOT NULL,
  `advanceid` int(20) DEFAULT NULL,
  `totalamountadjusted` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`adjustmentid`),
  KEY `FK_cust_acc_id` (`customeraccid`),
  KEY `FK_advance_master_id` (`advanceid`),
  CONSTRAINT `FK_advance_master_id` FOREIGN KEY (`advanceid`) REFERENCES `customeradvance` (`advanceId`),
  CONSTRAINT `FK_cust_acc_id` FOREIGN KEY (`customeraccid`) REFERENCES `account_master` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `customeradvanceadjstdtl` */

DROP TABLE IF EXISTS `customeradvanceadjstdtl`;

CREATE TABLE `customeradvanceadjstdtl` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `custadjmstid` int(20) DEFAULT NULL,
  `customerbillmaster` int(20) NOT NULL,
  `adjustedamount` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_adj_mst` (`custadjmstid`),
  KEY `fk_customer_bill` (`customerbillmaster`),
  CONSTRAINT `fk_adj_mst` FOREIGN KEY (`custadjmstid`) REFERENCES `customeradvanceadadjustment` (`adjustmentid`),
  CONSTRAINT `fk_customer_bill` FOREIGN KEY (`customerbillmaster`) REFERENCES `customerbillmaster` (`customerbillmasterid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `customerbillmaster` */

DROP TABLE IF EXISTS `customerbillmaster`;

CREATE TABLE `customerbillmaster` (
  `customerbillmasterid` int(10) NOT NULL AUTO_INCREMENT,
  `billdate` datetime NOT NULL,
  `billamount` decimal(10,2) NOT NULL,
  `invoicemasterid` int(10) NOT NULL,
  `saletype` enum('R','T') DEFAULT NULL,
  `customeraccountid` int(10) NOT NULL,
  `companyid` int(10) NOT NULL,
  `yearid` int(10) NOT NULL,
  PRIMARY KEY (`customerbillmasterid`),
  KEY `fk_customer_accid` (`customeraccountid`),
  CONSTRAINT `fk_customer_accid` FOREIGN KEY (`customeraccountid`) REFERENCES `account_master` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=763 DEFAULT CHARSET=latin1;

/*Table structure for table `customerreceiptdetail` */

DROP TABLE IF EXISTS `customerreceiptdetail`;

CREATE TABLE `customerreceiptdetail` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `customerrecptmstid` int(20) NOT NULL,
  `customerbillmasterid` int(20) NOT NULL,
  `receiptamount` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rcpt_mst` (`customerrecptmstid`),
  KEY `bill_id` (`customerbillmasterid`),
  CONSTRAINT `bill_id` FOREIGN KEY (`customerbillmasterid`) REFERENCES `customerbillmaster` (`customerbillmasterid`),
  CONSTRAINT `rcpt_mst` FOREIGN KEY (`customerrecptmstid`) REFERENCES `customerreceiptmaster` (`customerpaymentid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `customerreceiptmaster` */

DROP TABLE IF EXISTS `customerreceiptmaster`;

CREATE TABLE `customerreceiptmaster` (
  `customerpaymentid` int(20) NOT NULL AUTO_INCREMENT,
  `dateofpayment` datetime NOT NULL,
  `customeraccountid` int(20) NOT NULL,
  `totalreceipt` decimal(10,2) NOT NULL,
  `voucherid` int(20) NOT NULL,
  PRIMARY KEY (`customerpaymentid`),
  KEY `customer_account_id` (`customeraccountid`),
  KEY `voucher_recpt` (`voucherid`),
  CONSTRAINT `customer_account_id` FOREIGN KEY (`customeraccountid`) REFERENCES `account_master` (`id`),
  CONSTRAINT `voucher_recpt` FOREIGN KEY (`voucherid`) REFERENCES `voucher_master` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
