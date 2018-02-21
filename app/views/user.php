<?php
require_once 'utils/start_end_page.php';
require_once 'utils/party.php';
require_once 'app/model/Parties.php';
startPage("Annonce ton JDR", [], ["site/party.js"]);
$user = Session::unserializeConnectedUser();
?>
    <h1><?php echo $user->getPseudo(); ?></h1>
    <div>
        <h2>Vos parties</h2>
        <?php
        $user = isset($_SESSION['session']) ? Session::unserializeConnectedUser() : null;
        foreach (Parties::getPartyFromIdOwner($user->getId()) as $party)
            displayParty($party, true, $user);
        ?>
    </div>
    <div>
        <h2>Vos inscriptions</h2>
        <?php foreach (Parties::getPartyFromIdRegistered($user->getId()) as $party)
            displayParty($party, true, $user);
        ?>
    </div>

<?php
endPage();
?>