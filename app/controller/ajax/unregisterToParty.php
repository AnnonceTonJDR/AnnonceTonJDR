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
if (isset($_SESSION['session'])) {
    $user = Session::unserializeConnectedUser();
    $party = Parties::getPartyFromId($_POST['id']);

    if ($user->getId() == $party->getIdOwner()) {
        $flag = -2;
    } else {
        if (Parties::isRegisteredOn($user->getId(), $party->getId())) {
            if ($party->getMaxPlayer() > $party->getNbPlayerAlreadyIn()) {
                Parties::unregisterToParty($user->getId(), $party->getId());
                $flag = true;
            } else {
                $flag = -2;
            }
        } else {
            $flag = -1;
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