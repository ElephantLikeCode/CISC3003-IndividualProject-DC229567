-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2024-05-06 13:02:11
-- 服务器版本： 8.0.35
-- PHP 版本： 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `food-order`
--
CREATE DATABASE IF NOT EXISTS `food-order` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `food-order`;

-- --------------------------------------------------------

--
-- 表的结构 `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id` int UNSIGNED NOT NULL,
  `full_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `tbl_admin`
--

INSERT INTO `tbl_admin` (`id`, `full_name`, `username`, `password`) VALUES
(1, 'Admin', 'admin05', '5d793fc5b00a2348c3fb9ab59e5ca98a'),
(9, 'Elephant', 'elephant', '21232f297a57a5a743894a0e4a801fc3'),
(13, 'Figure01', 'f01', '827ccb0eea8a706c4c34a16891f84e7b'),
(14, 'ad', 'admin', '827ccb0eea8a706c4c34a16891f84e7b');

-- --------------------------------------------------------

--
-- 表的结构 `tbl_category`
--

CREATE TABLE `tbl_category` (
  `id` int UNSIGNED NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `image_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `featured` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `active` varchar(10) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `tbl_category`
--

INSERT INTO `tbl_category` (`id`, `title`, `image_name`, `featured`, `active`) VALUES
(5, 'Burger', 'Food_Category_326.jpg', 'Yes', 'Yes'),
(7, 'Momo', 'Food_Category_504.jpg', 'Yes', 'Yes'),
(12, 'Delicious', 'Food_Category_431.jpg', 'No', 'Yes'),
(19, 'Pizza', 'Food_Category_526.jpg', 'Yes', 'Yes');

-- --------------------------------------------------------

--
-- 表的结构 `tbl_food`
--

CREATE TABLE `tbl_food` (
  `id` int UNSIGNED NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `category_id` int UNSIGNED NOT NULL,
  `featured` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `active` varchar(10) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `tbl_food`
--

INSERT INTO `tbl_food` (`id`, `title`, `description`, `price`, `image_name`, `category_id`, `featured`, `active`) VALUES
(5, 'Smoky Sausage Pizza', 'Yummy pizza!', 50.00, 'Food-Name-1776.jpg', 1, 'Yes', 'Yes'),
(6, 'Dumping', 'Best dumping in the world!', 32.00, 'Food-Name-3129.jpg', 7, 'Yes', 'Yes'),
(7, 'Fried Dumping', 'This is another type of dumping', 30.00, 'Food-Name-1799.jpg', 7, 'No', 'Yes'),
(10, 'Cheese Burger', 'A chadar cheese', 45.00, 'Food-Name-9904.jpg', 5, 'Yes', 'Yes');

-- --------------------------------------------------------

--
-- 表的结构 `tbl_order`
--

CREATE TABLE `tbl_order` (
  `id` int UNSIGNED NOT NULL,
  `food` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `price` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `qty` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `order_date` datetime NOT NULL,
  `status` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `customer_name` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `customer_contact` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `customer_email` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `customer_address` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `tbl_order`
--

INSERT INTO `tbl_order` (`id`, `food`, `price`, `qty`, `total`, `order_date`, `status`, `customer_name`, `customer_contact`, `customer_email`, `customer_address`) VALUES
(2, 'Yummy Burger', '50.00', '1', 50.00, '2024-05-06 12:03:29', 'Deliveried', 'SUN SHENGHE', '15375212', '123@admin.com', 'Town'),
(3, 'Dumping', '32.00', '4', 128.00, '2024-05-06 12:05:24', 'Cancelled', 'Elephant', '54654561', '123@admin.com', 'Street'),
(4, 'Smoky Sausage Pizza', '50.00', '20', 1000.00, '2024-05-06 12:23:04', 'Ordered', 'Elephant', '54654561', '123@admin.com', 'Street'),
(5, 'Smoky Sausage Pizza', '50.00', '10', 500.00, '2024-05-06 12:55:09', 'Ordered', 'Elephant', '12345678', 'hi@test.com', 'Test City');

--
-- 转储表的索引
--

--
-- 表的索引 `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `tbl_food`
--
ALTER TABLE `tbl_food`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- 使用表AUTO_INCREMENT `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- 使用表AUTO_INCREMENT `tbl_food`
--
ALTER TABLE `tbl_food`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- 使用表AUTO_INCREMENT `tbl_order`
--
ALTER TABLE `tbl_order`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
