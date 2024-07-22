-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 22, 2024 at 03:09 PM
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
-- Database: `db_uas_tracer`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` char(12) COLLATE utf8mb4_general_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('admin') COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `nama`, `username`, `email`, `password`, `role`) VALUES
('1', 'admin#1234', 'admin', 'admin@gmail.com', '$2y$10$iZSGMNqyu8IeSa9a.huvyebuQaNcCENSJuGz7l.eGYD9kWbX.w.tS', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `alumni`
--

CREATE TABLE `alumni` (
  `nim` char(11) COLLATE utf8mb4_general_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `jurusan` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `ipk` decimal(3,2) DEFAULT NULL,
  `tahun_lulus` char(4) COLLATE utf8mb4_general_ci NOT NULL,
  `jk` char(1) COLLATE utf8mb4_general_ci NOT NULL,
  `telepon` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `foto` tinyblob,
  `email` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('alumni') COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alumni`
--

INSERT INTO `alumni` (`nim`, `nama`, `jurusan`, `ipk`, `tahun_lulus`, `jk`, `telepon`, `foto`, `email`, `password`, `role`, `username`) VALUES
('2113191075', 'Thor 2bulan', 's2_teknik_informatika', 4.00, '2019', 'L', '', '', 'toriqhaji2bulan@mail.aja', '$2y$10$mWg7U8hK.vHSxTNAGGDcR.zpfEzboxvT8njdSVR.Cmxggewf8ZW/.', 'alumni', 'tor'),
('2113191095', 'Anton Wibowo', 'D3 Teknik Informatika', NULL, '2019', 'L', NULL, NULL, 'anton@gmail.com', '$2y$10$UPTcJnf/93/URGxw79P37udCcFTXFR12Y7ldLqLNKNGT9Y1ISlhGu', 'alumni', 'anton'),
('2113201145', 'Neymar', 's1_teknik_informatika', 4.00, '2020', 'L', NULL, NULL, 'neymaro@gmail.com', '$2y$10$f2hSQgxb.2GdlkpXe9AqieXHFX85EV47sJ3zLYWyMNk1IoccGUbSO', 'alumni', 'ney'),
('2113211011', 'Mulan', 's2_teknik_informatika', 4.00, '2021', 'P', NULL, NULL, 'mulan@gmail.com', '$2y$10$c8ENflD1Q/mw5CTCf2zryODByEGaCopKT9DLKz4M6UY9iOK62JInS', 'alumni', 'mulan'),
('2113211088', 'Naura', 's1_teknik_informatika', 3.00, '2021', 'P', '', '', 'Naunau@nau', '$2y$10$LZMy.glRipqNMOT4PdEgR.h1Ta9wr8s6XmMBvRjy6E.xfQuM/6L1q', 'alumni', 'nau');

-- --------------------------------------------------------

--
-- Table structure for table `apply_jobs`
--

