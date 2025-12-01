-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 01, 2025 at 02:11 PM
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
-- Database: `lionsport_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(6) UNSIGNED NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `reg_date`) VALUES
(1, 'Ina', 'inaconteh001@gmail.com', '$2y$10$l.c6DVisg8/kXoWE/SzHxe5B9pMbtozQHtkLecVbxEh6jL/aFeetC', 'user', '2025-11-30 17:35:15'),
(2, 'Conteh', 'inacon@123', '$2y$10$FwjCdFP.8OSwDiiNx5PRKOrs0xdqF6e19gZiTIR68rYNR2Yon6AgK', 'user', '2025-11-30 17:39:13'),
(3, 'admin1', 'admin1@gmail.com', '$2y$10$HRmRq1Zw4eSg1VU0S3KSheR7bKFjvTio7nP.XXctjrf.IWIzytIay', 'admin', '2025-12-01 12:39:00'),
(4, 'admin2', 'admin2@gmail.com', '$2y$10$HRmRq1Zw4eSg1VU0S3KSheR7bKFjvTio7nP.XXctjrf.IWIzytIay', 'admin', '2025-12-01 12:39:27'),
(5, 'user1', 'user1@gmail.com', '$2y$10$HRmRq1Zw4eSg1VU0S3KSheR7bKFjvTio7nP.XXctjrf.IWIzytIay', 'user', '2025-12-01 12:39:50'),
(6, 'user2', 'moses@gmail.com', '$2y$10$HRmRq1Zw4eSg1VU0S3KSheR7bKFjvTio7nP.XXctjrf.IWIzytIay', 'user', '2025-12-01 12:40:33');

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
