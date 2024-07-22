-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 10, 2024 at 09:58 PM
-- Server version: 8.0.24
-- PHP Version: 8.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_tugasbesar`
--

-- --------------------------------------------------------

--
-- Table structure for table `alumni`
--

CREATE TABLE `alumni` (
  `id` int NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nama` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `nim` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `jurusan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tahun_lulus` varchar(5) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alumni`
--

INSERT INTO `alumni` (`id`, `username`, `nama`, `nim`, `jurusan`, `tahun_lulus`, `email`, `password`) VALUES
(1, NULL, 'Wildan', '2113221099', 'D3 Teknik Informatika', '2018', 'wim@wim', ''),
(2, 'wim', 'wim', '2113224545', 'D3 Teknik Informatika', '2018', '123@123', '123');

-- --------------------------------------------------------

--
-- Table structure for table `apply_jobs`
--

CREATE TABLE `apply_jobs` (
  `id` int NOT NULL,
  `job_id` int NOT NULL,
  `nim` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nama` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tahun` varchar(4) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jurusan` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `apply_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int NOT NULL,
  `alumni_id` int NOT NULL,
  `etika` int NOT NULL,
  `keahlian_bidang` int NOT NULL,
  `kerjasama_tim` int NOT NULL,
  `pengembangan_diri` int NOT NULL,
  `kemampuan_bahasa_inggris` int NOT NULL,
  `kemampuan_teknologi` int NOT NULL,
  `kemampuan_komunikasi` int NOT NULL,
  `feedback` text COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `alumni_id`, `etika`, `keahlian_bidang`, `kerjasama_tim`, `pengembangan_diri`, `kemampuan_bahasa_inggris`, `kemampuan_teknologi`, `kemampuan_komunikasi`, `feedback`, `created_at`) VALUES
(1, 1, 5, 5, 5, 5, 5, 5, 5, 'bagus', '2024-07-10 10:53:14');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `company` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `title`, `company`, `location`, `description`) VALUES
(1, 'Software Engineer', 'Tech Corp', 'Jakarta, Indonesia', 'Responsible for developing and maintaining software applications.'),
(2, 'Data Analyst', 'Data Inc.', 'Surabaya, Indonesia', 'Analyze and interpret complex data sets.'),
(3, 'UI/UX Designer', 'Design Studio', 'Bandung, Indonesia', 'Design user interfaces and user experiences for web and mobile applications.'),
(4, 'Machine Learning', 'Wim Corp', 'Jakarta, Indonesia', 'Responsible for developing and maintaining software applications.'),
(5, 'Cyber Security', 'Hacker Inc.', 'Surabaya, Indonesia', 'Analyze and interpret complex data sets.'),
(6, 'Dev Ops', 'Nginx corp', 'Bandung, Indonesia', 'Design user interfaces and user experiences for web and mobile applications.');

-- --------------------------------------------------------

--
-- Table structure for table `kuisioner`
--

CREATE TABLE `kuisioner` (
  `id` int NOT NULL,
  `nim` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `jurusan` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `tahun_lulus` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `jumlah_semester` int NOT NULL,
  `komentar` text COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status_pekerjaan` enum('kerja','wirausaha','belum kerja') COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kuisioner`
--

INSERT INTO `kuisioner` (`id`, `nim`, `nama`, `jurusan`, `tahun_lulus`, `jumlah_semester`, `komentar`, `tanggal`, `status_pekerjaan`) VALUES
(1, '2113229919', 'wim', 'Teknik Informatika', '2018', 8, 'hehee', '2024-07-09 02:07:23', 'kerja');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('user','admin','kaprodi') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `email`, `role`, `created_at`) VALUES
(3, 'wildan', 'wil', '$2y$10$zzvJBkAC.VW5zHetyYOqges6LF0sH.uyMIsgn/TNsx2o0CeevEJVK', 'waeas@hmail.com', 'user', '2024-06-26 09:12:45'),
(4, 'admin', 'admin', '$2y$10$294qoy6Yv6j2bI/vwbGvTutLDUYJ5QYDVIePcrD6LwMwOKHzriINW', '123@123', 'admin', '2024-06-26 09:21:53'),
(5, 'lorem', 'lorem', '$2y$10$UoiGztpTGk4XT2iJ5okcu.ZSWVKcwf19IcDZR50ZTbcNgJdjK2jZ6', 'fyfyfyf@ddf', 'kaprodi', '2024-07-06 12:47:26'),
(6, '', 'hehe', '123', 'hehe@hehe', 'user', '2024-07-10 09:38:07'),
(7, '', 'wi', '123', 'fyfyfyf@ddf', 'user', '2024-07-10 09:38:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alumni`
--
ALTER TABLE `alumni`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `apply_jobs`
--
ALTER TABLE `apply_jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_id` (`job_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `alumni_id` (`alumni_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kuisioner`
--
ALTER TABLE `kuisioner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alumni`
--
ALTER TABLE `alumni`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `apply_jobs`
--
ALTER TABLE `apply_jobs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `kuisioner`
--
ALTER TABLE `kuisioner`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `apply_jobs`
--
ALTER TABLE `apply_jobs`
  ADD CONSTRAINT `apply_jobs_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`);

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`alumni_id`) REFERENCES `alumni` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
