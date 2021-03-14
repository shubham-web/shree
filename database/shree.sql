-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 02, 2019 at 08:42 AM
-- Server version: 10.1.33-MariaDB
-- PHP Version: 7.2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shree`
--

-- --------------------------------------------------------

--
-- Table structure for table `advance`
--

CREATE TABLE `advance` (
  `id` int(11) NOT NULL,
  `employeeId` int(11) NOT NULL,
  `date` date NOT NULL,
  `takenAmt` varchar(255) NOT NULL,
  `returnedAmt` varchar(255) NOT NULL,
  `totalDue` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `advance`
--

INSERT INTO `advance` (`id`, `employeeId`, `date`, `takenAmt`, `returnedAmt`, `totalDue`) VALUES
(18, 13, '2019-01-25', '1200', '0', '1200'),
(19, 16, '2019-01-26', '2000', '0', '2000'),
(20, 10, '2019-01-28', '12000', '0', '12000'),
(21, 10, '2019-01-28', '0', '12000', '0');

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

CREATE TABLE `bills` (
  `id` int(11) NOT NULL,
  `billDate` date NOT NULL,
  `billNumber` varchar(255) NOT NULL,
  `hsnCode` varchar(255) NOT NULL,
  `companyId` int(11) NOT NULL,
  `gatepassNumber` varchar(255) DEFAULT NULL,
  `vehicleNumber` varchar(255) DEFAULT NULL,
  `billAmount` int(11) NOT NULL,
  `sgst` varchar(255) NOT NULL,
  `cgst` varchar(255) NOT NULL,
  `igst` varchar(255) NOT NULL,
  `billTotal` int(11) NOT NULL,
  `roundOff` varchar(255) NOT NULL,
  `billStatus` tinyint(1) NOT NULL DEFAULT '1',
  `remarks` text,
  `paymentStts` tinyint(4) NOT NULL DEFAULT '0',
  `paymentRecieved` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bills`
--

