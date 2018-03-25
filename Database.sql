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
(1, 'ENABLE_QUERY_CACHING', '0',  'input'),
(2, 'QC_TIME',  '100000', 'input'),
(3, 'SITE_TITLE', 'Example Dictionary', 'input'),
(4, 'LOGO_TITLE', 'Example Dictionary', 'input'),
(5, 'HOMEPAGE', 'assistant',  'input'),
(12,  'SITE_DESC',  '', 'input'),
(13,  'ACTIVE_LOCALE',  'English',  'input'),
(14,  'ENABLE_REGISTER',  '1',  'input'),
(15,  'REGISTER_DEFAULT_ROLE',  '3',  'input'),
(16,  'ENABLE_DEFINITIONS', '1',  'input'),
(17,  'LOGO_SYMBOL',  'fab fa-wpforms', 'input'),
(18,  'MAIL_FROM',  'noreply@localhost',  'input'),
(19,  'ENABLE_ACTIVATION_MAIL', '1',  'input'),
(20,  'ENABLE_TOS', '1',  'input'),
(21,  'MAIL_FROM_NAME', 'Donut dictionary', 'input'),
(22,  'REGISTER_ADMIN_ACTIVATION',  '0',  'input'),
(23,  'PAGE_MARGIN',  '6%', 'input'),
(24,  'ALWAYS_SHOW_LAST_UPDATE',  '0',  'input'),
(25,  'PERMISSION_CREATE_LEMMAS', '-3', 'input'),
(27,  'HEADER_CSS_BACKGROUND',  'background-color: #121D23;', 'input'),
(28,  'HEADER_CSS_HSEARCH', '', 'input'),
(29,  'ACCENT_COLOR_1', '#3454d1;', 'input'),
(30,  'ACCENT_COLOR_2', '#C62B4A;', 'input'),
(31,  'MENU_BREAK', '1',  ''),
(32,  'WIKI_LOCALE',  'EN', 'input'),
(33,  'TEST', '\\\'hoi\\',  'input'),
(34,  'NUMBER_OF_DOORS_IN_THIS_HOUSE',  '\\\'3\\',  'input'),
(35,  'ACCENT_COLOR_3', '#256BD7;', 'input');

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

