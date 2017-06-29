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

/*Table structure for table `gstmaster` */

DROP TABLE IF EXISTS `gstmaster`;

CREATE TABLE `gstmaster` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gstDescription` varchar(255) DEFAULT NULL,
  `gstType` enum('CGST','SGST','IGST') DEFAULT NULL,
  `rate` decimal(10,2) DEFAULT NULL,
  `accountId` int(11) DEFAULT NULL,
  `companyid` int(11) DEFAULT NULL,
  `yearId` int(11) DEFAULT NULL,
  `usedfor` enum('I','O') DEFAULT NULL COMMENT 'I=''INPUT'',O=''OUTPUT''',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `gstmaster` */

LOCK TABLES `gstmaster` WRITE;

insert  into `gstmaster`(`id`,`gstDescription`,`gstType`,`rate`,`accountId`,`companyid`,`yearId`,`usedfor`) values (1,'CGST @5%','CGST','5.00',450,1,7,'O'),(2,'SGST @ 5%','SGST','5.00',451,1,7,'O'),(3,'IGST @10%','IGST','10.00',452,1,7,'O'),(4,'CGST @9%','CGST','9.00',455,1,7,'O'),(5,'SGST @9%','SGST','9.00',456,1,7,'O'),(6,NULL,NULL,NULL,453,1,7,NULL),(7,NULL,NULL,NULL,453,1,7,NULL);

UNLOCK TABLES;

/*Table structure for table `othercharges` */

DROP TABLE IF EXISTS `othercharges`;

CREATE TABLE `othercharges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) DEFAULT NULL,
  `code` varchar(10) DEFAULT NULL,
  `accountid` int(11) DEFAULT NULL,
  `companyid` int(11) DEFAULT NULL,
  `yearid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `othercharges` */

LOCK TABLES `othercharges` WRITE;

insert  into `othercharges`(`id`,`description`,`code`,`accountid`,`companyid`,`yearid`) values (1,'Freight','FRG',176,1,7),(2,'Insurance','INSC',311,1,7),(3,'Packing and Forwarding','PFRWD',454,1,7);

UNLOCK TABLES;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
