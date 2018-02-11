<?php
include_once 'app/model/Users.php';
include_once 'app/model/session.php';
session_start();
?>
    <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
    <script>window.jQuery || document.write('<script src="/web/js/vendor/jquery-1.12.0.min.js"><\/script>')</script>
    <script src="/web/js/site/header.js"></script>

    <header data-connected="<?php echo isset($_SESSION['session']) ?>">
        <div class="banner" id="leftBanner">
            <ul>
                <li><a href="/?p=i">Accueil</a></li>
                <li><a href="/?p=s">Chercher une partie</a></li>
                <li><a href="/?p=c">Créer une partie</a></li>
                <li><a target="_blank" href="//www.annoncetonjdr.fr/forum/">Forum</a></li>
            </ul>
            <div class="endBanner"><img id="leftBannerArrow" src="/image/header/flecheHaut.png"></div>
        </div>
        <?php if (!isset($_SESSION['session'])) { ?>
        <div class="banner" id="rightBanner">
            <img class="avatar" src="/image/header/defaultAvatar.png">
            <a href="/?p=signin">Se connecter</a>
            <div class="endBanner"></div>
        </div>
        <div class="title"><a href="/?p=i">Annonce ton JDR</a></div>
        <!--        <div id="openConnectionMenuButton"><p>S'identifier</p></div>-->
    </header>
<?php } else { ?>

    <div class="banner" id="rightBanner">
        <a href="/?p=user"><img class="avatar" src="/image/header/defaultAvatar.png"></a>
        <a class="pseudo" href="/?p=user"><?php echo Session::unserializeConnectedUser()->getPseudo(); ?></a>
        <a id="deconnectionButton">Se déconnecter</a>
        <div class="endBanner"></div>
    </div>
    <div class="title"><a href="/?p=i">Annonce ton JDR</a></div>
    <!--        <div id="openConnectionMenuButton"><p>S'identifier</p></div>-->
    </header>
<?php }
