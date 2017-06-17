-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 17, 2017 at 04:46 AM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `visa2017`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrators`
--

CREATE TABLE `administrators` (
  `id` int(11) NOT NULL,
  `username` varchar(45) NOT NULL,
  `password` varchar(64) NOT NULL,
  `role` enum('admin','editor') NOT NULL DEFAULT 'admin',
  `sId` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `administrators`
--

INSERT INTO `administrators` (`id`, `username`, `password`, `role`, `sId`) VALUES
(1, 'visa', 'DckjtGFFperIX1VfwOw+0HW1e1xr/4wTQrZGyH0T3Rw=', 'admin', '4880');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` int(5) NOT NULL,
  `w_id` int(3) NOT NULL,
  `coupon` varchar(7) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `w_id`, `coupon`, `status`, `timestamp`) VALUES
(1, 1, 'CGS0001', 1, '2017-06-17 02:41:15'),
(2, 1, 'CGS0002', 1, '2017-06-17 02:41:23'),
(3, 1, 'CGS0003', 1, '2017-06-17 02:41:28'),
(4, 1, 'CGS0004', 1, '2017-06-17 02:41:33'),
(5, 1, 'CGS0005', 1, '2017-06-17 02:41:37');

-- --------------------------------------------------------

--
-- Table structure for table `members_redeems`
--

