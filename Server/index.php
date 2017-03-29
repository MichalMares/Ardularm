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
<p>Zapojení je zobrazeno v souboru <code>Ardularm (wiring).fzz</code> (formát programu Fritzing) nebo ve formátu PNG <code>Ardularm (wiring).png</code>.<br />
Použité součástky:</p>
<ul>
<li>Arduino UNO Rev3</li>
<li>Ethernet Shield R3</li>
<li>RFID Reader RC522</li>
<li>Passive Infrared Sensor HC-SR501 </li>
<li>Generic RGB Diode</li>
</ul>
<p>(Jiné součástky mohou také fungovat - nevyzkoušeno.)</p>
<h2>Instalace</h2>
<p>Ardularm byl vytvořen pomocí Arduino IDE (kód pro Arduino) a dalším editorem (pro serverovou část, PHP kód). Knihovny <a href="http://www.addicore.com/v/vspfiles/downloadables/Product%20Downloadables/RFID_RC522/AddicoreRFID.zip">AddicoreRFID</a>* a <a href="http://getbootstrap.com/">Bootstrap framework</a> byly využity při vývoji. Pro instalaci projektu je potřeba:</p>
<ol>
<li>Upravte a vyplňte <code>Server\config.template.php</code> a uložte soubor jako <code>Server\config.php</code>.</li>
<li>Vytvořte soubor <code>Server\.htpasswd</code> se zvoleným uživatelským jménem a heslem (<a href="https://faq.oit.gatech.edu/content/how-do-i-do-basicauth-using-htaccess-and-htpasswd">https://faq.oit.gatech.edu/content/how-do-i-do-basicauth-using-htaccess-and-htpasswd</a>).</li>
<li>Nahrajte obsah adresáře <code>Server</code> na server.</li>
<li>Spusťte <code>Server\create.php</code>. Tím automaticky vytvoříte tabulky databáze potřebné pro fungování Ardularmu.</li>
<li>Zapojte vaše Arduino UNO podle sekce &quot;Komponenty a zapojení&quot;.</li>
<li>Vyplňte proměnné v <code>Arduino\Ardularm\Ardularm.ino</code> pod komentářem &quot;user-configurable&quot;.</li>
<li>Nahrajte <code>Arduino\Ardularm\Ardularm.ino</code> na vaše Arduino UNO prostřednictvím Arduino IDE.</li>
<li>Opakujte kroky 5, 6, 7 pro každé zařízení, které si přejete připojit.</li>
<li>Užívejte si pocit bezpečí.</li>
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