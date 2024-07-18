-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 18, 2024 at 05:33 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mcclrc`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `middlename` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `phone_number` varchar(25) NOT NULL,
  `password` varchar(100) NOT NULL,
  `confirm_password` varchar(100) NOT NULL,
  `admin_image` varchar(100) NOT NULL,
  `admin_type` varchar(100) NOT NULL,
  `role_as` tinyint(4) NOT NULL DEFAULT 1,
  `admin_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `firstname`, `middlename`, `lastname`, `email`, `address`, `phone_number`, `password`, `confirm_password`, `admin_image`, `admin_type`, `role_as`, `admin_added`) VALUES
(13, 'Relina', '', 'Jabal-balili', 'admin@gmail.com', 'address', '09123456789', '21232f297a57a5a743894a0e4a801fc3', '21232f297a57a5a743894a0e4a801fc3', '1670055503.png', '', 1, '2022-11-30 01:17:21'),
(35, 'Emelen', '', 'Bayon-on', 'emelenbayon-on@gmail.com', 'Maricaban, Santa Fe, Cebu', '(+63) 9342-167-893', '0f420395018d23a2200007ad2fd37e84', '0f420395018d23a2200007ad2fd37e84', '1670213672.jpg', '', 1, '2022-12-06 22:55:14');

-- --------------------------------------------------------

--
-- Table structure for table `allowed_book`
--

