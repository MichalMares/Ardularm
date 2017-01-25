<?php
	include("connect.php");
	$handler = Connection();

	$uid1 = $_POST['uid1'];
	$uid2 = $_POST['uid2'];
	$uid3 = $_POST['uid3'];
	$uid4 = $_POST['uid4'];

	$qCheck = "SELECT * FROM cards
		WHERE uid1=? AND uid2=? AND uid3=? AND uid4=?;";

	$result = $handler->prepare($qCheck);
	$result->execute(array($uid1, $uid2, $uid3, $uid4));

	// Is tag in database already?
	if ($result->rowCount() != 0) {
	    $id;
	    $trusted;

	    $result->execute(array($uid1, $uid2, $uid3, $uid4));
	    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
	        $id = $row["id"];
	    }

	    $result->execute(array($uid1, $uid2, $uid3, $uid4));
	    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
	        $trusted = $row["trusted"];
	    }

    	// Is it trusted?
	    if ($trusted == 1) {
	    	$action = "Tag REMOVED from trusted";

				$qCard = $handler->prepare("UPDATE cards SET trusted=0 WHERE id=?;");
				$qCard->execute(array($id));

	     	$qLog = $handler->prepare("INSERT INTO logs (action, card_id) VALUES ('$action', '$id');");
				$qLog->execute(array($action, $id));
	    }

    	// Is it not trusted?
	    else if ($trusted == 0) {
	    	$action = "Tag ADDED as trusted";

				$qCard = $handler->prepare("UPDATE cards SET trusted=1 WHERE id=?;");
				$qCard->execute(array($id));

	     	$qLog = $handler->prepare("INSERT INTO logs (action, card_id) VALUES ('$action', '$id');");
				$qLog->execute(array($action, $id));
	    }
	}

	// Not in database -> not trusted -> add
	else {
		$action = "Tag ADDED as trusted";
		$qCard = $handler->prepare("INSERT INTO cards (trusted, uid1, uid2, uid3, uid4)	VALUES (1, ?, ?, ?, ?);");
		$qCard->execute(array($uid1, $uid2, $uid3, $uid4));

		$qLog = $handler->prepare("INSERT INTO logs (action, card_id) VALUES (?, LAST_INSERT_ID());");
		$qLog->execute(array($action));
	}

	header("Location: index.php");
?>
