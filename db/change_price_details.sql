-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 30, 2017 at 12:23 PM
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
-- Table structure for table `change_price_details`
--

CREATE TABLE `change_price_details` (
  `change_price_detail_id` int(11) NOT NULL,
  `change_price_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_price1_old` int(11) NOT NULL,
  `item_price1_new` int(11) NOT NULL,
  `item_price2_old` int(11) NOT NULL,
  `item_price2_new` int(11) NOT NULL,
  `item_price3_old` int(11) NOT NULL,
  `item_price3_new` int(11) NOT NULL,
  `item_price4_old` int(11) NOT NULL,
  `item_price4_new` int(11) NOT NULL,
  `item_price5_old` int(11) NOT NULL,
  `item_price5_new` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `change_price_details`
--
ALTER TABLE `change_price_details`
  ADD PRIMARY KEY (`change_price_detail_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `change_price_details`
--
ALTER TABLE `change_price_details`
  MODIFY `change_price_detail_id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
