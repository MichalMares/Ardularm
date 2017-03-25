<?php
	/**
	 * @file dashboard.php
	 * @Author Michal Mareš
	 * @date March, 2017
	 * @brief Enables the user to see entries in database.
	 */
  include('config.php');
	include('connect.php');
	$handler = Connection();

	$query = "SELECT * FROM logs LEFT JOIN cards ON logs.card_id=cards.id ORDER BY time DESC LIMIT 50;";
	$result = $handler->query($query);
?>

<?php
  include("header.php");
?>

            <ul class="nav navbar-nav">
              <li><a href="index.php">Domů</a></li>
              <li><a href="docs.php">Dokumentace</a></li>
              <li class="active"><a href="dash.php">Uživatel</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>

      <?php
        $dateFrom = $_GET['dateFrom'];
        $dateTo = $_GET['dateTo'];
        $refresh = $_GET['refresh'];
      ?>

      <form class="form-inline" action="dash.php" method="get">
        <div class="form-group">
          <label class="sr-only" for="exampleInputAmount">Amount (in dollars)</label>
          <div class="input-group">
            <div class="input-group-addon">From</div>
            <input class="form-control" type="text" autocomplete="off" name="dateFrom" id="dateFrom" size="12" placeholder="YYYY-MM-DD" value="<?php echo $_GET['dateFrom'];?>">
            <div class="input-group-addon">to</div>
            <input class="form-control" type="text" autocomplete="off" name="dateTo" id="dateTo" size="12" placeholder="YYYY-MM-DD" value="<?php echo $_GET['dateTo'];?>">
          </div>
        </div>
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
                  <th>Area</th>
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
            		?>
            	</table>
            </div>
          </div>
        </div>
      </div>

    </div> <!-- /container -->

    <?php
      include('scripts.php');
    ?>
    
    <!-- jQuery datepicker -->
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
    $(function() {
      $("#dateFrom").datepicker({dateFormat: "yy-mm-dd"});
      $("#dateTo").datepicker({dateFormat: "yy-mm-dd"});
    });
    </script>

  </body>
</html>
