<?php
include_once 'app/model/Utilisateur.php';
include_once 'app/model/session.php';
session_start();
?>
    <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
    <script>window.jQuery || document.write('<script src="/js/vendor/jquery-1.12.0.min.js"><\/script>')</script>
    <script src="/web/js/site/header.js"></script>

<?php if (!isset($_SESSION['session'])) { ?>
    <div id="menuConnexion">
        <div class="formulaireConnexion">
            <label for="idConnection">Identifiant</label><input type="text" name="identifiantConnexion"
                                                                id="idConnection"><br>
            <label for="pwdConnection">Mot de passe</label><input type="password" name="motDePasseConnexion"
                                                                  id="pwdConnection"><br>
            <button id="connectionButton">Se connecter</button>
            <a id="forgottenPswd" href="">Mot de passe oublié ?</a>
            <a id="signUp" href="">S'inscrire</a>
        </div>
    </div>

<?php } else { ?>

    <p>Vous etes connectés : <?php
        echo unserialize($_SESSION['session'])->getUtilisateur()->getPseudo(); ?>
        <button id="deconnectionButton">Déconnexion</button>
    </p>


<?php }
