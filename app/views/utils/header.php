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
            <div style="display:table-cell; vertical-align: middle;">
                <img src="/image/logo.png" style="padding: 5px;">
            </div>
            <div style="display:table-cell; vertical-align: middle;">
                <div style="display:inline-table; text-align: right;">
                    <div style="display: table-row">
                        <div><label for="idConnection">Identifiant</label><input type="text" name="identifiantConnexion"
                                                                                 id="idConnection">
                        </div>
                    </div>
                    <div style="display: table-row">

                        <div><label for="pwdConnection">Mot de passe</label><input type="password"
                                                                                   name="motDePasseConnexion"
                                                                                   id="pwdConnection">
                        </div>
                    </div>
                </div>
            </div>
            <div style="display:table-cell; vertical-align: middle; padding: 5px;">
                <button id="connectionButton">Se connecter</button>
                <div>
                    <a id="forgottenPswd" href="//lucasoms.alwaysdata.net?page=forgottenPwd">Mot de passe oublié ?</a>
                </div>
                <div>
                    <a id="signUp" href="//lucasoms.alwaysdata.net?page=register">S'inscrire</a>
                </div>
            </div>
        </div>
    </div>

<?php } else { ?>

    <p>Vous etes connectés : <?php
        echo unserialize($_SESSION['session'])->getUtilisateur()->getPseudo(); ?>
        <button id="deconnectionButton">Déconnexion</button>
    </p>

<?php }
