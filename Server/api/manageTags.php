<?php
	/**
	 * @file manageTags.php
	 * @Author Michal Mareš
	 * @date March, 2017
	 * @brief Changes, whether the tag is or is not trusted.
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

	$qCheck = "SELECT * FROM cards
	WHERE uid1=? AND uid2=? AND uid3=? AND uid4=?;";

	$result = $handler->prepare($qCheck);
	$result->execute(array($uid1, $uid2, $uid3, $uid4)); // try to find card in the db

	if ($result->rowCount() == 1) { // if card does exist
		$result->execute(array($uid1, $uid2, $uid3, $uid4)); // why doesn't it work without executing again?
		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$id = $row["id"]; // get card's id from the db
		}

		$result->execute(array($uid1, $uid2, $uid3, $uid4));
		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$trusted = $row["trusted"]; // get card's trusted value
		}

		if ($trusted == 1) { // if trusted, remove from trusted
			$action = "Tag REMOVED from Trusted";
			$trusted = 0;
		}

		else if ($trusted == 0) { // if not trusted, change to trusted
			$action = "Tag ADDED as Trusted";
			$trusted = 1;
		}

		$qCard = $handler->prepare("UPDATE cards SET trusted=? WHERE id=?;");
		$qCard->execute(array($trusted, $id)); // execute change to the card

		$qLog = $handler->prepare("INSERT INTO logs (area, action, card_id) VALUES (?, ?, ?);");
		$qLog->execute(array($area, $action, $id)); // add entry into the log
	}

	else { // if card does not exist
		$action = "Tag ADDED as Trusted";
		$qCard = $handler->prepare("INSERT INTO cards (trusted, uid1, uid2, uid3, uid4)	VALUES (1, ?, ?, ?, ?);");
		$qCard->execute(array($uid1, $uid2, $uid3, $uid4)); // add card as trusted

		$qLog = $handler->prepare("INSERT INTO logs (area, action, card_id) VALUES (?, ?, LAST_INSERT_ID());");
		$qLog->execute(array($area, $action)); // add entry into the log
	}

	echo "{" . $action . "}"; // return message to Arduino
?>
