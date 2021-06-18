-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 18, 2021 at 12:45 PM
-- Server version: 5.5.68-MariaDB
-- PHP Version: 7.2.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `untouchable`
--

-- --------------------------------------------------------

--
-- Table structure for table `cost`
--

CREATE TABLE `cost` (
  `id_cost` int(11) NOT NULL,
  `id_household` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_cost_category` int(11) NOT NULL,
  `cost_name` varchar(50) NOT NULL,
  `cost_price` float NOT NULL,
  `cost_description` varchar(255) DEFAULT NULL,
  `cost_creating_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cost`
--

INSERT INTO `cost` (`id_cost`, `id_household`, `id_user`, `id_cost_category`, `cost_name`, `cost_price`, `cost_description`, `cost_creating_date`) VALUES
(3, 6, 3, 44, 'Patike', 5000, 'Nove patike za fudbal ', '2021-06-18 04:25:22'),
(5, 6, 3, 46, 'Å tapovi za pecanje', 15000, 'Tri Å¡aranska Å¡tapa za pecanje', '2021-06-18 05:33:13'),
(11, 6, 3, 45, 'Letovanje u GrÄkoj', 10000, 'Letovanje u GrÄkoj', '2020-06-18 06:13:06'),
(12, 8, 2, 48, 'Koka kola', 120, 'Sok koka kola 2l', '2021-06-18 10:21:23'),
(13, 8, 4, 50, 'Struja', 12000, 'Struja za tekuci mesec', '2021-06-18 10:25:54');

-- --------------------------------------------------------

--
-- Table structure for table `cost_categories`
--

CREATE TABLE `cost_categories` (
  `id_cost_category` int(11) NOT NULL,
  `id_household` int(11) NOT NULL,
  `cost_category_name` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cost_categories`
--

INSERT INTO `cost_categories` (`id_cost_category`, `id_household`, `cost_category_name`) VALUES
(44, 6, 'Sportska oprema'),
(45, 6, 'Letovanje'),
(46, 6, 'Oprema za pecanje'),
(47, 6, 'Racuni'),
(48, 8, 'Hrana'),
(49, 8, 'Odmor'),
(50, 8, 'Racuni');

-- --------------------------------------------------------

--
-- Table structure for table `deleted_users`
--

CREATE TABLE `deleted_users` (
  `id` int(11) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `name` varchar(30) DEFAULT NULL,
  `lastname` varchar(30) DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `households`
--

CREATE TABLE `households` (
  `id_household` int(11) NOT NULL,
  `household_name` varchar(50) NOT NULL,
  `access` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `households`
--

INSERT INTO `households` (`id_household`, `household_name`, `access`) VALUES
(1, 'Sefcici', 0),
(2, 'Petrovici', 1),
(3, 'Drcici', 1),
(4, 'PEtrovici', 1),
(5, 'Djordjevici', 1),
(6, 'Sefcici 2', 1),
(7, 'Stevanovici', 1),
(8, 'Drcic', 1);

-- --------------------------------------------------------

--
-- Table structure for table `household_users`
--

CREATE TABLE `household_users` (
  `id_household` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `household_users`
--

INSERT INTO `household_users` (`id_household`, `id_user`, `id_role`) VALUES
(1, 2, 1),
(1, 3, 2),
(6, 3, 1),
(8, 4, 1),
(8, 2, 2),
(6, 4, 2);

-- --------------------------------------------------------

--
-- Table structure for table `household_user_invitation`
--

CREATE TABLE `household_user_invitation` (
  `id_household` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `inv_code` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `log_history`
--

CREATE TABLE `log_history` (
  `id_user` int(11) NOT NULL,
  `user_ip_address` varchar(15) NOT NULL,
  `web_browser` varchar(255) NOT NULL,
  `log_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `log_history`
--

INSERT INTO `log_history` (`id_user`, `user_ip_address`, `web_browser`, `log_date`) VALUES
(2, '::1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.101 Mobile Safari/537.36', '2021-06-15 22:06:01'),
(2, '::1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.101 Mobile Safari/537.36', '2021-06-15 22:08:21'),
(2, '::1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.101 Mobile Safari/537.36', '2021-06-15 22:08:40'),
(2, '::1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.101 Mobile Safari/537.36', '2021-06-15 22:09:26'),
(2, '::1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.101 Mobile Safari/537.36', '2021-06-15 22:22:38'),
(3, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.101 Safari/537.36', '2021-06-15 22:23:41'),
(2, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.101 Safari/537.36', '2021-06-15 22:25:37'),
(2, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.101 Safari/537.36', '2021-06-16 17:35:16'),
(2, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.101 Safari/537.36', '2021-06-16 18:03:59'),
(2, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.101 Safari/537.36', '2021-06-17 17:33:39'),
(3, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.101 Safari/537.36', '2021-06-17 17:35:35'),
(2, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.101 Safari/537.36', '2021-06-17 17:36:34'),
(3, '::1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.101 Mobile Safari/537.36', '2021-06-17 20:45:41'),
(2, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.101 Safari/537.36', '2021-06-17 21:34:49'),
(3, '::1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.101 Mobile Safari/537.36', '2021-06-17 21:35:38'),
(3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', '2021-06-17 21:55:54'),
(2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', '2021-06-17 22:09:14'),
(3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', '2021-06-17 23:09:22'),
(2, '85.222.187.41', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', '2021-06-18 09:15:59'),
(4, '109.93.138.177', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.101 Safari/537.36', '2021-06-18 10:17:34'),
(2, '109.93.138.177', 'Mozilla/5.0 (Linux; Android 8.0.0; ANE-LX1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.101 Mobile Safari/537.36', '2021-06-18 10:20:12'),
(4, '109.93.138.177', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.106 Safari/537.36', '2021-06-18 10:28:54'),
(4, '109.93.138.177', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.106 Safari/537.36', '2021-06-18 11:06:13'),
(4, '109.93.138.177', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.106 Safari/537.36', '2021-06-18 11:08:02'),
(4, '109.93.138.177', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.106 Safari/537.36', '2021-06-18 11:08:29'),
(5, '109.93.138.177', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.106 Safari/537.36', '2021-06-18 11:38:59'),
(2, '147.91.199.142', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.101 Safari/537.36 Edg/91.0.864.48', '2021-06-18 12:02:56'),
(3, '147.91.199.142', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.101 Safari/537.36 Edg/91.0.864.48', '2021-06-18 12:03:53'),
(4, '147.91.199.142', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36', '2021-06-18 12:10:49'),
(4, '147.91.199.142', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36', '2021-06-18 12:11:00'),
(4, '147.91.199.142', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36', '2021-06-18 12:22:27'),
(4, '147.91.199.142', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36', '2021-06-18 12:26:52'),
(5, '147.91.199.142', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36', '2021-06-18 12:35:49'),
(2, '147.91.199.142', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.101 Safari/537.36 Edg/91.0.864.48', '2021-06-18 12:42:38');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id_role` int(11) NOT NULL,
  `role_name` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
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
  `change_pw_code` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `email`, `name`, `lastname`, `address`, `phone`, `user_password`, `is_verified`, `verification_code`, `is_admin`, `is_banned`, `change_pw_code`) VALUES
(2, 'mateja.s2000@gmail.com', 'Mateja', 'Sefcic', 'Adresa', '012301239', '$2y$10$Qh5WYyNOTwGsDGF9R95AL.calL9wsymaRxfe8oRYMm2GKm3WiE4Uy', 1, NULL, 0, 0, NULL),
(3, 'mateja.sefcic@gmail.com', 'Mateja', 'Sefcic', 'Adresa', '012312333', '$2y$10$VxVieJ5tWC1wBzOT0hO26e.5eOMMNPKuCmXJpPRqtuy3oz31E6ueO', 1, NULL, 0, 0, NULL),
(4, 'mijatdrcic2000@gmail.com', 'mijat', 'Drcic', 'Ciganka Sisi 66', '06667773324', '$2y$10$wAMA0u.PcMJ3MBoj3k6iju2nazR.5JbZn.B4.RndIIGeywPCnC3Wi', 1, NULL, 0, 0, NULL),
(5, 'admin@admin.com', 'admin', 'admin', 'admin13', '827384797237', '$2y$10$aEu0xJ6GYIWSba.QwincTOS4.19VmQSFfoySbsoTHAMe9s7IHzmOG', 1, NULL, 1, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `wishes`
--

CREATE TABLE `wishes` (
  `id_wish` bigint(20) NOT NULL,
  `id_household` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_cost_category` int(11) NOT NULL,
  `wish_name` varchar(50) NOT NULL,
  `wish_price` float NOT NULL,
  `wish_expectation` date NOT NULL,
  `wish_creating_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `wishes`
--

INSERT INTO `wishes` (`id_wish`, `id_household`, `id_user`, `id_cost_category`, `wish_name`, `wish_price`, `wish_expectation`, `wish_creating_date`) VALUES
(7, 6, 3, 45, 'Letovanje u Grckoj', 30000, '2021-06-25', '2021-06-18 04:26:26'),
(8, 8, 4, 49, 'More', 24000, '2021-06-19', '2021-06-18 10:24:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cost`
--
ALTER TABLE `cost`
  ADD PRIMARY KEY (`id_cost`),
  ADD KEY `id_household` (`id_household`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_cost_category` (`id_cost_category`);

--
-- Indexes for table `cost_categories`
--
ALTER TABLE `cost_categories`
  ADD PRIMARY KEY (`id_cost_category`),
  ADD KEY `cost_categories_fk` (`id_household`);

--
-- Indexes for table `deleted_users`
--
ALTER TABLE `deleted_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `households`
--
ALTER TABLE `households`
  ADD PRIMARY KEY (`id_household`);

--
-- Indexes for table `household_users`
--
ALTER TABLE `household_users`
  ADD KEY `id_household` (`id_household`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_role` (`id_role`);

--
-- Indexes for table `household_user_invitation`
--
ALTER TABLE `household_user_invitation`
  ADD KEY `fk_id_user` (`id_user`),
  ADD KEY `fk_id_household` (`id_household`);

--
-- Indexes for table `log_history`
--
ALTER TABLE `log_history`
  ADD KEY `log_history_fk` (`id_user`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_role`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `wishes`
--
ALTER TABLE `wishes`
  ADD PRIMARY KEY (`id_wish`),
  ADD KEY `id_household` (`id_household`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_cost_category` (`id_cost_category`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cost`
--
ALTER TABLE `cost`
  MODIFY `id_cost` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `cost_categories`
--
ALTER TABLE `cost_categories`
  MODIFY `id_cost_category` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `households`
--
ALTER TABLE `households`
  MODIFY `id_household` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `wishes`
--
ALTER TABLE `wishes`
  MODIFY `id_wish` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
-- Constraints for table `household_user_invitation`
--
ALTER TABLE `household_user_invitation`
  ADD CONSTRAINT `fk_id_household` FOREIGN KEY (`id_household`) REFERENCES `households` (`id_household`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_id_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION;

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
