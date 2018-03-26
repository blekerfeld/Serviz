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

INSERT INTO `config` (`id`, `SETTING_NAME`, `SETTING_VALUE`, `SETTING_INPUT`) VALUES
(1, 'ENABLE_QUERY_CACHING', '1',  'input'),
(2, 'QC_TIME',  '100000', 'input'),
(3, 'SITE_TITLE', 'Example Dictionary', 'input'),
(4, 'LOGO_TITLE', 'Example Dictionary', 'input'),
(5, 'HOMEPAGE', 'assistant',  'input'),
(12,  'SITE_DESC',  '', 'input'),
(13,  'ACTIVE_LOCALE',  'English',  'input'),
(14,  'ENABLE_REGISTER',  '1',  'input'),
(15,  'REGISTER_DEFAULT_ROLE',  '3',  'input'),
(17,  'LOGO_SYMBOL',  'fab fa-wpforms', 'input'),
(18,  'MAIL_FROM',  'noreply@localhost',  'input'),
(19,  'ENABLE_ACTIVATION_MAIL', '1',  'input'),
(20,  'ENABLE_TOS', '1',  'input'),
(22,  'REGISTER_ADMIN_ACTIVATION',  '0',  'input'),
(23,  'PAGE_MARGIN',  '6%', 'input'),
(24,  'ALWAYS_SHOW_LAST_UPDATE',  '0',  'input'),
(25,  'PERMISSION_CREATE_LEMMAS', '-3', 'input'),
(29,  'ACCENT_COLOR_1', '#3454d1;', 'input'),
(30,  'ACCENT_COLOR_2', '#C62B4A;', 'input'),
(31,  'MENU_BREAK', '1',  ''),
(35,  'ACCENT_COLOR_3', '#256BD7;', 'input'),
(36,  'LOCAL_LOGO', 'serviz://library/staticimages/logoSurvey.png', '');

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

INSERT INTO `languages` (`id`, `name`, `showname`, `hidden_native_entry`, `flag`, `activated`, `locale`, `color`) VALUES
(0, 'Dutch',  'Dutch',  0,  'nl.png', 1,  'NL', '#3B66D6'),
(1, 'English',  'English',  0,  'gb.png', 1,  'EN', '#D33B3B'),
(15,  'Swedish',  'Swedish',  0,  'se.png', 0,  'SV', '#E5C839');

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

INSERT INTO `log` (`id`, `identifier`, `record`, `user_id`, `timestamp`) VALUES
(2, 'new_lemma',  67, 1,  '2017-09-02 19:21:49'),
(3, 'edit_lemma', 17, 1,  '2017-09-17 09:24:50'),
(4, 'edit_lemma', 65, 1,  '2017-09-17 09:37:45'),
(5, 'new_lemma',  0,  1,  '2017-09-17 13:54:42'),
(6, 'new_lemma',  68, 1,  '2017-09-17 21:23:49'),
(7, 'edit_lemma', 1,  1,  '2017-09-17 22:37:24'),
(8, 'new_lemma',  69, 1,  '2017-09-17 22:44:25'),
(9, 'edit_lemma', 42, 1,  '2017-09-20 22:17:04'),
(10,  'edit_lemma', 42, 1,  '2017-09-20 22:18:46'),
(11,  'edit_lemma', 18, 1,  '2017-09-21 07:45:14'),
(12,  'edit_lemma', 42, 1,  '2017-09-21 08:24:27'),
(13,  'edit_lemma', 38, 1,  '2017-09-21 08:25:15'),
(15,  'new_lemma',  0,  1,  '2017-09-28 09:59:45'),
(16,  'edit_lemma', 42, 1,  '2017-09-29 08:13:31'),
(17,  'new_lemma',  1337, 1,  '2017-10-02 22:12:37'),
(18,  'edit_lemma', 1337, 1,  '2017-10-02 22:23:39'),
(19,  'new_lemma',  1338, 1,  '2017-10-02 22:29:30'),
(25,  'new_lemma',  1340, 1,  '2017-11-18 22:34:23'),
(26,  'edit_lemma', 1340, 1,  '2017-11-18 22:34:51'),
(27,  'new_lemma',  1341, 1,  '2017-11-18 23:06:05'),
(28,  'new_lemma',  1342, 1,  '2017-11-18 23:56:00'),
(32,  'new_lemma',  1345, 1,  '2018-02-19 12:05:59'),
(35,  'new_lemma',  1347, 1,  '2018-03-10 02:10:17'),
(36,  'new_lemma',  0,  1,  '2018-03-10 02:10:31'),
(37,  'new_lemma',  0,  1,  '2018-03-12 21:38:25'),
(38,  'new_lemma',  1351, 1,  '2018-03-12 21:40:38'),
(39,  'new_lemma',  1352, 1,  '2018-03-12 21:42:11'),
(40,  'new_lemma',  1353, 1,  '2018-03-12 23:04:03'),
(41,  'new_lemma',  1354, 1,  '2018-03-12 23:26:14'),
(42,  'edit_lemma', 1354, 1,  '2018-03-12 23:26:44'),
(43,  'edit_lemma', 1354, 1,  '2018-03-12 23:27:39'),
(44,  'new_lemma',  1355, 1,  '2018-03-12 23:38:12'),
(45,  'edit_lemma', 1355, 1,  '2018-03-12 23:45:02'),
(46,  'edit_lemma', 1355, 1,  '2018-03-12 23:47:34'),
(47,  'edit_lemma', 1355, 1,  '2018-03-12 23:48:01'),
(48,  'edit_lemma', 1355, 1,  '2018-03-12 23:49:01');

