-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 19, 2025 at 04:05 PM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `library_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `admin_id` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `pass_hash` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `pass_hash`) VALUES
('admin', '$2y$10$mC2eijwR.Hzay76aXUEYCeSSBTtO/nYdwnyiYjJfz43ZA6Ym7W6DW');

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

DROP TABLE IF EXISTS `branch`;
CREATE TABLE IF NOT EXISTS `branch` (
  `Name` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`Name`) VALUES
('Electronics and Communication Engineering'),
('Computer Science and Business Studies'),
('Computer Science and Design'),
('Artificial Intelligence and Machine Learning'),
('Computer Science and Engineering');

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

DROP TABLE IF EXISTS `faculty`;
CREATE TABLE IF NOT EXISTS `faculty` (
  `emp_id` varchar(10) NOT NULL,
  `Fname` tinytext NOT NULL,
  `dept` tinytext NOT NULL,
  `EntryKey` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`emp_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`emp_id`, `Fname`, `dept`, `EntryKey`) VALUES
('1234567890', 'Faculty 1', 'Computer Science and Engineering', '67890');

-- --------------------------------------------------------

--
-- Table structure for table `faculty_history`
--

DROP TABLE IF EXISTS `faculty_history`;
CREATE TABLE IF NOT EXISTS `faculty_history` (
  `slno` int NOT NULL AUTO_INCREMENT,
  `emp_id` varchar(10) NOT NULL,
  `dept` tinytext NOT NULL,
  `purpose` tinytext NOT NULL,
  `TimeIn` time NOT NULL,
  `TimeOut` time DEFAULT NULL,
  `Date` date NOT NULL,
  PRIMARY KEY (`slno`)
) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `faculty_history`
--

INSERT INTO `faculty_history` (`slno`, `emp_id`, `dept`, `purpose`, `TimeIn`, `TimeOut`, `Date`) VALUES
(44, '1234567890', 'Computer Science and Engineering', 'Reading a Book', '10:44:57', '10:45:15', '2024-12-08'),
(43, '1234567890', 'Computer Science and Engineering', 'Reading a Book', '10:38:37', '10:38:58', '2024-12-08'),
(42, '1234567890', 'Computer Science and Engineering', 'Reading a Book', '10:32:19', '10:38:17', '2024-12-08');

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

DROP TABLE IF EXISTS `history`;
CREATE TABLE IF NOT EXISTS `history` (
  `slno` int NOT NULL AUTO_INCREMENT,
  `USN` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `Branch` tinytext NOT NULL,
  `Cyear` tinyint(1) NOT NULL,
  `purpose` tinytext NOT NULL,
  `TimeIn` time NOT NULL,
  `TimeOut` time DEFAULT NULL,
  `Date` date NOT NULL,
  PRIMARY KEY (`slno`)
) ENGINE=MyISAM AUTO_INCREMENT=102 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`slno`, `USN`, `Branch`, `Cyear`, `purpose`, `TimeIn`, `TimeOut`, `Date`) VALUES
(83, '4CB22CS020', 'Computer Science and Engineering', 4, 'Reading a Book', '10:38:27', '10:38:51', '2024-12-08'),
(84, '4CB22CS020', 'Computer Science and Engineering', 4, 'Reading a Book', '10:41:56', '10:42:03', '2024-12-08'),
(85, '4CB22CS031', 'Computer Science and Engineering', 4, 'Reading a Book', '10:44:37', '10:45:08', '2024-12-08'),
(86, '4CB22CS045', 'Computer Science and Engineering', 4, 'Reading the Newspaper', '12:16:19', '12:17:33', '2024-12-08'),
(87, '4CB22CS031', 'Computer Science and Engineering', 4, 'Reading a Book', '10:07:08', '10:07:56', '2024-12-11'),
(88, '4CB22CS020', 'Computer Science and Engineering', 4, 'Reading the Newspaper', '22:01:42', '22:01:46', '2024-12-11'),
(89, '4CB22CS031', 'Computer Science and Engineering', 4, 'Reading the Newspaper', '19:06:15', '19:06:23', '2025-01-07'),
(90, '4CB22CS031', 'Computer Science and Engineering', 4, 'Reading a Book', '19:16:32', '19:16:40', '2025-01-07'),
(91, '4CB22CS031', 'Computer Science and Engineering', 4, 'Reading a Book', '19:24:30', '19:24:40', '2025-01-07'),
(92, '4CB22CS031', 'Computer Science and Engineering', 4, 'Reading a Book', '19:25:19', '19:25:25', '2025-01-07'),
(93, '4CB22CS031', 'Computer Science and Engineering', 4, 'Reading a Book', '19:27:12', '19:27:14', '2025-01-07'),
(94, '4CB22CS031', 'Computer Science and Engineering', 4, 'Reading a Book', '19:29:04', '19:29:09', '2025-01-07'),
(95, '4CB22CS031', 'Computer Science and Engineering', 4, 'Reading a Book', '19:31:20', '19:31:26', '2025-01-07'),
(96, '4CB22CS031', 'Computer Science and Engineering', 4, 'Reading a Book', '19:35:16', '19:35:17', '2025-01-07'),
(97, '4CB22CS008', 'Computer Science and Engineering', 4, 'Reading a Book', '10:04:23', '10:23:20', '2025-02-07'),
(98, '4CB22CS031', 'Computer Science and Engineering', 4, 'Reading a Book', '10:05:35', '10:23:31', '2025-02-07'),
(99, '4CB22CS031', 'Computer Science and Engineering', 4, 'Reading the Newspaper', '10:29:53', '10:30:45', '2025-02-07'),
(100, '4CB22CS031', 'Computer Science and Engineering', 4, 'Reading the Newspaper', '14:24:55', '14:25:17', '2025-03-09'),
(101, '4CB22CS031', 'Computer Science and Engineering', 4, 'Reading the Newspaper', '14:29:33', '14:30:19', '2025-03-09');