CREATE TABLE `members_redeems` (
  `id` int(5) UNSIGNED ZEROFILL NOT NULL,
  `redeem_id` int(2) UNSIGNED ZEROFILL NOT NULL,
  `spending` decimal(10,2) DEFAULT NULL,
  `approval_code` varchar(6) NOT NULL,
  `is_used` tinyint(4) NOT NULL DEFAULT '0',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `members_redeems`
--

INSERT INTO `members_redeems` (`id`, `redeem_id`, `spending`, `approval_code`, `is_used`, `timestamp`) VALUES
(00001, 01, '1000000.00', 'a11111', 0, '2017-06-13 04:20:34'),
(00002, 02, '99999.00', '5555aa', 0, '2017-06-13 15:08:12'),
(00003, 03, '9999.00', 'a9999a', 0, '2017-06-13 16:59:07'),
(00004, 03, '9999.00', '9999jw', 0, '2017-06-13 17:52:36'),
(00005, 02, '9999.00', '5555a5', 0, '2017-06-13 22:38:34'),
(00006, 02, '55555.00', '99999y', 0, '2017-06-13 22:39:37'),
(00007, 03, '2345678.00', '800090', 0, '2017-06-13 23:31:18'),
(00008, 01, '99999.00', 'asf555', 0, '2017-06-14 09:04:47'),
(00009, 01, '9999.00', 'asssaw', 0, '2017-06-16 20:47:43'),
(00010, 01, '9999.00', 'assqaw', 0, '2017-06-16 20:53:43'),
(00011, 01, '9999.00', 'asoqaw', 0, '2017-06-16 20:59:01'),
(00012, 01, '9999.00', 'apoqaw', 0, '2017-06-16 20:59:50'),
(00013, 02, '99999.00', '9q3688', 0, '2017-06-16 21:01:04');

-- --------------------------------------------------------

--
-- Table structure for table `merchants`
--

CREATE TABLE `merchants` (
  `code` varchar(10) NOT NULL,
  `name` text,
  `country` text NOT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `merchants`
--

INSERT INTO `merchants` (`code`, `name`, `country`, `timestamp`) VALUES
('CDSKS', 'Central Kadsuan', 'CMI', '2017-06-14 01:30:13'),
('CDSPT', 'Central Phuket', 'PKT', '2017-06-14 01:30:41'),
('FSH', 'Fashion', 'BKK', '2017-06-14 00:04:34'),
('MGB', 'Mega Bangna', 'BKK', '2017-06-14 00:04:38'),
('RBS10', 'Robinson Chiangmai', 'CMI', '2017-06-14 00:10:06'),
('RC', 'River City', 'BKK', '2017-06-14 00:04:42');

-- --------------------------------------------------------

--
-- Table structure for table `redeems`
--

CREATE TABLE `redeems` (
  `id` int(2) UNSIGNED ZEROFILL NOT NULL,
  `item` text,
  `description` text,
  `amount` int(11) DEFAULT NULL,
  `allocate` int(3) NOT NULL,
  `allocate_now` int(3) NOT NULL,
  `crireria` int(5) NOT NULL DEFAULT '1000',
  `term` varchar(999) DEFAULT '<li>Customer must present Visa sales slip with qualified purchase amount</li> <li>The offer can be redeemed at the merchant outlet where the QR code was scanned only</li> <li>The offer is valid from 15 June – 31 August 2017</li> <li>The offer cannot be redeemed or exchanged for cash</li> <li>Terms and conditions apply for usage of each offer</li>',
  `type` enum('cash','gift') DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `merchant_code` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `redeems`
--

INSERT INTO `redeems` (`id`, `item`, `description`, `amount`, `allocate`, `allocate_now`, `crireria`, `term`, `type`, `timestamp`, `merchant_code`) VALUES
(01, 'The Loft 150 THB', 'the redemption counter L 1 floor (in front of Big C Extra)', 199, 10, 9, 1000, '<li>Customer must present Visa sales slip with qualified purchase amount</li>\r\n<li>The offer can be redeemed at the merchant outlet where the QR code was scanned only</li>\r\n<li>The offer is valid from 15 June – 31 August 2017</li>\r\n<li>The offer cannot be redeemed or exchanged for cash</li>\r\n<li>Terms and conditions apply for usage of each offer</li>', 'cash', '2017-06-16 20:59:51', 'MGB'),
(02, 'BiG Umbrella', 'the concierge counter 1st floor', 99, 10, 9, 5000, '<li>Customer must present Visa sales slip with qualified purchase amount</li>\r\n<li>The offer can be redeemed at the merchant outlet where the QR code was scanned only</li><li>The offer is valid from 15 June – 31 August 2017</li>\r\n<li>The offer cannot be redeemed or exchanged for cash</li>\r\n<li>Terms and conditions apply for usage of each offer</li>', 'cash', '2017-06-16 21:01:04', 'RC'),
(03, 'Coupon 100 THB', 'the information counter 1st floor', 300, 30, 30, 1000, '<li>Customer must present Visa sales slip with qualified purchase amount</li><li>The offer can be redeemed at the merchant outlet where the QR code was scanned only</li><li>The offer is valid from 15 June – 31 August 2017</li><li>The offer cannot be redeemed or exchanged for cash</li><li>Terms and conditions apply for usage of each offer</li>\r\n                            ', 'cash', '2017-06-16 20:36:33', 'FSH');

-- --------------------------------------------------------

--
-- Table structure for table `welcomepacks`
--

CREATE TABLE `welcomepacks` (
  `id` int(3) NOT NULL,
  `code` text NOT NULL,
  `name` text NOT NULL,
  `limits` int(11) NOT NULL DEFAULT '-1',
  `allocate` int(3) NOT NULL,
  `allocate_now` int(3) NOT NULL,
  `coupon_list` int(1) NOT NULL DEFAULT '0',
  `term` text NOT NULL,
  `description` text NOT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `welcomepacks`
--

INSERT INTO `welcomepacks` (`id`, `code`, `name`, `limits`, `allocate`, `allocate_now`, `coupon_list`, `term`, `description`, `timestamp`) VALUES
(1, 'GCS', '150 THB discount for any Grab services', 100, 20, 40, 1, '<li>The discount code is valid for payment made by Visa card only</li>\r\n<li>The discount code is valid for one time use</li> <li>The offer is valid from 15 June - 31 August 2017</li>\r\n <li>The offer cannot be redeemed or exchanged for cash</li> \r\n<li>Terms and conditions apply for usage of each offer</li>', 'Add this code when you make a reservation on Grab mobile application', '2017-06-17 01:32:14'),
(2, 'DTAC', 'Free Tourist SIM Card', 56, 30, 30, 0, '<li>The offer is valid from 15 June - 31 August 2017</li> <li>The offer cannot be redeemed or exchanged for cash</li> <li>Terms and conditions apply for usage of each offer</li>', 'Present this message screen at DTAC counter, arrival zone, Suvarnabhumi Airport or  arrival zone, Donmuang Airport to get free SIM', '2017-06-17 02:44:02'),
(3, 'CFW', 'Free 1 Iced Café'' Latte, or Green Tea Latte, or Iced Chocolate 16 oz.', 56, 30, 29, 0, '<li>Get one free drink from the specific drink listed only</li>\r\n<li>The offer is valid from 15 June - 31 August 2017</li>\r\n<li>The offer cannot be redeemed or exchanged for cash</li>\r\n<li>Terms and conditions apply for usage of each offer</li>', 'Present this message screen at participating Coffee World outlets to get free drink Look for this sign for the participating outlets', '2017-06-16 22:13:36');

-- --------------------------------------------------------

--
-- Table structure for table `welcomepacks_registers`
--

CREATE TABLE `welcomepacks_registers` (
  `id` int(5) UNSIGNED ZEROFILL NOT NULL,
  `welcomepack_id` int(3) NOT NULL,
  `country` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `welcomepacks_registers`
--

INSERT INTO `welcomepacks_registers` (`id`, `welcomepack_id`, `country`, `timestamp`) VALUES
(00001, 3, 'Bangladesh', '2017-06-13 17:34:31'),
(00002, 1, 'Bangladesh', '2017-06-13 17:34:36'),
(00003, 3, 'Azerbaijan', '2017-06-13 17:55:39'),
(00004, 1, 'Azerbaijan', '2017-06-13 17:55:44'),
(00005, 3, 'Azerbaijan', '2017-06-13 17:58:13'),
(00006, 2, 'Azerbaijan', '2017-06-13 17:58:18'),
(00007, 1, 'Azerbaijan', '2017-06-13 17:59:02'),
(00008, 2, 'Azerbaijan', '2017-06-13 17:59:05'),
(00009, 2, 'Azerbaijan', '2017-06-13 18:00:41'),
(00010, 3, 'Azerbaijan', '2017-06-13 18:01:09'),
(00011, 2, 'Azerbaijan', '2017-06-13 18:01:26'),
(00012, 1, 'Azerbaijan', '2017-06-13 18:01:28'),
(00013, 3, 'Azerbaijan', '2017-06-13 18:01:32'),
(00014, 2, 'Azerbaijan', '2017-06-13 18:11:52'),
(00015, 3, 'Azerbaijan', '2017-06-13 18:12:29'),
(00016, 2, 'Azerbaijan', '2017-06-13 18:13:24'),
(00017, 2, 'Azerbaijan', '2017-06-13 18:13:27'),
(00018, 1, 'Barbados', '2017-06-13 18:14:04'),
(00019, 2, 'Bangladesh', '2017-06-13 18:15:06'),
(00020, 1, 'Afganistan', '2017-06-13 18:24:56'),
(00021, 3, 'Barbados', '2017-06-13 18:25:02'),
(00022, 2, 'Bahrain', '2017-06-13 20:45:28'),
(00023, 2, 'Bahamas', '2017-06-13 21:02:42'),
(00024, 3, 'Bahrain', '2017-06-13 21:02:58'),
(00025, 3, 'Bahamas', '2017-06-13 21:25:23'),
(00026, 1, 'Bahamas', '2017-06-13 21:28:44'),
(00027, 2, 'Bahamas', '2017-06-13 21:28:50'),
(00028, 1, 'Bahamas', '2017-06-13 21:39:30'),
(00029, 3, 'Bahamas', '2017-06-13 21:43:17'),
(00030, 3, 'Bahamas', '2017-06-13 21:44:21'),
(00031, 2, 'Azerbaijan', '2017-06-13 22:57:29'),
(00032, 1, 'Bahamas', '2017-06-13 23:07:15'),
(00033, 2, 'Bahamas', '2017-06-13 23:07:19'),
(00034, 1, 'Bahamas', '2017-06-13 23:07:23'),
(00035, 2, 'Bahamas', '2017-06-13 23:07:24'),
(00036, 2, 'Bahamas', '2017-06-13 23:07:53'),
(00037, 3, 'Albania', '2017-06-13 23:11:58'),
(00038, 1, 'Bahrain', '2017-06-13 23:28:34'),
(00039, 3, 'Afganistan', '2017-06-14 03:55:09'),
(00040, 2, 'Afganistan', '2017-06-14 09:03:20'),
(00041, 1, 'Aruba', '2017-06-14 09:56:51'),
(00042, 3, 'Afganistan', '2017-06-15 21:47:51'),
(00043, 3, 'Albania', '2017-06-16 22:01:07'),
(00044, 2, 'Bangladesh', '2017-06-16 22:07:30'),
(00045, 3, 'Barbados', '2017-06-16 22:11:01'),
(00046, 3, 'Bangladesh', '2017-06-16 22:13:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrators`
--
ALTER TABLE `administrators`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `members_redeems`
--
ALTER TABLE `members_redeems`
  ADD PRIMARY KEY (`id`),
  ADD KEY `redeem_id` (`redeem_id`);

--
-- Indexes for table `merchants`
--
ALTER TABLE `merchants`
  ADD PRIMARY KEY (`code`),
  ADD KEY `code` (`code`),
  ADD KEY `code_2` (`code`);

--
-- Indexes for table `redeems`
--
ALTER TABLE `redeems`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Redeems_Merchants1_idx` (`merchant_code`),
  ADD KEY `merchant_code` (`merchant_code`),
  ADD KEY `merchant_code_2` (`merchant_code`);

--
-- Indexes for table `welcomepacks`
--
ALTER TABLE `welcomepacks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `welcomepacks_registers`
--
ALTER TABLE `welcomepacks_registers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `members_redeems`
--
ALTER TABLE `members_redeems`
  MODIFY `id` int(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `redeems`
--
ALTER TABLE `redeems`
  MODIFY `id` int(2) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `welcomepacks`
--
ALTER TABLE `welcomepacks`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `welcomepacks_registers`
--
ALTER TABLE `welcomepacks_registers`
  MODIFY `id` int(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `redeems`
--
ALTER TABLE `redeems`
  ADD CONSTRAINT `fk_Redeems_Merchants1` FOREIGN KEY (`merchant_code`) REFERENCES `merchants` (`code`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
