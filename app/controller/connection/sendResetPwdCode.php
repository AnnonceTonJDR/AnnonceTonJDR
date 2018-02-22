<?php
/**
 * Script ajax pour l'oubli de mot de passe
 *
 * @author Lucas OMS
 */
session_start();
include_once '../../model/Users.php';
include_once '../../model/session.php';

/**************************************************************
 *Si l'utilisateur est connecté pas besoin de changement de mot de passe        *
 ***************************************************************/
$flag = false;
$rand = "";
if (isset($_SESSION['session']))
    $error = 'Vous êtes connecté, vous ne pouvez donc pas réinitialiser votre mot de passe';

/************************************************************************************************
 *Si un identifiant est renseigné on essaie de récupèrer l'utilisateur et on vérifie que son compte ai bien été activé        *
 *************************************************************************************************/
if (isset($_GET['id'])) {
    $user = Users::getByMail($_GET['id']);

    if (!isset($user)) {
        $error = 'Pseudo ou mail inexistant!';
    } else if ($user->getState() == 0) {
        $error = 'Votre compte n\'a pas été activé !';
    } /**********************************************************************************
     *Si tout est ok on envoie un mail à l'utilisateuravec un code généré aléatoirement à récupérer        *
     ***********************************************************************************/
    else {
        $mailTo = $user->getMail();
        $subject = "Réinitialisation de votre mot de passe sur Annonce Ton JDR";
        $header = "From: motDePasse@annoncetonjdr.fr";
        $rand = md5(microtime());
        //Ajout en BD du code
        DB::connectionDB()->exec("DELETE FROM RecupMDP WHERE dateDemande < ADDDATE(NOW(), INTERVAL -1 DAY) OR idUtilisateur=" . $user->getId()
            . "; INSERT INTO RecupMDP(code, idUtilisateur) VALUES ('$rand', " . $user->getId() . ")");

        // Le lien d'activation est composé du pseudo(log) et de la clé(cle)
        $msg = 'Bonjour,
                        Vous avez demandé la réinitialisation de votre mot de passe,
                        Pour finaliser la réinitialisation, veuillez saisir ce code de réinitialisation dans le champs demandé.
                                    
                        ' . $rand . '            
                                    
                        ---------------
                        Ceci est un mail automatique, merci de ne pas y répondre.';

        mail($mailTo, $subject, $msg, $header); // Envoi du mail
        $flag = true;
    }
}

/****************************************************************************************
 *On renvoie si la procédure c'est bien passée, le code que l'utilisateur devra valider, ou les messages d'erreur    *
 *****************************************************************************************/
$obj = new stdClass();
$obj->ok = $flag;
$obj->message = $error;

////////////Sorties des variables en JSON
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');
echo json_encode($obj);
