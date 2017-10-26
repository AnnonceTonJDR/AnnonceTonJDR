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
    <link rel="stylesheet" href="/web/css/motDePasseOublie.css">
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
        <div id="demandeReinitialisation" class="panel panel-danger">
            <div>
                <strong>Quel est votre identifiant ?</strong> (mail ou pseudo)
            </div>
            <div>
                <div>
                    Un mail vous sera envoyé avec un code pour changer votre mot de passe.
                </div>
                <div>
                    Le code n'est valide que pour la session de navigation courante, veuillez ne pas quitter (ou
                    recharger) la page.
                </div>
                <div id="erreurIdentifiant"></div>
                <label>Votre identifiant : </label>
                <input type="text" id="identifiant">
            </div>
            <div>
                <button id="btnDemande" type="button">Réinitialiser</button>
            </div>
        </div>
        <div id="codeReinitialisation" style="display: none;">
            <div>
                <strong>Saisissez votre code de réinitialisation</strong>
            </div>
            <div>
                <label>Code de réinitialisation : </label>
                <input type="text" id="codeReinit">
            </div>
            <div>
                <button id="btnCode" type="button">Réinitialiser</button>
            </div>
        </div>
        <div id="reinitialisation" style="display: none;">
            <div>
                <strong>Veuillez saisir votre nouveau mot de passe</strong>
            </div>
            <div>
                <div id="erreurPassword" style="display: none;">
                    <ul>
                    </ul>
                </div>
                <label>Votre nouveau mot de passe : </label>
                <input type="password" id="motDePasseReset">
                <label>Confirmer votre nouveau mot de passe : </label>
                <input type="password" id="motDePasseConfirmation">
            </div>
            <div>
                <button id="btnReinitialisation" type="button">Réinitialiser</button>
            </div>
        </div>
        <div id="succesPassword" style="display:none;">
            Votre mot de passe à été réinitialisé avec succès.
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
<script>window.jQuery || document.write('<script src="/js/vendor/jquery-1.12.0.min.js"><\/script>')</script>
<script src="/web/js/site/forgottenPwd.js"></script>
</body>
</html>
