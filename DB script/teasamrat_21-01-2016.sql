-- phpMyAdmin SQL Dump
-- version 4.0.10.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 20, 2016 at 11:12 PM
-- Server version: 5.5.45-cll-lve
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `teasamrat`
--

DELIMITER $$
--
-- Procedures
--
$$

CREATE DEFINER=`softhought`@`localhost` PROCEDURE `sp_allgroup_sum_stock`()
BEGIN	
SELECT 
PID.`teagroup_master_id`,teagroup_master.`group_code`,
SUM((IF(PBD.`actual_bags` IS NULL, 0,PBD.`actual_bags`) -
 IF(`blending_details`.`number_of_blended_bag` IS NULL,0,`blending_details`.`number_of_blended_bag`)) )AS NumberOfStockBag,
SUM((
IF(PBD.`actual_bags`IS NULL,0,PBD.`actual_bags`)* IF(PBD.net IS NULL,0,PBD.net))-
(IF(`blending_details`.`number_of_blended_bag`IS NULL,0,`blending_details`.`number_of_blended_bag`)*
IF(`blending_details`.`qty_of_bag`IS NULL,0,`blending_details`.`qty_of_bag`))) AS StockBagQty
FROM `purchase_invoice_detail` PID 
INNER JOIN 
`purchase_bag_details` PBD ON PID.`id` =PBD.`purchasedtlid`
INNER JOIN 
do_to_transporter DOT ON PID.`id`= DOT.`purchase_inv_dtlid` AND DOT.`in_Stock`='Y'
LEFT JOIN `blending_details` ON PBD.`id` = `blending_details`.`purchasebag_id`
INNER JOIN garden_master ON PID.`garden_id` = garden_master.`id`
INNER JOIN grade_master ON PID.`grade_id` = grade_master.`id`
INNER JOIN `location` ON DOT.`locationId`=`location`.`id`  
INNER JOIN `teagroup_master` ON PID.`teagroup_master_id` = `teagroup_master`.`id`
GROUP BY PID.`teagroup_master_id`;
END$$

$$

CREATE DEFINER=`softhought`@`localhost` PROCEDURE `sp_groupwise_sum_stock`(
 IN teagroup INT(10)
)
BEGIN	
SELECT 
PID.`teagroup_master_id`,teagroup_master.`group_code`,
SUM((IF(PBD.`actual_bags` IS NULL, 0,PBD.`actual_bags`) -
 IF(`blending_details`.`number_of_blended_bag` IS NULL,0,`blending_details`.`number_of_blended_bag`)) )AS NumberOfStockBag,
SUM((
IF(PBD.`actual_bags`IS NULL,0,PBD.`actual_bags`)* IF(PBD.net IS NULL,0,PBD.net))-
(IF(`blending_details`.`number_of_blended_bag`IS NULL,0,`blending_details`.`number_of_blended_bag`)*
IF(`blending_details`.`qty_of_bag`IS NULL,0,`blending_details`.`qty_of_bag`))) AS StockBagQty
FROM `purchase_invoice_detail` PID 
INNER JOIN 
`purchase_bag_details` PBD ON PID.`id` =PBD.`purchasedtlid`
INNER JOIN 
do_to_transporter DOT ON PID.`id`= DOT.`purchase_inv_dtlid` AND DOT.`in_Stock`='Y'
LEFT JOIN `blending_details` ON PBD.`id` = `blending_details`.`purchasebag_id`
INNER JOIN garden_master ON PID.`garden_id` = garden_master.`id`
INNER JOIN grade_master ON PID.`grade_id` = grade_master.`id`
INNER JOIN `location` ON DOT.`locationId`=`location`.`id`  
INNER JOIN `teagroup_master` ON PID.`teagroup_master_id` = `teagroup_master`.`id`
GROUP BY PID.`teagroup_master_id`
HAVING 
PID.`teagroup_master_id`=teagroup;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `account_master`
--

CREATE TABLE IF NOT EXISTS `account_master` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `account_name` varchar(100) DEFAULT NULL,
  `group_master_id` int(10) DEFAULT NULL,
  `is_special` enum('Y','N') DEFAULT 'N',
  PRIMARY KEY (`id`),
  KEY `FK_account_group_master_id` (`group_master_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=139 ;

--
-- Dumping data for table `account_master`
--

INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(5, 'VAT', 5, 'Y');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(6, 'Purchase A/c', 4, 'Y');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(7, 'Sale A/C', 3, 'Y');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(30, 'J Thomas & Co. Pvt. Ltd', 2, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(36, 'Cash in Hand ', 8, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(41, 'Parcon India Private Limited', 2, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(42, 'ASSAM TEA BROKERS PVT. LTD', 2, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(44, 'ASSOCIATED BROKERS PVT.LTD (Siliguri)', 2, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(45, 'BIJOYNAGAR TEA COMPANY LIMMITED', 2, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(46, 'Softhought-Test', 2, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(47, 'Paramount Tea Marketing Pvt Ltd.', 2, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(48, 'JThomas & Company Pvt Ltd. (Siliguri)', 2, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(49, 'PARCON INDIA PRIVATE LIMITED (Siliguri)', 2, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(50, 'Contemporary Brokers Pvt.Ltd. (Siliguri)', 2, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(52, 'JAY SHREE TEA & INDUSTRIES LTD.', 2, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(53, 'ASSOCIATED BROKERS PVT.LTD', 2, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(54, 'Test_data_edit', 1, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(56, 'Raja', 1, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(57, 'Rahul Roychowdhury', 1, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(58, 'ISHAAN PLASTIC  PVT.LTD', 2, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(59, 'N.N.PRINT & PACK PVT.LTD.', 2, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(60, 'SURYA PACKAGERS', 2, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(61, 'MKB PRINT & PACK SOLUTIONS PVT.LTD.', 2, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(62, 'SATYAM ENTERPRISE', 2, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(63, 'PRACHI INDUSTRIES', 2, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(64, 'OM PACKAGING', 2, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(65, 'SONY PACKAGING INDUSTRY', 2, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(66, 'ARUP KUMAR NANDI', 1, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(67, 'GOODMORNING TEA CENTRER & SUPPLIERS', 1, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(68, 'REKHA TEA CENTRE ', 1, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(69, 'ANNAPURNA BHANDER', 1, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(70, 'MAA ANANDAMOYEE MILK SUPPLIERS', 1, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(71, 'BIKI ENTERPRISE', 1, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(72, 'NEERA TEA SUPPLIER', 1, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(73, 'GOUTAM GORUI', 1, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(74, 'AMITAVA MISRA', 1, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(75, 'KARBALA TEA HOUSE', 1, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(76, 'SREE RAM TRADERS', 1, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(77, 'BARNALI ENTERPRISE', 1, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(78, 'UTTAM ENTERPRISE', 1, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(79, 'SAHA TEA HOUSE', 1, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(80, 'SAMRAT REALPROJECTS PRIVATE LIMITED', 1, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(81, 'M/S GHOSH ENTERPRISE', 1, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(82, 'PRADIP TRADERS', 1, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(83, 'LAKSHMI STORES', 1, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(84, 'SUMANTA SADHUKHAN', 1, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(85, 'ANIMA ROY', 1, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(86, 'CHANDU SHEK', 1, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(87, 'BALARAM DUTTA', 1, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(88, 'DEY AGENCY', 1, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(89, 'MALLICK TEA', 1, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(90, 'ALOKE TEA', 1, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(91, 'JYOTI TRADING', 1, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(92, 'ANUP GHOSH', 1, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(93, 'MAA RAMANI BHANDER', 1, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(94, 'MAA GAYTREE ENTERPRISE', 1, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(95, 'H.B. CORPORATION', 1, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(96, 'SUBHASIS KUNDU', 1, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(97, 'CHOUDHURY ENTERPRISE', 1, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(98, 'NETAI NAG', 1, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(99, 'ARUP KUMAR NANDI', 1, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(100, 'DARJEELING TEA & TRADING CO.', 1, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(101, 'TAPAN CHAKRABORTY', 1, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(102, 'RAMAWTAR KHANDELWAL', 1, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(103, 'GOODMORNING TEA CENTRE & SUPPLIERS', 1, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(104, 'LIAKAT ALI', 1, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(105, 'MALLICK TEA  (U)', 1, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(106, 'SANKAR TRIPATHI', 1, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(107, 'SREEMA TEA HOUSE', 1, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(108, 'GANGA MATA AGENCY', 1, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(109, 'UTTAM TEA HOUSE', 1, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(110, 'SREE GURU ENTERPRISE', 1, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(111, 'BASUDEV TRADING', 1, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(112, 'GIRIDHARI MAJHI', 1, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(113, 'ARUP TEA CORNER', 1, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(114, 'R.S. ENTERPRISE', 1, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(115, 'PRONAB DAS', 1, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(116, 'KESHPUR TRADING', 1, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(117, 'THE SIMULBARIE TEA COMPANY (PVT) LTD', 2, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(118, 'CARE TEA PRIVATE LIMITED (SILIGURI)', 2, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(119, 'NORTH BENGAL TEA BROKERS (P) LTD (SILIGURI)', 2, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(120, 'Paramount Tea Marketing Pvt Ltd. (SILIGURI)', 2, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(121, 'UNIVERSAL TEA TRADERS', 2, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(122, 'NEW CHUMTA TEA COMPANY ', 2, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(123, 'TEA CHAMPAGNE PRIVATE LIMITED (SILIGURI)', 2, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(124, 'SUDHIR CHATERJEE & CO.PVT.LTD.', 2, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(125, 'THE NEW TERAI ASSOCIATION LIMITED', 2, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(126, 'GILLANDERS ARBUTHONT & CO.LTD.', 2, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(127, 'CONTEMPORARY BROKERS PVT.LTD', 2, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(128, 'KAMALA TEA CO.LTD', 2, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(129, 'JAI JALPESH INTERNATIONAL (PVT) LTD.', 2, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(130, 'VARDHAMAN TRADERS', 2, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(131, 'CHAMURCHI AGRO (INDIA) LTD', 2, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(132, 'KAYAN AGRO INDUSTRIES & CO. PVT. LTD.', 2, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(133, 'COOCHBEHAR AGRO TEA ESTATE (P)LTD.', 2, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(134, 'MADHU JAYANTI INTERNATIONAL LTD', 1, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(135, 'MOGULKATA TEA COMPANY PVT.LTD', 2, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(136, 'RYDAK SYNDICATE LTD', 2, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(137, 'BALASON TEA CO. PVT.LTD.', 2, 'N');
INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES(138, 'GOOD POINT TEA PVT. LTD.', 2, 'N');

-- --------------------------------------------------------

--
-- Table structure for table `account_opening_master`
--

CREATE TABLE IF NOT EXISTS `account_opening_master` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `account_master_id` int(10) DEFAULT NULL,
  `opening_balance` decimal(10,2) DEFAULT NULL,
  `company_id` int(10) DEFAULT NULL,
  `financialyear_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_company_id` (`company_id`),
  KEY `FK_financialyear_id` (`financialyear_id`),
  KEY `FK_account_master_id` (`account_master_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=110 ;

--
-- Dumping data for table `account_opening_master`
--

INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(6, 30, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(11, 41, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(12, 36, '12000.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(13, 42, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(15, 44, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(16, 45, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(17, 46, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(18, 47, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(19, 48, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(20, 49, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(21, 50, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(23, 52, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(24, 53, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(25, 54, '100.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(28, 57, '2000.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(29, 58, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(30, 59, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(31, 60, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(32, 61, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(33, 62, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(34, 63, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(35, 64, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(36, 65, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(37, 66, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(39, 68, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(40, 69, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(41, 70, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(42, 71, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(43, 72, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(44, 73, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(45, 74, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(46, 75, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(47, 76, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(48, 77, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(49, 78, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(50, 79, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(51, 80, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(52, 81, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(53, 82, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(54, 83, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(55, 84, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(56, 85, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(57, 86, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(58, 87, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(59, 88, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(60, 89, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(61, 90, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(62, 91, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(63, 92, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(64, 93, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(65, 94, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(66, 95, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(67, 96, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(68, 97, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(69, 98, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(71, 100, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(72, 101, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(73, 102, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(74, 103, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(75, 104, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(76, 105, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(77, 106, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(78, 107, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(79, 108, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(80, 109, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(81, 110, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(82, 111, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(83, 112, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(84, 113, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(85, 114, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(86, 115, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(87, 116, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(88, 117, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(89, 118, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(90, 119, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(91, 120, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(92, 121, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(93, 122, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(94, 123, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(95, 124, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(96, 125, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(97, 126, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(98, 127, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(99, 128, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(100, 129, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(101, 130, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(102, 131, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(103, 132, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(104, 133, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(105, 134, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(106, 135, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(107, 136, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(108, 137, '0.00', 1, 1);
INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES(109, 138, '0.00', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `auctionareamaster`
--

CREATE TABLE IF NOT EXISTS `auctionareamaster` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `auctionarea` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `auctionareamaster`
--

INSERT INTO `auctionareamaster` (`id`, `auctionarea`) VALUES(1, 'Kolkata Auction');
INSERT INTO `auctionareamaster` (`id`, `auctionarea`) VALUES(2, 'Siliguri Auction');
INSERT INTO `auctionareamaster` (`id`, `auctionarea`) VALUES(3, 'South India');
INSERT INTO `auctionareamaster` (`id`, `auctionarea`) VALUES(5, 'PRIVATE PURCHASES');

-- --------------------------------------------------------

--
-- Table structure for table `bagtypemaster`
--

CREATE TABLE IF NOT EXISTS `bagtypemaster` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `bagtype` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `bagtypemaster`
--

INSERT INTO `bagtypemaster` (`id`, `bagtype`) VALUES(1, 'Normal');
INSERT INTO `bagtypemaster` (`id`, `bagtype`) VALUES(2, 'Sample');
INSERT INTO `bagtypemaster` (`id`, `bagtype`) VALUES(3, 'Shortage');

-- --------------------------------------------------------

--
-- Table structure for table `blending_details`
--

CREATE TABLE IF NOT EXISTS `blending_details` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `blending_master_id` int(20) DEFAULT NULL,
  `purchase_dtl_id` int(20) DEFAULT NULL,
  `purchasebag_id` int(20) DEFAULT NULL,
  `number_of_blended_bag` int(20) DEFAULT NULL,
  `qty_of_bag` double(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_blendingmaster` (`blending_master_id`),
  KEY `FK_purDtlId` (`purchase_dtl_id`),
  KEY `FK_bagDtlId` (`purchasebag_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `blending_details`
--

INSERT INTO `blending_details` (`id`, `blending_master_id`, `purchase_dtl_id`, `purchasebag_id`, `number_of_blended_bag`, `qty_of_bag`) VALUES(8, 5, 227, 122, 2, 31.00);
INSERT INTO `blending_details` (`id`, `blending_master_id`, `purchase_dtl_id`, `purchasebag_id`, `number_of_blended_bag`, `qty_of_bag`) VALUES(9, 5, 227, 123, 1, 24.00);
INSERT INTO `blending_details` (`id`, `blending_master_id`, `purchase_dtl_id`, `purchasebag_id`, `number_of_blended_bag`, `qty_of_bag`) VALUES(16, 6, 481, 589, 5, 38.00);
INSERT INTO `blending_details` (`id`, `blending_master_id`, `purchase_dtl_id`, `purchasebag_id`, `number_of_blended_bag`, `qty_of_bag`) VALUES(17, 6, 266, 211, 5, 38.00);
INSERT INTO `blending_details` (`id`, `blending_master_id`, `purchase_dtl_id`, `purchasebag_id`, `number_of_blended_bag`, `qty_of_bag`) VALUES(18, 6, 482, 590, 10, 34.00);
INSERT INTO `blending_details` (`id`, `blending_master_id`, `purchase_dtl_id`, `purchasebag_id`, `number_of_blended_bag`, `qty_of_bag`) VALUES(19, 7, 276, 206, 5, 35.00);
INSERT INTO `blending_details` (`id`, `blending_master_id`, `purchase_dtl_id`, `purchasebag_id`, `number_of_blended_bag`, `qty_of_bag`) VALUES(20, 7, 278, 209, 5, 35.00);
INSERT INTO `blending_details` (`id`, `blending_master_id`, `purchase_dtl_id`, `purchasebag_id`, `number_of_blended_bag`, `qty_of_bag`) VALUES(21, 7, 274, 204, 10, 37.00);
INSERT INTO `blending_details` (`id`, `blending_master_id`, `purchase_dtl_id`, `purchasebag_id`, `number_of_blended_bag`, `qty_of_bag`) VALUES(22, 7, 274, 205, 0, 28.40);

-- --------------------------------------------------------

--
-- Table structure for table `blending_master`
--

CREATE TABLE IF NOT EXISTS `blending_master` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `blending_number` varchar(255) DEFAULT NULL,
  `blending_ref` varchar(255) DEFAULT NULL,
  `blending_date` datetime DEFAULT NULL,
  `warehouseid` int(20) NOT NULL,
  `blendedprice` double(10,2) DEFAULT NULL,
  `blendedBag` double(10,2) DEFAULT NULL,
  `blendedKgs` double(10,2) DEFAULT NULL,
  `companyid` int(20) DEFAULT NULL,
  `yearid` int(20) DEFAULT NULL,
  `productid` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_productid` (`productid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `blending_master`
--

INSERT INTO `blending_master` (`id`, `blending_number`, `blending_ref`, `blending_date`, `warehouseid`, `blendedprice`, `blendedBag`, `blendedKgs`, `companyid`, `yearid`, `productid`) VALUES(5, NULL, 'BL/001/15-16', '2015-11-03 00:00:00', 7, 495.00, 3.00, 86.00, 1, 1, 2);
INSERT INTO `blending_master` (`id`, `blending_number`, `blending_ref`, `blending_date`, `warehouseid`, `blendedprice`, `blendedBag`, `blendedKgs`, `companyid`, `yearid`, `productid`) VALUES(6, NULL, 'BL/002/15-16', '2015-12-23 00:00:00', 7, 3220.00, 20.00, 720.00, 1, 1, 2);
INSERT INTO `blending_master` (`id`, `blending_number`, `blending_ref`, `blending_date`, `warehouseid`, `blendedprice`, `blendedBag`, `blendedKgs`, `companyid`, `yearid`, `productid`) VALUES(7, NULL, '003', '2015-12-23 00:00:00', 7, 3190.00, 20.00, 720.00, 1, 1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `broker`
--

CREATE TABLE IF NOT EXISTS `broker` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `code` varchar(10) DEFAULT NULL,
  `address` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE IF NOT EXISTS `company` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `vat_number` varchar(255) DEFAULT NULL,
  `cst_number` varchar(255) DEFAULT NULL,
  `gst_number` varchar(255) DEFAULT NULL,
  `pan_number` varchar(255) DEFAULT NULL,
  `pin_number` int(11) DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  `bill_tag` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `company_name`, `location`, `vat_number`, `cst_number`, `gst_number`, `pan_number`, `pin_number`, `state_id`, `bill_tag`) VALUES(1, 'Tea Samrat', '8/1,Lalbazar Street,Kolkata-700001', '', '', '', '', 0, 3, 'TS');
INSERT INTO `company` (`id`, `company_name`, `location`, `vat_number`, `cst_number`, `gst_number`, `pan_number`, `pin_number`, `state_id`, `bill_tag`) VALUES(2, 'UNIVERSAL TEA TRADERS', '8/1, Lalabazar Street, 1st Floor, Room No - 6, Kolkata - 700  001', '', '', '', '', 0, 26, 'UTT');

-- --------------------------------------------------------

--
-- Table structure for table `cst`
--

CREATE TABLE IF NOT EXISTS `cst` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `cst_rate` decimal(10,2) DEFAULT NULL,
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(100) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `account_master_id` int(10) DEFAULT NULL,
  `tin_number` varchar(50) DEFAULT NULL,
  `cst_number` varchar(50) DEFAULT NULL,
  `pan_number` varchar(50) DEFAULT NULL,
  `service_tax_number` varchar(50) DEFAULT NULL,
  `GST_Number` varchar(50) DEFAULT NULL,
  `pin_number` int(11) DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_customer_account_master_id` (`account_master_id`),
  KEY `FK_customer_state_id` (`state_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=56 ;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `customer_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(1, 'Test_data_edit', 'TEST', NULL, 54, '1121', '1121', '12121sdd', '1121sw', '12121sdd', 743503, 26);
INSERT INTO `customer` (`id`, `customer_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(3, 'Rahul Roychowdhury', 'kolkata', '9876543210', 57, '0012', '23456', 'Aump1234', '999', '100', 700045, 26);
INSERT INTO `customer` (`id`, `customer_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(4, 'ARUP KUMAR NANDI', 'SAINYA HOOGHLY', '', 66, '', '', '', '', '', 712305, 26);
INSERT INTO `customer` (`id`, `customer_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(6, 'REKHA TEA CENTRE ', 'BETHUADAHARI,FULLTALA PARA,NADIA', '', 68, '19778712057', '', '', '', '', 741126, 26);
INSERT INTO `customer` (`id`, `customer_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(7, 'ANNAPURNA BHANDER', '46/1A, STAND ROAD\n\n\n', '', 69, '19270698031', '', '', '', '', 700007, 26);
INSERT INTO `customer` (`id`, `customer_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(8, 'MAA ANANDAMOYEE MILK SUPPLIERS', '810/243 N.BAHIRTAFA,ULUBERIA,HOWRAH', '', 70, '', '', '', '', '', 0, 26);
INSERT INTO `customer` (`id`, `customer_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(9, 'BIKI ENTERPRISE', 'CHANDITALA, HOOGHLY', '', 71, '', '', '', '', '', 712701, 26);
INSERT INTO `customer` (`id`, `customer_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(10, 'NEERA TEA SUPPLIER', 'VITARPARA,TARINPUR,NADIA.', '', 72, '19778687031', '', '', '', '', 741103, 26);
INSERT INTO `customer` (`id`, `customer_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(11, 'GOUTAM GORUI', 'ASRAMPARA,BANKURA', '', 73, '', '', '', '', '', 0, 26);
INSERT INTO `customer` (`id`, `customer_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(12, 'AMITAVA MISRA', 'JHARGRAM,MEDINIPUR (W)', '', 74, '19844790009', '', '', '', '', 0, 26);
INSERT INTO `customer` (`id`, `customer_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(13, 'KARBALA TEA HOUSE', 'V,215/6 KARBALA ROAD,KOLKATA', '', 75, '', '', '', '', '', 700018, 26);
INSERT INTO `customer` (`id`, `customer_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(14, 'SREE RAM TRADERS', 'N.S ROAD, GOCHARAN, KANTAPUKURIA,\nSOUTH 24 PARGANAS', '', 76, '19617479045', '', '', '', '', 743391, 26);
INSERT INTO `customer` (`id`, `customer_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(15, 'BARNALI ENTERPRISE', 'MOLLAPARA, BATANAGAR.\nKOLKATA', '', 77, '', '', '', '', '', 700140, 26);
INSERT INTO `customer` (`id`, `customer_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(16, 'UTTAM ENTERPRISE', 'D4-272/37 SANTOSHPUR STATION ROAD.\nRABINDRANAGAR\nSOUTH 24 PARGANAS', '', 78, '19637883092', '', '', '', '', 700018, 26);
INSERT INTO `customer` (`id`, `customer_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(17, 'SAHA TEA HOUSE', 'SANTOSHPUR, PADIRHATI.\nKOLKATA', '', 79, '', '', '', '', '', 700066, 26);
INSERT INTO `customer` (`id`, `customer_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(18, 'SAMRAT REALPROJECTS PRIVATE LIMITED', '8/1 LALBAZAR STREET,\nKOLKATA\n\n', '', 80, '19471987096', '', '', '', '', 700001, 26);
INSERT INTO `customer` (`id`, `customer_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(19, 'M/S GHOSH ENTERPRISE', 'MURAKATA RAMPUR.\nMEDINIPUR (W)', '', 81, '19848900093', '', '', '', '', 721437, 26);
INSERT INTO `customer` (`id`, `customer_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(20, 'PRADIP TRADERS', 'DEULPOTA KESHABCHAK,\nMEDINIPUR (E)', '', 82, '19858363025', '', '', '', '', 721432, 26);
INSERT INTO `customer` (`id`, `customer_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(21, 'LAKSHMI STORES', '195/8 M.G. ROAD, BUDGE BUDGE.\nSOUTH 24 PARGANAS', '', 83, '19637903074', '', '', '', '', 700137, 26);
INSERT INTO `customer` (`id`, `customer_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(22, 'SUMANTA SADHUKHAN', '21-B.G.T. ROAD,MALLICKPARA (W)\nSREERAMPUR.\nHOOGHLY', '', 84, '', '', '', '', '', 0, 26);
INSERT INTO `customer` (`id`, `customer_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(23, 'ANIMA ROY', '230,NETAJI SUBHAS ROAD.\nMASANDA (W), NEWBARRACKPUR\n24 PARGANAS (N)', '', 85, '', '', '', '', '', 0, 26);
INSERT INTO `customer` (`id`, `customer_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(24, 'CHANDU SHEK', 'VILL + P.O.- BHARATPUR.\nDIST - MURSIDABAD', '', 86, '', '', '', '', '', 742301, 26);
INSERT INTO `customer` (`id`, `customer_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(25, 'BALARAM DUTTA', 'LALBAG,MURSIDABAD', '', 87, '', '', '', '', '', 0, 26);
INSERT INTO `customer` (`id`, `customer_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(26, 'DEY AGENCY', 'PROTAPPUR, MEDINIPUR (E)', '', 88, '19853262086', '', '', '', '', 2147483647, 26);
INSERT INTO `customer` (`id`, `customer_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(27, 'MALLICK TEA', 'CHANDANNAGAR , HOOGHLY ', '', 89, '19731017836', '', '', '', '', 712136, 26);
INSERT INTO `customer` (`id`, `customer_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(28, 'ALOKE TEA', 'HATKHOLA, CHANDANNAGAR\nHOOGHLY', '', 90, '19739953088', '', '', '', '', 712136, 26);
INSERT INTO `customer` (`id`, `customer_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(29, 'JYOTI TRADING', 'GOPIBALLAPPUR, JHARGRAM\nMEDINIPUR (W)', '', 91, '198404639CV', '', '', '', '', 712506, 26);
INSERT INTO `customer` (`id`, `customer_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(30, 'ANUP GHOSH', 'VILL + P.O. - SONAKONIA, DATAN \nMEDINIPUR (W)\n', '', 92, '', '', '', '', '', 721426, 26);
INSERT INTO `customer` (`id`, `customer_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(31, 'MAA RAMANI BHANDER', 'NACHINDA, MEDINIPUR (E)\n', '', 93, '19859360088', '', '', '', '', 721444, 26);
INSERT INTO `customer` (`id`, `customer_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(32, 'MAA GAYTREE ENTERPRISE', '321,RBC ROAD GARIFA\n24 PARGANAS (N)\nNAIHATI', '', 94, '19661304518', '', '', '', '', 743166, 26);
INSERT INTO `customer` (`id`, `customer_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(33, 'H.B. CORPORATION', 'A/46, SARALA BAGAN 83 JUGIPARA ROAD,\nKOLKATA', '', 95, '19612947011  ', '', '', '', '', 700149, 26);
INSERT INTO `customer` (`id`, `customer_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(34, 'SUBHASIS KUNDU', '13 DHARINDA TAMLUK \nDistrict : MEDINIPUR(E)', '', 96, '19856136002', '', '', '', '', 0, 26);
INSERT INTO `customer` (`id`, `customer_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(35, 'CHOUDHURY ENTERPRISE', '240/224, STATION BAZAR,\nMEMARI,BURDWAN', '', 97, '', '', '', '', '', 0, 26);
INSERT INTO `customer` (`id`, `customer_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(36, 'NETAI NAG', 'MAROI BAZAR.\nBISHNUPUR, BANKURA.', '', 98, '', '', '', '', '', 0, 26);
INSERT INTO `customer` (`id`, `customer_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(38, 'DARJEELING TEA & TRADING CO.', 'BAINCHEE BAZAR. HOOGHLY', '', 100, '19730259005', '', '', '', '', 0, 26);
INSERT INTO `customer` (`id`, `customer_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(39, 'TAPAN CHAKRABORTY', 'SANTOSHPUR GOVT COLONY.\nKOLKATA.', '', 101, '', '', '', '', '', 700140, 26);
INSERT INTO `customer` (`id`, `customer_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(40, 'RAMAWTAR KHANDELWAL', 'MALANCHA ROAD KHARAGPUR.\nMEDINIPUR(W)', '', 102, '19843212013', '', '', '', '', 0, 26);
INSERT INTO `customer` (`id`, `customer_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(41, 'GOODMORNING TEA CENTRE & SUPPLIERS', 'CHAKDAHA BALARAMPUR, \nPASCHIM CHAKDAHA.\nNADIA', '', 103, '19778656088', '', '', '', '', 741222, 26);
INSERT INTO `customer` (`id`, `customer_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(42, 'LIAKAT ALI', 'HAMADAM, BERA CHAKA,\n24 PATGANAS (N)', '', 104, '', '', '', '', '', 0, 26);
INSERT INTO `customer` (`id`, `customer_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(43, 'MALLICK TEA  (U)', 'NORTH GANGARAMPUR , \nULUBERIA KAIJURI', '', 105, '', '', '', '', '', 711316, 26);
INSERT INTO `customer` (`id`, `customer_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(44, 'SANKAR TRIPATHI', 'PROTAPPUR, PASKURA\nMEDINIPUR (E)', '', 106, '', '', '', '', '', 0, 26);
INSERT INTO `customer` (`id`, `customer_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(45, 'SREEMA TEA HOUSE', 'BALICHAK, MEDINIPUR (W)', '', 107, '', '', '', '', '', 0, 26);
INSERT INTO `customer` (`id`, `customer_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(46, 'GANGA MATA AGENCY', 'GOBINDANAGAR, CHENDHUA\n GOBINDANAGAR, DASPUR \nDistrict : MEDINIPUR(W) ', '', 108, '19843496029', '', '', '', '', 0, 26);
INSERT INTO `customer` (`id`, `customer_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(47, 'UTTAM TEA HOUSE', 'MANIKPARA, JHARGRAM,\n District : MEDINIPUR(W', '', 109, '19848542066', '', '', '', '', 721513, 26);
INSERT INTO `customer` (`id`, `customer_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(48, 'SREE GURU ENTERPRISE', 'BARA BAMUNIA, GUMA\nDistrict : NORTH 24 PARGANAS ', '', 110, '19651216906', '', '', '', '', 743704, 26);
INSERT INTO `customer` (`id`, `customer_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(49, 'BASUDEV TRADING', '51/8 TARAKESWAR, BAJITPUR \nDistrict : HOOGLY', '', 111, '19739492047', '', '', '', '', 0, 26);
INSERT INTO `customer` (`id`, `customer_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(50, 'GIRIDHARI MAJHI', 'GAJONKOL,MADHYAPARA,BALICHATURI\nSHYAMPUR, HOWRAH\n', '', 112, '', '', '', '', '', 711315, 26);
INSERT INTO `customer` (`id`, `customer_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(51, 'ARUP TEA CORNER', 'VILL + P.O- HARIT, DATPUR\nHOOGHLY', '', 113, '', '', '', '', '', 712305, 26);
INSERT INTO `customer` (`id`, `customer_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(52, 'R.S. ENTERPRISE', 'CHAITANYAPUR, HALDIA \nMECHEDA ROAD, \n District : MEDINIPUR(E)', '', 114, '19854030035', '', '', '', '', 721645, 26);
INSERT INTO `customer` (`id`, `customer_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(53, 'PRONAB DAS', 'NAIHATI BAZAR,\n24 PARGANAS (N)', '', 115, '', '', '', '', '', 743249, 26);
INSERT INTO `customer` (`id`, `customer_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(54, 'KESHPUR TRADING', '1934 KESHPUR \nDistrict : MEDINIPUR(W)', '', 116, '19843215020', '', '', '', '', 0, 26);
INSERT INTO `customer` (`id`, `customer_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(55, 'MADHU JAYANTI INTERNATIONAL LTD', 'PACHIM BORAGAON,L.P. SCHOOL BYLANE\nMUKAND INFRASTRUCTUR PVT LTD - COMPOUND\nGUWAHATI', '09864259221', 134, '18240036291', '18339911167', '', '', '', 781033, 4);

-- --------------------------------------------------------

--
-- Table structure for table `customer_bill_master`
--

CREATE TABLE IF NOT EXISTS `customer_bill_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bill_id` int(11) DEFAULT NULL,
  `bill_amount` double(10,4) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `year_id` int(11) DEFAULT NULL,
  `voucher_id` int(11) DEFAULT NULL,
  `due_amount` double(11,4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_customer_bill_master_voucher_id` (`voucher_id`),
  KEY `FK_customer_bill_master_company_id` (`company_id`),
  KEY `FK_customer_bill_master_year_id` (`year_id`),
  KEY `FK_customer_bill_master_bill_id` (`bill_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `do_to_transporter`
--

CREATE TABLE IF NOT EXISTS `do_to_transporter` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `transporterId` int(20) DEFAULT NULL,
  `do` varchar(255) DEFAULT NULL,
  `purchase_inv_mst_id` int(20) DEFAULT NULL,
  `purchase_inv_dtlid` int(20) DEFAULT NULL,
  `transportationdt` datetime DEFAULT NULL,
  `chalanNumber` varchar(255) DEFAULT NULL,
  `chalanDate` datetime DEFAULT NULL,
  `is_sent` enum('N','Y') DEFAULT 'N',
  `shortkgs` decimal(10,2) DEFAULT NULL,
  `locationId` int(20) DEFAULT NULL,
  `in_Stock` enum('Y','N') DEFAULT 'N',
  `typeofpurchase` enum('AS','PS','SB') DEFAULT NULL,
  `yearid` int(20) DEFAULT NULL,
  `companyid` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `indx_purchase_master` (`purchase_inv_mst_id`),
  KEY `indx_purchase_dtl` (`purchase_inv_dtlid`),
  KEY `indx_location_id` (`locationId`),
  KEY `indx_transporter_id` (`transporterId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=295 ;

--
-- Dumping data for table `do_to_transporter`
--

INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(1, 2, '20802', 49, 227, '2015-09-16 00:00:00', '123', '2015-09-16 00:00:00', 'Y', NULL, 5, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(2, 5, '20182', 82, 265, '2015-12-10 00:00:00', '7009', '2015-12-16 00:00:00', 'Y', NULL, 20, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(3, 5, '57604', 83, 266, '2015-12-10 00:00:00', '6990', '2015-12-15 00:00:00', 'Y', NULL, 21, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(4, 5, '57605', 83, 267, '2015-12-10 00:00:00', '6990', '2015-12-15 00:00:00', 'Y', NULL, 21, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(5, 5, '57606', 83, 268, '2015-12-10 00:00:00', '6990', '2015-12-15 00:00:00', 'Y', NULL, 15, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(6, 5, '57599', 83, 269, '2015-12-10 00:00:00', '6990', '2015-12-15 00:00:00', 'Y', NULL, 22, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(7, 5, '57598', 83, 270, '2015-12-10 00:00:00', '6990', '2015-12-15 00:00:00', 'Y', NULL, 24, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(8, 5, '57593', 83, 271, '2015-12-10 00:00:00', '6990', '2015-12-15 00:00:00', 'Y', NULL, 21, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(9, 5, '57594', 83, 272, '2015-12-10 00:00:00', '6990', '2015-12-15 00:00:00', 'Y', NULL, 21, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(10, 5, '57595', 83, 273, '2015-12-10 00:00:00', '6990', '2015-12-15 00:00:00', 'Y', NULL, 21, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(11, 5, '57596', 83, 274, '2015-12-10 00:00:00', '6990', '2015-12-15 00:00:00', 'Y', NULL, 23, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(12, 5, '57597', 83, 275, '2015-12-10 00:00:00', '6990', '2015-12-15 00:00:00', 'Y', NULL, 21, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(13, 5, '57600', 83, 276, '2015-12-10 00:00:00', '6991', '2015-12-15 00:00:00', 'Y', NULL, 25, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(14, 5, '57603', 83, 277, '2015-12-10 00:00:00', '8856', '2015-12-15 00:00:00', 'Y', NULL, 25, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(15, 5, '57603', 83, 278, '2015-12-10 00:00:00', '6991', '2015-12-15 00:00:00', 'Y', NULL, 21, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(16, 5, '57602', 83, 279, '2015-12-10 00:00:00', '6991', '2015-12-15 00:00:00', 'Y', NULL, 14, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(17, 5, '55855', 85, 296, '2015-12-01 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(18, 5, '55846', 85, 295, '2015-12-01 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(19, 5, '55845', 85, 294, '2015-12-01 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(20, 5, '55844', 85, 293, '2015-12-01 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(21, 5, '55844', 85, 293, '2015-12-01 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(22, 5, '55843', 85, 292, '2015-12-01 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(23, 5, '55842', 85, 291, '2015-12-01 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(24, 5, '55854', 85, 290, '2015-12-01 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(25, 5, '55848', 85, 297, '2015-12-01 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(26, 5, '55853', 85, 298, '2015-12-01 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(27, 5, '55847', 85, 299, '2015-12-01 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(28, 5, '55847', 85, 299, '2015-12-01 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(29, 5, '55841', 85, 301, '2015-12-01 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(30, 5, '55852', 85, 300, '2015-12-01 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(31, 5, '55841', 85, 301, '2015-12-01 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(32, 5, '55859', 85, 302, '2015-12-01 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(33, 5, '55856', 85, 303, '2015-12-01 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(34, 5, '55850', 85, 304, '2015-12-01 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(35, 5, '55850', 85, 305, '2015-12-01 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(36, 5, '55850', 85, 306, '2015-12-01 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(37, 5, '55850', 85, 307, '2015-12-01 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(38, 5, '55851', 85, 308, '2015-12-01 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(39, 5, '55857', 85, 309, '2015-12-01 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(40, 5, '53032', 86, 311, '2015-12-01 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(41, 5, '53033', 86, 312, '2015-12-01 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(42, 5, '53023', 86, 313, '2015-12-01 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(43, 5, '53028', 86, 314, '2015-12-01 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(44, 5, '53029', 86, 315, '2015-12-01 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(45, 5, '53027', 86, 316, '2015-12-01 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(46, 5, '53022', 86, 317, '2015-12-01 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(47, 5, '53022', 86, 318, '2015-12-01 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(48, 5, '53031', 86, 319, '2015-12-01 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(49, 5, '35', 86, 320, '2015-12-01 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(50, 5, '53021', 86, 321, '2015-12-01 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(51, 5, '55858', 85, 310, '2015-12-01 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(52, 5, '42469', 88, 339, '2015-11-27 00:00:00', '6983', '2015-12-14 00:00:00', 'Y', NULL, 35, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(53, 5, '45468', 88, 340, '2015-11-27 00:00:00', '6983', '2015-12-14 00:00:00', 'Y', NULL, 35, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(54, 5, '45466', 88, 341, '2015-11-27 00:00:00', '6983', '2015-12-14 00:00:00', 'Y', NULL, 34, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(55, 5, '45467', 88, 342, '2015-11-27 00:00:00', '6983', '2015-12-14 00:00:00', 'Y', NULL, 34, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(56, 5, '22369', 87, 325, '2015-11-27 00:00:00', '6983', '2015-12-14 00:00:00', 'Y', NULL, 33, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(57, 5, '22370', 87, 326, '2015-11-27 00:00:00', '6983', '2015-12-14 00:00:00', 'Y', NULL, 33, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(58, 5, '22365', 87, 327, '2015-11-27 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(59, NULL, '22366', 87, 328, '2015-11-27 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(60, 5, '22366', 87, 328, '2015-11-27 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(61, 5, '22367', 87, 329, '2015-11-27 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(62, 5, '22364', 87, 330, '2015-11-27 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(63, 5, '22361', 87, 331, '2015-11-27 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(64, 5, '22362', 87, 332, '2015-11-27 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(65, 5, '22363', 87, 333, '2015-11-27 00:00:00', '6983', '2015-12-14 00:00:00', 'Y', NULL, 30, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(66, 5, '22359', 87, 334, '2015-11-27 00:00:00', '6983', '2015-12-14 00:00:00', 'Y', NULL, 31, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(67, 5, '22372', 87, 335, '2015-11-27 00:00:00', '6983', '2015-12-14 00:00:00', 'Y', NULL, 33, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(68, 5, '22368', 87, 336, '2015-11-27 00:00:00', '6983', '2015-12-14 00:00:00', 'Y', NULL, 33, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(69, 5, '22371', 87, 337, '2015-11-27 00:00:00', '6983', '2015-12-14 00:00:00', 'Y', NULL, 33, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(70, 5, '22360', 87, 338, '2015-11-27 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(71, NULL, NULL, 91, 346, NULL, NULL, NULL, 'Y', NULL, 5, 'Y', 'SB', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(72, NULL, NULL, 92, 347, NULL, NULL, NULL, 'Y', NULL, 5, 'Y', 'SB', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(73, NULL, NULL, 92, 348, NULL, NULL, NULL, 'Y', NULL, 5, 'Y', 'SB', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(74, NULL, NULL, 92, 349, NULL, NULL, NULL, 'Y', NULL, 5, 'Y', 'SB', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(75, NULL, NULL, 92, 350, NULL, NULL, NULL, 'Y', NULL, 5, 'Y', 'SB', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(76, NULL, NULL, 92, 351, NULL, NULL, NULL, 'Y', NULL, 5, 'Y', 'SB', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(77, NULL, NULL, 92, 352, NULL, NULL, NULL, 'Y', NULL, 5, 'Y', 'SB', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(78, NULL, NULL, 92, 353, NULL, NULL, NULL, 'Y', NULL, 5, 'Y', 'SB', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(79, NULL, NULL, 92, 354, NULL, NULL, NULL, 'Y', NULL, 5, 'Y', 'SB', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(80, NULL, NULL, 93, 356, NULL, NULL, NULL, 'Y', NULL, 5, 'Y', 'SB', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(81, NULL, NULL, 93, 357, NULL, NULL, NULL, 'Y', NULL, 5, 'Y', 'SB', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(82, 6, '47836', 94, 359, '2015-12-22 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(83, 6, '47838', 94, 360, '2015-12-22 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(84, 6, '47839', 94, 361, '2015-12-18 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(85, 6, '47840', 94, 362, '2015-12-22 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(86, 6, '47839', 94, 361, '2015-12-22 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(87, 6, '47841', 94, 363, '2015-12-22 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(88, 6, '47837', 94, 364, '2015-12-18 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(89, 6, '47837', 94, 365, '2015-12-18 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(90, 6, '47837', 94, 365, '2015-12-22 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(91, 6, '47837', 94, 364, '2015-12-18 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(92, NULL, NULL, 96, 368, NULL, NULL, NULL, 'Y', NULL, 56, 'Y', 'SB', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(93, 5, '59220', 100, 395, '2015-12-18 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(94, 5, '59221', 100, 397, '2015-12-18 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(95, 5, '59217', 100, 400, '2015-12-16 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(96, 5, '59218', 100, 402, '2015-12-16 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(97, 5, '59212', 100, 404, '2015-12-16 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(98, 5, '59213', 100, 406, '2015-12-16 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(99, 5, '59219', 100, 408, '2015-12-16 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(100, 5, '59220', 100, 395, '2015-12-18 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(101, 5, '59221', 100, 397, '2015-12-18 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(102, 5, '59217', 100, 400, '2015-12-18 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(103, 5, '59218', 100, 402, '2015-12-18 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(104, 5, '59212', 100, 404, '2015-12-18 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(105, 5, '59213', 100, 406, '2015-12-18 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(106, 5, '59219', 100, 408, '2015-12-18 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(107, 5, '59215', 100, 412, '2015-12-18 00:00:00', NULL, NULL, 'N', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(108, 5, '59215', 100, 412, '2015-12-18 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(109, NULL, '59216', 100, 413, '2015-12-18 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(110, 5, '59216', 100, 413, '2015-12-18 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(111, 5, '59215', 100, 412, '2015-12-18 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(112, 5, '59214', 100, 410, '2015-12-18 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(113, 5, '59219', 100, 408, '2015-12-18 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(114, 5, '59213', 100, 406, '2015-12-18 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(115, 5, '59212', 100, 404, '2015-12-18 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(116, 2, '12033', 109, 466, '2015-12-23 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(117, 2, '12034', 109, 467, '2015-12-23 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(118, 2, '12035', 109, 468, '2015-12-23 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(119, 2, '12036', 109, 469, '2015-12-23 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(120, 2, '12037', 109, 470, '2015-12-23 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(121, 2, '12038', 109, 471, '2015-12-23 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(122, 6, '10451', 97, 379, '2015-12-22 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(123, 6, '10450', 97, 376, '2015-12-22 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(124, 6, '10449', 97, 375, '2015-12-22 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(125, 6, '10448', 97, 374, '2015-12-22 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(126, 6, '10447', 97, 378, '2015-12-22 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(127, 6, '10446', 97, 377, '2015-12-22 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(128, 2, '10445', 97, 371, '2015-12-23 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(129, 2, '10444', 97, 373, '2015-12-23 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(130, 2, '10442', 97, 370, '2015-12-23 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(131, 2, '10441', 97, 369, '2015-12-23 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(132, 2, '10443', 97, 372, '2015-12-23 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(133, 2, '10443', 97, 372, '2015-12-23 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(134, 5, '54742', 110, 472, '2015-12-08 00:00:00', '7008', '2015-12-16 00:00:00', 'Y', NULL, 28, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(135, 5, '54742', 110, 473, '2015-12-08 00:00:00', '7009', '2015-12-16 00:00:00', 'Y', NULL, 28, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(136, 5, '54743', 110, 474, '2015-12-08 00:00:00', '7009', '2015-12-16 00:00:00', 'Y', NULL, 28, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(137, 5, '54744', 110, 475, '2015-12-08 00:00:00', '7009', '2015-12-16 00:00:00', 'Y', NULL, 28, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(138, 5, '54736', 110, 476, '2015-12-08 00:00:00', '7009', '2015-12-16 00:00:00', 'Y', NULL, 20, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(139, 5, '54736', 110, 477, '2015-12-08 00:00:00', '7009', '2015-12-16 00:00:00', 'Y', NULL, 20, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(140, 5, '54739', 110, 478, '2015-12-08 00:00:00', '7009', '2015-12-16 00:00:00', 'Y', NULL, 26, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(141, 5, '54740', 110, 479, '2015-12-08 00:00:00', '7009', '2015-12-16 00:00:00', 'Y', NULL, 22, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(142, 5, '54738', 110, 480, '2015-12-08 00:00:00', '7009', '2015-12-16 00:00:00', 'Y', NULL, 15, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(143, 5, '54739', 110, 481, '2015-12-08 00:00:00', '7009', '2015-12-16 00:00:00', 'Y', NULL, 14, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(144, 5, '54741', 110, 482, '2015-12-08 00:00:00', '7009', '2015-12-16 00:00:00', 'Y', NULL, 18, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(145, 5, '48135', 104, 443, '2015-12-22 00:00:00', '7071', '2015-12-28 00:00:00', 'Y', NULL, 25, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(146, 5, '48135', 104, 443, '2015-12-22 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(147, 6, '142580', 98, 389, '2015-12-23 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(148, 6, '142590', 98, 392, '2015-12-22 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(149, 6, '142591', 98, 393, '2015-12-23 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(150, 6, '142598', 98, 391, '2015-12-23 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(151, 6, '142598', 98, 390, '2015-12-23 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(152, 6, '142587', 98, 385, '2015-12-23 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(153, 6, '142597', 98, 386, '2015-12-23 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(154, 6, '142586', 98, 388, '2015-12-22 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(155, 6, '142592', 98, 381, '2015-12-23 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(156, 6, '142595', 98, 384, '2015-12-23 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(157, 6, '142594', 98, 383, '2015-12-23 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(158, 6, '142593', 98, 382, '2015-12-23 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(159, 6, '142596', 98, 380, '2015-12-23 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(160, 5, '3424', 101, 414, '2015-12-18 00:00:00', '7062', '2015-12-26 00:00:00', 'Y', NULL, 47, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(161, 5, '3425', 101, 415, '2015-12-18 00:00:00', '7062', '2015-12-26 00:00:00', 'Y', NULL, 29, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(162, 5, '3427', 101, 416, '2015-12-18 00:00:00', '7062', '2015-12-26 00:00:00', 'Y', NULL, 34, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(163, 5, '3427', 101, 417, '2015-12-18 00:00:00', '7062', '2015-12-26 00:00:00', 'Y', NULL, 52, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(164, 5, '3428', 101, 418, '2015-12-18 00:00:00', '7062', '2015-12-26 00:00:00', 'Y', NULL, 52, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(165, 5, '3429', 101, 419, '2015-12-18 00:00:00', '7062', '2015-12-26 00:00:00', 'Y', NULL, 35, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(166, 5, '3430', 101, 420, '2015-12-18 00:00:00', '7062', '2015-12-26 00:00:00', 'Y', NULL, 34, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(167, 5, '56445', 103, 431, '2015-12-18 00:00:00', '7062', '2015-12-26 00:00:00', 'Y', NULL, 35, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(168, 5, '56437', 103, 432, '2015-12-18 00:00:00', '7062', '2015-12-26 00:00:00', 'Y', NULL, 47, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(169, 5, '56438', 103, 433, '2015-12-18 00:00:00', '7062', '2015-12-26 00:00:00', 'Y', NULL, 52, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(170, 5, '56439', 103, 434, '2015-12-18 00:00:00', '7062', '2015-12-26 00:00:00', 'Y', NULL, 52, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(171, 5, '56441', 103, 435, '2015-12-18 00:00:00', '7062', '2015-12-26 00:00:00', 'Y', NULL, 33, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(172, 5, '56442', 103, 436, '2015-12-18 00:00:00', '7062', '2015-12-26 00:00:00', 'Y', NULL, 33, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(173, 5, '56442', 103, 437, '2015-12-18 00:00:00', '7062', '2015-12-26 00:00:00', 'Y', NULL, 33, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(174, 5, '56436', 103, 438, '2015-12-18 00:00:00', '7062', '2015-12-26 00:00:00', 'Y', NULL, 35, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(175, 5, '56440', 103, 439, '2015-12-18 00:00:00', '7062', '2015-12-26 00:00:00', 'Y', NULL, 47, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(176, 5, '56444', 103, 440, '2015-12-18 00:00:00', '7062', '2015-12-26 00:00:00', 'Y', NULL, 47, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(177, 5, '915', 105, 444, '2015-12-18 00:00:00', '7062', '2015-12-26 00:00:00', 'Y', NULL, 30, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(178, 5, '7572', 107, 446, '2015-12-18 00:00:00', '7062', '2015-12-26 00:00:00', 'Y', NULL, 30, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(179, 5, '7573', 107, 447, '2015-12-18 00:00:00', '7062', '2015-12-26 00:00:00', 'Y', NULL, 30, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(180, 5, '7574', 107, 448, '2015-12-18 00:00:00', '7062', '2015-12-26 00:00:00', 'Y', NULL, 30, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(181, 5, '7575', 107, 449, '2015-12-18 00:00:00', '7062', '2015-12-26 00:00:00', 'Y', NULL, 30, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(182, 5, '7576', 107, 450, '2015-12-18 00:00:00', '7062', '2015-12-26 00:00:00', 'Y', NULL, 34, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(183, 5, '7577', 107, 451, '2015-12-18 00:00:00', '7062', '2015-12-26 00:00:00', 'Y', NULL, 34, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(184, 5, '7578', 107, 452, '2015-12-18 00:00:00', '7062', '2015-12-26 00:00:00', 'Y', NULL, 34, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(185, 5, '7579', 107, 453, '2015-12-18 00:00:00', '7062', '2015-12-26 00:00:00', 'Y', NULL, 33, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(186, 5, '18492', 108, 454, '2015-12-18 00:00:00', '7071', '2015-12-28 00:00:00', 'Y', NULL, 26, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(187, 5, '18493', 108, 455, '2015-12-18 00:00:00', '7071', '2015-12-28 00:00:00', 'Y', NULL, 24, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(188, 5, '18494', 108, 456, '2015-12-18 00:00:00', '7071', '2015-12-28 00:00:00', 'Y', NULL, 14, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(189, 5, '18485', 108, 457, '2015-12-18 00:00:00', '7071', '2015-12-28 00:00:00', 'Y', NULL, 25, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(190, 5, '18486', 108, 458, '2015-12-18 00:00:00', '7071', '2015-12-28 00:00:00', 'Y', NULL, 25, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(191, 5, '18490', 108, 459, '2015-12-18 00:00:00', NULL, NULL, 'N', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(192, 5, '18490', 108, 459, '2015-12-18 00:00:00', '7071', '2015-12-28 00:00:00', 'Y', NULL, 25, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(193, 5, '18491', 108, 460, '2015-12-18 00:00:00', '7071', '2015-12-28 00:00:00', 'Y', NULL, 14, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(194, 5, '18495', 108, 461, '2015-12-18 00:00:00', '7071', '2015-12-28 00:00:00', 'Y', NULL, 25, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(195, 5, '18496', 108, 462, '2015-12-18 00:00:00', '7071', '2015-12-28 00:00:00', 'Y', NULL, 23, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(196, 5, '18487', 108, 463, '2015-12-18 00:00:00', '7071', '2015-12-28 00:00:00', 'Y', NULL, 25, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(197, 5, '18488', 108, 464, '2015-12-18 00:00:00', '7071', '2015-12-28 00:00:00', 'Y', NULL, 23, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(198, 5, '18489', 108, 465, '2015-12-18 00:00:00', '7071', '2015-12-28 00:00:00', 'Y', NULL, 15, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(199, 5, '48137', 104, 441, '2015-12-18 00:00:00', '7071', '2015-12-28 00:00:00', 'Y', NULL, 13, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(200, 5, '48136', 104, 442, '2015-12-18 00:00:00', '7071', '2015-12-28 00:00:00', 'Y', NULL, 16, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(201, 5, '2659', 106, 445, '2016-01-18 00:00:00', '7082', '2015-12-31 00:00:00', 'Y', NULL, 33, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(202, NULL, NULL, 128, 657, NULL, NULL, NULL, 'Y', NULL, 13, 'Y', 'SB', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(203, NULL, NULL, 128, 658, NULL, NULL, NULL, 'Y', NULL, 14, 'Y', 'SB', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(204, NULL, NULL, 128, 659, NULL, NULL, NULL, 'Y', NULL, 24, 'Y', 'SB', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(205, NULL, NULL, 128, 660, NULL, NULL, NULL, 'Y', NULL, 18, 'Y', 'SB', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(206, NULL, NULL, 128, 661, NULL, NULL, NULL, 'Y', NULL, 13, 'Y', 'SB', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(207, NULL, NULL, 128, 662, NULL, NULL, NULL, 'Y', NULL, 13, 'Y', 'SB', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(208, 5, '57971', 114, 526, '2015-12-23 00:00:00', '7112', '2016-01-04 00:00:00', 'Y', NULL, 22, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(209, 5, '57972', 114, 527, '2015-12-23 00:00:00', '7112', '2016-01-04 00:00:00', 'Y', NULL, 22, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(210, 5, '57973', 114, 528, '2015-12-23 00:00:00', '7112', '2016-01-04 00:00:00', 'Y', NULL, 24, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(211, 5, '57974', 114, 529, '2015-12-23 00:00:00', '7112', '2016-01-04 00:00:00', 'Y', NULL, 24, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(212, 5, '57975', 114, 530, '2015-12-23 00:00:00', '7112', '2016-01-04 00:00:00', 'Y', NULL, 24, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(213, 5, '57976', 114, 531, '2015-12-23 00:00:00', '7112', '2016-01-04 00:00:00', 'Y', NULL, 15, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(214, 5, '57977', 114, 532, '2015-12-23 00:00:00', '7112', '2016-01-04 00:00:00', 'Y', NULL, 26, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(215, 5, '57978', 114, 533, '2015-12-23 00:00:00', '7112', '2016-01-04 00:00:00', 'Y', NULL, 24, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(216, 5, '57979', 114, 534, '2015-12-23 00:00:00', '7112', '2016-01-04 00:00:00', 'Y', NULL, 26, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(217, 5, '57980', 114, 535, '2015-12-23 00:00:00', '7112', '2016-01-04 00:00:00', 'Y', NULL, 26, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(218, 5, '57981', 114, 536, '2015-12-23 00:00:00', '7112', '2016-01-04 00:00:00', 'Y', NULL, 26, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(219, 5, '19333', 115, 539, '2015-12-23 00:00:00', '7122', '2016-01-05 00:00:00', 'Y', NULL, 14, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(220, 5, '19349', 115, 540, '2015-12-23 00:00:00', '7122', '2016-01-05 00:00:00', 'Y', NULL, 23, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(221, 5, '19341', 115, 541, '2015-12-23 00:00:00', '7122', '2016-01-05 00:00:00', 'Y', NULL, 16, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(222, 5, '19342', 115, 542, '2015-12-23 00:00:00', '7122', '2016-01-05 00:00:00', 'Y', NULL, 16, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(223, 5, '19343', 115, 543, '2015-12-23 00:00:00', '7122', '2016-01-05 00:00:00', 'Y', NULL, 16, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(224, 5, '19344', 115, 544, '2015-12-23 00:00:00', '7122', '2016-01-05 00:00:00', 'Y', NULL, 16, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(225, 5, '19345', 115, 545, '2015-12-23 00:00:00', '7122', '2016-01-05 00:00:00', 'Y', NULL, 12, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(226, 5, '19339', 115, 546, '2015-12-23 00:00:00', '7122', '2016-01-05 00:00:00', 'Y', NULL, 21, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(227, 5, '19335', 115, 548, '2015-12-23 00:00:00', '7122', '2016-01-05 00:00:00', 'Y', NULL, 26, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(228, 5, '19336', 115, 549, '2015-12-23 00:00:00', '7122', '2016-01-05 00:00:00', 'Y', NULL, 26, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(229, 5, '19337', 115, 550, '2015-12-23 00:00:00', '7122', '2016-01-05 00:00:00', 'Y', NULL, 15, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(230, 5, '19330', 115, 551, '2015-12-23 00:00:00', '7122', '2016-01-05 00:00:00', 'Y', NULL, 13, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(231, 5, '19331', 115, 552, '2015-12-23 00:00:00', '7122', '2016-01-05 00:00:00', 'Y', NULL, 13, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(232, 5, '19347', 115, 553, '2015-12-23 00:00:00', '7122', '2016-01-05 00:00:00', 'Y', NULL, 20, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(233, 5, '19332', 115, 554, '2015-12-23 00:00:00', '7122', '2016-01-05 00:00:00', 'Y', NULL, 23, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(234, 5, '19348', 115, 555, '2015-12-23 00:00:00', '7122', '2016-01-05 00:00:00', 'Y', NULL, 23, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(235, 5, '19340', 115, 556, '2015-12-23 00:00:00', '7122', '2016-01-05 00:00:00', 'Y', NULL, 15, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(236, 5, '19346', 115, 537, '2015-12-23 00:00:00', '7122', '2016-01-05 00:00:00', 'Y', NULL, 22, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(237, 5, '49343', 112, 502, '2015-12-23 00:00:00', '7122', '2016-01-05 00:00:00', 'Y', NULL, 23, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(238, 5, '49344', 112, 503, '2015-12-23 00:00:00', '7122', '2016-01-05 00:00:00', 'Y', NULL, 23, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(239, 5, '49345', 112, 504, '2016-01-23 00:00:00', '7122', '2016-01-05 00:00:00', 'Y', NULL, 22, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(240, 5, '49341', 112, 505, '2015-12-23 00:00:00', '7122', '2016-01-05 00:00:00', 'Y', NULL, 19, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(241, NULL, '49345', 112, 504, NULL, NULL, NULL, 'N', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(242, 5, '49342', 112, 506, '2015-12-23 00:00:00', '7122', '2016-01-05 00:00:00', 'Y', NULL, 17, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(243, 5, '49345', 112, 504, '2016-01-23 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(244, 5, '49351', 112, 507, '2015-12-23 00:00:00', '7122', '2016-01-05 00:00:00', 'Y', NULL, 17, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(245, 5, '49352', 112, 508, '2015-12-23 00:00:00', '7122', '2016-01-05 00:00:00', 'Y', NULL, 15, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(246, 5, '49346', 112, 509, '2015-12-23 00:00:00', '7122', '2016-01-05 00:00:00', 'Y', NULL, 19, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(247, 5, '49348', 112, 510, '2015-12-23 00:00:00', '7122', '2016-01-12 00:00:00', 'Y', NULL, 20, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(248, 5, '49349', 112, 511, '2015-12-23 00:00:00', '7122', '2016-01-05 00:00:00', 'Y', NULL, 16, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(249, 5, '49350', 112, 512, '2015-12-23 00:00:00', '7122', '2016-01-05 00:00:00', 'Y', NULL, 16, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(250, 5, '49347', 112, 513, '2015-12-23 00:00:00', '7122', '2016-01-05 00:00:00', 'Y', NULL, 16, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(251, 5, '19338', 115, 538, '2015-12-23 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(252, 5, '19334', 115, 547, '2015-12-22 00:00:00', '7122', '2016-01-05 00:00:00', 'Y', NULL, 17, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(253, 5, '3510', 129, 663, '2016-01-23 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(254, NULL, '3510', 129, 663, NULL, NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(255, 5, '3510', 129, 663, '2015-12-23 00:00:00', '7121', '2016-01-05 00:00:00', 'Y', NULL, 15, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(256, 5, '3511', 129, 664, '2015-12-23 00:00:00', '7121', '2016-01-05 00:00:00', 'Y', NULL, 19, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(257, 5, '24938', 111, 483, '2015-12-23 00:00:00', '7120', '2016-01-05 00:00:00', 'Y', NULL, 12, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(258, 5, '24939', 111, 484, '2015-12-23 00:00:00', '7120', '2016-01-05 00:00:00', 'Y', NULL, 25, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(259, 5, '24940', 111, 485, '2015-12-23 00:00:00', '7120', '2016-01-05 00:00:00', 'Y', NULL, 14, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(260, 5, '24933', 111, 486, '2015-12-23 00:00:00', '7120', '2016-01-05 00:00:00', 'Y', NULL, 12, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(261, 5, '24934', 111, 487, '2015-12-23 00:00:00', '7120', '2016-01-05 00:00:00', 'Y', NULL, 12, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(262, 5, '24935', 111, 488, '2015-12-23 00:00:00', '7120', '2016-01-05 00:00:00', 'Y', NULL, 14, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(263, 5, '24936', 111, 489, '2015-12-23 00:00:00', '7120', '2016-01-05 00:00:00', 'Y', NULL, 14, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(264, 5, '24937', 111, 490, '2015-12-23 00:00:00', '7120', '2016-01-05 00:00:00', 'Y', NULL, 12, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(265, 5, '24931', 111, 491, '2015-12-23 00:00:00', '7120', '2016-01-05 00:00:00', 'Y', NULL, 12, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(266, 5, '24932', 111, 492, '2015-12-23 00:00:00', '7120', '2016-01-05 00:00:00', 'Y', NULL, 25, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(267, 5, '24927', 111, 493, '2015-12-23 00:00:00', '7120', '2016-01-05 00:00:00', 'Y', NULL, 14, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(268, 5, '24928', 111, 494, '2015-12-23 00:00:00', '7120', '2016-01-05 00:00:00', 'Y', NULL, 13, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(269, 5, '24929', 111, 495, '2015-12-23 00:00:00', '7120', '2016-01-05 00:00:00', 'Y', NULL, 14, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(270, 5, '24930', 111, 496, '2015-12-23 00:00:00', '7120', '2016-01-05 00:00:00', 'Y', NULL, 13, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(271, 5, '24943', 111, 497, '2015-12-23 00:00:00', '7120', '2016-01-05 00:00:00', 'Y', NULL, 12, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(272, 5, '24944', 111, 498, '2015-12-23 00:00:00', '7120', '2016-01-05 00:00:00', 'Y', NULL, 12, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(273, 5, '24941', 111, 499, '2015-12-23 00:00:00', '7120', '2016-01-05 00:00:00', 'Y', NULL, 13, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(274, 5, '24942', 111, 501, '2015-12-23 00:00:00', '7120', '2016-01-05 00:00:00', 'Y', NULL, 25, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(275, NULL, NULL, 134, 690, NULL, NULL, NULL, 'Y', NULL, 16, 'Y', 'SB', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(276, NULL, NULL, 134, 691, NULL, NULL, NULL, 'Y', NULL, 15, 'Y', 'SB', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(277, NULL, NULL, 134, 692, NULL, NULL, NULL, 'Y', NULL, 16, 'Y', 'SB', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(278, NULL, NULL, 134, 693, NULL, NULL, NULL, 'Y', NULL, 16, 'Y', 'SB', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(279, 2, NULL, 133, 689, '2016-01-18 00:00:00', NULL, NULL, 'Y', NULL, NULL, 'N', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(280, 5, '50497', 132, 675, '2016-01-05 00:00:00', '7180', '2016-01-19 00:00:00', 'Y', NULL, 31, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(281, 5, '50508', 132, 676, '2016-01-05 00:00:00', '7180', '2016-01-19 00:00:00', 'Y', NULL, 48, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(282, 5, '504999', 132, 677, '2016-01-05 00:00:00', '7180', '2016-01-19 00:00:00', 'Y', NULL, 48, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(283, 5, '50502', 132, 678, '2016-01-05 00:00:00', '7180', '2016-01-19 00:00:00', 'Y', NULL, 30, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(284, 5, '50495', 132, 679, '2016-01-05 00:00:00', '7180', '2016-01-19 00:00:00', 'Y', NULL, 30, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(285, 5, '50496', 132, 680, '2016-01-05 00:00:00', '7180', '2016-01-19 00:00:00', 'Y', NULL, 33, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(286, 5, '50500', 132, 681, '2016-01-05 00:00:00', '7180', '2016-01-19 00:00:00', 'Y', NULL, 31, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(287, 5, '50501', 132, 682, '2016-01-05 00:00:00', '7180', '2016-01-19 00:00:00', 'Y', NULL, 35, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(288, 5, '50503', 132, 683, '2016-01-05 00:00:00', '7180', '2016-01-19 00:00:00', 'Y', NULL, 43, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(289, 5, '50504', 132, 684, '2016-01-05 00:00:00', '7180', '2016-01-19 00:00:00', 'Y', NULL, 43, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(290, 5, '50505', 132, 685, '2016-01-05 00:00:00', '7180', '2016-01-19 00:00:00', 'Y', NULL, 32, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(291, 5, '50506', 132, 686, '2016-01-05 00:00:00', '7180', '2016-01-19 00:00:00', 'Y', NULL, 34, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(292, 5, '50498', 132, 687, '2016-01-05 00:00:00', '7180', '2016-01-19 00:00:00', 'Y', NULL, 32, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(293, 5, '50507', 132, 688, '2016-01-05 00:00:00', '7180', '2016-01-19 00:00:00', 'Y', NULL, 34, 'Y', 'AS', 1, 1);
INSERT INTO `do_to_transporter` (`id`, `transporterId`, `do`, `purchase_inv_mst_id`, `purchase_inv_dtlid`, `transportationdt`, `chalanNumber`, `chalanDate`, `is_sent`, `shortkgs`, `locationId`, `in_Stock`, `typeofpurchase`, `yearid`, `companyid`) VALUES(294, NULL, NULL, 135, 694, NULL, NULL, NULL, 'Y', NULL, 48, 'Y', 'SB', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `financialyear`
--

CREATE TABLE IF NOT EXISTS `financialyear` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `year` varchar(20) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `financialyear`
--

INSERT INTO `financialyear` (`id`, `year`, `start_date`, `end_date`) VALUES(1, '2015 - 2016', '2015-04-01', '2016-03-31');
INSERT INTO `financialyear` (`id`, `year`, `start_date`, `end_date`) VALUES(2, '2014 - 2015', '2014-04-01', '2015-03-31');
INSERT INTO `financialyear` (`id`, `year`, `start_date`, `end_date`) VALUES(3, '2013 - 2014', '2013-04-01', '2014-03-31');
INSERT INTO `financialyear` (`id`, `year`, `start_date`, `end_date`) VALUES(4, '2012 - 2013', '2012-04-01', '2013-03-31');
INSERT INTO `financialyear` (`id`, `year`, `start_date`, `end_date`) VALUES(5, '2011 - 2012', '2011-04-01', '2012-03-31');

-- --------------------------------------------------------

--
-- Table structure for table `finished_product`
--

CREATE TABLE IF NOT EXISTS `finished_product` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `productId` int(20) DEFAULT NULL,
  `blended_id` int(20) DEFAULT NULL,
  `blended_qty_kg` decimal(10,2) DEFAULT NULL,
  `consumed_kgs` decimal(10,2) DEFAULT NULL,
  `packing_date` datetime DEFAULT NULL,
  `warehouse_id` int(20) DEFAULT NULL,
  `created_by` int(20) DEFAULT NULL,
  `company_id` int(20) DEFAULT NULL,
  `year_id` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_blend` (`blended_id`),
  KEY `FK_warehouse` (`warehouse_id`),
  KEY `fk_finishproduct` (`productId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `finished_product`
--

INSERT INTO `finished_product` (`id`, `productId`, `blended_id`, `blended_qty_kg`, `consumed_kgs`, `packing_date`, `warehouse_id`, `created_by`, `company_id`, `year_id`) VALUES(4, 2, 5, '86.00', '48.00', '2015-11-03 00:00:00', 7, 2, 1, 1);
INSERT INTO `finished_product` (`id`, `productId`, `blended_id`, `blended_qty_kg`, `consumed_kgs`, `packing_date`, `warehouse_id`, `created_by`, `company_id`, `year_id`) VALUES(5, 2, 5, '86.00', '37.50', '2015-11-04 00:00:00', 7, 2, 1, 1);
INSERT INTO `finished_product` (`id`, `productId`, `blended_id`, `blended_qty_kg`, `consumed_kgs`, `packing_date`, `warehouse_id`, `created_by`, `company_id`, `year_id`) VALUES(6, 2, 5, '86.00', '5.50', '2015-11-02 00:00:00', 7, 2, 1, 1);
INSERT INTO `finished_product` (`id`, `productId`, `blended_id`, `blended_qty_kg`, `consumed_kgs`, `packing_date`, `warehouse_id`, `created_by`, `company_id`, `year_id`) VALUES(7, 5, 7, '720.00', '6.05', '2015-12-23 00:00:00', 7, 2, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `finished_product_dtl`
--

CREATE TABLE IF NOT EXISTS `finished_product_dtl` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `finishProductId` int(20) DEFAULT NULL,
  `product_packet` int(20) DEFAULT NULL,
  `numberof_packet` int(20) DEFAULT NULL,
  `net_in_packet` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_prod_pack` (`product_packet`),
  KEY `fk_finish_prod_id` (`finishProductId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `finished_product_dtl`
--

INSERT INTO `finished_product_dtl` (`id`, `finishProductId`, `product_packet`, `numberof_packet`, `net_in_packet`) VALUES(16, 5, 6, 150, '37.50');
INSERT INTO `finished_product_dtl` (`id`, `finishProductId`, `product_packet`, `numberof_packet`, `net_in_packet`) VALUES(17, 5, 7, 0, '0.00');
INSERT INTO `finished_product_dtl` (`id`, `finishProductId`, `product_packet`, `numberof_packet`, `net_in_packet`) VALUES(18, 5, 8, 0, '0.00');
INSERT INTO `finished_product_dtl` (`id`, `finishProductId`, `product_packet`, `numberof_packet`, `net_in_packet`) VALUES(19, 6, 6, 0, '0.00');
INSERT INTO `finished_product_dtl` (`id`, `finishProductId`, `product_packet`, `numberof_packet`, `net_in_packet`) VALUES(20, 6, 7, 110, '5.50');
INSERT INTO `finished_product_dtl` (`id`, `finishProductId`, `product_packet`, `numberof_packet`, `net_in_packet`) VALUES(21, 6, 8, 0, '0.00');
INSERT INTO `finished_product_dtl` (`id`, `finishProductId`, `product_packet`, `numberof_packet`, `net_in_packet`) VALUES(22, 4, 6, 112, '28.00');
INSERT INTO `finished_product_dtl` (`id`, `finishProductId`, `product_packet`, `numberof_packet`, `net_in_packet`) VALUES(23, 4, 7, 400, '20.00');
INSERT INTO `finished_product_dtl` (`id`, `finishProductId`, `product_packet`, `numberof_packet`, `net_in_packet`) VALUES(24, 4, 8, 0, '0.00');
INSERT INTO `finished_product_dtl` (`id`, `finishProductId`, `product_packet`, `numberof_packet`, `net_in_packet`) VALUES(25, 7, 57, 10, '2.50');
INSERT INTO `finished_product_dtl` (`id`, `finishProductId`, `product_packet`, `numberof_packet`, `net_in_packet`) VALUES(26, 7, 58, 10, '0.50');
INSERT INTO `finished_product_dtl` (`id`, `finishProductId`, `product_packet`, `numberof_packet`, `net_in_packet`) VALUES(27, 7, 59, 5, '0.05');
INSERT INTO `finished_product_dtl` (`id`, `finishProductId`, `product_packet`, `numberof_packet`, `net_in_packet`) VALUES(28, 7, 60, 4, '1.00');
INSERT INTO `finished_product_dtl` (`id`, `finishProductId`, `product_packet`, `numberof_packet`, `net_in_packet`) VALUES(29, 7, 61, 2, '2.00');

-- --------------------------------------------------------

--
-- Table structure for table `garden_master`
--

CREATE TABLE IF NOT EXISTS `garden_master` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `garden_name` varchar(100) NOT NULL,
  `address` varchar(500) DEFAULT 'null',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=295 ;

--
-- Dumping data for table `garden_master`
--

INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(34, 'JATINGA', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(36, 'DERBY', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(39, 'LAMABARI', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(40, 'KRISHNA BEHARI ROYAL', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(41, 'PANBARI (BORCHOLA)', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(42, 'BAGHMORA', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(43, 'PALLORBUND', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(44, 'DEWAN (SPECIAL)', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(45, 'DOOTERIAH', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(46, 'LONGVIEW', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(47, 'MAHAMAYA', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(48, 'KALPAK', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(49, 'MAHALAXMI', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(50, 'SUBHASINI', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(51, 'AIBHEEL', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(52, 'KUMAR GRAM', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(53, 'JITI', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(54, 'NIMTIJHORA', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(55, 'LEESH RIVER', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(56, 'WASHABARIE', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(57, 'DANGUAJHAR', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(58, 'MUJNAI', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(59, 'KARBALLA', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(60, 'CHALOUNI', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(61, 'MATHURA', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(62, 'MATRI', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(63, 'BILATIBARI', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(64, 'SATKHAYA', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(65, 'HULDIGHATI', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(66, 'KAMALA', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(67, 'LEKHAPANI', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(68, 'SARUGAON', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(69, 'BRAHMAPUR', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(70, 'SARASWATIPUR', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(71, 'DIROK', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(75, 'BHUYANKHAT', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(76, 'URRUNABUND', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(77, 'LARSINGAH', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(78, 'KALCHINI', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(79, 'SAMDANG', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(81, 'DIMA', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(82, 'DULIABUM', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(83, 'PANEERY', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(84, 'LABAC', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(85, 'KOOMBER', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(86, 'SAROJINI', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(88, 'LENGRAI', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(89, 'MANUVALLEY', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(91, 'MORAN', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(92, 'BURTOLL', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(93, 'TURTURI', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(95, 'JATINDRA MOHAN', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(96, 'RANIPOKHRI', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(97, 'KUNDALPOKHAR', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(98, 'NOWERA NUDDY', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(99, 'MAHAK', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(100, 'NALSARBARI', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(101, 'RAJA ROYAL', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(102, 'BHATPARA', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(103, 'JAYBIRPARA', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(104, 'DHOWLAJHORA', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(105, 'GOPALPUR', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(106, 'KIRAN CHANDRA', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(107, 'NUXALBARI', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(110, 'KONDALPOKHAR', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(111, 'PARAGON', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(112, 'RATNA', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(113, 'BARUAPARA', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(115, 'JALDAPARA', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(116, 'CHUAPARA', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(117, 'ANANDAPUR', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(118, 'AMBARI', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(119, 'ORD', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(120, 'NALSAR', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(121, 'ENGO', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(122, 'SABRANG', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(124, 'LEDO', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(125, 'DRBIJHORA', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(126, 'LALLACHERRA', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(127, 'HOLLONG', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(128, 'MARGHERITA', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(129, 'HARISANGAR', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(130, 'ATTAREEKHAT', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(131, 'MONABARIE', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(132, 'NAMDANG', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(133, 'HUNWAL', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(134, 'BEESAKOPIE', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(135, 'ATTABARRIE', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(136, 'CHANDANA', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(137, 'NEW DOOARS', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(138, 'MATELLI', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(139, 'FULBARI', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(140, 'SIMULBARI', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(141, 'BIJBARI', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(142, 'ETHELBARI', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(143, 'KHARIBARI', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(144, 'BEECH', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(145, 'HULDIBARI', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(146, 'BHARNOBARI', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(147, 'PATKAPARA', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(148, 'SAHEBBARI', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(149, 'BIJOYNAGAR', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(150, 'ARCUTTIPORE', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(151, 'SAYEDABAD', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(152, 'KAILASHPUR', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(153, 'BHANDIGURI', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(154, 'AMARPUR', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(155, 'SATALI', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(157, 'MAUSAM', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(158, 'SUKNA', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(159, 'CHINCHULA', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(160, 'PIONEER', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(161, 'BUDLA BETA', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(162, 'TALUP', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(163, 'OODLABARI', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(164, 'PUSPA', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(165, 'PUSPA GOLD', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(166, 'SWAPNA', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(167, 'SWAPNA GOLD', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(168, 'GOAL GACH', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(169, 'USHASREE', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(170, 'SOVA', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(171, 'GULMA', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(172, 'ELLENBARRIE', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(173, 'NAHORAJULI', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(174, 'RONGOLIJAN', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(175, 'SRIRAMPARA', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(176, 'KALAMATI', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(177, 'SRIKRISHNA', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(178, 'DISHA', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(179, 'HAPJAN', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(180, 'PENGAREE', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(181, 'SESSA', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(182, 'AMGOORIE', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(183, 'TIOK', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(184, 'KOOMSONG', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(186, 'HOOGRAJULI', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(187, 'SINGRI', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(188, 'HOKONGURI', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(189, 'KHOBONG', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(190, 'KAMAKHYA', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(191, 'PURMA', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(192, 'NAHORALI', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(193, 'PANBARI', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(194, 'R.D. GOLD', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(195, 'RAJAH ALI', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(196, 'MAYNAGURI', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(197, 'GIRISH CHANDRA', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(198, 'GOOMTEE', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(199, 'CASTELTON', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(200, 'KALEJ VALLEY', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(202, 'MILIKTHONG', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(203, 'GLENBURN', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(204, 'JOGMAYA', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(206, 'ARVIKAD', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(207, 'PERTABGHUR', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(208, 'SEPHINJURI', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(209, 'LENGREE', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(210, 'BINAGURI', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(211, 'BURTOLL SPECIAL', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(212, 'UDALGURI', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(213, 'SANKOS', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(214, 'RUNGAMUTTEE', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(215, 'RAMDURLABHPUR', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(216, 'MEENGLAS', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(217, 'HOPE', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(218, 'JAINTI', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(219, 'HIMALAYAN', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(220, 'BANARHAT', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(221, 'BHUBRIGHAT', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(222, 'TELEPARA', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(223, 'BATABARI', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(224, 'NANGDALA', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(225, 'MISSION HILL', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(226, 'BICRAMPORE', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(227, 'JELLALPORE', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(228, 'MOUNT BIR', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(229, 'GANDRAPARA', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(230, 'CHULSA', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(231, 'DHARMSALA', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(232, 'CHOONABHUTTI', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(233, 'LALLAMOOKH', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(234, 'BOGIJAN', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(235, 'BICRAMPORE', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(236, 'NYA GOGRA', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(237, 'TINKHARIA', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(238, 'CENTRAL DOOARS', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(239, 'TUSKER VALLEY', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(240, 'TUSKER VALLEY', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(241, 'SATYANARAYAN', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(242, 'JOKAIBARI', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(243, 'TINGALIBAM', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(244, 'KUSUM', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(245, 'MAJHERDABRI', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(246, 'GHATIA', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(247, 'GOODHOPE', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(248, 'ZURRANTEE', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(249, 'TAIPOO', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(250, 'COOCHBEHAR', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(251, 'DEBPARA', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(252, 'PAHARGOOMIAH', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(253, 'GAIRKHATA', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(254, 'SUPRIYA', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(255, 'DAMANPUR', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(256, 'KARALI SUPREME', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(257, 'NEPUCHAPUR', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(258, 'MAINAK HILLS', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(259, 'ARJUN CHANDRA', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(260, 'CARRON', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(261, 'RAIMOHAN', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(262, 'DEBIJHORA', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(263, 'GAYAGANGA', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(264, 'GURJANGJHORA', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(265, 'HARISHPUR', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(266, 'MOGULKATA', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(267, 'KETTELA', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(268, 'ADDABARIE', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(270, 'BALASON', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(271, 'KOPATI', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(272, 'KALLINE', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(273, 'KADAMBINI', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(274, 'JOGES CHANDRA', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(275, 'JOYPUR', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(276, 'MECHPARA', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(277, 'GRASSMORE', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(278, 'ATAL', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(279, 'CHENGMARI', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(280, 'INDONG', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(281, 'DOYAPORE', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(282, 'MARTYCHERRA', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(283, 'PHILLOBARI', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(284, 'NAMRING', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(285, 'FURKATING', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(286, 'COOMBERGRAM', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(287, 'BELGACHI', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(288, 'LOOKSUN', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(289, 'MARIONBARIE', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(290, 'CHANDAN', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(291, 'TIN BIGHA', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(292, 'SITARAMPUR', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(293, 'JAYABARI', '');
INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES(294, 'SATISHCHANDRA', '');

-- --------------------------------------------------------

--
-- Table structure for table `grade_master`
--

CREATE TABLE IF NOT EXISTS `grade_master` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `grade` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=41 ;

--
-- Dumping data for table `grade_master`
--

INSERT INTO `grade_master` (`id`, `grade`) VALUES(10, 'BP');
INSERT INTO `grade_master` (`id`, `grade`) VALUES(11, 'BOPSM');
INSERT INTO `grade_master` (`id`, `grade`) VALUES(14, 'BP1');
INSERT INTO `grade_master` (`id`, `grade`) VALUES(15, 'PF');
INSERT INTO `grade_master` (`id`, `grade`) VALUES(16, 'PF1');
INSERT INTO `grade_master` (`id`, `grade`) VALUES(17, 'BPSM1');
INSERT INTO `grade_master` (`id`, `grade`) VALUES(18, 'BPSM');
INSERT INTO `grade_master` (`id`, `grade`) VALUES(19, 'BOPS');
INSERT INTO `grade_master` (`id`, `grade`) VALUES(20, 'BOPF');
INSERT INTO `grade_master` (`id`, `grade`) VALUES(21, 'BOPSM1');
INSERT INTO `grade_master` (`id`, `grade`) VALUES(22, 'OF');
INSERT INTO `grade_master` (`id`, `grade`) VALUES(23, 'OF1');
INSERT INTO `grade_master` (`id`, `grade`) VALUES(24, 'DUST');
INSERT INTO `grade_master` (`id`, `grade`) VALUES(25, 'D');
INSERT INTO `grade_master` (`id`, `grade`) VALUES(26, 'TGOF');
INSERT INTO `grade_master` (`id`, `grade`) VALUES(27, 'GOF');
INSERT INTO `grade_master` (`id`, `grade`) VALUES(28, 'TGBOP');
INSERT INTO `grade_master` (`id`, `grade`) VALUES(29, 'SFTGFOP1');
INSERT INTO `grade_master` (`id`, `grade`) VALUES(30, 'GBOP');
INSERT INTO `grade_master` (`id`, `grade`) VALUES(31, 'FTGOF');
INSERT INTO `grade_master` (`id`, `grade`) VALUES(32, 'FTGFOP');
INSERT INTO `grade_master` (`id`, `grade`) VALUES(33, 'FOF');
INSERT INTO `grade_master` (`id`, `grade`) VALUES(34, 'FTGFOP1');
INSERT INTO `grade_master` (`id`, `grade`) VALUES(35, 'BOP');
INSERT INTO `grade_master` (`id`, `grade`) VALUES(36, 'TGBOP1');
INSERT INTO `grade_master` (`id`, `grade`) VALUES(37, 'STGOF');
INSERT INTO `grade_master` (`id`, `grade`) VALUES(38, 'PD');
INSERT INTO `grade_master` (`id`, `grade`) VALUES(39, 'PD1');
INSERT INTO `grade_master` (`id`, `grade`) VALUES(40, 'DU');

-- --------------------------------------------------------

--
-- Table structure for table `group_category`
--

CREATE TABLE IF NOT EXISTS `group_category` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `group_name_id` int(100) NOT NULL,
  `sub_group_name_id` int(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_group_name_id` (`group_name_id`),
  KEY `FK_sub_group_name_id` (`sub_group_name_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `group_category`
--

INSERT INTO `group_category` (`id`, `group_name_id`, `sub_group_name_id`) VALUES(13, 3, 1);
INSERT INTO `group_category` (`id`, `group_name_id`, `sub_group_name_id`) VALUES(15, 3, 2);
INSERT INTO `group_category` (`id`, `group_name_id`, `sub_group_name_id`) VALUES(16, 4, 3);
INSERT INTO `group_category` (`id`, `group_name_id`, `sub_group_name_id`) VALUES(17, 4, 4);

-- --------------------------------------------------------

--
-- Table structure for table `group_master`
--

CREATE TABLE IF NOT EXISTS `group_master` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(100) DEFAULT NULL,
  `group_category_id` int(10) DEFAULT NULL,
  `is_special` enum('Y','N') DEFAULT 'N',
  PRIMARY KEY (`id`),
  KEY `FK_group_category_id` (`group_category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `group_master`
--

INSERT INTO `group_master` (`id`, `group_name`, `group_category_id`, `is_special`) VALUES(1, 'Sundry Debtors', 13, 'Y');
INSERT INTO `group_master` (`id`, `group_name`, `group_category_id`, `is_special`) VALUES(2, 'Sundry Creditors', 15, 'Y');
INSERT INTO `group_master` (`id`, `group_name`, `group_category_id`, `is_special`) VALUES(3, 'Sale', 16, 'Y');
INSERT INTO `group_master` (`id`, `group_name`, `group_category_id`, `is_special`) VALUES(4, 'Purchase', 17, 'Y');
INSERT INTO `group_master` (`id`, `group_name`, `group_category_id`, `is_special`) VALUES(5, 'Indirect Expenditure', 17, 'Y');
INSERT INTO `group_master` (`id`, `group_name`, `group_category_id`, `is_special`) VALUES(8, 'Cash Balance', 13, 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `group_name`
--

CREATE TABLE IF NOT EXISTS `group_name` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `group_name`
--

INSERT INTO `group_name` (`id`, `name`) VALUES(3, 'Balance Sheet');
INSERT INTO `group_name` (`id`, `name`) VALUES(4, 'Profit and Loss');

-- --------------------------------------------------------

--
-- Table structure for table `item_master`
--

CREATE TABLE IF NOT EXISTS `item_master` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `grade_id` int(10) DEFAULT NULL,
  `garden_id` int(10) DEFAULT NULL,
  `invoice_number` varchar(255) DEFAULT NULL,
  `package` int(10) DEFAULT NULL,
  `net` int(10) DEFAULT NULL,
  `gross` varchar(255) DEFAULT NULL,
  `bill_id` int(10) DEFAULT NULL,
  `from_where` enum('AS','PS','SB') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_grade_id` (`grade_id`),
  KEY `FK_garden_id` (`garden_id`),
  KEY `FK_purchase_invoice_id` (`bill_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=445 ;

--
-- Dumping data for table `item_master`
--

INSERT INTO `item_master` (`id`, `grade_id`, `garden_id`, `invoice_number`, `package`, `net`, `gross`, `bill_id`, `from_where`) VALUES(393, 10, 34, 'C40', 30, 40, '40.2', 44, 'AS');
INSERT INTO `item_master` (`id`, `grade_id`, `garden_id`, `invoice_number`, `package`, `net`, `gross`, `bill_id`, `from_where`) VALUES(394, 10, 36, 'C-40/26062015', NULL, NULL, '30.2', 45, 'AS');
INSERT INTO `item_master` (`id`, `grade_id`, `garden_id`, `invoice_number`, `package`, `net`, `gross`, `bill_id`, `from_where`) VALUES(395, 11, 45, 'C-50/26062015', NULL, NULL, '40.5', 45, 'AS');
INSERT INTO `item_master` (`id`, `grade_id`, `garden_id`, `invoice_number`, `package`, `net`, `gross`, `bill_id`, `from_where`) VALUES(396, 15, 86, '313', NULL, NULL, '36.19', 46, 'AS');
INSERT INTO `item_master` (`id`, `grade_id`, `garden_id`, `invoice_number`, `package`, `net`, `gross`, `bill_id`, `from_where`) VALUES(397, 10, 58, 'C41-0001', NULL, NULL, '30.2', 47, 'AS');
INSERT INTO `item_master` (`id`, `grade_id`, `garden_id`, `invoice_number`, `package`, `net`, `gross`, `bill_id`, `from_where`) VALUES(398, 18, 45, 'C4-0001', NULL, NULL, '20.5', 47, 'AS');
INSERT INTO `item_master` (`id`, `grade_id`, `garden_id`, `invoice_number`, `package`, `net`, `gross`, `bill_id`, `from_where`) VALUES(399, 28, 34, 'C-40', NULL, NULL, '30.2', 48, 'AS');
INSERT INTO `item_master` (`id`, `grade_id`, `garden_id`, `invoice_number`, `package`, `net`, `gross`, `bill_id`, `from_where`) VALUES(400, 28, 34, 'C-12', NULL, NULL, '20.5', 48, 'AS');
INSERT INTO `item_master` (`id`, `grade_id`, `garden_id`, `invoice_number`, `package`, `net`, `gross`, `bill_id`, `from_where`) VALUES(401, 15, 39, '162', NULL, NULL, '31.4', 49, 'AS');
INSERT INTO `item_master` (`id`, `grade_id`, `garden_id`, `invoice_number`, `package`, `net`, `gross`, `bill_id`, `from_where`) VALUES(402, 15, 39, '241', NULL, NULL, '30.4', NULL, 'AS');
INSERT INTO `item_master` (`id`, `grade_id`, `garden_id`, `invoice_number`, `package`, `net`, `gross`, `bill_id`, `from_where`) VALUES(403, 10, 81, '380', NULL, NULL, '35.2', NULL, 'AS');
INSERT INTO `item_master` (`id`, `grade_id`, `garden_id`, `invoice_number`, `package`, `net`, `gross`, `bill_id`, `from_where`) VALUES(404, 15, 39, '162', NULL, NULL, '031.4', NULL, 'AS');
INSERT INTO `item_master` (`id`, `grade_id`, `garden_id`, `invoice_number`, `package`, `net`, `gross`, `bill_id`, `from_where`) VALUES(405, 15, 39, '162', NULL, NULL, '31.40', NULL, 'AS');
INSERT INTO `item_master` (`id`, `grade_id`, `garden_id`, `invoice_number`, `package`, `net`, `gross`, `bill_id`, `from_where`) VALUES(406, 15, 34, '240014T', NULL, NULL, '28.4', 50, 'AS');
INSERT INTO `item_master` (`id`, `grade_id`, `garden_id`, `invoice_number`, `package`, `net`, `gross`, `bill_id`, `from_where`) VALUES(407, 15, 207, '240014T', NULL, NULL, '28.40', NULL, 'AS');
INSERT INTO `item_master` (`id`, `grade_id`, `garden_id`, `invoice_number`, `package`, `net`, `gross`, `bill_id`, `from_where`) VALUES(408, 10, 208, '149', NULL, NULL, '30.2', NULL, 'AS');
INSERT INTO `item_master` (`id`, `grade_id`, `garden_id`, `invoice_number`, `package`, `net`, `gross`, `bill_id`, `from_where`) VALUES(409, 11, 43, '389', NULL, NULL, '35.2', NULL, 'AS');
INSERT INTO `item_master` (`id`, `grade_id`, `garden_id`, `invoice_number`, `package`, `net`, `gross`, `bill_id`, `from_where`) VALUES(410, 10, 43, '387', NULL, NULL, '35.2', NULL, 'AS');
INSERT INTO `item_master` (`id`, `grade_id`, `garden_id`, `invoice_number`, `package`, `net`, `gross`, `bill_id`, `from_where`) VALUES(411, 22, 43, '376', NULL, NULL, '35.2', NULL, 'AS');
INSERT INTO `item_master` (`id`, `grade_id`, `garden_id`, `invoice_number`, `package`, `net`, `gross`, `bill_id`, `from_where`) VALUES(412, 10, 62, '472', NULL, NULL, '35.2', NULL, 'AS');
INSERT INTO `item_master` (`id`, `grade_id`, `garden_id`, `invoice_number`, `package`, `net`, `gross`, `bill_id`, `from_where`) VALUES(413, 15, 207, '240014T', NULL, NULL, '28.40', NULL, 'AS');
INSERT INTO `item_master` (`id`, `grade_id`, `garden_id`, `invoice_number`, `package`, `net`, `gross`, `bill_id`, `from_where`) VALUES(414, 15, 207, '240014T', NULL, NULL, '28.40', NULL, 'AS');
INSERT INTO `item_master` (`id`, `grade_id`, `garden_id`, `invoice_number`, `package`, `net`, `gross`, `bill_id`, `from_where`) VALUES(415, 10, 207, '240014T', NULL, NULL, '30.2', NULL, 'AS');
INSERT INTO `item_master` (`id`, `grade_id`, `garden_id`, `invoice_number`, `package`, `net`, `gross`, `bill_id`, `from_where`) VALUES(416, 15, 207, '240014T', NULL, NULL, '28.40', NULL, 'AS');
INSERT INTO `item_master` (`id`, `grade_id`, `garden_id`, `invoice_number`, `package`, `net`, `gross`, `bill_id`, `from_where`) VALUES(417, 15, 207, '240014T', NULL, NULL, '28.40', NULL, 'AS');
INSERT INTO `item_master` (`id`, `grade_id`, `garden_id`, `invoice_number`, `package`, `net`, `gross`, `bill_id`, `from_where`) VALUES(418, 10, 88, '195', NULL, NULL, '36.2', 51, 'AS');
INSERT INTO `item_master` (`id`, `grade_id`, `garden_id`, `invoice_number`, `package`, `net`, `gross`, `bill_id`, `from_where`) VALUES(419, 15, 88, '130', NULL, NULL, '34.2', 51, 'AS');
INSERT INTO `item_master` (`id`, `grade_id`, `garden_id`, `invoice_number`, `package`, `net`, `gross`, `bill_id`, `from_where`) VALUES(420, 11, 76, '135', NULL, NULL, '39.6', 51, 'AS');
INSERT INTO `item_master` (`id`, `grade_id`, `garden_id`, `invoice_number`, `package`, `net`, `gross`, `bill_id`, `from_where`) VALUES(421, 10, 76, '136', NULL, NULL, '40.6', 51, 'AS');
INSERT INTO `item_master` (`id`, `grade_id`, `garden_id`, `invoice_number`, `package`, `net`, `gross`, `bill_id`, `from_where`) VALUES(422, 10, 88, '195', NULL, NULL, '36.20', NULL, 'AS');
INSERT INTO `item_master` (`id`, `grade_id`, `garden_id`, `invoice_number`, `package`, `net`, `gross`, `bill_id`, `from_where`) VALUES(423, 15, 209, '130', NULL, NULL, '34.20', NULL, 'AS');
INSERT INTO `item_master` (`id`, `grade_id`, `garden_id`, `invoice_number`, `package`, `net`, `gross`, `bill_id`, `from_where`) VALUES(424, 11, 76, '135', NULL, NULL, '39.60', NULL, 'AS');
INSERT INTO `item_master` (`id`, `grade_id`, `garden_id`, `invoice_number`, `package`, `net`, `gross`, `bill_id`, `from_where`) VALUES(425, 10, 76, '136', NULL, NULL, '40.60', NULL, 'AS');
INSERT INTO `item_master` (`id`, `grade_id`, `garden_id`, `invoice_number`, `package`, `net`, `gross`, `bill_id`, `from_where`) VALUES(426, 15, 39, '162', NULL, NULL, '31.40', NULL, 'AS');
INSERT INTO `item_master` (`id`, `grade_id`, `garden_id`, `invoice_number`, `package`, `net`, `gross`, `bill_id`, `from_where`) VALUES(427, 15, 39, '162', NULL, NULL, '31.40', NULL, 'AS');
INSERT INTO `item_master` (`id`, `grade_id`, `garden_id`, `invoice_number`, `package`, `net`, `gross`, `bill_id`, `from_where`) VALUES(428, 15, 39, '162', NULL, NULL, '31.40', NULL, 'AS');
INSERT INTO `item_master` (`id`, `grade_id`, `garden_id`, `invoice_number`, `package`, `net`, `gross`, `bill_id`, `from_where`) VALUES(429, 10, 171, 'C664', NULL, NULL, '38.5', 52, 'AS');
INSERT INTO `item_master` (`id`, `grade_id`, `garden_id`, `invoice_number`, `package`, `net`, `gross`, `bill_id`, `from_where`) VALUES(430, 14, 171, 'C632', NULL, NULL, '38.5', NULL, 'AS');
INSERT INTO `item_master` (`id`, `grade_id`, `garden_id`, `invoice_number`, `package`, `net`, `gross`, `bill_id`, `from_where`) VALUES(431, 10, 63, 'C546', NULL, NULL, '38.22', NULL, 'AS');
INSERT INTO `item_master` (`id`, `grade_id`, `garden_id`, `invoice_number`, `package`, `net`, `gross`, `bill_id`, `from_where`) VALUES(432, 10, 171, 'C664', NULL, NULL, '38.50', NULL, 'AS');
INSERT INTO `item_master` (`id`, `grade_id`, `garden_id`, `invoice_number`, `package`, `net`, `gross`, `bill_id`, `from_where`) VALUES(433, 15, 86, '544', NULL, NULL, '36.19', 53, 'AS');
INSERT INTO `item_master` (`id`, `grade_id`, `garden_id`, `invoice_number`, `package`, `net`, `gross`, `bill_id`, `from_where`) VALUES(434, 11, 76, 'CE212', NULL, NULL, '39.6', 53, 'AS');
INSERT INTO `item_master` (`id`, `grade_id`, `garden_id`, `invoice_number`, `package`, `net`, `gross`, `bill_id`, `from_where`) VALUES(435, 10, 76, 'CE218', NULL, NULL, '40.6', 53, 'AS');
INSERT INTO `item_master` (`id`, `grade_id`, `garden_id`, `invoice_number`, `package`, `net`, `gross`, `bill_id`, `from_where`) VALUES(436, 10, 76, 'CE219', NULL, NULL, '40.6', 53, 'AS');
INSERT INTO `item_master` (`id`, `grade_id`, `garden_id`, `invoice_number`, `package`, `net`, `gross`, `bill_id`, `from_where`) VALUES(437, 10, 76, 'CE225', NULL, NULL, '40.6', 53, 'AS');
INSERT INTO `item_master` (`id`, `grade_id`, `garden_id`, `invoice_number`, `package`, `net`, `gross`, `bill_id`, `from_where`) VALUES(438, 22, 76, 'CE220', NULL, NULL, '41.6', 53, 'AS');
INSERT INTO `item_master` (`id`, `grade_id`, `garden_id`, `invoice_number`, `package`, `net`, `gross`, `bill_id`, `from_where`) VALUES(439, 15, 86, '544', NULL, NULL, '36.19', NULL, 'AS');
INSERT INTO `item_master` (`id`, `grade_id`, `garden_id`, `invoice_number`, `package`, `net`, `gross`, `bill_id`, `from_where`) VALUES(440, 11, 76, 'CE212', NULL, NULL, '39.60', NULL, 'AS');
INSERT INTO `item_master` (`id`, `grade_id`, `garden_id`, `invoice_number`, `package`, `net`, `gross`, `bill_id`, `from_where`) VALUES(441, 10, 76, 'CE218', NULL, NULL, '40.60', NULL, 'AS');
INSERT INTO `item_master` (`id`, `grade_id`, `garden_id`, `invoice_number`, `package`, `net`, `gross`, `bill_id`, `from_where`) VALUES(442, 10, 76, 'CE219', NULL, NULL, '40.60', NULL, 'AS');
INSERT INTO `item_master` (`id`, `grade_id`, `garden_id`, `invoice_number`, `package`, `net`, `gross`, `bill_id`, `from_where`) VALUES(443, 10, 76, 'CE225', NULL, NULL, '40.60', NULL, 'AS');
INSERT INTO `item_master` (`id`, `grade_id`, `garden_id`, `invoice_number`, `package`, `net`, `gross`, `bill_id`, `from_where`) VALUES(444, 22, 76, 'CE220', NULL, NULL, '41.60', NULL, 'AS');

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE IF NOT EXISTS `location` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `location` varchar(255) DEFAULT NULL,
  `warehouseid` int(20) DEFAULT NULL,
  `is_active` enum('Y','N') DEFAULT 'Y',
  PRIMARY KEY (`id`),
  KEY `fk_warehouse_location` (`warehouseid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=57 ;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`id`, `location`, `warehouseid`, `is_active`) VALUES(5, 'L6', 7, 'Y');
INSERT INTO `location` (`id`, `location`, `warehouseid`, `is_active`) VALUES(6, '108', 7, 'Y');
INSERT INTO `location` (`id`, `location`, `warehouseid`, `is_active`) VALUES(7, 'T3', 7, 'Y');
INSERT INTO `location` (`id`, `location`, `warehouseid`, `is_active`) VALUES(8, 'FL', 7, 'Y');
INSERT INTO `location` (`id`, `location`, `warehouseid`, `is_active`) VALUES(9, 'GFL', 7, 'Y');
INSERT INTO `location` (`id`, `location`, `warehouseid`, `is_active`) VALUES(10, 'G', 7, 'Y');
INSERT INTO `location` (`id`, `location`, `warehouseid`, `is_active`) VALUES(11, 'H', 7, 'Y');
INSERT INTO `location` (`id`, `location`, `warehouseid`, `is_active`) VALUES(12, '9', 7, 'Y');
INSERT INTO `location` (`id`, `location`, `warehouseid`, `is_active`) VALUES(13, '10', 7, 'Y');
INSERT INTO `location` (`id`, `location`, `warehouseid`, `is_active`) VALUES(14, '11', 7, 'Y');
INSERT INTO `location` (`id`, `location`, `warehouseid`, `is_active`) VALUES(15, '12', 7, 'Y');
INSERT INTO `location` (`id`, `location`, `warehouseid`, `is_active`) VALUES(16, '13', 7, 'Y');
INSERT INTO `location` (`id`, `location`, `warehouseid`, `is_active`) VALUES(17, '14', 7, 'Y');
INSERT INTO `location` (`id`, `location`, `warehouseid`, `is_active`) VALUES(18, '15', 7, 'Y');
INSERT INTO `location` (`id`, `location`, `warehouseid`, `is_active`) VALUES(19, '16', 7, 'Y');
INSERT INTO `location` (`id`, `location`, `warehouseid`, `is_active`) VALUES(20, '17', 7, 'Y');
INSERT INTO `location` (`id`, `location`, `warehouseid`, `is_active`) VALUES(21, '18', 7, 'Y');
INSERT INTO `location` (`id`, `location`, `warehouseid`, `is_active`) VALUES(22, '19', 7, 'Y');
INSERT INTO `location` (`id`, `location`, `warehouseid`, `is_active`) VALUES(23, '20', 7, 'Y');
INSERT INTO `location` (`id`, `location`, `warehouseid`, `is_active`) VALUES(24, '21', 7, 'Y');
INSERT INTO `location` (`id`, `location`, `warehouseid`, `is_active`) VALUES(25, '22', 7, 'Y');
INSERT INTO `location` (`id`, `location`, `warehouseid`, `is_active`) VALUES(26, '23', 7, 'Y');
INSERT INTO `location` (`id`, `location`, `warehouseid`, `is_active`) VALUES(27, '24', 7, 'Y');
INSERT INTO `location` (`id`, `location`, `warehouseid`, `is_active`) VALUES(28, '25', 7, 'Y');
INSERT INTO `location` (`id`, `location`, `warehouseid`, `is_active`) VALUES(29, '26', 7, 'Y');
INSERT INTO `location` (`id`, `location`, `warehouseid`, `is_active`) VALUES(30, '27', 7, 'Y');
INSERT INTO `location` (`id`, `location`, `warehouseid`, `is_active`) VALUES(31, '28', 7, 'Y');
INSERT INTO `location` (`id`, `location`, `warehouseid`, `is_active`) VALUES(32, '29', 7, 'Y');
INSERT INTO `location` (`id`, `location`, `warehouseid`, `is_active`) VALUES(33, '30', 7, 'Y');
INSERT INTO `location` (`id`, `location`, `warehouseid`, `is_active`) VALUES(34, '31', 7, 'Y');
INSERT INTO `location` (`id`, `location`, `warehouseid`, `is_active`) VALUES(35, '32', 7, 'Y');
INSERT INTO `location` (`id`, `location`, `warehouseid`, `is_active`) VALUES(36, '33', 7, 'Y');
INSERT INTO `location` (`id`, `location`, `warehouseid`, `is_active`) VALUES(37, '34', 7, 'Y');
INSERT INTO `location` (`id`, `location`, `warehouseid`, `is_active`) VALUES(38, '35', 7, 'Y');
INSERT INTO `location` (`id`, `location`, `warehouseid`, `is_active`) VALUES(39, '36', 7, 'Y');
INSERT INTO `location` (`id`, `location`, `warehouseid`, `is_active`) VALUES(40, '46', 7, 'Y');
INSERT INTO `location` (`id`, `location`, `warehouseid`, `is_active`) VALUES(41, '47', 7, 'Y');
INSERT INTO `location` (`id`, `location`, `warehouseid`, `is_active`) VALUES(42, '48', 7, 'Y');
INSERT INTO `location` (`id`, `location`, `warehouseid`, `is_active`) VALUES(43, '49', 7, 'Y');
INSERT INTO `location` (`id`, `location`, `warehouseid`, `is_active`) VALUES(44, '50', 7, 'Y');
INSERT INTO `location` (`id`, `location`, `warehouseid`, `is_active`) VALUES(45, '51', 7, 'Y');
INSERT INTO `location` (`id`, `location`, `warehouseid`, `is_active`) VALUES(46, '51', 7, 'Y');
INSERT INTO `location` (`id`, `location`, `warehouseid`, `is_active`) VALUES(47, '52', 7, 'Y');
INSERT INTO `location` (`id`, `location`, `warehouseid`, `is_active`) VALUES(48, '53', 7, 'Y');
INSERT INTO `location` (`id`, `location`, `warehouseid`, `is_active`) VALUES(49, '54', 7, 'Y');
INSERT INTO `location` (`id`, `location`, `warehouseid`, `is_active`) VALUES(50, '55', 7, 'Y');
INSERT INTO `location` (`id`, `location`, `warehouseid`, `is_active`) VALUES(51, '56', 7, 'Y');
INSERT INTO `location` (`id`, `location`, `warehouseid`, `is_active`) VALUES(52, '57', 7, 'Y');
INSERT INTO `location` (`id`, `location`, `warehouseid`, `is_active`) VALUES(53, '58', 7, 'Y');
INSERT INTO `location` (`id`, `location`, `warehouseid`, `is_active`) VALUES(54, '59', 7, 'Y');
INSERT INTO `location` (`id`, `location`, `warehouseid`, `is_active`) VALUES(55, '60', 7, 'Y');
INSERT INTO `location` (`id`, `location`, `warehouseid`, `is_active`) VALUES(56, 'NONE', 7, 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(255) DEFAULT NULL,
  `menu_link` varchar(255) DEFAULT NULL,
  `is_parent` enum('C','P','SC') DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `menu_code` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=41 ;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `menu_name`, `menu_link`, `is_parent`, `parent_id`, `menu_code`) VALUES(3, 'Get Ready', '', 'P', NULL, NULL);
INSERT INTO `menu` (`id`, `menu_name`, `menu_link`, `is_parent`, `parent_id`, `menu_code`) VALUES(4, 'Garden', 'gardenmaster', 'C', 3, 'gardenmaster');
INSERT INTO `menu` (`id`, `menu_name`, `menu_link`, `is_parent`, `parent_id`, `menu_code`) VALUES(5, 'Grade', 'grademaster', 'C', 3, 'grademaster');
INSERT INTO `menu` (`id`, `menu_name`, `menu_link`, `is_parent`, `parent_id`, `menu_code`) VALUES(6, 'Warehouse', 'warehousemaster', 'C', 3, 'warehousemaster');
INSERT INTO `menu` (`id`, `menu_name`, `menu_link`, `is_parent`, `parent_id`, `menu_code`) VALUES(7, 'Service Tax', 'servicetaxmaster', 'C', 16, 'servicetaxmaster');
INSERT INTO `menu` (`id`, `menu_name`, `menu_link`, `is_parent`, `parent_id`, `menu_code`) VALUES(8, 'Broker', 'brokermaster', 'C', 3, 'brokermaster');
INSERT INTO `menu` (`id`, `menu_name`, `menu_link`, `is_parent`, `parent_id`, `menu_code`) VALUES(9, 'VAT', 'vatmaster', 'C', 16, 'vatmaster');
INSERT INTO `menu` (`id`, `menu_name`, `menu_link`, `is_parent`, `parent_id`, `menu_code`) VALUES(10, 'Group Category', 'groupcategorymaster', 'C', 16, 'groupcategorymaster');
INSERT INTO `menu` (`id`, `menu_name`, `menu_link`, `is_parent`, `parent_id`, `menu_code`) VALUES(11, 'Group Master', 'groupmaster', 'C', 16, 'groupmaster');
INSERT INTO `menu` (`id`, `menu_name`, `menu_link`, `is_parent`, `parent_id`, `menu_code`) VALUES(12, 'Account', 'accountmaster', 'C', 16, 'accountmaster');
INSERT INTO `menu` (`id`, `menu_name`, `menu_link`, `is_parent`, `parent_id`, `menu_code`) VALUES(13, 'Vendor', 'vendormaster', 'C', 3, 'vendormaster');
INSERT INTO `menu` (`id`, `menu_name`, `menu_link`, `is_parent`, `parent_id`, `menu_code`) VALUES(14, 'Purchase Invoice', 'purchaseinvoice', 'C', 27, 'purchaseinvoice');
INSERT INTO `menu` (`id`, `menu_name`, `menu_link`, `is_parent`, `parent_id`, `menu_code`) VALUES(15, 'Receiving DO', 'unreleaseddo', 'C', 27, 'unreleaseddo');
INSERT INTO `menu` (`id`, `menu_name`, `menu_link`, `is_parent`, `parent_id`, `menu_code`) VALUES(16, 'Accounts', 'acconuts', 'SC', 3, '');
INSERT INTO `menu` (`id`, `menu_name`, `menu_link`, `is_parent`, `parent_id`, `menu_code`) VALUES(17, 'CST', 'cstmaster', 'C', 16, 'cstmaster');
INSERT INTO `menu` (`id`, `menu_name`, `menu_link`, `is_parent`, `parent_id`, `menu_code`) VALUES(18, 'Customer', 'customermaster', 'C', 3, 'customermaster');
INSERT INTO `menu` (`id`, `menu_name`, `menu_link`, `is_parent`, `parent_id`, `menu_code`) VALUES(19, 'Transport', 'transportmaster', 'C', 3, 'transportmaster');
INSERT INTO `menu` (`id`, `menu_name`, `menu_link`, `is_parent`, `parent_id`, `menu_code`) VALUES(20, 'Tea Group', 'teagroupmaster', 'C', 3, 'teagroupmaster');
INSERT INTO `menu` (`id`, `menu_name`, `menu_link`, `is_parent`, `parent_id`, `menu_code`) VALUES(24, 'Send Do to Transporter', 'deliveryordertotransp', 'C', 27, 'deliveryordertotransp');
INSERT INTO `menu` (`id`, `menu_name`, `menu_link`, `is_parent`, `parent_id`, `menu_code`) VALUES(25, 'Transporter to Buyer', 'doproductrecv', 'C', 27, 'doproductrecv');
INSERT INTO `menu` (`id`, `menu_name`, `menu_link`, `is_parent`, `parent_id`, `menu_code`) VALUES(26, 'Location', 'locationmaster', 'C', 3, 'locationmaster');
INSERT INTO `menu` (`id`, `menu_name`, `menu_link`, `is_parent`, `parent_id`, `menu_code`) VALUES(27, 'Transaction', NULL, 'P', NULL, NULL);
INSERT INTO `menu` (`id`, `menu_name`, `menu_link`, `is_parent`, `parent_id`, `menu_code`) VALUES(28, 'Stock Summary', 'stocksummery', 'C', 31, 'stocksummery');
INSERT INTO `menu` (`id`, `menu_name`, `menu_link`, `is_parent`, `parent_id`, `menu_code`) VALUES(29, 'Packet', 'packet', 'C', 3, 'packet');
INSERT INTO `menu` (`id`, `menu_name`, `menu_link`, `is_parent`, `parent_id`, `menu_code`) VALUES(30, 'product Creation', 'product', 'C', 3, 'product');
INSERT INTO `menu` (`id`, `menu_name`, `menu_link`, `is_parent`, `parent_id`, `menu_code`) VALUES(31, 'Report', NULL, 'P', NULL, NULL);
INSERT INTO `menu` (`id`, `menu_name`, `menu_link`, `is_parent`, `parent_id`, `menu_code`) VALUES(32, 'Auction Area', 'auctionarea', 'C', 3, 'auctionarea');
INSERT INTO `menu` (`id`, `menu_name`, `menu_link`, `is_parent`, `parent_id`, `menu_code`) VALUES(33, 'Short Adjustment', 'shortageadjustment', 'C', 27, 'shortageadjustment');
INSERT INTO `menu` (`id`, `menu_name`, `menu_link`, `is_parent`, `parent_id`, `menu_code`) VALUES(34, 'Blending', 'blending', 'C', 27, 'blending');
INSERT INTO `menu` (`id`, `menu_name`, `menu_link`, `is_parent`, `parent_id`, `menu_code`) VALUES(35, 'Finish Product', 'finishproduct', 'C', 27, 'finishproduct');
INSERT INTO `menu` (`id`, `menu_name`, `menu_link`, `is_parent`, `parent_id`, `menu_code`) VALUES(36, 'Tax Invoice', 'taxinvoice', 'C', 27, 'taxinvoice');
INSERT INTO `menu` (`id`, `menu_name`, `menu_link`, `is_parent`, `parent_id`, `menu_code`) VALUES(37, 'Product Rate & Net', 'productpacketrate', 'C', 3, 'productpacketrate');
INSERT INTO `menu` (`id`, `menu_name`, `menu_link`, `is_parent`, `parent_id`, `menu_code`) VALUES(38, 'Company', 'companymaster', 'C', 3, 'companymaster');
INSERT INTO `menu` (`id`, `menu_name`, `menu_link`, `is_parent`, `parent_id`, `menu_code`) VALUES(39, 'Purchase Register', 'purchaseregister', 'C', 31, 'purchaseregister');
INSERT INTO `menu` (`id`, `menu_name`, `menu_link`, `is_parent`, `parent_id`, `menu_code`) VALUES(40, 'Stock with Transporter', 'stockwithtransporter', 'C', 31, 'stockwithregister');

-- --------------------------------------------------------

--
-- Table structure for table `packet`
--

CREATE TABLE IF NOT EXISTS `packet` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `packet` varchar(255) DEFAULT NULL,
  `PacketQty` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `packet`
--

INSERT INTO `packet` (`id`, `packet`, `PacketQty`) VALUES(1, 'Packet 250 gm', 0.25);
INSERT INTO `packet` (`id`, `packet`, `PacketQty`) VALUES(2, 'Jar 2.5 Kg ', 2.5);
INSERT INTO `packet` (`id`, `packet`, `PacketQty`) VALUES(3, 'Packet 1 Kg', 1);
INSERT INTO `packet` (`id`, `packet`, `PacketQty`) VALUES(4, 'Packet 50gm', 0.05);
INSERT INTO `packet` (`id`, `packet`, `PacketQty`) VALUES(6, 'Packet 100 gm  ', 0.01);
INSERT INTO `packet` (`id`, `packet`, `PacketQty`) VALUES(7, 'Jar 250gm', 0.25);
INSERT INTO `packet` (`id`, `packet`, `PacketQty`) VALUES(8, 'Packet Rs 5', 0.2);
INSERT INTO `packet` (`id`, `packet`, `PacketQty`) VALUES(9, 'Jar 1.00 kg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `product` varchar(255) NOT NULL,
  `productdesc` varchar(255) DEFAULT NULL,
  `is_active` enum('Y','N') DEFAULT 'Y',
  `insertiondate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `product`, `productdesc`, `is_active`, `insertiondate`) VALUES(2, 'Samrat Gold ', 'Samrat Gold ', 'Y', '2015-06-10 11:33:02');
INSERT INTO `product` (`id`, `product`, `productdesc`, `is_active`, `insertiondate`) VALUES(4, 'Samrat Green  ', '  Samrat Green ', 'Y', '2015-12-23 09:33:03');
INSERT INTO `product` (`id`, `product`, `productdesc`, `is_active`, `insertiondate`) VALUES(5, 'Samrat Gold Red Pouch ', '  Samrat Red Pouch    ', 'Y', '2015-12-23 11:10:04');
INSERT INTO `product` (`id`, `product`, `productdesc`, `is_active`, `insertiondate`) VALUES(6, 'Kohinoor ', 'Kohinoor Pouch/ Jar ', 'Y', '2015-12-23 09:35:29');
INSERT INTO `product` (`id`, `product`, `productdesc`, `is_active`, `insertiondate`) VALUES(7, 'Gram Bangla ', 'Gram Bangla Pouch/ Jar  ', 'Y', '2015-12-23 09:35:39');
INSERT INTO `product` (`id`, `product`, `productdesc`, `is_active`, `insertiondate`) VALUES(8, 'Samrat Gold 2.5 Jar', 'Samrat 2.5 Kg Jar  ', 'Y', '2016-01-09 07:15:59');

-- --------------------------------------------------------

--
-- Table structure for table `product_packet`
--

CREATE TABLE IF NOT EXISTS `product_packet` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `productid` int(20) DEFAULT NULL,
  `packetid` int(20) DEFAULT NULL,
  `sale_rate` decimal(10,2) DEFAULT NULL,
  `net_kgs` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `indx_prduct` (`productid`),
  KEY `indx_pckt` (`packetid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=64 ;

--
-- Dumping data for table `product_packet`
--

INSERT INTO `product_packet` (`id`, `productid`, `packetid`, `sale_rate`, `net_kgs`) VALUES(6, 2, 1, '125.00', NULL);
INSERT INTO `product_packet` (`id`, `productid`, `packetid`, `sale_rate`, `net_kgs`) VALUES(7, 2, 4, NULL, NULL);
INSERT INTO `product_packet` (`id`, `productid`, `packetid`, `sale_rate`, `net_kgs`) VALUES(8, 2, 6, NULL, NULL);
INSERT INTO `product_packet` (`id`, `productid`, `packetid`, `sale_rate`, `net_kgs`) VALUES(40, 4, 4, NULL, NULL);
INSERT INTO `product_packet` (`id`, `productid`, `packetid`, `sale_rate`, `net_kgs`) VALUES(41, 4, 6, NULL, NULL);
INSERT INTO `product_packet` (`id`, `productid`, `packetid`, `sale_rate`, `net_kgs`) VALUES(42, 4, 8, NULL, NULL);
INSERT INTO `product_packet` (`id`, `productid`, `packetid`, `sale_rate`, `net_kgs`) VALUES(46, 6, 2, NULL, NULL);
INSERT INTO `product_packet` (`id`, `productid`, `packetid`, `sale_rate`, `net_kgs`) VALUES(47, 6, 3, NULL, NULL);
INSERT INTO `product_packet` (`id`, `productid`, `packetid`, `sale_rate`, `net_kgs`) VALUES(48, 6, 9, NULL, NULL);
INSERT INTO `product_packet` (`id`, `productid`, `packetid`, `sale_rate`, `net_kgs`) VALUES(49, 7, 2, NULL, NULL);
INSERT INTO `product_packet` (`id`, `productid`, `packetid`, `sale_rate`, `net_kgs`) VALUES(50, 7, 3, NULL, NULL);
INSERT INTO `product_packet` (`id`, `productid`, `packetid`, `sale_rate`, `net_kgs`) VALUES(51, 7, 9, NULL, NULL);
INSERT INTO `product_packet` (`id`, `productid`, `packetid`, `sale_rate`, `net_kgs`) VALUES(57, 5, 1, NULL, NULL);
INSERT INTO `product_packet` (`id`, `productid`, `packetid`, `sale_rate`, `net_kgs`) VALUES(58, 5, 4, NULL, NULL);
INSERT INTO `product_packet` (`id`, `productid`, `packetid`, `sale_rate`, `net_kgs`) VALUES(59, 5, 6, NULL, NULL);
INSERT INTO `product_packet` (`id`, `productid`, `packetid`, `sale_rate`, `net_kgs`) VALUES(60, 5, 7, NULL, NULL);
INSERT INTO `product_packet` (`id`, `productid`, `packetid`, `sale_rate`, `net_kgs`) VALUES(61, 5, 9, NULL, NULL);
INSERT INTO `product_packet` (`id`, `productid`, `packetid`, `sale_rate`, `net_kgs`) VALUES(62, 8, 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_bag_details`
--

CREATE TABLE IF NOT EXISTS `purchase_bag_details` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `purchasedtlid` int(20) DEFAULT NULL,
  `bagtypeid` int(20) DEFAULT NULL,
  `no_of_bags` int(20) DEFAULT NULL,
  `net` double(10,2) DEFAULT NULL,
  `shortkg` double(10,2) DEFAULT NULL,
  `parent_bag_id` int(20) DEFAULT NULL,
  `actual_bags` int(20) DEFAULT NULL,
  `chestSerial` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_purchase_dtlId` (`purchasedtlid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1028 ;

--
-- Dumping data for table `purchase_bag_details`
--

INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(74, 230, 1, 3, 28.00, NULL, NULL, 3, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(75, 230, 2, 2, 21.00, NULL, NULL, 2, NULL);
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(81, 237, 1, 10, 36.00, NULL, NULL, 10, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(82, 238, 1, 9, 34.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(83, 238, 2, 1, 27.00, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(84, 239, 1, 10, 39.00, NULL, NULL, 10, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(85, 240, 1, 15, 40.00, NULL, NULL, 15, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(94, 241, 1, 14, 38.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(95, 241, 2, 1, 29.40, NULL, NULL, 1, NULL);
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(106, 244, 1, 9, 36.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(107, 244, 2, 1, 29.00, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(108, 245, 1, 14, 39.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(109, 245, 2, 1, 32.00, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(110, 246, 1, 14, 40.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(111, 246, 1, 1, 33.00, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(113, 248, 1, 13, 40.00, NULL, NULL, 13, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(114, 249, 1, 9, 41.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(115, 249, 1, 1, 34.00, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(122, 227, 1, 8, 31.00, NULL, NULL, 7, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(123, 227, 2, 1, 24.00, NULL, NULL, 1, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(124, 247, 1, 25, 40.00, NULL, NULL, 25, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(146, 251, 1, 10, 30.00, NULL, NULL, 10, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(147, 251, 2, 1, 28.00, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(148, 252, 1, 9, 19.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(149, 252, 2, 3, 15.40, NULL, NULL, 3, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(150, 253, 1, 9, 22.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(151, 253, 2, 2, 18.40, NULL, NULL, 2, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(152, 254, 1, 11, 22.00, NULL, NULL, 11, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(153, 254, 2, 2, 18.40, NULL, NULL, 2, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(154, 255, 1, 10, 36.00, NULL, NULL, 10, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(155, 256, 1, 10, 36.00, NULL, NULL, 10, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(156, 257, 1, 20, 33.00, NULL, NULL, 20, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(159, 258, 1, 13, 33.00, NULL, NULL, 13, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(160, 258, 2, 1, 26.00, NULL, NULL, 1, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(161, 259, 1, 14, 35.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(162, 259, 2, 1, 28.00, NULL, NULL, 1, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(163, 260, 1, 14, 35.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(164, 260, 2, 1, 28.00, NULL, NULL, 1, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(166, 262, 1, 14, 33.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(167, 262, 2, 1, 28.80, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(168, 263, 1, 20, 38.00, NULL, NULL, 20, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(169, 264, 1, 14, 38.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(170, 261, 1, 20, 27.00, NULL, NULL, 20, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(173, 265, 1, 11, 35.00, NULL, NULL, 11, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(174, 265, 2, 1, 26.40, NULL, NULL, 1, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(176, 267, 1, 15, 38.00, NULL, NULL, 15, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(177, 268, 1, 9, 38.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(178, 268, 2, 1, 32.30, NULL, NULL, 1, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(179, 269, 1, 10, 35.00, NULL, NULL, 10, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(180, 270, 1, 11, 35.00, NULL, NULL, 11, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(181, 270, 2, 1, 26.40, NULL, NULL, 1, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(190, 275, 1, 15, 32.00, NULL, NULL, 15, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(198, 271, 1, 14, 38.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(199, 271, 2, 1, 29.40, NULL, NULL, 1, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(200, 272, 1, 15, 38.00, NULL, NULL, 15, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(201, 273, 1, 15, 38.00, NULL, NULL, 15, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(204, 274, 1, 19, 37.00, NULL, NULL, 19, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(205, 274, 2, 1, 28.40, NULL, NULL, 1, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(206, 276, 1, 15, 35.00, NULL, NULL, 15, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(207, 277, 1, 9, 35.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(208, 277, 2, 1, 26.40, NULL, NULL, 1, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(209, 278, 1, 15, 35.00, NULL, NULL, 15, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(210, 279, 1, 10, 34.00, NULL, NULL, 10, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(211, 266, 1, 15, 38.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(214, 281, 1, 20, 26.00, NULL, NULL, 20, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(215, 282, 1, 14, 30.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(216, 282, 2, 1, 21.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(221, 283, 1, 14, 35.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(222, 283, 2, 1, 29.30, NULL, NULL, 1, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(223, 284, 1, 14, 36.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(224, 284, 2, 1, 26.40, NULL, NULL, 1, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(225, 285, 1, 14, 38.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(226, 285, 2, 1, 29.40, NULL, NULL, 1, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(227, 286, 1, 15, 38.00, NULL, NULL, 15, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(228, 287, 1, 14, 38.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(229, 287, 2, 1, 29.40, NULL, NULL, 1, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(230, 288, 1, 14, 38.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(231, 288, 2, 1, 29.40, NULL, NULL, 1, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(232, 289, 1, 12, 38.00, NULL, NULL, 12, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(233, 280, 1, 14, 26.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(234, 280, 2, 1, 17.40, NULL, NULL, 1, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(237, 291, 1, 9, 37.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(238, 291, 2, 1, 28.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(239, 292, 1, 9, 37.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(240, 292, 2, 1, 28.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(243, 294, 1, 10, 38.00, NULL, NULL, 10, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(244, 295, 1, 9, 38.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(245, 295, 2, 1, 29.40, NULL, NULL, 1, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(246, 296, 1, 14, 33.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(247, 296, 2, 1, 24.40, NULL, NULL, 1, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(248, 297, 1, 8, 35.00, NULL, NULL, 8, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(249, 297, 2, 2, 26.40, NULL, NULL, 2, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(250, 298, 1, 13, 26.00, NULL, NULL, 13, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(251, 298, 2, 2, 17.40, NULL, NULL, 2, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(252, 299, 1, 9, 35.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(253, 299, 2, 1, 26.40, NULL, NULL, 1, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(254, 300, 1, 14, 26.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(255, 300, 2, 1, 17.40, NULL, NULL, 1, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(260, 290, 1, 9, 38.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(261, 290, 2, 1, 29.40, NULL, NULL, 1, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(262, 301, 1, 29, 35.00, NULL, NULL, 29, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(263, 301, 2, 1, 26.40, NULL, NULL, 1, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(264, 302, 1, 9, 35.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(265, 302, 2, 1, 26.40, NULL, NULL, 1, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(266, 303, 1, 8, 35.00, NULL, NULL, 8, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(267, 303, 2, 2, 26.40, NULL, NULL, 2, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(268, 304, 1, 14, 38.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(269, 304, 2, 1, 29.40, NULL, NULL, 1, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(271, 306, 1, 15, 38.00, NULL, NULL, 15, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(272, 307, 1, 15, 38.00, NULL, NULL, 15, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(273, 308, 1, 14, 38.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(274, 308, 2, 1, 29.40, NULL, NULL, 1, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(275, 309, 1, 10, 38.00, NULL, NULL, 10, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(276, 310, 1, 24, 38.00, NULL, NULL, 24, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(277, 310, 2, 1, 29.40, NULL, NULL, 1, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(278, 293, 1, 9, 38.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(279, 293, 2, 1, 29.40, NULL, NULL, 1, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(280, 305, 1, 15, 38.00, NULL, NULL, 15, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(281, 311, 1, 29, 38.00, NULL, NULL, 29, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(282, 311, 2, 1, 29.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(283, 312, 1, 9, 38.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(284, 312, 2, 1, 29.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(285, 313, 1, 9, 38.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(286, 313, 2, 1, 29.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(287, 314, 1, 9, 38.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(288, 314, 2, 1, 29.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(289, 315, 1, 9, 38.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(290, 315, 2, 1, 29.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(291, 316, 1, 20, 26.00, NULL, NULL, 20, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(292, 317, 1, 15, 35.00, NULL, NULL, 15, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(293, 318, 1, 10, 35.00, NULL, NULL, 10, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(294, 319, 1, 10, 26.00, NULL, NULL, 10, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(295, 320, 1, 9, 35.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(296, 320, 2, 1, 26.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(297, 321, 1, 15, 35.00, NULL, NULL, 15, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(298, 322, 1, 9, 35.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(299, 322, 2, 1, 26.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(300, 323, 1, 19, 35.00, NULL, NULL, 19, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(301, 323, 2, 1, 26.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(302, 324, 1, 13, 35.00, NULL, NULL, 13, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(303, 324, 2, 1, 26.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(304, 325, 1, 9, 38.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(305, 325, 2, 1, 29.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(306, 326, 1, 11, 38.00, NULL, NULL, 11, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(307, 326, 2, 1, 29.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(308, 327, 1, 15, 38.00, NULL, NULL, 15, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(309, 328, 1, 15, 38.00, NULL, NULL, 15, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(310, 329, 1, 24, 38.00, NULL, NULL, 24, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(311, 329, 2, 1, 29.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(312, 330, 1, 8, 35.00, NULL, NULL, 8, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(313, 330, 2, 2, 26.40, NULL, NULL, 2, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(314, 331, 1, 11, 35.00, NULL, NULL, 11, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(315, 331, 2, 1, 26.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(316, 332, 1, 9, 35.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(317, 332, 2, 1, 26.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(318, 333, 1, 9, 35.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(319, 333, 2, 1, 26.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(320, 334, 1, 15, 36.00, NULL, NULL, 15, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(321, 335, 1, 9, 26.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(322, 335, 2, 1, 17.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(323, 336, 1, 9, 35.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(324, 336, 2, 1, 26.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(325, 337, 1, 8, 35.00, NULL, NULL, 8, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(326, 337, 2, 2, 26.40, NULL, NULL, 2, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(327, 338, 1, 20, 26.00, NULL, NULL, 20, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(328, 339, 1, 14, 33.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(329, 339, 2, 1, 24.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(330, 340, 1, 14, 38.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(331, 340, 2, 1, 29.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(332, 341, 1, 15, 38.00, NULL, NULL, 15, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(333, 342, 1, 15, 38.00, NULL, NULL, 15, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(334, 343, 1, 11, 28.00, NULL, NULL, 11, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(335, 343, 2, 1, 25.00, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(340, 344, 1, 14, 32.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(341, 344, 2, 1, 25.00, NULL, NULL, 1, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(342, 345, 1, 4, 33.00, NULL, NULL, 4, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(343, 345, 2, 1, 26.00, NULL, NULL, 1, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(344, 346, 1, 26, 26.00, NULL, NULL, 26, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(345, 347, 1, 15, 36.00, NULL, NULL, 15, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(346, 348, 1, 8, 38.00, NULL, NULL, 8, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(347, 348, 2, 2, 31.00, NULL, NULL, 2, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(348, 349, 1, 15, 38.00, NULL, NULL, 15, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(349, 350, 1, 20, 38.00, NULL, NULL, 20, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(350, 351, 1, 20, 38.00, NULL, NULL, 20, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(351, 352, 1, 15, 38.00, NULL, NULL, 15, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(352, 353, 1, 10, 35.00, NULL, NULL, 10, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(353, 354, 1, 10, 35.00, NULL, NULL, 10, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(355, 356, 1, 18, 29.00, NULL, NULL, 18, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(356, 356, 2, 1, 22.00, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(357, 356, 2, 1, 20.60, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(358, 357, 1, 9, 36.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(359, 357, 2, 1, 29.00, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(362, 358, 1, 9, 40.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(363, 358, 2, 1, 33.00, NULL, NULL, 1, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(364, 359, 1, 20, 39.95, NULL, NULL, 20, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(365, 360, 1, 14, 42.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(366, 360, 2, 1, 35.00, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(367, 361, 1, 14, 42.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(368, 361, 2, 1, 35.00, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(369, 362, 1, 14, 42.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(370, 362, 2, 1, 35.00, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(371, 363, 1, 14, 42.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(372, 363, 2, 1, 35.00, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(373, 364, 1, 20, 42.00, NULL, NULL, 20, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(374, 365, 1, 14, 41.95, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(375, 365, 2, 1, 34.95, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(376, 366, 1, 30, 32.00, NULL, NULL, 30, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(377, 367, 1, 30, 32.00, NULL, NULL, 30, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(378, 368, 1, 72, 40.00, NULL, NULL, 72, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(381, 355, 1, 20, 38.00, NULL, NULL, 20, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(386, 371, 1, 9, 37.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(387, 371, 2, 1, 30.00, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(388, 372, 1, 9, 37.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(389, 372, 2, 1, 30.00, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(390, 373, 1, 9, 38.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(391, 373, 2, 1, 31.00, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(392, 374, 1, 14, 40.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(393, 374, 2, 1, 33.00, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(394, 375, 1, 9, 40.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(395, 375, 2, 1, 33.00, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(396, 376, 1, 19, 40.00, NULL, NULL, 19, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(397, 376, 2, 1, 33.00, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(402, 379, 1, 19, 40.00, NULL, NULL, 19, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(403, 379, 2, 1, 33.00, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(404, 369, 1, 9, 37.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(405, 369, 2, 1, 30.00, NULL, NULL, 1, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(406, 370, 1, 9, 37.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(407, 370, 2, 1, 30.00, NULL, NULL, 1, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(408, 377, 1, 19, 40.00, NULL, NULL, 19, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(409, 377, 2, 1, 33.00, NULL, NULL, 1, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(410, 378, 1, 19, 40.00, NULL, NULL, 19, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(411, 378, 2, 1, 33.00, NULL, NULL, 1, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(412, 380, 1, 14, 40.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(413, 380, 2, 1, 33.00, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(414, 381, 1, 29, 40.00, NULL, NULL, 29, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(415, 381, 2, 1, 33.00, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(416, 382, 1, 14, 40.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(417, 382, 2, 1, 33.00, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(418, 383, 1, 14, 40.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(419, 383, 2, 1, 33.00, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(420, 384, 1, 14, 40.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(421, 384, 2, 1, 33.00, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(422, 385, 1, 15, 35.00, NULL, NULL, 15, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(423, 386, 1, 15, 32.00, NULL, NULL, 15, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(426, 388, 1, 9, 38.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(427, 388, 2, 1, 31.00, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(428, 389, 1, 19, 35.00, NULL, NULL, 19, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(429, 389, 2, 1, 28.00, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(430, 390, 1, 20, 35.00, NULL, NULL, 20, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(431, 391, 1, 19, 35.00, NULL, NULL, 19, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(432, 391, 2, 1, 28.00, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(433, 392, 1, 9, 35.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(434, 392, 2, 1, 28.00, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(435, 393, 1, 20, 35.00, NULL, NULL, 20, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(436, 387, 1, 14, 34.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(437, 387, 2, 1, 27.00, NULL, NULL, 1, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(438, 395, 1, 9, 38.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(441, 395, 2, 1, 32.30, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(444, 397, 1, 9, 38.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(445, 397, 2, 1, 32.30, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(449, 400, 1, 10, 38.00, NULL, NULL, 10, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(451, 402, 1, 9, 38.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(453, 402, 2, 1, 29.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(455, 404, 1, 14, 35.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(457, 404, 2, 1, 26.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(459, 406, 1, 9, 35.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(460, 406, 2, 1, 26.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(463, 408, 1, 15, 35.00, NULL, NULL, 15, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(465, 410, 1, 14, 35.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(467, 410, 2, 1, 26.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(469, 412, 1, 9, 35.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(471, 412, 2, 1, 26.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(472, 413, 1, 9, 35.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(473, 413, 2, 1, 26.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(474, 414, 1, 14, 26.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(475, 414, 2, 1, 17.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(476, 415, 1, 20, 26.00, NULL, NULL, 20, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(477, 416, 1, 10, 26.00, NULL, NULL, 10, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(478, 416, 2, 1, 17.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(479, 417, 1, 14, 26.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(480, 417, 2, 1, 17.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(483, 419, 1, 15, 26.00, NULL, NULL, 15, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(484, 420, 1, 17, 26.00, NULL, NULL, 17, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(485, 420, 2, 3, 17.40, NULL, NULL, 3, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(501, 431, 1, 9, 38.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(502, 431, 2, 1, 29.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(503, 432, 1, 15, 38.00, NULL, NULL, 15, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(504, 433, 1, 14, 38.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(505, 433, 2, 1, 29.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(506, 434, 1, 14, 38.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(507, 434, 2, 1, 29.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(508, 435, 1, 15, 38.00, NULL, NULL, 15, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(509, 436, 1, 14, 38.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(510, 436, 2, 1, 29.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(511, 437, 1, 20, 38.00, NULL, NULL, 20, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(512, 438, 1, 16, 26.00, NULL, NULL, 16, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(513, 438, 2, 1, 17.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(514, 439, 1, 15, 35.00, NULL, NULL, 15, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(515, 440, 1, 15, 35.00, NULL, NULL, 15, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(516, 441, 1, 11, 35.00, NULL, NULL, 11, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(517, 441, 2, 1, 26.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(518, 442, 1, 14, 26.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(519, 442, 2, 1, 17.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(520, 443, 1, 15, 38.00, NULL, NULL, 15, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(521, 444, 1, 9, 35.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(522, 444, 2, 1, 26.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(523, 445, 1, 13, 35.00, NULL, NULL, 13, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(524, 446, 1, 14, 30.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(525, 446, 2, 1, 21.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(526, 447, 1, 14, 30.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(527, 447, 2, 1, 21.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(528, 448, 1, 14, 35.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(529, 448, 2, 1, 26.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(530, 449, 1, 14, 35.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(531, 449, 2, 1, 26.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(532, 450, 1, 8, 35.00, NULL, NULL, 8, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(533, 450, 2, 2, 26.40, NULL, NULL, 2, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(534, 451, 1, 8, 32.00, NULL, NULL, 8, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(535, 451, 2, 2, 23.40, NULL, NULL, 2, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(537, 453, 1, 9, 35.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(538, 453, 2, 1, 26.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(539, 454, 1, 14, 26.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(540, 454, 2, 1, 17.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(541, 455, 1, 15, 30.00, NULL, NULL, 15, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(542, 456, 1, 14, 26.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(543, 456, 2, 1, 17.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(544, 457, 1, 14, 35.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(545, 457, 2, 1, 29.30, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(546, 458, 1, 14, 35.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(547, 458, 2, 1, 29.30, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(548, 459, 1, 16, 35.00, NULL, NULL, 16, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(549, 459, 2, 1, 26.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(550, 460, 1, 16, 35.00, NULL, NULL, 16, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(551, 460, 2, 1, 26.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(552, 461, 1, 14, 38.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(553, 461, 2, 1, 29.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(554, 462, 1, 15, 38.00, NULL, NULL, 15, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(555, 463, 1, 11, 35.00, NULL, NULL, 11, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(556, 463, 2, 1, 26.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(557, 464, 1, 14, 35.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(558, 464, 2, 1, 26.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(559, 465, 1, 10, 35.00, NULL, NULL, 10, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(560, 465, 2, 1, 26.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(561, 466, 1, 14, 27.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(562, 466, 2, 1, 22.90, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(563, 467, 1, 14, 27.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(564, 467, 2, 1, 22.90, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(565, 468, 1, 14, 27.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(566, 468, 2, 1, 22.90, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(567, 469, 1, 14, 27.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(568, 469, 2, 1, 22.90, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(569, 470, 1, 14, 27.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(570, 470, 2, 1, 22.90, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(571, 471, 1, 14, 27.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(572, 471, 2, 1, 22.90, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(573, 472, 1, 14, 38.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(574, 472, 2, 1, 29.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(575, 473, 1, 14, 38.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(576, 473, 2, 1, 29.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(577, 474, 1, 15, 38.00, NULL, NULL, 15, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(578, 475, 1, 14, 38.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(579, 475, 2, 1, 29.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(580, 476, 1, 9, 38.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(581, 476, 2, 1, 29.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(582, 477, 1, 25, 38.00, NULL, NULL, 25, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(583, 478, 1, 14, 38.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(584, 478, 2, 1, 29.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(585, 479, 1, 9, 38.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(586, 479, 2, 1, 29.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(587, 480, 1, 9, 35.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(588, 480, 2, 1, 26.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(589, 481, 1, 15, 38.00, NULL, NULL, 15, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(590, 482, 1, 15, 34.00, NULL, NULL, 15, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(591, 266, 3, 1, 33.00, 5.00, 211, 1, NULL);
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(594, 484, 1, 14, 38.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(595, 484, 2, 1, 29.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(596, 485, 1, 11, 38.00, NULL, NULL, 11, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(597, 485, 2, 1, 29.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(599, 487, 1, 15, 38.00, NULL, NULL, 15, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(600, 488, 1, 15, 38.00, NULL, NULL, 15, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(601, 489, 1, 15, 38.00, NULL, NULL, 15, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(602, 490, 1, 9, 38.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(603, 490, 2, 1, 29.40, NULL, NULL, 1, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(604, 491, 1, 32, 35.00, NULL, NULL, 32, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(605, 491, 2, 2, 26.40, NULL, NULL, 2, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(606, 492, 1, 15, 35.00, NULL, NULL, 15, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(607, 492, 2, 1, 26.40, NULL, NULL, 1, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(610, 494, 1, 9, 35.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(611, 494, 2, 1, 26.40, NULL, NULL, 1, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(612, 495, 1, 9, 35.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(613, 495, 2, 1, 26.40, NULL, NULL, 1, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(614, 496, 1, 9, 35.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(615, 496, 2, 1, 26.40, NULL, NULL, 1, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(618, 498, 1, 14, 26.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(619, 498, 2, 2, 17.40, NULL, NULL, 2, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(620, 499, 1, 9, 35.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(621, 499, 2, 1, 26.40, NULL, NULL, 1, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(624, 501, 1, 14, 30.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(625, 501, 2, 1, 21.40, NULL, NULL, 1, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(626, 500, 1, 0, 0.00, NULL, NULL, 0, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(627, 486, 1, 15, 38.00, NULL, NULL, 15, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(628, 502, 1, 4, 38.00, NULL, NULL, 4, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(629, 502, 2, 1, 29.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(630, 503, 1, 20, 38.00, NULL, NULL, 20, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(631, 504, 1, 9, 38.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(632, 504, 2, 1, 29.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(633, 505, 1, 11, 38.00, NULL, NULL, 11, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(634, 505, 2, 1, 29.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(635, 506, 1, 15, 38.00, NULL, NULL, 15, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(636, 507, 1, 14, 35.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(637, 507, 2, 1, 26.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(638, 508, 1, 9, 35.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(639, 508, 2, 1, 26.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(640, 509, 1, 15, 34.00, NULL, NULL, 15, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(641, 510, 1, 11, 35.00, NULL, NULL, 11, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(642, 510, 2, 1, 26.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(643, 511, 1, 11, 35.00, NULL, NULL, 11, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(644, 511, 2, 1, 26.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(645, 512, 1, 11, 35.00, NULL, NULL, 11, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(646, 512, 2, 1, 26.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(647, 513, 1, 9, 38.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(648, 513, 2, 1, 29.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(670, 526, 1, 29, 38.00, NULL, NULL, 29, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(671, 526, 2, 1, 29.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(672, 527, 1, 14, 38.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(673, 527, 2, 1, 29.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(674, 528, 1, 13, 38.00, NULL, NULL, 13, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(675, 528, 2, 2, 29.40, NULL, NULL, 2, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(676, 529, 1, 13, 38.00, NULL, NULL, 13, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(677, 529, 2, 2, 29.40, NULL, NULL, 2, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(678, 530, 1, 13, 38.00, NULL, NULL, 13, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(679, 530, 2, 2, 29.40, NULL, NULL, 2, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(680, 531, 1, 13, 38.00, NULL, NULL, 13, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(681, 531, 2, 2, 29.40, NULL, NULL, 2, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(682, 532, 1, 13, 38.00, NULL, NULL, 13, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(683, 532, 2, 2, 29.40, NULL, NULL, 2, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(684, 533, 1, 14, 38.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(685, 533, 2, 1, 29.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(686, 534, 1, 15, 38.00, NULL, NULL, 15, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(687, 535, 1, 20, 38.00, NULL, NULL, 20, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(688, 536, 1, 15, 38.00, NULL, NULL, 15, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(689, 537, 1, 14, 38.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(690, 537, 2, 1, 29.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(691, 538, 1, 14, 26.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(692, 538, 2, 1, 17.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(693, 539, 1, 14, 26.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(694, 539, 2, 1, 17.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(695, 540, 1, 9, 26.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(696, 540, 2, 1, 17.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(697, 541, 1, 14, 30.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(698, 541, 2, 1, 21.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(699, 542, 1, 29, 30.00, NULL, NULL, 29, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(700, 542, 2, 1, 21.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(701, 543, 1, 14, 30.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(702, 543, 2, 1, 21.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(703, 544, 1, 15, 30.00, NULL, NULL, 15, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(704, 545, 1, 14, 30.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(705, 545, 2, 1, 21.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(708, 547, 1, 14, 35.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(709, 547, 2, 1, 29.30, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(710, 548, 1, 14, 35.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(711, 548, 2, 1, 29.30, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(712, 549, 1, 14, 35.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(713, 549, 2, 1, 29.30, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(714, 550, 1, 14, 35.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(715, 550, 2, 1, 29.30, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(716, 551, 1, 14, 35.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(717, 551, 2, 1, 26.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(718, 552, 1, 15, 35.00, NULL, NULL, 15, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(719, 553, 1, 10, 38.00, NULL, NULL, 10, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(720, 553, 2, 1, 29.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(721, 554, 1, 22, 38.00, NULL, NULL, 22, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(722, 554, 2, 1, 29.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(723, 555, 1, 9, 38.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(724, 555, 2, 1, 29.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(728, 422, 1, 0, 38.00, NULL, NULL, 0, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(729, 423, 1, 0, 0.00, NULL, NULL, 0, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(730, 424, 1, 0, 0.00, NULL, NULL, 0, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(731, 425, 1, 0, 0.00, NULL, NULL, 0, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(732, 426, 1, 0, 0.00, NULL, NULL, 0, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(733, 427, 1, 0, 0.00, NULL, NULL, 0, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(734, 428, 1, 0, 0.00, NULL, NULL, 0, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(736, 421, 1, 0, 0.00, NULL, NULL, 0, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(737, 429, 1, 0, 0.00, NULL, NULL, 0, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(738, 430, 1, 0, 0.00, NULL, NULL, 0, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(739, 452, 1, 15, 35.00, NULL, NULL, 15, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(740, 418, 1, 14, 26.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(741, 418, 2, 1, 17.40, NULL, NULL, 1, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(742, 514, 1, 0, 0.00, NULL, NULL, 0, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(743, 515, 1, 0, 0.00, NULL, NULL, 0, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(744, 516, 1, 0, 0.00, NULL, NULL, 0, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(745, 517, 1, 0, 0.00, NULL, NULL, 0, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(746, 518, 1, 0, 0.00, NULL, NULL, 0, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(747, 519, 1, 0, 0.00, NULL, NULL, 0, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(748, 520, 1, 0, 0.00, NULL, NULL, 0, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(749, 521, 1, 0, 0.00, NULL, NULL, 0, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(750, 522, 1, 0, 0.00, NULL, NULL, 0, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(751, 523, 1, 0, 0.00, NULL, NULL, 0, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(752, 524, 1, 0, 0.00, NULL, NULL, 0, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(753, 525, 1, 0, 0.00, NULL, NULL, 0, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(754, 557, 1, 15, 38.00, NULL, NULL, 15, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(755, 558, 1, 15, 38.00, NULL, NULL, 15, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(756, 559, 1, 15, 38.00, NULL, NULL, 15, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(757, 560, 1, 14, 38.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(758, 560, 2, 1, 29.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(759, 561, 1, 20, 38.00, NULL, NULL, 20, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(760, 562, 1, 15, 38.00, NULL, NULL, 15, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(761, 563, 1, 15, 38.00, NULL, NULL, 15, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(762, 564, 1, 10, 37.00, NULL, NULL, 10, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(763, 565, 1, 10, 37.00, NULL, NULL, 10, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(764, 566, 1, 19, 38.00, NULL, NULL, 19, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(765, 566, 2, 1, 29.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(766, 567, 1, 10, 35.00, NULL, NULL, 10, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(767, 568, 1, 15, 38.00, NULL, NULL, 15, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(768, 569, 1, 15, 38.00, NULL, NULL, 15, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(769, 570, 1, 15, 38.00, NULL, NULL, 15, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(770, 571, 1, 14, 38.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(771, 571, 2, 1, 29.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(772, 572, 1, 20, 38.00, NULL, NULL, 20, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(773, 573, 1, 15, 38.00, NULL, NULL, 15, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(774, 574, 1, 15, 38.00, NULL, NULL, 15, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(775, 575, 1, 10, 37.00, NULL, NULL, 10, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(776, 576, 1, 10, 37.00, NULL, NULL, 10, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(777, 577, 1, 19, 38.00, NULL, NULL, 19, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(778, 577, 2, 1, 29.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(779, 578, 1, 10, 35.00, NULL, NULL, 10, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(780, 394, 1, 0, 0.00, NULL, NULL, 0, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(781, 396, 1, 0, 0.00, NULL, NULL, 0, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(782, 579, 1, 14, 38.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(783, 579, 2, 1, 29.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(784, 580, 1, 8, 37.00, NULL, NULL, 8, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(785, 580, 2, 2, 28.40, NULL, NULL, 2, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(786, 581, 1, 9, 37.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(787, 581, 2, 1, 28.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(788, 582, 1, 9, 35.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(789, 582, 2, 1, 26.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(790, 583, 1, 9, 35.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(791, 583, 2, 2, 26.40, NULL, NULL, 2, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(792, 584, 1, 10, 35.00, NULL, NULL, 10, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(793, 584, 2, 1, 26.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(794, 585, 1, 12, 35.00, NULL, NULL, 12, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(795, 585, 2, 2, 26.40, NULL, NULL, 2, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(796, 586, 1, 8, 35.00, NULL, NULL, 8, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(797, 586, 2, 2, 26.40, NULL, NULL, 2, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(798, 587, 1, 9, 38.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(799, 587, 2, 1, 29.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(803, 590, 1, 14, 37.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(804, 590, 2, 1, 28.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(805, 591, 1, 9, 35.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(806, 591, 2, 1, 26.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(809, 593, 1, 19, 32.00, NULL, NULL, 19, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(810, 593, 2, 1, 23.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(811, 594, 1, 14, 32.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(812, 594, 2, 1, 23.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(813, 595, 1, 14, 32.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(814, 595, 2, 1, 23.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(815, 596, 1, 14, 33.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(816, 596, 2, 1, 24.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(817, 597, 1, 14, 35.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(818, 597, 2, 1, 26.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(819, 598, 1, 14, 34.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(820, 598, 2, 1, 25.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(821, 599, 1, 14, 34.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(822, 599, 2, 1, 25.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(824, 601, 1, 9, 34.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(825, 601, 2, 1, 25.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(826, 602, 1, 14, 38.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(827, 602, 2, 1, 29.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(828, 600, 1, 15, 34.00, NULL, NULL, 15, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(829, 592, 1, 11, 35.00, NULL, NULL, 11, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(830, 592, 2, 1, 26.40, NULL, NULL, 1, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(831, 588, 1, 19, 26.00, NULL, NULL, 19, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(832, 588, 2, 1, 17.40, NULL, NULL, 1, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(833, 589, 1, 20, 26.00, NULL, NULL, 20, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(834, 398, 1, 0, 0.00, NULL, NULL, 0, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(835, 399, 1, 0, 0.00, NULL, NULL, 0, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(836, 401, 1, 0, 0.00, NULL, NULL, 0, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(837, 403, 1, 0, 0.00, NULL, NULL, 0, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(838, 405, 1, 0, 0.00, NULL, NULL, 0, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(839, 407, 1, 0, 0.00, NULL, NULL, 0, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(840, 409, 1, 0, 0.00, NULL, NULL, 0, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(841, 411, 1, 0, 0.00, NULL, NULL, 0, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(842, 603, 1, 10, 37.00, NULL, NULL, 10, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(843, 604, 1, 10, 37.00, NULL, NULL, 10, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(844, 605, 1, 9, 35.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(845, 605, 2, 1, 28.00, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(846, 606, 1, 9, 35.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(847, 606, 2, 1, 28.00, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(848, 607, 1, 30, 38.00, NULL, NULL, 30, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(849, 608, 1, 30, 38.00, NULL, NULL, 30, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(850, 609, 1, 14, 38.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(851, 609, 2, 1, 31.00, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(852, 610, 1, 14, 38.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(853, 610, 2, 1, 31.00, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(854, 611, 1, 14, 38.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(855, 611, 2, 1, 31.00, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(856, 612, 1, 14, 38.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(857, 612, 2, 1, 31.00, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(858, 613, 1, 14, 25.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(859, 613, 2, 1, 20.80, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(860, 614, 1, 9, 26.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(861, 614, 2, 1, 19.00, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(862, 615, 1, 4, 36.00, NULL, NULL, 4, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(863, 615, 2, 1, 29.00, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(864, 616, 1, 10, 35.00, NULL, NULL, 10, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(865, 617, 1, 14, 40.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(866, 617, 2, 1, 26.00, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(867, 618, 1, 14, 40.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(868, 618, 2, 1, 33.00, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(869, 619, 1, 14, 35.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(870, 619, 2, 1, 28.00, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(871, 620, 1, 14, 32.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(872, 620, 2, 1, 25.00, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(873, 621, 1, 14, 35.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(874, 621, 2, 1, 28.00, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(875, 622, 1, 15, 35.00, NULL, NULL, 15, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(876, 623, 1, 39, 40.00, NULL, NULL, 39, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(877, 623, 2, 1, 33.00, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(878, 624, 1, 14, 30.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(879, 624, 2, 1, 23.00, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(880, 625, 1, 14, 38.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(881, 625, 2, 1, 31.00, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(882, 626, 1, 10, 37.00, NULL, NULL, 10, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(883, 627, 1, 10, 37.00, NULL, NULL, 10, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(884, 628, 1, 10, 37.00, NULL, NULL, 10, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(885, 629, 1, 10, 37.00, NULL, NULL, 10, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(886, 630, 1, 20, 42.00, NULL, NULL, 20, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(887, 631, 1, 15, 42.00, NULL, NULL, 15, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(888, 632, 1, 14, 42.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(889, 632, 2, 1, 35.00, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(890, 633, 1, 15, 42.00, NULL, NULL, 15, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(895, 636, 1, 12, 32.00, NULL, NULL, 12, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(896, 636, 2, 1, 28.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(901, 638, 1, 16, 33.00, NULL, NULL, 16, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(902, 638, 2, 1, 26.00, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(903, 639, 1, 9, 38.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(904, 639, 2, 1, 31.00, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(905, 640, 1, 15, 35.00, NULL, NULL, 15, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(906, 641, 1, 9, 35.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(907, 641, 2, 1, 30.80, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(908, 642, 1, 9, 35.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(909, 642, 2, 1, 28.00, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(910, 643, 1, 10, 35.00, NULL, NULL, 10, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(911, 644, 1, 10, 35.00, NULL, NULL, 10, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(912, 645, 1, 16, 33.00, NULL, NULL, 16, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(913, 645, 2, 1, 26.00, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(914, 646, 1, 9, 38.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(915, 646, 2, 1, 31.00, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(916, 647, 1, 15, 35.00, NULL, NULL, 15, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(917, 648, 1, 9, 35.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(918, 648, 2, 1, 30.80, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(919, 649, 1, 9, 35.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(920, 649, 2, 1, 28.00, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(921, 650, 1, 10, 35.00, NULL, NULL, 10, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(922, 651, 1, 10, 35.00, NULL, NULL, 10, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(923, 634, 1, 10, 21.00, NULL, NULL, 10, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(924, 634, 2, 1, 17.40, NULL, NULL, 1, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(925, 635, 1, 12, 27.00, NULL, NULL, 12, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(926, 635, 2, 1, 23.40, NULL, NULL, 1, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(927, 637, 1, 14, 26.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(928, 637, 2, 1, 22.40, NULL, NULL, 1, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(929, 652, 1, 15, 35.00, NULL, NULL, 15, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(930, 653, 1, 9, 35.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(931, 653, 2, 1, 30.80, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(932, 654, 1, 14, 27.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(933, 654, 2, 1, 22.90, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(934, 655, 1, 25, 32.00, NULL, NULL, 25, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(935, 656, 1, 20, 32.00, NULL, NULL, 20, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(936, 657, 1, 15, 30.00, NULL, NULL, 15, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(937, 658, 1, 14, 35.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(938, 658, 2, 1, 26.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(939, 659, 1, 10, 35.00, NULL, NULL, 10, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(940, 659, 2, 1, 26.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(941, 660, 1, 4, 38.00, NULL, NULL, 4, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(942, 660, 2, 1, 29.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(943, 661, 1, 14, 38.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(944, 661, 2, 1, 29.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(945, 662, 1, 14, 38.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(946, 662, 2, 1, 29.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(947, 546, 1, 14, 26.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(948, 546, 2, 1, 17.40, NULL, NULL, 1, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(949, 556, 1, 16, 26.00, NULL, NULL, 16, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(950, 556, 2, 1, 17.40, NULL, NULL, 1, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(951, 663, 1, 20, 26.00, NULL, NULL, 20, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(952, 664, 1, 20, 26.00, NULL, NULL, 20, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(953, 483, 1, 11, 38.00, NULL, NULL, 11, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(954, 483, 2, 1, 29.40, NULL, NULL, 1, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(955, 493, 1, 9, 26.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(956, 493, 2, 3, 17.40, NULL, NULL, 3, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(957, 497, 1, 10, 26.00, NULL, NULL, 10, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(958, 497, 2, 2, 17.40, NULL, NULL, 2, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(959, 665, 1, 14, 38.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(960, 665, 2, 1, 29.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(961, 666, 1, 10, 35.00, NULL, NULL, 10, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(962, 667, 1, 9, 35.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(963, 667, 2, 1, 26.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(964, 668, 1, 16, 26.00, NULL, NULL, 16, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(965, 668, 2, 1, 17.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(974, 673, 1, 20, 30.00, NULL, NULL, 20, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(975, 669, 1, 14, 35.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(976, 669, 2, 1, 26.40, NULL, NULL, 1, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(977, 670, 1, 14, 35.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(978, 670, 2, 1, 26.40, NULL, NULL, 1, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(979, 671, 1, 14, 35.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(980, 671, 2, 1, 26.40, NULL, NULL, 1, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(981, 672, 1, 9, 35.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(982, 672, 2, 1, 26.40, NULL, NULL, 1, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(985, 674, 1, 4, 35.00, NULL, NULL, 4, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(986, 674, 2, 1, 30.80, NULL, NULL, 1, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(987, 675, 1, 14, 38.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(988, 675, 2, 1, 29.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(989, 676, 1, 9, 38.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(990, 676, 2, 1, 29.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(991, 677, 1, 11, 35.00, NULL, NULL, 11, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(992, 677, 2, 1, 26.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(993, 678, 1, 13, 38.00, NULL, NULL, 13, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(994, 678, 2, 2, 29.40, NULL, NULL, 2, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(995, 679, 1, 13, 38.00, NULL, NULL, 13, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(996, 679, 2, 2, 29.40, NULL, NULL, 2, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(997, 680, 1, 14, 38.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(998, 680, 2, 1, 29.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(999, 681, 1, 14, 35.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(1000, 681, 2, 1, 26.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(1001, 682, 1, 14, 35.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(1002, 682, 2, 1, 26.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(1003, 683, 1, 9, 35.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(1004, 683, 2, 1, 26.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(1005, 684, 1, 20, 35.00, NULL, NULL, 20, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(1006, 685, 1, 10, 26.00, NULL, NULL, 10, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(1007, 686, 1, 11, 26.00, NULL, NULL, 11, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(1008, 686, 2, 1, 17.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(1009, 687, 1, 14, 30.00, NULL, NULL, 14, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(1010, 687, 2, 1, 21.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(1013, 689, 1, 10, 2.00, NULL, NULL, 10, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(1014, 689, 2, 2, 5.00, NULL, NULL, 2, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(1015, 690, 1, 11, 35.00, NULL, NULL, 11, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(1016, 690, 2, 1, 26.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(1017, 691, 1, 9, 38.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(1018, 691, 2, 1, 29.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(1019, 692, 1, 9, 35.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(1020, 692, 2, 1, 26.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(1021, 693, 1, 9, 35.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(1022, 693, 2, 1, 26.40, NULL, NULL, 1, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(1024, 227, 3, 1, 29.00, 2.00, 122, 1, NULL);
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(1025, 688, 1, 9, 35.00, NULL, NULL, 9, '');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(1026, 688, 2, 1, 26.40, NULL, NULL, 1, '0');
INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES(1027, 694, 1, 16, 35.00, NULL, NULL, 16, '');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_invoice_detail`
--

CREATE TABLE IF NOT EXISTS `purchase_invoice_detail` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `purchase_master_id` int(10) DEFAULT NULL,
  `lot` varchar(255) DEFAULT NULL,
  `doRealisationDate` date DEFAULT NULL,
  `do` varchar(255) DEFAULT NULL,
  `invoice_number` varchar(255) DEFAULT NULL,
  `garden_id` int(10) DEFAULT NULL,
  `grade_id` int(10) DEFAULT NULL,
  `location_id` int(10) DEFAULT NULL,
  `warehouse_id` int(10) DEFAULT NULL,
  `gp_number` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `package` int(10) DEFAULT NULL,
  `stamp` decimal(10,2) DEFAULT NULL,
  `gross` decimal(10,2) DEFAULT NULL,
  `brokerage` decimal(10,2) DEFAULT NULL,
  `total_weight` decimal(10,2) DEFAULT NULL,
  `rate_type_value` double(10,2) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `service_tax` decimal(10,2) DEFAULT NULL,
  `total_value` decimal(10,2) DEFAULT NULL,
  `chest_from` int(10) DEFAULT NULL,
  `chest_to` int(10) DEFAULT NULL,
  `value_cost` decimal(10,2) DEFAULT NULL,
  `net` int(10) DEFAULT NULL,
  `rate_type` enum('V','C') DEFAULT NULL,
  `rate_type_id` int(11) NOT NULL,
  `service_tax_id` int(11) NOT NULL,
  `teagroup_master_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_purchase_master_id` (`purchase_master_id`),
  KEY `FK_DETAIL_garden_id` (`garden_id`),
  KEY `FK_DETAIL_grade_id` (`grade_id`),
  KEY `FK_DETAIL_warehouse_id` (`warehouse_id`),
  KEY `rate_type_id` (`rate_type_id`,`service_tax_id`),
  KEY `teagroup_master_id` (`teagroup_master_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=695 ;

--
-- Dumping data for table `purchase_invoice_detail`
--

INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(227, 49, '144', '2015-09-16', '20802', '162', 39, 10, 0, 26, '', NULL, NULL, '1.00', '31.40', '81.60', '272.00', 449.62, '165.00', '11.42', '45423.64', NULL, NULL, '44880.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(228, 49, '147', '2015-12-09', '20803', '241', 39, 15, 0, 26, '', NULL, NULL, '1.00', '30.40', '117.00', '390.00', 609.57, '156.00', '0.00', '61567.57', NULL, NULL, '60840.00', NULL, 'V', 7, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(229, 49, '402', '2015-12-22', '20801', '380', 81, 10, 0, 31, '', NULL, NULL, '1.00', '35.20', '210.00', '700.00', 1115.10, '159.00', '0.00', '112626.10', NULL, NULL, '111300.00', NULL, 'V', 7, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(230, 50, '61', NULL, '11153', '240014T', 207, 15, 0, 65, '', NULL, NULL, '1.00', '28.40', '37.80', '126.00', 189.38, '150.00', '0.00', '19128.18', NULL, NULL, '18900.00', NULL, 'V', 7, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(231, 50, '121', NULL, '11151', '149', 208, 10, 0, 66, '', NULL, NULL, '1.00', '30.20', '150.90', '503.00', 665.47, '132.00', '0.00', '67213.37', NULL, NULL, '66396.00', NULL, 'V', 7, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(232, 50, '124', NULL, '11154', '389', 43, 11, 0, 45, '', NULL, NULL, '1.00', '35.20', '102.90', '343.00', 433.21, '126.00', '0.00', '43755.11', NULL, NULL, '43218.00', NULL, 'V', 7, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(233, 50, '130', NULL, '11155', '387', 43, 10, 0, 45, '', NULL, NULL, '1.00', '35.20', '102.90', '343.00', 460.65, '134.00', '0.00', '46526.55', NULL, NULL, '45962.00', NULL, 'V', 7, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(234, 50, '134', NULL, '11156', '376', 43, 22, 0, 45, '', NULL, NULL, '1.00', '35.20', '155.40', '518.00', 706.03, '136.00', '0.00', '71310.43', NULL, NULL, '70448.00', NULL, 'V', 7, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(235, 50, '134', NULL, '11152', '472', 62, 10, 0, 19, '', NULL, NULL, '1.00', '35.20', '310.80', '1036.00', 1267.03, '122.00', '0.00', '127970.83', NULL, NULL, '126392.00', NULL, 'V', 7, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(236, 50, '61', NULL, '11153', '240014T', 207, 10, 0, 66, '', NULL, NULL, '1.00', '30.20', '150.90', '503.00', 665.47, '132.00', '0.00', '67213.37', NULL, NULL, '66396.00', NULL, 'V', 7, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(237, 51, '0132', NULL, '', '195', 88, 10, 0, 37, '', NULL, NULL, '0.00', '36.20', '108.00', '360.00', 483.48, '134.00', '0.00', '48831.48', NULL, NULL, '48240.00', NULL, 'V', 7, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(238, 51, '0172', NULL, '', '130', 209, 15, 0, 46, '', NULL, NULL, '0.00', '34.20', '99.90', '333.00', 467.20, '140.00', '0.00', '47187.10', NULL, NULL, '46620.00', NULL, 'V', 7, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(239, 51, '0206', NULL, '', '135', 76, 11, 0, 21, '', NULL, NULL, '0.00', '39.60', '117.00', '390.00', 648.57, '166.00', '0.00', '65505.57', NULL, NULL, '64740.00', NULL, 'V', 7, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(240, 51, '0208', NULL, '', '136', 76, 10, 0, 21, '', NULL, NULL, '0.00', '40.60', '180.00', '600.00', 997.80, '166.00', '0.00', '100777.80', NULL, NULL, '99600.00', NULL, 'V', 7, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(241, 52, '11', NULL, '25436', 'C664', 171, 10, 0, 7, '', NULL, NULL, '0.00', '38.50', '134.74', '561.00', 1039.20, '185.00', '18.86', '104977.80', NULL, NULL, '103785.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(242, 52, '16', NULL, '25437', 'C632', 171, 14, 0, 7, '', NULL, NULL, '0.00', '38.50', '128.59', '570.00', 804.99, '141.00', '18.00', '81321.58', NULL, NULL, '80370.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(243, 52, '54', NULL, '25452', 'C546', 63, 10, 0, 7, '', NULL, NULL, '0.00', '38.22', '134.74', '561.00', 1100.91, '196.00', '18.86', '111210.51', NULL, NULL, '109956.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(244, 53, '0181', NULL, '', '544', 86, 15, 0, 20, '', NULL, NULL, '0.00', '36.19', '105.90', '353.00', 467.02, '132.00', '14.83', '47183.75', NULL, NULL, '46596.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(245, 53, '0296', NULL, '', 'CE212', 76, 11, 0, 53, '', NULL, NULL, '0.00', '39.60', '173.40', '578.00', 978.55, '169.00', '24.28', '98858.23', NULL, NULL, '97682.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(246, 53, '0299', NULL, '', 'CE218', 76, 10, 0, 53, '', NULL, NULL, '0.00', '40.60', '177.90', '593.00', 938.72, '158.00', '24.91', '94835.53', NULL, NULL, '93694.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(247, 53, '0300', NULL, '', 'CE219', 76, 10, 0, 53, '', NULL, NULL, '0.00', '40.70', '300.00', '1000.00', 1613.00, '161.00', '42.00', '162955.00', NULL, NULL, '161000.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(248, 53, '0302', NULL, '', 'CE225', 76, 10, 0, 53, '', NULL, NULL, '0.00', '40.60', '156.00', '520.00', 812.76, '156.00', '21.84', '82110.60', NULL, NULL, '81120.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(249, 53, '0303', NULL, '', 'CE220', 76, 22, 0, 53, '', NULL, NULL, '0.00', '41.60', '120.90', '403.00', 605.71, '150.00', '16.93', '61193.54', NULL, NULL, '60450.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(251, 78, 'L-00012', NULL, 'D-00001', '125/0125/215', 34, 10, NULL, 7, '', NULL, NULL, '1.00', '30.20', '120.00', '328.00', 329.20, '100.00', '16.80', '33267.00', NULL, NULL, '32800.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(252, 79, '7144', NULL, '', 'DJ225', 46, 29, NULL, 38, '', NULL, NULL, '0.00', '19.40', '65.16', '217.20', 521.93, '240.00', '9.12', '52724.21', NULL, NULL, '52128.00', 0, 'V', 7, 11, 8);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(253, 79, '7115', NULL, '', 'DJ288', 46, 34, NULL, 38, '', NULL, NULL, '0.00', '22.40', '70.44', '234.80', 540.74, '230.00', '9.86', '54625.05', NULL, NULL, '54004.00', 0, 'V', 7, 11, 8);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(254, 79, '7116', NULL, '', 'DJ297', 46, 34, NULL, 38, '', NULL, NULL, '0.00', '22.40', '83.64', '278.80', 642.08, '230.00', '11.71', '64861.43', NULL, NULL, '64124.00', 0, 'V', 7, 11, 8);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(255, 80, '192', NULL, '30428', 'C168', 212, 15, NULL, 29, '', NULL, NULL, '1.00', '36.20', '108.00', '360.00', 490.69, '136.00', '15.12', '49574.81', NULL, NULL, '48960.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(256, 80, '193', NULL, '30429', 'C173', 212, 15, NULL, 29, '', NULL, NULL, '1.00', '36.20', '108.00', '360.00', 490.69, '136.00', '15.12', '49574.81', NULL, NULL, '48960.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(257, 80, '381', NULL, '30425', 'C821', 214, 10, NULL, 19, '', NULL, NULL, '1.00', '33.50', '198.00', '660.00', 965.59, '146.00', '27.72', '97552.31', NULL, NULL, '96360.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(258, 80, '383', NULL, '30426', 'C849', 214, 10, 0, 19, '', NULL, NULL, '1.00', '33.50', '136.50', '455.00', 697.52, '153.00', '19.11', '70469.13', NULL, NULL, '69615.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(259, 80, '385', NULL, '30427', 'C825', 214, 22, 0, 19, '', NULL, NULL, '1.00', '35.50', '155.40', '518.00', 840.72, '162.00', '21.76', '84934.88', NULL, NULL, '83916.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(260, 80, '395', NULL, '30430', 'C148', 81, 10, 0, 31, '', NULL, NULL, '1.00', '35.20', '155.40', '518.00', 768.20, '148.00', '21.76', '77610.36', NULL, NULL, '76664.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(261, 81, '76', NULL, '21259', 'C240536T', 207, 15, 0, 65, '', NULL, NULL, '1.00', '27.40', '162.00', '540.00', 800.83, '148.00', '22.68', '80906.51', NULL, NULL, '79920.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(262, 81, '180', NULL, '21266', 'C943', 240, 10, NULL, 52, '', NULL, NULL, '1.00', '33.20', '147.24', '490.80', 875.11, '178.00', '20.61', '88406.36', NULL, NULL, '87362.40', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(263, 81, '224', NULL, '21267', 'C479', 213, 11, 0, 26, '', NULL, NULL, '1.00', '38.22', '228.00', '760.00', 1301.89, '171.00', '31.92', '131522.81', NULL, NULL, '129960.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(264, 81, '226', NULL, '21265', 'C637', 213, 10, 0, 16, '', NULL, NULL, '1.00', '38.22', '168.90', '532.00', 964.62, '181.00', '23.65', '97450.16', NULL, NULL, '96292.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(265, 82, '0120', '2015-12-02', '20182', '582', 70, 11, 0, 67, '', NULL, NULL, '0.00', '35.20', '89.52', '411.40', 560.40, '136.00', '12.53', '56612.85', NULL, NULL, '55950.40', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(266, 83, '139', '2015-12-02', '57604', '670', 220, 10, 0, 67, '', NULL, NULL, '0.00', '38.50', '136.80', '570.00', 1033.07, '181.00', '19.15', '104359.02', NULL, NULL, '103170.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(267, 83, '145', '2015-12-02', '57605', '685', 220, 10, 0, 67, '', NULL, NULL, '0.00', '38.50', '136.80', '570.00', 1033.07, '181.00', '19.15', '104359.02', NULL, NULL, '103170.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(268, 83, '151', '2015-12-02', '57606', '685', 220, 14, 0, 67, '', NULL, NULL, '0.00', '38.50', '89.83', '374.30', 588.55, '157.00', '12.58', '59456.06', NULL, NULL, '58765.10', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(269, 83, '244', '2015-12-02', '57599', '848', 224, 11, 0, 67, '', NULL, NULL, '0.00', '35.20', '84.00', '350.00', 651.84, '186.00', '11.76', '65847.60', NULL, NULL, '65100.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(270, 83, '351', '2015-12-02', '57598', '495', 157, 10, 0, 67, '', NULL, NULL, '0.00', '35.20', '98.74', '411.40', 688.03, '167.00', '13.82', '69504.39', NULL, NULL, '68703.80', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(271, 83, '384', '2015-12-02', '57593', '884', 247, 10, 0, 67, '', NULL, NULL, '0.00', '38.20', '134.74', '561.40', 955.73, '170.00', '18.86', '96547.33', NULL, NULL, '95438.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(272, 83, '385', '2015-12-02', '57594', '892', 247, 10, 0, 67, '', NULL, NULL, '0.00', '38.20', '136.80', '570.00', 970.37, '170.00', '19.15', '98026.32', NULL, NULL, '96900.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(273, 83, '386', '2015-12-02', '57595', '893', 247, 10, 0, 67, '', NULL, NULL, '0.00', '38.20', '136.80', '570.00', 970.37, '170.00', '19.15', '98026.32', NULL, NULL, '96900.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(274, 83, '462', '2015-12-02', '57596', '502', 248, 14, 0, 67, '', NULL, NULL, '0.00', '37.20', '175.54', '731.40', 1223.19, '167.00', '24.58', '123567.11', NULL, NULL, '122143.80', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(275, 83, '557', '2015-12-02', '57597', '1294', 214, 11, 0, 67, '', NULL, NULL, '0.00', '32.50', '115.20', '480.00', 735.55, '153.00', '16.13', '74306.88', NULL, NULL, '73440.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(276, 83, '571', '2015-12-02', '57600', '1628', 246, 10, 0, 67, '', NULL, NULL, '0.00', '35.20', '126.00', '525.00', 841.26, '160.00', '17.64', '84984.90', NULL, NULL, '84000.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(277, 83, '572', NULL, '57603', '1629', 246, 10, 0, 67, '', NULL, NULL, '0.00', '35.20', '81.94', '341.40', 588.03, '172.00', '11.47', '59402.24', NULL, NULL, '58720.80', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(278, 83, '584', NULL, '57603', '459', 245, 14, 0, 67, '', NULL, NULL, '0.00', '35.20', '120.96', '525.00', 757.21, '144.00', '16.93', '76495.10', NULL, NULL, '75600.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(279, 83, '711', NULL, '57602', '458', 244, 10, 0, 67, '', NULL, NULL, '0.00', '34.20', '81.60', '340.00', 510.82, '150.00', '11.42', '51603.84', NULL, NULL, '51000.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(280, 84, '82', '2015-12-02', '17705', '616', 106, 11, 0, 67, '', NULL, NULL, '0.00', '26.20', '91.54', '381.40', 489.11, '128.00', '12.82', '49412.66', NULL, NULL, '48819.20', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(281, 84, '99', '2015-12-02', '17706', '630', 106, 10, NULL, 67, '', NULL, NULL, '0.00', '26.20', '124.80', '520.00', 672.05, '129.00', '17.47', '67894.32', NULL, NULL, '67080.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(282, 84, '121', '2015-12-02', '17698', '657', 172, 22, NULL, 67, '', NULL, NULL, '0.00', '30.20', '132.42', '441.40', 716.39, '162.00', '18.54', '72374.15', NULL, NULL, '71506.80', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(283, 84, '154', '2015-12-02', '17698', '418', 250, 10, 0, 67, '', NULL, NULL, '0.00', '35.20', '105.94', '519.30', 785.20, '151.00', '14.83', '79320.27', NULL, NULL, '78414.30', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(284, 84, '228', '2015-12-02', '17701', '357', 251, 11, 0, 67, '', NULL, NULL, '0.00', '35.20', '123.94', '530.40', 0.00, '146.00', '0.00', '77562.34', NULL, NULL, '77438.40', NULL, 'V', 0, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(285, 84, '228', '2015-12-02', '17702', '357', 251, 10, 0, 67, '', NULL, NULL, '0.00', '38.20', '134.74', '561.40', 893.97, '159.00', '18.86', '90310.18', NULL, NULL, '89262.60', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(286, 84, '232', '2015-12-02', '17703', '358', 251, 10, 0, 67, '', NULL, NULL, '0.00', '38.20', '136.80', '570.00', 890.57, '156.00', '19.15', '89966.52', NULL, NULL, '88920.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(287, 84, '234', '2015-12-02', '17699', '360', 251, 10, 0, 67, '', NULL, NULL, '0.00', '38.20', '134.74', '561.40', 798.54, '142.00', '18.86', '80670.94', NULL, NULL, '79718.80', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(288, 84, '239', '2015-12-02', '17704', '359', 251, 22, 0, 67, '', NULL, NULL, '0.00', '38.20', '134.74', '561.40', 787.31, '140.00', '18.86', '79536.91', NULL, NULL, '78596.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(289, 84, '243', '2015-12-02', '17704', '360', 251, 23, 0, 67, '', NULL, NULL, '0.00', '38.20', '109.44', '456.00', 575.65, '126.00', '15.32', '58156.42', NULL, NULL, '57456.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(290, 85, '76', '2015-12-14', '55854', '436', 60, 10, 0, 67, '', NULL, NULL, '0.00', '38.24', '89.10', '371.40', 669.41, '180.00', '12.47', '67622.99', NULL, NULL, '66852.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(291, 85, '167', '2015-12-14', '55842', '457', 232, 10, NULL, 67, '', NULL, NULL, '0.00', '37.45', '86.74', '361.40', 680.30, '188.00', '12.14', '68722.38', NULL, NULL, '67943.20', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(292, 85, '169', '2015-12-14', '55843', '459', 232, 10, NULL, 67, '', NULL, NULL, '0.00', '37.45', '86.74', '361.40', 673.07, '186.00', '12.14', '67992.35', NULL, NULL, '67220.40', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(293, 85, '202', '2015-12-14', '55844', '469', 232, 23, 0, 67, '', NULL, NULL, '0.00', '38.21', '89.14', '371.40', 587.70, '158.00', '12.48', '59370.52', NULL, NULL, '58681.20', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(294, 85, '203', '2015-12-14', '55845', '480', 232, 10, NULL, 67, '', NULL, NULL, '0.00', '38.21', '89.14', '380.00', 555.69, '146.00', '12.48', '56137.31', NULL, NULL, '55480.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(295, 85, '271', '2015-12-14', '55846', '692', 252, 23, 0, 67, '', NULL, NULL, '0.00', '38.20', '89.14', '371.40', 580.28, '156.00', '12.48', '58620.29', NULL, NULL, '57938.40', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(296, 85, '520', NULL, '55855', '1329', 253, 14, 0, 67, '', NULL, NULL, '0.00', '33.20', '108.95', '486.40', 682.05, '140.00', '15.25', '68902.25', NULL, NULL, '68096.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(297, 85, '796', '2015-12-14', '55848', '157', 254, 10, 0, 67, '', NULL, NULL, '0.00', '35.20', '66.56', '332.80', 416.67, '125.00', '9.32', '42092.54', NULL, NULL, '41600.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(298, 85, '887', NULL, '55853', '370', 255, 11, 0, 67, '', NULL, NULL, '0.00', '26.20', '68.00', '372.80', 425.67, '114.00', '9.52', '43002.39', NULL, NULL, '42499.20', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(299, 85, '889', '2015-12-14', '55847', '118', 197, 10, 0, 67, '', NULL, NULL, '0.00', '35.20', '64.46', '341.40', 403.50, '118.00', '9.02', '40762.18', NULL, NULL, '40285.20', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(300, 85, '925', NULL, '55852', '349', 148, 10, 0, 67, '', NULL, NULL, '0.00', '26.40', '75.06', '381.40', 469.87, '123.00', '10.51', '47467.64', NULL, NULL, '46912.20', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(301, 85, '1033', NULL, '55841', '314', 256, 10, 0, 67, '', NULL, NULL, '0.00', '35.20', '164.96', '1041.40', 1032.64, '99.00', '23.09', '104319.29', NULL, NULL, '103098.60', NULL, 'V', 7, 11, 9);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(302, 85, '1049', NULL, '55859', '909', 141, 11, 0, 67, '', NULL, NULL, '0.00', '35.50', '65.55', '341.40', 410.34, '120.00', '9.18', '41453.06', NULL, NULL, '40968.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(303, 85, '1050', '2015-12-14', '55856', '737', 141, 10, 0, 67, '', NULL, NULL, '0.00', '35.50', '59.11', '332.80', 370.00, '111.00', '8.28', '37378.18', NULL, NULL, '36940.80', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(304, 85, '1122', '2015-12-14', '55850', '467', 69, 10, 0, 67, '', NULL, NULL, '0.00', '38.20', '105.09', '561.40', 657.89, '117.00', '14.71', '66461.49', NULL, NULL, '65683.80', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(305, 85, '1124', NULL, '55850', '470', 69, 10, 0, 67, '', NULL, NULL, '0.00', '38.20', '106.70', '570.00', 667.97, '117.00', '0.00', '67464.67', NULL, NULL, '66690.00', NULL, 'V', 7, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(306, 85, '1124', '2015-12-14', '55850', '471', 69, 10, 0, 67, '', NULL, NULL, '0.00', '38.20', '106.70', '570.00', 667.97, '117.00', '0.00', '67464.67', NULL, NULL, '66690.00', NULL, 'V', 7, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(307, 85, '1124', '2015-12-14', '55850', '471', 69, 10, 0, 67, '', NULL, NULL, '0.00', '38.20', '106.70', '570.00', 667.97, '117.00', '14.94', '67479.60', NULL, NULL, '66690.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(308, 85, '1125', '2015-12-14', '55851', '471', 69, 10, 0, 67, '', NULL, NULL, '0.00', '38.20', '105.99', '561.40', 663.51, '118.00', '14.84', '67029.54', NULL, NULL, '66245.20', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(309, 85, '1137', '2015-12-14', '55857', '169', 115, 11, 0, 67, '', NULL, NULL, '0.00', '38.24', '73.57', '380.00', 460.54, '121.00', '10.30', '46524.41', NULL, NULL, '45980.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(310, 85, '1141', '2015-12-14', '55858', '169', 115, 22, 0, 67, '', NULL, NULL, '0.00', '38.24', '206.35', '941.40', 1291.78, '137.00', '28.89', '130498.82', NULL, NULL, '128971.80', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(311, 86, '343', '2015-11-26', '53032', '733', 137, 10, NULL, 67, '', NULL, NULL, '0.00', '38.50', '271.54', '1131.40', 2061.86, '182.00', '38.02', '208286.22', NULL, NULL, '205914.80', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(312, 86, '353', '2015-11-26', '53033', '749', 137, 14, NULL, 67, '', NULL, NULL, '0.00', '38.50', '89.14', '371.40', 632.27, '170.00', '12.48', '63871.89', NULL, NULL, '63138.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(313, 86, '375', '2015-11-26', '53023', '1016', 257, 14, NULL, 67, '', NULL, NULL, '0.00', '38.20', '80.82', '371.40', 505.91, '136.00', '11.31', '51108.45', NULL, NULL, '50510.40', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(314, 86, '480', '2015-11-26', '53028', '623', 118, 14, NULL, 67, '', NULL, NULL, '0.00', '38.20', '89.14', '371.40', 565.42, '152.00', '12.48', '57119.84', NULL, NULL, '56452.80', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(315, 86, '482', '2015-11-26', '53029', '641', 118, 14, NULL, 67, '', NULL, NULL, '0.00', '38.20', '89.14', '371.40', 572.85, '154.00', '12.48', '57870.07', NULL, NULL, '57195.60', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(316, 86, '517', '2626-11-15', '53027', '685', 104, 10, NULL, 67, '', NULL, NULL, '0.00', '56.20', '121.47', '520.00', 760.41, '146.00', '17.01', '76818.89', NULL, NULL, '75920.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(317, 86, '565', '2015-11-26', '53022', '1287', 249, 22, NULL, 67, '', NULL, NULL, '0.00', '35.20', '122.64', '525.00', 767.73, '146.00', '17.17', '77557.54', NULL, NULL, '76650.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(318, 86, '569', '2015-11-26', '53022', '375', 258, 10, NULL, 67, '', NULL, NULL, '0.00', '35.20', '84.00', '350.00', 560.84, '160.00', '11.76', '56656.60', NULL, NULL, '56000.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(319, 86, '581', '2015-11-26', '53031', '437', 244, 10, NULL, 67, '', NULL, NULL, '0.00', '26.20', '62.40', '260.00', 419.22, '161.00', '8.74', '42350.36', NULL, NULL, '41860.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(320, 86, '9', '2015-11-26', '35', '186', 259, 22, NULL, 67, '', NULL, NULL, '0.00', '35.20', '65.55', '341.40', 410.34, '120.00', '9.18', '41453.06', NULL, NULL, '40968.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(321, 86, '637', '2015-11-26', '53021', '1964', 120, 23, NULL, 67, '', NULL, NULL, '0.00', '35.20', '83.16', '525.00', 520.58, '99.00', '11.64', '52590.38', NULL, NULL, '51975.00', 0, 'V', 7, 11, 9);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(322, 86, '688', '2015-11-26', '53024', '287', 260, 11, NULL, 67, '', NULL, NULL, '0.00', '35.50', '68.83', '341.40', 430.85, '126.00', '9.64', '43525.72', NULL, NULL, '43016.40', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(323, 86, '690', '2015-11-26', '53025', '288', 260, 10, NULL, 67, '', NULL, NULL, '0.00', '35.20', '165.94', '691.40', 1059.50, '153.00', '23.23', '107032.87', NULL, NULL, '105784.20', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(324, 86, '691', '2015-11-26', '53026', '289', 260, 10, NULL, 67, '', NULL, NULL, '0.00', '35.20', '107.83', '481.40', 675.04, '140.00', '15.10', '68193.96', NULL, NULL, '67396.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(325, 87, '0022', '2015-11-27', '22369', '585', 58, 10, NULL, 67, '', NULL, NULL, '0.00', '38.20', '89.14', '371.40', 632.27, '170.00', '12.48', '63871.89', NULL, NULL, '63138.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(326, 87, '0024', '2015-11-27', '22370', '617', 58, 10, NULL, 67, '', NULL, NULL, '0.00', '38.20', '107.38', '447.40', 734.81, '164.00', '15.03', '74230.82', NULL, NULL, '73373.60', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(327, 87, '0051', '2015-11-27', '22365', '368', 261, 11, NULL, 67, '', NULL, NULL, '0.00', '38.20', '130.42', '570.00', 816.40, '143.00', '18.26', '82475.08', NULL, NULL, '81510.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(328, 87, '0055', '2015-11-27', '22366', '365', 261, 10, NULL, 67, '', NULL, NULL, '0.00', '38.20', '128.59', '570.00', 804.99, '141.00', '18.00', '81321.58', NULL, NULL, '80370.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(329, 87, '0060', '2015-11-27', '22367', '368', 261, 22, NULL, 67, '', NULL, NULL, '0.00', '38.20', '221.41', '941.40', 1386.07, '147.00', '31.00', '140024.28', NULL, NULL, '138385.80', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(330, 87, '0074', '2015-11-27', '22364', '359', 262, 10, NULL, 67, '', NULL, NULL, '0.00', '35.20', '75.08', '332.80', 470.00, '141.00', '10.51', '47480.39', NULL, NULL, '46924.80', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(331, 87, '0114', '2015-11-27', '22361', '562', 70, 11, NULL, 67, '', NULL, NULL, '0.00', '35.20', '78.98', '411.40', 494.47, '120.00', '11.06', '49952.51', NULL, NULL, '49368.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(332, 87, '0118', '2015-11-27', '22362', '570', 70, 10, NULL, 67, '', NULL, NULL, '0.00', '35.20', '73.74', '341.40', 461.63, '135.00', '10.32', '46634.69', NULL, NULL, '46089.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(333, 87, '0119', '2015-11-27', '22363', '575', 70, 10, NULL, 67, '', NULL, NULL, '0.00', '35.20', '69.91', '341.40', 437.69, '128.00', '9.79', '44216.59', NULL, NULL, '43699.20', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(334, 87, '0127', '2015-11-27', '22359', '575', 247, 10, NULL, 67, '', NULL, NULL, '0.00', '36.20', '91.58', '540.00', 573.32, '106.00', '12.82', '57917.72', NULL, NULL, '57240.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(335, 87, '0136', '2015-11-27', '22372', '601', 106, 11, NULL, 67, '', NULL, NULL, '0.00', '26.20', '54.70', '251.40', 342.45, '136.00', '7.66', '34595.21', NULL, NULL, '34190.40', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(336, 87, '0237', '2015-11-27', '22368', '190', 259, 10, NULL, 67, '', NULL, NULL, '0.00', '35.20', '69.91', '341.40', 437.69, '128.00', '9.79', '44216.59', NULL, NULL, '43699.20', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(337, 87, '0253', '2015-11-27', '22371', '679', 141, 22, NULL, 67, '', NULL, NULL, '0.00', '35.20', '65.50', '332.80', 410.00, '123.00', '9.17', '41419.07', NULL, NULL, '40934.40', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(338, 87, '0382', '2015-11-27', '22360', '506', 148, 11, NULL, 67, '', NULL, NULL, '0.00', '26.40', '98.18', '520.00', 614.58, '118.00', '13.75', '62086.51', NULL, NULL, '61360.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(339, 88, '253', '2015-11-02', '42469', '1732', 155, 14, NULL, 67, '', NULL, NULL, '0.00', '33.20', '116.74', '486.40', 798.86, '164.00', '16.34', '80701.55', NULL, NULL, '79769.60', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(340, 88, '293', '2015-11-28', '45468', '305', 257, 10, NULL, 67, '', NULL, NULL, '0.00', '38.20', '134.74', '561.40', 916.43, '163.00', '18.86', '92578.23', NULL, NULL, '91508.20', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(341, 88, '839', '2015-11-28', '45466', '919', 56, 10, NULL, 67, '', NULL, NULL, '0.00', '38.50', '136.80', '570.00', 993.17, '174.00', '19.15', '100329.12', NULL, NULL, '99180.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(342, 88, '840', '2015-11-28', '45467', '920', 56, 10, NULL, 67, '', NULL, NULL, '0.00', '35.80', '136.80', '570.00', 987.47, '173.00', '19.15', '99753.42', NULL, NULL, '98610.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(343, 89, '1', NULL, 's', '11', 34, 10, NULL, 26, '', NULL, NULL, '0.00', '28.20', '100.00', '333.00', 334.00, '100.00', '14.00', '33748.00', NULL, NULL, '33300.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(344, 90, '128', '2015-12-17', '46538', '643', 265, 16, 0, 68, '', NULL, NULL, '1.00', '32.27', '141.90', '473.00', 644.71, '136.00', '19.87', '65135.47', NULL, NULL, '64328.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(345, 90, '351', '2015-12-17', '46537', '1319', 214, 10, 0, 69, '', NULL, NULL, '1.00', '33.50', '47.40', '158.00', 269.08, '170.00', '6.64', '27184.12', NULL, NULL, '26860.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(346, 91, '874', NULL, '', '874', 266, 10, 5, 67, '', NULL, NULL, '0.00', '26.20', '0.00', '676.00', 5962.32, '176.40', '0.00', '125208.72', NULL, NULL, '119246.40', 0, 'V', 6, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(347, 92, '0175', NULL, '', '104', 75, 10, 5, 21, '', NULL, NULL, '0.00', '36.60', '0.00', '540.00', 4428.00, '164.00', '0.00', '92988.00', NULL, NULL, '88560.00', 0, 'V', 6, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(348, 92, '770', NULL, '', '770', 229, 10, 5, 47, '', NULL, NULL, '0.00', '38.20', '0.00', '366.00', 3531.90, '193.00', '0.00', '74169.90', NULL, NULL, '70638.00', 0, 'V', 6, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(349, 92, '421', NULL, '', '908', 229, 10, 5, 47, '', NULL, NULL, '0.00', '0.00', '0.00', '570.00', 5700.00, '200.00', '0.00', '119700.00', NULL, NULL, '114000.00', 0, 'V', 6, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(350, 92, '422', NULL, '', '909', 229, 10, 5, 47, '', NULL, NULL, '0.00', '38.20', '0.00', '760.00', 7220.00, '190.00', '0.00', '151620.00', NULL, NULL, '144400.00', 0, 'V', 6, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(351, 92, '423', NULL, '', '910', 229, 10, 5, 47, '', NULL, NULL, '0.00', '38.20', '0.00', '760.00', 7220.00, '190.00', '0.00', '151620.00', NULL, NULL, '144400.00', 0, 'V', 6, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(352, 92, '424', NULL, '', '914', 229, 10, 5, 47, '', NULL, NULL, '0.00', '38.20', '0.00', '570.00', 5415.00, '190.00', '0.00', '113715.00', NULL, NULL, '108300.00', 0, 'V', 6, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(353, 92, '446', NULL, '', '1187', 139, 10, 5, 21, '', NULL, NULL, '0.00', '35.70', '0.00', '350.00', 3097.50, '177.00', '0.00', '65047.50', NULL, NULL, '61950.00', 0, 'V', 6, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(354, 92, '0451', NULL, '', '1168', 139, 22, 5, 21, '', NULL, NULL, '0.00', '35.70', '0.00', '350.00', 2905.00, '166.00', '0.00', '61005.00', NULL, NULL, '58100.00', 0, 'V', 6, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(355, 92, '424', NULL, '', '912', 229, 10, 12, 47, '', NULL, NULL, '0.00', '38.20', '0.00', '760.00', 7220.00, '190.00', '0.00', '151620.00', NULL, NULL, '144400.00', NULL, 'V', 6, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(356, 93, '174', '2015-12-16', '11836', '896', 268, 15, 5, 43, '', NULL, NULL, '0.00', '29.40', '0.00', '564.60', 4996.71, '177.00', '0.00', '104930.91', NULL, NULL, '99934.20', 0, 'V', 6, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(357, 93, '194', '2015-12-16', '11835', '460', 227, 10, 5, 39, '', NULL, NULL, '0.00', '36.20', '0.00', '353.00', 2523.95, '143.00', '0.00', '53002.95', NULL, NULL, '50479.00', 0, 'V', 6, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(358, 93, '162', '2015-12-16', '11834', '771', 267, 10, 5, 70, '', NULL, NULL, '0.00', '40.20', '0.00', '393.00', 3320.85, '169.00', '0.00', '69737.85', NULL, NULL, '66417.00', NULL, 'V', 6, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(359, 94, '470', '2015-12-17', '47836', '673', 102, 11, NULL, 26, '', NULL, NULL, '1.00', '40.20', '239.70', '799.00', 1320.76, '165.00', '33.56', '133430.02', NULL, NULL, '131835.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(360, 94, '471', '2015-12-17', '47838', '585', 102, 10, NULL, 26, '', NULL, NULL, '1.00', '42.20', '186.90', '623.00', 1110.82, '178.00', '26.17', '112218.88', NULL, NULL, '110894.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(361, 94, '473', '2015-12-15', '47839', '588', 102, 10, NULL, 26, '', NULL, NULL, '1.00', '42.20', '186.90', '623.00', 1067.21, '171.00', '26.17', '107814.27', NULL, NULL, '106533.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(362, 94, '474', '2015-12-15', '47840', '590', 102, 10, NULL, 26, '', NULL, NULL, '1.00', '42.20', '186.90', '623.00', 1079.67, '173.00', '26.17', '109072.74', NULL, NULL, '107779.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(363, 94, '477', '2015-12-15', '47841', '632', 102, 10, NULL, 26, '', NULL, NULL, '1.00', '42.20', '186.90', '623.00', 1092.13, '175.00', '26.17', '110331.20', NULL, NULL, '109025.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(364, 94, '478', '2015-12-15', '47837', '679', 102, 10, NULL, 26, '', NULL, NULL, '1.00', '42.20', '252.00', '840.00', 1539.73, '183.00', '35.28', '155548.01', NULL, NULL, '153720.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(365, 94, '480', '2015-12-17', '47837', '679', 102, 10, NULL, 26, '', NULL, NULL, '1.00', '42.20', '186.68', '622.25', 1121.93, '180.00', '26.14', '113340.74', NULL, NULL, '112005.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(366, 95, '0', NULL, '', '210', 270, 14, NULL, 67, '', NULL, NULL, '0.00', '32.20', '0.00', '960.00', 3292.80, '68.60', '0.00', '69148.80', NULL, NULL, '65856.00', 0, 'V', 6, 0, 9);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(367, 95, '0', NULL, '', '3221', 270, 14, NULL, 67, '', NULL, NULL, '0.00', '32.20', '0.00', '960.00', 3292.80, '68.60', '0.00', '69148.80', NULL, NULL, '65856.00', 0, 'V', 6, 0, 9);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(368, 96, '0', NULL, '', '458', 271, 25, 56, 67, '', NULL, NULL, '0.00', '40.20', '0.00', '2880.00', 8640.00, '60.00', '0.00', '181440.00', NULL, NULL, '172800.00', 0, 'V', 6, 0, 9);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(369, 97, '0108', '2015-12-22', '10441', '732', 77, 10, 0, 72, '', NULL, NULL, '0.00', '37.20', '108.90', '363.00', 603.67, '166.00', '15.25', '60985.82', NULL, NULL, '60258.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(370, 97, '0112', '2015-12-22', '10442', '757', 77, 10, 0, 72, '', NULL, NULL, '0.00', '37.20', '108.90', '363.00', 654.49, '180.00', '15.25', '66118.63', NULL, NULL, '65340.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(371, 97, '0125', '2015-12-22', '10445', '682', 34, 10, NULL, 63, '', NULL, NULL, '0.00', '37.20', '108.90', '363.00', 647.23, '178.00', '15.25', '65385.38', NULL, NULL, '64614.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(372, 97, '0126', '2015-12-22', '10443', '697', 34, 10, NULL, 19, '', NULL, NULL, '0.00', '37.20', '108.90', '363.00', 629.08, '173.00', '15.25', '63552.22', NULL, NULL, '62799.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(373, 97, '0132', '2015-12-22', '10444', '700', 34, 22, NULL, 19, '', NULL, NULL, '0.00', '38.20', '111.90', '373.00', 601.65, '161.00', '15.67', '60782.21', NULL, NULL, '60053.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(374, 97, '0145', '2015-12-22', '10448', '930980', 116, 11, NULL, 47, '', NULL, NULL, '0.00', '40.20', '177.90', '593.00', 837.91, '141.00', '24.91', '84653.71', NULL, NULL, '83613.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(375, 97, '0148', '2015-12-22', '10449', '93100', 116, 11, NULL, 47, '', NULL, NULL, '0.00', '40.20', '117.90', '393.00', 551.38, '140.00', '16.51', '55705.79', NULL, NULL, '55020.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(376, 97, '0164', '2015-12-22', '10450', '931008', 116, 10, NULL, 47, '', NULL, NULL, '0.00', '40.20', '237.90', '793.00', 1239.46, '156.00', '33.31', '125218.66', NULL, NULL, '123708.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(377, 97, '0165', '2015-12-22', '10446', '931015', 116, 10, 0, 73, '', NULL, NULL, '0.00', '40.20', '237.90', '793.00', 1239.46, '156.00', '33.31', '125218.66', NULL, NULL, '123708.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(378, 97, '0166', '2015-12-22', '10447', '931016', 116, 10, 0, 73, '', NULL, NULL, '0.00', '40.20', '237.90', '793.00', 1215.67, '153.00', '33.31', '122815.88', NULL, NULL, '121329.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(379, 97, '0168', '2015-12-22', '10451', '931024', 116, 10, NULL, 47, '', NULL, NULL, '0.00', '40.20', '237.90', '793.00', 1255.32, '158.00', '33.31', '126820.52', NULL, NULL, '125294.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(380, 98, '1497', NULL, '142596', '950942', 218, 10, NULL, 73, '', NULL, NULL, '0.00', '40.25', '177.90', '593.00', 1175.92, '198.00', '24.91', '118792.73', NULL, NULL, '117414.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(381, 98, '1498', NULL, '142592', '950961', 218, 10, NULL, 47, '', NULL, NULL, '0.00', '40.25', '357.90', '1193.00', 2341.86, '196.00', '50.11', '236577.86', NULL, NULL, '233828.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(382, 98, '1499', NULL, '142593', '950962', 218, 10, NULL, 47, '', NULL, NULL, '0.00', '40.25', '177.90', '593.00', 1164.06, '196.00', '24.91', '117594.87', NULL, NULL, '116228.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(383, 98, '1501', NULL, '142594', '950964', 218, 10, NULL, 47, '', NULL, NULL, '0.00', '40.25', '177.90', '593.00', 1187.78, '200.00', '24.91', '119990.59', NULL, NULL, '118600.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(384, 98, '1506', NULL, '142595', '950990', 218, 10, NULL, 47, '', NULL, NULL, '0.00', '40.25', '177.90', '593.00', 1181.85, '199.00', '24.91', '119391.65', NULL, NULL, '118007.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(385, 98, '1533', '2015-12-22', '142587', '313', 85, 15, NULL, 75, '', NULL, NULL, '0.00', '35.40', '157.50', '525.00', 768.08, '146.00', '22.05', '77597.63', NULL, NULL, '76650.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(386, 98, '1535', '2015-12-22', '142597', '692', 85, 15, NULL, 76, '', NULL, NULL, '0.00', '32.40', '144.00', '480.00', 639.84, '133.00', '20.16', '64644.00', NULL, NULL, '63840.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(387, 98, '1564', NULL, '142585', '836', 272, 10, 0, 23, '', NULL, NULL, '0.00', '34.20', '150.90', '503.00', 655.41, '130.00', '21.13', '66217.43', NULL, NULL, '65390.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(388, 98, '1593', NULL, '142586', '663', 84, 10, NULL, 34, '', NULL, NULL, '0.00', '38.60', '111.90', '373.00', 508.40, '136.00', '15.67', '51363.96', NULL, NULL, '50728.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(389, 98, '1609', '2015-12-22', '142580', '676', 85, 10, NULL, 75, '', NULL, NULL, '0.00', '35.20', '207.90', '693.00', 951.49, '137.00', '29.11', '96129.49', NULL, NULL, '94941.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(390, 98, '1610', '2015-12-22', '142598', '677', 85, 10, NULL, 75, '', NULL, NULL, '0.00', '35.20', '210.00', '700.00', 884.10, '126.00', '29.40', '89323.50', NULL, NULL, '88200.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(391, 98, '1612', '2015-12-22', '142598', '689', 85, 10, NULL, 76, '', NULL, NULL, '0.00', '35.20', '207.90', '693.00', 951.49, '137.00', '29.11', '96129.49', NULL, NULL, '94941.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(392, 98, '1613', '2015-12-22', '142590', '690', 85, 10, NULL, 75, '', NULL, NULL, '0.00', '35.20', '102.90', '343.00', 484.66, '141.00', '14.41', '48964.96', NULL, NULL, '48363.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(393, 98, '1614', '2015-12-22', '142591', '701', 85, 10, NULL, 75, '', NULL, NULL, '0.00', '35.20', '210.00', '700.00', 884.10, '126.00', '29.40', '89323.50', NULL, NULL, '88200.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(394, 99, '0', NULL, '0', '0', 220, 14, 0, 67, '', NULL, NULL, '0.00', '0.00', '0.00', '0.00', 0.00, '0.00', '0.00', '0.00', NULL, NULL, '0.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(395, 100, '125', '2015-12-14', '59220', '699', 220, 14, NULL, 67, '', NULL, NULL, '0.00', '38.50', '89.83', '374.30', 588.55, '157.00', '12.58', '59456.06', NULL, NULL, '58765.10', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(396, 99, '0', NULL, '0', '0', 220, 14, 0, 67, '', NULL, NULL, '0.00', '0.00', '0.00', '0.00', 0.00, '0.00', '0.00', '0.00', NULL, NULL, '0.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(397, 100, '127', '2015-12-14', '59221', '706', 220, 14, NULL, 67, '', NULL, NULL, '0.00', '38.50', '89.83', '374.30', 603.52, '161.00', '12.58', '60968.23', NULL, NULL, '60262.30', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(398, 99, '0', '1970-01-01', '0', '0', 252, 14, 0, 67, '', NULL, NULL, '0.00', '0.00', '0.00', '0.00', 0.00, '0.00', '0.00', '0.00', NULL, NULL, '0.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(399, 99, '0', NULL, '0', '0', 252, 14, 0, 67, '', NULL, NULL, '0.00', '0.00', '0.00', '0.00', 0.00, '0.00', '0.00', '0.00', NULL, NULL, '0.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(400, 100, '193', '2015-12-14', '59217', '720', 252, 14, NULL, 67, '', NULL, NULL, '0.00', '38.20', '85.73', '380.00', 536.66, '141.00', '12.00', '54214.39', NULL, NULL, '53580.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(401, 99, '0', NULL, '0', '0', 157, 14, 0, 67, '', NULL, NULL, '0.00', '0.00', '0.00', '0.00', 0.00, '0.00', '0.00', '0.00', NULL, NULL, '0.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(402, 100, '194', '2015-12-14', '59218', '723', 252, 14, NULL, 67, '', NULL, NULL, '0.00', '38.20', '88.54', '371.40', 554.27, '149.00', '12.40', '55993.81', NULL, NULL, '55338.60', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(403, 99, '0', NULL, '0', '0', 99, 11, 0, 67, '', NULL, NULL, '0.00', '35.50', '0.00', '0.00', 0.00, '0.00', '0.00', '0.00', NULL, NULL, '0.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(404, 100, '305', '2015-12-14', '59212', '527', 157, 14, NULL, 67, '', NULL, NULL, '0.00', '38.20', '115.67', '516.40', 724.12, '140.00', '16.19', '73151.98', NULL, NULL, '72296.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(405, 99, '0', NULL, '0', '0', 99, 10, 0, 67, '', NULL, NULL, '0.00', '0.00', '0.00', '0.00', 0.00, '0.00', '0.00', '0.00', NULL, NULL, '0.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(406, 100, '644', '2015-12-14', '59213', '755', 99, 11, NULL, 67, '', NULL, NULL, '0.00', '35.50', '77.57', '341.40', 485.56, '142.00', '10.86', '49052.79', NULL, NULL, '48478.80', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(407, 99, '0', NULL, '0', '0', 99, 10, 0, 67, '0', NULL, NULL, '0.00', '0.00', '0.00', '0.00', 0.00, '0.00', '0.00', '0.00', NULL, NULL, '0.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(408, 100, '464', '2015-12-14', '59219', '690', 99, 10, NULL, 67, '', NULL, NULL, '0.00', '35.50', '111.72', '525.00', 699.37, '133.00', '15.64', '70651.73', NULL, NULL, '69825.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(409, 99, '0', NULL, '0', '0', 99, 22, 0, 67, '', NULL, NULL, '0.00', '0.00', '0.00', '0.00', 0.00, '0.00', '0.00', '0.00', NULL, NULL, '0.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(410, 100, '547', '2015-12-14', '59214', '761', 99, 10, NULL, 67, '', NULL, NULL, '0.00', '123.94', '123.94', '516.40', 781.00, '151.00', '17.35', '78898.69', NULL, NULL, '77976.40', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(411, 99, '0', NULL, '0', '0', 99, 22, 0, 67, '', NULL, NULL, '0.00', '0.00', '0.00', '0.00', 0.00, '0.00', '0.00', '0.00', NULL, NULL, '0.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(412, 100, '650', '2015-12-14', '59215', '757', 99, 22, NULL, 67, '', NULL, NULL, '0.00', '35.50', '79.75', '341.40', 499.24, '146.00', '11.16', '50434.56', NULL, NULL, '49844.40', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(413, 100, '652', '2015-12-14', '59216', '790', 99, 22, NULL, 67, '', NULL, NULL, '0.00', '35.50', '77.02', '341.40', 482.14, '141.00', '10.78', '48707.35', NULL, NULL, '48137.40', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(414, 101, '27', '2015-12-16', '3424', '692', 273, 22, NULL, 67, '', NULL, NULL, '0.00', '26.20', '0.00', '381.40', 537.77, '141.00', '0.00', '54315.17', NULL, NULL, '53777.40', 0, 'V', 7, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(415, 101, '33', '2015-12-16', '3425', '715', 274, 10, NULL, 67, '', NULL, NULL, '0.00', '26.20', '0.00', '520.00', 696.80, '134.00', '0.00', '70376.80', NULL, NULL, '69680.00', 0, 'V', 7, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(416, 101, '39', '2015-12-16', '3427', '729', 274, 22, NULL, 67, '', NULL, NULL, '0.00', '26.20', '0.00', '277.40', 360.62, '130.00', '0.00', '36422.62', NULL, NULL, '36062.00', 0, 'V', 7, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(417, 101, '85', '2015-12-16', '3427', '437', 255, 10, NULL, 67, '', NULL, NULL, '0.00', '26.20', '0.00', '381.40', 511.08, '134.00', '0.00', '51618.68', NULL, NULL, '51107.60', 0, 'V', 7, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(418, 101, '88', '2015-12-16', '3428', '463', 255, 10, 0, 67, '', NULL, NULL, '0.00', '26.20', '0.00', '381.40', 492.01, '129.00', '0.00', '49692.61', NULL, NULL, '49200.60', NULL, 'V', 7, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(419, 101, '137', '2015-12-16', '3429', '617', 274, 10, NULL, 67, '', NULL, NULL, '0.00', '26.20', '0.00', '390.00', 460.20, '118.00', '0.00', '46480.20', NULL, NULL, '46020.00', 0, 'V', 7, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(420, 101, '141', '2015-12-16', '3430', '614', 274, 22, NULL, 67, '', NULL, NULL, '0.00', '26.20', '0.00', '494.20', 597.98, '121.00', '0.00', '60396.18', NULL, NULL, '59798.20', 0, 'V', 7, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(421, 102, '0', '1970-01-01', '0', '0', 217, 23, 0, 67, '0', NULL, NULL, '0.00', '0.00', '0.00', '0.00', 0.00, '0.00', '0.00', '0.00', NULL, NULL, '0.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(422, 102, '0', '1970-01-01', '0', '0', 216, 14, 0, 67, '0', '1970-01-01', NULL, '0.00', '0.00', '0.00', '0.00', 0.00, '0.00', '0.00', '0.00', NULL, NULL, '0.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(423, 102, '0', NULL, '0', '0', 59, 10, 0, 67, '', '1970-01-01', NULL, '0.00', '0.00', '0.00', '0.00', 0.00, '0.00', '0.00', '0.00', NULL, NULL, '0.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(424, 102, '0', '1970-01-01', '0', '0', 59, 10, 0, 67, '0', '1970-01-01', NULL, '0.00', '0.00', '0.00', '0.00', 0.00, '0.00', '0.00', '0.00', NULL, NULL, '0.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(425, 102, '0', '1970-01-01', '0', '0', 137, 10, 0, 67, '0', '1970-01-01', NULL, '0.00', '0.00', '0.00', '0.00', 0.00, '0.00', '0.00', '0.00', NULL, NULL, '0.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(426, 102, '0', '1970-01-01', '0', '0', 137, 10, 0, 67, '0', '1970-01-01', NULL, '0.00', '0.00', '0.00', '0.00', 0.00, '0.00', '0.00', '0.00', NULL, NULL, '0.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(427, 102, '0', '1970-01-01', '0', '0', 137, 10, 0, 67, '0', '1970-01-01', NULL, '0.00', '0.00', '0.00', '0.00', 0.00, '0.00', '0.00', '0.00', NULL, NULL, '0.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(428, 102, '0', '1970-01-01', '0', '0', 266, 10, 0, 67, '0', '1970-01-01', NULL, '0.00', '0.00', '0.00', '0.00', 0.00, '0.00', '0.00', '0.00', NULL, NULL, '0.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(429, 102, '0', '1970-01-01', '0', '00', 107, 10, 0, 67, '', NULL, NULL, '0.00', '0.00', '0.00', '0.00', 0.00, '0.00', '0.00', '0.00', NULL, NULL, '0.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(430, 102, '0', NULL, '0', '0', 249, 22, 0, 67, '0', NULL, NULL, '0.00', '0.00', '0.00', '0.00', 0.00, '0.00', '0.00', '0.00', NULL, NULL, '0.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(431, 103, '160', '2015-12-16', '56445', '617', 217, 23, NULL, 67, '', NULL, NULL, '0.00', '38.24', '89.14', '371.40', 628.56, '169.00', '12.48', '63496.78', NULL, NULL, '62766.60', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(432, 103, '192', '2015-12-16', '56437', '776', 216, 14, NULL, 67, '', NULL, NULL, '0.00', '38.20', '114.00', '570.00', 713.64, '125.00', '15.96', '72093.60', NULL, NULL, '71250.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(433, 103, '203', '2015-12-16', '56438', '1242', 59, 10, NULL, 67, '', NULL, NULL, '0.00', '38.50', '134.74', '561.40', 1045.55, '186.00', '18.86', '105619.55', NULL, NULL, '104420.40', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(434, 103, '207', '2015-12-16', '56439', '1251', 59, 10, NULL, 67, '', NULL, NULL, '0.00', '38.50', '134.74', '561.40', 983.80, '175.00', '18.86', '99382.40', NULL, NULL, '98245.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(435, 103, '230', '2015-12-16', '56441', '789', 137, 10, NULL, 67, '', NULL, NULL, '0.00', '38.50', '136.80', '570.00', 998.87, '175.00', '19.15', '100904.82', NULL, NULL, '99750.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(436, 103, '234', '2015-12-16', '56442', '801', 137, 10, NULL, 67, '', NULL, NULL, '0.00', '38.50', '134.74', '561.40', 972.57, '173.00', '18.86', '98248.37', NULL, NULL, '97122.20', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(437, 103, '235', '2015-12-16', '56442', '802', 137, 10, NULL, 67, '', NULL, NULL, '0.00', '38.50', '182.40', '760.00', 1293.82, '170.00', '25.54', '130701.76', NULL, NULL, '129200.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(438, 103, '272', '2015-12-16', '56436', '729', 266, 10, NULL, 67, '', NULL, NULL, '0.00', '38.50', '104.20', '433.40', 837.50, '193.00', '14.59', '84602.49', NULL, NULL, '83646.20', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(439, 103, '355', '2015-12-16', '56440', '814', 107, 10, NULL, 67, '', NULL, NULL, '0.00', '35.20', '119.28', '525.00', 746.69, '142.00', '16.70', '75432.67', NULL, NULL, '74550.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(440, 103, '521', '2015-12-16', '56444', '1405', 249, 22, NULL, 67, '', NULL, NULL, '0.00', '35.20', '118.44', '525.00', 741.43, '141.00', '16.58', '74901.46', NULL, NULL, '74025.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(441, 104, '422', '2015-12-16', '48137', '604', 70, 10, NULL, 67, '', NULL, NULL, '0.00', '35.20', '84.91', '411.40', 531.56, '129.00', '11.89', '53698.95', NULL, NULL, '53070.60', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(442, 104, '576', '2015-12-16', '48136', '565', 148, 10, NULL, 67, '', NULL, NULL, '0.00', '26.40', '71.40', '381.40', 446.95, '117.00', '10.00', '45152.15', NULL, NULL, '44623.80', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(443, 104, '716', '2015-12-22', '48135', '990', 56, 10, NULL, 67, '', NULL, NULL, '0.00', '38.50', '136.80', '570.00', 953.27, '167.00', '19.15', '96299.22', NULL, NULL, '95190.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(444, 105, '0239', '2015-12-16', '915', '638', 151, 23, NULL, 67, '', NULL, NULL, '0.00', '35.20', '58.99', '341.40', 369.30, '108.00', '8.26', '37307.75', NULL, NULL, '36871.20', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(445, 106, '0013', '2015-12-16', '2659', '401', 103, 23, NULL, 67, '', NULL, NULL, '0.00', '35.20', '69.89', '455.00', 437.50, '96.00', '9.78', '44197.17', NULL, NULL, '43680.00', 0, 'V', 7, 11, 9);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(446, 107, '13', '2015-12-16', '7572', '395', 159, 10, NULL, 67, '', NULL, NULL, '0.00', '30.20', '0.00', '441.40', 600.30, '136.00', '0.00', '60630.70', NULL, NULL, '60030.40', 0, 'V', 7, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(447, 107, '14', '2015-12-16', '7573', '396', 159, 10, NULL, 67, '', NULL, NULL, '0.00', '30.20', '0.00', '441.40', 591.48, '134.00', '0.00', '59739.08', NULL, NULL, '59147.60', 0, 'V', 7, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(448, 107, '58', '2015-12-16', '7574', '435', 245, 14, NULL, 67, '', NULL, NULL, '0.00', '35.20', '0.00', '516.40', 774.60, '150.00', '0.00', '78234.60', NULL, NULL, '77460.00', 0, 'V', 7, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(449, 107, '59', '2015-12-16', '7575', '436', 245, 14, NULL, 67, '', NULL, NULL, '0.00', '35.20', '0.00', '516.40', 774.60, '150.00', '0.00', '78234.60', NULL, NULL, '77460.00', 0, 'V', 7, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(450, 107, '62', '2015-12-16', '7576', '353', 258, 10, NULL, 67, '', NULL, NULL, '0.00', '35.20', '0.00', '332.80', 515.84, '155.00', '0.00', '52099.84', NULL, NULL, '51584.00', 0, 'V', 7, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(451, 107, '65', '2015-12-16', '7577', '352', 258, 22, NULL, 67, '', NULL, NULL, '0.00', '32.20', '0.00', '302.80', 469.34, '155.00', '0.00', '47403.34', NULL, NULL, '46934.00', 0, 'V', 7, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(452, 107, '68', '2015-12-16', '7578', '1313', 152, 14, 0, 67, '', NULL, NULL, '0.00', '35.20', '0.00', '525.00', 740.25, '141.00', '0.00', '74765.25', NULL, NULL, '74025.00', NULL, 'V', 7, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(453, 107, '69', '2015-12-16', '7579', '1314', 152, 23, NULL, 67, '', NULL, NULL, '0.00', '35.20', '0.00', '341.40', 433.58, '127.00', '0.00', '43791.38', NULL, NULL, '43357.80', 0, 'V', 7, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(454, 108, '78', '2015-12-16', '18492', '706', 172, 11, NULL, 67, '', NULL, NULL, '0.00', '26.20', '0.00', '381.40', 556.84, '146.00', '0.00', '56241.24', NULL, NULL, '55684.40', 0, 'V', 7, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(455, 108, '83', '2015-12-16', '18493', '721', 172, 11, NULL, 67, '', NULL, NULL, '0.00', '30.20', '0.00', '450.00', 670.50, '149.00', '0.00', '67720.50', NULL, NULL, '67050.00', 0, 'V', 7, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(456, 108, '87', '2015-12-16', '18494', '713', 172, 22, NULL, 67, '', NULL, NULL, '0.00', '26.20', '0.00', '381.40', 530.15, '139.00', '0.00', '53544.75', NULL, NULL, '53014.60', 0, 'V', 7, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(457, 108, '139', '2015-12-16', '18485', '445', 250, 10, NULL, 67, '', NULL, NULL, '0.00', '35.20', '0.00', '519.30', 799.72, '154.00', '0.00', '80771.92', NULL, NULL, '79972.20', 0, 'V', 7, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(458, 108, '144', '2015-12-16', '18486', ' 451', 250, 10, NULL, 67, '', NULL, NULL, '0.00', '35.20', '0.00', '519.30', 820.49, '158.00', '0.00', '82869.89', NULL, NULL, '82049.40', 0, 'V', 7, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(459, 108, '   216', '2015-12-16', '18490', '639    ', 263, 10, NULL, 67, '', NULL, NULL, '0.00', '35.20', '0.00', '586.40', 768.18, '131.00', '0.00', '77586.58', NULL, NULL, '76818.40', 0, 'V', 7, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(460, 108, '219', '2015-12-16', '18491', '642', 263, 22, NULL, 67, '', NULL, NULL, '0.00', '35.20', '0.00', '586.40', 680.22, '116.00', '0.00', '68702.62', NULL, NULL, '68022.40', 0, 'V', 7, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(461, 108, '226', '2015-12-16', '18495', '363', 251, 10, NULL, 67, '', NULL, NULL, '0.00', '38.20', '0.00', '561.40', 735.43, '131.00', '0.00', '74278.83', NULL, NULL, '73543.40', 0, 'V', 7, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(462, 108, '233', '2015-12-16', '18496', '366', 251, 22, NULL, 67, '', NULL, NULL, '0.00', '38.20', '0.00', '570.00', 684.00, '120.00', '0.00', '69084.00', NULL, NULL, '68400.00', 0, 'V', 7, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(463, 108, '268', '2015-12-16', '18487', '641', 151, 10, NULL, 67, '', NULL, NULL, '0.00', '35.20', '0.00', '411.40', 518.36, '126.00', '0.00', '52354.76', NULL, NULL, '51836.40', 0, 'V', 7, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(464, 108, '269', '2015-12-16', '18488', '639', 151, 14, NULL, 67, '', NULL, NULL, '0.00', '35.20', '0.00', '516.40', 547.38, '106.00', '0.00', '55285.78', NULL, NULL, '54738.40', 0, 'V', 7, 0, 9);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(465, 108, '271', '2015-12-16', '18489', '641', 151, 22, NULL, 67, '', NULL, NULL, '0.00', '35.20', '0.00', '376.40', 466.74, '124.00', '0.00', '47140.34', NULL, NULL, '46673.60', 0, 'V', 7, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(466, 109, '5020', '2015-12-22', '12033', '170', 219, 36, NULL, 77, '', NULL, NULL, '0.00', '27.60', '120.27', '400.90', 650.66, '162.00', '16.84', '65733.57', NULL, NULL, '64945.80', 0, 'V', 7, 11, 6);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(467, 109, '5021', '2015-12-22', '12034', '171', 219, 36, NULL, 77, '', NULL, NULL, '0.00', '27.60', '120.27', '400.90', 666.70, '166.00', '16.84', '67353.20', NULL, NULL, '66549.40', 0, 'V', 7, 11, 6);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(468, 109, '5022', '2015-12-22', '12035', '172', 219, 36, NULL, 77, '', NULL, NULL, '0.00', '27.60', '120.27', '400.90', 670.71, '167.00', '16.84', '67758.11', NULL, NULL, '66950.30', 0, 'V', 7, 11, 6);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(469, 109, '5029', '2015-12-22', '12036', '170', 219, 28, NULL, 77, '', NULL, NULL, '0.00', '37.60', '120.27', '400.90', 690.75, '172.00', '16.84', '69782.66', NULL, NULL, '68954.80', 0, 'V', 7, 11, 6);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(470, 109, '5030', '2015-12-22', '12037', '171', 219, 28, NULL, 77, '', NULL, NULL, '0.00', '27.60', '120.27', '400.90', 686.74, '171.00', '16.84', '69377.75', NULL, NULL, '68553.90', 0, 'V', 7, 11, 6);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(471, 109, '5031', '2015-12-22', '12038', '172', 219, 28, NULL, 77, '', NULL, NULL, '0.00', '27.60', '120.27', '400.90', 666.70, '166.00', '16.84', '67353.20', NULL, NULL, '66549.40', 0, 'V', 7, 11, 6);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(472, 110, '180', '2015-12-07', '54742', '884', 229, 10, NULL, 67, '', NULL, NULL, '0.00', '38.20', '134.74', '561.40', 1034.32, '184.00', '18.86', '104485.53', NULL, NULL, '103297.60', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(473, 110, '183', '2015-12-07', '54742', '895', 229, 10, NULL, 67, '', NULL, NULL, '0.00', '38.20', '134.74', '561.40', 989.41, '176.00', '18.86', '99949.41', NULL, NULL, '98806.40', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(474, 110, '188', '2015-12-07', '54743', '900', 229, 10, NULL, 67, '', NULL, NULL, '0.00', '38.20', '136.80', '570.00', 1004.57, '176.00', '19.15', '101480.52', NULL, NULL, '100320.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(475, 110, '190', '2015-12-07', '54744', '915', 229, 10, NULL, 67, '', NULL, NULL, '0.00', '38.20', '134.74', '561.40', 978.18, '174.00', '18.86', '98815.39', NULL, NULL, '97683.60', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(476, 110, '151', '2015-12-07', '54736', '597', 217, 10, NULL, 67, '', NULL, NULL, '0.00', '38.24', '89.14', '371.40', 702.84, '189.00', '12.48', '70999.06', NULL, NULL, '70194.60', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(477, 110, '152', '2015-12-07', '54736', '846', 216, 10, NULL, 67, '', NULL, NULL, '0.00', '38.20', '228.00', '950.00', 1674.28, '176.00', '31.92', '169134.20', NULL, NULL, '167200.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(478, 110, '154', '2015-12-07', '54739', '1215', 59, 10, NULL, 67, '', NULL, NULL, '0.00', '38.50', '134.74', '561.40', 1045.55, '186.00', '18.86', '105619.55', NULL, NULL, '104420.40', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(479, 110, '155', '2015-12-07', '54740', '762', 137, 14, NULL, 67, '', NULL, NULL, '0.00', '38.50', '89.14', '371.40', 624.84, '168.00', '12.48', '63121.66', NULL, NULL, '62395.20', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(480, 110, '157', '2015-12-07', '54738', '369', 197, 11, NULL, 67, '', NULL, NULL, '0.00', '35.20', '80.30', '341.40', 502.66, '147.00', '11.24', '50780.00', NULL, NULL, '50185.80', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(481, 110, '158', '2015-12-07', '54739', '369', 197, 10, NULL, 67, '', NULL, NULL, '0.00', '38.20', '136.80', '570.00', 919.07, '161.00', '19.15', '92845.02', NULL, NULL, '91770.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(482, 110, '159', '2015-12-07', '54741', '1341', 249, 10, NULL, 67, '', NULL, NULL, '0.00', '34.20', '122.40', '510.00', 771.32, '151.00', '17.14', '77920.86', NULL, NULL, '77010.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(483, 111, '0035', '2015-12-22', '24938', '680', 58, 11, 0, 67, '', NULL, NULL, '0.00', '38.20', '107.38', '447.40', 685.60, '153.00', '15.03', '69260.21', NULL, NULL, '68452.20', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(484, 111, '0038', '2015-12-22', '24939', '681', 58, 10, NULL, 67, '', NULL, NULL, '0.00', '860.29', '134.74', '561.40', 860.29, '153.00', '18.86', '86908.09', NULL, NULL, '85894.20', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(485, 111, '0039', '2015-12-22', '24940', '682', 58, 22, NULL, 67, '', NULL, NULL, '0.00', '38.20', '105.94', '447.40', 663.21, '148.00', '14.83', '66999.18', NULL, NULL, '66215.20', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(486, 111, '0060', '2015-12-22', '24933', '365', 261, 11, 0, 67, '', NULL, NULL, '0.00', '38.50', '129.50', '570.00', 810.70, '142.00', '18.13', '81898.32', NULL, NULL, '80940.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(487, 111, '0061', '2016-01-22', '24934', '400', 261, 11, NULL, 67, '', NULL, NULL, '0.00', '38.00', '128.59', '570.00', 804.99, '141.00', '18.00', '81321.58', NULL, NULL, '80370.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(488, 111, '0063', '2015-12-22', '24935', '359', 261, 10, NULL, 67, '', NULL, NULL, '0.00', '38.20', '134.06', '570.00', 839.24, '147.00', '18.77', '84782.07', NULL, NULL, '83790.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(489, 111, '0064', '2015-12-22', '24936', '364', 261, 10, NULL, 67, '', NULL, NULL, '0.00', '38.20', '124.94', '570.00', 782.15, '137.00', '17.49', '79014.58', NULL, NULL, '78090.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(490, 111, '0068', '2015-12-22', '24937', '400', 261, 22, 0, 67, '', NULL, NULL, '0.00', '38.20', '87.35', '371.40', 546.83, '147.00', '12.23', '55242.21', NULL, NULL, '54595.80', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(491, 111, '0076', '2015-12-22', '24931', '719', 262, 10, 0, 67, '', NULL, NULL, '0.00', '35.20', '281.47', '1172.80', 1832.38, '156.00', '39.41', '185110.06', NULL, NULL, '182956.80', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(492, 111, '0077', '2015-12-22', '24932', '817', 262, 22, 0, 67, '', NULL, NULL, '0.00', '35.20', '115.57', '551.40', 723.49, '131.00', '16.18', '73088.64', NULL, NULL, '72233.40', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(493, 111, '0001', '2015-12-22', '24927', '618', 153, 10, 0, 67, '', NULL, NULL, '0.00', '26.20', '64.11', '286.20', 401.32, '140.00', '8.98', '40542.41', NULL, NULL, '40068.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(494, 111, '0088', '2015-12-22', '24928', '1388', 152, 10, 0, 67, '', NULL, NULL, '0.00', '35.20', '81.94', '341.40', 581.20, '170.00', '11.47', '58712.61', NULL, NULL, '58038.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(495, 111, '0093', '2015-12-22', '24929', '1394', 152, 22, 0, 67, '', NULL, NULL, '0.00', '35.20', '81.94', '341.40', 533.40, '156.00', '11.47', '53885.21', NULL, NULL, '53258.40', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(496, 111, '0114', '2015-12-22', '24930', '634', 70, 11, 0, 67, '', NULL, NULL, '0.00', '35.20', '77.01', '341.40', 482.14, '141.00', '10.78', '48707.34', NULL, NULL, '48137.40', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(497, 111, '0131', '2015-12-22', '24943', '604', 106, 10, 0, 67, '', NULL, NULL, '0.00', '26.20', '60.85', '294.80', 380.90, '129.00', '8.52', '38479.47', NULL, NULL, '38029.20', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(498, 111, '0132', '2015-12-22', '24944', '605', 106, 10, 0, 67, '', NULL, NULL, '0.00', '26.20', '83.59', '398.80', 523.26, '131.00', '11.70', '52861.36', NULL, NULL, '52242.80', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(499, 111, '0162', '2015-12-22', '24941', '325', 158, 10, 0, 67, '', NULL, NULL, '0.00', '35.20', '77.01', '341.40', 482.14, '141.00', '10.78', '48707.34', NULL, NULL, '48137.40', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(500, 111, '0', NULL, '0', '0', 158, 10, 0, 67, '', NULL, NULL, '0.00', '0.00', '0.00', '0.00', 0.00, '0.00', '0.00', '0.00', NULL, NULL, '0.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(501, 111, '0179', '2015-12-22', '24942', '1299', 275, 10, 0, 67, '', NULL, NULL, '0.00', '30.20', '98.16', '441.40', 614.53, '139.00', '13.74', '62081.03', NULL, NULL, '61354.60', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(502, 112, '90', '2015-12-22', '49343', '563', 52, 10, NULL, 67, '', NULL, NULL, '0.00', '38.20', '43.54', '181.40', 357.79, '197.00', '6.10', '36143.23', NULL, NULL, '35735.80', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(503, 112, '92', '2015-12-22', '49344', '569', 52, 10, NULL, 67, '', NULL, NULL, '0.00', '38.20', '182.40', '760.00', 1476.22, '194.00', '25.54', '149124.16', NULL, NULL, '147440.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(504, 112, '116', '2015-12-22', '49345', '799', 213, 14, NULL, 67, '', NULL, NULL, '0.00', '38.22', '89.14', '371.40', 591.42, '159.00', '12.48', '59745.64', NULL, NULL, '59052.60', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(505, 112, '155', '2015-12-22', '49341', '1120', 257, 11, NULL, 67, '', NULL, NULL, '0.00', '38.20', '103.80', '447.40', 649.77, '145.00', '14.53', '65641.10', NULL, NULL, '64873.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(506, 112, '167', '2015-12-22', '49342', '339', 276, 14, NULL, 67, '', NULL, NULL, '0.00', '38.20', '136.80', '570.00', 862.07, '151.00', '19.15', '87088.02', NULL, NULL, '86070.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(507, 112, '180', '2015-12-22', '49351', '886', 277, 10, NULL, 67, '', NULL, NULL, '0.00', '35.20', '123.94', '516.40', 899.78, '174.00', '17.35', '90894.67', NULL, NULL, '89853.60', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(508, 112, '182', '2015-12-22', '49352', '883', 277, 22, NULL, 67, '', NULL, NULL, '0.00', '35.20', '81.94', '341.40', 512.92, '150.00', '11.47', '51816.33', NULL, NULL, '51210.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(509, 112, '242', '2015-12-22', '49346', '559', 223, 11, NULL, 67, '', NULL, NULL, '0.00', '34.50', '122.40', '510.00', 832.52, '163.00', '17.14', '84102.06', NULL, NULL, '83130.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(510, 112, '257', '2015-12-22', '49348', '1387', 152, 11, NULL, 67, '', NULL, NULL, '0.00', '35.20', '98.74', '411.40', 683.91, '166.00', '13.82', '69088.88', NULL, NULL, '68292.40', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(511, 112, '258', '2015-12-22', '49349', '1344', 152, 10, NULL, 67, '', NULL, NULL, '0.00', '35.20', '98.74', '411.40', 671.57, '163.00', '13.82', '67842.33', NULL, NULL, '67058.20', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(512, 112, '262', '2015-12-22', '49350', '1391', 152, 10, NULL, 67, '', NULL, NULL, '0.00', '35.20', '98.74', '411.40', 696.25, '169.00', '13.82', '70335.42', NULL, NULL, '69526.60', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(513, 112, '303', '2015-12-22', '49347', '416', 258, 11, NULL, 67, '', NULL, NULL, '0.00', '38.20', '89.14', '371.40', 580.28, '156.00', '12.48', '58620.29', NULL, NULL, '57938.40', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(514, 113, '0', '1970-01-01', '0', '0', 52, 10, 0, 67, '', NULL, NULL, '0.00', '0.00', '0.00', '0.00', 0.00, '0.00', '0.00', '0.00', NULL, NULL, '0.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(515, 113, '0', NULL, '0', '0', 52, 10, 0, 67, '0', NULL, NULL, '0.00', '0.00', '0.00', '0.00', 0.00, '0.00', '0.00', '0.00', NULL, NULL, '0.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(516, 113, '0', NULL, '0', '0', 213, 14, 0, 67, '', NULL, NULL, '0.00', '0.00', '0.00', '0.00', 0.00, '0.00', '0.00', '0.00', NULL, NULL, '0.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(517, 113, '0', NULL, '0', '0', 257, 11, 0, 67, '', NULL, NULL, '0.00', '0.00', '0.00', '0.00', 0.00, '0.00', '0.00', '0.00', NULL, NULL, '0.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(518, 113, '0', '1970-01-01', '0', '0', 276, 14, 0, 67, '', NULL, NULL, '0.00', '0.00', '0.00', '0.00', 0.00, '0.00', '0.00', '0.00', NULL, NULL, '0.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(519, 113, '0', NULL, '0', '0', 277, 10, 0, 67, '', NULL, NULL, '0.00', '0.00', '0.00', '0.00', 0.00, '0.00', '0.00', '0.00', NULL, NULL, '0.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(520, 113, '0', NULL, '0', '0', 277, 22, 0, 67, '', NULL, NULL, '0.00', '0.00', '0.00', '0.00', 0.00, '0.00', '0.00', '0.00', NULL, NULL, '0.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(521, 113, '0', NULL, '0', '0', 223, 11, 0, 67, '', '1970-01-01', NULL, '0.00', '0.00', '0.00', '0.00', 0.00, '0.00', '0.00', '0.00', NULL, NULL, '0.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(522, 113, '0', NULL, '0', '0', 152, 11, 0, 67, '', NULL, NULL, '0.00', '0.00', '0.00', '0.00', 0.00, '0.00', '0.00', '0.00', NULL, NULL, '0.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(523, 113, '0', NULL, '0', '0', 152, 10, 0, 67, '', NULL, NULL, '0.00', '0.00', '0.00', '0.00', 0.00, '0.00', '0.00', '0.00', NULL, NULL, '0.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(524, 113, '0', NULL, '0', '0', 152, 10, 0, 67, '', NULL, NULL, '0.00', '0.00', '0.00', '0.00', 0.00, '0.00', '0.00', '0.00', NULL, NULL, '0.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(525, 113, '0', NULL, '0', '0', 258, 11, 0, 67, '', NULL, NULL, '0.00', '0.00', '0.00', '0.00', 0.00, '0.00', '0.00', '0.00', NULL, NULL, '0.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(526, 114, '189', '2015-12-22', '57971', '1287', 59, 10, NULL, 67, '', NULL, NULL, '0.00', '38.50', '271.54', '1131.40', 2163.69, '191.00', '38.02', '218570.65', NULL, NULL, '216097.40', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(527, 114, '190', '2015-12-22', '57972', '1288', 59, 10, NULL, 67, '', NULL, NULL, '0.00', '38.50', '134.74', '561.40', 1073.62, '191.00', '18.86', '108454.63', NULL, NULL, '107227.40', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(528, 114, '202', '2015-12-22', '57973', '710', 137, 10, NULL, 67, '', NULL, NULL, '0.00', '38.50', '132.67', '552.80', 1018.48, '184.00', '18.57', '102884.92', NULL, NULL, '101715.20', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(529, 114, '205', '2015-12-22', '57974', '718', 137, 10, NULL, 67, '', NULL, NULL, '0.00', '38.50', '132.67', '552.80', 1029.53, '186.00', '18.57', '104001.58', NULL, NULL, '102820.80', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(530, 114, '209', '2015-12-22', '57975', '729', 137, 10, NULL, 67, '', NULL, NULL, '0.00', '38.50', '132.67', '552.80', 1024.01, '185.00', '18.57', '103443.25', NULL, NULL, '102268.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(531, 114, '211', '2015-12-22', '57976', '734', 137, 10, NULL, 67, '', NULL, NULL, '0.00', '38.50', '132.67', '552.80', 1084.81, '196.00', '18.57', '109584.86', NULL, NULL, '108348.80', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(532, 114, '213', '2015-12-22', '57977', '743', 137, 10, NULL, 67, '', NULL, NULL, '0.00', '38.50', '132.67', '552.80', 979.78, '177.00', '18.57', '98976.63', NULL, NULL, '97845.60', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(533, 114, '215', '2015-12-22', '57978', '806', 137, 10, NULL, 67, '', NULL, NULL, '0.00', '38.50', '134.74', '561.40', 1045.55, '186.00', '18.86', '105619.55', NULL, NULL, '104420.40', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(534, 114, '217', '2015-12-22', '57979', '813', 137, 10, NULL, 67, '', NULL, NULL, '0.00', '38.50', '136.80', '570.00', 970.37, '170.00', '19.15', '98026.32', NULL, NULL, '96900.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(535, 114, '218', '2015-12-22', '57980', '820', 137, 10, NULL, 67, '', NULL, NULL, '0.00', '38.50', '182.40', '760.00', 1369.82, '180.00', '25.54', '138377.76', NULL, NULL, '136800.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(536, 114, '225', '2015-12-22', '57981', '848', 137, 10, NULL, 67, '', NULL, NULL, '0.00', '38.50', '136.80', '570.00', 1004.57, '176.00', '19.15', '101480.52', NULL, NULL, '100320.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(537, 115, '15', '2015-12-22', '19346', '374', 251, 10, NULL, 67, '', NULL, NULL, '0.00', '38.20', '0.00', '561.40', 887.01, '158.00', '0.00', '89588.21', NULL, NULL, '88701.20', 0, 'V', 7, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(538, 115, '24', '2015-12-22', '19338', '941', 104, 10, NULL, 67, '', NULL, NULL, '0.00', '26.20', '0.00', '381.40', 594.98, '156.00', '0.00', '60093.38', NULL, NULL, '59498.40', 0, 'V', 7, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(539, 115, '25', '2015-12-22', '19333', '942', 104, 10, NULL, 67, '', NULL, NULL, '0.00', '26.20', '0.00', '381.40', 575.91, '151.00', '0.00', '58167.31', NULL, NULL, '57591.40', 0, 'V', 7, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(540, 115, '72', '2015-12-22', '19349', '656', 106, 10, NULL, 67, '', NULL, NULL, '0.00', '26.20', '0.00', '251.40', 289.11, '115.00', '0.00', '29200.11', NULL, NULL, '28911.00', 0, 'V', 7, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(541, 115, '90', '2015-12-22', '19341', '581', 172, 10, NULL, 67, '', NULL, NULL, '0.00', '30.20', '0.00', '441.40', 719.48, '163.00', '0.00', '72667.68', NULL, NULL, '71948.20', 0, 'V', 7, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(542, 115, '93', '2015-12-22', '19342', '619', 172, 10, NULL, 67, '', NULL, NULL, '0.00', '30.20', '0.00', '891.40', 1461.90, '164.00', '0.00', '147651.50', NULL, NULL, '146189.60', 0, 'V', 7, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(543, 115, '94', '2015-12-22', '19343', '638', 172, 10, NULL, 67, '', NULL, NULL, '0.00', '30.20', '0.00', '441.40', 750.38, '170.00', '0.00', '75788.38', NULL, NULL, '75038.00', 0, 'V', 7, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(544, 115, '95', '2015-12-22', '19344', '644', 172, 10, NULL, 67, '', NULL, NULL, '0.00', '30.20', '0.00', '450.00', 756.00, '168.00', '0.00', '76356.00', NULL, NULL, '75600.00', 0, 'V', 7, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(545, 115, '98', '2015-12-22', '19345', '645', 172, 22, NULL, 67, '', NULL, NULL, '0.00', '30.20', '0.00', '441.40', 719.48, '163.00', '0.00', '72667.68', NULL, NULL, '71948.20', 0, 'V', 7, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(546, 115, '102', '2015-12-22', '19339', '927', 287, 10, 0, 67, '', NULL, NULL, '0.00', '26.20', '0.00', '381.40', 602.61, '158.00', '0.00', '60863.81', NULL, NULL, '60261.20', NULL, 'V', 7, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(547, 115, '120', '2015-12-22', '19334', '459', 250, 21, NULL, 67, '', NULL, NULL, '0.00', '35.20', '0.00', '519.30', 716.63, '138.00', '0.00', '72380.03', NULL, NULL, '71663.40', 0, 'V', 7, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(548, 115, '125', '2015-12-22', '19335', '468', 250, 10, NULL, 67, '', NULL, NULL, '0.00', '35.20', '0.00', '519.30', 841.27, '162.00', '0.00', '84967.87', NULL, NULL, '84126.60', 0, 'V', 7, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(549, 115, '128', '2015-12-22', '19336', '472', 250, 10, NULL, 67, '', NULL, NULL, '0.00', '35.20', '0.00', '519.30', 810.11, '156.00', '0.00', '81820.91', NULL, NULL, '81010.80', 0, 'V', 7, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(550, 115, '133', '2015-12-22', '19337', '464', 250, 14, NULL, 67, '', NULL, NULL, '0.00', '35.20', '0.00', '519.30', 654.32, '126.00', '0.00', '66086.12', NULL, NULL, '65431.80', 0, 'V', 7, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(551, 115, '208', '2015-12-22', '19330', '368', 251, 11, NULL, 67, '', NULL, NULL, '0.00', '35.20', '0.00', '516.40', 712.63, '138.00', '0.00', '71975.83', NULL, NULL, '71263.20', 0, 'V', 7, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(552, 115, '209', '2015-12-22', '19331', '369', 251, 11, NULL, 67, '', NULL, NULL, '0.00', '35.20', '0.00', '525.00', 687.75, '131.00', '0.00', '69462.75', NULL, NULL, '68775.00', 0, 'V', 7, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(553, 115, '215', '2015-12-22', '19347', '376', 251, 10, NULL, 67, '', NULL, NULL, '0.00', '38.20', '0.00', '409.40', 577.25, '141.00', '0.00', '58302.65', NULL, NULL, '57725.40', 0, 'V', 7, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(554, 115, '224', '2015-12-22', '19332', '368', 251, 22, NULL, 67, '', NULL, NULL, '0.00', '38.20', '0.00', '865.40', 1107.71, '128.00', '0.00', '111878.91', NULL, NULL, '110771.20', 0, 'V', 7, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(555, 115, '226', '2015-12-22', '19348', '376', 251, 22, NULL, 67, '', NULL, NULL, '0.00', '38.20', '0.00', '371.40', 475.39, '128.00', '0.00', '48014.59', NULL, NULL, '47539.20', 0, 'V', 7, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(556, 115, '249', '2015-12-22', '19340', '1337', 288, 22, 0, 67, '', NULL, NULL, '0.00', '26.20', '0.00', '433.40', 654.43, '151.00', '0.00', '66097.83', NULL, NULL, '65443.40', NULL, 'V', 7, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(557, 116, '121', NULL, '63511', '690', 220, 10, NULL, 67, '', NULL, NULL, '0.00', '38.50', '136.80', '570.00', 1067.27, '187.00', '19.15', '107813.22', NULL, NULL, '106590.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(558, 116, '122', NULL, '63512', '691', 220, 10, NULL, 67, '', NULL, NULL, '0.00', '38.50', '136.80', '570.00', 1101.47, '193.00', '19.15', '111267.42', NULL, NULL, '110010.00', 0, 'V', 7, 11, 9);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(559, 116, '123', NULL, '63513', '735', 220, 10, NULL, 67, '', NULL, NULL, '0.00', '38.50', '136.80', '570.00', 1090.07, '191.00', '19.15', '110116.02', NULL, NULL, '108870.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(560, 116, '124', NULL, '63514', '736', 220, 10, NULL, 67, '', NULL, NULL, '0.00', '38.50', '134.74', '561.40', 1011.87, '180.00', '18.86', '102217.47', NULL, NULL, '101052.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(561, 116, '125', NULL, '63515', '737', 220, 10, NULL, 67, '', NULL, NULL, '0.00', '38.50', '182.40', '760.00', 1514.22, '199.00', '25.54', '152962.16', NULL, NULL, '151240.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(562, 116, '126', NULL, '63516', '741', 220, 10, NULL, 67, '', NULL, NULL, '0.00', '38.50', '136.80', '570.00', 1090.07, '191.00', '19.15', '110116.02', NULL, NULL, '108870.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(563, 116, '130', NULL, '63517', '751', 220, 10, NULL, 67, '', NULL, NULL, '0.00', '38.50', '136.80', '570.00', 1055.87, '185.00', '19.15', '106661.82', NULL, NULL, '105450.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(564, 116, '148', NULL, '63508', '500', 232, 10, NULL, 67, '', NULL, NULL, '0.00', '37.45', '88.80', '370.00', 707.59, '191.00', '12.43', '71478.82', NULL, NULL, '70670.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(565, 116, '151', NULL, '63509', '503', 232, 10, NULL, 67, '', NULL, NULL, '0.00', '37.45', '88.80', '370.00', 711.29, '192.00', '12.43', '71852.52', NULL, NULL, '71040.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(566, 116, '171', NULL, '63507', '562', 232, 23, NULL, 67, '', NULL, NULL, '0.00', '38.45', '180.34', '751.40', 1136.42, '151.00', '25.25', '114803.40', NULL, NULL, '113461.40', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(567, 116, '291', NULL, '63510', '699', 278, 10, NULL, 67, '', NULL, NULL, '0.00', '35.50', '84.00', '350.00', 616.84, '176.00', '11.76', '62312.60', NULL, NULL, '61600.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(568, 117, '121', NULL, '63511', '690', 220, 10, NULL, 67, '', NULL, NULL, '0.00', '38.50', '136.80', '570.00', 1067.27, '187.00', '19.15', '107813.22', NULL, NULL, '106590.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(569, 117, '122', NULL, '63512', '691', 220, 10, NULL, 67, '', NULL, NULL, '0.00', '38.50', '136.80', '570.00', 1101.47, '193.00', '19.15', '111267.42', NULL, NULL, '110010.00', 0, 'V', 7, 11, 9);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(570, 117, '123', NULL, '63513', '735', 220, 10, NULL, 67, '', NULL, NULL, '0.00', '38.50', '136.80', '570.00', 1090.07, '191.00', '19.15', '110116.02', NULL, NULL, '108870.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(571, 117, '124', NULL, '63514', '736', 220, 10, NULL, 67, '', NULL, NULL, '0.00', '38.50', '134.74', '561.40', 1011.87, '180.00', '18.86', '102217.47', NULL, NULL, '101052.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(572, 117, '125', NULL, '63515', '737', 220, 10, NULL, 67, '', NULL, NULL, '0.00', '38.50', '182.40', '760.00', 1514.22, '199.00', '25.54', '152962.16', NULL, NULL, '151240.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(573, 117, '126', NULL, '63516', '741', 220, 10, NULL, 67, '', NULL, NULL, '0.00', '38.50', '136.80', '570.00', 1090.07, '191.00', '19.15', '110116.02', NULL, NULL, '108870.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(574, 117, '130', NULL, '63517', '751', 220, 10, NULL, 67, '', NULL, NULL, '0.00', '38.50', '136.80', '570.00', 1055.87, '185.00', '19.15', '106661.82', NULL, NULL, '105450.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(575, 117, '148', NULL, '63508', '500', 232, 10, NULL, 67, '', NULL, NULL, '0.00', '37.45', '88.80', '370.00', 707.59, '191.00', '12.43', '71478.82', NULL, NULL, '70670.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(576, 117, '151', NULL, '63509', '503', 232, 10, NULL, 67, '', NULL, NULL, '0.00', '37.45', '88.80', '370.00', 711.29, '192.00', '12.43', '71852.52', NULL, NULL, '71040.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(577, 117, '171', NULL, '63507', '562', 232, 23, NULL, 67, '', NULL, NULL, '0.00', '38.45', '180.34', '751.40', 1136.42, '151.00', '25.25', '114803.40', NULL, NULL, '113461.40', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(578, 117, '291', NULL, '63510', '699', 278, 10, NULL, 67, '', NULL, NULL, '0.00', '35.50', '84.00', '350.00', 616.84, '176.00', '11.76', '62312.60', NULL, NULL, '61600.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(579, 118, '158', NULL, '61515', '726', 220, 10, NULL, 67, '', NULL, NULL, '0.00', '38.50', '134.74', '561.40', 1028.71, '183.00', '18.86', '103918.51', NULL, NULL, '102736.20', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(580, 118, '183', NULL, '61495', '482', 232, 10, NULL, 67, '', NULL, NULL, '0.00', '37.45', '84.67', '352.80', 692.33, '196.00', '11.85', '69937.66', NULL, NULL, '69148.80', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(581, 118, '194', NULL, '61494', '534', 232, 10, NULL, 67, '', NULL, NULL, '0.00', '37.45', '86.74', '361.40', 622.48, '172.00', '12.14', '62882.16', NULL, NULL, '62160.80', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(582, 118, '266', NULL, '61507', '915', 224, 11, NULL, 67, '', NULL, NULL, '0.00', '35.20', '81.94', '341.40', 635.82, '186.00', '11.47', '64229.63', NULL, NULL, '63500.40', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(583, 118, '294', NULL, '51605', '381', 117, 10, NULL, 67, '', NULL, NULL, '0.00', '35.20', '88.27', '367.80', 607.75, '165.00', '12.36', '61395.38', NULL, NULL, '60687.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(584, 118, '301', NULL, '61506', '463', 117, 10, NULL, 67, '', NULL, NULL, '0.00', '35.20', '90.34', '376.40', 610.67, '162.00', '12.65', '61690.46', NULL, NULL, '60976.80', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(585, 118, '389', NULL, '61514', '287', 147, 10, NULL, 67, '', NULL, NULL, '0.00', '35.50', '112.72', '472.80', 705.60, '149.00', '15.78', '71281.30', NULL, NULL, '70447.20', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(586, 118, '408', NULL, '61498', '584', 278, 10, NULL, 67, '', NULL, NULL, '0.00', '35.50', '79.87', '332.80', 579.87, '174.00', '11.18', '58578.12', NULL, NULL, '57907.20', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(587, 118, '411', NULL, '61496', '844', 247, 11, NULL, 67, '', NULL, NULL, '0.00', '38.20', '89.14', '371.40', 658.27, '177.00', '12.48', '66497.69', NULL, NULL, '65737.80', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(588, 118, '452', NULL, '61516', '1154', 279, 10, 0, 67, '', NULL, NULL, '0.00', '26.40', '122.74', '511.40', 1029.14, '201.00', '17.18', '103960.46', NULL, NULL, '102791.40', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(589, 118, '453', NULL, '61517', '1155', 279, 10, 0, 67, '', NULL, NULL, '0.00', '26.40', '124.80', '520.00', 942.45, '181.00', '17.47', '95204.72', NULL, NULL, '94120.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(590, 118, '482', NULL, '61497', '542', 248, 10, NULL, 67, '', NULL, NULL, '0.00', '37.20', '131.14', '546.40', 968.44, '177.00', '18.36', '97830.74', NULL, NULL, '96712.80', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(591, 118, '543', NULL, '61508', '1357', 152, 10, NULL, 67, '', NULL, NULL, '0.00', '35.20', '81.94', '341.40', 557.30, '163.00', '11.47', '56298.91', NULL, NULL, '55648.20', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(592, 118, '621', NULL, '61509', '850', 280, 22, 0, 67, '', NULL, NULL, '0.00', '35.20', '98.74', '411.40', 651.00, '158.00', '13.82', '65764.76', NULL, NULL, '65001.20', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(593, 118, '623', NULL, '61499', '1365', 214, 11, NULL, 67, '', NULL, NULL, '0.00', '32.50', '143.45', '631.40', 898.02, '142.00', '20.08', '90720.36', NULL, NULL, '89658.80', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(594, 118, '624', NULL, '61500', '1374', 214, 11, NULL, 67, '', NULL, NULL, '0.00', '32.50', '113.14', '471.40', 741.23, '157.00', '15.84', '74880.01', NULL, NULL, '74009.80', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(595, 118, '626', NULL, '61501', '1390', 214, 11, NULL, 67, '', NULL, NULL, '0.00', '32.50', '103.33', '471.40', 646.85, '137.00', '14.47', '65346.45', NULL, NULL, '64581.80', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(596, 118, '639', NULL, '61502', '1392', 214, 10, NULL, 67, '', NULL, NULL, '0.00', '33.50', '116.74', '486.40', 759.95, '156.00', '16.34', '76771.43', NULL, NULL, '75878.40', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(597, 118, '656', NULL, '61503', '1386', 214, 22, NULL, 67, '', NULL, NULL, '0.00', '35.50', '115.67', '516.40', 724.12, '140.00', '16.19', '73151.98', NULL, NULL, '72296.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(598, 118, '661', NULL, '61504', '1434', 214, 22, NULL, 67, '', NULL, NULL, '0.00', '34.50', '106.70', '501.40', 667.93, '133.00', '14.94', '67475.77', NULL, NULL, '66686.20', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(599, 118, '668', NULL, '61512', '652', 98, 10, NULL, 67, '', NULL, NULL, '0.00', '34.50', '120.34', '501.40', 838.54, '167.00', '16.85', '84709.53', NULL, NULL, '83733.80', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(600, 118, '669', NULL, '61513', '656', 98, 10, 0, 67, '', NULL, NULL, '0.00', '34.50', '122.40', '510.00', 863.12, '169.00', '17.14', '87192.66', NULL, NULL, '86190.00', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(601, 118, '706', NULL, '61511', '483', 244, 11, NULL, 67, '', NULL, NULL, '0.00', '34.20', '79.54', '331.40', 501.21, '151.00', '11.14', '50633.28', NULL, NULL, '50041.40', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(602, 118, '713', NULL, '61510', '401', 112, 22, NULL, 67, '', NULL, NULL, '0.00', '38.20', '125.75', '561.40', 787.22, '140.00', '17.61', '79526.57', NULL, NULL, '78596.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(603, 119, '0090', NULL, '', '718', 34, 10, NULL, 7, '', NULL, NULL, '0.00', '37.20', '111.00', '370.00', 633.81, '171.00', '15.54', '64030.35', NULL, NULL, '63270.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(604, 119, '0090', NULL, '', '718', 34, 10, NULL, 7, '', NULL, NULL, '0.00', '37.20', '111.00', '370.00', 633.81, '171.00', '15.54', '64030.35', NULL, NULL, '63270.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(605, 119, '0120', NULL, '0', '928', 92, 11, NULL, 7, '', NULL, NULL, '0.00', '35.20', '102.90', '343.00', 488.09, '142.00', '14.41', '49311.39', NULL, NULL, '48706.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(606, 119, '0120', NULL, '0', '928', 92, 11, NULL, 7, '', NULL, NULL, '0.00', '35.20', '102.90', '343.00', 488.09, '142.00', '14.41', '49311.39', NULL, NULL, '48706.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(607, 119, '0127', NULL, '0', '897', 92, 10, NULL, 7, '', NULL, NULL, '0.00', '38.20', '342.00', '1140.00', 1622.22, '142.00', '47.88', '163892.10', NULL, NULL, '161880.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(608, 119, '0127', NULL, '0', '897', 92, 10, NULL, 7, '', NULL, NULL, '0.00', '38.20', '342.00', '1140.00', 1622.22, '142.00', '47.88', '163892.10', NULL, NULL, '161880.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(609, 119, '0128', NULL, '0', '905', 92, 10, NULL, 7, '', NULL, NULL, '0.00', '38.20', '168.90', '563.00', 806.78, '143.00', '23.65', '81508.32', NULL, NULL, '80509.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(610, 119, '0128', NULL, '0', '905', 42, 10, NULL, 7, '', NULL, NULL, '0.00', '38.20', '168.90', '563.00', 806.78, '143.00', '23.65', '81508.32', NULL, NULL, '80509.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(611, 119, '0132', NULL, '0', '931', 92, 10, NULL, 7, '', NULL, NULL, '0.00', '38.00', '168.90', '563.00', 739.22, '131.00', '23.65', '74684.76', NULL, NULL, '73753.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(612, 119, '0132', NULL, '0', '931', 92, 10, NULL, 7, '', NULL, NULL, '0.00', '38.20', '168.90', '563.00', 739.22, '131.00', '23.65', '74684.76', NULL, NULL, '73753.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(613, 120, '258', NULL, '146816190', '624', 281, 23, NULL, 61, '', NULL, NULL, '0.00', '25.40', '111.24', '370.80', 468.32, '126.00', '15.57', '47315.93', NULL, NULL, '46720.80', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(614, 120, '266', NULL, '14682298', '418', 282, 22, NULL, 52, '', NULL, NULL, '0.00', '26.17', '75.90', '253.00', 370.14, '146.00', '10.63', '37394.67', NULL, NULL, '36938.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(615, 120, '268', NULL, '14682398', '484', 282, 15, NULL, 52, '', NULL, NULL, '0.00', '26.20', '51.90', '173.00', 234.07, '135.00', '7.27', '23648.24', NULL, NULL, '23355.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(616, 120, '335', NULL, '146821658', '070675', 283, 15, NULL, 42, '', NULL, NULL, '0.00', '35.20', '105.00', '350.00', 526.05, '150.00', '14.70', '53145.75', NULL, NULL, '52500.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(617, 120, '248', NULL, '146827113', '920934', 61, 11, NULL, 47, '', NULL, NULL, '0.00', '40.25', '175.80', '586.00', 851.46, '145.00', '24.61', '86021.87', NULL, NULL, '84970.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(618, 120, '1255', NULL, '146824128', '921091', 61, 11, NULL, 75, '', NULL, NULL, '0.00', '40.25', '177.90', '593.00', 831.98, '140.00', '24.91', '84054.79', NULL, NULL, '83020.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(619, 120, '1342', NULL, '146825272', '769', 85, 10, NULL, 75, '', NULL, NULL, '0.00', '35.20', '155.40', '518.00', 628.33, '121.00', '21.76', '63483.49', NULL, NULL, '62678.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(620, 120, '1355', NULL, '146826254', '741', 85, 15, NULL, 75, '', NULL, NULL, '0.00', '34.20', '141.90', '473.00', 625.78, '132.00', '19.87', '63223.54', NULL, NULL, '62436.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(621, 120, '1389', NULL, '146820187', '837', 272, 22, NULL, 30, '', NULL, NULL, '0.00', '35.20', '155.40', '518.00', 773.37, '149.00', '21.76', '78132.53', NULL, NULL, '77182.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(622, 120, '1394', NULL, '146817203', '904', 272, 22, NULL, 34, '', NULL, NULL, '0.00', '35.20', '157.50', '525.00', 762.83, '145.00', '22.05', '77067.38', NULL, NULL, '76125.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(623, 120, '1406', NULL, '146818169', '671', 84, 22, NULL, 34, '', NULL, NULL, '0.00', '40.60', '477.90', '1593.00', 2330.56, '146.00', '66.91', '235453.36', NULL, NULL, '232578.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(624, 120, '1408', NULL, '146819174', '689', 84, 22, NULL, 34, '', NULL, NULL, '0.00', '30.40', '132.90', '443.00', 608.24, '137.00', '18.61', '61450.75', NULL, NULL, '60691.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(625, 121, '354', NULL, '49190', '725', 220, 10, NULL, 25, '', NULL, NULL, '1.00', '38.50', '168.90', '563.00', 1077.03, '191.00', '23.65', '108803.57', NULL, NULL, '107533.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(626, 121, '361', NULL, '49191', '506', 232, 11, NULL, 25, '', NULL, NULL, '1.00', '37.45', '111.00', '370.00', 630.12, '170.00', '15.54', '63657.66', NULL, NULL, '62900.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(627, 121, '362', NULL, '49192', '532', 232, 11, NULL, 25, '', NULL, NULL, '1.00', '37.45', '111.00', '370.00', 663.42, '179.00', '15.54', '67020.96', NULL, NULL, '66230.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(628, 121, '363', NULL, '49193', '536', 232, 11, NULL, 25, '', NULL, NULL, '1.00', '37.45', '111.00', '370.00', 648.62, '175.00', '15.54', '65526.16', NULL, NULL, '64750.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(629, 121, '364', NULL, '49194', '506', 232, 10, NULL, 25, '', NULL, NULL, '1.00', '37.45', '111.00', '370.00', 681.92, '184.00', '15.54', '68889.46', NULL, NULL, '68080.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(630, 121, '368', NULL, '49186', '980646', 102, 10, NULL, 70, '', NULL, NULL, '1.00', '42.20', '252.00', '840.00', 1472.53, '175.00', '35.28', '148760.81', NULL, NULL, '147000.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(631, 121, '369', NULL, '49187', '980654', 102, 10, NULL, 70, '', NULL, NULL, '1.00', '42.20', '189.00', '630.00', 1180.00, '187.00', '26.46', '119206.46', NULL, NULL, '117810.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(632, 121, '370', NULL, '49188', '980660', 102, 10, NULL, 70, '', NULL, NULL, '1.00', '42.20', '186.90', '623.00', 1123.28, '180.00', '26.17', '113477.35', NULL, NULL, '112140.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(633, 121, '371', NULL, '49189', '980662', 102, 10, NULL, 70, '', NULL, NULL, '1.00', '42.20', '189.00', '630.00', 1180.00, '187.00', '26.46', '119206.46', NULL, NULL, '117810.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(634, 122, '7330', NULL, '145058', '924', 132, 28, 0, 66, '', NULL, NULL, '0.00', '21.40', '68.22', '227.40', 546.44, '240.00', '9.55', '55200.21', NULL, NULL, '54576.00', NULL, 'V', 7, 11, 8);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(635, 122, '7338', NULL, '145059', '923', 132, 26, 0, 66, '', NULL, NULL, '0.00', '27.40', '104.22', '347.40', 626.36, '180.00', '14.59', '63277.17', NULL, NULL, '62532.00', NULL, 'V', 7, 11, 8);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(636, 122, '7389', NULL, '145060', '280', 225, 33, NULL, 24, '', NULL, NULL, '0.00', '32.45', '105.16', '412.40', 351.59, '85.00', '14.72', '35525.47', NULL, NULL, '35054.00', 0, 'V', 7, 11, 8);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(637, 122, '7394', NULL, '145061', '287', 225, 37, 0, 77, '', NULL, NULL, '0.00', '26.45', '115.92', '386.40', 580.76, '150.00', '16.23', '58672.91', NULL, NULL, '57960.00', NULL, 'V', 7, 11, 8);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(638, 123, '0189', NULL, '0', '667', 285, 15, NULL, 29, '', NULL, NULL, '0.00', '33.20', '166.20', '554.00', 810.50, '146.00', '23.27', '81883.97', NULL, NULL, '80884.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(639, 123, '0359', NULL, '', '0992', 229, 10, NULL, 75, '', NULL, NULL, '0.00', '38.20', '111.90', '373.00', 743.39, '199.00', '15.67', '75097.96', NULL, NULL, '74227.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(640, 123, '0376', NULL, '', '1159', 138, 14, NULL, 21, '', NULL, NULL, '0.00', '35.20', '157.50', '525.00', 789.08, '150.00', '22.05', '79718.63', NULL, NULL, '78750.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(641, 123, '0394', NULL, '', '1162', 138, 23, NULL, 21, '', NULL, NULL, '0.00', '35.20', '103.74', '345.80', 505.91, '146.00', '14.52', '51110.97', NULL, NULL, '50486.80', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(642, 123, '0396', NULL, '', '1192', 138, 23, NULL, 21, '', NULL, NULL, '0.00', '35.20', '102.90', '343.00', 484.66, '141.00', '14.41', '48964.96', NULL, NULL, '48363.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(643, 123, '0405', NULL, '', '1231', 139, 22, NULL, 21, '', NULL, NULL, '0.00', '35.70', '105.00', '350.00', 540.05, '154.00', '14.70', '54559.75', NULL, NULL, '53900.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(644, 123, '0406', NULL, '', '1232', 139, 22, NULL, 21, '', NULL, NULL, '0.00', '35.70', '105.00', '350.00', 547.05, '156.00', '14.70', '55266.75', NULL, NULL, '54600.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(645, 124, '0189', NULL, '0', '667', 285, 15, NULL, 29, '', NULL, NULL, '0.00', '33.20', '166.20', '554.00', 810.50, '146.00', '23.27', '81883.97', NULL, NULL, '80884.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(646, 124, '0359', NULL, '', '0992', 229, 10, NULL, 75, '', NULL, NULL, '0.00', '38.20', '111.90', '373.00', 743.39, '199.00', '15.67', '75097.96', NULL, NULL, '74227.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(647, 124, '0376', NULL, '', '1159', 138, 14, NULL, 21, '', NULL, NULL, '0.00', '35.20', '157.50', '525.00', 789.08, '150.00', '22.05', '79718.63', NULL, NULL, '78750.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(648, 124, '0394', NULL, '', '1162', 138, 23, NULL, 21, '', NULL, NULL, '0.00', '35.20', '103.74', '345.80', 505.91, '146.00', '14.52', '51110.97', NULL, NULL, '50486.80', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(649, 124, '0396', NULL, '', '1192', 138, 23, NULL, 21, '', NULL, NULL, '0.00', '35.20', '102.90', '343.00', 484.66, '141.00', '14.41', '48964.96', NULL, NULL, '48363.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(650, 124, '0405', NULL, '', '1231', 139, 22, NULL, 21, '', NULL, NULL, '0.00', '35.70', '105.00', '350.00', 540.05, '154.00', '14.70', '54559.75', NULL, NULL, '53900.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(651, 124, '0406', NULL, '', '1232', 139, 22, NULL, 21, '', NULL, NULL, '0.00', '35.70', '105.00', '350.00', 547.05, '156.00', '14.70', '55266.75', NULL, NULL, '54600.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(652, 125, '206', NULL, '12822', '287', 286, 10, NULL, 64, '', NULL, NULL, '0.00', '35.20', '157.50', '525.00', 636.83, '121.00', '22.05', '64341.38', NULL, NULL, '63525.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(653, 125, '218', NULL, '12823', '289', 286, 16, NULL, 64, '', NULL, NULL, '0.00', '30.80', '103.74', '345.80', 471.33, '136.00', '14.52', '47618.39', NULL, NULL, '47028.80', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(654, 126, '5036', NULL, '12524', '181', 219, 28, NULL, 77, '', NULL, NULL, '0.00', '27.60', '120.27', '400.90', 566.47, '141.00', '16.84', '57230.48', NULL, NULL, '56526.90', 0, 'V', 7, 11, 6);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(655, 127, '0', NULL, '', '3282', 270, 14, NULL, 67, '', NULL, NULL, '0.00', '32.20', '0.00', '800.00', 3057.60, '76.44', '0.00', '64209.60', NULL, NULL, '61152.00', 0, 'V', 6, 0, 9);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(656, 127, '0', NULL, '', '3284', 270, 16, NULL, 67, '', NULL, NULL, '0.00', '32.50', '0.00', '640.00', 2446.08, '76.44', '0.00', '51367.68', NULL, NULL, '48921.60', 0, 'V', 6, 0, 7);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(657, 128, '11', NULL, '7857', '413', 159, 10, 13, 7, '', NULL, NULL, '0.00', '30.20', '0.00', '450.00', 3105.00, '138.00', '0.00', '65205.00', NULL, NULL, '62100.00', 0, 'V', 6, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(658, 128, '282', NULL, '49359', '800', 262, 11, 14, 7, '', NULL, NULL, '0.00', '35.20', '0.00', '516.40', 3227.50, '125.00', '0.00', '67777.50', NULL, NULL, '64550.00', 0, 'V', 6, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(659, 128, '381', NULL, '49360', '649', 151, 22, 24, 7, '', NULL, NULL, '0.00', '35.20', '0.00', '376.40', 2578.34, '137.00', '0.00', '54145.14', NULL, NULL, '51566.80', 0, 'V', 6, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(660, 128, '592', NULL, '49356', '196', 122, 11, 18, 7, '', NULL, NULL, '0.00', '38.22', '0.00', '181.40', 1197.24, '132.00', '0.00', '25142.04', NULL, NULL, '23944.80', 0, 'V', 6, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(661, 128, '595', NULL, '49357', '196', 122, 10, 13, 7, '', NULL, NULL, '0.00', '38.22', '0.00', '561.40', 3621.03, '129.00', '0.00', '76041.63', NULL, NULL, '72420.60', 0, 'V', 6, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(662, 128, '596', NULL, '49358', '197', 122, 10, 13, 7, '', NULL, NULL, '0.00', '38.22', '0.00', '561.40', 3536.82, '126.00', '0.00', '74273.22', NULL, NULL, '70736.40', 0, 'V', 6, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(663, 129, '70', '2015-12-22', '3510', '492', 255, 10, NULL, 67, '', NULL, NULL, '0.00', '26.20', '97.34', '520.00', 609.37, '117.00', '13.63', '61560.34', NULL, NULL, '60840.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(664, 129, '73', '2016-01-22', '3511', '492', 255, 22, NULL, 67, '', NULL, NULL, '0.00', '26.20', '96.51', '520.00', 604.17, '116.00', '13.51', '61034.19', NULL, NULL, '60320.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(665, 130, '224', NULL, '59488', '1320', 59, 10, NULL, 67, '', NULL, NULL, '0.00', '38.50', '134.74', '561.40', 1068.01, '190.00', '18.86', '107887.61', NULL, NULL, '106666.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(666, 130, '264', NULL, '59490', '859', 137, 14, NULL, 67, '', NULL, NULL, '0.00', '35.20', '84.00', '350.00', 529.34, '151.00', '11.76', '53475.10', NULL, NULL, '52850.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(667, 130, '266', NULL, '59491', '866', 137, 14, NULL, 67, '', NULL, NULL, '0.00', '35.20', '81.94', '341.40', 533.40, '156.00', '11.47', '53885.21', NULL, NULL, '53258.40', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(668, 130, '302', NULL, '59783', '780', 266, 10, NULL, 67, '', NULL, NULL, '0.00', '26.20', '104.02', '433.40', 807.16, '186.00', '14.56', '81538.15', NULL, NULL, '80612.40', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(669, 130, '316', NULL, '59484', '990', 289, 10, 0, 67, '', NULL, NULL, '0.00', '35.50', '123.94', '516.40', 832.64, '161.00', '17.35', '84114.33', NULL, NULL, '83140.40', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(670, 130, '317', NULL, '59485', '992', 289, 10, 0, 67, '', NULL, NULL, '0.00', '35.50', '123.94', '516.40', 822.32, '159.00', '17.35', '83071.21', NULL, NULL, '82107.60', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(671, 130, '320', NULL, '59486', '1004', 289, 10, 0, 67, '', NULL, NULL, '0.00', '35.50', '123.94', '516.40', 822.32, '159.00', '17.35', '83071.21', NULL, NULL, '82107.60', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(672, 130, '322', NULL, '59487', '989', 289, 22, 0, 67, '', NULL, NULL, '0.00', '35.50', '81.94', '341.40', 567.54, '166.00', '11.47', '57333.35', NULL, NULL, '56672.40', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(673, 130, '410', NULL, '59489', '882', 280, 11, NULL, 67, '', NULL, NULL, '0.00', '30.20', '121.92', '600.00', 763.22, '127.00', '17.07', '77102.21', NULL, NULL, '76200.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(674, 131, '3030', NULL, '0', '070756', 283, 39, 0, 78, '', NULL, NULL, '0.00', '35.20', '51.24', '170.80', 205.47, '120.00', '7.17', '20759.89', NULL, NULL, '20496.00', NULL, 'V', 7, 11, 7);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(675, 132, '99', '2016-01-04', '50497', '586', 52, 14, NULL, 67, '', NULL, NULL, '0.00', '38.20', '134.74', '561.40', 966.96, '172.00', '18.86', '97681.36', NULL, NULL, '96560.80', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(676, 132, '124', '2016-01-04', '50508', '911', 51, 14, NULL, 67, '', NULL, NULL, '0.00', '38.20', '89.14', '371.40', 598.85, '161.00', '12.48', '60495.86', NULL, NULL, '59795.40', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(677, 132, '148', '2016-01-04', '504999', '1905', 155, 23, NULL, 67, '', NULL, NULL, '0.00', '35.20', '96.10', '411.40', 601.60, '146.00', '13.45', '60775.56', NULL, NULL, '60064.40', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(678, 132, '157', '2016-01-04', '50502', '1011', 257, 10, NULL, 67, '', NULL, NULL, '0.00', '38.20', '132.67', '552.80', 941.09, '170.00', '18.57', '95068.33', NULL, NULL, '93976.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(679, 132, '158', '2016-01-04', '50495', '1024', 257, 10, NULL, 67, '', NULL, NULL, '0.00', '38.20', '132.67', '552.80', 941.09, '170.00', '18.57', '95068.33', NULL, NULL, '93976.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(680, 132, '167', '2016-01-04', '50496', '347', 276, 14, NULL, 67, '', NULL, NULL, '0.00', '38.20', '134.74', '561.40', 849.06, '151.00', '18.86', '85774.06', NULL, NULL, '84771.40', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(681, 132, '186', '2016-01-04', '50500', '544', 157, 11, NULL, 67, '', NULL, NULL, '0.00', '35.20', '123.94', '516.40', 884.28, '171.00', '17.35', '89329.97', NULL, NULL, '88304.40', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(682, 132, '188', '2016-01-04', '50501', '541', 157, 14, NULL, 67, '', NULL, NULL, '0.00', '35.20', '123.94', '516.40', 806.82, '156.00', '17.35', '81506.51', NULL, NULL, '80558.40', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(683, 132, '197', '2016-01-04', '50503', '904', 277, 10, NULL, 67, '', NULL, NULL, '0.00', '35.20', '81.94', '341.40', 516.33, '151.00', '11.47', '52161.14', NULL, NULL, '51551.40', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(684, 132, '199', '2016-01-04', '50504', '912', 277, 10, NULL, 67, '', NULL, NULL, '0.00', '35.20', '157.92', '700.00', 988.58, '141.00', '22.11', '99868.61', NULL, NULL, '98700.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(685, 132, '214', '2016-01-04', '50505', '501', 244, 11, NULL, 67, '', NULL, NULL, '0.00', '26.44', '62.40', '260.00', 427.02, '164.00', '8.74', '43138.16', NULL, NULL, '42640.00', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(686, 132, '216', '2016-01-04', '50506', '501', 244, 10, NULL, 67, '', NULL, NULL, '0.00', '26.40', '72.82', '303.40', 513.47, '169.00', '10.19', '51871.09', NULL, NULL, '51274.60', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(687, 132, '286', '2016-01-04', '50498', '596', 290, 10, NULL, 67, '', NULL, NULL, '0.00', '30.50', '96.05', '441.40', 601.26, '136.00', '13.45', '60741.16', NULL, NULL, '60030.40', 0, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(688, 132, '294', '2016-01-04', '50507', '1448', 291, 10, 0, 67, '', NULL, NULL, '0.00', '35.20', '81.94', '341.40', 519.75, '152.00', '11.47', '52505.96', NULL, NULL, '51892.80', NULL, 'V', 7, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(689, 133, 'TEST123', '2016-01-14', '', 'TEST121/14-01-16', 34, 10, NULL, 23, '', '2016-01-14', NULL, '1.00', '0.00', '100.00', '30.00', 155.05, '100.00', '14.00', '3270.05', NULL, NULL, '3000.00', 0, 'V', 6, 11, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(690, 134, '0382', NULL, '25836', '436', 292, 14, 16, 67, '', NULL, NULL, '0.00', '35.20', '0.00', '411.40', 2283.27, '111.00', '0.00', '47948.67', NULL, NULL, '45665.40', 0, 'V', 6, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(691, 134, '0383', NULL, '25837', '437', 292, 23, 15, 67, '', NULL, NULL, '0.00', '38.20', '0.00', '371.40', 1968.42, '106.00', '0.00', '41336.82', NULL, NULL, '39368.40', 0, 'V', 6, 0, 9);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(692, 134, '0491', NULL, '25835', '537', 293, 23, 16, 67, '', NULL, NULL, '0.00', '35.20', '0.00', '341.40', 1365.60, '80.00', '0.00', '28677.60', NULL, NULL, '27312.00', 0, 'V', 6, 0, 9);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(693, 134, '0515', NULL, '25838', '120', 294, 10, 16, 67, '', NULL, NULL, '0.00', '35.50', '0.00', '341.40', 2475.15, '145.00', '0.00', '51978.15', NULL, NULL, '49503.00', 0, 'V', 6, 0, 5);
INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `location_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES(694, 135, '16', NULL, '', '962', 266, 10, 48, 67, '', NULL, NULL, '0.00', '35.20', '0.00', '560.00', 3567.20, '127.40', '0.00', '74911.20', NULL, NULL, '71344.00', 0, 'V', 6, 0, 5);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_invoice_master`
--

CREATE TABLE IF NOT EXISTS `purchase_invoice_master` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `purchase_invoice_number` varchar(255) DEFAULT NULL,
  `purchase_invoice_date` date DEFAULT NULL,
  `auctionareaid` int(20) DEFAULT '0',
  `vendor_id` int(10) DEFAULT NULL,
  `voucher_master_id` int(11) DEFAULT NULL,
  `sale_number` varchar(10) DEFAULT NULL,
  `sale_date` datetime DEFAULT NULL,
  `promt_date` datetime DEFAULT NULL,
  `tea_value` decimal(10,2) DEFAULT NULL,
  `brokerage` decimal(10,2) DEFAULT NULL,
  `service_tax` decimal(10,2) DEFAULT NULL,
  `total_cst` double(10,2) DEFAULT NULL,
  `total_vat` double(10,2) DEFAULT NULL,
  `chestage_allowance` decimal(10,2) DEFAULT NULL,
  `stamp` decimal(10,2) DEFAULT NULL,
  `other_charges` decimal(10,2) DEFAULT NULL,
  `round_off` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `company_id` int(11) NOT NULL,
  `year_id` int(11) NOT NULL,
  `from_where` enum('AS','PS','SB') DEFAULT NULL COMMENT 'AS=Auction Sale,PS=Private Sale,SB=Seller To byuer',
  PRIMARY KEY (`id`),
  KEY `FK_vendor_id` (`vendor_id`),
  KEY `voucher_master_id` (`voucher_master_id`),
  KEY `company_id` (`company_id`,`year_id`),
  KEY `year_id` (`year_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=136 ;

--
-- Dumping data for table `purchase_invoice_master`
--

INSERT INTO `purchase_invoice_master` (`id`, `purchase_invoice_number`, `purchase_invoice_date`, `auctionareaid`, `vendor_id`, `voucher_master_id`, `sale_number`, `sale_date`, `promt_date`, `tea_value`, `brokerage`, `service_tax`, `total_cst`, `total_vat`, `chestage_allowance`, `stamp`, `other_charges`, `round_off`, `total`, `company_id`, `year_id`, `from_where`) VALUES(49, 'PIP/AUC/KOL/L/2103', '2015-07-14', 1, 13, 54, '28', '2015-07-14 00:00:00', '2015-07-28 00:00:00', '217020.00', '408.60', '11.42', 0.00, 2174.29, '0.00', '3.00', NULL, NULL, '219617.31', 1, 1, 'AS');
INSERT INTO `purchase_invoice_master` (`id`, `purchase_invoice_number`, `purchase_invoice_date`, `auctionareaid`, `vendor_id`, `voucher_master_id`, `sale_number`, `sale_date`, `promt_date`, `tea_value`, `brokerage`, `service_tax`, `total_cst`, `total_vat`, `chestage_allowance`, `stamp`, `other_charges`, `round_off`, `total`, `company_id`, `year_id`, `from_where`) VALUES(50, 'CB/K/CT/15-16/1478', '2015-07-14', 0, 45, 55, '28', '2015-07-14 00:00:00', '2015-07-28 00:00:00', '85296.00', '188.70', '0.00', 0.00, 854.85, '0.00', '2.00', NULL, NULL, '86341.55', 1, 1, 'AS');
INSERT INTO `purchase_invoice_master` (`id`, `purchase_invoice_number`, `purchase_invoice_date`, `auctionareaid`, `vendor_id`, `voucher_master_id`, `sale_number`, `sale_date`, `promt_date`, `tea_value`, `brokerage`, `service_tax`, `total_cst`, `total_vat`, `chestage_allowance`, `stamp`, `other_charges`, `round_off`, `total`, `company_id`, `year_id`, `from_where`) VALUES(51, 'ABL/KOL1850/15-16', '2015-07-14', 1, 25, 56, '28', '2015-07-14 00:00:00', '2015-07-28 00:00:00', '259200.00', '504.90', '0.00', 0.00, 2597.05, '0.00', '0.00', NULL, NULL, '262301.95', 1, 1, 'AS');
INSERT INTO `purchase_invoice_master` (`id`, `purchase_invoice_number`, `purchase_invoice_date`, `auctionareaid`, `vendor_id`, `voucher_master_id`, `sale_number`, `sale_date`, `promt_date`, `tea_value`, `brokerage`, `service_tax`, `total_cst`, `total_vat`, `chestage_allowance`, `stamp`, `other_charges`, `round_off`, `total`, `company_id`, `year_id`, `from_where`) VALUES(52, 'CB/SL/CT/15-16/2554', '2015-07-22', 2, 22, 57, '32', '2015-07-22 00:00:00', '2015-08-04 00:00:00', '294111.00', '398.07', '55.72', 0.00, 2945.10, '0.00', '0.00', NULL, NULL, '297509.89', 1, 1, 'AS');
INSERT INTO `purchase_invoice_master` (`id`, `purchase_invoice_number`, `purchase_invoice_date`, `auctionareaid`, `vendor_id`, `voucher_master_id`, `sale_number`, `sale_date`, `promt_date`, `tea_value`, `brokerage`, `service_tax`, `total_cst`, `total_vat`, `chestage_allowance`, `stamp`, `other_charges`, `round_off`, `total`, `company_id`, `year_id`, `from_where`) VALUES(53, 'ABL/KOL2911/15-16', '2015-08-25', 1, 25, 58, '34', '2015-08-25 00:00:00', '2015-09-08 00:00:00', '540542.00', '1034.10', '144.79', 0.00, 5415.76, '-0.02', '0.00', NULL, NULL, '547136.65', 1, 1, 'AS');
INSERT INTO `purchase_invoice_master` (`id`, `purchase_invoice_number`, `purchase_invoice_date`, `auctionareaid`, `vendor_id`, `voucher_master_id`, `sale_number`, `sale_date`, `promt_date`, `tea_value`, `brokerage`, `service_tax`, `total_cst`, `total_vat`, `chestage_allowance`, `stamp`, `other_charges`, `round_off`, `total`, `company_id`, `year_id`, `from_where`) VALUES(78, 'T-001', '2015-09-25', 1, 18, 57, '123', '1970-01-01 00:00:00', '2015-09-25 00:00:00', '32800.00', '120.00', '16.80', 0.00, 329.20, NULL, '1.00', NULL, NULL, '33267.00', 1, 1, 'AS');
INSERT INTO `purchase_invoice_master` (`id`, `purchase_invoice_number`, `purchase_invoice_date`, `auctionareaid`, `vendor_id`, `voucher_master_id`, `sale_number`, `sale_date`, `promt_date`, `tea_value`, `brokerage`, `service_tax`, `total_cst`, `total_vat`, `chestage_allowance`, `stamp`, `other_charges`, `round_off`, `total`, `company_id`, `year_id`, `from_where`) VALUES(79, 'PTM/DL/15/0315', '2015-09-15', 1, 19, 57, '37', '2015-09-15 00:00:00', '2015-09-29 00:00:00', '511560.00', '219.24', '30.69', 0.00, 1704.75, NULL, '0.00', NULL, NULL, '513514.68', 1, 1, 'AS');
INSERT INTO `purchase_invoice_master` (`id`, `purchase_invoice_number`, `purchase_invoice_date`, `auctionareaid`, `vendor_id`, `voucher_master_id`, `sale_number`, `sale_date`, `promt_date`, `tea_value`, `brokerage`, `service_tax`, `total_cst`, `total_vat`, `chestage_allowance`, `stamp`, `other_charges`, `round_off`, `total`, `company_id`, `year_id`, `from_where`) VALUES(80, 'PIP/AUC/KOL/L/3883', '2015-09-15', 1, 13, 57, '37', '2015-09-15 00:00:00', '2015-09-29 00:00:00', '424475.00', '861.30', '120.59', 0.00, 4253.41, NULL, '6.00', NULL, NULL, '429716.30', 1, 1, 'AS');
INSERT INTO `purchase_invoice_master` (`id`, `purchase_invoice_number`, `purchase_invoice_date`, `auctionareaid`, `vendor_id`, `voucher_master_id`, `sale_number`, `sale_date`, `promt_date`, `tea_value`, `brokerage`, `service_tax`, `total_cst`, `total_vat`, `chestage_allowance`, `stamp`, `other_charges`, `round_off`, `total`, `company_id`, `year_id`, `from_where`) VALUES(81, 'CB/K/CT/15-16/3762', '2015-11-04', 1, 45, NULL, '44', '2015-11-04 00:00:00', '2015-11-18 00:00:00', '393534.40', '706.14', '98.86', 0.00, 3942.45, NULL, '4.00', '0.00', '0.00', '398285.85', 1, 1, 'AS');
INSERT INTO `purchase_invoice_master` (`id`, `purchase_invoice_number`, `purchase_invoice_date`, `auctionareaid`, `vendor_id`, `voucher_master_id`, `sale_number`, `sale_date`, `promt_date`, `tea_value`, `brokerage`, `service_tax`, `total_cst`, `total_vat`, `chestage_allowance`, `stamp`, `other_charges`, `round_off`, `total`, `company_id`, `year_id`, `from_where`) VALUES(82, 'NB/L-3973', '2015-12-02', 2, 37, NULL, '48', '2015-12-02 00:00:00', '2015-12-16 00:00:00', '55950.40', '89.52', '12.53', 0.00, 560.40, NULL, '0.00', '0.45', '-0.30', '56613.00', 1, 1, 'AS');
INSERT INTO `purchase_invoice_master` (`id`, `purchase_invoice_number`, `purchase_invoice_date`, `auctionareaid`, `vendor_id`, `voucher_master_id`, `sale_number`, `sale_date`, `promt_date`, `tea_value`, `brokerage`, `service_tax`, `total_cst`, `total_vat`, `chestage_allowance`, `stamp`, `other_charges`, `round_off`, `total`, `company_id`, `year_id`, `from_where`) VALUES(83, 'PIP/AUC/SLG/6206', '2015-12-02', 2, 21, NULL, '48', '2015-12-02 00:00:00', '2015-12-16 00:00:00', '1153051.50', '1655.75', '231.79', 0.00, 11547.09, NULL, '0.00', '0.00', '0.00', '0.00', 1, 1, 'AS');
INSERT INTO `purchase_invoice_master` (`id`, `purchase_invoice_number`, `purchase_invoice_date`, `auctionareaid`, `vendor_id`, `voucher_master_id`, `sale_number`, `sale_date`, `promt_date`, `tea_value`, `brokerage`, `service_tax`, `total_cst`, `total_vat`, `chestage_allowance`, `stamp`, `other_charges`, `round_off`, `total`, `company_id`, `year_id`, `from_where`) VALUES(84, 'TC/L-3358', '2015-12-02', 2, 41, 57, '48', '2015-12-02 00:00:00', '2015-12-16 00:00:00', '737212.10', '1229.10', '154.71', 0.00, 6608.79, NULL, '0.00', '-1352.70', '0.00', '-1352.70', 1, 1, 'AS');
INSERT INTO `purchase_invoice_master` (`id`, `purchase_invoice_number`, `purchase_invoice_date`, `auctionareaid`, `vendor_id`, `voucher_master_id`, `sale_number`, `sale_date`, `promt_date`, `tea_value`, `brokerage`, `service_tax`, `total_cst`, `total_vat`, `chestage_allowance`, `stamp`, `other_charges`, `round_off`, `total`, `company_id`, `year_id`, `from_where`) VALUES(85, 'PIP/AUC/SLG/L/5997', '2015-11-26', 2, 21, NULL, '47', '2015-11-26 00:00:00', '2015-12-10 00:00:00', '1301466.00', '2013.75', '252.04', 0.00, 13034.82, NULL, '0.00', '0.00', '-0.04', '1316766.57', 1, 1, 'AS');
INSERT INTO `purchase_invoice_master` (`id`, `purchase_invoice_number`, `purchase_invoice_date`, `auctionareaid`, `vendor_id`, `voucher_master_id`, `sale_number`, `sale_date`, `promt_date`, `tea_value`, `brokerage`, `service_tax`, `total_cst`, `total_vat`, `chestage_allowance`, `stamp`, `other_charges`, `round_off`, `total`, `company_id`, `year_id`, `from_where`) VALUES(86, 'JT/AUC/SLG/L/6102', '2015-11-26', 2, 20, 57, '47', '2015-11-26 00:00:00', '2015-12-10 00:00:00', '992781.20', '1501.60', '210.24', 0.00, 9942.82, NULL, '0.00', '7.50', '-0.35', '1004443.01', 1, 1, 'AS');
INSERT INTO `purchase_invoice_master` (`id`, `purchase_invoice_number`, `purchase_invoice_date`, `auctionareaid`, `vendor_id`, `voucher_master_id`, `sale_number`, `sale_date`, `promt_date`, `tea_value`, `brokerage`, `service_tax`, `total_cst`, `total_vat`, `chestage_allowance`, `stamp`, `other_charges`, `round_off`, `total`, `company_id`, `year_id`, `from_where`) VALUES(87, 'NB/L-3844', '2015-11-27', 2, 37, 57, '47', '2015-11-27 00:00:00', '2015-12-11 00:00:00', '860282.40', '1354.52', '189.64', 0.00, 8616.37, NULL, '0.00', '6.77', '0.30', '6.77', 1, 1, 'AS');
INSERT INTO `purchase_invoice_master` (`id`, `purchase_invoice_number`, `purchase_invoice_date`, `auctionareaid`, `vendor_id`, `voucher_master_id`, `sale_number`, `sale_date`, `promt_date`, `tea_value`, `brokerage`, `service_tax`, `total_cst`, `total_vat`, `chestage_allowance`, `stamp`, `other_charges`, `round_off`, `total`, `company_id`, `year_id`, `from_where`) VALUES(88, 'CB/SL/CT/15-16/5695', '2015-11-28', 2, 22, 57, '47', '2015-11-28 00:00:00', '2015-12-14 00:00:00', '369067.80', '525.08', '73.50', 0.00, 3695.93, NULL, '0.00', '2.61', '0.08', '373365.00', 1, 1, 'AS');
INSERT INTO `purchase_invoice_master` (`id`, `purchase_invoice_number`, `purchase_invoice_date`, `auctionareaid`, `vendor_id`, `voucher_master_id`, `sale_number`, `sale_date`, `promt_date`, `tea_value`, `brokerage`, `service_tax`, `total_cst`, `total_vat`, `chestage_allowance`, `stamp`, `other_charges`, `round_off`, `total`, `company_id`, `year_id`, `from_where`) VALUES(89, '111', '2015-12-15', 0, 18, 57, '11', '2015-12-15 00:00:00', '2015-12-29 00:00:00', '33300.00', '100.00', '14.00', 0.00, 334.00, NULL, '0.00', '2.00', '0.00', '33750.00', 1, 1, 'AS');
INSERT INTO `purchase_invoice_master` (`id`, `purchase_invoice_number`, `purchase_invoice_date`, `auctionareaid`, `vendor_id`, `voucher_master_id`, `sale_number`, `sale_date`, `promt_date`, `tea_value`, `brokerage`, `service_tax`, `total_cst`, `total_vat`, `chestage_allowance`, `stamp`, `other_charges`, `round_off`, `total`, `company_id`, `year_id`, `from_where`) VALUES(90, 'PIP/AUC/KOL/L/6220', '2015-12-10', 1, 13, 57, '49', '2015-12-10 00:00:00', '2015-12-24 00:00:00', '91188.00', '189.30', '26.51', 0.00, 913.79, NULL, '2.00', '0.95', '0.45', '92321.00', 1, 1, 'AS');
INSERT INTO `purchase_invoice_master` (`id`, `purchase_invoice_number`, `purchase_invoice_date`, `auctionareaid`, `vendor_id`, `voucher_master_id`, `sale_number`, `sale_date`, `promt_date`, `tea_value`, `brokerage`, `service_tax`, `total_cst`, `total_vat`, `chestage_allowance`, `stamp`, `other_charges`, `round_off`, `total`, `company_id`, `year_id`, `from_where`) VALUES(91, 'MTC/188/15-16', '2015-12-09', 0, 52, NULL, '0', '2015-12-09 00:00:00', '2015-12-16 00:00:00', '119246.40', '0.00', '0.00', 0.00, 5962.32, NULL, '0.00', '0.00', '0.28', '125209.00', 1, 1, 'SB');
INSERT INTO `purchase_invoice_master` (`id`, `purchase_invoice_number`, `purchase_invoice_date`, `auctionareaid`, `vendor_id`, `voucher_master_id`, `sale_number`, `sale_date`, `promt_date`, `tea_value`, `brokerage`, `service_tax`, `total_cst`, `total_vat`, `chestage_allowance`, `stamp`, `other_charges`, `round_off`, `total`, `company_id`, `year_id`, `from_where`) VALUES(92, 'UTT/076/15-16', '2015-12-16', 0, 39, NULL, '0', '2015-12-16 00:00:00', '2015-12-30 00:00:00', '934748.00', '0.00', '0.00', 0.00, 46737.40, NULL, '0.00', '0.00', '0.00', '981485.40', 1, 1, 'SB');
INSERT INTO `purchase_invoice_master` (`id`, `purchase_invoice_number`, `purchase_invoice_date`, `auctionareaid`, `vendor_id`, `voucher_master_id`, `sale_number`, `sale_date`, `promt_date`, `tea_value`, `brokerage`, `service_tax`, `total_cst`, `total_vat`, `chestage_allowance`, `stamp`, `other_charges`, `round_off`, `total`, `company_id`, `year_id`, `from_where`) VALUES(93, 'UTT/077/15-16', '2015-12-16', NULL, 39, 57, '', '2015-12-16 00:00:00', '2015-12-30 00:00:00', '216830.20', '0.00', '0.00', 0.00, 10841.51, NULL, '0.00', '0.00', '0.29', '227672.00', 1, 1, 'SB');
INSERT INTO `purchase_invoice_master` (`id`, `purchase_invoice_number`, `purchase_invoice_date`, `auctionareaid`, `vendor_id`, `voucher_master_id`, `sale_number`, `sale_date`, `promt_date`, `tea_value`, `brokerage`, `service_tax`, `total_cst`, `total_vat`, `chestage_allowance`, `stamp`, `other_charges`, `round_off`, `total`, `company_id`, `year_id`, `from_where`) VALUES(94, 'PIP/AUC/KOL/L/66397', '2015-12-15', 1, 13, 57, '50', '2015-12-15 00:00:00', '2015-12-29 00:00:00', '831791.00', '1425.98', '199.66', 0.00, 8332.25, NULL, '7.00', '7.11', '0.00', '841763.00', 1, 1, 'AS');
INSERT INTO `purchase_invoice_master` (`id`, `purchase_invoice_number`, `purchase_invoice_date`, `auctionareaid`, `vendor_id`, `voucher_master_id`, `sale_number`, `sale_date`, `promt_date`, `tea_value`, `brokerage`, `service_tax`, `total_cst`, `total_vat`, `chestage_allowance`, `stamp`, `other_charges`, `round_off`, `total`, `company_id`, `year_id`, `from_where`) VALUES(95, 'BL/040/15-16', '2015-12-11', 5, 54, 57, '0', '2015-12-11 00:00:00', '2015-12-11 00:00:00', '131712.00', '0.00', '0.00', 0.00, 6585.60, NULL, '0.00', '0.00', '0.40', '138298.00', 1, 1, 'AS');
INSERT INTO `purchase_invoice_master` (`id`, `purchase_invoice_number`, `purchase_invoice_date`, `auctionareaid`, `vendor_id`, `voucher_master_id`, `sale_number`, `sale_date`, `promt_date`, `tea_value`, `brokerage`, `service_tax`, `total_cst`, `total_vat`, `chestage_allowance`, `stamp`, `other_charges`, `round_off`, `total`, `company_id`, `year_id`, `from_where`) VALUES(96, 'R/80/15', '2015-12-16', NULL, 53, 57, '0', '2015-12-16 00:00:00', '2015-12-16 00:00:00', '172800.00', '0.00', '0.00', 0.00, 8640.00, NULL, '0.00', '0.00', '0.00', '181440.00', 1, 1, 'SB');
INSERT INTO `purchase_invoice_master` (`id`, `purchase_invoice_number`, `purchase_invoice_date`, `auctionareaid`, `vendor_id`, `voucher_master_id`, `sale_number`, `sale_date`, `promt_date`, `tea_value`, `brokerage`, `service_tax`, `total_cst`, `total_vat`, `chestage_allowance`, `stamp`, `other_charges`, `round_off`, `total`, `company_id`, `year_id`, `from_where`) VALUES(97, 'PTM/L/15/1512', '2015-12-15', 1, 19, 57, '50', '2015-12-15 00:00:00', '2015-12-29 00:00:00', '945736.00', '1794.90', '251.33', 0.00, 9475.32, NULL, '0.00', '8.97', '-0.03', '957257.48', 1, 1, 'AS');
INSERT INTO `purchase_invoice_master` (`id`, `purchase_invoice_number`, `purchase_invoice_date`, `auctionareaid`, `vendor_id`, `voucher_master_id`, `sale_number`, `sale_date`, `promt_date`, `tea_value`, `brokerage`, `service_tax`, `total_cst`, `total_vat`, `chestage_allowance`, `stamp`, `other_charges`, `round_off`, `total`, `company_id`, `year_id`, `from_where`) VALUES(98, 'UTT/J.T', '2015-12-15', 1, 39, NULL, '50', '2015-12-15 00:00:00', '2015-12-30 00:00:00', '1375330.00', '2572.50', '360.19', 0.00, 13779.04, NULL, '0.00', '12.86', '0.00', '1392041.66', 1, 1, 'AS');
INSERT INTO `purchase_invoice_master` (`id`, `purchase_invoice_number`, `purchase_invoice_date`, `auctionareaid`, `vendor_id`, `voucher_master_id`, `sale_number`, `sale_date`, `promt_date`, `tea_value`, `brokerage`, `service_tax`, `total_cst`, `total_vat`, `chestage_allowance`, `stamp`, `other_charges`, `round_off`, `total`, `company_id`, `year_id`, `from_where`) VALUES(99, 'PIP/AUC/SLG/L/6415', '2015-12-09', 2, 21, 57, '49', '2015-12-09 00:00:00', '2015-12-23 00:00:00', '0.00', '0.00', '0.00', 0.00, 0.00, NULL, '0.00', '0.00', '0.00', '0.00', 1, 1, 'AS');
INSERT INTO `purchase_invoice_master` (`id`, `purchase_invoice_number`, `purchase_invoice_date`, `auctionareaid`, `vendor_id`, `voucher_master_id`, `sale_number`, `sale_date`, `promt_date`, `tea_value`, `brokerage`, `service_tax`, `total_cst`, `total_vat`, `chestage_allowance`, `stamp`, `other_charges`, `round_off`, `total`, `company_id`, `year_id`, `from_where`) VALUES(100, 'PIP/AUC/SLG/L/6415', '2015-12-09', 2, 21, 57, '49', '2015-12-09 00:00:00', '2015-12-23 00:00:00', '594504.00', NULL, NULL, 0.00, 5954.43, NULL, '0.00', '4.71', '-0.28', '601534.00', 1, 1, 'AS');
INSERT INTO `purchase_invoice_master` (`id`, `purchase_invoice_number`, `purchase_invoice_date`, `auctionareaid`, `vendor_id`, `voucher_master_id`, `sale_number`, `sale_date`, `promt_date`, `tea_value`, `brokerage`, `service_tax`, `total_cst`, `total_vat`, `chestage_allowance`, `stamp`, `other_charges`, `round_off`, `total`, `company_id`, `year_id`, `from_where`) VALUES(101, 'GP/EL-01217', '2015-12-09', 2, 55, NULL, '49', '2015-12-09 00:00:00', '2015-12-23 00:00:00', '365645.80', '0.00', '0.00', 0.00, 3656.46, NULL, '0.00', '0.00', '0.00', '369302.26', 1, 1, 'AS');
INSERT INTO `purchase_invoice_master` (`id`, `purchase_invoice_number`, `purchase_invoice_date`, `auctionareaid`, `vendor_id`, `voucher_master_id`, `sale_number`, `sale_date`, `promt_date`, `tea_value`, `brokerage`, `service_tax`, `total_cst`, `total_vat`, `chestage_allowance`, `stamp`, `other_charges`, `round_off`, `total`, `company_id`, `year_id`, `from_where`) VALUES(102, 'JT/AUC/SLG/L/6549', '2015-12-10', 2, 20, 57, '49', '2015-12-10 00:00:00', '2015-12-24 00:00:00', '0.00', '0.00', '0.00', 0.00, 0.00, NULL, '0.00', '6.33', '-0.22', '0.00', 1, 1, 'AS');
INSERT INTO `purchase_invoice_master` (`id`, `purchase_invoice_number`, `purchase_invoice_date`, `auctionareaid`, `vendor_id`, `voucher_master_id`, `sale_number`, `sale_date`, `promt_date`, `tea_value`, `brokerage`, `service_tax`, `total_cst`, `total_vat`, `chestage_allowance`, `stamp`, `other_charges`, `round_off`, `total`, `company_id`, `year_id`, `from_where`) VALUES(103, 'JT/AUC/SLG/L/6549', '2015-12-10', 2, 20, 57, '49', '2015-12-10 00:00:00', '2015-12-24 00:00:00', '894975.40', NULL, NULL, 0.00, 8962.43, NULL, '0.00', '6.33', '-0.22', '905390.00', 1, 1, 'AS');
INSERT INTO `purchase_invoice_master` (`id`, `purchase_invoice_number`, `purchase_invoice_date`, `auctionareaid`, `vendor_id`, `voucher_master_id`, `sale_number`, `sale_date`, `promt_date`, `tea_value`, `brokerage`, `service_tax`, `total_cst`, `total_vat`, `chestage_allowance`, `stamp`, `other_charges`, `round_off`, `total`, `company_id`, `year_id`, `from_where`) VALUES(104, 'CB/SL/CT/15-16/6115', '2015-12-10', 2, 22, 57, '49', '2015-12-10 00:00:00', '2015-12-24 00:00:00', '192884.40', NULL, NULL, 0.00, 1931.78, NULL, '0.00', '1.46', '0.21', '195152.00', 1, 1, 'AS');
INSERT INTO `purchase_invoice_master` (`id`, `purchase_invoice_number`, `purchase_invoice_date`, `auctionareaid`, `vendor_id`, `voucher_master_id`, `sale_number`, `sale_date`, `promt_date`, `tea_value`, `brokerage`, `service_tax`, `total_cst`, `total_vat`, `chestage_allowance`, `stamp`, `other_charges`, `round_off`, `total`, `company_id`, `year_id`, `from_where`) VALUES(105, 'NB/L-4101', '2015-12-09', 2, 37, 57, '49', '2015-12-09 00:00:00', '2015-12-23 00:00:00', '36871.20', NULL, NULL, 0.00, 369.30, NULL, '0.00', '0.29', '-0.04', '37308.00', 1, 1, 'AS');
INSERT INTO `purchase_invoice_master` (`id`, `purchase_invoice_number`, `purchase_invoice_date`, `auctionareaid`, `vendor_id`, `voucher_master_id`, `sale_number`, `sale_date`, `promt_date`, `tea_value`, `brokerage`, `service_tax`, `total_cst`, `total_vat`, `chestage_allowance`, `stamp`, `other_charges`, `round_off`, `total`, `company_id`, `year_id`, `from_where`) VALUES(106, 'PTM/L/1252', '2015-12-10', 2, 38, 57, '49', '2015-12-10 00:00:00', '2015-12-23 00:00:00', '43680.00', NULL, NULL, 0.00, 437.50, NULL, '0.00', '0.35', '0.48', '44198.00', 1, 1, 'AS');
INSERT INTO `purchase_invoice_master` (`id`, `purchase_invoice_number`, `purchase_invoice_date`, `auctionareaid`, `vendor_id`, `voucher_master_id`, `sale_number`, `sale_date`, `promt_date`, `tea_value`, `brokerage`, `service_tax`, `total_cst`, `total_vat`, `chestage_allowance`, `stamp`, `other_charges`, `round_off`, `total`, `company_id`, `year_id`, `from_where`) VALUES(107, 'CR/EL-02541', '2015-12-09', 2, 36, 57, '49', '2015-12-09 00:00:00', '2015-12-23 00:00:00', '489998.80', '0.00', '0.00', 0.00, 4899.99, NULL, '0.00', '3.89', '0.00', '494898.79', 1, 1, 'AS');
INSERT INTO `purchase_invoice_master` (`id`, `purchase_invoice_number`, `purchase_invoice_date`, `auctionareaid`, `vendor_id`, `voucher_master_id`, `sale_number`, `sale_date`, `promt_date`, `tea_value`, `brokerage`, `service_tax`, `total_cst`, `total_vat`, `chestage_allowance`, `stamp`, `other_charges`, `round_off`, `total`, `company_id`, `year_id`, `from_where`) VALUES(108, 'TC/L-3491', '2015-12-09', 2, 41, 57, '49', '2015-12-09 00:00:00', '2015-12-23 00:00:00', '777803.20', '1234.47', '172.80', 0.00, 7778.01, NULL, '0.00', '6.17', '0.00', '786994.65', 1, 1, 'AS');
INSERT INTO `purchase_invoice_master` (`id`, `purchase_invoice_number`, `purchase_invoice_date`, `auctionareaid`, `vendor_id`, `voucher_master_id`, `sale_number`, `sale_date`, `promt_date`, `tea_value`, `brokerage`, `service_tax`, `total_cst`, `total_vat`, `chestage_allowance`, `stamp`, `other_charges`, `round_off`, `total`, `company_id`, `year_id`, `from_where`) VALUES(109, 'ATB/K/O/15-16/3062', '2015-12-16', 1, 14, 57, '50', '2015-12-16 00:00:00', '2015-12-30 00:00:00', '402503.60', NULL, NULL, 0.00, 4032.26, NULL, '0.00', '3.61', '-0.02', '407362.11', 1, 1, 'AS');
INSERT INTO `purchase_invoice_master` (`id`, `purchase_invoice_number`, `purchase_invoice_date`, `auctionareaid`, `vendor_id`, `voucher_master_id`, `sale_number`, `sale_date`, `promt_date`, `tea_value`, `brokerage`, `service_tax`, `total_cst`, `total_vat`, `chestage_allowance`, `stamp`, `other_charges`, `round_off`, `total`, `company_id`, `year_id`, `from_where`) VALUES(110, 'JT/AUC/SLG/L/6321', '2015-12-03', 2, 20, 57, '48', '2015-12-03 00:00:00', '2015-12-17 00:00:00', '1023283.60', NULL, NULL, 0.00, 10247.04, NULL, '0.00', '7.15', '-0.33', '1035158.00', 1, 1, 'AS');
INSERT INTO `purchase_invoice_master` (`id`, `purchase_invoice_number`, `purchase_invoice_date`, `auctionareaid`, `vendor_id`, `voucher_master_id`, `sale_number`, `sale_date`, `promt_date`, `tea_value`, `brokerage`, `service_tax`, `total_cst`, `total_vat`, `chestage_allowance`, `stamp`, `other_charges`, `round_off`, `total`, `company_id`, `year_id`, `from_where`) VALUES(111, 'NB/L-4248', '2015-12-16', 2, 37, 57, '50', '2015-12-16 00:00:00', '2015-12-30 00:00:00', '1252803.40', '1974.15', '276.37', 0.00, 12547.77, NULL, '0.00', '9.87', '0.44', '1267612.00', 1, 1, 'AS');
INSERT INTO `purchase_invoice_master` (`id`, `purchase_invoice_number`, `purchase_invoice_date`, `auctionareaid`, `vendor_id`, `voucher_master_id`, `sale_number`, `sale_date`, `promt_date`, `tea_value`, `brokerage`, `service_tax`, `total_cst`, `total_vat`, `chestage_allowance`, `stamp`, `other_charges`, `round_off`, `total`, `company_id`, `year_id`, `from_where`) VALUES(112, 'CB/SL/CT/15-16/6307', '2015-12-17', 2, 22, 57, '50', '2015-12-17 00:00:00', '2016-01-01 00:00:00', '880180.60', NULL, NULL, 0.00, 8814.50, NULL, '0.00', '6.34', '-0.46', '890448.00', 1, 1, 'AS');
INSERT INTO `purchase_invoice_master` (`id`, `purchase_invoice_number`, `purchase_invoice_date`, `auctionareaid`, `vendor_id`, `voucher_master_id`, `sale_number`, `sale_date`, `promt_date`, `tea_value`, `brokerage`, `service_tax`, `total_cst`, `total_vat`, `chestage_allowance`, `stamp`, `other_charges`, `round_off`, `total`, `company_id`, `year_id`, `from_where`) VALUES(113, 'CB/SL/CT/15-16/6307', '2015-12-17', 2, 22, 57, '50', '2015-12-17 00:00:00', '2016-01-01 00:00:00', '0.00', '0.00', '0.00', 0.00, 0.00, NULL, '0.00', '0.00', '0.00', '0.00', 1, 1, 'AS');
INSERT INTO `purchase_invoice_master` (`id`, `purchase_invoice_number`, `purchase_invoice_date`, `auctionareaid`, `vendor_id`, `voucher_master_id`, `sale_number`, `sale_date`, `promt_date`, `tea_value`, `brokerage`, `service_tax`, `total_cst`, `total_vat`, `chestage_allowance`, `stamp`, `other_charges`, `round_off`, `total`, `company_id`, `year_id`, `from_where`) VALUES(114, 'JT/AUC/SLG/L.15-16/6765', '2015-12-17', 2, 20, 57, '50', '2015-12-17 00:00:00', '2015-12-31 00:00:00', '1274763.60', NULL, NULL, 0.00, 12764.23, NULL, '0.00', '8.27', '0.00', '1287536.10', 1, 1, 'AS');
INSERT INTO `purchase_invoice_master` (`id`, `purchase_invoice_number`, `purchase_invoice_date`, `auctionareaid`, `vendor_id`, `voucher_master_id`, `sale_number`, `sale_date`, `promt_date`, `tea_value`, `brokerage`, `service_tax`, `total_cst`, `total_vat`, `chestage_allowance`, `stamp`, `other_charges`, `round_off`, `total`, `company_id`, `year_id`, `from_where`) VALUES(115, 'TC/L-3619', '2015-12-16', 2, 41, 57, '50', '2015-12-16 00:00:00', '2015-12-31 00:00:00', '1459437.20', '0.00', '0.00', 0.00, 14594.35, NULL, '0.00', '11.19', '0.00', '1474031.55', 1, 1, 'AS');
INSERT INTO `purchase_invoice_master` (`id`, `purchase_invoice_number`, `purchase_invoice_date`, `auctionareaid`, `vendor_id`, `voucher_master_id`, `sale_number`, `sale_date`, `promt_date`, `tea_value`, `brokerage`, `service_tax`, `total_cst`, `total_vat`, `chestage_allowance`, `stamp`, `other_charges`, `round_off`, `total`, `company_id`, `year_id`, `from_where`) VALUES(116, 'PIP/AUC/SLG/L/6863', '2015-12-23', 2, 21, 57, '51', '2015-12-23 00:00:00', '2016-01-07 00:00:00', '1108853.40', NULL, NULL, 0.00, 11102.98, NULL, '0.00', '7.18', '0.34', '1121609.00', 1, 1, 'AS');
INSERT INTO `purchase_invoice_master` (`id`, `purchase_invoice_number`, `purchase_invoice_date`, `auctionareaid`, `vendor_id`, `voucher_master_id`, `sale_number`, `sale_date`, `promt_date`, `tea_value`, `brokerage`, `service_tax`, `total_cst`, `total_vat`, `chestage_allowance`, `stamp`, `other_charges`, `round_off`, `total`, `company_id`, `year_id`, `from_where`) VALUES(117, 'PIP/AUC/SLG/L/6863', '2015-12-23', 2, 21, 57, '51', '2015-12-23 00:00:00', '2016-01-07 00:00:00', '1108853.40', NULL, NULL, 0.00, 11102.98, NULL, '0.00', '7.18', '0.34', '1121609.00', 1, 1, 'AS');
INSERT INTO `purchase_invoice_master` (`id`, `purchase_invoice_number`, `purchase_invoice_date`, `auctionareaid`, `vendor_id`, `voucher_master_id`, `sale_number`, `sale_date`, `promt_date`, `tea_value`, `brokerage`, `service_tax`, `total_cst`, `total_vat`, `chestage_allowance`, `stamp`, `other_charges`, `round_off`, `total`, `company_id`, `year_id`, `from_where`) VALUES(118, 'PIP/AUC/SLG/L/6638', '2015-12-18', 2, 21, NULL, '50', '2015-12-18 00:00:00', '2016-01-02 00:00:00', '1769248.00', '2554.85', '357.67', 0.00, 17718.02, NULL, '0.00', '12.76', '-0.30', '1789891.00', 1, 1, 'AS');
INSERT INTO `purchase_invoice_master` (`id`, `purchase_invoice_number`, `purchase_invoice_date`, `auctionareaid`, `vendor_id`, `voucher_master_id`, `sale_number`, `sale_date`, `promt_date`, `tea_value`, `brokerage`, `service_tax`, `total_cst`, `total_vat`, `chestage_allowance`, `stamp`, `other_charges`, `round_off`, `total`, `company_id`, `year_id`, `from_where`) VALUES(119, 'PTM/L/15/1565', '2015-12-23', 1, 38, 57, '51', '2015-12-23 00:00:00', '2016-01-06 00:00:00', '856236.00', NULL, NULL, 0.00, 8580.24, NULL, '0.00', '8.92', '0.18', '866863.00', 1, 1, 'AS');
INSERT INTO `purchase_invoice_master` (`id`, `purchase_invoice_number`, `purchase_invoice_date`, `auctionareaid`, `vendor_id`, `voucher_master_id`, `sale_number`, `sale_date`, `promt_date`, `tea_value`, `brokerage`, `service_tax`, `total_cst`, `total_vat`, `chestage_allowance`, `stamp`, `other_charges`, `round_off`, `total`, `company_id`, `year_id`, `from_where`) VALUES(120, 'JT/AUC/KOL/L/11627', '2015-12-22', 1, 5, 57, '51', '2015-12-22 00:00:00', '2016-01-06 00:00:00', '899193.80', NULL, NULL, 0.00, 9011.13, NULL, '0.00', '9.61', '0.00', '910401.93', 1, 1, 'AS');
INSERT INTO `purchase_invoice_master` (`id`, `purchase_invoice_number`, `purchase_invoice_date`, `auctionareaid`, `vendor_id`, `voucher_master_id`, `sale_number`, `sale_date`, `promt_date`, `tea_value`, `brokerage`, `service_tax`, `total_cst`, `total_vat`, `chestage_allowance`, `stamp`, `other_charges`, `round_off`, `total`, `company_id`, `year_id`, `from_where`) VALUES(121, 'PIP/AUC/KOL/L/6601', '2015-12-22', 1, 13, 57, '51', '2015-12-22 00:00:00', '2016-01-05 00:00:00', '864253.00', NULL, NULL, 0.00, 8656.92, NULL, '9.00', '7.17', '-0.07', '874556.00', 1, 1, 'AS');
INSERT INTO `purchase_invoice_master` (`id`, `purchase_invoice_number`, `purchase_invoice_date`, `auctionareaid`, `vendor_id`, `voucher_master_id`, `sale_number`, `sale_date`, `promt_date`, `tea_value`, `brokerage`, `service_tax`, `total_cst`, `total_vat`, `chestage_allowance`, `stamp`, `other_charges`, `round_off`, `total`, `company_id`, `year_id`, `from_where`) VALUES(122, 'JT/AUC/KOL/L/11484', '2015-12-22', 1, 5, 57, '51', '2015-12-22 00:00:00', '2016-01-05 00:00:00', '210122.00', '393.52', '55.09', 0.00, 2105.15, NULL, '0.00', '1.97', '0.00', '212675.76', 1, 1, 'AS');
INSERT INTO `purchase_invoice_master` (`id`, `purchase_invoice_number`, `purchase_invoice_date`, `auctionareaid`, `vendor_id`, `voucher_master_id`, `sale_number`, `sale_date`, `promt_date`, `tea_value`, `brokerage`, `service_tax`, `total_cst`, `total_vat`, `chestage_allowance`, `stamp`, `other_charges`, `round_off`, `total`, `company_id`, `year_id`, `from_where`) VALUES(123, 'ABL/KOL/5647/15-16', '2015-12-23', 1, 25, 57, '51', '2015-12-23 00:00:00', '2016-01-06 00:00:00', '441210.80', NULL, NULL, 0.00, 4420.64, NULL, '0.00', '4.24', '0.00', '446607.24', 1, 1, 'AS');
INSERT INTO `purchase_invoice_master` (`id`, `purchase_invoice_number`, `purchase_invoice_date`, `auctionareaid`, `vendor_id`, `voucher_master_id`, `sale_number`, `sale_date`, `promt_date`, `tea_value`, `brokerage`, `service_tax`, `total_cst`, `total_vat`, `chestage_allowance`, `stamp`, `other_charges`, `round_off`, `total`, `company_id`, `year_id`, `from_where`) VALUES(124, 'ABL/KOL/5647/15-16', '2015-12-23', 1, 25, 57, '51', '2015-12-23 00:00:00', '2016-01-06 00:00:00', '441210.80', NULL, NULL, 0.00, 4420.64, NULL, '0.00', '4.24', '0.00', '446607.24', 1, 1, 'AS');
INSERT INTO `purchase_invoice_master` (`id`, `purchase_invoice_number`, `purchase_invoice_date`, `auctionareaid`, `vendor_id`, `voucher_master_id`, `sale_number`, `sale_date`, `promt_date`, `tea_value`, `brokerage`, `service_tax`, `total_cst`, `total_vat`, `chestage_allowance`, `stamp`, `other_charges`, `round_off`, `total`, `company_id`, `year_id`, `from_where`) VALUES(125, 'ATB/K/L/15-16/3221', '2015-12-23', 1, 14, 57, '51', '2015-12-23 00:00:00', '2016-01-06 00:00:00', '110553.80', NULL, NULL, 0.00, 1108.16, NULL, '0.00', '1.30', '0.00', '111961.07', 1, 1, 'AS');
INSERT INTO `purchase_invoice_master` (`id`, `purchase_invoice_number`, `purchase_invoice_date`, `auctionareaid`, `vendor_id`, `voucher_master_id`, `sale_number`, `sale_date`, `promt_date`, `tea_value`, `brokerage`, `service_tax`, `total_cst`, `total_vat`, `chestage_allowance`, `stamp`, `other_charges`, `round_off`, `total`, `company_id`, `year_id`, `from_where`) VALUES(126, 'ATB/K/O/15-16/3165', '2015-12-23', 1, 14, 57, '51', '2015-12-23 00:00:00', '2016-01-06 00:00:00', '56526.90', NULL, NULL, 0.00, 566.47, NULL, '0.00', '0.60', '0.00', '57231.08', 1, 1, 'AS');
INSERT INTO `purchase_invoice_master` (`id`, `purchase_invoice_number`, `purchase_invoice_date`, `auctionareaid`, `vendor_id`, `voucher_master_id`, `sale_number`, `sale_date`, `promt_date`, `tea_value`, `brokerage`, `service_tax`, `total_cst`, `total_vat`, `chestage_allowance`, `stamp`, `other_charges`, `round_off`, `total`, `company_id`, `year_id`, `from_where`) VALUES(127, 'BL/044/15-16', '2015-12-14', 5, 54, 57, '', '2015-12-14 00:00:00', '2015-12-28 00:00:00', '110073.60', '0.00', '0.00', 0.00, 5503.68, NULL, '0.00', '0.00', '-0.28', '115577.00', 1, 1, 'AS');
INSERT INTO `purchase_invoice_master` (`id`, `purchase_invoice_number`, `purchase_invoice_date`, `auctionareaid`, `vendor_id`, `voucher_master_id`, `sale_number`, `sale_date`, `promt_date`, `tea_value`, `brokerage`, `service_tax`, `total_cst`, `total_vat`, `chestage_allowance`, `stamp`, `other_charges`, `round_off`, `total`, `company_id`, `year_id`, `from_where`) VALUES(128, 'UTT/079/15-16', '2016-01-04', NULL, 39, 57, '', '2016-01-04 00:00:00', '2016-01-18 00:00:00', '345318.60', '0.00', '0.00', 0.00, 17265.93, NULL, '0.00', '0.00', '0.47', '362585.00', 1, 1, 'SB');
INSERT INTO `purchase_invoice_master` (`id`, `purchase_invoice_number`, `purchase_invoice_date`, `auctionareaid`, `vendor_id`, `voucher_master_id`, `sale_number`, `sale_date`, `promt_date`, `tea_value`, `brokerage`, `service_tax`, `total_cst`, `total_vat`, `chestage_allowance`, `stamp`, `other_charges`, `round_off`, `total`, `company_id`, `year_id`, `from_where`) VALUES(129, 'GP/EL - 01268', '2015-12-16', 2, 55, 57, '50', '2015-12-16 00:00:00', '2015-12-31 00:00:00', '121160.00', NULL, NULL, 0.00, 1213.54, NULL, '0.00', '0.97', '-0.50', '122595.00', 1, 1, 'AS');
INSERT INTO `purchase_invoice_master` (`id`, `purchase_invoice_number`, `purchase_invoice_date`, `auctionareaid`, `vendor_id`, `voucher_master_id`, `sale_number`, `sale_date`, `promt_date`, `tea_value`, `brokerage`, `service_tax`, `total_cst`, `total_vat`, `chestage_allowance`, `stamp`, `other_charges`, `round_off`, `total`, `company_id`, `year_id`, `from_where`) VALUES(130, 'JT/AUC/SLG/L/6973', '2015-12-22', 2, 20, NULL, '51', '2015-12-22 00:00:00', '2016-01-07 00:00:00', '673614.80', '980.38', '137.24', 0.00, 6745.95, NULL, '0.00', '4.90', '-0.27', '681483.00', 1, 1, 'AS');
INSERT INTO `purchase_invoice_master` (`id`, `purchase_invoice_number`, `purchase_invoice_date`, `auctionareaid`, `vendor_id`, `voucher_master_id`, `sale_number`, `sale_date`, `promt_date`, `tea_value`, `brokerage`, `service_tax`, `total_cst`, `total_vat`, `chestage_allowance`, `stamp`, `other_charges`, `round_off`, `total`, `company_id`, `year_id`, `from_where`) VALUES(131, 'SCC/D/1928', '2015-12-24', 1, 42, 57, '51', '2015-12-24 00:00:00', '2016-01-08 00:00:00', '20496.00', '51.24', '7.17', 0.00, 205.47, NULL, '0.00', '0.26', '0.00', '20760.14', 1, 1, 'AS');
INSERT INTO `purchase_invoice_master` (`id`, `purchase_invoice_number`, `purchase_invoice_date`, `auctionareaid`, `vendor_id`, `voucher_master_id`, `sale_number`, `sale_date`, `promt_date`, `tea_value`, `brokerage`, `service_tax`, `total_cst`, `total_vat`, `chestage_allowance`, `stamp`, `other_charges`, `round_off`, `total`, `company_id`, `year_id`, `from_where`) VALUES(132, 'CB/SL/CT/15-16/6481', '2015-12-22', 2, 22, 57, '51', '2015-12-22 00:00:00', '2016-01-06 00:00:00', '1014096.00', '1521.01', '212.92', 0.00, 10156.16, NULL, '0.00', '7.59', '0.32', '1025994.00', 1, 1, 'AS');
INSERT INTO `purchase_invoice_master` (`id`, `purchase_invoice_number`, `purchase_invoice_date`, `auctionareaid`, `vendor_id`, `voucher_master_id`, `sale_number`, `sale_date`, `promt_date`, `tea_value`, `brokerage`, `service_tax`, `total_cst`, `total_vat`, `chestage_allowance`, `stamp`, `other_charges`, `round_off`, `total`, `company_id`, `year_id`, `from_where`) VALUES(133, 'TEST123/14-01-16', '2016-01-14', 0, 18, 57, 'T1234', '2016-01-14 00:00:00', '2016-01-28 00:00:00', '3000.00', '100.00', '14.00', 0.00, 155.05, NULL, '1.00', '0.00', '0.00', '3270.05', 1, 1, 'AS');
INSERT INTO `purchase_invoice_master` (`id`, `purchase_invoice_number`, `purchase_invoice_date`, `auctionareaid`, `vendor_id`, `voucher_master_id`, `sale_number`, `sale_date`, `promt_date`, `tea_value`, `brokerage`, `service_tax`, `total_cst`, `total_vat`, `chestage_allowance`, `stamp`, `other_charges`, `round_off`, `total`, `company_id`, `year_id`, `from_where`) VALUES(134, 'UTT/084/15-16', '2016-01-12', NULL, 39, 57, '51', '2016-01-12 00:00:00', '2016-01-26 00:00:00', '161848.80', '0.00', '0.00', 0.00, 8092.44, NULL, '0.00', '0.00', '-0.24', '169941.00', 1, 1, 'SB');
INSERT INTO `purchase_invoice_master` (`id`, `purchase_invoice_number`, `purchase_invoice_date`, `auctionareaid`, `vendor_id`, `voucher_master_id`, `sale_number`, `sale_date`, `promt_date`, `tea_value`, `brokerage`, `service_tax`, `total_cst`, `total_vat`, `chestage_allowance`, `stamp`, `other_charges`, `round_off`, `total`, `company_id`, `year_id`, `from_where`) VALUES(135, 'MTC/196/15-16', '2016-01-06', NULL, 52, 57, '', '2016-01-06 00:00:00', '2016-01-13 00:00:00', '71344.00', '0.00', '0.00', 0.00, 3567.20, NULL, '0.00', '0.00', '-0.20', '74911.00', 1, 1, 'SB');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_invoice_sample`
--

CREATE TABLE IF NOT EXISTS `purchase_invoice_sample` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `purchase_invoice_detail_id` int(10) DEFAULT NULL,
  `sample_number` int(10) DEFAULT NULL,
  `sample_net` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_purchase_invoice_detail_id` (`purchase_invoice_detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `role_name` varchar(50) NOT NULL,
  `id` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_name`, `id`) VALUES('user', 1);
INSERT INTO `roles` (`role_name`, `id`) VALUES('admin', 2);

-- --------------------------------------------------------

--
-- Table structure for table `saler_to_buyer_details`
--

CREATE TABLE IF NOT EXISTS `saler_to_buyer_details` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `saler_to_buyer_master_id` int(10) DEFAULT NULL,
  `lot` int(10) DEFAULT NULL,
  `invoice_number` varchar(255) DEFAULT NULL,
  `garden_id` int(10) DEFAULT NULL,
  `grade_id` int(10) DEFAULT NULL,
  `gp_number` int(10) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `package` int(10) DEFAULT NULL,
  `stamp` decimal(10,2) DEFAULT NULL,
  `gross` decimal(10,2) DEFAULT NULL,
  `brokerage` decimal(10,2) DEFAULT NULL,
  `total_weight` decimal(10,2) DEFAULT NULL,
  `rate_type_value` decimal(10,2) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `service_tax` decimal(10,2) DEFAULT NULL,
  `total_value` decimal(10,2) DEFAULT NULL,
  `chest_from` int(10) DEFAULT NULL,
  `chest_to` int(10) DEFAULT NULL,
  `value_cost` decimal(10,2) DEFAULT NULL,
  `net` int(10) DEFAULT NULL,
  `rate_type` enum('V','C') DEFAULT NULL,
  `rate_type_id` int(11) DEFAULT NULL,
  `service_tax_id` int(11) DEFAULT NULL,
  `teagroup_master_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_STBD_saler_to_buyer_master` (`saler_to_buyer_master_id`),
  KEY `FK_STBD_garden_id` (`garden_id`),
  KEY `FK_STBD_grade_id` (`grade_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `saler_to_buyer_master`
--

CREATE TABLE IF NOT EXISTS `saler_to_buyer_master` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `salertobuyer_invoice_number` varchar(255) DEFAULT NULL,
  `salertobuyer_invoice_date` date DEFAULT NULL,
  `vendor_id` int(10) DEFAULT NULL,
  `sale_number` varchar(10) DEFAULT NULL,
  `sale_date` date DEFAULT NULL,
  `promt_date` date DEFAULT NULL,
  `tea_value` decimal(10,2) DEFAULT NULL,
  `brokerage` decimal(10,2) DEFAULT NULL,
  `service_tax` decimal(10,2) DEFAULT NULL,
  `total_vat` decimal(10,2) DEFAULT NULL,
  `chestage_allowance` decimal(10,2) DEFAULT NULL,
  `stamp` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `voucher_master_id` int(11) DEFAULT NULL,
  `total_cst` decimal(10,2) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `year_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_STB_vendor_id` (`vendor_id`),
  KEY `FK_STB_vouchermaster_id` (`voucher_master_id`),
  KEY `FK_STB_company_id` (`company_id`),
  KEY `PK_STB_year_id` (`year_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `saler_to_buyer_sample`
--

CREATE TABLE IF NOT EXISTS `saler_to_buyer_sample` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `saler_to_buyer_detail_id` int(10) DEFAULT NULL,
  `sample_number` int(10) DEFAULT NULL,
  `sample_net` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_STBS_saler_to_buyer_detail_id` (`saler_to_buyer_detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `sale_bill_details`
--

CREATE TABLE IF NOT EXISTS `sale_bill_details` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `salebillmasterid` int(20) DEFAULT NULL,
  `productpacketid` int(20) DEFAULT NULL,
  `packingbox` double(10,2) DEFAULT NULL,
  `packingnet` double(10,2) DEFAULT NULL,
  `quantity` double(10,2) DEFAULT NULL,
  `rate` double(10,2) DEFAULT NULL,
  `amount` double(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_salebill_master` (`salebillmasterid`),
  KEY `fk_product_packet_id` (`productpacketid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=75 ;

--
-- Dumping data for table `sale_bill_details`
--

INSERT INTO `sale_bill_details` (`id`, `salebillmasterid`, `productpacketid`, `packingbox`, `packingnet`, `quantity`, `rate`, `amount`) VALUES(73, 17, 6, 10.00, 25.00, 250.00, 125.00, 31250.00);
INSERT INTO `sale_bill_details` (`id`, `salebillmasterid`, `productpacketid`, `packingbox`, `packingnet`, `quantity`, `rate`, `amount`) VALUES(74, 17, 7, 12.00, 20.00, 240.00, 120.00, 28800.00);

-- --------------------------------------------------------

--
-- Table structure for table `sale_bill_master`
--

CREATE TABLE IF NOT EXISTS `sale_bill_master` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `srl_no` int(20) DEFAULT NULL,
  `salebillno` varchar(255) DEFAULT NULL,
  `salebilldate` datetime DEFAULT NULL,
  `customerId` int(20) DEFAULT NULL,
  `taxinvoiceno` varchar(255) DEFAULT NULL,
  `taxinvoicedate` datetime DEFAULT NULL,
  `duedate` datetime DEFAULT NULL,
  `taxrateType` enum('C','V') DEFAULT NULL COMMENT 'C=CST,V=VAT',
  `taxrateTypeId` int(20) DEFAULT NULL,
  `taxamount` double(10,2) DEFAULT NULL,
  `discountRate` double(10,2) DEFAULT NULL,
  `discountAmount` double(10,2) DEFAULT NULL,
  `deliverychgs` double(10,2) DEFAULT NULL,
  `totalpacket` double(10,2) DEFAULT NULL,
  `totalquantity` double(10,2) DEFAULT NULL,
  `totalamount` double(10,2) DEFAULT NULL,
  `roundoff` double(10,2) DEFAULT NULL,
  `grandtotal` double(10,2) DEFAULT NULL,
  `yearid` int(20) DEFAULT NULL,
  `companyid` int(20) DEFAULT NULL,
  `creationdate` int(20) DEFAULT NULL,
  `userid` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_customer` (`customerId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `sale_bill_master`
--

INSERT INTO `sale_bill_master` (`id`, `srl_no`, `salebillno`, `salebilldate`, `customerId`, `taxinvoiceno`, `taxinvoicedate`, `duedate`, `taxrateType`, `taxrateTypeId`, `taxamount`, `discountRate`, `discountAmount`, `deliverychgs`, `totalpacket`, `totalquantity`, `totalamount`, `roundoff`, `grandtotal`, `yearid`, `companyid`, `creationdate`, `userid`) VALUES(17, 1, 'TS/00001/15-16', '2015-12-29 00:00:00', 1, 'TS/00001/15-16', '2015-12-29 00:00:00', '2015-12-29 00:00:00', 'V', 7, 600.50, 0.00, 0.00, 0.00, 22.00, 490.00, 60050.00, -0.50, 60650.00, 1, 1, 2015, 2);

-- --------------------------------------------------------

--
-- Table structure for table `service_tax`
--

CREATE TABLE IF NOT EXISTS `service_tax` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `tax_rate` decimal(10,2) DEFAULT NULL,
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `service_tax`
--

INSERT INTO `service_tax` (`id`, `tax_rate`, `from_date`, `to_date`) VALUES(7, '10.00', '2015-02-03', '2015-03-31');
INSERT INTO `service_tax` (`id`, `tax_rate`, `from_date`, `to_date`) VALUES(9, '2.50', '2014-03-01', '2014-03-31');
INSERT INTO `service_tax` (`id`, `tax_rate`, `from_date`, `to_date`) VALUES(10, '0.00', '1970-01-01', '1970-01-01');
INSERT INTO `service_tax` (`id`, `tax_rate`, `from_date`, `to_date`) VALUES(11, '14.00', '2015-04-01', '2016-03-31');

-- --------------------------------------------------------

--
-- Table structure for table `state_master`
--

CREATE TABLE IF NOT EXISTS `state_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `state_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

--
-- Dumping data for table `state_master`
--

INSERT INTO `state_master` (`id`, `state_name`) VALUES(3, 'Andhra Pradesh');
INSERT INTO `state_master` (`id`, `state_name`) VALUES(4, 'Assam');
INSERT INTO `state_master` (`id`, `state_name`) VALUES(5, 'Bihar');
INSERT INTO `state_master` (`id`, `state_name`) VALUES(6, 'Chandigarh');
INSERT INTO `state_master` (`id`, `state_name`) VALUES(7, 'Chhatisgarh');
INSERT INTO `state_master` (`id`, `state_name`) VALUES(8, 'Delhi');
INSERT INTO `state_master` (`id`, `state_name`) VALUES(9, 'Gujarat');
INSERT INTO `state_master` (`id`, `state_name`) VALUES(10, 'Haryana');
INSERT INTO `state_master` (`id`, `state_name`) VALUES(11, 'Jharkhand');
INSERT INTO `state_master` (`id`, `state_name`) VALUES(12, 'Karnataka');
INSERT INTO `state_master` (`id`, `state_name`) VALUES(13, 'Kerala');
INSERT INTO `state_master` (`id`, `state_name`) VALUES(14, 'Madhya Pradesh');
INSERT INTO `state_master` (`id`, `state_name`) VALUES(15, 'Maharashtra');
INSERT INTO `state_master` (`id`, `state_name`) VALUES(16, 'Manipur');
INSERT INTO `state_master` (`id`, `state_name`) VALUES(17, 'Meghalaya');
INSERT INTO `state_master` (`id`, `state_name`) VALUES(18, 'Mizoram');
INSERT INTO `state_master` (`id`, `state_name`) VALUES(19, 'Orissa');
INSERT INTO `state_master` (`id`, `state_name`) VALUES(20, 'Pondicherry');
INSERT INTO `state_master` (`id`, `state_name`) VALUES(21, 'Punjab');
INSERT INTO `state_master` (`id`, `state_name`) VALUES(22, 'Tamil Nadu');
INSERT INTO `state_master` (`id`, `state_name`) VALUES(23, 'Tripura');
INSERT INTO `state_master` (`id`, `state_name`) VALUES(24, 'Uttar Pradesh');
INSERT INTO `state_master` (`id`, `state_name`) VALUES(25, 'Uttarakhand');
INSERT INTO `state_master` (`id`, `state_name`) VALUES(26, 'West Bengal');
INSERT INTO `state_master` (`id`, `state_name`) VALUES(27, 'Arunachal Pradesh');
INSERT INTO `state_master` (`id`, `state_name`) VALUES(28, 'Goa');
INSERT INTO `state_master` (`id`, `state_name`) VALUES(29, 'Jammu & Kashmir');
INSERT INTO `state_master` (`id`, `state_name`) VALUES(30, 'Himachal Pradesh');
INSERT INTO `state_master` (`id`, `state_name`) VALUES(31, 'Nagaland');
INSERT INTO `state_master` (`id`, `state_name`) VALUES(32, 'Telangana');
INSERT INTO `state_master` (`id`, `state_name`) VALUES(33, 'Sikkim');

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE IF NOT EXISTS `stock` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `stock_related_detail_id` int(10) DEFAULT NULL,
  `from_where` enum('PR','SB') DEFAULT NULL,
  `received_master_id` int(10) DEFAULT NULL,
  `company_id` int(10) DEFAULT NULL,
  `year_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_stock_company_id` (`company_id`),
  KEY `FK_stock_year_id` (`year_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `subgroup_name`
--

CREATE TABLE IF NOT EXISTS `subgroup_name` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `subgroup_name`
--

INSERT INTO `subgroup_name` (`id`, `name`) VALUES(1, 'Asset');
INSERT INTO `subgroup_name` (`id`, `name`) VALUES(2, 'Liabilities');
INSERT INTO `subgroup_name` (`id`, `name`) VALUES(3, 'Income');
INSERT INTO `subgroup_name` (`id`, `name`) VALUES(4, 'Expenditure');

-- --------------------------------------------------------

--
-- Table structure for table `teagroup_master`
--

CREATE TABLE IF NOT EXISTS `teagroup_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_code` varchar(50) DEFAULT NULL,
  `group_description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `teagroup_master`
--

INSERT INTO `teagroup_master` (`id`, `group_code`, `group_description`) VALUES(5, 'CTC', 'CTC');
INSERT INTO `teagroup_master` (`id`, `group_code`, `group_description`) VALUES(6, 'ORTH', 'ORTHODOX');
INSERT INTO `teagroup_master` (`id`, `group_code`, `group_description`) VALUES(7, 'DST', 'DUST');
INSERT INTO `teagroup_master` (`id`, `group_code`, `group_description`) VALUES(8, 'DJ', 'DARJEELING');
INSERT INTO `teagroup_master` (`id`, `group_code`, `group_description`) VALUES(9, 'CTC1', 'CTC');

-- --------------------------------------------------------

--
-- Table structure for table `transport`
--

CREATE TABLE IF NOT EXISTS `transport` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `code` varchar(10) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `address` text CHARACTER SET utf8,
  `Phone` varchar(255) DEFAULT NULL,
  `pin` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `transport`
--

INSERT INTO `transport` (`id`, `code`, `name`, `address`, `Phone`, `pin`) VALUES(2, 'NT', 'NABIN TEA SERVICE', 'KOLKATA', '700016', '743503');
INSERT INTO `transport` (`id`, `code`, `name`, `address`, `Phone`, `pin`) VALUES(3, '0', 'Das And Ghosh Roadways Packers And Movers', '4 No, Surya Sen Nagar, \nKolkata - 700117,\nNear Tata Gate ', '98741563', '7423363');
INSERT INTO `transport` (`id`, `code`, `name`, `address`, `Phone`, `pin`) VALUES(4, NULL, 'Assam-Transport', 'Hemanta Bose Sarani,\nB B D Bag, \nKolkatta-700001', '9831024741', NULL);
INSERT INTO `transport` (`id`, `code`, `name`, `address`, `Phone`, `pin`) VALUES(5, NULL, 'MAA ANNAPURNA TRANSPORT', 'SILIGURI', '033', '123');
INSERT INTO `transport` (`id`, `code`, `name`, `address`, `Phone`, `pin`) VALUES(6, NULL, 'B.SAHA', 'SANTOSHPUR', '9432596500', '700142');

-- --------------------------------------------------------

--
-- Table structure for table `unreleaseddo`
--

CREATE TABLE IF NOT EXISTS `unreleaseddo` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `purchase_invoice_master_id` int(10) DEFAULT NULL,
  `do_number` int(10) DEFAULT NULL,
  `do_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_unreleaseddo_purchase_invoice_master_id` (`purchase_invoice_master_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `userole`
--

CREATE TABLE IF NOT EXISTS `userole` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) DEFAULT NULL,
  `role_id` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_USERROLE_UID` (`user_id`),
  KEY `FK_USERROLE_RID` (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `userole`
--

INSERT INTO `userole` (`id`, `user_id`, `role_id`) VALUES(10, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `login_id`, `password`, `First_Name`, `Last_Name`, `Address`, `Email`, `Contact_Number`, `IS_ACTIVE`) VALUES(2, 'admin', '8a8bb7cd343aa2ad99b7d762030857a2', 'Admin', NULL, NULL, NULL, NULL, 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `vat`
--

CREATE TABLE IF NOT EXISTS `vat` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `vat_rate` decimal(10,2) DEFAULT NULL,
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `vat`
--

INSERT INTO `vat` (`id`, `vat_rate`, `from_date`, `to_date`) VALUES(5, '10.00', '2014-04-01', '2015-03-31');
INSERT INTO `vat` (`id`, `vat_rate`, `from_date`, `to_date`) VALUES(6, '5.00', '2015-04-01', '2016-03-31');
INSERT INTO `vat` (`id`, `vat_rate`, `from_date`, `to_date`) VALUES(7, '1.00', '2015-04-01', '2016-03-31');

-- --------------------------------------------------------

--
-- Table structure for table `vendor`
--

CREATE TABLE IF NOT EXISTS `vendor` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `vendor_name` varchar(100) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `account_master_id` int(10) DEFAULT NULL,
  `tin_number` varchar(50) DEFAULT NULL,
  `cst_number` varchar(50) DEFAULT NULL,
  `pan_number` varchar(50) DEFAULT NULL,
  `service_tax_number` varchar(50) DEFAULT NULL,
  `GST_Number` varchar(50) DEFAULT NULL,
  `pin_number` int(11) DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_vendor_account_master_id` (`account_master_id`),
  KEY `state_id` (`state_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=56 ;

--
-- Dumping data for table `vendor`
--

INSERT INTO `vendor` (`id`, `vendor_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(5, 'J Thomas & Co. Pvt. Ltd', '11 R N Mukherjee Road\nKolkata', NULL, 30, '19200164093', '19200164287', 'AABCJ2851Q', 'AABCJ2851QST005', '', 700001, 26);
INSERT INTO `vendor` (`id`, `vendor_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(13, 'Parcon India Private Limited', '207 A J C BOSE ROAD\nKOLKATA', NULL, 41, '19200626007', '19200626290', 'AARCP6453A', 'AARCP6453AST001', '', 700017, 26);
INSERT INTO `vendor` (`id`, `vendor_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(14, 'ASSAM TEA BROKERS PVT. LTD', '113 PARK STREET, \n9th Floor \nKolkata', NULL, 42, '19432268021', '19432268021', 'AABCA7736M', 'AABCA7736MSD001', '', 700016, 26);
INSERT INTO `vendor` (`id`, `vendor_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(16, 'ASSOCIATED BROKERS PVT.LTD (Siliguri)', 'UTTORAYON LUXMI TOWNSHIP. P.O.- MATIGARA\nSILIGURI', NULL, 44, '19411143070', '19411143070', 'AAECA4414D', 'AAECA4414DST001', '', 734010, 26);
INSERT INTO `vendor` (`id`, `vendor_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(17, 'BIJOYNAGAR TEA COMPANY LIMMITED', '11,GOVERNMENT PLACE EAST, 2ND FLOOR, KOLKATA', '2248-7629', 45, '19450691037', '19450691231', '', '', '', 700069, 26);
INSERT INTO `vendor` (`id`, `vendor_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(18, 'Softhought-Test', '50&51 Jodhpur gardens', '8648831063', 46, '100000-A', 'CS-0002', 'ADHFX3LOP', '10235', '', 700051, 26);
INSERT INTO `vendor` (`id`, `vendor_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(19, 'Paramount Tea Marketing Pvt Ltd.', '11 Park Mansions, 57 Park Street, Kolkata', NULL, 47, '19500598022', '', '', '', '', 700016, 26);
INSERT INTO `vendor` (`id`, `vendor_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(20, 'JThomas & Company Pvt Ltd. (Siliguri)', 'G, 318/9, City Centre, Uttorayon Matigara, Siliguri', NULL, 48, '19200164093', '', '', '', '', 734010, 26);
INSERT INTO `vendor` (`id`, `vendor_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(21, 'PARCON INDIA PRIVATE LIMITED (Siliguri)', 'Pratap Market, Siliguri', '0353-2542910/2546249', 49, '19200626007', '', '', '', '', 734401, 26);
INSERT INTO `vendor` (`id`, `vendor_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(22, 'Contemporary Brokers Pvt.Ltd. (Siliguri)', 'STAC Building, Mallaguri, P.O.- Pradhan Nagar', NULL, 50, '19200898092', '', '', '', '', 0, 26);
INSERT INTO `vendor` (`id`, `vendor_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(24, 'JAY SHREE TEA & INDUSTRIES LTD.', '10, Camac street, Calcutta', NULL, 52, '19200537058', '', '', '', '', 700017, 26);
INSERT INTO `vendor` (`id`, `vendor_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(25, 'ASSOCIATED BROKERS PVT.LTD', '17, R.N.Mukharjee Road, Kolkata', NULL, 53, '19411143070', '', '', '', '', 700001, 26);
INSERT INTO `vendor` (`id`, `vendor_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(27, 'ISHAAN PLASTIC  PVT.LTD', '40,JAY BIBI RAOD, GROUND FLOOR,PLOT NO 61&62, GHUSURI,HOWARH.', '26555492', 58, '19281768059', '', '', 'AABCI5376BSD001', '', 711107, 26);
INSERT INTO `vendor` (`id`, `vendor_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(28, 'N.N.PRINT & PACK PVT.LTD.', 'VILL - GOPALPUR,CHANDIGARH.P.O.- GANGANAGAR,KOLKATA', '25386641/9191', 59, '19651723052', '', 'AABCN1073E', '', '', 700132, 26);
INSERT INTO `vendor` (`id`, `vendor_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(29, 'SURYA PACKAGERS', '135A,BIPLABI RASH BEHARI BASUROAD,\n2ND FLOOR,KOLKATA.', '9230513556/8017555777', 60, '19260439020', '', '', '', '', 700001, 26);
INSERT INTO `vendor` (`id`, `vendor_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(30, 'MKB PRINT & PACK SOLUTIONS PVT.LTD.', '3/2 TANGRA ROAD SOUTH,KOLKATA.', '', 61, '19397695087', '', 'AAGCM3156L', '', '', 700046, 26);
INSERT INTO `vendor` (`id`, `vendor_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(31, 'SATYAM ENTERPRISE', '135-A,BIPLABI RASH BEHARI BASU ROAD.2ND FLOOR,KOLKATA', '9836304990/9038002419', 62, '19261436083', '', '', '', '', 700001, 26);
INSERT INTO `vendor` (`id`, `vendor_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(32, 'PRACHI INDUSTRIES', '156 RABINDRA SARANI, FIRST FLOOR,KOLKATA', '', 63, '19272056031', '', '', '', '', 700007, 26);
INSERT INTO `vendor` (`id`, `vendor_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(33, 'OM PACKAGING', 'G-8,RABINDRA PALLY,SPACE TOWER, BLOCK -C 3RD FLOOR, KOLKATA', '', 64, '19671168933', '', '', '', '', 700059, 26);
INSERT INTO `vendor` (`id`, `vendor_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(34, 'SONY PACKAGING INDUSTRY', '64-B, BELGACHIA ROAD,KOLKATA,', '', 65, '19300641058', '', '', '', '', 700037, 26);
INSERT INTO `vendor` (`id`, `vendor_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(35, 'THE SIMULBARIE TEA COMPANY (PVT) LTD', 'MITTER HOUSE,(3RD FLOOR) \n71 GANESH CHANDRA AVENUE\nKOLKATA', '033-223717474', 117, '19533133083', '', '', '', '', 700013, 26);
INSERT INTO `vendor` (`id`, `vendor_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(36, 'CARE TEA PRIVATE LIMITED (SILIGURI)', 'SUNNY TOWER BUILDING, 2ND FLOOR\nSEVOK ROAD,\nSILIGURI', '2641132/2641845', 118, '19895080047', '', '', '', '', 734001, 26);
INSERT INTO `vendor` (`id`, `vendor_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(37, 'NORTH BENGAL TEA BROKERS (P) LTD (SILIGURI)', 'B.M.SARANI,MAHANANDA PARA\nSILIGURI', '2532257/2535664', 119, '19894704075', '', '', '', '', 734001, 26);
INSERT INTO `vendor` (`id`, `vendor_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(38, 'Paramount Tea Marketing Pvt Ltd. (SILIGURI)', 'KIRAN MOTI BUILDING,1ST FLOOR\nMALLAGURI, SILIGURU', '09002015586', 120, '19500598022', '', '', '', '', 734403, 26);
INSERT INTO `vendor` (`id`, `vendor_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(39, 'UNIVERSAL TEA TRADERS', '8/1, LALBAZAR STREET,\nKOLKATA', '', 121, '19470628029', '', '', '', '', 70001, 26);
INSERT INTO `vendor` (`id`, `vendor_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(40, 'NEW CHUMTA TEA COMPANY ', '3, NETAJI SUBHAS ROAD\nKOLKATA', '', 122, '19450322049 ', '', '', '', '', 700001, 26);
INSERT INTO `vendor` (`id`, `vendor_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(41, 'TEA CHAMPAGNE PRIVATE LIMITED (SILIGURI)', 'CITY CENTRE,UTTORAYON\nMATIGARA', '2576079/2576080', 123, '19890744050', '', '', '', '', 734010, 26);
INSERT INTO `vendor` (`id`, `vendor_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(42, 'SUDHIR CHATERJEE & CO.PVT.LTD.', 'KIRAN DYUTI APARTMENT, 1ST FLOOR\nMALLAGURI, SILIGUR', '', 124, '19580818089', '', '', '', '', 734003, 26);
INSERT INTO `vendor` (`id`, `vendor_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(43, 'THE NEW TERAI ASSOCIATION LIMITED', '26, BURTOLLA STREET.\nKOLKATA\n', '', 125, '19340112007 (CANCEL)', '', '', '', '', 700007, 26);
INSERT INTO `vendor` (`id`, `vendor_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(44, 'GILLANDERS ARBUTHONT & CO.LTD.', 'C-4, GILLANDER HOUSE, 4 TH FLOOR\nNETAJI SUBHAS ROAD\nKOLKATA', '2230-2331/36', 126, '19481313064', '', '', '', '', 700001, 26);
INSERT INTO `vendor` (`id`, `vendor_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(45, 'CONTEMPORARY BROKERS PVT.LTD', '1,OLD COURT HOUSE CORNER\nKOLKATA', '22307241/42', 127, '19200898092', '', '', '', '', 700001, 26);
INSERT INTO `vendor` (`id`, `vendor_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(46, 'KAMALA TEA CO.LTD', '240/B ACHARYA JAGADISH CHANDRA BOSE ROAD\nKOLKATA\n', '2283-2945/2947', 128, '19410646042', '', '', '', '', 700020, 26);
INSERT INTO `vendor` (`id`, `vendor_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(47, 'JAI JALPESH INTERNATIONAL (PVT) LTD.', 'MAYNAGURI,\nJALPAIGURI', '', 129, '19831159084', '', '', '', '', 0, 26);
INSERT INTO `vendor` (`id`, `vendor_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(48, 'VARDHAMAN TRADERS', '23-A, HEAD POST OFFICE ROAD,CONOOR\n', '0423-2232657/09442229850', 130, '33102542261', '', '', '', '', 643101, 22);
INSERT INTO `vendor` (`id`, `vendor_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(49, 'CHAMURCHI AGRO (INDIA) LTD', '4,D.L.KHAN ROAD,4TH FLOOR,\nKOLKATA', '2252-6728', 131, '19251762079', '', '', '', '', 700025, 26);
INSERT INTO `vendor` (`id`, `vendor_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(50, 'KAYAN AGRO INDUSTRIES & CO. PVT. LTD.', '4A, POLLACK STREET, SWAIKA CENTER, ROOM NO- 1\nKOLKATA', '', 132, '19893391083', '', '', '', '', 700001, 26);
INSERT INTO `vendor` (`id`, `vendor_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(51, 'COOCHBEHAR AGRO TEA ESTATE (P)LTD.', 'HINDUSTHAN BUILDING\n4, CHITTARANJAN AVENUE, 2ND FLOOR\nKOLKATA', '2212-6753/54', 133, '19541045082', '', '', '', '', 700072, 26);
INSERT INTO `vendor` (`id`, `vendor_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(52, 'MOGULKATA TEA COMPANY PVT.LTD', 'H.O.\nMITTER HOUSE. 71, GANESH CHANDRA AVENUE, (3RD FLOOR)   KOLKATA', '033-23371747', 135, '19533791034', '19533791034', '', '', '', 700013, 26);
INSERT INTO `vendor` (`id`, `vendor_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(53, 'RYDAK SYNDICATE LTD', '4, Dr. RAJENDRA PRASAD SARANI, KOLKATA\n', '', 136, '19480044013', '', '', '', '', 700001, 26);
INSERT INTO `vendor` (`id`, `vendor_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(54, 'BALASON TEA CO. PVT.LTD.', 'HINDUSTHAN BUILDING, 4,CHITTARANJAN AVENUE, 2ND FLOOR, KOLKATA', '033-22126753', 137, '19893813033', '', '', '', '', 700072, 26);
INSERT INTO `vendor` (`id`, `vendor_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES(55, 'GOOD POINT TEA PVT. LTD.', '1ST FLOOR, BALAJI COMPLEX,PANITANKI ROAD, SEVOK ROAD, SILIGURI', '0353-2527805', 138, '19470546064', '', '', '', '', 734001, 26);

-- --------------------------------------------------------

--
-- Table structure for table `vendor_bill_master`
--

CREATE TABLE IF NOT EXISTS `vendor_bill_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bill_id` int(11) DEFAULT NULL,
  `bill_amount` double(10,4) DEFAULT NULL,
  `due_amount` double(10,4) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `year_id` int(11) DEFAULT NULL,
  `voucher_id` int(11) DEFAULT NULL,
  `from_where` enum('PR','SB') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_billmaster_voucher_id` (`voucher_id`),
  KEY `FK_billmaster_company_id` (`company_id`),
  KEY `FK_billmaster_year_id` (`year_id`),
  KEY `bill_id` (`bill_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=57 ;

--
-- Dumping data for table `vendor_bill_master`
--

INSERT INTO `vendor_bill_master` (`id`, `bill_id`, `bill_amount`, `due_amount`, `company_id`, `year_id`, `voucher_id`, `from_where`) VALUES(47, 44, 120140.5000, 120140.5000, 1, 1, 49, 'PR');
INSERT INTO `vendor_bill_master` (`id`, `bill_id`, `bill_amount`, `due_amount`, `company_id`, `year_id`, `voucher_id`, `from_where`) VALUES(48, 45, 133952.5000, 133952.5000, 1, 1, 50, 'PR');
INSERT INTO `vendor_bill_master` (`id`, `bill_id`, `bill_amount`, `due_amount`, `company_id`, `year_id`, `voucher_id`, `from_where`) VALUES(49, 46, 50377.6900, 50377.6900, 1, 1, 51, 'PR');
INSERT INTO `vendor_bill_master` (`id`, `bill_id`, `bill_amount`, `due_amount`, `company_id`, `year_id`, `voucher_id`, `from_where`) VALUES(50, 47, 86628.5000, 86628.5000, 1, 1, 52, 'PR');
INSERT INTO `vendor_bill_master` (`id`, `bill_id`, `bill_amount`, `due_amount`, `company_id`, `year_id`, `voucher_id`, `from_where`) VALUES(51, 48, 66510.5000, 66510.5000, 1, 1, 53, 'PR');
INSERT INTO `vendor_bill_master` (`id`, `bill_id`, `bill_amount`, `due_amount`, `company_id`, `year_id`, `voucher_id`, `from_where`) VALUES(52, 49, 219605.8900, 219605.8900, 1, 1, 54, 'PR');
INSERT INTO `vendor_bill_master` (`id`, `bill_id`, `bill_amount`, `due_amount`, `company_id`, `year_id`, `voucher_id`, `from_where`) VALUES(53, 50, 86341.5500, 86341.5500, 1, 1, 55, 'PR');
INSERT INTO `vendor_bill_master` (`id`, `bill_id`, `bill_amount`, `due_amount`, `company_id`, `year_id`, `voucher_id`, `from_where`) VALUES(54, 51, 262301.9500, 262301.9500, 1, 1, 56, 'PR');
INSERT INTO `vendor_bill_master` (`id`, `bill_id`, `bill_amount`, `due_amount`, `company_id`, `year_id`, `voucher_id`, `from_where`) VALUES(55, 52, 297509.8900, 297509.8900, 1, 1, 57, 'PR');
INSERT INTO `vendor_bill_master` (`id`, `bill_id`, `bill_amount`, `due_amount`, `company_id`, `year_id`, `voucher_id`, `from_where`) VALUES(56, 53, 547136.6300, 547136.6300, 1, 1, 58, 'PR');

-- --------------------------------------------------------

--
-- Table structure for table `vendor_opening_balance_noneed`
--

CREATE TABLE IF NOT EXISTS `vendor_opening_balance_noneed` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vendor_id` int(11) DEFAULT NULL,
  `bill_number` varchar(255) DEFAULT NULL,
  `bill_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `bill_amount` double(10,4) DEFAULT NULL,
  `due_amount` double(10,4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_vbalnc_vendor_id` (`vendor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `voucher_detail`
--

CREATE TABLE IF NOT EXISTS `voucher_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `voucher_master_id` int(11) DEFAULT NULL,
  `account_master_id` int(11) DEFAULT NULL,
  `voucher_amount` double(10,4) DEFAULT NULL,
  `is_debit` enum('Y','N') DEFAULT 'N',
  PRIMARY KEY (`id`),
  KEY `FK_voucherdetail_voucher_master_id` (`voucher_master_id`),
  KEY `FK_voucherdetail_account_master_id` (`account_master_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=465 ;

--
-- Dumping data for table `voucher_detail`
--

INSERT INTO `voucher_detail` (`id`, `voucher_master_id`, `account_master_id`, `voucher_amount`, `is_debit`) VALUES(396, 49, 6, 118951.0000, 'Y');
INSERT INTO `voucher_detail` (`id`, `voucher_master_id`, `account_master_id`, `voucher_amount`, `is_debit`) VALUES(397, 49, 5, 1189.5000, 'Y');
INSERT INTO `voucher_detail` (`id`, `voucher_master_id`, `account_master_id`, `voucher_amount`, `is_debit`) VALUES(398, 49, 46, 120140.5000, 'N');
INSERT INTO `voucher_detail` (`id`, `voucher_master_id`, `account_master_id`, `voucher_amount`, `is_debit`) VALUES(399, 50, 6, 129452.0000, 'Y');
INSERT INTO `voucher_detail` (`id`, `voucher_master_id`, `account_master_id`, `voucher_amount`, `is_debit`) VALUES(400, 50, 5, 4500.5000, 'Y');
INSERT INTO `voucher_detail` (`id`, `voucher_master_id`, `account_master_id`, `voucher_amount`, `is_debit`) VALUES(401, 50, 46, 133952.5000, 'N');
INSERT INTO `voucher_detail` (`id`, `voucher_master_id`, `account_master_id`, `voucher_amount`, `is_debit`) VALUES(402, 51, 6, 49878.9000, 'Y');
INSERT INTO `voucher_detail` (`id`, `voucher_master_id`, `account_master_id`, `voucher_amount`, `is_debit`) VALUES(403, 51, 5, 498.7900, 'Y');
INSERT INTO `voucher_detail` (`id`, `voucher_master_id`, `account_master_id`, `voucher_amount`, `is_debit`) VALUES(404, 51, 53, 50377.6900, 'N');
INSERT INTO `voucher_detail` (`id`, `voucher_master_id`, `account_master_id`, `voucher_amount`, `is_debit`) VALUES(405, 52, 6, 83652.0000, 'Y');
INSERT INTO `voucher_detail` (`id`, `voucher_master_id`, `account_master_id`, `voucher_amount`, `is_debit`) VALUES(406, 52, 5, 2976.5000, 'Y');
INSERT INTO `voucher_detail` (`id`, `voucher_master_id`, `account_master_id`, `voucher_amount`, `is_debit`) VALUES(407, 52, 46, 86628.5000, 'N');
INSERT INTO `voucher_detail` (`id`, `voucher_master_id`, `account_master_id`, `voucher_amount`, `is_debit`) VALUES(408, 53, 6, 65852.0000, 'Y');
INSERT INTO `voucher_detail` (`id`, `voucher_master_id`, `account_master_id`, `voucher_amount`, `is_debit`) VALUES(409, 53, 5, 658.5000, 'Y');
INSERT INTO `voucher_detail` (`id`, `voucher_master_id`, `account_master_id`, `voucher_amount`, `is_debit`) VALUES(410, 53, 46, 66510.5000, 'N');
INSERT INTO `voucher_detail` (`id`, `voucher_master_id`, `account_master_id`, `voucher_amount`, `is_debit`) VALUES(435, 55, 6, 85486.7000, 'Y');
INSERT INTO `voucher_detail` (`id`, `voucher_master_id`, `account_master_id`, `voucher_amount`, `is_debit`) VALUES(436, 55, 5, 854.8500, 'Y');
INSERT INTO `voucher_detail` (`id`, `voucher_master_id`, `account_master_id`, `voucher_amount`, `is_debit`) VALUES(437, 55, 127, 86341.5500, 'N');
INSERT INTO `voucher_detail` (`id`, `voucher_master_id`, `account_master_id`, `voucher_amount`, `is_debit`) VALUES(441, 56, 6, 259704.9000, 'Y');
INSERT INTO `voucher_detail` (`id`, `voucher_master_id`, `account_master_id`, `voucher_amount`, `is_debit`) VALUES(442, 56, 5, 2597.0500, 'Y');
INSERT INTO `voucher_detail` (`id`, `voucher_master_id`, `account_master_id`, `voucher_amount`, `is_debit`) VALUES(443, 56, 53, 262301.9500, 'N');
INSERT INTO `voucher_detail` (`id`, `voucher_master_id`, `account_master_id`, `voucher_amount`, `is_debit`) VALUES(450, 54, 6, 217431.6000, 'Y');
INSERT INTO `voucher_detail` (`id`, `voucher_master_id`, `account_master_id`, `voucher_amount`, `is_debit`) VALUES(451, 54, 5, 2174.2900, 'Y');
INSERT INTO `voucher_detail` (`id`, `voucher_master_id`, `account_master_id`, `voucher_amount`, `is_debit`) VALUES(452, 54, 41, 219605.8900, 'N');
INSERT INTO `voucher_detail` (`id`, `voucher_master_id`, `account_master_id`, `voucher_amount`, `is_debit`) VALUES(456, 57, 6, 294564.7900, 'Y');
INSERT INTO `voucher_detail` (`id`, `voucher_master_id`, `account_master_id`, `voucher_amount`, `is_debit`) VALUES(457, 57, 5, 2945.1000, 'Y');
INSERT INTO `voucher_detail` (`id`, `voucher_master_id`, `account_master_id`, `voucher_amount`, `is_debit`) VALUES(458, 57, 50, 297509.8900, 'N');
INSERT INTO `voucher_detail` (`id`, `voucher_master_id`, `account_master_id`, `voucher_amount`, `is_debit`) VALUES(462, 58, 6, 541720.9100, 'Y');
INSERT INTO `voucher_detail` (`id`, `voucher_master_id`, `account_master_id`, `voucher_amount`, `is_debit`) VALUES(463, 58, 5, 5415.7600, 'Y');
INSERT INTO `voucher_detail` (`id`, `voucher_master_id`, `account_master_id`, `voucher_amount`, `is_debit`) VALUES(464, 58, 53, 547136.6300, 'N');

-- --------------------------------------------------------

--
-- Table structure for table `voucher_master`
--

CREATE TABLE IF NOT EXISTS `voucher_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `voucher_number` varchar(255) DEFAULT NULL,
  `voucher_date` date DEFAULT NULL,
  `narration` varchar(255) DEFAULT NULL,
  `cheque_number` varchar(255) DEFAULT NULL,
  `cheque_date` date DEFAULT NULL,
  `transaction_type` varchar(50) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `year_id` int(11) DEFAULT NULL,
  `serial_number` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_voucher_created_by` (`created_by`),
  KEY `FK_voucher_company_id` (`company_id`),
  KEY `FK_voucher_year_id` (`year_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=59 ;

--
-- Dumping data for table `voucher_master`
--

INSERT INTO `voucher_master` (`id`, `voucher_number`, `voucher_date`, `narration`, `cheque_number`, `cheque_date`, `transaction_type`, `created_by`, `company_id`, `year_id`, `serial_number`) VALUES(49, 'PR/00012015-2016', '2015-06-12', 'Purchase Invoice Number T-00012T-000122015-06-12', NULL, NULL, 'PR', 2, 1, 1, 1);
INSERT INTO `voucher_master` (`id`, `voucher_number`, `voucher_date`, `narration`, `cheque_number`, `cheque_date`, `transaction_type`, `created_by`, `company_id`, `year_id`, `serial_number`) VALUES(50, 'PR/000502015-2016', '2015-06-26', 'Purchase Invoice Number TEST/26/06/2015/00001TEST/26/06/2015/000012015-06-26', NULL, NULL, 'PR', 2, 1, 1, 2);
INSERT INTO `voucher_master` (`id`, `voucher_number`, `voucher_date`, `narration`, `cheque_number`, `cheque_date`, `transaction_type`, `created_by`, `company_id`, `year_id`, `serial_number`) VALUES(51, 'PR/000512015-2016', '2015-07-01', 'Purchase Invoice Number TESTTEST2015-07-01', NULL, NULL, 'PR', 2, 1, 1, 3);
INSERT INTO `voucher_master` (`id`, `voucher_number`, `voucher_date`, `narration`, `cheque_number`, `cheque_date`, `transaction_type`, `created_by`, `company_id`, `year_id`, `serial_number`) VALUES(52, 'PR/000522015-2016', '2015-07-20', 'Purchase Invoice Number TEST/SOFT/0001/TESTTEST/SOFT/0001/TEST2015-07-20', NULL, NULL, 'PR', 2, 1, 1, 4);
INSERT INTO `voucher_master` (`id`, `voucher_number`, `voucher_date`, `narration`, `cheque_number`, `cheque_date`, `transaction_type`, `created_by`, `company_id`, `year_id`, `serial_number`) VALUES(53, 'PR/000532015-2016', '2015-07-20', 'Purchase Invoice Number TEST/0001/200715TEST/0001/2007152015-07-20', NULL, NULL, 'PR', 2, 1, 1, 5);
INSERT INTO `voucher_master` (`id`, `voucher_number`, `voucher_date`, `narration`, `cheque_number`, `cheque_date`, `transaction_type`, `created_by`, `company_id`, `year_id`, `serial_number`) VALUES(54, 'PR/000542015-2016', '2015-07-14', 'Purchase Invoice Number PIP/AUC/KOL/L/2103PIP/AUC/KOL/L/21032015-07-14', NULL, NULL, 'PR', 2, 1, 1, 6);
INSERT INTO `voucher_master` (`id`, `voucher_number`, `voucher_date`, `narration`, `cheque_number`, `cheque_date`, `transaction_type`, `created_by`, `company_id`, `year_id`, `serial_number`) VALUES(55, 'PR/000552015-2016', '2015-07-14', 'Purchase Invoice Number CB/K/CT/15-16/1478CB/K/CT/15-16/14782015-07-14', NULL, NULL, 'PR', 2, 1, 1, 7);
INSERT INTO `voucher_master` (`id`, `voucher_number`, `voucher_date`, `narration`, `cheque_number`, `cheque_date`, `transaction_type`, `created_by`, `company_id`, `year_id`, `serial_number`) VALUES(56, 'PR/000562015-2016', '2015-07-14', 'Purchase Invoice Number ABL/KOL1850/15-16ABL/KOL1850/15-162015-07-14', NULL, NULL, 'PR', 2, 1, 1, 8);
INSERT INTO `voucher_master` (`id`, `voucher_number`, `voucher_date`, `narration`, `cheque_number`, `cheque_date`, `transaction_type`, `created_by`, `company_id`, `year_id`, `serial_number`) VALUES(57, 'PR/000572015-2016', '2015-07-22', 'Purchase Invoice Number CB/SL/CT/15-16/2554CB/SL/CT/15-16/25542015-07-22', NULL, NULL, 'PR', 2, 1, 1, 9);
INSERT INTO `voucher_master` (`id`, `voucher_number`, `voucher_date`, `narration`, `cheque_number`, `cheque_date`, `transaction_type`, `created_by`, `company_id`, `year_id`, `serial_number`) VALUES(58, 'PR/000582015-2016', '2015-08-25', 'Purchase Invoice Number ABL/KOL2911/15-16ABL/KOL2911/15-162015-08-25', NULL, NULL, 'PR', 2, 1, 1, 10);

-- --------------------------------------------------------

--
-- Table structure for table `warehouse`
--

CREATE TABLE IF NOT EXISTS `warehouse` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `code` varchar(10) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `area` varchar(100) DEFAULT 'null',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=79 ;

--
-- Dumping data for table `warehouse`
--

INSERT INTO `warehouse` (`id`, `code`, `name`, `area`) VALUES(7, '001', 'OWN', 'SANTOSHPUR, B.B.T.R');
INSERT INTO `warehouse` (`id`, `code`, `name`, `area`) VALUES(16, '010', 'L M - U2', '');
INSERT INTO `warehouse` (`id`, `code`, `name`, `area`) VALUES(17, '011', 'SREEMA-U 4', 'GORAGACHA ROAD, MAJHERHAT');
INSERT INTO `warehouse` (`id`, `code`, `name`, `area`) VALUES(18, '012', 'JPN/BROOKLYN', 'BROOKLYN, H. ROAD');
INSERT INTO `warehouse` (`id`, `code`, `name`, `area`) VALUES(19, '013', 'BEHERA/11TDR', 'T D R .H. ROAD');
INSERT INTO `warehouse` (`id`, `code`, `name`, `area`) VALUES(20, '014', 'MADHU-BBTR', 'B.B.T.R.  RAMPUR');
INSERT INTO `warehouse` (`id`, `code`, `name`, `area`) VALUES(21, '015', 'HML', 'H.M.L. H.ROAD');
INSERT INTO `warehouse` (`id`, `code`, `name`, `area`) VALUES(22, '016', 'KTS/ BROOKLYN S2', 'H. ROAD');
INSERT INTO `warehouse` (`id`, `code`, `name`, `area`) VALUES(23, '017', 'J/S - 7 TDR', 'H. ROAD');
INSERT INTO `warehouse` (`id`, `code`, `name`, `area`) VALUES(24, '018', 'JS/P 9B TDR', 'H. ROAD');
INSERT INTO `warehouse` (`id`, `code`, `name`, `area`) VALUES(25, '019', 'DAVY/OSHED', 'KANTA PUKUR');
INSERT INTO `warehouse` (`id`, `code`, `name`, `area`) VALUES(26, '020', 'UNITY/UNIT', 'B.B.T.R');
INSERT INTO `warehouse` (`id`, `code`, `name`, `area`) VALUES(27, '021', 'ESEM 1 GGR', 'G.G. KANTA, H.ROAD');
INSERT INTO `warehouse` (`id`, `code`, `name`, `area`) VALUES(28, '022', 'OCTAVIUS, 2TDR', 'H. ROAD');
INSERT INTO `warehouse` (`id`, `code`, `name`, `area`) VALUES(29, '023', 'IBWC/NSHED', 'H.ROAD');
INSERT INTO `warehouse` (`id`, `code`, `name`, `area`) VALUES(30, '024', 'JAYSHREE/KHA', 'B.B.T.R KHALPOOL');
INSERT INTO `warehouse` (`id`, `code`, `name`, `area`) VALUES(31, '025', 'PATEL (10AMGR)', 'M.G.R. KHIDIRPUR');
INSERT INTO `warehouse` (`id`, `code`, `name`, `area`) VALUES(32, '026', 'KANOI', 'T.D.R. H. ROAD');
INSERT INTO `warehouse` (`id`, `code`, `name`, `area`) VALUES(33, '027', 'SONAI 2ES&amp;S', 'H. ROAD');
INSERT INTO `warehouse` (`id`, `code`, `name`, `area`) VALUES(34, '028', 'JS/RAMPUR', 'B.B.T.R');
INSERT INTO `warehouse` (`id`, `code`, `name`, `area`) VALUES(35, '029', 'ITSA(1/1 TDR)', 'H. ROAD');
INSERT INTO `warehouse` (`id`, `code`, `name`, `area`) VALUES(36, '030', 'J/S (P7 TDR)', 'T.D.R   H. ROAD');
INSERT INTO `warehouse` (`id`, `code`, `name`, `area`) VALUES(37, '031', 'BEHERA-1', 'H. ROAD');
INSERT INTO `warehouse` (`id`, `code`, `name`, `area`) VALUES(38, '032', 'ESS/P15 TDR', 'T.D.R  H.ROAD');
INSERT INTO `warehouse` (`id`, `code`, `name`, `area`) VALUES(39, '033', 'JS/ K POOL', 'B.B.T.R');
INSERT INTO `warehouse` (`id`, `code`, `name`, `area`) VALUES(40, '034', 'KAPPA (DAV)', 'KANTA PUKUR');
INSERT INTO `warehouse` (`id`, `code`, `name`, `area`) VALUES(42, '035', 'UNITY RAMPUR', 'B.B.T.R');
INSERT INTO `warehouse` (`id`, `code`, `name`, `area`) VALUES(43, '036', 'OS (TDR)', 'H.ROAD');
INSERT INTO `warehouse` (`id`, `code`, `name`, `area`) VALUES(44, '037', 'NITB (1 TDR)', 'H.ROAD');
INSERT INTO `warehouse` (`id`, `code`, `name`, `area`) VALUES(45, '038', 'KAMAL TEWARI', 'H.ROAD');
INSERT INTO `warehouse` (`id`, `code`, `name`, `area`) VALUES(46, '039', 'SREEMA-P51', 'TARATALLA');
INSERT INTO `warehouse` (`id`, `code`, `name`, `area`) VALUES(47, '040', 'UNITY-UNIT 4', 'B.B.T.R');
INSERT INTO `warehouse` (`id`, `code`, `name`, `area`) VALUES(48, '041', 'BS4 GG KATA', 'H.ROAD');
INSERT INTO `warehouse` (`id`, `code`, `name`, `area`) VALUES(49, '042', 'JJPUL (OS)', 'H.ROAD');
INSERT INTO `warehouse` (`id`, `code`, `name`, `area`) VALUES(50, '043', 'BANSHI GG KATA', 'H.ROAD');
INSERT INTO `warehouse` (`id`, `code`, `name`, `area`) VALUES(51, '044', 'KANOI (3TDR)', 'H.ROAD');
INSERT INTO `warehouse` (`id`, `code`, `name`, `area`) VALUES(52, '045', 'TEWARI - F SHED', 'KANTA PUKUR');
INSERT INTO `warehouse` (`id`, `code`, `name`, `area`) VALUES(53, '046', 'BEHERA -K ASHANI', 'T.D.R.   H. ROAD');
INSERT INTO `warehouse` (`id`, `code`, `name`, `area`) VALUES(57, '047', 'DUTTA/BBTR', 'B.B.T.R');
INSERT INTO `warehouse` (`id`, `code`, `name`, `area`) VALUES(58, '048', 'UNITY-U3', 'B.B.T.R');
INSERT INTO `warehouse` (`id`, `code`, `name`, `area`) VALUES(59, '049', 'BBTR UNITY', 'B.B.T.R');
INSERT INTO `warehouse` (`id`, `code`, `name`, `area`) VALUES(60, '050', 'UNITY-U1', 'B.B.T.R');
INSERT INTO `warehouse` (`id`, `code`, `name`, `area`) VALUES(61, '051', 'JPNAYAK', 'RAMPUR');
INSERT INTO `warehouse` (`id`, `code`, `name`, `area`) VALUES(62, '052', 'JPNAYAK 1/1', 'TARATOLA');
INSERT INTO `warehouse` (`id`, `code`, `name`, `area`) VALUES(63, '053', 'BEHERA-1OTA SHED', 'H.ROAD');
INSERT INTO `warehouse` (`id`, `code`, `name`, `area`) VALUES(64, '054', 'DEV-KAPPA', 'KANTA PUKUR');
INSERT INTO `warehouse` (`id`, `code`, `name`, `area`) VALUES(65, '055', 'INDIAN T STOR', 'B.B.T.R');
INSERT INTO `warehouse` (`id`, `code`, `name`, `area`) VALUES(66, '055', 'BEHERA ( J SHED)', 'H.ROAD');
INSERT INTO `warehouse` (`id`, `code`, `name`, `area`) VALUES(67, '056', 'SILIGURI', 'SILIGURI');
INSERT INTO `warehouse` (`id`, `code`, `name`, `area`) VALUES(68, '057', 'ESS/ 2, SONAI', '');
INSERT INTO `warehouse` (`id`, `code`, `name`, `area`) VALUES(69, '058', 'BEHERA P1 TDRS', 'H.ROAD');
INSERT INTO `warehouse` (`id`, `code`, `name`, `area`) VALUES(70, '059', 'AMBAR/G3', 'JALKOL. B.B.T.R');
INSERT INTO `warehouse` (`id`, `code`, `name`, `area`) VALUES(71, '060', 'SATYABHAMA/GG', 'H. ROAD');
INSERT INTO `warehouse` (`id`, `code`, `name`, `area`) VALUES(72, '061', 'BEHERA W SHADE', 'H.ROAD');
INSERT INTO `warehouse` (`id`, `code`, `name`, `area`) VALUES(73, '062', 'UNITY UNIT 2A', 'B.B.T.R');
INSERT INTO `warehouse` (`id`, `code`, `name`, `area`) VALUES(75, '063', 'UNITY 2', 'B.B.T.R');
INSERT INTO `warehouse` (`id`, `code`, `name`, `area`) VALUES(76, '063', 'UNITY 2B', 'B.B.T.R');
INSERT INTO `warehouse` (`id`, `code`, `name`, `area`) VALUES(77, '064', 'JPNAYK 1/1 TDR', 'TRANSPORT DEPOT ROAD,  H.ROAD');
INSERT INTO `warehouse` (`id`, `code`, `name`, `area`) VALUES(78, '', 'SOVAN ', 'RAMPUR');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `account_master`
--
ALTER TABLE `account_master`
  ADD CONSTRAINT `FK_account_group_master_id` FOREIGN KEY (`group_master_id`) REFERENCES `group_master` (`id`);

--
-- Constraints for table `account_opening_master`
--
ALTER TABLE `account_opening_master`
  ADD CONSTRAINT `FK_account_master_id` FOREIGN KEY (`account_master_id`) REFERENCES `account_master` (`id`),
  ADD CONSTRAINT `FK_company_id` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`),
  ADD CONSTRAINT `FK_financialyear_id` FOREIGN KEY (`financialyear_id`) REFERENCES `financialyear` (`id`);

--
-- Constraints for table `blending_details`
--
ALTER TABLE `blending_details`
  ADD CONSTRAINT `FK_bagDtlId` FOREIGN KEY (`purchasebag_id`) REFERENCES `purchase_bag_details` (`id`),
  ADD CONSTRAINT `FK_blendingmaster` FOREIGN KEY (`blending_master_id`) REFERENCES `blending_master` (`id`),
  ADD CONSTRAINT `FK_purDtlId` FOREIGN KEY (`purchase_dtl_id`) REFERENCES `purchase_invoice_detail` (`id`);

--
-- Constraints for table `blending_master`
--
ALTER TABLE `blending_master`
  ADD CONSTRAINT `FK_productid` FOREIGN KEY (`productid`) REFERENCES `product` (`id`);

--
-- Constraints for table `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `FK_customer_account_master_id` FOREIGN KEY (`account_master_id`) REFERENCES `account_master` (`id`),
  ADD CONSTRAINT `FK_customer_state_id` FOREIGN KEY (`state_id`) REFERENCES `state_master` (`id`);

--
-- Constraints for table `customer_bill_master`
--
ALTER TABLE `customer_bill_master`
  ADD CONSTRAINT `FK_customer_bill_master_bill_id` FOREIGN KEY (`bill_id`) REFERENCES `purchase_invoice_master` (`id`),
  ADD CONSTRAINT `FK_customer_bill_master_company_id` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`),
  ADD CONSTRAINT `FK_customer_bill_master_voucher_id` FOREIGN KEY (`voucher_id`) REFERENCES `voucher_master` (`id`),
  ADD CONSTRAINT `FK_customer_bill_master_year_id` FOREIGN KEY (`year_id`) REFERENCES `financialyear` (`id`);

--
-- Constraints for table `do_to_transporter`
--
ALTER TABLE `do_to_transporter`
  ADD CONSTRAINT `fk_location_id` FOREIGN KEY (`locationId`) REFERENCES `location` (`id`),
  ADD CONSTRAINT `fk_purchase_dtl` FOREIGN KEY (`purchase_inv_dtlid`) REFERENCES `purchase_invoice_detail` (`id`),
  ADD CONSTRAINT `fk_purchase_mst` FOREIGN KEY (`purchase_inv_mst_id`) REFERENCES `purchase_invoice_master` (`id`),
  ADD CONSTRAINT `fk_transporter_id` FOREIGN KEY (`transporterId`) REFERENCES `transport` (`id`);

--
-- Constraints for table `finished_product`
--
ALTER TABLE `finished_product`
  ADD CONSTRAINT `FK_blend` FOREIGN KEY (`blended_id`) REFERENCES `blending_master` (`id`),
  ADD CONSTRAINT `fk_finishproduct` FOREIGN KEY (`productId`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `FK_warehouse` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouse` (`id`);

--
-- Constraints for table `finished_product_dtl`
--
ALTER TABLE `finished_product_dtl`
  ADD CONSTRAINT `fk_finish_prod_id` FOREIGN KEY (`finishProductId`) REFERENCES `finished_product` (`id`),
  ADD CONSTRAINT `fk_prod_pack` FOREIGN KEY (`product_packet`) REFERENCES `product_packet` (`id`);

--
-- Constraints for table `group_category`
--
ALTER TABLE `group_category`
  ADD CONSTRAINT `FK_group_name_id` FOREIGN KEY (`group_name_id`) REFERENCES `group_name` (`id`),
  ADD CONSTRAINT `FK_sub_group_name_id` FOREIGN KEY (`sub_group_name_id`) REFERENCES `subgroup_name` (`id`);

--
-- Constraints for table `group_master`
--
ALTER TABLE `group_master`
  ADD CONSTRAINT `FK_group_category_id` FOREIGN KEY (`group_category_id`) REFERENCES `group_category` (`id`);

--
-- Constraints for table `item_master`
--
ALTER TABLE `item_master`
  ADD CONSTRAINT `FK_garden_id` FOREIGN KEY (`garden_id`) REFERENCES `garden_master` (`id`),
  ADD CONSTRAINT `FK_grade_id` FOREIGN KEY (`grade_id`) REFERENCES `grade_master` (`id`);

--
-- Constraints for table `location`
--
ALTER TABLE `location`
  ADD CONSTRAINT `fk_warehouse_location` FOREIGN KEY (`warehouseid`) REFERENCES `warehouse` (`id`);

--
-- Constraints for table `product_packet`
--
ALTER TABLE `product_packet`
  ADD CONSTRAINT `fk_packet` FOREIGN KEY (`packetid`) REFERENCES `packet` (`id`),
  ADD CONSTRAINT `fk_product` FOREIGN KEY (`productid`) REFERENCES `product` (`id`);

--
-- Constraints for table `purchase_bag_details`
--
ALTER TABLE `purchase_bag_details`
  ADD CONSTRAINT `fk_purchase_dtlId` FOREIGN KEY (`purchasedtlid`) REFERENCES `purchase_invoice_detail` (`id`);

--
-- Constraints for table `purchase_invoice_detail`
--
ALTER TABLE `purchase_invoice_detail`
  ADD CONSTRAINT `FK_DETAIL_garden_id` FOREIGN KEY (`garden_id`) REFERENCES `garden_master` (`id`),
  ADD CONSTRAINT `FK_DETAIL_grade_id` FOREIGN KEY (`grade_id`) REFERENCES `grade_master` (`id`),
  ADD CONSTRAINT `FK_DETAIL_warehouse_id` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouse` (`id`),
  ADD CONSTRAINT `FK_purchase_master_id` FOREIGN KEY (`purchase_master_id`) REFERENCES `purchase_invoice_master` (`id`);

--
-- Constraints for table `purchase_invoice_master`
--
ALTER TABLE `purchase_invoice_master`
  ADD CONSTRAINT `FK_vendor_id` FOREIGN KEY (`vendor_id`) REFERENCES `vendor` (`id`),
  ADD CONSTRAINT `FK_vouchermaster_id` FOREIGN KEY (`voucher_master_id`) REFERENCES `voucher_master` (`id`),
  ADD CONSTRAINT `purchase_invoice_master_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `purchase_invoice_master_ibfk_2` FOREIGN KEY (`year_id`) REFERENCES `financialyear` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `purchase_invoice_sample`
--
ALTER TABLE `purchase_invoice_sample`
  ADD CONSTRAINT `FK_purchase_invoice_detail_id` FOREIGN KEY (`purchase_invoice_detail_id`) REFERENCES `purchase_invoice_detail` (`id`);

--
-- Constraints for table `saler_to_buyer_details`
--
ALTER TABLE `saler_to_buyer_details`
  ADD CONSTRAINT `FK_STBD_garden_id` FOREIGN KEY (`garden_id`) REFERENCES `garden_master` (`id`),
  ADD CONSTRAINT `FK_STBD_grade_id` FOREIGN KEY (`grade_id`) REFERENCES `grade_master` (`id`),
  ADD CONSTRAINT `FK_STBD_saler_to_buyer_master` FOREIGN KEY (`saler_to_buyer_master_id`) REFERENCES `saler_to_buyer_master` (`id`);

--
-- Constraints for table `saler_to_buyer_master`
--
ALTER TABLE `saler_to_buyer_master`
  ADD CONSTRAINT `FK_STB_company_id` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_STB_vendor_id` FOREIGN KEY (`vendor_id`) REFERENCES `vendor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_STB_vouchermaster_id` FOREIGN KEY (`voucher_master_id`) REFERENCES `voucher_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `PK_STB_year_id` FOREIGN KEY (`year_id`) REFERENCES `financialyear` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `saler_to_buyer_sample`
--
ALTER TABLE `saler_to_buyer_sample`
  ADD CONSTRAINT `FK_STBS_saler_to_buyer_detail_id` FOREIGN KEY (`saler_to_buyer_detail_id`) REFERENCES `saler_to_buyer_details` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sale_bill_details`
--
ALTER TABLE `sale_bill_details`
  ADD CONSTRAINT `fk_product_packet_id` FOREIGN KEY (`productpacketid`) REFERENCES `product_packet` (`id`),
  ADD CONSTRAINT `fk_salebill_master` FOREIGN KEY (`salebillmasterid`) REFERENCES `sale_bill_master` (`id`);

--
-- Constraints for table `sale_bill_master`
--
ALTER TABLE `sale_bill_master`
  ADD CONSTRAINT `fk_customer` FOREIGN KEY (`customerId`) REFERENCES `customer` (`id`);

--
-- Constraints for table `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `FK_stock_company_id` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`),
  ADD CONSTRAINT `FK_stock_year_id` FOREIGN KEY (`year_id`) REFERENCES `financialyear` (`id`);

--
-- Constraints for table `unreleaseddo`
--
ALTER TABLE `unreleaseddo`
  ADD CONSTRAINT `FK_unreleaseddo_purchase_invoice_master_id` FOREIGN KEY (`purchase_invoice_master_id`) REFERENCES `purchase_invoice_master` (`id`);

--
-- Constraints for table `userole`
--
ALTER TABLE `userole`
  ADD CONSTRAINT `FK_USERROLE_RID` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `FK_USERROLE_UID` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `vendor`
--
ALTER TABLE `vendor`
  ADD CONSTRAINT `FK_vendor_account_master_id` FOREIGN KEY (`account_master_id`) REFERENCES `account_master` (`id`),
  ADD CONSTRAINT `FK_vendor_state_id` FOREIGN KEY (`state_id`) REFERENCES `state_master` (`id`);

--
-- Constraints for table `vendor_bill_master`
--
ALTER TABLE `vendor_bill_master`
  ADD CONSTRAINT `FK_billmaster_company_id` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`),
  ADD CONSTRAINT `FK_billmaster_voucher_id` FOREIGN KEY (`voucher_id`) REFERENCES `voucher_master` (`id`),
  ADD CONSTRAINT `FK_billmaster_year_id` FOREIGN KEY (`year_id`) REFERENCES `financialyear` (`id`);

--
-- Constraints for table `vendor_opening_balance_noneed`
--
ALTER TABLE `vendor_opening_balance_noneed`
  ADD CONSTRAINT `FK_vbalnc_vendor_id` FOREIGN KEY (`vendor_id`) REFERENCES `vendor` (`id`);

--
-- Constraints for table `voucher_detail`
--
ALTER TABLE `voucher_detail`
  ADD CONSTRAINT `FK_voucherdetail_account_master_id` FOREIGN KEY (`account_master_id`) REFERENCES `account_master` (`id`),
  ADD CONSTRAINT `FK_voucherdetail_voucher_master_id` FOREIGN KEY (`voucher_master_id`) REFERENCES `voucher_master` (`id`);

--
-- Constraints for table `voucher_master`
--
ALTER TABLE `voucher_master`
  ADD CONSTRAINT `FK_voucher_company_id` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`),
  ADD CONSTRAINT `FK_voucher_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `FK_voucher_year_id` FOREIGN KEY (`year_id`) REFERENCES `financialyear` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
