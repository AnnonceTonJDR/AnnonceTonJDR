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

    <link rel="stylesheet" href="/web/css/normalize.css">
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
        <p>Je suis la page d'index</p>
        <?php include_once 'app/model/BD.php'; ?>
    </div>
</div>


<script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
<script>window.jQuery || document.write('<script src="/js/vendor/jquery-1.12.0.min.js"><\/script>')</script>
<script src="/web/js/plugins.js"></script>
</body>
</html>
