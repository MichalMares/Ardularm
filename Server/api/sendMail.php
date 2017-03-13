<?php
	/**
	 * @file sendMail.php
	 * @Author Michal Mareš
	 * @date March, 2017
	 * @brief This script sends an email about detected breach.
	 */

	include("../authenticate.php");
	include("../connect.php");
	include("../config.php");
	$handler = Connection();

	require '../PHPMailer/PHPMailerAutoload.php';
	$mail = new PHPMailer;

	$key = $_POST['key'];

	if (Authenticate($key)) {

		//$mail->SMTPDebug = 3;                               // Enable verbose debug output

		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = $mailHost;  					// Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = $mailUsername;     // SMTP username
		$mail->Password = $mailPassword;                       // SMTP password
		$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 587;                                    // TCP port to connect to

		$mail->setFrom($mailSetFromAddress, $mailSetFromName);
		$mail->addAddress($mailaddAddressAddress, $mailaddAddressName);     // Add a recipient
		//$mail->addAddress('ellen@example.com');               // Name is optional
		//$mail->addReplyTo('info@example.com', 'Information');
		//$mail->addCC('cc@example.com');
		//$mail->addBCC('bcc@example.com');

		//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
		//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
		$mail->isHTML(true);                                  // Set email format to HTML

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
			echo '{ERROR: Email not sent}';
			echo 'Mailer Error: ' . $mail->ErrorInfo;
		} else {
			echo '{Email sent}';
		}

		$query = $handler->query("INSERT INTO logs (action) VALUES ('Message has been sent');");
	}

	else {
		header('Location: ../index.php');
	}
?>
