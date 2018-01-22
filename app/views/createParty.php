<?php
require_once 'utils/start_end_page.php';
require_once 'app/model/Parties.php';
require_once 'app/model/Users.php';
require_once 'app/model/session.php';

startPage("Annonce ton JDR - Créer une partie", ["createParty.css"], ["site/createParty.js"]);
$user = Session::unserializeConnectedUser();
?>
    <p id="addressText"><label for="adresse">J'organiserais mon jeu de rôle en ce lieu : </label><input type="text"
                                                                                                        id="adresse"/>.
    </p>
    <p><input type="checkbox" id="isVirtual"/><label for="isVirtual">Cette partie se déroulera sur le net.</label></p>
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
    <p><label for="nomJeu">Ma partie se jouerait dans l'univers de </label><input type="text" maxlength="255"
                                                                                  id="nomJeu"/> qui
        est un jeu
        <!-- Choix de l'édition jeu -->
        <?php echo Parties::comboBoxWithChoicesFor("EditionJeu") ?>
        .
    </p>
    <!--endregion-->

    <!--region nom et edition scénario et description-->
    <p><label for="nomScenario">Le scénario s'intitulerait "</label><input type="text" maxlength="255"
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

    <!--TODO addresse-->
    <!-- html -->
    <div class="mdl-textfield mdl-js-textfield mdl-cell">
        <input type="text" class="mdl-textfield__input control" id="place-input" placeholder="Où habitez vous">
    </div>
    <!-- javascript-->
<!--    la library javascript avec notre apiKey-->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDtnql0_LAPbI6QU8GTnlShmyJ7QQMSL1Q&libraries=places"></script>
<!--    initialisation du field-->
    <script defer='defer' type='text/javascript'>
        var input = document.getElementById('place-input');

        autocomplete = new google.maps.places.Autocomplete(input);
    </script>
   <!--
    MMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMM
    MMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMWWWWNWWWWWNWMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMM
    MMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMWWNX0kkkkxxkOkkkk0KXXKXNMMMMMMMMMMMMMMMMMMMMMMMMM
    MMMMMMMMMMMMMMMMMMMMMMMMMMWWWNXX0Okxoc:ccllldolooooocok0KXXNWMMMMMMMMMMMMMMMMMMM
    MMMMMMMMMMMMMMMMMMMMMMMWNXKKKKK00OOOOxddxdoodollcc::cloollodOKNMMMMMMMMMMMMMMMMM
    MMMMMMMMMMMMMMMMMMMMWNXXK0000KK0O0OOOOOkxkkxdollloooxkxxdddxkxkKNWMMMMMMMMMMMMMM
    MMMMMMMMMMMMMMMMMMWNXK00OOO0KKKK0KKOkxxkkxxdooolodxdxkOOkkkkOOkxO0XNWMMMMMMMMMMM
    MMMMMMMMMMMMMMMMWNKOxooodxxxxkKKKXK0000OOOkkkxxxkkkxxxkOkxxxxxddxxxxONMMMMMMMMMM
    MMMMMMMMMMMMMWWNX0o;cdOKNNNX0dd0XXKKXXXKKK000OO00000OO0OkxddoooddddddOKWMMMMMMMM
    MMMMMMMMMMMMNK0KOc..,;cdxkkdllcdKXXXNNNNNNNNXXKK00XKKK0Okdodxolc::loxxx0NMMMMMMM
    MMMMMMMMMMWX0O0x,.      ...  .,oKXXNNNNNWWWWWNNNXXNXXX0OddOXWX0xc,':oodx0NMMMMMM
    MMMMMMMMWNKkk0Oc'.           .,xKXNNNNNNWWWWWNNNNNNNNK0dclolc;'.....;cclxKWMMMMM
    MMMMMMMNKOxxkKk;..           .oOKXNNWNNWWNWWWNNWWNNNXK0o;.           .;:okXWMMMM
    MMMMMMN0kddx0Kkc'.  .    ...,o00KXNNNNWNNNWWWNNWNNNNXKOl,.           ..;cokKWMMM
    MMMMMNOkxxkkOKKx:'........;ok00KXXNNNNNNNNWNNNNNNNNXXX0o,.           ..;:clokXWM
    MMMMN0kxkxxxk0KKko:;,;:ldk0KKKKXNNNNNNNNNNNNWWNNNNNNXK0kl,.          .';:clllxKW
    MMWXOkxxxdxxxxkO00OOOO0KXXNNNNWWWWWNXXNNNNWWWWWWNNXXXK00ko;...     ..',::::cllok
    MWXkdddddxxxdxkkkkkOOOKXNWWWWWWWWWNKkxk0XXNWWNX0OOKKKKK00kdc;'......,::::::;::cl
    MNOdddxxxxdloddddxO0KXNWWWWWWWWWWWWNNX00KXNNXKOkxk00KKKK0Okdolc;;;:cc:;;;;;:;:::
    WKdcclol:;;cllldk0XNNNWNWWWWWWWWWWNNXXXXXXKKKXXXXXXXXXXKK0Okdoolc::;,;:::;,,;:c:
    WOc:cll:;;::cox0KXNNNNNNNNNNNNNNNNX0kdlcc::clok0KKXNXKK000OOxdlc;,,,';cc::;,,;::
    Xkolllooolldk0KXXXNNNNNNNNNNNNNX0dllldxxdxxdolllok0KKK0OOkkkxdlc;,'''.,;;,,;,,::
    dodoodoolok0KXXXXXXXXXNNNNXXXX0xllx0KXKKK00000Oxocok00Okkkkxdool;......',;;;;;;:
    :cooolcloxOKXXXXXXXXXXXXXXKK0xdx0XXKKK0000OOkkkkkdclk0Okxxxxdllcc;.....',,,;:::c
    ;:cccllodOKXXXXXXXXKKKKKKK0OxdOXXXXXXXXKKKK000000Oxodkkxdooolllooo;.........';;:
    ;;;;codoxOKKKXXXXXXKK0000Okxk0XXXXXXXXXKKKKKKKKK000xlldddooollodxdo,..........',
    :;::cloodkO0KKKKKK000OOkkkkOKKKKKKXXXXKKKKKKKXKKK0Okdloxxdlllloddxxd:...........
    c:cccooooxO0000000OOOkkxxkO0000KKKKKKKK00KK0KKKK0Okkxoldxooollooooxxo:,.....'.''
    lcc::cloodkO0000OOkkxddooxkO0000000000O0000OO000Okxxdlldxxxdllooooddol;,''''....
    clc;,;;:loxxxkkkxddooooodkOO0OOOOOOOOOOOOOOkkkOkkxdolccdkkxdoodddooolc;,''''....
    cc:;;,;:odddodddxddxkkkkOO00OOOOOOOOOOOOOkkxddddddoc:::ldxddxxddollllc;,........
    :::::::coodoooxkkkOO000KKKK000000000OOOkkkxdoooooolcclllloddxxddlccc:;,'........
    :cc::ccldddddxO000KKKKKXXXXKKKXXKKK0000OOOkxxxddxxxxddooooloooolc;;::,,''.......
    ;:::clldddxkOO00KKKKXXXNNNXXXXXXKKKK0000000OOOkkOOOOkxdooolllll:,',;;;,'''......
    -->


    <!--region A amener/possibilité de fumer -->
    <p><label for="typeLieu">Nous jouerions</label>
        <?php echo Parties::comboBoxWithChoicesFor("TypeLieu") ?>.
        <label for="nourritureBoisson">Les joueurs sont priés </label>

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

    <p id="signature"><?php echo $user->getPseudo() ?></p>
<?php
endPage();
?>