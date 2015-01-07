-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2015 年 01 月 07 日 09:24
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
-- 表的结构 `connect`
--

CREATE TABLE IF NOT EXISTS `connect` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `follow_id` int(11) NOT NULL,
  `desc` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=41 ;

--
-- 转存表中的数据 `connect`
--

INSERT INTO `connect` (`id`, `role_id`, `follow_id`, `desc`) VALUES
(1, 1, 2, '销售员到审计员:文件，合同，订单，客户样'),
(2, 2, 4, '审计员到制作主管:送客户样,通知文件处理'),
(3, 2, 5, '审计员到仓库主管:询料'),
(4, 5, 3, '仓库主管到工艺下单员:有库存(注明)无库存通知'),
(5, 3, 4, '工艺下单员到制作主管:客户样，数码样，通知排版，申完工艺'),
(6, 3, 10, '工艺下单员到采购员:通知备料'),
(7, 3, 11, '工艺下单员到质量经理:数码样'),
(8, 3, 15, '工艺下单员到调度员:下单完成'),
(9, 3, 16, '工艺下单员到外协员:通知外协员，打印工艺样'),
(10, 16, 15, '外协员到调度员:工艺样'),
(11, 11, 3, '质量经理到工艺下单员:确认质量标准'),
(12, 11, 15, '质量经理到调度员:通知物料检查完成'),
(13, 10, 13, '采购员到总经办经理:采购物料审计'),
(14, 13, 14, '总经办经理到财务:审核盖章'),
(15, 4, 6, '制作主管到制作员:客户样，通知处理文件'),
(16, 6, 9, '制作员到检查员:通知检查文件'),
(17, 7, 3, '数码部到工艺下单员:数码样完成'),
(18, 4, 8, '制作主管到排版员:客户样，数码样，拼版'),
(19, 8, 9, '排版员到检查员:客户样数码样拼版完成'),
(20, 9, 7, '检查员到数码部:检查完成'),
(21, 4, 15, '制作主管到调度员:通知文件处理检查完成'),
(22, 15, 23, '调度员到版房:通知晒版'),
(23, 10, 12, '采购到入库'),
(24, 12, 15, '入库到调度：备料完成'),
(25, 15, 17, '调度到胶印主管:通知印刷'),
(26, 17, 16, '胶印到外协:通知发外'),
(27, 16, 4, '外协到质量经理:通知检查'),
(28, 11, 19, '质量经理到品检员:安排品检'),
(29, 19, 20, '品检员到装订部'),
(30, 23, 17, '版房到胶印主管:晒版完成'),
(31, 17, 18, '胶印主管到机长:安排印刷'),
(32, 18, 11, '机长到质量经理:通知品检'),
(33, 20, 11, '装订到品质量经理:通知成品检查'),
(34, 19, 21, '品检员到仓库出货员:出货'),
(35, 21, 2, '仓库出货员到审计员:送货回单'),
(36, 21, 22, '仓库出货员到司机：安排送货'),
(37, 22, 21, '司机到仓库出货员:送货回单'),
(38, 2, 1, '审计员到销售员:送货回单'),
(39, 2, 3, '审计员到工艺下单员:工价审计完成，订单审核完成'),
(40, 9, 15, '检查员到调度员:通知文件处理检查完成');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=15 ;

--
-- 转存表中的数据 `order`
--

