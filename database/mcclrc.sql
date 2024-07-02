-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 02, 2024 at 08:04 PM
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
(13, 'Relinas', '', 'Jabal-balili', 'admin@gmail.com', 'address', '09123456789', '21232f297a57a5a743894a0e4a801fc3', '21232f297a57a5a743894a0e4a801fc3', '1670055503.png', '', 1, '2022-11-30 01:17:21'),
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

--
-- Dumping data for table `barcode`
--

INSERT INTO `barcode` (`barcode_id`, `pre_barcode`, `mid_barcode`, `suf_barcode`) VALUES
(1, 'MCC', 2, 'LRC'),
(2, 'MCC', 2, 'LRC'),
(3, 'MCC', 2, 'LRC'),
(4, 'MCC', 2, 'LRC'),
(5, 'MCC', 2, 'LRC'),
(6, 'MCC', 2, 'LRC'),
(7, 'MCC', 2, 'LRC'),
(8, 'MCC', 2, 'LRC'),
(9, 'MCC', 2, 'LRC'),
(10, 'MCC', 2, 'LRC'),
(11, 'MCC', 2, 'LRC'),
(12, 'MCC', 2, 'LRC'),
(13, 'MCC', 2, 'LRC'),
(14, 'MCC', 2, 'LRC'),
(15, 'MCC', 2, 'LRC'),
(16, 'MCC', 2, 'LRC'),
(17, 'MCC', 2, 'LRC'),
(18, 'MCC', 2, 'LRC'),
(19, 'MCC', 2, 'LRC'),
(20, 'MCC', 3, 'LRC'),
(21, 'MCC', 4, 'LRC'),
(22, 'MCC', 5, 'LRC'),
(23, 'MCC', 6, 'LRC'),
(24, 'MCC', 7, 'LRC'),
(25, 'MCC', 8, 'LRC'),
(26, 'MCC', 9, 'LRC'),
(27, 'MCC', 10, 'LRC'),
(28, 'MCC', 11, 'LRC'),
(29, 'MCC', 12, 'LRC'),
(30, 'MCC', 13, 'LRC'),
(31, 'MCC', 14, 'LRC'),
(32, 'MCC', 15, 'LRC'),
(33, 'MCC', 16, 'LRC'),
(34, 'MCC', 17, 'LRC'),
(35, 'MCC', 18, 'LRC'),
(36, 'MCC', 19, 'LRC'),
(37, 'MCC', 20, 'LRC'),
(38, 'MCC', 21, 'LRC'),
(39, 'MCC', 22, 'LRC'),
(40, 'MCC', 23, 'LRC'),
(41, 'MCC', 24, 'LRC'),
(42, 'MCC', 25, 'LRC'),
(43, 'MCC', 26, 'LRC'),
(44, 'MCC', 27, 'LRC'),
(45, 'MCC', 28, 'LRC'),
(46, 'MCC', 29, 'LRC'),
(47, 'MCC', 30, 'LRC'),
(48, 'MCC', 31, 'LRC'),
(49, 'MCC', 32, 'LRC'),
(50, 'MCC', 33, 'LRC'),
(51, 'MCC', 34, 'LRC'),
(52, 'MCC', 35, 'LRC'),
(53, 'MCC', 36, 'LRC'),
(54, 'MCC', 37, 'LRC'),
(55, 'MCC', 38, 'LRC'),
(56, 'MCC', 39, 'LRC'),
(57, 'MCC', 40, 'LRC'),
(58, 'MCC', 41, 'LRC'),
(59, 'MCC', 42, 'LRC'),
(60, 'MCC', 43, 'LRC'),
(61, 'MCC', 44, 'LRC'),
(62, 'MCC', 45, 'LRC'),
(63, 'MCC', 46, 'LRC'),
(64, 'MCC', 47, 'LRC'),
(65, 'MCC', 48, 'LRC'),
(66, 'MCC', 49, 'LRC'),
(67, 'MCC', 0, 'LRC'),
(68, 'MCC', 0, 'LRC'),
(69, 'MCC', 0, 'LRC'),
(70, 'MCC', 0, 'LRC');

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
  `copy` int(20) NOT NULL,
  `barcode` varchar(50) NOT NULL,
  `book_image` varchar(100) NOT NULL,
  `date_added` datetime NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`book_id`, `call_number`, `accession_number`, `title`, `category_id`, `author`, `copyright_date`, `publisher`, `place_publication`, `isbn`, `copy`, `barcode`, `book_image`, `date_added`, `status`) VALUES
