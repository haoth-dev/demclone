-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 17, 2024 at 04:44 PM
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
-- Table structure for table `dem_type`
--

CREATE TABLE `dem_type` (
  `dt_id` int(11) NOT NULL,
  `dt_name` varchar(50) NOT NULL,
  `dt_desc` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dem_type`
--

INSERT INTO `dem_type` (`dt_id`, `dt_name`, `dt_desc`) VALUES
(1, 'Alzheimer Disease', 'Alzheimer’s disease is the most common form of dementia.\r\n\r\nAlzheimer’s disease causes damage to your neurons – cells in your brain that carry messages. Just like plaque grows on your teeth, a plaque of proteins forms on your neurons. Other proteins tangle up inside the neurons.\r\n\r\nThese damaged neurons can’t communicate with each other as well as they used to. The neurons eventually die and your brain’s volume shrinks.\r\n\r\nIf you have Alzheimer’s disease, you might experience memory loss, slower thinking and changed behaviour. These changes can happen in different ways and at different speeds for each person.\r\n\r\nOver time, as Alzheimer’s disease develops, your memory, thinking and behaviour will become more affected.\r\n\r\nThere is no known cure for Alzheimer’s disease. But there is medication, treatment and support to help you live the best life you can.'),
(2, 'Vascular Dementia', 'Vascular dementia is caused by damage from restricted blood flow in your brain. ‘Vascular’ refers to your blood vessels.\r\n\r\nVascular dementia affects your reasoning, planning, judgement and attention, and how you function. These changes are significant enough to interfere with your daily life.\r\n\r\nOften, vascular dementia occurs alongside Alzheimer’s disease or other brain disease, and it can be difficult to diagnose.\r\n\r\nThere is no known cure for vascular dementia, but medication and treatment can help slow the decline. Support is available.'),
(3, 'Frontotemporal dementia(FTD)', 'Frontotemporal dementia is a brain condition that causes damage to two parts of your brain: the frontal lobe and the temporal lobe.\r\n\r\nIf you’ve been diagnosed with frontotemporal dementia, you may experience changes in your behaviour, personality, language and movement. Your memory isn’t always affected, especially in the early stages. These changes get worse over time.\r\n\r\nThere’s no known cure for frontotemporal dementia yet. But treatment can help with some symptoms, and support is available.'),
(4, 'Lewy Body Dementia(LBD)', '“Lewy body dementias” is an umbrella term describing two forms of dementia: dementia with Lewy bodies and Parkinson’s disease dementia.\r\n\r\nThese two forms of dementia are grouped together because they both involve damage to the brain caused by Lewy bodies.\r\n\r\nA Lewy body is a tiny tangle of protein called alpha-synuclein inside brain cells. These tangled proteins cause damage that affects your movement, thinking and behaviour.\r\n\r\nOver time, as Lewy body dementia develops, your memory, thinking and behaviour will become more affected.\r\n\r\nThere is no known cure for Lewy body dementia. But there is medication, treatment and support to help you live the best life you can.'),
(5, 'Mild Cognitive Impairment(MCI)', 'Mild cognitive impairment (MCI) is a condition in which people have more memory or thinking problems than other people their age. The symptoms of MCI are not as severe as those of Alzheimer’s disease or a related dementia.');

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
(18, 'admin@gmail.com', 'admin', 'active'),
(29, 'alifjulaihi.mp@gmail.com', 'abc123', 'active'),
(30, 'abu@gmail.com', 'abc123', 'active'),
(31, 'allen@gmail.com', 'abc123', 'active');

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
(3, 'Panadol', 'For headache and painkiller', '2024-05-20', 32),
(4, 'panadol extra', 'bit stronger than normal panadol and activefast', '2024-06-08', 32),
(5, 'Gaviscon', 'for gastric', '2024-06-09', 32);

-- --------------------------------------------------------

--
-- Table structure for table `missing_pt`
--

CREATE TABLE `missing_pt` (
  `mp_id` int(11) NOT NULL,
  `pcd_id` int(11) NOT NULL,
  `pt_id` int(11) NOT NULL,
  `mp_latitude` varchar(50) NOT NULL,
  `mp_longitude` varchar(50) NOT NULL,
  `mp_status` varchar(50) NOT NULL,
  `mp_date` date NOT NULL,
  `mp_remark` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `dt_id` int(11) NOT NULL,
  `pt_relationship` varchar(50) NOT NULL,
  `pt_location` longtext NOT NULL,
  `pt_remark` longtext NOT NULL COMMENT 'symptomps'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`pt_id`, `pcm_id`, `pcd_id`, `pt_ic`, `pt_name`, `pt_dob`, `pt_height`, `pt_weight`, `dt_id`, `pt_relationship`, `pt_location`, `pt_remark`) VALUES
(5, 0, 32, '123123', 'Ali', '2024-05-01', 175, 120, 0, 'First cousin', 'Same house', 'easily forgot to eat'),
(6, 0, 32, '12121212', 'Bakar', '2024-05-23', 200, 175, 0, 'adik', 'miri`', 'diabetic');

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
(32, '0123456', 0, 'aliff julaihi', '2000-02-21', 'alifjulaihi.mp@gmail.com', '8847554', 'Brunei Darussalam', 'primary'),
(33, '11223344', 32, 'Abu', '2024-05-15', 'abu@gmail.com', '226111', 'same house', 'secondary'),
(34, 'admin', 0, 'admin', '2024-05-22', 'admin@gmail.com', '33730000', '', 'admin'),
(35, '123212', 32, 'allen', '2024-05-12', 'allen@gmail.com', '88475556', 'miri', 'secondary');

-- --------------------------------------------------------

--
-- Table structure for table `pc_meds`
--

CREATE TABLE `pc_meds` (
  `pcm_id` int(11) NOT NULL,
  `pcd_id` int(11) NOT NULL,
  `pt_id` int(11) NOT NULL,
  `meds_id` int(11) NOT NULL,
  `pcm_qty` int(11) NOT NULL,
  `pcm_unit` varchar(50) NOT NULL,
  `pcm_freq` int(11) NOT NULL,
  `pcm_remark` longtext NOT NULL,
  `pcm_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pc_sc`
--

CREATE TABLE `pc_sc` (
  `pcsc_id` int(11) NOT NULL,
  `pcd_id` int(11) NOT NULL,
  `scd_id` int(11) NOT NULL,
  `pt_id` int(11) NOT NULL,
  `pcsc_status` varchar(50) NOT NULL,
  `pcsc_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pc_sc`
--

INSERT INTO `pc_sc` (`pcsc_id`, `pcd_id`, `scd_id`, `pt_id`, `pcsc_status`, `pcsc_date`) VALUES
(17, 32, 33, 5, 'set', '2024-05-20'),
(18, 32, 35, 6, 'unset', '2024-05-27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dem_type`
--
ALTER TABLE `dem_type`
  ADD PRIMARY KEY (`dt_id`);

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
-- Indexes for table `missing_pt`
--
ALTER TABLE `missing_pt`
  ADD PRIMARY KEY (`mp_id`);

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
-- Indexes for table `pc_meds`
--
ALTER TABLE `pc_meds`
  ADD PRIMARY KEY (`pcm_id`);

--
-- Indexes for table `pc_sc`
--
ALTER TABLE `pc_sc`
  ADD PRIMARY KEY (`pcsc_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dem_type`
--
ALTER TABLE `dem_type`
  MODIFY `dt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `l_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `medication`
--
ALTER TABLE `medication`
  MODIFY `meds_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `missing_pt`
--
ALTER TABLE `missing_pt`
  MODIFY `mp_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
  MODIFY `pt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pc_detail`
--
ALTER TABLE `pc_detail`
  MODIFY `pcd_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `pc_meds`
--
ALTER TABLE `pc_meds`
  MODIFY `pcm_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `pc_sc`
--
ALTER TABLE `pc_sc`
  MODIFY `pcsc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
