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
    <link rel="stylesheet" href="/web/css/forgottenPwd.css">
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
        <div id="askingReset" class="panel panel-danger">
            <div>
                <strong>Quel est votre mail ?</strong>
            </div>
            <div>
                <div>
                    Un mail vous sera envoyé avec un code pour changer votre mot de passe.
                </div>
                <div id="erreurIdentifiant"></div>
                <label for="id"> Votre mail : </label>
                <input type="text" name="id" id="id">
            </div>
            <div>
                <button id="sendCodeButton" type="button">Envoyez moi le code</button>
                <button id="hasCodeAlreadyButton" type="button">J'ai déjà le code</button>
            </div>
        </div>
        <div id="askingMail" class="invisible">
            <p>Veuillez indiquez votre mail (cela a pour but de vérifier votre identité)</p>
            <label for="mail">Votre mail : </label>
            <input type="text" name="mail" id="mail">
            <button id="validateMail" type="button">Valider</button>
        </div>
        <div id="enterCode" style="display: none;">
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
        <div id="reset" style="display: none;">
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
                <button id="validateNewPwd" type="button">Réinitialiser</button>
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
