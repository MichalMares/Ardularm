<?php
	/**
	 * @file addEntry.php
	 * @Author Michal Mareš
	 * @date March, 2017
	 * @brief Adds an entry with a message into the database.
	 */

	include("../authenticate.php");
	include("../connect.php");
	include("../config.php");
	$handler = Connection();
	Authenticate();

	$uid1 = $_POST['uid1'];
	$uid2 = $_POST['uid2'];
	$uid3 = $_POST['uid3'];
	$uid4 = $_POST['uid4'];
	$area = $_POST['area'];
	$action = $_POST['action'];

	$qCheck = "SELECT * FROM cards
		WHERE uid1=? AND uid2=? AND uid3=? AND uid4=?;";

	$result = $handler->prepare($qCheck);
	$result->execute(array($uid1, $uid2, $uid3, $uid4)); // try to find card in the db

	if ($result->rowCount() == 1) { // if card does exist
		while($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$id = $row["id"]; // get card's id from the db
		}

		$qLog = $handler->prepare(
			"INSERT INTO logs (area, action, card_id) VALUES (?, ?);"
		);
		$qLog->execute(array($area, $action, $id)); // insert entry with corresponding card id into the db
	}

	else { // if card does not exist
		$qCard = $handler->prepare(
			"INSERT INTO cards (uid1, uid2, uid3, uid4) VALUES (?, ?, ?, ?);"
		);
		$qLog = $handler->prepare(
			"INSERT INTO logs (area, action, card_id) VALUES (?, ?, LAST_INSERT_ID());"
		);

		$qCard->execute(array($uid1, $uid2, $uid3, $uid4)); // insert new card into db
		$qLog->execute(array($area, $action)); // insert entry with corresponding card id into the db
	}

	echo "{" . $action . "}"; // return message to Arduino
?>
