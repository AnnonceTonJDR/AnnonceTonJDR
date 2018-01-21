<?php
/**
 * Script ajax pour savoir si l'utilisateur est connecté
 *
 * @author Lucas OMS
 */
session_start();
require_once '../../model/Users.php';
require_once '../../model/session.php';
$returnValue = false;

/************************************************************************
 *Si une session est initialisée c'est qu'un utilisateur est connecté et on récupère son id    *
 *************************************************************************/
if (isset($_SESSION['session'])) {
    $id = Session::unserializeConnectedUser()->getId();
    $returnValue = true;
}

/**************************************
 *On renvoie le drapeau et l'id de l'utilisateur        *
 ***************************************/
$obj = new stdClass();
$obj->ok = $returnValue;
$obj->id = $id;

header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');
echo json_encode($obj);
