-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 29, 2025 at 03:56 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

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
-- Table structure for table `credentials`
--

CREATE TABLE `credentials` (
  `account_id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `site_id` int(11) NOT NULL,
  `username` varchar(35) NOT NULL,
  `password` varbinary(100) NOT NULL,
  `notes` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `credentials`
--

INSERT INTO `credentials` (`account_id`, `users_id`, `site_id`, `username`, `password`, `notes`) VALUES
(15, 4, 1, 'testfb', 0x7de0b3567e8869fe74f1b71ba5f06f1e, ''),
(17, 4, 7, 'testuser@gmail.com', 0x6ff570ca968f25b5ca550fa541a57bbf, ''),
(18, 5, 1, 'fbuserupdate', 0xc5c0fe3f6b4f5de5d24918af86ae03d2, ''),
(23, 5, 1, 'ASurafb', 0xc5c0fe3f6b4f5de5d24918af86ae03d2, ''),
(24, 5, 2, 'isntagram', 0xfc4161df6137d6f0ab473b9454fcbdab, ''),
(27, 5, 8, 'asdan', 0x1e02d86d154745b7f0d0eb223cf3c421, ''),
(29, 5, 4, 'asdad', 0x263631eee5311cd113a38f9e9698de35, ''),
(30, 5, 9, 'Asuraasd', 0x1e02d86d154745b7f0d0eb223cf3c421, ''),
(32, 5, 3, 'newgmailasdadasd', 0xbbc0fd8db1692c80dbe80f61a86e7b7f, ''),
(33, 5, 10, 'ribubaucha@gmail.com', 0x08df287ac4a0032b8323d27a7b4c69e9, ''),
(34, 11, 1, 'fbusername', 0xf06addb7ecff6d7a266b03d8bab6cdbe, ''),
(35, 11, 1, 'asura', 0xc35ba4587d705ea44c2b2e74f847c130, ''),
(36, 11, 2, 'instagram', 0xfb0df39b88dc783006c449cf5efa21b3, ''),
(37, 11, 2, 'newinsta', 0x8a28a5ab33f4c67614fdd756d8e08c0e, ''),
(38, 11, 3, 'ribubaucha@gmail.com', 0x2df29a18337eb84820125df9cb958586, ''),
(39, 11, 10, 'ribubaucha@gmail.com', 0x00bef392cef11e19021f16a5b8a21c9f, ''),
(40, 9, 1, 'FBusername', 0x39942b6e5d2c74fe715546815b035450, ''),
(41, 9, 10, 'ribesh.maharjan04@gmail.com', 0x8dbc3c8c23f03bcb81f0ff665d7711c1, ''),
(42, 9, 2, 'instaid', 0xf3ee47659ec6d70131c150efa115ad91, ''),
(43, 9, 2, 'instauser', 0x5316e7f6fb62d0c49b3f8f42f33c0e9a, ''),
(45, 12, 1, 'fbuser', 0x3839346232303430396534663463373062323134313437663261646365323535, '');

-- --------------------------------------------------------

--
-- Table structure for table `password_history`
--

CREATE TABLE `password_history` (
  `history_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `previous_username` varchar(35) NOT NULL,
  `previous_password` varbinary(100) NOT NULL,
  `changed_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `password_history`
--

INSERT INTO `password_history` (`history_id`, `account_id`, `previous_username`, `previous_password`, `changed_time`) VALUES
(14, 18, 'fbuser', 0xc5c0fe3f6b4f5de5d24918af86ae03d2, '2025-04-06 11:03:18'),
(15, 18, 'fbuser', 0xc5c0fe3f6b4f5de5d24918af86ae03d2, '2025-04-06 11:03:50'),
(16, 18, 'fbuser', 0xc5c0fe3f6b4f5de5d24918af86ae03d2, '2025-04-06 11:04:07'),
(19, 32, 'newgmail', 0xbbc0fd8db1692c80dbe80f61a86e7b7f, '2025-04-06 14:05:54'),
(20, 33, 'Googid', 0xa0298af4a3c903de24d2442447eb5540, '2025-04-07 09:50:43'),
(21, 33, 'ribubaucha@gmail.com', 0xe0b06971154b76e2df0911fceb267d4f, '2025-04-17 14:12:18'),
(22, 41, 'ribesh.maharjan01@gmail.com', 0x8dbc3c8c23f03bcb81f0ff665d7711c1, '2025-04-19 00:57:51');

-- --------------------------------------------------------

--
-- Table structure for table `sites`
--

CREATE TABLE `sites` (
  `site_id` int(11) NOT NULL,
  `site_name` varchar(50) NOT NULL,
  `site_url` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sites`
--

INSERT INTO `sites` (`site_id`, `site_name`, `site_url`) VALUES
(1, 'Facebook', 'facebook.com'),
(2, 'Instagram', 'instagram.com'),
(3, 'Gmail', 'gmail.com'),
(4, 'linkednin', 'linkednin.com'),
(5, 'canvas', 'cancas.com'),
(6, 'discord', 'discord.com'),
(7, 'localhost', 'localhost'),
(8, 'instagram', 'instragram.com'),
(9, 'linkedin', 'linkedin.com'),
(10, 'Google', 'google.com');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `users_name` varchar(35) NOT NULL,
  `users_email` varchar(50) NOT NULL,
  `users_pwd` varbinary(255) NOT NULL,
  `users_salt` varbinary(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `token` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `users_name`, `users_email`, `users_pwd`, `users_salt`, `created_at`, `token`) VALUES
(1, 'ribesh', 'ribubaucha@gmail.com', 0x243279243130242f47744a36634442466273537979772e666775566b75774b622e5a2e614f694d52723665516d536766464c57504a503367432f6971, 0xaa97351dcdb93ef66f035d631417282ea588ad75029f44c1, '2024-11-12 04:13:24', ''),
(2, 'asura', 'asura@gmail.com', 0x9b5fa4aa0cc9a997433cfb4131a21f28, 0x41db6b4f4e854f5123419d75dde97c29dba814fc44471ace, '2024-12-20 08:31:26', ''),
(3, 'ribesh1', 'ribubaucha1@gmail.com', 0x710e2603a2bf75cbed7fa34bcdb7bbd0, 0x41db6b4f4e854f5123419d75dde97c29dba814fc44471ace, '2024-12-20 09:29:25', ''),
(4, 'testuser', 'testuser@gmail.com', 0x6ff570ca968f25b5ca550fa541a57bbf, 0xb87b79b2479f3c4a2cf2c80c8365bee558618217e05ad7af, '2025-03-26 00:21:07', '30c3af4026a27ec89af0f0fd8ac00cc55dc784608833a5051613b3ed443f7475'),
(5, 'sandesh khakuri', 'sandesh21@gmail.com', 0xb8d59c62b63ca9ba9373f0f6a425a827, 0x054dde8dcba7a02dfc20a4cffa3d958f3e89aad06cba2c2b, '2025-04-03 23:43:46', '5a2e402bc103bd6588ff16d57eb8c1860e8bbacac81bb392655e1a0704565da8'),
(6, 'helloworld', 'world@gmail.com', 0xa4f3b87eb3c57d62f7b25a47646aca1d, 0x18db18beca90cd60c322b9e44d83b7906868d8babb92fdea, '2025-04-06 10:19:39', ''),
(7, 'newtesting', 'testing@gmail.com', 0x8eca91b79922ae7d44c18361ff6e0410, 0x526122d1a508f2e8aa2602ac30e3f14988cd811050e60fb6, '2025-04-06 10:20:07', ''),
(9, 'John Doe', 'john@gmail.com', 0x0a5037430b8aad552f70cb1a2e36d683, 0xfab8d000846e4af1c2d2903cd45a86bd5a9ffba44c13741d, '2025-04-06 14:08:16', '3dc32236961d9785340f840ac49c8c2feeca272b296d41d821f119fb372ad4a2'),
(10, 'ramesh', 'ramesh@gmail.com', 0xff7a2262237fe5714ad0bfc1d9b8ca18, 0xb72d4adaf09cfbd76ebfe2c89220b375bc3890434e2548a9, '2025-04-18 12:32:04', ''),
(11, 'user', 'user@gmail.com', 0x1fda9c30c0cbf35d0bdc0c18001eb5e4, 0x4c620ad67be5686dbb20c081f7869399d8ea2abded4fa8fa, '2025-04-18 21:16:09', '64b042dc71bd1ea122f4c7a094a3e81f98575866aa98338320214f21ccd35727'),
(12, 'aestest', 'aes@gmail.com', 0x3266343466313063326236636332633461613038303033663137383066393764, 0xc6ee4290a54435f9bcfc3eff98699c1dd027d01488f11b3c, '2025-04-28 06:43:25', '');

--
-- Indexes for dumped tables
--

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
  ADD PRIMARY KEY (`site_id`);

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
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `password_history`
--
ALTER TABLE `password_history`
  MODIFY `history_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `sites`
--
ALTER TABLE `sites`
  MODIFY `site_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
