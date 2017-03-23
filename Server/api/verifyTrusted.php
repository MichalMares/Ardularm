<?php
	/**
	* @file verifyTrusted.php
	* @Author Michal Mareš
	* @date March, 2017
	* @brief Verifies, if the tag sent by Arduino is set as trusted in database.
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

	$qCheck = "SELECT * FROM cards
		WHERE uid1=? AND uid2=? AND uid3=? AND uid4=?;";

	$result = $handler->prepare($qCheck);
	$result->execute(array($uid1, $uid2, $uid3, $uid4)); // try to find card in the db

	if ($result->rowCount() == 1) { // if card does exist
		$row = $result->fetch(PDO::FETCH_ASSOC);
		$output = $row['trusted']; // get card's trusted value
	} else {
		$output = 0; // if card not found, it is definitely not trusted
	}

	echo "{trusted=" . $output . "}"; // return message with value to Arduino
?>
