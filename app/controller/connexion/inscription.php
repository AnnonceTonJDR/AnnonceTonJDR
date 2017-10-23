<?php
/**
 * Script ajax pour s'inscrire via le formulaire d'inscription
 *
 * @author Lucas OMS
 */
session_start();
include_once '../../model/Utilisateur.php';

/************************************************
 *On considère au départ que aucune action n'est valide        *
 *************************************************/
$drapeau = false;
$mail = false;
$pseudo = false;
$password = false;
$passwordConfirm = false;

if (isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['pseudo']) && isset($_POST['mail']) && isset($_POST['motDePasse']) && isset($_POST['motDePasseConfirmation'])) {  //si tous les champs obligatoire ont été renseignés
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

    if (strlen($_POST['motDePasse']) < 8 || preg_match('#[A-Z]#', $_POST['motDePasse']) < 1 || preg_match('#[0-9]#', $_POST['motDePasse']) < 1 || preg_match('/[^a-zA-Z0-9]+/', $_POST['motDePasse'] < 1)) {
        $AErreurInscription[] = 'Le mot de passe ne remplis pas les conditions nécéssaires';
        $password = false;
        $drapeau = false;
    } else
        $password = true;

    if ($drapeau) {
        $utilisateurs->inscrireUtilisateur($_POST['pseudo'], $_POST['mail'], $_POST['motDePasse'], $_POST['nom'], $_POST['prenom']);
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
//$obj->motDePasse = $password;
//$obj->motDePasseConfirmation = $password;
$obj->motDePasse = $_POST['motDePasse'];
$obj->motDePasseConfirmation = $_POST['motDePasseConfirmation'];
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