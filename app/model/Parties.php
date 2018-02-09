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
    static function createParty(int $idOwner,
                                int $ageMin,
                                int $ageMax,
                                int $maxPlayer,
                                string $gameName,
                                string $gameEdition,
                                string $scenarioName,
                                string $scenarioEdition,
                                string $address,
                                string $place,
                                int $foodBeverage,
                                int $alcohol,
                                int $smokerFree,
                                string $forumTitle,
                                string $comment,
                                $date,
                                bool $isOpenedCampain,
                                int $nbPlayerAlreadyIn)
    {
        $req = DB::connectionDB()->prepare("INSERT INTO Annonce VALUES(NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NULL)");
        $req->execute(
            array($idOwner,         //idUtilisateur
                null,               //Lien associée
                $maxPlayer,         //joueurMax
                $nbPlayerAlreadyIn, //playersAlreadyIn
                $ageMin,            //ageMin
                $ageMax,            //ageMax
                $gameName,          //nomJeu
                $gameEdition,       //edition
                $scenarioName,      //nomScenario
                $scenarioEdition,   //editionScenario
                $address,           //adresse
                $place,             //lieu
                $foodBeverage,      //nourritureBoisson
                $alcohol,           //alcool
                $smokerFree,        //fumer
                $forumTitle,        //titreforum
                $comment,           //commentaire
                $date,              //date
                $isOpenedCampain    //faitPartieCampagneOuverte
            ));
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
        $result = "<select id='" . strtolower($string) . "'>";
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

    public static function getLastFiveParties(): array
    {
        $req = DB_readOnly::connectionDB_readOnly()->query("SELECT idAnnonce FROM Annonce " .
            "ORDER BY idAnnonce DESC LIMIT 0,5");
        $partiesId = $req->fetchAll();
        $parties = array();
        foreach ($partiesId as $party) {
            $parties[] = self::getPartyFromId($party['idAnnonce']);
        }
        return $parties;
    }

    public static function getPartyFromId(int $id)
    {
        $req = DB_readOnly::connectionDB_readOnly()->query("SELECT * FROM Annonce " .
            "WHERE idAnnonce=" . $id);
        $party = $req->fetch();
        if ($party != null)
            return new Party(
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
        return null;
    }
}

class Party
{

    private $id;
    private $idOwner;
    private $ageMin;
    private $ageMax;
    private $maxPlayer;
    private $gameName;
    private $gameEdition;
    private $scenarioName;
    private $scenarioEdition;
    private $address;
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
    public function __construct(int $id, int $idOwner, int $ageMin, int $ageMax, int $maxPlayer, string $gameName,
                                string $gameEdition, string $scenarioName, string $scenarioEdition, string $address,
                                string $place, int $foodBeverage, int $alcohol, int $smoker,
                                string $forumTitle, string $comment, $date, bool $isOpenedCampain, int $nbPlayerAlreadyIn)
    {
        $this->id = $id;
        $this->idOwner = $idOwner;
        $this->ageMin = $ageMin;
        $this->ageMax = $ageMax;
        $this->maxPlayer = $maxPlayer;
        $this->gameName = $gameName;
        $this->gameEdition = $gameEdition;
        $this->scenarioName = $scenarioName;
        $this->scenarioEdition = $scenarioEdition;
        $this->address = $address;
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

    public function getId(): int
    {
        return $this->id;
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