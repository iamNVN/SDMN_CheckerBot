-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 04, 2021 at 08:18 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- --------------------------------------------------------

--
-- Table structure for table `antispam`
--

CREATE TABLE `antispam` (
  `id` int(11) NOT NULL,
  `userid` varchar(50) NOT NULL,
  `last_checked_on` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `global_checker_stats`
--

CREATE TABLE `global_checker_stats` (
  `total_checked` varchar(100) NOT NULL,
  `total_ccn` varchar(100) NOT NULL,
  `total_cvv` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `global_checker_stats`
--

INSERT INTO `global_checker_stats` (`total_checked`, `total_ccn`, `total_cvv`) VALUES
('0', '0', '0');
COMMIT;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `userid` varchar(50) NOT NULL,
  `registered_on` varchar(50) NOT NULL,
  `is_banned` varchar(50) NOT NULL,
  `is_muted` varchar(50) NOT NULL,
  `mute_timer` varchar(50) NOT NULL,
  `sk_key` varchar(500) NOT NULL,
  `total_checked` varchar(50) NOT NULL,
  `total_cvv` varchar(50) NOT NULL,
  `total_ccn` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `antispam`
--
ALTER TABLE `antispam`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `antispam`
--
ALTER TABLE `antispam`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;
COMMIT;
