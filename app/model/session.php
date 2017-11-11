<?php
/**************************************
 *Créateur:        Lucas OMS                            *
 *Date:                14/04/17                                    *
 *Description:    Classe pour gérer les sessions        *
 ***************************************/

include_once 'Utilisateur.php';

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

    public function getUtilisateur(): Utilisateur
    {
        return $this->utilisateur;
    }
}
