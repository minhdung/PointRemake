-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 18, 2014 at 07:32 AM
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
  `access_token` varchar(50) DEFAULT NULL,
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `clerks`
--

INSERT INTO `clerks` (`id`, `clerk_login`, `password`, `clerk_name`, `shop_id`, `access_token`, `created`, `updated`, `deleted`) VALUES
(1, 'bigc_clerk1', '61a002006fdb3e4d98c2d91a069aa4dffa28d350', 'HHD', 2, NULL, '2014-04-17 11:04:04', '2014-04-18 06:11:08', NULL),
(3, 'tgdb_clerk1', '61a002006fdb3e4d98c2d91a069aa4dffa28d350', 'TGDD 1', 7, NULL, '2014-04-18 02:39:42', '2014-04-18 02:39:42', NULL),
(5, 'it_clerk1', '61a002006fdb3e4d98c2d91a069aa4dffa28d350', 'Kana', 8, NULL, '2014-04-18 06:38:08', '2014-04-18 06:38:08', NULL),
(6, 'it_clerk2', '61a002006fdb3e4d98c2d91a069aa4dffa28d350', 'Kata', 8, NULL, '2014-04-18 06:39:42', '2014-04-18 07:00:34', NULL),
(7, 'it_tech3', '61a002006fdb3e4d98c2d91a069aa4dffa28d350', '', 8, NULL, '2014-04-18 07:10:09', '2014-04-18 07:10:09', NULL),
(8, 'it_tech4', '61a002006fdb3e4d98c2d91a069aa4dffa28d350', '', 8, NULL, '2014-04-18 07:10:20', '2014-04-18 07:10:20', NULL),
(9, 'it_tech5', '61a002006fdb3e4d98c2d91a069aa4dffa28d350', '', 8, NULL, '2014-04-18 07:10:32', '2014-04-18 07:10:32', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `gifts`
--

CREATE TABLE IF NOT EXISTS `gifts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) NOT NULL COMMENT 'ショップのＩＤ',
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
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
  `shop_mail` varchar(100) NOT NULL,
  `shop_name` varchar(100) DEFAULT NULL,
  `shop_address` varchar(100) DEFAULT NULL,
  `stamp_to_point` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `shops`
--

INSERT INTO `shops` (`id`, `shop_login`, `password`, `shop_mail`, `shop_name`, `shop_address`, `stamp_to_point`, `created`, `updated`, `deleted`) VALUES
(2, 'bigc', '61a002006fdb3e4d98c2d91a069aa4dffa28d350', 'bigc@gmail.com', 'BigC', '234 Tran Duy Hung, Cau Giay, Ha Noi', 100, '2014-04-16 12:45:00', '2014-04-18 06:34:25', NULL),
(7, 'thegioididong', '31ca4e8a90f9e2d7d569ae9092bd1f960c25cfc8', 'thegioididong@gmail.com', 'The Gioi Di Dong', '1 Chua Boc, Hai Ba Trung, Ha Noi', NULL, '2014-04-17 07:49:41', '2014-04-17 09:14:54', NULL),
(8, 'it_tech', '61a002006fdb3e4d98c2d91a069aa4dffa28d350', 'chienle.bk@gmail.com', '', '', NULL, '2014-04-18 03:17:55', '2014-04-18 07:13:34', NULL),
(9, 'Sport', '61a002006fdb3e4d98c2d91a069aa4dffa28d350', 'sport@yahoo.com', '', '', NULL, '2014-04-18 03:19:42', '2014-04-18 03:19:42', NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
