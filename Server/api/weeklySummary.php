<?php
	include("../config.php");
	include("../authenticate.php");
	include("../connect.php");
	$handler = Connection();

	echo date("Y-m-d")."<br />";
	echo date('Y-m-d', strtotime('-7 days'));

	//$key = $_GET['key'];
	if (Authenticate($key)) {
		require '../PHPMailer/PHPMailerAutoload.php';
		$mail = new PHPMailer;

	  $query = "SELECT * FROM logs LEFT JOIN cards ON logs.card_id=cards.id WHERE time BETWEEN '" . $dateFrom . "' AND '" . $dateTo . "' ORDER BY time DESC;";
	  $result = $handler->query($query);

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
