<?php
/**
 * Script ajax pour reset le MDP
 * @see envoyerMDPOublie.php
 *
 * @author Lucas OMS
 */
session_start();
include_once '../../model/Utilisateur.php';
$utilisateurs = new Utilisateurs();
$user = $utilisateurs->getByIdentifiantConnexion($_GET['log']);

$drapeau = false;

/**************************************************************************************
 *On fait les même vérifications sur le mot de passe que pour l'inscription avant de faire le changement        *
 ***************************************************************************************/
if (isset($_GET['mdp']) && isset($_GET['confirm'])) {  //si tous les champs obligatoire ont été renseignés
    $drapeau = true;  //pour l'instant on peut modifier le mot de passe

    if ($_GET['mdp'] != $_GET['confirm']) {
        $AErreurInscription[] = 'Les mot de passes ne coresspondent pas';
        $drapeau = false;
    }
    if (strlen($_GET['mdp']) < 8 || preg_match('#[A-Z]#', $_GET['mdp']) < 1 || preg_match('#[0-9]#', $_GET['mdp']) < 1 || preg_match('/[^a-zA-Z0-9]+/', $_GET['mdp'] < 1)) {
        $AErreurInscription[] = 'Le mot de passe ne remplis pas les conditions nécéssaires';
        $drapeau = false;
    }

    /**********************************************************************
     *Si tout est ok on essaie de changer le mot de passe si échec on en avertit l'utilisateur    *
     ***********************************************************************/
    if ($drapeau) {
        $AErreurInscription = array();
        if ($user->changerMotDePasse($_GET['confirm'])) {
            $drapeau = true;
        } else {
            $AErreurInscription[] = 'Votre mot de passe n\'a pas été modifié dans la base de données';
            $drapeau = false;
        }
    }

} else {
    $AErreurInscription[] = 'Vous n\'avez pas renseigné les champs de mot de passe';
    $drapeau = false;
}

/****************************************************************************************
 *On envoie si le changement a bien été effectué ou non et les erreurs qui peuvent être la cause de l'échec    *
 *****************************************************************************************/
$obj = new stdClass();
$obj->ok = $drapeau;
$obj->message = Array();
if (count($AErreurInscription) > 0)
    foreach ($AErreurInscription as $erreur) {
        array_push($obj->message, $erreur);
    }

////////////Sorties des variables en JSON
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');
echo json_encode($obj);
