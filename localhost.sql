-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Počítač: localhost
-- Vygenerováno: Pon 07. pro 2015, 17:20
-- Verze MySQL: 5.6.27
-- Verze PHP: 5.3.29

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databáze: `xknote11`
--
CREATE DATABASE `xknote11` DEFAULT CHARACTER SET latin2 COLLATE latin2_czech_cs;
USE `xknote11`;

-- --------------------------------------------------------

--
-- Struktura tabulky `compositions`
--

CREATE TABLE IF NOT EXISTS `compositions` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) COLLATE latin2_czech_cs NOT NULL,
  `Comp_Key` varchar(5) COLLATE latin2_czech_cs NOT NULL,
  `Takt` varchar(3) COLLATE latin2_czech_cs NOT NULL,
  `Tempo` int(11) NOT NULL,
  `Sm` int(11) NOT NULL COMMENT 'smycce',
  `D` int(11) NOT NULL COMMENT 'dechy',
  `Str` int(11) NOT NULL COMMENT 'strunne',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin2 COLLATE=latin2_czech_cs AUTO_INCREMENT=32 ;

--
-- Vypisuji data pro tabulku `compositions`
--

INSERT INTO `compositions` (`ID`, `Name`, `Comp_Key`, `Takt`, `Tempo`, `Sm`, `D`, `Str`) VALUES
(27, 'Pohodový večer', 'C', '2/4', 83, 20, 10, 4),
(28, 'Blouznivá nálada', 'E', '3/4', 99, 15, 5, 2),
(29, 'Poslední tanec', 'F#', '6/8', 107, 50, 20, 10),
(30, 'Půlnoční sen', 'A', '4/4', 70, 2, 1, 0),
(31, 'Slunce z rána', 'B', '2/4', 88, 10, 3, 10);

-- --------------------------------------------------------

--
-- Struktura tabulky `concert_composition`
--

