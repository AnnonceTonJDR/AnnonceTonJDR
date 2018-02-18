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
} // Chercher partie
else if (isset($_GET["p"]) && $_GET["p"] === "s") {
    include_once 'app/controller/searchParty.php';
} // Profil l'utilisateur
else if (isset($_GET["p"]) && $_GET["p"] === "user") {
    include_once 'app/controller/userProfile.php';
} // Validation de mail
else if (isset($_GET["p"]) && $_GET["p"] === "validateMail") {
    include_once 'app/controller/connection/validateRegister.php';
} //Connexion
else if (isset($_GET["p"]) && $_GET["p"] === "signin") {
    include_once 'app/controller/connection.php';
} // Index
else {
    include_once 'app/controller/index.php';
}