-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 20, 2014 at 04:51 PM
-- Server version: 5.5.40-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bd_byopc`
--

--
-- Table structure for table `survey_questions`
--

CREATE TABLE IF NOT EXISTS `survey_questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `desc` varchar(2000) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `type` set('YesNo','Numeric','Text','Others') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Others',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `survey_questions`
--

INSERT INTO `survey_questions` (`id`, `desc`, `created_at`, `type`) VALUES
(1, 'Would you like to pay for your work laptop out of your own pocket?', '2014-11-04 18:04:26', 'YesNo'),
(2, 'I am satisfied with my current BD issued laptop', '2014-11-04 18:04:26', 'Numeric'),
(3, 'I currently own a personal laptop', '2014-11-04 18:04:26', 'YesNo'),
(4, 'I would like to bring my personal laptop into the office', '2014-11-08 00:46:30', 'YesNo');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=63 ;

--
-- Dumping data for table `survey_results`
--

INSERT INTO `survey_results` (`id`, `userid`, `surveyid`, `value`, `created_at`) VALUES
(35, 4, 1, 0, '2014-11-08 17:09:46'),
(36, 4, 4, 1, '2014-11-08 17:09:55'),
(37, 4, 2, 5, '2014-11-08 17:09:55'),
(38, 4, 3, 1, '2014-11-08 17:09:55'),
(39, 5, 1, 1, '2014-11-13 21:08:06'),
(40, 5, 2, 1, '2014-11-13 21:08:20'),
(41, 5, 3, 1, '2014-11-13 21:08:20'),
(42, 5, 4, 1, '2014-11-13 21:08:20'),
(43, 6, 1, 1, '2014-11-13 21:08:56'),
(44, 6, 4, 1, '2014-11-13 21:09:02'),
(45, 6, 2, 2, '2014-11-13 21:09:02'),
(46, 6, 3, 1, '2014-11-13 21:09:02'),
(47, 7, 1, 0, '2014-11-20 21:27:18'),
(48, 7, 2, 4, '2014-11-20 21:27:18'),
(49, 7, 3, 1, '2014-11-20 21:27:37'),
(50, 7, 4, 0, '2014-11-20 21:27:37'),
(51, 8, 1, 1, '2014-11-20 21:28:00'),
(52, 8, 2, 3, '2014-11-20 21:28:00'),
(53, 8, 3, 1, '2014-11-20 21:28:27'),
(54, 8, 4, 1, '2014-11-20 21:28:27'),
(55, 9, 1, 0, '2014-11-20 21:28:54'),
(56, 9, 2, 5, '2014-11-20 21:28:54'),
(57, 9, 3, 0, '2014-11-20 21:29:26'),
(58, 9, 4, 1, '2014-11-20 21:29:26'),
(59, 10, 1, 1, '2014-11-20 21:29:42'),
(60, 10, 2, 2, '2014-11-20 21:29:42'),
(61, 10, 3, 1, '2014-11-20 21:30:00'),
(62, 10, 4, 0, '2014-11-20 21:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `role` set('normal','admin') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'normal',
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT '0',
  `participate` int(1) NOT NULL DEFAULT '-1',
  `model` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'unspecified',
  `os` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'unspecified',
  `comment` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `role`, `password`, `salt`, `completed`, `participate`, `model`, `os`, `comment`) VALUES
(3, 'mike', 'admin', '9c01c96cd422112c19494de74ef52bab3caab6b2fb9d9ebe5b3a66faf313d9f1', '3c1935ca170b6614', 1, 0, 'Lenovo', 'Windows 7', 'That''s too expensive!'),
(4, 'joker', 'normal', 'c8b939ea3d14bae4b5181da2b2b57f8b542e3cb639882ba83ffeba41f27599d1', '1c71b27a1dee24bd', 0, 1, 'Acer', 'Linux', NULL),
(5, 'joe', 'normal', '122024dbde90dacfd02736b1fda1a2e64eb4b34edc30acc3c2b703b51ff87068', '3aca586d37051418', 0, 1, 'Dell', 'Windows 8', NULL),
(6, 'Kat', 'normal', '17cc96c9835e4016ddba42b3497709460b47584538d2e69b996746af0421e2ed', '9c8d91eb72ea3b', 0, 0, 'HP', 'Windows 7', NULL),
(7, 'Jessica', 'normal', NULL, NULL, 1, 1, 'Acer', 'Windows 8', NULL),
(8, 'Tom', 'normal', NULL, NULL, 0, 1, 'Lenovo', 'Windows 7', NULL),
(9, 'Dave', 'normal', NULL, NULL, 1, 0, 'Dell', 'Windows XP', NULL),
(10, 'Matt', 'normal', NULL, NULL, 0, 0, 'Apple', 'OSx', NULL);

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