CREATE TABLE `allowed_book` (
  `allowed_book_id` int(11) NOT NULL,
  `qntty_books` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `allowed_book`
--

INSERT INTO `allowed_book` (`allowed_book_id`, `qntty_books`) VALUES
(1, 3),
(2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `allowed_days`
--

CREATE TABLE `allowed_days` (
  `allowed_days_id` int(11) NOT NULL,
  `no_of_days` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `allowed_days`
--

INSERT INTO `allowed_days` (`allowed_days_id`, `no_of_days`) VALUES
(1, 3),
(2, 150);

-- --------------------------------------------------------

--
-- Table structure for table `barcode`
--

CREATE TABLE `barcode` (
  `barcode_id` int(11) NOT NULL,
  `pre_barcode` varchar(100) NOT NULL,
  `mid_barcode` int(100) NOT NULL,
  `suf_barcode` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `book_id` int(11) NOT NULL,
  `call_number` varchar(50) NOT NULL,
  `accession_number` varchar(50) NOT NULL,
  `title` varchar(150) NOT NULL,
  `category_id` int(11) NOT NULL,
  `author` varchar(50) NOT NULL,
  `copyright_date` varchar(20) NOT NULL,
  `publisher` varchar(50) NOT NULL,
  `place_publication` varchar(50) NOT NULL,
  `isbn` varchar(50) NOT NULL,
  `barcode` varchar(50) NOT NULL,
  `book_image` varchar(100) NOT NULL,
  `date_added` datetime NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`book_id`, `call_number`, `accession_number`, `title`, `category_id`, `author`, `copyright_date`, `publisher`, `place_publication`, `isbn`, `barcode`, `book_image`, `date_added`, `status`) VALUES
(93, '1234', '1235', 'Computer Programming', 1, 'Rich', '2021', 'Mann', 'Kingdom', '12345678', 'MCC-LRC1235', '1719979739.jpg', '2024-07-03 12:08:59', 'Unavailable'),
(94, '1234', '5678', 'Computer Programming', 1, 'Rich', '2021', 'Mann', 'Kingdom', '12345678', 'MCC-LRC5678', '1719979739.jpg', '2024-07-03 12:08:59', 'Unavailable'),
(95, '5678', '8765', 'C# Programming', 5, 'Black', '2021', 'Mann', 'Clover', '123456789', 'MCC-LRC8765', '1719979865.jfif', '2024-07-03 12:11:05', 'Unavailable'),
(96, '5678', '4321', 'C# Programming', 5, 'Black', '2021', 'Mann', 'Clover', '123456789', 'MCC-LRC4321', '1719979865.jfif', '2024-07-03 12:11:05', 'Unavailable');

-- --------------------------------------------------------

--
-- Table structure for table `borrow_book`
--

CREATE TABLE `borrow_book` (
  `borrow_book_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `faculty_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `date_borrowed` datetime NOT NULL,
  `due_date` datetime NOT NULL,
  `date_returned` datetime NOT NULL,
  `borrowed_status` varchar(100) NOT NULL,
  `book_penalty` varchar(100) NOT NULL,
  `accession_number` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `borrow_book`
--

INSERT INTO `borrow_book` (`borrow_book_id`, `user_id`, `faculty_id`, `book_id`, `date_borrowed`, `due_date`, `date_returned`, `borrowed_status`, `book_penalty`, `accession_number`) VALUES
(700, 84, 0, 93, '2024-07-15 00:00:00', '2024-07-18 00:00:00', '2024-07-15 00:00:00', 'returned', '0', ''),
(701, 84, 0, 93, '2024-07-15 00:00:00', '2024-07-18 00:00:00', '2024-07-15 00:00:00', 'returned', '0', ''),
(702, 85, 0, 94, '2024-07-15 00:00:00', '2024-07-18 00:00:00', '2024-07-15 00:00:00', 'returned', '0', ''),
(703, 84, 0, 93, '2024-07-15 00:00:00', '2024-07-18 00:00:00', '2024-07-15 00:00:00', 'returned', '0', ''),
(704, 85, 0, 94, '2024-07-15 00:00:00', '2024-07-18 00:00:00', '2024-07-15 00:00:00', 'returned', '0', ''),
(705, 84, 0, 93, '2024-07-15 00:00:00', '2024-07-18 00:00:00', '2024-07-16 00:00:00', 'returned', '0', ''),
(706, 85, 0, 94, '2024-07-15 00:00:00', '2024-07-18 00:00:00', '2024-07-16 00:00:00', 'returned', '0', ''),
(707, 84, 0, 93, '2024-07-17 00:00:00', '2024-07-20 00:00:00', '2024-07-17 00:00:00', 'returned', '0', ''),
(708, 84, 0, 93, '2024-07-17 00:00:00', '2024-07-20 00:00:00', '0000-00-00 00:00:00', 'borrowed', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `classname` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `classname`) VALUES
(1, 'Filipiniana Section'),
(2, 'Circulation Section'),
(3, 'Reserved Section'),
(4, 'Periodical Section'),
(5, 'Fiction Section');

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `faculty_id` int(11) NOT NULL,
  `faculty_log_id` int(11) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `middlename` varchar(50) NOT NULL,
  `gender` varchar(45) NOT NULL,
  `course` varchar(45) NOT NULL,
  `address` varchar(45) NOT NULL,
  `cell_no` varchar(25) NOT NULL,
  `birthdate` varchar(45) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `cpassword` varchar(255) NOT NULL,
  `role_as` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `faculty_added` datetime NOT NULL,
  `qr_code` varchar(255) NOT NULL,
  `reset_token` varchar(2) NOT NULL,
  `token_expiry` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`faculty_id`, `faculty_log_id`, `lastname`, `firstname`, `middlename`, `gender`, `course`, `address`, `cell_no`, `birthdate`, `email`, `username`, `password`, `cpassword`, `role_as`, `status`, `faculty_added`, `qr_code`, `reset_token`, `token_expiry`) VALUES
(12, 0, 'Calatero', 'Diovin', 'Pasicaran', 'Male', 'BSIT', 'Patao, Bantayan, Cebu', '09858024662', '2002-03-14', 'bman23382@gmail.com', 'diovin', '$2y$10$P0Vma8o3xlHDPX50z1GGpOOzhmLXS9A13tcBsvuhuiSIbrnUlu.b.', '', 'faculty', 'approved', '2024-07-05 07:05:22', 'diovin.png', '', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `holds`
--

CREATE TABLE `holds` (
  `hold_id` int(11) NOT NULL,
  `book_title` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `faculty_id` int(11) NOT NULL,
  `accession_number` varchar(255) NOT NULL,
  `hold_status` varchar(50) NOT NULL,
  `hold_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `penalty`
--

CREATE TABLE `penalty` (
  `penalty_id` int(11) NOT NULL,
  `penalty_amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `penalty`
--

INSERT INTO `penalty` (`penalty_id`, `penalty_amount`) VALUES
(1, 5),
(2, 20);

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `report_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `faculty_id` int(11) NOT NULL,
  `admin_name` varchar(100) NOT NULL,
  `detail_action` varchar(100) NOT NULL,
  `date_transaction` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `report`
--

INSERT INTO `report` (`report_id`, `book_id`, `user_id`, `faculty_id`, `admin_name`, `detail_action`, `date_transaction`) VALUES
(1338, 93, 0, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-05 08:42:13'),
(1339, 96, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-06 15:48:37'),
(1340, 96, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-06 15:49:27'),
(1341, 93, 0, 12, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-06 15:58:48'),
(1342, 93, 0, 12, 'Relina  Jabal-balili', 'Returned Book', '2024-07-06 16:00:10'),
(1343, 93, 0, 12, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-06 16:07:30'),
(1344, 93, 0, 12, 'Relina  Jabal-balili', 'Returned Book', '2024-07-06 16:07:42'),
(1345, 93, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-06 16:35:11'),
(1346, 94, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-06 16:35:17'),
(1347, 96, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-06 16:35:24'),
(1348, 93, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-06 16:42:27'),
(1349, 94, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-06 16:42:27'),
(1350, 96, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-06 16:42:28'),
(1351, 93, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-06 19:58:38'),
(1352, 94, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-06 19:58:47'),
(1353, 93, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-06 20:01:50'),
(1354, 94, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-06 20:01:51'),
(1355, 93, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-06 20:09:34'),
(1356, 94, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-06 20:09:38'),
(1357, 93, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-06 20:09:51'),
(1358, 94, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-06 20:09:51'),
(1359, 93, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-06 20:18:00'),
(1360, 93, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-06 20:18:25'),
(1361, 93, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-06 20:28:48'),
(1362, 94, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-06 20:28:52'),
(1363, 93, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-06 20:31:35'),
(1364, 94, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-06 20:31:36'),
(1365, 93, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-06 22:57:36'),
(1366, 94, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-06 22:57:41'),
(1367, 93, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-06 22:58:03'),
(1368, 94, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-06 22:58:03'),
(1369, 93, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-06 22:59:55'),
(1370, 96, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-06 23:00:03'),
(1371, 93, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-06 23:00:20'),
(1372, 96, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-06 23:00:21'),
(1373, 93, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-06 23:04:00'),
(1374, 96, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-06 23:04:05'),
(1375, 93, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-06 23:04:18'),
(1376, 96, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-06 23:04:18'),
(1377, 93, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-06 23:06:29'),
(1378, 96, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-06 23:06:32'),
(1379, 93, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-06 23:06:46'),
(1380, 96, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-06 23:06:46'),
(1381, 93, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-06 23:08:32'),
(1382, 96, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-06 23:08:37'),
(1383, 93, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-06 23:08:50'),
(1384, 96, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-06 23:08:51'),
(1385, 93, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-06 23:12:33'),
(1386, 96, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-06 23:12:37'),
(1387, 93, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-06 23:12:52'),
(1388, 96, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-06 23:12:52'),
(1389, 93, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-06 23:14:29'),
(1390, 96, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-06 23:14:34'),
(1391, 93, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-06 23:14:48'),
(1392, 96, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-06 23:14:48'),
(1393, 93, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-06 23:46:20'),
(1394, 96, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-06 23:46:24'),
(1395, 93, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-06 23:46:45'),
(1396, 96, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-06 23:46:45'),
(1397, 93, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-06 23:59:42'),
(1398, 96, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-06 23:59:47'),
(1399, 93, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-06 23:59:59'),
(1400, 96, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-07 00:00:00'),
(1401, 93, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-07 06:28:58'),
(1402, 96, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-07 06:29:02'),
(1403, 93, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-07 06:34:09'),
(1404, 96, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-07 06:34:09'),
(1405, 93, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-07 13:27:06'),
(1406, 96, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-07 13:27:10'),
(1407, 93, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-07 13:33:46'),
(1408, 96, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-07 13:33:46'),
(1409, 93, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-07 13:38:21'),
(1410, 96, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-07 13:38:25'),
(1411, 93, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-07 13:38:34'),
(1412, 96, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-07 13:38:34'),
(1413, 93, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-07 13:53:45'),
(1414, 96, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-07 13:53:50'),
(1415, 93, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-07 13:54:06'),
(1416, 96, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-07 13:54:06'),
(1417, 93, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-07 13:57:21'),
(1418, 96, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-07 13:57:24'),
(1419, 93, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-07 13:57:31'),
(1420, 96, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-07 13:57:31'),
(1421, 93, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-07 14:00:04'),
(1422, 96, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-07 14:00:11'),
(1423, 93, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-07 14:00:21'),
(1424, 96, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-07 14:00:21'),
(1425, 93, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-09 12:41:54'),
(1426, 96, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-09 12:42:01'),
(1427, 93, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-09 12:44:05'),
(1428, 96, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-09 12:44:05'),
(1429, 93, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-09 12:52:45'),
(1430, 96, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-09 12:52:49'),
(1431, 93, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-09 13:18:39'),
(1432, 96, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-09 13:18:39'),
(1433, 93, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-09 14:16:54'),
(1434, 96, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-09 14:16:58'),
(1435, 93, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-14 14:23:23'),
(1436, 96, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-19 14:34:28'),
(1437, 93, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-09 19:11:46'),
(1438, 96, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-09 19:18:14'),
(1439, 93, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-09 19:18:48'),
(1440, 96, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-09 19:20:48'),
(1441, 93, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-09 21:14:12'),
(1442, 96, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-09 21:14:22'),
(1443, 93, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-09 21:14:54'),
(1444, 96, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-09 21:14:54'),
(1445, 93, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-09 21:17:56'),
(1446, 94, 85, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-09 21:18:34'),
(1447, 94, 85, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-09 21:19:21'),
(1448, 93, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-09 21:20:06'),
(1449, 93, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-09 21:23:57'),
(1450, 96, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-09 21:24:09'),
(1451, 93, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-10 20:41:32'),
(1452, 96, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-10 21:07:18'),
(1453, 93, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-10 21:07:41'),
(1454, 93, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-10 21:08:11'),
(1455, 93, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-10 21:10:23'),
(1456, 93, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-10 21:14:26'),
(1457, 93, 0, 12, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-10 21:17:10'),
(1458, 93, 0, 12, 'Relina  Jabal-balili', 'Returned Book', '2024-07-10 21:46:00'),
(1459, 93, 0, 12, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-10 21:49:20'),
(1460, 93, 0, 12, 'Relina  Jabal-balili', 'Returned Book', '2024-07-15 21:55:08'),
(1461, 93, 0, 12, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-15 21:56:48'),
(1462, 93, 0, 12, 'Relina  Jabal-balili', 'Returned Book', '2024-07-20 22:02:32'),
(1463, 93, 0, 12, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-11 09:27:34'),
(1464, 93, 0, 12, 'Relina  Jabal-balili', 'Returned Book', '2024-07-11 09:28:16'),
(1465, 93, 0, 12, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-11 09:32:16'),
(1466, 93, 0, 12, 'Relina  Jabal-balili', 'Returned Book', '2024-07-16 09:35:17'),
(1467, 93, 0, 12, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-11 09:36:56'),
(1468, 93, 0, 12, 'Relina  Jabal-balili', 'Returned Book', '2024-07-11 09:37:46'),
(1469, 93, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-11 09:40:45'),
(1470, 93, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-11 09:41:15'),
(1471, 93, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-11 09:51:54'),
(1472, 93, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-11 10:15:27'),
(1473, 93, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-11 10:20:38'),
(1474, 93, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-11 10:20:51'),
(1475, 93, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-11 10:23:56'),
(1476, 93, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-11 10:24:15'),
(1477, 93, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-13 12:50:08'),
(1478, 93, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-18 12:51:11'),
(1479, 93, 0, 12, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-18 13:07:58'),
(1480, 93, 0, 12, 'Relina  Jabal-balili', 'Returned Book', '2024-07-18 13:08:31'),
(1481, 93, 0, 12, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-18 13:13:55'),
(1482, 93, 0, 12, 'Relina  Jabal-balili', 'Returned Book', '2024-07-18 13:14:16'),
(1483, 93, 0, 12, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-13 13:14:58'),
(1484, 93, 0, 12, 'Relina  Jabal-balili', 'Returned Book', '2024-07-18 13:15:26'),
(1485, 93, 0, 12, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-13 13:16:21'),
(1486, 94, 0, 12, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-13 13:16:31'),
(1487, 93, 0, 12, 'Relina  Jabal-balili', 'Returned Book', '2024-07-13 13:17:02'),
(1488, 94, 0, 12, 'Relina  Jabal-balili', 'Returned Book', '2024-07-13 13:17:02'),
(1489, 93, 0, 12, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-13 13:25:42'),
(1490, 94, 0, 12, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-13 13:32:43'),
(1491, 94, 0, 12, 'Relina  Jabal-balili', 'Returned Book', '2024-07-13 13:33:07'),
(1492, 94, 0, 12, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-13 13:34:10'),
(1493, 94, 0, 12, 'Relina  Jabal-balili', 'Returned Book', '2024-07-13 13:37:54'),
(1494, 96, 0, 12, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-13 13:38:25'),
(1495, 93, 0, 12, 'Relina  Jabal-balili', 'Returned Book', '2024-07-13 13:38:37'),
(1496, 96, 0, 12, 'Relina  Jabal-balili', 'Returned Book', '2024-07-13 13:38:38'),
(1497, 93, 0, 12, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-13 13:39:57'),
(1498, 93, 0, 12, 'Relina  Jabal-balili', 'Returned Book', '2024-07-13 13:43:36'),
(1499, 93, 0, 12, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-13 13:47:34'),
(1500, 93, 0, 12, 'Relina  Jabal-balili', 'Returned Book', '2024-07-13 13:49:45'),
(1501, 93, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-13 13:50:02'),
(1502, 93, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-18 13:50:58'),
(1503, 93, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-18 13:54:40'),
(1504, 93, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-18 13:54:54'),
(1505, 93, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-18 13:55:40'),
(1506, 93, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-18 13:55:48'),
(1507, 93, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-15 15:20:58'),
(1508, 93, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-15 16:03:51'),
(1509, 93, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-15 16:04:09'),
(1510, 94, 85, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-15 16:04:20'),
(1511, 93, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-15 16:04:52'),
(1512, 94, 85, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-15 16:05:59'),
(1513, 93, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-15 17:05:40'),
(1514, 94, 85, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-15 18:34:37'),
(1515, 93, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-15 21:26:17'),
(1516, 94, 85, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-15 21:26:54'),
(1517, 93, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-15 21:29:23'),
(1518, 94, 85, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-15 21:29:45'),
(1519, 93, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-16 12:23:42'),
(1520, 94, 85, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-16 12:23:59'),
(1521, 93, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-17 15:44:37'),
(1522, 93, 84, 0, 'Relina  Jabal-balili', 'Returned Book', '2024-07-17 15:45:14'),
(1523, 93, 84, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2024-07-17 15:50:11');

-- --------------------------------------------------------

--
-- Table structure for table `return_book`
--

CREATE TABLE `return_book` (
  `return_book_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `faculty_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `date_borrowed` datetime NOT NULL,
  `due_date` datetime NOT NULL,
  `date_returned` datetime NOT NULL,
  `book_penalty` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `return_book`
--

INSERT INTO `return_book` (`return_book_id`, `user_id`, `faculty_id`, `book_id`, `date_borrowed`, `due_date`, `date_returned`, `book_penalty`) VALUES
(725, 84, 0, 93, '2024-07-15 00:00:00', '2024-07-18 00:00:00', '2024-07-15 00:00:00', '0'),
(726, 84, 0, 93, '2024-07-15 00:00:00', '2024-07-18 00:00:00', '2024-07-15 00:00:00', '0'),
(727, 85, 0, 94, '2024-07-15 00:00:00', '2024-07-18 00:00:00', '2024-07-15 00:00:00', '0'),
(728, 84, 0, 93, '2024-07-15 00:00:00', '2024-07-18 00:00:00', '2024-07-15 00:00:00', '0'),
(729, 85, 0, 94, '2024-07-15 00:00:00', '2024-07-18 00:00:00', '2024-07-15 00:00:00', '0'),
(730, 84, 0, 93, '2024-07-15 00:00:00', '2024-07-18 00:00:00', '2024-07-16 00:00:00', '0'),
(731, 85, 0, 94, '2024-07-15 00:00:00', '2024-07-18 00:00:00', '2024-07-16 00:00:00', '0'),
(732, 84, 0, 93, '2024-07-17 00:00:00', '2024-07-20 00:00:00', '2024-07-17 00:00:00', '0');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_log_id` int(11) NOT NULL,
  `lastname` varchar(45) NOT NULL,
  `firstname` varchar(45) NOT NULL,
  `middlename` varchar(45) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `course` varchar(45) NOT NULL,
  `address` varchar(100) NOT NULL,
  `cell_no` varchar(25) NOT NULL,
  `birthdate` varchar(45) NOT NULL,
  `email` varchar(50) NOT NULL,
  `year_level` varchar(45) NOT NULL,
  `student_id_no` varchar(45) NOT NULL,
  `password` varchar(255) NOT NULL,
  `cpassword` varchar(255) NOT NULL,
  `role_as` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `user_added` datetime NOT NULL,
  `qr_code` varchar(255) NOT NULL,
  `verify_token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_log_id`, `lastname`, `firstname`, `middlename`, `gender`, `course`, `address`, `cell_no`, `birthdate`, `email`, `year_level`, `student_id_no`, `password`, `cpassword`, `role_as`, `status`, `user_added`, `qr_code`, `verify_token`) VALUES
(84, 0, 'Calatero', 'Diovin', 'Pasicaran', 'Male', 'BSIT', 'Patao, Bantayan, Cebu', '09858024662', '2002-03-14', 'bman23382@gmail.com', '4th year', '2021-1055', '$2y$10$AYJwsS7T8yi1Vj1SdFNBOebvWM1UorXDjsJma.02uq4YsGaudnNTi', '', 'student', 'approved', '2024-07-01 20:04:19', '2021-1055.png', 'e5088e4dfc5660259c62a77416170d95');

-- --------------------------------------------------------

--
-- Table structure for table `user_log`
--

CREATE TABLE `user_log` (
  `user_log_id` int(11) NOT NULL,
  `student_id` varchar(25) NOT NULL,
  `lastname` varchar(45) NOT NULL,
  `firstname` varchar(45) NOT NULL,
  `middlename` varchar(45) NOT NULL,
  `time_log` time NOT NULL,
  `date_log` date NOT NULL,
  `time_out` time NOT NULL,
  `course` varchar(50) NOT NULL,
  `year_level` varchar(50) NOT NULL,
  `role` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user_log`
--

INSERT INTO `user_log` (`user_log_id`, `student_id`, `lastname`, `firstname`, `middlename`, `time_log`, `date_log`, `time_out`, `course`, `year_level`, `role`) VALUES
(271, '2021-1055', 'Calatero', 'Diovin', 'Pasicaran', '16:30:15', '2024-07-06', '16:31:12', 'BSIT', '4th year', 'student'),
(272, '2021-1055', 'Calatero', 'Diovin', 'Pasicaran', '15:54:12', '2024-07-17', '15:54:36', 'BSIT', '4th year', 'student'),
(273, '2021-1055', 'Calatero', 'Diovin', 'Pasicaran', '15:54:59', '2024-07-17', '00:00:00', 'BSIT', '4th year', 'student');

-- --------------------------------------------------------

--
-- Table structure for table `web_opac`
--

CREATE TABLE `web_opac` (
  `web_opac_id` int(11) NOT NULL,
  `opac_image` varchar(100) DEFAULT NULL,
  `ebook` varchar(191) NOT NULL,
  `title` varchar(100) NOT NULL,
  `author` varchar(100) NOT NULL,
  `copyright_date` varchar(100) NOT NULL,
  `publisher` varchar(100) NOT NULL,
  `added_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `web_opac`
--

INSERT INTO `web_opac` (`web_opac_id`, `opac_image`, `ebook`, `title`, `author`, `copyright_date`, `publisher`, `added_at`) VALUES
(20, '1670761330.png', '1670761330.pdf', 'LEARN ALGORITHMS THROUGH PROGRAMMING AND PUZZLE SOLVING', 'Alexander Kulikov and Pavel Pevzner', '2018', 'Active Learning Technologies', '2022-11-29 10:28:53'),
(21, '1670761278.png', '1670761278.pdf', 'Java for Absolute Beginners Learn to Program the Fundamentals the Java 9+ Way', 'Iuliana Cosmina', ' 2018', 'Iuliana Cosmina', '2022-12-01 15:10:08'),
(22, '1670761205.png', '1670761205.pdf', 'Black Hat Go Go Programming for Hackers and Pentesters', 'Dan Kottmann', '2020', 'William Pollock', '2022-12-01 15:24:21'),
(43, '1671145749.png', '1671145749.pdf', 'Laptop Repair Guide', 'GARRY ROMANEO', '2011', ' Garry Romaneo,', '2022-12-16 07:09:09'),
(44, '1671145981.png', '1671145981.pdf', 'Web Designer\'s guide to wordpress', 'Jesse Friedman', '2013', ' Jesse Friedman', '2022-12-16 07:13:01'),
(45, '1671146158.png', '1671146158.pdf', 'English Grammar Reference Book', 'Jacqueline Melvin', '2014', 'Jacqueline Melvin', '2022-12-16 07:15:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `allowed_book`
--
ALTER TABLE `allowed_book`
  ADD PRIMARY KEY (`allowed_book_id`);

--
-- Indexes for table `allowed_days`
--
ALTER TABLE `allowed_days`
  ADD PRIMARY KEY (`allowed_days_id`);

--
-- Indexes for table `barcode`
--
ALTER TABLE `barcode`
  ADD PRIMARY KEY (`barcode_id`);

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`book_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `borrow_book`
--
ALTER TABLE `borrow_book`
  ADD PRIMARY KEY (`borrow_book_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `faculty_id` (`faculty_id`),
  ADD KEY `borrow_book_ibfk_1` (`book_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`faculty_id`),
  ADD UNIQUE KEY `FOREIGN KEY` (`faculty_log_id`) USING BTREE;

--
-- Indexes for table `holds`
--
ALTER TABLE `holds`
  ADD PRIMARY KEY (`hold_id`);

--
-- Indexes for table `penalty`
--
ALTER TABLE `penalty`
  ADD PRIMARY KEY (`penalty_id`);

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`report_id`);

--
-- Indexes for table `return_book`
--
ALTER TABLE `return_book`
  ADD PRIMARY KEY (`return_book_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `faculty_id` (`faculty_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `user_log_id` (`user_log_id`);

--
-- Indexes for table `user_log`
--
ALTER TABLE `user_log`
  ADD PRIMARY KEY (`user_log_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `web_opac`
--
ALTER TABLE `web_opac`
  ADD PRIMARY KEY (`web_opac_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `allowed_book`
--
ALTER TABLE `allowed_book`
  MODIFY `allowed_book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `allowed_days`
--
ALTER TABLE `allowed_days`
  MODIFY `allowed_days_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `barcode`
--
ALTER TABLE `barcode`
  MODIFY `barcode_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `borrow_book`
--
ALTER TABLE `borrow_book`
  MODIFY `borrow_book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=709;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=801;

--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
  MODIFY `faculty_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `holds`
--
ALTER TABLE `holds`
  MODIFY `hold_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `penalty`
--
ALTER TABLE `penalty`
  MODIFY `penalty_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `report`
--
ALTER TABLE `report`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1524;

--
-- AUTO_INCREMENT for table `return_book`
--
ALTER TABLE `return_book`
  MODIFY `return_book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=733;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `user_log`
--
ALTER TABLE `user_log`
  MODIFY `user_log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=274;

--
-- AUTO_INCREMENT for table `web_opac`
--
ALTER TABLE `web_opac`
  MODIFY `web_opac_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `borrow_book`
--
ALTER TABLE `borrow_book`
  ADD CONSTRAINT `borrow_book_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `book` (`book_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `return_book`
--
ALTER TABLE `return_book`
  ADD CONSTRAINT `return_book_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `book` (`book_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
