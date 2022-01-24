-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 30-11-2017 a las 12:37:11
-- Versión del servidor: 5.5.24-log
-- Versión de PHP: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `aaron`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jugadores`
--

CREATE TABLE IF NOT EXISTS `jugadores` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(25) COLLATE utf8_bin NOT NULL,
  `apellido` varchar(50) COLLATE utf8_bin NOT NULL,
  `foto` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `nacimiento` date DEFAULT NULL,
  `provincia` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `debutante` varchar(100) COLLATE utf8_bin DEFAULT 'Desconocido',
  `actual` varchar(100) COLLATE utf8_bin DEFAULT 'Desconocido',
  `posicion` varchar(15) COLLATE utf8_bin DEFAULT 'Banquillo',
  `numero` tinyint(4) DEFAULT '0',
  `patrocinador` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `preciofichaje` bigint(20) DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=19 ;

--
-- Volcado de datos para la tabla `jugadores`
--

INSERT INTO `jugadores` (`ID`, `nombre`, `apellido`, `foto`, `nacimiento`, `provincia`, `debutante`, `actual`, `posicion`, `numero`, `patrocinador`, `preciofichaje`) VALUES
(3, 'Cristiano', 'Ronaldo dos Santos Aveiro', 'fotos/CristianoRonaldodosSantosAveiro.jpg', '1985-02-05', 'Funchal, Portugal', 'S. C. Portugal', 'Real Madrid CF', 'Delantero', 7, 'Coca-Cola', 90000000),
(4, 'Karim', 'Mostafa Benzema', 'fotos/KarimMostafaBenzema.jpg', '1987-12-19', 'Lyon, Francia', 'Olympique Lyonnais', 'Real Madrid FC', 'Delantero', 9, 'Coca-Cola', 1000000000),
(5, 'Gareth', 'Frank Bale', 'fotos/GarethFrankBale.jpg', '1989-07-16', 'Cardiff, Gales', 'Southampton F. C.', 'Real Madrid CF', 'Delantero Later', 11, 'btwin', 99743542),
(6, 'Filipe Lu&iacute;s', 'Kasmirski', 'fotos/FilipeLuisKasmirski.jpg', '1985-08-09', 'Santa Catarina, Brasil', 'Figueirense', 'Atl&eacute;tico de Madrid', 'Defensa', 3, 'Trade Plus 500', 16000000),
(7, 'Unai', 'Núñez Gestoso', 'fotos/UnaiNezGestoso.jpg', '1997-01-30', 'Portugalete', NULL, 'Athletic Club de Bilbao', 'Defensa', 30, 'kutxabank', 300000),
(8, 'Sergio', 'García Guerrero de la Fuente', 'fotos/SergioGarcaGuerrerodelaFuente.jpg', '1983-06-09', 'Barcelona', 'F. C. Barcelona', 'RCD Espanyol', 'Delantero Centr', 9, 'Inter Apuestas', 150000),
(9, 'Fernando', 'José Torres Sanz', 'fotos/FernandoJosTorresSanz.jpg', '1984-03-20', 'Madrid', 'Atlético de Madrid', 'Atlético de Madrid', 'Delantero Centr', 9, 'Azerbaijan', 4000000),
(10, 'Lionel Andrés Messi', 'Cuccittini', 'fotos/LionelAndrsMessiCuccittini.jpg', '1987-06-24', 'Rosario, Argentina', 'F.C. Barcelona', 'F.C. Barcelona', 'Delantero Centr', 10, 'Rakuten', 120000000),
(11, 'Simone', 'Zaza', 'fotos/SimoneZaza.jpg', '1991-06-25', 'Policoro, Italia', 'Atlanta', 'Valencia C.F', 'Delantero Centr', 9, 'BLU Bold Like Us', 16000000),
(12, 'Roberto', 'Jiménez Gago', 'fotos/RobertoJimnezGago.jpg', '1986-02-10', 'Fuenlabrada, Madrid', 'Atlético de Madrid B', 'Málaga C.F', 'Portero', 16, 'Unicef', 9000000),
(13, 'Álvaro', 'García Segovia', 'fotos/lvaroGarcaSegovia.jpg', '2000-06-01', 'Madrid', NULL, 'Albacete Balompié Juvenil A', 'Centrocampista', 14, NULL, 5000),
(14, 'Abel', 'Ruiz Ortega', 'fotos/AbelRuizOrtega.jpg', '2000-01-28', 'Barcelona', 'F.C. Barecelona', 'F.C. Barcelona B', 'Delantero Centr', 9, 'Rakuten', 100000),
(15, 'Marco', 'Asensio Willemsen', 'fotos/MarcoAsensioWillemsen.jpg', '1996-01-21', 'Madrid', 'R.C.D Mallorca', 'Real Madrid C.F', 'Delantero Later', 20, 'Fly Emirates', 30000000),
(16, 'Marcos', 'Llorente Moreno', 'fotos/MarcosLlorenteMoreno.jpg', '1995-01-30', 'Madrid', 'Real Madrid Castilla C.F', 'Real Madrid C.F', 'Centrocampista', 18, 'Fly Emirates', 15000000),
(17, 'Paulo', 'Exequiel Dybala', 'fotos/PauloExequielDybala.jpg', '1993-11-15', 'Laguna Larga, Argentina', 'Instituto', 'Juventus F.C.', 'Delantero Centr', 10, 'Jeep', 70000000),
(18, 'Leonardo', 'Merio', 'fotos/default.jpg', '1999-03-28', 'Omegna', NULL, 'Juventus Primavera', 'Centrocampista', 34, 'Jeep', 50000);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
