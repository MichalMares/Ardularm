<?php
	/**
	* @file verifyTrusted.php
	* @Author Michal Mareš
	* @date March, 2017
	* @brief This script verifies, if the tag sent by Arduino is set as trusted in database.
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

		if ($result->rowCount() == 1) {
			$row = $result->fetch(PDO::FETCH_ASSOC);
			$output = $row['trusted'];
		} else {
			$output = 0;
		}

		echo "<OK; tag=" . $output . ">";
	}

	else {
		header("Location: ../index.php");
	}
?>
