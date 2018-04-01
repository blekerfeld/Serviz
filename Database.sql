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
(14,  'ENABLE_REGISTER',  '0',  'input'),
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
(36,  'LOCAL_LOGO', 'serviz://library/staticimages/logo.png', '');

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

DROP TABLE IF EXISTS `surveys`;
CREATE TABLE `surveys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `survey_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `survey_logo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `survey_status` tinyint(4) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `surveys_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `surveys` (`id`, `survey_name`, `survey_logo`, `survey_status`, `user_id`) VALUES
(2, 'LVIE cognates',  'serviz://library/staticimages/logoSurvey.png', 1,  1),
(3, 'test', 'serviz://library/staticimages/logoSurvey.png', 0,  -1),
(4, 'Tweede', '', 1,  0);

DROP TABLE IF EXISTS `survey_answers`;
CREATE TABLE `survey_answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `survey_session` int(11) NOT NULL,
  `word` int(11) NOT NULL,
  `word_group` int(11) NOT NULL,
  `answer` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `isMatch` float NOT NULL,
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
(73,  86, 9,  1,  'rädd', 0.5,  1),
(74,  86, 11, 1,  'gripa',  1,  1),
(75,  86, 12, 1,  'skepp',  1,  1);

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
(196, 86, 9,  '22'),
(197, 86, 10, '0'),
(198, 86, 11, 'sv'),
(199, 86, 12, 'fi'),
(200, 86, 13, 'no;0'),
(201, 86, 14, 'nederländska;engelska'),
(202, 86, 15, '1'),
(203, 86, 16, '1'),
(204, 86, 17, '3'),
(205, 86, 18, '5'),
(206, 88, 9,  '13'),
(207, 88, 10, '3'),
(208, 88, 11, 'sv'),
(209, 88, 12, 'sv'),
(210, 88, 13, 'sv;0;nl;en');

DROP TABLE IF EXISTS `survey_background_dropdown_options`;
CREATE TABLE `survey_background_dropdown_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dropdown_option` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dropdown_value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dropdown_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `survey_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `survey_id` (`survey_id`),
  CONSTRAINT `survey_background_dropdown_options_ibfk_1` FOREIGN KEY (`survey_id`) REFERENCES `surveys` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `survey_background_dropdown_options` (`id`, `dropdown_option`, `dropdown_value`, `dropdown_id`, `survey_id`) VALUES
