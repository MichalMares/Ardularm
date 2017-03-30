<?php
	/**
	 * @file summary.php
	 * @Author Michal Mareš
	 * @date March, 2017
	 * @brief Sends an email with a table of last week's activities.
	 */

	include("../authenticate.php");
	include("../connect.php");
	include("../config.php");
	$handler = Connection();
	Authenticate();

	$dateTo = date("Y-m-d");
	$dateFrom = date('Y-m-d', strtotime('-7 days'));
	$link = CONFIG::domain . '/dash.php?dateFrom=' . $dateFrom . '&dateTo=' . $dateTo;

	$query = "SELECT * FROM logs LEFT JOIN cards ON logs.card_id=cards.id
		WHERE time BETWEEN '" . $dateFrom . " 00:00:00' AND '" . $dateTo . " 23:59:59' ORDER BY time DESC;";
	$result = $handler->query($query);

	$msg = "Hello,<br>
	<br>
	This is your action summary for the past week:<br>";

	$msg .= "<table>
				<tr>
					<th>Time</th>
					<th>Area</th>
					<th>Action</th>
					<th>Card ID</th>
					<th>User</th>
					<th>UID1</th>
					<th>UID2</th>
					<th>UID3</th>
					<th>UID4</th>
				</tr>";

	if ($result!==FALSE) {
		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$msg .= "<tr>
				<td> {$row['time']} </td>
				<td> {$row['area']} </td>
				<td> {$row['action']} </td>
				<td> {$row['card_id']} </td>
				<td> {$row['user_name']} </td>
				<td> {$row['uid1']} </td>
				<td> {$row['uid2']} </td>
				<td> {$row['uid3']} </td>
				<td> {$row['uid4']} </td>
			</tr>";
		}
	}

	$msg .= "</table><br><br>
		Your Ardularm";

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
	$mail->Body    = $msg;
	$mail->AltBody = 'Hello,
This is your action summary for the past week. To view this, you have to open HTML version of this email or manually enter this address: ' . $link . '
Your Ardularm';

	if (!$mail->send()) {
		echo '{ERROR: Summary NOT Sent}';
		echo 'Mailer Error: ' . $mail->ErrorInfo;
		$query = $handler->query("INSERT INTO logs (action) VALUES ('ERROR: Summary NOT Sent');");
	} else {
		echo '{Summary Sent}';
		$query = $handler->query("INSERT INTO logs (action) VALUES ('Summary Sent');");
	}

?>
