-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Nov 08, 2023 at 07:01 AM
-- Server version: 5.7.39
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `php_inventory_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(19, 'syrup'),
(20, 'base'),
(21, 'tea'),
(22, 'milk');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `category` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` double NOT NULL,
  `description` text NOT NULL,
  `picture` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `category`, `quantity`, `price`, `description`, `picture`) VALUES
(18, 'butterscotch syrup1', 19, 25, 100, '750ml', 'images/products/pic_6548ac2fe3f25.png'),
(19, 'creme brulee syrup', 19, 26, 20, '750ml', 'images/products/pic_6547ad215c75a.png'),
(21, 'chocolate syrup', 19, 16, 25, '650G', 'images/products/pic_6547afd41d700.png'),
(22, 'chocolate powder', 20, 25, 40, '1kg\r\n', 'images/products/pic_6547b029e279e.png'),
(23, 'peach tea', 21, 10, 20, '650ml', 'images/products/pic_6547b16bbfe38.png'),
(24, 'full cream ', 22, 44, 60, '1L', 'images/products/pic_6547b2f685792.png');

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `stock_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `buy_date` date DEFAULT NULL,
  `total_amount` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`stock_id`, `user_id`, `buy_date`, `total_amount`) VALUES
(39, 6, '2023-11-08', 12),
(40, 6, '2023-11-08', 3),
(41, 6, '2023-11-08', 8);

-- --------------------------------------------------------

--
-- Table structure for table `stock_details`
--

CREATE TABLE `stock_details` (
  `detail_id` int(11) NOT NULL,
  `stock_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` double(10,2) DEFAULT NULL,
  `price_x_quantity` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stock_details`
--

INSERT INTO `stock_details` (`detail_id`, `stock_id`, `product_id`, `quantity`, `price`, `price_x_quantity`) VALUES
(39, 39, 18, 2, 2.00, '4.00'),
(40, 39, 19, 2, 2.00, '4.00'),
(41, 39, 21, 2, 2.00, '4.00'),
(42, 40, 18, 1, 1.00, '1.00'),
(43, 40, 19, 1, 1.00, '1.00'),
(44, 40, 21, 1, 1.00, '1.00'),
(45, 41, 18, 2, 4.00, '8.00');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `fullname` varchar(200) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` text NOT NULL,
  `tel` varchar(100) NOT NULL,
  `user_role` varchar(100) NOT NULL,
  `user_image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `fullname`, `email`, `password`, `tel`, `user_role`, `user_image`) VALUES
(6, 'syrf', 'adminuser-adminpass@mail.com', '$2y$10$F.lByujyZ.7LqeVLzosXBeEPlIqsn5krbrOec2g4koSyLxh04qRve', '8822 6699 7733 0511', 'admin', 'images/users/pic_64aecdb2810ba.png'),
(17, 'theuser', 'thenewuser@mail.com', '$2y$10$b1Ntp536uMno9N6F61WNaOUcLchaDJ4yWRt7lcaiYYwwiFc0vB6DW', '158 7896 3578', 'admin', 'images/users/pic_64aec81daf417.png'),
(19, 'Insyi', 'insyrhnbihah@gmail.com', '$2y$10$F.lByujyZ.7LqeVLzosXBeEPlIqsn5krbrOec2g4koSyLxh04qRve', '0169287276', 'staff', 'images/users/pic_652ff1e06ad16.jpeg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`stock_id`),
  ADD KEY `user_id` (`user_id`) USING BTREE;

--
-- Indexes for table `stock_details`
--
ALTER TABLE `stock_details`
  ADD PRIMARY KEY (`detail_id`),
  ADD KEY `sid` (`stock_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `stock_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `stock_details`
--
ALTER TABLE `stock_details`
  MODIFY `detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `stock_details`
--
ALTER TABLE `stock_details`
  ADD CONSTRAINT `sid` FOREIGN KEY (`stock_id`) REFERENCES `stock` (`stock_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