DROP TABLE IF EXISTS `survey_answers`;
CREATE TABLE `survey_answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `survey_session` int(11) NOT NULL,
  `word` int(11) NOT NULL,
  `word_group` int(11) NOT NULL,
  `answer` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `isMatch` tinyint(4) NOT NULL,
  `revised` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `survey_session` (`survey_session`),
  KEY `word` (`word`),
  KEY `word_group` (`word_group`),
  CONSTRAINT `survey_answers_ibfk_1` FOREIGN KEY (`survey_session`) REFERENCES `survey_sessions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `survey_answers_ibfk_2` FOREIGN KEY (`word`) REFERENCES `survey_words` (`id`) ON DELETE CASCADE,
  CONSTRAINT `survey_answers_ibfk_3` FOREIGN KEY (`word_group`) REFERENCES `survey_word_groups` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `survey_answers` (`id`, `survey_session`, `word`, `word_group`, `answer`, `isMatch`, `revised`) VALUES
(45,  42, 1,  1,  'schip',  1,  1),
(46,  42, 2,  1,  'skeppr', 0,  1),
(47,  42, 3,  2,  'rqdd', 0,  1),
(48,  44, 1,  1,  'skeppppe', 0,  1),
(49,  48, 4,  1,  'jurk', 0,  0);

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

INSERT INTO `survey_background_answers` (`id`, `survey_session`, `survey_question`, `answer`) VALUES
(87,  41, 1,  'nl'),
(88,  41, 3,  'Groningen'),
(89,  42, 1,  'sv'),
(90,  42, 3,  'Groningen'),
(91,  43, 1,  'nl'),
(92,  43, 3,  ''),
(93,  44, 1,  'nl'),
(94,  44, 3,  ''),
(95,  45, 1,  'nl'),
(96,  48, 2,  '3'),
(97,  48, 4,  ''),
(98,  50, 1,  'nl'),
(99,  50, 3,  '');

DROP TABLE IF EXISTS `survey_background_dropdown_options`;
CREATE TABLE `survey_background_dropdown_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dropdown_option` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dropdown_value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dropdown_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `survey_background_dropdown_options` (`id`, `dropdown_option`, `dropdown_value`, `dropdown_id`) VALUES
(1, 'Deutsch',  '3',  'nl_DE'),
(2, 'Niederländisch', '1',  'nl_DE'),
(3, 'Swedisch', '2',  'nl_DE'),
(4, 'nederländska', 'nl', 'nl_SV'),
(5, 'svenska',  'sv', 'nl_SV'),
(6, 'tyska',  'de', 'nl_SV'),
(7, 'engelska', 'en', 'nl_SV'),
(8, 'annorlunda', '0',  'nl_SV');

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

INSERT INTO `survey_background_questions` (`id`, `question`, `is_slide`, `force_noButtons`, `slideText`, `doneStatus`, `internID`, `language`, `sorter`, `type`) VALUES
(1, 'Vad är ditt modersmål?', 0,  0,  '', 0,  'nativelang', 2,  -1, 'nl_SV'),
(2, 'Was ist Ihre Muttersprache?',  0,  0,  '', 0,  'nativelang', 3,  -1, 'nl_DE'),
(3, 'Var bor du?',  0,  0,  '', 0,  'living', 2,  2,  'input'),
(4, 'Wo wohnen Sie?', 0,  0,  '', 0,  'living', 3,  2,  'input'),
(5, '.',  1,  0,  '# Välkommen! <br /> \r\n\r\nVi vill gärna veta hur bra svenskspråkiga är på att nederländska ord utan någon kontext. Därför är vi tacksamma att du fyller i enkäten!\r\n\r\nSjälvklart förblir du fullständigt anonym och datan kommer endast att användas för forskningen vid Universitet i Groningen (NL).\r\n\r\nFörst får du några bakgrundfrågor (ålder, modersmål etc) och sedan får du översätta både talade och skrivna ord. Sätt på volymen på din dator innan du börjar!\r\n\r\nTack för att du deltar! ', 0,  'slide1', 2,  -3, ''),
(8, '', 1,  1,  'Tack så mycket för ditt bidrag!',  1,  'finalslide', 2,  9999, '');

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

INSERT INTO `survey_correct_translations` (`id`, `survey_word`, `language`, `translation`) VALUES
(1, 1,  2,  'skepp'),
(2, 3,  2,  'rädd'),
(3, 3,  2,  'rätt');

