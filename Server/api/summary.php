<?php
	/**
	 * @file summary.php
	 * @Author Michal Mareš
	 * @date March, 2017
	 * @brief This script sends a link with overview of last week's activities.
	 */

	include("../config.php");
	include("../authenticate.php");
	include("../connect.php");
	$handler = Connection();

	$dateFrom = date("Y-m-d");
	$dateTo = date('Y-m-d', strtotime('-7 days'));
	$link = $domain . '/index.php?dateFrom=' . $dateFrom . '&dateTo=' . $dateTo;

	$key = $_GET['key'];
	if (Authenticate($key)) {
		require '../PHPMailer/PHPMailerAutoload.php';
		$mail = new PHPMailer;

		$mail->isSMTP();
		$mail->Host = $mailHost;
		$mail->SMTPAuth = true;
		$mail->Username = $mailUsername;
		$mail->Password = $mailPassword;
		$mail->SMTPSecure = 'tls';
		$mail->Port = 587;

		$mail->setFrom($mailSetFromAddress, $mailSetFromName);
		$mail->addAddress($mailaddAddressAddress, $mailaddAddressName);
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
