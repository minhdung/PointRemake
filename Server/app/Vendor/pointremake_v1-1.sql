-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 17, 2014 at 09:37 AM
-- Server version: 5.6.16
-- PHP Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pointremake`
--

-- --------------------------------------------------------

--
-- Table structure for table `cards`
--

CREATE TABLE IF NOT EXISTS `cards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `card_name` varchar(50) NOT NULL COMMENT 'カードの物理のID',
  `access_token` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL COMMENT '削除の時間',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `card_shops`
--

CREATE TABLE IF NOT EXISTS `card_shops` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `card_id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `point` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `charge_logs`
--

CREATE TABLE IF NOT EXISTS `charge_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `card_id` int(11) NOT NULL COMMENT 'カードのＩＤ',
  `shop_id` int(11) NOT NULL COMMENT 'ショップＩＤ',
  `clerk_id` int(11) NOT NULL COMMENT '店員ＩＤ',
  `point` int(11) NOT NULL COMMENT 'ポイントの数',
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `clerks`
--

CREATE TABLE IF NOT EXISTS `clerks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `clerk_login` varchar(50) NOT NULL COMMENT '店員ＩＤ',
  `password` varchar(50) NOT NULL,
  `clerk_name` varchar(100) DEFAULT NULL,
  `shop_id` int(11) NOT NULL,
  `access_token` varchar(50) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gifts`
--

CREATE TABLE IF NOT EXISTS `gifts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) NOT NULL COMMENT 'ショップのＩＤ',
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `description` text,
  `url_icon` varchar(55) DEFAULT NULL,
  `url_poster` varchar(100) DEFAULT NULL,
  `stamp` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `shops`
--

CREATE TABLE IF NOT EXISTS `shops` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_login` varchar(50) NOT NULL COMMENT 'owner shop login',
  `password` varchar(50) NOT NULL,
  `shop_name` varchar(100) DEFAULT NULL,
  `shop_address` varchar(100) DEFAULT NULL,
  `stamp_to_point` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `shops`
--

INSERT INTO `shops` (`id`, `shop_login`, `password`, `shop_name`, `shop_address`, `stamp_to_point`, `created`, `updated`, `deleted`) VALUES
(2, 'bigc', '6c12ea4785f722cc0f94b254f5de20f274892a39', 'BigC', '234 Tran Duy Hung, Cau Giay, Ha Noi', 100, '2014-04-16 12:45:00', '2014-04-17 08:50:52', NULL),
(7, 'thegioididong', '31ca4e8a90f9e2d7d569ae9092bd1f960c25cfc8', 'The Gioi Di Dong', '1 Chua Boc, Hai Ba Trung, Ha Noi', NULL, '2014-04-17 07:49:41', '2014-04-17 09:14:54', NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
