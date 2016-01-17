-- phpMyAdmin SQL Dump
-- version 4.5.0.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 08, 2016 at 08:10 AM
-- Server version: 10.0.17-MariaDB
-- PHP Version: 5.6.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `goal2`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

DROP TABLE IF EXISTS `activity`;
CREATE TABLE `activity` (
  `activity_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `type` text NOT NULL,
  `hit_count` int(11) NOT NULL,
  `last_used` date NOT NULL,
  `timestamp` date NOT NULL,
  `server_push` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `activity`
--

INSERT INTO `activity` (`activity_id`, `user_id`, `name`, `type`, `hit_count`, `last_used`, `timestamp`, `server_push`) VALUES
(1, 0, 'Sample', 'U', 5, '0000-00-00', '0000-00-00', 0),
(2, 0, 'Sample', 'U', 5, '0000-00-00', '2016-01-02', 0),
(3, 0, 'Sample', 'U', 5, '0000-00-00', '2016-01-02', 0),
(4, 0, 'Sample', 'U', 5, '0000-00-00', '2016-01-02', 0),
(5, 0, 'Sample', 'U', 5, '0000-00-00', '2016-01-02', 0),
(6, 0, 'Sample', 'U', 5, '0000-00-00', '2016-01-02', 0),
(7, 1, 'Sample', 'U', 5, '0000-00-00', '2016-01-03', 0);

-- --------------------------------------------------------

--
-- Table structure for table `activity_entry`
--

DROP TABLE IF EXISTS `activity_entry`;
CREATE TABLE `activity_entry` (
  `activity_entry_id` int(11) NOT NULL,
  `goal_id` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL,
  `timestamp` datetime NOT NULL,
  `rpe` int(11) NOT NULL,
  `activity_length` text NOT NULL,
  `count_towards_goal` int(11) NOT NULL,
  `notes` text NOT NULL,
  `image` text NOT NULL,
  `server_push` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `activity_entry`
--

INSERT INTO `activity_entry` (`activity_entry_id`, `goal_id`, `activity_id`, `timestamp`, `rpe`, `activity_length`, `count_towards_goal`, `notes`, `image`, `server_push`) VALUES
(1, 1, 1, '2016-01-08 05:30:26', 2, 'some_length', 3, 'some notes', 'file:///storage/emulated/0/1_201601081230', 0),
(2, 1, 1, '2016-01-08 05:35:39', 2, 'some_length', 3, 'some notes', 'file:///storage/emulated/0/1_201601081234', 0),
(3, 1, 1, '2016-01-08 06:20:35', 2, 'some_length', 3, 'some notes', 'file:///storage/emulated/0/1_201601080120.jpg', 0),
(4, 1, 1, '2016-01-08 06:24:43', 2, 'some_length', 3, 'some notes', 'file:///storage/emulated/0/1_201601080124.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `nutrition_entry`
--

DROP TABLE IF EXISTS `nutrition_entry`;
CREATE TABLE `nutrition_entry` (
  `nutrition_entry_id` int(11) NOT NULL,
  `goal_id` int(11) NOT NULL,
  `nutrition_type` text NOT NULL,
  `timestamp` datetime NOT NULL,
  `towards_goal` int(11) NOT NULL,
  `type` text NOT NULL,
  `attic_food` int(11) NOT NULL,
  `diary` int(11) NOT NULL,
  `vegetable` int(11) NOT NULL,
  `fruit` int(11) NOT NULL,
  `grain` int(11) NOT NULL,
  `water_intake` int(11) NOT NULL,
  `notes` text NOT NULL,
  `image` blob,
  `server_push` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `first_name` text NOT NULL,
  `last_name` text NOT NULL,
  `type` text NOT NULL,
  `age` int(11) NOT NULL,
  `phone` text NOT NULL,
  `gender` text NOT NULL,
  `program` text NOT NULL,
  `rewards_count` int(11) NOT NULL,
  `server_push` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `first_name`, `last_name`, `type`, `age`, `phone`, `gender`, `program`, `rewards_count`, `server_push`) VALUES
(1, 'john', 'smith', 'U', 24, '8121231234', 'M', 'Goal', 1, 0),
(2, 'john', 'smith', 'U', 24, '8121231234', 'M', 'Goal', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_goal`
--

DROP TABLE IF EXISTS `user_goal`;
CREATE TABLE `user_goal` (
  `goal_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `type` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `weekly_count` int(11) NOT NULL,
  `reward_type` text NOT NULL,
  `text` text NOT NULL,
  `server_push` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_goal`
--

INSERT INTO `user_goal` (`goal_id`, `user_id`, `timestamp`, `type`, `start_date`, `end_date`, `weekly_count`, `reward_type`, `text`, `server_push`) VALUES
(3, 0, '2016-01-02 08:24:17', 0, '0000-00-00', '0000-00-00', 5, 'NONE', '50 gm protein', 0),
(4, 0, '2016-01-02 08:24:28', 0, '0000-00-00', '0000-00-00', 5, 'NONE', '50 gm protein', 0),
(5, 0, '2016-01-02 08:44:31', 0, '0000-00-00', '0000-00-00', 5, 'NONE', '50 gm protein', 0),
(6, 0, '2016-01-02 08:45:13', 0, '0000-00-00', '0000-00-00', 5, 'NONE', '50 gm protein', 0),
(7, 0, '2016-01-02 08:45:58', 0, '0000-00-00', '0000-00-00', 5, 'NONE', '50 gm protein', 0),
(8, 0, '2016-01-02 08:46:57', 0, '0000-00-00', '0000-00-00', 5, 'NONE', '50 gm protein', 0),
(9, 0, '2016-01-02 08:47:13', 0, '0000-00-00', '0000-00-00', 5, 'NONE', '50 gm protein', 0),
(10, 0, '2016-01-02 08:48:01', 0, '0000-00-00', '0000-00-00', 5, 'NONE', '50 gm protein', 0),
(11, 0, '2016-01-02 08:48:17', 0, '0000-00-00', '0000-00-00', 5, 'NONE', '50 gm protein', 0),
(12, 0, '2016-01-02 08:49:27', 0, '0000-00-00', '0000-00-00', 5, 'NONE', '50 gm protein', 0),
(13, 0, '2016-01-02 08:52:54', 0, '0000-00-00', '0000-00-00', 5, 'NONE', '50 gm protein', 0),
(14, 0, '2016-01-02 08:53:39', 0, '0000-00-00', '0000-00-00', 5, 'NONE', '50 gm protein', 0),
(15, 0, '2016-01-03 09:26:11', 0, '0000-00-00', '0000-00-00', 5, 'NONE', '50 gm protein', 0),
(16, 0, '2016-01-02 08:54:42', 0, '0000-00-00', '0000-00-00', 5, 'NONE', '50 gm protein', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_steps`
--

DROP TABLE IF EXISTS `user_steps`;
CREATE TABLE `user_steps` (
  `steps_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `steps_count` int(11) NOT NULL,
  `timestamp` datetime NOT NULL,
  `server_push` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_steps`
--

INSERT INTO `user_steps` (`steps_id`, `user_id`, `steps_count`, `timestamp`, `server_push`) VALUES
(1, 1, 250, '0000-00-00 00:00:00', 0),
(2, 1, 250, '0000-00-00 00:00:00', 0),
(3, 1, 250, '0000-00-00 00:00:00', 0),
(4, 1, 250, '0000-00-00 00:00:00', 0),
(5, 1, 250, '2016-01-03 04:25:32', 0),
(6, 1, 250, '2016-01-03 04:26:07', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`activity_id`),
  ADD KEY `activity_user_fk` (`user_id`);

--
-- Indexes for table `activity_entry`
--
ALTER TABLE `activity_entry`
  ADD PRIMARY KEY (`activity_entry_id`),
  ADD KEY `goal_id` (`goal_id`),
  ADD KEY `activity_id` (`activity_id`);

--
-- Indexes for table `nutrition_entry`
--
ALTER TABLE `nutrition_entry`
  ADD PRIMARY KEY (`nutrition_entry_id`),
  ADD KEY `nutrition_entry_user_goal_fk` (`goal_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_goal`
--
ALTER TABLE `user_goal`
  ADD PRIMARY KEY (`goal_id`),
  ADD KEY `user_goal_user_fk` (`user_id`);

--
-- Indexes for table `user_steps`
--
ALTER TABLE `user_steps`
  ADD PRIMARY KEY (`steps_id`),
  ADD KEY `user_steps_user_fk` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity`
--
ALTER TABLE `activity`
  MODIFY `activity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `activity_entry`
--
ALTER TABLE `activity_entry`
  MODIFY `activity_entry_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `nutrition_entry`
--
ALTER TABLE `nutrition_entry`
  MODIFY `nutrition_entry_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `user_goal`
--
ALTER TABLE `user_goal`
  MODIFY `goal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `user_steps`
--
ALTER TABLE `user_steps`
  MODIFY `steps_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
