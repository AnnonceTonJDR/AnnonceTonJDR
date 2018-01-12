<?php
/**
 * @author Lucas OMS
 *
 */

session_start();
include_once '../../model/Users.php';
include_once '../../model/Parties.php';
include_once '../../controller/Utils.php';

//region Tags for client to know what is wrong
$age = false;
$maxPlayer = false;

$gameName = false;
$gameEdition = false;

$scenarioName = false;
$scenarioEdition = false;

$address = false;

$area = false;

$place = false;

$foodBeverage = false;

$alcohol = false;

$smoker = false;

$forumTitle = false;

$comment = false;

$date = false;

$isOpenedCampain = false;

$nbPlayerAlreadyIn = false;

//endregion

if (!isset($_SESSION['session'])) {
    //Throw error
    $CreationErrors[] = "Vous devez être connecté pour créer une partie";
} else {
    /************************************************
     *On considère au départ que aucune action n'est valide        *
     *************************************************/
    $flag = true;//While flag is true, the party still can be created
    $user = unserialize($_SESSION['session'])->getUtilisateur();

    if (!isset($_POST['ageMin']) || !isset($_POST['ageMax'])) {
        $CreationErrors[] = "L'age maximum et l'age minimum doivent être spécifiés";
        $flag = false;
    } else {
        if ($_POST['ageMin'] < 7 || $_POST['ageMax'] > 123 || $_POST['ageMax'] < $_POST['ageMin']) {
            $CreationErrors[] = "L'age maximum et l'age minimum doivent être entre 7 et 123, l'age maximum doit être au moins égal à l'age minimum";
            $flag = false;
        } else
            $age = true;
    }

    if (!isset($_POST['joueurMax'])) {
        $CreationErrors[] = "Le nombre maximum de joueur doit être spécifié";
        $flag = false;
    } else {
        if ($_POST['joueurMax'] > 99) {
            $CreationErrors[] = "Vous ne pouvez pas avoir plus de 99 joueurs, soyez raisonnable !";
            $flag = false;
        } else
            $maxPlayer = true;
    }

    //region Test game name and edition
    if (!isset($_POST['nomJeu'])) {
        $CreationErrors[] = "Le nom du jeu doit être spécifié";
        $flag = false;
    } else {
        if (strlen($_POST['nomJeu']) > 255) {
            $CreationErrors[] = "Le nom du jeu ne peu excéder 255 caractères";
            $flag = false;
        } else
            $gameName = true;

    }

    if (!isset($_POST['edition'])) {
        $CreationErrors[] = "L'édition du jeu doit être spécifié";
        $flag = false;
    } else {
        if (!Parties::isValidGameEdition($_POST['edition'])) {
            $CreationErrors[] = "L'édition du jeu doit être l'un des choix possibles";
            $flag = false;
        } else
            $gameEdition = true;

    }

    //endregion

    //region Test scenario name and edition
    if (!isset($_POST['nomScenario'])) {
        $CreationErrors[] = "Le nom du jeu doit être spécifié";
        $flag = false;
    } else {
        if (strlen($_POST['nomScenario']) > 255) {
            $CreationErrors[] = "Le nom du scénario ne peu excéder 255 caractères";
            $flag = false;
        } else
            $scenarioName = true;

    }

    if (!isset($_POST['editionScenario'])) {
        $CreationErrors[] = "L'édition du jeu doit être spécifié";
        $flag = false;
    } else {
        if (!Parties::isValidScenarioEdition($_POST['editionScenario'])) {
            $CreationErrors[] = "L'édition du scénario doit être l'un des choix possibles";
            $flag = false;
        } else
            $scenarioEdition = true;

    }

    //endregion

    if (!isset($_POST['adresse'])) {
        $address = true;
    } else {
        if (strlen($_POST['adresse']) > 255) {
            $CreationErrors[] = "L'adresse ne peut exceder 255 caractères";
            $flag = false;
        } else
            $address = true;
    }


    if (!isset($_POST['zone'])) {
        $CreationErrors[] = "La zone doit être spécifié";
        $flag = false;
    } else {
        if (!Parties::doesAreaExist($_POST['zone'])) {
            $flag = false;
        } else {
            if (!Parties::isAreaAccurateEnough($_POST[''])) {
                $CreationErrors[] = "Vous devez être plus précis dans lal ocalisation de la partie";
                $flag = false;
            } else
                $area = true;
        }
    }

    if (!isset($_POST['lieu'])) {
        $CreationErrors[] = "Le lieu doit être spécifié";
        $flag = false;
    } else {
        if (!Parties::isValidPlace($_POST['lieu'])) {
            $CreationErrors[] = "Le lieu doit être l'un des choix proposés";
            $flag = false;
        } else
            $place = true;

    }

    //region Test sur nourritures, boissons et fumeurs
    if (!isset($_POST['nourritureBoisson'])) {
        $CreationErrors[] = "L'apport de nourriture et de boissons doit être spécifié";
        $flag = false;
    } else {
        if ($_POST['nourritureBoisson'] >= 0 && $_POST['nourritureBoisson'] <= 2) {
            $CreationErrors[] = "Le choix sur l'apport de nourriture et de boissons doit être parmis les choix proposés";
            $flag = false;
        } else
            $foodBeverage = true;
    }

    if (!isset($_POST['alcool'])) {
        $CreationErrors[] = "L'apport d'alcool doit être spécifié";
        $flag = false;
    } else {
        if ($_POST['alcool'] >= 0 && $_POST['alcool'] <= 2) {
            $CreationErrors[] = "Le choix sur l'apport d'alcool doit être parmis les choix proposés";
            $flag = false;
        } else
            $alcohol = true;
    }


    if (!isset($_POST['fumer'])) {
        $CreationErrors[] = "Vous devez spécifier si vous acceptez les fumeurs";
        $flag = false;
    } else {
        if ($_POST['fumer']) {
            $CreationErrors[] = "L'acceptation des fumeurs doit être parmis les choix possibles";
            $flag = false;
        } else
            $smoker = true;
    }

    //endregion


    if (!isset($_POST['titreForum'])) {
        $forumTitle = true;
    } else {
        if (strlen($_POST['titreForum']) > 255) {
            $CreationErrors[] = "Le titre du forum ne doit pas dépasser 255 caractères";
            $flag = false;
        } else
            $forumTitle = true;

    }

    if (!isset($_POST['commentaire'])) {
        $CreationErrors[] = "Vous devez expliquer le scénario de manière à donner envie aux joueurs";
        $flag = false;
    } else {
        if ($_POST['commentaire'] > 1024 || $_POST['commentaire'] < 50) {
            $CreationErrors[] = "La description du scénario doit dépasser 50 caractères et ne pas dépasser 1000";
            $flag = false;
        } else
            $comment = true;
    }

    if (!isset($_POST['date'])) {
        $CreationErrors[] = "La date doit être spécifiée";
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
        $CreationErrors[] = "Le fait que le scénario fasse partie d'une campagne ouverte doit être spécifié";
        $flag = false;
    } else {
        if (0 < $_POST['faitPartieCampagneOuverte'] && $_POST['faitPartieCampagneOuverte'] > 1) {
            $CreationErrors[] = "Vous devez choisir parmi les réponses possibles si le scénario fait partie d'une campagne";
            $flag = false;
        } else
            $isOpenedCampain = true;
    }

    if (!isset($_POST['nbJoueurDejaInscrits'])) {
        $CreationErrors[] = "Le nombre de joueur(s) déjà inscrit(s) doit être spécifié";
        $flag = false;
    } else {
        if ($_POST['nbJoueurDejaInscrits'] < $_POST['joueurMax'] && $maxPlayer) {
            $CreationErrors[] = "Le nombre de joueur inscrit ne peux pas dépasser le nombre de joueur maximum et le nombre maximum doit être valide";
            $flag = false;
        } else
            $nbPlayerAlreadyIn = true;
    }

    if ($flag) {
        Parties::createParty($user->getId(),
            $_POST['ageMin'],
            $_POST['ageMax'],
            $_POST['joueurMax'],
            $_POST['nomJeu'],
            $_POST['edition'],
            $_POST['nomScenario'],
            $_POST['editionScenario'],
            $_POST['adresse'],
            $_POST['zone'],
            $_POST['lieu'],
            $_POST['nourritureBoisson'],
            $_POST['alcool'],
            $_POST['fumer'],
            $_POST['titreForum'],
            $_POST['commentaire'],
            $_POST['date'],
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

    $obj->area = $area;

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
if (count($CreationErrors) > 0)
    foreach ($CreationErrors as $erreur) {
        array_push($obj->msgError, $erreur);
    }

////////////Sorties des variables en JSON
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');
echo json_encode($obj);