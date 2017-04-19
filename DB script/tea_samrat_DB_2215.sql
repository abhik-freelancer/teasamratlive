/*
SQLyog Ultimate v10.00 Beta1
MySQL - 5.6.11 : Database - for_codeigniter
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

/*Table structure for table `account_master` */

DROP TABLE IF EXISTS `account_master`;

CREATE TABLE `account_master` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `account_name` varchar(100) DEFAULT NULL,
  `group_master_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_account_group_master_id` (`group_master_id`),
  CONSTRAINT `FK_account_group_master_id` FOREIGN KEY (`group_master_id`) REFERENCES `group_master` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `account_master` */

insert  into `account_master`(`id`,`account_name`,`group_master_id`) values (2,'somwrita',1),(3,'rahul',2);

/*Table structure for table `account_opening_master` */

DROP TABLE IF EXISTS `account_opening_master`;

CREATE TABLE `account_opening_master` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `account_master_id` int(10) DEFAULT NULL,
  `opening_balance` decimal(10,2) DEFAULT NULL,
  `company_id` int(10) DEFAULT NULL,
  `financialyear_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_company_id` (`company_id`),
  KEY `FK_financialyear_id` (`financialyear_id`),
  KEY `FK_account_master_id` (`account_master_id`),
  CONSTRAINT `FK_account_master_id` FOREIGN KEY (`account_master_id`) REFERENCES `account_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_company_id` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_financialyear_id` FOREIGN KEY (`financialyear_id`) REFERENCES `financialyear` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `account_opening_master` */

insert  into `account_opening_master`(`id`,`account_master_id`,`opening_balance`,`company_id`,`financialyear_id`) values (2,2,'-25.00',1,1);

/*Table structure for table `broker` */

DROP TABLE IF EXISTS `broker`;

CREATE TABLE `broker` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `code` varchar(10) DEFAULT NULL,
  `address` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

/*Data for the table `broker` */

insert  into `broker`(`id`,`name`,`code`,`address`) values (1,'Somwrita','SD','kolkata 700034'),(2,'Rahul','RR','Halisohor'),(3,'Abhik','AB','Amtala'),(4,'Jayanta','JB','Barackpur'),(5,'Amitava','AK',''),(20,'Neha','NS','Chowrasta kolkata');

/*Table structure for table `company` */

DROP TABLE IF EXISTS `company`;

CREATE TABLE `company` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `company` */

insert  into `company`(`id`,`company_name`,`location`) values (1,'abc co. pvt. ltd','hazra'),(2,'XYZ co. Pvt. Ltd','behala'),(3,'MNO co. Pvt. Ltd.','howrah');

/*Table structure for table `financialyear` */

DROP TABLE IF EXISTS `financialyear`;

CREATE TABLE `financialyear` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `year` varchar(20) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `financialyear` */

insert  into `financialyear`(`id`,`year`,`start_date`,`end_date`) values (1,'2015 - 2016','2015-04-01','2016-03-31'),(2,'2014 - 2015','2014-04-01','2015-03-31'),(3,'2013 - 2014','2013-04-01','2014-03-31'),(4,'2012 - 2013','2012-04-01','2013-03-31'),(5,'2011 - 2012','2011-04-01','2012-03-31');

/*Table structure for table `garden_master` */

DROP TABLE IF EXISTS `garden_master`;

CREATE TABLE `garden_master` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `garden_name` varchar(100) NOT NULL,
  `address` varchar(500) DEFAULT 'null',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;

/*Data for the table `garden_master` */

insert  into `garden_master`(`id`,`garden_name`,`address`) values (27,'tol','France'),(28,'abc tea garden','darjeelin<br />west bengal'),(29,'fxcvgdx','s<br />ds'),(30,'erdwea','zxcxz'),(31,'fgfd','fg<br />vcbvc'),(32,'szc','c<br />xzvvxz');

/*Table structure for table `grade_master` */

DROP TABLE IF EXISTS `grade_master`;

CREATE TABLE `grade_master` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `grade` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `grade_master` */

insert  into `grade_master`(`id`,`grade`) values (1,'A+'),(2,'B+'),(3,'C+'),(4,'A'),(5,'B'),(7,'AA'),(8,'BB');

/*Table structure for table `group_category` */

DROP TABLE IF EXISTS `group_category`;

CREATE TABLE `group_category` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `group_name_id` int(100) NOT NULL,
  `sub_group_name_id` int(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_group_name_id` (`group_name_id`),
  KEY `FK_sub_group_name_id` (`sub_group_name_id`),
  CONSTRAINT `FK_group_name_id` FOREIGN KEY (`group_name_id`) REFERENCES `group_name` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_sub_group_name_id` FOREIGN KEY (`sub_group_name_id`) REFERENCES `subgroup_name` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

/*Data for the table `group_category` */

insert  into `group_category`(`id`,`group_name_id`,`sub_group_name_id`) values (3,2,3),(4,2,4),(11,1,1),(12,1,2);

/*Table structure for table `group_master` */

DROP TABLE IF EXISTS `group_master`;

CREATE TABLE `group_master` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(100) DEFAULT NULL,
  `group_category_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_group_category_id` (`group_category_id`),
  CONSTRAINT `FK_group_category_id` FOREIGN KEY (`group_category_id`) REFERENCES `group_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `group_master` */

