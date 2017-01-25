<?php
	function Connection() {
		$dsn = "mysql:dbname=ardularm;host=localhost";
		$user = "root";
		$password = "";

		try {
		    $handler = new PDO($dsn, $user, $password);
		} catch (PDOException $e) {
		    echo 'Connection failed: ' . $e->getMessage();
		}

		return $handler;
	}
?>
