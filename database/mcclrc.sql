-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 29, 2024 at 12:59 AM
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
  `admin_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `firstname`, `middlename`, `lastname`, `email`, `address`, `phone_number`, `password`, `confirm_password`, `admin_image`, `admin_type`, `admin_added`) VALUES
(42, 'Diovin', 'Pasicaran', 'Calatero', 'diovincalatero150@gmail.com', 'Patao, Bantayan, Cebu', '09858024662', '$2y$10$DqhTbOtMAdSgVbEnBnq57.FFlvNuw3Y4XvYEiGJJKcmjhuRB1Y5Lu', '', '1722155329.webp', 'Staff', '2024-07-28 16:28:49'),
(43, 'Relina', '', 'Jabal-Balili', 'admin@gmail.com', 'secret', '09123456789', '$2y$10$MpZjrHt4vuw52aURtC1PuOCoubx9d5JzwqUsapgAIqoMoO6IucbiK', '', '1722156775.webp', 'Admin', '2024-07-28 16:52:55');

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
  `status` varchar(50) NOT NULL,
  `status_hold` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`book_id`, `call_number`, `accession_number`, `title`, `category_id`, `author`, `copyright_date`, `publisher`, `place_publication`, `isbn`, `barcode`, `book_image`, `date_added`, `status`, `status_hold`) VALUES
(93, '1234', '1234', 'Computer Programming', 1, 'Rich', '2021', 'Mann', 'Kingdom', '12345678', 'MCC-LRC1234', '1719979739.jpg', '2024-07-03 12:08:59', 'Unavailable', ''),
(94, '1234', '5678', 'Computer Programming', 1, 'Rich', '2021', 'Mann', 'Kingdom', '12345678', 'MCC-LRC5678', '1719979739.jpg', '2024-07-03 12:08:59', 'Unavailable', ''),
(95, '5678', '8765', 'C# Programming', 5, 'Black', '2021', 'Mann', 'Clover', '123456789', 'MCC-LRC8765', '1719979865.jfif', '2024-07-03 12:11:05', 'Available', ''),
(96, '5678', '4321', 'C# Programming', 5, 'Black', '2021', 'Mann', 'Clover', '123456789', 'MCC-LRC4321', '1719979865.jfif', '2024-07-03 12:11:05', 'Available', '');

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
  `accession_number` varchar(255) NOT NULL,
  `notification_status` varchar(10) DEFAULT 'Unread'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
  `verify_token` varchar(255) NOT NULL,
  `token_used` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`faculty_id`, `lastname`, `firstname`, `middlename`, `gender`, `course`, `address`, `cell_no`, `birthdate`, `email`, `username`, `password`, `cpassword`, `role_as`, `status`, `faculty_added`, `qr_code`, `verify_token`, `token_used`) VALUES
(16, 'Black', 'Mann', '', 'Male', 'BSIT', 'Patao, Bantayan, Cebu', '09858024662', '2002-12-03', 'diovincalatero150@gmail.com', 'blackmann', '$2y$10$DrhIer5JAjRH3gAuBAzJ6ejsvZZ/PMdaf/D0jL/a04uUdtrJNxFjO', '', 'staff', 'approved', '2024-07-28 10:26:42', 'blackmann.png', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `holds`
--

CREATE TABLE `holds` (
  `hold_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
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

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
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
  `verify_token` varchar(255) NOT NULL,
  `token_used` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `lastname`, `firstname`, `middlename`, `gender`, `course`, `address`, `cell_no`, `birthdate`, `email`, `year_level`, `student_id_no`, `password`, `cpassword`, `role_as`, `status`, `user_added`, `qr_code`, `verify_token`, `token_used`) VALUES
(84, 'Calatero', 'Diovin', 'Pasicaran', 'Male', 'BSIT', 'Patao, Bantayan, Cebu', '09858024662', '2002-03-14', 'bman23382@gmail.com', '4th year', '2021-1055', '$2y$10$frgxFJiWLEjHNpKXmR86AejUIG/Q6oIYTFt8HFfMUhRhkU3KMbbgO', '', 'student', 'approved', '2024-07-01 20:04:19', '2021-1055.png', '53bd9966145af9c18ec597434e607e29', 0);

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
  ADD PRIMARY KEY (`user_id`);

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
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

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
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `borrow_book`
--
ALTER TABLE `borrow_book`
  MODIFY `borrow_book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=714;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=801;

--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
  MODIFY `faculty_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `holds`
--
ALTER TABLE `holds`
  MODIFY `hold_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT for table `penalty`
--
ALTER TABLE `penalty`
  MODIFY `penalty_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `report`
--
ALTER TABLE `report`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1533;

--
-- AUTO_INCREMENT for table `return_book`
--
ALTER TABLE `return_book`
  MODIFY `return_book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=737;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

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
