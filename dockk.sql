-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2014 年 12 月 03 日 05:39
-- 服务器版本: 5.5.8
-- PHP 版本: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `dockk`
--

-- --------------------------------------------------------

--
-- 表的结构 `order`
--

CREATE TABLE IF NOT EXISTS `order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_number` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `costumer_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `qrcode_path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` char(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `order`
--

INSERT INTO `order` (`id`, `order_number`, `name`, `costumer_name`, `qrcode_path`, `status`, `created_at`, `updated_at`) VALUES
(1, '123', '订单1', '客户1', '/special/showOrder/1', '2', 1417566760, 1417579296);

-- --------------------------------------------------------

--
-- 表的结构 `orderlog`
--

CREATE TABLE IF NOT EXISTS `orderlog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `process_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `is_completed` tinyint(2) NOT NULL,
  `is_waibao` tinyint(2) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='订单记录表' AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `orderlog`
--

INSERT INTO `orderlog` (`id`, `process_id`, `order_id`, `is_completed`, `is_waibao`, `created_at`, `updated_at`) VALUES
(7, 1, 1, 2, 0, 1417574013, 0),
(8, 1, 1, 2, 1, 1417574055, 0),
(9, 2, 1, 1, 0, 1417578972, 0),
(10, 2, 1, 1, 1, 1417579296, 0);

-- --------------------------------------------------------

--
-- 表的结构 `process`
--

CREATE TABLE IF NOT EXISTS `process` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=12 ;

--
-- 转存表中的数据 `process`
--

INSERT INTO `process` (`id`, `name`) VALUES
(1, '工序1'),
(2, '工序2'),
(3, '工序3'),
(4, '工序4'),
(5, '工序5'),
(6, '工序6'),
(7, '工序7'),
(8, '工序8'),
(9, '工序9'),
(10, '工序10'),
(11, '工序11');

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `process_id` int(11) NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=15 ;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `process_id`, `name`, `password`, `type`) VALUES
(1, 0, 'admin', '123456', 1),
(2, 0, '入单', '123456', 2),
(3, 0, '外包', '123456', 3),
(4, 1, '员工1', '123456', 0),
(5, 2, '员工2', '123456', 0),
(6, 3, '员工3', '123456', 0),
(7, 4, '员工4', '123456', 0),
(8, 5, '员工5', '123456', 0),
(9, 6, '员工6', '123456', 0),
(10, 7, '员工7', '123456', 0),
(11, 8, '员工8', '123456', 0),
(12, 9, '员工9', '123456', 0),
(13, 10, '员工10', '123456', 0),
(14, 11, '员工11', '123456', 0);
