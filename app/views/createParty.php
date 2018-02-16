<?php
require_once 'utils/start_end_page.php';
require_once 'app/model/Parties.php';
require_once 'app/model/Users.php';
require_once 'app/model/session.php';

startPage("Annonce ton JDR - Créer une partie", ["createParty.css"], ["site/createParty.js"]);
$user = Session::unserializeConnectedUser();
?>
    <p id="addressText"><label for="adresse">J'organiserai mon jeu de rôle en ce lieu : </label>
        <input type="text" style="min-width: 300px;" id="place-input" title="Où habitez-vous ?" placeholder="">.
    </p>
    <!--    la library javascript avec notre apiKey-->
    <script type="text/javascript"
            src="//maps.googleapis.com/maps/api/js?key=AIzaSyDtnql0_LAPbI6QU8GTnlShmyJ7QQMSL1Q&libraries=places"></script>
    <!--    initialisation du field-->
    <script defer='defer' type='text/javascript'>
        var input = document.getElementById('place-input');
        autocomplete = new google.maps.places.Autocomplete(input);
    </script>
    <p><input type="checkbox" id="isVirtual"/><label for="isVirtual">Cette partie se déroulera sur le net.</label></p>

    <p><label for="date">Elle se déroulera le </label><input type="date" id="date">
        à <input id="heure" type="number" min="0" max="24" title="heure" placeholder="00">:<input id="minute"
                                                                                                  type="number" min="0"
                                                                                                  max="59"
                                                                                                  title="minute"
                                                                                                  placeholder="00"
                                                                                                  size="2"></p>


    <!--region nombre de joueur-->
    <p><label for="joueurMax">Via cette annonce, je cherche à recruter</label><input type="number" min="1" max="99"
                                                                                     id="joueurMax"/>
        <label for="nbJoueurDejaInscrits">joueurs, en plus des </label><input type="number" min="0" max="98"
                                                                              id="nbJoueurDejaInscrits"> joueurs déjà
        inscrits.</p>
    <!--endregion-->

    <!--region age-->
    <div id="age">
        <p><label for="ageMin">Je souhaiterais jouer avec des gens ayant de </label>
            <input type="number" min="7" max="123" id="ageMin"/>
            <label for="ageMax">à</label>
            <input type="number" min="7" max="123" id="ageMax"/> ans.</p>
    </div>
    <!--endregion-->

    <!--region nom et edition jeu-->
    <p><label for="nomJeu">Ma partie s'appuiera sur le système de jeu "</label><input type="text" maxlength="255"
                                                                                      id="nomJeu"/>" qui
        est un jeu
        <!-- Choix de l'édition jeu -->
        <?php echo Parties::comboBoxWithChoicesFor("EditionJeu") ?>
        .
    </p>
    <!--endregion-->

    <!--region nom et edition scénario et description-->
    <p><label for="nomScenario">Le scénario s'intitulera "</label><input type="text" maxlength="255"
                                                                         id="nomScenario"/>"
        scénario provenant
        <!-- Choix de l'édition jeu -->
        <?php echo Parties::comboBoxWithChoicesFor("EditionScenario") ?>.
        <label for="isOpenedCampain">Ce scénario </label>
        <select id="isOpenedCampain">
            <option value="0" selected>ne fait pas partie</option>
            <option value="1">fait partie</option>
        </select>
        d'une campagne ouverte.

        <label for="commentaire">Voici une brève description et d'autres élèments que je voudrais ajouter :</label>
        <textarea id="commentaire"></textarea>
    </p>
    <!--endregion-->

    <!--region A amener/possibilité de fumer -->
    <p><label for="typeLieu">Nous jouerons</label>
        <?php echo Parties::comboBoxWithChoicesFor("TypeLieu") ?>.
        <label for="nourritureBoisson">Les joueurs sont priés </label>

        <!--select boisson/nourricture-->
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
        <label for="fumer">, il sera</label>
        <!--select -->
        <select id="fumer">
            <option value="1" selected>possible</option>
            <option value="0">impossible</option>
        </select>
        de fumer à l'intérieur.
    </p>
    <!--endregion-->

    <p>
        <input type="checkbox" id="placebo" title=""/>
        <label for="placebo">J'ai créé un sujet sur le forum</label><label class="nameForum" style="display: none">
            &nbsp;portant le nom de </label>
        <input class="nameForum" style="display: none" type="text" maxlength="255" id="titreForum"
               title="sujet du forum associé"/></p>

    <p><br/><br/>Je certifie sur l'honneur les données ci-dessus valides<br/></p>

    <button id="sendForm" onclick="sendForm(); return false;" style="display: block; margin: auto;">Créer la partie
    </button>

    <p id="signature"><?php echo $user->getPseudo() ?></p>
<?php
endPage();
?>