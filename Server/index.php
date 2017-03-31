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
<p>Ardularm je projekt, který se zabývá vytvořením levného domácího alarmu prostřednictvím platformy Arduino.</p>
<h2>Komponenty a zapojení</h2>
<p>Schéma zapojení:</p>
<p><img src="DoxyDoc/Wiring.png" alt="Wiring" width=100%/></p>
<p>Použité součástky:</p>
<ul>
<li><p>Arduino UNO Rev3</p></li>
<li><p>Ethernet Shield R3</p></li>
<li><p>RFID Reader RC522</p></li>
<li><p>Passive Infrared Sensor HC-SR501 </p></li>
<li><p>Generic RGB Diode</p></li>
</ul>
<p>(Jiné součástky mohou také fungovat - nevyzkoušeno.)</p>
<h2>Instalace</h2>
<p>Ardularm byl vytvořen pomocí Arduino IDE (kód pro Arduino) a dalším editorem (pro serverovou část, PHP kód). Knihovny <a href="http://www.addicore.com/v/vspfiles/downloadables/Product%20Downloadables/RFID_RC522/AddicoreRFID.zip">AddicoreRFID</a>* a <a href="http://getbootstrap.com/">Bootstrap framework</a> byly využity při vývoji. Pro instalaci projektu je potřeba:</p>
<ol>
<li><p>Vytvořte databázi na vašem hostingu.</p></li>
<li><p>Upravte a vyplňte <code>Server\config.template.php</code> a uložte soubor jako <code>Server\config.php</code>.</p></li>
<li><p>Vytvořte soubor <code>Server\.htpasswd</code> se zvoleným uživatelským jménem a heslem (<a href="https://faq.oit.gatech.edu/content/how-do-i-do-basicauth-using-htaccess-and-htpasswd">https://faq.oit.gatech.edu/content/how-do-i-do-basicauth-using-htaccess-and-htpasswd</a>).</p></li>
<li><p>Nahrajte obsah adresáře <code>Server</code> na server.</p></li>
<li><p>Spusťte <code>Server\create.php</code>. Tím automaticky vytvoříte tabulky databáze potřebné pro fungování Ardularmu.</p></li>
<li><p>Zapojte vaše Arduino UNO podle sekce &quot;Komponenty a zapojení&quot;.</p></li>
<li><p>Vyplňte proměnné v <code>Arduino\Ardularm\Ardularm.ino</code> pod komentářem &quot;user-configurable&quot;.</p></li>
<li><p>Nahrajte <code>Arduino\Ardularm\Ardularm.ino</code> na vaše Arduino UNO prostřednictvím Arduino IDE.</p></li>
<li><p>Opakujte kroky 6, 7, 8 pro každé zařízení, které si přejete připojit.</p></li>
<li><p>Užívejte si pocit bezpečí.</p></li>
</ol>
<p>* Knihovna AddicoreRFID musela být modifikována, aby fungovala paralelně s Ethernet Shield.</p>
<h2>Návod k použití</h2>
<p><strong>Zapnutí/vypnutí alarmu</strong><br />
Pouze důvěryhodné karty mohou přepínat stav alarmu. Pokud je alarm aktivní, svítí červeně, pokud neaktivní, zeleně (jako semafor - zelená znamená, že můžete projít).</p>
<p><strong>Přidat/odebrat kartu do/z důvěryhodných</strong><br />
Nejdříve je potřeba načíst MasterTag (administrátorská karta) a vyčkat, než se dioda rozsvítí modře. Pak lze načíst další kartu, která bude zaevidována jako důvěryhodná, pokud předtím nebyla. POZOR: Pokud karta již byla důvěryhodná, bude z důvěryhodných ODEBRÁNA.</p>
<p><strong>Zobrazení událost</strong><br />
Zobrazení událostí je možné v logu na <code>../dash.php</code>.</p>
<p><strong>Změna jména karty</strong>
Pod výběrem data u logu klikněte na &quot;Change User Name&quot;.</p>
<h2>Licence</h2>
<p><a href="https://github.com/MichalMares/Ardularm/blob/master/LICENSE.txt">MIT</a> @ <a href="https://github.com/MichalMares">Michal Mareš</a></p>

      </div>

    </div> <!-- /container -->

    <?php
      include('scripts.php');
    ?>

  </body>
</html>