insert  into `group_master`(`id`,`group_name`,`group_category_id`) values (1,'Sundry Creditor',11),(2,'Sundry debtors',12);

/*Table structure for table `group_name` */

DROP TABLE IF EXISTS `group_name`;

CREATE TABLE `group_name` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `group_name` */

insert  into `group_name`(`id`,`name`) values (1,'Balance Sheet'),(2,'Profit and Loss');

/*Table structure for table `item_master` */

DROP TABLE IF EXISTS `item_master`;

CREATE TABLE `item_master` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `warehouse_id` int(10) DEFAULT NULL,
  `grade_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_warehouse_id` (`warehouse_id`),
  KEY `FK_grade_id` (`grade_id`),
  CONSTRAINT `FK_grade_id` FOREIGN KEY (`grade_id`) REFERENCES `grade_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_warehouse_id` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouse` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `item_master` */

/*Table structure for table `menu` */

DROP TABLE IF EXISTS `menu`;

CREATE TABLE `menu` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(255) DEFAULT NULL,
  `menu_link` varchar(255) DEFAULT NULL,
  `is_parent` enum('N','Y') DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `menu_code` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

/*Data for the table `menu` */

insert  into `menu`(`id`,`menu_name`,`menu_link`,`is_parent`,`parent_id`,`menu_code`) values (3,'Get Ready','','Y',NULL,NULL),(4,'Garden','gardenmaster','N',3,'grademaster'),(5,'Grade','grademaster','N',3,'grademaster'),(6,'Warehouse','warehousemaster','N',3,'warehousemaster'),(7,'ServiceTax','servicetaxmaster','N',3,'servicetaxmaster'),(8,'Broker','brokermaster','N',3,'brokermaster'),(9,'VAT','vatmaster','N',3,'vatmaster'),(10,'GroupCategory','groupcategorymaster','N',3,'groupcategorymaster'),(11,'GroupMaster','groupmaster','N',3,'groupmaster'),(12,'Account','accountmaster','N',3,'accountmaster'),(13,'Vendor','vendormaster','N',3,'vendormaster'),(14,'PurchaseInvoice','purchaseinvoice/showlistpurchaseinvoice','Y',NULL,'purchaseinvoice');

/*Table structure for table `purchase_invoice_detail` */

DROP TABLE IF EXISTS `purchase_invoice_detail`;

CREATE TABLE `purchase_invoice_detail` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `purchase_master_id` int(10) DEFAULT NULL,
  `lot` int(10) DEFAULT NULL,
  `do` int(10) DEFAULT NULL,
  `invoice_number` varchar(255) DEFAULT NULL,
  `garden_id` int(10) DEFAULT NULL,
  `grade_id` int(10) DEFAULT NULL,
  `warehouse_id` int(10) DEFAULT NULL,
  `gp_number` int(10) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `package` int(10) DEFAULT NULL,
  `stamp` varchar(255) DEFAULT NULL,
  `gross` varchar(255) DEFAULT NULL,
  `brokerage` varchar(255) DEFAULT NULL,
  `total_weight` decimal(10,2) DEFAULT NULL,
  `vat` decimal(10,2) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `service_tax` decimal(10,2) DEFAULT NULL,
  `total_value` decimal(10,2) DEFAULT NULL,
  `chest_from` int(10) DEFAULT NULL,
  `chest_to` int(10) DEFAULT NULL,
  `value_cost` decimal(10,2) DEFAULT NULL,
  `net` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_purchase_master_id` (`purchase_master_id`),
  KEY `FK_DETAIL_garden_id` (`garden_id`),
  KEY `FK_DETAIL_grade_id` (`grade_id`),
  KEY `FK_DETAIL_warehouse_id` (`warehouse_id`),
  CONSTRAINT `FK_DETAIL_garden_id` FOREIGN KEY (`garden_id`) REFERENCES `garden_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_DETAIL_grade_id` FOREIGN KEY (`grade_id`) REFERENCES `grade_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_DETAIL_warehouse_id` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouse` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_purchase_master_id` FOREIGN KEY (`purchase_master_id`) REFERENCES `purchase_invoice_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

/*Data for the table `purchase_invoice_detail` */

insert  into `purchase_invoice_detail`(`id`,`purchase_master_id`,`lot`,`do`,`invoice_number`,`garden_id`,`grade_id`,`warehouse_id`,`gp_number`,`date`,`package`,`stamp`,`gross`,`brokerage`,`total_weight`,`vat`,`price`,`service_tax`,`total_value`,`chest_from`,`chest_to`,`value_cost`,`net`) values (14,46,10,20,'30',27,1,2,88,'2015-01-24',10,'20','40','50','30.00','8.00','9.00','11.00','2328.00',10,20,'2259.00',NULL),(15,46,1,2,'3',30,5,3,89,'2015-01-24',6,'7','9','10','3.00','3.00','8.00','7.00','404.00',10,11,'384.00',NULL),(16,47,0,0,'',NULL,NULL,NULL,0,'1970-01-01',0,'','','','0.00','0.00','0.00','0.00','0.00',0,0,'0.00',NULL);

/*Table structure for table `purchase_invoice_master` */

DROP TABLE IF EXISTS `purchase_invoice_master`;

CREATE TABLE `purchase_invoice_master` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `tax_invoice_number` int(10) DEFAULT NULL,
  `tax_invoice_date` date DEFAULT NULL,
  `vendor_id` int(10) DEFAULT NULL,
  `sale_number` varchar(10) DEFAULT NULL,
  `sale_date` date DEFAULT NULL,
  `promt_date` date DEFAULT NULL,
  `tea_value` decimal(10,2) DEFAULT NULL,
  `brokerage` decimal(10,2) DEFAULT NULL,
  `service_tax` decimal(10,2) DEFAULT NULL,
  `type` enum('V','C') DEFAULT NULL,
  `vat_rate` decimal(10,2) DEFAULT NULL,
  `chestage_allowance` decimal(10,2) DEFAULT NULL,
  `stamp` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_vendor_id` (`vendor_id`),
  CONSTRAINT `FK_vendor_id` FOREIGN KEY (`vendor_id`) REFERENCES `vendor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=latin1;

/*Data for the table `purchase_invoice_master` */

insert  into `purchase_invoice_master`(`id`,`tax_invoice_number`,`tax_invoice_date`,`vendor_id`,`sale_number`,`sale_date`,`promt_date`,`tea_value`,`brokerage`,`service_tax`,`type`,`vat_rate`,`chestage_allowance`,`stamp`,`total`) values (46,10,'2015-01-01',2,'1000','2015-01-02','2015-01-16','2643.00','60.00','600.00','','0.00','0.00','0.00','3303.00'),(47,65416,'2015-01-09',2,'554','2015-01-24','2015-02-07','0.00','0.00','0.00','','0.00','0.00','0.00','0.00');

/*Table structure for table `purchase_invoice_sample` */

DROP TABLE IF EXISTS `purchase_invoice_sample`;

CREATE TABLE `purchase_invoice_sample` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `purchase_invoice_detail_id` int(10) DEFAULT NULL,
  `sample_number` int(10) DEFAULT NULL,
  `sample_net` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_purchase_invoice_detail_id` (`purchase_invoice_detail_id`),
  CONSTRAINT `FK_purchase_invoice_detail_id` FOREIGN KEY (`purchase_invoice_detail_id`) REFERENCES `purchase_invoice_detail` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

