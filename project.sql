-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 11, 2020 at 02:40 AM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
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
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `created_at`) VALUES
(1, 'Admin', 'admin@admin.com', '$2y$10$qcH3sL94yt7zM4wqZo467OH9PAhKj2R.N5ZS8jNxkyFgcVPYK4WsK', '2020-04-08');

-- --------------------------------------------------------

--
-- Table structure for table `exams`
--

CREATE TABLE `exams` (
  `id` int(11) NOT NULL,
  `file` varchar(200) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `year_id` int(11) DEFAULT NULL,
  `semester_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fees`
--

CREATE TABLE `fees` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `year_id` int(11) NOT NULL,
  `fees` decimal(10,2) DEFAULT NULL,
  `payed` decimal(10,2) DEFAULT NULL,
  `remaining` decimal(10,2) DEFAULT NULL,
  `fees_type` varchar(50) DEFAULT NULL,
  `ticket` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fees`
--

INSERT INTO `fees` (`id`, `student_id`, `year_id`, `fees`, `payed`, `remaining`, `fees_type`, `ticket`) VALUES
(7, 17, 1, '17.00', NULL, NULL, 'Rate 3', '16'),
(9, 17, 1, '54.00', NULL, NULL, 'Rate 1', '345'),
(10, 17, 1, '3.00', NULL, NULL, 'Rate 3', '546456'),
(11, 17, 1, '12.00', NULL, NULL, 'Rate 1', '12'),
(12, 17, 1, '100.00', NULL, NULL, 'Rate 1', '11');

-- --------------------------------------------------------

--
-- Table structure for table `marks`
--

CREATE TABLE `marks` (
  `id` int(11) NOT NULL,
  `mark` varchar(10) NOT NULL,
  `student_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `year_id` int(11) DEFAULT NULL,
  `session` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `marks`
--

INSERT INTO `marks` (`id`, `mark`, `student_id`, `section_id`, `subject_id`, `year_id`, `session`) VALUES
(9, '500', 17, 9, 1, 1, 'semester'),
(10, '100', 17, 9, 2, 1, 'semester'),
(11, '', 0, 0, 0, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `fees` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`id`, `name`, `fees`) VALUES
(9, 'A.I.A.', '100.00'),
(10, 'Software engineering', '200.00'),
(11, 'Automation engineering', '400.00');

-- --------------------------------------------------------

--
-- Table structure for table `section_years`
--

CREATE TABLE `section_years` (
  `id` int(11) NOT NULL,
  `year_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `section_years`
--

INSERT INTO `section_years` (`id`, `year_id`, `section_id`) VALUES
(59, 1, 9),
(60, 2, 9),
(61, 3, 9),
(62, 4, 9),
(63, 1, 10),
(64, 2, 10),
(65, 3, 10),
(66, 1, 11),
(67, 2, 11),
(68, 3, 11);

-- --------------------------------------------------------

--
-- Table structure for table `semesters`
--

CREATE TABLE `semesters` (
  `id` int(11) NOT NULL,
  `name` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `semesters`
--

INSERT INTO `semesters` (`id`, `name`) VALUES
(1, 'first semester'),
(2, 'second semester');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `username` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `year_id` int(11) DEFAULT NULL,
  `section_id` int(11) DEFAULT NULL,
  `created_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `username`, `last_name`, `email`, `password`, `year_id`, `section_id`, `created_at`) VALUES
(17, 'ewrwerwe', 'dskjfkdf', 'rwerwerwer', 'admin@admin.com', '$2y$10$VViW7KsK277bzK.AtA/U4ekcACxft5EE5nMpiTuOXCD3vhpBrR72m', 1, 9, NULL),
(18, 'ewrwerwe', 'sdjkfkjdsfh', 'rwerwerwer', 'adqmin@admin.com', '$2y$10$2/ZePhYyvqsjwq/jtyoPH.GJVBbLPe8oQtba9cbwT9R/kP4IxmTCu', 2, 9, NULL),
(19, 'Mohammed', 'fdjgkjdfg', 'rwerwerwer', 'adqqmin@admin.com', '$2y$10$arFlNnmFkse5DEdFgRfnDeRQYDsTxwyk/y5jQXhr7hvKFoZiVQUd2', 1, 9, NULL),
(20, 'ewrwerwe', 'jklfdhksjdf', 'rwerwerwer', 'adqqmwin@admin.com', '$2y$10$czk5uGoZJJalyIAPKFmX/eX/xVC1tRTm3NT0GJ24Gu4IKT7XmbHDC', 4, 9, NULL),
(21, 'fdgfdg', 'ddjkfksjdf', 'fdgfdgfdgfdg', 'mosallam06@gmail.com', '$2y$10$9jtuJkGehu2uzkV4Oot5uec6G9gfLQ18sKMcJ2WV//SxLfPzPGKPi', 1, 10, NULL),
(22, 'fdgfdg', 'djfhksjdf', 'fdgfdgfdgfdg', 'mosallamd06@gmail.com', '$2y$10$Ks6mcDBq8JlLVMU98BraJOf4xAaxWk4oGZna/ajXBf/TkpIB7mLhu', 2, 10, NULL),
(23, 'fdgfdg', 'klfdjghkjdfg', 'fdgfdgfdgfdg', 'mosallamdd06@gmail.com', '$2y$10$Q/p5bI8dgpunx56dhd2wZ.sn0x4FkagDle8IO7RFtVlidgyH3kMXy', 3, 10, NULL),
(24, 'sdfdsfsdf', 'lkdfjgkdj', 'sdfdsfsdf', 'mosallamf06@gmail.com', '$2y$10$Uj0CYbZymbNDokXqNpqsMu8Dfbs7OJdMtJ/8DyW0uyIHdfpurTj.6', 1, 11, NULL),
(25, 'sdfdsfsdf', 'fdjgkdsjf', 'sdfdsfsdf', 'mosallamfff06@gmail.com', '$2y$10$JYWLez5fAoRAzVasxFFa7OhyJJfdi2ZQWRzwhXeB/32.oXxLABSIy', 2, 11, NULL),
(26, 'sdfdsfsdf', 'dflkgjfldkgj', 'sdfdsfsdf', 'mosalamfff06@gmail.com', '$2y$10$0hX2m3txrx2/2XDLVJTnEOY8/oopsJ7rpnzxuRN6B0uFIEQ8j0J2u', 3, 11, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `year_id` int(11) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `section_id` int(11) DEFAULT NULL,
  `credit` enum('0','1','2','3','4','5') NOT NULL,
  `semester` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `name`, `year_id`, `teacher_id`, `section_id`, `credit`, `semester`) VALUES
(1, 'علوم ', 1, 3, 9, '2', 'first semester'),
(2, 'رياضيات', 1, 1, 9, '2', 'first semester'),
(3, 'ghjghjghj', 59, 1, 9, '2', 'first semester'),
(4, 'ghjghjghj', 59, 1, 9, '2', 'first semester'),
(5, 'ghjghjghj', 59, 1, 9, '2', 'first semester'),
(6, 'ghjghjghj', 59, 1, 9, '2', 'first semester'),
(7, 'ghjghjghj', 59, 1, 9, '2', 'first semester'),
(8, 'ghjghjghj', 59, 1, 9, '2', 'first semester'),
(9, 'ghjghjghj', 59, 1, 9, '2', 'first semester'),
(10, 'ghjghjghj', 59, 3, 9, '2', 'first semester'),
(11, 'ghjghjghj', 61, 3, 9, '2', 'first semester'),
(12, 'ghjghjghj', 61, 3, 9, '2', 'second semester'),
(13, 'ghjghjghj', 62, 4, 9, '2', 'second semester'),
(14, 'ttyutyuytu', 64, 1, 10, '2', 'first semester'),
(15, 'ttyutyuytu', 64, 1, 10, '2', 'first semester');

-- --------------------------------------------------------

--
-- Table structure for table `subject_files`
--

CREATE TABLE `subject_files` (
  `id` int(11) NOT NULL,
  `file` varchar(200) NOT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `section_id` int(11) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `year_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `name`, `last_name`, `username`, `email`, `phone`, `password`, `created_at`) VALUES
(1, 'Mohammed', 'sallam', 'mo200', 'te@te.com', '002010109184421', '$2y$10$T7/KPvRMJCfBih1aDERHy.6SsNxGGvZWl1nlonOTbSkih00E5KoBW', '2020-04-09 00:00:00'),
(2, 'Ahmed Sallam', 'sallam', 'ahsallam90', 'mo@mo.com', '002010109184422', '$2y$10$c3k0xRGd3RXLqPt6jfqem.CKRXQ64Q2B53adoKW2fyR06JXL8NVv2', '2020-04-09 00:00:00'),
(3, 'Mai', 'Adel', 'mai200', 'mo11@mo.com', '002012010918449', '$2y$10$fHUQYGU6JjzATwKPDAoQgO0Tfp.3Lystj9fWfXpnTRkAwVFtUhSqG', '2020-04-09 20:35:49'),
(4, 'Karem ', 'sallam', 'ka200', 'mo1@mo.com', '002012010918423', '$2y$10$S3zwXNWocZ4za8Un.QPUk.PYLbZEsDSAgYJRbQ4UQGg.oajLMsERq', '2020-04-09 20:36:22');

-- --------------------------------------------------------

--
-- Table structure for table `years`
--

CREATE TABLE `years` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `years`
--

INSERT INTO `years` (`id`, `name`) VALUES
(1, 'السنة الأولى'),
(2, 'السنة الثانية'),
(3, 'السنة الثالثة'),
(4, 'السنة الرابعة');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fees`
--
ALTER TABLE `fees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `marks`
--
ALTER TABLE `marks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `section_years`
--
ALTER TABLE `section_years`
  ADD PRIMARY KEY (`id`),
  ADD KEY `section_id` (`section_id`);

--
-- Indexes for table `semesters`
--
ALTER TABLE `semesters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `years`
--
ALTER TABLE `years`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `fees`
--
ALTER TABLE `fees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `marks`
--
ALTER TABLE `marks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `section_years`
--
ALTER TABLE `section_years`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `semesters`
--
ALTER TABLE `semesters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `years`
--
ALTER TABLE `years`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `fees`
--
ALTER TABLE `fees`
  ADD CONSTRAINT `fees_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `section_years`
--
ALTER TABLE `section_years`
  ADD CONSTRAINT `section_years_ibfk_1` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
