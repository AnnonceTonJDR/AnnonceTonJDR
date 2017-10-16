<?php

class Services
{
    /**
     * cryptage du password
     *
     * @param string $password
     * @return string
     */
    public static function hashPass(string $password) :string
    {
        return hash(sha256 ,PREFIX_SALT.$password.SUFFIX_SALT);
    }

    /**
     * verification email
     *
     * @param string $mail
     * @return bool
     */
    public static function checkMail(string $mail) :bool
    {
        return filter_var($mail, FILTER_VALIDATE_EMAIL);
    }

    /**
     * log un user
     *
     * @param string $login
     * @param string $password
     * @return bool
     */
    public static function login(string $login, string $password) :bool
    {
        $this->hashPass($password);

        /* 
        /!\ TODO /!\ 
        faire la requete qui match login / hash mdp
        */

        return true;
    }

    /**
     * inscrire un user
     *
     * @param string $login
     * @param string $password
     * @return void
     */
    public static function register(string $login, string $password)
    {
        $this->hashPass($password);

        /* 
        /!\ TODO /!\ 
        faire la requete qui écrit login / hash mdp
        */
    }

    /**
     * connection via cookie
     *
     * @param string $lastConnect
     * @param string $hash
     * @return void
     */
    public static function connectCookie( string $lastConnect, string $hash)
    {

        // TODO faire la connectiuon via cookie
    }

    /**
     * crée le cookie
     *
     * @param string $password
     * @return void
     */
    public static function makeCookie( string $password)
    {
        $date = date_create('now');

        setcookie("last-connect", date_format($date, 'd-m-Y H:i:s'));
        setcookie("last-hash", $this->hashPass($password));
    }

    /**
     * réinitialisation du mots de passe
     *
     * @param string $mail
     * @return void
     */
    public static function resetPassword( string $mail)
    {
        // TODO faire la requete qui verifie l'adresse email

        // TODO verifier que une requete na pas déjà été faite.

        // TODO écrire dans la bdd la date de péremption du lien.

        // TODO faire l'envoi de mail.
    }
}
