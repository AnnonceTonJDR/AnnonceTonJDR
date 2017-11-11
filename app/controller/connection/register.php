<?php
/**
 * Script ajax pour s'inscrire via le formulaire d'inscription
 *
 * @author Lucas OMS
 */
session_start();
include_once '../../model/Utilisateur.php';
include_once '../../controller/Utils.php';

/************************************************
 *On considère au départ que aucune action n'est valide        *
 *************************************************/
$flag = false;
$mail = false;
$pseudo = false;
$pwd = false;
$pwdConfirm = false;

if (isset($_POST['lastName']) && isset($_POST['firstName']) && isset($_POST['pseudo']) && isset($_POST['birth']) && isset($_POST['mail']) && isset($_POST['pwd']) && isset($_POST['pwdConfirm'])) {  //si tous les champs obligatoire ont été renseignés
    $flag = true;  //pourl'instant on peut ajouter l'utilisateur
    $users = new Utilisateurs();

    /****************************************************
     *Vérifications des différentes infos saisies dans le formulaire        *
     *****************************************************/
    if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
        $AInscriptionsError[] = 'Le format de l\'adresse mail est invalide';
        $mail = false;
        $flag = false;
    } else
        $mail = true;

    $date = date_parse_from_format("Y/m/d", $_POST['birth']);
    if (checkdate($date['month'], $date['day'], $date['year']) && $date['year'] > 1900) {
        $birth = true;
    } else {
        $AInscriptionsError[] = 'La date est invalide';
        $birth = false;
        $flag = false;
    }

    if (strlen($_POST['pseudo']) < 4) {
        $AInscriptionsError[] = 'Le pseudo doit faire au minimum 4 charactères';
        $pseudo = false;
        $flag = false;
    } else
        $pseudo = true;

    if ($users->pseudoExisteDeja($_POST['pseudo'])) {
        $AInscriptionsError[] = 'Le pseudo que vous voulez utiliser existe déjà';
        $pseudo = false;
        $flag = false;
    } else
        $pseudo = true;

    if ($users->mailExisteDeja($_POST['mail'])) {
        $AInscriptionsError[] = 'Le mail que vous voulez utiliser est déjà associé à un compte';
        $mail = false;
        $flag = false;
    } else
        $mail = true;

    if ($_POST['motDePasse'] != $_POST['pwdConfirmation']) {
        $AInscriptionsError[] = 'Les mot de passes ne coresspondent pas';
        $flag = false;
        $pwdConfirm = false;
    } else
        $pwdConfirm = true;

    if (!Utils::isValidPwd($_POST['pwd'])) {
        $AInscriptionsError[] = 'Le mot de passe ne remplis pas les conditions nécéssaires';
        $pwd = false;
        $flag = false;
    } else
        $pwd = true;

    if ($flag) {
        $users->inscrireUtilisateur($_POST['pseudo'], $_POST['mail'], $_POST['pwd'], $_POST['lastName'], $_POST['firstName'], $_POST['birth']);
    }
} else
    $AInscriptionsError[] = 'Vous n\'avez pas renseigné tous les champs requis';

/****************************************************************************************
 *On envoie en JSON quels ont pue être les champs invalides et les erreurs en conséquences ou le drapeau        *
 *****************************************************************************************/
$obj = new stdClass();
$obj->ok = $flag;
$obj->mail = $mail;
$obj->pseudo = $pseudo;
$obj->birth = $birth;
$obj->msgError = Array();
if (count($AInscriptionsError) > 0)
    foreach ($AInscriptionsError as $erreur) {
        array_push($obj->messageErreur, $erreur);
    }

//////////////// CALCUL DE TOUTES LES VARIABLES

////////////Sorties des variables en JSON
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');
echo json_encode($obj);
