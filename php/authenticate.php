<?php
	// checks if client has the right access key
	function Authenticate($input) {
		$key = "*****";

		if ($key == $input) {
			return true;
		}

		else {
			return false;
		}
	}
?>
