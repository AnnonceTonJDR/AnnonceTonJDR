<?php

include_once('constant.php');

try {
    $bdd = new PDO('mysql:host='.HOST.';dbname='.DBNAME.';charset=utf8', USER, PASS);
}
catch (PDOException $e) {
    die('Connect Failed: ' . $e->getMessage());
}


$req = $bdd->query('SELECT * FROM OneShot_Test');

while($response = $req->fetch())
{
    echo('<pre>');
    echo($response['userName']);
    echo('</pre>');
}

$req->closeCursor();