INSERT INTO `order` (`id`, `order_number`, `name`, `costumer_name`, `qrcode_path`, `status`, `is_completed`, `created_at`, `updated_at`, `order_type`) VALUES
(11, '321', '小学教材印刷', '新华小学', '/special/showOrder/11', '0', 1, 1420528766, 1420528766, 1),
(12, '333', '天下足球体育杂志', '武汉卓尔足球', '/special/showOrder/12', '0', 1, 1420615275, 1420615275, 1),
(13, '555', '美丽画册', '湖北美术学院', '/special/showOrder/13', '0', 1, 1420615492, 1420615492, 1),
(14, '111', '百度公司年历', '百度', '/special/showOrder/14', '0', 1, 1420618680, 1420618680, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='订单记录表' AUTO_INCREMENT=12 ;

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
(8, 1, 3, 2, 1, 1418629878, 0),
(9, 3, 3, 2, 0, 1418634100, 0),
(10, 5, 3, 2, 0, 1418634733, 0),
(11, 1, 2, 1, 0, 1419243767, 0);

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
-- 表的结构 `record`
--

CREATE TABLE IF NOT EXISTS `record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `connect_id` int(11) NOT NULL,
  `to_id` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  `ended_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=25 ;

--
-- 转存表中的数据 `record`
--

INSERT INTO `record` (`id`, `order_id`, `connect_id`, `to_id`, `created_at`, `ended_at`) VALUES
(9, 11, 2, 4, 1420531166, 1420535767),
(10, 11, 3, 5, 1420531186, 1420531463),
(11, 11, 39, 3, 1420531192, 0),
(14, 11, 4, 3, 1420534452, 0),
(15, 11, 15, 6, 1420535767, 1420607358),
(16, 11, 18, 8, 1420535829, 1420607630),
(17, 11, 16, 9, 1420607358, 1420608480),
(18, 11, 19, 9, 1420607630, 1420608480),
(19, 11, 40, 15, 1420608480, 0),
(20, 11, 20, 7, 1420608945, 1420609561),
(21, 11, 17, 3, 1420609561, 0),
(22, 13, 2, 4, 1420615552, 0),
(23, 13, 3, 5, 1420615581, 0),
(24, 14, 39, 3, 1420618965, 0);

-- --------------------------------------------------------

--
-- 表的结构 `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=24 ;

--
-- 转存表中的数据 `role`
--

INSERT INTO `role` (`id`, `name`) VALUES
(1, '销售员'),
(2, '审计员'),
(3, '工艺下单员'),
(4, '制作主管'),
(5, '仓库主管'),
(6, '制作员'),
(7, '数码部'),
(8, '排版员'),
(9, '检查员'),
(10, '采购员'),
(11, '质量经理'),
(12, '入库员'),
(13, '总经办经理'),
(14, '财务'),
(15, '调度员'),
(16, '外协员'),
(17, '胶印主管'),
(18, '机长'),
(19, '品检员'),
(20, '装订部'),
(21, '仓库出货员'),
(22, '司机'),
(23, '版房');

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
  `role_id` int(11) NOT NULL COMMENT '角色id',
  `process_id` int(11) NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=31 ;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `role_id`, `process_id`, `name`, `password`, `type`) VALUES
(1, 0, 0, 'admin', '123456', 1),
(2, 0, 0, '入单', '123456', 2),
(3, 9, 0, '员工1', '123456', 0),
(4, 0, 3, '员工2', '123456', 0),
(5, 0, 5, '员工3', '123456', 0),
(6, 0, 7, '员工4', '123456', 0),
(7, 0, 9, '员工5', '123456', 0),
(8, 0, 11, '员工6', '123456', 0),
(9, 0, 13, '员工7', '123456', 0),
(10, 0, 15, '员工8', '123456', 0),
(11, 0, 17, '员工9', '123456', 0),
(12, 0, 19, '员工10', '123456', 0),
(13, 0, 2, '员工1发外', '123456', 3),
(14, 0, 4, '员工2发外', '123456', 3),
(15, 0, 6, '员工3发外', '123456', 3),
(16, 0, 8, '员工4发外', '123456', 3),
(17, 0, 10, '员工5发外', '123456', 3),
(18, 0, 12, '员工6发外', '123456', 3),
(19, 0, 14, '员工7发外', '123456', 3),
(20, 18, 0, '张三', '123456', 0),
(21, 2, 0, '刘强', '123456', 2),
(22, 5, 0, '仓库主管', '123456', 0),
(23, 2, 0, '审计员', '123456', 2),
(24, 4, 0, '制作主管', '123456', 0),
(25, 6, 0, '制作员', '123456', 0),
(26, 8, 0, '排版员', '123456', 0),
(27, 9, 0, '检查员', '123456', 0),
(28, 3, 0, '工艺下单员', '123456', 0),
(29, 7, 0, '数码部', '123456', 0),
(30, 2, 0, '审计员', '123456', 2);
