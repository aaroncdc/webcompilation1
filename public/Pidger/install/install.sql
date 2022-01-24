SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE pidger DEFAULT CHARACTER SET utf8mb4 DEFAULT COLLATE utf8mb4_bin;

USE pidger;

CREATE TABLE `userprivacy` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user` bigint(20) NOT NULL,
  `showname` tinyint(4) NOT NULL DEFAULT '0',
  `publicmail` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

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


CREATE TABLE `tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `mentions` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `sessions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `userid` bigint(20) NOT NULL,
  `session_key` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `login_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `login_expire` datetime NOT NULL,
  `browser_agent` varchar(300) COLLATE utf8mb4_bin NOT NULL DEFAULT 'Unknown',
  `client_ip` varchar(40) COLLATE utf8mb4_bin NOT NULL DEFAULT ':::0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `reportedmessages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `message` bigint(20) NOT NULL,
  `user` bigint(20) NOT NULL,
  `reason` varchar(300) COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `messagetags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `message` bigint(20) NOT NULL,
  `tag` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

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

CREATE TABLE `likedcontent` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `likedmsg` bigint(20) NOT NULL,
  `user` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `friends` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `userA` bigint(20) NOT NULL,
  `userB` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `follows` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `follower` bigint(20) NOT NULL,
  `following` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `bug_reporting` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `error_number` int(11) NOT NULL DEFAULT '0',
  `error_description` varchar(500) COLLATE utf8mb4_bin DEFAULT NULL,
  `function` varchar(128) COLLATE utf8mb4_bin DEFAULT NULL,
  `backtrace` varchar(5000) COLLATE utf8mb4_bin DEFAULT NULL,
  `datetime` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `blocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `userA` bigint(20) NOT NULL,
  `userB` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

ALTER TABLE `blocks`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `bug_reporting`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `follows`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `friends`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `likedcontent`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `media`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `messagetags`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `reportedmessages`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `userdata`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `userprivacy`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `blocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `bug_reporting`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `follows`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `friends`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `likedcontent`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `media`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `messagetags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `reportedmessages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `sessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

ALTER TABLE `tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `userdata`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `userprivacy`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

INSERT INTO `userdata` (`id`, `nick`, `name`, `surname`, `password`, `birthdate`, `gender`, `adress`, `phone`, `nationality`, `mail`, `eula`, `news`, `cookies`, `privacy`, `avatar`, `active`, `banned`, `reason`, `expire`, `deleted`, `type`) VALUES
(1, 'Admin', 'Admin', '', '@pass', '1990-01-01', 'O', '', '+34', 'Espa&ntilde;a', '@mail', 1, 1, 1, 1, 'users/avatars/default.jpg', 0, 0, NULL, NULL, 0, 2);

INSERT INTO `userprivacy` (`id`, `user`, `showname`, `publicmail`) VALUES
(1, 1, 1, 0);

COMMIT;