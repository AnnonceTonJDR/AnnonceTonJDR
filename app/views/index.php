<?php
require_once 'utils/start_end_page.php';
require_once 'utils/party.php';
require_once 'app/model/Parties.php';
startPage("Annonce ton JDR", [], ["site/party.js"]);
?>
    <br>
    <h1> Dernières parties créées </h1>
<?php
foreach (Parties::getLastFiveParties() as $party) {
    displayParty($party);
}
?>


<?php
endPage();
?>