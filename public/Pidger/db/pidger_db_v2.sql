-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-01-2018 a las 11:45:51
-- Versión del servidor: 10.1.28-MariaDB
-- Versión de PHP: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `pidger`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `blocks`
--

CREATE TABLE `blocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `userA` bigint(20) NOT NULL,
  `userB` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `follows`
--

CREATE TABLE `follows` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `follower` bigint(20) NOT NULL,
  `following` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `friends`
--

CREATE TABLE `friends` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `userA` bigint(20) NOT NULL,
  `userB` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `likedcontent`
--

CREATE TABLE `likedcontent` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `likedmsg` bigint(20) NOT NULL,
  `user` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `media`
--

CREATE TABLE `media` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `message` bigint(20) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `width` int(11) DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `length` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `author` bigint(20) NOT NULL,
  `postdate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `content` varchar(500) COLLATE utf8mb4_bin NOT NULL,
  `medialist` varchar(1000) COLLATE utf8mb4_bin DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `shared` bigint(20) DEFAULT NULL,
  `replyto` bigint(20) DEFAULT NULL,
  `likes` int(11) NOT NULL DEFAULT '0',
  `tags` varchar(500) COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `messagetags`
--

CREATE TABLE `messagetags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `message` bigint(20) NOT NULL,
  `tag` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reportedmessages`
--

CREATE TABLE `reportedmessages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `message` bigint(20) NOT NULL,
  `user` bigint(20) NOT NULL,
  `reason` varchar(300) COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `userid` bigint(20) NOT NULL,
  `session_key` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `login_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `login_expire` datetime NOT NULL,
  `browser_agent` varchar(300) COLLATE utf8mb4_bin NOT NULL DEFAULT 'Unknown',
  `client_ip` varchar(40) COLLATE utf8mb4_bin NOT NULL DEFAULT ':::0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tags`
--

CREATE TABLE `tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `mentions` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `userdata`
--

CREATE TABLE `userdata` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nick` varchar(30) COLLATE utf8mb4_bin NOT NULL,
  `name` varchar(40) COLLATE utf8mb4_bin NOT NULL,
  `surname` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `birthdate` date NOT NULL,
  `gender` char(1) COLLATE utf8mb4_bin NOT NULL DEFAULT 'O',
  `adress` varchar(300) COLLATE utf8mb4_bin DEFAULT NULL,
  `phone` varchar(16) COLLATE utf8mb4_bin DEFAULT NULL,
  `nationality` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `mail` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `eula` tinyint(1) NOT NULL DEFAULT '0',
  `news` tinyint(1) NOT NULL DEFAULT '0',
  `cookies` tinyint(1) NOT NULL DEFAULT '0',
  `privacy` tinyint(1) NOT NULL DEFAULT '0',
  `avatar` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `banned` tinyint(1) NOT NULL DEFAULT '0',
  `reason` varchar(300) COLLATE utf8mb4_bin DEFAULT NULL,
  `expire` datetime DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `type` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `userprivacy`
--

CREATE TABLE `userprivacy` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user` bigint(20) NOT NULL,
  `showname` tinyint(4) NOT NULL DEFAULT '0',
  `publicmail` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `blocks`
--
ALTER TABLE `blocks`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `follows`
--
ALTER TABLE `follows`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `likedcontent`
--
ALTER TABLE `likedcontent`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `messagetags`
--
ALTER TABLE `messagetags`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `reportedmessages`
--
ALTER TABLE `reportedmessages`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `userdata`
--
ALTER TABLE `userdata`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `userprivacy`
--
ALTER TABLE `userprivacy`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `blocks`
--
ALTER TABLE `blocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `follows`
--
ALTER TABLE `follows`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `friends`
--
ALTER TABLE `friends`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `likedcontent`
--
ALTER TABLE `likedcontent`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `media`
--
ALTER TABLE `media`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `messagetags`
--
ALTER TABLE `messagetags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reportedmessages`
--
ALTER TABLE `reportedmessages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tags`
--
ALTER TABLE `tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `userdata`
--
ALTER TABLE `userdata`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `userprivacy`
--
ALTER TABLE `userprivacy`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
