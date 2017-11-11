<?php
/**
 * Script ajax pour l'oubli de mot de passe
 *
 * @author Lucas OMS
 */
session_start();
include_once '../../model/Utilisateur.php';
include_once '../../model/session.php';

/**************************************************************
 *Si l'utilisateur est connecté pas besoin de changement de mot de passe        *
 ***************************************************************/
$flag = false;
$rand = "";
if (isset($_SESSION['session']))
    $error = 'Vous êtes connecté vous ne pouvez donc pas réinitialiser votre mot de passe';

/************************************************************************************************
 *Si un id est renseigné on essaie de récupèrer l'utilisateur et on vérifie que son compte ai bien été activé        *
 *************************************************************************************************/
if (isset($_GET['id']) && isset($_GET['code'])) {
    $users = new Utilisateurs();
    $user = $users->getByMail($_GET['id']);

    if (!isset($user)) {
        $error = 'Mail inexistant!';
    } else if ($user->getEtat() == 0) {
        $error = 'Votre compte n\'a pas été activé !';
    } /**********************************************************************************
     *Si tout est ok on vérifie que le code existe en BD
     ***********************************************************************************/
    else {
        $req = DB::connectionDB()->query("DELETE FROM RecupMDP WHERE dateDemande < ADDDATE(NOW(), INTERVAL -1 DAY); SELECT * FROM RecupMDP WHERE idUtilisateur=" . $user->getId() . " AND code='" . $_GET['code'] . "'");
        $res = $req->fetch();
        $flag = is_bool($res);
        $error = "Aucune demande d'oubli de mot de passe recensée pour ce compte";
    }
}

/****************************************************************************************
 *On renvoie si la procédure c'est bien passée, le code que l'utilisateur devra valider, ou les messages d'erreur    *
 *****************************************************************************************/
$obj = new stdClass();
$obj->ok = $flag;
$obj->msg = $error;

////////////Sorties des variables en JSON
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');
echo json_encode($obj);
