<?php
require_once 'utils/start_end_page.php';
startPage("Annonce Ton JDR - Oubli de mot de passe", [], ["site/forgottenPwd.js"]);
?>
    <div id="askingReset" class="panel panel-danger">
        <h3>Quel est votre adresse mail ?</h3>
        <div>
            <div>
                Un mail vous sera envoyé avec un code pour changer votre mot de passe.
            </div>
            <div id="idError"></div>
            <div style="margin-top: 5px;">
                <label for="id"> Votre adresse mail : </label>
                <input type="text" name="id" id="id">
            </div>
        </div>
        <div>
            <button id="sendCodeButton" type="button">Envoyez moi le code</button>
            <button id="hasCodeAlreadyButton" type="button">J'ai déjà le code</button>
        </div>
    </div>
    <div id="askingMail" style="display: none">
        <p>Veuillez indiquer votre mail (cela a pour but de vérifier votre identité)</p>
        <label for="mail">Votre adresse mail : </label>
        <input type="text" name="mail" id="mail">
        <button id="validateMail" type="button">Valider</button>
    </div>
    <div id="enterCode" style="display: none;">
        <div>
            <strong>Saisissez votre code de réinitialisation</strong>
        </div>
        <div>
            <label for="codeReinit">Code de réinitialisation : </label>
            <input type="text" id="codeReinit">
        </div>
        <div>
            <button id="btnCode" type="button">Réinitialiser</button>
        </div>
    </div>
    <div id="reset" style="display: none;">
        <div>
            <strong>Veuillez saisir votre nouveau mot de passe<br></strong>
        </div>
        <div>
            <div id="pwdError" style="display: none;">
                <ul>
                </ul>
            </div>
            <label for="pwdReset">Votre nouveau mot de passe : </label>
            <input type="password" id="pwdReset">
            <label for="pwdConfirm">Confirmer votre nouveau mot de passe : </label>
            <input type="password" id="pwdConfirm">
        </div>
        <div>
            <button id="validateNewPwd" type="button">Réinitialiser</button>
        </div>
    </div>
    <div id="succesPassword" style="display:none;">
        Votre mot de passe à été réinitialisé avec succès.
    </div>
<?php
endPage();
?>