<?php
  /**
   * @file user.php
   * @Author Michal Mareš
   * @date March, 2017
   * @brief Enables the user to change names associated with cards.
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
        $uid1 = $_POST['uid1'];
        $uid2 = $_POST['uid2'];
        $uid3 = $_POST['uid3'];
        $uid4 = $_POST['uid4'];
        $name = $_POST['name'];

        $query = "UPDATE cards SET user_name=? WHERE uid1=? AND uid2=? AND uid3=? AND uid4=?;";

        $sth = $handler->prepare($query);
        $sth->execute(array($name, $uid1, $uid2, $uid3, $uid4)); // update name for corresponding card
      ?>

      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h1>Change Card Name</h1>

        <form class="form-inline" action="user.php" method="post">
          <input class="form-control" type="text" autocomplete="off" name="uid1" id="uid1" size="12" placeholder="UID1" value="">
          <input class="form-control" type="text" autocomplete="off" name="uid2" id="uid2" size="12" placeholder="UID2" value="">
          <input class="form-control" type="text" autocomplete="off" name="uid3" id="uid3" size="12" placeholder="UID3" value="">
          <input class="form-control" type="text" autocomplete="off" name="uid4" id="uid4" size="12" placeholder="UID4" value="">
          <br>
          <br>
          <input class="form-control" type="text" autocomplete="off" name="name" id="name" size="12" placeholder="Name" value="">
          <input class="btn btn-default" type="submit" value="Change">
        </form>

        <?php
          if (!(empty($uid1)) || !(empty($uid2)) || !(empty($uid3)) || !(empty($uid4)) || !(empty($name))) {
            $qCheck = "SELECT * FROM cards WHERE uid1=? AND uid2=? AND uid3=? AND uid4=?;";

            $result = $handler->prepare($qCheck);
            $result->execute(array($uid1, $uid2, $uid3, $uid4)); // try to find card in the db

            if ($result->rowCount() == 1) { // if card does exist
              echo "Done";
            } else {
              echo "ERROR: Card Not Found";
            }
          }
        ?>

      </div>
    </div> <!-- /container -->

    <?php
      include('scripts.php');
    ?>

  </body>
</html>