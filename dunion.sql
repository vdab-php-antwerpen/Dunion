-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Machine: 127.0.0.1
-- Genereertijd: 03 okt 2013 om 09:43
-- Serverversie: 5.5.27
-- PHP-versie: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databank: `dunion`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `dunion_answers`
--

CREATE TABLE IF NOT EXISTS `dunion_answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) NOT NULL,
  `answer` varchar(200) NOT NULL,
  `correct` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `question_id` (`question_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Gegevens worden uitgevoerd voor tabel `dunion_answers`
--

INSERT INTO `dunion_answers` (`id`, `question_id`, `answer`, `correct`) VALUES
(1, 1, 'Michael Jackson', 1),
(2, 1, 'Neil Armstrong', 0),
(3, 1, 'Louis Armstrong', 0),
(4, 2, 'Karl Marx', 0),
(5, 2, 'Groucho Marx', 1),
(6, 2, 'Harpo Marx', 0),
(7, 3, 'Lennon-McCartney', 0),
(8, 3, 'Ingvar Kamprad', 0),
(9, 3, 'Haruki Murakami', 1),
(10, 4, 'DonCorleone', 0),
(11, 4, 'James Brown', 1),
(12, 4, 'Marlon Brando', 0),
(13, 5, 'White', 0),
(14, 5, 'Castle', 0),
(15, 5, 'Morgan', 1),
(16, 6, 'Apple', 0),
(17, 6, 'Monthy Python', 1),
(18, 6, 'Bjarne Stroustrup', 0),
(19, 7, 'Eleven', 0),
(20, 7, 'Infinite', 0),
(21, 7, 'Seven', 1),
(22, 8, 'Silvio Dante', 1),
(23, 8, 'Silvio Commedia', 0),
(24, 8, 'Silvio Divina', 0),
(25, 9, 'Allak-Swivel', 0),
(26, 9, 'Lillhojden', 0),
(27, 9, 'Larsson', 1),
(28, 10, 'Railway station at Toulouse, France', 0),
(29, 10, 'The Walt Disney Concert Hall', 1),
(30, 10, 'Bridge over the Schelde in Temse, Belgium', 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `dunion_location`
--

CREATE TABLE IF NOT EXISTS `dunion_location` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `description` text,
  `start` tinyint(1) NOT NULL,
  `end` tinyint(1) NOT NULL,
  `level` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Gegevens worden uitgevoerd voor tabel `dunion_location`
--

INSERT INTO `dunion_location` (`id`, `name`, `description`, `start`, `end`, `level`) VALUES
(1, 'start', 'This is the starting location for new players', 1, 0, 1),
(2, 'Location 2', '', 0, 0, 1),
(3, 'Location 3', '', 0, 0, 1),
(4, 'Location 4', '', 0, 0, 1),
(5, 'Location 5', '', 0, 0, 1),
(6, 'Location 6', '', 0, 0, 1),
(7, 'Location 7', '', 0, 0, 1),
(8, 'Location 8', '', 0, 0, 1),
(9, 'Location 9', '', 0, 0, 1),
(10, 'Location 10', 'This is where it all ends.\r\nEnd of level 1', 0, 1, 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `dunion_questions`
--

CREATE TABLE IF NOT EXISTS `dunion_questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` text NOT NULL,
  `points` int(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Gegevens worden uitgevoerd voor tabel `dunion_questions`
--

INSERT INTO `dunion_questions` (`id`, `question`, `points`) VALUES
(1, 'Whose 1988 autobiography is entitled ''Moonwalk''?', 50),
(2, 'Who said ''Whatever it is- I''m against it!''?', 50),
(3, 'Who wrote the novel ''Norwegian wood''?', 50),
(4, 'Who was known as the Godfather of soul?', 50),
(5, 'What''s the last name of the main character in the TV-series ''Dexter''?', 50),
(6, 'Who created the machine that goes ''ping!''?', 50),
(7, 'How many time can a regular piece of paper be folded?', 50),
(8, 'What''s the charactername of Steven van Zandt in the Sopranos?', 50),
(9, 'Who wrote the Millenium trilogy?', 50),
(10, 'What wasn''t designed by the architect Gustave Eiffel?', 50);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `dunion_route`
--

CREATE TABLE IF NOT EXISTS `dunion_route` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `current` int(11) NOT NULL,
  `target` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `current` (`current`),
  KEY `target` (`target`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=51 ;

--
-- Gegevens worden uitgevoerd voor tabel `dunion_route`
--

INSERT INTO `dunion_route` (`id`, `current`, `target`) VALUES
(25, 1, 2),
(26, 1, 3),
(27, 2, 1),
(28, 2, 8),
(29, 3, 1),
(30, 3, 4),
(31, 4, 3),
(32, 4, 6),
(33, 4, 5),
(34, 5, 4),
(35, 5, 7),
(36, 5, 8),
(37, 6, 7),
(38, 6, 4),
(39, 7, 6),
(40, 7, 10),
(41, 7, 8),
(42, 7, 5),
(43, 8, 5),
(44, 8, 7),
(45, 8, 9),
(46, 8, 2),
(47, 9, 8),
(48, 9, 10),
(49, 10, 7),
(50, 10, 9);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `dunion_user`
--

CREATE TABLE IF NOT EXISTS `dunion_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `email` varchar(100) NOT NULL,
  `pasword` varchar(40) NOT NULL,
  `score` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `logged_in` tinyint(1) NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `location_id` (`location_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=105 ;

--
-- Beperkingen voor gedumpte tabellen
--

--
-- Beperkingen voor tabel `dunion_answers`
--
ALTER TABLE `dunion_answers`
  ADD CONSTRAINT `dunion_answers_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `dunion_questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `dunion_route`
--
ALTER TABLE `dunion_route`
  ADD CONSTRAINT `dunion_route_ibfk_1` FOREIGN KEY (`current`) REFERENCES `dunion_location` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dunion_route_ibfk_2` FOREIGN KEY (`target`) REFERENCES `dunion_location` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `dunion_user`
--
ALTER TABLE `dunion_user`
  ADD CONSTRAINT `dunion_user_ibfk_1` FOREIGN KEY (`location_id`) REFERENCES `dunion_location` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
