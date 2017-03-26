<?php
  include('header.php');
?>

            <ul class="nav navbar-nav">
              <li class="active"><a href="index.php">Domů</a></li>
              <li><a href="docs.php">Dokumentace</a></li>
              <li><a href="dash.php">Uživatel</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>

      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron">

<h1>Ardularm</h1>
<p>Ardularm is a school project which focuses on making an inexpensive alarm based on the Arduino platform.</p>
<h2>Motivation</h2>
<p>This is a proof-of-concept. Arduino is very powerful!</p>
<h2>Wiring</h2>
<p>Wiring can be seen in <code>Ardularm (wiring).fzz</code> (via Fritzing) or as in PNG format in <code>Ardularm (wiring).png</code>.<br />
Used components are:</p>
<ul>
<li>Arduino UNO Rev3</li>
<li>Ethernet Shield R3</li>
<li>RFID Reader RC522</li>
<li>Passive Infrared Sensor HC-SR501 </li>
<li>Generic RGB Diode</li>
</ul>
<p>(Other components might work as well - not tested.)</p>
<h2>Installation</h2>
<p>Ardularm had been developed with the use od Arduino IDE for the Arduino code and any other editor for the server-side PHP code. Libraries <a href="http://www.addicore.com/v/vspfiles/downloadables/Product%20Downloadables/RFID_RC522/AddicoreRFID.zip">AddicoreRFID</a>* and <a href="http://getbootstrap.com/">Bootstrap framework</a> were used while creating this. To run this project on your own, there are a few steps necessary:</p>
<ol start="3">
<li>Fill in the settings file with the right credentials for your database in <code>Server\config.template.php</code> and save it as <code>Server\config.php</code>.</li>
<li>Run the <code>Server\create.php</code> script. This will create all the tables needed for the project and necessary values.</li>
<li>Create a <code>Server\.htpasswd</code> file with your desired user name and password (<a href="https://faq.oit.gatech.edu/content/how-do-i-do-basicauth-using-htaccess-and-htpasswd">https://faq.oit.gatech.edu/content/how-do-i-do-basicauth-using-htaccess-and-htpasswd</a>).</li>
<li>Upload the content of <code>Server</code> onto your server.</li>
<li>Wire up your Arduino UNO according to wiring section of this document.</li>
<li>Fill in the variables in <code>Arduino\Ardularm\Ardularm.ino</code> under the comment &quot;user-configurable&quot;.</li>
<li>Upload <code>Arduino\Ardularm\Ardularm.ino</code> on your Arduino UNO using the Arduino IDE.</li>
<li>Repeat steps 7, 8, 9 for each unit you want to connect.</li>
<li>Enjoy your extra safety.</li>
</ol>
<p>* The AddicoreRFID library had to be edited in order to work with Ethernet shield.</p>
<h2>How to use Ardularm?</h2>
<p><strong>How to turn Ardularm on/off?</strong><br />
Trusted card has to be used to toggle the state. When the alarm is on the diode turns read, when off it is green (as a traffic light - green means you can enter).</p>
<p><strong>How to add my card into trusted?</strong><br />
First, MasterTag has to be detected and the diode turns blue. Then you can scan your card and it will be added as trusted. BEWARE: If your card is already trusted, it will be REMOVED.</p>
<p><strong>How to view the log?</strong><br />
Log is located on the page <code>../dash.php</code>.</p>
<h2>License</h2>
<p><a href="https://github.com/MichalMares/Ardularm/blob/master/LICENSE.txt">MIT</a> @ <a href="https://github.com/MichalMares">Michal Mareš</a></p>

      </div>

    </div> <!-- /container -->

    <?php
      include('scripts.php');
    ?>

  </body>
</html>