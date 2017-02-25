<?php
	include("connect.php");
	$handler = Connection();
  echo date("Y-m-d")."<br />";
  echo date('Y-m-d', strtotime('-7 days'));

	require 'PHPMailer/PHPMailerAutoload.php';
	$mail = new PHPMailer;

	$key = $_POST['key'];

  $query = "SELECT * FROM logs LEFT JOIN cards ON logs.card_id=cards.id WHERE time BETWEEN '" . $dateFrom . "' AND '" . $dateTo . "' ORDER BY time DESC;";
  $result = $handler->query($query);
	//$mail->SMTPDebug = 3;                               // Enable verbose debug output

	$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->Host = '****.com;';  					// Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                               // Enable SMTP authentication
	$mail->Username = '*****@****.com';     // SMTP username
	$mail->Password = '*****';                       // SMTP password
	$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
	$mail->Port = 587;                                    // TCP port to connect to

	$mail->setFrom('*****@****.com', 'Ardularm');
	$mail->addAddress('*****@****.com', 'Name');			// Add a recipient
	$mail->isHTML(true);																								// Set email format to HTML

	$mail->Subject = 'Weekly Summary';
	$mail->Body    = 'Hello,<br>
		<br>
		there are thieves in your home, get your gun and act quickly!<br>
		<br>
		Your Ardularm';
	$mail->AltBody = 'Hello,

		there are thieves in your home, get your gun and act quickly!

		Your Ardularm';

	if(!$mail->send()) {
		echo '<Message could not be sent.>';
		echo 'Mailer Error: ' . $mail->ErrorInfo;
	} else {
		echo '<OK; message has been sent>';
	}

	$query = $handler->query("INSERT INTO logs (action) VALUES ('Message has been sent');");
?>
