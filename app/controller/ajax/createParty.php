<?php
/**
 * @author Lucas OMS
 *
 */

session_start();
include_once '../../model/Users.php';
include_once '../../model/Parties.php';
include_once '../../model/session.php';
include_once '../../controller/Utils.php';

//region Tags for client to know what is wrong
$age = false;
$maxPlayer = false;

$gameName = false;
$gameEdition = false;

$scenarioName = false;
$scenarioEdition = false;

$address = false;

$place = false;

$foodBeverage = false;

$alcohol = false;

$smoker = false;

$forumTitle = false;

$comment = false;

$date = false;

$isOpenedCampain = false;

$nbPlayerAlreadyIn = false;

$creationErrors = [];
//endregion

if (!isset($_SESSION['session'])) {
    //Throw error
    $creationErrors[] = "Vous devez être connecté pour créer une partie";
} else {
    /************************************************
     *On considère au départ que aucune action n'est valide        *
     *************************************************/
    $flag = true;//While flag is true, the party still can be created
    $user = Session::unserializeConnectedUser();

    if (!isset($_POST['ageMin']) || !isset($_POST['ageMax'])) {
        $creationErrors[] = "L'âge maximum et l'âge minimum doivent être spécifiés";
        $flag = false;
    } else {
        if ($_POST['ageMin'] < 7 || $_POST['ageMax'] > 123 || $_POST['ageMax'] < $_POST['ageMin']) {
            $creationErrors[] = "L'âge maximum et l'âge minimum doivent être entre 7 et 123, l'âge maximum doit être au moins égal à l'âge minimum";
            $flag = false;
        } else
            $age = true;
    }

    if (!isset($_POST['joueurMax'])) {
        $creationErrors[] = "Le nombre maximum de joueurs doit être spécifié";
        $flag = false;
    } else {
        if ($_POST['joueurMax'] > 99) {
            $creationErrors[] = "Vous ne pouvez pas avoir plus de 99 joueurs, soyez raisonnable !";
            $flag = false;
        } else
            $maxPlayer = true;
    }

    //region Test game name and edition
    if (!isset($_POST['nomJeu'])) {
        $creationErrors[] = "Le nom du jeu doit être spécifié";
        $flag = false;
    } else {
        if (strlen($_POST['nomJeu']) > 255) {
            $creationErrors[] = "Le nom du jeu ne peut pas excéder 255 caractères";
            $flag = false;
        } else
            $gameName = true;

    }

    if (!isset($_POST['edition'])) {
        $creationErrors[] = "L'édition du jeu doit être spécifié";
        $flag = false;
    } else {
        if (!Parties::isValidGameEdition($_POST['edition'])) {
            $creationErrors[] = "L'édition du jeu doit être l'un des choix possibles";
            $flag = false;
        } else
            $gameEdition = true;

    }

    //endregion

    //region Test scenario name and edition
    if (!isset($_POST['nomScenario'])) {
        $creationErrors[] = "Le nom du scénario doit être spécifié";
        $flag = false;
    } else {
        if (strlen($_POST['nomScenario']) > 255) {
            $creationErrors[] = "Le nom du scénario ne peut pas excéder 255 caractères";
            $flag = false;
        } else
            $scenarioName = true;

    }

    if (!isset($_POST['editionScenario'])) {
        $creationErrors[] = "La provenance du scénario doit être spécifié";
        $flag = false;
    } else {
        if (!Parties::isValidScenarioEdition($_POST['editionScenario'])) {
            $creationErrors[] = "La provenance du scénario doit être l'un des choix possibles";
            $flag = false;
        } else
            $scenarioEdition = true;

    }

    //endregion

    if (!isset($_POST['adresse'])) {
        $address = true;
    } else {
        $location = Utils::adressToCoordinates($_POST["adresse"]);
        if (strlen($_POST['adresse']) > 255) {
            $creationErrors[] = "L'adresse ne peut exceder 255 caractères";
            $flag = false;
        } else if (!$location["lon"] && !$location["lat"] && $_POST["adresse"] !== 'Internet') {
            $creationErrors[] = "L'adresse saisie doit être reconnue parmis les choix proposés";
            $flag = false;
        } else
            $address = true;
    }


    if (!isset($_POST['lieu'])) {
        $creationErrors[] = "Le lieu doit être spécifié";
        $flag = false;
    } else {
        if (!Parties::isValidPlace($_POST['lieu'])) {
            $creationErrors[] = "Le lieu doit être l'un des choix proposés";
            $flag = false;
        } else
            $place = true;

    }

    //region Test sur nourritures, boissons et fumeurs
    if (!isset($_POST['nourritureBoisson'])) {
        $creationErrors[] = "L'apport de nourriture et de boisson doit être spécifié";
        $flag = false;
    } else {
        if ($_POST['nourritureBoisson'] < 0 || $_POST['nourritureBoisson'] > 2) {
            $creationErrors[] = "Le choix sur l'apport de nourriture et de boisson doit être parmi les choix proposés";
            $flag = false;
        } else
            $foodBeverage = true;
    }

    if (!isset($_POST['alcool'])) {
        $creationErrors[] = "L'apport d'alcool doit être spécifié";
        $flag = false;
    } else {
        if ($_POST['alcool'] < 0 || $_POST['alcool'] > 2) {
            $creationErrors[] = "Le choix sur l'apport d'alcool doit être parmi les choix proposés";
            $flag = false;
        } else
            $alcohol = true;
    }


    if (!isset($_POST['fumer'])) {
        $creationErrors[] = "Vous devez spécifier si vous acceptez les fumeurs en intérieur";
        $flag = false;
    } else {
        if ($_POST['fumer'] < 0 || $_POST['fumer'] > 2) {
            $creationErrors[] = "L'acceptation des fumeurs en intérieur doit être parmi les choix possibles";
            $flag = false;
        } else
            $smoker = true;
    }

    //endregion


    if (!isset($_POST['titreForum'])) {
        $forumTitle = true;
    } else {
        if (strlen($_POST['titreForum']) > 255) {
            $creationErrors[] = "Le titre du forum ne doit pas dépasser 255 caractères";
            $flag = false;
        } else
            $forumTitle = true;

    }

    if (!isset($_POST['commentaire'])) {
        $creationErrors[] = "Vous devez décrire le scénario de manière à donner envie aux joueurs";
        $flag = false;
    } else {
        if (strlen($_POST['commentaire']) > 1024 || strlen($_POST['commentaire']) < 50) {
            $creationErrors[] = "La description du scénario doit dépasser 50 caractères et ne pas en dépasser 1000";
            $flag = false;
        } else
            $comment = true;
    }

    if (!isset($_POST['date']) || !isset($_POST['heure']) || !isset($_POST['minute'])) {
        $creationErrors[] = "La date et l'heure doivent être spécifiées";
        $flag = false;
    } else {
        //TODO vérifier que la date est bien future à aujourd'hui
//        if ($_POST['date']) {
//            $CreationErrors[] = "";
//            $flag = false;
//        } else
        $date = true;
    }

    if (!isset($_POST['faitPartieCampagneOuverte'])) {
        $creationErrors[] = "Le fait que le scénario fasse partie d'une campagne ouverte doit être spécifié";
        $flag = false;
    } else {
        if (0 < $_POST['faitPartieCampagneOuverte'] && $_POST['faitPartieCampagneOuverte'] > 1) {
            $creationErrors[] = "Vous devez choisir parmi les réponses possibles si le scénario fait partie d'une campagne";
            $flag = false;
        } else
            $isOpenedCampain = true;
    }

    if (!isset($_POST['nbJoueurDejaInscrits'])) {
        $creationErrors[] = "Le nombre de joueur(s) déjà inscrit(s) doit être spécifié";
        $flag = false;
    } else {
        if ($_POST['nbJoueurDejaInscrits'] > $_POST['joueurMax']) {
            $creationErrors[] = "Le nombre de joueur(s) inscrit(s) ne peux pas dépasser le nombre de joueur maximum et le nombre maximum doit être valide";
            $flag = false;
        } else
            $nbPlayerAlreadyIn = true;
    }

    if ($flag) {
        //FIXME Ligne inutile ?
        $location = Utils::adressToCoordinates($_POST["adresse"]);
        Parties::createParty($user->getId(),
            $_POST['ageMin'],
            $_POST['ageMax'],
            $_POST['joueurMax'],
            $_POST['nomJeu'],
            $_POST['edition'],
            $_POST['nomScenario'],
            $_POST['editionScenario'],
            $_POST['adresse'],
            $_POST['adresse'] === 'Internet' ? 0 : $location["lon"],
            $_POST['adresse'] === 'Internet' ? 0 : $location["lat"],
            $_POST['lieu'],
            $_POST['nourritureBoisson'],
            $_POST['alcool'],
            $_POST['fumer'],
            $_POST['titreForum'],
            $_POST['commentaire'],
            $_POST['date'],
            $_POST['heure'],
            $_POST['minute'],
            $_POST['faitPartieCampagneOuverte'],
            $_POST['nbJoueurDejaInscrits']);
    }

}