CREATE TABLE IF NOT EXISTS `concert_composition` (
  `concert_ID` int(11) NOT NULL,
  `comp_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin2 COLLATE=latin2_czech_cs;

--
-- Vypisuji data pro tabulku `concert_composition`
--

INSERT INTO `concert_composition` (`concert_ID`, `comp_ID`) VALUES
(18, 4),
(18, 6),
(19, 7),
(19, 8),
(24, 6),
(42, 4),
(42, 6),
(46, 6),
(46, 9),
(47, 6),
(47, 9),
(50, 6),
(50, 9),
(54, 6),
(54, 9),
(62, 6),
(62, 9),
(89, 27),
(89, 28),
(89, 31),
(90, 27),
(90, 29),
(90, 31),
(91, 30),
(91, 31),
(92, 27),
(92, 28),
(92, 29),
(92, 30),
(92, 31),
(93, 27),
(93, 29),
(93, 30);

-- --------------------------------------------------------

--
-- Struktura tabulky `concert_musician`
--

CREATE TABLE IF NOT EXISTS `concert_musician` (
  `concert_ID` int(11) NOT NULL,
  `music_RC` varchar(11) COLLATE latin2_czech_cs NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin2 COLLATE=latin2_czech_cs;

--
-- Vypisuji data pro tabulku `concert_musician`
--

INSERT INTO `concert_musician` (`concert_ID`, `music_RC`) VALUES
(18, '23456786543'),
(18, '21474836475'),
(18, '39573482340'),
(19, '24585247931'),
(24, '21474836475'),
(25, '23456786543'),
(42, '23456786543'),
(42, '23457676981'),
(42, '24585247931'),
(46, '23456786543'),
(46, '23457676981'),
(46, '24585247931'),
(47, '23456786543'),
(47, '23457676981'),
(47, '24585247931'),
(50, '23456786543'),
(50, '23457676981'),
(50, '24585247931'),
(54, '23456786543'),
(54, '23457676981'),
(54, '24585247931'),
(62, '23457676981'),
(62, '24585247931'),
(25, '/'),
(25, '789546/7895'),
(89, '167.6600967'),
(89, '332.8130252'),
(90, '182.1144164'),
(90, '2777.137931'),
(90, '118.5487192'),
(90, '167.6600967'),
(90, '332.8130252'),
(90, '236.8402453'),
(91, '167.6600967'),
(91, '332.8130252'),
(91, '236.8402453'),
(92, '182.1144164'),
(92, '2777.137931'),
(92, '118.5487192'),
(92, '167.6600967'),
(92, '332.8130252'),
(92, '236.8402453'),
(93, '182.1144164'),
(93, '2777.137931'),
(93, '118.5487192'),
(93, '332.8130252');

-- --------------------------------------------------------

--
-- Struktura tabulky `concerts`
--

CREATE TABLE IF NOT EXISTS `concerts` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) COLLATE latin2_czech_cs NOT NULL COMMENT 'nazev koncertu',
  `Date` date NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin2 COLLATE=latin2_czech_cs AUTO_INCREMENT=94 ;

--
-- Vypisuji data pro tabulku `concerts`
--

INSERT INTO `concerts` (`ID`, `Name`, `Date`) VALUES
(89, 'Tanec světel', '2016-03-06'),
(90, 'Nový úsvit', '2016-01-05'),
(91, 'Podzimní večer', '2015-12-19'),
(92, 'Plavba oceánu', '2017-06-12'),
(93, 'Modrá modř', '2016-04-08');

-- --------------------------------------------------------

--
-- Struktura tabulky `musicians`
--

CREATE TABLE IF NOT EXISTS `musicians` (
  `Name` varchar(30) COLLATE latin2_czech_cs NOT NULL,
  `SName` varchar(50) COLLATE latin2_czech_cs NOT NULL COMMENT 'Second name',
  `RC` varchar(11) COLLATE latin2_czech_cs NOT NULL,
  `Phone` varchar(11) COLLATE latin2_czech_cs NOT NULL,
  `Email` varchar(25) COLLATE latin2_czech_cs NOT NULL,
  `Town` varchar(50) COLLATE latin2_czech_cs NOT NULL,
  `Sm` char(1) COLLATE latin2_czech_cs NOT NULL COMMENT 'umi smycec',
  `D` char(1) COLLATE latin2_czech_cs NOT NULL COMMENT 'umi dech',
  `Str` char(1) COLLATE latin2_czech_cs NOT NULL COMMENT 'umi strunny',
  PRIMARY KEY (`RC`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2 COLLATE=latin2_czech_cs;

--
-- Vypisuji data pro tabulku `musicians`
--

INSERT INTO `musicians` (`Name`, `SName`, `RC`, `Phone`, `Email`, `Town`, `Sm`, `D`, `Str`) VALUES
('Martin', 'Drna', '875424/4807', '+4208759632', 'drna@filharmonie.cz', 'Brno', 'T', 'F', 'T'),
('Jiří', 'Vyrvál', '885907/0319', '+4207394327', 'vyrval@filharmonie.cz', 'Praha', 'T', 'F', 'F'),
('Jan', 'Pochop', '921005/7769', '+4204859756', 'pochop@filharmonie.cz', 'Brno', 'T', 'T', 'F'),
('Ema', 'Součková', '935711/5581', '+4205789632', 'souckova@filharmonie.cz', 'Hodonín', 'T', 'T', 'F'),
('Jakub', 'Král', '950514/2856', '+4205789632', 'kral@filharmonie.cz', 'Olomouc', 'T', 'T', 'T'),
('Anna', 'Mlynářová', '965124/4075', '+4201785478', 'mlynarova@filharmonie.cz', 'Vídeň', 'F', 'T', 'T');

-- --------------------------------------------------------

--
-- Struktura tabulky `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `Name` varchar(30) COLLATE latin2_czech_cs NOT NULL,
  `Login` varchar(10) COLLATE latin2_czech_cs NOT NULL,
  `Password` varchar(10) COLLATE latin2_czech_cs NOT NULL,
  `Date` date NOT NULL,
  `Role` int(11) NOT NULL,
  PRIMARY KEY (`Login`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2 COLLATE=latin2_czech_cs;

--
-- Vypisuji data pro tabulku `users`
--

INSERT INTO `users` (`Name`, `Login`, `Password`, `Date`, `Role`) VALUES
('Jan Vehnal', 'sprkon', 'sprkon', '1880-03-05', 2),
('Martin Krump', 'sprper', 'sprper', '1965-07-08', 1),
('Dana Zábrodská', 'sprskl', 'sprskl', '1945-03-04', 3);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
