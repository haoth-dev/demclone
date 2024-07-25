-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 18, 2024 at 06:01 PM
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
  `l_pass` varchar(50) NOT NULL,
  `l_status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`l_id`, `l_username`, `l_pass`, `l_status`) VALUES
(17, 'aliff@outlook.com', 'abc123', 'active'),
(18, 'admin', 'admin', 'active'),
(19, 'scaregiver@gmail.com', 'abc123', 'active'),
(20, 'scaregiver@gmail.com', 'abc123', 'active'),
(21, 'scaregive2r@gmail.com', 'abc123', 'active'),
(22, 'scaregiver3@gmail.com', 'abc123', 'active'),
(23, 'aliza@gmail.com', 'abc123', 'active'),
(24, 'scaregiver@gmail.com', '121212', 'active'),
(25, 'scaregiver@gmail.com', '121212', 'active'),
(26, 'scaregive2r@gmail.com', '121212', 'active'),
(27, 'scaregiver@gmail.com', '121212', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `medication`
--

CREATE TABLE `medication` (
  `meds_id` int(11) NOT NULL,
  `meds_name` varchar(100) NOT NULL,
  `meds_desc` longtext NOT NULL,
  `meds_added_date` date NOT NULL,
  `pcd_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medication`
--

INSERT INTO `medication` (`meds_id`, `meds_name`, `meds_desc`, `meds_added_date`, `pcd_id`) VALUES
(1, 'Panadol extra', 'for pain killerd', '2024-05-10', 20),
(2, 'clonazepam', 'for reduce seizure attack and help patient with sleep in the evening', '2024-05-10', 20);

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `pt_id` int(11) NOT NULL,
  `pcm_id` int(11) NOT NULL,
  `pcd_id` int(11) NOT NULL,
  `pt_ic` varchar(50) NOT NULL,
  `pt_name` varchar(100) NOT NULL,
  `pt_dob` date NOT NULL,
  `pt_height` double NOT NULL,
  `pt_weight` double NOT NULL,
  `pt_relationship` varchar(50) NOT NULL,
  `pt_location` longtext NOT NULL,
  `pt_remark` longtext NOT NULL COMMENT 'symptomps'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`pt_id`, `pcm_id`, `pcd_id`, `pt_ic`, `pt_name`, `pt_dob`, `pt_height`, `pt_weight`, `pt_relationship`, `pt_location`, `pt_remark`) VALUES
(1, 0, 20, '123123', 'Sabtu ibrahim', '1965-03-04', 100.87, 175.34, 'First cousin', 'same house in lambak', 'high bp and high cholestrol'),
(2, 0, 20, '12312323', 'Pg Aji', '2024-05-14', 175, 120, 'brother', 'sam address', 'have high sugar and easily irritated');

-- --------------------------------------------------------

--
-- Table structure for table `pc_detail`
--

CREATE TABLE `pc_detail` (
  `pcd_id` int(11) NOT NULL,
  `pcd_ic` varchar(50) NOT NULL,
  `pcd_assign_id` int(11) NOT NULL,
  `pcd_name` varchar(50) NOT NULL,
  `pcd_dob` date NOT NULL,
  `pcd_email` varchar(50) NOT NULL,
  `pcd_contact` varchar(50) NOT NULL,
  `pcd_addr` longtext NOT NULL,
  `pcd_level` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pc_detail`
--

INSERT INTO `pc_detail` (`pcd_id`, `pcd_ic`, `pcd_assign_id`, `pcd_name`, `pcd_dob`, `pcd_email`, `pcd_contact`, `pcd_addr`, `pcd_level`) VALUES
(20, '4345443', 0, 'akuma', '2024-05-24', 'aliff@outlook.com', '33223234', 'MIRI', 'primary'),
(30, '123456', 20, 'scaregiver', '2024-05-01', 'scaregiver@gmail.com', '88475556', 'saas', 'secondary');

-- --------------------------------------------------------

--
-- Table structure for table `pc_sc`
--

CREATE TABLE `pc_sc` (
  `pcsc_id` int(11) NOT NULL,
  `pcd_id` int(11) NOT NULL,
  `scd_id` int(11) NOT NULL,
  `pt_id` int(11) NOT NULL,
  `pcsc_assign_id` varchar(50) NOT NULL,
  `pcsc_status` varchar(50) NOT NULL,
  `pcsc_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pc_sc`
--

INSERT INTO `pc_sc` (`pcsc_id`, `pcd_id`, `scd_id`, `pt_id`, `pcsc_assign_id`, `pcsc_status`, `pcsc_date`) VALUES
(10, 20, 30, 0, '1030', 'unset', '2024-05-18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`l_id`);

--
-- Indexes for table `medication`
--
ALTER TABLE `medication`
  ADD PRIMARY KEY (`meds_id`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`pt_id`);

--
-- Indexes for table `pc_detail`
--
ALTER TABLE `pc_detail`
  ADD PRIMARY KEY (`pcd_id`);

--
-- Indexes for table `pc_sc`
--
ALTER TABLE `pc_sc`
  ADD PRIMARY KEY (`pcsc_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `l_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `medication`
--
ALTER TABLE `medication`
  MODIFY `meds_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
  MODIFY `pt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pc_detail`
--
ALTER TABLE `pc_detail`
  MODIFY `pcd_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `pc_sc`
--
ALTER TABLE `pc_sc`
  MODIFY `pcsc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
