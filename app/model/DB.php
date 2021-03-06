<?php

/**
 * Permet la connection à la base de données en écriture, et via un singleton
 *
 * @author Lucas OMS
 *
 */
class DB
{
    private static $bdd = null;

    /**
     * @var string user
     */
    private static $user = 'lucasoms_atjdr';

    /**
     * @var string password
     */
    private static $pass = 'lucasoms_aTJDR';


    /**********************************************
     *Constrcuteur privé pour ne pas pouvoir être appelé        *
     *Constrution de l'objet PDO pour se connecter à la BD    *
     *On affecte l'objet construit à la classe                            *
     ***********************************************/
    private function __construct()
    {
        $pdo = null;
        try {
            $pdo = new PDO("mysql:host=mysql-lucasoms.alwaysdata.net;dbname=lucasoms_annoncetonjdr;charset=utf8", DB::$user, DB::$pass);
            if (isset($pdo))
                self::$bdd = $pdo;
        } catch (Exception $e) {
            die();       //vérifier qu'on s'est bien connecté à la base
        }

    }

    /**************************************************************
     *Fonction statique pour récupèrer l'unique connection à la base de donnée    *
     ***************************************************************/
    public static function connectionDB() : PDO
    {
        if (self::$bdd == null) {
            new DB();
        }
        return self::$bdd;
    }
}
