<?php
/**
 * Script ajax pour se déconnecter
 *
 * @author Lucas OMS
 */
session_start();

//destruction de session de la doc officielle
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
session_destroy();
header('Location: /index.php');
exit();