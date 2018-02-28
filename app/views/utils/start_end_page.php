<?php
function startPage($title, array $supCSS, array $supJS)
{
    session_start();
    ?>
    <!doctype html>
    <html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title><?php echo $title ?></title>
        <meta name="description" content="Site d'annonces de parties de jeux de rôle autour d'une table">
        <meta name="keywords" content="JDR, jeux de rôle, jeu de rôle, annonces, annonce, jeu de role, jeux de roles, autour d'une table, table, papier">
        <meta name="publisher" content="Amir Hammoutene">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" href="/image/logoBlanc.png"/>
        <link rel="icon" href="/image/favicon.ico"/>

        <link rel="stylesheet" href="/web/css/normalize.css">
        <link rel="stylesheet" type="text/css" href="/web/css/common.css">
        <link rel="stylesheet" type="text/css" href="/web/css/fonts.css">
        <?php foreach ($supCSS as $css) { ?>
            <link rel="stylesheet" type="text/css" href="/web/css/<?php echo $css; ?>">
        <?php } ?>
        <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
        <script>window.jQuery || document.write('<script src="/web/js/vendor/jquery-1.12.0.min.js"><\/script>')</script>
        <?php foreach ($supJS as $js) { ?>
            <script src="/web/js/<?php echo $js; ?>"></script>
        <?php } ?>
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
    <?php include_once 'app/views/utils/header.php'; ?>
    <div id="contenu">
    <div class="leftBorder"></div>
    <div class="rightBorder"></div>
    <div id="startContent" class="js_close_connectionInterface"><br>
    <?php

}

function endPage()
{
    ?>
    </div>
    <?php include_once 'app/views/utils/endScroll.php'; ?>
    </div>
    <?php include_once 'app/views/utils/footer.php'; ?>
    </div>
    </body>
    </html>
    <?php
}