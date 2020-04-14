-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 05, 2020 at 05:45 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hockeyfusion`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrateur`
--

CREATE TABLE `administrateur` (
  `MOT_PASSE` char(50) CHARACTER SET utf8 NOT NULL,
  `COURRIEL` char(100) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `administrateur`
--

INSERT INTO `administrateur` (`MOT_PASSE`, `COURRIEL`) VALUES
('theboss', 'theboss@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `calendrier`
--

CREATE TABLE `calendrier` (
  `ID_CALENDRIER` int(11) NOT NULL,
  `DATE_DEBUT_CALENDRIER` date NOT NULL,
  `DATE_FIN_CALENDRIER` date NOT NULL,
  `NBR_EQUIPES` int(11) NOT NULL,
  `NBR_PARTIES` int(11) DEFAULT NULL,
  `ID_TOURNOI` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `calendrier`
--

INSERT INTO `calendrier` (`ID_CALENDRIER`, `DATE_DEBUT_CALENDRIER`, `DATE_FIN_CALENDRIER`, `NBR_EQUIPES`, `NBR_PARTIES`, `ID_TOURNOI`) VALUES
(25, '2020-04-14', '2020-05-21', 5, 20, 57);

-- --------------------------------------------------------

--
-- Table structure for table `equipe`
--

CREATE TABLE `equipe` (
  `ID_EQUIPE` int(11) NOT NULL,
  `NOM_EQUIPE` char(50) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `equipe`
--

INSERT INTO `equipe` (`ID_EQUIPE`, `NOM_EQUIPE`) VALUES
(227, 'Les Muffins Anglais'),
(228, 'Les Ustensiles'),
(229, 'Les Irlandais Roux'),
(230, 'Les Covid-19'),
(231, 'Les Papillons Viriles'),
(232, 'Les XAMPP'),
(233, 'Les Pogos'),
(234, 'Les Croquettes'),
(235, 'Les Chameaux');

-- --------------------------------------------------------

--
-- Table structure for table `fiche`
--

CREATE TABLE `fiche` (
  `ID_FICHE` int(11) NOT NULL,
  `NB_VICTOIRES` int(11) DEFAULT NULL,
  `NB_DEFAITES` int(11) DEFAULT NULL,
  `NB_NULLES` int(11) DEFAULT NULL,
  `ID_EQUIPE` int(11) NOT NULL,
  `ID_TOURNOI` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fiche`
--

INSERT INTO `fiche` (`ID_FICHE`, `NB_VICTOIRES`, `NB_DEFAITES`, `NB_NULLES`, `ID_EQUIPE`, `ID_TOURNOI`) VALUES
(226, 1, 0, 1, 227, 57),
(233, 0, 1, 0, 231, 57),
(234, 0, 0, 1, 233, 57),
(235, 1, 0, 0, 229, 57),
(236, 0, 1, 0, 228, 57);

-- --------------------------------------------------------

--
-- Table structure for table `participant`
--

CREATE TABLE `participant` (
  `ID_EQUIPE` int(11) NOT NULL,
  `ID_TOURNOI` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `participant`
--

INSERT INTO `participant` (`ID_EQUIPE`, `ID_TOURNOI`) VALUES
(227, 57),
(228, 57),
(229, 57),
(231, 57),
(233, 57);

-- --------------------------------------------------------

--
-- Table structure for table `partie`
--

CREATE TABLE `partie` (
  `ID_PARTIE` int(11) NOT NULL,
  `JOUR_PARTIE` date NOT NULL,
  `DEBUT_PARTIE` time NOT NULL,
  `ID_TOURNOI` int(11) NOT NULL,
  `ID_EQUIPE_LOCALE` int(11) NOT NULL,
  `ID_EQUIPE_ADVERSE` int(11) NOT NULL,
  `BUTS_LOCAUX` int(11) DEFAULT NULL,
  `BUTS_ADVERSES` int(11) DEFAULT NULL,
  `ID_CALENDRIER` int(11) NOT NULL,
  `ID_PATINOIRE` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `partie`
--

INSERT INTO `partie` (`ID_PARTIE`, `JOUR_PARTIE`, `DEBUT_PARTIE`, `ID_TOURNOI`, `ID_EQUIPE_LOCALE`, `ID_EQUIPE_ADVERSE`, `BUTS_LOCAUX`, `BUTS_ADVERSES`, `ID_CALENDRIER`, `ID_PATINOIRE`) VALUES
(29, '2020-04-14', '08:00:00', 57, 227, 228, 8, 5, 25, 3),
(30, '2020-04-14', '10:00:00', 57, 229, 231, 4, 2, 25, 2),
(31, '2020-04-16', '19:30:00', 57, 233, 227, 2, 2, 25, 5);

-- --------------------------------------------------------

--
-- Table structure for table `patinoire`
--

CREATE TABLE `patinoire` (
  `ID_PATINOIRE` int(11) NOT NULL,
  `NOM_ARENA` char(50) CHARACTER SET utf8 NOT NULL,
  `VILLE_ARENA` char(50) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `patinoire`
--

INSERT INTO `patinoire` (`ID_PATINOIRE`, `NOM_ARENA`, `VILLE_ARENA`) VALUES
(1, 'Patinoire Chez Roger', 'Matane'),
(2, 'Glace des Bleuets', 'Chicoutimi'),
(3, 'Patinoire des Warriors', 'Kanawake'),
(4, 'Glace des Blokes', 'Ottawa'),
(5, 'Patinoire des Gagnants', 'Montreal'),
(6, 'Patinoire des Wannabe', 'Laval'),
(7, 'Lac des Phoques', 'Iqualuit'),
(8, 'Patinoire des Bizarres', 'Trois-Rivieres');

-- --------------------------------------------------------

--
-- Table structure for table `resultat`
--

CREATE TABLE `resultat` (
  `ID_RESULTAT` int(11) NOT NULL,
  `BUTS_LOCAUX` int(11) DEFAULT NULL,
  `BUTS_ADVERSES` int(11) DEFAULT NULL,
  `ID_PARTIE` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `resultat`
--

INSERT INTO `resultat` (`ID_RESULTAT`, `BUTS_LOCAUX`, `BUTS_ADVERSES`, `ID_PARTIE`) VALUES
(27, 8, 5, 29),
(28, 4, 2, 30),
(29, 2, 2, 31);

-- --------------------------------------------------------

--
-- Table structure for table `tournoi`
--

CREATE TABLE `tournoi` (
  `ID_TOURNOI` int(11) NOT NULL,
  `NOM_TOURNOI` char(50) CHARACTER SET utf8 NOT NULL,
  `NBR_MAX_EQUIPES` int(11) DEFAULT NULL,
  `NBR_MIN_EQUIPES` int(10) DEFAULT NULL,
  `DATE_DEBUT_TOURNOI` date DEFAULT NULL,
  `DATE_FIN_TOURNOI` date DEFAULT NULL,
  `DATE_LIMITE_INSCRIPTION` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tournoi`
--

INSERT INTO `tournoi` (`ID_TOURNOI`, `NOM_TOURNOI`, `NBR_MAX_EQUIPES`, `NBR_MIN_EQUIPES`, `DATE_DEBUT_TOURNOI`, `DATE_FIN_TOURNOI`, `DATE_LIMITE_INSCRIPTION`) VALUES
(57, 'Championnat 2020', 6, 4, '2020-04-07', '2020-05-21', '2020-03-29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrateur`
--
ALTER TABLE `administrateur`
  ADD PRIMARY KEY (`COURRIEL`);

--
-- Indexes for table `calendrier`
--
ALTER TABLE `calendrier`
  ADD PRIMARY KEY (`ID_CALENDRIER`),
  ADD KEY `tournoi_calendrier_fk` (`ID_TOURNOI`);

--
-- Indexes for table `equipe`
--
ALTER TABLE `equipe`
  ADD PRIMARY KEY (`ID_EQUIPE`);

--
-- Indexes for table `fiche`
--
ALTER TABLE `fiche`
  ADD PRIMARY KEY (`ID_FICHE`),
  ADD KEY `fiche_participant_fk` (`ID_EQUIPE`,`ID_TOURNOI`);

--
-- Indexes for table `participant`
--
ALTER TABLE `participant`
  ADD PRIMARY KEY (`ID_EQUIPE`,`ID_TOURNOI`),
  ADD KEY `participant_tournoi_fk` (`ID_TOURNOI`);

--
-- Indexes for table `partie`
--
ALTER TABLE `partie`
  ADD PRIMARY KEY (`ID_PARTIE`),
  ADD KEY `equipe_local_partie_fk` (`ID_EQUIPE_LOCALE`,`ID_TOURNOI`),
  ADD KEY `equipe_adverse_partie_fk` (`ID_EQUIPE_ADVERSE`,`ID_TOURNOI`),
  ADD KEY `calendrier_partie_fk` (`ID_CALENDRIER`),
  ADD KEY `patinoire_partie_fk` (`ID_PATINOIRE`);

--
-- Indexes for table `patinoire`
--
ALTER TABLE `patinoire`
  ADD PRIMARY KEY (`ID_PATINOIRE`);

--
-- Indexes for table `resultat`
--
ALTER TABLE `resultat`
  ADD PRIMARY KEY (`ID_RESULTAT`),
  ADD KEY `partie_resultat_fk` (`ID_PARTIE`);

--
-- Indexes for table `tournoi`
--
ALTER TABLE `tournoi`
  ADD PRIMARY KEY (`ID_TOURNOI`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `calendrier`
--
ALTER TABLE `calendrier`
  MODIFY `ID_CALENDRIER` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `equipe`
--
ALTER TABLE `equipe`
  MODIFY `ID_EQUIPE` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=236;

--
-- AUTO_INCREMENT for table `fiche`
--
ALTER TABLE `fiche`
  MODIFY `ID_FICHE` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=237;

--
-- AUTO_INCREMENT for table `partie`
--
ALTER TABLE `partie`
  MODIFY `ID_PARTIE` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `patinoire`
--
ALTER TABLE `patinoire`
  MODIFY `ID_PATINOIRE` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `resultat`
--
ALTER TABLE `resultat`
  MODIFY `ID_RESULTAT` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `tournoi`
--
ALTER TABLE `tournoi`
  MODIFY `ID_TOURNOI` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `calendrier`
--
ALTER TABLE `calendrier`
  ADD CONSTRAINT `tournoi_calendrier_fk` FOREIGN KEY (`ID_TOURNOI`) REFERENCES `tournoi` (`ID_TOURNOI`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `fiche`
--
ALTER TABLE `fiche`
  ADD CONSTRAINT `fiche_participant_fk` FOREIGN KEY (`ID_EQUIPE`,`ID_TOURNOI`) REFERENCES `participant` (`ID_EQUIPE`, `ID_TOURNOI`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `participant`
--
ALTER TABLE `participant`
  ADD CONSTRAINT `participant_equipe_fk` FOREIGN KEY (`ID_EQUIPE`) REFERENCES `equipe` (`ID_EQUIPE`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `participant_tournoi_fk` FOREIGN KEY (`ID_TOURNOI`) REFERENCES `tournoi` (`ID_TOURNOI`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `partie`
--
ALTER TABLE `partie`
  ADD CONSTRAINT `calendrier_partie_fk` FOREIGN KEY (`ID_CALENDRIER`) REFERENCES `calendrier` (`ID_CALENDRIER`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `equipe_adverse_partie_fk` FOREIGN KEY (`ID_EQUIPE_ADVERSE`,`ID_TOURNOI`) REFERENCES `participant` (`ID_EQUIPE`, `ID_TOURNOI`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `equipe_local_partie_fk` FOREIGN KEY (`ID_EQUIPE_LOCALE`,`ID_TOURNOI`) REFERENCES `participant` (`ID_EQUIPE`, `ID_TOURNOI`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `patinoire_partie_fk` FOREIGN KEY (`ID_PATINOIRE`) REFERENCES `patinoire` (`ID_PATINOIRE`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `resultat`
--
ALTER TABLE `resultat`
  ADD CONSTRAINT `partie_resultat_fk` FOREIGN KEY (`ID_PARTIE`) REFERENCES `partie` (`ID_PARTIE`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
