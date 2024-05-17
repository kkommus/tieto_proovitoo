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
-- Tabeli struktuur tabelile `restoranid`
--

CREATE TABLE `restoranid` (
  `id` int(11) NOT NULL,
  `nimi` varchar(50) NOT NULL,
  `asukoht` text NOT NULL,
  `hinnang` decimal(3,1) NOT NULL,
  `restorani_id` int(11) NOT NULL,
  `kordade_arv` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Andmete tõmmistamine tabelile `restoranid`
--

INSERT INTO `restoranid` (`id`, `nimi`, `asukoht`, `hinnang`, `restorani_id`, `kordade_arv`) VALUES
(1, 'Rowe-Simonis', 'Poisoning by oth estrogens and progestogens, accidental', 6.1, 1, 91),
(2, 'Wisozk LLC', 'Contracture of muscle, unspecified upper arm', 7.9, 2, 83),
(3, 'Hane-Keeling', 'Obst labor due to incmpl rotation of fetal head, fetus 1', 9.6, 3, 68),
(4, 'Hammes-Olson', 'Toxic effect of soaps, intentional self-harm, subs encntr', 7.1, 4, 13),
(5, 'Hettinger, Bailey and Dach', 'Familial chondrocalcinosis', 5.6, 5, 79),
(6, 'Torphy-Miller', 'Pedl cyc pasngr injured in clsn w rail trn/veh nontraf, init', 5.7, 6, 97),
(7, 'Reichert LLC', 'Partial traumatic amputation of one unsp lesser toe, subs', 5.5, 7, 95),
(8, 'Brakus-Hermiston', 'Hypertrophy of bone, right ulna', 3.0, 8, 85),
(9, 'Greenfelder Group', 'Inj unsp muscle, fascia and tendon at wrist and hand level', 3.0, 9, 64),
(10, 'Schaden, O\'Connell and Nitzsche', 'Kaposi\'s sarcoma of soft tissue', 2.8, 10, 80),
(11, 'Weber, Funk and Larson', 'Coma scale, best motor response, none, unspecified time', 4.6, 11, 85),
(12, 'Kunde, Fritsch and Ernser', 'Laceration w/o fb of r idx fngr w/o damage to nail, sequela', 8.7, 12, 59),
(13, 'Lakin, Dietrich and Windler', 'Unspecified trochanteric fracture of femur', 4.2, 13, 84),
(14, 'Klein, Wiegand and Hirthe', 'Disp fx of head of unsp rad, 7thN', 7.1, 14, 64),
(15, 'McLaughlin LLC', 'Athscl native arteries of extrm w gangrene, bilateral legs', 4.6, 15, 43),
(16, 'Murphy and Sons', 'Poisoning by digestants, assault', 9.8, 16, 66),
(17, 'Emmerich-Erdman', 'Passenger of special construct vehicle injured in traf, init', 8.0, 17, 34),
(18, 'Daniel-Marvin', 'Pasngr in 3-whl mv injured in clsn w pedl cyc in traf, init', 4.8, 18, 15),
(19, 'Pfeffer, Crist and O\'Kon', 'Person outside special industrial vehicle injured in traf', 7.6, 19, 6),
(20, 'Rolfson-Flatley', 'Cocaine abuse with cocaine-induced mood disorder', 2.8, 20, 3),
(21, 'Thiel-Jast', 'Bacterial infection, unspecified', 3.1, 21, 46),
(22, 'Rohan-Cronin', 'Other branchial cleft malformations', 5.3, 22, 29),
(23, 'Murray LLC', 'Primary cough headache', 8.4, 23, 39),
(24, 'Fritsch and Sons', 'Abnormal involuntary movements', 6.0, 24, 67),
(25, 'Graham-Klein', 'Personal history of oth diseases of the female genital tract', 4.2, 25, 11),
(26, 'Pfeffer Group', 'Fracture of subcondylar process of left mandible', 5.9, 26, 69),
(27, 'Wisoky-Dicki', 'Oth forn object in resp tract, part unsp cause oth inj, init', 7.3, 27, 46),
(28, 'DuBuque, Wintheiser and Schuster', 'Blister (nonthermal) of unspecified part of head, sequela', 6.0, 28, 61),
(29, 'Schmeler-Hermiston', 'Burn 2nd deg mul sites of right lower limb, ex ank/ft, sqla', 3.9, 29, 40),
(30, 'Oberbrunner, Considine and Nitzsche', 'Riboflavin deficiency', 5.4, 30, 28),
(31, 'Russel-Legros', 'Juvenile osteochondrosis of patella', 7.3, 31, 55),
(32, 'Gerhold, Jenkins and Wuckert', 'Corrosion of second degree of left knee, initial encounter', 2.1, 32, 32),
(33, 'Spencer, Harris and Littel', 'Toxic effect of unspecified spider venom, assault', 4.4, 33, 92),
(34, 'Kessler-Kautzer', 'Osteochondrosis (juvenile) of metacarpal heads, unsp hand', 2.2, 34, 31),
(35, 'Kautzer-Wilderman', 'Oth fx low end l ulna, 7thR', 6.2, 35, 29),
(36, 'Haag-Lynch', 'Insect bite (nonvenomous) of right hand, subs encntr', 8.0, 36, 50),
(37, 'MacGyver-Cummings', 'Sprain of unspecified sternoclavicular joint, subs encntr', 4.5, 37, 59),
(38, 'Hills Inc', 'Nondisp fx of med condyle of unsp tibia, 7thQ', 5.8, 38, 14),
(39, 'Fisher, Sanford and O\'Reilly', 'Cystocele', 8.7, 39, 14),
(40, 'Ortiz Inc', 'Cont preg aft elctv fetl rdct of one fts or more, third tri', 8.0, 40, 60),
(41, 'Gleichner Group', 'Nondisp fx of med malleolus of l tibia, 7thC', 6.3, 41, 79),
(42, 'Hintz-Rogahn', 'Explosion of other materials', 7.6, 42, 57),
(43, 'Hodkiewicz Inc', 'Explosion and rupture of air tank, sequela', 5.4, 43, 18),
(44, 'Nicolas-Kautzer', 'Inj conjunctiva and corneal abras w/o fb, left eye, sequela', 2.0, 44, 69),
(45, 'Osinski, Bergstrom and Gislason', 'Benign neoplasm of right epididymis', 9.7, 45, 12),
(46, 'Gulgowski-Yundt', 'Acute maxillary sinusitis, unspecified', 5.9, 46, 50),
(47, 'Runte, Toy and Runolfsson', 'Corros 2nd deg mul sites of shldr/up lmb, ex wrs/hnd, sqla', 7.1, 47, 54),
(48, 'Gerlach, Abernathy and Jerde', 'Nondisp seg fx shaft of l femur, subs for clos fx w nonunion', 8.3, 48, 15),
(49, 'Hammes Inc', 'Wrist drop (acquired)', 9.6, 49, 44),
(50, 'Lang and Sons', 'Puncture wound w foreign body of right buttock, init encntr', 4.7, 50, 11);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
