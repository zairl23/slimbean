-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2014 年 12 月 15 日 08:54
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
  `is_completed` tinyint(1) NOT NULL DEFAULT '0' COMMENT '当前工序是否完成',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `order_type` int(11) NOT NULL DEFAULT '1' COMMENT '订单类型',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `order`
--

INSERT INTO `order` (`id`, `order_number`, `name`, `costumer_name`, `qrcode_path`, `status`, `is_completed`, `created_at`, `updated_at`, `order_type`) VALUES
(1, '111', '订单1', '客户1', '/special/showOrder/1', '9', 0, 1418621035, 1418628791, 1),
(2, '124', '产品名称-2', '客户-3', '/special/showOrder/2', '0', 1, 1418628926, 1418629437, 1),
(3, '125', '产品6', '客户名称-2', '/special/showOrder/3', '1', 1, 1418629467, 1418629981, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='订单记录表' AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `orderlog`
--

INSERT INTO `orderlog` (`id`, `process_id`, `order_id`, `is_completed`, `is_waibao`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2, 0, 1418623360, 0),
(2, 3, 1, 2, 0, 1418625172, 0),
(3, 5, 1, 2, 0, 1418625661, 0),
(4, 7, 1, 1, 0, 1418625998, 0),
(5, 7, 1, 2, 1, 1418628462, 0),
(6, 9, 1, 1, 0, 1418628791, 0),
(7, 1, 3, 2, 0, 1418629593, 0),
(8, 1, 3, 2, 1, 1418629878, 0);

-- --------------------------------------------------------

--
-- 表的结构 `process`
--

CREATE TABLE IF NOT EXISTS `process` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=21 ;

--
-- 转存表中的数据 `process`
--

INSERT INTO `process` (`id`, `pid`, `name`, `type`) VALUES
(1, 0, '工序1', 0),
(2, 1, '工序1发外', 1),
(3, 0, '工序2', 0),
(4, 3, '工序2发外', 1),
(5, 0, '工序3', 0),
(6, 5, '工序3发外', 1),
(7, 0, '工序4', 0),
(8, 7, '工序4发外', 1),
(9, 0, '工序5', 0),
(10, 9, '工序5发外', 1),
(11, 0, '工序6', 0),
(12, 11, '工序6发外', 1),
(13, 0, '工序7', 0),
(14, 13, '工序7发外', 1),
(15, 0, '工序8', 0),
(16, 15, '工序8发外', 1),
(17, 0, '工序9', 0),
(18, 17, '工序9发外', 1),
(19, 0, '工序10', 0),
(20, 19, '工序10发外', 1);

-- --------------------------------------------------------

--
-- 表的结构 `type`
--

CREATE TABLE IF NOT EXISTS `type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `process_ids` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '工序列',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='订单类型' AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `type`
--

INSERT INTO `type` (`id`, `name`, `process_ids`) VALUES
(1, '默认工序流程', '0,1,3,5,7,9,11,15,17,19');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=20 ;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `process_id`, `name`, `password`, `type`) VALUES
(1, 0, 'admin', '123456', 1),
(2, 0, '入单', '123456', 2),
(3, 1, '员工1', '123456', 0),
(4, 3, '员工2', '123456', 0),
(5, 5, '员工3', '123456', 0),
(6, 7, '员工4', '123456', 0),
(7, 9, '员工5', '123456', 0),
(8, 11, '员工6', '123456', 0),
(9, 13, '员工7', '123456', 0),
(10, 15, '员工8', '123456', 0),
(11, 17, '员工9', '123456', 0),
(12, 19, '员工10', '123456', 0),
(13, 2, '员工1发外', '123456', 3),
(14, 4, '员工2发外', '123456', 3),
(15, 6, '员工3发外', '123456', 3),
(16, 8, '员工4发外', '123456', 3),
(17, 10, '员工5发外', '123456', 3),
(18, 12, '员工6发外', '123456', 3),
(19, 14, '员工7发外', '123456', 3);
