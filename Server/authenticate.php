<?php
	/**
	 * This function checks whether the key sent by Arduino via POST request
	 * agrees.
	 * @param [type] $input Key sent by Arduino
	 */
	function Authenticate($input) {
		include("config.php");
		
		if ($key == $input) {
			return true;
		}

		else {
			return false;
		}
	}
?>
