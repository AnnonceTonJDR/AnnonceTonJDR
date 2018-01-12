<?php
/**
 * Created by PhpStorm.
 * User: Lucas OMS
 * Date: 12/01/2018
 * Time: 16:38
 */

include_once "DB_readOnly.php";

class Parties
{
    static function createParty($idOwner, $minAge, $maxAge, $maxPlayer, $gameName, $gameEdition, $scenarioName, $scenarioEdition, $address, $area, $place, $foodBeverage, $alcohol, $smokerFree, $forumTitle, $comment, $date, $isOpenedCampain, $playersAlreadyIn)
    {

    }

    public static function isValidGameEdition($edition): bool
    {
        $req = DB_readOnly::connectionDB_readOnly()->query("SELECT * FROM EditionJeu")->fetchAll();
        foreach ($req as $ed) {
            if ($ed['type'] == $edition)
                return true;
        }
        return false;
    }

    public static function isValidScenarioEdition($edition): bool
    {
        $req = DB_readOnly::connectionDB_readOnly()->query("SELECT * FROM EditionScenario")->fetchAll();
        foreach ($req as $ed) {
            if ($ed['type'] == $edition)
                return true;
        }
        return false;
    }

    public static function doesAreaExist($idZone): bool
    {
        //TODO vérif l'id en BD
        return true;
    }

    public static function isAreaAccurateEnough($idZone): bool
    {
        //TODO Check level of the area from the root of the tree
        return true;
    }

    public static function isValidPlace($lieu): bool
    {
        $req = DB_readOnly::connectionDB_readOnly()->query("SELECT * FROM TypeLieu")->fetchAll();
        foreach ($req as $place) {
            if ($place['type'] == $lieu)
                return true;
        }
        return true;
    }
}

class Party
{

}