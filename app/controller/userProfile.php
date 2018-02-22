<?php
/**
 * Controlleur de la page d'affichage d'un profil
 *
 * @author Lucas OMS
 * @version 1
 */

//IF everything ok :
if (isset($_SESSION['session']))
    include_once 'app/views/user.php';
else
    include_once 'app/views/connection.php';