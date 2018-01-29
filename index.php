<?php
session_start();
/*
    Ficher de routing
*/

// Register
if (isset($_GET["p"]) && $_GET["p"] === "r") {
    include_once 'app/controller/register.php';
} // Mot de passe oublié
else if (isset($_GET["p"]) && $_GET["p"] === "fp") {
    include_once 'app/views/forgottenPwd.php';
} // CGU
else if (isset($_GET["p"]) && $_GET["p"] === "cgu") {
    include_once 'app/views/conditionsUtilisation.php';
} // Créer partie
else if (isset($_GET["p"]) && $_GET["p"] === "c") {
    include_once 'app/controller/createParty.php';
} // Profil l'utilisateur
else if (isset($_GET["p"]) && $_GET["p"] === "user") {
    include_once 'app/controller/userProfile.php';
} // Connexion
else if (isset($_GET["p"]) && $_GET["p"] === "signin") {
    include_once 'app/controller/connection.php';
} // Index
else {
    include_once 'app/controller/index.php';
}