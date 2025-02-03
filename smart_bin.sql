-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 02, 2025 at 10:03 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smart_bin`
--

-- --------------------------------------------------------

--
-- Table structure for table `photo_electric`
--

CREATE TABLE `photo_electric` (
  `id` int(11) NOT NULL,
  `value` int(255) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `photo_electric`
--

INSERT INTO `photo_electric` (`id`, `value`, `time`) VALUES
(1, 30, '2025-02-02 19:06:57'),
(2, 50, '2025-02-02 19:28:53'),
(3, 37, '2025-02-02 19:47:06'),
(4, 30, '2025-02-02 20:19:43'),
(5, 99, '2025-02-02 20:27:04'),
(6, 59, '2025-02-02 20:27:57'),
(7, 39, '2025-02-02 20:31:37'),
(8, 37, '2025-02-02 20:31:47'),
(9, 70, '2025-02-02 20:31:57'),
(10, 10, '2025-02-02 20:32:07'),
(11, 55, '2025-02-02 20:32:10'),
(12, 22, '2025-02-02 20:32:17'),
(13, 94, '2025-02-02 20:32:27'),
(14, 55, '2025-02-02 20:32:37'),
(15, 82, '2025-02-02 20:32:47'),
(16, 55, '2025-02-02 20:44:39'),
(17, 93, '2025-02-02 20:54:03'),
(18, 46, '2025-02-02 20:54:19'),
(19, 80, '2025-02-02 20:56:02'),
(20, 87, '2025-02-02 20:57:08'),
(21, 78, '2025-02-02 20:57:29'),
(22, 86, '2025-02-02 20:59:28'),
(23, 86, '2025-02-02 20:59:34'),
(24, 85, '2025-02-02 20:59:49'),
(25, 85, '2025-02-02 20:59:51'),
(26, 80, '2025-02-02 21:02:07'),
(27, 72, '2025-02-02 21:02:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `photo_electric`
--
ALTER TABLE `photo_electric`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `photo_electric`
--
ALTER TABLE `photo_electric`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