CREATE TABLE `apply_jobs` (
  `jobs_id` int NOT NULL,
  `nim` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nama` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tahun` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jurusan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `file_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `isApply` tinyint(1) NOT NULL DEFAULT '0',
  `apply_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `apply_jobs`
--

INSERT INTO `apply_jobs` (`jobs_id`, `nim`, `nama`, `tahun`, `jurusan`, `file_path`, `isApply`, `apply_date`) VALUES
(1, '2113191095', 'Anton', '2019', 'D3 Teknik Informatika', 'uploads/db_uas_tracer.sql', 1, '2024-07-20 10:03:40'),
(3, '2113191095', 'Anton Wibowo', '2019', 'D3 Teknik Informatika', '../../uploads/Screenshot from 2024-07-16 11-31-21.png', 0, '2024-07-21 04:10:53');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `company` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
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
-- Table structure for table `kaprodi`
--

CREATE TABLE `kaprodi` (
  `nidn` char(12) COLLATE utf8mb4_general_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `jk` char(1) COLLATE utf8mb4_general_ci NOT NULL,
  `jurusan` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `foto` tinyblob,
  `role` enum('kaprodi') COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kaprodi`
--

INSERT INTO `kaprodi` (`nidn`, `nama`, `username`, `email`, `password`, `jk`, `jurusan`, `foto`, `role`) VALUES
('0118342833', 'Faraj', 'tor', 'thor@gmail.com', '$2y$10$TyNhtSAFDYR/31sDwpB5TejwwGtmz7PTJoZH9oV4Cgd6knuR66kE6', 'L', 'Teknik Informatika', NULL, 'kaprodi');

-- --------------------------------------------------------

--
-- Table structure for table `kuisioner`
--

CREATE TABLE `kuisioner` (
  `nim_alumni` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `jurusan` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `ipk_kelulusan` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `lama_studi` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pekerjaan` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jenis_tempat_bekerja` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `level_tempat_bekerja` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `reg_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kuisioner`
--

INSERT INTO `kuisioner` (`nim_alumni`, `nama`, `jurusan`, `ipk_kelulusan`, `lama_studi`, `pekerjaan`, `jenis_tempat_bekerja`, `level_tempat_bekerja`, `reg_date`) VALUES
('2113191075', 'Thor 2bulan', 's2_teknik_informatika', '4', '1-3', 'bekerja', 'lembaga_swasta', 'nasional', '2024-07-21 15:23:03'),
('2113191095', 'Anton Wibowo', 'd3_teknik_informatika', '4', '1-3', 'bekerja', 'instansi_pemerintah', 'lokal', '2024-07-22 06:59:23'),
('2113201145', 'Neymar', 's1_teknik_informatika', '4', '1-3', 'tidak_bekerja', 'instansi_pemerintah', 'lokal', '2024-07-22 07:04:34'),
('2113211088', 'Naura', 's1_teknik_informatika', '4', '1-3', 'wirausaha', 'instansi_pemerintah', 'multinasional_internasional', '2024-07-22 06:59:23');

-- --------------------------------------------------------

--
-- Table structure for table `penilaian`
--

CREATE TABLE `penilaian` (
  `alumni_nim` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `etika` int NOT NULL,
  `keahlian_bidang` int NOT NULL,
  `kerjasama_tim` int NOT NULL,
  `pengembangan_diri` int NOT NULL,
  `kemampuan_bahasa_inggris` int NOT NULL,
  `kemampuan_teknologi` int NOT NULL,
  `kemampuan_komunikasi` int NOT NULL,
  `feedback` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penilaian`
--

INSERT INTO `penilaian` (`alumni_nim`, `etika`, `keahlian_bidang`, `kerjasama_tim`, `pengembangan_diri`, `kemampuan_bahasa_inggris`, `kemampuan_teknologi`, `kemampuan_komunikasi`, `feedback`, `created_at`) VALUES
('2113191075', 5, 5, 5, 5, 5, 4, 3, '-', '2024-07-21 14:17:41'),
('2113191095', 5, 5, 5, 5, 5, 5, 5, '5', '2024-07-20 09:27:32'),
('2113201145', 4, 5, 4, 4, 4, 5, 4, '-', '2024-07-22 07:08:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `alumni`
--
ALTER TABLE `alumni`
  ADD PRIMARY KEY (`nim`);

--
-- Indexes for table `apply_jobs`
--
ALTER TABLE `apply_jobs`
  ADD KEY `apply` (`jobs_id`),
  ADD KEY `nim_ibfk_1` (`nim`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kaprodi`
--
ALTER TABLE `kaprodi`
  ADD PRIMARY KEY (`nidn`);

--
-- Indexes for table `kuisioner`
--
ALTER TABLE `kuisioner`
  ADD PRIMARY KEY (`nim_alumni`),
  ADD KEY `nim_alumni` (`nim_alumni`),
  ADD KEY `nim_alumni_2` (`nim_alumni`);

--
-- Indexes for table `penilaian`
--
ALTER TABLE `penilaian`
  ADD UNIQUE KEY `alumni_nim` (`alumni_nim`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `apply_jobs`
--
ALTER TABLE `apply_jobs`
  ADD CONSTRAINT `apply` FOREIGN KEY (`jobs_id`) REFERENCES `jobs` (`id`),
  ADD CONSTRAINT `nim_ibfk_1` FOREIGN KEY (`nim`) REFERENCES `alumni` (`nim`);

--
-- Constraints for table `kuisioner`
--
ALTER TABLE `kuisioner`
  ADD CONSTRAINT `kuisioner_ibfk_1` FOREIGN KEY (`nim_alumni`) REFERENCES `alumni` (`nim`),
  ADD CONSTRAINT `kuisioner_ibfk_2` FOREIGN KEY (`nim_alumni`) REFERENCES `alumni` (`nim`);

--
-- Constraints for table `penilaian`
--
ALTER TABLE `penilaian`
  ADD CONSTRAINT `penilaian_ibfk_1` FOREIGN KEY (`alumni_nim`) REFERENCES `alumni` (`nim`) ON DELETE CASCADE ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
