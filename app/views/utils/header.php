<?php
include_once 'app/model/Users.php';
include_once 'app/model/session.php';
session_start();
?>
    <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
    <script>window.jQuery || document.write('<script src="/js/vendor/jquery-1.12.0.min.js"><\/script>')</script>
    <script src="/web/js/site/header.js"></script>

<?php if (!isset($_SESSION['session'])) { ?>
    <div id="menuConnexion">
        <div class="formulaireConnexion">
          <ul>
            <li><img src="image/logo.png"></li>
            <li><label for="idConnection">Identifiant</label><input type="text" name="identifiantConnexion"
                                                                id="idConnection"></li>
            <li><label for="pwdConnection">Mot de passe</label><input type="password" name="motDePasseConnexion"
                                                                  id="pwdConnection"></li>
            <li><button id="connectionButton">Se connecter</button></li>
            <li><a id="forgottenPswd" href="//lucasoms.alwaysdata.net?page=forgottenPwd">Mot de passe oublié ?</a></li>
            <li><a id="signUp" href="//lucasoms.alwaysdata.net?page=register">S'inscrire</a></li>
        </div>
    </div>

<?php } else { ?>

    <li><p>Vous etes connectés : <?php
        echo unserialize($_SESSION['session'])->getUtilisateur()->getPseudo(); ?>
        <button id="deconnectionButton">Déconnexion</button>
    </p>

  </li>
</ul>
<?php }
