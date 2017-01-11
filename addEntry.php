<?php
	include("connect.php");
	$link = Connection();

	$uid1 = mysqli_real_escape_string($link, $_POST['uid1']);
	$uid2 = mysqli_real_escape_string($link, $_POST['uid2']);
	$uid3 = mysqli_real_escape_string($link, $_POST['uid3']);
	$uid4 = mysqli_real_escape_string($link, $_POST['uid4']);
	$action = mysqli_real_escape_string($link, $_POST['action']);

	$qCheck = "SELECT * FROM cards
		WHERE uid1='$uid1' AND uid2='$uid2' AND uid3='$uid3' AND uid4='$uid4';";

	$result = mysqli_query($link, $qCheck);

	if (mysqli_num_rows($result) != 0) {
	    $id;
	    while($row = mysqli_fetch_assoc($result)) {
	        $id = $row["id"];
	    }

     	$qLog = "INSERT INTO logs (action, card_id)
			VALUES ('$action', '$id');";
		mysqli_query($link, $qLog);
	}

	else {
		$qCard = "INSERT INTO cards (uid1, uid2, uid3, uid4)
			VALUES ('$uid1', '$uid2', '$uid3', '$uid4');";
		$qLog = "INSERT INTO logs (action, card_id)
			VALUES ('$action', LAST_INSERT_ID());";

		mysqli_query($link, $qCard);
		mysqli_query($link, $qLog);
	}

	mysqli_close($link);

	header("Location: index.php");
?>
