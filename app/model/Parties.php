<?php
/**
 * Created by PhpStorm.
 * User: Lucas OMS
 * Date: 12/01/2018
 * Time: 16:38
 */

include_once "DB.php";
include_once "DB_readOnly.php";

class Parties
{
    static function createParty($idOwner, $minAge, $maxAge, $maxPlayer, $gameName, $gameEdition, $scenarioName, $scenarioEdition, $address, $area, $place, $foodBeverage, $alcohol, $smokerFree, $forumTitle, $comment, $date, $isOpenedCampain, $playersAlreadyIn)
    {
        $req = DB::connectionDB()->prepare("INSERT INTO Annonce VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $req->execute(array($idOwner,
            $minAge,
            $maxAge,
            $maxPlayer,
            $gameName,
            $gameEdition,
            $scenarioName,
            $scenarioEdition,
            $address,
            $area,
            $place,
            $foodBeverage,
            $alcohol,
            $smokerFree,
            $forumTitle,
            $comment,
            $date,
            $isOpenedCampain,
            $playersAlreadyIn));
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

    private $idOwner;
    private $ageMin;
    private $ageMax;
    private $maxPlayer;
    private $gameName;
    private $gameEdition;
    private $scenarioName;
    private $scenarioEdition;
    private $address;
    private $area;
    private $place;
    private $foodBeverage;
    private $alcohol;
    private $smoker;
    private $forumTitle;
    private $comment;
    private $date;
    private $isOpenedCampain;
    private $nbPlayerAlreadyIn;

    /**
     * Party constructor.
     */
    public function __construct($idOwner, $ageMin, $ageMax, $maxPlayer, $gameName, $gameEdition, $scenarioName, $scenarioEdition, $address, $area, $place, $foodBeverage, $alcohol, $smoker, $forumTitle, $comment, $date, $isOpenedCampain, $nbPlayerAlreadyIn)
    {
        $this->idOwner = $idOwner;
        $this->ageMin = $ageMin;
        $this->ageMax = $ageMax;
        $this->maxPlayer = $maxPlayer;
        $this->gameName = $gameName;
        $this->gameEdition = $gameEdition;
        $this->scenarioName = $scenarioName;
        $this->scenarioEdition = $scenarioEdition;
        $this->address = $address;
        $this->area = $area;
        $this->place = $place;
        $this->foodBeverage = $foodBeverage;
        $this->alcohol = $alcohol;
        $this->smoker = $smoker;
        $this->forumTitle = $forumTitle;
        $this->comment = $comment;
        $this->date = $date;
        $this->isOpenedCampain = $isOpenedCampain;
        $this->nbPlayerAlreadyIn = $nbPlayerAlreadyIn;
    }

    public function getIdOwner()
    {
        return $this->idOwner;
    }

    public function getAgeMin()
    {
        return $this->ageMin;
    }

    public function getAgeMax()
    {
        return $this->ageMax;
    }

    public function getMaxPlayer()
    {
        return $this->maxPlayer;
    }

    public function getGameName()
    {
        return $this->gameName;
    }

    public function getGameEdition()
    {
        return $this->gameEdition;
    }

    public function getScenarioName()
    {
        return $this->scenarioName;
    }

    public function getScenarioEdition()
    {
        return $this->scenarioEdition;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function getArea()
    {
        return $this->area;
    }

    public function getPlace()
    {
        return $this->place;
    }

    public function getFoodBeverage()
    {
        return $this->foodBeverage;
    }

    public function getAlcohol()
    {
        return $this->alcohol;
    }

    public function getSmoker()
    {
        return $this->smoker;
    }

    public function getForumTitle()
    {
        return $this->forumTitle;
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function getDate()
    {
        return $this->date;
    }


    public function getisOpenedCampain()
    {
        return $this->isOpenedCampain;
    }

    public function getNbPlayerAlreadyIn()
    {
        return $this->nbPlayerAlreadyIn;
    }


}