(83, '25325423', '2414', 'ffsdfsdf', 1, 'fgdsgfg', '43r252', 'dgdgd', 'dgegwg', '3252354325', 2, 'MCC2414LRC', '1719934889.jpg', '2024-07-02 23:41:29', 'Available'),
(84, '25325423', '23432', 'ffsdfsdf', 1, 'fgdsgfg', '43r252', 'dgdgd', 'dgegwg', '3252354325', 2, 'MCC23432LRC', '1719934889.jpg', '2024-07-02 23:41:30', 'Available');

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
  `book_penalty` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `borrow_book`
--

INSERT INTO `borrow_book` (`borrow_book_id`, `user_id`, `faculty_id`, `book_id`, `date_borrowed`, `due_date`, `date_returned`, `borrowed_status`, `book_penalty`) VALUES
(587, 84, 0, 55, '2024-07-02 15:12:08', '2024-07-05 15:12:08', '2024-07-02 15:13:24', 'returned', 'No Penalty'),
(588, 84, 0, 55, '2024-07-02 15:17:34', '2024-07-05 15:17:34', '2024-07-02 15:23:15', 'returned', 'No Penalty');

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
(2, 'Foreign Section'),
(3, 'Reserved Section'),
(4, 'Periodical Section'),
(5, 'Fiction Section');

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `faculty_id` int(11) NOT NULL,
  `employee_id_no` varchar(45) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `middlename` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `nickname` varchar(45) NOT NULL,
  `gender` varchar(45) NOT NULL,
  `department` varchar(45) NOT NULL,
  `employment_status` varchar(45) NOT NULL,
  `address` varchar(45) NOT NULL,
  `cell_no` varchar(25) NOT NULL,
  `birthdate` varchar(45) NOT NULL,
  `contact_person` varchar(45) NOT NULL,
  `contact_person_no` varchar(25) NOT NULL,
  `username` varchar(45) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role_as` tinyint(4) NOT NULL DEFAULT 0,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `faculty_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`faculty_id`, `employee_id_no`, `firstname`, `middlename`, `lastname`, `nickname`, `gender`, `department`, `employment_status`, `address`, `cell_no`, `birthdate`, `contact_person`, `contact_person_no`, `username`, `email`, `role_as`, `status`, `faculty_added`) VALUES
(6, '1234', 'Relina', '', 'Jabal-balili', '', 'Female', 'BSIT', '1234', 'Unknown', '(+63) 9123-456-789', '2022-12-12', 'Unknown', '(+63) 9123-456-789', 'Relina', 'relina@gmail.com', 0, 0, '2022-12-13 20:56:01'),
(7, '124775567', 'Lovely', '', 'Umbao', 'Lovely', 'Female', 'BSED', 'none', 'Maalat, Madridejos, Cebu', '(+63) 9123-456-789', '2000-09-08', 'Umbao Lovely', '(+63) 9123-456-789', 'Lovely', 'lovelyumbao@gmail.com', 0, 0, '2022-12-15 21:42:29'),
(8, '32544785', 'Manilyn', '', 'Galang', 'Manilyn', 'Female', 'BEED', 'none', 'Okoy, Santa Fe, Cebu', '(+63) 9123-456-789', '2000-03-06', 'Manilyn Galang', '(+63) 9123-456-789', 'Manilyn', 'manilyngalang@gmail.com', 0, 0, '2022-12-15 21:45:32'),
(9, '27487585868', 'Jecel', '', 'Mancio', 'Jecel', 'Female', 'BSBA', 'none', 'Bunakan, Madridejos, Cebu', '(+63) 9123-456-789', '2000-07-08', 'Jecel Mancio', '(+63) 9123-456-789', 'Jecel', 'jecelmancio@gmail.com', 0, 0, '2022-12-15 21:47:41'),
(10, '58573553', 'Rubelyns', '', 'Seville', 'Rubelyn', 'Female', 'BSHM', 'none', 'Mancilang, Madridejos, Cebu', '(+63) 9123-456-789', '2000-02-24', 'Rubelyn Seville', '(+63) 9123-456-789', 'Rubelyn', 'rubelynseville@gmail.com', 0, 0, '2022-12-15 21:50:00');