INSERT INTO `survey_answers` (`id`, `survey_session`, `word`, `word_group`, `answer`, `match`, `revised`) VALUES
(1, 11, 1,  1,  '', 0,  0),
(2, 12, 1,  1,  'skepp',  2147483647, 0),
(3, 13, 1,  1,  'skepp',  1,  0),
(4, 16, 1,  1,  'ske',  2147483647, 0),
(5, 15, 1,  1,  'skepp',  1,  0),
(6, 20, 1,  1,  'skepp',  1,  0),
(7, 20, 2,  1,  'skep', 2147483647, 0),
(8, 20, 3,  2,  'rädd', 1,  0),
(9, 22, 1,  1,  'skepd',  0,  0),
(10,  22, 2,  1,  'skepp',  0,  0),
(11,  22, 3,  2,  'bang', 0,  0),
(12,  23, 1,  1,  'sss',  2147483647, 0),
(13,  23, 2,  1,  'skepp',  2147483647, 0),
(14,  23, 3,  2,  'rädd', 1,  0),
(15,  23, 1,  1,  'skepp',  1,  0),
(16,  23, 2,  1,  'skep', 0,  0),
(17,  23, 3,  2,  'rädd', 1,  0),
(18,  24, 1,  1,  '', 0,  0),
(19,  24, 2,  1,  '', 0,  0),
(20,  24, 3,  2,  '', 0,  0),
(21,  25, 1,  1,  '', 0,  0),
(22,  25, 2,  1,  '', 0,  0),
(23,  25, 3,  2,  '', 0,  0),
(24,  26, 1,  1,  'skepp',  1,  0),
(25,  26, 2,  1,  'skepp',  0,  0),
(26,  26, 3,  2,  'bang', 0,  0),
(27,  29, 1,  1,  'schiff', 0,  0),
(28,  29, 2,  1,  'schiff', 0,  0),
(29,  29, 3,  2,  'Bange?', 0,  0),
(30,  30, 1,  1,  'g',  0,  0),
(31,  30, 2,  1,  'ghdfhg', 0,  0),
(32,  30, 3,  2,  '', 0,  0),
(33,  31, 1,  1,  'asdfs',  0,  0),
(34,  31, 2,  1,  'asdfsdf',  0,  0),
(35,  31, 3,  2,  'asdf', 0,  0),
(36,  33, 1,  1,  'skepp',  1,  0),
(37,  33, 2,  1,  'skepp',  0,  0),
(38,  33, 3,  2,  'rädd', 1,  0),
(39,  34, 1,  1,  '', 0,  0),
(40,  34, 2,  1,  '', 0,  0),
(41,  34, 3,  2,  '', 0,  0),
(42,  35, 1,  1,  'skepp',  1,  0),
(43,  35, 2,  1,  'skepp',  0,  0),
(44,  35, 3,  2,  'skepp',  0,  0);

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
(7, 3,  1,  'nederländska'),
(8, 3,  3,  'Spanien'),
(9, 4,  2,  'Deutsch'),
(10,  4,  4,  'Berlin'),
(11,  7,  1,  'nl'),
(12,  7,  3,  ''),
(13,  8,  1,  'nl'),
(14,  8,  3,  'Berlin'),
(15,  9,  1,  'nl'),
(16,  9,  3,  'Stockholm'),
(17,  10, 1,  'nl'),
(18,  10, 3,  'Berlin'),
(19,  11, 1,  'nl'),
(20,  11, 3,  'Stockholm'),
(21,  12, 1,  'nl'),
(22,  12, 3,  'Groningen'),
(23,  13, 1,  'nl'),
(24,  13, 3,  'ssdsd'),
(25,  14, 1,  'nl'),
(26,  14, 3,  'Groningen'),
(27,  15, 1,  'en'),
(28,  15, 3,  ''),
(29,  16, 1,  'nl'),
(30,  16, 3,  'Stockholm'),
(31,  18, 1,  '0'),
(32,  19, 1,  'nl'),
(33,  20, 1,  'nl'),
(34,  20, 3,  ''),
(35,  21, 1,  'nl'),
(36,  22, 1,  'nl'),
(37,  22, 3,  'Groningen'),
(38,  23, 1,  'nl'),
(39,  23, 3,  'dd'),
(40,  24, 6,  'nl'),
(41,  24, 7,  'nej'),
(42,  25, 1,  'nl'),
(43,  25, 3,  'Groningen'),
(44,  25, 6,  'sv'),
(45,  25, 7,  'nej'),
(46,  26, 1,  'nl'),
(47,  26, 3,  ''),
(48,  26, 6,  'nl'),
(49,  26, 7,  ''),
(50,  27, 1,  'nl'),
(51,  27, 3,  ''),
(52,  28, 1,  'sv'),
(53,  28, 3,  'Groningen'),
(54,  29, 2,  '3'),
(55,  29, 4,  'Berlin'),
(56,  30, 1,  'nl'),
(57,  30, 3,  'ghfdgh'),
(58,  30, 6,  'nl'),
(59,  30, 7,  ''),
(60,  31, 1,  'nl'),
(61,  31, 3,  'asdfdsf'),
(62,  31, 6,  'nl'),
(63,  31, 7,  ''),
(64,  32, 1,  'nl'),
(65,  33, 1,  'nl'),
(66,  33, 3,  'Groningen'),
(67,  33, 6,  'en'),
(68,  33, 7,  'NEJ!'),
(69,  34, 1,  'nl'),
(70,  34, 3,  ''),
(71,  34, 6,  'nl'),
(72,  34, 7,  ''),
(73,  35, 1,  'sv'),
(74,  35, 3,  'groningen'),
(75,  35, 6,  'nl'),
(76,  35, 7,  'df'),
(77,  36, 1,  'sv'),
(78,  36, 3,  'Groningen'),
(79,  36, 6,  'nl'),
(80,  36, 7,  ''),
(81,  37, 1,  'nl'),
(82,  37, 3,  'groningen');

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
(6, 'Tänkte du det var svårt?', 0,  0,  '', 1,  'status', 2,  -1, 'nl_SV'),
(7, 'Tänkte du det var svårt?', 0,  0,  '', 1,  'status', 2,  -1, 'input'),
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
  PRIMARY KEY (`id`),
  KEY `language` (`language`),
  CONSTRAINT `survey_sessions_ibfk_1` FOREIGN KEY (`language`) REFERENCES `survey_languages` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `survey_sessions` (`id`, `ipadress`, `location`, `language`, `date_started`, `doneStatus`) VALUES
