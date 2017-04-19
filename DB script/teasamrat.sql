-- phpMyAdmin SQL Dump
-- version 4.0.10.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 27, 2015 at 11:43 PM
-- Server version: 5.5.42-cll-lve
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=135 ;

--
-- Dumping data for table `account_master`
--

INSERT INTO `account_master` (`id`, `account_name`, `group_master_id`, `is_special`) VALUES
(5, 'VAT', 5, 'Y'),
(6, 'Purchase A/c', 4, 'Y'),
(7, 'Sale A/C', 3, 'Y'),
(30, 'J Thomas & Co. Pvt. Ltd', 2, 'N'),
(36, 'Cash in Hand ', 8, 'N'),
(41, 'Parcon India Private Limited', 2, 'N'),
(42, 'ASSAM TEA BROKERS PVT. LTD', 2, 'N'),
(44, 'ASSOCIATED BROKERS PVT.LTD (Siliguri)', 2, 'N'),
(45, 'BIJOYNAGAR TEA COMPANY LIMMITED', 2, 'N'),
(46, 'Softhought-Test', 2, 'N'),
(47, 'Paramount Tea Marketing Pvt Ltd.', 2, 'N'),
(48, 'JThomas & Company Pvt Ltd. (Siliguri)', 2, 'N'),
(49, 'PARCON INDIA PRIVATE LIMITED (Siliguri)', 2, 'N'),
(50, 'Contemporary Brokers Pvt.Ltd. (Siliguri)', 2, 'N'),
(52, 'JAY SHREE TEA & INDUSTRIES LTD.', 2, 'N'),
(53, 'ASSOCIATED BROKERS PVT.LTD', 2, 'N'),
(54, 'Test_data_edit', 1, 'N'),
(56, 'Raja', 1, 'N'),
(57, 'Rahul Roychowdhury', 1, 'N'),
(58, 'ISHAAN PLASTIC  PVT.LTD', 2, 'N'),
(59, 'N.N.PRINT & PACK PVT.LTD.', 2, 'N'),
(60, 'SURYA PACKAGERS', 2, 'N'),
(61, 'MKB PRINT & PACK SOLUTIONS PVT.LTD.', 2, 'N'),
(62, 'SATYAM ENTERPRISE', 2, 'N'),
(63, 'PRACHI INDUSTRIES', 2, 'N'),
(64, 'OM PACKAGING', 2, 'N'),
(65, 'SONY PACKAGING INDUSTRY', 2, 'N'),
(66, 'ARUP KUMAR NANDI', 1, 'N'),
(67, 'GOODMORNING TEA CENTRER & SUPPLIERS', 1, 'N'),
(68, 'REKHA TEA CENTRE ', 1, 'N'),
(69, 'ANNAPURNA BHANDER', 1, 'N'),
(70, 'MAA ANANDAMOYEE MILK SUPPLIERS', 1, 'N'),
(71, 'BIKI ENTERPRISE', 1, 'N'),
(72, 'NEERA TEA SUPPLIER', 1, 'N'),
(73, 'GOUTAM GORUI', 1, 'N'),
(74, 'AMITAVA MISRA', 1, 'N'),
(75, 'KARBALA TEA HOUSE', 1, 'N'),
(76, 'SREE RAM TRADERS', 1, 'N'),
(77, 'BARNALI ENTERPRISE', 1, 'N'),
(78, 'UTTAM ENTERPRISE', 1, 'N'),
(79, 'SAHA TEA HOUSE', 1, 'N'),
(80, 'SAMRAT REALPROJECTS PRIVATE LIMITED', 1, 'N'),
(81, 'M/S GHOSH ENTERPRISE', 1, 'N'),
(82, 'PRADIP TRADERS', 1, 'N'),
(83, 'LAKSHMI STORES', 1, 'N'),
(84, 'SUMANTA SADHUKHAN', 1, 'N'),
(85, 'ANIMA ROY', 1, 'N'),
(86, 'CHANDU SHEK', 1, 'N'),
(87, 'BALARAM DUTTA', 1, 'N'),
(88, 'DEY AGENCY', 1, 'N'),
(89, 'MALLICK TEA', 1, 'N'),
(90, 'ALOKE TEA', 1, 'N'),
(91, 'JYOTI TRADING', 1, 'N'),
(92, 'ANUP GHOSH', 1, 'N'),
(93, 'MAA RAMANI BHANDER', 1, 'N'),
(94, 'MAA GAYTREE ENTERPRISE', 1, 'N'),
(95, 'H.B. CORPORATION', 1, 'N'),
(96, 'SUBHASIS KUNDU', 1, 'N'),
(97, 'CHOUDHURY ENTERPRISE', 1, 'N'),
(98, 'NETAI NAG', 1, 'N'),
(99, 'ARUP KUMAR NANDI', 1, 'N'),
(100, 'DARJEELING TEA & TRADING CO.', 1, 'N'),
(101, 'TAPAN CHAKRABORTY', 1, 'N'),
(102, 'RAMAWTAR KHANDELWAL', 1, 'N'),
(103, 'GOODMORNING TEA CENTRE & SUPPLIERS', 1, 'N'),
(104, 'LIAKAT ALI', 1, 'N'),
(105, 'MALLICK TEA  (U)', 1, 'N'),
(106, 'SANKAR TRIPATHI', 1, 'N'),
(107, 'SREEMA TEA HOUSE', 1, 'N'),
(108, 'GANGA MATA AGENCY', 1, 'N'),
(109, 'UTTAM TEA HOUSE', 1, 'N'),
(110, 'SREE GURU ENTERPRISE', 1, 'N'),
(111, 'BASUDEV TRADING', 1, 'N'),
(112, 'GIRIDHARI MAJHI', 1, 'N'),
(113, 'ARUP TEA CORNER', 1, 'N'),
(114, 'R.S. ENTERPRISE', 1, 'N'),
(115, 'PRONAB DAS', 1, 'N'),
(116, 'KESHPUR TRADING', 1, 'N'),
(117, 'THE SIMULBARIE TEA COMPANY (PVT) LTD', 2, 'N'),
(118, 'CARE TEA PRIVATE LIMITED (SILIGURI)', 2, 'N'),
(119, 'NORTH BENGAL TEA BROKERS (P) LTD (SILIGURI)', 2, 'N'),
(120, 'Paramount Tea Marketing Pvt Ltd. (SILIGURI)', 2, 'N'),
(121, 'UNIVERSAL TEA TRADERS', 2, 'N'),
(122, 'NEW CHUMTA TEA COMPANY ', 2, 'N'),
(123, 'TEA CHAMPAGNE PRIVATE LIMITED', 2, 'N'),
(124, 'SUDHIR CHATERJEE & CO.PVT.LTD.', 2, 'N'),
(125, 'THE NEW TERAI ASSOCIATION LIMITED', 2, 'N'),
(126, 'GILLANDERS ARBUTHONT & CO.LTD.', 2, 'N'),
(127, 'CONTEMPORARY BROKERS PVT.LTD', 2, 'N'),
(128, 'KAMALA TEA CO.LTD', 2, 'N'),
(129, 'JAI JALPESH INTERNATIONAL (PVT) LTD.', 2, 'N'),
(130, 'VARDHAMAN TRADERS', 2, 'N'),
(131, 'CHAMURCHI AGRO (INDIA) LTD', 2, 'N'),
(132, 'KAYAN AGRO INDUSTRIES & CO. PVT. LTD.', 2, 'N'),
(133, 'COOCHBEHAR AGRO TEA ESTATE (P)LTD.', 2, 'N'),
(134, 'MADHU JAYANTI INTERNATIONAL LTD', 1, 'N');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=106 ;

--
-- Dumping data for table `account_opening_master`
--

