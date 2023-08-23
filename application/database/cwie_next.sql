-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 13, 2023 at 09:33 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.0.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cwie_next`
--

-- --------------------------------------------------------

--
-- Table structure for table `cwie_admin`
--

CREATE TABLE `cwie_admin` (
  `admin_id` int(11) NOT NULL,
  `admin_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'ชื่อ',
  `admin_surname` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'นามสกุล',
  `admin_tel` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'เบอร์ติดต่อ',
  `admin_email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'อีเมล',
  `auth_id` int(11) NOT NULL COMMENT 'รหัสยืนยันตัวตน'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cwie_admin`
--

INSERT INTO `cwie_admin` (`admin_id`, `admin_name`, `admin_surname`, `admin_tel`, `admin_email`, `auth_id`) VALUES
(2, 'Tharathon', 'Tippayasotti', '0909670968', 'tharathon0238@gmail.com', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cwie_authentication`
--

CREATE TABLE `cwie_authentication` (
  `auth_id` int(11) NOT NULL,
  `auth_username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'username',
  `auth_password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'password',
  `auth_type` char(2) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'ประเภทบัญชี (0 = แอดมิน 1 = คณะ)',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cwie_authentication`
--

INSERT INTO `cwie_authentication` (`auth_id`, `auth_username`, `auth_password`, `auth_type`, `created_at`, `updated_at`) VALUES
(1, 'tharathon.tip', '$2y$10$qgib61CSqnJc5X/712zm1.82LtViid.BOAbqELu0D1.CbLSrPfnIG', '0', '2023-02-15 06:11:01', '2023-02-15 06:11:01'),
(65, 'fc01', '$2y$10$izUqtQTlDPKgboG7XBDIMuSBNcw8ZE53W0VqvaGNev1ntcakkwHce', '1', '2023-02-24 09:33:46', '2023-02-24 09:33:46'),
(70, 'fc02', '$2y$10$zz1BN3e02df6/ON50UXoJOd7LWRIXId7MlAHdgIVN.mov0Le.bny6', '1', '2023-03-10 02:00:31', '2023-03-10 02:00:31'),
(71, 'fc03', '$2y$10$z8B5QeSM7BkIKB.y9VWMD.HqpAa2U67v8Qo5rGMj5MTzRcw1anx36', '1', '2023-03-10 02:00:48', '2023-03-10 02:00:48'),
(72, 'fc04', '$2y$10$RMRcp3HdUrv8HPcNwZb3YuK9h5GXFRTDEOtjr1gWjPRRdY8UGGxha', '1', '2023-03-10 02:01:03', '2023-03-10 02:01:03'),
(73, 'fc05', '$2y$10$PWYT43mAZ33.B2o0LFWkBeS6seFYUD4FFic71tWTUD9pf2I9vUzXq', '1', '2023-03-10 02:01:19', '2023-03-10 02:01:19'),
(74, 'fc06', '$2y$10$bkF/tabAFkEsMgjOBSM1bO8j3IFu79zE6hLAG.Xsc8aVi2wvK5kqq', '1', '2023-03-10 02:01:41', '2023-03-10 02:01:41'),
(75, 'fc07', '$2y$10$sqH6Adyxt68fOTTYT/mkUefb3dXB/Gto4.VSBNLD11PX0PCtn8j8u', '1', '2023-03-10 02:01:55', '2023-03-10 02:01:55'),
(76, 'fc08', '$2y$10$0ot.iGnKBA5ZtP/nJJJGTuw.zSWnpjn5wqT15D2N561nmv5GoIEwK', '1', '2023-03-10 02:08:50', '2023-03-10 02:08:50'),
(77, 'fc09', '$2y$10$VPkdFyovomGKZpfJz5bIMe4Y3wHWGvroKtszQZkPDlIqNQ2na93Ne', '1', '2023-03-10 02:09:05', '2023-03-10 02:09:05'),
(80, 'fc10', '$2y$10$Fj1X3M4NcmcF99TeYVJOK.kBMocKGafq.K.lLhdbFHpq29AGq36su', '1', '2023-03-10 02:14:08', '2023-03-10 02:14:08'),
(81, 'fc11', '$2y$10$wy7QLlkkvlBk84MORJF49e8xX/I9m3ENn1qUWg.3e0J7xkBCeNl6W', '1', '2023-03-10 02:14:20', '2023-03-10 02:14:20'),
(82, 'fc12', '$2y$10$jh6UmA/vw0Uwis23Sel6TeBg87LvJpW9JkqMZ.bcil4Rsq0cSOGii', '1', '2023-03-10 02:14:31', '2023-03-10 02:14:31'),
(84, 'fc13', '$2y$10$bGQX2h3eqEkh8y8tz8X6LuZjZ7zR9nLpXsuS9mwMMQENlEIJ7luwS', '1', '2023-03-13 08:15:59', '2023-03-13 08:15:59');

-- --------------------------------------------------------

--
-- Table structure for table `cwie_banner_image`
--

CREATE TABLE `cwie_banner_image` (
  `banner_id` int(11) NOT NULL,
  `banner_image_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'ชื่อไฟล์',
  `banner_image_type` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'ประเภทไฟล์',
  `banner_image_order` tinyint(4) DEFAULT NULL COMMENT 'ลำดับ',
  `banner_image_display` tinyint(1) DEFAULT 1 COMMENT 'แสดง Banner'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cwie_banner_image`
--

INSERT INTO `cwie_banner_image` (`banner_id`, `banner_image_name`, `banner_image_type`, `banner_image_order`, `banner_image_display`) VALUES
(39, 'MJ8fmo53Fys0lYkhcaSxLGgWvIKTnw', '.jpg', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cwie_calendar_events`
--

CREATE TABLE `cwie_calendar_events` (
  `calendar_event_id` int(11) NOT NULL,
  `calendar_event_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'ชื่อกิจกรรม',
  `calendar_event_detail` text COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'รายละเอียด',
  `calendar_event_place` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'สถานที่จัดกิจกรรม',
  `calendar_event_start` date DEFAULT NULL COMMENT 'วันเริ่มกิจกรรม',
  `calendar_event_end` date DEFAULT NULL COMMENT 'วันสิ้นสุดกิจกรรม',
  `calendar_event_time_start` time DEFAULT NULL COMMENT 'เวลาเริ่ม',
  `calendar_event_time_end` time DEFAULT NULL COMMENT 'เวลาสิ้นสุด'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cwie_faculty`
--

CREATE TABLE `cwie_faculty` (
  `faculty_id` int(11) NOT NULL,
  `faculty_name_th` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'ชื่อคณะ ไทย',
  `faculty_name_en` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'ชื่อคณะ อังกฤษ',
  `faculty_tel` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'เบอร์โทร',
  `faculty_email` varchar(100) COLLATE utf8_unicode_ci DEFAULT 'NULL' COMMENT 'อีเมล',
  `faculty_link` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'NULL' COMMENT 'ลิงก์ผลงาน',
  `faculty_coordinator_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT 'NULL' COMMENT 'ชื่อผู้ประสานงาน',
  `faculty_coordinator_surname` varchar(100) COLLATE utf8_unicode_ci DEFAULT 'NULL' COMMENT 'นามสกุลผู้ประสานงาน',
  `faculty_coordinator_tel` varchar(50) COLLATE utf8_unicode_ci DEFAULT 'NULL' COMMENT 'เบอร์ติดต่อ',
  `faculty_coordinator_email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'อีเมลผู้ประสานงาน',
  `auth_id` int(11) NOT NULL COMMENT 'รหัสยืนยันตัวตน	'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cwie_faculty`
--

INSERT INTO `cwie_faculty` (`faculty_id`, `faculty_name_th`, `faculty_name_en`, `faculty_tel`, `faculty_email`, `faculty_link`, `faculty_coordinator_name`, `faculty_coordinator_surname`, `faculty_coordinator_tel`, `faculty_coordinator_email`, `auth_id`) VALUES
(36, 'คณะคอมพิวเตอร์และเทคโนโลยีสารสนเทศ', 'Faculty of Computer and technology information', NULL, NULL, NULL, 'นายธราธร', 'ทิพยโสตถิ', '0909670968', NULL, 65),
(41, 'สำนักวิชารัฐศาสตร์และรัฐประศาสนศาสตร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 70),
(42, 'สำนักวิชานิติศาสตร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 71),
(43, 'คณะวิทยาศาสตร์และเทคโนโลยี', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 72),
(44, 'คณะมนุษยศาสตร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 73),
(45, 'คณะครุศาสตร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 74),
(46, 'วิทยาลัยการแพทย์พื้นบ้านและการแพทย์ทางเลือก', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 75),
(47, 'สำนักวิชาการท่องเที่ยว', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 76),
(48, 'สำนักวิชาสังคมศาสตร์', NULL, NULL, NULL, NULL, 'ผู้ช่วยศาสตราจารย์วิจิตรา', 'มนตรี', '0815315070', NULL, 77),
(51, 'สำนักวิชาบัญชี', NULL, NULL, NULL, NULL, 'นางภัทรา', 'เชาว์ยุทธ์', '0858633335', NULL, 80),
(52, 'คณะวิทยาการจัดการ', NULL, NULL, NULL, NULL, 'นางสาวปนัดดา', 'ถิระธรรม', '0954525678', NULL, 81),
(53, 'สำนักวิชาวิทยาศาสตร์สุขภาพ', NULL, NULL, NULL, NULL, 'นางวนิดา', 'เมืองมา', '0914788053', NULL, 82),
(55, 'เทคโนโลยีอุตสาหกรรม', NULL, NULL, NULL, NULL, 'นายธราธร', 'ทิพยโสตถิ', '0909670968', NULL, 84);

-- --------------------------------------------------------

--
-- Table structure for table `cwie_profile_image`
--

CREATE TABLE `cwie_profile_image` (
  `profile_image_id` int(11) NOT NULL,
  `profile_image_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'ชื่อไฟล์',
  `profile_image_type` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'ประเภทไฟล์',
  `auth_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cwie_profile_image`
--

INSERT INTO `cwie_profile_image` (`profile_image_id`, `profile_image_name`, `profile_image_type`, `auth_id`) VALUES
(19, 'fsJTiMxdgyF2I9mc4nRULaA0qNS5bD', '.png', 65),
(22, '5uK6waJDpoSx7b3iUr8VtNeEvTYqfM', '.gif', 1),
(26, 'bthBy7Az9YpOqQVDj3GHciwSkv46dC', '.png', 82),
(27, 'VprTC4niDzo05jOKeAXwgkINBf1uZS', '.png', 81),
(28, 'WhsiGNvUxRbgl72CO10qJLY38ZAKjd', '.png', 80),
(29, 'xpXun2glHY7oDGd9qRaky8PA5OrFJb', '.png', 77),
(30, 'osa1yLRcgmTjqtEDnJz2IHFO3AVU58', '.png', 76),
(31, '4ukx7Qj9KDSvsHP0FoW8VTOzmCEGhe', '.png', 75),
(32, 'bgnt8HjIkOV6DPyTZY9m5SxvFJQGhL', '.png', 74),
(33, 'sEh3agcbdJPC21UxZjzpBuLmIYvXFK', '.png', 73),
(34, '5JRs0d14hGHZTkO3gtl6LDMufUzSP9', '.png', 72),
(35, 'YyE0Kk56a2WZCBtLvTVde8GmQPnhiJ', '.png', 71),
(36, '2DCkwqRb6P9i80YJB7VNdeAolHxMyp', '.png', 70),
(39, 'nVfeD5Ypwa70X4Zbl8OLSqWz6BdJu1', '.png', 84);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cwie_admin`
--
ALTER TABLE `cwie_admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD KEY `auth_id_relation_admin` (`auth_id`) USING BTREE;

--
-- Indexes for table `cwie_authentication`
--
ALTER TABLE `cwie_authentication`
  ADD PRIMARY KEY (`auth_id`),
  ADD UNIQUE KEY `auth_username` (`auth_username`);

--
-- Indexes for table `cwie_banner_image`
--
ALTER TABLE `cwie_banner_image`
  ADD PRIMARY KEY (`banner_id`);

--
-- Indexes for table `cwie_calendar_events`
--
ALTER TABLE `cwie_calendar_events`
  ADD PRIMARY KEY (`calendar_event_id`);

--
-- Indexes for table `cwie_faculty`
--
ALTER TABLE `cwie_faculty`
  ADD PRIMARY KEY (`faculty_id`),
  ADD KEY `auth_id_relation_faculty` (`auth_id`);

--
-- Indexes for table `cwie_profile_image`
--
ALTER TABLE `cwie_profile_image`
  ADD PRIMARY KEY (`profile_image_id`),
  ADD KEY `auth_id_relation_profiel_image` (`auth_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cwie_admin`
--
ALTER TABLE `cwie_admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cwie_authentication`
--
ALTER TABLE `cwie_authentication`
  MODIFY `auth_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `cwie_banner_image`
--
ALTER TABLE `cwie_banner_image`
  MODIFY `banner_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `cwie_calendar_events`
--
ALTER TABLE `cwie_calendar_events`
  MODIFY `calendar_event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `cwie_faculty`
--
ALTER TABLE `cwie_faculty`
  MODIFY `faculty_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `cwie_profile_image`
--
ALTER TABLE `cwie_profile_image`
  MODIFY `profile_image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cwie_admin`
--
ALTER TABLE `cwie_admin`
  ADD CONSTRAINT `auth_id_relation` FOREIGN KEY (`auth_id`) REFERENCES `cwie_authentication` (`auth_id`) ON DELETE CASCADE;

--
-- Constraints for table `cwie_faculty`
--
ALTER TABLE `cwie_faculty`
  ADD CONSTRAINT `auth_id_relation_faculty` FOREIGN KEY (`auth_id`) REFERENCES `cwie_authentication` (`auth_id`) ON DELETE CASCADE;

--
-- Constraints for table `cwie_profile_image`
--
ALTER TABLE `cwie_profile_image`
  ADD CONSTRAINT `auth_id_relation_profiel_image` FOREIGN KEY (`auth_id`) REFERENCES `cwie_authentication` (`auth_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
