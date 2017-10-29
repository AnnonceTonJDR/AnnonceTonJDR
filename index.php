<?php
session_start();
/*
    Ficher de routing
*/

// Register
if (isset($_GET["page"]) && $_GET["page"] === "register") {
    include_once 'app/controller/register.php';
} // Mot de passe oublié
else if (isset($_GET["page"]) && $_GET["page"] === "forgottenPwd") {
    include_once 'app/views/forgottenPwd.php';
} // CGU
else if (isset($_GET["page"]) && $_GET["page"] === "cgu") {
    include_once 'app/views/conditionsUtilisation.php';
} // Profil l'utilisateur
else if (isset($_GET["page"]) && $_GET["page"] === "user") {
    include_once 'app/controller/user.php';
} // Index
else {
    include_once 'app/controller/index.php';
}