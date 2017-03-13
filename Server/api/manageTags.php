<?php
	/**
	 * @file manageTags.php
	 * @Author Michal Mareš
	 * @date March, 2017
	 * @brief This script changes, whether the tag is or is not trusted.
	 */

	include("../authenticate.php");
	include("../connect.php");
	$handler = Connection();

	$key = $_POST['key'];
	$uid1 = $_POST['uid1'];
	$uid2 = $_POST['uid2'];
	$uid3 = $_POST['uid3'];
	$uid4 = $_POST['uid4'];

	if (Authenticate($key)) {
		$qCheck = "SELECT * FROM cards
		WHERE uid1=? AND uid2=? AND uid3=? AND uid4=?;";

		$result = $handler->prepare($qCheck);
		$result->execute(array($uid1, $uid2, $uid3, $uid4));

		// Is tag in database already?
		if ($result->rowCount() == 1) {
			$result->execute(array($uid1, $uid2, $uid3, $uid4)); // why doesn't it work without executing again?
			while($row = $result->fetch(PDO::FETCH_ASSOC)) {
				$id = $row["id"]; // edit withou while
			}

			$result->execute(array($uid1, $uid2, $uid3, $uid4));
			while($row = $result->fetch(PDO::FETCH_ASSOC)) {
				$trusted = $row["trusted"];
			}

			// Is it trusted?
			if ($trusted == 1) {
				$action = "Tag REMOVED from trusted";
				$trusted = 0;
			}

			// Is it not trusted?
			else if ($trusted == 0) {
				$action = "Tag ADDED as trusted";
				$trusted = 1;
			}

			$qCard = $handler->prepare("UPDATE cards SET trusted=? WHERE id=?;");
			$qCard->execute(array($trusted, $id));

			$qLog = $handler->prepare("INSERT INTO logs (action, card_id) VALUES (?, ?);");
			$qLog->execute(array($action, $id));
		}

		// Not in database -> not trusted -> add
		else {
			$action = "Tag ADDED as trusted";
			$qCard = $handler->prepare("INSERT INTO cards (trusted, uid1, uid2, uid3, uid4)	VALUES (1, ?, ?, ?, ?);");
			$qCard->execute(array($uid1, $uid2, $uid3, $uid4));

			$qLog = $handler->prepare("INSERT INTO logs (action, card_id) VALUES (?, LAST_INSERT_ID());");
			$qLog->execute(array($action));
		}

		echo "{" . $action . "}";
	}

	else {
		header("Location: ../index.php");
	}
?>
