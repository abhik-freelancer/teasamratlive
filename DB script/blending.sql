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

/*Table structure for table `blending_details` */

DROP TABLE IF EXISTS `blending_details`;

CREATE TABLE `blending_details` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `blending_master_id` int(20) DEFAULT NULL,
  `purchase_dtl_id` int(20) DEFAULT NULL,
  `purchasebag_id` int(20) DEFAULT NULL,
  `number_of_blended_bag` int(20) DEFAULT NULL,
  `qty_of_bag` double(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_blendingmaster` (`blending_master_id`),
  KEY `FK_purDtlId` (`purchase_dtl_id`),
  KEY `FK_bagDtlId` (`purchasebag_id`),
  CONSTRAINT `FK_bagDtlId` FOREIGN KEY (`purchasebag_id`) REFERENCES `purchase_bag_details` (`id`),
  CONSTRAINT `FK_blendingmaster` FOREIGN KEY (`blending_master_id`) REFERENCES `blending_master` (`id`),
  CONSTRAINT `FK_purDtlId` FOREIGN KEY (`purchase_dtl_id`) REFERENCES `purchase_invoice_detail` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `blending_details` */

insert  into `blending_details`(`id`,`blending_master_id`,`purchase_dtl_id`,`purchasebag_id`,`number_of_blended_bag`,`qty_of_bag`) values (1,1,230,74,2,28.00),(2,1,230,75,2,21.00),(3,1,231,124,5,30.00),(4,1,231,125,1,28.00);

/*Table structure for table `blending_master` */

DROP TABLE IF EXISTS `blending_master`;

CREATE TABLE `blending_master` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `blending_number` varchar(255) DEFAULT NULL,
  `blending_ref` varchar(255) DEFAULT NULL,
  `blending_date` datetime DEFAULT NULL,
  `companyid` int(20) DEFAULT NULL,
  `yearid` int(20) DEFAULT NULL,
  `productid` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_productid` (`productid`),
  CONSTRAINT `FK_productid` FOREIGN KEY (`productid`) REFERENCES `product` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `blending_master` */

insert  into `blending_master`(`id`,`blending_number`,`blending_ref`,`blending_date`,`companyid`,`yearid`,`productid`) values (1,'B/0001/04-15','B/0001/04-15','2015-09-04 11:45:41',1,1,3);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
