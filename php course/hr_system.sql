-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 04, 2025 at 10:57 PM
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
-- Database: `hr_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `attendance_date` date NOT NULL,
  `status` enum('present','absent','leave') NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `employee_id`, `attendance_date`, `status`, `note`, `created_at`) VALUES
(2, 6, '2025-10-02', 'present', NULL, '2025-10-02 15:33:34'),
(5, 6, '2025-10-04', 'absent', NULL, '2025-10-04 19:36:15'),
(7, 8, '2025-10-04', 'present', NULL, '2025-10-04 20:48:39'),
(8, 9, '2025-10-04', 'present', NULL, '2025-10-04 20:48:39'),
(9, 10, '2025-10-04', 'present', NULL, '2025-10-04 20:53:05');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `description`, `created_at`) VALUES
(1, 'HR', 'Human Resources', '2025-10-01 21:49:55'),
(2, 'IT', 'Information Technology', '2025-10-01 21:49:55'),
(3, 'Finance', 'Finance Department', '2025-10-01 21:49:55');

-- --------------------------------------------------------

--
-- Table structure for table `employess`
--

CREATE TABLE `employess` (
  `id` int(11) NOT NULL,
  `First_name` varchar(100) NOT NULL,
  `Last_name` varchar(100) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `hire_date` date DEFAULT NULL,
  `basic_salary` decimal(10,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employess`
--

INSERT INTO `employess` (`id`, `First_name`, `Last_name`, `email`, `phone`, `department_id`, `hire_date`, `basic_salary`, `created_at`, `updated_at`, `user_id`) VALUES
(6, 'sara', 'ahmad', 'saraahmad@gmail.com', '000000', 2, '2020-02-01', 500.00, '2025-10-01 22:19:44', NULL, 2),
(8, 'ali', 'sami', 'ali@gmail.com', '00000', 3, '2024-10-12', 400.00, '2025-10-04 20:13:22', NULL, NULL),
(9, 'halla', 'ahmad', 'halla@gmail.com', '0000', 2, '2024-09-04', 400.00, '2025-10-04 20:46:45', NULL, NULL),
(10, 'ali', 'aa', 'ali@gmil.com', '1111', 2, '2025-10-04', 300.00, '2025-10-04 20:51:55', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `leaves`
--

CREATE TABLE `leaves` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `applied_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `processed_by` int(11) DEFAULT NULL,
  `processed_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leaves`
--

INSERT INTO `leaves` (`id`, `employee_id`, `start_date`, `end_date`, `type`, `reason`, `status`, `applied_at`, `processed_by`, `processed_at`) VALUES
(5, 6, '2025-10-03', '2025-10-05', 'sick', 'sick leave', 'rejected', '2025-10-03 18:41:49', NULL, NULL),
(6, 6, '2025-10-03', '2025-10-05', 'annual', 'sdfghj', 'approved', '2025-10-03 19:05:54', NULL, NULL),
(7, 6, '2025-10-04', '2025-10-05', 'annual', 'fghjk', 'pending', '2025-10-04 19:37:09', NULL, NULL),
(8, 6, '2025-10-04', '2025-10-07', 'sick', 'sick', 'pending', '2025-10-04 20:53:59', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payslips`
--

CREATE TABLE `payslips` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `basic_salary` decimal(10,2) NOT NULL,
  `allowances` decimal(10,2) DEFAULT 0.00,
  `deductions` decimal(10,2) DEFAULT 0.00,
  `net_salary` decimal(10,2) NOT NULL,
  `generated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','employee') NOT NULL DEFAULT 'employee',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `employee_id`, `username`, `password`, `role`, `created_at`) VALUES
(1, NULL, 'admin', '$2y$10$K9GNeryY5rQf3fBJoM3mCONxmyGU/zCprjmNhuqEvtx6oF9FnITou', 'admin', '2025-09-30 21:45:29'),
(2, 6, 'adan', '$2y$10$Z5Jhy3G8cDIKZosA9OJUqeJQ8Su6JYoNLL1IQNcfazUAQbK.CAQGO', 'employee', '2025-09-30 22:16:50'),
(3, NULL, 'ahmad', '$2y$10$Z5Jhy3G8cDIKZosA9OJUqeJQ8Su6JYoNLL1IQNcfazUAQbK.CAQGO', 'employee', '2025-10-03 18:05:33');

--
-- Triggers `users`
--
DELIMITER $$
CREATE TRIGGER `after_user_insert` AFTER INSERT ON `users` FOR EACH ROW BEGIN
    UPDATE employess
    SET user_id = NEW.id
    WHERE id = NEW.employee_id;
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_emp_date` (`employee_id`,`attendance_date`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employess`
--
ALTER TABLE `employess`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `leaves`
--
ALTER TABLE `leaves`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `payslips`
--
ALTER TABLE `payslips`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_payslip` (`employee_id`,`month`,`year`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `employee_id` (`employee_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `employess`
--
ALTER TABLE `employess`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `leaves`
--
ALTER TABLE `leaves`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `payslips`
--
ALTER TABLE `payslips`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employess` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employess`
--
ALTER TABLE `employess`
  ADD CONSTRAINT `employess_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_user_employee` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `leaves`
--
ALTER TABLE `leaves`
  ADD CONSTRAINT `leaves_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employess` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payslips`
--
ALTER TABLE `payslips`
  ADD CONSTRAINT `payslips_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employess` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employess` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
