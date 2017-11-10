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
$drapeau = false;
$mail = false;
$pseudo = false;
$password = false;
$passwordConfirm = false;

if (isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['pseudo']) && isset($_POST['dateNaissance']) && isset($_POST['mail']) && isset($_POST['motDePasse']) && isset($_POST['motDePasseConfirmation'])) {  //si tous les champs obligatoire ont été renseignés
    $drapeau = true;  //pourl'instant on peut ajouter l'utilisateur
    $utilisateurs = new Utilisateurs();

    /****************************************************
     *Vérifications des différentes infos saisies dans le formulaire        *
     *****************************************************/
    if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
        $AErreurInscription[] = 'Le format de l\'adresse mail est invalide';
        $mail = false;
        $drapeau = false;
    } else
        $mail = true;

    $date = date_parse_from_format("Y/m/d", $_POST['dateNaissance']);
    if (checkdate($date['month'], $date['day'], $date['year']) && $date['year'] > 1900) {
        $dateNaissance = true;
    } else {
        $AErreurInscription[] = 'La date est invalide';
        $dateNaissance = false;
        $drapeau = false;
    }

    if (strlen($_POST['pseudo']) < 4) {
        $AErreurInscription[] = 'Le pseudo doit faire au minimum 4 charactères';
        $pseudo = false;
        $drapeau = false;
    } else
        $pseudo = true;

    if ($utilisateurs->pseudoExisteDeja($_POST['pseudo'])) {
        $AErreurInscription[] = 'Le pseudo que vous voulez utiliser existe déjà';
        $pseudo = false;
        $drapeau = false;
    } else
        $pseudo = true;

    if ($utilisateurs->mailExisteDeja($_POST['mail'])) {
        $AErreurInscription[] = 'Le mail que vous voulez utiliser est déjà associé à un compte';
        $mail = false;
        $drapeau = false;
    } else
        $mail = true;

    if ($_POST['motDePasse'] != $_POST['motDePasseConfirmation']) {
        $AErreurInscription[] = 'Les mot de passes ne coresspondent pas';
        $drapeau = false;
        $passwordConfirm = false;
    } else
        $passwordConfirm = true;

    if (!Utils::isValidePwd($_POST['motDePasse'])) {
        $AErreurInscription[] = 'Le mot de passe ne remplis pas les conditions nécéssaires';
        $password = false;
        $drapeau = false;
    } else
        $password = true;

    if ($drapeau) {
        $utilisateurs->inscrireUtilisateur($_POST['pseudo'], $_POST['mail'], $_POST['motDePasse'], $_POST['nom'], $_POST['prenom'], $_POST['dateNaissance']);
    }
} else
    $AErreurInscription[] = 'Vous n\'avez pas renseigné tous les champs requis';

/****************************************************************************************
 *On envoie en JSON quels ont pue être les champs invalides et les erreurs en conséquences ou le drapeau        *
 *****************************************************************************************/
$obj = new stdClass();
$obj->ok = $drapeau;
$obj->mail = $mail;
$obj->pseudo = $pseudo;
$obj->dateNaissance = $dateNaissance;
$obj->messageErreur = Array();
if (count($AErreurInscription) > 0)
    foreach ($AErreurInscription as $erreur) {
        array_push($obj->messageErreur, $erreur);
    }

//////////////// CALCUL DE TOUTES LES VARIABLES

////////////Sorties des variables en JSON
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');
echo json_encode($obj);
