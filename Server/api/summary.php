<?php
	/**
	 * @file summary.php
	 * @Author Michal Mareš
	 * @date March, 2017
	 * @brief Sends a link with overview of last week's activities.
	 */

	include("../authenticate.php");
	include("../connect.php");
	include("../config.php");
	$handler = Connection();
	Authenticate();

	$dateFrom = date("Y-m-d");
	$dateTo = date('Y-m-d', strtotime('-7 days'));
	$link = CONFIG::domain . '/dash.php?dateFrom=' . $dateFrom . '&dateTo=' . $dateTo;

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
	$mail->isHTML(true);

	$mail->Subject = 'Weekly Summary';
	$mail->Body    = 'Hello,<br>
		<br>
		You can view your action summary for the past week <a href="' . $link . '">here</a>.<br>
		<br>
		Your Ardularm';
	$mail->AltBody = 'Hello,

		This is your action summary for the past week. To view this, you have to open HTML version of this email.

		Your Ardularm';

	if(!$mail->send()) {
		echo '{ERROR: Summary not sent}';
		echo 'Mailer Error: ' . $mail->ErrorInfo;
	} else {
		echo '{Summary sent}';
	}

	$query = $handler->query("INSERT INTO logs (action) VALUES ('Summary sent');");
?>