INSERT INTO `bills` (`id`, `billDate`, `billNumber`, `hsnCode`, `companyId`, `gatepassNumber`, `vehicleNumber`, `billAmount`, `sgst`, `cgst`, `igst`, `billTotal`, `roundOff`, `billStatus`, `remarks`, `paymentStts`, `paymentRecieved`) VALUES
(2, '2018-01-15', 'AR002', '8455', 1, 'MDF001', '', 20200, '1818', '1818', '0			', 23836, '0', 1, NULL, 2, 23836),
(3, '2018-11-27', 'AR003', '8455', 2, 'SF001', '', 11810, '1062.9', '1062.9', '0', 13935, '0.8', 1, NULL, 2, 13935),
(4, '2018-11-27', 'AR004', '8455', 4, 'JST001', 'VH001', 17400, '1566', '1566', '0', 20532, '0', 1, NULL, 2, 20532),
(5, '2018-11-15', 'AR005', '8455', 1, 'MDF100', '', 17430, '1568.7', '1568.7', '0', 20567, '0.4', 1, NULL, 2, 20567),
(6, '2018-11-28', 'AR006', '8455', 8, 'CS002', '', 19251, '0', '0', '3465.18', 22716, '0.18', 1, NULL, 2, 22716),
(7, '2017-09-28', 'AR007', '8455', 3, 'MH100', '', 24358, '2192.22', '2192.22', '0', 28742, '0.44', 1, NULL, 2, 28742),
(8, '2018-01-29', 'AR008', '8455', 9, 'PD001', 'MP09MH2019', 20720, '1864.8', '1864.8', '0', 24449, '0.6', 1, NULL, 2, 24449),
(9, '2018-11-29', 'AR009', '8455', 3, 'MH121', '', 18000, '1620', '1620', '0', 21240, '0', 1, NULL, 2, 21240),
(10, '2018-11-29', 'AR010', '8455', 8, 'CI001', '', 15901, '0', '0', '2862.18', 18763, '0.18', 1, '', 2, 18763),
(11, '2018-06-19', 'AR011', '8455', 1, 'MDF321', '', 83790, '7541.1', '7541.1', '0', 98872, '0.2', 1, NULL, 2, 98872),
(12, '2018-10-02', 'AR012', '8455', 2, 'SF009', '', 15000, '1350', '1350', '0', 17700, '0', 1, NULL, 2, 17700),
(13, '2018-09-01', 'AR013', '8455', 3, 'MH520', '', 3600, '324', '324', '0', 4248, '0', 1, NULL, 2, 4248),
(14, '2018-11-29', 'AR014', '8455', 3, 'MH998', '', 15600, '1404', '1404', '0', 18408, '0', 1, NULL, 2, 18408),
(15, '2018-11-29', 'AR015', '8455', 4, 'JST987', '', 63000, '5670', '5670', '0', 74340, '0', 1, NULL, 2, 74340),
(16, '2018-11-29', 'AR016', '8455', 5, 'HT325', '', 12000, '1080', '1080', '0', 14160, '0', 1, NULL, 2, 14160),
(17, '2018-10-29', 'AR017', '8455', 6, 'VI185', '', 6202, '558.18', '558.18', '0', 7318, '0.36', 1, NULL, 2, 7318),
(18, '2018-11-29', 'AR018', '8455', 7, 'SF369', '', 31260, '2813.4', '2813.4', '0', 36886, '0.8', 1, NULL, 2, 36886),
(19, '2018-11-29', 'AR019', '8455', 8, 'CI9812', '', 3200, '0', '0', '576', 3776, '0', 1, NULL, 2, 3776),
(20, '2018-09-29', 'AR020', '8455', 9, 'PD3210', '', 51000, '4590', '4590', '0', 60180, '0', 1, NULL, 2, 60180),
(21, '2018-10-29', 'AR021', '8455', 5, 'HT145', '', 9000, '810', '810', '0', 10620, '0', 1, NULL, 2, 10620),
(22, '2018-10-29', 'AR022', '8456', 10, 'PO3520', '', 7000, '630', '630', '0', 8260, '0', 1, '', 2, 8260),
(23, '2018-11-29', 'AR023', '8455', 10, 'PO3521', '', 16050, '1444.5', '1444.5', '0', 18939, '0', 1, NULL, 2, 18939),
(24, '2018-12-02', 'AR001', '8455', 10, 'PO2000', '', 7200, '648', '648', '0', 8496, '0', 1, NULL, 2, 8496),
(25, '2018-12-03', 'AR026', '8455', 12, 'H001', '', 4730, '425.7', '425.7', '0', 5581, '0.4', 1, NULL, 2, 5581),
(26, '2018-12-08', 'AR027', '8455', 2, '09DEC', '', 3600, '324', '324', '0', 4248, '0', 1, NULL, 2, 4248),
(27, '2018-12-09', 'AR028', '8455', 1, '09DEC', '', 13000, '1170', '1170', '0', 15340, '0', 1, NULL, 2, 15340),
(28, '2017-12-11', 'AR029', '8455', 1, 'MDF002', '', 14601, '1314.09', '1314.09', '0', 17229, '0.18', 1, NULL, 2, 17229),
(29, '2018-12-11', 'AR030', '8455', 7, 'SF3654', '', 20200, '1818', '1818', '0', 23836, '0', 1, NULL, 2, 23836),
(30, '2018-12-11', 'AR031', '8455', 13, 'NT100', '', 21281, '1915.29', '1915.29', '0', 25111, '0.58', 1, NULL, 2, 25111),
(31, '2018-12-11', 'AR032', '8455', 13, 'NT101', '', 4520, '0', '0', '813.6', 5333, '0.6', 1, NULL, 2, 5333),
(32, '2018-12-12', 'AR033', '8455', 14, 'RT001', '', 4501, '0', '0', '810.18', 5311, '0.18', 1, NULL, 2, 5311),
(33, '2018-12-12', 'AR034', '8455', 14, 'RT002', '', 2000, '0', '0', '360', 2360, '0', 1, NULL, 2, 2360),
(34, '2018-12-13', 'AR035', '8455', 13, 'NT102', '', 2397, '0', '0', '431.46', 2828, '0.46', 1, NULL, 2, 2828),
(35, '2018-12-20', 'AR036', '8455', 3, 'MK001', '', 3750, '0', '0', '675', 4425, '0', 1, '', 2, 4425),
(36, '2018-12-20', 'AR037', '8455', 1, 'MDF003', '', 15000, '1350', '1350', '0', 17700, '0', 1, '', 2, 17700),
(37, '2018-12-18', 'AR038', '8455', 9, 'PD002', '', 6400, '0', '0', '1152', 7552, '0', 1, NULL, 2, 7552),
(38, '2018-12-20', 'AR039', '8455', 14, 'RT003', '', 2765, '0', '0', '497.7', 3262, '0.7', 1, NULL, 2, 3262),
(39, '2018-12-16', 'AR040', '8456', 6, 'VI001', '', 9051, '0', '0', '1629.18', 10680, '0.18', 1, NULL, 2, 10680),
(41, '2018-12-23', 'AR041', '8455', 2, 'SF003', '', 6000, '540', '540', '0', 7080, '0', 1, NULL, 2, 7080),
(42, '2018-12-21', 'AR042', '8455', 15, 'SR001', '', 1300, '0', '0', '234', 1534, '0', 1, NULL, 2, 1534),
(45, '2018-12-21', 'AR043', '8455', 7, NULL, NULL, 1703, '0', '0', '306.54', 2009, '0.54', 1, NULL, 2, 2009),
(46, '2018-12-21', 'AR044', '8455', 8, 'CI002', '', 3897, '0', '0', '701.46', 4598, '0.46', 1, NULL, 2, 4598),
(47, '2018-12-21', 'AR045', '8455', 7, 'SF369', '', 8000, '0', '0', '1440', 9440, '0', 1, NULL, 2, 9440),
(48, '2018-12-21', 'AR046', '8455', 12, 'HS001', '', 4598, '413.82', '413.82', '0', 5425, '0.64', 1, NULL, 2, 5425),
(49, '2018-12-21', 'AR047', '8455', 3, 'MH100', '', 3600, '0', '0', '648', 4248, '0', 1, NULL, 2, 4248),
(50, '2018-12-21', 'AR048', '8455', 5, 'HT001', '', 6000, '540', '540', '0', 7080, '0', 1, NULL, 2, 7080),
(51, '2018-12-23', 'AR049', '8455', 5, 'HT001', '', 13800, '1242', '1242', '0', 16284, '0', 1, NULL, 2, 16284),
(52, '2018-12-24', 'AR050', '8455', 7, '', '', 24502, '0', '0', '4410.387', 28912, '0.54', 1, NULL, 2, 28912),
(53, '2018-12-25', 'AR051', '8455', 7, 'SF369', '', 5000, '0', '0', '900', 5900, '0', 1, '', 2, 5900),
(54, '2018-12-31', 'AR052', '8455', 5, 'HT003', '', 2460, '221.4', '221.4', '0', 2902, '0.8', 1, '', 2, 2902),
(55, '2019-01-01', 'AR053', '8455', 26, '1901', '', 5501, '0', '0', '990.18', 6491, '0.18', 1, 'Dummy Bills', 2, 6491),
(56, '2019-01-01', 'AR054', '8455', 1, 'MDF004', '', 52900, '4761', '4761', '0', 62422, '0', 1, NULL, 2, 62422),
(57, '2019-01-05', 'AR055', '8455', 15, '', '', 6000, '0', '0', '1080', 7080, '0', 0, '', 2, 7080),
(58, '2019-01-05', 'AR056', '8455', 7, '', '', 22000, '0', '0', '3960', 25960, '0', 0, '', 2, 25960),
(59, '2019-01-05', 'AR057', '8455', 25, 'SB001', '', 3000, '0', '0', '540', 3540, '0', 0, 'Test Bill', 2, 3540),
(60, '2019-01-05', 'AR058', '8455', 25, '', '', 8400, '0', '0', '1512', 9912, '0', 0, 'Test Bill', 2, 9912),
(61, '2019-01-05', 'AR059', '8455', 15, '', '', 200, '0', '0', '36', 236, '0', 0, 'Test Bill', 2, 236),
(62, '2019-01-05', 'AR060', '8455', 6, '', '', 12101, '0', '0', '2178.18', 14279, '0.18', 0, 'Test Bill', 2, 14279),
(63, '2019-01-11', 'AR061', '8455', 15, 'SR001', '', 20615, '0', '0', '3710.7', 24325, '0.7', 1, NULL, 2, 24325),
(64, '2019-01-10', 'AR062', '8455', 8, 'DEMO', '', 24660, '0', '0', '4438.8', 29098, '0.8', 1, NULL, 2, 29098),
(65, '2019-01-10', 'AR063', '8455', 8, '231', '', 4000, '0', '0', '720', 4720, '0', 1, NULL, 2, 4720),
(66, '2019-01-10', 'AR064', '8455', 8, 'CI003', '', 8250, '0', '0', '1485', 9735, '0', 1, NULL, 2, 9735),
(67, '2019-01-12', 'AR065', '8455', 27, 'FM001', '', 15501, '0', '0', '2790.18', 18291, '0.18', 1, NULL, 2, 18291),
(68, '2019-01-18', 'AR066', '8455', 27, 'FM002', '', 15201, '0', '0', '2736.18', 17937, '0.18', 1, '', 2, 17937),
(69, '2019-01-18', 'AR067', '8455', 5, 'HT002', '', 5000, '450', '450', '0', 5900, '0', 1, NULL, 2, 5900),
(70, '2019-01-24', 'AR068', '8455', 26, '2321', '', 6900, '0', '0', '1242', 8142, '0', 1, NULL, 2, 8142),
(71, '2019-01-26', 'AR069', '8455', 8, '130', '', 7801, '0', '0', '1404.18', 9205, '0.18', 1, NULL, 2, 9205),
(72, '2019-01-27', 'AR070', '8455', 26, '586', '', 11501, '0', '0', '2070.18', 13571, '0.18', 1, NULL, 2, 13571),
(73, '2018-12-10', 'AR071', '8455', 1, 'MF001', '', 103800, '9342', '9342', '0', 122484, '0', 1, NULL, 2, 122484),
(74, '2019-01-28', 'AR072', '8455', 8, 'CI004', '', 36000, '0', '0', '6480', 42480, '0', 1, NULL, 2, 42480),
(75, '2019-01-29', 'AR073', '8455', 4, 'JST002', '', 7551, '679.59', '679.59', '0', 8910, '0.18', 1, NULL, 0, 0),
(76, '2019-01-30', 'AR074', '8455', 12, 'HS003', '', 7101, '639.09', '639.09', '0', 8379, '0.18', 1, NULL, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `chalans`
--

CREATE TABLE `chalans` (
  `number` int(11) NOT NULL,
  `date` date NOT NULL,
  `companyId` int(11) NOT NULL,
  `gatepassNumber` varchar(255) NOT NULL,
  `vehicleNumber` varchar(255) NOT NULL,
  `rollsInfo` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chalans`
--

INSERT INTO `chalans` (`number`, `date`, `companyId`, `gatepassNumber`, `vehicleNumber`, `rollsInfo`) VALUES
(4, '2018-11-25', 1, 'MDF001', 'MP41MH2019', '[[\"10\",\"1200 x 1500 Roll\"],[\"1\",\"2500 x 3000 Type 1\"],[\"3\",\"5200 x 3600 Roll\"],[\"10\",\"1250 x 1302 Rolls\"]]'),
(5, '2018-11-25', 2, 'SF001', '', '[[\"1\",\"2000 x 1200 Rolls\"],[\"3\",\"1200 x 5200 Type D\"]]'),
(6, '2018-11-25', 2, 'SF001', '', '[[\"3\",\"2000 x 1200 Rolls\"],[\"3\",\"2000 x 1222 Rolls\"],[\"120\",\"Description\"]]'),
(7, '2018-11-27', 4, 'JST001', '', '[[\"2\",\"400 x 300 Rolls\"],[\"4\",\"1400 x 300 Rolls\"],[\"5\",\"400 x 1300 Rolls\"],[\"3\",\"1250 x 1302 Rolls\"]]'),
(8, '2018-11-27', 8, 'CS002', '', '[[\"2\",\"1200 x 1000 Rolls\"]]'),
(9, '2018-11-27', 8, 'CS002', '', '[[\"3\",\"1800 x 100 Rolls\"]]'),
(10, '2018-11-27', 8, 'CS002', '', '[[\"2\",\"1200 x 1000 Rolls\"]]'),
(11, '2018-11-27', 8, 'CS002', '', '[[\"1\",\"1200 x 1000 Rolls\"],[\"2\",\"Custom Desc\"]]'),
(12, '2016-01-28', 1, 'MDF100', '', '[[\"3\",\"1200 x 60 Rolls\"]]'),
(13, '2018-11-28', 1, 'MDF100', '', '[[\"3\",\"1200 x 160 Rolls\"]]'),
(14, '2018-11-28', 1, 'MDF100', '', '[[\"1\",\"1200 x 160 Rolls\"]]'),
(15, '2018-11-28', 3, 'MH100', '', '[[\"7\",\"600 x 600 Rolls\"],[\"2\",\"1600 x 1600 Rolls\"],[\"2\",\"3200 x 1200 type 5\"]]'),
(16, '2018-11-29', 9, 'PD001', 'MP09MH3209', '[[\"2\",\"400 x 200 Rolls\"],[\"1\",\"3200 x 1200 Type c\"],[\"3\",\"3520 x 1520 Rolls\"]]'),
(17, '2018-11-29', 9, 'PD001', '', '[[\"1\",\"400 x 200 Rolls\"],[\"6\",\"200 x 200 Rolls\"],[\"3\",\"400 x 200 type b\"]]'),
(18, '2018-11-29', 9, 'PD001', '', '[[\"2\",\"200 x 200 Rolls\"]]'),
(19, '2018-11-29', 3, 'MH121', '', '[[\"3\",\"360 x 180 Rolls\"],[\"1\",\"3200 x 1620 Rolls\"]]'),
(20, '2018-11-29', 8, 'CI001', '', '[[\"6\",\"3200 x 50 Rolls\"]]'),
(22, '2018-11-29', 1, 'MDF321', 'MP21DD3210', '[[\"10\",\"345 x 543 Roll\"]]'),
(23, '2018-11-13', 2, 'SF009', '', '[[\"3\",\"400 x 400 Rolls\"]]'),
(24, '2018-11-29', 3, 'MH520', '', '[[\"3\",\"100 x 1000 Rolls\"]]'),
(25, '2018-11-29', 3, 'MH998', '', '[[\"3\",\"710 x 120 Rolls\"]]'),
(26, '2018-11-29', 4, 'JST987', '', '[[\"12\",\"100 x 200 Rolls\"]]'),
(27, '2018-11-09', 5, 'HT325', '', '[[\"2\",\"120 x 320 Rolls\"]]'),
(28, '2018-11-29', 6, 'VI185', '', '[[\"2\",\"3220 x 1500 Rolls\"]]'),
(29, '2018-11-29', 7, 'SF369', '', '[[\"4\",\"660 x 1000 Rolls\"]]'),
(30, '2018-11-29', 7, 'SF369', '', '[[\"2\",\"660 x 1000 Rolls\"]]'),
(31, '2018-11-29', 8, 'CI9812', '', '[[\"1\",\"3250 x 1200 Rolls\"]]'),
(32, '2018-11-29', 9, 'PD3210', '', '[[\"3\",\"2000 x 1200 Rolls\"]]'),
(33, '2018-11-29', 9, 'PD3210', '', '[[\"3\",\"2000 x 1200 Rolls\"]]'),
(34, '2018-10-31', 5, 'HT145', '', '[[\"6\",\"4000 x 300 Rolls\"]]'),
(35, '2018-09-29', 10, 'PO3520', '', '[[\"2\",\"120 x 320 Rolls\"]]'),
(36, '2018-11-29', 10, 'PO3521', '', '[[\"5\",\"120 x 210 Rolls\"]]'),
(37, '2018-11-29', 10, 'PO2000', '', '[[\"6\",\"400 x 500 Rolls\"]]'),
(38, '2018-12-03', 12, 'H001', '', '[[\"3\",\"1000 x 2000 Rolls\"],[\"3\",\"1100 x 2000 Rolls\"],[\"1\",\"1100 x 2100 Rolls\"]]'),
(39, '2018-12-08', 1, '09DEC', '', '[[\"3\",\"100 x 200 Rolls\"]]'),
(40, '2018-12-08', 2, '09DEC', '', '[[\"1\",\"10 x 20 ROlls\"]]'),
(41, '2018-12-08', 2, '09DEC', '', '[[\"2\",\"10 x 20 ROlls\"]]'),
(42, '2018-12-09', 1, 'MDF002', '', '[[\"3\",\"100 x 200 Rolls\"],[\"3\",\"100 x 2000 Rolls\"]]'),
(43, '2018-12-11', 7, 'SF3654', '', '[[\"4\",\"3201 x 6550 Rolls\"]]'),
(44, '2018-12-11', 7, 'SF3654', '', '[[\"2\",\"3201 x 6550 Rolls\"],[\"3\",\"1100 x 655 Rolls\"]]'),
(45, '2018-12-11', 13, 'NT100', '', '[[\"6\",\"1000 x 2100 Rolls\"],[\"3\",\"2100 x 60\"],[\"1\",\"Additional 100 x 200 Roll of Type D\"]]'),
(46, '2018-12-11', 13, 'NT101', 'MP23MH2015', '[[\"1\",\"Description\"]]'),
(47, '2018-12-12', 14, 'RT001', 'MP41MH2001', '[[\"3\",\"200 x 1000 Rolls\"],[\"2\",\"Additional 100 x 200 Roll of Type D\"]]'),
(48, '2018-12-12', 14, 'RT002', '', '[[\"1\",\"100 x 2000 Rolls\"]]'),
(49, '2018-12-13', 13, 'NT102', '', '[[\"1\",\"1200 x 1200 Rolls\"]]'),
(50, '2018-12-13', 13, 'NT102', '', '[[\"2\",\"1200 x 1200 Rolls\"]]'),
(51, '2018-12-15', 3, 'MK001', '', '[[\"3\",\"2100 x 2500 Roll\"]]'),
(52, '2018-12-16', 1, 'MDF003', '', '[[\"5\",\"320 x 1000 Rolls\"]]'),
(53, '2018-12-16', 9, 'PD002', '', '[[\"2\",\"100 x 1020 Rolls\"]]'),
(54, '2018-12-16', 14, 'RT003', '', '[[\"2\",\"100 x 2050\"]]'),
(55, '2018-12-16', 14, 'RT003', '', '[[\"1\",\"100 x 2050\"]]'),
(56, '2018-12-16', 6, 'VI001', 'MP41MH2017', '[[\"2\",\"250 x 500 Rolls\"],[\"3\",\"100 x 201 Rolls\"]]'),
(57, '2018-12-16', 6, 'VI001', '', '[[\"1\",\"250 x 500 Rolls\"],[\"1\",\"100 x 201 Rolls\"]]'),
(58, '2018-12-16', 8, 'CI002', '', '[[\"3\",\"100 x 2000 Type B\"]]'),
(59, '2018-12-18', 2, 'SF003', '', '[[\"2\",\"200 x 100 Rolls\"]]'),
(60, '2018-12-18', 2, 'SF003', '', '[[\"3\",\"200 x 100 Rolls\"]]'),
(61, '2018-12-20', 15, 'SR001', '', '[[\"5\",\"100 x 1000 Rolls\"],[\"3\",\"200 x 30 Rolls\"]]'),
(62, '2018-12-21', 12, 'HS001', '', '[[\"2\",\"100 x 200 Rolls\"],[\"1\",\"500 x 100 Rolls\"]]'),
(63, '2018-12-21', 12, 'HS001', '', '[[\"2\",\"500 x 100 Rolls\"]]'),
(64, '2018-12-23', 5, 'HT001', '', '[[\"3\",\"800 x 800 Rolls\"],[\"2\",\"100 x 1800 Rolls\"],[\"3\",\"Custom description Type 2\"]]'),
(65, '2018-12-24', 25, 'SB001', '', '[[\"3\",\"Custom description Type 3\"]]'),
(66, '2018-12-24', 25, 'SB001', '', '[[\"2\",\"1200 x 204 Rolls\"]]'),
(67, '2018-12-25', 5, 'HT002', '', '[[\"1\",\"100 x 100 Rolls\"]]'),
(68, '2018-12-27', 8, 'DEMO', '', '[[\"2\",\"OLD CI FLACKER ROLL . ROLL SIZE (600 X 1300) REGRINDING WORK LABOUR WORK ONLY\"]]'),
(69, '2018-12-27', 8, '231', '', '[[\"2\",\"Somwthing\"]]'),
(70, '2018-12-30', 5, 'HT003', '', '[[\"2\",\"1500\"],[\"1\",\"Custom description Type 9\"]]'),
(71, '2019-01-01', 26, '1901', '', '[[\"1\",\"1200 x 1200 Rolls\"],[\"2\",\"2000 x 1000 Rollls\"]]'),
(72, '2019-01-01', 26, '1901', '', '[[\"2\",\"1200 x 1200 Rolls\"]]'),
(73, '2019-01-01', 1, 'MDF004', '', '[[\"1\",\"Most Costly 1000 x 1000 Rolls\"]]'),
(74, '2019-01-09', 8, 'CI003', '', '[[\"2\",\"Desc 1\"],[\"2\",\"Desc 2\"],[\"3\",\"Custom Description Roll\"]]'),
(75, '2019-01-12', 27, 'FM001', '', '[[\"2\",\"Roll Size (1000 x 200) Regrinding and grooving work\"],[\"1\",\"Roll Size (1000 x 1200) Regrinding and grooving work\"]]'),
(76, '2019-01-12', 27, 'FM001', '', '[[\"1\",\"Roll Size (1000 x 200) Regrinding and grooving work\"],[\"3\",\"Roll Size (1000 x 1200) Regrinding and grooving work\"]]'),
(77, '2019-01-16', 27, 'FM002', '', '[[\"4\",\"ROLL SIZE (1000 x 3200) REGRINDING AND GROOVING WORK\"],[\"1\",\"ROLL SIZE (1500 x 200) REGRINDING AND GROOVING WORK\"]]'),
(78, '2019-01-16', 27, 'FM002', '', '[[\"1\",\"ROLL SIZE (1000 x 3200) REGRINDING AND GROOVING WORK\"],[\"2\",\"ROLL SIZE (1500 x 200) REGRINDING AND GROOVING WORK\"],[\"2\",\"Additional Chalan\"]]'),
(79, '2019-01-22', 26, '586', '', '[[\"5\",\"ROLL SIZE (100 x 200) REGRINDING AND GROOVING WORK\"]]'),
(80, '2019-01-22', 26, '586', '', '[[\"2\",\"ROLL SIZE (350 x 350) REGRINDING AND GROOVING WORK\"]]'),
(81, '2019-01-24', 26, '2321', '', '[[\"3\",\"ROLL SIZE (900 x 30) REGRINDING AND GROOVING WORK\"]]'),
(82, '2019-01-24', 4, 'JST002', '', '[[\"3\",\"ROLL SIZE (200 x 200) REGRINDING AND GROOVING WORK\"]]'),
(83, '2019-01-24', 4, 'JST002', '', '[[\"2\",\"ROLL SIZE (200 x 200) REGRINDING AND GROOVING WORK\"]]'),
(84, '2019-01-26', 8, '130', '', '[[\"1\",\"ROLL SIZE (100 x 200) REGRINDING AND GROOVING WORK\"],[\"5\",\"ROLL SIZE (1000 x 200) REGRINDING AND GROOVING WORK\"]]'),
(85, '2019-01-28', 1, 'MF001', '', '[[\"3\",\"ROLL SIZE (350 x 2000) REGRINDING AND GROOVING WORK\"]]'),
(86, '2019-01-28', 8, 'CI004', '', '[[\"3\",\"ROLL SIZE (100 x 200) REGRINDING AND GROOVING WORK\"]]'),
(87, '2019-01-30', 12, 'HS003', '', '[[\"6\",\"ROLL SIZE (1000 x 200) REGRINDING AND GROOVING WORK\"]]'),
(88, '2019-01-31', 1, 'MDF009', '', '[[\"5\",\"ROLL SIZE (1000 x 300) REGRINDING AND GROOVING WORK\"]]');

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `gstin` text NOT NULL,
  `contactPerson1` varchar(255) NOT NULL,
  `contactNumber1` text NOT NULL,
  `contactPerson2` varchar(255) NOT NULL,
  `contactNumber2` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `name`, `address`, `gstin`, `contactPerson1`, `contactNumber1`, `contactPerson2`, `contactNumber2`) VALUES
(1, 'MS Dawat Foods', '1/B, Aerocity, Delhi', '23DDADFDFSDFDA1', 'Rakesh Sinha', '9878654532', 'Mukesh Sinha', '7889659623'),
(2, 'Sanghvi Foods', 'Dewas', '23DDDSDDSFSD1XC', 'Dinesh Sanghvi', '9842338505', 'Rajesh Sanghvi', '9846315215'),
(3, 'Mahakali', 'Ujjain MP', '22DFSFG554S5D54', 'Danish Mishra', '6263300158', 'Rohit Kumawat', '9889545520'),
(4, 'Jain Shree Transport', 'Indore', '23DSVSFDFSDSF1Z', 'Mradul Jain', '8789996596', 'Sahitya Jain', '8523269884'),
(5, 'Hathi Transport', 'Mumbai', '23AAAAAAAA123Z2', 'Kailash Hathi', '8451454444', 'Harish Hathi', '9745216688'),
(6, 'Vippy Indutries PVT LTD', 'Dewas', '21DEFFSS12SS12S', 'Gorav Goyal', '6484512158', 'Raja Jhala', '8945103942'),
(7, 'Santushti Foods', 'Indore', '22DS55D8FDDD512', 'Deepak Saxena', '6899210053', 'BhagyaShree Sendhav', '6899210053'),
(8, 'Chiku IT', 'Dubai', '22SSJKSGHJFS523', 'Shweta', '9895454895', 'Shubham', '7896652964'),
(9, 'Prodevelopers Dewas', 'India', '20WEREWEREWE1CC', 'Shubham', '8319505750', 'Advaith', '9856332100'),
(10, 'Projection Online', 'Indore', '06DFGF87S45FG1B', 'Ritesh', '6984512469', 'Hemant', '6947845154'),
(12, 'HSOFT', 'India', '23REGDGDFFDFG10', 'Shubham', '9898977877', 'Sandeep', '8777878787'),
(13, 'Netflix', 'India', '04847AAAA578154', 'Shubham', '9447525874', 'Sandeep', '5977847784'),
(14, 'Rahul Traders', 'Dewas  Madhya Pradesh', '2114SSSSSSSS494', 'Deepak Kumar', '9458451248', 'Shubham', '8455488458'),
(15, 'SAR Dewas', 'Dewas', '21RDGFGBTDRERDT', 'Anshul', '9687242478', 'Rohit', '9674539735'),
(20, 'Shubham\'s Company', 'India', '32DSDDDDDDDDD0D', 'Shubham', '9999999999', '', ''),
(25, 'S And B', 'dgdfsg', '32DSDDDDDDDDD0D', 'fake person', '0000000000', '', ''),
(26, '2k19', 'USA', '16FDFFDGSDFGSDF', 'John', '9855633211', 'Doe', ''),
(27, 'Fluido Mat', 'India', '06ASDASD5988569', 'Vikas', '9898989898', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `qualification` varchar(255) DEFAULT NULL,
  `mobileNumber` text,
  `aadhar` text,
  `joiningDate` date DEFAULT NULL,
  `salary` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `name`, `qualification`, `mobileNumber`, `aadhar`, `joiningDate`, `salary`) VALUES
(4, 'Shankaracharya', 'MBBS', '6122519920', '948614849561', '2000-06-04', 250),
(6, 'Sharad', '11th Pass', '9851145214', '484615316489', '2001-04-12', 700),
(8, 'Amish', '11th Pass', '9548784512', '845121548794', '2014-01-12', 350),
(10, 'Manas', '12th Pass', '6897465135', '598556232474', '1986-06-17', 300),
(11, 'Prem', 'BA Pass', '5985147945', '895479548458', '2011-01-23', 452),
(13, 'Amar', 'BA Qualified', '9896566523', '858654845215', '2013-10-30', 800),
(16, 'Krishna', '12th Pass', '8525962485', '259669558658', '2019-01-12', 690);

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(11) NOT NULL,
  `invoiceNumber` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `amount` int(11) NOT NULL,
  `vendorId` int(11) NOT NULL,
  `taxPercentage` int(11) NOT NULL,
  `cgst` int(11) NOT NULL,
  `sgst` int(11) NOT NULL,
  `igst` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `invoiceNumber`, `date`, `amount`, `vendorId`, `taxPercentage`, `cgst`, `sgst`, `igst`, `total`, `description`) VALUES
(1, 'P1', '2018-11-01', 1200, 1, 12, 0, 0, 144, 1344, ''),
(2, 'P2', '2018-11-03', 2100, 2, 10, 0, 0, 210, 2310, ''),
(3, 'P3', '2018-12-05', 1100, 2, 20, 0, 0, 220, 1320, ''),
(4, 'P4', '2018-12-12', 1000, 4, 10, 0, 0, 100, 1100, ''),
(5, 'P6', '2019-01-06', 1000, 6, 10, 50, 50, 0, 1100, '10'),
(6, 'P5', '2019-01-06', 1200, 2, 6, 0, 0, 72, 1272, 'Desc'),
(7, 'P7', '2019-01-09', 1000, 6, 10, 50, 50, 0, 1100, ''),
(8, 'P8', '2019-01-19', 2300, 2, 20, 0, 0, 460, 2760, ''),
(9, 'P9', '2018-01-25', 1500, 2, 10, 0, 0, 150, 1650, ''),
(10, 'P10', '2019-01-25', 5000, 3, 18, 0, 0, 900, 5900, ''),
(11, 'P11', '2019-01-25', 9000, 1, 20, 0, 0, 1800, 10800, 'Microsoft'),
(12, 'P12', '2018-10-27', 100000, 6, 18, 9000, 9000, 0, 118000, ''),
(13, 'P13', '2019-01-28', 250000, 3, 10, 0, 0, 25000, 275000, ''),
(14, 'P14', '2018-12-28', 150000, 2, 20, 0, 0, 30000, 180000, ''),
(15, 'P15', '2018-11-02', 50000, 3, 18, 0, 0, 9000, 59000, '');

-- --------------------------------------------------------

--
-- Table structure for table `gatepasses`
--

CREATE TABLE `gatepasses` (
  `id` int(11) NOT NULL,
  `companyId` int(11) NOT NULL,
  `gatepassNumber` varchar(255) NOT NULL,
  `gatepassDate` date NOT NULL,
  `rollsInfo` text NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gatepasses`
--

INSERT INTO `gatepasses` (`id`, `companyId`, `gatepassNumber`, `gatepassDate`, `rollsInfo`, `status`) VALUES
(1, 1, 'MDF001', '2018-11-25', '[{\"quantity\":\"10\",\"description\":\"1200 x 1500 Roll\"},{\"quantity\":\"1\",\"description\":\"2500 x 3000 Type 1\"},{\"quantity\":\"3\",\"description\":\"5200 x 3600 Roll\"}]', 'Delivered'),
(2, 2, 'SF001', '2018-11-25', '[{\"quantity\":\"4\",\"description\":\"2000 x 1200 Rolls\"},{\"quantity\":\"3\",\"description\":\"2000 x 1222 Rolls\"}]', 'Delivered'),
(3, 4, 'JST001', '2018-11-25', '[{\"quantity\":\"2\",\"description\":\"400 x 300 Rolls\"},{\"quantity\":\"4\",\"description\":\"1400 x 300 Rolls\"},{\"quantity\":\"5\",\"description\":\"400 x 1300 Rolls\"}]', 'Delivered'),
(4, 8, 'CS002', '2018-11-27', '[{\"quantity\":\"5\",\"description\":\"1200 x 1000 Rolls\"},{\"quantity\":\"3\",\"description\":\"1800 x 100 Rolls\"}]', 'Delivered'),
(5, 1, 'MDF100', '2017-11-28', '[{\"quantity\":\"3\",\"description\":\"1200 x 60 Rolls\"},{\"quantity\":\"4\",\"description\":\"1200 x 160 Rolls\"}]', 'Delivered'),
(6, 3, 'MH100', '2018-09-23', '[{\"quantity\":\"7\",\"description\":\"600 x 600 Rolls\"},{\"quantity\":\"2\",\"description\":\"1600 x 1600 Rolls\"}]', 'Delivered'),
(7, 9, 'PD001', '2018-11-29', '[{\"quantity\":\"3\",\"description\":\"400 x 200 Rolls\"},{\"quantity\":\"8\",\"description\":\"200 x 200 Rolls\"},{\"quantity\":\"1\",\"description\":\"3200 x 1200 Type c\"},{\"quantity\":\"3\",\"description\":\"400 x 200 type b\"}]', 'Delivered'),
(8, 3, 'MH121', '2018-11-02', '[{\"quantity\":\"3\",\"description\":\"360 x 180 Rolls\"}]', 'Delivered'),
(9, 8, 'CI001', '2018-11-29', '[{\"quantity\":\"6\",\"description\":\"3200 x 50 Rolls\"}]', 'Delivered'),
(10, 1, 'MDF321', '2018-11-29', '[{\"quantity\":\"10\",\"description\":\"345 x 543 Roll\"}]', 'Delivered'),
(11, 2, 'SF009', '2018-10-02', '[{\"quantity\":\"3\",\"description\":\"400 x 400 Rolls\"}]', 'Delivered'),
(12, 3, 'MH520', '2018-09-04', '[{\"quantity\":\"3\",\"description\":\"100 x 1000 Rolls\"}]', 'Delivered'),
(13, 3, 'MH998', '2018-11-12', '[{\"quantity\":\"3\",\"description\":\"710 x 120 Rolls\"}]', 'Delivered'),
(14, 4, 'JST987', '2018-10-17', '[{\"quantity\":\"12\",\"description\":\"100 x 200 Rolls\"}]', 'Delivered'),
(15, 5, 'HT325', '2018-09-21', '[{\"quantity\":\"2\",\"description\":\"120 x 320 Rolls\"}]', 'Delivered'),
(16, 6, 'VI185', '2018-11-29', '[{\"quantity\":\"2\",\"description\":\"3220 x 1500 Rolls\"}]', 'Delivered'),
(17, 7, 'SF369', '2018-09-01', '[{\"quantity\":\"6\",\"description\":\"660 x 1000 Rolls\"}]', 'Delivered'),
(18, 8, 'CI9812', '2018-10-29', '[{\"quantity\":\"1\",\"description\":\"3250 x 1200 Rolls\"}]', 'Delivered'),
(19, 9, 'PD3210', '2018-03-29', '[{\"quantity\":\"6\",\"description\":\"2000 x 1200 Rolls\"}]', 'Delivered'),
(20, 5, 'HT145', '2018-10-23', '[{\"quantity\":\"6\",\"description\":\"4000 x 300 Rolls\"}]', 'Delivered'),
(21, 10, 'PO3520', '2018-10-29', '[{\"quantity\":\"2\",\"description\":\"120 x 320 Rolls\"}]', 'Delivered'),
(22, 10, 'PO3521', '2018-10-29', '[{\"quantity\":\"5\",\"description\":\"120 x 210 Rolls\"}]', 'Delivered'),
(23, 10, 'PO2000', '2018-11-29', '[{\"quantity\":\"6\",\"description\":\"400 x 500 Rolls\"}]', 'Delivered'),
(24, 7, 'SF3654', '2018-12-02', '[{\"quantity\":\"6\",\"description\":\"3201 x 6550 Rolls\"},{\"quantity\":\"3\",\"description\":\"1100 x 655 Rolls\"}]', 'Delivered'),
(25, 1, 'MDF002', '2018-12-03', '[{\"quantity\":\"3\",\"description\":\"100 x 200 Rolls\"},{\"quantity\":\"3\",\"description\":\"100 x 2000 Rolls\"}]', 'Delivered'),
(26, 12, 'H001', '2018-12-03', '[{\"quantity\":\"3\",\"description\":\"1000 x 2000 Rolls\"},{\"quantity\":\"3\",\"description\":\"1100 x 2000 Rolls\"},{\"quantity\":\"1\",\"description\":\"1100 x 2100 Rolls\"}]', 'Delivered'),
(27, 1, '09DEC', '2018-12-08', '[{\"quantity\":\"3\",\"description\":\"100 x 200 Rolls\"}]', 'Delivered'),
(28, 2, '09DEC', '2018-12-08', '[{\"quantity\":\"3\",\"description\":\"10 x 20 ROlls\"}]', 'Delivered'),
(29, 13, 'NT100', '2018-12-10', '[{\"quantity\":\"6\",\"description\":\"1000 x 2100 Rolls\"},{\"quantity\":\"3\",\"description\":\"2100 x 60\"}]', 'Delivered'),
(30, 13, 'NT101', '2018-12-11', '[{\"quantity\":\"1\",\"description\":\"Description\"}]', 'Delivered'),
(31, 14, 'RT001', '2018-12-12', '[{\"quantity\":\"3\",\"description\":\"200 x 1000 Rolls\"}]', 'Delivered'),
(32, 14, 'RT002', '2018-12-12', '[{\"quantity\":\"1\",\"description\":\"100 x 2000 Rolls\"}]', 'Delivered'),
(33, 13, 'NT102', '2018-12-12', '[{\"quantity\":\"3\",\"description\":\"1200 x 1200 Rolls\"}]', 'Delivered'),
(34, 3, 'MK001', '2018-12-14', '[{\"quantity\":\"3\",\"description\":\"2100 x 2500 Roll\"}]', 'Delivered'),
(35, 1, 'MDF003', '2018-12-16', '[{\"quantity\":\"5\",\"description\":\"320 x 1000 Rolls\"}]', 'Delivered'),
(36, 9, 'PD002', '2018-12-16', '[{\"quantity\":\"2\",\"description\":\"100 x 1020 Rolls\"}]', 'Delivered'),
(37, 14, 'RT003', '2018-12-16', '[{\"quantity\":\"3\",\"description\":\"100 x 2050\"}]', 'Delivered'),
(38, 6, 'VI001', '2018-12-16', '[{\"quantity\":\"3\",\"description\":\"250 x 500 Rolls\"},{\"quantity\":\"4\",\"description\":\"100 x 201 Rolls\"}]', 'Delivered'),
(39, 8, 'CI002', '2018-12-16', '[{\"quantity\":\"3\",\"description\":\"100 x 2000 Type B\"}]', 'Delivered'),
(40, 2, 'SF003', '2018-12-18', '[{\"quantity\":\"5\",\"description\":\"200 x 100 Rolls\"}]', 'Delivered'),
(41, 15, 'SR001', '2018-12-20', '[{\"quantity\":\"5\",\"description\":\"100 x 1000 Rolls\"},{\"quantity\":\"3\",\"description\":\"200 x 30 Rolls\"}]', 'Delivered'),
(42, 12, 'HS001', '2018-12-20', '[{\"quantity\":\"2\",\"description\":\"100 x 200 Rolls\"},{\"quantity\":\"3\",\"description\":\"500 x 100 Rolls\"}]', 'Delivered'),
(43, 5, 'HT001', '2018-12-23', '[{\"quantity\":\"3\",\"description\":\"800 x 800 Rolls\"},{\"quantity\":\"2\",\"description\":\"100 x 1800 Rolls\"}]', 'Delivered'),
(44, 25, 'SB001', '2018-12-23', '[{\"quantity\":\"2\",\"description\":\"1200 x 204 Rolls\"}]', 'Delivered'),
(45, 5, 'HT002', '2018-12-24', '[{\"quantity\":\"1\",\"description\":\"100 x 100 Rolls\"}]', 'Delivered'),
(46, 5, 'HT003', '2018-12-25', '[{\"quantity\":\"2\",\"description\":\"1500\"}]', 'Delivered'),
(47, 8, 'DEMO', '2018-12-27', '[{\"quantity\":\"2\",\"description\":\"OLD CI FLACKER ROLL . ROLL SIZE (600 X 1300) REGRINDING WORK LABOUR WORK ONLY\"}]', 'Delivered'),
(48, 8, '231', '2017-10-25', '[{\"quantity\":\"2\",\"description\":\"Something\"}]', 'Delivered'),
(49, 26, '1901', '2019-01-01', '[{\"quantity\":\"3\",\"description\":\"1200 x 1200 Rolls\"},{\"quantity\":\"2\",\"description\":\"2000 x 1000 Rollls\"}]', 'Delivered'),
(50, 1, 'MDF004', '2019-01-01', '[{\"quantity\":\"1\",\"description\":\"Most Costly 1000 x 1000 Rolls\"}]', 'Delivered'),
(51, 8, 'CI003', '2019-01-09', '[{\"quantity\":\"2\",\"description\":\"Desc 1\"},{\"quantity\":\"2\",\"description\":\"Desc 2\"}]', 'Delivered'),
(52, 27, 'FM001', '2019-01-12', '[{\"quantity\":\"3\",\"description\":\"Roll Size (1000 x 200) Regrinding and grooving work\"},{\"quantity\":\"4\",\"description\":\"Roll Size (1000 x 1200) Regrinding and grooving work\"}]', 'Delivered'),
(53, 27, 'FM002', '2019-01-16', '[{\"quantity\":\"5\",\"description\":\"ROLL SIZE (1000 x 3200) REGRINDING AND GROOVING WORK\"},{\"quantity\":\"3\",\"description\":\"ROLL SIZE (1500 x 200) REGRINDING AND GROOVING WORK\"}]', 'Delivered'),
(54, 26, '586', '2019-01-20', '[{\"quantity\":\"5\",\"description\":\"ROLL SIZE (100 x 200) REGRINDING AND GROOVING WORK\"},{\"quantity\":\"2\",\"description\":\"ROLL SIZE (350 x 350) REGRINDING AND GROOVING WORK\"}]', 'Delivered'),
(55, 26, '2321', '2019-01-23', '[{\"quantity\":\"3\",\"description\":\"ROLL SIZE (900 x 30) REGRINDING AND GROOVING WORK\"}]', 'Delivered'),
(56, 4, 'JST002', '2019-01-23', '[{\"quantity\":\"5\",\"description\":\"ROLL SIZE (200 x 200) REGRINDING AND GROOVING WORK\"}]', 'Delivered'),
(57, 1, 'MF001', '2019-01-23', '[{\"quantity\":\"3\",\"description\":\"ROLL SIZE (350 x 2000) REGRINDING AND GROOVING WORK\"}]', 'Delivered'),
(58, 6, 'VI009', '2019-01-23', '[{\"quantity\":\"6\",\"description\":\"ROLL SIZE (1200 x 30) REGRINDING AND GROOVING WORK\"}]', 'Delivered'),
(59, 8, '130', '2019-01-26', '[{\"quantity\":\"1\",\"description\":\"ROLL SIZE (100 x 200) REGRINDING AND GROOVING WORK\"},{\"quantity\":\"5\",\"description\":\"ROLL SIZE (1000 x 200) REGRINDING AND GROOVING WORK\"}]', 'Delivered'),
(60, 8, 'CI004', '2019-01-28', '[{\"quantity\":\"3\",\"description\":\"ROLL SIZE (100 x 200) REGRINDING AND GROOVING WORK\"}]', 'Delivered'),
(61, 12, 'HS003', '2019-01-30', '[{\"quantity\":\"6\",\"description\":\"ROLL SIZE (1000 x 200) REGRINDING AND GROOVING WORK\"}]', 'Delivered'),
(62, 1, 'MDF009', '2019-01-31', '[{\"quantity\":\"5\",\"description\":\"ROLL SIZE (1000 x 300) REGRINDING AND GROOVING WORK\"}]', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `email`, `password`) VALUES
(1, 'shree@prodevelopers.in', 'c07fefbae558f73d32686dec591af0ac'),
(2, 'admin@prodevelopers.in', '3b6beb51e76816e632a40d440eab0097');

-- --------------------------------------------------------

--
-- Table structure for table `particulars`
--

CREATE TABLE `particulars` (
  `id` int(11) NOT NULL,
  `billNumber` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `quantity` float(7,2) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `total` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `particulars`
--

INSERT INTO `particulars` (`id`, `billNumber`, `description`, `quantity`, `price`, `total`) VALUES
(1, 'AR002', '1200 x 1500 Roll', 10.00, 1000, 10000),
(2, 'AR002', '2500 x 3000 Type 1', 1.00, 1200, 1200),
(3, 'AR002', '5200 x 3600 Roll', 3.00, 2000, 6000),
(4, 'AR002', '1250 x 1302 Rolls', 1.00, 5000, 5000),
(5, 'AR002', 'Discount', 1.00, -2000, -2000),
(6, 'AR002', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod', 0.00, 0, 0),
(7, 'AR003', '2000 x 1200 Rolls', 4.00, 1500, 6000),
(8, 'AR003', '2000 x 1222 Rolls', 3.00, 1200, 3600),
(9, 'AR003', 'Custom (Not In gate pass)', 1.00, 3210, 3210),
(10, 'AR003', 'Discount', 1.00, -1000, -1000),
(11, 'AR004', '400 x 300 Rolls', 2.00, 1200, 2400),
(12, 'AR004', '1400 x 300 Rolls', 4.00, 2000, 8000),
(13, 'AR004', '400 x 1300 Rolls', 3.00, 1000, 3000),
(14, 'AR004', 'Baring Sheet', 1.00, 5000, 5000),
(15, 'AR004', 'Discount', 1.00, -1000, -1000),
(16, 'AR004', '2 Rolls Without Work', 0.00, 0, 0),
(17, 'AR005', '1200 x 60 Rolls', 3.00, 6410, 19230),
(18, 'AR005', '1200 x 160 Rolls', 1.00, 1200, 1200),
(19, 'AR005', 'Discount', 1.00, -3000, -3000),
(20, 'AR005', '3 Rolls Without work', 0.00, 0, 0),
(21, 'AR006', '1200 x 1000 Rolls', 5.00, 2030, 10150),
(22, 'AR006', '1800 x 100 Rolls', 3.00, 2000, 6000),
(23, 'AR006', 'Additional Charge', 1.00, 3200, 3200),
(24, 'AR006', 'Discount', 1.00, -99, -99),
(25, 'AR007', '600 x 600 Rolls', 7.00, 3200, 22400),
(26, 'AR007', '1600 x 1600 Rolls', 2.00, 1000, 2000),
(27, 'AR007', 'Discount', 1.00, -42, -42),
(28, 'AR008', '400 x 200 Rolls', 3.00, 3200, 9600),
(29, 'AR008', '200 x 200 Rolls', 8.00, 1200, 9600),
(30, 'AR008', '3200 x 1200 Type c', 1.00, 3520, 3520),
(31, 'AR008', '400 x 200 type b', 1.00, 1200, 1200),
(32, 'AR008', 'Discount', 1.00, -3200, -3200),
(33, 'AR008', 'Two Rolls without work', 0.00, 0, 0),
(34, 'AR009', '360 x 180 Rolls', 3.00, 6000, 18000),
(35, 'AR010', '3200 x 50 Rolls', 5.00, 3200, 16000),
(36, 'AR010', 'Discount', 1.00, -99, -99),
(37, 'AR010', '1 Roll Without Work', 0.00, 0, 0),
(38, 'AR011', '345 x 543 Roll', 10.00, 8700, 87000),
(39, 'AR011', 'Discount', 1.00, -3210, -3210),
(40, 'AR012', '400 x 400 Rolls', 3.00, 5000, 15000),
(41, 'AR013', '100 x 1000 Rolls', 3.00, 1200, 3600),
(42, 'AR014', '710 x 120 Rolls', 3.00, 5200, 15600),
(43, 'AR015', '100 x 200 Rolls', 9.00, 7000, 63000),
(44, 'AR015', '3 Roll Without Work', 0.00, 0, 0),
(45, 'AR016', '120 x 320 Rolls', 2.00, 6000, 12000),
(46, 'AR017', '3220 x 1500 Rolls', 2.00, 3201, 6402),
(47, 'AR017', 'Discount', 1.00, -200, -200),
(48, 'AR018', '660 x 1000 Rolls', 6.00, 5210, 31260),
(49, 'AR019', '3250 x 1200 Rolls', 1.00, 3200, 3200),
(50, 'AR020', '2000 x 1200 Rolls', 6.00, 8500, 51000),
(51, 'AR021', '4000 x 300 Rolls', 6.00, 1500, 9000),
(52, 'AR022', '120 x 320 Rolls', 2.00, 3500, 7000),
(53, 'AR023', '120 x 210 Rolls', 5.00, 3210, 16050),
(54, 'AR001', '400 x 500 Rolls', 6.00, 1200, 7200),
(55, 'AR026', '1000 x 2000 Rolls', 3.00, 1200, 3600),
(56, 'AR026', '1100 x 2000 Rolls', 1.00, 1000, 1000),
(57, 'AR026', '1100 x 2100 Rolls', 1.00, 2130, 2130),
(58, 'AR026', 'Discount', 1.00, -2000, -2000),
(59, 'AR026', '2 Rolls Without Work', 0.00, 0, 0),
(60, 'AR027', '100 x 200 Rolls', 3.00, 1200, 3600),
(61, 'AR028', '100 x 200 Rolls', 2.00, 6500, 13000),
(62, 'AR028', '1 Roll Without work', 0.00, 0, 0),
(63, 'AR029', '100 x 200 Rolls', 3.00, 1250, 3750),
(64, 'AR029', '100 x 2000 Rolls', 3.00, 3650, 10950),
(65, 'AR029', 'Discount', 1.00, -99, -99),
(66, 'AR030', '3201 x 6550 Rolls', 6.00, 3200, 19200),
(67, 'AR030', '1100 x 655 Rolls', 1.00, 2000, 2000),
(68, 'AR030', 'Discount', 1.00, -1000, -1000),
(69, 'AR030', '2 Rolls without work', 0.00, 0, 0),
(70, 'AR031', '1000 x 2100 Rolls', 6.00, 3200, 19200),
(71, 'AR031', '2100 x 60', 1.00, 1200, 1200),
(72, 'AR031', 'Additional 100 x 200 Roll of Type D', 1.00, 980, 980),
(73, 'AR031', 'Discount', 1.00, -99, -99),
(74, 'AR031', 'Two Rolls without Work of 2100 x 60 ', 0.00, 0, 0),
(75, 'AR032', 'Description', 1.00, 4520, 4520),
(76, 'AR033', '200 x 1000 Rolls', 2.00, 2300, 4600),
(77, 'AR033', 'Discount', 1.00, -99, -99),
(78, 'AR033', '1 Roll Without Work', 0.00, 0, 0),
(79, 'AR034', '100 x 2000 Rolls', 1.00, 2000, 2000),
(80, 'AR035', '1200 x 1200 Rolls', 3.00, 799, 2397),
(81, 'AR036', '2100 x 2500 Roll', 3.00, 1250, 3750),
(82, 'AR037', '320 x 1000 Rolls', 5.00, 3000, 15000),
(83, 'AR038', '100 x 1020 Rolls', 2.00, 3200, 6400),
(84, 'AR039', '100 x 2050', 3.00, 1255, 3765),
(85, 'AR039', 'Discount', 1.00, -1000, -1000),
(86, 'AR040', '250 x 500 Rolls', 3.00, 2350, 7050),
(87, 'AR040', '100 x 201 Rolls', 3.00, 1000, 3000),
(88, 'AR040', 'Discount', 1.00, -999, -999),
(89, 'AR040', '1 Roll Without Work', 0.00, 0, 0),
(110, 'AR042', '100 x 1000 Rolls', 5.00, 200, 1000),
(111, 'AR042', '200 x 30 Rolls', 3.00, 100, 300),
(112, 'AR041', '200 x 100 Rolls', 5.00, 1200, 6000),
(117, 'AR043', 'desc 1 rolls', 3.00, 301, 903),
(118, 'AR043', 'desc 2', 2.00, 400, 800),
(119, 'AR044', '100 x 2000 Type B', 3.00, 1299, 3897),
(120, 'AR045', '100  x 200 Rolls', 4.00, 2000, 8000),
(121, 'AR046', '100 x 200 Rolls', 2.00, 999, 1998),
(122, 'AR046', '500 x 100 Rolls', 3.00, 1200, 3600),
(123, 'AR046', 'Discount', 1.00, -1000, -1000),
(124, 'AR047', '100 x 200 Rolls', 1.00, 1200, 1200),
(125, 'AR047', '100 x 1200 Rolls', 2.00, 1200, 2400),
(126, 'AR048', '1200 x 120 Rolls', 5.00, 1200, 6000),
(127, 'AR049', '800 x 800 Rolls', 3.00, 3600, 10800),
(128, 'AR049', '100 x 1800 Rolls', 2.00, 1500, 3000),
(129, 'AR050', 'Carbon Wonder', 11.25, 2305, 24502),
(130, 'AR051', '1200 x 300 Rolls', 2.00, 1000, 2000),
(131, 'AR051', '1200 x 200 Rolls', 2.00, 1000, 2000),
(132, 'AR051', 'Add On Description', 1.00, 1000, 1000),
(133, 'AR052', '1500', 2.00, 1230, 2460),
(134, 'AR052', 'Test Note', 0.00, 0, 0),
(135, 'AR053', '1200 x 1200 Rolls', 3.00, 1200, 3600),
(136, 'AR053', '2000 x 1000 Rollls', 2.00, 1000, 2000),
(137, 'AR053', 'Discount', 1.00, -99, -99),
(138, 'AR053', 'New Year Discount 99 Applied', 0.00, 0, 0),
(139, 'AR054', 'Most Costly 1000 x 1000 Rolls', 1.00, 53000, 53000),
(140, 'AR054', 'Discount', 1.00, -100, -100),
(141, 'AR055', '100 x 200 Rolls', 5.00, 1200, 6000),
(142, 'AR056', 'fdd', 2.00, 11000, 22000),
(143, 'AR057', '1200 x 204 Rolls', 2.00, 1500, 3000),
(144, 'AR057', 'Note', 0.00, 0, 0),
(145, 'AR058', '1200 x 200 Rolls', 3.00, 3200, 9600),
(146, 'AR058', 'Desc', 1.00, -1200, -1200),
(147, 'AR059', 'fddf', 1.00, 200, 200),
(148, 'AR059', 'Chal ja yrr', 0.00, 0, 0),
(149, 'AR060', '1200', 10.00, 1200, 12000),
(150, 'AR060', 'ADditonio ', 1.00, 200, 200),
(151, 'AR060', 'Discount', 1.00, -99, -99),
(152, 'AR060', 'Note', 0.00, 0, 0),
(156, 'AR062', 'OLD CI FLACKER ROLL . ROLL SIZE (600 X 1300) REGRINDING WORK LABOUR WORK ONLY', 2.00, 12330, 24660),
(157, 'AR063', 'Somwthing', 2.00, 2000, 4000),
(158, 'AR064', 'Desc 1', 2.00, 3500, 7000),
(159, 'AR064', 'Desc 2', 1.00, 1250, 1250),
(160, 'AR064', '1 Roll Without Work', 0.00, 0, 0),
(161, 'AR061', '100 x 1000 Rolls', 5.00, 3211, 16055),
(162, 'AR061', '200 x 30 Rolls', 3.00, 1520, 4560),
(163, 'AR061', 'Test Bill', 0.00, 0, 0),
(164, 'AR065', 'Roll Size (1000 x 200) Regrinding and grooving work', 3.00, 1200, 3600),
(165, 'AR065', 'Roll Size (1000 x 1200) Regrinding and grooving work', 4.00, 3000, 12000),
(166, 'AR065', 'Discount', 1.00, -99, -99),
(167, 'AR065', 'Test Note', 0.00, 0, 0),
(168, 'AR066', 'ROLL SIZE (1000 x 3200) REGRINDING AND GROOVING WORK', 5.00, 1200, 6000),
(169, 'AR066', 'ROLL SIZE (1500 x 200) REGRINDING AND GROOVING WORK', 3.00, 3000, 9000),
(170, 'AR066', 'Additional Chalan', 1.00, 300, 300),
(171, 'AR066', 'Discount', 1.00, -99, -99),
(172, 'AR066', 'Coupan Code LUCK7 Applied', 0.00, 0, 0),
(173, 'AR067', '100 x 100 Rolls', 1.00, 5000, 5000),
(174, 'AR068', 'ROLL SIZE (900 x 30) REGRINDING AND GROOVING WORK', 3.00, 2300, 6900),
(175, 'AR069', 'ROLL SIZE (100 x 200) REGRINDING AND GROOVING WORK', 1.00, 2000, 2000),
(176, 'AR069', 'ROLL SIZE (1000 x 200) REGRINDING AND GROOVING WORK', 5.00, 1200, 6000),
(177, 'AR069', 'Discount', 1.00, -199, -199),
(178, 'AR070', 'ROLL SIZE (100 x 200) REGRINDING AND GROOVING WORK', 5.00, 1520, 7600),
(179, 'AR070', 'ROLL SIZE (350 x 350) REGRINDING AND GROOVING WORK', 2.00, 2000, 4000),
(180, 'AR070', 'Discount', 1.00, -99, -99),
(181, 'AR071', 'ROLL SIZE (350 x 2000) REGRINDING AND GROOVING WORK', 3.00, 35000, 105000),
(182, 'AR071', 'Discount', 1.00, -1200, -1200),
(183, 'AR072', 'ROLL SIZE (100 x 200) REGRINDING AND GROOVING WORK', 3.00, 12000, 36000),
(184, 'AR073', 'ROLL SIZE (200 x 200) REGRINDING AND GROOVING WORK', 5.00, 1530, 7650),
(185, 'AR073', 'Discount', 1.00, -99, -99),
(186, 'AR073', 'Discount of Rs. 99 Applied', 0.00, 0, 0),
(187, 'AR074', 'ROLL SIZE (1000 x 200) REGRINDING AND GROOVING WORK', 6.00, 1200, 7200),
(188, 'AR074', 'Discount', 1.00, -99, -99),
(189, 'AR074', 'Discount of Rs. 99 Applied', 0.00, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `paymentDate` date NOT NULL,
  `companyId` int(11) NOT NULL,
  `modeOfPayment` varchar(255) NOT NULL,
  `paymentAmount` int(11) NOT NULL,
  `paidBills` text NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `paymentDate`, `companyId`, `modeOfPayment`, `paymentAmount`, `paidBills`, `description`) VALUES
(50, '2018-09-02', 1, 'CHEQUE', 143275, '[{\"invoice\":\"AR002\",\"amt\":23836},{\"invoice\":\"AR005\",\"amt\":20567},{\"invoice\":\"AR011\",\"amt\":98872}]', ''),
(51, '2018-10-12', 6, 'CHEQUE', 32277, '[{\"invoice\":\"AR017\",\"amt\":7318},{\"invoice\":\"AR040\",\"amt\":10680},{\"invoice\":\"AR060\",\"amt\":14279}]', ''),
(52, '2018-09-10', 1, 'CHEQUE', 32569, '[{\"invoice\":\"AR028\",\"amt\":15340},{\"invoice\":\"AR029\",\"amt\":17229}]', ''),
(53, '2018-08-18', 8, 'CHEQUE', 45255, '[{\"invoice\":\"AR006\",\"amt\":22716},{\"invoice\":\"AR010\",\"amt\":18763},{\"invoice\":\"AR019\",\"amt\":3776}]', 'Remark for 006, 010 and 019'),
(54, '2018-10-05', 1, 'CHEQUE', 80122, '[{\"invoice\":\"AR037\",\"amt\":17700},{\"invoice\":\"AR054\",\"amt\":62422}]', ''),
(55, '2018-11-11', 27, 'CHEQUE', 36228, '[{\"invoice\":\"AR065\",\"amt\":18291},{\"invoice\":\"AR066\",\"amt\":17937}]', ''),
(56, '2018-12-07', 12, 'CHEQUE', 11006, '[{\"invoice\":\"AR026\",\"amt\":5581},{\"invoice\":\"AR046\",\"amt\":5425}]', ''),
(57, '2019-01-27', 15, 'CHEQUE', 33175, '[{\"invoice\":\"AR042\",\"amt\":1534},{\"invoice\":\"AR055\",\"amt\":7080},{\"invoice\":\"AR059\",\"amt\":236},{\"invoice\":\"AR061\",\"amt\":24325}]', ''),
(58, '2019-01-07', 5, 'CHEQUE', 25086, '[{\"invoice\":\"AR049\",\"amt\":16284},{\"invoice\":\"AR052\",\"amt\":2902},{\"invoice\":\"AR067\",\"amt\":5900}]', ''),
(59, '2018-12-17', 4, 'CHEQUE', 94872, '[{\"invoice\":\"AR004\",\"amt\":20532},{\"invoice\":\"AR015\",\"amt\":74340}]', ''),
(60, '2018-11-11', 25, 'CHEQUE', 13452, '[{\"invoice\":\"AR057\",\"amt\":3540},{\"invoice\":\"AR058\",\"amt\":9912}]', ''),
(62, '2018-11-23', 3, 'CHEQUE', 72638, '[{\"invoice\":\"AR007\",\"amt\":28742},{\"invoice\":\"AR009\",\"amt\":21240},{\"invoice\":\"AR013\",\"amt\":4248},{\"invoice\":\"AR014\",\"amt\":18408}]', ''),
(63, '2018-09-12', 5, 'CHEQUE', 31860, '[{\"invoice\":\"AR016\",\"amt\":14160},{\"invoice\":\"AR021\",\"amt\":10620},{\"invoice\":\"AR048\",\"amt\":7080}]', ''),
(64, '2019-01-20', 7, 'CHEQUE', 72171, '[{\"invoice\":\"AR018\",\"amt\":36886},{\"invoice\":\"AR030\",\"amt\":23836},{\"invoice\":\"AR043\",\"amt\":2009},{\"invoice\":\"AR045\",\"amt\":9440}]', ''),
(65, '2019-01-25', 3, 'CHEQUE', 8673, '[{\"invoice\":\"AR036\",\"amt\":4425},{\"invoice\":\"AR047\",\"amt\":4248}]', ''),
(66, '2019-01-10', 13, 'CHEQUE', 33272, '[{\"invoice\":\"AR031\",\"amt\":25111},{\"invoice\":\"AR032\",\"amt\":5333},{\"invoice\":\"AR035\",\"amt\":2828}]', ''),
(67, '2019-01-01', 26, 'CHEQUE', 28204, '[{\"invoice\":\"AR053\",\"amt\":6491},{\"invoice\":\"AR068\",\"amt\":8142},{\"invoice\":\"AR070\",\"amt\":13571}]', ''),
(68, '2019-01-23', 7, 'CHEQUE', 60772, '[{\"invoice\":\"AR050\",\"amt\":28912},{\"invoice\":\"AR051\",\"amt\":5900},{\"invoice\":\"AR056\",\"amt\":25960}]', ''),
(69, '2019-01-25', 8, 'CHEQUE', 43431, '[{\"invoice\":\"AR044\",\"amt\":4598},{\"invoice\":\"AR062\",\"amt\":29098},{\"invoice\":\"AR064\",\"amt\":9735}]', ''),
(70, '2019-01-04', 8, 'CHEQUE', 13925, '[{\"invoice\":\"AR063\",\"amt\":4720},{\"invoice\":\"AR069\",\"amt\":9205}]', ''),
(71, '2018-10-20', 9, 'CHEQUE', 7552, '[{\"invoice\":\"AR038\",\"amt\":7552}]', ''),
(72, '2018-08-09', 9, 'CHEQUE', 84629, '[{\"invoice\":\"AR008\",\"amt\":24449},{\"invoice\":\"AR020\",\"amt\":60180}]', ''),
(73, '2019-01-19', 10, 'CHEQUE', 35695, '[{\"invoice\":\"AR022\",\"amt\":8260},{\"invoice\":\"AR023\",\"amt\":18939},{\"invoice\":\"AR001\",\"amt\":8496}]', ''),
(74, '2019-01-23', 2, 'CHEQUE', 42963, '[{\"invoice\":\"AR003\",\"amt\":13935},{\"invoice\":\"AR012\",\"amt\":17700},{\"invoice\":\"AR027\",\"amt\":4248},{\"invoice\":\"AR041\",\"amt\":7080}]', ''),
(75, '2019-01-03', 14, 'CHEQUE', 10933, '[{\"invoice\":\"AR033\",\"amt\":5311},{\"invoice\":\"AR034\",\"amt\":2360},{\"invoice\":\"AR039\",\"amt\":3262}]', ''),
(76, '2018-12-28', 1, 'CHEQUE', 122484, '[{\"invoice\":\"AR071\",\"amt\":122484}]', ''),
(78, '2019-01-28', 8, 'CHEQUE', 40480, '[{\"invoice\":\"AR072\",\"amt\":40480}]', '2nd Remark For AR072'),
(79, '2019-01-28', 8, 'CHEQUE', 2000, '[{\"invoice\":\"AR072\",\"amt\":2000}]', '');

-- --------------------------------------------------------

--
-- Table structure for table `salary`
--

CREATE TABLE `salary` (
  `id` int(11) NOT NULL,
  `employeeId` int(11) NOT NULL,
  `workingDays` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `salary`
--

INSERT INTO `salary` (`id`, `employeeId`, `workingDays`, `date`, `amount`) VALUES
(99, 13, '29', '2018-09-10', 23200),
(100, 8, '28', '2018-09-10', 9800),
(101, 16, '28', '2018-09-10', 19320),
(102, 10, '25.5', '2018-09-10', 7650),
(103, 11, '26', '2018-09-10', 11752),
(104, 4, '30.1', '2018-09-10', 7525),
(105, 6, '25', '2018-09-10', 17500),
(113, 13, '30', '2018-10-12', 24000),
(114, 8, '28', '2018-10-12', 9800),
(115, 16, '25.5', '2018-10-12', 17595),
(116, 10, '29', '2018-10-12', 8700),
(117, 11, '24', '2018-10-12', 10848),
(118, 4, '25', '2018-10-12', 6250),
(119, 6, '26', '2018-10-12', 18200),
(120, 13, '26', '2018-11-10', 20800),
(121, 8, '28', '2018-11-10', 9800),
(122, 16, '27', '2018-11-10', 18630),
(123, 10, '29', '2018-11-10', 8700),
(124, 11, '25', '2018-11-10', 11300),
(125, 4, '23', '2018-11-10', 5750),
(126, 6, '20.5', '2018-11-10', 14350),
(127, 13, '25', '2018-12-10', 20000),
(128, 8, '29', '2018-12-10', 10150),
(129, 16, '23', '2018-12-10', 15870),
(130, 10, '30', '2018-12-10', 9000),
(131, 11, '30', '2018-12-10', 13560),
(132, 4, '25.2', '2018-12-10', 6300),
(133, 6, '26', '2018-12-10', 18200);

-- --------------------------------------------------------

--
-- Table structure for table `trash`
--

CREATE TABLE `trash` (
  `trashId` int(11) NOT NULL,
  `tableName` varchar(255) NOT NULL,
  `rowData` text NOT NULL,
  `deletedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trash`
--

INSERT INTO `trash` (`trashId`, `tableName`, `rowData`, `deletedAt`) VALUES
(1, 'companies', '{\"id\":\"9\",\"name\":\"Pro-Developers Dewas\",\"address\":\"640 E.W.S. Vikas Nagar\",\"gstin\":\"21ggsfzbgdfvx8b\",\"contactPerson1\":\"Shubham\",\"contactNumber1\":\"8319505750\",\"contactPerson2\":\"Monika\",\"contactNumber2\":\"8585585254\"}', '2018-11-04 14:11:20'),
(2, 'companies', 'null', '2018-11-05 04:49:05'),
(3, 'companies', '{\"id\":\"9\",\"name\":\"Pro-Developers Dewas\",\"address\":\"Odisha\",\"gstin\":\"gf21aaafsdf7sfd\",\"contactPerson1\":\"Ritesh \",\"contactNumber1\":\"7451012458\",\"contactPerson2\":\"Shashank\",\"contactNumber2\":\"8754586798\"}', '2018-11-05 04:54:56'),
(4, 'companies', '{\"id\":\"10\",\"name\":\"Pro-Developers Dewas\",\"address\":\"640 E.W.S. Vikas Nagar\",\"gstin\":\"23DDDSDDSFSD1XC\",\"contactPerson1\":\"Shubham\",\"contactNumber1\":\"8319505750\",\"contactPerson2\":\"Dummy\",\"contactNumber2\":\"5885484885\"}', '2018-11-05 04:56:48'),
(5, 'companies', '{\"id\":\"8\",\"name\":\"Chiku IT\",\"address\":\"Delhi\",\"gstin\":\"22DFghhhh4S5D54\",\"contactPerson1\":\"Shweta\",\"contactNumber1\":\"7458952208\",\"contactPerson2\":\"Shubham\",\"contactNumber2\":\"9851541430\"}', '2018-11-06 05:39:47'),
(6, 'companies', '{\"id\":\"8\",\"name\":\"Chiku IT Dubai\",\"address\":\"10 DD Dubai\",\"gstin\":\"22sdfsbbs587451\",\"contactPerson1\":\"Shubham\",\"contactNumber1\":\"8451201548\",\"contactPerson2\":\"Shweta\",\"contactNumber2\":\"0215487452\"}', '2018-11-10 10:31:07'),
(7, 'vendors', '{\"id\":\"3\",\"name\":\"vendor 3 \",\"address\":\"Address Updated\",\"description\":\"vvfsd8bsdf\",\"gstin\":\"584525512bfgbfg\"}', '2018-11-11 06:44:24'),
(8, 'vendors', '{\"id\":\"2\",\"name\":\"532.0.326568\",\"address\":\"845154874511548\",\"description\":\"fsfs\n\",\"gstin\":\"588451205845121\"}', '2018-11-11 06:45:35'),
(9, 'vendors', '{\"id\":\"1\",\"name\":\"Vendor 1 \",\"address\":\"42 AB Road Dewas\",\"description\":\"Description\",\"gstin\":\"21SDDADS55525S5\"}', '2018-11-11 06:51:19'),
(10, 'vendors', '{\"id\":\"4\",\"name\":\"Vendor 1\",\"address\":\"Vendor1 Address\",\"description\":\"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.\",\"gstin\":\"21dfsfgsfdgsfd5\"}', '2018-11-11 07:14:52'),
(11, 'vendors', '{\"id\":\"1\",\"name\":\"Vendor 1\",\"address\":\"Address v1\",\"description\":\"Null\",\"gstin\":\"21fsfdgsfgsdfgs\"}', '2018-11-11 09:23:22'),
(12, 'vendors', '{\"id\":\"1\",\"name\":\"Vendor 1 \",\"address\":\"ddd\",\"description\":\"\",\"gstin\":\"588888888888888\"}', '2018-11-12 10:45:02'),
(13, 'companies', '{\"id\":\"10\",\"name\":\"Projection\",\"address\":\"Dewas\",\"gstin\":\"23ARRR111111111\",\"contactPerson1\":\"Shubham\",\"contactNumber1\":\"9888888888\",\"contactPerson2\":\"Shweta\",\"contactNumber2\":\"8888888888\"}', '2018-11-22 12:11:09'),
(14, 'companies', '{\"id\":\"11\",\"name\":\"TCS\",\"address\":\"Address\",\"gstin\":\"23GSDG8SD48FG87\",\"contactPerson1\":\"Someone\",\"contactNumber1\":\"8751497949\",\"contactPerson2\":\"Someone 2\",\"contactNumber2\":\"8456465346\"}', '2018-12-03 09:07:26'),
(15, 'companies', '{\"id\":\"18\",\"name\":\"&lt;h1&gt;hack\",\"address\":\"India\",\"gstin\":\"23DFSDF89468654\",\"contactPerson1\":\"dfsfdgsdfgs89dfgsdfgdsf\",\"contactNumber1\":\"7988888888\",\"contactPerson2\":\"sdgsdv\",\"contactNumber2\":\"7847847884\"}', '2018-12-22 19:26:31'),
(16, 'companies', '{\"id\":\"17\",\"name\":\"<h1>hack</h1>\",\"address\":\"6666\",\"gstin\":\"235485121544514\",\"contactPerson1\":\"4548\",\"contactNumber1\":\"4496956666\",\"contactPerson2\":\"66\",\"contactNumber2\":\"666666666\"}', '2018-12-22 19:26:36'),
(17, 'companies', '{\"id\":\"19\",\"name\":\"S\",\"address\":\"4879846532\",\"gstin\":\"054879864548798\",\"contactPerson1\":\"517dvsdvsdfvs79df787\",\"contactNumber1\":\"7984687984\",\"contactPerson2\":\"57/98465\",\"contactNumber2\":\"8798465131\"}', '2018-12-22 19:29:33'),
(18, 'companies', '{\"id\":\"26\",\"name\":\"Rajesh\",\"address\":\"Noida\",\"gstin\":\"23DFGF888888888\",\"contactPerson1\":\"12\",\"contactNumber1\":\"4888888888\",\"contactPerson2\":\"\",\"contactNumber2\":\"\"}', '2018-12-23 12:03:20'),
(19, 'companies', '{\"id\":\"5\",\"name\":\"Hathi Transport\",\"address\":\"Mumbai\",\"gstin\":\"23AAAAAAAA123Z2\",\"contactPerson1\":\"Kailash Hathi\",\"contactNumber1\":\"8451454444\",\"contactPerson2\":\"Harish Hathi\",\"contactNumber2\":\"9745216688\"}', '2018-12-27 09:16:37'),
(20, 'employees', '{\"id\":\"5\",\"name\":\"Known\",\"qualification\":\"PHD\",\"mobileNumber\":\"9841445121\",\"aadhar\":\"941303258561\",\"joiningDate\":\"2018-12-29\",\"salary\":\"1000\"}', '2018-12-27 09:20:12'),
(21, 'employees', '{\"id\":\"1\",\"name\":\"Ratan Tata\",\"qualification\":\"PHD\",\"mobileNumber\":\"9876543210\",\"aadhar\":\"684582655886\",\"joiningDate\":\"2018-12-20\",\"salary\":\"750\"}', '2018-12-27 09:21:53'),
(22, 'employees', '{\"id\":\"6\",\"name\":\"Bhuwan Updated\",\"qualification\":\"BA\",\"mobileNumber\":\"9876556544\",\"aadhar\":\"989898887887\",\"joiningDate\":\"2018-12-27\",\"salary\":\"800\"}', '2018-12-27 10:05:10'),
(23, 'employees', '{\"id\":\"3\",\"name\":\"Dinesh Sanghvi\",\"qualification\":\"BCA\",\"mobileNumber\":\"8548451485\",\"aadhar\":\"484654898465\",\"joiningDate\":\"2018-08-04\",\"salary\":\"50000\"}', '2018-12-28 19:00:46'),
(24, 'companies', '{\"id\":\"16\",\"name\":\"Fake Company\",\"address\":\"Russia\",\"gstin\":\"0488SGSDGSD2020\",\"contactPerson1\":\"fake person\",\"contactNumber1\":\"9784512497\",\"contactPerson2\":\"\",\"contactNumber2\":\"\"}', '2019-01-01 03:45:19'),
(25, 'employees', '{\"id\":\"6\",\"name\":\"Sandeep\",\"qualification\":\"BE (CS)\",\"mobileNumber\":\"7247255846\",\"aadhar\":\"523288701233\",\"joiningDate\":\"2019-06-04\",\"salary\":\"100\"}', '2019-01-04 07:56:50'),
(26, 'vouchers', '{\"id\":\"2\",\"date\":\"2019-01-05\",\"amount\":\"200\",\"paidTo\":\"[object HTMLInputElement]\",\"description\":\"[object HTMLTextAreaElement]\"}', '2019-01-05 10:14:06'),
(27, 'vouchers', '{\"id\":\"4\",\"date\":\"2019-01-05\",\"amount\":\"100\",\"paidTo\":\"\",\"description\":\"\"}', '2019-01-05 10:21:18'),
(28, 'vouchers', '{\"id\":\"5\",\"date\":\"2019-01-05\",\"amount\":\"2300\",\"paidTo\":\"\",\"description\":\"\"}', '2019-01-05 10:21:20'),
(29, 'vouchers', '{\"id\":\"3\",\"date\":\"2019-01-05\",\"amount\":\"24500\",\"paidTo\":\"Manav\",\"description\":\"Dell Laptop\"}', '2019-01-05 10:22:39'),
(30, 'vouchers', '{\"id\":\"1\",\"date\":\"2019-01-23\",\"amount\":\"1000\",\"paidTo\":\"Vandana Stationery\",\"description\":\"Office Stationery\"}', '2019-01-05 10:22:42'),
(31, 'vouchers', '{\"id\":\"4\",\"date\":\"2019-01-05\",\"amount\":\"1200\",\"paidTo\":\"Shubham\",\"description\":\"\"}', '2019-01-05 12:18:40'),
(32, 'vouchers', '{\"id\":\"1\",\"date\":\"2019-01-11\",\"amount\":\"1201\",\"paidTo\":\"Big Box\",\"description\":\"desc updated\"}', '2019-01-05 13:52:36'),
(33, 'vouchers', '{\"id\":\"2\",\"date\":\"2019-01-05\",\"amount\":\"3200\",\"paidTo\":\"Shubham\",\"description\":\"Description\"}', '2019-01-05 13:52:42'),
(34, 'vouchers', '{\"id\":\"3\",\"date\":\"2019-01-05\",\"amount\":\"500\",\"paidTo\":\"Mayank\",\"description\":\"Desc Demo\"}', '2019-01-05 13:52:50'),
(35, 'employees', '{\"id\":\"6\",\"name\":\"New\",\"qualification\":\"Employee\",\"mobileNumber\":\"\",\"aadhar\":\"656556565556\",\"joiningDate\":\"2019-01-08\",\"salary\":\"140\"}', '2019-01-08 09:14:22'),
(36, 'employees', '{\"id\":\"6\",\"name\":\"Mark\",\"qualification\":\"Drop out\",\"mobileNumber\":\"9876543210\",\"aadhar\":\"964458848548\",\"joiningDate\":\"0000-00-00\",\"salary\":\"1230\"}', '2019-01-12 04:10:34'),
(37, 'employees', '{\"id\":\"8\",\"name\":\"David\",\"qualification\":\"PHD\",\"mobileNumber\":\"6553312995\",\"aadhar\":\"894489894984\",\"joiningDate\":null,\"salary\":\"200\"}', '2019-01-12 04:14:18'),
(38, 'employees', '{\"id\":\"5\",\"name\":\"Elon Musk\",\"qualification\":\"12th Pass\",\"mobileNumber\":\"6977555000\",\"aadhar\":\"984512154878\",\"joiningDate\":null,\"salary\":\"1200\"}', '2019-01-12 04:14:21'),
(39, 'employees', '{\"id\":\"7\",\"name\":\"Mark\",\"qualification\":\"Drop out\",\"mobileNumber\":\"9487864535\",\"aadhar\":\"566428666655\",\"joiningDate\":null,\"salary\":\"3000\"}', '2019-01-12 04:14:25'),
(40, 'employees', '{\"id\":\"3\",\"name\":\"SHubham\",\"qualification\":\"12th Pass\",\"mobileNumber\":\"\",\"aadhar\":\"\",\"joiningDate\":\"0000-00-00\",\"salary\":\"0\"}', '2019-01-12 04:38:03'),
(41, 'employees', '{\"id\":\"1\",\"name\":\"Mark\",\"qualification\":\"Drop out\",\"mobileNumber\":\"9856222321\",\"aadhar\":\"596864636227\",\"joiningDate\":\"0000-00-00\",\"salary\":\"120\"}', '2019-01-12 04:38:06'),
(42, 'employees', '{\"id\":\"2\",\"name\":\"Elon\",\"qualification\":\"\",\"mobileNumber\":\"\",\"aadhar\":\"\",\"joiningDate\":\"0000-00-00\",\"salary\":\"0\"}', '2019-01-12 04:38:09'),
(43, 'employees', '{\"id\":\"14\",\"name\":\"Abhinav\",\"qualification\":\"8th Pass\",\"mobileNumber\":\"8485598969\",\"aadhar\":\"487448745481\",\"joiningDate\":\"2018-01-06\",\"salary\":\"900\"}', '2019-01-13 06:31:35'),
(44, 'employees', '{\"id\":\"7\",\"name\":\"Sumit\",\"qualification\":\"8th Pass\",\"mobileNumber\":\"8746534687\",\"aadhar\":\"468795978645\",\"joiningDate\":\"2019-01-12\",\"salary\":\"980\"}', '2019-01-13 06:31:42'),
(45, 'employees', '{\"id\":\"12\",\"name\":\"Shanti Shrivastav\",\"qualification\":\"BA Qualified\",\"mobileNumber\":\"9877785564\",\"aadhar\":\"356698552266\",\"joiningDate\":\"2002-02-23\",\"salary\":\"350\"}', '2019-01-13 06:31:50'),
(46, 'employees', '{\"id\":\"5\",\"name\":\"Gagan\",\"qualification\":\"BCA\",\"mobileNumber\":\"5948451548\",\"aadhar\":\"487878787878\",\"joiningDate\":\"2013-01-15\",\"salary\":\"350\"}', '2019-01-13 06:31:54'),
(47, 'employees', '{\"id\":\"17\",\"name\":\"Anuraag\",\"qualification\":\"9th\",\"mobileNumber\":\"9845159546\",\"aadhar\":\"369585623326\",\"joiningDate\":\"2018-12-05\",\"salary\":\"600\"}', '2019-01-13 06:31:57'),
(48, 'employees', '{\"id\":\"15\",\"name\":\"Jatayu\",\"qualification\":\"12th Pass\",\"mobileNumber\":\"8529637419\",\"aadhar\":\"596845826885\",\"joiningDate\":\"2019-01-12\",\"salary\":\"970\"}', '2019-01-13 06:31:59'),
(49, 'employees', '{\"id\":\"9\",\"name\":\"Keshav\",\"qualification\":\"12th Pass\",\"mobileNumber\":\"8845148784\",\"aadhar\":\"596866666666\",\"joiningDate\":\"2001-09-12\",\"salary\":\"500\"}', '2019-01-13 06:32:00'),
(50, 'vouchers', '{\"id\":\"7\",\"date\":\"2019-01-13\",\"amount\":\"1200\",\"paidTo\":\"\",\"description\":\"\"}', '2019-01-13 10:57:12'),
(51, 'payments', '{\"id\":\"48\",\"paymentDate\":\"2019-01-20\",\"companyId\":\"27\",\"modeOfPayment\":\"CHEQUE\",\"paymentAmount\":\"17937\",\"paidBills\":\"[{\"invoice\":\"AR066\",\"amt\":17937}]\",\"description\":\"\"}', '2019-01-20 10:38:25'),
(52, 'payments', '{\"id\":\"46\",\"paymentDate\":\"2019-01-20\",\"companyId\":\"1\",\"modeOfPayment\":\"CHEQUE\",\"paymentAmount\":\"15340\",\"paidBills\":\"[{\"invoice\":\"AR028\",\"amt\":15340}]\",\"description\":\"\"}', '2019-01-20 15:16:38'),
(53, 'payments', '{\"id\":\"49\",\"paymentDate\":\"2019-01-20\",\"companyId\":\"27\",\"modeOfPayment\":\"CHEQUE\",\"paymentAmount\":\"17937\",\"paidBills\":\"[{\"invoice\":\"AR066\",\"amt\":17937}]\",\"description\":\"\"}', '2019-01-20 15:16:42'),
(54, 'payments', '{\"id\":\"50\",\"paymentDate\":\"2019-01-20\",\"companyId\":\"5\",\"modeOfPayment\":\"CHEQUE\",\"paymentAmount\":\"10080\",\"paidBills\":\"[{\"invoice\":\"AR048\",\"amt\":80},{\"invoice\":\"AR049\",\"amt\":10000}]\",\"description\":\"\"}', '2019-01-20 15:16:45'),
(55, 'payments', '{\"id\":\"51\",\"paymentDate\":\"2019-01-20\",\"companyId\":\"5\",\"modeOfPayment\":\"CHEQUE\",\"paymentAmount\":\"6000\",\"paidBills\":\"[{\"invoice\":\"AR049\",\"amt\":6000}]\",\"description\":\"\"}', '2019-01-20 15:16:48'),
(56, 'payments', '{\"id\":\"52\",\"paymentDate\":\"2019-01-20\",\"companyId\":\"3\",\"modeOfPayment\":\"CHEQUE\",\"paymentAmount\":\"3742\",\"paidBills\":\"[{\"invoice\":\"AR007\",\"amt\":3742}]\",\"description\":\"\"}', '2019-01-20 15:17:49'),
(57, 'payments', '{\"id\":\"43\",\"paymentDate\":\"2019-01-21\",\"companyId\":\"27\",\"modeOfPayment\":\"CHEQUE\",\"paymentAmount\":\"17937\",\"paidBills\":\"[{\"invoice\":\"AR066\",\"amt\":17937}]\",\"description\":\"\"}', '2019-01-21 10:29:15'),
(58, 'payments', '{\"id\":\"43\",\"paymentDate\":\"2019-01-21\",\"companyId\":\"27\",\"modeOfPayment\":\"CHEQUE\",\"paymentAmount\":\"17937\",\"paidBills\":\"[{\"invoice\":\"AR066\",\"amt\":17937}]\",\"description\":\"\"}', '2019-01-21 17:29:33'),
(59, 'payments', '{\"id\":\"43\",\"paymentDate\":\"2019-01-23\",\"companyId\":\"27\",\"modeOfPayment\":\"CHEQUE\",\"paymentAmount\":\"17937\",\"paidBills\":\"[{\"invoice\":\"AR066\",\"amt\":17937}]\",\"description\":\"\"}', '2019-01-24 08:18:01'),
(60, 'payments', '{\"id\":\"45\",\"paymentDate\":\"2019-01-23\",\"companyId\":\"5\",\"modeOfPayment\":\"CHEQUE\",\"paymentAmount\":\"5000\",\"paidBills\":\"[{\"invoice\":\"AR049\",\"amt\":4000},{\"invoice\":\"AR067\",\"amt\":1000}]\",\"description\":\"\"}', '2019-01-24 08:28:11'),
(61, 'advance', '{\"id\":\"17\",\"employeeId\":\"8\",\"date\":\"2019-01-25\",\"takenAmt\":\"2500\",\"returnedAmt\":\"0\",\"totalDue\":\"2500\"}', '2019-01-25 16:25:34'),
(62, 'advance', '{\"id\":\"14\",\"employeeId\":\"13\",\"date\":\"2019-01-25\",\"takenAmt\":\"0\",\"returnedAmt\":\"500\",\"totalDue\":\"0\"}', '2019-01-25 16:26:05'),
(63, 'advance', '{\"id\":\"12\",\"employeeId\":\"13\",\"date\":\"2019-01-25\",\"takenAmt\":\"0\",\"returnedAmt\":\"1500\",\"totalDue\":\"500\"}', '2019-01-25 16:26:07'),
(64, 'advance', '{\"id\":\"10\",\"employeeId\":\"13\",\"date\":\"2019-01-25\",\"takenAmt\":\"2000\",\"returnedAmt\":\"0\",\"totalDue\":\"2000\"}', '2019-01-25 16:26:09'),
(65, 'payments', '{\"id\":\"46\",\"paymentDate\":\"2019-01-23\",\"companyId\":\"5\",\"modeOfPayment\":\"CHEQUE\",\"paymentAmount\":\"2900\",\"paidBills\":\"[{\"invoice\":\"AR052\",\"amt\":2000},{\"invoice\":\"AR067\",\"amt\":900}]\",\"description\":\"\"}', '2019-01-27 14:04:01'),
(66, 'payments', '{\"id\":\"47\",\"paymentDate\":\"2019-01-23\",\"companyId\":\"5\",\"modeOfPayment\":\"CHEQUE\",\"paymentAmount\":\"4000\",\"paidBills\":\"[{\"invoice\":\"AR067\",\"amt\":4000}]\",\"description\":\"\"}', '2019-01-27 14:04:03'),
(67, 'payments', '{\"id\":\"48\",\"paymentDate\":\"2019-01-23\",\"companyId\":\"3\",\"modeOfPayment\":\"CHEQUE\",\"paymentAmount\":\"10000\",\"paidBills\":\"[{\"invoice\":\"AR009\",\"amt\":10000}]\",\"description\":\"\"}', '2019-01-27 14:04:06'),
(68, 'payments', '{\"id\":\"44\",\"paymentDate\":\"2019-01-20\",\"companyId\":\"5\",\"modeOfPayment\":\"CHEQUE\",\"paymentAmount\":\"12080\",\"paidBills\":\"[{\"invoice\":\"AR048\",\"amt\":80},{\"invoice\":\"AR049\",\"amt\":12000}]\",\"description\":\"\"}', '2019-01-27 14:04:09'),
(69, 'payments', '{\"id\":\"40\",\"paymentDate\":\"2019-01-13\",\"companyId\":\"3\",\"modeOfPayment\":\"CHEQUE\",\"paymentAmount\":\"26408\",\"paidBills\":\"[{\"invoice\":\"AR014\",\"amt\":18408},{\"invoice\":\"AR036\",\"amt\":4000},{\"invoice\":\"AR047\",\"amt\":4000}]\",\"description\":\"\"}', '2019-01-27 14:04:12'),
(70, 'payments', '{\"id\":\"41\",\"paymentDate\":\"2019-01-13\",\"companyId\":\"8\",\"modeOfPayment\":\"CHEQUE\",\"paymentAmount\":\"43553\",\"paidBills\":\"[{\"invoice\":\"AR062\",\"amt\":29098},{\"invoice\":\"AR063\",\"amt\":4720},{\"invoice\":\"AR064\",\"amt\":9735}]\",\"description\":\"\"}', '2019-01-27 14:04:14'),
(71, 'payments', '{\"id\":\"42\",\"paymentDate\":\"2019-01-13\",\"companyId\":\"5\",\"modeOfPayment\":\"CHEQUE\",\"paymentAmount\":\"1186\",\"paidBills\":\"[{\"invoice\":\"AR049\",\"amt\":284},{\"invoice\":\"AR052\",\"amt\":902}]\",\"description\":\"\"}', '2019-01-27 14:04:18'),
(72, 'payments', '{\"id\":\"39\",\"paymentDate\":\"2019-01-12\",\"companyId\":\"27\",\"modeOfPayment\":\"CHEQUE\",\"paymentAmount\":\"18291\",\"paidBills\":\"[{\"invoice\":\"AR065\",\"amt\":18291}]\",\"description\":\"\"}', '2019-01-27 14:04:21'),
(73, 'payments', '{\"id\":\"38\",\"paymentDate\":\"2019-01-11\",\"companyId\":\"12\",\"modeOfPayment\":\"CHEQUE\",\"paymentAmount\":\"11006\",\"paidBills\":\"[{\"invoice\":\"AR026\",\"amt\":5581},{\"invoice\":\"AR046\",\"amt\":5425}]\",\"description\":\"\"}', '2019-01-27 14:04:23'),
(74, 'payments', '{\"id\":\"34\",\"paymentDate\":\"2019-01-09\",\"companyId\":\"5\",\"modeOfPayment\":\"CHEQUE\",\"paymentAmount\":\"7000\",\"paidBills\":\"[{\"invoice\":\"AR048\",\"amt\":7000}]\",\"description\":\"\"}', '2019-01-27 14:04:26'),
(75, 'payments', '{\"id\":\"35\",\"paymentDate\":\"2019-01-09\",\"companyId\":\"13\",\"modeOfPayment\":\"CHEQUE\",\"paymentAmount\":\"33272\",\"paidBills\":\"[{\"invoice\":\"AR031\",\"amt\":25111},{\"invoice\":\"AR032\",\"amt\":5333},{\"invoice\":\"AR035\",\"amt\":2828}]\",\"description\":\"\"}', '2019-01-27 14:04:28'),
(76, 'payments', '{\"id\":\"36\",\"paymentDate\":\"2019-01-09\",\"companyId\":\"2\",\"modeOfPayment\":\"CHEQUE\",\"paymentAmount\":\"42963\",\"paidBills\":\"[{\"invoice\":\"AR003\",\"amt\":13935},{\"invoice\":\"AR012\",\"amt\":17700},{\"invoice\":\"AR027\",\"amt\":4248},{\"invoice\":\"AR041\",\"amt\":7080}]\",\"description\":\"\"}', '2019-01-27 14:04:31'),
(77, 'payments', '{\"id\":\"37\",\"paymentDate\":\"2019-01-09\",\"companyId\":\"9\",\"modeOfPayment\":\"CHEQUE\",\"paymentAmount\":\"92181\",\"paidBills\":\"[{\"invoice\":\"AR008\",\"amt\":24449},{\"invoice\":\"AR020\",\"amt\":60180},{\"invoice\":\"AR038\",\"amt\":7552}]\",\"description\":\"\"}', '2019-01-27 14:04:33'),
(78, 'payments', '{\"id\":\"33\",\"paymentDate\":\"2019-01-05\",\"companyId\":\"3\",\"modeOfPayment\":\"CHEQUE\",\"paymentAmount\":\"25000\",\"paidBills\":\"[{\"invoice\":\"AR007\",\"amt\":25000}]\",\"description\":\"\"}', '2019-01-27 14:04:35'),
(79, 'payments', '{\"id\":\"32\",\"paymentDate\":\"2019-01-03\",\"companyId\":\"5\",\"modeOfPayment\":\"CHEQUE\",\"paymentAmount\":\"10620\",\"paidBills\":\"[{\"invoice\":\"AR021\",\"amt\":10620}]\",\"description\":\"\"}', '2019-01-27 14:04:36'),
(80, 'payments', '{\"id\":\"23\",\"paymentDate\":\"2019-01-02\",\"companyId\":\"26\",\"modeOfPayment\":\"CHEQUE\",\"paymentAmount\":\"6491\",\"paidBills\":\"[{\"invoice\":\"AR053\",\"amt\":6491}]\",\"description\":\"\"}', '2019-01-27 14:04:37'),
(81, 'payments', '{\"id\":\"24\",\"paymentDate\":\"2019-01-02\",\"companyId\":\"5\",\"modeOfPayment\":\"CHEQUE\",\"paymentAmount\":\"14160\",\"paidBills\":\"[{\"invoice\":\"AR016\",\"amt\":14160}]\",\"description\":\"\"}', '2019-01-27 14:04:38'),
(82, 'payments', '{\"id\":\"25\",\"paymentDate\":\"2019-01-02\",\"companyId\":\"4\",\"modeOfPayment\":\"CHEQUE\",\"paymentAmount\":\"94872\",\"paidBills\":\"[{\"invoice\":\"AR004\",\"amt\":20532},{\"invoice\":\"AR015\",\"amt\":74340}]\",\"description\":\"\"}', '2019-01-27 14:04:39'),
(83, 'payments', '{\"id\":\"26\",\"paymentDate\":\"2019-01-02\",\"companyId\":\"8\",\"modeOfPayment\":\"CHEQUE\",\"paymentAmount\":\"41479\",\"paidBills\":\"[{\"invoice\":\"AR006\",\"amt\":22716},{\"invoice\":\"AR010\",\"amt\":18763}]\",\"description\":\"\"}', '2019-01-27 14:04:40'),
(84, 'payments', '{\"id\":\"27\",\"paymentDate\":\"2019-01-02\",\"companyId\":\"8\",\"modeOfPayment\":\"CHEQUE\",\"paymentAmount\":\"8374\",\"paidBills\":\"[{\"invoice\":\"AR019\",\"amt\":3776},{\"invoice\":\"AR044\",\"amt\":4598}]\",\"description\":\"\"}', '2019-01-27 14:04:41'),
(85, 'payments', '{\"id\":\"28\",\"paymentDate\":\"2019-01-02\",\"companyId\":\"1\",\"modeOfPayment\":\"CHEQUE\",\"paymentAmount\":\"143275\",\"paidBills\":\"[{\"invoice\":\"AR002\",\"amt\":23836},{\"invoice\":\"AR005\",\"amt\":20567},{\"invoice\":\"AR011\",\"amt\":98872}]\",\"description\":\"Cheque No. 9876546314521\"}', '2019-01-27 14:04:42'),
(86, 'payments', '{\"id\":\"30\",\"paymentDate\":\"2019-01-02\",\"companyId\":\"1\",\"modeOfPayment\":\"RTGS\",\"paymentAmount\":\"17229\",\"paidBills\":\"[{\"invoice\":\"AR029\",\"amt\":17229}]\",\"description\":\"Ref no. 99999\"}', '2019-01-27 14:04:43'),
(87, 'payments', '{\"id\":\"31\",\"paymentDate\":\"2019-01-02\",\"companyId\":\"1\",\"modeOfPayment\":\"CASH\",\"paymentAmount\":\"80122\",\"paidBills\":\"[{\"invoice\":\"AR037\",\"amt\":17700},{\"invoice\":\"AR054\",\"amt\":62422}]\",\"description\":\"Paid By Cash\"}', '2019-01-27 14:04:44'),
(88, 'payments', '{\"id\":\"49\",\"paymentDate\":\"2019-01-27\",\"companyId\":\"1\",\"modeOfPayment\":\"CHEQUE\",\"paymentAmount\":\"143275\",\"paidBills\":\"[{\"invoice\":\"AR002\",\"amt\":23836},{\"invoice\":\"AR005\",\"amt\":20567},{\"invoice\":\"AR011\",\"amt\":98872}]\",\"description\":\"\"}', '2019-01-27 14:05:46'),
(89, 'payments', '{\"id\":\"61\",\"paymentDate\":\"2019-11-27\",\"companyId\":\"9\",\"modeOfPayment\":\"CHEQUE\",\"paymentAmount\":\"84629\",\"paidBills\":\"[{\"invoice\":\"AR008\",\"amt\":24449},{\"invoice\":\"AR020\",\"amt\":60180}]\",\"description\":\"\"}', '2019-01-27 14:27:10'),
(90, 'payments', '{\"id\":\"77\",\"paymentDate\":\"2019-01-28\",\"companyId\":\"8\",\"modeOfPayment\":\"CHEQUE\",\"paymentAmount\":\"2000\",\"paidBills\":\"[{\"invoice\":\"AR072\",\"amt\":2000}]\",\"description\":\"First Remark for AR072\"}', '2019-01-28 11:18:12');

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `description` text,
  `gstin` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`id`, `name`, `address`, `description`, `gstin`) VALUES
(1, 'Microsoft', 'California', '', '07SDF5148454874'),
(2, 'Google Inc.', 'Chandigarh', '', '0488451548ASDFS'),
(3, 'Facebook', 'Goa ', '', '30DSFGDF584748Z'),
(4, 'S3 Traders', 'Gujarat', 'Vendor From Gujrat For Type 2 Rolls', '24RRGD874F87D8F'),
(5, 'Vendor 5', 'MP', '', '23FDF5488g448gg'),
(6, '2k19', 'India', 'Optional', '23FDSGFGSGSFGSD');

-- --------------------------------------------------------

--
-- Table structure for table `vouchers`
--

CREATE TABLE `vouchers` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `amount` int(11) NOT NULL,
  `paidTo` text,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vouchers`
--

INSERT INTO `vouchers` (`id`, `date`, `amount`, `paidTo`, `description`) VALUES
(5, '2019-01-05', 1200, 'Name', 'Description'),
(6, '2019-01-05', 1350, 'Shubham', 'sdf'),
(7, '2019-01-23', 1200, 'Someone', 'Office Cleaning'),
(8, '2019-01-25', 200, 'Daily Tea Service', ''),
(9, '2019-01-25', 3000, 'Priest', 'Paid 3000 To Priest'),
(10, '2019-01-29', 30000, 'MPEB', 'Electricity bill Paid of December'),
(11, '2018-09-12', 35000, 'MPEB', 'Electricity Bills Paid of Month August'),
(12, '2018-10-15', 25000, 'MPEB', 'Electricity bill Paid of December');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `advance`
--
ALTER TABLE `advance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bills`
--
ALTER TABLE `bills`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `billNumber` (`billNumber`);

--
-- Indexes for table `chalans`
--
ALTER TABLE `chalans`
  ADD PRIMARY KEY (`number`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gatepasses`
--
ALTER TABLE `gatepasses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `particulars`
--
ALTER TABLE `particulars`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `salary`
--
ALTER TABLE `salary`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trash`
--
ALTER TABLE `trash`
  ADD PRIMARY KEY (`trashId`);

--
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vouchers`
--
ALTER TABLE `vouchers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `advance`
--
ALTER TABLE `advance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `bills`
--
ALTER TABLE `bills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `chalans`
--
ALTER TABLE `chalans`
  MODIFY `number` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `gatepasses`
--
ALTER TABLE `gatepasses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `particulars`
--
ALTER TABLE `particulars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=190;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `salary`
--
ALTER TABLE `salary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT for table `trash`
--
ALTER TABLE `trash`
  MODIFY `trashId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `vouchers`
--
ALTER TABLE `vouchers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
