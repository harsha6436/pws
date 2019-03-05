-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 05, 2019 at 02:36 PM
-- Server version: 10.1.35-MariaDB
-- PHP Version: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `basic`
--

-- --------------------------------------------------------

--
-- Structure for view `userinfo`
--

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `userinfo`  AS  select `u`.`id` AS `id`,`u`.`first_name` AS `first_name`,`u`.`last_name` AS `last_name`,`ua`.`payable_salary` AS `payable_salary`,`ua`.`basic_salary` AS `basic_salary`,`ua`.`tax_value` AS `tax_value`,`d`.`last_month_deduction` AS `last_month_deduction`,`d`.`name` AS `department_name`,`ut`.`name` AS `employee_type_name` from (((`user_accounts` `ua` join `user` `u` on((`u`.`id` = `ua`.`user_id`))) join `departments` `d` on((`d`.`id` = `u`.`department_id`))) join `user_types` `ut` on((`ut`.`id` = `u`.`user_type_id`))) ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
