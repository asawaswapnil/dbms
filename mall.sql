-- phpMyAdmin SQL Dump
-- version 4.4.15.9
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 03, 2018 at 05:18 AM
-- Server version: 5.6.37
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mall`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `check_productwise_profit`(IN `start_date` DATE, IN `end_date` DATE)
Select cost.Product_id, Product_name, costp as average_cost_price,round(avg_selling_price,2), quant as quantity_sold_between_given_date, round((avg_selling_price- costp)*quant,2) as product_total_profit from (Select avg(price) as costp, Product_id as Product_id from Supply group by Product_id) as cost, (Select pi.product_id as pid, p.Price, p.Product_name as Product_name, count(pi.discount) as quant, avg(pi.discount) as disc, p.Price*avg(pi.discount) as avg_selling_price from Product p, pro_invoice pi, invoice as i where pi.product_id=p.Product_id and i.Invoice_id =pi.invoice_id and i.date >start_date and i.date< end_date Group by p.product_id) as sell Where cost.Product_id=sell.pid order by product_total_profit desc$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `check_total_profit`(IN `start_date` DATE, IN `end_date` DATE)
Select round(sum((avg_selling_price- costp)*quant),2) as total_profit from (Select avg(price) as costp, Product_id as Product_id from Supply group by Product_id) as cost, (Select pi.product_id as pid, p.Price, count(pi.discount) as quant, avg(pi.discount) as disc, p.Price*avg(pi.discount) as avg_selling_price from Product p, pro_invoice pi, invoice as i where pi.product_id=p.Product_id and i.Invoice_id =pi.invoice_id and i.date >start_date and i.date< end_date Group by p.product_id) as sell Where cost.Product_id=sell.pid$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `hottest`(IN start date, IN end date)
select p.product_name,count(pi.product_number) as count from product p join pro_invoice pi on pi.product_id=p.product_id join invoice i on i.Invoice_id=pi.invoice_id  where i.date between start and end group by p.product_id order by count(pi.product_number) Desc limit 5$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `restock`()
select pi.product_id,ceil(sum(pi.product_number)/12) as safety_stock,p.inventory from pro_invoice pi join invoice i on pi.invoice_id=i.Invoice_id join product p on p.product_id=pi.product_id where pi.invoice_id not in (SELECT i.Invoice_id from pro_invoice pi join invoice i on pi.invoice_id=i.Invoice_id where DATE_FORMAT(date_sub(now(), interval 12 month),'%Y-%m')>DATE_FORMAT(i.date,'%Y-%m') order by i.date asc) group by pi.product_id having ceil(sum(pi.product_number)/12)>p.inventory$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `Customer_id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `birthday` date DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`Customer_id`, `name`, `gender`, `birthday`, `email`) VALUES
(1, 'Graggi', 'male', '1985-09-04', 'dafafa@id.com\r'),
(2, 'Abhi', 'male', '1980-09-08', 'daf321afa@id.com\r'),
(3, 'Sic', 'male', '1984-08-07', 'dafa2312fa@id.com\r'),
(4, 'Ron', 'male', '1961-10-29', 'daf121afa@id.com\r'),
(5, 'Sia', 'male', '1978-09-06', 'dafa332fa@id.com\r'),
(6, 'Paul', 'female', '1970-09-09', 'dafa111fa@id.com\r'),
(7, 'Xi', 'female', '1997-02-09', 'dafaf32131a@id.com\r'),
(8, 'Hu', 'female', '1966-02-26', 'dafa231231fa@id.com\r'),
(9, 'Swap', 'female', '1976-08-04', 'dafa333fa@id.com\r'),
(10, 'Goku', 'female', '1996-02-11', 'daf11111afa@id.com\r');

-- --------------------------------------------------------

--
-- Table structure for table `Department`
--

