-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 10, 2023 at 02:31 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `codeweb_student_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `application_form_payments`
--

CREATE TABLE `application_form_payments` (
  `payment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `receipt` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `course_price` decimal(10,2) NOT NULL,
  `name` varchar(255) NOT NULL,
  `course_logo` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `category` varchar(255) NOT NULL,
  `duration_in_months` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `staff_id`, `course_price`, `name`, `course_logo`, `description`, `category`, `duration_in_months`) VALUES
(1, 1, 250000.00, 'Mobile development with flutter', 'flutter-logo.webp', '<p>In this course, you would learn the following:</p>\n<ul><li>The dart programming language</li><li>How to create UI elements</li><li>Handle user input</li><li>Integrating data sources in flutter apps</li></ul>', 'mobile', 4),
(2, 1, 250000.00, 'Mobile development with xamarin', 'xamarin-logo.png', '<p>In this course, you would learn the following:</p>\n<ul><li>How to create a new xamarin project as well as understanding the various components of a xamarin app</li><li>How to design and build user interfaces as well as how to add and manage data</li><li>You would also learn how to publish your apps in the app store</li></ul>', 'mobile', 6),
(3, 1, 150000.00, 'CCNA/CCNP networking course', 'cisco-logo.jpg', '<p>In this course, you would learn the following:</p>\n<ul><li>The fundamentals of computer networking and prepares students for the CCNA and CCNP certification exams</li><li>Learn the basics of networking protocols such as TCP/IP</li><li>Introduction to common networking devices such as routers and switches</li><li>Learn about the network security, wireless networking and network management </li></ul>', 'networking', 6),
(4, 1, 2000.00, 'Web development using the LAMP stack (PHP)', 'php-logo.png', '<p>In this course, you would learn the following:</p>\n<ul><li>The basics of each component of the lamp stack</li><li>How to create dynamic web pages</li><li>Installing and configuring Linux, Apache and PHP</li><li>Managing databases with mySQL</li><li>You would also learn how to develop, design and deploy dynamic web pages</li></ul>', 'web', 4),
(5, 1, 150000.00, 'Web development using the .NET framework', 'dot-net.png', '<p>In this course, you would learn the following:</p>\n<ul><li>Learning how to develop, deploy and run applications using .NET technologies such as C# ASP.NET, and Windows Forms</li><li>Topics covered includes:<ul><li>.NET Architecture</li><li>Common Language Runtime (CLR)</li><li>.NET class libraries</li><li>C# language basics</li><li>ASP.NET web forms</li><li>Windows Form development</li></ul></li></ul>', 'web', 6),
(6, 1, 20000.00, 'Holiday coding camp', 'holiday-coding-camp.jfif', '<p>Prepare your children for a brighter future with the following ICT trainings:</p>\n<ul>\n<li>Learning to code</li>\n<li>Graphics Design</li>\n<li>Robotics</li>\n</ul>', 'special', 1);

-- --------------------------------------------------------

--
-- Table structure for table `course_lookup`
--

CREATE TABLE `course_lookup` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `completed` varchar(1) NOT NULL DEFAULT '0' COMMENT '0-incompleted, 1-completed',
  `fully_paid` varchar(1) NOT NULL COMMENT '0=No, 1=Yes',
  `installment` varchar(1) NOT NULL DEFAULT '0' COMMENT '0=No,1=Yes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `course_payments`
--

