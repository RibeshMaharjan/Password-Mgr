-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 14, 2025 at 02:48 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `passwordmgr`
--

-- --------------------------------------------------------

--
-- Table structure for table `auth_settings`
--

CREATE TABLE `auth_settings` (
  `user_id` int NOT NULL,
  `isVerified` varchar(2) NOT NULL DEFAULT '0',
  `is_2FA_enabled` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '0',
  `verification_code` varchar(8) DEFAULT NULL,
  `verification_req_date` timestamp NULL DEFAULT NULL,
  `otp` varchar(8) DEFAULT NULL,
  `otp_expiry_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `auth_settings`
--

INSERT INTO `auth_settings` (`user_id`, `isVerified`, `is_2FA_enabled`, `verification_code`, `verification_req_date`, `otp`, `otp_expiry_date`) VALUES
(1, '1', '0', NULL, NULL, '179189', '2025-05-31 12:13:35'),
(2, '1', '1', NULL, NULL, NULL, '2025-06-14 02:46:22'),
(3, '1', '0', NULL, NULL, NULL, '2025-05-31 11:56:26'),
(4, '1', '1', NULL, NULL, '148366', '2025-05-16 20:47:48');

-- --------------------------------------------------------

--
-- Table structure for table `credentials`
--

CREATE TABLE `credentials` (
  `account_id` int NOT NULL,
  `users_id` int NOT NULL,
  `site_id` int NOT NULL,
  `username` varchar(35) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varbinary(255) NOT NULL,
  `notes` varchar(500) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `credentials`
--

INSERT INTO `credentials` (`account_id`, `users_id`, `site_id`, `username`, `password`, `notes`, `created_at`, `updated_at`) VALUES
(19, 2, 12, 'ribesh.maharjan04@gmail.com', 0x3165336566353839323235386132346362613937356663633266613838366462, '', '2025-05-13 07:56:28', NULL),
(20, 2, 12, 'ribubaucha@gmail.com', 0x3335366163376565323137653566386437633039626137313333353231303834, '', '2025-05-13 11:37:16', NULL),
(22, 3, 13, 'asura_007', 0x3430323335393763363730383362333566373330333630333537343063623439, '', '2025-05-15 04:35:01', NULL),
(23, 3, 14, 'facebookid', 0x3938356163616239643666313066643935333363636635383830326535613564, '', '2025-05-15 04:52:56', NULL),
(24, 3, 15, 'instaid', 0x3563653935333835383833333834616532373664376365636563346638623138, 'Credential for Instagram', '2025-05-15 04:53:42', '2025-05-16 01:20:07'),
(25, 3, 15, 'asura_007', 0x3563653935333835383833333834616532373664376365636563346638623138, '', '2025-05-15 04:54:07', '2025-05-16 01:20:45'),
(26, 3, 15, 'ribesh_01', 0x6363363335613863303539633132623537316439326166303330623930316163, '', '2025-05-15 04:54:57', NULL),
(28, 1, 17, 'john_01', 0x3966613063356262633133323836323962636132383738303630663231303362, '', '2025-05-31 12:23:30', NULL),
(30, 2, 11, 'facebookid', 0x6332366238656264396234316234333535653630393064653062636161666635, 'Asura facebook passsword', '2025-06-14 02:25:36', NULL),
(31, 2, 18, 'insta', 0x3330643638326566366231636437326433316330636366313739333263356461, 'asdfadsad', '2025-06-14 02:26:22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_history`
--

CREATE TABLE `password_history` (
  `history_id` int NOT NULL,
  `account_id` int NOT NULL,
  `previous_username` varchar(35) COLLATE utf8mb4_general_ci NOT NULL,
  `previous_password` varbinary(100) NOT NULL,
  `changed_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `password_history`
--

INSERT INTO `password_history` (`history_id`, `account_id`, `previous_username`, `previous_password`, `changed_time`) VALUES
(32, 24, 'instaid', 0x3562363335343236653734306130396332386530336438353731366463366233, '2025-05-15 04:55:14'),
(33, 25, 'asura_007', 0x3364353635623234663531396139343666396361353332663333333864636634, '2025-05-16 01:20:02'),
(34, 24, 'instaid', 0x3037373130306239363261333061656430346365333661373530343030366163, '2025-05-16 01:20:07'),
(35, 25, 'asura_007', 0x3563653935333835383833333834616532373664376365636563346638623138, '2025-05-16 01:20:27'),
(36, 25, 'asura_007', 0x6363653233376334356430323063333735623164396436633432356530393734, '2025-05-16 01:20:45');

-- --------------------------------------------------------

--
-- Table structure for table `sites`
--

CREATE TABLE `sites` (
  `site_id` int NOT NULL,
  `user_id` int NOT NULL,
  `site_name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `site_url` varchar(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sites`
--

INSERT INTO `sites` (`site_id`, `user_id`, `site_name`, `site_url`) VALUES
(11, 2, 'Facebook', 'https://www.facebook.com'),
(12, 2, 'Google', 'https://www.google.com'),
(13, 3, 'Google', 'https://www.google.com'),
(14, 3, 'Facebook', 'https://www.facebook.com'),
(15, 3, 'Instagram', 'https://www.instagram.com'),
(17, 1, 'Facebook', 'https://www.facebook.com'),
(18, 2, 'Instagram', 'https://www.instagram.com'),
(19, 3, 'LinkedIn', 'http://linkedin.com'),
(20, 3, 'LinkedIn', 'http://www.linkedin.com');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `users_fullname` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `users_name` varchar(35) COLLATE utf8mb4_general_ci NOT NULL,
  `users_email` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `users_pwd` varbinary(255) NOT NULL,
  `users_salt` varbinary(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `token` varchar(82) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `users_fullname`, `users_name`, `users_email`, `users_pwd`, `users_salt`, `created_at`, `token`) VALUES
(1, 'John Doe', 'john', 'john@gmail.com', 0x3335366163376565323137653566386437633039626137313333353231303834, 0x6ca5c27eda4006398e1d739a4977ed412e89b6edc53b1cd5, '2025-04-29 02:05:01', '86aa887815e7e825f2d6e5246b3d1620db4307bc4c27bc2c2cae2fc0b27b3446'),
(2, 'Ribesh Maharjan', 'ribesh_01', 'ribesh.maharjan04@gmail.com', 0x3335366163376565323137653566386437633039626137313333353231303834, 0x6ca5c27eda4006398e1d739a4977ed412e89b6edc53b1cd5, '2025-05-13 07:14:24', '221290133af60d11d3f27ee2db1f7a91748a177ff1d1cf1b1fa9ce6a907253a9'),
(3, 'Asura Maharjan', 'asura_007', 'ribubaucha@gmail.com', 0x3563653935333835383833333834616532373664376365636563346638623138, 0xa93f3dd14b26684fd49874868cd2dd0508a07f5f3f3a8b1c, '2025-05-15 01:46:48', '5189c88d2b489e112c6a1ff332ee2d5164c7b14ee18b8b87c01b93732dcab748'),
(4, 'RIjan Bajrachrya', 'rijan_001', 'rijan123bajracharya@gmail.com', 0x3635363438356637616238356564376262303535333034383335336435306464, 0x844fa7505818b4fc7a319d3ef3a76a2e5b36c38162a12089, '2025-05-16 20:43:06', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auth_settings`
--
ALTER TABLE `auth_settings`
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `credentials`
--
ALTER TABLE `credentials`
  ADD PRIMARY KEY (`account_id`),
  ADD KEY `users_id` (`users_id`),
  ADD KEY `site_id` (`site_id`);

--
-- Indexes for table `password_history`
--
ALTER TABLE `password_history`
  ADD PRIMARY KEY (`history_id`),
  ADD KEY `account_id` (`account_id`);

--
-- Indexes for table `sites`
--
ALTER TABLE `sites`
  ADD PRIMARY KEY (`site_id`),
  ADD KEY `site_tbl_constraint` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `users_email` (`users_email`),
  ADD UNIQUE KEY `users_name` (`users_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `credentials`
--
ALTER TABLE `credentials`
  MODIFY `account_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `password_history`
--
ALTER TABLE `password_history`
  MODIFY `history_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `sites`
--
ALTER TABLE `sites`
  MODIFY `site_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `auth_settings`
--
ALTER TABLE `auth_settings`
  ADD CONSTRAINT `user_id_constraint` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `credentials`
--
ALTER TABLE `credentials`
  ADD CONSTRAINT `site_id` FOREIGN KEY (`site_id`) REFERENCES `sites` (`site_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_id` FOREIGN KEY (`users_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `password_history`
--
ALTER TABLE `password_history`
  ADD CONSTRAINT `account_id` FOREIGN KEY (`account_id`) REFERENCES `credentials` (`account_id`) ON DELETE CASCADE;

--
-- Constraints for table `sites`
--
ALTER TABLE `sites`
  ADD CONSTRAINT `site_tbl_constraint` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
