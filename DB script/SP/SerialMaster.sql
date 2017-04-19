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

/*Table structure for table `serialmaster` */

DROP TABLE IF EXISTS `serialmaster`;

CREATE TABLE `serialmaster` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `Serial` int(20) NOT NULL,
  `moduleTag` varchar(50) DEFAULT NULL,
  `lastnumber` int(20) DEFAULT NULL,
  `noofpaddingdigit` int(20) DEFAULT NULL,
  `module` varchar(255) DEFAULT NULL,
  `companyid` int(20) DEFAULT NULL,
  `yearid` int(20) DEFAULT NULL,
  `yeartag` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `serialmaster` */

LOCK TABLES `serialmaster` WRITE;

insert  into `serialmaster`(`id`,`Serial`,`moduleTag`,`lastnumber`,`noofpaddingdigit`,`module`,`companyid`,`yearid`,`yeartag`) values (1,10,'TS',10,5,'SALE',1,7,'17-18'),(2,4,'SRPL',4,5,'SALE',3,7,'17-18'),(3,3,'UTT',3,5,'SALE',2,7,'17-18'),(4,1,'TSGH',1,5,'SALE',4,7,'17-18');

UNLOCK TABLES;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
