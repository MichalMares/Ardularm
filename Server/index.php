<?php
	/**
	 * @file index.php
	 * @Author Michal Mareš
	 * @date March, 2017
	 * @brief This script enables the user to see entries in database.
	 */

	include("connect.php");
	$handler = Connection();

	$query = "SELECT * FROM logs LEFT JOIN cards ON logs.card_id=cards.id ORDER BY time DESC LIMIT 50;";
	$result = $handler->query($query);
?>

<html>
<head>
	<!-- <meta http-equiv="refresh" content="30"> -->
	<title>Ardularm</title>

	<link rel="shortcut icon" type="image/x-icon" href="favicon.png">
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Noto+Sans">
	<link rel="stylesheet" type="text/css" href="styles.css">

	<!-- jQuery datepicker -->
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script>
	$(function() {
		$("#dateFrom").datepicker({dateFormat: "yy-mm-dd"});
	});
	$(function() {
		$("#dateTo").datepicker({dateFormat: "yy-mm-dd"});
	});
	</script>
</head>

<body>
	<h1>Ardularm log</h1>
	<?php
		$dateFrom = $_GET['dateFrom'];
		$dateTo = $_GET['dateTo'];
		$refresh = $_GET['refresh'];
	?>

	<form action="index.php" method="get">
		View entries from
		<input type="text" name="dateFrom" id="dateFrom" size="12"
			placeholder="YYYY-MM-DD" value="<?php echo $_GET['dateFrom'];?>">
		to
		<input type="text" name="dateTo" id="dateTo" size="12"
			placeholder="YYYY-MM-DD" value="<?php echo $_GET['dateTo'];?>">
		<input type="submit" value="Search">
	</form>
	<p>Showing last 50 entries</p>

	<?php
		if ( !(empty($dateFrom)) && !(empty($dateTo)) ) {
			$query = "SELECT * FROM logs LEFT JOIN cards ON logs.card_id=cards.id WHERE time BETWEEN '" . $dateFrom . "' AND '" . $dateTo . "' ORDER BY time DESC;";
			$result = $handler->query($query);
		}
	?>

	<table class="log">
		<tr>
			<th width=15%>Time</th>
			<th width=45%>Action</th>
			<th width=5%>Card ID</th>
			<th width=15%>User</th>
			<th width=5%>UID1</th>
			<th width=5%>UID2</th>
			<th width=5%>UID3</th>
			<th width=5%>UID4</th>
		</tr>

		<?php
			if ($result!==FALSE) {
				while ($row = $result->fetch()) {
					echo "<tr>
						<td> {$row['time']} </td>
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
		?>
	</table>
</body>
</html>
