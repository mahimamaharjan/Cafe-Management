-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 05, 2018 at 05:23 PM
-- Server version: 5.6.26
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mahimam`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_user`
--

CREATE TABLE IF NOT EXISTS `admin_user` (
  `user_id` int(10) unsigned NOT NULL COMMENT 'User ID',
  `firstname` varchar(32) DEFAULT NULL COMMENT 'User First Name',
  `lastname` varchar(32) DEFAULT NULL COMMENT 'User Last Name',
  `email` varchar(128) DEFAULT NULL COMMENT 'User Email',
  `username` varchar(40) DEFAULT NULL COMMENT 'User Login',
  `password` varchar(255) NOT NULL COMMENT 'User Password',
  `role_admin` enum('admin') NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'User Created Time',
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'User Modified Time',
  `is_active` smallint(6) NOT NULL DEFAULT '1' COMMENT 'User Is Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Admin User Table';

-- --------------------------------------------------------

--
-- Table structure for table `authorization_rule`
--

CREATE TABLE IF NOT EXISTS `authorization_rule` (
  `rule_id` int(10) unsigned NOT NULL COMMENT 'Rule ID',
  `role_code` enum('admin','student') NOT NULL COMMENT 'Role code',
  `resource_id` varchar(255) DEFAULT NULL COMMENT 'Resource ID',
  `permission` varchar(10) DEFAULT NULL COMMENT 'Permission'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Admin Rule Table';

-- --------------------------------------------------------

--
-- Table structure for table `cafes`
--

CREATE TABLE IF NOT EXISTS `cafes` (
  `id` int(10) NOT NULL,
  `name` varchar(255) DEFAULT NULL COMMENT 'name of cafee',
  `logo` varchar(255) DEFAULT NULL COMMENT 'logo path',
  `opening_time` time DEFAULT NULL COMMENT 'opening time of cafee',
  `closing_time` time DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cafes`
--

INSERT INTO `cafes` (`id`, `name`, `logo`, `opening_time`, `closing_time`) VALUES
(2, 'The Ref', NULL, '06:30:00', '20:00:00'),
(3, 'Lazenbys', NULL, '10:00:00', '17:30:00'),
(4, 'Trade Table', NULL, '10:30:00', '18:15:00');

-- --------------------------------------------------------

--
-- Table structure for table `cafe_item`
--

CREATE TABLE IF NOT EXISTS `cafe_item` (
  `id` int(11) NOT NULL,
  `cafe_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cafe_item`
--

INSERT INTO `cafe_item` (`id`, `cafe_id`, `item_id`) VALUES
(9, 3, 3),
(19, 2, 3),
(20, 3, 2),
(23, 3, 4),
(24, 4, 3),
(25, 4, 2),
(26, 4, 6),
(27, 4, 4),
(28, 2, 4),
(29, 3, 6),
(30, 2, 6),
(31, 2, 11),
(32, 2, 9),
(33, 2, 8),
(34, 2, 7),
(35, 2, 10),
(36, 4, 12),
(37, 2, 12),
(38, 2, 14),
(39, 2, 13),
(40, 2, 15),
(41, 2, 16);

-- --------------------------------------------------------

--
-- Table structure for table `cafe_manager`
--

CREATE TABLE IF NOT EXISTS `cafe_manager` (
  `manager_id` int(11) NOT NULL,
  `manager_name` int(11) NOT NULL,
  `cafe_id` int(11) NOT NULL,
  `roles` enum('admin','sales','manager','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` enum('food','beverage') DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `name`, `type`, `price`, `date`) VALUES
(2, 'Fries', 'food', '20.00', '2018-04-30'),
(3, 'Fries', 'food', '30.00', '2018-03-02'),
(4, 'Burger', 'food', '45.00', '2018-04-30'),
(6, 'Juice', 'beverage', '10.00', '2018-04-30'),
(7, 'Sandwich', 'food', '60.00', '2018-05-03'),
(8, 'Tea', 'beverage', '15.00', '2018-05-03'),
(9, 'Coffee', 'beverage', '20.00', '2018-05-03'),
(10, 'Pizza', 'food', '200.00', '2018-05-03'),
(11, 'Lasagna', 'food', '150.00', '2018-05-03'),
(12, 'Burger', 'food', '20.00', '2018-05-05'),
(13, 'Sprite', 'beverage', '10.00', '2018-05-05'),
(14, 'Fanta', 'beverage', '12.00', '2018-05-05'),
(15, 'Toast', 'food', '30.00', '2018-05-05'),
(16, 'Omelette', 'food', '16.00', '2018-05-05');

-- --------------------------------------------------------

--
-- Table structure for table `menu_item`
--

CREATE TABLE IF NOT EXISTS `menu_item` (
  `menu_id` int(11) NOT NULL,
  `menu_name` varchar(255) NOT NULL,
  `cafe_id` int(10) NOT NULL,
  `is_active` int(11) NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `menu_type` enum('indian_breakfast','farmer_breakfast','set_breakfast','coffee','soup','momo','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `cafe_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `collection_time` time DEFAULT NULL,
  `discount_rate` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `date`, `cafe_id`, `user_id`, `collection_time`, `discount_rate`) VALUES
(1, '2018-05-03', 2, 4, '08:30:00', '0.00'),
(2, '2018-05-03', 2, 4, '17:45:00', '0.00'),
(3, '2018-05-04', 4, 4, '15:00:00', '0.00'),
(4, '2018-05-04', 2, 12, '11:00:00', '0.00'),
(5, '2018-05-04', 2, 4, '08:45:00', '0.00'),
(6, '2018-05-04', 2, 4, '09:15:00', '0.00'),
(7, '2018-05-05', 2, 4, '11:15:00', '10.00'),
(8, '2018-05-05', 4, 12, '17:15:00', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `order_item`
--

CREATE TABLE IF NOT EXISTS `order_item` (
  `id` int(11) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `comment` text,
  `order_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order_item`
--

INSERT INTO `order_item` (`id`, `item_id`, `quantity`, `comment`, `order_id`) VALUES
(1, 10, 2, 'without mushrooms', 1),
(2, 7, 4, '', 1),
(3, 8, 1, '', 2),
(4, 9, 2, 'black coffee', 2),
(5, 12, 14, '', 3),
(6, 15, 2, 'with butter', 4),
(7, 14, 1, '', 4),
(8, 16, 4, '', 5),
(9, 12, 2, '', 5),
(10, 15, 1, '', 6),
(11, 12, 1, '', 6),
(12, 16, 1, '', 6),
(13, 16, 2, 'with black pepper', 7),
(14, 14, 6, '', 7),
(15, 12, 2, '', 8);

-- --------------------------------------------------------

--
-- Table structure for table `quote_item`
--

CREATE TABLE IF NOT EXISTS `quote_item` (
  `quote_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `menu_detail` text NOT NULL COMMENT 'save menu detail in serialise form',
  `customer_id` int(11) NOT NULL,
  `customer_detail` text NOT NULL,
  `is_guest` int(11) NOT NULL,
  `cafe_id` int(11) NOT NULL,
  `cafe_detail` text NOT NULL,
  `qty` int(11) NOT NULL,
  `unit_price` double NOT NULL,
  `sub_total` double NOT NULL,
  `tax` double NOT NULL,
  `discount` double NOT NULL,
  `grand_total` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(255) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `email_address` varchar(255) DEFAULT NULL,
  `creditcard_number` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `type` enum('board_director','cafe_staff','cafe_manager','employee','student') DEFAULT NULL,
  `cafe_id` int(11) DEFAULT NULL,
  `balance` decimal(10,2) NOT NULL DEFAULT '0.00',
  `confirmation_code` varchar(255) DEFAULT NULL,
  `is_confirmed` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `user_id`, `email_address`, `creditcard_number`, `password`, `phone`, `type`, `cafe_id`, `balance`, `confirmation_code`, `is_confirmed`) VALUES
(1, 'Mahima', 'Maharjan', 'DB1100', 'mahima@example.com', NULL, 'bdc5f4e6ca07d85327cbbb1aef469322', '8881212', 'board_director', NULL, '0.00', NULL, 1),
(2, 'Karan', 'Bajracharya', 'CS7070', 'karan@example.com', NULL, 'e3fb1135e6fc005b1306acac20b5d721', '8881212', 'cafe_manager', 2, '0.00', NULL, 1),
(3, 'Krita', 'Maharjan', 'CS2020', 'krita@example.com', NULL, 'a75d850ce78a9102c6d8da3d69c9b173', '78787878', 'cafe_staff', 2, '0.00', NULL, 1),
(4, 'Sabina', 'Hona', 'US2424', 'sabina@example.com', '123789456', '3ecb1bb8ab11d58456caba4ecd9ce959', '987654', 'student', NULL, '12000.00', NULL, 1),
(10, 'Aditi', 'Budhathoki', 'CS5427', 'aditi@example.com', NULL, 'a6dfdd04e93f77fd9d0518c0589bea85', '257385', 'cafe_manager', 4, '0.00', NULL, 1),
(11, 'Amrita', 'Nepal', 'CS8090', 'amrita@example.com', NULL, '725ce8a0f07c0e217c23daaf2c2437ef', '846301', 'cafe_staff', 4, '0.00', NULL, 1),
(12, 'Soni', 'Gurung', 'UE4581', 'soni@example.com', '851296375', 'ff591df877f5d154b64a356c66709570', '834812', 'employee', NULL, '888.00', NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_user`
--
ALTER TABLE `admin_user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `ADMIN_USER_USERNAME` (`username`);

--
-- Indexes for table `authorization_rule`
--
ALTER TABLE `authorization_rule`
  ADD PRIMARY KEY (`rule_id`),
  ADD UNIQUE KEY `role_code` (`role_code`,`resource_id`,`permission`);

--
-- Indexes for table `cafes`
--
ALTER TABLE `cafes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cafe_item`
--
ALTER TABLE `cafe_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cafe_id` (`cafe_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `cafe_manager`
--
ALTER TABLE `cafe_manager`
  ADD PRIMARY KEY (`manager_id`),
  ADD KEY `fk_cafe_id` (`cafe_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_item`
--
ALTER TABLE `menu_item`
  ADD PRIMARY KEY (`menu_id`),
  ADD KEY `fk_menu_cafe_id` (`cafe_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cafe_id` (`cafe_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_item`
--
ALTER TABLE `order_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `quote_item`
--
ALTER TABLE `quote_item`
  ADD PRIMARY KEY (`quote_id`),
  ADD KEY `fk_quote_menu_id` (`menu_id`),
  ADD KEY `fk_quote_customer_id` (`customer_id`),
  ADD KEY `fk_quote_cafe_id` (`cafe_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cafe_id` (`cafe_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_user`
--
ALTER TABLE `admin_user`
  MODIFY `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'User ID';
--
-- AUTO_INCREMENT for table `authorization_rule`
--
ALTER TABLE `authorization_rule`
  MODIFY `rule_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Rule ID';
--
-- AUTO_INCREMENT for table `cafes`
--
ALTER TABLE `cafes`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `cafe_item`
--
ALTER TABLE `cafe_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=42;
--
-- AUTO_INCREMENT for table `cafe_manager`
--
ALTER TABLE `cafe_manager`
  MODIFY `manager_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `menu_item`
--
ALTER TABLE `menu_item`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `order_item`
--
ALTER TABLE `order_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `quote_item`
--
ALTER TABLE `quote_item`
  MODIFY `quote_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `cafe_item`
--
ALTER TABLE `cafe_item`
  ADD CONSTRAINT `cafe_item_ibfk_1` FOREIGN KEY (`cafe_id`) REFERENCES `cafes` (`id`),
  ADD CONSTRAINT `cafe_item_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`);

--
-- Constraints for table `cafe_manager`
--
ALTER TABLE `cafe_manager`
  ADD CONSTRAINT `fk_cafe_id` FOREIGN KEY (`cafe_id`) REFERENCES `cafes` (`id`);

--
-- Constraints for table `menu_item`
--
ALTER TABLE `menu_item`
  ADD CONSTRAINT `fk_menu_cafe_id` FOREIGN KEY (`cafe_id`) REFERENCES `cafes` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`cafe_id`) REFERENCES `cafes` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_item`
--
ALTER TABLE `order_item`
  ADD CONSTRAINT `order_item_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`),
  ADD CONSTRAINT `order_item_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

--
-- Constraints for table `quote_item`
--
ALTER TABLE `quote_item`
  ADD CONSTRAINT `fk_quote_cafe_id` FOREIGN KEY (`cafe_id`) REFERENCES `cafes` (`id`),
  ADD CONSTRAINT `fk_quote_customer_id` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_quote_menu_id` FOREIGN KEY (`menu_id`) REFERENCES `menu_item` (`menu_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`cafe_id`) REFERENCES `cafes` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
