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
    static function createParty(int $idOwner, int $ageMin, int $ageMax, int $maxPlayer, string $gameName,
                                string $gameEdition, string $scenarioName, string $scenarioEdition, string $address,
                                int $area, string $place, int $foodBeverage, int $alcohol, int $smokerFree,
                                string $forumTitle, string $comment, $date, bool $isOpenedCampain, int $nbPlayerAlreadyIn)
    {
        $req = DB::connectionDB()->prepare("INSERT INTO Annonce VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $req->execute(array($idOwner,
            $ageMin,
            $ageMax,
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
            $nbPlayerAlreadyIn));
    }

    public static function isValidGameEdition(string $edition): bool
    {
        $req = DB_readOnly::connectionDB_readOnly()->query("SELECT * FROM EditionJeu")->fetchAll();
        foreach ($req as $ed) {
            if ($ed['type'] == $edition)
                return true;
        }
        return false;
    }

    public static function isValidScenarioEdition(string $edition): bool
    {
        $req = DB_readOnly::connectionDB_readOnly()->query("SELECT * FROM EditionScenario")->fetchAll();
        foreach ($req as $ed) {
            if ($ed['type'] == $edition)
                return true;
        }
        return false;
    }

    public static function doesAreaExist(int $idZone): bool
    {
        return !is_bool(DB_readOnly::connectionDB_readOnly()
            ->query("SELECT id FROM Zone WHERE id=" . $idZone)->fetch());
    }

    public static function isAreaAccurateEnough(int $idZone): bool
    {
        //TODO Check level of the area from the root of the tree
        return true;
    }

    public static function isValidPlace(string $lieu): bool
    {
        $req = DB_readOnly::connectionDB_readOnly()->query("SELECT * FROM TypeLieu")->fetchAll();
        foreach ($req as $place) {
            if ($place['type'] == $lieu)
                return true;
        }
        return true;
    }

    public static function comboBoxWithChoicesFor(string $string): string
    {
        $result = "<select>";
        $req = DB_readOnly::connectionDB_readOnly()->query("SELECT * FROM " . $string);
        if (is_bool($req))
            return "";
        $req = $req->fetchAll();

        $first = true;
        foreach ($req as $row) {
            $result .= "<option value=\"" . $row[0] . "\" " . ($first ? "selected" : "") . " >" . $row[0] . "</option>";
            if ($first)
                $first = false;
        }
        $result .= "</select>";
        return $result;
    }
}

class Zone
{
    private $id;
    private $fatherId;
    private $name;

    public function __construct(int $id, $fatherId, string $name)
    {
        $this->id = $id;
        $this->fatherId = $fatherId;
        $this->name = $name;
    }

    public static function getSubZone($idStart): array
    {
        $result = array();
        $zones = DB_readOnly::connectionDB_readOnly()->query("SELECT * FROM Zone WHERE " .
            ($idStart != null ? "idPere = " . $idStart : "idPere IS NULL"))->fetchAll();
        foreach ($zones as $zone) {
            array_push($result, new Zone($zone['id'], $zone['idPere'], $zone['nom']));
            foreach (self::getSubZone($zone['id']) as $child) {
                $result[] = new Zone($child->getId(), $child->getFatherId(), $child->getName());
            }
        }
        return $result;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getFatherId()
    {
        return $this->fatherId;
    }

    public function getName(): string
    {
        return $this->name;
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
    public function __construct(int $idOwner, int $ageMin, int $ageMax, int $maxPlayer, string $gameName,
                                string $gameEdition, string $scenarioName, string $scenarioEdition, string $address,
                                int $area, string $place, int $foodBeverage, int $alcohol, int $smoker,
                                string $forumTitle, string $comment, $date, bool $isOpenedCampain, int $nbPlayerAlreadyIn)
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

    public function getIdOwner(): int
    {
        return $this->idOwner;
    }

    public function getAgeMin(): int
    {
        return $this->ageMin;
    }

    public function getAgeMax(): int
    {
        return $this->ageMax;
    }

    public function getMaxPlayer(): int
    {
        return $this->maxPlayer;
    }

    public function getGameName(): string
    {
        return $this->gameName;
    }

    public function getGameEdition(): string
    {
        return $this->gameEdition;
    }

    public function getScenarioName(): string
    {
        return $this->scenarioName;
    }

    public function getScenarioEdition(): string
    {
        return $this->scenarioEdition;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getArea(): int
    {
        return $this->area;
    }

    public function getPlace(): string
    {
        return $this->place;
    }

    public function getFoodBeverage(): int
    {
        return $this->foodBeverage;
    }

    public function getAlcohol(): int
    {
        return $this->alcohol;
    }

    public function getSmoker(): int
    {
        return $this->smoker;
    }

    public function getForumTitle(): string
    {
        return $this->forumTitle;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function getDate()
    {
        return $this->date;
    }


    public function getisOpenedCampain(): bool
    {
        return $this->isOpenedCampain;
    }

    public function getNbPlayerAlreadyIn(): int
    {
        return $this->nbPlayerAlreadyIn;
    }


}