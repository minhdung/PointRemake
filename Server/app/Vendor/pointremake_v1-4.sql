-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2014 at 06:43 AM
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
  `card_id` int(11) DEFAULT NULL COMMENT 'カードのＩＤ',
  `shop_id` int(11) DEFAULT NULL COMMENT 'ショップＩＤ',
  `clerk_id` int(11) DEFAULT NULL COMMENT '店員ＩＤ',
  `point` int(11) DEFAULT NULL COMMENT 'ポイントの数',
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `charge_logs`
--

INSERT INTO `charge_logs` (`id`, `card_id`, `shop_id`, `clerk_id`, `point`, `created`) VALUES
(1, 1, 2, 1, 10, '2013-04-13 00:00:00'),
(2, 1, 2, 1, 20, '2014-03-21 00:00:00'),
(3, 2, 2, 1, 10, '2014-04-17 00:00:00'),
(4, 2, 2, 0, 20, '2014-04-22 00:00:00'),
(5, 2, 2, 1, 25, '2014-04-22 00:00:00');

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
  `image` varchar(50) DEFAULT NULL,
  `description` text,
  `stamp` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `gifts`
--

INSERT INTO `gifts` (`id`, `shop_id`, `start_time`, `end_time`, `name`, `image`, `description`, `stamp`, `created`, `updated`, `deleted`) VALUES
(5, 2, '2014-04-21 04:26:00', '2014-04-28 04:26:00', 'World cup 2014', 'worlcup2014.jpg', 'Sap den world cup roi, lai mot mua he nong bong', 4, '2014-04-21 04:26:38', '2014-04-21 07:39:09', NULL),
(7, 2, '2014-04-21 05:58:00', '2014-05-21 05:58:00', 'Summer', 'summer.jpg', 'Chien dich mua he xanh', 10, '2014-04-21 05:59:06', '2014-04-21 07:39:15', NULL),
(8, 7, '2014-04-21 06:05:00', '2014-04-28 06:05:00', 'Nexus 7', 'nexus7.jpg', 'Mot trai nghiem tren ca tuyet voi', 12, '2014-04-21 06:06:27', '2014-04-21 07:10:03', NULL),
(9, 7, '2014-04-21 06:07:00', '2014-08-21 06:07:00', 'Ipad mini', 'ipad_mini.jpg', 'Dang cap cua apple', 15, '2014-04-21 06:08:15', '2014-04-21 07:10:11', NULL),
(10, 7, '2014-04-21 07:29:00', '2014-06-21 07:29:00', 'Galaxy s4', 'galaxy_s4.jpg', 'Dang cap thuc cua samsung', 18, '2014-04-21 07:29:59', '2014-04-21 07:29:59', NULL),
(12, 2, '2014-04-21 07:46:00', '2014-04-21 07:46:00', '', 'autumn.jpg', '', NULL, '2014-04-21 07:46:21', '2014-04-21 07:46:21', NULL);

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
(2, 'bigc', '61a002006fdb3e4d98c2d91a069aa4dffa28d350', 'bigc@gmail.com', 'BigC', '234 Tran Duy Hung, Cau Giay, Ha Noi', 100, '2014-04-16 12:45:00', '2014-04-23 06:39:59', NULL),
(7, 'thegioididong', '61a002006fdb3e4d98c2d91a069aa4dffa28d350', 'thegioididong@gmail.com', 'The Gioi Di Dong', '1 Chua Boc, Hai Ba Trung, Ha Noi', NULL, '2014-04-17 07:49:41', '2014-04-21 06:05:55', NULL),
(8, 'it_tech', '61a002006fdb3e4d98c2d91a069aa4dffa28d350', 'chienle.bk@gmail.com', 'IT technology', 'So 1, Le Thanh Nghi, Hai Ba Trung, Ha Noi', NULL, '2014-04-18 03:17:55', '2014-04-18 08:09:36', NULL),
(9, 'Sport', '61a002006fdb3e4d98c2d91a069aa4dffa28d350', 'sport@yahoo.com', '', '', NULL, '2014-04-18 03:19:42', '2014-04-18 03:19:42', NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
