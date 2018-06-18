-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 18, 2018 at 05:32 PM
-- Server version: 5.6.34-log
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `games`
--

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE `games` (
  `id` int(11) NOT NULL,
  `name` varchar(60) DEFAULT NULL,
  `platform` varchar(35) DEFAULT NULL,
  `release_date` varchar(10) DEFAULT NULL,
  `description` varchar(502) DEFAULT NULL,
  `user_rating` int(1) DEFAULT NULL,
  `region` varchar(13) DEFAULT NULL,
  `labels` varchar(15) DEFAULT NULL,
  `genres` varchar(89) DEFAULT NULL,
  `developers` varchar(206) DEFAULT NULL,
  `publishers` varchar(158) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`id`, `name`, `platform`, `release_date`, `description`, `user_rating`, `region`, `labels`, `genres`, `developers`, `publishers`) VALUES
(1, '100% Orange Juice', 'PC', '8/14/2009', '100% Orange Juice is a goal-oriented boardgame played by OrangeJuice\'s all-star cast including characters from Acceleration of Suguri, Flying Red Barrel: A Diary of Little Aviator, Sora, and QP Shooting.  This is a world where dogs, people and machines fly through the air. In that world, a small patch of darkness was born. Infinitesimal at first, it gradually began to envelope everything...  A youth named Kai, led by the mysterious life form known as Marie Poppo, begins a journey that will span...', 0, '', 'Unplayed', 'Indie, Strategy, Turn-based strategy (TBS)', 'Orange_Juice', 'Fruitbat Factory, Orange_Juice');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=682;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
