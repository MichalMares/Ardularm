<?php
	/**
	 * @file create.php
	 * @Author Michal Mareš
	 * @date March, 2017
	 * @brief Creates necessary tables in database to run Ardularm.
	 */

	include("config.php");
	include("connect.php");
	$handler = Connection();

	$query = "
	SET NAMES utf8;
	SET time_zone = '+00:00';
	SET foreign_key_checks = 0;
	SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

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
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

	CREATE TABLE IF NOT EXISTS `logs` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
		`card_id` int(11) DEFAULT NULL,
		`action` text COLLATE utf8_bin NOT NULL,
		`area` text COLLATE utf8_bin NOT NULL,
		PRIMARY KEY (`id`),
		KEY `card_id` (`card_id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

	CREATE TABLE IF NOT EXISTS `settings` (
		`setting` text COLLATE utf8_bin NOT NULL,
		`value` tinyint(1) NOT NULL DEFAULT '0'
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

	INSERT INTO `settings` (`setting`, `value`) VALUES
	('alarmState', 0);
	";

	$handler->exec($query);
	echo "Tables created successfully. DELETE this file for safety reasons!";
?>
