<?php
  /**
   * @file dash.php
   * @Author Michal Mareš
   * @date March, 2017
   * @brief Enables the user to see entries in database.
   */
  include('config.php');
  include('connect.php');
  $handler = Connection();
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

      <script>
        var reloading;

        function ClearFields() {
          document.getElementById("dateFrom").value = "";
          document.getElementById("dateTo").value = "";
        }

        function checkReloading() {
            if (window.location.hash=="#autoreload") {
                reloading=setTimeout("window.location.reload();", 5000);
                document.getElementById("reloadCB").checked=true;
            }
        }

        function toggleAutoRefresh(cb) {
            if (cb.checked) {
                window.location.replace("#autoreload");
                reloading=setTimeout("window.location.reload();", 5000);
            } else {
                window.location.replace("#");
                clearTimeout(reloading);
            }
        }

        window.onload=checkReloading;
      </script>

      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h1>Log</h1>
        
        <form class="form-inline" action="dash.php" method="get">
          <div class="form-group">
            <div class="input-group">
              <div class="input-group-addon">Show entries from</div>
              <input class="form-control" type="text" autocomplete="off" name="dateFrom" id="dateFrom" size="12" placeholder="YYYY-MM-DD" value="<?php echo $_GET['dateFrom'];?>">
              <div class="input-group-addon">to</div>
              <input class="form-control" type="text" autocomplete="off" name="dateTo" id="dateTo" size="12" placeholder="YYYY-MM-DD" value="<?php echo $_GET['dateTo'];?>">
            </div>
          </div>
          <input class="btn btn-default" type="submit" value="Search">
          <input class="btn btn-default" type="button" onclick="ClearFields();" value="Clear">
          <div class="checkbox">
            <label>
              <input type="checkbox" onclick="toggleAutoRefresh(this);" id="reloadCB"> Autorefresh
            </label>
          </div>
        </form>

        <?php
          if ( !(empty($dateFrom)) && !(empty($dateTo)) ) {
            $query = "SELECT * FROM logs LEFT JOIN cards ON logs.card_id=cards.id WHERE time BETWEEN '" . $dateFrom . " 00:00:00' AND '" . $dateTo . " 23:59:59' ORDER BY time DESC;";
            $result = $handler->query($query);

            if ($dateFrom > $dateTo) {
              echo "ERROR: dateFrom > dateTo";
            }
          }
          
          else {
            $query = "SELECT * FROM logs LEFT JOIN cards ON logs.card_id=cards.id ORDER BY time DESC LIMIT 100;";
            $result = $handler->query($query);
            echo "Showing last 100 entries";
          }
        ?>

        <br>
        <a href="/user.php">Change User Name</a>
        </div>

      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-0 col-sm-offset-0 col-md-0 col-md-offset-0 main">

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
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
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
