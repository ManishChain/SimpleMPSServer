-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 13, 2024 at 09:29 PM
-- Server version: 5.7.23-23
-- PHP Version: 8.1.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `myperzem_simplemps`
--
CREATE DATABASE IF NOT EXISTS `myperzem_simplemps` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `myperzem_simplemps`;

DELIMITER $$
--
-- Functions
--
DROP FUNCTION IF EXISTS `F_SET_TYPE_SMS`$$
$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `ADMIN_SMS`
--

DROP TABLE IF EXISTS `ADMIN_SMS`;
CREATE TABLE IF NOT EXISTS `ADMIN_SMS` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `DEVICE_ID` int(20) NOT NULL,
  `OWNER` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `SPY` tinyint(1) NOT NULL DEFAULT '0',
  `TESTING` tinyint(1) NOT NULL,
  `ACTIVE` tinyint(1) NOT NULL,
  `BATTERY` tinyint(4) NOT NULL,
  `MESSAGE` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `EMULATOR` tinyint(1) NOT NULL DEFAULT '0',
  `ADDED_ON` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `TYPE_SMS` tinyint(4) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `DEVICE_ID` (`DEVICE_ID`),
  KEY `OWNER` (`OWNER`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Triggers `ADMIN_SMS`
--
DROP TRIGGER IF EXISTS `SET_TYPE_SMS`;
DELIMITER $$
CREATE TRIGGER `SET_TYPE_SMS` BEFORE INSERT ON `ADMIN_SMS` FOR EACH ROW SET NEW.TYPE_SMS = F_SET_TYPE_SMS(NEW.MESSAGE)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `ALTERNATE_SMS`
--

DROP TABLE IF EXISTS `ALTERNATE_SMS`;
CREATE TABLE IF NOT EXISTS `ALTERNATE_SMS` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `DEVICE_ID` int(20) NOT NULL,
  `OWNER` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `SPY` tinyint(1) NOT NULL DEFAULT '0',
  `TESTING` tinyint(1) NOT NULL,
  `ACTIVE` tinyint(1) NOT NULL,
  `BATTERY` tinyint(4) NOT NULL,
  `MESSAGE` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `EMULATOR` tinyint(1) NOT NULL DEFAULT '0',
  `ADDED_ON` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  KEY `DEVICE_ID` (`DEVICE_ID`),
  KEY `OWNER` (`OWNER`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `DEVICE`
--

DROP TABLE IF EXISTS `DEVICE`;
CREATE TABLE IF NOT EXISTS `DEVICE` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NUMBER` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `ANDROID` smallint(11) NOT NULL,
  `HANDET_INFO` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `ADDED_ON` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `LIVE` tinyint(1) NOT NULL DEFAULT '0',
  `ADMIN` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `OWNER` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `OWNER_INFO` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `DEVICE_STATUS` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DEVICE_ACTIVE_ON` date DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `EXTRA_SMS`
--

DROP TABLE IF EXISTS `EXTRA_SMS`;
CREATE TABLE IF NOT EXISTS `EXTRA_SMS` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `DEVICE_ID` int(20) NOT NULL,
  `OWNER` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `SPY` tinyint(1) NOT NULL DEFAULT '0',
  `TESTING` tinyint(1) NOT NULL,
  `ACTIVE` tinyint(1) NOT NULL,
  `BATTERY` tinyint(4) NOT NULL,
  `MESSAGE` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `EMULATOR` tinyint(1) NOT NULL DEFAULT '0',
  `ADDED_ON` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  KEY `DEVICE_ID` (`DEVICE_ID`),
  KEY `OWNER` (`OWNER`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `OTHER_SMS`
--

DROP TABLE IF EXISTS `OTHER_SMS`;
CREATE TABLE IF NOT EXISTS `OTHER_SMS` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `DEVICE_ID` int(20) NOT NULL,
  `OWNER` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `SPY` tinyint(1) NOT NULL DEFAULT '0',
  `TESTING` tinyint(1) NOT NULL,
  `ACTIVE` tinyint(1) NOT NULL,
  `BATTERY` tinyint(4) NOT NULL,
  `MESSAGE` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `EMULATOR` tinyint(1) NOT NULL DEFAULT '0',
  `ADDED_ON` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  KEY `DEVICE_ID` (`DEVICE_ID`),
  KEY `OWNER` (`OWNER`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `OWNER_SMS`
--

DROP TABLE IF EXISTS `OWNER_SMS`;
CREATE TABLE IF NOT EXISTS `OWNER_SMS` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `DEVICE_ID` int(20) NOT NULL,
  `OWNER` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `SPY` tinyint(1) NOT NULL DEFAULT '0',
  `TESTING` tinyint(1) NOT NULL,
  `ACTIVE` tinyint(1) NOT NULL,
  `BATTERY` tinyint(4) NOT NULL,
  `MESSAGE` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `EMULATOR` tinyint(1) NOT NULL DEFAULT '0',
  `ADDED_ON` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  KEY `DEVICE_ID` (`DEVICE_ID`),
  KEY `OWNER` (`OWNER`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `SIM`
--

DROP TABLE IF EXISTS `SIM`;
CREATE TABLE IF NOT EXISTS `SIM` (
  `NAME` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `NUMBER` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `TESTING` tinyint(1) NOT NULL DEFAULT '1',
  `RECHARGE_DATE` date NOT NULL,
  `NEXT_RECHARGE_DATE` date NOT NULL,
  UNIQUE KEY `NUMBER` (`NUMBER`),
  UNIQUE KEY `NAME` (`NAME`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `SUPER_SMS`
--

DROP TABLE IF EXISTS `SUPER_SMS`;
CREATE TABLE IF NOT EXISTS `SUPER_SMS` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `DEVICE_ID` int(20) NOT NULL,
  `OWNER` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `SPY` tinyint(1) NOT NULL DEFAULT '0',
  `TESTING` tinyint(1) NOT NULL,
  `ACTIVE` tinyint(1) NOT NULL,
  `BATTERY` tinyint(4) NOT NULL,
  `MESSAGE` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `EMULATOR` tinyint(1) NOT NULL DEFAULT '0',
  `ADDED_ON` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  KEY `DEVICE_ID` (`DEVICE_ID`),
  KEY `OWNER` (`OWNER`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ADMIN_SMS`
--
ALTER TABLE `ADMIN_SMS` ADD FULLTEXT KEY `MESSAGE` (`MESSAGE`);

--
-- Indexes for table `ALTERNATE_SMS`
--
ALTER TABLE `ALTERNATE_SMS` ADD FULLTEXT KEY `MESSAGE` (`MESSAGE`);

--
-- Indexes for table `EXTRA_SMS`
--
ALTER TABLE `EXTRA_SMS` ADD FULLTEXT KEY `MESSAGE` (`MESSAGE`);

--
-- Indexes for table `OTHER_SMS`
--
ALTER TABLE `OTHER_SMS` ADD FULLTEXT KEY `MESSAGE` (`MESSAGE`);

--
-- Indexes for table `OWNER_SMS`
--
ALTER TABLE `OWNER_SMS` ADD FULLTEXT KEY `MESSAGE` (`MESSAGE`);

--
-- Indexes for table `SUPER_SMS`
--
ALTER TABLE `SUPER_SMS` ADD FULLTEXT KEY `MESSAGE` (`MESSAGE`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
