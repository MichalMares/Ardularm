<?php
	include("connect.php");
	$handler = Connection();

	$to      = 'mamivaji@seznam.cz';
	$subject = 'Alarm Breached';
	$message = '
		Dear user,

		Alarm system registered unauthorized movement in your house. We advise you to check the house immediatelly.

		Sincerely,
		your Ardularm

		THIS EMAIL IS GENERATED ATOMATICALLY, DO NOT REPLY
	';
	$headers = 'From: ardularm.github.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion();

	mail($to, $subject, $message, $headers);

	$query = "INSERT INTO logs (action) VALUES ('E-mail sent');";
	mysqli_query($link, $query);

	header("Location: index.php");
?>