DROP TABLE IF EXISTS `survey_languages`;
CREATE TABLE `survey_languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `language_locale` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `choosable` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `survey_languages` (`id`, `language_name`, `language_locale`, `choosable`) VALUES
(1, 'Nederlands', 'NL', 0),
(2, 'svenska',  'SV', 1),
(3, 'Deutsch',  'DE', 1);

DROP TABLE IF EXISTS `survey_sessions`;
CREATE TABLE `survey_sessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ipadress` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `location` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `language` int(11) NOT NULL,
  `date_started` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `doneStatus` int(11) NOT NULL,
  `survey_version` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `language` (`language`),
  KEY `survey_version` (`survey_version`),
  CONSTRAINT `survey_sessions_ibfk_1` FOREIGN KEY (`language`) REFERENCES `survey_languages` (`id`) ON DELETE CASCADE,
  CONSTRAINT `survey_sessions_ibfk_2` FOREIGN KEY (`survey_version`) REFERENCES `survey_versions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `survey_sessions` (`id`, `ipadress`, `location`, `language`, `date_started`, `doneStatus`, `survey_version`) VALUES
(40,  '::1',  'Somewhere',  3,  '2018-03-25 19:52:15',  2147483647, 1),
(41,  '::1',  'Somewhere',  2,  '2018-03-25 19:53:46',  1,  1),
(42,  '::1',  'Somewhere',  2,  '2018-03-25 19:54:10',  1,  1),
(43,  '::1',  'Somewhere',  2,  '2018-03-25 23:48:48',  2147483647, 1),
(44,  '::1',  'Somewhere',  2,  '2018-03-26 08:55:38',  2147483647, 1),
(45,  '::1',  'Somewhere',  2,  '2018-03-26 09:21:33',  2147483647, 1),
(46,  '::1',  'Somewhere',  2,  '2018-03-26 09:47:33',  2147483647, 1),
(47,  '::1',  'Somewhere',  2,  '2018-03-26 09:48:04',  2147483647, 1),
(48,  '::1',  'Somewhere',  3,  '2018-03-26 10:03:06',  1,  2),
(49,  '::1',  'Somewhere',  2,  '2018-03-26 10:05:37',  0,  1),
(50,  '::1',  'Somewhere',  2,  '2018-03-26 10:19:38',  0,  2);

DROP TABLE IF EXISTS `survey_versions`;
CREATE TABLE `survey_versions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `internName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `usageCount` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `survey_versions` (`id`, `internName`, `usageCount`) VALUES
(1, 'A',  2),
(2, 'B',  2);

DROP TABLE IF EXISTS `survey_words`;
CREATE TABLE `survey_words` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `word` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `audiofile` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `language` int(11) NOT NULL,
  `survey_word_group` int(11) NOT NULL,
  `survey_version` int(11) NOT NULL,
  `internID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `language` (`language`),
  KEY `survey_word_group` (`survey_word_group`),
  KEY `survey_version` (`survey_version`),
  CONSTRAINT `survey_words_ibfk_1` FOREIGN KEY (`language`) REFERENCES `survey_languages` (`id`) ON DELETE CASCADE,
  CONSTRAINT `survey_words_ibfk_2` FOREIGN KEY (`survey_word_group`) REFERENCES `survey_word_groups` (`id`) ON DELETE CASCADE,
  CONSTRAINT `survey_words_ibfk_3` FOREIGN KEY (`survey_version`) REFERENCES `survey_versions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `survey_words` (`id`, `word`, `audiofile`, `language`, `survey_word_group`, `survey_version`, `internID`) VALUES
(1, 'schip',  'schip.ogg',  1,  1,  1,  'schip'),
(2, '', 'schip.ogg',  1,  1,  1,  'schipX'),
(3, '', 'bang.ogg', 1,  2,  1,  'bang'),
(4, '', 'jurk.ogg', 1,  1,  2,  'jurkAUDIO');

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

INSERT INTO `survey_word_groups` (`id`, `word_group_name`, `internID`, `language`) VALUES
(1, 'With soundchange', 'soundchange',  1),
(2, 'Control',  'control',  1);

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

INSERT INTO `users` (`id`, `longname`, `username`, `password`, `reg_date`, `role`, `avatar`, `activated`, `might_be_banned`, `email`, `disable_notifications`, `about`) VALUES
(-1,  'system', 'SYSTEM', 'root', '2017-09-23 21:10:42',  0,  '', 1,  0,  'root@SYSTEM',  1,  ''),
(0, 'Guest',  'guest',  '', '2017-08-24 12:04:51',  4,  '', 1,  0,  'niet@veel.com',  0,  ''),
(1, 'Serviz User',  'serviz', 'e69fd784f93f82eb6bf5148f0a0e3f5282df5ac10427ab3d6704799adca95a07', '2018-03-25 11:38:18',  0,  'serviz://library/staticimages/default_avatar.png', 1,  0,  'serviz@localhost', 0,  '');

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


-- 2018-03-26 10:41:29
