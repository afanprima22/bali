-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 11, 2017 at 11:04 AM
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
-- Table structure for table `retur_cus_reports`
--

CREATE TABLE `retur_cus_reports` (
  `retur_cus_report_id` int(11) NOT NULL,
  `retur_cus_report_date` date NOT NULL,
  `retur_cus_id` int(11) NOT NULL,
  `retur_cus_date` date NOT NULL,
  `retur_cus_code` varchar(50) NOT NULL,
  `nota_id` int(11) NOT NULL,
  `customer_name` varchar(50) NOT NULL,
  `retur_cus_detail_id` int(11) NOT NULL,
  `retur_cus_detail_qty` int(11) NOT NULL,
  `retur_cus_detail_desc` text NOT NULL,
  `retur_cus_detail_status` varchar(50) NOT NULL,
  `nota_detail_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `retur_cus_reports`
--

INSERT INTO `retur_cus_reports` (`retur_cus_report_id`, `retur_cus_report_date`, `retur_cus_id`, `retur_cus_date`, `retur_cus_code`, `nota_id`, `customer_name`, `retur_cus_detail_id`, `retur_cus_detail_qty`, `retur_cus_detail_desc`, `retur_cus_detail_status`, `nota_detail_id`) VALUES
(2, '2017-09-05', 1, '2017-08-05', 'RC2017080001', 3, 'ipul', 1, 1, 'rusak', 'Belum Diterima', 14),
(3, '2017-09-07', 1, '2017-08-05', 'RC2017080001', 3, 'ipul', 1, 1, 'rusak', 'Sudah Diterima', 14);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `retur_cus_reports`
--
ALTER TABLE `retur_cus_reports`
  ADD PRIMARY KEY (`retur_cus_report_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `retur_cus_reports`
--
ALTER TABLE `retur_cus_reports`
  MODIFY `retur_cus_report_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
