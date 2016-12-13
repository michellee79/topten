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
-- Structure for view `vw_promos`
--

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vw_promos`  AS  select `promos`.`id` AS `id`,`promos`.`code` AS `code`,`promos`.`created` AS `created`,`promos`.`assignedTo` AS `assignedTo`,`promos`.`isActive` AS `isActive`,`promos`.`requireActivation` AS `requireActivation`,`promos`.`isDeleted` AS `isDeleted`,(select count(`users`.`id`) AS `total` from `users` where ((`users`.`promoCode` = `promos`.`code`) and (`users`.`isDeleted` = 0))) AS `totalSignedUp`,(select count(`Users_1`.`id`) AS `total` from `users` `Users_1` where ((`Users_1`.`promoCode` = `promos`.`code`) and (`Users_1`.`isActivated` = 1) and (`Users_1`.`isDeleted` = 0))) AS `totalActivated` from `promos` ;

--
-- VIEW  `vw_promos`
-- Data: None
--


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
