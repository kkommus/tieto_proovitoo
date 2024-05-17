-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Loomise aeg: Aprill 17, 2024 kell 08:26 PL
-- Serveri versioon: 10.4.32-MariaDB
-- PHP versioon: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Andmebaas: `restoranid`
--

-- --------------------------------------------------------

--
-- Tabeli struktuur tabelile `hinnangud`
--

CREATE TABLE `hinnangud` (
  `id` int(11) NOT NULL,
  `nimi` varchar(50) DEFAULT NULL,
  `kommentaar` text DEFAULT NULL,
  `hinnang` decimal(3,1) DEFAULT NULL,
  `restorani_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Andmete tõmmistamine tabelile `hinnangud`
--

INSERT INTO `hinnangud` (`id`, `nimi`, `kommentaar`, `hinnang`, `restorani_id`) VALUES
(1, 'Keiti', 'sdsdsdsdsdsdsdsd', 10.0, 1),
(2, 'madis', 'mdmdmdmd', 6.0, 3),
(3, 'buuuuu', 'vuuuuu', 7.0, 7),
(4, 'Keiti', 'sssssssssssss', 7.0, 4),
(5, 'eeee', 'cccccccccccccccccccccccc', 7.0, 8),
(6, 'ccccccccc', 'ccccccccccccccccccc', 6.0, 1),
(7, 'peedu', 'ddddd', 8.0, 1),
(8, 'seeedddeee', 'dfsfsdsdsdsd', 6.0, 24),
(9, 'mmmmmmmmmmmm', 'mmmmmmmmmmmm', 7.0, 5),
(10, 'uuuuuuuuuuu', 'uuuuuuuuuuuuu', 6.0, 7);

--
-- Indeksid tõmmistatud tabelitele
--

--
-- Indeksid tabelile `hinnangud`
--
ALTER TABLE `hinnangud`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT tõmmistatud tabelitele
--

--
-- AUTO_INCREMENT tabelile `hinnangud`
--
ALTER TABLE `hinnangud`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

