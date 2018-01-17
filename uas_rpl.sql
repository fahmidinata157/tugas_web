-- phpMyAdmin SQL Dump
-- version 4.7.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 15, 2018 at 06:54 PM
-- Server version: 10.1.29-MariaDB
-- PHP Version: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `uas_rpl`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_agen`
--

CREATE TABLE `tbl_agen` (
  `id_agen` int(11) NOT NULL,
  `namaagen` varchar(12) CHARACTER SET latin1 DEFAULT NULL,
  `keterangan` text CHARACTER SET latin1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_agen`
--

INSERT INTO `tbl_agen` (`id_agen`, `namaagen`, `keterangan`) VALUES
(1, 'amirul', 'sendang'),
(2, 'dfd', 'dfs');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_koordinatagen`
--

CREATE TABLE `tbl_koordinatagen` (
  `id_koordinatagen` int(11) NOT NULL,
  `agen_id` int(11) DEFAULT NULL,
  `latitude` varchar(24) CHARACTER SET latin1 DEFAULT NULL,
  `longitude` varchar(24) CHARACTER SET latin1 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_koordinatagen`
--

INSERT INTO `tbl_koordinatagen` (`id_koordinatagen`, `agen_id`, `latitude`, `longitude`) VALUES
(1, 1, '-6.72708651278197', '110.70854235780644'),
(2, 2, '-6.732200872472724', '110.69523860109257');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sessions`
--

CREATE TABLE `tbl_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(12) CHARACTER SET latin1 DEFAULT NULL,
  `password` varchar(512) CHARACTER SET latin1 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_agen`
--
ALTER TABLE `tbl_agen`
  ADD PRIMARY KEY (`id_agen`);

--
-- Indexes for table `tbl_koordinatagen`
--
ALTER TABLE `tbl_koordinatagen`
  ADD PRIMARY KEY (`id_koordinatagen`),
  ADD KEY `agen_id` (`agen_id`);

--
-- Indexes for table `tbl_sessions`
--
ALTER TABLE `tbl_sessions`
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_agen`
--
ALTER TABLE `tbl_agen`
  MODIFY `id_agen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_koordinatagen`
--
ALTER TABLE `tbl_koordinatagen`
  MODIFY `id_koordinatagen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_koordinatagen`
--
ALTER TABLE `tbl_koordinatagen`
  ADD CONSTRAINT `tbl_koordinatagen_ibfk_1` FOREIGN KEY (`agen_id`) REFERENCES `tbl_agen` (`id_agen`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
