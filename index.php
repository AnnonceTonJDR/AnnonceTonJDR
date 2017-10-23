<?php
    session_start();

    include_once("app/controller/main.php");

    /* 
        Ficher de routing
    */

    // Register
    if (isset($_GET["page"]) && $_GET["page"] === "register")
    {
        echo register();
    }
    // Login
    elseif (isset($_GET["page"]) && $_GET["page"] === "login")
    {
        echo login();
    }
    // CGU
    elseif (isset($_GET["page"]) && $_GET["page"] === "cgu")
    {
        echo cgu();
    }
    // Profil l'utilisateur
    elseif (isset($_GET["page"]) && $_GET["page"] === "user")
    {
        echo user();
    }
    // req/recherche
    elseif (isset($_GET["page"]) && $_GET["page"] === "req")
    {
        echo req();
    }
    // Index
    else
    {
        echo index();
    }