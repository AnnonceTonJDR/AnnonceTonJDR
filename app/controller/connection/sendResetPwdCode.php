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
$drapeau = false;
$rand = "";
if (isset($_SESSION['session']))
    $erreur = 'Vous êtes connecté vous ne pouvez donc pas réinitialiser votre mot de passe';

/************************************************************************************************
 *Si un identifiant est renseigné on essaie de récupèrer l'utilisateur et on vérifie que son compte ai bien été activé        *
 *************************************************************************************************/
if (isset($_GET['identifiant'])) {
    $utilisateurs = new Utilisateurs();
    $user = $utilisateurs->getByMail($_GET['identifiant']);

    if (!isset($user)) {
        $erreur = 'Pseudo ou mail inexistant!';
    } else if ($user->getEtat() == 0) {
        $erreur = 'Votre compte n\'a pas été activé !';
    } /**********************************************************************************
     *Si tout est ok on envoie un mail à l'utilisateuravec un code généré aléatoirement à récupérer        *
     ***********************************************************************************/
    else {
        $destinataire = $user->getMail();
        $sujet = "Réinitialisation de votre mot de passe sur le jeu de Lucas OMS";
        $entete = "From: motDePasse@annonceTonJDR.fr";
        $rand = md5(microtime());
        //Ajout en BD du code
        BD::connexionBDD()->exec("DELETE FROM RecupMDP WHERE dateDemande < ADDDATE(NOW(), INTERVAL -1 DAY) OR idUtilisateur=" . $user->getId()
            . "; INSERT INTO RecupMDP(code, idUtilisateur) VALUES ('$rand', " . $user->getId() . ")");

        // Le lien d'activation est composé du pseudo(log) et de la clé(cle)
        $message = 'Bonjour,
                        Vous avez demandé la réinitialisation de votre mot de passe,
                        Pour finaliser la réinitialisation, veuillez saisir ce code de réinitialisation dans le champs demandé.
                                    
                        ' . $rand . '            
                                    
                        ---------------
                        Ceci est un mail automatique, Merci de ne pas y répondre.';

        mail($destinataire, $sujet, $message, $entete); // Envoi du mail
        $drapeau = true;
    }
}

/****************************************************************************************
 *On renvoie si la procédure c'est bien passée, le code que l'utilisateur devra valider, ou les messages d'erreur    *
 *****************************************************************************************/
$obj = new stdClass();
$obj->ok = $drapeau;
$obj->message = $erreur;

////////////Sorties des variables en JSON
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');
echo json_encode($obj);