/*Data for the table `purchase_invoice_sample` */

insert  into `purchase_invoice_sample`(`id`,`purchase_invoice_detail_id`,`sample_number`,`sample_net`) values (15,14,10,5),(16,14,20,6),(17,15,85,9),(18,15,2,9);

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `role_name` varchar(50) NOT NULL,
  `id` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `roles` */

insert  into `roles`(`role_name`,`id`) values ('user',1),('admin',2);

/*Table structure for table `service_tax` */

DROP TABLE IF EXISTS `service_tax`;

CREATE TABLE `service_tax` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `tax_rate` decimal(10,2) DEFAULT NULL,
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `service_tax` */

insert  into `service_tax`(`id`,`tax_rate`,`from_date`,`to_date`) values (1,'12.00','2014-04-01','2015-03-31'),(2,'13.00','2013-04-01','2014-03-31'),(3,'10.00','2015-01-28','2015-01-31'),(4,'10.00','2015-01-01','2015-01-17'),(5,'10.00','2015-04-02','2015-04-30');

/*Table structure for table `subgroup_name` */

DROP TABLE IF EXISTS `subgroup_name`;

CREATE TABLE `subgroup_name` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `subgroup_name` */

insert  into `subgroup_name`(`id`,`name`) values (1,'Asset'),(2,'Liabilities'),(3,'Income'),(4,'Expenditure');

