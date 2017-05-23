-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Nov 12, 2015 at 01:03 PM
-- Server version: 5.5.42
-- PHP Version: 5.6.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `yipuqu`
--

-- --------------------------------------------------------

--
-- Table structure for table `baojias`
--

CREATE TABLE `baojias` (
  `id` int(11) NOT NULL,
  `baojia_id` varchar(20) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `customer` varchar(100) DEFAULT NULL,
  `total_price` varchar(20) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `tax` varchar(20) DEFAULT NULL,
  `setup_cost` varchar(20) DEFAULT NULL,
  `tour_cost` varchar(20) DEFAULT NULL,
  `creator` varchar(100) DEFAULT NULL,
  `checkor` varchar(100) DEFAULT NULL,
  `create_time` varchar(100) DEFAULT NULL,
  `update_time` varchar(100) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `company_id` varchar(20) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `baojia_detail`
--

CREATE TABLE `baojia_detail` (
  `id` int(11) NOT NULL,
  `detail_name` varchar(100) DEFAULT NULL,
  `brand` varchar(20) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `size` varchar(255) DEFAULT NULL,
  `unit_price` varchar(20) DEFAULT NULL,
  `cost_price` varchar(50) NOT NULL,
  `count` varchar(20) DEFAULT NULL,
  `unit` varchar(10) DEFAULT NULL,
  `total` varchar(20) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `category` varchar(20) DEFAULT NULL,
  `project_id` varchar(20) DEFAULT NULL,
  `project_name` varchar(100) DEFAULT NULL,
  `parent_id` varchar(20) DEFAULT NULL,
  `create_time` varchar(20) DEFAULT NULL,
  `company_id` varchar(20) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `baojia_detail_tmp`
--

CREATE TABLE `baojia_detail_tmp` (
  `id` int(11) NOT NULL,
  `detail_name` varchar(100) DEFAULT NULL,
  `brand` varchar(20) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `size` varchar(255) DEFAULT NULL,
  `unit_price` varchar(20) DEFAULT NULL,
  `cost_price` varchar(50) NOT NULL,
  `count` varchar(20) DEFAULT NULL,
  `unit` varchar(10) DEFAULT NULL,
  `total` varchar(20) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `category` varchar(20) DEFAULT NULL,
  `project_id` varchar(20) DEFAULT NULL,
  `project_name` varchar(100) DEFAULT NULL,
  `parent_id` varchar(20) DEFAULT NULL,
  `create_time` varchar(20) DEFAULT NULL,
  `company_id` varchar(20) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=279 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `company_id` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` int(11) NOT NULL,
  `company_name` varchar(100) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `is_default` int(1) DEFAULT NULL,
  `mingxi_abbre` varchar(10) DEFAULT NULL,
  `baojia_abbre` varchar(10) DEFAULT NULL,
  `baojia_length` int(11) DEFAULT NULL,
  `mingxi_length` int(11) DEFAULT NULL,
  `company_id` varchar(20) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `company_name`, `logo`, `is_default`, `mingxi_abbre`, `baojia_abbre`, `baojia_length`, `mingxi_length`, `company_id`) VALUES
(1, '易普趣', NULL, 1, 'MX', 'YPQ', 5, 5, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `details`
--

CREATE TABLE `details` (
  `id` int(11) NOT NULL,
  `detail_id` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL DEFAULT '',
  `category` varchar(50) NOT NULL,
  `brand` varchar(20) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `unit_price` varchar(20) DEFAULT NULL,
  `cost_price` varchar(50) NOT NULL,
  `size` varchar(255) DEFAULT NULL,
  `unit` varchar(20) DEFAULT NULL,
  `company_id` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `menu_id` varchar(20) NOT NULL,
  `menu_name` varchar(100) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`menu_id`, `menu_name`, `remark`) VALUES
('baojias', '报价管理', '报价管理'),
('details', '明细管理', '明细管理'),
('reports', '报表中心', '报表中心'),
('shenhes', '审核管理', '审核管理'),
('sys_config', '系统设置', '系统设置'),
('sys_index', '系统首页', '系统首页');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `company_id` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(100) NOT NULL,
  `remark` varchar(255) NOT NULL,
  `rights` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`, `remark`, `rights`) VALUES
(1, '超级用户', '有任何权限', 'baojias,details,reports,shenhes,sys_config,sys_index,'),
(2, '管理员', '只能查看系统配置', 'sys_config,'),
(3, '普通用户', '只能报价', 'baojias,');

-- --------------------------------------------------------

--
-- Table structure for table `statuses`
--

CREATE TABLE `statuses` (
  `id` int(11) NOT NULL,
  `status_name` varchar(100) DEFAULT NULL,
  `is_edit` int(1) DEFAULT NULL,
  `is_delete` int(1) DEFAULT NULL,
  `is_export` int(1) DEFAULT NULL,
  `is_refund` int(1) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `statuses`
--

INSERT INTO `statuses` (`id`, `status_name`, `is_edit`, `is_delete`, `is_export`, `is_refund`) VALUES
(1, '未提交', 1, 1, 0, 0),
(2, '待审批', 0, 0, 0, 1),
(3, '未通过', 1, 0, 0, 0),
(4, '已通过', 0, 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `systems`
--

CREATE TABLE `systems` (
  `server_email` varchar(64) DEFAULT NULL,
  `email_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `systems`
--

INSERT INTO `systems` (`server_email`, `email_name`) VALUES
('721_baobao@163.com', 'Jean');

-- --------------------------------------------------------

--
-- Table structure for table `templates`
--

CREATE TABLE `templates` (
  `id` int(11) NOT NULL,
  `template_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `templates`
--

INSERT INTO `templates` (`id`, `template_name`) VALUES
(1, '模板1'),
(2, '模板2'),
(3, '模板3');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) DEFAULT NULL,
  `email` varchar(64) DEFAULT NULL,
  `telephone` varchar(12) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `company_ids` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `telephone`, `role_id`, `company_ids`) VALUES
(1, 'Jean', '21232f297a57a5a743894a0e4a801fc3', '22658481@qq.com', '15312199035', 1, '1'),
(3, 'Rational', 'e99a18c428cb38d5f260853678922e03', 'lizhi0907@163.com', '181364362939', 3, '1'),
(4, 'Administrator', '21232f297a57a5a743894a0e4a801fc3', '721_baobao@163.com', '0512-8766818', 2, '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `baojias`
--
ALTER TABLE `baojias`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `baojia_detail`
--
ALTER TABLE `baojia_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `baojia_detail_tmp`
--
ALTER TABLE `baojia_detail_tmp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `details`
--
ALTER TABLE `details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `templates`
--
ALTER TABLE `templates`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `baojias`
--
ALTER TABLE `baojias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `baojia_detail`
--
ALTER TABLE `baojia_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=77;
--
-- AUTO_INCREMENT for table `baojia_detail_tmp`
--
ALTER TABLE `baojia_detail_tmp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=279;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `details`
--
ALTER TABLE `details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `statuses`
--
ALTER TABLE `statuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `templates`
--
ALTER TABLE `templates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;