(1, 'Deutsch',  '3',  'nl_DE',  2),
(2, 'Niederländisch', '1',  'nl_DE',  2),
(3, 'Swedisch', '2',  'nl_DE',  2),
(4, 'nederländska', 'nl', 'nl_SV',  2),
(5, 'svenska',  'sv', 'nl_SV',  2),
(6, 'tyska',  'de', 'nl_SV',  2),
(7, 'engelska', 'en', 'nl_SV',  2),
(8, 'annorlunda', '0',  'nl_SV',  2),
(9, 'varje dag',  '5',  'kontakt',  2),
(11,  'varje vecka',  '4',  'kontakt',  2),
(12,  'varje månad',  '3',  'kontakt',  2),
(15,  'mindre än årligen',  '1',  'kontakt',  2),
(16,  'aldrig', '0',  'kontakt',  2),
(17,  'kvinna', '0',  'sex_SV', 2),
(18,  'man',  '1',  'sex_SV', 2),
(19,  'annat',  '2',  'sex_SV', 2),
(20,  'vill inte säga', '3',  'sex_SV', 2),
(21,  'Sverige',  'sv', 'country_SV', 2),
(22,  'Finland',  'fi', 'country_SV', 2),
(23,  'Norge',  'no', 'country_SV', 2),
(24,  'Danmark',  'da', 'country_SV', 2),
(25,  'Nederländerna',  'nl', 'country_SV', 2),
(26,  'Belgien',  'be', 'country_SV', 2),
(27,  'Tyskland', 'de', 'country_SV', 2),
(28,  'Annat land', '0',  'country_SV', 2),
(30,  'nej',  '0',  'noyes_SV', 2),
(31,  'ja', '1',  'noyes_sv', 2),
(33,  'svenska',  'sv', 'multi_lang_SV',  2),
(34,  'norska', 'no', 'multi_lang_SV',  2),
(35,  'danska', '0',  'multi_lang_SV',  2),
(36,  'tyska',  'de', 'multi_lang_SV',  2),
(37,  'nederländska', 'nl', 'multi_lang_SV',  2),
(38,  'polska', 'pl', 'multi_lang_SV',  2),
(39,  'engelska', 'en', 'multi_lang_SV',  2),
(40,  'annat',  '0',  'multi_lang_SV',  2);

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
  `order_swap` int(11) NOT NULL,
  `order_alpha` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `survey_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `language` (`language`),
  KEY `survey_id` (`survey_id`),
  CONSTRAINT `survey_background_questions_ibfk_1` FOREIGN KEY (`language`) REFERENCES `survey_languages` (`id`) ON DELETE CASCADE,
  CONSTRAINT `survey_background_questions_ibfk_2` FOREIGN KEY (`survey_id`) REFERENCES `surveys` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `survey_background_questions` (`id`, `question`, `is_slide`, `force_noButtons`, `slideText`, `doneStatus`, `internID`, `language`, `sorter`, `order_swap`, `order_alpha`, `type`, `survey_id`) VALUES
(2, 'Was ist Ihre Muttersprache?',  0,  0,  '', 0,  'nativelang', 3,  -1, 0,  0,  'nl_DE',  2),
(5, '.',  1,  0,  '### Välkommen! <br /> \r\n\r\nVi vill gärna veta hur bra svenskspråkiga är på att nederländska ord utan någon kontext. Därför är vi tacksamma att du fyller i enkäten!<br /> \r\n<br /> \r\n\r\nSjälvklart förblir du fullständigt anonym och datan kommer endast att användas för forskningen vid Universitet i Groningen (NL).<br /> \r\n<br /> \r\n\r\nFörst får du några bakgrundfrågor (ålder, modersmål etc) och sedan får du översätta både talade och skrivna ord. Sätt på volymen på din dator innan du börjar!<br /> \r\n<br /> \r\n\r\nTack för att du deltar! ', 0,  'slide1', 2,  -3, 0,  0,  '', 2),
(8, '', 1,  1,  'Tack så mycket för ditt bidrag! <br />\r\nDu svarade %CORRECT% ut av %TOTAL% korrekt! (icke-korrigerat för stavningsfel).',  1,  'finalslide', 2,  9999, 0,  0,  '', 2),
(9, 'Hur gammal är du?',  0,  0,  '', 0,  'age',  2,  -1, 0,  0,  '_age', 2),
(10,  'Vad är ditt kön?', 0,  0,  '', 0,  'sex',  2,  0,  0,  0,  'sex_SV', 2),
(11,  'I vilket land föddes du?', 0,  0,  '', 0,  'country_born', 2,  1,  0,  0,  'country_SV', 2),
(12,  'I vilket land bor du nu?', 0,  0,  '', 0,  'country_live', 2,  1,  0,  0,  'country_SV', 2),
(13,  'Vad är ditt/Vilka är dina modersmål?', 0,  0,  '', 0,  'nativelang', 2,  3,  0,  0,  'multi_lang_SV',  2),
(14,  'Vilka andra språk kan du?',  0,  0,  '', 0,  'otherlang',  2,  3,  0,  0,  '_tagsinput', 2),
(15,  'Har du lärt dig/försökt lära dig nederländska?', 0,  0,  '', 0,  'learnt_dutch', 2,  4,  1,  0,  'noyes_SV', 2),
(16,  'Hur ofta läser du nederländska?',  0,  0,  '', 0,  'contact_read', 2,  6,  1,  0,  'kontakt',  2),
(17,  'Hur ofta hör du nederländska? (också på teve/radio)',  0,  0,  '', 0,  'contact_listen', 2,  7,  1,  0,  'kontakt',  2),
(18,  'Hur ofta besöker du Nederländerna, Belgien eller Surinam?',  0,  0,  '', 0,  'contact_visit',  2,  8,  1,  0,  'kontakt',  2);

DROP TABLE IF EXISTS `survey_correct_translations`;
CREATE TABLE `survey_correct_translations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `survey_word` int(11) NOT NULL,
  `language` int(11) NOT NULL,
  `translation` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `survey_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `survey_word` (`survey_word`),
  KEY `language` (`language`),
  KEY `survey_id` (`survey_id`),
  CONSTRAINT `survey_correct_translations_ibfk_1` FOREIGN KEY (`survey_word`) REFERENCES `survey_words` (`id`) ON DELETE CASCADE,
  CONSTRAINT `survey_correct_translations_ibfk_2` FOREIGN KEY (`language`) REFERENCES `survey_languages` (`id`) ON DELETE CASCADE,
  CONSTRAINT `survey_correct_translations_ibfk_3` FOREIGN KEY (`survey_id`) REFERENCES `surveys` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `survey_correct_translations` (`id`, `survey_word`, `language`, `translation`, `survey_id`) VALUES
(6, 9,  2,  'rädd', 2),
(7, 11, 2,  'gripa',  2),
(8, 12, 2,  'skepp',  2);

DROP TABLE IF EXISTS `survey_languages`;
CREATE TABLE `survey_languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `language_locale` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `strNext` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `strDone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `strBack` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `strTranslate` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `strChoose` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `choosable` int(11) NOT NULL,
  `survey_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `survey_id` (`survey_id`),
  CONSTRAINT `survey_languages_ibfk_1` FOREIGN KEY (`survey_id`) REFERENCES `surveys` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `survey_languages` (`id`, `language_name`, `language_locale`, `strNext`, `strDone`, `strBack`, `strTranslate`, `strChoose`, `choosable`, `survey_id`) VALUES
