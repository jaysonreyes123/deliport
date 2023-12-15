-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 04, 2023 at 05:17 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `deliport_db`
--
CREATE DATABASE IF NOT EXISTS `deliport_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `deliport_db`;

-- --------------------------------------------------------

--
-- Table structure for table `cart_list`
--

CREATE TABLE `cart_list` (
  `id` int(30) NOT NULL,
  `client_id` int(30) NOT NULL,
  `product_id` int(30) NOT NULL,
  `quantity` float NOT NULL DEFAULT '0',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cart_list`
--

INSERT INTO `cart_list` (`id`, `client_id`, `product_id`, `quantity`, `date_created`) VALUES
(73, 10, 24, 6, '2023-12-04 16:07:51');

-- --------------------------------------------------------

--
-- Table structure for table `category_list`
--

CREATE TABLE `category_list` (
  `id` int(30) NOT NULL,
  `vendor_id` int(30) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `delete_flag` tinyint(1) NOT NULL DEFAULT '0',
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category_list`
--

INSERT INTO `category_list` (`id`, `vendor_id`, `name`, `description`, `status`, `delete_flag`, `date_created`, `date_updated`) VALUES
(10, 1, 'Delicacy', 'Delicacy', 1, 1, '2023-06-18 15:53:14', '2023-06-29 08:01:21'),
(11, 4, 'Supplies', 'Natural Cooking Supplies', 1, 0, '2023-06-18 16:47:24', NULL),
(12, 5, 'Delicacy', 'Delicacy', 1, 0, '2023-06-19 13:12:10', NULL),
(13, 5, 'Puto', 'Puto', 1, 1, '2023-06-19 13:31:18', '2023-06-29 08:00:17'),
(14, 1, 'Puto', 'Puto', 0, 0, '2023-06-19 13:32:08', '2023-06-29 10:57:05'),
(15, 6, 'test', 'test', 1, 0, '2023-11-28 14:40:09', NULL),
(17, 14, 'test', 'test', 1, 0, '2023-12-03 23:49:44', NULL),
(18, 14, 'test2', 'test', 1, 0, '2023-12-04 14:24:47', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `client_list`
--

CREATE TABLE `client_list` (
  `id` int(30) NOT NULL,
  `code` varchar(100) NOT NULL,
  `firstname` text NOT NULL,
  `middlename` text,
  `lastname` text NOT NULL,
  `gender` text NOT NULL,
  `contact` text NOT NULL,
  `address` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `avatar` text,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `delete_flag` tinyint(1) NOT NULL DEFAULT '0',
  `house_no` varchar(200) NOT NULL,
  `street` varchar(200) NOT NULL,
  `barangay` varchar(200) NOT NULL,
  `municipality` varchar(200) NOT NULL,
  `province` varchar(200) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `email_verification_status` enum('Pending','Verified') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `client_list`
--

INSERT INTO `client_list` (`id`, `code`, `firstname`, `middlename`, `lastname`, `gender`, `contact`, `address`, `email`, `password`, `avatar`, `status`, `delete_flag`, `house_no`, `street`, `barangay`, `municipality`, `province`, `date_created`, `date_updated`, `email_verification_status`) VALUES
(1, '202202-00001', 'John', 'D', 'Smith', 'Male', '09123456789', 'This is only my sample address', 'jsmith@sample.com', '1254737c076cf867dc53d60a0364f38e', 'uploads/clients/1.png?v=1687144991', 1, 0, '', '', '', '', '', '2022-02-09 13:53:36', '2023-06-19 11:23:11', 'Pending'),
(9, '202306-00001', 'Chan', 'Casuapanan', 'Angeles', 'Male', '09305105718', '028 Binunga St. Duale, Limay, Bataan', 'chanangeles13@gmail.com', '26c322652770620e64ac90682eb6504c', 'uploads/clients/9.png?v=1687151166', 1, 0, '', '', '', '', '', '2023-06-19 13:06:06', '2023-06-19 13:06:06', 'Pending'),
(10, '202311-00001', 'Marvin', '', 'Peña', 'Male', '45454645', 'dssada', 'marvinpena03151996@gmail.com', '25d55ad283aa400af464c76d713c07ad', NULL, 1, 0, '', '', '', '', '', '2023-11-28 14:43:46', '2023-12-03 22:50:54', 'Pending'),
(11, '202312-00001', 'asd', 'asd', 'asd', 'Male', 'asd', 'asd', 'asd@gmail.com', '7815696ecbf1c96e6894b779456d330e', 'uploads/clients/11.png?v=1701576083', 1, 0, '', '', '', '', '', '2023-12-03 12:01:22', '2023-12-03 12:01:23', 'Pending'),
(12, '202312-00002', 'Mercedes', 'Kaden Martinez', 'Sanchez', 'Male', 'Est sed magnam liber', '', 'xapawidetu@mailinator.com', '202cb962ac59075b964b07152d234b70', 'uploads/clients/12.png?v=1701612771', 1, 0, 'Soluta voluptate ali', 'Tempor est nostrum a', 'Officiis et nihil hi', 'Temporibus sunt est ', 'Voluptatibus eu aut ', '2023-12-03 22:12:50', '2023-12-03 22:12:51', 'Pending'),
(13, '202312-00003', 'Lavinia', 'Clementine Henry', 'Chavez', 'Female', 'Sunt laboris non inv', '', 'votuto@mailinator.com', 'f3ed11bbdb94fd9ebdefbaf646ab94d3', NULL, 0, 0, 'Voluptatem voluptate', 'Autem reiciendis qua', 'Odio nulla eum aut c', 'Nisi sequi eaque vol', 'Nostrum ea consequat', '2023-12-03 22:57:15', NULL, 'Pending'),
(14, '202312-00004', 'Julian', 'Cameran Santiago', 'Pearson', 'Male', 'Qui molestias animi', '', 'qyxisi@mailinator.com', 'f3ed11bbdb94fd9ebdefbaf646ab94d3', NULL, 0, 0, 'Nulla est aut sunt', 'Facilis quia et inci', 'Mollit corporis temp', 'Maiores ea impedit ', 'Debitis neque quis v', '2023-12-03 22:58:02', NULL, 'Pending'),
(15, '202312-00005', 'Rhoda', 'Caesar Norton', 'Goodwin', 'Female', 'Modi nulla quis aspe', '', 'fyxizu@mailinator.com', 'f3ed11bbdb94fd9ebdefbaf646ab94d3', NULL, 0, 0, 'Non amet voluptatem', 'Suscipit et incididu', 'Repudiandae occaecat', 'Itaque et sapiente i', 'Ea exercitation in q', '2023-12-03 22:58:36', NULL, 'Pending'),
(17, '202312-00007', 'Jessica', 'Alice Woodard', 'Fernandez', 'Female', 'Laboris provident i', '', 'jabisowob@mailinator.com', 'f3ed11bbdb94fd9ebdefbaf646ab94d3', NULL, 0, 0, 'Aute natus minim asp', 'Adipisci nisi volupt', 'Quod quo ipsum labor', 'Proident debitis ut', 'Aliqua Reprehenderi', '2023-12-03 23:01:41', NULL, 'Pending'),
(30, '202312-00006', 'Ila', 'Herman Kim', 'Franklin', 'Female', 'Sint eum repellendu', '', 'jaysonreyes012345@gmail.com', 'f3ed11bbdb94fd9ebdefbaf646ab94d3', 'uploads/clients/30.png?v=1701658120', 0, 0, 'Delectus quia volup', 'Architecto sit volup', 'Voluptates tempora e', 'Rerum iusto qui expl', 'Aliquip possimus do', '2023-12-04 10:48:37', '2023-12-04 10:48:40', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`id`, `order_id`, `product_id`, `client_id`, `vendor_id`, `status`, `is_read`, `date_created`) VALUES
(4, 88, 21, 10, 14, 0, 1, '2023-12-03 17:18:16'),
(5, 88, 21, 10, 14, 3, 1, '2023-12-03 17:25:01');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_id` int(30) NOT NULL,
  `product_id` int(30) NOT NULL,
  `quantity` double NOT NULL DEFAULT '0',
  `price` double NOT NULL DEFAULT '0',
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_id`, `product_id`, `quantity`, `price`, `date_created`) VALUES
(89, 24, 17, 12, '2023-12-05 00:06:18');

-- --------------------------------------------------------

--
-- Table structure for table `order_list`
--

CREATE TABLE `order_list` (
  `id` int(30) NOT NULL,
  `code` varchar(100) NOT NULL,
  `client_id` int(30) NOT NULL,
  `vendor_id` int(30) NOT NULL,
  `total_amount` double NOT NULL DEFAULT '0',
  `delivery_address` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `option` text NOT NULL,
  `rate` decimal(5,1) NOT NULL,
  `feedback` text NOT NULL,
  `deliverydate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_list`
--

INSERT INTO `order_list` (`id`, `code`, `client_id`, `vendor_id`, `total_amount`, `delivery_address`, `status`, `date_created`, `date_updated`, `option`, `rate`, `feedback`, `deliverydate`) VALUES
(69, '202311-00001', 10, 5, 20, 'sda', 0, '2023-11-29 12:40:57', '2023-11-29 12:40:57', '', '0.0', '', NULL),
(70, '202311-00002', 10, 6, 12, 'asdas', 3, '2023-11-29 12:43:36', '2023-11-29 14:01:35', '', '0.0', '', NULL),
(71, '202311-00003', 10, 1, 50, 'adasd,', 0, '2023-11-29 13:32:27', '2023-11-29 13:32:27', '', '0.0', '', NULL),
(72, '202311-00004', 10, 5, 20, 'asd,', 0, '2023-11-29 13:32:51', '2023-11-29 13:32:51', '{()}', '0.0', '', NULL),
(73, '202311-00005', 10, 5, 20, 'sad,', 0, '2023-11-29 13:34:28', '2023-11-29 13:34:28', '', '0.0', '', NULL),
(77, '202311-00006', 10, 4, 20, '', 0, '2023-11-29 13:41:56', '2023-11-29 13:41:56', 'asd', '0.0', '', NULL),
(78, '202311-00007', 10, 5, 50, 'zxzx', 0, '2023-11-29 13:42:36', '2023-11-29 13:42:36', '', '0.0', '', NULL),
(79, '202311-00008', 10, 1, 50, 'asdasd', 0, '2023-11-29 13:43:32', '2023-11-29 13:43:32', '', '0.0', '', NULL),
(80, '202311-00009', 10, 4, 50, 'dssada', 0, '2023-11-29 13:47:29', '2023-11-29 13:47:29', 'asda', '0.0', '', NULL),
(81, '202311-00010', 10, 1, 50, 'dssada', 0, '2023-11-29 13:48:14', '2023-11-29 13:48:14', '', '0.0', '', NULL),
(82, '202311-00011', 10, 5, 20, 'zz', 0, '2023-11-29 13:48:47', '2023-11-29 13:48:47', 'delivery', '0.0', '', NULL),
(83, '202311-00012', 10, 4, 20, 'dssada', 0, '2023-11-29 13:51:08', '2023-11-29 13:51:08', 'pick', '0.0', '', '0000-00-00 00:00:00'),
(84, '202311-00013', 10, 4, 20, 'marvin', 0, '2023-11-29 13:51:49', '2023-11-29 13:51:49', 'pick', '0.0', '', '2023-11-29 13:54:00'),
(85, '202311-00014', 10, 5, 50, 'batangas', 0, '2023-11-29 14:54:00', '2023-11-29 14:54:00', 'delivery', '0.0', '', '2023-11-30 18:53:00'),
(87, '202312-00001', 10, 14, 5, 'dssada', 3, '2023-12-03 23:50:48', '2023-12-04 00:56:49', 'delivery', '5.0', 'qweqwe', '2023-12-04 23:50:00'),
(88, '202312-00002', 10, 14, 5, 'dssada', 3, '2023-12-04 01:10:40', '2023-12-04 01:25:01', 'delivery', '0.0', '', '2023-12-04 01:10:00'),
(89, '202312-00003', 10, 14, 204, 'dssada', 0, '2023-12-05 00:06:18', '2023-12-05 00:06:18', 'delivery', '0.0', '', '2023-12-05 00:06:00');

-- --------------------------------------------------------

--
-- Table structure for table `product_list`
--

CREATE TABLE `product_list` (
  `id` int(30) NOT NULL,
  `vendor_id` int(30) DEFAULT NULL,
  `category_id` int(30) DEFAULT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `price` double NOT NULL DEFAULT '0',
  `image_path` text,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `delete_flag` tinyint(1) NOT NULL DEFAULT '0',
  `limit_per_day` int(11) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_list`
--

INSERT INTO `product_list` (`id`, `vendor_id`, `category_id`, `name`, `description`, `price`, `image_path`, `status`, `delete_flag`, `limit_per_day`, `supplier_id`, `date_created`, `date_updated`) VALUES
(11, 1, 14, 'Mini Bibingka', 'abc', 15, 'uploads/products/11.png?v=1687074848', 1, 0, NULL, NULL, '2023-06-18 15:54:08', '2023-11-28 06:21:15'),
(12, 4, 11, 'Coconut Milk', 'Fresh Coconut Milk', 20, 'uploads/products/12.png?v=1687080847', 1, 0, NULL, NULL, '2023-06-18 16:50:12', '2023-06-18 17:34:07'),
(13, 1, 10, 'Puto', '&lt;p&gt;Colorful Puto with Feelings&lt;/p&gt;', 50, 'uploads/products/13.png?v=1687101924', 1, 0, NULL, NULL, '2023-06-18 23:25:24', '2023-06-18 23:25:24'),
(14, 4, 11, 'Glutinous Rice', '&lt;p&gt;Bigas na Malagkit&lt;/p&gt;', 50, 'uploads/products/14.png?v=1687102224', 1, 0, NULL, NULL, '2023-06-18 23:30:24', '2023-06-18 23:30:24'),
(15, 5, 12, 'Sapin Sapin', '&lt;p&gt;Sapin Sapin&lt;/p&gt;', 100, 'uploads/products/15.png?v=1687151573', 1, 0, NULL, NULL, '2023-06-19 13:12:53', '2023-06-19 13:12:53'),
(16, 5, 13, 'Puto', '&lt;p&gt;Puto&lt;/p&gt;', 20, 'uploads/products/16.png?v=1687152538', 1, 0, NULL, NULL, '2023-06-19 13:28:58', '2023-06-19 13:31:34'),
(17, 5, 12, 'Kutsinta', '&lt;p&gt;Kutsinta with niyog.&lt;/p&gt;', 50, 'uploads/products/17.png?v=1688002753', 1, 0, NULL, NULL, '2023-06-29 09:39:13', '2023-06-29 09:39:13'),
(18, 6, 15, 'q', '&lt;p&gt;64&lt;/p&gt;', 12, NULL, 1, 0, NULL, NULL, '2023-11-28 14:47:15', NULL),
(24, 14, 17, 'test', '&lt;p&gt;12&lt;/p&gt;', 12, 'uploads/products/24.png?v=1701699293', 1, 0, 5, NULL, '2023-12-04 22:14:53', '2023-12-04 23:46:14');

-- --------------------------------------------------------

--
-- Table structure for table `request_info`
--

CREATE TABLE `request_info` (
  `id` int(11) NOT NULL,
  `seller_id` int(11) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `request` text NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `request_info`
--

INSERT INTO `request_info` (`id`, `seller_id`, `supplier_id`, `request`, `date_created`) VALUES
(32, 14, 21, 'test qwe qweqwe jashdkashdkjasd d asd asd a', '2023-12-04 14:43:59'),
(33, 14, 21, 'test 12 testing 2', '2023-12-04 14:44:07');

-- --------------------------------------------------------

--
-- Table structure for table `shop_type_list`
--

CREATE TABLE `shop_type_list` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `delete_flag` tinyint(1) NOT NULL DEFAULT '0',
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `shop_type_list`
--

INSERT INTO `shop_type_list` (`id`, `name`, `status`, `delete_flag`, `date_created`, `date_updated`) VALUES
(6, 'Supplies', 1, 0, '2023-06-18 19:11:14', NULL),
(7, 'Delicacy', 1, 0, '2023-06-18 19:11:25', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `system_info`
--

CREATE TABLE `system_info` (
  `id` int(30) NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `system_info`
--

INSERT INTO `system_info` (`id`, `meta_field`, `meta_value`) VALUES
(1, 'name', 'DeliPort: Native Delicacies Portal Management System with 2D Mapping'),
(6, 'short_name', 'DeliPort'),
(11, 'logo', 'uploads/logo-1687072216.png'),
(13, 'user_avatar', 'uploads/user_avatar.jpg'),
(14, 'cover', 'uploads/cover-1687060926.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(50) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `lastname` varchar(250) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `avatar` text,
  `last_login` datetime DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `password`, `avatar`, `last_login`, `type`, `date_added`, `date_updated`) VALUES
(1, 'Adminstrator', 'Admin', 'admin', '0192023a7bbd73250516f069df18b500', 'uploads/avatar-1.png?v=1687140611', NULL, 1, '2021-01-20 14:02:37', '2023-06-19 10:10:11');

-- --------------------------------------------------------

--
-- Table structure for table `vendor_list`
--

CREATE TABLE `vendor_list` (
  `id` int(30) NOT NULL,
  `code` varchar(100) NOT NULL,
  `shop_type_id` int(30) NOT NULL,
  `shop_name` text NOT NULL,
  `shop_owner` text NOT NULL,
  `contact` text NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `avatar` text,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `delete_flag` tinyint(1) NOT NULL DEFAULT '0',
  `business_permit` text,
  `is_supplier` tinyint(4) NOT NULL DEFAULT '0',
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vendor_list`
--

INSERT INTO `vendor_list` (`id`, `code`, `shop_type_id`, `shop_name`, `shop_owner`, `contact`, `username`, `password`, `avatar`, `status`, `delete_flag`, `business_permit`, `is_supplier`, `date_created`, `date_updated`) VALUES
(1, '202202-00001', 7, 'Shop101', 'Chan D. UK', '09123456788', 'shop101', 'ee6c4d4ba80f29dd389f0deb8863de69', 'uploads/vendors/1.png?v=1687143061', 1, 0, NULL, 0, '2022-02-09 10:50:53', '2023-06-19 10:51:01'),
(4, '202306-00001', 6, 'Cooking Supplies Shop', 'Ally N. Dug', '09486732667', 'Ally', '2ad733df56aaafa5650bafc9c98c6ffb', 'uploads/vendors/4.png?v=1687145184', 1, 0, NULL, 0, '2023-06-18 16:46:48', '2023-06-19 11:26:24'),
(5, '202306-00002', 7, 'Delicacy Shop', 'Allyssa Q. Cruz', '09486732667', 'Dang', 'd6a846dd6216ca644c75d2b798ecf8d2', 'uploads/vendors/5.png?v=1687150803', 1, 0, NULL, 0, '2023-06-19 13:00:03', '2023-06-19 13:11:13'),
(14, '202312-00001', 6, 'Ivan Wise', 'Deirdre Clemons', 'Impedit excepturi s', 'test', '098f6bcd4621d373cade4e832627b4f6', 'uploads/vendors/14.png?v=1701614664', 1, 0, 'uploads/permit/14.png?v=1701614827', 0, '2023-12-03 22:44:24', '2023-12-03 22:48:14'),
(15, '202312-00002', 6, 'Zenaida Clark', 'Hayes Pierce', 'Ut lorem in quaerat ', 'pimubip', 'f3ed11bbdb94fd9ebdefbaf646ab94d3', 'uploads/vendors/15.png?v=1701626168', 0, 0, 'uploads/permit/15.png?v=1701626168', 0, '2023-12-04 01:56:08', '2023-12-04 01:56:08'),
(16, '202312-00003', 6, 'Kyra Rutledge', 'Holmes Odonnell', 'Ducimus ex voluptas', 'tocejym', 'f3ed11bbdb94fd9ebdefbaf646ab94d3', 'uploads/vendors/16.png?v=1701626251', 0, 0, 'uploads/permit/16.png?v=1701626251', 0, '2023-12-04 01:57:31', '2023-12-04 01:57:31'),
(17, '202312-00004', 7, 'Stewart Ellison', 'Edward Burks', 'Occaecat culpa vita', 'qitupeh', 'f3ed11bbdb94fd9ebdefbaf646ab94d3', 'uploads/vendors/17.png?v=1701626265', 0, 0, 'uploads/permit/17.png?v=1701626265', 0, '2023-12-04 01:57:45', '2023-12-04 01:57:45'),
(18, '202312-00005', 6, 'Shay Hess', 'Kirestin Bradshaw', 'Dolor incidunt prov', 'muhuc', 'f3ed11bbdb94fd9ebdefbaf646ab94d3', 'uploads/vendors/18.png?v=1701663086', 0, 0, 'uploads/permit/18.png?v=1701663086', 1, '2023-12-04 12:11:26', '2023-12-04 12:11:26'),
(19, '202312-00006', 7, 'Ariana Henson', 'Zahir Yates', 'Consequat Deleniti ', 'fixicefet', 'f3ed11bbdb94fd9ebdefbaf646ab94d3', 'uploads/vendors/19.png?v=1701663103', 0, 0, 'uploads/permit/19.png?v=1701663103', 0, '2023-12-04 12:11:42', '2023-12-04 12:11:43'),
(20, '202312-00007', 6, 'Orson Mcbride', 'Bethany Welch', 'Omnis dolorum ut in ', 'vuhaxy', 'f3ed11bbdb94fd9ebdefbaf646ab94d3', 'uploads/vendors/20.png?v=1701663117', 1, 0, 'uploads/permit/20.png?v=1701663117', 1, '2023-12-04 12:11:57', '2023-12-04 14:26:07'),
(21, '202312-00008', 7, 'Blythe Hays', 'Cheryl Mayer', 'Ipsum velit aut sap', 'testing', '098f6bcd4621d373cade4e832627b4f6', 'uploads/vendors/21.png?v=1701668558', 1, 0, 'uploads/permit/21.png?v=1701668558', 1, '2023-12-04 13:42:38', '2023-12-04 13:46:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart_list`
--
ALTER TABLE `cart_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `category_list`
--
ALTER TABLE `category_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vendor_id` (`vendor_id`);

--
-- Indexes for table `client_list`
--
ALTER TABLE `client_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `order_list`
--
ALTER TABLE `order_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `vendor_id` (`vendor_id`);

--
-- Indexes for table `product_list`
--
ALTER TABLE `product_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vendor_id` (`vendor_id`),
  ADD KEY `category_id` (`category_id`) USING BTREE;

--
-- Indexes for table `request_info`
--
ALTER TABLE `request_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shop_type_list`
--
ALTER TABLE `shop_type_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_info`
--
ALTER TABLE `system_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendor_list`
--
ALTER TABLE `vendor_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shop_type_id` (`shop_type_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart_list`
--
ALTER TABLE `cart_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;
--
-- AUTO_INCREMENT for table `category_list`
--
ALTER TABLE `category_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `client_list`
--
ALTER TABLE `client_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `order_list`
--
ALTER TABLE `order_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;
--
-- AUTO_INCREMENT for table `product_list`
--
ALTER TABLE `product_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `request_info`
--
ALTER TABLE `request_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `shop_type_list`
--
ALTER TABLE `shop_type_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `system_info`
--
ALTER TABLE `system_info`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `vendor_list`
--
ALTER TABLE `vendor_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart_list`
--
ALTER TABLE `cart_list`
  ADD CONSTRAINT `cart_list_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `client_list` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_list_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product_list` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `category_list`
--
ALTER TABLE `category_list`
  ADD CONSTRAINT `category_list_ibfk_1` FOREIGN KEY (`vendor_id`) REFERENCES `vendor_list` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order_list` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product_list` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_list`
--
ALTER TABLE `order_list`
  ADD CONSTRAINT `order_list_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `client_list` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_list_ibfk_2` FOREIGN KEY (`vendor_id`) REFERENCES `vendor_list` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_list`
--
ALTER TABLE `product_list`
  ADD CONSTRAINT `product_list_ibfk_1` FOREIGN KEY (`vendor_id`) REFERENCES `vendor_list` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `product_list_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category_list` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `vendor_list`
--
ALTER TABLE `vendor_list`
  ADD CONSTRAINT `vendor_list_ibfk_1` FOREIGN KEY (`shop_type_id`) REFERENCES `shop_type_list` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
