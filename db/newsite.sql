-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 25, 2013 at 01:20 PM
-- Server version: 5.6.11
-- PHP Version: 5.5.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_administrators`
--

CREATE TABLE IF NOT EXISTS `tbl_administrators` (
  `administrator_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `email_address` varchar(255) NOT NULL,
  `user_type_id` int(4) NOT NULL,
  `is_active` tinyint(4) NOT NULL,
  `datetime_created` datetime DEFAULT NULL,
  PRIMARY KEY (`administrator_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `tbl_administrators`
--

INSERT INTO `tbl_administrators` (`administrator_id`, `username`, `password`, `firstname`, `lastname`, `email_address`, `user_type_id`, `is_active`, `datetime_created`) VALUES
(1, 'admin', 'administrator', 'Admin', 'Admin', 'admin@d-s-c.ch', 1, 1, '2009-01-28 19:49:35');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_categories`
--

CREATE TABLE IF NOT EXISTS `tbl_categories` (
  `category_id` int(10) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(100) NOT NULL,
  `category_text_color` varchar(100) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `tbl_categories`
--

INSERT INTO `tbl_categories` (`category_id`, `category_name`, `category_text_color`) VALUES
(1, 'Workshops', '#FFFFFF'),
(2, 'Milongas mit Livemusik', '#FFCC00'),
(3, 'Schnupperkurse', '#00CCFF'),
(4, 'Salsa', '#CCFF66'),
(5, 'Swing', '#CC66FF'),
(6, 'Standard/Latein', '#FF99FF');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_courses`
--

CREATE TABLE IF NOT EXISTS `tbl_courses` (
  `event_id` int(100) NOT NULL AUTO_INCREMENT,
  `event_title` varchar(255) DEFAULT NULL,
  `event_sub_title` varchar(255) DEFAULT NULL,
  `event_location` varchar(255) DEFAULT NULL,
  `event_photo` varchar(255) DEFAULT NULL,
  `event_is_active` tinyint(1) DEFAULT '0',
  `event_created_date` datetime DEFAULT NULL,
  `event_updated_date` datetime DEFAULT NULL,
  `category_id` int(10) DEFAULT NULL,
  `event_link` varchar(255) NOT NULL,
  `event_price` varchar(20) DEFAULT NULL,
  `event_description` longtext,
  PRIMARY KEY (`event_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `tbl_courses`
--

INSERT INTO `tbl_courses` (`event_id`, `event_title`, `event_sub_title`, `event_location`, `event_photo`, `event_is_active`, `event_created_date`, `event_updated_date`, `category_id`, `event_link`, `event_price`, `event_description`) VALUES
(12, 'für Einsteiger', 'Tangoluft schnuppern', 'Club el Social', NULL, 1, '2013-06-16 20:39:23', '2013-08-09 15:17:25', 2, 'http://elsocial.ch/Pages/Kurse/kurseschnuppern.htm', NULL, NULL),
(13, 'für Einsteiger, erste Basis', 'Tangoluft schnuppern', 'Club el Social', NULL, 1, '2013-06-17 21:30:23', '2013-08-09 15:18:41', 3, 'http://elsocial.ch/Pages/Kurse/kurseschnuppern.htm', NULL, NULL),
(14, 'Kurs 1', 'mit Basiskenntnissen und bis zu 1 Jahr', 'Club el Social', NULL, 1, '2013-06-20 06:53:22', '2013-08-09 15:21:13', 1, 'http://elsocial.ch/Pages/Kurse/spielregeln.html', NULL, NULL),
(15, 'Kurs TE', 'für alle Personen ohne Kenntnisse', 'Club el Social', NULL, 1, '2013-08-09 15:22:53', '2013-08-09 15:22:53', 1, 'http://elsocial.ch/Pages/Kurse/spielregeln.html', NULL, NULL),
(16, 'Kurs 2', 'nach ca 1. Jahr Kurse', 'Club el Social', NULL, 1, '2013-08-09 15:26:39', '2013-08-09 15:26:39', 1, 'http://elsocial.ch/Pages/Kurse/spielregeln.html', NULL, NULL),
(17, 'Tango Frauentechnikkurs mit Sanja', 'Beweglichkeit', 'Club el Social', '137605498889729700.jpg', 1, '2013-08-09 15:29:48', '2013-08-09 15:29:48', 4, 'http://elsocial.ch/Pages/Kurse/index2.html', NULL, NULL),
(18, 'Kurs 1', 'Test', 'Club el Social', NULL, 1, '2013-08-09 15:31:54', '2013-08-09 15:31:54', 1, 'http://elsocial.ch/Pages/Kurse/index2.html', NULL, NULL),
(19, 'Tango Argentino', 'Intensiv Einführungskurs', 'Club el Social, im Viadukt 10, Viaduktstr. 67,', '137891343166440300.jpg', 1, '2013-08-29 17:16:56', '2013-09-11 17:30:31', 3, 'http://www.elsocial.ch/Pages/Kurse/kurseschnuppern', '75', 'Tango Intensiv-Einführungskurs 2013\r\n\r\nJeweils am Sonntag 12.00 - 15.00 Uhr (mit 30 Minuten Pause)\r\n22. September / 27. Oktober / 24. November / 22. Dezember\r\n\r\nweitere Daten folgen\r\n\r\nKurstag pro Person CHF 75.-\r\n\r\nAnmeldung bitte paarweise unter info@elsocial.ch\r\n\r\nClub el Social, im Viadukt 10, Viaduktstrasse 67, Zürich'),
(20, 'gratis Tango Argentino Schnupperkurs', '1 x im Monat im Viadukt', 'Club el Social, im Viadukt 10, Viaduktstr. 67,', '137891376542693400.jpg', 1, '2013-09-11 17:36:07', '2013-09-11 17:36:07', 2, 'http://www.elsocial.ch/Pages/Kurse/kurseschnuppern', '0', 'Gratis! Tango- Schnupperkurse 2013\r\n\r\njeden 4. Samstag im Monat im Club el Social\r\nnächste Daten:\r\nSamstag 28. September 15.00 - 16.00 Uhr	\r\n\r\nAnmeldung bitte paarweise unter info@elsocial.chClub el Social, im Viadukt 10, Viaduktstrasse 67, Zürich'),
(21, 'Tango Frauentechnikkurs mit Sanja', '1x im Monat im Viadukt', 'Club el Social, im Viadukt 10, Viaduktstr. 67,', '137891395836477000.jpg', 1, '2013-09-11 17:39:18', '2013-09-11 17:39:18', 4, 'http://www.elsocial.ch/Pages/Kurse/workshops%20ZH.', '40', 'Tango Frauentechnikkurs für Anfängerinnen und mittleres Niveau mit Sanja\r\n\r\nSamstag 12. Oktober 2013 (Thema: Rotationen) \r\n\r\n13.00 - 14.30 Uhr Frauentechnik und Körperarbeit mit Schwerpunkt auf: Haltung, Gehtechnik, Gleichgewicht, Rotation und Spiralbewegung, Körperbewusstsein und Körperwahrnehmung mit Sanja Belul, dipl. Bewegungspädagogin BGB\r\n\r\nKosten: CHF 40.- pro Person pro Kurstag\r\nBitte flache Schuhe/Socken / Tanzschuhe, Trainingskleidung und Tüechli mitbringen. \r\n\r\nAnmeldung (ohne Partner) bis spätestens Freitag davor um 15.00 Uhr unter info@elsocial.ch,044 241 21 40\r\n\r\nErgänzende Kurse/Tanztraining bietet Sanja im Beldance an.\r\n\r\nKursort: el Social, im Viadukt 10, Viaduktstr. 67, Zürich'),
(22, 'Tango Argentino Kurs 1', 'mit Basiskenntnissen und bis zu 1 Jahr', 'Club el Social, im Viadukt 10, Viaduktstr. 67,', '137891443935289500.jpg', 1, '2013-09-11 17:47:19', '2013-09-11 17:47:19', 1, 'http://www.elsocial.ch/Pages/Kurse/spielregeln.htm', '200', 'Tango Anfänger/Mittelstufekurs\r\nVorwärts- /Rückwärts-Ochos, Continuado,\r\nSandwich, Media Luna, halbe Drehungen kombiniert mit Vorwärts- /Rückwärts-Ochos und Caminatas, Ganze Drehungen, 8 Positionen der Drehung mit Entradas, Kombinationen in der Drehung nach rechts, Kombinationen in der Drehung nach links, Calesita (Karussell), Espejo (Spiegel), Ocho acompañado (begleitete Ocho), pequeños Adornos (kleine Verzierungen), Ocho cortado\r\nDas Ziel ist sich sicher auf der Tanzfläche bewegen zu können, eine gute Haltung, Eleganz, ein gutes Rhythmusgefühl und die Synchronisierung der Bewegungen im Paar.\r\n\r\nEin Kursblock (8 Lektionen während 2 Monaten) kostet CHF 200.-. Wer während des Kursblocks 2 Kurse besucht, bezahlt CHF 300.-, für 3 Kurse CHF 400.- und für 4 Kurse CHF 500.- .(Legipreis für Studenten unter 30 Jahren abzgl. 10%.) Eine verpasste Lektion kann während des Kursblocks an einem anderen Tag vor- oder nachgeholt werden. Die maximale Teilnehmerzahl pro Kurs ist 12 Paare.\r\n-'),
(23, 'Tango Argentino Kurs 2 Fortgeschrittene', 'Tango Salon + / nach der Stufe 1', 'Club el Social, im Viadukt 10, Viaduktstr. 67,', '137891468874934900.jpg', 1, '2013-09-11 17:51:28', '2013-09-11 17:51:28', 1, 'http://www.elsocial.ch/Pages/Kurse/spielregeln.htm', '200', 'Barridas (Schieber), Boleos vorwärts und rückwärts, Sacadas vorwärts und rückwärts, Enrosque, Lapiz, Ganchos,\r\nPlaneo, Alteraciones, Cadenas, usw. \r\nDieser Kurs ist für Fortgeschrittene, die alle Elemente der ersten Niveaus beherrschen.\r\nEin Kursblock (8 Lektionen während 2 Monaten) kostet CHF 200.-. Wer während des Kursblocks 2 Kurse besucht, bezahlt CHF 300.-, für 3 Kurse CHF 400.- und für 4 Kurse CHF 500.- .(Legipreis für Studenten unter 30 Jahren abzgl. 10%.) Eine verpasste Lektion kann während des Kursblocks an einem anderen Tag vor- oder nachgeholt werden. Die maximale Teilnehmerzahl pro Kurs ist 12 Paare.\r\n-\r\nKonditionen:\r\nDu kannst nur deinem Niveau entsprechende Kurse oder Kurse darunter besuchen.\r\nDie Wochenend-Workshops und die Tanzabende sind nicht in den Kurskosten inbegriffen.'),
(24, 'Tango Einführungskurs', 'für alle Personen ohne Kenntnisse', 'Club el Social, im Viadukt 10, Viaduktstr. 67,', '137908217589287600.gif', 1, '2013-09-13 16:22:55', '2013-09-13 16:22:55', 1, 'http://www.elsocial.ch/Pages/Kurse/kurse_zurich.ht', '200', 'Caminar (Technik des Gehens und Gehkombinationen), Haltung, Abrazo (Umarmung), Rhythmik im Tango, Cruce (Kreuz), Cambio de Frente (Frontwechsel), Paradas (Stopps), Cambio de peso (Gewichtsverlagerung), Technik der Ochos (Vorwärts- /Rückwärts-Ochos), Giro (Einführung in die Drehung)\r\nDas Ziel dieser ersten beiden Niveaus ist sich sicher auf der Tanzfläche bewegen zu können, eine gute Haltung, Eleganz, ein gutes Rhythmusgefühl und die Synchronisierung der Bewegungen im Paar.\r\nEin Kursblock (8 Lektionen während 2 Monaten) kostet CHF 200.-. Wer während des Kursblocks 2 Kurse besucht, bezahlt CHF 300.-'),
(25, 'Tango Kurs 1 Anfänger/Mittelstufe Tango Salon 1', 'mit Basiskenntnissen und bis zu 1 Jahr', 'Club el Social, im Viadukt 10, Viaduktstr. 67,', '137908230203190900.jpg', 1, '2013-09-13 16:25:02', '2013-09-13 16:25:02', 1, 'http://www.elsocial.ch/Pages/Kurse/spielregeln.htm', '200', 'Vorwärts- /Rückwärts-Ochos, Continuado,\r\nSandwich, Media Luna, halbe Drehungen kombiniert mit Vorwärts- /Rückwärts-Ochos und Caminatas, Ganze Drehungen, 8 Positionen der Drehung mit Entradas, Kombinationen in der Drehung nach rechts, Kombinationen in der Drehung nach links, Calesita (Karussell), Espejo (Spiegel), Ocho acompañado (begleitete Ocho), pequeños Adornos (kleine Verzierungen), Ocho cortado\r\nEin Kursblock (8 Lektionen während 2 Monaten) kostet CHF 200.-. Wer während des Kursblocks 2 Kurse besucht, bezahlt CHF 300.-'),
(26, 'Tango Argentino Kurs 2 Fortgeschrittene', 'nach ca 1. Jahr Kurse', 'Club el Social, im Viadukt 10, Viaduktstr. 67,', '137908250373198400.jpg', 1, '2013-09-13 16:28:23', '2013-09-13 16:28:23', 1, 'http://www.elsocial.ch/Pages/Kurse/spielregeln.htm', '200', 'Tango Fortgeschrittene, Tango Salon +\r\nBarridas (Schieber), Boleos vorwärts und rückwärts, Sacadas vorwärts und rückwärts, Enrosque, Lapiz, Ganchos,\r\nPlaneo, Alteraciones, Cadenas, usw. \r\nEin Kursblock (8 Lektionen während 2 Monaten) kostet CHF 200.-. Wer während des Kursblocks 2 Kurse besucht, bezahlt CHF 300.-');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_course_categories`
--

CREATE TABLE IF NOT EXISTS `tbl_course_categories` (
  `category_id` int(10) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(100) NOT NULL,
  `category_text_color` varchar(100) NOT NULL,
  `section` int(1) DEFAULT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `tbl_course_categories`
--

INSERT INTO `tbl_course_categories` (`category_id`, `category_name`, `category_text_color`, `section`) VALUES
(1, 'Tangokurse in Zurich', '#FFCC00', NULL),
(2, 'Tango Schnupperkurse ', '#00CCFF', NULL),
(3, 'Tango Intensiv Einfuhrungskurs', '#CCFF66', NULL),
(4, 'Workshops', '#CC66FF', NULL),
(7, 'Milonga (ohne Livemusik)', '007fff', 1),
(8, 'Lesung', 'aad4ff', 1),
(9, 'Raum vermietet', 'ff5656', 1),
(10, 'Tangofestival', '00bf00', 1),
(11, 'Special (Anderes)', 'cccccc', 1),
(12, 'Bassersdorf', '#A52A2A', 2),
(13, 'Reserviert', '#FF0000', 2),
(14, 'Basel', '#008000', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_events`
--

CREATE TABLE IF NOT EXISTS `tbl_events` (
  `event_id` int(10) NOT NULL AUTO_INCREMENT,
  `event_title` varchar(255) NOT NULL,
  `event_sub_title` varchar(255) NOT NULL,
  `event_location` varchar(255) NOT NULL,
  `event_photo` varchar(255) NOT NULL,
  `event_is_active` tinyint(1) NOT NULL,
  `event_created_date` datetime NOT NULL,
  `event_updated_date` datetime NOT NULL,
  `category_id` int(10) NOT NULL,
  `event_link` varchar(255) NOT NULL,
  `event_price` varchar(20) DEFAULT NULL,
  `event_description` longtext,
  PRIMARY KEY (`event_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `tbl_events`
--

INSERT INTO `tbl_events` (`event_id`, `event_title`, `event_sub_title`, `event_location`, `event_photo`, `event_is_active`, `event_created_date`, `event_updated_date`, `category_id`, `event_link`, `event_price`, `event_description`) VALUES
(8, 'Salsa On2 1x im Monat am Sonntag', 'Salsa', 'Club el Social', '137142175631093300.png', 1, '2013-06-14 10:06:30', '2013-08-09 14:08:35', 4, 'http://www.elsocial.ch/Pages/salsa.html', NULL, NULL),
(7, 'geführte Practica', 'mit Pascal', 'Club el Social', '137604971267702000.jpg', 1, '2013-06-14 09:43:19', '2013-08-09 14:01:52', 1, 'http://www.elsocial.ch/Pages/Tango_tanzabende.html', NULL, NULL),
(10, 'Tango Argentino', 'on 24. August 2013', 'Club el Social', '137142173041412200.png', 1, '2013-06-15 18:20:53', '2013-08-09 13:48:37', 3, 'http://www.google.com', NULL, NULL),
(12, 'jeden Freitag Livemusik zum Tangotanzen', 'mit Javier Fernandez und seinen Musikerfreunden', 'Club el Social', '137604979550586000.jpg', 1, '2013-06-16 16:15:52', '2013-08-09 14:03:15', 2, 'http://www.elsocial.ch/Pages/Konzerte_Events.htm', NULL, NULL),
(14, 'Salsamoods Tanzabend', 'jeden Mittwoch', 'Club el Social', '137604935596306900.jpg', 1, '2013-08-09 13:51:51', '2013-08-09 13:55:56', 4, 'http://www.elsocial.ch/Pages/salsa.html', NULL, NULL),
(15, 'Lindy Hop/Balboa Tanzabend', 'Crashkurs und Kurs vorher', 'Club el Social', '137604930546941000.jpg', 1, '2013-08-09 13:55:05', '2013-08-09 13:55:05', 5, 'http://www.elsocial.ch/Pages/swing.html', NULL, NULL),
(16, 'Tango Intensiv Einführungskurs', 'für Einsteiger', 'Club el Social', '', 1, '2013-08-09 14:05:44', '2013-08-09 14:05:44', 1, 'http://www.elsocial.ch/Pages/Kurse/kurseschnuppern', NULL, NULL),
(22, 'Salsamoods Tanzabend', 'jeden Mittwoch', 'Club el Social, im Viadukt 10, Viaduktstr. 67,', '137891209127119600.jpg', 1, '2013-09-11 17:08:11', '2013-09-11 17:08:11', 15, 'http://www.elsocial.ch/Pages/salsa.html', '10', 'jeden Mittwoch 21.00 - 00.30 Uhr\r\nSalsa-Party im Viadukt 10\r\n\r\nDaten 2013 und die DJ''s:\r\n14. August DJD \r\n21. August DJ Pepe \r\n28. August DJ Pepe \r\n04. September DJ SN \r\n11. September DJ Pepe \r\n18. September DJD \r\n25. September DJ Pepe\r\n\r\nweitere Daten folgen\r\n\r\nEintritt Party CHF 10.00 inkl. 1 Getränk\r\n\r\nWir sind auch auf Facebook mit der Gruppe Salsamoods\r\n\r\nClub el Social, Im Viadukt 10, Viaduktstrasse 67, 8005 Zürich'),
(23, 'el Boge Swing', 'jeden Dienstag', 'Club el Social, im Viadukt 10, Viaduktstr. 67,', '137891234765257700.jpg', 1, '2013-09-11 17:12:27', '2013-09-11 17:12:27', 16, 'http://www.elsocial.ch/Pages/swing.html', '10', 'el Boge Swing\r\n\r\nLindy Hop & Balboa tanzen\r\nJeden Dienstag im Viadukt:\r\n1x im Monat mit Live Musik! \r\n\r\n19.00 - 19.30 Uhr Lindy Hop Schnupperkurs - gratis\r\n19.30 - 20.15 Uhr Lindy Hop Training - CHF 20.00 inkl. Party und 1 Getränk\r\n20.15 bis 00.00 Uhr Lindy Hop & Balboa Party - Eintritt CHF 10.- inkl. 1 Getränk (bei Live Musik Eintritt CHF 15.-)\r\n\r\nWir sind auch auf Facebook mit der Gruppe el Boge Swing.'),
(28, 'TEST', 'SUB TITLE', 'LOCATION', '', 1, '2013-09-25 18:50:01', '2013-09-25 18:50:01', 14, 'http://www.yahoo.com', '12', 'DESCRIPTINO'),
(29, 's', 's', 's', '', 1, '2013-09-25 19:10:11', '2013-09-25 19:10:11', 12, 'http://www.yahoo.com', '2', 's'),
(26, 'Tanz-Boge Paartanzabend', '2x im Monat am Sonntag', 'Club el Social, im Viadukt 10, Viaduktstr. 67,', '137891312499769500.jpg', 1, '2013-09-11 17:25:25', '2013-09-11 17:25:25', 17, 'http://www.elsocial.ch/Pages/Tanz_Boge.htm', '10', 'Tanz-Boge\r\n\r\nWalzer, Cha Cha Cha, Rumba, Swing, Disco, Jive, Salsa, ...\r\n\r\n20.00 - 23.00 Uhr\r\n\r\nEintritt CHF 10.- (inkl. 1 Getränk)\r\n\r\nDaten 2013:\r\n15. September DJ Claudio\r\n06. Oktober DJ Alex\r\n20. Oktober DJane Christine \r\n03. November DJ Alex\r\n17. November DJ Claudio\r\n\r\nweitere Daten folgen\r\n\r\nauch TänzerInnen ohne TanzpartnerIn sind herzlich eingeladen\r\n\r\nClub el Social, Im Viadukt 10, Viaduktstasse 67, 8005 Zürich'),
(27, 'test b', 'sub title', 't b', '', 1, '2013-09-25 18:11:05', '2013-09-25 18:11:05', 14, 'http://www.yahoo.com', '34', 't b');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_event_dates`
--

CREATE TABLE IF NOT EXISTS `tbl_event_dates` (
  `date_id` int(10) NOT NULL AUTO_INCREMENT,
  `eevent_id` int(10) DEFAULT NULL,
  `section` int(1) DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  PRIMARY KEY (`date_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=168 ;

--
-- Dumping data for table `tbl_event_dates`
--

INSERT INTO `tbl_event_dates` (`date_id`, `eevent_id`, `section`, `start_date`, `end_date`) VALUES
(164, 28, 1, '2013-09-25 12:34:00', '2013-09-25 23:45:00'),
(165, 28, 1, '2013-10-03 12:34:00', '2013-10-03 23:45:00'),
(166, 29, 1, '2013-09-25 12:35:00', '2013-09-25 12:55:00'),
(167, 29, 1, '2013-10-02 12:35:00', '2013-10-02 12:55:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_other_events`
--

CREATE TABLE IF NOT EXISTS `tbl_other_events` (
  `event_id` int(100) NOT NULL AUTO_INCREMENT,
  `event_title` varchar(255) DEFAULT NULL,
  `event_sub_title` varchar(255) DEFAULT NULL,
  `event_location` varchar(255) DEFAULT NULL,
  `event_photo` varchar(255) DEFAULT NULL,
  `event_is_active` tinyint(1) DEFAULT '0',
  `event_created_date` datetime DEFAULT NULL,
  `event_updated_date` datetime DEFAULT NULL,
  `category_id` int(10) DEFAULT NULL,
  `event_link` varchar(200) DEFAULT NULL,
  `event_price` varchar(20) DEFAULT NULL,
  `event_description` longtext,
  PRIMARY KEY (`event_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `tbl_other_events`
--

INSERT INTO `tbl_other_events` (`event_id`, `event_title`, `event_sub_title`, `event_location`, `event_photo`, `event_is_active`, `event_created_date`, `event_updated_date`, `category_id`, `event_link`, `event_price`, `event_description`) VALUES
(16, 'dididi', 'dididi', 'dididi', '137761695009565300.jpg', 1, '2013-08-27 17:17:20', '2013-08-27 17:22:30', 7, 'http://www.drflow.ch', NULL, NULL),
(17, 'lesung', 'lesung', 'lesung', NULL, 1, '2013-08-29 15:46:43', '2013-08-29 15:46:43', 8, 'www.elsocial.ch', '23', NULL),
(18, 'Milonga el Puntazo', 'jeden Mittwoch', 'Casa d''Italia, Erismannstr. 6, Zürich', '137908054221467300.jpg', 1, '2013-09-13 15:55:42', '2013-09-13 15:58:36', 7, 'http://www.elsocial.ch/Pages/Tango_tanzabende.html', '10', '20.30 - 23.45 Uhr / Eintritt CHF 10.00'),
(19, 'Milonga el Falcone', 'jeden Sonntag im schönsten Raum von Zürich', 'Restaurant Falcone, Birmensdorferstrasse 150, ZH', NULL, 1, '2013-09-13 15:58:16', '2013-09-13 15:58:16', 7, 'http://www.elsocial.ch/Pages/Tango_tanzabende.html', '15', '19.30 - 23.30 Uhr / Eintritt CHF 15.00 / mit Legi CHF 10.00'),
(20, 'Lesung Tango Fatal', 'mit Karin Betz', 'Club el Social, im Viadukt 10, Viaduktstr. 67,', '137908115946574100.jpg', 1, '2013-09-13 16:05:59', '2013-09-13 16:05:59', 11, 'http://www.elsocial.ch/Pages/Konzerte_Events.htm', '25.', 'Tango fatal - Tangogeschichten mit Karin Betz \r\nSamstag, 26. Oktober 2013\r\n\r\n13.30 - 15.00 Uhr (im Anschluss Tango-Schnupperkurs)\r\n\r\nSie tanzt nicht nur in jeder freien Minute Tango und macht Musik für solche, die es ihr gleichtun. Karin Betz hat nun dem argentinischen Tango eine weitere Ausdrucksform verliehen. Sie hat ihm ein Buch gewidmet. Es sind Geschichten, die spannend und unergründlich sind, die naiv und obsessiv erzählen von einem Tanz, der süchtig macht. \r\n\r\nEintritt (inkl. Tango-Schnupperkurs): CHF 25.00, ermässigt CHF 20.00. Tickets online unter www.zuerich-liest.ch/tickets und vom 24. Oktober bis 27. Oktober im Festivalzelt an der Torgasse (neben Café Odeon).\r\n\r\nClub el Social, im Viadukt 10, Viaduktstr. 67, 8005 Zürich'),
(21, 'Pfingst-Tangofestival Luzern', 'zum 5ten', 'Luzern', '137908188384735800.jpg', 1, '2013-09-13 16:18:03', '2013-09-13 16:18:03', 10, 'http://www.elsocial.ch/Pages/Konzerte_Events.htm', '.', 'Details....');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
