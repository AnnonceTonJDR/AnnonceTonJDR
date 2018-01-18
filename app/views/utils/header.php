<?php
include_once 'app/model/Users.php';
include_once 'app/model/session.php';
session_start();
?>
    <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
    <script>window.jQuery || document.write('<script src="/js/vendor/jquery-1.12.0.min.js"><\/script>')</script>
    <script src="/web/js/site/header.js"></script>

<?php if (!isset($_SESSION['session'])) { ?>
    <header>
        <div class="leftBorderScroll"></div>
        <div class="rightBorderScroll"></div>
        <div id="openConnectionMenuButton"><p>S'identifier</p></div>
    </header>
    <div id="menuConnexion" class="invisible">
        <div class="formulaireConnexion">
            <label for="identifiantConnexion">Identifiant</label><input type="text" name="identifiantConnexion"
                                                                        id="identifiantConnexion"/><br/>
            <label for="motDePasseConnexion">Mot de passe</label><input type="password" name="motDePasseConnexion"
                                                                        id="motDePasseConnexion"/><br/>
            <button id="boutonConnexion">Se connecter</button>
            <a id="motDePasseOublie" href="/?p=fp">Mot de passe oublié ?</a>
            <a id="inscription" href="/?p=r">S'inscrire</a>
        </div>
    </div>

<?php } else { ?>
    <header>
        <div>
            <p>
                <?php echo unserialize($_SESSION['session'])->getUtilisateur()->getPseudo(); ?>
                <button id="deconnectionButton">Déconnexion</button>
            </p>
        </div>
    </header>
<?php }
