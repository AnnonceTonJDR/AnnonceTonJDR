<?php
if (!isset($_SESSION['session'])) {
    include_once 'app/views/index.php';
} else
    include_once 'app/views/createParty.php';
