-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: May 25, 2022 at 04:50 PM
-- Server version: 10.3.28-MariaDB-1:10.3.28+maria~focal-log
-- PHP Version: 7.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db`
--

-- --------------------------------------------------------

--
-- Table structure for table `content_both_top_500`
--

CREATE TABLE `content_both_top_500` (
  `id` int(11) NOT NULL,
  `name` int(11) NOT NULL,
  `link` varchar(255) NOT NULL,
  `title` text NOT NULL,
  `breadcrumb` text NOT NULL,
  `translation_title` text NOT NULL,
  `translation_breadcrumb` text NOT NULL,
  `language` varchar(2) NOT NULL,
  `translation_language` varchar(2) NOT NULL,
  `content` longtext CHARACTER SET utf8mb4 NOT NULL,
  `translation_content` longtext NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `modified` date NOT NULL,
  `path` varchar(255) NOT NULL,
  `translation_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `content_both_top_500`
--
ALTER TABLE `content_both_top_500`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `content_both_top_500`
--
ALTER TABLE `content_both_top_500`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
