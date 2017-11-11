<?php
/**
 * Script ajax pour se connecter
 *
 * @author Lucas OMS
 */

include '../../model/Users.php';
include '../../model/session.php';
session_start();

/************************************************************************
 *Si les champs ont été renseignés on cherche à récupérer l'utilisateur correspondant        *
 *************************************************************************/
if (isset($_POST['id']) && isset($_POST['pwd'])) {
    $users = new Users();
    $user = $users->getByConnectionId($_POST['id']);

    /**********************************************************************
     *Lorsqu'on a l'utilisateur on vérifie que son compte a bien été activé                            *
     *Si tel est le cas on vérifie son mot de passe et si tout est ok on initialise la session        *
     ***********************************************************************/

    if (isset($user)) {
        if ($user->getState() == 0) {
            $connectionMsg = 'Votre compte n\'a pas été activé !';
        } else {
            if ($user->verifyPwd($_POST['pwd'])) {
                $_SESSION['session'] = serialize(new Session($user));
                $flag = 1;
            } else {
                $flag = -1;
                $connectionMsg = 'Votre mot de passe est invalide';
            }
        }
    } else {
        $flag = -2;
        $connectionMsg = 'Vos identifiants sont invalides';
    }
}

/********************************************************************
 *Renvoie en JSON des éventuels message d'erreur et du drapeau ainsi que le nom    *
 *********************************************************************/

$obj = new stdClass();
$obj->ok = $flag;
$obj->msg = $connectionMsg;
$obj->userName = (isset($user) ? $user->getLastName() : "Utilisateur introuvable");

////////////Sorties des variables en JSON
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');
echo json_encode($obj);
?>
