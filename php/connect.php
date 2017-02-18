<?php
	// establishes connection with the database
	function Connection() {
		$dsn = "mysql:dbname=*****;host=*****:*****";
		$user = "*****";
		$password = "*****";

		try {
			$handler = new PDO($dsn, $user, $password);
		} catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
			exit();
		}

		return $handler;
	}
?>
