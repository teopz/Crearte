-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generato il: Feb 16, 2014 alle 11:44
-- Versione del server: 5.6.11
-- Versione PHP: 5.5.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `crearte`
--
CREATE DATABASE IF NOT EXISTS `crearte` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `crearte`;

-- --------------------------------------------------------

--
-- Struttura della tabella `articolo`
--

CREATE TABLE IF NOT EXISTS `articolo` (
  `titolo` varchar(1024) NOT NULL,
  `data` datetime NOT NULL,
  `autore` int(11) NOT NULL,
  `sottotitolo` varchar(2048) NOT NULL,
  `testo` text NOT NULL,
  `immagine` varchar(256) DEFAULT NULL,
  `key` int(11) NOT NULL AUTO_INCREMENT,
  `modifica` datetime DEFAULT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Dump dei dati per la tabella `articolo`
--

INSERT INTO `articolo` (`titolo`, `data`, `autore`, `sottotitolo`, `testo`, `immagine`, `key`, `modifica`) VALUES
('prova ricerca', '2013-09-10 16:36:32', 1, 'prova inserimento sottotitolo', 'questo testo deve essere trovato dal motore di ricerca ammaccabanane AMMACCABANANE!', NULL, 8, '2013-09-11 13:18:55'),
('prova ricerca2', '2013-09-10 16:36:59', 1, 'prova nuovo sottotitolo', 'questo testo non deve essere trovato dal motore di ricerca jambalaia urrÃ  Ã¨ Ã¨', NULL, 9, '2013-09-11 13:21:59'),
('Articolo e css', '2013-09-11 11:57:27', 1, 'la cacca', 'articolo di prova per verificare il funzionamento dei css', NULL, 10, '2013-09-11 13:29:49'),
('Prova nuovo articolo 5', '2013-09-11 13:26:45', 1, 'Nuovo sottotitolo', 'Prova inserimento nuovo articolo e sottotitolo\r\nnuova modifica\r\nciao come va?', NULL, 11, '2013-10-04 20:17:09'),
('articolo nuovo di zecca', '2013-10-15 23:28:35', 1, 'nuovo articolo', 'ARTICOLOOOOOOONEEEEEEEE! minuscolo', NULL, 13, NULL),
('altro maledetto articolo', '2013-10-16 00:06:24', 1, 'bla bla', 'testo testo testo testo testo testo', NULL, 14, NULL),
('C''era una volta', '2013-10-16 20:46:51', 1, 'Un''altra volta', '<img src="immagini/maschere.jpg" width="200"></img>\r\n</br>Un''enorme mole di apostrofi </br> che per fortuna sconfissi! \r\n<p>Prova del simpatico paragrafo che ad un certo punto \r\n<b>diventa grassetto!</b>\r\n</p>\r\n<img src="immagini/maschere.jpg" width="150"></img>', NULL, 15, '2013-12-21 14:22:35'),
('Inserimento articolo da Chrome', '2013-10-16 20:59:10', 1, 'Speriamo vada bene', 'Sono fiducioso che andrÃ  tutto a meraviglia', NULL, 16, NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `autore`
--

CREATE TABLE IF NOT EXISTS `autore` (
  `nome` varchar(256) NOT NULL,
  `cognome` varchar(256) NOT NULL,
  `password` varchar(32) NOT NULL,
  `sessione` varchar(26) DEFAULT NULL,
  `mail` varchar(256) NOT NULL,
  `immagine` varchar(256) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dump dei dati per la tabella `autore`
--

INSERT INTO `autore` (`nome`, `cognome`, `password`, `sessione`, `mail`, `immagine`, `id`) VALUES
('Matteo', 'Patrucco', '43a565b670a03756493f8c111e6a9ab3', 'dkga7vj8qgprfh6mqkmv4uhc05', 'teopz', NULL, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
