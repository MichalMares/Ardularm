<?php
	include("connect.php");
	$handler = Connection();

	$query = "SELECT * FROM logs LEFT JOIN cards ON logs.card_id=cards.id ORDER BY time DESC;";
	$result = $handler->query($query);
?>

<html>
<head>
	<meta http-equiv="refresh" content="5" >
  	<title>Ardularm</title>

  	<link rel="shortcut icon" type="image/x-icon" href="favicon.png">

  	<link rel="stylesheet" type="text/css"
      href="https://fonts.googleapis.com/css?family=Noto+Sans">

	<style>
		body {
 			font-family: 'Noto Sans', serif;
 			color: #71f525;
 			background-color: #000000;
		}
		table, th, td {
			border: 1px solid #ddd;
			border-collapse: collapse;
			text-align: center;
			padding: 5px;
		}
		table {
			width: 100%;
		}
		tr:hover {
			background-color: #202020;
		}
	</style>
</head>

<body>
   <h1>Ardularm log</h1>

   <table>
		<tr>
			<th width=15%>time</th>
			<th width=45%>action</th>
			<th width=5%>card_id</th>
			<th width=15%>user_name</th>
			<th width=5%>uid1</th>
			<th width=5%>uid2</th>
			<th width=5%>uid3</th>
			<th width=5%>uid4</th>
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
