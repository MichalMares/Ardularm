<?php
	include("connect.php");
	$link = Connection();

	$uid1 = mysqli_real_escape_string($link, $_GET['uid1']);
	$uid2 = mysqli_real_escape_string($link, $_GET['uid2']);
	$uid3 = mysqli_real_escape_string($link, $_GET['uid3']);
	$uid4 = mysqli_real_escape_string($link, $_GET['uid4']);

	$query = "SELECT trusted FROM cards WHERE uid1='$uid1' AND uid2='$uid2' AND uid3='$uid3' AND uid4='$uid4';";

	$result = mysqli_query($link, $query);

	$output;
	if (mysqli_num_rows($result) > 0) {
	     // output data of each row
	     while($row = mysqli_fetch_assoc($result)) {
	         $output = $row["trusted"];
	     }
	} else {
	     $output = 0;
	}

	echo $output;

	mysqli_close($link);
?>
