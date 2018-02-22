<?php
require_once 'utils/start_end_page.php';
require_once 'utils/party.php';
require_once 'app/model/Parties.php';
startPage("Annonce Ton JDR", ["index.css"], ["site/party.js"]);
?>
    <br>
    <div class="speechIndex">
        <p>Bienvenue sur Annonce Ton JDR.<br>Ce site vous permet de consulter et de créer des annonces de jeux de rôle
            autour
            d'une table.
            <a target="_blank" href="//www.facebook.com/Annonce-Ton-JDR-1248933045203703/">Suivre notre page
                Facebook</a></p>
    </div>
    <br>
    <h1> Dernières parties créées </h1>
<?php
$user = isset($_SESSION['session']) ? Session::unserializeConnectedUser() : null;
foreach (Parties::getLastFiveParties() as $party) {
    displayParty($party, false, $user);
}
?>


<?php
endPage();
?>