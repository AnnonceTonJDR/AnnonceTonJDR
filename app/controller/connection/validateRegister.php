<?php
/**
 * Script ajax pour valider son inscription via le mail
 *
 * @author Lucas OMS
 */
session_start();
require_once '../../model/Utilisateur.php';
require_once '../../model/session.php';

$drapeau = false;
$messageRetour = "Erreur inconnue";
$pseudo = $_GET['log'];
$cle = $_GET['cle'];

/****************************************************************
 *Si la clé n'est pas renseigné dans l'URL on ne peut valider l'inscription            *
 *On en informe donc l'utilisateur qui doit réouvrir le lien depuis sa boite mail    *
 *****************************************************************/
if (!isset($_GET['cle']))
    $messageRetour = "Essayer de ré-ouvrir le lien depuis votre boite mail";

/******************************************
 *On essaie de récupérer le compte lié au pseudo    *
 *Si on y arrive pas c'est que le compte n'existe pas        *
 *******************************************/
$utilisateurs = new Utilisateurs();
$user = $utilisateurs->getByPseudo($pseudo);
if (!isset($user))
    $messageRetour = "Ce compte n'existe pas";

/************************************************************
 *Si l'état de l'utilisateur vaut 0 c'est que son compte n'était pas activé    *
 *On l'active donc et si on y arrive on charge en session son compte                *
 *Sinon c'est que son compte a déjà été activé on l'en informe                    *
 *************************************************************/

else if ($user->getEtat() == 0) {
    $retour = $user->validerInscription($pseudo, $cle);
    if ($retour) {
        $drapeau = true;
        $messageRetour = "Votre compte a été activé";
        $_SESSION['session'] = serialize(new Session($user));
    }
} else {
    $messageRetour = "Votre compte a déjà été activé";
}

/******************************************************
 *Renvoie en JSON du drapeau et des messages en conséquences    *
 *******************************************************/

$obj = new stdClass();
$obj->ok = $drapeau;
$obj->erreur = $messageRetour;

header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');
echo json_encode($obj);

?>
