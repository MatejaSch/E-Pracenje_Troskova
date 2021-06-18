-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 13, 2021 at 03:10 PM
-- Server version: 5.7.31
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e_pracenje_troskova`
--

DELIMITER $$
--
-- Procedures
--
DROP PROCEDURE IF EXISTS `addCost`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `addCost` (IN `household_id` INT(11), IN `user_id` INT(11), IN `cost_category_id` INT(11), IN `name` VARCHAR(50), IN `price` FLOAT, IN `description` VARCHAR(255), IN `creating_date` DATE)  BEGIN 
	DECLARE message varchar(40) DEFAULT "";
   	DECLARE access tinyint(1);
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
    	BEGIN
    		SET message = "Error";
    		ROLLBACK;
   	END;
	DECLARE EXIT HANDLER FOR NOT FOUND
    	BEGIN
    		SET message = "Error 2";
    		ROLLBACK;
   	END;
   	 START TRANSACTION;
    	SET access = (SELECT access FROM  households where households.id_household = household_id);
    	IF access = 0 THEN
		SET message = "Access denied";
    		ROLLBACK;
   	END IF;
    	INSERT INTO cost(id_household, id_user, id_cost_category, cost_name, cost_price, cost_description, cost_creating_date) VALUES (household_id, user_id, cost_category_id, name, price, description, creating_date);
    	SET message = "Succesfully inserted new cost";
        SELECT message;
    COMMIT;
END$$

DROP PROCEDURE IF EXISTS `getAllCategoriesOfHousehold`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getAllCategoriesOfHousehold` (IN `household_id` INT(11))  BEGIN
	SELECT cost_category_name from cost_categories WHERE id_household=household_id;
END$$

--
-- Functions
--
DROP FUNCTION IF EXISTS `getTopSpentCategory`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `getTopSpentCategory` (`household_id` INT(11)) RETURNS VARCHAR(100) CHARSET utf8 BEGIN
	DECLARE topSpent varchar(100) DEFAULT "";
	DECLARE topSpentCat varchar(40) DEFAULT "";
    DECLARE topSpentMoney varchar(40) DEFAULT "";
    
    SET topSpentCat = (SELECT cost_category_name
	FROM cost INNER JOIN cost_categories on cost.id_cost_category = cost_categories.id_cost_category
	WHERE cost.id_household = household_id
	GROUP BY cost.id_cost_category
	ORDER BY SUM(cost_price) DESC limit 1);
    
    SET topSpentMoney = (SELECT SUM(cost_price) as suma
	FROM cost INNER JOIN cost_categories on cost.id_cost_category = cost_categories.id_cost_category
	WHERE cost.id_household = household_id
	GROUP BY cost.id_cost_category
	ORDER BY suma DESC limit 1);
    
    SET topSpent = CONCAT(topSpentCat,": ",topSpentMoney);
    RETURN topSpent;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `cost`
--

