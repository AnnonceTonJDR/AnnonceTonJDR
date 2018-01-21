<?php
require_once 'utils/start_end_page.php';
require_once 'app/model/Parties.php';
require_once 'app/model/Users.php';
require_once 'app/model/session.php';

startPage("Annonce ton JDR - Créer une partie", ["createParty.css"], ["site/createParty.js"]);
$user = Session::unserializeConnectedUser();
?>
    <!--region age-->
    <div id="age">
        <p><label for="ageMin">Je souhaiterais jouer avec des gens ayant de </label>
            <input type="number" min="7" max="123" id="ageMin"/>
            <label for="ageMax">à</label>
            <input type="number" min="7" max="123" id="ageMax"/> ans.</p>
    </div>
    <!--endregion-->

    <!--region nombre de joueur-->
    <p><label for="joueurMax">J'aimerai </label><input type="number" min="1" max="99" id="joueurMax"/>
        <label for="nbJoueurDejaInscrits">joueurs, en plus des </label><input type="number" min="0" max="98"
                                                                              id="nbJoueurDejaInscrits"> joueurs déjà
        inscrits</p>
    <!--endregion-->

    <!--region nom et edition jeu-->
    <p><label for="nomJeu">Pour jouer à </label><input type="text" maxlength="255" id="nomJeu"/> qui
        est un jeu
        <!-- Choix de l'édition jeu -->
        <?php echo Parties::comboBoxWithChoicesFor("editionJeu") ?>
        .
    </p>
    <!--endregion-->

    <!--region nom et edition scénario et description-->
    <p><label for="nomScenario">Pour réaliser le scénario "</label><input type="text" maxlength="255" id="nomScenario"/>"
        qui provient de
        <!-- Choix de l'édition jeu -->
        <?php echo Parties::comboBoxWithChoicesFor("editionScenario") ?>
        <label for="commentaire">et dont voilà une brève description :</label>
        <textarea id="commentaire"></textarea>
    </p>
    <!--endregion-->

    <!--TODO addresse-->

    <!--region A amener/possibilité de fumer -->
    <p><label for="typeLieu">Nous jouerions</label>
        <?php echo Parties::comboBoxWithChoicesFor("typeLieu") ?>
        <label for="nourritureBoisson">et les joueurs sont priés </label>

        <!--select boisson/nourriture-->
        <select id="nourritureBoisson">
            <option value="2">d'amener</option>
            <option value="1" selected>d'amener ou non</option>
            <option value="0">de ne pas amener</option>
        </select>
        <label for="alcool">de la nourriture ou des boissons, l'alcool étant</label>
        <!--select alcool-->
        <select id="alcool">
            <option value="1" selected>autorisé</option>
            <option value="0">prohibé</option>
            <option value="2">exigé</option>
        </select>
        <label for="fumer">et il sera</label>
        <!--select -->
        <select id="fumer">
            <option value="1" selected>possible</option>
            <option value="0">impossible</option>
        </select>
        de fumer.
    </p>
    <!--endregion-->

    <p><label for="titreForum">J'ai également créer un sujet du nom de </label>
        <input type="text" maxlength="255" id="titreForum"/> sur le forum</p>

    <p>Je certifie sur l'honneur les données ci-dessus valides</p>

    <p id="signature"><?php echo $user->getPseudo() ?></p>
<?php
endPage();
?>