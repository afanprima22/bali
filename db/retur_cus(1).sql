-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 11, 2017 at 11:05 AM
-- Server version: 10.1.9-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bali`
--

-- --------------------------------------------------------

--
-- Table structure for table `retur_cus`
--

CREATE TABLE `retur_cus` (
  `retur_cus_id` int(11) NOT NULL,
  `retur_cus_code` varchar(30) NOT NULL,
  `retur_cus_date` date NOT NULL,
  `nota_id` int(11) NOT NULL,
  `retur_cus_desc` varchar(100) NOT NULL,
  `retur_cus_status` int(11) NOT NULL COMMENT '0 belum dipakai,1 sudah di pakai',
  `retur_cus_total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `retur_cus`
--

INSERT INTO `retur_cus` (`retur_cus_id`, `retur_cus_code`, `retur_cus_date`, `nota_id`, `retur_cus_desc`, `retur_cus_status`, `retur_cus_total`) VALUES
(1, 'RC2017080001', '2017-08-05', 3, 'asds', 1, 4000),
(2, 'RC2017080002', '2017-08-15', 5, 'test', 0, 4000),
(3, 'RC2017080003', '2017-08-31', 6, '', 0, 7200);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `retur_cus`
--
ALTER TABLE `retur_cus`
  ADD PRIMARY KEY (`retur_cus_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `retur_cus`
--
ALTER TABLE `retur_cus`
  MODIFY `retur_cus_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
