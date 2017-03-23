<?php
	/**
	 * @file manageState.php
	 * @Author Michal Mareš
	 * @date March, 2017
	 * @brief Toggles the state of the alarm.
	 */

	include("../authenticate.php");
	include("../connect.php");
	include("../config.php");
	$handler = Connection();
	Authenticate();

	$option = $_POST['option'];

	$qCheck = "SELECT * FROM settings WHERE setting='alarmState';";
	$result = $handler->query($qCheck); // find alarmState in the db

	if ($result->rowCount() == 1) {
		$row = $result->fetch(PDO::FETCH_ASSOC);
		$output = $row['value']; // get alarmState value

		if ($option == "sync") { // if Arduino wants to synchronize
			echo "{Sync: alarmState=" . $output . "}"; // return current state back to Arduino
		}

		else if ($option == "change") { // if Arduino wants to change the state
			$query = "UPDATE settings SET value=? WHERE setting='alarmState';";
			$change = $handler->prepare($query);
			if ($output == 1) {
				$value = 0;
			}
			else if ($output == 0) {
				$value = 1;
			}
			$change->execute(array($value));
			echo "{Change: alarmState=" . $value . "}"; // confirm the change to the Arduino
		}
	}
?>
