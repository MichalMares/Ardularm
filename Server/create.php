<?php
  include('connect.php');
  $handler = Connection();

  $query = "
    SET NAMES utf8;
    SET time_zone = '+00:00';
    SET foreign_key_checks = 0;
    SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

    CREATE TABLE `cards` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `trusted` bit(1) DEFAULT b'0',
      `uid1` tinyint(3) unsigned NOT NULL,
      `uid2` tinyint(3) unsigned NOT NULL,
      `uid3` tinyint(3) unsigned NOT NULL,
      `uid4` tinyint(3) unsigned NOT NULL,
      `user_name` varchar(255) COLLATE utf8_bin DEFAULT NULL,
      PRIMARY KEY (`id`),
      UNIQUE KEY `unique_id` (`uid1`,`uid2`,`uid3`,`uid4`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

    CREATE TABLE `logs` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `card_id` int(11) DEFAULT NULL,
      `action` text COLLATE utf8_bin NOT NULL,
      PRIMARY KEY (`id`),
      KEY `card_id` (`card_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

    CREATE TABLE `settings` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `card_id` int(11) DEFAULT NULL,
      `action` text COLLATE utf8_bin NOT NULL,
      PRIMARY KEY (`id`),
      KEY `card_id` (`card_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
    ";

  $handler->exec($query);
  echo "Tables created successfully. DELETE this file for safety reasons!";
?>
