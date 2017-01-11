<?php
	include("connect.php");
	$link = Connection();

	$uid1 = mysqli_real_escape_string($link, $_POST['uid1']);
	$uid2 = mysqli_real_escape_string($link, $_POST['uid2']);
	$uid3 = mysqli_real_escape_string($link, $_POST['uid3']);
	$uid4 = mysqli_real_escape_string($link, $_POST['uid4']);

	$qCheck = "SELECT * FROM cards
		WHERE uid1='$uid1' AND uid2='$uid2' AND uid3='$uid3' AND uid4='$uid4';";

	$result = mysqli_query($link, $qCheck);

	// is tag in database already?
	if (mysqli_num_rows($result) != 0) {
	    $id;
	    $trusted;

	    $result = mysqli_query($link, $qCheck);
	    while($row = mysqli_fetch_assoc($result)) {
	        $id = $row["id"];
	    }

	    $result = mysqli_query($link, $qCheck);
	    while($row = mysqli_fetch_assoc($result)) {
	        $trusted = $row["trusted"];
	    }

    	// is trusted
	    if ($trusted == 1) {
	    	$action = "Tag REMOVED from trusted";
		    $qCard = "UPDATE cards SET trusted=0 WHERE id='$id';";
	     	$qLog = "INSERT INTO logs (action, card_id)
				VALUES ('$action', '$id');";

			mysqli_query($link, $qCard);
			mysqli_query($link, $qLog);
	    }

    	// is not trusted
	    else if ($trusted == 0) {
	    	$action = "Tag ADDED as trusted";
		    $qCard = "UPDATE cards SET trusted=1 WHERE id='$id';";
	     	$qLog = "INSERT INTO logs (action, card_id)
				VALUES ('$action', '$id');";

			mysqli_query($link, $qCard);
			mysqli_query($link, $qLog);
	    }
	}

	// not in database -> not trusted
	else {
		$action = "Tag ADDED as trusted";
		$qCard = "INSERT INTO cards (trusted, uid1, uid2, uid3, uid4)
			VALUES (1, '$uid1', '$uid2', '$uid3', '$uid4');";
		$qLog = "INSERT INTO logs (action, card_id)
			VALUES ('$action', LAST_INSERT_ID());";

		mysqli_query($link, $qCard);
		mysqli_query($link, $qLog);
	}

	mysqli_close($link);

	header("Location: index.php");
?>
