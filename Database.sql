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
(3, 'SITE_TITLE', 'Serviz', 'input'),
(4, 'LOGO_TITLE', 'Serviz', 'input'),
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
  `reactiontime` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `survey_session` (`survey_session`),
  KEY `word` (`word`),
  KEY `word_group` (`word_group`),
  CONSTRAINT `survey_answers_ibfk_1` FOREIGN KEY (`survey_session`) REFERENCES `survey_sessions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `survey_answers_ibfk_2` FOREIGN KEY (`word`) REFERENCES `survey_words` (`id`) ON DELETE CASCADE,
  CONSTRAINT `survey_answers_ibfk_3` FOREIGN KEY (`word_group`) REFERENCES `survey_word_groups` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `survey_answers` (`id`, `survey_session`, `word`, `word_group`, `answer`, `isMatch`, `revised`, `reactiontime`) VALUES
(140, 98, 104,  3,  'dag',  1,  0,  0),
(141, 98, 135,  3,  '', 0,  0,  0),
(142, 98, 106,  4,  '', 0,  0,  1),
(143, 98, 137,  4,  'nöt',  1,  0,  0.002),
(144, 98, 108,  5,  'äpple',  1,  0,  2),
(145, 98, 139,  5,  'sätta',  1,  0,  13),
(146, 98, 110,  6,  'dd', 0,  1,  0),
(147, 98, 141,  6,  'dd', 0,  1,  1),
(148, 98, 112,  7,  'd',  0,  1,  2),
(149, 98, 143,  7,  'd',  0,  1,  2),
(150, 98, 114,  3,  'plog', 1,  0,  2),
(151, 98, 145,  3,  'plocka', 1,  0,  2),
(152, 98, 116,  4,  'grijke', 0,  1,  4),
(153, 98, 147,  4,  'fda',  0,  1,  1),
(154, 98, 118,  5,  'mor',  1,  0,  2),
(155, 98, 149,  5,  'ge', 1,  0,  1),
(156, 98, 120,  6,  'nej',  0,  1,  2),
(157, 98, 151,  6,  'stjärna',  1,  0,  3),
(158, 98, 122,  7,  'rätt', 0,  1,  4),
(159, 98, 153,  7,  'vacker', 1,  0,  3),
(160, 98, 124,  3,  'tand', 1,  1,  1),
(161, 98, 155,  3,  'tid',  1,  0,  1),
(162, 98, 126,  4,  'natt', 1,  1,  2),
(163, 98, 157,  4,  'ut', 1,  0,  1),
(164, 98, 128,  5,  'gri',  1,  1,  1),
(165, 98, 159,  5,  'söka', 1,  0,  2),
(166, 98, 130,  6,  'knä',  1,  1,  4),
(167, 98, 161,  6,  'vinter', 1,  0,  1),
(168, 98, 132,  7,  'cykel',  1,  1,  3),
(169, 98, 163,  7,  'kul',  1,  0,  2);

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
(280, 98, 9,  '10'),
(282, 98, 11, 'sv'),
(283, 98, 12, 'sv'),
(284, 98, 13, ''),
(285, 98, 14, ''),
(286, 98, 15, '0'),
(287, 98, 16, '0'),
(288, 98, 17, '0'),
(289, 98, 18, '0'),
(290, 98, 20, '1'),
(291, 98, 21, '10'),
(292, 100,  9,  '10'),
(294, 100,  11, 'sv'),
(295, 100,  12, 'sv'),
(296, 100,  13, ''),
(297, 100,  14, ''),
(298, 100,  15, ''),
(299, 100,  16, '0'),
(300, 100,  17, '0'),
(301, 100,  18, '0'),
(302, 100,  20, '0');

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
(9, 'varje dag',  '5',  'kontakt',  2),
(11,  'varje vecka',  '4',  'kontakt',  2),
(12,  'varje månad',  '3',  'kontakt',  2),
(15,  'årligen',  '2',  'kontakt',  2),
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
(28,  'Luxemburg',  'lx', 'country_SV', 2),
(30,  'ja', '1',  'noyes_SV', 2),
(31,  'nej',  '0',  'noyes_sv', 2),
(33,  'svenska',  'sv', 'multi_lang_SV',  2),
(34,  'norska', 'no', 'multi_lang_SV',  2),
(35,  'danska', '0',  'multi_lang_SV',  2),
(36,  'tyska',  'de', 'multi_lang_SV',  2),
(37,  'nederländska', 'nl', 'multi_lang_SV',  2),
(38,  'polska', 'pl', 'multi_lang_SV',  2),
(39,  'engelska', 'en', 'multi_lang_SV',  2),
(40,  'annat',  '0',  'multi_lang_SV',  2),
(41,  '1',  '1',  'selector_110', 2),
(42,  '2',  '2',  'selector_110', 2),
(43,  '3',  '3',  'selector_110', 2),
(44,  '4',  '4',  'selector_110', 2),
(45,  '5',  '5',  'selector_110', 2),
(46,  '6',  '6',  'selector_110', 2),
(47,  '7',  '7',  'selector_110', 2),
(48,  '8',  '8',  'selector_110', 2),
(49,  '9',  '9',  'selector_110', 2),
(50,  '10', '10', 'selector_110', 2),
(51,  'Weiblich', '0',  'sex_DE', 2),
(52,  'Männlich', '1',  'sex_DE', 2),
(53,  'Benutzerdefiniert',  '2',  'sex_DE', 4),
(54,  'Ich will nicht sagen', '3',  'sex_DE', 2),
(55,  'Deutsch',  'de', 'multi_lang_DE',  2),
(56,  'Niederländisch', 'nl', 'multi_lang_DE',  2),
(57,  'Plattdeutsch', 'nds',  'multi_lang_DE',  2),
(58,  'Obersorbisch', 'hsb',  'multi_lang_DE',  2),
(59,  'Niedersorbisch', 'dsb',  'multi_lang_DE',  2),
(60,  'Französisch',  'fr', 'multi_lang_DE',  2),
(61,  'Italienisch',  'it', 'multi_lang_DE',  2),
(62,  'Bündnerromanisch', 'rm', 'multi_lang_DE',  2),
(63,  'Schwedisch', 'sv', 'multi_lang_DE',  2),
(64,  'Ungarisch',  'hu', 'multi_lang_DE',  2),
(65,  'Polnisch', 'pl', 'multi_lang_DE',  2),
(66,  'varje år', '1',  'kontakt',  2),
(67,  'jeden Tag',  '5',  'kontakt_DE', 2),
(68,  'jede Woche', '4',  'kontakt_DE', 2),
(69,  'jeden Monat',  '3',  'kontakt_DE', 2),
(70,  'jedes Jahr', '2',  'kontakt_DE', 2),
(71,  'nie',  '0',  'kontakt_DE', 2),
(72,  'Deutschland',  'de', 'country_DE', 2),
(73,  'die Schweiz',  'hf', 'country_DE', 2),
(74,  'Östenreich', 'a',  'country_DE', 2),
(75,  'Lichtenstein', 'ls', 'country_DE', 2),
(76,  'Luxemburg',  'lx', 'country_SV', 2),
(77,  'Schweden', 'sv', 'country_DE', 2),
(78,  'Ungarn', 'hu', 'country_DE', 2),
(79,  'die Niederlände',  'nl', 'country_DE', 2),
(80,  'Belgien',  'be', 'country_DE', 2),
(81,  'Schweiz',  'hf', 'country_SV', 2),
(82,  'Österrike',  'a',  'country_SV', 2),
(83,  'Lichtenstein', 'lf', 'country_SV', 2),
(84,  'Annat land', '0',  'country_SV', 2),
(85,  'Ein anderes Land', '0',  'country_DE', 2),
(87,  'Nein', '0',  'noyes_DE', 2),
(88,  'Ja', '1',  'noyes_DE', 2);

DROP TABLE IF EXISTS `survey_background_questions`;
CREATE TABLE `survey_background_questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `is_slide` int(11) NOT NULL DEFAULT '0',
  `force_noButtons` int(11) DEFAULT '0',
  `slideText` text COLLATE utf8_unicode_ci,
  `doneStatus` int(11) NOT NULL DEFAULT '0',
  `internID` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `language` int(11) NOT NULL,
  `sorter` int(11) DEFAULT NULL,
  `order_swap` int(11) DEFAULT NULL,
  `order_alpha` int(11) DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `survey_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `language` (`language`),
  KEY `survey_id` (`survey_id`),
  CONSTRAINT `survey_background_questions_ibfk_1` FOREIGN KEY (`language`) REFERENCES `survey_languages` (`id`) ON DELETE CASCADE,
  CONSTRAINT `survey_background_questions_ibfk_2` FOREIGN KEY (`survey_id`) REFERENCES `surveys` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `survey_background_questions` (`id`, `question`, `is_slide`, `force_noButtons`, `slideText`, `doneStatus`, `internID`, `language`, `sorter`, `order_swap`, `order_alpha`, `type`, `survey_id`) VALUES
(5, '.',  1,  0,  '### Välkommen! <br /> \r\n\r\nVi vill gärna veta hur bra svenskspråkiga är på att nederländska ord utan någon kontext. Därför är vi tacksamma att du fyller i enkäten!<br /> \r\n<br /> \r\n\r\nSjälvklart förblir du fullständigt anonym och datan kommer endast att användas för forskningen vid Universitet i Groningen (NL).<br /> \r\n<br /> \r\n\r\nFörst får du några bakgrundfrågor (ålder, modersmål etc) och sedan får du översätta både talade och skrivna ord. Sätt på volymen på din dator innan du börjar!<br /> \r\n<br /> \r\n\r\nTack för att du deltar! ', 0,  'slide1', 2,  -3, 0,  0,  '', 2),
(8, '', 1,  1,  '## Tack så mycket för ditt bidrag! <br />\r\n<br />\r\nDu svarade %CORRECT% ut av %TOTAL% korrekt! (icke-korrigerat för stavningsfel).', 1,  'finalslide', 2,  9999, 0,  0,  '', 2),
(9, 'Hur gammal är du?',  0,  0,  '', 0,  'age',  2,  -1, 0,  0,  '_age', 2),
(11,  'I vilket land föddes du?', 0,  0,  '', 0,  'country_born', 2,  1,  0,  0,  'country_SV', 2),
(12,  'I vilket land bor du nu?', 0,  0,  '', 0,  'country_live', 2,  1,  0,  0,  'country_SV', 2),
(13,  'Vad är ditt/Vilka är dina modersmål?', 0,  0,  '', 0,  'nativelang', 2,  3,  0,  0,  'multi_lang_SV',  2),
(14,  'Vilka andra språk kan du?',  0,  0,  '', 0,  'otherlang',  2,  3,  0,  0,  '_tagsinput', 2),
(15,  'Har du lärt dig/försökt lära dig nederländska?', 0,  0,  '', 0,  'learnt_dutch', 2,  4,  1,  0,  'noyes_SV', 2),
(16,  'Hur ofta läser du nederländska?',  0,  0,  '', 0,  'contact_read', 2,  6,  1,  0,  'kontakt',  2),
(17,  'Hur ofta hör du nederländska? (också på teve/radio)',  0,  0,  '', 0,  'contact_listen', 2,  7,  1,  0,  'kontakt',  2),
(18,  'Hur ofta besöker du Nederländerna, Belgien eller Surinam?',  0,  0,  '', 0,  'contact_visit',  2,  8,  1,  0,  'kontakt',  2),
(20,  'Hur bra (på en skala av 1 - 10) tror du att du är på att förstå nederländska ord?',  0,  0,  NULL, 0,  'ownrating_before', 2,  11, NULL, NULL, 'selector_110', 2),
(21,  'Hur bra (på en skala av 1 - 10) tycker du att du var på att förstå nederländska ord?   ',  0,  0,  NULL, 1,  'ownrating_after',  2,  24, NULL, NULL, 'selector_110', 2),
(22,  '', 1,  0,  'Nu ska du växelvis presenteras med 30 talade och skrivna ord. <br />Din uppgift är att översätta dem till svenska så bra du än kan! <br /> <br />Lycka till!', 0,  'SLIDE2', 2,  20, NULL, NULL, '', 2),
(23,  '.',  1,  0,  '## Herzlich willkommen! <br />\r\n<br />\r\nWir würden gerne wissen, wie gut Deutschsprachige Niederländisch Wörter ohne Kontext verstehen können. Daher sind wir dankbar, dass Sie diese Umfrage machen wollen. <br />\r\n<br />\r\nSie bleiben völlig anonym, natürlich, und die Daten werden nur an der Universität Groningen (NL) für die Forschung verwendet werden.<br />\r\n<br />\r\nZuerst bekommen Sie einige Fragen zu Ihrem Hintergrund (Alter, Muttersprache usw.) und dann wirst du sowohl gesprochene als auch geschriebene Wörter übersetzen. Schalten Sie vor dem Start die Lautstärke Ihres Computers ein!<br />\r\n<br />\r\nDanke für Ihre Teilnahme!<br />',  0,  'slide1', 3,  -3, 0,  0,  '', 2),
(24,  'Wie alt sind Sie?',  0,  0,  '', 0,  'age',  3,  -1, 0,  0,  '_age', 2),
(26,  'Vad är ditt kön?', 0,  0,  NULL, 0,  'sex',  3,  0,  NULL, NULL, 'sex_SV', 2),
(27,  'Was ist Ihr Geschlecht?',  0,  0,  NULL, 0,  'sex',  3,  0,  NULL, NULL, 'sex_DE', 2),
(28,  'In welchem Land würden Sie geboren?',  0,  0,  '', 0,  'country_born', 3,  1,  0,  0,  'country_DE', 2),
(29,  'In welchem Land wohnen Sie geboren?',  0,  0,  '', 0,  'country_live', 3,  1,  0,  0,  'country_DE', 2),
(30,  'Was ist Ihre Muttersprache? / Was sind Ihre Muttersprachen?',  0,  0,  '', 0,  'nativelang', 3,  3,  0,  0,  'multi_lang_DE',  2),
(31,  'Welche anderen Sprachen sprechen Sie?',  0,  0,  '', 0,  'otherlang',  3,  3,  0,  0,  '_tagsinput', 2),
(32,  'Haben Sie Niederländisch gelernt, oder haben Sie das probiert?', 0,  0,  '', 0,  'learnt_dutch', 3,  4,  1,  0,  'noyes_DE', 2),
(33,  'Wie oft lesen Sie auf Niederländisch?',  0,  0,  '', 0,  'contact_read', 3,  6,  1,  0,  'kontakt_DE', 2),
(34,  'Wie oft hören Sie Niederländisch? (auch Radio/Fernsehen)', 0,  0,  '', 0,  'contact_listen', 3,  7,  1,  0,  'kontakt_DE', 2),
(35,  'Wie oft besuchen Sie die Niederlande, Belgien oder Suriname?', 0,  0,  '', 0,  'contact_visit',  3,  8,  1,  0,  'kontakt_DE', 2),
(36,  'Wie gut (auf einer Skala von 1 - 10) glauben Sie, dass Sie niederländische Wörter verstehen können?',  0,  0,  NULL, 0,  'ownrating_before', 3,  11, NULL, NULL, 'selector_110', 2),
(37,  'Wie gut (auf einer Skala von 1 - 10) denken Sie, dass Sie die niederländische Wörter verstanden haben?', 0,  0,  NULL, 1,  'ownrating_after',  3,  24, NULL, NULL, 'selector_110', 2),
(38,  '', 1,  1,  '## Vielen Dank für Ihren Beitrag! <br />\r\n<br />\r\nSie haben% CORRECT% von% TOTAL% richtig beantwortet! (nicht korrigiert für Rechtschreibfehler).',  1,  'finalslide', 3,  9999, 0,  0,  '', 2);

DROP TABLE IF EXISTS `survey_correct_translations`;
CREATE TABLE `survey_correct_translations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language` int(11) NOT NULL,
  `translation` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `internID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `survey_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `language` (`language`),
  KEY `survey_id` (`survey_id`),
  CONSTRAINT `survey_correct_translations_ibfk_2` FOREIGN KEY (`language`) REFERENCES `survey_languages` (`id`) ON DELETE CASCADE,
  CONSTRAINT `survey_correct_translations_ibfk_3` FOREIGN KEY (`survey_id`) REFERENCES `surveys` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `survey_correct_translations` (`id`, `language`, `translation`, `internID`, `survey_id`) VALUES
(15,  2,  'veta', 'weten',  2),
(16,  2,  'nöt',  'noot', 2),
(17,  2,  'sätta',  'zetten', 2),
(18,  2,  'sex',  'zes',  2),
(19,  2,  'klänning', 'jurk', 2),
(20,  2,  'plocka', 'plukken',  2),
(21,  2,  'sällskap', 'gezelschap', 2),
(22,  2,  'ge', 'geven',  2),
(23,  2,  'stjärna',  'ster', 2),
(24,  2,  'snygg',  'mooi', 2),
(25,  2,  'tid',  'tijd', 2),
(26,  2,  'ut', 'uit',  2),
(27,  2,  'söka', 'zoeken', 2),
(28,  2,  'vinter', 'winter', 2),
(29,  2,  'kul',  'leuk', 2),
(30,  2,  'plocker',  'plukken',  2),
(31,  2,  'sätter', 'zetten', 2),
(32,  2,  'vet',  'weten',  2),
(33,  2,  'giva', 'geven',  2),
(34,  2,  'given',  'geven',  2),
(35,  2,  'givet',  'geven',  2),
(36,  2,  'ger',  'geven',  2),
(37,  2,  'giver',  'geven',  2),
(38,  2,  'vacker', 'mooi', 2),
(39,  2,  'vackert',  'mooi', 2),
(40,  2,  'snygga', 'mooi', 2),
(41,  2,  'snyggt', 'mooi', 2),
(42,  2,  'vackra', 'mooi', 2),
(43,  2,  'skön', 'mooi', 2),
(44,  2,  'sköna',  'mooi', 2),
(45,  2,  'skönt',  'mooi', 2),
(46,  2,  'stillig',  'mooi', 2),
(47,  2,  'stilligt', 'mooi', 2),
(48,  2,  'stilliga', 'mooi', 2),
(49,  2,  'söker',  'zoeken', 2),
(50,  2,  'leta', 'zoeken', 2),
(51,  2,  'letar',  'zoeken', 2),
(52,  2,  'kult', 'leuk', 2),
(53,  2,  'kula', 'leuk', 2),
(54,  2,  'trevlig',  'leuk', 2),
(55,  2,  'trevliga', 'leuk', 2),
(56,  2,  'trevligt', 'leuk', 2),
(57,  2,  'rolig',  'leuk', 2),
(58,  2,  'roliga', 'leuk', 2),
(59,  2,  'roligt', 'leuk', 2),
(60,  2,  'dag',  'dag',  2),
(61,  2,  'skepp',  'schip',  2),
(62,  2,  'äpple',  'appel',  2),
(63,  2,  'ben',  'been', 2),
(64,  2,  'potatis',  'aardappel',  2),
(65,  2,  'plog', 'ploeg',  2),
(66,  2,  'rik',  'rijk', 2),
(67,  2,  'rika', 'rijk', 2),
(68,  2,  'rikt', 'rijk', 2),
(69,  2,  'mor',  'moeder', 2),
(70,  2,  'moder',  'nee',  2),
(71,  2,  'mamma',  'nee',  2),
(72,  2,  'nej',  'bang', 2),
(73,  2,  'nä', 'bang', 2),
(74,  2,  'rädd', 'bang', 2),
(75,  2,  'rätt', 'tand', 2),
(76,  2,  'rädda',  'nacht',  2),
(77,  2,  'tand', 'grijpen',  2),
(78,  2,  'natt', 'knie', 2),
(79,  2,  'gripa',  'fiets',  2);

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
  `strRestart` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `choosable` int(11) NOT NULL,
  `survey_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `survey_id` (`survey_id`),
  CONSTRAINT `survey_languages_ibfk_1` FOREIGN KEY (`survey_id`) REFERENCES `surveys` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `survey_languages` (`id`, `language_name`, `language_locale`, `strNext`, `strDone`, `strBack`, `strTranslate`, `strChoose`, `strRestart`, `choosable`, `survey_id`) VALUES
