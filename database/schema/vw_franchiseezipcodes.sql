-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 25, 2016 at 10:01 AM
-- Server version: 5.5.52-cll
-- PHP Version: 5.5.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ttpco_toptenpercent_test`
--

-- --------------------------------------------------------

--
-- Structure for view `vw_franchiseezipcodes`
--

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vw_franchiseezipcodes`  AS  select `zipcodes`.`zipcode` AS `zipcode`,`franchisees`.`name` AS `name`,`franchisees`.`code` AS `code` from ((`franchisees` join `franchiseezipcodes` on((`franchisees`.`id` = `franchiseezipcodes`.`franchiseeId`))) join `zipcodes` on((`franchiseezipcodes`.`zipcodeId` = `zipcodes`.`id`))) ;

--
-- VIEW  `vw_franchiseezipcodes`
-- Data: None
--


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
