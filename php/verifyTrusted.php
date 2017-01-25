<?php
	include("connect.php");
	$handler = Connection();

	$uid1 = $_GET['uid1'];
	$uid2 = $_GET['uid2'];
	$uid3 = $_GET['uid3'];
	$uid4 = $_GET['uid4'];

	$qCheck = "SELECT * FROM cards
		WHERE uid1=? AND uid2=? AND uid3=? AND uid4=?;";

	$result = $handler->prepare($qCheck);
	$result->execute(array($uid1, $uid2, $uid3, $uid4));

	$output;
	if ($result->rowCount() != 0) {
	     while($row = $result->fetch(PDO::FETCH_ASSOC)) {
	         $output = $row["trusted"];
	     }
	} else {
	     $output = 0;
	}

	echo $output;
?>
