<?php
	include("../authenticate.php");

	require '../PHPMailer/PHPMailerAutoload.php';
	$mail = new PHPMailer;

	$key = $_POST['key'];

	if (Authenticate($key)) {
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

		$mail->Subject = 'Area Compromised';
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
	}

	else {
		header("Location: ../index.php");
	}
?>
