<?php
  include('header.php');
?>

            <ul class="nav navbar-nav">
              <li><a href="index.php">Domů</a></li>
              <li class="active"><a href="docs.php">Dokumentace</a></li>
              <li><a href="dash.php">Uživatel</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>

      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h1>Arduino</h1>
        <p>Část, která je programována na Arduinu.</p>
        <br>
        <h1>Server</h1>
        <p>Serverová část v PHP.</p>
      </div>

    </div> <!-- /container -->


    <?php
      include('scripts.php');
    ?>
  </body>
</html>