CREATE TABLE IF NOT EXISTS `Department` (
  `id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Department`
--

INSERT INTO `Department` (`id`, `name`) VALUES
(5, 'Books'),
(2, 'Clothes'),
(4, 'Electronics'),
(1, 'Groceries'),
(3, 'Healthcare');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE IF NOT EXISTS `invoice` (
  `Invoice_id` int(10) NOT NULL,
  `Customer_id` int(10) NOT NULL,
  `Total_value` float NOT NULL,
  `salesman_id` int(10) NOT NULL,
  `date` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=128 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`Invoice_id`, `Customer_id`, `Total_value`, `salesman_id`, `date`) VALUES
(1, 4, 1594.39, 1, '2018-05-15 00:00:00'),
(2, 10, 132.5, 3, '2018-08-04 00:00:00'),
(3, 5, 1788.77, 2, '2018-12-02 00:00:00'),
(4, 2, 3362.87, 2, '2018-07-23 00:00:00'),
(5, 7, 2531.28, 5, '2018-05-31 00:00:00'),
(6, 10, 3477.78, 4, '2018-11-15 00:00:00'),
(7, 2, 1054.98, 4, '2018-04-29 00:00:00'),
(8, 5, 1593.18, 1, '2018-10-27 00:00:00'),
(9, 10, 3058.87, 3, '2018-08-07 00:00:00'),
(10, 7, 16.49, 5, '2018-06-20 00:00:00'),
(11, 3, 384, 6, '2018-02-09 00:00:00'),
(12, 7, 1920, 6, '2018-01-12 00:00:00'),
(13, 10, 16, 4, '2018-03-29 00:00:00'),
(14, 9, 16.49, 2, '2018-08-14 00:00:00'),
(15, 3, 9.5, 4, '2018-05-18 00:00:00'),
(16, 10, 16.32, 3, '2018-09-11 00:00:00'),
(17, 10, 15.81, 4, '2018-09-03 00:00:00'),
(18, 5, 9.9, 3, '2018-11-22 00:00:00'),
(19, 3, 576, 6, '2018-06-18 00:00:00'),
(20, 10, 9.8, 3, '2018-03-04 00:00:00'),
(21, 8, 11.04, 4, '2018-07-03 00:00:00'),
(22, 9, 14.25, 4, '2018-11-09 00:00:00'),
(23, 7, 15.3, 2, '2018-03-05 00:00:00'),
(24, 3, 11.28, 1, '2018-06-13 00:00:00'),
(25, 4, 15.52, 5, '2018-02-03 00:00:00'),
(26, 8, 11.83, 6, '2018-04-27 00:00:00'),
(27, 4, 12.88, 4, '2018-02-11 00:00:00'),
(28, 3, 13.72, 2, '2018-04-23 00:00:00'),
(29, 8, 12.35, 5, '2018-09-04 00:00:00'),
(30, 8, 16.15, 5, '2018-01-12 00:00:00'),
(31, 1, 1860, 1, '2018-04-19 00:00:00'),
(32, 2, 14.56, 5, '2018-06-12 00:00:00'),
(33, 8, 12.09, 4, '2018-01-21 00:00:00'),
(34, 5, 1980, 2, '2018-07-12 00:00:00'),
(35, 6, 14.4, 5, '2018-09-28 00:00:00'),
(36, 2, 900, 3, '2018-07-05 00:00:00'),
(37, 10, 14.55, 5, '2018-10-24 00:00:00'),
(38, 6, 564, 1, '2018-03-31 00:00:00'),
(39, 5, 376, 2, '2018-08-28 00:00:00'),
(40, 1, 16.49, 3, '2018-09-13 00:00:00'),
(41, 2, 10.8, 3, '2018-05-31 00:00:00'),
(42, 8, 17, 1, '2018-02-01 00:00:00'),
(43, 6, 16, 6, '2018-08-12 00:00:00'),
(44, 8, 15.52, 4, '2018-10-02 00:00:00'),
(45, 10, 930, 4, '2018-09-06 00:00:00'),
(46, 9, 14.55, 4, '2018-09-19 00:00:00'),
(47, 10, 396, 3, '2018-05-08 00:00:00'),
(48, 1, 15.98, 2, '2018-07-08 00:00:00'),
(49, 5, 558, 3, '2018-11-24 00:00:00'),
(50, 10, 15.81, 3, '2018-05-28 00:00:00'),
(51, 3, 396, 1, '2018-11-28 00:00:00'),
(52, 7, 11.04, 4, '2018-08-01 00:00:00'),
(53, 5, 360, 2, '2018-05-03 00:00:00'),
(54, 3, 9.7, 6, '2018-04-15 00:00:00'),
(55, 7, 400, 3, '2018-07-27 00:00:00'),
(56, 10, 14, 4, '2018-05-03 00:00:00'),
(57, 5, 13.16, 6, '2018-05-01 00:00:00'),
(58, 9, 540, 2, '2018-02-09 00:00:00'),
(59, 8, 17, 5, '2018-10-12 00:00:00'),
(60, 10, 11.64, 5, '2018-01-15 00:00:00'),
(61, 10, 9.8, 6, '2018-06-29 00:00:00'),
(62, 3, 16, 4, '2018-07-28 00:00:00'),
(63, 10, 15.04, 3, '2018-06-25 00:00:00'),
(64, 2, 10, 1, '2018-04-15 00:00:00'),
(65, 4, 15.81, 5, '2018-01-30 00:00:00'),
(66, 2, 368, 4, '2018-06-29 00:00:00'),
(67, 5, 15.64, 6, '2018-04-05 00:00:00'),
(68, 4, 14.4, 6, '2018-01-11 00:00:00'),
(69, 1, 13, 2, '2018-09-28 00:00:00'),
(70, 9, 9.7, 6, '2018-09-17 00:00:00'),
(71, 5, 910, 6, '2018-05-03 00:00:00'),
(72, 6, 970, 4, '2018-03-14 00:00:00'),
(73, 10, 9, 5, '2018-04-03 00:00:00'),
(74, 8, 15.36, 4, '2018-09-01 00:00:00'),
(75, 2, 9.6, 5, '2018-08-31 00:00:00'),
(76, 10, 15.04, 5, '2018-06-07 00:00:00'),
(77, 6, 11.96, 5, '2018-10-01 00:00:00'),
(78, 8, 14.4, 3, '2018-02-10 00:00:00'),
(79, 8, 13.5, 3, '2018-03-22 00:00:00'),
(80, 8, 1800, 6, '2018-01-07 00:00:00'),
(81, 8, 14.56, 6, '2018-06-12 00:00:00'),
(82, 4, 372, 2, '2018-03-12 00:00:00'),
(83, 1, 11.52, 4, '2018-10-02 00:00:00'),
(84, 8, 16.66, 1, '2018-08-31 00:00:00'),
(85, 6, 14.1, 2, '2018-01-21 00:00:00'),
(86, 10, 594, 6, '2018-07-04 00:00:00'),
(87, 10, 16.83, 4, '2018-03-10 00:00:00'),
(88, 1, 16, 5, '2018-11-30 00:00:00'),
(89, 4, 1920, 6, '2018-01-16 00:00:00'),
(90, 6, 980, 4, '2018-04-14 00:00:00'),
(91, 8, 16.66, 5, '2018-06-18 00:00:00'),
(92, 4, 15.52, 4, '2018-06-12 00:00:00'),
(93, 10, 594, 4, '2018-03-07 00:00:00'),
(94, 4, 14.72, 2, '2018-02-04 00:00:00'),
(95, 7, 1960, 2, '2018-09-14 00:00:00'),
(96, 5, 1860, 5, '2018-07-11 00:00:00'),
(97, 7, 368, 1, '2018-05-01 00:00:00'),
(98, 8, 13.5, 2, '2018-11-01 00:00:00'),
(99, 6, 16.15, 4, '2018-08-27 00:00:00'),
(100, 8, 15.84, 6, '2018-11-14 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `Product`
--

CREATE TABLE IF NOT EXISTS `Product` (
  `Product_id` int(10) NOT NULL,
  `Product_name` varchar(50) NOT NULL,
  `Inventory` int(10) unsigned NOT NULL,
  `Price` int(10) unsigned NOT NULL,
  `Brand` varchar(50) NOT NULL,
  `Department_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Product`
--

INSERT INTO `Product` (`Product_id`, `Product_name`, `Inventory`, `Price`, `Brand`, `Department_id`) VALUES
(1, 'Honey', 4, 17, 'BigB', 1),
(2, 'Potatos', 5, 13, 'BigB', 1),
(3, 'Honey', 6, 15, 'BigB', 1),
(4, 'Cheetos', 7, 16, 'BigB', 1),
(5, 'Tomato', 8, 17, 'BigC', 1),
(6, 'Milk', 8, 16, 'BigC', 1),
(7, 'bread', 4, 15, 'BigC', 1),
(8, 'butter', 6, 10, 'BigC', 1),
(9, 'dressredblue', 4, 16, 'Zara', 2),
(10, 'tiegreen', 5, 10, 'Zara', 2),
(11, 'crocin', 6, 14, 'medcure', 3),
(12, 'kefpod', 7, 12, 'medcure', 3),
(13, 'macbook', 8, 1000, 'mac', 4),
(14, 'macbookpro', 8, 2000, ' mac', 4),
(15, 'history9th', 4, 400, 'ncert', 5),
(16, 'geo10th', 6, 600, 'ncert', 5),
(17, 'Ultimate Snack Package', 500, 3, 'Frito lay', 1),
(18, 'Dijonnaise Cream Mustard', 200, 19, 'Best Food', 1),
(19, 'Holiday Fruit and Nuts', 300, 28, 'Five Star Gift Baskets', 1),
(20, 'Snacks and Treats Variety Pack', 400, 25, 'Mondelez', 1),
(21, 'Inglehoffer Mustard', 200, 12, 'Inglehoffer', 1),
(22, 'Men''s Ultraboost', 20, 162, 'Addidas', 2),
(23, 'Wemen''s low heel', 50, 21, 'Daily Shoes', 2),
(24, 'Men''s Mx623v3 Training Shoe', 30, 135, 'New Balance', 2),
(25, 'Air Max 2017 Women''s Running Sneaker', 30, 131, 'NIKE', 2),
(26, 'Women''s Gella Dress Pump', 30, 125, 'Calvin Klein', 2),
(27, 'Men''s Long Sleeve Moisture Wicking Athletic Sport ', 100, 16, 'Clothe Co', 2),
(28, 'Men''s Cooling Performance Crew Long Sleeve Tee', 200, 20, 'A4', 2),
(29, 'Men''s Cooling Performance Crew Short Sleeve Tee', 200, 16, 'A4', 2),
(30, 'Yoga Tops Activewear Workout Clothes', 200, 20, 'icyzone', 2),
(31, 'Women''s Contrast-Sleeve Cotton Sweater', 150, 40, 'Cable Stitch', 2),
(32, 'Samsung Galaxy S9', 200, 450, 'Samsung', 4),
(33, 'Samsung Galaxy S9+ Plus', 150, 643, 'Samsung', 4),
(34, 'iPhone 8 64GB', 200, 579, 'Apple', 4),
(35, 'Apple iPhone 8 PLUS 64GB', 150, 679, 'Apple', 4),
(36, 'Samsung Galaxy Note 9 128GB', 150, 710, 'Samsung', 4);

-- --------------------------------------------------------

--
-- Table structure for table `pro_invoice`
--

CREATE TABLE IF NOT EXISTS `pro_invoice` (
  `id` int(10) NOT NULL,
  `invoice_id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  `Product_number` int(10) unsigned NOT NULL,
  `Discount` float NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=182 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pro_invoice`
--

INSERT INTO `pro_invoice` (`id`, `invoice_id`, `product_id`, `Product_number`, `Discount`) VALUES
(1, 1, 1, 3, 0.99),
(2, 1, 7, 2, 0.96),
(3, 1, 12, 1, 0.96),
(4, 1, 16, 1, 0.97),
(5, 1, 4, 2, 0.96),
(6, 1, 10, 3, 0.99),
(7, 1, 13, 3, 0.91),
(8, 1, 10, 2, 0.94),
(9, 1, 4, 1, 0.98),
(10, 1, 8, 2, 0.93),
(11, 2, 8, 2, 0.95),
(12, 2, 3, 1, 1),
(13, 2, 1, 1, 0.92),
(14, 2, 4, 1, 0.9),
(15, 2, 9, 1, 0.98),
(16, 2, 2, 1, 0.96),
(17, 2, 8, 1, 0.93),
(18, 2, 2, 3, 0.92),
(19, 2, 3, 2, 0.9),
(20, 2, 9, 2, 0.94),
(21, 3, 1, 2, 0.92),
(22, 3, 12, 1, 0.99),
(23, 3, 16, 1, 0.94),
(24, 3, 8, 3, 0.99),
(25, 3, 3, 2, 0.93),
(26, 3, 5, 3, 0.9),
(27, 3, 16, 1, 0.98),
(28, 3, 7, 3, 1),
(29, 3, 8, 2, 0.91),
(30, 3, 16, 1, 0.91),
(31, 4, 3, 3, 0.94),
(32, 4, 15, 3, 0.96),
(33, 4, 8, 2, 0.95),
(34, 4, 5, 3, 0.98),
(35, 4, 5, 2, 0.98),
(36, 4, 12, 3, 0.9),
(37, 4, 13, 3, 0.91),
(38, 4, 3, 2, 0.9),
(39, 4, 12, 3, 0.93),
(40, 4, 1, 3, 0.97),
(41, 4, 14, 3, 0.98),
(42, 5, 4, 3, 0.95),
(43, 5, 11, 2, 0.94),
(44, 5, 15, 3, 0.94),
(45, 5, 1, 2, 0.9),
(46, 5, 13, 3, 0.97),
(47, 5, 16, 3, 0.91),
(48, 5, 16, 2, 0.95),
(49, 5, 11, 1, 0.93),
(50, 5, 11, 1, 0.9),
(51, 6, 11, 1, 0.96),
(52, 6, 14, 3, 0.94),
(53, 6, 8, 3, 0.98),
(54, 6, 5, 3, 0.92),
(55, 6, 10, 3, 0.96),
(56, 6, 7, 3, 0.9),
(57, 6, 12, 1, 0.95),
(58, 6, 4, 2, 0.9),
(59, 6, 13, 2, 0.97),
(60, 6, 16, 1, 0.9),
(61, 7, 8, 2, 0.91),
(62, 7, 8, 2, 0.95),
(63, 7, 8, 2, 0.93),
(64, 7, 1, 2, 1),
(65, 7, 13, 3, 0.93),
(66, 7, 9, 2, 1),
(67, 7, 1, 1, 1),
(68, 7, 6, 3, 0.98),
(69, 7, 1, 2, 1),
(70, 7, 6, 2, 0.9),
(71, 8, 6, 1, 0.97),
(72, 8, 12, 1, 0.94),
(73, 8, 8, 3, 0.99),
(74, 8, 4, 1, 0.92),
(75, 8, 13, 2, 0.9),
(76, 8, 16, 1, 0.98),
(77, 8, 6, 2, 0.94),
(78, 8, 11, 1, 0.99),
(79, 8, 6, 3, 0.96),
(80, 8, 8, 1, 0.95),
(81, 9, 4, 2, 0.94),
(82, 9, 3, 1, 0.9),
(83, 9, 13, 1, 0.94),
(84, 9, 9, 2, 0.99),
(85, 9, 14, 2, 1),
(86, 9, 1, 3, 0.99),
(87, 9, 7, 1, 1),
(88, 9, 6, 3, 0.97),
(89, 9, 7, 3, 0.96),
(90, 9, 11, 2, 0.91),
(91, 10, 1, 2, 0.97),
(92, 11, 15, 7, 0.96),
(93, 12, 14, 6, 0.96),
(94, 13, 6, 6, 1),
(95, 14, 1, 3, 0.97),
(96, 15, 10, 6, 0.95),
(97, 16, 1, 5, 0.96),
(98, 17, 1, 4, 0.93),
(99, 18, 8, 4, 0.99),
(100, 19, 16, 6, 0.96),
(101, 20, 8, 3, 0.98),
(102, 21, 12, 6, 0.92),
(103, 22, 7, 5, 0.95),
(104, 23, 5, 7, 0.9),
(105, 24, 12, 5, 0.94),
(106, 25, 4, 5, 0.97),
(107, 26, 2, 7, 0.91),
(108, 27, 11, 6, 0.92),
(109, 28, 11, 4, 0.98),
(110, 29, 2, 3, 0.95),
(111, 30, 1, 2, 0.95),
(112, 31, 14, 5, 0.93),
(113, 32, 9, 2, 0.91),
(114, 33, 2, 8, 0.93),
(115, 34, 14, 8, 0.99),
(116, 35, 7, 6, 0.96),
(117, 36, 13, 3, 0.9),
(118, 37, 3, 4, 0.97),
(119, 38, 16, 5, 0.94),
(120, 39, 15, 4, 0.94),
(121, 40, 5, 5, 0.97),
(122, 41, 12, 6, 0.9),
(123, 42, 5, 8, 1),
(124, 43, 4, 5, 1),
(125, 44, 9, 8, 0.97),
(126, 45, 13, 7, 0.93),
(127, 46, 3, 5, 0.97),
(128, 47, 15, 5, 0.99),
(129, 48, 5, 7, 0.94),
(130, 49, 16, 7, 0.93),
(131, 50, 5, 8, 0.93),
(132, 51, 15, 7, 0.99),
(133, 52, 12, 4, 0.92),
(134, 53, 15, 8, 0.9),
(135, 54, 8, 3, 0.97),
(136, 55, 15, 8, 1),
(137, 56, 11, 8, 1),
(138, 57, 11, 7, 0.94),
(139, 58, 16, 8, 0.9),
(140, 59, 5, 5, 1),
(141, 60, 12, 6, 0.97),
(142, 61, 10, 5, 0.98),
(143, 62, 9, 4, 1),
(144, 63, 4, 2, 0.94),
(145, 64, 10, 7, 1),
(146, 65, 5, 2, 0.93),
(147, 66, 15, 5, 0.92),
(148, 67, 5, 6, 0.92),
(149, 68, 6, 4, 0.9),
(150, 69, 2, 2, 1),
(151, 70, 8, 6, 0.97),
(152, 71, 13, 5, 0.91),
(153, 72, 13, 7, 0.97),
(154, 73, 8, 6, 0.9),
(155, 74, 9, 3, 0.96),
(156, 75, 8, 8, 0.96),
(157, 76, 6, 7, 0.94),
(158, 77, 2, 2, 0.92),
(159, 78, 4, 5, 0.9),
(160, 79, 3, 4, 0.9),
(161, 80, 14, 2, 0.9),
(162, 81, 6, 5, 0.91),
(163, 82, 15, 7, 0.93),
(164, 83, 12, 2, 0.96),
(165, 84, 1, 5, 0.98),
(166, 85, 3, 2, 0.94),
(167, 86, 16, 5, 0.99),
(168, 87, 1, 8, 0.99),
(169, 88, 9, 4, 1),
(170, 89, 14, 7, 0.96),
(171, 90, 13, 3, 0.98),
(172, 91, 1, 5, 0.98),
(173, 92, 9, 7, 0.97),
(174, 93, 16, 2, 0.99),
(175, 94, 6, 3, 0.92),
(176, 95, 14, 8, 0.98),
(177, 96, 14, 3, 0.93),
(178, 97, 15, 2, 0.92),
(179, 98, 7, 2, 0.9),
(180, 99, 5, 8, 0.95),
(181, 100, 4, 4, 0.99);

-- --------------------------------------------------------

--
-- Table structure for table `Salesman`
--

CREATE TABLE IF NOT EXISTS `Salesman` (
  `id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `department_id` int(10) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `birthday` date NOT NULL,
  `start_working_date` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Salesman`
--

INSERT INTO `Salesman` (`id`, `name`, `department_id`, `gender`, `birthday`, `start_working_date`) VALUES
(1, 'Sam', 1, 'M', '1985-09-04', '2000-02-01'),
(2, 'Edin', 2, 'M', '1980-09-08', '2000-03-01'),
(3, 'Gory', 3, 'F', '1984-08-07', '2000-04-01'),
(4, 'Prince', 4, 'M', '2061-10-29', '2000-05-01'),
(5, 'Shal', 5, 'F', '1978-09-06', '2000-01-01'),
(6, 'Samu', 1, 'M', '1970-09-09', '2000-01-01');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE IF NOT EXISTS `supplier` (
  `id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`, `name`) VALUES
(1, 'Sup1'),
(2, 'Sup2 '),
(3, 'Sup3');

-- --------------------------------------------------------

--
-- Table structure for table `Supply`
--

CREATE TABLE IF NOT EXISTS `Supply` (
  `Supply_id` int(10) NOT NULL,
  `Supplier_id` int(10) NOT NULL,
  `Product_id` int(10) NOT NULL,
  `Sup_amount` int(10) NOT NULL,
  `Price` int(10) NOT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Supply`
--

INSERT INTO `Supply` (`Supply_id`, `Supplier_id`, `Product_id`, `Sup_amount`, `Price`, `date`) VALUES
(3, 1, 25, 134, 91, '2016-04-05'),
(4, 1, 30, 177, 14, '2017-01-03'),
(5, 1, 5, 153, 12, '2016-04-05'),
(6, 1, 7, 155, 11, '2017-01-03'),
(7, 1, 7, 178, 11, '2016-04-05'),
(8, 2, 3, 111, 11, '2017-01-03'),
(9, 3, 8, 196, 7, '2017-01-03'),
(10, 3, 2, 160, 9, '2016-04-05'),
(11, 3, 32, 102, 315, '2018-01-01'),
(12, 2, 2, 126, 9, '2017-01-03'),
(13, 1, 17, 147, 2, '2016-04-05'),
(14, 2, 14, 166, 1400, '2017-01-03'),
(15, 3, 19, 108, 20, '2016-04-05'),
(16, 2, 33, 116, 450, '2018-01-01'),
(17, 2, 5, 143, 12, '2016-04-05'),
(18, 1, 34, 170, 405, '2017-01-03'),
(19, 3, 12, 175, 8, '2017-01-03'),
(20, 1, 4, 155, 11, '2016-04-05'),
(21, 1, 17, 182, 2, '2016-04-05'),
(22, 1, 26, 162, 87, '2018-01-01'),
(23, 1, 1, 194, 12, '2018-01-01'),
(24, 3, 26, 182, 87, '2017-01-03'),
(25, 2, 3, 108, 11, '2016-04-05'),
(26, 2, 35, 112, 475, '2017-01-03'),
(27, 1, 1, 126, 12, '2016-04-05'),
(28, 2, 27, 174, 11, '2017-01-03'),
(29, 1, 3, 111, 11, '2018-01-01'),
(30, 1, 2, 117, 9, '2017-01-03'),
(31, 3, 6, 172, 11, '2016-04-05'),
(32, 3, 1, 174, 12, '2018-01-01'),
(33, 1, 23, 139, 15, '2018-01-01'),
(34, 2, 10, 172, 7, '2016-04-05'),
(35, 2, 32, 185, 315, '2018-01-01'),
(36, 2, 2, 140, 9, '2018-04-05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`Customer_id`);

--
-- Indexes for table `Department`
--
ALTER TABLE `Department`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`Invoice_id`),
  ADD KEY `cus_id_fk` (`Customer_id`),
  ADD KEY `sals_id_fk` (`salesman_id`);

--
-- Indexes for table `Product`
--
ALTER TABLE `Product`
  ADD PRIMARY KEY (`Product_id`),
  ADD KEY `Department_id_fk` (`Department_id`);

--
-- Indexes for table `pro_invoice`
--
ALTER TABLE `pro_invoice`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_id_fk1` (`invoice_id`),
  ADD KEY `Product_id_fk1` (`product_id`);

--
-- Indexes for table `Salesman`
--
ALTER TABLE `Salesman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `de_id_fk` (`department_id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Supply`
--
ALTER TABLE `Supply`
  ADD PRIMARY KEY (`Supply_id`),
  ADD KEY `Supplier_id_fk` (`Supplier_id`),
  ADD KEY `Product_id_fk` (`Product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `Customer_id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `Department`
--
ALTER TABLE `Department`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `Invoice_id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=128;
--
-- AUTO_INCREMENT for table `Product`
--
ALTER TABLE `Product`
  MODIFY `Product_id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT for table `pro_invoice`
--
ALTER TABLE `pro_invoice`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=182;
--
-- AUTO_INCREMENT for table `Salesman`
--
ALTER TABLE `Salesman`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `Supply`
--
ALTER TABLE `Supply`
  MODIFY `Supply_id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=66;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `cus_id_fk` FOREIGN KEY (`Customer_id`) REFERENCES `Customer` (`Customer_id`),
  ADD CONSTRAINT `sals_id_fk` FOREIGN KEY (`salesman_id`) REFERENCES `Salesman` (`id`);

--
-- Constraints for table `Product`
--
ALTER TABLE `Product`
  ADD CONSTRAINT `Department_id_fk` FOREIGN KEY (`Department_id`) REFERENCES `Department` (`id`);

--
-- Constraints for table `pro_invoice`
--
ALTER TABLE `pro_invoice`
  ADD CONSTRAINT `Product_id_fk1` FOREIGN KEY (`product_id`) REFERENCES `Product` (`Product_id`),
  ADD CONSTRAINT `invoice_id_fk` FOREIGN KEY (`invoice_id`) REFERENCES `Invoice` (`Invoice_id`),
  ADD CONSTRAINT `invoice_id_fk1` FOREIGN KEY (`invoice_id`) REFERENCES `Invoice` (`Invoice_id`);

--
-- Constraints for table `Salesman`
--
ALTER TABLE `Salesman`
  ADD CONSTRAINT `de_id_fk` FOREIGN KEY (`department_id`) REFERENCES `Department` (`id`);

--
-- Constraints for table `Supply`
--
ALTER TABLE `Supply`
  ADD CONSTRAINT `Product_id_fk` FOREIGN KEY (`Product_id`) REFERENCES `Product` (`Product_id`),
  ADD CONSTRAINT `Supplier_id_fk` FOREIGN KEY (`Supplier_id`) REFERENCES `supplier` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
