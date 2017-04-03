<?php
	/**
	 * @file connect.php
	 * @Author Michal Mareš
	 * @date March, 2017
	 * @brief Connects to the database.
	 */

	/**
	 * Establishes connection with the database.
	 * @return object $handler Returns a connection.
	 */
	function Connection() {
		try {
			$handler = new PDO(CONFIG::dsn, CONFIG::user, CONFIG::password);
		} catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
			exit();
		}

		return $handler;
	}
?>
