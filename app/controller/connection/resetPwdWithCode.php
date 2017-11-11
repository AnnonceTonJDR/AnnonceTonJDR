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

$flag = false;

/**************************************************************************************
 *On fait les même vérifications sur le mot de passe que pour l'inscription avant de faire le changement        *
 ***************************************************************************************/
if (isset($_GET['pwd']) && isset($_GET['confirm']) && isset($_GET['code']) && isset($_GET['id'])) {  //si tous les champs obligatoire ont été renseignés
    $flag = true;  //pour l'instant on peut modifier le mot de passe

    //En premier lieu, on vérifie son code
    $users = new Utilisateurs();
    $user = $users->getByMail($_GET['id']);

    if (!isset($user)) {
        $error = 'Mail inexistant!';
        $flag = false;
    } else if ($user->getEtat() == 0) {
        $error = 'Votre compte n\'a pas été activé !';
        $flag = false;
    } /**********************************************************************************
     *Si tout est ok on vérifie que le code existe en BD
     ***********************************************************************************/
    else {
        $req = BD::connexionBDD()->query("DELETE FROM RecupMDP WHERE dateDemande < ADDDATE(NOW(), INTERVAL -1 DAY); SELECT * FROM RecupMDP WHERE idUtilisateur=" . $user->getId() . " AND code='" . $_GET['code'] . "'");
        $res = $req->fetch();
        $flag = is_bool($res);
        $error = "Aucune demande d'oubli de mot de passe recensée pour ce compte";
    }

    if ($flag) {
        if ($_GET['pwd'] != $_GET['confirm']) {
            $AInscriptionError[] = 'Les mot de passes ne coresspondent pas';
            $flag = false;
        }
        if (!Utils::isValidePwd($_GET['pwd'])) {
            $AInscriptionError[] = 'Le mot de passe ne remplis pas les conditions nécéssaires';
            $flag = false;
        }

        /**********************************************************************
         *Si tout est ok on essaie de changer le mot de passe si échec on en avertit l'utilisateur    *
         ***********************************************************************/
        if ($flag) {
            $AInscriptionError = array();
            if ($user->changerMotDePasse($_GET['confirm'])) {
                $flag = true;
                //SI tout s'est bien passé, on supprime le code de la BD
                BD::connexionBDD()->exec("DELETE FROM RecupMDP WHERE idUtilisateur=" . $user->getId());
            } else {
                $AInscriptionError[] = 'Votre mot de passe n\'a pas été modifié dans la base de données';
                $flag = false;
            }
        }
    } else {
        $AInscriptionError[] = "Votre code de réinitialisation n'existe pas";
    }

} else {
    $AInscriptionError[] = 'Vous n\'avez pas renseigné les champs de mot de passe';
    $flag = false;
}

/****************************************************************************************
 *On envoie si le changement a bien été effectué ou non et les erreurs qui peuvent être la cause de l'échec    *
 *****************************************************************************************/
$obj = new stdClass();
$obj->ok = $flag;
$obj->message = Array();
if (count($AInscriptionError) > 0)
    foreach ($AInscriptionError as $error) {
        array_push($obj->message, $error);
    }

////////////Sorties des variables en JSON
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');
echo json_encode($obj);
