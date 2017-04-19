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

/*Table structure for table `finished_product` */

DROP TABLE IF EXISTS `finished_product`;

CREATE TABLE `finished_product` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `productId` int(20) DEFAULT NULL,
  `blended_id` int(20) DEFAULT NULL,
  `blended_qty_kg` decimal(10,2) DEFAULT NULL,
  `short_excess_kg` decimal(10,2) DEFAULT NULL,
  `packing_date` datetime DEFAULT NULL,
  `warehouse_id` int(20) DEFAULT NULL,
  `created_by` int(20) DEFAULT NULL,
  `company_id` int(20) DEFAULT NULL,
  `year_id` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_blend` (`blended_id`),
  KEY `FK_warehouse` (`warehouse_id`),
  KEY `fk_finishproduct` (`productId`),
  CONSTRAINT `FK_blend` FOREIGN KEY (`blended_id`) REFERENCES `blending_master` (`id`),
  CONSTRAINT `fk_finishproduct` FOREIGN KEY (`productId`) REFERENCES `product` (`id`),
  CONSTRAINT `FK_warehouse` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouse` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Table structure for table `finished_product_dtl` */

DROP TABLE IF EXISTS `finished_product_dtl`;

CREATE TABLE `finished_product_dtl` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `finishProductId` int(20) DEFAULT NULL,
  `product_packet` int(20) DEFAULT NULL,
  `numberof_packet` int(20) DEFAULT NULL,
  `net_in_packet` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_prod_pack` (`product_packet`),
  KEY `fk_finish_prod_id` (`finishProductId`),
  CONSTRAINT `fk_finish_prod_id` FOREIGN KEY (`finishProductId`) REFERENCES `finished_product` (`id`),
  CONSTRAINT `fk_prod_pack` FOREIGN KEY (`product_packet`) REFERENCES `product_packet` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
