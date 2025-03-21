-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 13, 2024 at 06:54 AM
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
) ENGINE=MyISAM AUTO_INCREMENT=93 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purpose_of_visit`
--

DROP TABLE IF EXISTS `purpose_of_visit`;
CREATE TABLE IF NOT EXISTS `purpose_of_visit` (
  `purpose` tinytext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