CREATE TABLE `course_payments` (
  `payment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `amount_paid` decimal(10,2) NOT NULL,
  `months_paid` int(11) NOT NULL,
  `receipt` varchar(250) NOT NULL,
  `paid_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deposits`
--

CREATE TABLE `deposits` (
  `deposit_id` int(11) NOT NULL,
  `transaction_ref` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `deposit_amount` decimal(10,2) NOT NULL,
  `deposit_for` varchar(1) NOT NULL COMMENT '1-application form, 2-course payment',
  `deposit_status` varchar(1) NOT NULL DEFAULT '0',
  `deposit_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `guardians`
--

CREATE TABLE `guardians` (
  `guardian_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `phone_no` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `occupation` varchar(255) NOT NULL,
  `relationship` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `score_records`
--

CREATE TABLE `score_records` (
  `score_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `first_sitting` int(11) NOT NULL,
  `second_sitting` int(11) NOT NULL,
  `final_grade` int(11) NOT NULL,
  `exam_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staffs`
--

CREATE TABLE `staffs` (
  `staff_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `father_first_name` varchar(255) NOT NULL,
  `father_last_name` varchar(255) NOT NULL,
  `mother_first_name` varchar(255) NOT NULL,
  `mother_last_name` varchar(255) NOT NULL,
  `father_contact` varchar(255) NOT NULL,
  `mother_contact` varchar(255) NOT NULL,
  `father_profession` varchar(255) NOT NULL,
  `mother_profession` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `sex` varchar(1) NOT NULL,
  `date_of_birth` date NOT NULL,
  `place_of_birth` varchar(255) NOT NULL,
  `date_of_hiring` date NOT NULL,
  `years_of_service` int(11) DEFAULT NULL,
  `salary` decimal(10,2) DEFAULT NULL,
  `specialty` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staffs`
--

INSERT INTO `staffs` (`staff_id`, `first_name`, `last_name`, `father_first_name`, `father_last_name`, `mother_first_name`, `mother_last_name`, `father_contact`, `mother_contact`, `father_profession`, `mother_profession`, `address`, `sex`, `date_of_birth`, `place_of_birth`, `date_of_hiring`, `years_of_service`, `salary`, `specialty`, `created_at`) VALUES
(1, 'Charles', 'Olusoji', 'Charles', 'Olusoji', 'Charles', 'Olusoji', '07026790425', '07026790425', 'programmer', 'trader', 'some address', 'm', '2023-02-10', 'Ikorodu', '2023-02-10', 2, 150000.00, 'mobile and web development', '2023-02-11 21:48:40');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `sex` varchar(1) NOT NULL,
  `date_of_birth` date NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `leads` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `passkey` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_no` varchar(255) NOT NULL,
  `profile_avatar` varchar(255) NOT NULL,
  `reg_status` varchar(1) NOT NULL COMMENT '0-application-form-payment, 1-application-form, 2-select-course, 3-course-payment',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `application_form_payments`
--
ALTER TABLE `application_form_payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `course_lookup`
--
ALTER TABLE `course_lookup`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `course_lookup_ibfk_2` (`user_id`);

--
-- Indexes for table `course_payments`
--
ALTER TABLE `course_payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `deposits`
--
ALTER TABLE `deposits`
  ADD PRIMARY KEY (`deposit_id`);

--
-- Indexes for table `guardians`
--
ALTER TABLE `guardians`
  ADD PRIMARY KEY (`guardian_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `score_records`
--
ALTER TABLE `score_records`
  ADD PRIMARY KEY (`score_id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `staffs`
--
ALTER TABLE `staffs`
  ADD PRIMARY KEY (`staff_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `application_form_payments`
--
ALTER TABLE `application_form_payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `course_lookup`
--
ALTER TABLE `course_lookup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `course_payments`
--
ALTER TABLE `course_payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `deposits`
--
ALTER TABLE `deposits`
  MODIFY `deposit_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `guardians`
--
ALTER TABLE `guardians`
  MODIFY `guardian_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `score_records`
--
ALTER TABLE `score_records`
  MODIFY `score_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staffs`
--
ALTER TABLE `staffs`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `application_form_payments`
--
ALTER TABLE `application_form_payments`
  ADD CONSTRAINT `application_form_payments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staffs` (`staff_id`);

--
-- Constraints for table `course_lookup`
--
ALTER TABLE `course_lookup`
  ADD CONSTRAINT `course_lookup_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`),
  ADD CONSTRAINT `course_lookup_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `course_payments`
--
ALTER TABLE `course_payments`
  ADD CONSTRAINT `course_payments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `course_payments_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`);

--
-- Constraints for table `guardians`
--
ALTER TABLE `guardians`
  ADD CONSTRAINT `guardians_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`);

--
-- Constraints for table `score_records`
--
ALTER TABLE `score_records`
  ADD CONSTRAINT `score_records_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`),
  ADD CONSTRAINT `score_records_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