(1, '::1',  'Somewhere',  1,  '2018-03-24 11:52:21',  0),
(2, '::1',  'Somewhere',  2,  '2018-03-24 12:02:27',  0),
(3, '::1',  'Somewhere',  2,  '2018-03-24 12:18:09',  0),
(4, '::1',  'Somewhere',  3,  '2018-03-24 12:28:12',  0),
(5, '::1',  'Somewhere',  3,  '2018-03-24 12:39:58',  0),
(6, '::1',  'Somewhere',  3,  '2018-03-24 12:44:22',  0),
(7, '::1',  'Somewhere',  2,  '2018-03-24 13:53:04',  0),
(8, '::1',  'Somewhere',  2,  '2018-03-24 14:12:58',  0),
(9, '::1',  'Somewhere',  2,  '2018-03-24 14:15:24',  0),
(10,  '::1',  'Somewhere',  2,  '2018-03-24 14:34:40',  0),
(11,  '::1',  'Somewhere',  2,  '2018-03-24 14:58:53',  0),
(12,  '::1',  'Somewhere',  2,  '2018-03-24 15:17:42',  0),
(13,  '::1',  'Somewhere',  2,  '2018-03-24 15:18:07',  0),
(14,  '::1',  'Somewhere',  2,  '2018-03-24 15:21:31',  0),
(15,  '::1',  'Somewhere',  2,  '2018-03-24 15:26:58',  0),
(16,  '::1',  'Somewhere',  2,  '2018-03-24 15:52:47',  0),
(17,  '::1',  'Somewhere',  3,  '2018-03-24 16:28:36',  0),
(18,  '::1',  'Somewhere',  2,  '2018-03-24 16:28:51',  0),
(19,  '::1',  'Somewhere',  2,  '2018-03-24 16:43:11',  0),
(20,  '::1',  'Somewhere',  2,  '2018-03-24 16:51:12',  0),
(21,  '::1',  'Somewhere',  2,  '2018-03-24 16:55:40',  0),
(22,  '::1',  'Somewhere',  2,  '2018-03-24 17:00:01',  0),
(23,  '::1',  'Somewhere',  2,  '2018-03-24 17:01:36',  0),
(24,  '::1',  'Somewhere',  2,  '2018-03-24 17:11:07',  0),
(25,  '::1',  'Somewhere',  2,  '2018-03-24 17:19:10',  0),
(26,  '::1',  'Somewhere',  2,  '2018-03-24 17:22:35',  0),
(27,  '::1',  'Somewhere',  2,  '2018-03-24 17:27:02',  0),
(28,  '::1',  'Somewhere',  2,  '2018-03-24 17:38:58',  0),
(29,  '::1',  'Somewhere',  3,  '2018-03-24 17:39:32',  0),
(30,  '::1',  'Somewhere',  2,  '2018-03-24 17:40:14',  0),
(31,  '::1',  'Somewhere',  2,  '2018-03-24 17:41:21',  0),
(32,  '::1',  'Somewhere',  2,  '2018-03-24 17:44:23',  0),
(33,  '::1',  'Somewhere',  2,  '2018-03-24 17:48:09',  2147483647),
(34,  '::1',  'Somewhere',  2,  '2018-03-24 17:49:52',  1),
(35,  '::1',  'Somewhere',  2,  '2018-03-24 18:51:28',  1),
(36,  '::1',  'Somewhere',  2,  '2018-03-25 11:00:27',  1),
(37,  '::1',  'Somewhere',  2,  '2018-03-25 11:00:31',  2147483647);

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

INSERT INTO `survey_words` (`id`, `word`, `audiofile`, `language`, `survey_word_group`, `internID`) VALUES
(1, 'schip',  'schip.ogg',  1,  1,  'schip'),
(2, '', 'schip.ogg',  1,  1,  'schipX'),
(3, '', 'bang.ogg', 1,  2,  'bang');

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


-- 2018-03-25 11:54:24
