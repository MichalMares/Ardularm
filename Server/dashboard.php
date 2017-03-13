<?php
	/**
	 * @file dashboard.php
	 * @Author Michal Mareš
	 * @date March, 2017
	 * @brief This script enables the user to see entries in database.
	 */

	include("connect.php");
	$handler = Connection();

	$query = "SELECT * FROM logs LEFT JOIN cards ON logs.card_id=cards.id ORDER BY time DESC LIMIT 50;";
	$result = $handler->query($query);
?>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="Michal Mareš">
    <link rel="icon" href="favicon.png">

    <title>Ardularm</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="navbar.css" rel="stylesheet">
  </head>

  <body>

    <div class="container">

      <!-- Static navbar -->
      <nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.html">Ardularm</a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li><a href="index.php">Domů</a></li>
              <li><a href="docs.php">Dokumentace</a></li>
              <li class="active"><a href="dashboard.php">Uživatel</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>

      <?php
        $dateFrom = $_GET['dateFrom'];
        $dateTo = $_GET['dateTo'];
        $refresh = $_GET['refresh'];
      ?>

      <form class="form-inline" action="dashboard.php" method="get">
        View entries from
        <input class="form-control" type="text" autocomplete="off" name="dateFrom"
					id="dateFrom" size="12" placeholder="YYYY-MM-DD" value="<?php echo $_GET['dateFrom'];?>">
        to
        <input class="form-control" type="text" autocomplete="off" name="dateTo"
					id="dateTo" size="12" placeholder="YYYY-MM-DD" value="<?php echo $_GET['dateTo'];?>">
        <input class="btn btn-default" type="submit" value="Search">
      </form>
      <p>Showing last 50 entries</p>

      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-0 col-sm-offset-0 col-md-0 col-md-offset-0 main">
            <h1 class="page-header">Log</h1>

            <?php
              if ( !(empty($dateFrom)) && !(empty($dateTo)) ) {
                $query = "SELECT * FROM logs LEFT JOIN cards ON logs.card_id=cards.id WHERE time BETWEEN '" . $dateFrom . "' AND '" . $dateTo . "' ORDER BY time DESC;";
                $result = $handler->query($query);
              }
            ?>

            <div class="table-responsive">
              <table class="table table-striped">
            		<tr>
            			<th>Time</th>
            			<th>Action</th>
            			<th>Card ID</th>
            			<th>User</th>
            			<th>UID1</th>
            			<th>UID2</th>
            			<th>UID3</th>
            			<th>UID4</th>
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
            </div>
          </div>
        </div>
      </div>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="js/bootstrap.min.js"></script>

    <!-- jQuery datepicker -->
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
    $(function() {
      $("#dateFrom").datepicker({dateFormat: "yy-mm-dd"});
    });
    $(function() {
      $("#dateTo").datepicker({dateFormat: "yy-mm-dd"});
    });
    </script>
  </body>
</html>