-- --------------------------------------------------------

--
-- Table structure for table `holds`
--

CREATE TABLE `holds` (
  `hold_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `hold_status` varchar(50) NOT NULL,
  `hold_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `holds`
--

INSERT INTO `holds` (`hold_id`, `book_id`, `user_id`, `hold_status`, `hold_date`) VALUES
(60, 69, 87, '', '2024-07-02 15:04:59'),
(61, 55, 87, '', '2024-07-02 15:08:29');

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
(1, 20),
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
(1247, 55, 1, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2022-12-14 01:53:18'),
(1248, 55, 44, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2022-12-14 01:53:57'),
(1249, 55, 1, 0, 'Relina  Jabal-balili', 'Returned Book', '2022-12-14 01:54:26'),
(1250, 55, 44, 0, 'Relina  Jabal-balili', 'Returned Book', '2022-12-14 01:55:02'),
(1251, 56, 0, 6, 'Relina  Jabal-balili', 'Borrowed Book', '2022-12-14 01:56:23'),
(1252, 56, 0, 6, 'Relina  Jabal-balili', 'Returned Book', '2022-12-14 01:56:45'),
(1253, 55, 1, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2022-12-14 10:34:44'),
(1254, 55, 1, 0, 'Relina  Jabal-balili', 'Returned Book', '2022-12-14 10:36:46'),
(1255, 55, 0, 6, 'Relina  Jabal-balili', 'Borrowed Book', '2022-12-14 10:37:53'),
(1256, 55, 0, 6, 'Relina  Jabal-balili', 'Returned Book', '2022-12-14 10:38:12'),
(1257, 55, 1, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2022-12-15 21:51:25'),
(1258, 56, 1, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2022-12-15 21:51:47'),
(1259, 57, 1, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2022-12-15 21:51:58'),
(1260, 59, 45, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2022-12-15 21:53:08'),
(1261, 66, 45, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2022-12-15 21:53:32'),
(1262, 69, 45, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2022-12-15 21:53:51'),
(1263, 69, 0, 6, 'Relina  Jabal-balili', 'Borrowed Book', '2022-12-15 21:55:13'),
(1264, 57, 1, 0, 'Relina  Jabal-balili', 'Returned Book', '2022-12-20 22:11:58'),
(1265, 55, 1, 0, 'Relina  Jabal-balili', 'Returned Book', '2022-12-20 22:16:18'),
(1266, 56, 1, 0, 'Relina  Jabal-balili', 'Returned Book', '2022-12-20 22:16:36'),
(1267, 69, 45, 0, 'Relina  Jabal-balili', 'Returned Book', '2022-12-22 00:08:33'),
(1268, 59, 45, 0, 'Relina  Jabal-balili', 'Returned Book', '2022-12-22 00:08:48'),
(1269, 66, 45, 0, 'Relina  Jabal-balili', 'Returned Book', '2022-12-22 00:09:04'),
(1270, 69, 0, 6, 'Relina  Jabal-balili', 'Returned Book', '2022-12-15 23:40:14'),
(1271, 55, 32, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2022-12-16 09:02:45'),
(1272, 55, 31, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2022-12-16 11:00:06'),
(1273, 65, 45, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2022-12-16 11:02:55'),
(1274, 66, 45, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2022-12-16 11:03:40'),
(1275, 57, 46, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2022-12-16 11:05:03'),
(1276, 58, 47, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2022-12-16 11:06:09'),
(1277, 59, 48, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2022-12-16 11:06:38'),
(1278, 60, 50, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2022-12-16 11:07:15'),
(1279, 61, 52, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2022-12-16 11:07:47'),
(1280, 55, 1, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2022-12-16 15:19:48'),
(1281, 55, 1, 0, 'Relina  Jabal-balili', 'Returned Book', '2022-12-16 15:20:38'),
(1282, 55, 1, 0, 'Relina  Jabal-balili', 'Returned Book', '2022-12-16 15:20:40'),
(1283, 55, 1, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2023-03-29 11:01:44'),
(1284, 55, 0, 6, 'Relina  Jabal-balili', 'Borrowed Book', '2023-04-03 11:04:21'),
(1285, 55, 0, 6, 'Relina  Jabal-balili', 'Returned Book', '2023-09-02 11:47:16'),
(1286, 55, 1, 0, 'Relina  Jabal-balili', 'Returned Book', '2023-09-02 11:48:49'),
(1287, 55, 1, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2023-03-29 11:10:33'),
(1288, 55, 1, 0, 'Relina  Jabal-balili', 'Returned Book', '2023-03-29 11:11:33'),
(1289, 55, 1, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2023-03-29 20:52:21'),
(1290, 55, 1, 0, 'Relina  Jabal-balili', 'Returned Book', '2023-03-29 20:54:45'),
(1291, 55, 1, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2023-03-29 20:55:22'),
(1292, 55, 0, 6, 'Relina  Jabal-balili', 'Borrowed Book', '2023-03-29 21:58:36'),
(1293, 55, 0, 6, 'Relina  Jabal-balili', 'Returned Book', '2023-03-29 21:59:44'),
(1294, 55, 1, 0, 'Relina  Jabal-balili', 'Returned Book', '2023-04-02 22:03:03'),
(1295, 55, 1, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2023-03-29 22:08:41'),
(1296, 55, 1, 0, 'Relina  Jabal-balili', 'Returned Book', '2023-04-03 22:10:00'),
(1297, 55, 1, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2023-03-31 11:15:08'),
(1298, 55, 1, 0, 'Relina  Jabal-balili', 'Returned Book', '2023-03-31 11:35:25'),
(1299, 55, 1, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2023-03-31 11:40:57'),
(1300, 55, 1, 0, 'Relina  Jabal-balili', 'Returned Book', '2023-04-04 13:01:45'),
(1301, 55, 1, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2023-04-04 14:06:53'),
(1302, 55, 1, 0, 'Relina  Jabal-balili', 'Returned Book', '2023-04-04 14:07:09'),
(1303, 55, 1, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2023-04-04 14:09:19'),
(1304, 55, 1, 0, 'Relina  Jabal-balili', 'Returned Book', '2023-04-05 16:23:00'),
(1305, 55, 1, 0, 'Relina  Jabal-balili', 'Borrowed Book', '2023-04-06 16:09:53'),
(1306, 55, 1, 0, 'Relina  Jabal-balili', 'Returned Book', '2023-04-06 16:10:21'),
(1307, 55, 1, 0, 'Relinas  Jabal-balili', 'Borrowed Book', '2023-04-08 08:25:48'),
(1308, 55, 84, 0, 'Relinas  Jabal-balili', 'Borrowed Book', '2024-07-02 15:12:15'),
(1309, 55, 84, 0, 'Relinas  Jabal-balili', 'Returned Book', '2024-07-02 15:13:24'),
(1310, 55, 84, 0, 'Relinas  Jabal-balili', 'Borrowed Book', '2024-07-02 15:19:17'),
(1311, 55, 84, 0, 'Relinas  Jabal-balili', 'Returned Book', '2024-07-02 15:23:15');

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
(627, 84, 0, 55, '2024-07-02 15:12:08', '2024-07-05 15:12:08', '2024-07-02 15:13:18', 'No Penalty'),
(628, 84, 0, 55, '2024-07-02 15:17:34', '2024-07-05 15:17:34', '2024-07-02 15:22:56', 'No Penalty');

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
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `cpassword` varchar(255) NOT NULL,
  `role_as` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `user_added` datetime NOT NULL,
  `qr_code` varchar(255) NOT NULL,
  `reset_token` varchar(100) NOT NULL,
  `token_expiry` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_log_id`, `lastname`, `firstname`, `middlename`, `gender`, `course`, `address`, `cell_no`, `birthdate`, `email`, `year_level`, `student_id_no`, `username`, `password`, `cpassword`, `role_as`, `status`, `user_added`, `qr_code`, `reset_token`, `token_expiry`) VALUES
(84, 0, 'Calatero', 'Diovin', 'Pasicaran', 'Male', 'BSIT', 'Patao, Bantayan, Cebu', '09858024662', '2002-03-14', 'bman23382@gmail.com', '4th year', '2021-1055', '', '$2y$10$AYJwsS7T8yi1Vj1SdFNBOebvWM1UorXDjsJma.02uq4YsGaudnNTi', '', 'student', 'approved', '2024-07-01 20:04:19', '2021-1055.png', '', '0000-00-00 00:00:00'),
(85, 0, 'Ofianga', 'Joana', '', 'Female', 'BSIT', 'Pili, Madridejos, Cebu', '09123456789', '2002-06-19', 'ofiangajoana22@gmail.com', '4th year', '2021-1181', '', '$2y$10$ceZfbQE.yM8052SZJvaGs.yzcOXfmr3mNHY1WOEtJR3nxT/MZ5naW', '', 'student', 'approved', '2024-07-01 20:53:47', '2021-1181.png', '', '0000-00-00 00:00:00'),
(86, 0, 'Calatero', 'Diovin', 'Pasicaran', 'Male', 'BSIT', 'Patao, Bantayan, Cebu', '09858024662', '2002-03-14', 'bman23382@gmail.com', '', '', 'diovin', '$2y$10$X2TKGGTDn0M7K5sjjtmYeOYTL8ZucnABKmVES0GqRd4TBV6sEzequ', '', 'faculty', 'approved', '2024-07-01 21:32:47', 'diovin.png', '', '0000-00-00 00:00:00'),
(87, 0, 'Cahutay', 'Mayette', 'Dela Pena', 'Female', 'BSIT', 'Pili, Madridejos, Cebu', '09647364736', '2022-05-21', 'cahutaymayette2002@gmail.com', '4th year', '2021-1180', '', '$2y$10$sN3tYonteOFOcMYDJcGI0OhRyuBJXjx.U3V09yakqDPFJE/X2FOGq', '', 'student', 'approved', '2024-07-02 14:38:22', '2021-1180.png', '', '0000-00-00 00:00:00'),
(88, 0, 'Mata', 'Romeo', '', 'Male', 'BSED', 'Patao, Bantayan, Cebu', '09675643353', '2002-12-12', 'mata@gmail.com', '4th year', '2021-1170', '', '$2y$10$CNbhgHwpuqW.oayUqA.q4.SvNbv8aO9AbAnf3xLlISlJvcR7f5MAy', '', 'student', 'approved', '2024-07-02 15:28:33', '2021-1170.png', '', '0000-00-00 00:00:00');

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
(266, '2021-1055', 'Calatero', 'Diovin', 'Pasicaran', '18:14:48', '2024-07-02', '00:00:00', 'BSIT', '4th year', 'student'),
(267, '2021-1181', 'Ofianga', 'Joana', '', '18:19:47', '2024-07-02', '00:00:00', 'BSIT', '4th year', 'student'),
(268, 'diovin', 'Calatero', 'Diovin', 'Pasicaran', '18:20:01', '2024-07-02', '00:00:00', 'BSIT', 'faculty', 'faculty'),
(269, '2021-1170', 'Mata', 'Romeo', '', '18:21:42', '2024-07-02', '00:00:00', 'BSED', '4th year', 'student');

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
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`faculty_id`);

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
  MODIFY `barcode_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `borrow_book`
--
ALTER TABLE `borrow_book`
  MODIFY `borrow_book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=589;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=801;

--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
  MODIFY `faculty_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `holds`
--
ALTER TABLE `holds`
  MODIFY `hold_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `penalty`
--
ALTER TABLE `penalty`
  MODIFY `penalty_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `report`
--
ALTER TABLE `report`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1312;

--
-- AUTO_INCREMENT for table `return_book`
--
ALTER TABLE `return_book`
  MODIFY `return_book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=629;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `user_log`
--
ALTER TABLE `user_log`
  MODIFY `user_log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=270;

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
