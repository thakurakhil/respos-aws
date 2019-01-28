
-- phpMyAdmin SQL Dump
-- version 2.11.11.3
-- http://www.phpmyadmin.net
--
-- Host: 68.178.143.65
-- Generation Time: Aug 03, 2015 at 05:29 AM
-- Server version: 5.5.43
-- PHP Version: 5.1.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `froogal`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `image` text NOT NULL,
  `gender` enum('male','female') NOT NULL DEFAULT 'male',
  `restaurant_id` bigint(100) NOT NULL,
  UNIQUE KEY `username` (`username`),
  KEY `restaurant_id` (`restaurant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` VALUES('demo', 'demo', '', 'male', 1);

-- --------------------------------------------------------

--
-- Table structure for table `banktransfer`
--

CREATE TABLE `banktransfer` (
  `transfer_id` bigint(100) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(100) NOT NULL,
  `bankname` varchar(100) NOT NULL,
  `accountnumber` varchar(100) NOT NULL,
  `ifsccode` varchar(100) NOT NULL,
  `amount` int(10) NOT NULL,
  `phonenumber` varchar(100) NOT NULL,
  `date` datetime NOT NULL,
  `status` enum('SUCCESS','PROCESSING','FAILED') NOT NULL DEFAULT 'PROCESSING',
  PRIMARY KEY (`transfer_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `banktransfer`
--


-- --------------------------------------------------------

--
-- Table structure for table `call_waiter`
--

CREATE TABLE `call_waiter` (
  `unique_id` bigint(100) NOT NULL AUTO_INCREMENT,
  `restaurant_id` bigint(100) NOT NULL,
  `uid` bigint(100) NOT NULL,
  `datetime` datetime NOT NULL,
  `status` enum('open','closed') NOT NULL,
  PRIMARY KEY (`unique_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `call_waiter`
--

INSERT INTO `call_waiter` VALUES(1, 1, 188, '2015-07-25 18:08:28', 'closed');
INSERT INTO `call_waiter` VALUES(2, 1, 188, '2015-07-25 18:09:27', 'closed');
INSERT INTO `call_waiter` VALUES(3, 1, 188, '2015-07-25 18:11:33', 'closed');
INSERT INTO `call_waiter` VALUES(4, 1, 188, '2015-07-25 18:11:49', 'closed');
INSERT INTO `call_waiter` VALUES(5, 1, 188, '2015-07-25 18:16:02', 'closed');
INSERT INTO `call_waiter` VALUES(6, 1, 188, '2015-07-25 18:16:59', 'closed');
INSERT INTO `call_waiter` VALUES(7, 1, 188, '2015-07-25 18:22:22', 'closed');
INSERT INTO `call_waiter` VALUES(8, 1, 188, '2015-07-25 18:22:26', 'closed');
INSERT INTO `call_waiter` VALUES(9, 1, 188, '2015-07-25 18:22:29', 'closed');
INSERT INTO `call_waiter` VALUES(10, 1, 188, '2015-07-25 19:16:23', 'open');
INSERT INTO `call_waiter` VALUES(11, 1, 188, '2015-07-25 19:17:14', 'closed');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` bigint(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `restaurant_id` bigint(100) NOT NULL,
  `status` enum('active','not active') NOT NULL DEFAULT 'active',
  PRIMARY KEY (`category_id`),
  KEY `restaurant_id` (`restaurant_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=88 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` VALUES(82, 'BIG O WICH', 1, 'active');
INSERT INTO `category` VALUES(83, 'LE CLASSICS', 1, 'active');
INSERT INTO `category` VALUES(85, 'SWEET BITES', 1, 'active');
INSERT INTO `category` VALUES(86, 'Y NO PANEER..!!', 1, 'active');
INSERT INTO `category` VALUES(87, 'CHEESE O MANIA', 1, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `checkin`
--

CREATE TABLE `checkin` (
  `checkin_id` bigint(100) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(100) NOT NULL,
  `restaurant_id` bigint(100) NOT NULL,
  `status` enum('active','not active') NOT NULL DEFAULT 'active',
  `checkin_time` datetime NOT NULL,
  PRIMARY KEY (`checkin_id`),
  KEY `user_id` (`user_id`),
  KEY `restaurant_id` (`restaurant_id`),
  KEY `status` (`status`),
  KEY `time` (`checkin_time`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `checkin`
--


-- --------------------------------------------------------

--
-- Table structure for table `cost_to_restaurant`
--

CREATE TABLE `cost_to_restaurant` (
  `unique_id` bigint(100) NOT NULL AUTO_INCREMENT,
  `restaurant_id` bigint(100) NOT NULL,
  `desc` varchar(100) NOT NULL,
  `cost` bigint(100) NOT NULL,
  `tag` varchar(100) NOT NULL,
  `uid` bigint(100) NOT NULL,
  PRIMARY KEY (`unique_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=54 ;

--
-- Dumping data for table `cost_to_restaurant`
--

INSERT INTO `cost_to_restaurant` VALUES(1, 1, 'Rs 1/- has been deducted from your account for using our Email service !', 1, 'Email', 187);
INSERT INTO `cost_to_restaurant` VALUES(2, 1, 'Rs 1/- has been deducted from your account for using our Push service !', 1, 'Push', 187);
INSERT INTO `cost_to_restaurant` VALUES(3, 1, 'Rs 1/- has been deducted from your account for using our Push service !', 1, 'Push', 187);
INSERT INTO `cost_to_restaurant` VALUES(4, 1, 'Rs 1/- has been deducted from your account for using our Push service !', 1, 'Push', 187);
INSERT INTO `cost_to_restaurant` VALUES(5, 1, 'Rs 1/- has been deducted from your account for using our Push service !', 1, 'Push', 187);
INSERT INTO `cost_to_restaurant` VALUES(6, 1, 'Rs 1/- has been deducted from your account for using our Push service !', 1, 'Push', 187);
INSERT INTO `cost_to_restaurant` VALUES(7, 1, 'Rs 1/- has been deducted from your account for using our Push service !', 1, 'Push', 187);
INSERT INTO `cost_to_restaurant` VALUES(8, 1, 'Rs 1/- has been deducted from your account for using our Push service !', 1, 'Push', 187);
INSERT INTO `cost_to_restaurant` VALUES(9, 1, 'Rs 1/- has been deducted from your account for using our Push service !', 1, 'Push', 187);
INSERT INTO `cost_to_restaurant` VALUES(10, 1, 'Rs 1/- has been deducted from your account for using our Push service !', 1, 'Push', 187);
INSERT INTO `cost_to_restaurant` VALUES(11, 1, 'Rs 1/- has been deducted from your account for using our Push service !', 1, 'Push', 187);
INSERT INTO `cost_to_restaurant` VALUES(12, 1, 'Rs 1/- has been deducted from your account for using our Push service !', 1, 'Push', 187);
INSERT INTO `cost_to_restaurant` VALUES(13, 1, 'Rs 1/- has been deducted from your account for using our Push service !', 1, 'Push', 187);
INSERT INTO `cost_to_restaurant` VALUES(14, 1, 'Rs 1/- has been deducted from your account for using our Push service !', 1, 'Push', 187);
INSERT INTO `cost_to_restaurant` VALUES(15, 1, 'Rs 1/- has been deducted from your account for using our Push service !', 1, 'Push', 187);
INSERT INTO `cost_to_restaurant` VALUES(16, 1, 'Rs 1/- has been deducted from your account for using our Push service !', 1, 'Push', 187);
INSERT INTO `cost_to_restaurant` VALUES(17, 1, 'Rs 1/- has been deducted from your account for using our Push service !', 1, 'Push', 187);
INSERT INTO `cost_to_restaurant` VALUES(18, 1, 'Rs 1/- has been deducted from your account for using our Email service !', 1, 'Email', 187);
INSERT INTO `cost_to_restaurant` VALUES(19, 1, 'Rs 1/- has been deducted from your account for using our Email service !', 1, 'Email', 187);
INSERT INTO `cost_to_restaurant` VALUES(20, 1, 'Rs 1/- has been deducted from your account for using our Push service !', 1, 'Push', 187);
INSERT INTO `cost_to_restaurant` VALUES(21, 1, 'Rs 1/- has been deducted from your account for using our Push service !', 1, 'Push', 187);
INSERT INTO `cost_to_restaurant` VALUES(22, 1, 'Rs 1/- has been deducted from your account for using our Email service !', 1, 'Email', 187);
INSERT INTO `cost_to_restaurant` VALUES(23, 1, 'Rs 1/- has been deducted from your account for using our Push service !', 1, 'Push', 187);
INSERT INTO `cost_to_restaurant` VALUES(24, 1, 'Rs 1/- has been deducted from your account for using our Email service !', 1, 'Email', 179);
INSERT INTO `cost_to_restaurant` VALUES(25, 1, 'Rs 1/- has been deducted from your account for using our Email service !', 1, 'Email', 188);
INSERT INTO `cost_to_restaurant` VALUES(26, 1, 'Rs 1/- has been deducted from your account for using our Email service !', 1, 'Email', 189);
INSERT INTO `cost_to_restaurant` VALUES(27, 1, 'Rs 1/- has been deducted from your account for using our Email service !', 1, 'Email', 190);
INSERT INTO `cost_to_restaurant` VALUES(28, 1, 'Rs 1/- has been deducted from your account for using our Email service !', 1, 'Email', 191);
INSERT INTO `cost_to_restaurant` VALUES(29, 1, 'Rs 1/- has been deducted from your account for using our Push service !', 1, 'Push', 179);
INSERT INTO `cost_to_restaurant` VALUES(30, 1, 'Rs 1/- has been deducted from your account for using our Push service !', 1, 'Push', 188);
INSERT INTO `cost_to_restaurant` VALUES(31, 1, 'Rs 1/- has been deducted from your account for using our Push service !', 1, 'Push', 189);
INSERT INTO `cost_to_restaurant` VALUES(32, 1, 'Rs 1/- has been deducted from your account for using our Push service !', 1, 'Push', 190);
INSERT INTO `cost_to_restaurant` VALUES(33, 1, 'Rs 1/- has been deducted from your account for using our Push service !', 1, 'Push', 191);
INSERT INTO `cost_to_restaurant` VALUES(34, 1, 'Rs 1/- has been deducted from your account for using our Push service !', 1, 'Push', 179);
INSERT INTO `cost_to_restaurant` VALUES(35, 1, 'Rs 1/- has been deducted from your account for using our Push service !', 1, 'Push', 188);
INSERT INTO `cost_to_restaurant` VALUES(36, 1, 'Rs 1/- has been deducted from your account for using our Push service !', 1, 'Push', 189);
INSERT INTO `cost_to_restaurant` VALUES(37, 1, 'Rs 1/- has been deducted from your account for using our Push service !', 1, 'Push', 190);
INSERT INTO `cost_to_restaurant` VALUES(38, 1, 'Rs 1/- has been deducted from your account for using our Push service !', 1, 'Push', 191);
INSERT INTO `cost_to_restaurant` VALUES(39, 1, 'Rs 1/- has been deducted from your account for using our Email service !', 1, 'Email', 179);
INSERT INTO `cost_to_restaurant` VALUES(40, 1, 'Rs 1/- has been deducted from your account for using our Email service !', 1, 'Email', 188);
INSERT INTO `cost_to_restaurant` VALUES(41, 1, 'Rs 1/- has been deducted from your account for using our Email service !', 1, 'Email', 189);
INSERT INTO `cost_to_restaurant` VALUES(42, 1, 'Rs 1/- has been deducted from your account for using our Email service !', 1, 'Email', 190);
INSERT INTO `cost_to_restaurant` VALUES(43, 1, 'Rs 1/- has been deducted from your account for using our Email service !', 1, 'Email', 191);
INSERT INTO `cost_to_restaurant` VALUES(44, 1, 'Rs 1/- has been deducted from your account for using our Push service !', 1, 'Push', 179);
INSERT INTO `cost_to_restaurant` VALUES(45, 1, 'Rs 1/- has been deducted from your account for using our Push service !', 1, 'Push', 188);
INSERT INTO `cost_to_restaurant` VALUES(46, 1, 'Rs 1/- has been deducted from your account for using our Push service !', 1, 'Push', 189);
INSERT INTO `cost_to_restaurant` VALUES(47, 1, 'Rs 1/- has been deducted from your account for using our Push service !', 1, 'Push', 190);
INSERT INTO `cost_to_restaurant` VALUES(48, 1, 'Rs 1/- has been deducted from your account for using our Push service !', 1, 'Push', 191);
INSERT INTO `cost_to_restaurant` VALUES(49, 1, 'Rs 1/- has been deducted from your account for using our Push service !', 1, 'Push', 192);
INSERT INTO `cost_to_restaurant` VALUES(50, 1, 'Rs 1/- has been deducted from your account for using our Push service !', 1, 'Push', 192);
INSERT INTO `cost_to_restaurant` VALUES(51, 1, 'Rs 1/- has been deducted from your account for using our Push service !', 1, 'Push', 192);
INSERT INTO `cost_to_restaurant` VALUES(52, 1, 'Rs 1/- has been deducted from your account for using our Push service !', 1, 'Push', 192);
INSERT INTO `cost_to_restaurant` VALUES(53, 1, 'Rs 1/- has been deducted from your account for using our Email service !', 1, 'Email', 192);

-- --------------------------------------------------------

--
-- Table structure for table `event_offers_given`
--

CREATE TABLE `event_offers_given` (
  `unique_id` bigint(100) NOT NULL,
  `uid` bigint(100) NOT NULL,
  `percentage` bigint(100) NOT NULL,
  `restaurant_id` bigint(100) NOT NULL,
  `message` varchar(100) NOT NULL,
  `event` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `event_offers_given`
--

INSERT INTO `event_offers_given` VALUES(0, 187, 10, 0, 'Hi, A special only for you on your birthday !', 'birthday');
INSERT INTO `event_offers_given` VALUES(0, 187, 0, 0, 'Hi, A special only for you on your birthday !', 'birthday');
INSERT INTO `event_offers_given` VALUES(0, 187, 0, 0, 'Hi, A special only for you on your birthday !', 'birthday');
INSERT INTO `event_offers_given` VALUES(0, 187, 0, 0, 'Hi, A special only for you on your birthday !', 'birthday');
INSERT INTO `event_offers_given` VALUES(0, 187, 0, 0, 'Hi, A special only for you on your birthday !', 'birthday');
INSERT INTO `event_offers_given` VALUES(0, 187, 0, 0, 'Hi, A special only for you on your birthday !', 'birthday');
INSERT INTO `event_offers_given` VALUES(0, 187, 10, 0, 'Hi, A special only for you on your birthday !', 'birthday');
INSERT INTO `event_offers_given` VALUES(0, 187, 15, 0, 'Hi, A special only for you on your birthday !', 'birthday');
INSERT INTO `event_offers_given` VALUES(0, 187, 15, 0, 'Hi, A special only for you on your birthday !', 'birthday');
INSERT INTO `event_offers_given` VALUES(0, 187, 15, 0, 'Hi, A special only for you on your birthday !', 'birthday');
INSERT INTO `event_offers_given` VALUES(0, 187, 15, 0, 'Hi, A special only for you on your birthday !', 'birthday');
INSERT INTO `event_offers_given` VALUES(0, 187, 15, 0, 'Hi, A special only for you on your birthday !', 'birthday');
INSERT INTO `event_offers_given` VALUES(0, 187, 20, 0, 'Hi, A special only for you on your birthday !', 'birthday');
INSERT INTO `event_offers_given` VALUES(0, 187, 20, 0, 'Hi, A special only for you on your birthday !', 'birthday');
INSERT INTO `event_offers_given` VALUES(0, 187, 20, 0, 'Hi, A special only for you on your birthday !', 'birthday');
INSERT INTO `event_offers_given` VALUES(0, 187, 20, 0, 'Hi, A special only for you on your birthday !', 'birthday');
INSERT INTO `event_offers_given` VALUES(0, 187, 20, 0, 'Hi, A special only for you on your birthday !', 'birthday');
INSERT INTO `event_offers_given` VALUES(0, 187, 20, 0, 'Hi, A special only for you on your birthday !', 'birthday');
INSERT INTO `event_offers_given` VALUES(0, 187, 15, 0, 'Hi, A special only for you on your birthday !', 'birthday');
INSERT INTO `event_offers_given` VALUES(0, 187, 15, 0, 'Hi, A special only for you on your birthday !', 'birthday');
INSERT INTO `event_offers_given` VALUES(0, 187, 15, 0, 'Hi, A special only for you on your birthday !', 'birthday');
INSERT INTO `event_offers_given` VALUES(0, 187, 20, 0, 'Hi, A special only for you on your birthday !', 'birthday');
INSERT INTO `event_offers_given` VALUES(0, 187, 20, 0, 'Hi, A special only for you on your birthday !', 'birthday');
INSERT INTO `event_offers_given` VALUES(0, 187, 20, 0, 'Hi, A special only for you on your birthday !', 'birthday');
INSERT INTO `event_offers_given` VALUES(0, 187, 10, 0, 'Hi, A special only for you on your birthday !', 'birthday');
INSERT INTO `event_offers_given` VALUES(0, 187, 10, 0, 'Hi, A special only for you on your birthday !', 'birthday');
INSERT INTO `event_offers_given` VALUES(0, 187, 10, 0, 'Hi, A special only for you on your birthday !', 'birthday');
INSERT INTO `event_offers_given` VALUES(0, 187, 15, 0, 'Hi, A special only for you on your birthday !', 'ann_date');
INSERT INTO `event_offers_given` VALUES(0, 187, 15, 0, 'Hi, A special only for you on your birthday !', 'ann_date');

-- --------------------------------------------------------

--
-- Table structure for table `extras`
--

CREATE TABLE `extras` (
  `unique_id` bigint(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `restaurant_id` bigint(100) NOT NULL,
  `price` bigint(100) NOT NULL,
  `product_id` bigint(100) NOT NULL,
  PRIMARY KEY (`unique_id`),
  KEY `restaurant_id` (`restaurant_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `extras`
--

INSERT INTO `extras` VALUES(1, 'Cheese', 1, 20, 1);
INSERT INTO `extras` VALUES(2, 'Butter', 1, 30, 2);

-- --------------------------------------------------------

--
-- Table structure for table `facebook_friends`
--

CREATE TABLE `facebook_friends` (
  `facebook_id` varchar(50) NOT NULL,
  `id` varchar(25) NOT NULL,
  `name` varchar(25) NOT NULL,
  KEY `unique_id_index` (`facebook_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `facebook_friends`
--


-- --------------------------------------------------------

--
-- Table structure for table `favourites`
--

CREATE TABLE `favourites` (
  `fav_id` bigint(100) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(100) NOT NULL,
  `restaurant_id` bigint(100) NOT NULL,
  `time` datetime DEFAULT NULL,
  PRIMARY KEY (`fav_id`),
  KEY `user_id` (`user_id`),
  KEY `restaurant_id` (`restaurant_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `favourites`
--


-- --------------------------------------------------------

--
-- Table structure for table `loyaltyCards`
--

CREATE TABLE `loyaltyCards` (
  `loyaltycard_id` bigint(100) NOT NULL AUTO_INCREMENT,
  `restaurant_id` bigint(100) NOT NULL,
  `start_datetime` datetime NOT NULL,
  `end_datetime` datetime NOT NULL,
  `number_visits` bigint(255) NOT NULL,
  PRIMARY KEY (`loyaltycard_id`),
  UNIQUE KEY `restaurant_id` (`restaurant_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `loyaltyCards`
--

INSERT INTO `loyaltyCards` VALUES(2, 1, '2015-07-18 00:00:00', '2015-07-31 23:59:59', 5);

-- --------------------------------------------------------

--
-- Table structure for table `loyalty_card_statistics`
--

CREATE TABLE `loyalty_card_statistics` (
  `loyaltycard_id` bigint(100) NOT NULL,
  `restaurant_id` bigint(100) NOT NULL,
  `discount` bigint(100) NOT NULL,
  `product_id` bigint(100) NOT NULL,
  `visit_number` bigint(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `loyalty_card_statistics`
--

INSERT INTO `loyalty_card_statistics` VALUES(2, 1, 0, 0, 1);
INSERT INTO `loyalty_card_statistics` VALUES(2, 1, 0, 0, 2);
INSERT INTO `loyalty_card_statistics` VALUES(2, 1, 0, 0, 3);
INSERT INTO `loyalty_card_statistics` VALUES(2, 1, 0, 0, 4);
INSERT INTO `loyalty_card_statistics` VALUES(2, 1, 0, 0, 5);

-- --------------------------------------------------------

--
-- Table structure for table `mobilerecharge`
--

CREATE TABLE `mobilerecharge` (
  `recharge_id` bigint(100) NOT NULL AUTO_INCREMENT,
  `order_id` varchar(250) NOT NULL,
  `transaction_id` varchar(100) NOT NULL,
  `user_id` bigint(100) NOT NULL,
  `status` varchar(20) NOT NULL,
  `operator` varchar(20) NOT NULL,
  `service` varchar(20) NOT NULL,
  `amount` int(10) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`recharge_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `mobilerecharge`
--


-- --------------------------------------------------------

--
-- Table structure for table `new_offers_given`
--

CREATE TABLE `new_offers_given` (
  `unique_id` bigint(100) NOT NULL AUTO_INCREMENT,
  `uid` bigint(100) NOT NULL,
  `restaurant_id` bigint(100) NOT NULL,
  `percentage` bigint(100) NOT NULL,
  `message` bigint(100) NOT NULL,
  UNIQUE KEY `unique_id` (`unique_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `new_offers_given`
--

INSERT INTO `new_offers_given` VALUES(1, 179, 0, 15, 0);
INSERT INTO `new_offers_given` VALUES(2, 179, 0, 15, 0);
INSERT INTO `new_offers_given` VALUES(3, 188, 0, 15, 0);
INSERT INTO `new_offers_given` VALUES(4, 189, 0, 15, 0);
INSERT INTO `new_offers_given` VALUES(5, 190, 0, 15, 0);
INSERT INTO `new_offers_given` VALUES(6, 191, 0, 15, 0);
INSERT INTO `new_offers_given` VALUES(7, 179, 0, 15, 0);
INSERT INTO `new_offers_given` VALUES(8, 179, 0, 15, 0);
INSERT INTO `new_offers_given` VALUES(9, 188, 0, 15, 0);
INSERT INTO `new_offers_given` VALUES(10, 189, 0, 15, 0);
INSERT INTO `new_offers_given` VALUES(11, 190, 0, 15, 0);
INSERT INTO `new_offers_given` VALUES(12, 191, 0, 15, 0);
INSERT INTO `new_offers_given` VALUES(13, 179, 0, 15, 0);
INSERT INTO `new_offers_given` VALUES(14, 188, 0, 15, 0);
INSERT INTO `new_offers_given` VALUES(15, 189, 0, 15, 0);
INSERT INTO `new_offers_given` VALUES(16, 190, 0, 15, 0);
INSERT INTO `new_offers_given` VALUES(17, 191, 0, 15, 0);
INSERT INTO `new_offers_given` VALUES(18, 179, 0, 15, 0);
INSERT INTO `new_offers_given` VALUES(19, 188, 0, 15, 0);
INSERT INTO `new_offers_given` VALUES(20, 189, 0, 15, 0);
INSERT INTO `new_offers_given` VALUES(21, 190, 0, 15, 0);
INSERT INTO `new_offers_given` VALUES(22, 191, 0, 15, 0);
INSERT INTO `new_offers_given` VALUES(23, 179, 0, 15, 0);
INSERT INTO `new_offers_given` VALUES(24, 188, 0, 15, 0);
INSERT INTO `new_offers_given` VALUES(25, 189, 0, 15, 0);
INSERT INTO `new_offers_given` VALUES(26, 190, 0, 15, 0);
INSERT INTO `new_offers_given` VALUES(27, 191, 0, 15, 0);
INSERT INTO `new_offers_given` VALUES(28, 192, 0, 15, 0);
INSERT INTO `new_offers_given` VALUES(29, 192, 0, 15, 0);
INSERT INTO `new_offers_given` VALUES(30, 192, 0, 15, 0);
INSERT INTO `new_offers_given` VALUES(31, 192, 0, 15, 0);
INSERT INTO `new_offers_given` VALUES(32, 192, 0, 15, 0);

-- --------------------------------------------------------

--
-- Table structure for table `offer_bogo`
--

CREATE TABLE `offer_bogo` (
  `bogo_id` bigint(100) NOT NULL AUTO_INCREMENT,
  `restaurant_id` bigint(100) NOT NULL,
  `buy_id` bigint(100) NOT NULL,
  `get_id` bigint(100) NOT NULL,
  `start_datetime` datetime NOT NULL,
  `end_datetime` datetime NOT NULL,
  PRIMARY KEY (`bogo_id`),
  KEY `restaurant_id` (`restaurant_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `offer_bogo`
--

INSERT INTO `offer_bogo` VALUES(4, 1, 1021, 1023, '2008-02-04 04:30:03', '2020-04-04 02:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `offer_discount`
--

CREATE TABLE `offer_discount` (
  `discount_id` bigint(100) NOT NULL AUTO_INCREMENT,
  `restaurant_id` bigint(100) NOT NULL,
  `product_id` bigint(100) NOT NULL,
  `percentage` double NOT NULL,
  `start_datetime` datetime NOT NULL,
  `end_datetime` datetime NOT NULL,
  PRIMARY KEY (`discount_id`),
  KEY `restaurant_id` (`restaurant_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `offer_discount`
--

INSERT INTO `offer_discount` VALUES(1, 1, 1021, 50, '2015-07-02 18:01:42', '2019-07-12 18:01:45');
INSERT INTO `offer_discount` VALUES(2, 1, 1022, 25, '2015-07-02 18:01:42', '2020-07-17 18:01:45');

-- --------------------------------------------------------

--
-- Table structure for table `offer_loyalty`
--

CREATE TABLE `offer_loyalty` (
  `offer_id` bigint(100) NOT NULL AUTO_INCREMENT,
  `loyaltycard_id` bigint(100) NOT NULL,
  `type` enum('discount','free') NOT NULL,
  `product_id` bigint(20) DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `minbill` double DEFAULT NULL,
  `visit` int(20) NOT NULL,
  PRIMARY KEY (`offer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `offer_loyalty`
--

INSERT INTO `offer_loyalty` VALUES(1, 1, 'discount', NULL, 20, 200, 1);
INSERT INTO `offer_loyalty` VALUES(2, 1, 'free', 1021, NULL, NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `offer_rewards`
--

CREATE TABLE `offer_rewards` (
  `rewards_id` bigint(100) NOT NULL AUTO_INCREMENT,
  `restaurant_id` bigint(100) NOT NULL,
  `percentage` double NOT NULL,
  `start_datetime` datetime NOT NULL,
  `end_datetime` datetime NOT NULL,
  PRIMARY KEY (`rewards_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `offer_rewards`
--

INSERT INTO `offer_rewards` VALUES(1, 1, 10, '2015-07-09 18:02:27', '2020-07-10 18:02:31');

-- --------------------------------------------------------

--
-- Table structure for table `orderItems`
--

CREATE TABLE `orderItems` (
  `order_id` bigint(100) NOT NULL,
  `product_id` bigint(100) NOT NULL,
  `quantity` bigint(100) NOT NULL,
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orderItems`
--


-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` bigint(100) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(100) NOT NULL,
  `restaurant_id` bigint(100) NOT NULL,
  `status` enum('closed','notclosed') NOT NULL DEFAULT 'notclosed',
  PRIMARY KEY (`order_id`),
  KEY `user_id` (`user_id`),
  KEY `restaurant_id` (`restaurant_id`),
  KEY `status` (`status`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;

--
-- Dumping data for table `orders`
--


-- --------------------------------------------------------

--
-- Table structure for table `percentage_scheme`
--

CREATE TABLE `percentage_scheme` (
  `unique_id` bigint(100) NOT NULL AUTO_INCREMENT,
  `product_id` bigint(100) NOT NULL,
  `start_date` varchar(100) NOT NULL,
  `end_date` varchar(100) NOT NULL,
  `desc` varchar(100) NOT NULL,
  `percentage` bigint(100) NOT NULL,
  `restaurant_id` bigint(100) NOT NULL,
  PRIMARY KEY (`unique_id`),
  KEY `restaurant_id` (`restaurant_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `percentage_scheme`
--

INSERT INTO `percentage_scheme` VALUES(3, 1024, '2012-04-04', '2015-06-07', 'Fucking cool', 10, 1);
INSERT INTO `percentage_scheme` VALUES(4, 1021, '2012-03-02', '2015-05-07', 'gdsf', 10, 1);
INSERT INTO `percentage_scheme` VALUES(5, 1021, '2015-02-02', '2008-03-06', 'Fucking cool', 15, 1);
INSERT INTO `percentage_scheme` VALUES(6, 1021, '2008-04-03', '2014-04-10', 'svvda', 15, 1);
INSERT INTO `percentage_scheme` VALUES(7, 1021, '2015-01-01', '2015-01-01', 'ouubdf', 15, 1);
INSERT INTO `percentage_scheme` VALUES(8, 1021, '2015-01-01', '2015-01-01', 'ouubdf', 15, 1);
INSERT INTO `percentage_scheme` VALUES(9, 1021, '2014-02-03', '2014-03-04', 'dkbv', 15, 1);
INSERT INTO `percentage_scheme` VALUES(10, 1021, '2014-02-03', '2014-03-04', 'dkbv', 15, 1);
INSERT INTO `percentage_scheme` VALUES(11, 1021, '2013-03-02', '2013-06-06', 'sdfsdad', 15, 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` bigint(100) NOT NULL AUTO_INCREMENT,
  `category_id` bigint(100) NOT NULL,
  `description` text NOT NULL,
  `image_url` varchar(1000) NOT NULL,
  `name` varchar(1000) NOT NULL,
  `size` varchar(100) NOT NULL,
  `price` varchar(100) NOT NULL,
  `rating` varchar(20) DEFAULT NULL,
  `restaurant_id` bigint(100) NOT NULL,
  PRIMARY KEY (`product_id`),
  KEY `category_id` (`category_id`),
  KEY `restaurant_id` (`restaurant_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1058 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` VALUES(1026, 82, '', 'food.jpg', 'Mini Club', 'Normal', '80', NULL, 1);
INSERT INTO `products` VALUES(1027, 82, '', 'food.jpg', 'Wich Please Special', 'Normal', '100', NULL, 1);
INSERT INTO `products` VALUES(1028, 82, '', 'food.jpg', 'Tandoori Special Club', 'Normal', '110', NULL, 1);
INSERT INTO `products` VALUES(1029, 82, '', 'food.jpg', 'Special Paneer Club', 'Normal', '120', NULL, 1);
INSERT INTO `products` VALUES(1030, 83, '', 'food.jpg', 'Classic Aloo Wich', 'Normal', '35', NULL, 1);
INSERT INTO `products` VALUES(1031, 83, '', 'food.jpg', 'Butter Toast', 'Normal', '30', NULL, 1);
INSERT INTO `products` VALUES(1032, 83, '', 'food.jpg', 'Veggie Wich', 'Normal', '40', NULL, 1);
INSERT INTO `products` VALUES(1033, 83, '', 'food.jpg', 'Grilled Masala Wich', 'Normal', '45', NULL, 1);
INSERT INTO `products` VALUES(1034, 83, '', 'food.jpg', 'Bombay Kaccha', 'Normal', '45', NULL, 1);
INSERT INTO `products` VALUES(1035, 83, '', 'food.jpg', 'Special Tandoori Wich', 'Normal', '70', NULL, 1);
INSERT INTO `products` VALUES(1036, 83, '', 'food.jpg', 'Special Tandoori Wich', 'Normal', '70', NULL, 1);
INSERT INTO `products` VALUES(1037, 85, '', 'food.jpg', 'Creamy Toast', 'Normal', '30', NULL, 1);
INSERT INTO `products` VALUES(1038, 85, '', 'food.jpg', 'Butter Sweet Wich', 'Normal', '45', NULL, 1);
INSERT INTO `products` VALUES(1039, 85, '', 'food.jpg', 'Jam Cheese Wich', 'Normal', '50', NULL, 1);
INSERT INTO `products` VALUES(1040, 85, '', 'food.jpg', 'Pineapple Cheese Wich', 'Normal', '70', NULL, 1);
INSERT INTO `products` VALUES(1041, 85, '', 'food.jpg', 'Chocolate Grilled Wich', 'Normal', '75', NULL, 1);
INSERT INTO `products` VALUES(1042, 85, '', 'food.jpg', 'Nutella Toast', 'Normal', '70', NULL, 1);
INSERT INTO `products` VALUES(1043, 86, '', 'food.jpg', 'Tandoori Paneer Wich', 'Normal', '90', NULL, 1);
INSERT INTO `products` VALUES(1044, 86, '', 'food.jpg', 'Cottage Cheese Masala', 'Normal', '60', NULL, 1);
INSERT INTO `products` VALUES(1045, 86, '', 'food.jpg', 'Paneer Tikka', 'Normal', '70', NULL, 1);
INSERT INTO `products` VALUES(1046, 87, '', 'food.jpg', 'Cheese Masala Wich', 'Normal', '60', NULL, 1);
INSERT INTO `products` VALUES(1047, 87, '', 'food.jpg', 'Chilli Garlic Wich', 'Normal', '70', NULL, 1);
INSERT INTO `products` VALUES(1048, 87, '', 'food.jpg', 'Spinach Corn', 'Normal', '80', NULL, 1);
INSERT INTO `products` VALUES(1049, 87, '', 'food.jpg', 'Special Mayo Wich', 'Normal', '80', NULL, 1);
INSERT INTO `products` VALUES(1050, 87, '', 'food.jpg', 'Cheese Potatino', 'Normal', '50', NULL, 1);
INSERT INTO `products` VALUES(1051, 87, '', 'food.jpg', 'Cheese Veggie', 'Normal', '55', NULL, 1);
INSERT INTO `products` VALUES(1052, 87, '', 'food.jpg', 'Cheese Chutney', 'Normal', '60', NULL, 1);
INSERT INTO `products` VALUES(1053, 87, '', 'food.jpg', 'Cheese Butter', 'Normal', '50', NULL, 1);
INSERT INTO `products` VALUES(1054, 87, '', 'food.jpg', 'Mayo Veggie', 'Normal', '60', NULL, 1);
INSERT INTO `products` VALUES(1055, 87, '', 'food.jpg', 'Mayo Aloo Wich', 'Normal', '60', NULL, 1);
INSERT INTO `products` VALUES(1056, 87, '', 'food.jpg', 'Capsionio', 'Normal', '70', NULL, 1);
INSERT INTO `products` VALUES(1057, 87, '', 'food.jpg', 'Cheese Chilli', 'Normal', '70', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `restaurants`
--

CREATE TABLE `restaurants` (
  `restaurant_id` bigint(100) NOT NULL AUTO_INCREMENT,
  `unique_id` varchar(23) NOT NULL,
  `name` varchar(23) NOT NULL,
  `address` varchar(23) NOT NULL,
  `primaryContact` varchar(15) NOT NULL,
  `rating` varchar(10) DEFAULT NULL,
  `phone_number` varchar(10) NOT NULL,
  `longitude` float(10,6) NOT NULL,
  `latitude` float(10,6) NOT NULL,
  `reward` enum('green','red') NOT NULL DEFAULT 'green',
  `coupon` enum('green','red') NOT NULL DEFAULT 'red',
  `tags` varchar(500) DEFAULT NULL,
  `tagsdata` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`restaurant_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `restaurants`
--

INSERT INTO `restaurants` VALUES(1, '1', 'Amity Restaurant', 'gachibowli aha', '222222', '4.375', '4564564564', 78.358429, 17.441483, 'green', 'red', '["servers alcohol","servers non veg","server veg","serves water","tables","chairs","wakeup"]', '["1","1","1","1","1","0","1"]');
INSERT INTO `restaurants` VALUES(2, '2', 'Udipi Tiffins', 'address2', '11111', '2.3', 'number2', 78.360687, 17.440924, 'green', 'green', NULL, NULL);
INSERT INTO `restaurants` VALUES(3, '3', 'Paradise', 'IMAX', '222222', '5', '555555', 78.465508, 17.412155, 'red', 'red', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` bigint(100) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(100) NOT NULL,
  `restaurant_id` bigint(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `rating` varchar(100) NOT NULL,
  `likes` int(100) DEFAULT '0',
  `dislikes` int(100) DEFAULT '0',
  `date` datetime NOT NULL,
  PRIMARY KEY (`review_id`),
  KEY `restaurant_id` (`restaurant_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `reviews`
--


-- --------------------------------------------------------

--
-- Table structure for table `rewards`
--

CREATE TABLE `rewards` (
  `reward_id` bigint(100) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(100) NOT NULL,
  `type` bigint(100) NOT NULL DEFAULT '0',
  `from_id` bigint(100) NOT NULL,
  `reward` bigint(100) NOT NULL,
  `status` bigint(100) NOT NULL,
  PRIMARY KEY (`reward_id`),
  KEY `user_id` (`user_id`),
  KEY `from_id` (`from_id`),
  KEY `status` (`status`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `rewards`
--

INSERT INTO `rewards` VALUES(1, 179, 0, 22, 25, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `uid` bigint(100) NOT NULL AUTO_INCREMENT,
  `unique_id` varchar(23) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(100) DEFAULT NULL,
  `mobile_verified` enum('yes','no') NOT NULL DEFAULT 'no',
  `encrypted_password` varchar(80) NOT NULL,
  `salt` varchar(10) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `longitude` varchar(25) NOT NULL,
  `latitude` varchar(25) NOT NULL,
  `ip_address` text NOT NULL,
  `registered_at` text NOT NULL,
  `IMEI` text NOT NULL,
  `registered_through` text,
  `image_url` longtext NOT NULL,
  `gcm_token` longtext NOT NULL,
  `special_id` varchar(50) NOT NULL,
  `birthday` varchar(30) DEFAULT NULL,
  `rewards_all` bigint(100) DEFAULT '0',
  `rewards_used` bigint(100) DEFAULT '0',
  `referral_code` varchar(100) NOT NULL,
  `referred_by` varchar(100) NOT NULL,
  `ann_date` date NOT NULL,
  PRIMARY KEY (`uid`),
  KEY `unique_id_index` (`unique_id`),
  KEY `facebook_id` (`special_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=194 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` VALUES(192, '55bcd8fe7e1e81.03509779', 'Rohit', 'Svk', 'rohitsakala@gmail.com', '9666255517', 'yes', 'PJC5aCY8zZig1OKhju+jPoH00M82MjRjOGQ2NzBj', '624c8d670c', '2015-08-01 07:34:38', '78.3499046', '17.4460012', '10.2.193.96', 'Hyderabad', '864587023821250', 'f', 'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xfp1/v/t1.0-1/c5.0.50.50/p50x50/310335_276296669066497_1511196060_n.jpg?oh=675103d90a9997218b573d3c92ffdfc8&oe=5651CC68&__gda__=1447776782_9dd88a11df9abc673f6d13f356f4c506', 'dlyMP-bEqbw:APA91bE5hOwaFbBlA0tKYdEyismAfKMMxOyNgqew1ZBfi2LZx6dwCmok2Q3xwMwwyd8B9VWHBmKdTaoGpy9D75ShtuPrIAEX5_NL_PSQUu_QU8c_QRHBEpDHpxBs53hU_Ah-GnCw9cF1', '1083091688386987', '', 0, 0, '', '', '0000-00-00');
INSERT INTO `users` VALUES(193, '55bdc0021acac7.15858400', 'xxx', 'xxc', 'vxxxc@gmail.com', NULL, 'no', '48Yxi8FErkOI2N5eAFK6YQ3dd35hNTUyYWFhM2Q5', 'a552aaa3d9', '2015-08-02 00:00:18', '78.3499698', '17.4459291', '10.42.0.62', 'Hyderabad', '864587023821250', 'e', '', 'dlyMP-bEqbw:APA91bE5hOwaFbBlA0tKYdEyismAfKMMxOyNgqew1ZBfi2LZx6dwCmok2Q3xwMwwyd8B9VWHBmKdTaoGpy9D75ShtuPrIAEX5_NL_PSQUu_QU8c_QRHBEpDHpxBs53hU_Ah-GnCw9cF1', '', '', 0, 0, '', '', '0000-00-00');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `banktransfer`
--
ALTER TABLE `banktransfer`
  ADD CONSTRAINT `banktransfer_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `category`
--
ALTER TABLE `category`
  ADD CONSTRAINT `category_ibfk_1` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`restaurant_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `checkin`
--
ALTER TABLE `checkin`
  ADD CONSTRAINT `checkin_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `checkin_ibfk_2` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`restaurant_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `extras`
--
ALTER TABLE `extras`
  ADD CONSTRAINT `extras_ibfk_1` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`restaurant_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `facebook_friends`
--
ALTER TABLE `facebook_friends`
  ADD CONSTRAINT `facebook_friends_ibfk_1` FOREIGN KEY (`facebook_id`) REFERENCES `users` (`special_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `favourites`
--
ALTER TABLE `favourites`
  ADD CONSTRAINT `favourites_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `favourites_ibfk_2` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`restaurant_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mobilerecharge`
--
ALTER TABLE `mobilerecharge`
  ADD CONSTRAINT `mobilerecharge_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orderItems`
--
ALTER TABLE `orderItems`
  ADD CONSTRAINT `orderItems_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orderItems_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`restaurant_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `percentage_scheme`
--
ALTER TABLE `percentage_scheme`
  ADD CONSTRAINT `percentage_scheme_ibfk_1` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`restaurant_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`restaurant_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`restaurant_id`) ON DELETE CASCADE ON UPDATE CASCADE;
