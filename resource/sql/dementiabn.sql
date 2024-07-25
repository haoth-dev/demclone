-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 18, 2024 at 03:13 PM
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
-- Database: `dementiabn`
--

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `l_id` int(11) NOT NULL,
  `l_username` varchar(50) NOT NULL,
  `l_pass` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`l_id`, `l_username`, `l_pass`) VALUES
(7, 'ALIFF@GMAIL.COM', 'abc123');

-- --------------------------------------------------------

--
-- Table structure for table `pc_detail`
--

CREATE TABLE `pc_detail` (
  `pcd_id` int(11) NOT NULL,
  `pcd_name` varchar(50) NOT NULL,
  `pcd_age` int(11) NOT NULL,
  `pcd_email` varchar(50) NOT NULL,
  `pcd_contact` varchar(50) NOT NULL,
  `pcd_addr` longtext NOT NULL,
  `pcd_level` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pc_detail`
--

INSERT INTO `pc_detail` (`pcd_id`, `pcd_name`, `pcd_age`, `pcd_email`, `pcd_contact`, `pcd_addr`, `pcd_level`) VALUES
(10, 'ALIFF', 35, 'ALIFF@GMAIL.COM', '88874637', 'Brunei', 'primary');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`l_id`);

--
-- Indexes for table `pc_detail`
--
ALTER TABLE `pc_detail`
  ADD PRIMARY KEY (`pcd_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `l_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pc_detail`
--
ALTER TABLE `pc_detail`
  MODIFY `pcd_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
