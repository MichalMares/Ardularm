<?php
	/**
	 * @file authenticate.php
	 * @Author Michal Mareš
	 * @date March, 2017
	 */

	/**
	 * Checks whether the key sent by Arduino via POST request agrees.
	 */
	function Authenticate() {
		$input = $_POST['key'];
		if (!isset($_POST['key'])) {
			$input = $_GET['key'];
		}

		if ($input != CONFIG::key) {
			header("Location: ../dash.php");
			die();
		}
	}
?>
