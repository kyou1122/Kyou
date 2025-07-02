-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 02, 2025 at 05:43 PM
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
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` int(11) NOT NULL,
  `business_id` int(11) NOT NULL,
  `officer_id` int(11) DEFAULT NULL,
  `status` varchar(20) NOT NULL,
  `date_submitted` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `business_id`, `officer_id`, `status`, `date_submitted`) VALUES
(1, 1, 2, 'approved', '2025-06-01 00:14:29'),
(2, 4, 5, 'approved', '2025-06-01 14:26:51'),
(3, 6, 5, 'rejected', '2025-06-01 20:29:33'),
(4, 5, 5, 'approved', '2025-06-01 21:52:04'),
(5, 7, 15, 'approved', '2025-06-02 00:31:22'),
(6, 10, 15, 'rejected', '2025-06-02 00:31:24'),
(7, 8, 5, 'approved', '2025-06-14 22:22:51');

-- --------------------------------------------------------

--
-- Table structure for table `businesses`
--

CREATE TABLE `businesses` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `business_name` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `ic_number` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `businesses`
--

INSERT INTO `businesses` (`id`, `user_id`, `business_name`, `name`, `email`, `ic_number`, `address`, `type`) VALUES
(1, 1, 'kioi', 'chien', 'chong@gmail.com', '563654565', 'lot122 daaaa', 'food'),
(4, 6, 'ali chicken goreng', 'ali bin abu', 'ali@gmail.com', '045313158825', 'lot 131121 jbakjdadkjash', 'food'),
(5, 4, 'LAM CLOTH COMPANNY', 'LAM LI LONG', 'lam@gmail.com', '3516131515', 'No. 23, Jalan Setia Indah 9/1, Taman Setia Indah, 81100 Johor Bahru, Johor, Malaysia.', 'clothing'),
(6, 7, 'abu bakery', 'abu bakar bin ali bakar', 'abu122@gmail.com', '0235481668566', 'No. 15, Jalan SS 2/75, SS 2, 47300 Petaling Jaya, Selangor, Malaysia.', 'backery'),
(7, 12, 'zia jia ', 'lee zi jia', 'zijia113@gmail.com', '900203145678', 'No. 27, Jalan Anggerik 3, Taman Bukit Dahlia, 81700 Pasir Gudang, Johor', 'retail'),
(8, 13, 'marsha store', 'marsha bin morshim', 'marsha123@gmail.com', '014562152344', 'No. 15, Lorong Kenanga 5, Taman Sri Wangi, 13200 Kepala Batas, Pulau Pinang', 'retail'),
(9, 14, 'cigi book', 'cigi zhing', 'cigi1123@gmail.com', '461216166784', 'No. 42, Jalan Merpati, Taman Indah, 70400 Seremban, Negeri SembilanNo. 42, Jalan Merpati, Taman Indah, 70400 Seremban, Negeri Sembilan', 'bookstore'),
(10, 10, 'hazieq BBQ STORE', 'mohd hazieq bin andul rahman', 'mohdhazieq@gmail.com', '045890234323', 'No. 19, Jalan Bunga Raya 3, Taman Seri Melati, 31400 Ipoh, Perak', 'retail'),
(11, 18, 'yuan chan cafe', 'yuan chan wai', 'yuan1029@gmail.com', '041202121227', 'No. 23, Jalan Teratai 8/2, Taman Desa Cemerlang, 81800 Ulu Tiram, Johor', 'retail'),
(12, 17, 'wei jia game', 'wei jia tan', 'weijia6565@gmail.com', '040506119898', 'No. 61, Lorong Mawar 2, Taman Sri Rampai, 53300 Setapak, Kuala Lumpur', 'retail');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('client','officer','admin') NOT NULL DEFAULT 'client'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`) VALUES
(1, 'chien', 'chienAAA@gmail.com', '$2y$10$CYNghCOcALaIrsBEg9kS3.PjGMWNjAREGC7tF1DgtXuolUX/FsbGi', 'client'),
(2, 'aiman', 'aiman@gmail.com', '$2y$10$oYqyI9HOg2uynUYx2GsNeuLpAZscaP.fEy9O591V1KJDhkrufgsRG', 'officer'),
(4, 'lam', 'lam@gmail.com', '$2y$10$oYqyI9HOg2uynUYx2GsNeuLpAZscaP.fEy9O591V1KJDhkrufgsRG', 'client'),
(5, 'zul', 'zul@gmail.com', '$2y$10$oYqyI9HOg2uynUYx2GsNeuLpAZscaP.fEy9O591V1KJDhkrufgsRG', 'officer'),
(6, 'ali', 'ali@gmail.com', '$2y$10$oYqyI9HOg2uynUYx2GsNeuLpAZscaP.fEy9O591V1KJDhkrufgsRG', 'client'),
(7, 'abu', 'abu@gmail.com', '$2y$10$oYqyI9HOg2uynUYx2GsNeuLpAZscaP.fEy9O591V1KJDhkrufgsRG', 'client'),
(8, 'khiun chien', 'khiunchien12@gmail.com', '$2y$10$GAoDrj97JvJ0lrrBNVcdKup0PnISsrZQ/WX6LrBuyp56.ZlllxTmy', 'client'),
(9, 'admin', 'admin@gmail.com', '$2y$10$GAoDrj97JvJ0lrrBNVcdKup0PnISsrZQ/WX6LrBuyp56.ZlllxTmy', 'admin'),
(10, 'hazieq', 'mohdhazieq@gmail.com', '$2y$10$JBNz65lx3EWXRUZojJo8d.Gqam7dPQBDDB8Bd4wF1Pc/nV56Hy01S', 'client'),
(11, 'DANIELA', 'danilashafika@gmail.com', '$2y$10$nKJa2xmjzOFcWwiYM2O7v.F.6F3TmKPXi361u4F.aYFjUTtS2jHNm', 'client'),
(12, 'zi jia', 'leezijia1113@gmail.com', '$2y$10$aVySMY1Q/wxG6vVkSkyHwevAf8MgTg47Cwy7eLR/b7/8A7cnSepxS', 'client'),
(13, 'marsha', 'marsha123@gmail.com', '$2y$10$HuXeSXZv8qvAIS3SxLOqoO5UQ4HLlDyam.h8SfAckjfUslhF6tBa2', 'client'),
(14, 'cigi', 'cigi1123@gmail.com', '$2y$10$uGlTqlfJdL0e.bkNcgGdcuGkOWHEFhcd.M1ePsxqmYrnCd6fsEqJa', 'client'),
(15, 'officer', 'officer@gmail.com', '$2y$10$wtwQm0Y1OSdgxGJDZXePq.WD7dCLJamIIyiMYo9X.koZZg0zvoyqC', 'officer'),
(16, 'khiunchien', 'khiunchien@gmail.com', '$2y$10$jJWXZ/ce4K3QT1tHHHYcvOFRewKZcxdSONfByieTkdIryPLovyQB2', 'client'),
(17, 'wei jia', 'weijia6565@gmail.com', '$2y$10$v5UNqxSqCqVOXzCjx37go.rn5rsMPeNvbam9ykSPc/9W3O4gcw2/m', 'client'),
(18, 'yuan chan', 'yuan1029@gmail.com', '$2y$10$BAjFGMcgFCNdtTF8hWYBgeJ0jUxBH24QGSiKpNjdSjjj3pAp8Vi/K', 'client'),
(19, 'amirulz89', 'amirulz89@gmail.com', '$2y$10$9p687TMpEV0IfkON7GetROVGSIMdsznjgQuLTmJg4ajBN3Uqfe4EW', 'client'),
(20, 'syaqina23', 'syaqina23@gmail.com', '$2y$10$lRwDfbWmpvJ0XaneWuqFbugulH007KjZw7mXr1e30kCxHynUE9h0u', 'client'),
(21, 'hafizul_m', 'hafizul_m@yahoo.com', '$2y$10$4bm/yCcO0hWUa7cQcavrheuCCyLY7QRLmeclQHc6vkokwnH5sye9K', 'client'),
(22, 'izzah_rahman', 'izzah_rahman@hotmail.com', '$2y$10$bYRTDLSGbF9DIkLD4Ls1VOSWg5mwFdympA6S/fj3IUx6oteFOk7.a', 'client'),
(23, 'danielk94', 'danielk94@outlook.com', '$2y$10$1KE26NBm3YtCoySKaTOpO.dE/UBNTQOFCYbrSpbn6gaeHom5vaP1K', 'client'),
(24, 'aiman.tech', 'aiman.tech@gmail.com', '$2y$10$63kkOCqWM.m2cCq6LfNDoOeCueHFtr1rB4ZoSLjcWR6DUNvMlgIKC', 'client'),
(25, 'babu', 'babu@gmail.com', '$2y$10$AHOnhHB5m.pObTvvGlloTeN6gGeLIn4yZ4UUtKadicefKh5RwPc7u', 'client'),
(26, 'AhhhDeep', 'asdeep@gmail.com', '$2y$10$XpgfGjpxySv7QcI.F.tpzOkZaG4KqRi2GiF/SvnUfaP4pYoDlJ3f2', 'client');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `business_id` (`business_id`),
  ADD KEY `fk_officer_id` (`officer_id`);

--
-- Indexes for table `businesses`
--
ALTER TABLE `businesses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `businesses`
--
ALTER TABLE `businesses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_ibfk_1` FOREIGN KEY (`business_id`) REFERENCES `businesses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_officer_id` FOREIGN KEY (`officer_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `businesses`
--
ALTER TABLE `businesses`
  ADD CONSTRAINT `businesses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