INSERT INTO `account_opening_master` (`id`, `account_master_id`, `opening_balance`, `company_id`, `financialyear_id`) VALUES
(6, 30, '0.00', 1, 1),
(11, 41, '0.00', 1, 1),
(12, 36, '12000.00', 1, 1),
(13, 42, '0.00', 1, 1),
(15, 44, '0.00', 1, 1),
(16, 45, '0.00', 1, 1),
(17, 46, '0.00', 1, 1),
(18, 47, '0.00', 1, 1),
(19, 48, '0.00', 1, 1),
(20, 49, '0.00', 1, 1),
(21, 50, '0.00', 1, 1),
(23, 52, '0.00', 1, 1),
(24, 53, '0.00', 1, 1),
(25, 54, '100.00', 1, 1),
(28, 57, '2000.00', 1, 1),
(29, 58, '0.00', 1, 1),
(30, 59, '0.00', 1, 1),
(31, 60, '0.00', 1, 1),
(32, 61, '0.00', 1, 1),
(33, 62, '0.00', 1, 1),
(34, 63, '0.00', 1, 1),
(35, 64, '0.00', 1, 1),
(36, 65, '0.00', 1, 1),
(37, 66, '0.00', 1, 1),
(39, 68, '0.00', 1, 1),
(40, 69, '0.00', 1, 1),
(41, 70, '0.00', 1, 1),
(42, 71, '0.00', 1, 1),
(43, 72, '0.00', 1, 1),
(44, 73, '0.00', 1, 1),
(45, 74, '0.00', 1, 1),
(46, 75, '0.00', 1, 1),
(47, 76, '0.00', 1, 1),
(48, 77, '0.00', 1, 1),
(49, 78, '0.00', 1, 1),
(50, 79, '0.00', 1, 1),
(51, 80, '0.00', 1, 1),
(52, 81, '0.00', 1, 1),
(53, 82, '0.00', 1, 1),
(54, 83, '0.00', 1, 1),
(55, 84, '0.00', 1, 1),
(56, 85, '0.00', 1, 1),
(57, 86, '0.00', 1, 1),
(58, 87, '0.00', 1, 1),
(59, 88, '0.00', 1, 1),
(60, 89, '0.00', 1, 1),
(61, 90, '0.00', 1, 1),
(62, 91, '0.00', 1, 1),
(63, 92, '0.00', 1, 1),
(64, 93, '0.00', 1, 1),
(65, 94, '0.00', 1, 1),
(66, 95, '0.00', 1, 1),
(67, 96, '0.00', 1, 1),
(68, 97, '0.00', 1, 1),
(69, 98, '0.00', 1, 1),
(71, 100, '0.00', 1, 1),
(72, 101, '0.00', 1, 1),
(73, 102, '0.00', 1, 1),
(74, 103, '0.00', 1, 1),
(75, 104, '0.00', 1, 1),
(76, 105, '0.00', 1, 1),
(77, 106, '0.00', 1, 1),
(78, 107, '0.00', 1, 1),
(79, 108, '0.00', 1, 1),
(80, 109, '0.00', 1, 1),
(81, 110, '0.00', 1, 1),
(82, 111, '0.00', 1, 1),
(83, 112, '0.00', 1, 1),
(84, 113, '0.00', 1, 1),
(85, 114, '0.00', 1, 1),
(86, 115, '0.00', 1, 1),
(87, 116, '0.00', 1, 1),
(88, 117, '0.00', 1, 1),
(89, 118, '0.00', 1, 1),
(90, 119, '0.00', 1, 1),
(91, 120, '0.00', 1, 1),
(92, 121, '0.00', 1, 1),
(93, 122, '0.00', 1, 1),
(94, 123, '0.00', 1, 1),
(95, 124, '0.00', 1, 1),
(96, 125, '0.00', 1, 1),
(97, 126, '0.00', 1, 1),
(98, 127, '0.00', 1, 1),
(99, 128, '0.00', 1, 1),
(100, 129, '0.00', 1, 1),
(101, 130, '0.00', 1, 1),
(102, 131, '0.00', 1, 1),
(103, 132, '0.00', 1, 1),
(104, 133, '0.00', 1, 1),
(105, 134, '0.00', 1, 1);

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

INSERT INTO `auctionareamaster` (`id`, `auctionarea`) VALUES
(1, 'Kolkata Auction'),
(2, 'Siliguri Auction'),
(3, 'South India'),
(5, 'PRIVATE PURCHASES');

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

INSERT INTO `bagtypemaster` (`id`, `bagtype`) VALUES
(1, 'Normal'),
(2, 'Sample'),
(3, 'Shortage');

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `company_name`, `location`) VALUES
(1, 'Tea Samrat', '');

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

