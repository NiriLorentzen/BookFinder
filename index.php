<?php
require_once __DIR__ . '/scripts/sessionStart.php';

$pageTitle = 'Velkommen';
ob_start();
?>
<div class="welcomePage">
    <h1>Velkommen til BookFinder!</h1>

    <p>Er du utkikk etter nye bøker? Sliter du med å finne den som er perfekt for deg?
        Eller kanskje trenger du et sted å lagre bøkene du planlegger å lese? <br><br>
        <b>Da har du kommet til rett sted!</b><hr><br>

        Snakk med vår AI bibliotekar for bokanbefalinger basert på dine preferanser,
        eller søk i vår omfattende bokdatabase. <br><br>

        Slå deg løs, finn deg en bok, og opprett en konto for å lagre dine favorittbøker i din personlige bokhylle.
    </p>
</div>
<?php
$pageContent = ob_get_clean();
include __DIR__ . '/templates/layout.php';
