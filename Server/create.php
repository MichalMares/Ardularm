<?php
  include("connect.php");
  $handler = Connection();

  $query = "
    -- phpMyAdmin SQL Dump
    -- version 3.5.8.2
    -- http://www.phpmyadmin.net
    --
    -- Host: wm138.wedos.net:3306
    -- Generation Time: Feb 25, 2017 at 02:54 PM
    -- Server version: 10.1.19-MariaDB
    -- PHP Version: 5.4.23

    SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
    SET time_zone = "+00:00";


    /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
    /*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
    /*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
    /*!40101 SET NAMES utf8 */;

    --
    -- Database: `d154501_ardu`
    --

    -- --------------------------------------------------------

    --
    -- Table structure for table `cards`
    --

    CREATE TABLE IF NOT EXISTS `cards` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `trusted` tinyint(1) DEFAULT '0',
      `uid1` tinyint(3) unsigned NOT NULL,
      `uid2` tinyint(3) unsigned NOT NULL,
      `uid3` tinyint(3) unsigned NOT NULL,
      `uid4` tinyint(3) unsigned NOT NULL,
      `user_name` varchar(255) COLLATE utf8_bin DEFAULT NULL,
      PRIMARY KEY (`id`),
      UNIQUE KEY `unique_id` (`uid1`,`uid2`,`uid3`,`uid4`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=6 ;

    -- --------------------------------------------------------

    --
    -- Table structure for table `logs`
    --

    CREATE TABLE IF NOT EXISTS `logs` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `card_id` int(11) DEFAULT NULL,
      `action` text COLLATE utf8_bin NOT NULL,
      PRIMARY KEY (`id`),
      KEY `card_id` (`card_id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=280 ;

    -- --------------------------------------------------------

    --
    -- Table structure for table `settings`
    --

    CREATE TABLE IF NOT EXISTS `settings` (
      `setting` text COLLATE utf8_bin NOT NULL,
      `value` tinyint(1) NOT NULL DEFAULT '0'
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

    INSERT INTO `settings` (`setting`, `value`) VALUES
    ('alarmState', 0);

    /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
    /*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
    /*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
  ";

  $handler->exec($query); // what if they are already created?
  echo "Tables created successfully. DELETE this file for safety reasons!";
?>
