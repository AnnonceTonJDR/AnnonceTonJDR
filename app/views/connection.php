<!doctype html>
<html class="no-js" lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Annonce ton JDR - Connexion</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/png" href="/image/logo.png"/>

    <link rel="stylesheet" href="/web/css/normalize.css">
    <link rel="stylesheet" type="text/css" href="/web/css/common.css">
    <link rel="stylesheet" type="text/css" href="/web/css/fonts.css">
    <link rel="stylesheet" type="text/css" href="/web/css/index.css">
    <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
    <script>window.jQuery || document.write('<script src="/web/js/vendor/jquery-1.12.0.min.js"><\/script>')</script>
    <script src="/web/js/vendor/modernizr-2.8.3.min.js"></script>
    <script src="/web/js/site/connection.js"></script>
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
    <div id="menuConnexion">
        <div class="formulaireConnexion">
            <label for="idConnection">Identifiant</label><input type="text" name="idConnection"
                                                                id="idConnection"/><br/>
            <label for="pwdConnection">Mot de passe</label><input type="password" name="pwdConnection"
                                                                  id="pwdConnection"/><br/>
            <button id="connectionButton">Se connecter</button>
            <a id="motDePasseOublie" href="/?p=fp">Mot de passe oublié ?</a>
            <a id="inscription" href="/?p=r">S'inscrire</a>
        </div>
    </div>
    <footer style="bottom: 0;">
        <div id="ligneCGU">
            <a href="/"><img src="/image/logoBlanc.png"
                             style="height: 30px; display: table-cell;"></a>
            <p> 2018 Annonce ton JDR . Tous droits réservés . <a
                        href="/?p=cgu#mentionsLegales"> Mentions
                    légales </a> - <a href="/?p=cgu#CGU"> Condition
                    d'utilisation</a> - <a
                        href="/?p=cgu#donneesPersonnelles">Politique de
                    confidentialité</a></p>
        </div>
    </footer>
</div>
</body>
</html>
