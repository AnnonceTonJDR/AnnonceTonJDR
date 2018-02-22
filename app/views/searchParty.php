<?php
require_once 'utils/start_end_page.php';
require_once 'app/model/Parties.php';
require_once 'app/model/Users.php';
require_once 'app/model/session.php';

startPage("Annonce Ton JDR - Chercher une partie", ["searchParty.css", "createParty.css"], ["site/searchParty.js", "site/party.js"]);
$user = isset($_SESSION['session']) ? Session::unserializeConnectedUser() : null;
?>
    <div id="formRecherche">
        <p id="addressText"><label for="place-input">Adresse : </label><input id="place-input" name="place-input"
                                                                                    type="text"/>
            <script type="text/javascript"
                    src="//maps.googleapis.com/maps/api/js?key=AIzaSyDtnql0_LAPbI6QU8GTnlShmyJ7QQMSL1Q&libraries=places"></script>
            <!--    initialisation du field-->
            <script defer='defer' type='text/javascript'>
                var input = document.getElementById('place-input');
                autocomplete = new google.maps.places.Autocomplete(input);
            </script>
            <br>
            <label for="range">Rayon de recherche : </label><input id="range" name="range" type="number"/> km
        </p>
        <p id="withNetText"><input id="withNet" name="withNet" type="checkbox"/><label for="withNet">
                Inclure les parties sur le net</label></p>
        <p id="onlyNetText" style="display: none;"><input id="onlyNet" name="onlyNet" type="checkbox"/><label
                    for="onlyNet">Ne rechercher que les parties sur le net</label></p>
        <p><label for="nomJeu">Le nom du jeu recherché contient : </label><input id="nomJeu" name="nomJeu" type="text"/></p>
        <button onclick="searchParties()">Lancer la recherche</button>
    </div>
    <div id="reponseRecherche"></div>
<?php
endPage();
?>