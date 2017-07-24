-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 22, 2017 at 02:15 PM
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
-- Table structure for table `banks`
--

CREATE TABLE `banks` (
  `bank_id` int(11) NOT NULL,
  `bank_name` varchar(20) NOT NULL,
  `bank_rek` varchar(50) NOT NULL,
  `bank_branch` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `banks`
--

INSERT INTO `banks` (`bank_id`, `bank_name`, `bank_rek`, `bank_branch`) VALUES
(1, 'BCA', '27937194639', 'Kenjeran'),
(2, 'Mandiri', '4567865432', 'gresik');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `brand_id` int(11) NOT NULL,
  `brand_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`brand_id`, `brand_name`) VALUES
(1, 'Honda'),
(2, 'Yamah'),
(3, 'Suzuki'),
(4, 'Kawasaki');

-- --------------------------------------------------------

--
-- Table structure for table `business`
--

CREATE TABLE `business` (
  `busines_id` int(11) NOT NULL,
  `busines_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `business`
--

INSERT INTO `business` (`busines_id`, `busines_name`) VALUES
(1, 'PT'),
(2, 'UD'),
(3, 'CV'),
(4, 'Toko'),
(5, 'Perseorangan');

-- --------------------------------------------------------

--
-- Table structure for table `cashs`
--

CREATE TABLE `cashs` (
  `cash_id` int(11) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `cash_date` date NOT NULL,
  `cash_nominal` int(11) NOT NULL,
  `cash_code` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cashs`
--

INSERT INTO `cashs` (`cash_id`, `warehouse_id`, `cash_date`, `cash_nominal`, `cash_code`) VALUES
(2, 1, '2017-07-30', 2000000, ''),
(3, 1, '2017-07-01', 99999, 'PU2017070001'),
(4, 1, '2017-07-01', 100000, 'CA2017070001');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(1, 'Material'),
(2, 'Sperpart'),
(3, 'Barang Set Jadi');

-- --------------------------------------------------------

--
-- Table structure for table `category_prices`
--

CREATE TABLE `category_prices` (
  `category_price_id` int(11) NOT NULL,
  `category_price_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category_prices`
--

INSERT INTO `category_prices` (`category_price_id`, `category_price_name`) VALUES
(1, 'Harga 1'),
(2, 'Harga 2'),
(3, 'Harga 3'),
(4, 'Harga 4'),
(5, 'Harga 5');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `city_id` int(11) NOT NULL,
  `city_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`city_id`, `city_name`) VALUES
(1, 'Surabya'),
(2, 'Gresik'),
(3, 'Madura');

-- --------------------------------------------------------

--
-- Table structure for table `coas`
--

CREATE TABLE `coas` (
  `coa_id` int(11) NOT NULL,
  `coa_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `coas`
--

INSERT INTO `coas` (`coa_id`, `coa_name`) VALUES
(1, 'CASH'),
(2, 'DEBIT'),
(3, 'KREDIT/HUTANG'),
(4, 'KARTU KREDIT');

-- --------------------------------------------------------

--
-- Table structure for table `coa_details`
--

CREATE TABLE `coa_details` (
  `coa_detail_id` int(11) NOT NULL,
  `coa_id` int(11) NOT NULL,
  `warehouse_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `coa_details`
--

INSERT INTO `coa_details` (`coa_detail_id`, `coa_id`, `warehouse_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(50) NOT NULL,
  `busines_id` int(11) NOT NULL,
  `customer_group_id` int(11) NOT NULL,
  `customer_address` varchar(200) NOT NULL,
  `customer_store` varchar(50) NOT NULL,
  `customer_telp` varchar(30) NOT NULL,
  `customer_hp` varchar(30) NOT NULL,
  `customer_npwp` varchar(20) NOT NULL,
  `customer_npwp_name` varchar(50) NOT NULL,
  `customer_mail` varchar(50) NOT NULL,
  `city_id` int(11) NOT NULL,
  `customer_img` text NOT NULL,
  `category_price_id` int(11) NOT NULL,
  `customer_limit_kredit` int(11) NOT NULL,
  `customer_limit_card` int(11) NOT NULL,
  `customer_limit_day` int(11) NOT NULL,
  `customer_card_no` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `customer_name`, `busines_id`, `customer_group_id`, `customer_address`, `customer_store`, `customer_telp`, `customer_hp`, `customer_npwp`, `customer_npwp_name`, `customer_mail`, `city_id`, `customer_img`, `category_price_id`, `customer_limit_kredit`, `customer_limit_card`, `customer_limit_day`, `customer_card_no`) VALUES
(1, 'ipul', 1, 2, 'asfsfdsf', 'wefdsfdsf', '3324235', '325325', '32432', '23432', 'sdgds@rhrj.fh', 1, '2fbce207a5765d2c87e3b5051db950d9.jpg', 4, 24234, 23432, 234324, '1234567876543');

-- --------------------------------------------------------

--
-- Table structure for table `customer_details`
--

CREATE TABLE `customer_details` (
  `customer_detail_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `customer_member_id` int(11) NOT NULL,
  `customer_detail_bonus` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_details`
--

INSERT INTO `customer_details` (`customer_detail_id`, `customer_id`, `customer_member_id`, `customer_detail_bonus`) VALUES
(4, 1, 1, 8),
(5, 1, 1, 9);

-- --------------------------------------------------------

--
-- Table structure for table `customer_groups`
--

CREATE TABLE `customer_groups` (
  `customer_group_id` int(11) NOT NULL,
  `customer_group_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_groups`
--

INSERT INTO `customer_groups` (`customer_group_id`, `customer_group_name`) VALUES
(1, 'Group 1'),
(2, 'Group 2'),
(3, 'Group 3'),
(4, 'Group 4'),
(5, 'Group 5');

-- --------------------------------------------------------

--
-- Table structure for table `deliveries`
--

CREATE TABLE `deliveries` (
  `delivery_id` int(11) NOT NULL,
  `delivery_date` date NOT NULL,
  `employee_id` int(11) NOT NULL,
  `nota_id` int(11) NOT NULL,
  `delivery_cost` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `deliveries`
--

INSERT INTO `deliveries` (`delivery_id`, `delivery_date`, `employee_id`, `nota_id`, `delivery_cost`) VALUES
(1, '2017-07-12', 3, 2, 300000);

-- --------------------------------------------------------

--
-- Table structure for table `delivery_details`
--

CREATE TABLE `delivery_details` (
  `delivery_detail_id` int(11) NOT NULL,
  `delivery_id` int(11) NOT NULL,
  `delivery_detail_code` varchar(50) NOT NULL,
  `delivery_detail_status` int(11) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `delivery_detail_type` int(11) NOT NULL COMMENT '1 untuk kirim,2 untuk ambil'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `delivery_details`
--

INSERT INTO `delivery_details` (`delivery_detail_id`, `delivery_id`, `delivery_detail_code`, `delivery_detail_status`, `warehouse_id`, `delivery_detail_type`) VALUES
(1, 1, 'DO2017070001', 0, 1, 1),
(2, 1, 'DO2017070002', 0, 1, 2),
(3, 1, 'DO2017070003', 0, 2, 1),
(4, 1, 'DO2017070004', 0, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `delivery_sends`
--

CREATE TABLE `delivery_sends` (
  `delivery_send_id` int(11) NOT NULL,
  `delivery_detail_id` int(11) NOT NULL,
  `nota_detail_order_id` int(11) NOT NULL,
  `delivery_send_qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `delivery_sends`
--

INSERT INTO `delivery_sends` (`delivery_send_id`, `delivery_detail_id`, `nota_detail_order_id`, `delivery_send_qty`) VALUES
(1, 1, 24, 4),
(2, 2, 24, 1),
(3, 1, 8, 5),
(4, 2, 8, 5),
(5, 1, 10, 7),
(6, 2, 10, 1),
(7, 3, 11, 10),
(8, 4, 11, 3),
(9, 3, 25, 3),
(10, 4, 25, 1),
(11, 3, 9, 8),
(12, 4, 9, 5);

-- --------------------------------------------------------

--
-- Table structure for table `divisions`
--

CREATE TABLE `divisions` (
  `division_id` int(11) NOT NULL,
  `division_name` varchar(50) NOT NULL,
  `division_leader` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `divisions`
--

INSERT INTO `divisions` (`division_id`, `division_name`, `division_leader`) VALUES
(1, 'Kantor', 1),
(2, 'Lapangan', 2),
(3, 'Sopir', 0),
(4, 'Mandor', 0);

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `employee_id` int(11) NOT NULL,
  `employee_name` varchar(50) NOT NULL,
  `employee_address` varchar(100) NOT NULL,
  `employee_birth_date` date NOT NULL,
  `employee_hp` varchar(20) NOT NULL,
  `employee_rek` varchar(20) NOT NULL,
  `employee_bank` varchar(20) NOT NULL,
  `employee_npwp` varchar(20) NOT NULL,
  `employee_name_npwp` varchar(20) NOT NULL,
  `employee_ktp` varchar(20) NOT NULL,
  `division_id` int(11) NOT NULL,
  `employee_status` varchar(15) NOT NULL,
  `employee_begin` date NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `employee_first_salary` int(11) NOT NULL,
  `employee_piece` int(11) NOT NULL,
  `employee_over` int(11) NOT NULL,
  `employee_type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`employee_id`, `employee_name`, `employee_address`, `employee_birth_date`, `employee_hp`, `employee_rek`, `employee_bank`, `employee_npwp`, `employee_name_npwp`, `employee_ktp`, `division_id`, `employee_status`, `employee_begin`, `warehouse_id`, `employee_first_salary`, `employee_piece`, `employee_over`, `employee_type`) VALUES
(1, 'Sugiono', 'kjbhsdhf', '2017-03-16', '987230473', '9837483', 'MANDIRI', '8937432894', 'jshdsuifh', '987230473', 1, 'Aktif', '2017-05-23', 0, 0, 0, 0, 'Sales'),
(2, 'Sukijan', 'Surabaya', '2017-04-19', '09876545678', '4567898765', 'BCA', '4567887654', 'Ketenagakerjaan', '44567876543', 1, 'Aktif', '2017-04-19', 0, 2500000, 5000, 3000, 'Karyawan'),
(3, 'Paiman', 'dfgsdg', '2017-07-13', '45434', '3455434', 'BCA', '324543423', 'Ketenagakerjaan', '654345', 3, 'Aktif', '2017-07-11', 1, 1000000, 10000, 50000, 'Karyawan'),
(4, 'Joko', 'fghgfdsa', '2017-07-06', '34567', '45676543', 'BCA', '456787654', 'Ketenagakerjaan', '565432', 4, 'Aktif', '2017-07-17', 1, 5000000, 10000, 100000, 'Karyawan');

-- --------------------------------------------------------

--
-- Table structure for table `employee_cities`
--

CREATE TABLE `employee_cities` (
  `employee_city_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `employee_city_presentase` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employee_galeries`
--

CREATE TABLE `employee_galeries` (
  `employee_galery_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `employee_galery_file` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee_galeries`
--

INSERT INTO `employee_galeries` (`employee_galery_id`, `employee_id`, `employee_galery_file`) VALUES
(1, 2, 'ae9e2a86ae075469dc8665734cfd7b89.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `foremans`
--

CREATE TABLE `foremans` (
  `foreman_id` int(11) NOT NULL,
  `foreman_date` date NOT NULL,
  `employee_id` int(11) NOT NULL,
  `delivery_detail_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `foremans`
--

INSERT INTO `foremans` (`foreman_id`, `foreman_date`, `employee_id`, `delivery_detail_id`) VALUES
(1, '2017-07-14', 4, 1),
(2, '2017-07-21', 4, 3);

-- --------------------------------------------------------

--
-- Table structure for table `foreman_details`
--

CREATE TABLE `foreman_details` (
  `foreman_detail_id` int(11) NOT NULL,
  `foreman_id` int(11) NOT NULL,
  `delivery_send_id` int(11) NOT NULL,
  `foreman_detail_qty` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `foreman_details`
--

INSERT INTO `foreman_details` (`foreman_detail_id`, `foreman_id`, `delivery_send_id`, `foreman_detail_qty`, `user_id`) VALUES
(1, 1, 1, 4, 43),
(2, 1, 3, 5, 43),
(3, 1, 5, 7, 43),
(4, 2, 7, 10, 43),
(5, 2, 9, 3, 43),
(6, 2, 11, 5, 43);

-- --------------------------------------------------------

--
-- Table structure for table `foreman_racks`
--

CREATE TABLE `foreman_racks` (
  `foreman_rack_id` int(11) NOT NULL,
  `foreman_detail_id` int(11) NOT NULL,
  `rack_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `foreman_rack_qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `foreman_racks`
--

INSERT INTO `foreman_racks` (`foreman_rack_id`, `foreman_detail_id`, `rack_id`, `item_id`, `foreman_rack_qty`) VALUES
(1, 2, 1, 2, 4),
(2, 3, 1, 1, 5),
(3, 1, 3, 3, 4),
(4, 2, 3, 2, 1),
(5, 3, 3, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `gifts`
--

CREATE TABLE `gifts` (
  `gift_id` int(11) NOT NULL,
  `gift_name` varchar(20) NOT NULL,
  `gift_point` int(11) NOT NULL,
  `gift_img` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gifts`
--

INSERT INTO `gifts` (`gift_id`, `gift_name`, `gift_point`, `gift_img`) VALUES
(1, 'Sepeda', 1500, '31e8349a5d60e31704b1a162aea3162a.jpg'),
(2, 'TV', 500, '');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_id` int(11) NOT NULL,
  `item_clas_id` int(11) NOT NULL,
  `item_sub_clas_id` int(11) NOT NULL,
  `item_name` varchar(50) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `item_barcode` varchar(50) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `item_per_unit` int(11) NOT NULL,
  `item_min` int(11) NOT NULL,
  `item_max` int(11) NOT NULL,
  `item_last_price` int(11) NOT NULL,
  `item_price1` int(11) NOT NULL,
  `item_price2` int(11) NOT NULL,
  `item_price3` int(11) NOT NULL,
  `item_price4` int(11) NOT NULL,
  `item_price5` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `item_clas_id`, `item_sub_clas_id`, `item_name`, `brand_id`, `item_barcode`, `unit_id`, `item_per_unit`, `item_min`, `item_max`, `item_last_price`, `item_price1`, `item_price2`, `item_price3`, `item_price4`, `item_price5`) VALUES
(1, 1, 1, 'kawat', 2, '23432123', 2, 12, 234, 432, 1234567, 1000, 2000, 3000, 4000, 5000),
(2, 1, 1, 'Besi', 3, '2345', 4, 1, 10, 50, 2000, 2000, 3000, 4000, 5000, 6000),
(3, 1, 1, 'Paku', 4, '65432345', 2, 12, 12, 20, 1000, 2000, 3000, 4000, 5000, 6000),
(4, 1, 1, 'Klem', 3, '65432345', 2, 10, 20, 50, 20000, 30000, 40000, 50000, 60000, 70000);

-- --------------------------------------------------------

--
-- Table structure for table `item_clases`
--

CREATE TABLE `item_clases` (
  `item_clas_id` int(11) NOT NULL,
  `item_clas_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_clases`
--

INSERT INTO `item_clases` (`item_clas_id`, `item_clas_name`) VALUES
(1, 'Tekstil'),
(3, 'Kulit');

-- --------------------------------------------------------

--
-- Table structure for table `item_galeries`
--

CREATE TABLE `item_galeries` (
  `item_galery_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_galery_file` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_galeries`
--

INSERT INTO `item_galeries` (`item_galery_id`, `item_id`, `item_galery_file`) VALUES
(1, 1, '4bd8d605ac9363e92124df9979ba767a.jpg'),
(2, 1, '13a4d02090dcec645cb1c2f0abcab6e8.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `item_sub_clases`
--

CREATE TABLE `item_sub_clases` (
  `item_sub_clas_id` int(11) NOT NULL,
  `item_clas_id` int(11) NOT NULL,
  `item_sub_clas_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_sub_clases`
--

INSERT INTO `item_sub_clases` (`item_sub_clas_id`, `item_clas_id`, `item_sub_clas_name`) VALUES
(1, 1, 'Gelas');

-- --------------------------------------------------------

--
-- Table structure for table `notas`
--

CREATE TABLE `notas` (
  `nota_id` int(11) NOT NULL,
  `nota_code` varchar(25) NOT NULL,
  `nota_date` date NOT NULL,
  `customer_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `nota_type` int(11) NOT NULL,
  `coa_detail_id` int(11) NOT NULL,
  `nota_tempo` date NOT NULL,
  `nota_credit_card` varchar(20) NOT NULL,
  `nota_desc` varchar(100) NOT NULL,
  `nota_status` int(11) NOT NULL COMMENT '0 proses,1 do',
  `nota_reference` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notas`
--

INSERT INTO `notas` (`nota_id`, `nota_code`, `nota_date`, `customer_id`, `employee_id`, `nota_type`, `coa_detail_id`, `nota_tempo`, `nota_credit_card`, `nota_desc`, `nota_status`, `nota_reference`) VALUES
(2, 'NT2017060001', '2017-06-17', 1, 1, 1, 1, '2017-06-17', '', 'test', 0, 3),
(3, 'NT2017060002', '2017-06-17', 1, 1, 1, 1, '2017-06-17', '', '', 0, 0),
(4, 'NT2017070001', '2017-07-21', 1, 1, 1, 1, '2017-07-21', '', 'test', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `nota_details`
--

CREATE TABLE `nota_details` (
  `nota_detail_id` int(11) NOT NULL,
  `nota_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `nota_detail_qty` int(11) NOT NULL,
  `nota_detail_price` int(11) NOT NULL,
  `nota_detail_promo` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nota_details`
--

INSERT INTO `nota_details` (`nota_detail_id`, `nota_id`, `item_id`, `nota_detail_qty`, `nota_detail_price`, `nota_detail_promo`, `user_id`) VALUES
(5, 2, 2, 1, 5000, 5000, 11),
(6, 2, 1, 12, 4000, 4000, 11),
(13, 3, 2, 1, 5000, 0, 11),
(14, 3, 1, 12, 4000, 2000, 11),
(15, 2, 3, 12, 5000, 5000, 11),
(16, 4, 3, 12, 5000, 0, 43),
(17, 4, 1, 12, 4000, 4000, 43);

-- --------------------------------------------------------

--
-- Table structure for table `nota_detail_orders`
--

CREATE TABLE `nota_detail_orders` (
  `nota_detail_order_id` int(11) NOT NULL,
  `nota_detail_id` int(11) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `nota_detail_order_qty` int(11) NOT NULL,
  `nota_detail_order_now` int(11) NOT NULL,
  `accumulation_qty` int(11) NOT NULL,
  `accumulation_now` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nota_detail_orders`
--

INSERT INTO `nota_detail_orders` (`nota_detail_order_id`, `nota_detail_id`, `warehouse_id`, `item_id`, `nota_detail_order_qty`, `nota_detail_order_now`, `accumulation_qty`, `accumulation_now`) VALUES
(8, 5, 1, 2, 5, 5, 0, 0),
(9, 5, 2, 2, 8, 5, 0, 0),
(10, 6, 1, 1, 7, 1, 0, 0),
(11, 6, 2, 1, 10, 3, 0, 0),
(22, 13, 1, 2, 10, 0, 0, 0),
(23, 14, 1, 1, 2, 1, 0, 0),
(24, 15, 1, 3, 4, 1, 0, 0),
(25, 15, 2, 3, 3, 1, 0, 0),
(26, 17, 1, 1, 4, 2, 0, 0),
(27, 16, 1, 3, 1, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `oprationals`
--

CREATE TABLE `oprationals` (
  `oprational_id` int(11) NOT NULL,
  `oprational_name` varchar(50) NOT NULL,
  `oprational_coa` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oprationals`
--

INSERT INTO `oprationals` (`oprational_id`, `oprational_name`, `oprational_coa`) VALUES
(1, 'Test1', '1234567890dfghjkl');

-- --------------------------------------------------------

--
-- Table structure for table `partners`
--

CREATE TABLE `partners` (
  `partner_id` int(11) NOT NULL,
  `partner_name` varchar(50) NOT NULL,
  `partner_sales_name` varchar(50) NOT NULL,
  `category_id` int(11) NOT NULL,
  `partner_owner` varchar(50) NOT NULL,
  `partner_telp` varchar(20) NOT NULL,
  `partner_hp` varchar(20) NOT NULL,
  `partner_address` varchar(200) NOT NULL,
  `partner_rek` varchar(20) NOT NULL,
  `partner_bank` varchar(20) NOT NULL,
  `partner_mail` varchar(50) NOT NULL,
  `partner_npwp` varchar(20) NOT NULL,
  `partner_name_npwp` varchar(20) NOT NULL,
  `partner_npwp_rek` varchar(20) NOT NULL,
  `partner_npwp_bank` varchar(20) NOT NULL,
  `partner_tempo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `partners`
--

INSERT INTO `partners` (`partner_id`, `partner_name`, `partner_sales_name`, `category_id`, `partner_owner`, `partner_telp`, `partner_hp`, `partner_address`, `partner_rek`, `partner_bank`, `partner_mail`, `partner_npwp`, `partner_name_npwp`, `partner_npwp_rek`, `partner_npwp_bank`, `partner_tempo`) VALUES
(1, 'Jenggi', 'Jansuki', 1, 'Jumali', '678987654', '098765678', 'Surabaya', '56789865', 'BCA', 'jenggi@gmail.com', '345677654', 'ASKES', '65567876', 'BNI', 10),
(2, 'asdfghjghfgdf', 'dsfghjhg', 1, 'sdfghgf', '323454657', '234540', 'hghfds', '253645', 'asdfhfgdf', 'bffdsa@gmail.com', '32443', 'hgfd', '2435465', 'ngfdfs', 3456),
(3, 'fgdhgh', 'gfh', 3, 'fghgfh', '345', '34634', 'fh', '346', 'fghf', 'sdgsdfds@fdfhfdh.gj', '2353', 'fhg', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `permits`
--

CREATE TABLE `permits` (
  `permit_id` int(11) NOT NULL,
  `user_type_id` int(11) NOT NULL,
  `side_menu_id` int(11) NOT NULL,
  `permit_acces` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `permits`
--

INSERT INTO `permits` (`permit_id`, `user_type_id`, `side_menu_id`, `permit_acces`) VALUES
(534, 7, 1, '1'),
(535, 7, 2, '1'),
(536, 7, 3, '1'),
(537, 7, 18, '1'),
(538, 7, 29, 'u'),
(539, 7, 30, 'd'),
(540, 7, 46, '1'),
(541, 7, 57, 'c'),
(542, 7, 58, 'r'),
(543, 7, 59, 'u'),
(544, 7, 60, 'd'),
(545, 7, 61, 'u'),
(546, 7, 62, 'r'),
(547, 7, 63, 'c'),
(548, 7, 64, 'r'),
(549, 7, 65, 'r'),
(550, 7, 66, 'c'),
(551, 7, 67, 'r'),
(552, 7, 68, 'u'),
(553, 7, 69, 'd'),
(554, 7, 70, 'u'),
(555, 7, 71, 'r'),
(600, 9, 1, '1'),
(601, 9, 2, '1'),
(602, 9, 3, '1'),
(603, 9, 18, '1'),
(604, 9, 29, ''),
(605, 9, 30, ''),
(606, 9, 46, '1'),
(607, 9, 57, ''),
(608, 9, 58, ''),
(609, 9, 59, ''),
(610, 9, 60, ''),
(611, 9, 61, ''),
(612, 9, 62, ''),
(613, 9, 63, ''),
(614, 9, 64, ''),
(615, 9, 65, ''),
(616, 9, 66, ''),
(617, 9, 67, ''),
(618, 9, 68, ''),
(619, 9, 69, ''),
(620, 9, 70, ''),
(621, 9, 71, ''),
(714, 5, 1, '1'),
(715, 5, 2, '1'),
(716, 5, 3, '1'),
(717, 5, 18, '1'),
(718, 5, 29, 'c,r,u,d'),
(719, 5, 30, 'c,r,u,d'),
(720, 5, 46, '1'),
(721, 5, 57, 'c,r,u,d'),
(722, 5, 58, 'c,r,u,d'),
(723, 5, 59, 'c,r,u,d'),
(724, 5, 60, 'c,r,u,d'),
(725, 5, 61, 'c,r,u,d'),
(726, 5, 62, 'c,r,u,d'),
(727, 5, 63, 'c,r,u,d'),
(728, 5, 64, 'c,r,u,d'),
(729, 5, 65, 'c,r,u,d'),
(730, 5, 66, 'c,r,u,d'),
(731, 5, 68, 'c,r,u,d'),
(732, 5, 69, 'c,r,u,d'),
(733, 5, 70, 'c,r,u,d'),
(734, 5, 71, 'c,r,u,d'),
(735, 5, 72, 'c,r,u,d'),
(736, 5, 73, 'c,r,u,d'),
(737, 5, 74, 'c,r,u,d'),
(738, 5, 75, 'c,r,u,d'),
(739, 5, 76, 'c,r,u,d'),
(740, 5, 77, 'c,r,u,d'),
(741, 5, 78, 'c,r,u,d'),
(742, 5, 79, 'c,r,u,d'),
(743, 5, 80, 'c,r,u,d');

-- --------------------------------------------------------

--
-- Table structure for table `promotions`
--

CREATE TABLE `promotions` (
  `promotion_id` int(11) NOT NULL,
  `promotion_name` varchar(50) NOT NULL,
  `promotion_date1` date NOT NULL,
  `promotion_date2` date NOT NULL,
  `warehouse_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `promotions`
--

INSERT INTO `promotions` (`promotion_id`, `promotion_name`, `promotion_date1`, `promotion_date2`, `warehouse_id`) VALUES
(1, 'Lebaran', '2017-05-01', '2017-06-30', 1);

-- --------------------------------------------------------

--
-- Table structure for table `promotion_details`
--

CREATE TABLE `promotion_details` (
  `promotion_detail_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `promotion_detail_qty_min` int(11) NOT NULL,
  `promotion_detail_price` int(11) NOT NULL,
  `promotion_detail_item` int(11) NOT NULL,
  `promotion_detail_qty_bonus` int(11) NOT NULL,
  `promotion_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `promotion_details`
--

INSERT INTO `promotion_details` (`promotion_detail_id`, `item_id`, `promotion_detail_qty_min`, `promotion_detail_price`, `promotion_detail_item`, `promotion_detail_qty_bonus`, `promotion_id`, `user_id`) VALUES
(1, 1, 3, 3000, 1, 3, 1, 11);

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `purchase_id` int(11) NOT NULL,
  `purchase_code` varchar(50) NOT NULL,
  `purchase_date` date NOT NULL,
  `partner_id` int(11) NOT NULL,
  `purchase_tempo` date NOT NULL,
  `purchase_desc` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`purchase_id`, `purchase_code`, `purchase_date`, `partner_id`, `purchase_tempo`, `purchase_desc`) VALUES
(12, 'PU2017070001', '2017-07-26', 2, '2017-07-31', 'fs'),
(13, 'PU2017070002', '2017-07-27', 1, '2017-07-09', 'hgg');

-- --------------------------------------------------------

--
-- Table structure for table `purchases_details`
--

CREATE TABLE `purchases_details` (
  `purchase_detail_id` int(11) NOT NULL,
  `purchase_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `purchase_detail_qty` int(11) NOT NULL,
  `purchase_detail_price` int(11) NOT NULL,
  `purchase_detail_discount` int(11) NOT NULL,
  `purchase_detail_cost_transport` int(11) NOT NULL,
  `purchase_detail_cost_send` int(11) NOT NULL,
  `purchase_detail_cost_etc` int(11) NOT NULL,
  `purchase_detail_total` int(11) NOT NULL,
  `purchase_detail_qty_akumulation` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchases_details`
--

INSERT INTO `purchases_details` (`purchase_detail_id`, `purchase_id`, `item_id`, `user_id`, `purchase_detail_qty`, `purchase_detail_price`, `purchase_detail_discount`, `purchase_detail_cost_transport`, `purchase_detail_cost_send`, `purchase_detail_cost_etc`, `purchase_detail_total`, `purchase_detail_qty_akumulation`) VALUES
(1, 7, 0, 11, 2, 432, 2, 2, 2, 2, 2, 2),
(15, 8, 1, 11, 1, 12345, 1, 1, 1, 1, 1, 2),
(16, 9, 2, 11, 1, 432, 1, 1, 1, 1, 1, 2),
(17, 10, 1, 11, 2, 12345, 2, 2, 2, 2, 2, 2),
(18, 11, 0, 11, 2, 12345, 2, 2, 2, 2, 4, 2),
(19, 11, 0, 11, 1, 12345, 1, 1, 1, 1, 1, 2),
(32, 12, 2, 11, 23, 432, 3, 3, 3, 3, 3, 2),
(34, 13, 2, 11, 4, 432, 4, 4, 4, 4, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `racks`
--

CREATE TABLE `racks` (
  `rack_id` int(11) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `rack_name` varchar(20) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `racks`
--

INSERT INTO `racks` (`rack_id`, `warehouse_id`, `rack_name`, `user_id`) VALUES
(1, 1, 'Rak 1', 11),
(3, 1, 'Rak 2', 11),
(4, 2, 'Rak 1', 11),
(5, 2, 'Rak 2', 11),
(6, 2, 'Rak 3', 11);

-- --------------------------------------------------------

--
-- Table structure for table `rack_details`
--

CREATE TABLE `rack_details` (
  `rack_detail_id` int(11) NOT NULL,
  `rack_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rack_details`
--

INSERT INTO `rack_details` (`rack_detail_id`, `rack_id`, `item_id`) VALUES
(7, 1, 1),
(9, 3, 1),
(10, 4, 1),
(11, 5, 1),
(12, 6, 1),
(13, 1, 2),
(14, 3, 2),
(15, 4, 2),
(16, 5, 2),
(17, 6, 2),
(18, 1, 3),
(19, 1, 4),
(20, 4, 3),
(21, 4, 4),
(22, 3, 3),
(23, 3, 4),
(24, 5, 3),
(25, 5, 4),
(26, 6, 3),
(27, 6, 4);

-- --------------------------------------------------------

--
-- Table structure for table `receptions`
--

CREATE TABLE `receptions` (
  `reception_id` int(11) NOT NULL,
  `purchase_id` int(11) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `reception_date` date NOT NULL,
  `reception_code` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `receptions`
--

INSERT INTO `receptions` (`reception_id`, `purchase_id`, `warehouse_id`, `reception_date`, `reception_code`) VALUES
(1, 4, 1, '2017-07-30', 'RE2017070001'),
(2, 5, 1, '2017-07-06', 'RE2017070002'),
(3, 7, 2, '2017-07-30', 'RE2017070003'),
(4, 7, 1, '2017-07-28', 'RE2017070004'),
(5, 12, 2, '2017-07-13', 'RE2017070005');

-- --------------------------------------------------------

--
-- Table structure for table `receptions_details`
--

CREATE TABLE `receptions_details` (
  `reception_detail_id` int(11) NOT NULL,
  `purchase_detail_id` int(11) NOT NULL,
  `reception_id` int(11) NOT NULL,
  `reception_detail_order` int(11) NOT NULL,
  `reception_detail_qty` int(11) NOT NULL,
  `reception_detail_qty_batal` int(11) NOT NULL,
  `reception_detail_desc_batal` text NOT NULL,
  `reception_detail_qty_kembali` int(11) NOT NULL,
  `reception_detail_desc_kembali` text NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `receptions_details`
--

INSERT INTO `receptions_details` (`reception_detail_id`, `purchase_detail_id`, `reception_id`, `reception_detail_order`, `reception_detail_qty`, `reception_detail_qty_batal`, `reception_detail_desc_batal`, `reception_detail_qty_kembali`, `reception_detail_desc_kembali`, `user_id`) VALUES
(5, 1, 1, 10, 9, 1, 'barangnya belum datang', 0, '', 11),
(6, 12, 2, 1, 1, 0, '', 0, '', 11),
(7, 1, 3, 2, 2, 0, '', 0, '', 11),
(8, 1, 4, 2, 2, 0, '', 0, '', 11),
(9, 26, 5, 3, 2, 0, '', 0, '', 11),
(17, 2, 0, 4, 2, 0, '', 0, '', 11),
(22, 34, 0, 4, 1, 0, '', 0, '', 11),
(26, 34, 0, 4, 1, 0, '', 0, '', 11);

-- --------------------------------------------------------

--
-- Table structure for table `returs_suppliers`
--

CREATE TABLE `returs_suppliers` (
  `retur_supplier_id` int(11) NOT NULL,
  `purchase_id` int(11) NOT NULL,
  `retur_supplier_date` date NOT NULL,
  `retur_supplier_code` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `returs_suppliers`
--

INSERT INTO `returs_suppliers` (`retur_supplier_id`, `purchase_id`, `retur_supplier_date`, `retur_supplier_code`) VALUES
(29, 3, '2017-07-25', 'RS2017070001');

-- --------------------------------------------------------

--
-- Table structure for table `returs_suppliers_details`
--

CREATE TABLE `returs_suppliers_details` (
  `retur_supplier_detail_id` int(11) NOT NULL,
  `retur_supplier_id` int(11) NOT NULL,
  `retur_supplier_detail_qty` int(11) NOT NULL,
  `purchase_detail_id` int(11) NOT NULL,
  `retur_supplier_detail_desc` text NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `saless`
--

CREATE TABLE `saless` (
  `sales_id` int(11) NOT NULL,
  `sales_name` varchar(50) NOT NULL,
  `sales_address` varchar(100) NOT NULL,
  `sales_ktp` varchar(20) NOT NULL,
  `sales_hp` varchar(20) NOT NULL,
  `sales_simc` varchar(20) NOT NULL,
  `sales_birth` date NOT NULL,
  `sales_status` varchar(15) NOT NULL,
  `sales_note` text NOT NULL,
  `sales_begin` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `saless`
--

INSERT INTO `saless` (`sales_id`, `sales_name`, `sales_address`, `sales_ktp`, `sales_hp`, `sales_simc`, `sales_birth`, `sales_status`, `sales_note`, `sales_begin`) VALUES
(2, 'Sugiono', 'Surabaya', '567898765', '0987654345678', '345678765', '1989-06-20', 'Tidak Aktif', 'test testsan', '2017-05-17'),
(3, 'Jaini', 'gresik', '2345678765432', '23456765432', '23456776543', '2017-05-26', 'Aktif', 'test', '2017-05-18');

-- --------------------------------------------------------

--
-- Table structure for table `sales_cities`
--

CREATE TABLE `sales_cities` (
  `sales_city_id` int(11) NOT NULL,
  `sales_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales_cities`
--

INSERT INTO `sales_cities` (`sales_city_id`, `sales_id`, `city_id`) VALUES
(4, 2, 1),
(5, 2, 3),
(6, 3, 1),
(7, 3, 3),
(8, 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `sales_costs`
--

CREATE TABLE `sales_costs` (
  `sales_cost_id` int(11) NOT NULL,
  `sales_cost_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales_costs`
--

INSERT INTO `sales_costs` (`sales_cost_id`, `sales_cost_name`) VALUES
(1, 'Makan'),
(2, 'Kendaraan');

-- --------------------------------------------------------

--
-- Table structure for table `sales_galeries`
--

CREATE TABLE `sales_galeries` (
  `sales_galery_id` int(11) NOT NULL,
  `sales_id` int(11) NOT NULL,
  `sales_galery_file` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales_galeries`
--

INSERT INTO `sales_galeries` (`sales_galery_id`, `sales_id`, `sales_galery_file`) VALUES
(1, 2, '1489553006_alchemist-toxic-siege-armor-wallpaper.jpg'),
(2, 2, '1489553093_ember-spirit-dota-2-wallpaper.jpg'),
(5, 3, 'db80ce7abb86ef6e84717b6906d2b559.jpg'),
(6, 3, 'bb864b7a70080566b6dc6d696331aea3.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('0ndp0tgl8cb6jlbc4siklh3u1gnh30b2', '::1', 1499998151, 0x5f5f63695f6c6173745f726567656e65726174657c693a313439393939383037353b6c6f676765647c733a323a22696e223b757365725f69647c733a323a223131223b757365725f757365726e616d657c733a353a2261646d696e223b757365725f6e616d657c733a353a2241646d696e223b757365725f747970655f69647c733a313a2235223b),
('0trkaoj0f9ms6lk86qhel35brb86i59d', '::1', 1500004413, 0x6c6f676765647c733a323a22696e223b757365725f69647c733a323a223433223b757365725f757365726e616d657c733a363a226d616e646f72223b757365725f6e616d657c733a303a22223b757365725f747970655f69647c733a313a2235223b5f5f63695f6c6173745f726567656e65726174657c693a313530303030343138373b),
('1icp12u6q3emvt04g8en71t9730uvdr0', '::1', 1499937023, 0x6c6f676765647c733a323a22696e223b757365725f69647c733a323a223433223b757365725f757365726e616d657c733a363a226d616e646f72223b757365725f6e616d657c733a303a22223b757365725f747970655f69647c733a313a2235223b5f5f63695f6c6173745f726567656e65726174657c693a313439393933363838313b),
('1ubup2a76h78sksghp9ur0bufdt8jklr', '::1', 1500619919, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530303631393633353b6c6f676765647c733a323a22696e223b757365725f69647c733a323a223131223b757365725f757365726e616d657c733a353a2261646d696e223b757365725f6e616d657c733a353a2241646d696e223b757365725f747970655f69647c733a313a2235223b),
('2gmmqrlpcbrf5gh9fc1ue7frij56n648', '::1', 1500693570, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530303639333535363b6c6f676765647c733a323a22696e223b757365725f69647c733a323a223131223b757365725f757365726e616d657c733a353a2261646d696e223b757365725f6e616d657c733a353a2241646d696e223b757365725f747970655f69647c733a313a2235223b),
('2ose00uput97ktgpm9vfp2crgka9lm26', '::1', 1500016346, 0x6c6f676765647c733a323a22696e223b757365725f69647c733a323a223433223b757365725f757365726e616d657c733a363a226d616e646f72223b757365725f6e616d657c733a303a22223b757365725f747970655f69647c733a313a2235223b5f5f63695f6c6173745f726567656e65726174657c693a313530303031363333383b),
('358hg9vqrduakbb9c0echnin8gf472uv', '::1', 1500619439, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530303631393032353b6c6f676765647c733a323a22696e223b757365725f69647c733a323a223131223b757365725f757365726e616d657c733a353a2261646d696e223b757365725f6e616d657c733a353a2241646d696e223b757365725f747970655f69647c733a313a2235223b),
('437m7au8mv78qcck2sv5t8b7bpgqjkpu', '::1', 1500005276, 0x6c6f676765647c733a323a22696e223b757365725f69647c733a323a223433223b757365725f757365726e616d657c733a363a226d616e646f72223b757365725f6e616d657c733a303a22223b757365725f747970655f69647c733a313a2235223b5f5f63695f6c6173745f726567656e65726174657c693a313530303030353137343b),
('50a1tku6jim303fgjehegmlj4a0r9ljr', '::1', 1500620105, 0x6c6f676765647c733a323a22696e223b757365725f69647c733a323a223433223b757365725f757365726e616d657c733a363a226d616e646f72223b757365725f6e616d657c733a303a22223b757365725f747970655f69647c733a313a2235223b5f5f63695f6c6173745f726567656e65726174657c693a313530303631393935353b),
('5cdhhbl7g1b0khku4n0b75mdntgp9psg', '::1', 1500030289, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530303033303232353b6c6f676765647c733a323a22696e223b757365725f69647c733a323a223131223b757365725f757365726e616d657c733a353a2261646d696e223b757365725f6e616d657c733a353a2241646d696e223b757365725f747970655f69647c733a313a2235223b),
('7csjvd66cutkkugq4el5o1l2kqpm45qs', '::1', 1500023561, 0x6c6f676765647c733a323a22696e223b757365725f69647c733a323a223433223b757365725f757365726e616d657c733a363a226d616e646f72223b757365725f6e616d657c733a303a22223b757365725f747970655f69647c733a313a2235223b5f5f63695f6c6173745f726567656e65726174657c693a313530303032313837343b),
('81aabkcl5msjh1d4qp4plno5aklqg29k', '::1', 1500006062, 0x6c6f676765647c733a323a22696e223b757365725f69647c733a323a223433223b757365725f757365726e616d657c733a363a226d616e646f72223b757365725f6e616d657c733a303a22223b757365725f747970655f69647c733a313a2235223b5f5f63695f6c6173745f726567656e65726174657c693a313530303030353935363b),
('8aiaelfole2dhc73os4n5p3p77v69f3b', '::1', 1500605426, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530303630353330333b6c6f676765647c733a323a22696e223b757365725f69647c733a323a223131223b757365725f757365726e616d657c733a353a2261646d696e223b757365725f6e616d657c733a353a2241646d696e223b757365725f747970655f69647c733a313a2235223b),
('ac6h4k85fg42t05rj8a2aavem6aq8b15', '::1', 1500697274, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530303639373237323b6c6f676765647c733a323a22696e223b757365725f69647c733a323a223131223b757365725f757365726e616d657c733a353a2261646d696e223b757365725f6e616d657c733a353a2241646d696e223b757365725f747970655f69647c733a313a2235223b),
('c22vnkoef95flc1111dfjrlhhnhnshqt', '::1', 1500616589, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530303631363538313b6c6f676765647c733a323a22696e223b757365725f69647c733a323a223131223b757365725f757365726e616d657c733a353a2261646d696e223b757365725f6e616d657c733a353a2241646d696e223b757365725f747970655f69647c733a313a2235223b),
('cdg2efn9n3jind2u8jjnse1penaqlvip', '::1', 1500356511, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530303335363437343b6c6f676765647c733a323a22696e223b757365725f69647c733a323a223131223b757365725f757365726e616d657c733a353a2261646d696e223b757365725f6e616d657c733a353a2241646d696e223b757365725f747970655f69647c733a313a2235223b),
('d8pg4dp3rv2efvimpas7bj3mscfficip', '::1', 1500021867, 0x6c6f676765647c733a323a22696e223b757365725f69647c733a323a223433223b757365725f757365726e616d657c733a363a226d616e646f72223b757365725f6e616d657c733a303a22223b757365725f747970655f69647c733a313a2235223b5f5f63695f6c6173745f726567656e65726174657c693a313530303032313533333b),
('djna183tj9p8hh59rhfs2omljo52rvnc', '::1', 1500608589, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530303630383536393b6c6f676765647c733a323a22696e223b757365725f69647c733a323a223131223b757365725f757365726e616d657c733a353a2261646d696e223b757365725f6e616d657c733a353a2241646d696e223b757365725f747970655f69647c733a313a2235223b),
('f5luq9ieeg6bn4pl89qdr1mdo1faa63i', '::1', 1500004132, 0x6c6f676765647c733a323a22696e223b757365725f69647c733a323a223433223b757365725f757365726e616d657c733a363a226d616e646f72223b757365725f6e616d657c733a303a22223b757365725f747970655f69647c733a313a2235223b5f5f63695f6c6173745f726567656e65726174657c693a313530303030333832353b),
('fn111rdovicgvfg9kmk157hqp3dh18ab', '::1', 1500018895, 0x6c6f676765647c733a323a22696e223b757365725f69647c733a323a223433223b757365725f757365726e616d657c733a363a226d616e646f72223b757365725f6e616d657c733a303a22223b757365725f747970655f69647c733a313a2235223b5f5f63695f6c6173745f726567656e65726174657c693a313530303031373734343b),
('grj6sgbnn8h1vv5tmgk2j8sm69931k25', '::1', 1499937912, 0x6c6f676765647c733a323a22696e223b757365725f69647c733a323a223433223b757365725f757365726e616d657c733a363a226d616e646f72223b757365725f6e616d657c733a303a22223b757365725f747970655f69647c733a313a2235223b5f5f63695f6c6173745f726567656e65726174657c693a313439393933373835393b),
('irlfbjvjm3oqfhgpufk7mnnf33p0nd53', '::1', 1500011554, 0x6c6f676765647c733a323a22696e223b757365725f69647c733a323a223433223b757365725f757365726e616d657c733a363a226d616e646f72223b757365725f6e616d657c733a303a22223b757365725f747970655f69647c733a313a2235223b5f5f63695f6c6173745f726567656e65726174657c693a313530303030373032383b),
('jdvnlbg7c4ummc3kh39qb5m8c9jl9o0q', '::1', 1499937401, 0x6c6f676765647c733a323a22696e223b757365725f69647c733a323a223433223b757365725f757365726e616d657c733a363a226d616e646f72223b757365725f6e616d657c733a303a22223b757365725f747970655f69647c733a313a2235223b5f5f63695f6c6173745f726567656e65726174657c693a313439393933373237303b),
('jph7qamr788v0ifs7458mg5tor094aie', '::1', 1500005913, 0x6c6f676765647c733a323a22696e223b757365725f69647c733a323a223433223b757365725f757365726e616d657c733a363a226d616e646f72223b757365725f6e616d657c733a303a22223b757365725f747970655f69647c733a313a2235223b5f5f63695f6c6173745f726567656e65726174657c693a313530303030353634343b),
('k4tosus89vm485ide53umjkf4af5i2nl', '::1', 1499939548, 0x6c6f676765647c733a323a22696e223b757365725f69647c733a323a223433223b757365725f757365726e616d657c733a363a226d616e646f72223b757365725f6e616d657c733a303a22223b757365725f747970655f69647c733a313a2235223b5f5f63695f6c6173745f726567656e65726174657c693a313439393933383638393b),
('kacrk7te2nht1f164m941jima7hk1tfq', '::1', 1500005083, 0x6c6f676765647c733a323a22696e223b757365725f69647c733a323a223433223b757365725f757365726e616d657c733a363a226d616e646f72223b757365725f6e616d657c733a303a22223b757365725f747970655f69647c733a313a2235223b5f5f63695f6c6173745f726567656e65726174657c693a313530303030343737343b),
('kmbi2gmg3hk3r4sned14bdbd90i8ipjn', '::1', 1500002068, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530303030323032353b6c6f676765647c733a323a22696e223b757365725f69647c733a323a223131223b757365725f757365726e616d657c733a353a2261646d696e223b757365725f6e616d657c733a353a2241646d696e223b757365725f747970655f69647c733a313a2235223b),
('lrdvkk127ll5sve6dc3pha0fc3ba86qo', '::1', 1499939564, 0x6c6f676765647c733a323a22696e223b757365725f69647c733a323a223433223b757365725f757365726e616d657c733a363a226d616e646f72223b757365725f6e616d657c733a303a22223b757365725f747970655f69647c733a313a2235223b5f5f63695f6c6173745f726567656e65726174657c693a313439393933393535343b),
('lsnkfvja1k3uh3hmj672i8nd25ithqiq', '::1', 1499998623, 0x5f5f63695f6c6173745f726567656e65726174657c693a313439393939383531333b6c6f676765647c733a323a22696e223b757365725f69647c733a323a223131223b757365725f757365726e616d657c733a353a2261646d696e223b757365725f6e616d657c733a353a2241646d696e223b757365725f747970655f69647c733a313a2235223b),
('mnsctv17ptc4ps4b2it5qhrgks5sir4h', '::1', 1500707696, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530303730373635363b6c6f676765647c733a323a22696e223b757365725f69647c733a323a223131223b757365725f757365726e616d657c733a353a2261646d696e223b757365725f6e616d657c733a353a2241646d696e223b757365725f747970655f69647c733a313a2235223b),
('q0jkcbnpm49adh96t941834gih00bkpu', '::1', 1500012220, 0x6c6f676765647c733a323a22696e223b757365725f69647c733a323a223433223b757365725f757365726e616d657c733a363a226d616e646f72223b757365725f6e616d657c733a303a22223b757365725f747970655f69647c733a313a2235223b5f5f63695f6c6173745f726567656e65726174657c693a313530303031323231363b),
('q4t2reo272dqrmrqa2pt8fd74b78glfn', '::1', 1500017448, 0x6c6f676765647c733a323a22696e223b757365725f69647c733a323a223433223b757365725f757365726e616d657c733a363a226d616e646f72223b757365725f6e616d657c733a303a22223b757365725f747970655f69647c733a313a2235223b5f5f63695f6c6173745f726567656e65726174657c693a313530303031363937323b),
('q5v3hs7h2ck7b7bnt7omqh7vvou7uoku', '::1', 1500015189, 0x6c6f676765647c733a323a22696e223b757365725f69647c733a323a223433223b757365725f757365726e616d657c733a363a226d616e646f72223b757365725f6e616d657c733a303a22223b757365725f747970655f69647c733a313a2235223b5f5f63695f6c6173745f726567656e65726174657c693a313530303031353133353b),
('rnk5rnlibnaga5pi73ij7e6q91cd9664', '::1', 1500016933, 0x6c6f676765647c733a323a22696e223b757365725f69647c733a323a223433223b757365725f757365726e616d657c733a363a226d616e646f72223b757365725f6e616d657c733a303a22223b757365725f747970655f69647c733a313a2235223b5f5f63695f6c6173745f726567656e65726174657c693a313530303031363635333b),
('s1pfcrrc7e643apadvrtvep6lg34151c', '::1', 1500706523, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530303730363531323b6c6f676765647c733a323a22696e223b757365725f69647c733a323a223131223b757365725f757365726e616d657c733a353a2261646d696e223b757365725f6e616d657c733a353a2241646d696e223b757365725f747970655f69647c733a313a2235223b),
('s86drjk7neudfrvltqe41v8rbc1tcvr1', '::1', 1500616165, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530303631363135343b6c6f676765647c733a323a22696e223b757365725f69647c733a323a223131223b757365725f757365726e616d657c733a353a2261646d696e223b757365725f6e616d657c733a353a2241646d696e223b757365725f747970655f69647c733a313a2235223b),
('sfee18hnud7jpi8u4ndquvegjvlrubui', '::1', 1500020434, 0x6c6f676765647c733a323a22696e223b757365725f69647c733a323a223433223b757365725f757365726e616d657c733a363a226d616e646f72223b757365725f6e616d657c733a303a22223b757365725f747970655f69647c733a313a2235223b5f5f63695f6c6173745f726567656e65726174657c693a313530303031383935323b),
('sh4bj4bjpfhhebbmfdg438oo35vuue61', '::1', 1500001714, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530303030313632303b6c6f676765647c733a323a22696e223b757365725f69647c733a323a223131223b757365725f757365726e616d657c733a353a2261646d696e223b757365725f6e616d657c733a353a2241646d696e223b757365725f747970655f69647c733a313a2235223b),
('u5p6ennpafn1embta0p3o09lfvt009ed', '::1', 1500620661, 0x6c6f676765647c733a323a22696e223b757365725f69647c733a323a223433223b757365725f757365726e616d657c733a363a226d616e646f72223b757365725f6e616d657c733a303a22223b757365725f747970655f69647c733a313a2235223b5f5f63695f6c6173745f726567656e65726174657c693a313530303632303339393b),
('v4deia2fjdl5maus92mb7m8s5phqag3v', '::1', 1499938605, 0x6c6f676765647c733a323a22696e223b757365725f69647c733a323a223433223b757365725f757365726e616d657c733a363a226d616e646f72223b757365725f6e616d657c733a303a22223b757365725f747970655f69647c733a313a2235223b5f5f63695f6c6173745f726567656e65726174657c693a313439393933383335313b);

-- --------------------------------------------------------

--
-- Table structure for table `side_menus`
--

CREATE TABLE `side_menus` (
  `side_menu_id` int(11) NOT NULL,
  `side_menu_name` varchar(100) NOT NULL,
  `side_menu_url` varchar(100) NOT NULL,
  `side_menu_parent` int(11) NOT NULL,
  `side_menu_icon` varchar(100) NOT NULL,
  `side_menu_level` int(11) NOT NULL,
  `side_menu_type_parent` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `side_menus`
--

INSERT INTO `side_menus` (`side_menu_id`, `side_menu_name`, `side_menu_url`, `side_menu_parent`, `side_menu_icon`, `side_menu_level`, `side_menu_type_parent`) VALUES
(1, 'Dashboard', 'Dashboard', 0, 'glyphicon glyphicon-home', 1, 1),
(2, 'Master Data', '#', 0, 'glyphicon glyphicon-edit', 1, 1),
(3, 'Setup Data', '#', 0, 'glyphicon glyphicon-hdd', 1, 1),
(18, 'Setting', '#', 0, 'glyphicon glyphicon-cog', 1, 1),
(29, 'User', 'Setting/User', 18, '', 2, 0),
(30, 'Type User', 'Setting/Type-User', 18, '', 2, 0),
(46, 'Transaksi', '#', 0, 'glyphicon glyphicon-shopping-cart', 1, 1),
(57, 'Bank', 'Setup-Data/Bank', 3, '', 2, 0),
(58, 'Biaya Sales', 'Setup-Data/Biaya-Sales', 3, '', 2, 0),
(59, 'Divisi', 'Setup-Data/Divisi', 3, '', 2, 0),
(60, 'Hadiah', 'Setup-Data/Hadiah', 3, '', 2, 0),
(61, 'Kendaraan', 'Setup-Data/Kendaraan', 3, '', 2, 0),
(62, 'Merk', 'Setup-Data/Merk', 3, '', 2, 0),
(63, 'Oprasional', 'Setup-Data/Oprasional', 3, '', 2, 0),
(64, 'Wilayah', 'Setup-Data/Wilayah', 3, '', 2, 0),
(65, 'Karyawan/Sales', 'Master-Data/Karyawan', 2, '', 2, 0),
(66, 'Partner', 'Master-Data/Partner', 2, '', 2, 0),
(68, 'Barang', 'Master-Data/Barang', 2, '', 2, 0),
(69, 'Gudang', 'Master-Data/Gudang', 2, '', 2, 0),
(70, 'Promo', 'Master-Data/Promo', 2, '', 2, 0),
(71, 'Customer', 'Master-Data/Customer', 2, '', 2, 0),
(72, 'Nota', 'Transaksi/Nota', 46, '', 2, 0),
(73, 'Delivery Order', 'Transaksi/Delivery-Order', 46, '', 2, 0),
(74, 'Mandor Gudang', 'Transaksi/Mandor-Gudang', 46, '', 2, 0),
(75, 'Pembelian', 'Transaksi/Pembelian', 46, '', 2, 0),
(76, 'Penerimaan Supplier', 'Transaksi/Penerimaan-Barang', 46, '', 2, 0),
(77, 'Return Supplier', 'Transaksi/Return', 46, '', 2, 0),
(78, 'Kas', 'Transaksi/Kas', 46, '', 2, 0),
(79, 'Biaya Sales', 'Transaksi/Cost-Sales', 46, '', 2, 0),
(80, 'Pengeluaran Operasional', 'Transaksi/Pengeluaran-Operasional', 46, '', 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `spendings`
--

CREATE TABLE `spendings` (
  `spending_id` int(11) NOT NULL,
  `spending_date` date NOT NULL,
  `spending_needs` varchar(50) NOT NULL,
  `spending_cost` int(11) NOT NULL,
  `spending_code` varchar(50) NOT NULL,
  `oprational_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `spendings_details`
--

CREATE TABLE `spendings_details` (
  `spending_detail_id` int(11) NOT NULL,
  `spending_id` int(11) NOT NULL,
  `spending_detail_cost_total` int(11) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `spendings_details`
--

INSERT INTO `spendings_details` (`spending_detail_id`, `spending_id`, `spending_detail_cost_total`, `warehouse_id`, `user_id`) VALUES
(1, 3, 6, 1, 11);

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `stock_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `rack_id` int(11) NOT NULL,
  `stock_qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`stock_id`, `item_id`, `rack_id`, `stock_qty`) VALUES
(1, 1, 1, 120),
(2, 1, 3, 100),
(3, 1, 4, 200),
(4, 1, 5, 300),
(5, 1, 6, 500),
(6, 2, 1, 20),
(7, 2, 3, 5),
(8, 2, 4, 3),
(9, 2, 5, 5),
(10, 2, 6, 30),
(11, 3, 1, 20),
(12, 4, 1, 50),
(13, 3, 4, 50),
(14, 4, 4, 100),
(15, 3, 3, 100),
(16, 4, 3, 25),
(17, 3, 5, 30),
(18, 4, 5, 20),
(19, 3, 6, 20),
(20, 4, 6, 20);

-- --------------------------------------------------------

--
-- Table structure for table `transaless`
--

CREATE TABLE `transaless` (
  `transales_id` int(11) NOT NULL,
  `transales_periode` date NOT NULL,
  `transales_code` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transaless_details`
--

CREATE TABLE `transaless_details` (
  `transales_detail_id` int(11) NOT NULL,
  `transales_id` int(11) NOT NULL,
  `sales_id` int(11) NOT NULL,
  `transales_detail_cost_arround` int(11) NOT NULL,
  `transales_detail_cost_additional` int(11) NOT NULL,
  `cash_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaless_details`
--

INSERT INTO `transaless_details` (`transales_detail_id`, `transales_id`, `sales_id`, `transales_detail_cost_arround`, `transales_detail_cost_additional`, `cash_id`, `user_id`) VALUES
(6, 8, 2, 30000, 20000, 100000, 11),
(8, 9, 2, 10000, 10000, 1, 11),
(9, 10, 3, 1000, 1000, 1, 11),
(10, 11, 2, 2000, 2000, 1, 11),
(11, 12, 3, 20000, 20000, 1, 11);

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `unit_id` int(11) NOT NULL,
  `unit_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`unit_id`, `unit_name`) VALUES
(1, 'Biji'),
(2, 'Box'),
(3, 'Saset'),
(4, 'Kg'),
(5, 'Karung');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_type_id` int(11) DEFAULT NULL,
  `user_username` varchar(100) DEFAULT NULL,
  `user_password` varchar(100) DEFAULT NULL,
  `user_name` varchar(100) DEFAULT NULL,
  `user_addres` varchar(100) NOT NULL,
  `user_ktp` varchar(100) DEFAULT NULL,
  `user_img` text NOT NULL,
  `user_active_status` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_type_id`, `user_username`, `user_password`, `user_name`, `user_addres`, `user_ktp`, `user_img`, `user_active_status`, `employee_id`) VALUES
(11, 5, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Admin', '', 'A0001', '', 1, 0),
(41, 5, 'aku', '8dfa2998de01f7013440139135151812', 'aku', 'aku', 'aku', '6b2fffd3a02f9b88282d7efdf0ab2622.jpg', 1, 0),
(42, 5, 'test', '098f6bcd4621d373cade4e832627b4f6', 'Test', 'surabaya', '45678987654', '1489139109_505544.jpg', 1, 0),
(43, 5, 'mandor', '707d803707c87747c71b0e5513ef73a9', '', 'jhgfdsdfg', '23456654', '435d2fa58f9ad215f0cefff5f5bf4374.jpg', 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `user_types`
--

CREATE TABLE `user_types` (
  `user_type_id` int(11) NOT NULL,
  `user_type_name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_types`
--

INSERT INTO `user_types` (`user_type_id`, `user_type_name`) VALUES
(4, 'Direktur'),
(5, 'Super User'),
(6, 'Sales'),
(7, 'Administrator'),
(8, 'Sales Manager');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `vehicle_id` int(11) NOT NULL,
  `vehicle_name` varchar(50) NOT NULL,
  `vehicle_brand` varchar(20) NOT NULL,
  `vehicle_year` int(11) NOT NULL,
  `vehicle_kir` date NOT NULL,
  `vehicle_stnk` varchar(20) NOT NULL,
  `vehicle_stnk_date` date NOT NULL,
  `vehicle_bpkb` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`vehicle_id`, `vehicle_name`, `vehicle_brand`, `vehicle_year`, `vehicle_kir`, `vehicle_stnk`, `vehicle_stnk_date`, `vehicle_bpkb`) VALUES
(1, 'Kijang Inova', 'Toyota', 2015, '2015-06-01', '765434567876', '2017-06-19', '234567654345');

-- --------------------------------------------------------

--
-- Table structure for table `warehouses`
--

CREATE TABLE `warehouses` (
  `warehouse_id` int(11) NOT NULL,
  `warehouse_name` varchar(50) NOT NULL,
  `warehouse_telp` varchar(50) NOT NULL,
  `warehouse_address` varchar(200) NOT NULL,
  `warehouse_fax` varchar(50) NOT NULL,
  `warehouse_pic` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `warehouses`
--

INSERT INTO `warehouses` (`warehouse_id`, `warehouse_name`, `warehouse_telp`, `warehouse_address`, `warehouse_fax`, `warehouse_pic`) VALUES
(1, 'Gudang 1', '1234567654', 'surabaya', '234567887654', '23456787654'),
(2, 'Gudang 2', '654334', 'ghjkkhjhg', '6756454565', 'as');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`bank_id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`brand_id`);

--
-- Indexes for table `business`
--
ALTER TABLE `business`
  ADD PRIMARY KEY (`busines_id`);

--
-- Indexes for table `cashs`
--
ALTER TABLE `cashs`
  ADD PRIMARY KEY (`cash_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `category_prices`
--
ALTER TABLE `category_prices`
  ADD PRIMARY KEY (`category_price_id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`city_id`);

--
-- Indexes for table `coas`
--
ALTER TABLE `coas`
  ADD PRIMARY KEY (`coa_id`);

--
-- Indexes for table `coa_details`
--
ALTER TABLE `coa_details`
  ADD PRIMARY KEY (`coa_detail_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `customer_details`
--
ALTER TABLE `customer_details`
  ADD PRIMARY KEY (`customer_detail_id`);

--
-- Indexes for table `customer_groups`
--
ALTER TABLE `customer_groups`
  ADD PRIMARY KEY (`customer_group_id`);

--
-- Indexes for table `deliveries`
--
ALTER TABLE `deliveries`
  ADD PRIMARY KEY (`delivery_id`);

--
-- Indexes for table `delivery_details`
--
ALTER TABLE `delivery_details`
  ADD PRIMARY KEY (`delivery_detail_id`);

--
-- Indexes for table `delivery_sends`
--
ALTER TABLE `delivery_sends`
  ADD PRIMARY KEY (`delivery_send_id`);

--
-- Indexes for table `divisions`
--
ALTER TABLE `divisions`
  ADD PRIMARY KEY (`division_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`employee_id`);

--
-- Indexes for table `employee_cities`
--
ALTER TABLE `employee_cities`
  ADD PRIMARY KEY (`employee_city_id`);

--
-- Indexes for table `employee_galeries`
--
ALTER TABLE `employee_galeries`
  ADD PRIMARY KEY (`employee_galery_id`);

--
-- Indexes for table `foremans`
--
ALTER TABLE `foremans`
  ADD PRIMARY KEY (`foreman_id`);

--
-- Indexes for table `foreman_details`
--
ALTER TABLE `foreman_details`
  ADD PRIMARY KEY (`foreman_detail_id`);

--
-- Indexes for table `foreman_racks`
--
ALTER TABLE `foreman_racks`
  ADD PRIMARY KEY (`foreman_rack_id`);

--
-- Indexes for table `gifts`
--
ALTER TABLE `gifts`
  ADD PRIMARY KEY (`gift_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `item_clases`
--
ALTER TABLE `item_clases`
  ADD PRIMARY KEY (`item_clas_id`);

--
-- Indexes for table `item_galeries`
--
ALTER TABLE `item_galeries`
  ADD PRIMARY KEY (`item_galery_id`);

--
-- Indexes for table `item_sub_clases`
--
ALTER TABLE `item_sub_clases`
  ADD PRIMARY KEY (`item_sub_clas_id`);

--
-- Indexes for table `notas`
--
ALTER TABLE `notas`
  ADD PRIMARY KEY (`nota_id`);

--
-- Indexes for table `nota_details`
--
ALTER TABLE `nota_details`
  ADD PRIMARY KEY (`nota_detail_id`);

--
-- Indexes for table `nota_detail_orders`
--
ALTER TABLE `nota_detail_orders`
  ADD PRIMARY KEY (`nota_detail_order_id`);

--
-- Indexes for table `oprationals`
--
ALTER TABLE `oprationals`
  ADD PRIMARY KEY (`oprational_id`);

--
-- Indexes for table `partners`
--
ALTER TABLE `partners`
  ADD PRIMARY KEY (`partner_id`);

--
-- Indexes for table `permits`
--
ALTER TABLE `permits`
  ADD PRIMARY KEY (`permit_id`);

--
-- Indexes for table `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`promotion_id`);

--
-- Indexes for table `promotion_details`
--
ALTER TABLE `promotion_details`
  ADD PRIMARY KEY (`promotion_detail_id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`purchase_id`);

--
-- Indexes for table `purchases_details`
--
ALTER TABLE `purchases_details`
  ADD PRIMARY KEY (`purchase_detail_id`);

--
-- Indexes for table `racks`
--
ALTER TABLE `racks`
  ADD PRIMARY KEY (`rack_id`);

--
-- Indexes for table `rack_details`
--
ALTER TABLE `rack_details`
  ADD PRIMARY KEY (`rack_detail_id`);

--
-- Indexes for table `receptions`
--
ALTER TABLE `receptions`
  ADD PRIMARY KEY (`reception_id`);

--
-- Indexes for table `receptions_details`
--
ALTER TABLE `receptions_details`
  ADD PRIMARY KEY (`reception_detail_id`);

--
-- Indexes for table `returs_suppliers`
--
ALTER TABLE `returs_suppliers`
  ADD PRIMARY KEY (`retur_supplier_id`);

--
-- Indexes for table `returs_suppliers_details`
--
ALTER TABLE `returs_suppliers_details`
  ADD PRIMARY KEY (`retur_supplier_detail_id`);

--
-- Indexes for table `saless`
--
ALTER TABLE `saless`
  ADD PRIMARY KEY (`sales_id`);

--
-- Indexes for table `sales_cities`
--
ALTER TABLE `sales_cities`
  ADD PRIMARY KEY (`sales_city_id`);

--
-- Indexes for table `sales_costs`
--
ALTER TABLE `sales_costs`
  ADD PRIMARY KEY (`sales_cost_id`);

--
-- Indexes for table `sales_galeries`
--
ALTER TABLE `sales_galeries`
  ADD PRIMARY KEY (`sales_galery_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `side_menus`
--
ALTER TABLE `side_menus`
  ADD PRIMARY KEY (`side_menu_id`);

--
-- Indexes for table `spendings`
--
ALTER TABLE `spendings`
  ADD PRIMARY KEY (`spending_id`);

--
-- Indexes for table `spendings_details`
--
ALTER TABLE `spendings_details`
  ADD PRIMARY KEY (`spending_detail_id`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`stock_id`);

--
-- Indexes for table `transaless`
--
ALTER TABLE `transaless`
  ADD PRIMARY KEY (`transales_id`);

--
-- Indexes for table `transaless_details`
--
ALTER TABLE `transaless_details`
  ADD PRIMARY KEY (`transales_detail_id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`unit_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_types`
--
ALTER TABLE `user_types`
  ADD PRIMARY KEY (`user_type_id`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`vehicle_id`);

--
-- Indexes for table `warehouses`
--
ALTER TABLE `warehouses`
  ADD PRIMARY KEY (`warehouse_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banks`
--
ALTER TABLE `banks`
  MODIFY `bank_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `brand_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `business`
--
ALTER TABLE `business`
  MODIFY `busines_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `cashs`
--
ALTER TABLE `cashs`
  MODIFY `cash_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `category_prices`
--
ALTER TABLE `category_prices`
  MODIFY `category_price_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `city_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `coas`
--
ALTER TABLE `coas`
  MODIFY `coa_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `coa_details`
--
ALTER TABLE `coa_details`
  MODIFY `coa_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `customer_details`
--
ALTER TABLE `customer_details`
  MODIFY `customer_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `customer_groups`
--
ALTER TABLE `customer_groups`
  MODIFY `customer_group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `deliveries`
--
ALTER TABLE `deliveries`
  MODIFY `delivery_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `delivery_details`
--
ALTER TABLE `delivery_details`
  MODIFY `delivery_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `delivery_sends`
--
ALTER TABLE `delivery_sends`
  MODIFY `delivery_send_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `divisions`
--
ALTER TABLE `divisions`
  MODIFY `division_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `employee_cities`
--
ALTER TABLE `employee_cities`
  MODIFY `employee_city_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `employee_galeries`
--
ALTER TABLE `employee_galeries`
  MODIFY `employee_galery_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `foremans`
--
ALTER TABLE `foremans`
  MODIFY `foreman_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `foreman_details`
--
ALTER TABLE `foreman_details`
  MODIFY `foreman_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `foreman_racks`
--
ALTER TABLE `foreman_racks`
  MODIFY `foreman_rack_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `gifts`
--
ALTER TABLE `gifts`
  MODIFY `gift_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `item_clases`
--
ALTER TABLE `item_clases`
  MODIFY `item_clas_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `item_galeries`
--
ALTER TABLE `item_galeries`
  MODIFY `item_galery_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `item_sub_clases`
--
ALTER TABLE `item_sub_clases`
  MODIFY `item_sub_clas_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `notas`
--
ALTER TABLE `notas`
  MODIFY `nota_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `nota_details`
--
ALTER TABLE `nota_details`
  MODIFY `nota_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `nota_detail_orders`
--
ALTER TABLE `nota_detail_orders`
  MODIFY `nota_detail_order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `oprationals`
--
ALTER TABLE `oprationals`
  MODIFY `oprational_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `partners`
--
ALTER TABLE `partners`
  MODIFY `partner_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `permits`
--
ALTER TABLE `permits`
  MODIFY `permit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=744;
--
-- AUTO_INCREMENT for table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `promotion_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `promotion_details`
--
ALTER TABLE `promotion_details`
  MODIFY `promotion_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `purchase_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `purchases_details`
--
ALTER TABLE `purchases_details`
  MODIFY `purchase_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `racks`
--
ALTER TABLE `racks`
  MODIFY `rack_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `rack_details`
--
ALTER TABLE `rack_details`
  MODIFY `rack_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `receptions`
--
ALTER TABLE `receptions`
  MODIFY `reception_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `receptions_details`
--
ALTER TABLE `receptions_details`
  MODIFY `reception_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `returs_suppliers`
--
ALTER TABLE `returs_suppliers`
  MODIFY `retur_supplier_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `returs_suppliers_details`
--
ALTER TABLE `returs_suppliers_details`
  MODIFY `retur_supplier_detail_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `saless`
--
ALTER TABLE `saless`
  MODIFY `sales_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `sales_cities`
--
ALTER TABLE `sales_cities`
  MODIFY `sales_city_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `sales_costs`
--
ALTER TABLE `sales_costs`
  MODIFY `sales_cost_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `sales_galeries`
--
ALTER TABLE `sales_galeries`
  MODIFY `sales_galery_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `side_menus`
--
ALTER TABLE `side_menus`
  MODIFY `side_menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;
--
-- AUTO_INCREMENT for table `spendings`
--
ALTER TABLE `spendings`
  MODIFY `spending_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `spendings_details`
--
ALTER TABLE `spendings_details`
  MODIFY `spending_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `stock_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `transaless`
--
ALTER TABLE `transaless`
  MODIFY `transales_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `transaless_details`
--
ALTER TABLE `transaless_details`
  MODIFY `transales_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `unit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
--
-- AUTO_INCREMENT for table `user_types`
--
ALTER TABLE `user_types`
  MODIFY `user_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `vehicle_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `warehouses`
--
ALTER TABLE `warehouses`
  MODIFY `warehouse_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
