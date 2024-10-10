-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 04, 2024 at 05:16 AM
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
-- Database: `kanji_memory_master`
--

-- --------------------------------------------------------

--
-- Table structure for table `flashcard_deck`
--

CREATE TABLE `flashcard_deck` (
  `deck_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `deckname` varchar(255) NOT NULL,
  `description` mediumtext DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`deck_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `flashcard_deck`
--

INSERT INTO flashcard_deck (deck_id, user_id, deckname, description, created_at) VALUES
(1, 1, 'Basic Japanese Vocabulary', 'Deck for basic Japanese vocabulary', '2024-09-27 09:00:00'),
(2, 1, 'Advanced Japanese Vocabulary', 'Deck for advanced Japanese vocabulary', '2024-09-27 09:05:00'),
(3, 2, 'Japanese Kanji Characters', 'Deck for learning Japanese Kanji characters', '2024-09-27 09:10:00');

-- --------------------------------------------------------


--
-- Table structure for table `flashcard`
--

CREATE TABLE `flashcard` (
  `flashcard_id` int(11) NOT NULL AUTO_INCREMENT,
  `deck_id` int(11) DEFAULT NULL,
  `f_term` varchar(255) NOT NULL,
  `f_definition` text NOT NULL,
  `f_image_url` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`flashcard_id`),
  FOREIGN KEY (`deck_id`) REFERENCES `flashcard_deck`(`deck_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;


--
-- Dumping data for table `flashcard`
--

INSERT INTO `flashcard` (`flashcard_id`, `deck_id`, `f_term`, `f_definition`, `f_image_url`, `created_at`) VALUES
(1, 1, 'こんにちは', 'Hello', '', '2024-09-27 09:13:01'),
(2, 1, 'ありがとう', 'Thank you', '', '2024-09-27 09:13:33'),
(3, 1, 'さようなら', 'Goodbye', '', '2024-10-04 10:02:44'),
(4, 2, '勉強', 'Study', '', '2024-10-04 10:02:49'),
(5, 2, '仕事', 'Work', '', '2024-10-04 10:10:11'),
(6, 3, '漢字', 'Kanji', '', '2024-10-04 10:15:22'),
(7, 3, '日本', 'Japan', '', '2024-10-04 10:20:33');

-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

CREATE TABLE `quiz` (
  `quiz_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` mediumtext DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_item`
--

CREATE TABLE `quiz_item` (
  `item_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `question` mediumtext DEFAULT NULL,
  `correct_answer` varchar(255) NOT NULL,
  `option_A` varchar(255) NOT NULL,
  `option_B` varchar(255) NOT NULL,
  `option_C` varchar(255) NOT NULL,
  `option_D` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_result`
--

CREATE TABLE `quiz_result` (
  `result_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `correct_answers` int(11) NOT NULL,
  `score` double NOT NULL,
  `complete_status` tinyint(1) NOT NULL DEFAULT 0,
  `quiz_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_ID` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `date_of_birth` date NOT NULL,
  `isAdmin` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `flashcard`
--
ALTER TABLE `flashcard`
  ADD PRIMARY KEY (`flashcard_id`),
  ADD KEY `deck_id` (`deck_id`);

--
-- Indexes for table `flashcard_deck`
--
ALTER TABLE `flashcard_deck`
  ADD PRIMARY KEY (`deck_id`);

--
-- Indexes for table `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`quiz_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `quiz_item`
--
ALTER TABLE `quiz_item`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `quiz_result`
--
ALTER TABLE `quiz_result`
  ADD KEY `quiz_id` (`quiz_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_ID`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `flashcard`
--
ALTER TABLE `flashcard`
  MODIFY `flashcard_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `flashcard_deck`
--
ALTER TABLE `flashcard_deck`
  MODIFY `deck_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quiz`
--
ALTER TABLE `quiz`
  MODIFY `quiz_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quiz_item`
--
ALTER TABLE `quiz_item`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `flashcard`
--
ALTER TABLE `flashcard`
  ADD CONSTRAINT `flashcard_ibfk_1` FOREIGN KEY (`deck_id`) REFERENCES `flashcard_deck` (`deck_id`);

--
-- Constraints for table `quiz`
--
ALTER TABLE `quiz`
  ADD CONSTRAINT `quiz_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_ID`);

--
-- Constraints for table `quiz_item`
--
ALTER TABLE `quiz_item`
  ADD CONSTRAINT `quiz_item_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`quiz_id`);

--
-- Constraints for table `quiz_result`
--
ALTER TABLE `quiz_result`
  ADD CONSTRAINT `quiz_result_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`quiz_id`),
  ADD CONSTRAINT `quiz_result_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
