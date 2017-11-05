<?php
/**
 * Script ajax pour reset le MDP
 * @see sendResetPwdCode.php
 *
 * @author Lucas OMS
 */
session_start();
include_once '../../model/Utilisateur.php';
include_once '../../controller/Utils.php';
$utilisateurs = new Utilisateurs();
$user = $utilisateurs->getByIdentifiantConnexion($_GET['log']);

$drapeau = false;

/**************************************************************************************
 *On fait les même vérifications sur le mot de passe que pour l'inscription avant de faire le changement        *
 ***************************************************************************************/
if (isset($_GET['mdp']) && isset($_GET['confirm']) && isset($_GET['code']) && isset($_GET['identifiant'])) {  //si tous les champs obligatoire ont été renseignés
    $drapeau = true;  //pour l'instant on peut modifier le mot de passe

    //En premier lieu, on vérifie son code
    $utilisateurs = new Utilisateurs();
    $user = $utilisateurs->getByMail($_GET['identifiant']);

    if (!isset($user)) {
        $erreur = 'Mail inexistant!';
        $drapeau = false;
    } else if ($user->getEtat() == 0) {
        $erreur = 'Votre compte n\'a pas été activé !';
        $drapeau = false;
    } /**********************************************************************************
     *Si tout est ok on vérifie que le code existe en BD
     ***********************************************************************************/
    else {
        $req = BD_lecture::connexionBDD_lecture()->query("DELETE FROM RecupMDP WHERE dateDemande < ADDDATE(NOW(), INTERVAL -1 DAY); SELECT * FROM RecupMDP WHERE idUtilisateur=" . $user->getId() . " AND code='" . $_GET['code'] . "'");
        $res = $req->fetch();
        $drapeau = is_bool($res);
        $erreur = "Aucune demande d'oubli de mot de passe recensée pour ce compte";
    }

    if ($drapeau) {
        if ($_GET['mdp'] != $_GET['confirm']) {
            $AErreurInscription[] = 'Les mot de passes ne coresspondent pas';
            $drapeau = false;
        }
        if (!Utils::isValidePwd($_GET['mdp'])) {
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
                //SI tout s'est bien passé, on supprime le code de la BD
                BD::connexionBDD()->exec("DELETE FROM RecupMDP WHERE idUtilisateur=" . $user->getId());
            } else {
                $AErreurInscription[] = 'Votre mot de passe n\'a pas été modifié dans la base de données';
                $drapeau = false;
            }
        }
    } else {
        $AErreurInscription[] = "Votre code de réinitialisation n'existe pas";
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
