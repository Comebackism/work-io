-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 29, 2020 at 02:29 PM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `workshop_work_io`
--
CREATE DATABASE IF NOT EXISTS `workshop_work_io` DEFAULT CHARACTER SET utf32 COLLATE utf32_general_ci;
USE `workshop_work_io`;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_emp`
--

CREATE TABLE `tbl_emp` (
  `m_id` int(11) NOT NULL,
  `m_username` varchar(50) NOT NULL,
  `m_password` varchar(50) NOT NULL,
  `m_firstname` varchar(50) NOT NULL,
  `m_name` varchar(100) NOT NULL,
  `m_lastname` varchar(100) NOT NULL,
  `m_position` varchar(100) NOT NULL,
  `m_img` varchar(100) DEFAULT NULL,
  `m_phone` varchar(20) NOT NULL,
  `m_email` varchar(50) NOT NULL,
  `m_level` varchar(10) NOT NULL,
  `m_datesave` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_emp`
--

INSERT INTO `tbl_emp` (`m_id`, `m_username`, `m_password`, `m_firstname`, `m_name`, `m_lastname`, `m_position`, `m_img`, `m_phone`, `m_email`, `m_level`, `m_datesave`) VALUES
(1, '111', '6216f8a75fd5bb3d5f22b6f9958cdede3fc086c2', 'นาย', 'ทดสอบ', 'ระบบ', 'โปรแกรมเมอร์', 'e1.png', '0948616709', 'devbanban@gmail.com', 'staff', '2020-03-24 04:00:33'),
(2, '222', '1c6637a8f2e1f75e06ff9984894d6bd16a3a36a9', 'นาย', 'พนง.', 'ในบริษัท', 'โปรแกรมเมอร์', 'e2.png', '0948616709', 'devbanban@gmail.com', 'staff', '2020-03-24 04:00:33'),
(3, '333', '43814346e21444aaf4f70841bf7ed5ae93f55a9d', 'นางสาว', 'frontend', 'dd', 'frontend', 'e3.png', '0948616709', 'devbanban@gmail.com', 'staff', '2020-03-24 04:00:33'),
(4, '444', '9a3e61b6bcc8abec08f195526c3132d5a4a98cc0', 'นาย', 'admin', 'naja', 'admin', 'e1.png', '0948616709', 'devbanban@gmail.com', 'admin', '2020-03-24 04:00:33'),
(5, '555', 'cfa1150f1787186742a9a884b73a43d8cf219f9b', 'นางสาว', '5555', 'pppppp', 'frontend', 'e3.png', '0948616709', 'devbanban@gmail.com', 'staff', '2020-03-24 04:00:33');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_job`
--

CREATE TABLE `tbl_job` (
  `id` int(11) NOT NULL,
  `ref_m_id` int(11) NOT NULL,
  `job_detail` text NOT NULL,
  `job_remark` text NOT NULL,
  `job_by` varchar(200) NOT NULL,
  `date_save` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Dumping data for table `tbl_job`
--

INSERT INTO `tbl_job` (`id`, `ref_m_id`, `job_detail`, `job_remark`, `job_by`, `date_save`) VALUES
(1, 1, 'ทำส่วนหน้าบ้าน', 'ส่งให้ดูทางไลน์แล้ว', 'บอส', '2020-03-27 03:38:09'),
(2, 1, 'ปรับปรุงหน้าฟอร์มสมัครสมาชิก', 'ปรับ css', 'boss1', '2020-03-27 03:41:04'),
(3, 2, 'แก้ไข function register', 'ได้เพิ่ม......... และอัพขึ้น server เรียบร้อยแล้ว', 'หัวหน้าแผนก', '2020-03-29 03:15:38'),
(4, 2, 'แก้หนังสือ/บันทึกข้อความ', 'ใส่ชื่อหัวหน้าสำนักงานเข้าไปในด้วย', 'หัวหน้าสำนักงาน', '2020-03-29 03:16:23'),
(5, 3, 'แก้ form register', 'เพิ่ม css ', 'boss', '2020-03-29 03:22:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_work_io`
--

CREATE TABLE `tbl_work_io` (
  `id` int(11) NOT NULL,
  `m_id` int(11) NOT NULL COMMENT 'ไอดี พนง.',
  `workdate` date NOT NULL,
  `workin` time NOT NULL,
  `workout` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Dumping data for table `tbl_work_io`
--

INSERT INTO `tbl_work_io` (`id`, `m_id`, `workdate`, `workin`, `workout`) VALUES
(1, 1, '2020-03-21', '11:55:34', '12:01:19'),
(2, 2, '2020-03-23', '12:07:05', '12:07:45'),
(3, 3, '2020-03-24', '12:19:03', NULL),
(4, 1, '2020-03-22', '13:14:23', '13:15:02'),
(5, 1, '2020-03-23', '13:27:14', '13:28:27'),
(6, 1, '2020-03-24', '13:32:04', NULL),
(7, 2, '2020-03-24', '14:01:45', '14:02:53'),
(8, 5, '2020-03-24', '14:04:14', '14:04:40'),
(9, 1, '2020-03-27', '10:37:33', NULL),
(10, 2, '2020-03-29', '10:08:54', NULL),
(11, 3, '2020-03-29', '10:21:25', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_emp`
--
ALTER TABLE `tbl_emp`
  ADD PRIMARY KEY (`m_id`);

--
-- Indexes for table `tbl_job`
--
ALTER TABLE `tbl_job`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_work_io`
--
ALTER TABLE `tbl_work_io`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_emp`
--
ALTER TABLE `tbl_emp`
  MODIFY `m_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_job`
--
ALTER TABLE `tbl_job`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_work_io`
--
ALTER TABLE `tbl_work_io`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
