-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Servidor: 10.40.32.10:4401
-- Temps de generació: 20-02-2019 a les 13:47:43
-- Versió del servidor: 5.5.47
-- Versió de PHP: 7.0.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de dades: `facturacio`
--

-- --------------------------------------------------------

--
-- Estructura de la taula `factura`
--

CREATE TABLE `factura` (
  `num_reg` int(11) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `adreca` varchar(255) DEFAULT NULL,
  `nif` varchar(11) DEFAULT NULL,
  `detalls` text,
  `factura` text,
  `observacions` text,
  `tipus` tinyint(1) DEFAULT NULL,
  `fecha_solicitud` date DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `cobrada` tinyint(1) NOT NULL DEFAULT '0',
  `modificat` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 PACK_KEYS=1;

--
-- Indexos per taules bolcades
--

--
-- Index de la taula `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`num_reg`);

--
-- AUTO_INCREMENT per les taules bolcades
--

--
-- AUTO_INCREMENT per la taula `factura`
--
ALTER TABLE `factura`
  MODIFY `num_reg` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
