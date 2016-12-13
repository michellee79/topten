-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 25, 2016 at 09:57 AM
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
-- Structure for view `vw_businesses`
--

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vw_businesses`  AS  select `businesses`.`id` AS `id`,`businesses`.`name` AS `name`,`businesses`.`address` AS `address`,`businesses`.`city` AS `city`,`businesses`.`state` AS `state`,`businesses`.`zipcode` AS `zipcode`,`businesses`.`firstName` AS `firstName`,`businesses`.`lastName` AS `lastName`,`businesses`.`email` AS `email`,`businesses`.`phone` AS `phone`,`businesses`.`cellPhone` AS `cellPhone`,`businesses`.`startDate` AS `startDate`,`businesses`.`dateCreated` AS `dateCreated`,`businesses`.`latitude` AS `latitude`,`businesses`.`longitude` AS `longitude`,`businesses`.`isActive` AS `isActive`,`businesses`.`isDeleted` AS `isDeleted`,`businesses`.`profileTopLeft` AS `profileTopLeft`,`businesses`.`profileTopRight` AS `profileTopRight`,`businesses`.`profileBottomLeft` AS `profileBottomLeft`,`businesses`.`summary` AS `summary`,`businesssubcategories`.`id` AS `businesssubcategoryId`,`businesssubcategories`.`parentCategoryId` AS `parentcategoryId`,`businesses`.`logoId` AS `logoId`,`businesscategory`.`ctGroup` AS `ctGroup`,`businesses`.`website` AS `website`,`businesscontracts`.`vip` AS `vip`,`businesscontracts`.`promo` AS `promo`,`businesscontracts`.`lastUpdated` AS `signedDate`,(select avg(`c`.`averageValue`) AS `Expr1` from `coupons` `c` where ((`c`.`businessId` = `businesses`.`id`) and (`c`.`isActive` = 1) and (`c`.`isDeleted` = 0))) AS `averageValue`,(select avg(`r`.`rating`) from `ratings` `r` where ((`r`.`businessId` = `businesses`.`id`) and (`r`.`isDeleted` = 0) and `r`.`isResolved`)) AS `averageRating`,`bsc2`.`id` AS `businesssubcategoryId2`,`bsc2`.`parentCategoryId` AS `parentcategoryId2`,`bc2`.`ctGroup` AS `ctGroup2` from (((((`businesses` left join `businesssubcategories` on((`businesses`.`subCatId` = `businesssubcategories`.`id`))) left join `businesscategory` on((`businesssubcategories`.`parentCategoryId` = `businesscategory`.`id`))) left join `businesscontracts` on((`businesses`.`id` = `businesscontracts`.`businessId`))) left join `businesssubcategories` `bsc2` on((`businesses`.`subCatId2` = `bsc2`.`id`))) left join `businesscategory` `bc2` on((`bsc2`.`parentCategoryId` = `bc2`.`id`))) group by `businesses`.`id` ;

--
-- VIEW  `vw_businesses`
-- Data: None
--


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