DROP TABLE IF EXISTS `cost`;
CREATE TABLE IF NOT EXISTS `cost` (
  `id_cost` int(11) NOT NULL AUTO_INCREMENT,
  `id_household` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_cost_category` int(11) NOT NULL,
  `cost_name` varchar(50) NOT NULL,
  `cost_price` float NOT NULL,
  `cost_description` varchar(255) DEFAULT NULL,
  `cost_creating_date` date NOT NULL,
  PRIMARY KEY (`id_cost`),
  KEY `id_household` (`id_household`),
  KEY `id_user` (`id_user`),
  KEY `id_cost_category` (`id_cost_category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cost_categories`
--

DROP TABLE IF EXISTS `cost_categories`;
CREATE TABLE IF NOT EXISTS `cost_categories` (
  `id_cost_category` int(11) NOT NULL AUTO_INCREMENT,
  `id_household` int(11) NOT NULL,
  `cost_category_name` varchar(40) NOT NULL,
  PRIMARY KEY (`id_cost_category`),
  KEY `cost_categories_fk` (`id_household`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cost_categories`
--

INSERT INTO `cost_categories` (`id_cost_category`, `id_household`, `cost_category_name`) VALUES
(5, 26, 'Tehnika'),
(6, 26, 'Letovanje'),
(7, 27, 'Letovanje');

-- --------------------------------------------------------

--
-- Table structure for table `deleted_users`
--

DROP TABLE IF EXISTS `deleted_users`;
CREATE TABLE IF NOT EXISTS `deleted_users` (
  `id` int(11) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `name` varchar(30) DEFAULT NULL,
  `lastname` varchar(30) DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `deleted_users`
--

INSERT INTO `deleted_users` (`id`, `email`, `name`, `lastname`, `is_admin`) VALUES
(1, 'marko@gmail.com', 'Marko', 'Markovic', 0),
(2, 'zvonimir.rudinski@noubis.com', 'Zvonimir', 'Rudinski', 0),
(8, 'mijatdrcic2000@gmail.com', 'Mijat', 'Drcic', 0),
(9, 'mateja.s2000@gmail.com', 'Mateja', 'Sefcic', 0),
(33, 'mateja.sefcic@gmail.com', 'Mateja', 'Sefcic', 0),
(34, 'mateja.s2000@gmail.com', 'Mateja', 'Sefcic', 0),
(35, 'mijatdrcic@gmail.com', 'Mijat', 'Drcic', 1),
(36, 'mateja.s2000@gmail.com', 'Mateja', 'Sefcic', 0),
(37, 'mateja.sefcic@gmail.com', 'Mateja', 'Sefcic', 0),
(38, 'mateja.s2000@gmail.com', 'Mateja', 'Sefcic', 0),
(39, 'mateja.s2000@gmail.com', 'Mateja', 'Sefcic', 0),
(40, 'mateja.s2000@gmail.com', 'Mateja', 'Sefcic', 0),
(41, 'mateja.s2000@gmail.com', 'Mateja', 'Sefcic', 0),
(42, 'mateja.sefcic@gmail.com', 'Mateja', 'Sefcic', 0),
(43, 'mateja.s2000@gmail.com', 'Mateja', 'Sefcic', 0),
(44, 'mateja.s2000@gmail.com', 'Mateja', 'Sefcic', 0),
(45, 'mateja.sefcic@gmail.com', 'Stevan', 'Stevanovic', 0),
(46, 'mateja.s2000@gmail.com', 'Mateja', 'Sefcic', 1),
(47, 'mateja.sefcic@gmail.com', 'mateja', 'Sefcic', 0),
(48, 'mateja.s2000@gmail.com', 'Mateja', 'Sefcic', 1),
(49, 'mijatdrcic2000@gmail.com', 'Mijat', 'Drcic', 1),
(50, 'mateja.s2000@gmail.com', 'Mateja', 'Sefcic', 0),
(51, 'mateja.s2000@gmail.com', 'Mateja', 'Sefcic', 0),
(52, 'mateja.s2000@gmail.com', 'Mateja', 'Sefcic', 0),
(53, 'mateja.s2000@gmail.com', 'Mateja', 'Sefcic', 0),
(54, 'mateja.s2000@gmail.com', 'Mateja', 'Sefcic', 0),
(55, 'mateja.s2000@gmail.com', 'Mateja', 'Sefcic', 0),
(56, 'mateja.s2000@gmail.com', 'Mateja', 'Sefcic', 0),
(57, 'mateja.s2000@gmail.com', 'Mateja', 'Sefcic', 0),
(58, 'mateja.s2000@gmail.com', 'Mateja', 'Sefcic', 0),
(59, 'mateja.s2000@gmail.com', 'Mateja', 'Sefcic', 0),
(60, 'mateja.s2000@gmail.com', 'Mateja', 'Sefcic', 0),
(61, 'mateja.s2000@gmail.com', 'Mateja', 'Sefcic', 0),
(62, 'mateja.s2000@gmail.com', 'Mateja', 'Sefcic', 0),
(63, 'mateja.s2000@gmail.com', 'Mateja', 'Sefcic', 0);

-- --------------------------------------------------------

--
-- Table structure for table `households`
--

DROP TABLE IF EXISTS `households`;
CREATE TABLE IF NOT EXISTS `households` (
  `id_household` int(11) NOT NULL AUTO_INCREMENT,
  `household_name` varchar(50) NOT NULL,
  `access` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_household`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `households`
--

INSERT INTO `households` (`id_household`, `household_name`, `access`) VALUES
(24, 'Stevanovici', 1),
(25, 'Sefcici', 1),
(26, 'Petrovici', 1),
(27, 'Petrovici', 1);

-- --------------------------------------------------------

--
-- Table structure for table `household_users`
--

DROP TABLE IF EXISTS `household_users`;
CREATE TABLE IF NOT EXISTS `household_users` (
  `id_household` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_role` int(11) NOT NULL,
  KEY `id_household` (`id_household`),
  KEY `id_user` (`id_user`),
  KEY `id_role` (`id_role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `log_history`
--

DROP TABLE IF EXISTS `log_history`;
CREATE TABLE IF NOT EXISTS `log_history` (
  `id_user` int(11) NOT NULL,
  `user_ip_address` varchar(15) NOT NULL,
  `web_browser` varchar(255) NOT NULL,
  `log_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `log_history_fk` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `log_history`
--

INSERT INTO `log_history` (`id_user`, `user_ip_address`, `web_browser`, `log_date`) VALUES
(64, '::1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.101 Mobile Safari/537.36', '2021-06-13 13:10:24'),
(64, '::1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.101 Mobile Safari/537.36', '2021-06-13 13:10:46'),
(64, '::1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.101 Mobile Safari/537.36', '2021-06-13 13:11:54'),
(64, '::1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.101 Mobile Safari/537.36', '2021-06-13 13:28:38');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id_role` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id_role`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id_role`, `role_name`) VALUES
(1, 'Admin'),
(2, 'User');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `name` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `address` varchar(150) NOT NULL,
  `phone` varchar(40) DEFAULT NULL,
  `user_password` varchar(70) NOT NULL,
  `is_verified` tinyint(1) DEFAULT '0',
  `verification_code` varchar(70) DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT '0',
  `is_banned` tinyint(1) NOT NULL DEFAULT '0',
  `change_pw_code` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `email`, `name`, `lastname`, `address`, `phone`, `user_password`, `is_verified`, `verification_code`, `is_admin`, `is_banned`, `change_pw_code`) VALUES
(64, 'mateja.s2000@gmail.com', 'Mateja', 'Sefcic', 'Adresa je ovo', '012361231', '$2y$10$UsEgorq3k3gOM2RSch47jOXHQCZvjb8G9JuMXPKSf6QipREYrJvB6', 1, NULL, 0, 0, 'BL0TfhdV33oB3JBeoxeE');

--
-- Triggers `users`
--
DROP TRIGGER IF EXISTS `onUserDelete`;
DELIMITER $$
CREATE TRIGGER `onUserDelete` AFTER DELETE ON `users` FOR EACH ROW BEGIN
	INSERT INTO deleted_users(id, email, name, lastname, is_admin) values (OLD.id_user, OLD.email, OLD.name, OLD.lastname, OLD.is_admin);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `viewadmins`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `viewadmins`;
CREATE TABLE IF NOT EXISTS `viewadmins` (
`name` varchar(30)
,`email` varchar(100)
);

-- --------------------------------------------------------

--
-- Table structure for table `wishes`
--

DROP TABLE IF EXISTS `wishes`;
CREATE TABLE IF NOT EXISTS `wishes` (
  `id_wish` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_household` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_cost_category` int(11) NOT NULL,
  `wish_name` varchar(50) NOT NULL,
  `wish_price` float NOT NULL,
  `wish_expectation` date NOT NULL,
  `wish_creating_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_wish`),
  KEY `id_household` (`id_household`),
  KEY `id_user` (`id_user`),
  KEY `id_cost_category` (`id_cost_category`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure for view `viewadmins`
--
DROP TABLE IF EXISTS `viewadmins`;

DROP VIEW IF EXISTS `viewadmins`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewadmins`  AS  select `users`.`name` AS `name`,`users`.`email` AS `email` from `users` where (`users`.`is_admin` = 1) ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cost`
--
ALTER TABLE `cost`
  ADD CONSTRAINT `cost_ibfk_1` FOREIGN KEY (`id_household`) REFERENCES `households` (`id_household`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cost_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `cost_ibfk_3` FOREIGN KEY (`id_cost_category`) REFERENCES `cost_categories` (`id_cost_category`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cost_categories`
--
ALTER TABLE `cost_categories`
  ADD CONSTRAINT `cost_categories_fk` FOREIGN KEY (`id_household`) REFERENCES `households` (`id_household`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `household_users`
--
ALTER TABLE `household_users`
  ADD CONSTRAINT `household_users_ibfk_1` FOREIGN KEY (`id_household`) REFERENCES `households` (`id_household`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `household_users_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `household_users_ibfk_3` FOREIGN KEY (`id_role`) REFERENCES `roles` (`id_role`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `log_history`
--
ALTER TABLE `log_history`
  ADD CONSTRAINT `log_history_fk` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `wishes`
--
ALTER TABLE `wishes`
  ADD CONSTRAINT `wishes_ibfk_1` FOREIGN KEY (`id_household`) REFERENCES `households` (`id_household`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `wishes_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `wishes_ibfk_3` FOREIGN KEY (`id_cost_category`) REFERENCES `cost_categories` (`id_cost_category`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
