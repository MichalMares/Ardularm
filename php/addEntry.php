<?php
	include("connect.php");
	$handler = Connection();

	$uid1 = $_POST['uid1'];
	$uid2 = $_POST['uid2'];
	$uid3 = $_POST['uid3'];
	$uid4 = $_POST['uid4'];
	$action = $_POST['action'];

	$qCheck = "SELECT * FROM cards
		WHERE uid1=? AND uid2=? AND uid3=? AND uid4=?;";

	$result = $handler->prepare($qCheck);
	$result->execute(array($uid1, $uid2, $uid3, $uid4));

	if ($result->rowCount() != 0) {
		$id;
		while($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$id = $row["id"];
		}

		$qLog = $handler->prepare(
			"INSERT INTO logs (action, card_id) VALUES (?, ?);"
		);
		$qLog->execute(array($action, $id));
	} else {
		$qCard = $handler->prepare(
			"INSERT INTO cards (uid1, uid2, uid3, uid4) VALUES (?, ?, ?, ?);"
		);
		$qLog = $handler->prepare(
			"INSERT INTO logs (action, card_id) VALUES (?, LAST_INSERT_ID());"
		);

		$qCard->execute(array($uid1, $uid2, $uid3, $uid4));
		$qLog->execute(array($action));
	}

	header("Location: index.php");
?>
