<?php

class Services
{
    /* 
    services:      cryptage du password
    version:       1.0
    arguments:     string $password
    return:        string
    */
    function hashPass(string $password) :string
    {
        return hash(sha256 ,PREFIX_SALT.$password.SUFFIX_SALT);
    }

    /* 
    services:      verification email
    version:       1.0
    arguments:     string $password
    return:        string
    */
    function checkMail(string $mail) :string
    {
        return filter_var($mail, FILTER_VALIDATE_EMAIL);
    }


    /* 
    services:      login
    version:       1.0
    arguments:     login $login
                    string $password
    return:        bool
    */
    function login(string $login, string $password) :bool
    {
        $this->hashPass($password);

        /* 
        /!\ TODO /!\ 
        faire la requete qui match login / hash mdp
        */

        return true;
    }

    /* 
    services:      register
    version:       1.0
    arguments:     login $login
                    string $password
    return:        void
    */
    function register(string $login, string $password)
    {
        $this->hashPass($password);

        /* 
        /!\ TODO /!\ 
        faire la requete qui écrit login / hash mdp
        */
    }

    /* 
    services:      connect cookie
    version:       1.0
    arguments:     $hash
                   $lastConnect
    */
    function connectCookie( string $lastConnect, string $hash)
    {

        // TODO faire la connectiuon via cookie
    }

    /* 
    services:      make cookie
    version:       1.0
    arguments:     $hash
    return:        void
    */
    function makeCookie( string $password)
    {
        $date = date_create('now');

        setcookie("last-connect", date_format($date, 'd-m-Y H:i:s'));
        setcookie("last-hash", $this->hashPass($password));
    }

    /* 
    services:      reset password
    version:       1.0
    arguments:     $mail
    return:        void
    */
    function resetPassword( string $mail)
    {
        // TODO faire la requete qui verifie l'adresse email

        // TODO verifier que une requete na pas déjà été faite.

        // TODO écrire dans la bdd la date de péremption du lien.

        // TODO faire l'envoi de mail.
    }
}