/****************************************************************************************
 *On envoie en JSON quels ont pue être les champs invalides et les erreurs en conséquences ou le drapeau        *
 *****************************************************************************************/

$obj = new stdClass();
$obj->ok = $flag;
//Return flags
if (isset($_SESSION['session'])) {
    $obj->age = $age;
    $obj->maxPlayer = $maxPlayer;

    $obj->gameName = $gameName;
    $obj->gameEdition = $gameEdition;

    $obj->scenarioName = $scenarioName;
    $obj->scenarioEdition = $scenarioEdition;

    $obj->address = $address;

    $obj->place = $place;

    $obj->foodBeverage = $foodBeverage;

    $obj->alcohol = $alcohol;

    $obj->smoker = $smoker;

    $obj->forumTitle = $forumTitle;

    $obj->comment = $comment;

    $obj->date = $date;

    $obj->isOpenedCampain = $isOpenedCampain;

    $obj->nbPlayerAlreadyIn = $nbPlayerAlreadyIn;
}
$obj->msgError = Array();
//TODO CHECK CA
$obj->ok = $flag;
if (count($creationErrors) > 0)
    foreach ($creationErrors as $erreur) {
        array_push($obj->msgError, $erreur);
    }

////////////Sorties des variables en JSON
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');
echo json_encode($obj);