/*Table structure for table `userole` */

DROP TABLE IF EXISTS `userole`;

CREATE TABLE `userole` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) DEFAULT NULL,
  `role_id` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_USERROLE_UID` (`user_id`),
  KEY `FK_USERROLE_RID` (`role_id`),
  CONSTRAINT `FK_USERROLE_RID` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_USERROLE_UID` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Data for the table `userole` */

insert  into `userole`(`id`,`user_id`,`role_id`) values (1,1,1),(2,3,1),(3,2,2),(4,4,1),(5,5,1),(6,6,1),(7,7,1),(8,8,1),(9,9,1);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `login_id` varchar(10) NOT NULL,
  `password` varchar(100) NOT NULL,
  `First_Name` varchar(255) DEFAULT NULL,
  `Last_Name` varchar(255) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Contact_Number` varchar(255) DEFAULT NULL,
  `IS_ACTIVE` enum('Y','N') DEFAULT 'Y',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Data for the table `users` */

insert  into `users`(`id`,`login_id`,`password`,`First_Name`,`Last_Name`,`Address`,`Email`,`Contact_Number`,`IS_ACTIVE`) values (1,'so','8ddf878039b70767c4a5bcf4f0c4f65e','Somwrita','Debnath',NULL,NULL,'8961721759','Y'),(2,'admin','8a8bb7cd343aa2ad99b7d762030857a2','Admin',NULL,NULL,NULL,NULL,'Y'),(3,'ra','7c92cf1eee8d99cc85f8355a3d6e4b86','RAZAUL','MONDAL',NULL,NULL,'123456','Y'),(4,'AB','7c92cf1eee8d99cc85f8355a3d6e4b86','ABHIK','GHOSH',NULL,NULL,'123456','Y'),(5,'PO','7c92cf1eee8d99cc85f8355a3d6e4b86','POUSHALI','MUKHERHEE',NULL,NULL,'1234569','Y'),(6,'RR','7c92cf1eee8d99cc85f8355a3d6e4b86','RAHUL','ROY',NULL,NULL,'123456987','Y'),(7,'NE','7c92cf1eee8d99cc85f8355a3d6e4b86','NEHA','SHARMA',NULL,NULL,'1354634','Y'),(8,'PU','7c92cf1eee8d99cc85f8355a3d6e4b86','PUNAM','SHAW',NULL,NULL,'78989645343','Y'),(9,'SOU','7c92cf1eee8d99cc85f8355a3d6e4b86','SOUMI','PATTANAYAK',NULL,NULL,'5837638768','Y');

/*Table structure for table `vat` */

DROP TABLE IF EXISTS `vat`;

CREATE TABLE `vat` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `vat_rate` decimal(10,2) DEFAULT NULL,
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `vat` */

insert  into `vat`(`id`,`vat_rate`,`from_date`,`to_date`) values (1,'10.00','2013-12-05','2015-01-09'),(2,'10.00','2015-05-12','2016-03-16');

/*Table structure for table `vendor` */

DROP TABLE IF EXISTS `vendor`;

CREATE TABLE `vendor` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `vendor_name` varchar(100) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `account_master_id` int(10) DEFAULT NULL,
  `opening_balance` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_vendor_account_master_id` (`account_master_id`),
  CONSTRAINT `FK_vendor_account_master_id` FOREIGN KEY (`account_master_id`) REFERENCES `account_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `vendor` */

insert  into `vendor`(`id`,`vendor_name`,`address`,`account_master_id`,`opening_balance`) values (2,'somwrita','24/j/4 mukherjee bagan lane',2,NULL),(3,'rahul','halisahor',3,NULL);

/*Table structure for table `warehouse` */

DROP TABLE IF EXISTS `warehouse`;

CREATE TABLE `warehouse` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `code` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `area` varchar(100) DEFAULT 'null',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `warehouse` */

insert  into `warehouse`(`id`,`code`,`name`,`area`) values (2,'dsz','xzv','xvz'),(3,'ABC','sdfrsdfd','hazra30');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
