-- Adminer 4.3.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `bans`;
CREATE TABLE `bans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `untill` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `bans_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


SET NAMES utf8mb4;

DROP TABLE IF EXISTS `config`;
CREATE TABLE `config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `SETTING_NAME` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `SETTING_VALUE` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SETTING_INPUT` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `languages`;
CREATE TABLE `languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `showname` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `hidden_native_entry` int(11) NOT NULL,
  `flag` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `activated` int(11) NOT NULL,
  `locale` varchar(8) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `color` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `locale` (`locale`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `log`;
CREATE TABLE `log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `identifier` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `record` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `log_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `survey_answers`;
CREATE TABLE `survey_answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `survey_session` int(11) NOT NULL,
  `word` int(11) NOT NULL,
  `word_group` int(11) NOT NULL,
  `answer` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `match` int(11) NOT NULL,
  `revised` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `survey_session` (`survey_session`),
  KEY `word` (`word`),
  KEY `word_group` (`word_group`),
  CONSTRAINT `survey_answers_ibfk_1` FOREIGN KEY (`survey_session`) REFERENCES `survey_sessions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `survey_answers_ibfk_2` FOREIGN KEY (`word`) REFERENCES `survey_words` (`id`) ON DELETE CASCADE,
  CONSTRAINT `survey_answers_ibfk_3` FOREIGN KEY (`word_group`) REFERENCES `survey_word_groups` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `survey_background_answers`;
CREATE TABLE `survey_background_answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `survey_session` int(11) NOT NULL,
  `survey_question` int(11) NOT NULL,
  `answer` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `survey_session` (`survey_session`),
  KEY `survey_question` (`survey_question`),
  CONSTRAINT `survey_background_answers_ibfk_1` FOREIGN KEY (`survey_session`) REFERENCES `survey_sessions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `survey_background_answers_ibfk_2` FOREIGN KEY (`survey_question`) REFERENCES `survey_background_questions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `survey_background_dropdown_options`;
CREATE TABLE `survey_background_dropdown_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dropdown_option` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dropdown_value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dropdown_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `survey_background_questions`;
CREATE TABLE `survey_background_questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_slide` int(11) NOT NULL DEFAULT '0',
  `force_noButtons` int(11) NOT NULL,
  `slideText` text COLLATE utf8_unicode_ci NOT NULL,
  `doneStatus` int(11) NOT NULL,
  `internID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `language` int(11) NOT NULL,
  `sorter` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `language` (`language`),
  CONSTRAINT `survey_background_questions_ibfk_1` FOREIGN KEY (`language`) REFERENCES `survey_languages` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `survey_correct_translations`;
CREATE TABLE `survey_correct_translations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `survey_word` int(11) NOT NULL,
  `language` int(11) NOT NULL,
  `translation` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `survey_word` (`survey_word`),
  KEY `language` (`language`),
  CONSTRAINT `survey_correct_translations_ibfk_1` FOREIGN KEY (`survey_word`) REFERENCES `survey_words` (`id`) ON DELETE CASCADE,
  CONSTRAINT `survey_correct_translations_ibfk_2` FOREIGN KEY (`language`) REFERENCES `survey_languages` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `survey_languages`;
CREATE TABLE `survey_languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `language_locale` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `choosable` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `survey_sessions`;
CREATE TABLE `survey_sessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ipadress` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `location` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `language` int(11) NOT NULL,
  `date_started` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `doneStatus` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `language` (`language`),
  CONSTRAINT `survey_sessions_ibfk_1` FOREIGN KEY (`language`) REFERENCES `survey_languages` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `survey_words`;
CREATE TABLE `survey_words` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `word` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `audiofile` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `language` int(11) NOT NULL,
  `survey_word_group` int(11) NOT NULL,
  `internID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `language` (`language`),
  KEY `survey_word_group` (`survey_word_group`),
  CONSTRAINT `survey_words_ibfk_1` FOREIGN KEY (`language`) REFERENCES `survey_languages` (`id`) ON DELETE CASCADE,
  CONSTRAINT `survey_words_ibfk_2` FOREIGN KEY (`survey_word_group`) REFERENCES `survey_word_groups` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `survey_word_groups`;
CREATE TABLE `survey_word_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `word_group_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `internID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `language` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `language` (`language`),
  CONSTRAINT `survey_word_groups_ibfk_1` FOREIGN KEY (`language`) REFERENCES `survey_languages` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `longname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `reg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `role` int(11) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `activated` int(11) NOT NULL,
  `might_be_banned` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `disable_notifications` int(11) NOT NULL,
  `about` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `user_activation`;
CREATE TABLE `user_activation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `untill` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ipadress` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `user_activation_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- 2018-03-25 11:51:39
