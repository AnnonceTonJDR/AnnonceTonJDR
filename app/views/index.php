<?php
session_start();
?>
<!doctype html>
<html class="no-js" lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Annonce ton JDR</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/png" href="/image/logo.png"/>

    <link rel="stylesheet" href="/web/css/normalize.css">
    <link rel="stylesheet" type="text/css" href="/web/css/common.css">
    <link rel="stylesheet" type="text/css" href="/web/css/fonts.css">
    <link rel="stylesheet" type="text/css" href="/web/css/index.css">
    <link rel="stylesheet" type="text/css" href="/web/css/mobile.css">
    <script src="/web/js/vendor/modernizr-2.8.3.min.js"></script>
</head>
<body>
<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a
        href="http://browsehappy.com/">upgrade
    your browser</a> to improve your experience.</p>
<![endif]-->

<!-- Add your site or application content here -->
<div id="wrapper">
    <div id="contenu">
        <?php include_once 'app/views/utils/header.php'; ?>
        <div class="leftBorder"></div>
        <div class="rightBorder"></div>
        <div class="js_close_connectionInterface"><br>
            <br>
            <h1> Annonce ton JDR </h1>
            <br>
            <br>
            <h2> Recherche de partie </h2>
            <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat
                non proident, sunt in culpa qui officia deserunt mollit anim id est
                laborum.</p>
            <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat
                non proident, sunt in culpa qui officia deserunt mollit anim id est
                laborum.</p>
            <p>Je suis la page d'index</p>
        </div>
        <?php include_once 'app/views/utils/endScroll.php'; ?>
    </div>
    <?php include_once 'app/views/utils/footer.php'; ?>
</div>

<script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
<script>window.jQuery || document.write('<script src="/js/vendor/jquery-1.12.0.min.js"><\/script>')</script>
</body>
</html>
