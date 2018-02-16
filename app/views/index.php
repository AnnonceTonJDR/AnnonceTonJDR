<?php
require_once 'utils/start_end_page.php';
require_once 'utils/party.php';
require_once 'app/model/Parties.php';
startPage("Annonce ton JDR", ["index.css"], ["site/party.js"]);
?>
    <br>
    <div class="speechIndex">
        <p>Bienvenue sur AnnonceTonJDR. Ce site vous permettra de consulter et de créer des annonces de jeux de rôle
            autour
            d'une table.
            <a target="_blank" href="//www.facebook.com/Annonce-Ton-JDR-1248933045203703/">Suivre notre page
                Facebook</a></p>
    </div>
    <br>
    <h1> Dernières parties créées </h1>
<?php
foreach (Parties::getLastFiveParties() as $party) {
    displayParty($party, false);
}
?>


<?php
endPage();
?>