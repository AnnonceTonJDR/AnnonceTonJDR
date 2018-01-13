<?php

class Utils
{
    public static function isValidPwd(string $password): bool
    {
        //Si on veut rendre plus compliqué un jour
        //preg_match('#[A-Z]#', $_POST['motDePasse']) < 1 || preg_match('#[0-9]#', $_POST['motDePasse']) < 1 || preg_match('/[^a-zA-Z0-9]+/', $_POST['motDePasse'] < 1))
        return (strlen($password) >= 6);
    }
}