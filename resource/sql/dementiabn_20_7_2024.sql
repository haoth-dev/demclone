-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 20, 2024 at 02:29 PM
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
-- Table structure for table `admin_log`
--

CREATE TABLE `admin_log` (
  `al_id` int(11) NOT NULL,
  `al_type` varchar(50) NOT NULL,
  `al_detail` longtext NOT NULL,
  `al_date` datetime NOT NULL,
  `pcd_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_log`
--

INSERT INTO `admin_log` (`al_id`, `al_type`, `al_detail`, `al_date`, `pcd_id`) VALUES
(304, 'access', 'admin@gmail.com succesfully logged in to DementiaBN', '2024-07-15 22:22:33', 34),
(305, 'access', 'admin@gmail.com succesfully logged in to DementiaBN', '2024-07-15 22:22:35', 34),
(306, 'event', 'login account succesfully created by  for reiza.sulaiman@gmail.com', '2024-07-15 22:26:15', 0),
(307, 'access', ' succesfully logged in to DementiaBN', '2024-07-15 22:28:13', 0),
(308, 'access', ' succesfully logged in to DementiaBN', '2024-07-15 22:28:24', 0),
(309, 'access', ' succesfully logged in to DementiaBN', '2024-07-15 22:31:29', 0),
(310, 'access', ' succesfully logged in to DementiaBN', '2024-07-15 22:38:38', 0),
(311, 'access', 'dementiabn@dementiabn.xyz succesfully logged in to DementiaBN', '2024-07-15 22:39:31', 32),
(312, 'access', 'dementiabn@dementiabn.xyz succesfully logged in to DementiaBN', '2024-07-15 22:39:41', 32),
(313, 'access', 'dementiabn@dementiabn.xyz succesfully logged in to DementiaBN', '2024-07-15 22:39:45', 32),
(314, 'access', 'dementiabn@dementiabn.xyz succesfully logged in to DementiaBN', '2024-07-15 22:39:51', 32),
(315, 'access', 'dementiabn@dementiabn.xyz succesfully logged in to DementiaBN', '2024-07-15 22:39:52', 32),
(316, 'access', 'dementiabn@dementiabn.xyz succesfully logged in to DementiaBN', '2024-07-15 22:39:52', 32),
(317, 'access', 'dementiabn@dementiabn.xyz succesfully logged in to DementiaBN', '2024-07-15 22:39:52', 32),
(318, 'event', 'login account succesfully created by  for alifjulaihi.mp@gmail.com', '2024-07-15 22:44:09', 0),
(319, 'event', ' succesfully upload profile photo for alifjulaihi.mp@gmail.com', '2024-07-15 22:44:09', 0),
(320, 'access', 'alifjulaihi.mp@gmail.com succesfully logged in to DementiaBN', '2024-07-15 22:48:37', 47),
(321, 'access', 'alifjulaihi.mp@gmail.com succesfully logged in to DementiaBN', '2024-07-15 22:49:10', 47),
(322, 'access', 'alifjulaihi.mp@gmail.com succesfully logged in to DementiaBN', '2024-07-15 22:50:39', 47),
(323, 'access', 'dementiabn@dementiabn.xyz succesfully logged in to DementiaBN', '2024-07-17 00:53:18', 32),
(324, 'access', 'dementiabn@dementiabn.xyz succesfully logged in to DementiaBN', '2024-07-17 01:20:45', 32),
(325, 'access', 'dementiabn@dementiabn.xyz succesfully logged in to DementiaBN', '2024-07-17 03:08:28', 32),
(326, 'access', 'alifjulaihi.mp@gmail.com succesfully logged in to DementiaBN', '2024-07-20 16:17:43', 47),
(327, 'event', 'insert_incident:return 0', '2024-07-20 20:13:42', 47),
(328, 'event', 'alifjulaihi.mp@gmail.com added new incident. Inc ID:1', '2024-07-20 20:13:42', 47),
(329, 'event', 'insert_incident:return 0', '2024-07-20 20:14:47', 47),
(330, 'event', 'alifjulaihi.mp@gmail.com added new incident. Inc ID:2', '2024-07-20 20:14:47', 47),
(331, 'event', 'insert_incident:return 0', '2024-07-20 20:23:52', 47),
(332, 'event', 'alifjulaihi.mp@gmail.com added new incident. Inc ID:3', '2024-07-20 20:23:52', 47),
(333, 'event', 'insert_incident:return 0', '2024-07-20 20:24:50', 47),
(334, 'event', 'alifjulaihi.mp@gmail.com added new incident. Inc ID:4', '2024-07-20 20:24:50', 47),
(335, 'event', 'insert_incident:return 0', '2024-07-20 20:25:43', 47),
(336, 'event', 'alifjulaihi.mp@gmail.com added new incident. Inc ID:5', '2024-07-20 20:25:43', 47);

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
-- Table structure for table `incident`
--

CREATE TABLE `incident` (
  `inc_id` int(11) NOT NULL,
  `inc_title` varchar(50) NOT NULL,
  `inc_desc` longtext NOT NULL,
  `inc_status` varchar(50) NOT NULL,
  `inc_caller` varchar(50) NOT NULL,
  `inc_date_opened` datetime NOT NULL,
  `inc_date_closed` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `incident`
--

INSERT INTO `incident` (`inc_id`, `inc_title`, `inc_desc`, `inc_status`, `inc_caller`, `inc_date_opened`, `inc_date_closed`) VALUES
(1, 'test', 'test', 'In-Progress', 'alifjulaihi.mp@gmail.com', '2024-07-20 20:13:42', '0000-00-00 00:00:00'),
(2, 'my atuk went missing', 'last seen: yesterdat 20hb julai 2024\nlast location:my home. refer to my address. ', 'In-Progress', 'alifjulaihi.mp@gmail.com', '2024-07-20 20:14:47', '0000-00-00 00:00:00'),
(3, 'test2', 'test3', 'In-Progress', 'alifjulaihi.mp@gmail.com', '2024-07-20 20:23:52', '0000-00-00 00:00:00'),
(4, 'test for single quote mark', 'i don\'t understand', 'In-Progress', 'alifjulaihi.mp@gmail.com', '2024-07-20 20:24:50', '0000-00-00 00:00:00'),
(5, 'i don\'t get it', 'test', 'In-Progress', 'alifjulaihi.mp@gmail.com', '2024-07-20 20:25:43', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `inc_type`
--

CREATE TABLE `inc_type` (
  `it_id` int(11) NOT NULL,
  `it_name` varchar(50) NOT NULL,
  `it_desc` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inc_type`
--

INSERT INTO `inc_type` (`it_id`, `it_name`, `it_desc`) VALUES
(1, 'inquiry', 'accout related, or others'),
(2, 'missing pwd', 'incident for reporting missing person of dementia');

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
(18, 'dementiabn@dementiabn.xyz', 'admin', 'active'),
(40, 'reiza.sulaiman@gmail.com', 'abc123', 'active'),
(41, 'alifjulaihi.mp@gmail.com', 'abc123', 'active');

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
  `mp_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `mp_remark` longtext NOT NULL,
  `mp_reporter_name` varchar(50) NOT NULL,
  `mp_reporter_contact_no` varchar(50) NOT NULL,
  `mp_reporter_email` varchar(50) NOT NULL,
  `mp_photo_path` varchar(100) NOT NULL
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
  `dt_id` int(11) NOT NULL,
  `pt_stage` varchar(50) NOT NULL,
  `pt_relationship` varchar(50) NOT NULL,
  `pt_location` longtext NOT NULL,
  `pt_remark` longtext NOT NULL COMMENT 'symptomps',
  `pt_qr_path` varchar(100) NOT NULL,
  `pt_photo_path` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`pt_id`, `pcm_id`, `pcd_id`, `pt_ic`, `pt_name`, `pt_dob`, `dt_id`, `pt_stage`, `pt_relationship`, `pt_location`, `pt_remark`, `pt_qr_path`, `pt_photo_path`) VALUES
(45, 0, 47, '00325655', 'Fatimah Binti Ali', '1960-07-14', 1, 'early', 'grandmother', 'Kg Ayer, ', 'easy to forget her meal', 'asset/qr/45_file_4bbbdd15d88a8e6b5e04e21913dbaa3c.png', 'asset/photo/45.png');

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
  `pcd_level` varchar(50) NOT NULL,
  `pcd_photo_path` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pc_detail`
--

INSERT INTO `pc_detail` (`pcd_id`, `pcd_ic`, `pcd_assign_id`, `pcd_name`, `pcd_dob`, `pcd_email`, `pcd_contact`, `pcd_addr`, `pcd_level`, `pcd_photo_path`) VALUES
(32, '01020305', 0, 'admin', '2000-07-03', 'dementiabn@dementiabn.xyz', '8885555', 'KIGS QIULAP', 'admin', ''),
(46, '01034088', 0, 'Reiza sulaiman', '2000-06-15', 'reiza.sulaiman@gmail.com', '8878554', 'Kg Selayun, Sengkurong', 'primary', ''),
(47, '01020405', 0, 'alif julaihi', '2000-07-15', 'alifjulaihi.mp@gmail.com', '88998382', 'Kg Tanjung Bunut', 'primary', 'asset/photo/47.png');

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
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_log`
--
ALTER TABLE `admin_log`
  ADD PRIMARY KEY (`al_id`);

--
-- Indexes for table `dem_type`
--
ALTER TABLE `dem_type`
  ADD PRIMARY KEY (`dt_id`);

--
-- Indexes for table `incident`
--
ALTER TABLE `incident`
  ADD PRIMARY KEY (`inc_id`);

--
-- Indexes for table `inc_type`
--
ALTER TABLE `inc_type`
  ADD PRIMARY KEY (`it_id`);

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
-- AUTO_INCREMENT for table `admin_log`
--
ALTER TABLE `admin_log`
  MODIFY `al_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=337;

--
-- AUTO_INCREMENT for table `dem_type`
--
ALTER TABLE `dem_type`
  MODIFY `dt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `incident`
--
ALTER TABLE `incident`
  MODIFY `inc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `inc_type`
--
ALTER TABLE `inc_type`
  MODIFY `it_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `l_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `medication`
--
ALTER TABLE `medication`
  MODIFY `meds_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `missing_pt`
--
ALTER TABLE `missing_pt`
  MODIFY `mp_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
  MODIFY `pt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `pc_detail`
--
ALTER TABLE `pc_detail`
  MODIFY `pcd_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `pc_meds`
--
ALTER TABLE `pc_meds`
  MODIFY `pcm_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `pc_sc`
--
ALTER TABLE `pc_sc`
  MODIFY `pcsc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