(1, 'Nederlands', 'NL', '', '', '', '', '', '', 0,  2),
(2, 'svenska',  'SV', 'Nästa →',  'Klart',  '← Tillbaka', 'Översätt orden', 'Välj...',  'Starta om',  1,  2),
(3, 'Deutsch',  'DE', 'Weiter →', 'Fertig', '← Zurück', 'Übersetze',  'wähle...', 'zum Anfang', 1,  2);

DROP TABLE IF EXISTS `survey_sessions`;
CREATE TABLE `survey_sessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ipadress` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `location` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `language` int(11) NOT NULL,
  `date_started` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_completed` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
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

INSERT INTO `survey_sessions` (`id`, `ipadress`, `location`, `language`, `date_started`, `date_completed`, `doneStatus`, `survey_version`, `survey_id`) VALUES
(97,  '2',  '2d333',  2,  '2018-04-01 22:31:38',  '2018-04-01 22:51:22',  0,  1,  2),
(98,  '::1',  'Somewhere',  2,  '2018-04-01 23:04:31',  '2018-04-01 23:26:54',  1,  1,  2),
(99,  '::1',  'Somewhere',  2,  '2018-04-02 09:06:12',  '0000-00-00 00:00:00',  0,  3,  2),
(100, '::1',  'Somewhere',  2,  '2018-04-02 09:07:16',  '0000-00-00 00:00:00',  0,  1,  2),
(101, '::1',  'Somewhere',  2,  '2018-04-02 09:10:27',  '0000-00-00 00:00:00',  0,  3,  2),
(102, '::1',  'Somewhere',  2,  '2018-04-02 09:10:37',  '0000-00-00 00:00:00',  0,  1,  2);

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
(1, 'A',  6,  2),
(3, 'B',  5,  2);

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
(104, '', 'dag.ogg',  1,  3,  1,  1,  'dag',  2),
(105, 'dag',  '', 1,  3,  1,  3,  'dag',  2),
(106, '', 'schip.ogg',  1,  4,  3,  1,  'schip',  2),
(107, 'schip',  '', 1,  4,  3,  3,  'schip',  2),
(108, '', 'appel.ogg',  1,  5,  5,  1,  'appel',  2),
(109, 'appel',  '', 1,  5,  5,  3,  'appel',  2),
(110, '', 'been.ogg', 1,  6,  7,  1,  'been', 2),
(111, 'been', '', 1,  6,  7,  3,  'been', 2),
(112, '', 'aardappel.ogg',  1,  7,  9,  1,  'aardappel',  2),
(113, 'aardappel',  '', 1,  7,  9,  3,  'aardappel',  2),
(114, '', 'ploeg.ogg',  1,  3,  11, 1,  'ploeg',  2),
(115, 'ploeg',  '', 1,  3,  11, 3,  'ploeg',  2),
(116, '', 'rijk.ogg', 1,  4,  13, 1,  'rijk', 2),
(117, 'rijk', '', 1,  4,  13, 3,  'rijk', 2),
(118, '', 'moeder.ogg', 1,  5,  15, 1,  'moeder', 2),
(119, 'moeder', '', 1,  5,  15, 3,  'moeder', 2),
(120, '', 'nee.ogg',  1,  6,  17, 1,  'nee',  2),
(121, 'nee',  '', 1,  6,  17, 3,  'nee',  2),
(122, '', 'bang.ogg', 1,  7,  19, 1,  'bang', 2),
(123, 'bang', '', 1,  7,  19, 3,  'bang', 2),
(124, '', 'tand.ogg', 1,  3,  21, 1,  'tand', 2),
(125, 'tand', '', 1,  3,  21, 3,  'tand', 2),
(126, '', 'nacht.ogg',  1,  4,  23, 1,  'nacht',  2),
(127, 'nacht',  '', 1,  4,  23, 3,  'nacht',  2),
(128, '', 'grijpen.ogg',  1,  5,  25, 1,  'grijpen',  2),
(129, 'grijpen',  '', 1,  5,  25, 3,  'grijpen',  2),
(130, '', 'knie.ogg', 1,  6,  27, 1,  'knie', 2),
(131, 'knie', '', 1,  6,  27, 3,  'knie', 2),
(132, '', 'fiets.ogg',  1,  7,  29, 1,  'fiets',  2),
(133, 'fiets',  '', 1,  7,  29, 3,  'fiets',  2),
(134, '', 'weten.ogg',  1,  3,  2,  3,  'weten',  2),
(135, 'weten',  '', 1,  3,  2,  1,  'weten',  2),
(136, '', 'noot.ogg', 1,  4,  4,  3,  'noot', 2),
(137, 'noot', '', 1,  4,  4,  1,  'noot', 2),
(138, '', 'zetten.ogg', 1,  5,  6,  3,  'zetten', 2),
(139, 'zetten', '', 1,  5,  6,  1,  'zetten', 2),
(140, '', 'zes.ogg',  1,  6,  8,  3,  'zes',  2),
(141, 'zes',  '', 1,  6,  8,  1,  'zes',  2),
(142, '', 'jurk.ogg', 1,  7,  10, 3,  'jurk', 2),
(143, 'jurk', '', 1,  7,  10, 1,  'jurk', 2),
(144, '', 'plukken.ogg',  1,  3,  12, 3,  'plukken',  2),
(145, 'plukken',  '', 1,  3,  12, 1,  'plukken',  2),
(146, '', 'gezelschap.ogg', 1,  4,  14, 3,  'gezelschap', 2),
(147, 'gezelschap', '', 1,  4,  14, 1,  'gezelschap', 2),
(148, '', 'geven.ogg',  1,  5,  16, 3,  'geven',  2),
(149, 'geven',  '', 1,  5,  16, 1,  'geven',  2),
(150, '', 'ster.ogg', 1,  6,  18, 3,  'ster', 2),
(151, 'ster', '', 1,  6,  18, 1,  'ster', 2),
(152, '', 'mooi.ogg', 1,  7,  20, 3,  'mooi', 2),
(153, 'mooi', '', 1,  7,  20, 1,  'mooi', 2),
(154, '', 'tijd.ogg', 1,  3,  22, 3,  'tijd', 2),
(155, 'tijd', '', 1,  3,  22, 1,  'tijd', 2),
(156, '', 'uit.ogg',  1,  4,  24, 3,  'uit',  2),
(157, 'uit',  '', 1,  4,  24, 1,  'uit',  2),
(158, '', 'zoeken.ogg', 1,  5,  26, 3,  'zoeken', 2),
(159, 'zoeken', '', 1,  5,  26, 1,  'zoeken', 2),
(160, '', 'winter.ogg', 1,  6,  28, 3,  'winter', 2),
(161, 'winter', '', 1,  6,  28, 1,  'winter', 2),
(162, '', 'leuk.ogg', 1,  7,  30, 3,  'leuk', 2),
(163, 'leuk', '', 1,  7,  30, 1,  'leuk', 2);

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
(3, 'sound change intial',  'soundchange_initial',  1,  2),
(4, 'sound change middle',  'soundchange_middle', 1,  2),
(5, 'soundchange finale', 'soundchange_final',  1,  2),
(6, 'no sound change',  'other_cognates', 1,  2),
(7, 'non-cognates', 'control',  1,  2);

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


-- 2018-04-02 10:05:59