-- --------------------------------------------------------

--
-- Table structure for table `purpose_of_visit`
--

DROP TABLE IF EXISTS `purpose_of_visit`;
CREATE TABLE IF NOT EXISTS `purpose_of_visit` (
  `purpose` tinytext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `purpose_of_visit`
--

INSERT INTO `purpose_of_visit` (`purpose`) VALUES
('Reading a Book'),
('Reading the Newspaper');

-- --------------------------------------------------------

--
-- Table structure for table `super_user`
--

DROP TABLE IF EXISTS `super_user`;
CREATE TABLE IF NOT EXISTS `super_user` (
  `sUser_id` varchar(10) NOT NULL,
  `pass_hash` varchar(255) NOT NULL,
  PRIMARY KEY (`sUser_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `super_user`
--

INSERT INTO `super_user` (`sUser_id`, `pass_hash`) VALUES
('institute', '$2y$10$mC2eijwR.Hzay76aXUEYCeSSBTtO/nYdwnyiYjJfz43ZA6Ym7W6DW');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `USN` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Sname` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Branch` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Section` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `RegYear` smallint NOT NULL,
  `EntryKey` varchar(3) NOT NULL,
  `Cyear` tinyint(1) NOT NULL,
  `last_promoted_at` date DEFAULT NULL,
  PRIMARY KEY (`USN`),
  UNIQUE KEY `USN` (`USN`),
  UNIQUE KEY `USN_2` (`USN`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`USN`, `Sname`, `Branch`, `Section`, `RegYear`, `EntryKey`, `Cyear`, `last_promoted_at`) VALUES
('4CB22CS031', 'Christy Sojan', 'Computer Science and Engineering', 'A', 2022, '031', 4, NULL),
('4CB22CS025', 'Paveen Bangera', 'Computer Science and Engineering', 'A', 2022, '025', 4, NULL),
('4CB22CS048', 'H Sumith Shenoy', 'Computer Science and Business Studies', 'D', 2022, '048', 4, NULL),
('4CB22CS020', 'B M Yashwanth', 'Computer Science and Engineering', 'A', 2022, '020', 4, NULL),
('4CB22CS045', 'Harshith M H', 'Computer Science and Engineering', 'A', 2022, '045', 4, NULL),
('4CB22CS008', 'Amrutesh', 'Computer Science and Engineering', 'A', 2022, '008', 4, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_login`
--

DROP TABLE IF EXISTS `user_login`;
CREATE TABLE IF NOT EXISTS `user_login` (
  `id` varchar(5) NOT NULL,
  `pass_hash` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_login`
--

INSERT INTO `user_login` (`id`, `pass_hash`) VALUES
('user', '$2y$10$mC2eijwR.Hzay76aXUEYCeSSBTtO/nYdwnyiYjJfz43ZA6Ym7W6DW');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
