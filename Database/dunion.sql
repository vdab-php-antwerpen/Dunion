-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Machine: 127.0.0.1
-- Genereertijd: 13 dec 2013 om 08:54
-- Serverversie: 5.6.14
-- PHP-versie: 5.5.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
-- Tabelstructuur voor tabel `dunion_events`
--

CREATE TABLE IF NOT EXISTS `dunion_events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(200) NOT NULL,
  `location_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `location_id` (`location_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Gegevens worden uitgevoerd voor tabel `dunion_events`
--

INSERT INTO `dunion_events` (`id`, `description`, `location_id`) VALUES
(1, 'event van locatie 1', 1),
(2, 'event van locatie 2', 2),
(3, 'event van locatie 3', 3),
(4, 'event van locatie 4', 4),
(5, 'event van locatie 5', 5),
(6, 'event van locatie 6', 6),
(7, 'event van locatie 7', 7),
(8, 'event van locatie 8', 8),
(9, 'event van locatie 9', 9),
(10, 'event van locatie 10', 10);

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
(2, 'Location 2', 'this is location 2', 0, 0, 1),
(3, 'Location 3', 'this is location 3', 0, 0, 1),
(4, 'Location 4', 'this is location 4', 0, 0, 1),
(5, 'Location 5', 'this is location 5', 0, 0, 1),
(6, 'Location 6', 'this is location 6', 0, 0, 1),
(7, 'Location 7', 'this is location 7', 0, 0, 1),
(8, 'Location 8', 'this is location 8', 0, 0, 1),
(9, 'Location 9', 'this is location 9', 0, 0, 1),
(10, 'Location 10', 'This is where it all ends.\r\nEnd of level 1', 0, 1, 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `dunion_messages`
--

CREATE TABLE IF NOT EXISTS `dunion_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` varchar(200) NOT NULL,
  `user_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `location_id` (`location_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Gegevens worden uitgevoerd voor tabel `dunion_messages`
--

INSERT INTO `dunion_messages` (`id`, `text`, `user_id`, `location_id`, `datetime`) VALUES
(2, 'jhhjgjh', 108, 1, '2013-12-11 10:49:16'),
(3, 'ghhhj', 108, 1, '2013-12-11 10:49:23'),
(4, 'jhjkhh', 108, 1, '2013-12-11 10:49:33'),
(5, 'hhh', 108, 2, '2013-12-11 10:49:42');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `dunion_results`
--

CREATE TABLE IF NOT EXISTS `dunion_results` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(200) NOT NULL,
  `event_id` int(11) NOT NULL,
  `outcome` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `event_id` (`event_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=68 ;

--
-- Gegevens worden uitgevoerd voor tabel `dunion_results`
--

INSERT INTO `dunion_results` (`id`, `description`, `event_id`, `outcome`) VALUES
(1, 'Het 1e result', 1, 1),
(2, 'Het 2e result', 1, 2),
(3, 'Het 3e result', 1, 3),
(4, 'Het 1e result', 2, 1),
(5, 'Het 2e result', 2, 2),
(6, 'Het 3e result', 2, 3),
(7, 'Het 1e result', 3, 1),
(8, 'Het 2e result', 3, 2),
(9, 'Het 3e result', 3, 3),
(47, 'Het 1e result', 4, 1),
(48, 'Het 2e result', 4, 2),
(49, 'Het 3e result', 4, 3),
(50, 'Het 1e result', 5, 1),
(51, 'Het 2e result', 5, 2),
(52, 'Het 3e result', 5, 3),
(53, 'Het 1e result', 6, 1),
(54, 'Het 2e result', 6, 2),
(55, 'Het 3e result', 6, 3),
(56, 'Het 1e result', 7, 1),
(57, 'Het 2e result', 7, 2),
(58, 'Het 3e result', 7, 3),
(59, 'Het 1e result', 8, 1),
(60, 'Het 2e result', 8, 2),
(61, 'Het 3e result', 8, 3),
(62, 'Het 1e result', 9, 1),
(63, 'Het 2e result', 9, 2),
(64, 'Het 3e result', 9, 3),
(65, 'Het 1e result', 10, 1),
(66, 'Het 2e result', 10, 2),
(67, 'Het 3e result', 10, 3);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=110 ;

--
-- Gegevens worden uitgevoerd voor tabel `dunion_user`
--

INSERT INTO `dunion_user` (`id`, `username`, `email`, `pasword`, `score`, `location_id`, `logged_in`, `last_updated`) VALUES
(105, 'thomas', 'thomas@thomas.com', '5f50a84c1fa3bcff146405017f36aec1a10a9e38', 0, 1, 0, '2013-12-09 09:51:46'),
(106, 'jos', 'jos@jos.com', '7735a5fe86a8af42599ea328f9ed3ef64ccaffb0', 0, 1, 0, '2013-12-09 12:01:57'),
(107, 'jos2', 'jos2@jos.com', '889182f70d3226df681c9e6ffb0a6fa6feaf0cb5', 0, 1, 0, '2013-10-04 09:50:11'),
(108, 'ds', 'ds@ds.com', 'ba4868b3f277c8e387b55d9e3d0be7c045cdd89e', 0, 1, 0, '2013-12-12 12:29:42'),
(109, 'dsdsqd', 'ddsqds@ds.com', '80b2f0caa594a3e173b7e356161f88b2dd02b9b9', 0, 1, 0, '2013-12-09 12:33:42');

--
-- Beperkingen voor gedumpte tabellen
--

--
-- Beperkingen voor tabel `dunion_events`
--
ALTER TABLE `dunion_events`
  ADD CONSTRAINT `dunion_events_ibfk_1` FOREIGN KEY (`location_id`) REFERENCES `dunion_location` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `dunion_messages`
--
ALTER TABLE `dunion_messages`
  ADD CONSTRAINT `dunion_messages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `dunion_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dunion_messages_ibfk_2` FOREIGN KEY (`location_id`) REFERENCES `dunion_location` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `dunion_results`
--
ALTER TABLE `dunion_results`
  ADD CONSTRAINT `dunion_results_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `dunion_events` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
