<?php
	/**
	 * @file manageState.php
	 * @Author Michal Mareš
	 * @date March, 2017
	 * @brief This script toggles the state of the alarm.
	 */

	include("../authenticate.php");
	include("../connect.php");
	$handler = Connection();

	$key = $_POST['key'];
	$option = $_POST['option'];

	if (Authenticate($key)) {
		$qCheck = "SELECT * FROM settings WHERE setting='alarmState';";
		$result = $handler->query($qCheck);

		if ($result->rowCount() == 1) {
			$row = $result->fetch(PDO::FETCH_ASSOC);
			$output = $row['value']; // now output is 1 or 0

			if ($option == "get") {
				echo "<OK; alarmState=" . $output . ">";
			}

			else if ($option == "change") {
				$query = "UPDATE settings SET value=? WHERE setting='alarmState';";
				$change = $handler->prepare($query);
				if ($output == 1) {
					$value = 0;
				}
				else if ($output == 0) {
					$value = 1;
				}
				$change->execute(array($value));
				echo "<OK; changed to alarmState=" . $value . ">";
			}
		}
	}

	else {
		header("Location: ../index.php");
	}
?>
