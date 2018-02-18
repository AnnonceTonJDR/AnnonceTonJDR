<?php
require_once 'utils/start_end_page.php';
require_once 'app/model/Parties.php';
require_once 'app/model/Users.php';
require_once 'app/model/session.php';

startPage("Annonce ton JDR - Chercher une partie", ["searchParty.css"], ["site/searchParty.js", "site/party.js"]);
$user = Session::unserializeConnectedUser();
?>
    <div id="formRecherche"></div>
    <div id="reponseRecherche"></div>
<?php
endPage();
?>