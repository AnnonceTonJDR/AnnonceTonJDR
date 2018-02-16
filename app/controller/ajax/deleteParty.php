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

//region Tags for client to know what is wrong
$flag = false;
//endregion

if (!isset($_SESSION['session'])) {
    //Throw error
    $flag = -2;
} else {
    $party = Parties::getPartyFromId($_POST['idParty']);
    if (!isset($_POST['idParty']) || $party) {
        $flag = -3;
        $user = Session::unserializeConnectedUser();
        if ($party->getIdOwner() == $user->getId()) {
            $flag = true;
            Parties::deleteParty($party->getId());
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