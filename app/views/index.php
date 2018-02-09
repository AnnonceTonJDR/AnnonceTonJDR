<?php
require_once 'utils/start_end_page.php';
require_once 'utils/party.php';
require_once 'app/model/Parties.php';
startPage("Annonce ton JDR", [], ["site/party.js"]);
?>
    <br>
    <h1> Annonce ton JDR </h1>
    <br>
    <br>
    <h2>Dernières parties créées</h2>
<?php
foreach (Parties::getLastFiveParties() as $party) {
    displayParty($party);
}
?>


<?php
endPage();
?>