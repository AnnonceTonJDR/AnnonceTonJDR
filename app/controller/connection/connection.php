<?php
/**
 * Script ajax pour se connecter
 *
 * @author Lucas OMS
 */

include '../../model/Utilisateur.php';
include '../../model/session.php';
session_start();

/************************************************************************
 *Si les champs ont été renseignés on cherche à récupérer l'utilisateur correspondant        *
 *************************************************************************/
if (isset($_POST['id']) && isset($_POST['motDePasse'])) {
    $utilisateurs = new Utilisateurs();
    $utilisateur = $utilisateurs->getByIdentifiantConnexion($_POST['id']);

    /**********************************************************************
     *Lorsqu'on a l'utilisateur on vérifie que son compte a bien été activé                            *
     *Si tel est le cas on vérifie son mot de passe et si tout est ok on initialise la session        *
     ***********************************************************************/

    if (isset($utilisateur)) {
        if ($utilisateur->getEtat() == 0) {
            $messageConexion = 'Votre compte n\'a pas été activé !';
        } else {
            if ($utilisateur->verifierMotDePasse($_POST['motDePasse'])) {
                $_SESSION['session'] = serialize(new Session($utilisateur));
                $drapeau = 1;
            } else {
                $drapeau = -1;
                $messageConexion = 'Votre mot de passe est invalide';
            }
        }
    } else {
        $drapeau = -2;
        $messageConexion = 'Vos identifiants sont invalides';
    }
}

/********************************************************************
 *Renvoie en JSON des éventuels message d'erreur et du drapeau ainsi que le nom    *
 *********************************************************************/

$obj = new stdClass();
$obj->ok = $drapeau;
$obj->message = $messageConexion;
$obj->nomUser = (isset($utilisateur) ? $utilisateur->getNom() : "Utilisateur introuvable");

////////////Sorties des variables en JSON
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');
echo json_encode($obj);
?>