INSERT INTO `customer` (`id`, `customer_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES
(1, 'Test_data_edit', 'TEST', NULL, 54, '1121', '1121', '12121sdd', '1121sw', '12121sdd', 743503, 26),
(3, 'Rahul Roychowdhury', 'kolkata', '9876543210', 57, '0012', '23456', 'Aump1234', '999', '100', 700045, 26),
(4, 'ARUP KUMAR NANDI', 'SAINYA HOOGHLY', '', 66, '', '', '', '', '', 712305, 26),
(6, 'REKHA TEA CENTRE ', 'BETHUADAHARI,FULLTALA PARA,NADIA', '', 68, '19778712057', '', '', '', '', 741126, 26),
(7, 'ANNAPURNA BHANDER', '46/1A, STAND ROAD\n\n\n', '', 69, '19270698031', '', '', '', '', 700007, 26),
(8, 'MAA ANANDAMOYEE MILK SUPPLIERS', '810/243 N.BAHIRTAFA,ULUBERIA,HOWRAH', '', 70, '', '', '', '', '', 0, 26),
(9, 'BIKI ENTERPRISE', 'CHANDITALA, HOOGHLY', '', 71, '', '', '', '', '', 712701, 26),
(10, 'NEERA TEA SUPPLIER', 'VITARPARA,TARINPUR,NADIA.', '', 72, '19778687031', '', '', '', '', 741103, 26),
(11, 'GOUTAM GORUI', 'ASRAMPARA,BANKURA', '', 73, '', '', '', '', '', 0, 26),
(12, 'AMITAVA MISRA', 'JHARGRAM,MEDINIPUR (W)', '', 74, '19844790009', '', '', '', '', 0, 26),
(13, 'KARBALA TEA HOUSE', 'V,215/6 KARBALA ROAD,KOLKATA', '', 75, '', '', '', '', '', 700018, 26),
(14, 'SREE RAM TRADERS', 'N.S ROAD, GOCHARAN, KANTAPUKURIA,\nSOUTH 24 PARGANAS', '', 76, '19617479045', '', '', '', '', 743391, 26),
(15, 'BARNALI ENTERPRISE', 'MOLLAPARA, BATANAGAR.\nKOLKATA', '', 77, '', '', '', '', '', 700140, 26),
(16, 'UTTAM ENTERPRISE', 'D4-272/37 SANTOSHPUR STATION ROAD.\nRABINDRANAGAR\nSOUTH 24 PARGANAS', '', 78, '19637883092', '', '', '', '', 700018, 26),
(17, 'SAHA TEA HOUSE', 'SANTOSHPUR, PADIRHATI.\nKOLKATA', '', 79, '', '', '', '', '', 700066, 26),
(18, 'SAMRAT REALPROJECTS PRIVATE LIMITED', '8/1 LALBAZAR STREET,\nKOLKATA\n\n', '', 80, '19471987096', '', '', '', '', 700001, 26),
(19, 'M/S GHOSH ENTERPRISE', 'MURAKATA RAMPUR.\nMEDINIPUR (W)', '', 81, '19848900093', '', '', '', '', 721437, 26),
(20, 'PRADIP TRADERS', 'DEULPOTA KESHABCHAK,\nMEDINIPUR (E)', '', 82, '19858363025', '', '', '', '', 721432, 26),
(21, 'LAKSHMI STORES', '195/8 M.G. ROAD, BUDGE BUDGE.\nSOUTH 24 PARGANAS', '', 83, '19637903074', '', '', '', '', 700137, 26),
(22, 'SUMANTA SADHUKHAN', '21-B.G.T. ROAD,MALLICKPARA (W)\nSREERAMPUR.\nHOOGHLY', '', 84, '', '', '', '', '', 0, 26),
(23, 'ANIMA ROY', '230,NETAJI SUBHAS ROAD.\nMASANDA (W), NEWBARRACKPUR\n24 PARGANAS (N)', '', 85, '', '', '', '', '', 0, 26),
(24, 'CHANDU SHEK', 'VILL + P.O.- BHARATPUR.\nDIST - MURSIDABAD', '', 86, '', '', '', '', '', 742301, 26),
(25, 'BALARAM DUTTA', 'LALBAG,MURSIDABAD', '', 87, '', '', '', '', '', 0, 26),
(26, 'DEY AGENCY', 'PROTAPPUR, MEDINIPUR (E)', '', 88, '19853262086', '', '', '', '', 2147483647, 26),
(27, 'MALLICK TEA', 'CHANDANNAGAR , HOOGHLY ', '', 89, '19731017836', '', '', '', '', 712136, 26),
(28, 'ALOKE TEA', 'HATKHOLA, CHANDANNAGAR\nHOOGHLY', '', 90, '19739953088', '', '', '', '', 712136, 26),
(29, 'JYOTI TRADING', 'GOPIBALLAPPUR, JHARGRAM\nMEDINIPUR (W)', '', 91, '198404639CV', '', '', '', '', 712506, 26),
(30, 'ANUP GHOSH', 'VILL + P.O. - SONAKONIA, DATAN \nMEDINIPUR (W)\n', '', 92, '', '', '', '', '', 721426, 26),
(31, 'MAA RAMANI BHANDER', 'NACHINDA, MEDINIPUR (E)\n', '', 93, '19859360088', '', '', '', '', 721444, 26),
(32, 'MAA GAYTREE ENTERPRISE', '321,RBC ROAD GARIFA\n24 PARGANAS (N)\nNAIHATI', '', 94, '19661304518', '', '', '', '', 743166, 26),
(33, 'H.B. CORPORATION', 'A/46, SARALA BAGAN 83 JUGIPARA ROAD,\nKOLKATA', '', 95, '19612947011  ', '', '', '', '', 700149, 26),
(34, 'SUBHASIS KUNDU', '13 DHARINDA TAMLUK \nDistrict : MEDINIPUR(E)', '', 96, '19856136002', '', '', '', '', 0, 26),
(35, 'CHOUDHURY ENTERPRISE', '240/224, STATION BAZAR,\nMEMARI,BURDWAN', '', 97, '', '', '', '', '', 0, 26),
(36, 'NETAI NAG', 'MAROI BAZAR.\nBISHNUPUR, BANKURA.', '', 98, '', '', '', '', '', 0, 26),
(38, 'DARJEELING TEA & TRADING CO.', 'BAINCHEE BAZAR. HOOGHLY', '', 100, '19730259005', '', '', '', '', 0, 26),
(39, 'TAPAN CHAKRABORTY', 'SANTOSHPUR GOVT COLONY.\nKOLKATA.', '', 101, '', '', '', '', '', 700140, 26),
(40, 'RAMAWTAR KHANDELWAL', 'MALANCHA ROAD KHARAGPUR.\nMEDINIPUR(W)', '', 102, '19843212013', '', '', '', '', 0, 26),
(41, 'GOODMORNING TEA CENTRE & SUPPLIERS', 'CHAKDAHA BALARAMPUR, \nPASCHIM CHAKDAHA.\nNADIA', '', 103, '19778656088', '', '', '', '', 741222, 26),
(42, 'LIAKAT ALI', 'HAMADAM, BERA CHAKA,\n24 PATGANAS (N)', '', 104, '', '', '', '', '', 0, 26),
(43, 'MALLICK TEA  (U)', 'NORTH GANGARAMPUR , \nULUBERIA KAIJURI', '', 105, '', '', '', '', '', 711316, 26),
(44, 'SANKAR TRIPATHI', 'PROTAPPUR, PASKURA\nMEDINIPUR (E)', '', 106, '', '', '', '', '', 0, 26),
(45, 'SREEMA TEA HOUSE', 'BALICHAK, MEDINIPUR (W)', '', 107, '', '', '', '', '', 0, 26),
(46, 'GANGA MATA AGENCY', 'GOBINDANAGAR, CHENDHUA\n GOBINDANAGAR, DASPUR \nDistrict : MEDINIPUR(W) ', '', 108, '19843496029', '', '', '', '', 0, 26),
(47, 'UTTAM TEA HOUSE', 'MANIKPARA, JHARGRAM,\n District : MEDINIPUR(W', '', 109, '19848542066', '', '', '', '', 721513, 26),
(48, 'SREE GURU ENTERPRISE', 'BARA BAMUNIA, GUMA\nDistrict : NORTH 24 PARGANAS ', '', 110, '19651216906', '', '', '', '', 743704, 26),
(49, 'BASUDEV TRADING', '51/8 TARAKESWAR, BAJITPUR \nDistrict : HOOGLY', '', 111, '19739492047', '', '', '', '', 0, 26),
(50, 'GIRIDHARI MAJHI', 'GAJONKOL,MADHYAPARA,BALICHATURI\nSHYAMPUR, HOWRAH\n', '', 112, '', '', '', '', '', 711315, 26),
(51, 'ARUP TEA CORNER', 'VILL + P.O- HARIT, DATPUR\nHOOGHLY', '', 113, '', '', '', '', '', 712305, 26),
(52, 'R.S. ENTERPRISE', 'CHAITANYAPUR, HALDIA \nMECHEDA ROAD, \n District : MEDINIPUR(E)', '', 114, '19854030035', '', '', '', '', 721645, 26),
(53, 'PRONAB DAS', 'NAIHATI BAZAR,\n24 PARGANAS (N)', '', 115, '', '', '', '', '', 743249, 26),
(54, 'KESHPUR TRADING', '1934 KESHPUR \nDistrict : MEDINIPUR(W)', '', 116, '19843215020', '', '', '', '', 0, 26),
(55, 'MADHU JAYANTI INTERNATIONAL LTD', 'PACHIM BORAGAON,L.P. SCHOOL BYLANE\nMUKAND INFRASTRUCTUR PVT LTD - COMPOUND\nGUWAHATI', '09864259221', 134, '18240036291', '18339911167', '', '', '', 781033, 4);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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

INSERT INTO `financialyear` (`id`, `year`, `start_date`, `end_date`) VALUES
(1, '2015 - 2016', '2015-04-01', '2016-03-31'),
(2, '2014 - 2015', '2014-04-01', '2015-03-31'),
(3, '2013 - 2014', '2013-04-01', '2014-03-31'),
(4, '2012 - 2013', '2012-04-01', '2013-03-31'),
(5, '2011 - 2012', '2011-04-01', '2012-03-31');

-- --------------------------------------------------------

--
-- Table structure for table `garden_master`
--

CREATE TABLE IF NOT EXISTS `garden_master` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `garden_name` varchar(100) NOT NULL,
  `address` varchar(500) DEFAULT 'null',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=211 ;

--
-- Dumping data for table `garden_master`
--

INSERT INTO `garden_master` (`id`, `garden_name`, `address`) VALUES
(34, 'JATINGA', ''),
(36, 'DERBY', ''),
(39, 'LAMABARI', ''),
(40, 'KRISHNA BEHARI ROYAL', ''),
(41, 'PANBARI (BORCHOLA)', ''),
(42, 'BAGHMORA', ''),
(43, 'PALLORBUND', ''),
(44, 'DEWAN (SPECIAL)', ''),
(45, 'DOOTERIAH', ''),
(46, 'LONGVIEW', ''),
(47, 'MAHAMAYA', ''),
(48, 'KALPAK', ''),
(49, 'MAHALAXMI', ''),
(50, 'SUBHASINI', ''),
(51, 'AIBHEEL', ''),
(52, 'KUMAR GRAM', ''),
(53, 'JITI', ''),
(54, 'NIMTIJHORA', ''),
(55, 'LEESH RIVER', ''),
(56, 'WASHABARIE', ''),
(57, 'DANGUAJHAR', ''),
(58, 'MUJNAI', ''),
(59, 'KARBALLA', ''),
(60, 'CHALOUNI', ''),
(61, 'MATHURA', ''),
(62, 'MATRI', ''),
(63, 'BILATIBARI', ''),
(64, 'SATKHAYA', ''),
(65, 'HULDIGHATI', ''),
(66, 'KAMALA', ''),
(67, 'LEKHAPANI', ''),
(68, 'SARUGAON', ''),
(69, 'BRAHMAPUR', ''),
(70, 'SARASWATIPUR', ''),
(71, 'DIROK', ''),
(75, 'BHUYANKHAT', ''),
(76, 'URRUNABUND', ''),
(77, 'LARSINGAH', ''),
(78, 'KALCHINI', ''),
(79, 'SAMDANG', ''),
(81, 'DIMA', ''),
(82, 'DULIABUM', ''),
(83, 'PANEERY', ''),
(84, 'LABAC', ''),
(85, 'KOOMBER', ''),
(86, 'SAROJINI', ''),
(88, 'LENGRAI', ''),
(89, 'MANUVALLEY', ''),
(91, 'MORAN', ''),
(92, 'BURTOLL', ''),
(93, 'TURTURI', ''),
(94, 'SAHABARI', ''),
(95, 'JATINDRA MOHAN', ''),
(96, 'RANIPOKHRI', ''),
(97, 'KUNDALPOKHAR', ''),
(98, 'NOWERA NUDDY', ''),
(99, 'MAHAK', ''),
(100, 'NALSARBARI', ''),
(101, 'RAJA', ''),
(102, 'BHATPARA', ''),
(103, 'JAYBIRPARA', ''),
(104, 'DHOWLAJHORA', ''),
(105, 'GOPALPUR', ''),
(106, 'KIRAN CHANDRA', ''),
(107, 'NUXALBARI', ''),
(110, 'KONDALPOKHAR', ''),
(111, 'PARAGON', ''),
(112, 'RATNA', ''),
(113, 'BARUAPARA', ''),
(115, 'JALDAPARA', ''),
(116, 'CHUAPARA', ''),
(117, 'ANANDAPUR', ''),
(118, 'AMBARI', ''),
(119, 'ORD', ''),
(120, 'NALSAR', ''),
(121, 'ENGO', ''),
(122, 'SABRANG', ''),
(124, 'LEDO', ''),
(125, 'DRBIJHORA', ''),
(126, 'LALLACHERRA', ''),
(127, 'HOLLONG', ''),
(128, 'MARGHERITA', ''),
(129, 'HARISANGAR', ''),
(130, 'ATTAREEKHAT', ''),
(131, 'MONABARIE', ''),
(132, 'NAMDANG', ''),
(133, 'HUNWAL', ''),
(134, 'BEESAKOPIE', ''),
(135, 'ATTABARRIE', ''),
(136, 'CHANDANA', ''),
(137, 'NEW DOOARS', ''),
(138, 'MATELLI', ''),
(139, 'FULBARI', ''),
(140, 'SIMULBARI', ''),
(141, 'BIJBARI', ''),
(142, 'ETHELBARI', ''),
(143, 'KHARIBARI', ''),
(144, 'BEECH', ''),
(145, 'HULDIBARI', ''),
(146, 'BHARNOBARI', ''),
(147, 'PATKAPARA', ''),
(148, 'SAHEBBARI', ''),
(149, 'BIJOYNAGAR', ''),
(150, 'ARCUTTIPORE', ''),
(151, 'SAYEDABAD', ''),
(152, 'KAILASHPUR', ''),
(153, 'BHANDIGURI', ''),
(154, 'AMARPUR', ''),
(155, 'SATALI', ''),
(157, 'MAUSAM', ''),
(158, 'SUKNA', ''),
(159, 'CHINCHULA', ''),
(160, 'PIONEER', ''),
(161, 'BUDLA BETA', ''),
(162, 'TALUP', ''),
(163, 'OODLABARI', ''),
(164, 'PUSPA', ''),
(165, 'PUSPA GOLD', ''),
(166, 'SWAPNA', ''),
(167, 'SWAPNA GOLD', ''),
(168, 'GOAL GACH', ''),
(169, 'USHASREE', ''),
(170, 'SOVA', ''),
(171, 'GULMA', ''),
(172, 'ELLENBARRIE', ''),
(173, 'NAHORAJULI', ''),
(174, 'RONGOLIJAN', ''),
(175, 'SRIRAMPARA', ''),
(176, 'KALAMATI', ''),
(177, 'SRIKRISHNA', ''),
(178, 'DISHA', ''),
(179, 'HAPJAN', ''),
(180, 'PENGAREE', ''),
(181, 'SESSA', ''),
(182, 'AMGOORIE', ''),
(183, 'TIOK', ''),
(184, 'KOOMSONG', ''),
(186, 'HOOGRAJULI', ''),
(187, 'SINGRI', ''),
(188, 'HOKONGURI', ''),
(189, 'KHOBONG', ''),
(190, 'KAMAKHYA', ''),
(191, 'PURMA', ''),
(192, 'NAHORALI', ''),
(193, 'PANBARI', ''),
(194, 'R.D. GOLD', ''),
(195, 'RAJAH ALI', ''),
(196, 'MAYNAGURI', ''),
(197, 'GIRISH CHANDRA', ''),
(198, 'GOOMTEE', ''),
(199, 'CASTELTON', ''),
(200, 'KALEJ VALLEY', ''),
(202, 'MILIKTHONG', ''),
(203, 'GLENBURN', ''),
(204, 'JOGMAYA', ''),
(206, 'ARVIKAD', ''),
(207, 'PERTABGHUR', ''),
(208, 'SEPHINJURI', ''),
(209, 'LENGREE', ''),
(210, 'BINAGURI', '');

-- --------------------------------------------------------

--
-- Table structure for table `grade_master`
--

CREATE TABLE IF NOT EXISTS `grade_master` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `grade` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

--
-- Dumping data for table `grade_master`
--

INSERT INTO `grade_master` (`id`, `grade`) VALUES
(10, 'BP'),
(11, 'BOPSM'),
(14, 'BP1'),
(15, 'PF'),
(16, 'PF1'),
(17, 'BPSM1'),
(18, 'BPSM'),
(19, 'BOPS'),
(20, 'BOPF'),
(21, 'BOPSM1'),
(22, 'OF'),
(23, 'OF1'),
(24, 'DUST'),
(25, 'D'),
(26, 'TGOF'),
(27, 'GOF'),
(28, 'TGBOP'),
(29, 'SFTGFOP1'),
(30, 'GBOP'),
(31, 'FTGOF'),
(32, 'FTGFOP'),
(33, 'FOF'),
(34, 'FTGFOP1'),
(35, 'BOP');

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

INSERT INTO `group_category` (`id`, `group_name_id`, `sub_group_name_id`) VALUES
(13, 3, 1),
(15, 3, 2),
(16, 4, 3),
(17, 4, 4);

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

INSERT INTO `group_master` (`id`, `group_name`, `group_category_id`, `is_special`) VALUES
(1, 'Sundry Debtors', 13, 'Y'),
(2, 'Sundry Creditors', 15, 'Y'),
(3, 'Sale', 16, 'Y'),
(4, 'Purchase', 17, 'Y'),
(5, 'Indirect Expenditure', 17, 'Y'),
(8, 'Cash Balance', 13, 'Y');

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

INSERT INTO `group_name` (`id`, `name`) VALUES
(3, 'Balance Sheet'),
(4, 'Profit and Loss');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=433 ;

--
-- Dumping data for table `item_master`
--

INSERT INTO `item_master` (`id`, `grade_id`, `garden_id`, `invoice_number`, `package`, `net`, `gross`, `bill_id`, `from_where`) VALUES
(393, 10, 34, 'C40', 30, 40, '40.2', 44, 'AS'),
(394, 10, 36, 'C-40/26062015', NULL, NULL, '30.2', 45, 'AS'),
(395, 11, 45, 'C-50/26062015', NULL, NULL, '40.5', 45, 'AS'),
(396, 15, 86, '313', NULL, NULL, '36.19', 46, 'AS'),
(397, 10, 58, 'C41-0001', NULL, NULL, '30.2', 47, 'AS'),
(398, 18, 45, 'C4-0001', NULL, NULL, '20.5', 47, 'AS'),
(399, 28, 34, 'C-40', NULL, NULL, '30.2', 48, 'AS'),
(400, 28, 34, 'C-12', NULL, NULL, '20.5', 48, 'AS'),
(401, 15, 39, '162', NULL, NULL, '31.4', 49, 'AS'),
(402, 15, 39, '241', NULL, NULL, '30.4', NULL, 'AS'),
(403, 10, 81, '380', NULL, NULL, '35.2', NULL, 'AS'),
(404, 15, 39, '162', NULL, NULL, '031.4', NULL, 'AS'),
(405, 15, 39, '162', NULL, NULL, '31.40', NULL, 'AS'),
(406, 15, 34, '240014T', NULL, NULL, '28.4', 50, 'AS'),
(407, 15, 207, '240014T', NULL, NULL, '28.40', NULL, 'AS'),
(408, 10, 208, '149', NULL, NULL, '30.2', NULL, 'AS'),
(409, 11, 43, '389', NULL, NULL, '35.2', NULL, 'AS'),
(410, 10, 43, '387', NULL, NULL, '35.2', NULL, 'AS'),
(411, 22, 43, '376', NULL, NULL, '35.2', NULL, 'AS'),
(412, 10, 62, '472', NULL, NULL, '35.2', NULL, 'AS'),
(413, 15, 207, '240014T', NULL, NULL, '28.40', NULL, 'AS'),
(414, 15, 207, '240014T', NULL, NULL, '28.40', NULL, 'AS'),
(415, 10, 207, '240014T', NULL, NULL, '30.2', NULL, 'AS'),
(416, 15, 207, '240014T', NULL, NULL, '28.40', NULL, 'AS'),
(417, 15, 207, '240014T', NULL, NULL, '28.40', NULL, 'AS'),
(418, 10, 88, '195', NULL, NULL, '36.2', 51, 'AS'),
(419, 15, 88, '130', NULL, NULL, '34.2', 51, 'AS'),
(420, 11, 76, '135', NULL, NULL, '39.6', 51, 'AS'),
(421, 10, 76, '136', NULL, NULL, '40.6', 51, 'AS'),
(422, 10, 88, '195', NULL, NULL, '36.20', NULL, 'AS'),
(423, 15, 209, '130', NULL, NULL, '34.20', NULL, 'AS'),
(424, 11, 76, '135', NULL, NULL, '39.60', NULL, 'AS'),
(425, 10, 76, '136', NULL, NULL, '40.60', NULL, 'AS'),
(426, 15, 39, '162', NULL, NULL, '31.40', NULL, 'AS'),
(427, 15, 39, '162', NULL, NULL, '31.40', NULL, 'AS'),
(428, 15, 39, '162', NULL, NULL, '31.40', NULL, 'AS'),
(429, 10, 171, 'C664', NULL, NULL, '38.5', 52, 'AS'),
(430, 14, 171, 'C632', NULL, NULL, '38.5', NULL, 'AS'),
(431, 10, 63, 'C546', NULL, NULL, '38.22', NULL, 'AS'),
(432, 10, 171, 'C664', NULL, NULL, '38.50', NULL, 'AS');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`id`, `location`, `warehouseid`, `is_active`) VALUES
(5, 'L6', 7, 'Y'),
(6, '108', 7, 'Y');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `menu_name`, `menu_link`, `is_parent`, `parent_id`, `menu_code`) VALUES
(3, 'Get Ready', '', 'P', NULL, NULL),
(4, 'Garden', 'gardenmaster', 'C', 3, 'gardenmaster'),
(5, 'Grade', 'grademaster', 'C', 3, 'grademaster'),
(6, 'Warehouse', 'warehousemaster', 'C', 3, 'warehousemaster'),
(7, 'Service Tax', 'servicetaxmaster', 'C', 16, 'servicetaxmaster'),
(8, 'Broker', 'brokermaster', 'C', 3, 'brokermaster'),
(9, 'VAT', 'vatmaster', 'C', 16, 'vatmaster'),
(10, 'Group Category', 'groupcategorymaster', 'C', 16, 'groupcategorymaster'),
(11, 'Group Master', 'groupmaster', 'C', 16, 'groupmaster'),
(12, 'Account', 'accountmaster', 'C', 16, 'accountmaster'),
(13, 'Vendor', 'vendormaster', 'C', 3, 'vendormaster'),
(14, 'Purchase Invoice', 'purchaseinvoice', 'C', 27, 'purchaseinvoice'),
(15, 'Receiving DO', 'unreleaseddo', 'C', 27, 'unreleaseddo'),
(16, 'Accounts', 'acconuts', 'SC', 3, ''),
(17, 'CST', 'cstmaster', 'C', 16, 'cstmaster'),
(18, 'Customer', 'customermaster', 'C', 3, 'customermaster'),
(19, 'Transport', 'transportmaster', 'C', 3, 'transportmaster'),
(20, 'Tea Group', 'teagroupmaster', 'C', 3, 'teagroupmaster'),
(24, 'Send Do to Transporter', 'deliveryordertotransp', 'C', 27, 'deliveryordertotransp'),
(25, 'Transporter to Buyer', 'doproductrecv', 'C', 27, 'doproductrecv'),
(26, 'Location', 'locationmaster', 'C', 3, 'locationmaster'),
(27, 'Transaction', NULL, 'P', NULL, NULL),
(28, 'Stock Summery', 'stocksummery', 'C', 31, 'stocksummery'),
(29, 'Packet', 'packet', 'C', 3, 'packet'),
(30, 'product', 'product', 'C', 3, 'product'),
(31, 'Report', NULL, 'P', NULL, NULL),
(32, 'Auction Area', 'auctionarea', 'C', 3, 'auctionarea'),
(33, 'Short Adjustment', 'shortageadjustment', 'C', 27, 'shortageadjustment');

-- --------------------------------------------------------

--
-- Table structure for table `packet`
--

CREATE TABLE IF NOT EXISTS `packet` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `packet` varchar(255) DEFAULT NULL,
  `PacketQty` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `packet`
--

INSERT INTO `packet` (`id`, `packet`, `PacketQty`) VALUES
(1, 'Packet 250 gm', 0.25),
(2, 'Packet 2.5 Kg', 2.5),
(3, 'Packet 1 Kg', 1),
(4, 'Packet 50gm', 0.05),
(6, 'Packet 100 gm  ', 0.01);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `product`, `productdesc`, `is_active`, `insertiondate`) VALUES
(1, 'Samrat Petjar', 'Samrat Petjar', 'Y', NULL),
(2, 'Samrat Gold ', 'Samrat Gold ', 'Y', '2015-06-10 11:33:02'),
(3, 'Samrat premium', 'Samrat premium', 'Y', '2015-06-09 13:02:30');

-- --------------------------------------------------------

--
-- Table structure for table `product_packet`
--

CREATE TABLE IF NOT EXISTS `product_packet` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `productid` int(20) DEFAULT NULL,
  `packetid` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `indx_prduct` (`productid`),
  KEY `indx_pckt` (`packetid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `product_packet`
--

INSERT INTO `product_packet` (`id`, `productid`, `packetid`) VALUES
(1, 1, 2),
(2, 1, 1),
(3, 3, 1),
(4, 3, 3),
(5, 3, 6),
(6, 2, 1),
(7, 2, 4),
(8, 2, 6);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=96 ;

--
-- Dumping data for table `purchase_bag_details`
--

INSERT INTO `purchase_bag_details` (`id`, `purchasedtlid`, `bagtypeid`, `no_of_bags`, `net`, `shortkg`, `parent_bag_id`, `actual_bags`, `chestSerial`) VALUES
(74, 230, 1, 3, 28.00, NULL, NULL, 3, ''),
(75, 230, 2, 2, 21.00, NULL, NULL, 2, NULL),
(81, 237, 1, 10, 36.00, NULL, NULL, 10, ''),
(82, 238, 1, 9, 34.00, NULL, NULL, 9, ''),
(83, 238, 2, 1, 27.00, NULL, NULL, 1, ''),
(84, 239, 1, 10, 39.00, NULL, NULL, 10, ''),
(85, 240, 1, 15, 40.00, NULL, NULL, 15, ''),
(90, 227, 1, 8, 31.00, NULL, NULL, 8, ''),
(91, 227, 2, 1, 24.00, NULL, NULL, 1, NULL),
(94, 241, 1, 14, 38.00, NULL, NULL, 14, ''),
(95, 241, 2, 1, 29.40, NULL, NULL, 1, NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=244 ;

--
-- Dumping data for table `purchase_invoice_detail`
--

INSERT INTO `purchase_invoice_detail` (`id`, `purchase_master_id`, `lot`, `doRealisationDate`, `do`, `invoice_number`, `garden_id`, `grade_id`, `warehouse_id`, `gp_number`, `date`, `package`, `stamp`, `gross`, `brokerage`, `total_weight`, `rate_type_value`, `price`, `service_tax`, `total_value`, `chest_from`, `chest_to`, `value_cost`, `net`, `rate_type`, `rate_type_id`, `service_tax_id`, `teagroup_master_id`) VALUES
(227, 49, '144', NULL, '20802', '162', 39, 15, 26, '', NULL, NULL, '1.00', '31.40', '81.60', '272.00', 449.62, '165.00', '0.00', '45412.22', NULL, NULL, '44880.00', NULL, 'V', 7, 0, 5),
(228, 49, '147', NULL, '20803', '241', 39, 15, 26, '', NULL, NULL, '1.00', '30.40', '117.00', '390.00', 609.57, '156.00', '0.00', '61567.57', NULL, NULL, '60840.00', NULL, 'V', 7, 0, 5),
(229, 49, '402', NULL, '20801', '380', 81, 10, 31, '', NULL, NULL, '1.00', '35.20', '210.00', '700.00', 1115.10, '159.00', '0.00', '112626.10', NULL, NULL, '111300.00', NULL, 'V', 7, 0, 5),
(230, 50, '61', NULL, '11153', '240014T', 207, 15, 65, '', NULL, NULL, '1.00', '28.40', '37.80', '126.00', 189.38, '150.00', '0.00', '19128.18', NULL, NULL, '18900.00', NULL, 'V', 7, 0, 5),
(231, 50, '121', NULL, '11151', '149', 208, 10, 66, '', NULL, NULL, '1.00', '30.20', '150.90', '503.00', 665.47, '132.00', '0.00', '67213.37', NULL, NULL, '66396.00', NULL, 'V', 7, 0, 5),
(232, 50, '124', NULL, '11154', '389', 43, 11, 45, '', NULL, NULL, '1.00', '35.20', '102.90', '343.00', 433.21, '126.00', '0.00', '43755.11', NULL, NULL, '43218.00', NULL, 'V', 7, 0, 5),
(233, 50, '130', NULL, '11155', '387', 43, 10, 45, '', NULL, NULL, '1.00', '35.20', '102.90', '343.00', 460.65, '134.00', '0.00', '46526.55', NULL, NULL, '45962.00', NULL, 'V', 7, 0, 5),
(234, 50, '134', NULL, '11156', '376', 43, 22, 45, '', NULL, NULL, '1.00', '35.20', '155.40', '518.00', 706.03, '136.00', '0.00', '71310.43', NULL, NULL, '70448.00', NULL, 'V', 7, 0, 5),
(235, 50, '134', NULL, '11152', '472', 62, 10, 19, '', NULL, NULL, '1.00', '35.20', '310.80', '1036.00', 1267.03, '122.00', '0.00', '127970.83', NULL, NULL, '126392.00', NULL, 'V', 7, 0, 5),
(236, 50, '61', NULL, '11153', '240014T', 207, 10, 66, '', NULL, NULL, '1.00', '30.20', '150.90', '503.00', 665.47, '132.00', '0.00', '67213.37', NULL, NULL, '66396.00', NULL, 'V', 7, 0, 5),
(237, 51, '0132', NULL, '', '195', 88, 10, 37, '', NULL, NULL, '0.00', '36.20', '108.00', '360.00', 483.48, '134.00', '0.00', '48831.48', NULL, NULL, '48240.00', NULL, 'V', 7, 0, 5),
(238, 51, '0172', NULL, '', '130', 209, 15, 46, '', NULL, NULL, '0.00', '34.20', '99.90', '333.00', 467.20, '140.00', '0.00', '47187.10', NULL, NULL, '46620.00', NULL, 'V', 7, 0, 5),
(239, 51, '0206', NULL, '', '135', 76, 11, 21, '', NULL, NULL, '0.00', '39.60', '117.00', '390.00', 648.57, '166.00', '0.00', '65505.57', NULL, NULL, '64740.00', NULL, 'V', 7, 0, 5),
(240, 51, '0208', NULL, '', '136', 76, 10, 21, '', NULL, NULL, '0.00', '40.60', '180.00', '600.00', 997.80, '166.00', '0.00', '100777.80', NULL, NULL, '99600.00', NULL, 'V', 7, 0, 5),
(241, 52, '11', NULL, '25436', 'C664', 171, 10, 7, '', NULL, NULL, '0.00', '38.50', '134.74', '561.00', 1039.20, '185.00', '18.86', '104977.80', NULL, NULL, '103785.00', NULL, 'V', 7, 11, 5),
(242, 52, '16', NULL, '25437', 'C632', 171, 14, 7, '', NULL, NULL, '0.00', '38.50', '128.59', '570.00', 804.99, '141.00', '18.00', '81321.58', NULL, NULL, '80370.00', NULL, 'V', 7, 11, 5),
(243, 52, '54', NULL, '25452', 'C546', 63, 10, 7, '', NULL, NULL, '0.00', '38.22', '134.74', '561.00', 1100.91, '196.00', '18.86', '111210.51', NULL, NULL, '109956.00', NULL, 'V', 7, 11, 5);

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
  `total` decimal(10,2) DEFAULT NULL,
  `company_id` int(11) NOT NULL,
  `year_id` int(11) NOT NULL,
  `from_where` enum('AS','PS','SB') DEFAULT NULL COMMENT 'AS=Auction Sale,PS=Private Sale,SB=Seller To byuer',
  PRIMARY KEY (`id`),
  KEY `FK_vendor_id` (`vendor_id`),
  KEY `voucher_master_id` (`voucher_master_id`),
  KEY `company_id` (`company_id`,`year_id`),
  KEY `year_id` (`year_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=53 ;

--
-- Dumping data for table `purchase_invoice_master`
--

INSERT INTO `purchase_invoice_master` (`id`, `purchase_invoice_number`, `purchase_invoice_date`, `auctionareaid`, `vendor_id`, `voucher_master_id`, `sale_number`, `sale_date`, `promt_date`, `tea_value`, `brokerage`, `service_tax`, `total_cst`, `total_vat`, `chestage_allowance`, `stamp`, `total`, `company_id`, `year_id`, `from_where`) VALUES
(49, 'PIP/AUC/KOL/L/2103', '2015-07-14', 1, 13, 54, '28', '2015-07-14 00:00:00', '2015-07-28 00:00:00', '217020.00', '408.60', '0.00', 0.00, 2174.29, '0.00', '3.00', '219605.89', 1, 1, 'AS'),
(50, 'CB/K/CT/15-16/1478', '2015-07-14', 0, 45, 55, '28', '2015-07-14 00:00:00', '2015-07-28 00:00:00', '85296.00', '188.70', '0.00', 0.00, 854.85, '0.00', '2.00', '86341.55', 1, 1, 'AS'),
(51, 'ABL/KOL1850/15-16', '2015-07-14', 1, 25, 56, '28', '2015-07-14 00:00:00', '2015-07-28 00:00:00', '259200.00', '504.90', '0.00', 0.00, 2597.05, '0.00', '0.00', '262301.95', 1, 1, 'AS'),
(52, 'CB/SL/CT/15-16/2554', '2015-07-22', 2, 22, 57, '32', '2015-07-22 00:00:00', '2015-08-04 00:00:00', '294111.00', '398.07', '55.72', 0.00, 2945.10, '0.00', '0.00', '297509.89', 1, 1, 'AS');

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

INSERT INTO `roles` (`role_name`, `id`) VALUES
('user', 1),
('admin', 2);

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

INSERT INTO `service_tax` (`id`, `tax_rate`, `from_date`, `to_date`) VALUES
(7, '10.00', '2015-02-03', '2015-03-31'),
(9, '2.50', '2014-03-01', '2014-03-31'),
(10, '0.00', '1970-01-01', '1970-01-01'),
(11, '14.00', '2015-04-01', '2016-03-31');

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

INSERT INTO `state_master` (`id`, `state_name`) VALUES
(3, 'Andhra Pradesh'),
(4, 'Assam'),
(5, 'Bihar'),
(6, 'Chandigarh'),
(7, 'Chhatisgarh'),
(8, 'Delhi'),
(9, 'Gujarat'),
(10, 'Haryana'),
(11, 'Jharkhand'),
(12, 'Karnataka'),
(13, 'Kerala'),
(14, 'Madhya Pradesh'),
(15, 'Maharashtra'),
(16, 'Manipur'),
(17, 'Meghalaya'),
(18, 'Mizoram'),
(19, 'Orissa'),
(20, 'Pondicherry'),
(21, 'Punjab'),
(22, 'Tamil Nadu'),
(23, 'Tripura'),
(24, 'Uttar Pradesh'),
(25, 'Uttarakhand'),
(26, 'West Bengal'),
(27, 'Arunachal Pradesh'),
(28, 'Goa'),
(29, 'Jammu & Kashmir'),
(30, 'Himachal Pradesh'),
(31, 'Nagaland'),
(32, 'Telangana'),
(33, 'Sikkim');

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

INSERT INTO `subgroup_name` (`id`, `name`) VALUES
(1, 'Asset'),
(2, 'Liabilities'),
(3, 'Income'),
(4, 'Expenditure');

-- --------------------------------------------------------

--
-- Table structure for table `teagroup_master`
--

CREATE TABLE IF NOT EXISTS `teagroup_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_code` varchar(50) DEFAULT NULL,
  `group_description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `teagroup_master`
--

INSERT INTO `teagroup_master` (`id`, `group_code`, `group_description`) VALUES
(5, 'CTC', 'CTC'),
(6, 'ORTH', 'ORTHODOX'),
(7, 'DST', 'DUST'),
(8, 'DJ', 'DARJEELING');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `transport`
--

INSERT INTO `transport` (`id`, `code`, `name`, `address`, `Phone`, `pin`) VALUES
(2, 'NT', 'NABIN TEA SERVICE', 'KOLKATA', '700016', '743503'),
(3, '0', 'Das And Ghosh Roadways Packers And Movers', '4 No, Surya Sen Nagar, \nKolkata - 700117,\nNear Tata Gate ', '98741563', '7423363'),
(4, NULL, 'Assam-Transport', 'Hemanta Bose Sarani,\nB B D Bag, \nKolkatta-700001', '9831024741', NULL);

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

INSERT INTO `userole` (`id`, `user_id`, `role_id`) VALUES
(10, 2, 2);

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

INSERT INTO `users` (`id`, `login_id`, `password`, `First_Name`, `Last_Name`, `Address`, `Email`, `Contact_Number`, `IS_ACTIVE`) VALUES
(2, 'admin', '8a8bb7cd343aa2ad99b7d762030857a2', 'Admin', NULL, NULL, NULL, NULL, 'Y');

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

INSERT INTO `vat` (`id`, `vat_rate`, `from_date`, `to_date`) VALUES
(5, '10.00', '2014-04-01', '2015-03-31'),
(6, '5.00', '2015-04-01', '2016-03-31'),
(7, '1.00', '2015-04-01', '2016-03-31');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=52 ;

--
-- Dumping data for table `vendor`
--

INSERT INTO `vendor` (`id`, `vendor_name`, `address`, `telephone`, `account_master_id`, `tin_number`, `cst_number`, `pan_number`, `service_tax_number`, `GST_Number`, `pin_number`, `state_id`) VALUES
(5, 'J Thomas & Co. Pvt. Ltd', '11 R N Mukherjee Road\nKolkata', NULL, 30, '19200164093', '19200164287', 'AABCJ2851Q', 'AABCJ2851QST005', '', 700001, 26),
(13, 'Parcon India Private Limited', '207 A J C BOSE ROAD\nKOLKATA', NULL, 41, '19200626007', '19200626290', 'AARCP6453A', 'AARCP6453AST001', '', 700017, 26),
(14, 'ASSAM TEA BROKERS PVT. LTD', '113 PARK STREET, \n9th Floor \nKolkata', NULL, 42, '19432268021', '19432268021', 'AABCA7736M', 'AABCA7736MSD001', '', 700016, 26),
(16, 'ASSOCIATED BROKERS PVT.LTD (Siliguri)', 'UTTORAYON LUXMI TOWNSHIP. P.O.- MATIGARA\nSILIGURI', NULL, 44, '19411143070', '19411143070', 'AAECA4414D', 'AAECA4414DST001', '', 734010, 26),
(17, 'BIJOYNAGAR TEA COMPANY LIMMITED', '11,GOVERNMENT PLACE EAST, 2ND FLOOR, KOLKATA', '2248-7629', 45, '19450691037', '19450691231', '', '', '', 700069, 26),
(18, 'Softhought-Test', '50&51 Jodhpur gardens', '8648831063', 46, '100000-A', 'CS-0002', 'ADHFX3LOP', '10235', '', 700051, 26),
(19, 'Paramount Tea Marketing Pvt Ltd.', '11 Park Mansions, 57 Park Street, Kolkata', NULL, 47, '19500598022', '', '', '', '', 700016, 26),
(20, 'JThomas & Company Pvt Ltd. (Siliguri)', 'G, 318/9, City Centre, Uttorayon Matigara, Siliguri', NULL, 48, '19200164093', '', '', '', '', 734010, 26),
(21, 'PARCON INDIA PRIVATE LIMITED (Siliguri)', 'Pratap Market, Siliguri', '0353-2542910/2546249', 49, '19200626007', '', '', '', '', 734401, 26),
(22, 'Contemporary Brokers Pvt.Ltd. (Siliguri)', 'STAC Building, Mallaguri, P.O.- Pradhan Nagar', NULL, 50, '19200898092', '', '', '', '', 0, 26),
(24, 'JAY SHREE TEA & INDUSTRIES LTD.', '10, Camac street, Calcutta', NULL, 52, '19200537058', '', '', '', '', 700017, 26),
(25, 'ASSOCIATED BROKERS PVT.LTD', '17, R.N.Mukharjee Road, Kolkata', NULL, 53, '19411143070', '', '', '', '', 700001, 26),
(27, 'ISHAAN PLASTIC  PVT.LTD', '40,JAY BIBI RAOD, GROUND FLOOR,PLOT NO 61&62, GHUSURI,HOWARH.', '26555492', 58, '19281768059', '', '', 'AABCI5376BSD001', '', 711107, 26),
(28, 'N.N.PRINT & PACK PVT.LTD.', 'VILL - GOPALPUR,CHANDIGARH.P.O.- GANGANAGAR,KOLKATA', '25386641/9191', 59, '19651723052', '', 'AABCN1073E', '', '', 700132, 26),
(29, 'SURYA PACKAGERS', '135A,BIPLABI RASH BEHARI BASUROAD,\n2ND FLOOR,KOLKATA.', '9230513556/8017555777', 60, '19260439020', '', '', '', '', 700001, 26),
(30, 'MKB PRINT & PACK SOLUTIONS PVT.LTD.', '3/2 TANGRA ROAD SOUTH,KOLKATA.', '', 61, '19397695087', '', 'AAGCM3156L', '', '', 700046, 26),
(31, 'SATYAM ENTERPRISE', '135-A,BIPLABI RASH BEHARI BASU ROAD.2ND FLOOR,KOLKATA', '9836304990/9038002419', 62, '19261436083', '', '', '', '', 700001, 26),
(32, 'PRACHI INDUSTRIES', '156 RABINDRA SARANI, FIRST FLOOR,KOLKATA', '', 63, '19272056031', '', '', '', '', 700007, 26),
(33, 'OM PACKAGING', 'G-8,RABINDRA PALLY,SPACE TOWER, BLOCK -C 3RD FLOOR, KOLKATA', '', 64, '19671168933', '', '', '', '', 700059, 26),
(34, 'SONY PACKAGING INDUSTRY', '64-B, BELGACHIA ROAD,KOLKATA,', '', 65, '19300641058', '', '', '', '', 700037, 26),
(35, 'THE SIMULBARIE TEA COMPANY (PVT) LTD', 'MITTER HOUSE,(3RD FLOOR) \n71 GANESH CHANDRA AVENUE\nKOLKATA', '033-223717474', 117, '19533133083', '', '', '', '', 700013, 26),
(36, 'CARE TEA PRIVATE LIMITED (SILIGURI)', 'SUNNY TOWER BUILDING, 2ND FLOOR\nSEVOK ROAD,\nSILIGURI', '2641132/2641845', 118, '19895080047', '', '', '', '', 734001, 26),
(37, 'NORTH BENGAL TEA BROKERS (P) LTD (SILIGURI)', 'B.M.SARANI,MAHANANDA PARA\nSILIGURI', '2532257/2535664', 119, '19894704075', '', '', '', '', 734001, 26),
(38, 'Paramount Tea Marketing Pvt Ltd. (SILIGURI)', 'KIRAN MOTI BUILDING,1ST FLOOR\nMALLAGURI, SILIGURU', '09002015586', 120, '19500598022', '', '', '', '', 734403, 26),
(39, 'UNIVERSAL TEA TRADERS', '8/1, LALBAZAR STREET,\nKOLKATA', '', 121, '19470628029', '', '', '', '', 70001, 26),
(40, 'NEW CHUMTA TEA COMPANY ', '3, NETAJI SUBHAS ROAD\nKOLKATA', '', 122, '19450322049 ', '', '', '', '', 700001, 26),
(41, 'TEA CHAMPAGNE PRIVATE LIMITED', 'CITY CENTRE,UTTORAYON\nMATIGARA', '2576079/2576080', 123, '19890744050', '', '', '', '', 734010, 26),
(42, 'SUDHIR CHATERJEE & CO.PVT.LTD.', 'KIRAN DYUTI APARTMENT, 1ST FLOOR\nMALLAGURI, SILIGUR', '', 124, '19580818089', '', '', '', '', 734003, 26),
(43, 'THE NEW TERAI ASSOCIATION LIMITED', '26, BURTOLLA STREET.\nKOLKATA\n', '', 125, '19340112007 (CANCEL)', '', '', '', '', 700007, 26),
(44, 'GILLANDERS ARBUTHONT & CO.LTD.', 'C-4, GILLANDER HOUSE, 4 TH FLOOR\nNETAJI SUBHAS ROAD\nKOLKATA', '2230-2331/36', 126, '19481313064', '', '', '', '', 700001, 26),
(45, 'CONTEMPORARY BROKERS PVT.LTD', '1,OLD COURT HOUSE CORNER\nKOLKATA', '22307241/42', 127, '19200898092', '', '', '', '', 700001, 26),
(46, 'KAMALA TEA CO.LTD', '240/B ACHARYA JAGADISH CHANDRA BOSE ROAD\nKOLKATA\n', '2283-2945/2947', 128, '19410646042', '', '', '', '', 700020, 26),
(47, 'JAI JALPESH INTERNATIONAL (PVT) LTD.', 'MAYNAGURI,\nJALPAIGURI', '', 129, '19831159084', '', '', '', '', 0, 26),
(48, 'VARDHAMAN TRADERS', '23-A, HEAD POST OFFICE ROAD,CONOOR\n', '0423-2232657/09442229850', 130, '33102542261', '', '', '', '', 643101, 22),
(49, 'CHAMURCHI AGRO (INDIA) LTD', '4,D.L.KHAN ROAD,4TH FLOOR,\nKOLKATA', '2252-6728', 131, '19251762079', '', '', '', '', 700025, 26),
(50, 'KAYAN AGRO INDUSTRIES & CO. PVT. LTD.', '4A, POLLACK STREET, SWAIKA CENTER, ROOM NO- 1\nKOLKATA', '', 132, '19893391083', '', '', '', '', 700001, 26),
(51, 'COOCHBEHAR AGRO TEA ESTATE (P)LTD.', 'HINDUSTHAN BUILDING\n4, CHITTARANJAN AVENUE, 2ND FLOOR\nKOLKATA', '2212-6753/54', 133, '19541045082', '', '', '', '', 700072, 26);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=56 ;

--
-- Dumping data for table `vendor_bill_master`
--

INSERT INTO `vendor_bill_master` (`id`, `bill_id`, `bill_amount`, `due_amount`, `company_id`, `year_id`, `voucher_id`, `from_where`) VALUES
(47, 44, 120140.5000, 120140.5000, 1, 1, 49, 'PR'),
(48, 45, 133952.5000, 133952.5000, 1, 1, 50, 'PR'),
(49, 46, 50377.6900, 50377.6900, 1, 1, 51, 'PR'),
(50, 47, 86628.5000, 86628.5000, 1, 1, 52, 'PR'),
(51, 48, 66510.5000, 66510.5000, 1, 1, 53, 'PR'),
(52, 49, 219605.8900, 219605.8900, 1, 1, 54, 'PR'),
(53, 50, 86341.5500, 86341.5500, 1, 1, 55, 'PR'),
(54, 51, 262301.9500, 262301.9500, 1, 1, 56, 'PR'),
(55, 52, 297509.8900, 297509.8900, 1, 1, 57, 'PR');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=459 ;

--
-- Dumping data for table `voucher_detail`
--

INSERT INTO `voucher_detail` (`id`, `voucher_master_id`, `account_master_id`, `voucher_amount`, `is_debit`) VALUES
(396, 49, 6, 118951.0000, 'Y'),
(397, 49, 5, 1189.5000, 'Y'),
(398, 49, 46, 120140.5000, 'N'),
(399, 50, 6, 129452.0000, 'Y'),
(400, 50, 5, 4500.5000, 'Y'),
(401, 50, 46, 133952.5000, 'N'),
(402, 51, 6, 49878.9000, 'Y'),
(403, 51, 5, 498.7900, 'Y'),
(404, 51, 53, 50377.6900, 'N'),
(405, 52, 6, 83652.0000, 'Y'),
(406, 52, 5, 2976.5000, 'Y'),
(407, 52, 46, 86628.5000, 'N'),
(408, 53, 6, 65852.0000, 'Y'),
(409, 53, 5, 658.5000, 'Y'),
(410, 53, 46, 66510.5000, 'N'),
(435, 55, 6, 85486.7000, 'Y'),
(436, 55, 5, 854.8500, 'Y'),
(437, 55, 127, 86341.5500, 'N'),
(441, 56, 6, 259704.9000, 'Y'),
(442, 56, 5, 2597.0500, 'Y'),
(443, 56, 53, 262301.9500, 'N'),
(450, 54, 6, 217431.6000, 'Y'),
(451, 54, 5, 2174.2900, 'Y'),
(452, 54, 41, 219605.8900, 'N'),
(456, 57, 6, 294564.7900, 'Y'),
(457, 57, 5, 2945.1000, 'Y'),
(458, 57, 50, 297509.8900, 'N');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=58 ;

--
-- Dumping data for table `voucher_master`
--

INSERT INTO `voucher_master` (`id`, `voucher_number`, `voucher_date`, `narration`, `cheque_number`, `cheque_date`, `transaction_type`, `created_by`, `company_id`, `year_id`, `serial_number`) VALUES
(49, 'PR/00012015-2016', '2015-06-12', 'Purchase Invoice Number T-00012T-000122015-06-12', NULL, NULL, 'PR', 2, 1, 1, 1),
(50, 'PR/000502015-2016', '2015-06-26', 'Purchase Invoice Number TEST/26/06/2015/00001TEST/26/06/2015/000012015-06-26', NULL, NULL, 'PR', 2, 1, 1, 2),
(51, 'PR/000512015-2016', '2015-07-01', 'Purchase Invoice Number TESTTEST2015-07-01', NULL, NULL, 'PR', 2, 1, 1, 3),
(52, 'PR/000522015-2016', '2015-07-20', 'Purchase Invoice Number TEST/SOFT/0001/TESTTEST/SOFT/0001/TEST2015-07-20', NULL, NULL, 'PR', 2, 1, 1, 4),
(53, 'PR/000532015-2016', '2015-07-20', 'Purchase Invoice Number TEST/0001/200715TEST/0001/2007152015-07-20', NULL, NULL, 'PR', 2, 1, 1, 5),
(54, 'PR/000542015-2016', '2015-07-14', 'Purchase Invoice Number PIP/AUC/KOL/L/2103PIP/AUC/KOL/L/21032015-07-14', NULL, NULL, 'PR', 2, 1, 1, 6),
(55, 'PR/000552015-2016', '2015-07-14', 'Purchase Invoice Number CB/K/CT/15-16/1478CB/K/CT/15-16/14782015-07-14', NULL, NULL, 'PR', 2, 1, 1, 7),
(56, 'PR/000562015-2016', '2015-07-14', 'Purchase Invoice Number ABL/KOL1850/15-16ABL/KOL1850/15-162015-07-14', NULL, NULL, 'PR', 2, 1, 1, 8),
(57, 'PR/000572015-2016', '2015-07-22', 'Purchase Invoice Number CB/SL/CT/15-16/2554CB/SL/CT/15-16/25542015-07-22', NULL, NULL, 'PR', 2, 1, 1, 9);

-- --------------------------------------------------------

--
-- Table structure for table `warehouse`
--

CREATE TABLE IF NOT EXISTS `warehouse` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `code` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `area` varchar(100) DEFAULT 'null',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=68 ;

--
-- Dumping data for table `warehouse`
--

INSERT INTO `warehouse` (`id`, `code`, `name`, `area`) VALUES
(7, '001', 'OWN', 'SANTOSHPUR'),
(16, '010', 'L M - U2', ''),
(17, '011', 'SREEMA-U 4', ''),
(18, '012', 'JPN/BROOKLYN', ''),
(19, '013', 'BEHERA/11TDR', ''),
(20, '014', 'MADHU-BBTR', ''),
(21, '015', 'HML', ''),
(22, '016', 'KTS/ BROOKLYN S2', ''),
(23, '017', 'J/S - 7 TDR', ''),
(24, '018', 'JS/P9BTDR', ''),
(25, '019', 'DAVY/OSHED', ''),
(26, '020', 'UNITY/UNITY', ''),
(27, '021', 'ESEM 1 GGR', ''),
(28, '022', 'OCTAVIUS, 2TD', ''),
(29, '023', 'IBWC/NSHED', ''),
(30, '024', 'JAYSHREE/KHA', ''),
(31, '025', 'PATEL (10AMGR)', ''),
(32, '026', 'KANOI', ''),
(33, '027', 'SONAI 2ES&S', ''),
(34, '028', 'JS/RAMPUR', ''),
(35, '029', 'ITSA(1/1 TDR)', ''),
(36, '030', 'J/S (P7TDR)', ''),
(37, '031', 'BEHERA-KASHANI', ''),
(38, '032', 'ESS/P15TDR', ''),
(39, '033', 'JS/KPOOL', ''),
(40, '034', 'KAPPA(DAV)', ''),
(42, '035', 'UNITY RAMPUR', ''),
(43, '036', 'OS (TDR)', ''),
(44, '037', 'NITB (1 TDR)', ''),
(45, '038', 'KAMAL TEWARI', ''),
(46, '039', 'SREEMA-P51', 'TARATALLA'),
(47, '040', 'UNITY-4', ''),
(48, '041', 'BS4 GG KATA', ''),
(49, '042', 'JJPUL (OS)', ''),
(50, '043', 'BANSHI GG KATA', ''),
(51, '044', 'KANOI (3TDR)', ''),
(52, '045', 'TEWARI - F SHED', ''),
(53, '046', 'BEHERA (P1 TDR)', ''),
(57, '047', 'DUTTA/BBTR', ''),
(58, '048', 'UNITY-U3', ''),
(59, '049', 'BBTR UNITY', ''),
(60, '050', 'UNITY-U1', ''),
(61, '051', 'JPNAYAK', 'RAMPUR'),
(62, '052', 'JPNAYAK 1/1', ''),
(63, '053', 'BEHERA-1OTA SHED', ''),
(64, '054', 'DEV-KAPPA', ''),
(65, '055', 'INDIAN T STOR', ''),
(66, '055', 'BEHERA ( J SHED)', ''),
(67, '056', 'SILIGURI', 'SILIGURI');

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
