<?php
require_once 'utils/start_end_page.php';
startPage("Annonce ton JDR - Inscription", ["register.css"], []);
?>
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
        <div id="inputDateNaissance">
            <label for="dateNaissance">Date de naissance : <strong style="color: red">*</strong></label>
            <input type="date" name="dateNaissance" id="dateNaissance" required="">
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
            <p class="condition">Le mot de passe doit faire une taille minimale de 8 caractères</p>
            <!-- comporter une majuscule, une minuscule, et un caractère spécial -->
            <!-- doit contenir une majuscule, un caractère spécial, 8 caractère minimum, un chiffre -->
        </div>
        <div id="inputPasswordConfirm">
            <label for="motDePasseConfirmation">Confirmer le mot de passe : <strong
                        style="color: red">*</strong></label>
            <input type="password" name="motDePasseConfirmation" id="motDePasseConfirmation" required=""
                   autocomplete="new-password">
            <!-- doit être le même -->
        </div>
        <p id="tips">Les champs suivis d'une <strong style="color: red">*</strong> sont obligatoires.</p>
        <button id="boutonValider">Valider</button>
    </div>

<?php
endPage();
?>