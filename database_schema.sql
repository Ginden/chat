-- phpMyAdmin SQL Dump
-- version 3.5.0
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 24, 2014 at 02:25 AM
-- Server version: 5.1.72-log
-- PHP Version: 5.3.26

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ginden_rept`
--

-- --------------------------------------------------------

--
-- Table structure for table `chat_access`
--

CREATE TABLE IF NOT EXISTS `chat_access` (
  `userid` int(11) NOT NULL,
  `channel` int(12) NOT NULL DEFAULT '0',
  `access` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 = brak, 1 = normal, 2 = mod',
  `banned` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`userid`,`channel`)
) ENGINE=MyISAM DEFAULT CHARSET=latin2;

-- --------------------------------------------------------

--
-- Table structure for table `chat_accounts`
--

CREATE TABLE IF NOT EXISTS `chat_accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `identifier` varchar(70) COLLATE utf8_polish_ci NOT NULL,
  `unikalny_klucz` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `accountkey` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `strims` tinyint(1) NOT NULL DEFAULT '0',
  `password` varchar(128) COLLATE utf8_polish_ci NOT NULL,
  `login_type` smallint(6) NOT NULL,
  `email` varchar(70) COLLATE utf8_polish_ci NOT NULL DEFAULT '',
  `updated_at` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user` (`name`),
  KEY `id` (`id`),
  KEY `id_2` (`id`),
  KEY `id_3` (`id`),
  KEY `id_4` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=280 ;

-- --------------------------------------------------------

--
-- Table structure for table `chat_banners`
--

CREATE TABLE IF NOT EXISTS `chat_banners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8_polish_ci NOT NULL,
  `file` varchar(30) COLLATE utf8_polish_ci NOT NULL,
  `when` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`,`name`,`file`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `chat_channels`
--

CREATE TABLE IF NOT EXISTS `chat_channels` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `img` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `short_decline` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `long_decline` text COLLATE utf8_polish_ci NOT NULL,
  `favicon` varchar(30) COLLATE utf8_polish_ci DEFAULT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chat_emots`
--

CREATE TABLE IF NOT EXISTS `chat_emots` (
  `emoticon` varchar(25) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `image` varchar(80) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`emoticon`)
) ENGINE=MyISAM DEFAULT CHARSET=latin2;

-- --------------------------------------------------------

--
-- Table structure for table `chat_messages`
--

CREATE TABLE IF NOT EXISTS `chat_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `message` varchar(1200) COLLATE utf8_polish_ci NOT NULL,
  `timestamp` int(11) NOT NULL,
  `channel` int(11) NOT NULL DEFAULT '255',
  `to` varchar(40) COLLATE utf8_polish_ci NOT NULL DEFAULT '',
  `special` char(1) COLLATE utf8_polish_ci DEFAULT NULL,
  `ip` varchar(30) COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `channel` (`channel`,`timestamp`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=123470 ;

-- --------------------------------------------------------

--
-- Table structure for table `chat_preferences_values`
--

CREATE TABLE IF NOT EXISTS `chat_preferences_values` (
  `identifier` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `value` varchar(40) COLLATE utf8_polish_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`identifier`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `chat_random_texts`
--

CREATE TABLE IF NOT EXISTS `chat_random_texts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `when` int(11) NOT NULL DEFAULT '0',
  `text` text COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=159 ;

-- --------------------------------------------------------

--
-- Table structure for table `chat_register_log`
--

CREATE TABLE IF NOT EXISTS `chat_register_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nick` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `klucz` varchar(70) COLLATE utf8_polish_ci NOT NULL,
  `date` date NOT NULL,
  `ip` varchar(40) COLLATE utf8_polish_ci NOT NULL,
  `typ` smallint(6) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nick` (`nick`,`date`),
  UNIQUE KEY `nick_2` (`nick`,`date`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `chat_users_online`
--

CREATE TABLE IF NOT EXISTS `chat_users_online` (
  `user` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL DEFAULT '0',
  `channel` int(11) NOT NULL DEFAULT '0',
  `afk` tinyint(1) NOT NULL,
  UNIQUE KEY `user` (`user`,`channel`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
