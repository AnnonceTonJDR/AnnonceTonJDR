<?php
/**
 *  * Created by PhpStorm.
 * User: Gregoire Peltier ( idevedit@gmail.com )
 * Date: 16/02/2018
 * Time: 19:27
 *
 * This file answer to a post request with the result of a search through the Annonce database.
 * The request body should contain at least one of the following attributes :
 * "address"
 * "range" (if address)
 * "virtual" (not yet taken into account)
 * "rpg"
 * the answer will be a object containing an ok flag and a result array in which are the request results.
 */

session_start();
include_once 'app/model/Users.php';
include_once 'app/model/Parties.php';
include_once 'app/model/session.php';
include_once 'app/controller/Utils.php';
include_once 'app/views/utils/party.php';
$flag = false;

/**
 *On envoie en JSON quels ont pue être les champs invalides et les erreurs en conséquences ou le drapeau        *
 */

/**
 * query the database for a party based on the supplied parameters
 * @param $params array linked array containing the necessary keys for the query.
 */
function search_party($datas)
{

    $fields = "*";
    $where = "";
    $having = "";
    $table = "Annonce";
    $params = [];

    if (isset($datas["address"]) && $datas["address"] !== "") {
        $fields .= ", 6371 * 2 * ASIN(SQRT(POWER(SIN((:searchLat - abs(latitude)) * pi()/180 / 2),2) + COS(:searchLat * pi()/180 ) * COS(abs(latitude) *pi()/180) * POWER(SIN((:searchLon - longitude) *pi()/180 / 2), 2) )) as distance ";
        $having .= " HAVING distance < :range ";
        $location = Utils::adressToCoordinates($datas["address"]);
        $params["searchLat"] = $location["lat"];
        $params["searchLon"] = $location["lon"];
        $params["range"] = $datas["range"];
    }

    if (isset($datas["rpg"])) {
        $where .= " `nomJeu` like :rpg ";
        $params["rpg"] = "%" . $datas["rpg"] . "%";
    }

    if (isset($datas["virtual"])) {
        switch ($datas["virtual"]) {
            case "no":
                $where .= " AND  `adresse` != \"Internet\" ";
                break;
            case "yes":
                $having .= " OR `adresse` = \"Internet\" ";
                break;
            case "only":
                $where = " `adresse` = \"Internet\" ";
                break;
        }
    }

    $req = DB_readOnly::connectionDB_readOnly()->prepare("Select " . $fields . " FROM `" . $table . "` WHERE " . $where . $having . " ORDER BY date ASC");

    if ($req->execute($params)) {
        $returnedArray = array();
        foreach ($req->fetchAll() as $party) {
            $returnedArray[] = new Party(
                $party['idAnnonce'],
                $party['idUtilisateur'],
                $party['ageMin'],
                $party['ageMax'],
                $party['joueurMax'],
                $party['nomJeu'],
                $party['edition'],
                $party['nomScenario'],
                $party['editionScenario'],
                $party['adresse'],
                $party['lieu'],
                $party['nourritureBoisson'],
                $party['alcool'],
                $party['fumer'],
                $party['titreForum'],
                $party['commentaire'],
                $party['date'],
                $party['faitPartieCampagneOuverte'] == 1,
                $party['joueurDejaInscrits']
            );
        }
        return $returnedArray;
    }

    return null;
}

////////////Sorties des variables en JSON
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');
$obj = new stdClass();
$obj->ok = $flag;
$obj->result = search_party($_POST);
$obj->ok = $obj->result != null;
$obj->printing = "";
foreach ($obj->result as $party) {

    displayParty($party, false, isset($_SESSION['session']) ? Session::unserializeConnectedUser() : null);
}
