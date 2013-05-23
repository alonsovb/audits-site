-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 23-05-2013 a las 04:43:18
-- Versión del servidor: 5.5.24-log
-- Versión de PHP: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `audits`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `assets`
--

CREATE TABLE IF NOT EXISTS `assets` (
  `id_asset` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` int(11) NOT NULL,
  PRIMARY KEY (`id_asset`),
  UNIQUE KEY `id_asset` (`id_asset`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `audits`
--

CREATE TABLE IF NOT EXISTS `audits` (
  `id_audit` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `room` bigint(20) unsigned NOT NULL,
  `date` datetime NOT NULL,
  `comment` varchar(100) NOT NULL,
  `completed` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_audit`),
  UNIQUE KEY `id_audit` (`id_audit`),
  KEY `room` (`room`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `audit_assets`
--

CREATE TABLE IF NOT EXISTS `audit_assets` (
  `audit` bigint(20) unsigned NOT NULL,
  `asset` bigint(20) unsigned NOT NULL,
  `present` tinyint(1) NOT NULL,
  `state` tinyint(1) NOT NULL,
  `rating` tinyint(4) NOT NULL,
  `comment` varchar(100) NOT NULL,
  PRIMARY KEY (`audit`,`asset`),
  KEY `asset` (`asset`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `buildings`
--

CREATE TABLE IF NOT EXISTS `buildings` (
  `id_building` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `headquarter` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id_building`),
  UNIQUE KEY `id_building` (`id_building`),
  KEY `headquarter` (`headquarter`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `buildings`
--

INSERT INTO `buildings` (`id_building`, `name`, `headquarter`) VALUES
(1, 'Administrative', 1),
(2, 'Dinning Hall', 1),
(3, 'Classrooms & Dpts.', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `headquarters`
--

CREATE TABLE IF NOT EXISTS `headquarters` (
  `id_hq` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`id_hq`),
  UNIQUE KEY `id_hq` (`id_hq`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `headquarters`
--

INSERT INTO `headquarters` (`id_hq`, `name`) VALUES
(1, 'San Carlos'),
(2, 'San José'),
(3, 'Cartago');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rooms`
--

CREATE TABLE IF NOT EXISTS `rooms` (
  `id_room` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `floor` tinyint(4) NOT NULL,
  `building` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id_room`),
  UNIQUE KEY `id_room` (`id_room`),
  KEY `building` (`building`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `rooms`
--

INSERT INTO `rooms` (`id_room`, `name`, `floor`, `building`) VALUES
(1, 'Reception', 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id_user` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` char(40) NOT NULL,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `id_user` (`id_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `name`) VALUES
(1, 'alonsovb', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'Alonso Vega');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `audits`
--
ALTER TABLE `audits`
  ADD CONSTRAINT `audits_ibfk_1` FOREIGN KEY (`room`) REFERENCES `rooms` (`id_room`);

--
-- Filtros para la tabla `audit_assets`
--
ALTER TABLE `audit_assets`
  ADD CONSTRAINT `audit_assets_ibfk_2` FOREIGN KEY (`asset`) REFERENCES `assets` (`id_asset`),
  ADD CONSTRAINT `audit_assets_ibfk_1` FOREIGN KEY (`audit`) REFERENCES `audits` (`id_audit`);

--
-- Filtros para la tabla `buildings`
--
ALTER TABLE `buildings`
  ADD CONSTRAINT `buildings_ibfk_1` FOREIGN KEY (`headquarter`) REFERENCES `headquarters` (`id_hq`);

--
-- Filtros para la tabla `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_ibfk_1` FOREIGN KEY (`building`) REFERENCES `buildings` (`id_building`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
