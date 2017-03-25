<?php
	/**
	 * @file sendMail.php
	 * @Author Michal Mareš
	 * @date March, 2017
	 * @brief Sends an email about detected breach.
	 */

	include("../authenticate.php");
	include("../connect.php");
	include("../config.php");
	$handler = Connection();
	Authenticate();

	$area = $_POST['area'];

	require '../PHPMailer/PHPMailerAutoload.php';
	$mail = new PHPMailer;

	$mail->isSMTP();
	$mail->Host = CONFIG::mailHost;
	$mail->SMTPAuth = true;
	$mail->Username = CONFIG::mailUsername;
	$mail->Password = CONFIG::mailPassword;
	$mail->SMTPSecure = 'tls';
	$mail->Port = 587;

	$mail->setFrom(CONFIG::mailSetFromAddress, CONFIG::mailSetFromName);
	$mail->addAddress(CONFIG::mailAddAddressAddress, CONFIG::mailAddAddressName);

	$mail->isHTML(false);

	$mail->Subject = 'Area Compromised';
	$mail->Body    = 'Hello

A breach was detected in secured area called "' . $area . '". You might want to check it out.

Your Ardularm';

	if(!$mail->send()) {
		echo '{ERROR: Email NOT Sent}';
		echo '<br>';
		echo 'Mailer Error: ' . $mail->ErrorInfo;
		$query = $handler->prepare("INSERT INTO logs (area, action) VALUES (?, 'ERROR: Email NOT Sent');");
	} else {
		echo '{Email Sent}';
		$query = $handler->prepare("INSERT INTO logs (area, action) VALUES (?, 'Email Sent');");
	}
	$query->execute(array($area));
?>
