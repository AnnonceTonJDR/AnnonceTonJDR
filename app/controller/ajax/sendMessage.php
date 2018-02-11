<?php
/**
 * @author Lucas OMS
 *
 */

session_start();
include_once '../../model/Users.php';
include_once '../../model/Parties.php';
include_once '../../model/session.php';
include_once '../../controller/Utils.php';
$flag = false;
if (isset($_SESSION['session']) && isset($_POST['idParty']) && isset($_POST['message']) && isset($_POST['private'])) {
    $user = Session::unserializeConnectedUser();
    $party = Parties::getPartyFromId($_POST['idParty']);

    if ($user->getId() == $party->getIdOwner() && $_POST['private'] == 1) {
        $flag = -1;
    } else {
        if (strlen($_POST['message']) > 5) {
            $party->message($user->getId(), $_POST['message'], $_POST['private']);
            $flag = true;
        } else {
            $flag = -2;
        }
    }
}

/****************************************************************************************
 *On envoie en JSON quels ont pue être les champs invalides et les erreurs en conséquences ou le drapeau        *
 *****************************************************************************************/

$obj = new stdClass();
$obj->ok = $flag;

////////////Sorties des variables en JSON
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');
echo json_encode($obj);