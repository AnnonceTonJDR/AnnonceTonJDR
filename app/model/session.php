<?php
/**************************************
 *Créateur:        Lucas OMS                            *
 *Date:                14/04/17                                    *
 *Description:    Classe pour gérer les sessions        *
 ***************************************/

include_once 'Users.php';

class Session
{
    private $utilisateur;

    /**
     * @author Lucas OMS
     * @version
     * @param $utilisateur
     */
    public function __construct($utilisateur)
    {
        $this->utilisateur = $utilisateur;
    }

    public function getUtilisateur(): User
    {
        return $this->utilisateur;
    }
}