(1, 'Nederlands', 'NL', '', '', '', '', '', 0,  2),
(2, 'svenska',  'SV', 'Nästa →',  'Klart',  '← Tillbaka', 'Översätt orden', 'Välj...',  1,  2),
(3, 'Deutsch',  'DE', 'Weiter →', 'Fertig', '← Zurück', 'Übersetze',  'wähle...', 1,  2);

DROP TABLE IF EXISTS `survey_sessions`;
CREATE TABLE `survey_sessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ipadress` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `location` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `language` int(11) NOT NULL,
  `date_started` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `doneStatus` int(11) NOT NULL,
  `survey_version` int(11) NOT NULL,
  `survey_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `language` (`language`),
  KEY `survey_version` (`survey_version`),
  KEY `survey_id` (`survey_id`),
  CONSTRAINT `survey_sessions_ibfk_1` FOREIGN KEY (`language`) REFERENCES `survey_languages` (`id`) ON DELETE CASCADE,
  CONSTRAINT `survey_sessions_ibfk_2` FOREIGN KEY (`survey_version`) REFERENCES `survey_versions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `survey_sessions_ibfk_3` FOREIGN KEY (`survey_id`) REFERENCES `surveys` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `survey_sessions` (`id`, `ipadress`, `location`, `language`, `date_started`, `doneStatus`, `survey_version`, `survey_id`) VALUES
(86,  '::1',  'Somewhere',  2,  '2018-03-30 20:35:51',  1,  1,  2),
(87,  '::1',  'Somewhere',  2,  '2018-03-30 21:42:53',  0,  1,  2),
(88,  '::1',  'Somewhere',  2,  '2018-03-31 23:07:18',  0,  1,  2),
(89,  '::1',  'Somewhere',  2,  '2018-04-01 16:47:28',  0,  1,  2);

DROP TABLE IF EXISTS `survey_versions`;
CREATE TABLE `survey_versions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `internName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `usageCount` int(11) NOT NULL,
  `survey_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `survey_id` (`survey_id`),
  CONSTRAINT `survey_versions_ibfk_1` FOREIGN KEY (`survey_id`) REFERENCES `surveys` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `survey_versions` (`id`, `internName`, `usageCount`, `survey_id`) VALUES
(1, 'A',  37, 2);

DROP TABLE IF EXISTS `survey_words`;
CREATE TABLE `survey_words` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `word` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `audiofile` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `language` int(11) NOT NULL,
  `survey_word_group` int(11) NOT NULL,
  `sorter` int(11) NOT NULL,
  `survey_version` int(11) NOT NULL,
  `internID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `survey_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `language` (`language`),
  KEY `survey_word_group` (`survey_word_group`),
  KEY `survey_version` (`survey_version`),
  KEY `survey_id` (`survey_id`),
  CONSTRAINT `survey_words_ibfk_1` FOREIGN KEY (`language`) REFERENCES `survey_languages` (`id`) ON DELETE CASCADE,
  CONSTRAINT `survey_words_ibfk_2` FOREIGN KEY (`survey_word_group`) REFERENCES `survey_word_groups` (`id`) ON DELETE CASCADE,
  CONSTRAINT `survey_words_ibfk_3` FOREIGN KEY (`survey_version`) REFERENCES `survey_versions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `survey_words_ibfk_4` FOREIGN KEY (`survey_id`) REFERENCES `surveys` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `survey_words` (`id`, `word`, `audiofile`, `language`, `survey_word_group`, `sorter`, `survey_version`, `internID`, `survey_id`) VALUES
(9, 'bang', 'bang.ogg', 1,  1,  0,  1,  'bang', 2),
(11,  '', '', 1,  1,  1,  1,  'grijpenAUDIO', 2),
(12,  '', 'schip.ogg',  1,  1,  -1, 1,  'schipAudio', 2);

DROP TABLE IF EXISTS `survey_word_groups`;
CREATE TABLE `survey_word_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `word_group_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `internID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `language` int(11) NOT NULL,
  `survey_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `language` (`language`),
  KEY `survey_id` (`survey_id`),
  CONSTRAINT `survey_word_groups_ibfk_1` FOREIGN KEY (`language`) REFERENCES `survey_languages` (`id`) ON DELETE CASCADE,
  CONSTRAINT `survey_word_groups_ibfk_2` FOREIGN KEY (`survey_id`) REFERENCES `surveys` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `survey_word_groups` (`id`, `word_group_name`, `internID`, `language`, `survey_id`) VALUES
(1, 'With soundchange', 'soundchange',  1,  2),
(2, 'Control',  'control',  1,  2);

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
(-1,  'system', 'SYSTEM', '0',  '2018-03-30 21:04:55',  0,  '', 1,  0,  'root@SYSTEM',  1,  ''),
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


-- 2018-04-01 17:12:44
