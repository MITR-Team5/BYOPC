-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 04, 2014 at 09:27 PM
-- Server version: 5.5.32
-- PHP Version: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bd_byopc`
--
CREATE DATABASE IF NOT EXISTS `bd_byopc` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `bd_byopc`;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'Anonymous'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`created_at`, `value`, `username`) VALUES
('0000-00-00 00:00:00', 'test comment', NULL),
('0000-00-00 00:00:00', 'test comment', 'mikeogod');

-- --------------------------------------------------------

--
-- Table structure for table `survey_questions`
--

CREATE TABLE IF NOT EXISTS `survey_questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `desc` varchar(2000) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `survey_questions`
--

INSERT INTO `survey_questions` (`id`, `desc`, `created_at`) VALUES
(1, 'desc0', '2014-11-04 18:04:26'),
(2, 'desc1', '2014-11-04 18:04:26'),
(3, 'desc2', '2014-11-04 18:04:26');

-- --------------------------------------------------------

--
-- Table structure for table `survey_results`
--

CREATE TABLE IF NOT EXISTS `survey_results` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `surveyid` int(11) NOT NULL,
  `value` int(2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  KEY `surveyid` (`surveyid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `survey_results`
--

INSERT INTO `survey_results` (`id`, `userid`, `surveyid`, `value`, `created_at`) VALUES
(2, 1, 1, 1, '2014-11-04 18:10:38'),
(3, 1, 2, 3, '2014-11-04 18:10:38'),
(4, 1, 3, 2, '2014-11-04 18:10:38');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `role` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'normal',
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `role`, `password`, `salt`) VALUES
(1, 'mikeogod', 'admin', 'b1d86f0775cbd7faf23b2f36977f5eb08a4ef148b474c76edc81999fe4ffe222', '46d42d7a783f21ad'),
(2, 'mikeogod1', 'normal', '46b9c44ff9ffc04f3eae44a9c2597ffc72318a460d85a4e02762f9873193ddc6', '25d4f02612c8301d');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `survey_results`
--
ALTER TABLE `survey_results`
  ADD CONSTRAINT `survey_results_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `survey_results_ibfk_2` FOREIGN KEY (`surveyid`) REFERENCES `survey_questions` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
