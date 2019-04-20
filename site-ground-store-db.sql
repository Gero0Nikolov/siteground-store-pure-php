-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 20, 2019 at 03:24 PM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `site-ground-store-db`
--

-- --------------------------------------------------------

--
-- Table structure for table `str_products`
--

CREATE TABLE `str_products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `str_products`
--

INSERT INTO `str_products` (`id`, `product_name`, `date_created`) VALUES
(1, 'Product 1', '2019-04-20 13:22:46'),
(2, 'Product 2', '2019-04-20 13:22:58'),
(3, 'Product 3', '2019-04-20 13:23:08'),
(4, 'Product 4', '2019-04-20 13:23:24');

-- --------------------------------------------------------

--
-- Table structure for table `str_products_discounts`
--

CREATE TABLE `str_products_discounts` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `product_price` decimal(11,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `str_products_discounts`
--

INSERT INTO `str_products_discounts` (`id`, `product_id`, `quantity`, `product_price`) VALUES
(1, 1, 2, '15.00'),
(2, 2, 3, '10.00'),
(3, 4, 6, '10.00');

-- --------------------------------------------------------

--
-- Table structure for table `str_products_prices`
--

CREATE TABLE `str_products_prices` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_price` decimal(11,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `str_products_prices`
--

INSERT INTO `str_products_prices` (`id`, `product_id`, `product_price`) VALUES
(1, 1, '10.00'),
(2, 2, '5.00'),
(3, 3, '1.00'),
(4, 4, '3.00');

-- --------------------------------------------------------

--
-- Table structure for table `str_product_sales`
--

CREATE TABLE `str_product_sales` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `product_price` decimal(11,2) DEFAULT NULL,
  `quantity_discount` int(11) DEFAULT NULL,
  `quantity_discount_price` decimal(11,2) DEFAULT NULL,
  `total` decimal(11,2) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `str_product_sales`
--

INSERT INTO `str_product_sales` (`id`, `product_id`, `quantity`, `product_price`, `quantity_discount`, `quantity_discount_price`, `total`, `date_created`) VALUES
(1, 1, 2, '10.00', 2, '15.00', '15.00', '2019-04-20 13:24:29'),
(2, 2, 3, '5.00', 3, '10.00', '10.00', '2019-04-20 13:24:29'),
(3, 3, 2, '1.00', 0, '0.00', '2.00', '2019-04-20 13:24:29'),
(4, 4, 6, '3.00', 6, '10.00', '10.00', '2019-04-20 13:24:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `str_products`
--
ALTER TABLE `str_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_name` (`product_name`(191)),
  ADD KEY `date_created` (`date_created`);

--
-- Indexes for table `str_products_discounts`
--
ALTER TABLE `str_products_discounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `product_price` (`product_price`);

--
-- Indexes for table `str_products_prices`
--
ALTER TABLE `str_products_prices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `product_price` (`product_price`);

--
-- Indexes for table `str_product_sales`
--
ALTER TABLE `str_product_sales`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `str_products`
--
ALTER TABLE `str_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `str_products_discounts`
--
ALTER TABLE `str_products_discounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `str_products_prices`
--
ALTER TABLE `str_products_prices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `str_product_sales`
--
ALTER TABLE `str_product_sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
