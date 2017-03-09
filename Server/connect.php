<?php
	/**
	 * @file connect.php
	 * @Author Michal Mareš
	 * @date March, 2017
	 */

	/**
	 * This function establishes connection with the database.
	 * @return object $handler Returns a connection.
	 */
	function Connection() {
		include("config.php");

		try {
			$handler = new PDO($dsn, $user, $password);
		} catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
			exit();
		}

		return $handler;
	}
?>