-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 11, 2017 at 11:30 AM
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
-- Table structure for table `returs_supplier_reports`
--

CREATE TABLE `returs_supplier_reports` (
  `retur_supplier_report_id` int(11) NOT NULL,
  `retur_supplier_report_date` date NOT NULL,
  `retur_supplier_id` int(11) NOT NULL,
  `retur_supplier_date` date NOT NULL,
  `retur_supplier_code` varchar(50) NOT NULL,
  `purchase_id` int(11) NOT NULL,
  `partner_name` varchar(50) NOT NULL,
  `retur_supplier_detail_id` int(11) NOT NULL,
  `retur_supplier_detail_qty` int(11) NOT NULL,
  `retur_supplier_detail_desc` text NOT NULL,
  `purchase_detail_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `returs_supplier_reports`
--

INSERT INTO `returs_supplier_reports` (`retur_supplier_report_id`, `retur_supplier_report_date`, `retur_supplier_id`, `retur_supplier_date`, `retur_supplier_code`, `purchase_id`, `partner_name`, `retur_supplier_detail_id`, `retur_supplier_detail_qty`, `retur_supplier_detail_desc`, `purchase_detail_id`) VALUES
(2, '2017-09-05', 30, '2017-09-04', 'RS2017090001', 14, 'asdfghjghfgdf', 1, 2, '', 34),
(3, '2017-09-05', 30, '2017-09-04', 'RS2017090001', 14, 'asdfghjghfgdf', 2, 1, '', 35),
(4, '2017-09-05', 31, '2017-09-05', 'RS2017090002', 12, 'asdfghjghfgdf', 3, 23, '', 32),
(5, '2017-09-07', 30, '2017-09-06', 'RS2017090001', 12, 'asdfghjghfgdf', 1, 1, 'test', 32);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `returs_supplier_reports`
--
ALTER TABLE `returs_supplier_reports`
  ADD PRIMARY KEY (`retur_supplier_report_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `returs_supplier_reports`
--
ALTER TABLE `returs_supplier_reports`
  MODIFY `retur_supplier_report_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
