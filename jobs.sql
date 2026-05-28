-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 27, 2026 at 12:08 PM
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
-- Database: `jobs`
--

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int(11) NOT NULL,
  `job_code` varchar(20) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `salary_min` decimal(10,2) DEFAULT NULL,
  `salary_max` decimal(10,2) DEFAULT NULL,
  `skills` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `job_code`, `title`, `description`, `salary_min`, `salary_max`, `skills`) VALUES
(1, 'SD005', 'Software Developer', 'We are looking for a passionate Software Developer to join our team. The ideal candidate will have experience in web development and a strong understanding of modern programming practices. Responsibilities include developing and maintaining our digital health platforms, collaborating with cross-functional teams, and ensuring the security and reliability of our applications.', 80000.00, 100000.00, 'Proficiency in JavaScript HTML and CSS,Experience with frameworks such as React or Angular,Background in healthcare technology'),
(2, 'IS024', 'IT Support Specialist', 'We are seeking an IT Support Specialist to provide technical assistance and support to our employees. The ideal candidate will have experience in troubleshooting hardware and software issues, managing user accounts, and maintaining a secure network environment. Responsibilities include responding to user inquiries, performing routine maintenance tasks, and documenting technical issues and resolutions.', 50000.00, 70000.00, 'Strong problem-solving abilities,Excellent communication skills,Solid understanding of IT systems and protocols'),
(3, 'CA901', 'Cybersecurity Analyst', 'We are seeking a Cybersecurity Analyst to protect our digital assets and ensure the integrity of our systems. The ideal candidate will have experience in identifying and mitigating security threats, conducting vulnerability assessments, and implementing security measures. Responsibilities include monitoring security alerts, investigating incidents, and developing strategies to enhance our overall security posture.', 90000.00, 110000.00, 'Knowledge of cybersecurity principles,Experience with security tools and technologies,Ability to stay current with emerging threats'),
(4, 'WD101', 'Web Designer', 'We are looking for a creative Web Designer to create engaging and user-friendly interfaces for our digital products. The ideal candidate will have a strong portfolio of design work and experience with modern design tools. Responsibilities include collaborating with developers to implement designs, creating wireframes and mockups, and ensuring a consistent brand experience across all platforms.', 60000.00, 80000.00, 'Proficiency in design software such as Adobe Creative Suite,Understanding of user experience (UX) principles,Ability to create responsive designs');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
