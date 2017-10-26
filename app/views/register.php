<!doctype html>
<html class="no-js" lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Annonce ton JDR - Inscription</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="/web/css/normalize.css">
    <link rel="stylesheet" href="/web/css/register.css">
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
        <div id="erreur" style="display: none;">
            Votre inscription n'a pue être réalisée, voici les erreurs:
        </div>
        <div style="margin-top: 20px">
            <div id="inputPrenom">
                <label for="prenom">Prénom : <strong style="color: red">*</strong></label>
                <input type="text" name="prenom" id="prenom" required="">
            </div>
            <div id="inputNom">
                <label for="nom">Nom : <strong style="color: red">*</strong></label>
                <input type="text" name="nom" id="nom" required="">
            </div>
            <div id="inputPseudo">
                <label for="pseudo">Pseudo : <strong style="color: red">*</strong></label>
                <input type="text" name="pseudo" id="pseudo" required="">
                <p class="condition">Le pseudo doit être unique et faire au minimum 4 caractères</p>
                <!-- doit être unique taille min de 4 char-->
            </div>
            <div id="inputMail">
                <label for="mail">Mail : <strong style="color: red">*</strong></label>
                <input type="text" name="mail" id="mail" required="">
                <p class="condition">Vous ne pouvez associer qu'un unique compte par adresse mail</p>
            </div>
            <div id="inputPassword">
                <label for="motDePasse">Mot de passe : <strong style="color: red">*</strong> </label>
                <input type="password" name="motDePasse" id="motDePasse" required="">
                <p>Le mot de passe doit faire une taille minimale de 8 charactères</p>
                <!-- comporter une majuscule, une minuscule, et un caractère spécial -->
                <!-- doit contenir une majuscule, un caractère spécial, 8 caractère minimum, un chiffre -->
            </div>
            <div id="inputPasswordConfirm">
                <label for="motDePasseConfirmation">Confirmer le mot de passe : <strong
                            style="color: red">*</strong></label>
                <input type="password" name="motDePasseConfirmation" id="motDePasseConfirmation" required="">
                <!-- doit être le même -->
            </div>
            <p>Les champs suivis d'une <strong style="color: red">*</strong> sont obligatoires.</p>
            <button id="boutonValider">Valider</button>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
<script>window.jQuery || document.write('<script src="/js/vendor/jquery-1.12.0.min.js"><\/script>')</script>
<script src="/web/js/site/register.js"></script>
</body>
</html>
