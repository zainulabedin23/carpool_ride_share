-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 19, 2023 at 04:14 PM
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
-- Database: `ride-share`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `UserName` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `UserName`, `Password`) VALUES
(1, 'admin', '5c428d8875d2948607f3e3fe134d71b4');

-- --------------------------------------------------------

--
-- Table structure for table `car`
--

CREATE TABLE `car` (
  `driver_id` int(255) NOT NULL,
  `car_no` varchar(255) NOT NULL,
  `car_model` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `car`
--

INSERT INTO `car` (`driver_id`, `car_no`, `car_model`) VALUES
(13, '12345', 'suzuki');

-- --------------------------------------------------------

--
-- Table structure for table `carsharetrips`
--

CREATE TABLE `carsharetrips` (
  `trip_id` int(255) NOT NULL,
  `user_id` int(255) DEFAULT NULL,
  `departure` char(30) DEFAULT NULL,
  `departurecoord` char(30) DEFAULT NULL,
  `destination` char(30) DEFAULT NULL,
  `destinationcoord` char(30) DEFAULT NULL,
  `price` char(10) DEFAULT NULL,
  `seatsavailable` char(2) DEFAULT NULL,
  `regular` char(1) DEFAULT NULL,
  `date` char(20) DEFAULT NULL,
  `time` char(10) DEFAULT NULL,
  `monday` char(1) DEFAULT NULL,
  `tuesday` char(1) DEFAULT NULL,
  `wednesday` char(1) DEFAULT NULL,
  `thursday` char(1) DEFAULT NULL,
  `friday` char(1) DEFAULT NULL,
  `saturday` char(1) DEFAULT NULL,
  `sunday` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carsharetrips`
--

INSERT INTO `carsharetrips` (`trip_id`, `user_id`, `departure`, `departurecoord`, `destination`, `destinationcoord`, `price`, `seatsavailable`, `regular`, `date`, `time`, `monday`, `tuesday`, `wednesday`, `thursday`, `friday`, `saturday`, `sunday`) VALUES
(14, 4, 'mumbai', NULL, 'pune', NULL, '1000', '5', 'N', 'Tue 19 Sep, 2023', '03:10', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 3, 'indore', NULL, 'sanavad', NULL, '200', '4', 'N', 'Tue 26 Sep, 2023', '01:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 5, 'indore', NULL, 'ujjain', NULL, '500', '4', 'N', 'Wed 20 Sep, 2023', '18:02', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(23, 13, 'Mhow', NULL, 'dewas', NULL, '199', '2', 'N', 'Tue 26 Sep, 2023', '13:55', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(26, 13, 'Mhow', NULL, 'Indore', NULL, '50', '2', 'N', 'Tue 26 Sep, 2023', '14:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(27, 13, 'Rajwada', NULL, 'Bangali Square', NULL, '50', '2', 'N', 'Fri 29 Sep, 2023', '18:15', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(29, 12, 'ujjain', NULL, 'indore', NULL, '120', '2', 'Y', NULL, '10:10', '1', '1', '1', '1', '1', '1', '1'),
(30, 13, 'indore', NULL, 'ujjain', NULL, '120', '3', 'Y', NULL, '22:15', '1', '1', '1', '1', '1', '1', '1'),
(31, 12, 'Mhow', NULL, 'Vijay Nagar', NULL, '120', '4', 'Y', NULL, '22:35', '1', '1', '1', '1', '1', '1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `contact_form_data`
--

CREATE TABLE `contact_form_data` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `query` text NOT NULL,
  `submission_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_form_data`
--

INSERT INTO `contact_form_data` (`id`, `name`, `phone`, `query`, `submission_time`) VALUES
(3, 'Mohammed', '0000011111', 'kmdkl', '2023-10-03 16:02:26'),
(6, 'Zainul ', '0000011111', 'hello', '2023-10-03 16:08:13'),
(9, 'Mohammed', '0000011111', 'hello', '2023-10-16 11:06:24'),
(12, 'Mohammed', '0000011111', 'hello', '2023-10-16 11:12:23');

-- --------------------------------------------------------

--
-- Table structure for table `driver`
--

CREATE TABLE `driver` (
  `driver_id` int(255) NOT NULL,
  `license_no` varchar(255) NOT NULL,
  `rating` int(10) DEFAULT NULL,
  `license_img` varchar(255) NOT NULL,
  `verified` enum('verified','not verified') DEFAULT 'verified'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `driver`
--

INSERT INTO `driver` (`driver_id`, `license_no`, `rating`, `license_img`, `verified`) VALUES
(2, 'MP09-123456789101', 3, '', 'verified'),
(13, '832984712345', 0, 'uploads/MY2.jpg', 'not verified');

-- --------------------------------------------------------

--
-- Table structure for table `review_table`
--

CREATE TABLE `review_table` (
  `review_id` int(255) NOT NULL,
  `driver_id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `user_rating` int(255) NOT NULL,
  `user_review` text NOT NULL,
  `added_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `review_table`
--

INSERT INTO `review_table` (`review_id`, `driver_id`, `user_id`, `user_rating`, `user_review`, `added_on`) VALUES
(19, 4, 3, 0, 'sdfasdfdsafsdffb', '2023-10-28 08:09:33'),
(20, 3, 5, 0, 'sdafsdfadsf', '2023-10-28 08:18:36'),
(21, 3, 3, 4, 'ehdg', '2023-10-28 08:55:53'),
(22, 5, 3, 3, 'sdfdsafad', '2023-10-28 08:56:59'),
(23, 5, 3, 2, 'sdfdsafad', '2023-10-28 08:57:53'),
(24, 6, 3, 5, 'sdfdsafad', '2023-10-28 08:57:57'),
(25, 4, 3, 1, 'asdfasdf', '2023-10-28 08:59:12'),
(26, 5, 4, 3, 'good experience', '2023-10-28 11:09:48'),
(29, 13, 12, 4, 'Good', '2023-12-19 15:05:07'),
(30, 13, 12, 3, 'Good', '2023-12-19 15:06:15');

-- --------------------------------------------------------

--
-- Table structure for table `riderequest`
--

CREATE TABLE `riderequest` (
  `request_id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `driver_id` int(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `trip_id` int(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `riderequest`
--

INSERT INTO `riderequest` (`request_id`, `user_id`, `driver_id`, `status`, `trip_id`) VALUES
(175, 13, 12, 'accepted', 29),
(176, 12, 13, 'accepted', 30);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(255) NOT NULL,
  `first_name` char(30) NOT NULL,
  `last_name` char(30) NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(64) DEFAULT NULL,
  `activation` char(32) DEFAULT NULL,
  `gender` char(6) DEFAULT NULL,
  `phonenumber` char(15) DEFAULT NULL,
  `moreinformation` varchar(300) DEFAULT NULL,
  `profilepicture` varchar(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `username`, `email`, `password`, `activation`, `gender`, `phonenumber`, `moreinformation`, `profilepicture`) VALUES
(1, 'demo', 'demo', 'demo@123', 'demo@gmail.com', 'ff96673205dc722320598ebf8f88325b2ac56922d5a2164b5765868274bc0d73', 'activated', 'male', '1234567891', 'hello ', NULL),
(2, 'kunal', 'mali', 'demo1@123', 'kunal@gmail.com', 'ff96673205dc722320598ebf8f88325b2ac56922d5a2164b5765868274bc0d73', 'activated', 'male', '1234567891', 'hello', NULL),
(3, 'Ramesh', 'Shah', 'Ramesh@123', 'ramesh@gmail.com', 'ff96673205dc722320598ebf8f88325b2ac56922d5a2164b5765868274bc0d73', 'activated', 'male', '834971', 'hello', NULL),
(4, 'suresh', 'kumar', 'suresh@123', 'suresh@gmail.com', 'ff96673205dc722320598ebf8f88325b2ac56922d5a2164b5765868274bc0d73', 'activated', 'male', '1235', 'helolo', NULL),
(5, 'pujan', 'parekh', 'pujan@123', 'pujan@gmail.com', 'ff96673205dc722320598ebf8f88325b2ac56922d5a2164b5765868274bc0d73', 'activated', 'male', '1234567', 'hi', NULL),
(6, 'Gopal', 'Radhawami', 'Gopal', 'gopal@gmail.com', 'ff96673205dc722320598ebf8f88325b2ac56922d5a2164b5765868274bc0d73', 'activated', 'male', '98745263', 'hi i am gopal', NULL),
(7, 'Divyansh', 'shrivas', 'divyansh', 'divyansh@gmail.com', 'ff96673205dc722320598ebf8f88325b2ac56922d5a2164b5765868274bc0d73', 'activated', 'male', '9513577412', 'hi i am divyansh', NULL),
(8, 'zainul', 'fda', 'zainul123', 'd@gmail.com', 'ff96673205dc722320598ebf8f88325b2ac56922d5a2164b5765868274bc0d73', 'activated', 'male', '01234567891', 'hello', NULL),
(9, 'sasa', 'sas', 'asa', 'hello123@gmail.com', '5552074bd7337945e3be1c4713a009b1feabd7bcb22ada6d10e5f79535d2c0c0', 'activated', 'male', '321113123', 'fafa', NULL),
(11, 'h', 'h', 'zainul', 'zainul@gmail.com', '5552074bd7337945e3be1c4713a009b1feabd7bcb22ada6d10e5f79535d2c0c0', 'activated', 'male', '0000000000', 'gjk', NULL),
(12, 'm', 'hw', 'Mohammed', 'hoshangabadwalam@gmail.com', 'f8aa14da2301e201e817f5b8667a36bb40c8ca49da69b3470a74d0f4ec194961', 'activated', 'male', '0000000000', 'hii', 'profilepicture/31616a6a411df153eebdc2613fc1f1e1.jpg'),
(13, 'zain', 'Abedin', 'zainul', 'abedinz427@gmail.com', 'f8aa14da2301e201e817f5b8667a36bb40c8ca49da69b3470a74d0f4ec194961', 'activated', 'male', '0000000000', 'hello', 'profilepicture/df3f4bee7f8f4b89c995645bec1eeb51.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `car`
--
ALTER TABLE `car`
  ADD PRIMARY KEY (`driver_id`,`car_no`);

--
-- Indexes for table `carsharetrips`
--
ALTER TABLE `carsharetrips`
  ADD PRIMARY KEY (`trip_id`),
  ADD KEY `user_id_foreign_key` (`user_id`);

--
-- Indexes for table `contact_form_data`
--
ALTER TABLE `contact_form_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `driver`
--
ALTER TABLE `driver`
  ADD PRIMARY KEY (`driver_id`);

--
-- Indexes for table `review_table`
--
ALTER TABLE `review_table`
  ADD PRIMARY KEY (`review_id`);

--
-- Indexes for table `riderequest`
--
ALTER TABLE `riderequest`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `driver_id foreign key` (`driver_id`),
  ADD KEY `trip_id foreign key` (`trip_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `carsharetrips`
--
ALTER TABLE `carsharetrips`
  MODIFY `trip_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `contact_form_data`
--
ALTER TABLE `contact_form_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `review_table`
--
ALTER TABLE `review_table`
  MODIFY `review_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `riderequest`
--
ALTER TABLE `riderequest`
  MODIFY `request_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=177;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `car`
--
ALTER TABLE `car`
  ADD CONSTRAINT `Test` FOREIGN KEY (`driver_id`) REFERENCES `driver` (`driver_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `carsharetrips`
--
ALTER TABLE `carsharetrips`
  ADD CONSTRAINT `user_id_foreign_key` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `driver`
--
ALTER TABLE `driver`
  ADD CONSTRAINT `driver_id_fk` FOREIGN KEY (`driver_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `riderequest`
--
ALTER TABLE `riderequest`
  ADD CONSTRAINT `driver_id foreign key` FOREIGN KEY (`driver_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `riderequest_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `trip_id foreign key` FOREIGN KEY (`trip_id`) REFERENCES `carsharetrips` (`trip_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
