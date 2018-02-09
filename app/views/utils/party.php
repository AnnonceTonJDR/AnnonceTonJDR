<?php
include_once 'app/model/Parties.php';
function displayParty(Party $party)
{
    if ($party != null) {
        ?>
        <div id="party<?php echo $party->getId(); ?>" class="party">
            <div class="headerParty" onclick="details(<?php echo $party->getId(); ?>);">   <!-- table -->
                <div class="infos">     <!-- table row -->
                    <div style="display: table-cell;">
                        <p>Nom du jeu</p>
                    </div>
                    <div style="display: table-cell;">
                        <p>Nom du scénario</p>
                    </div>
                    <div style="display: table-cell;">
                        <p>Date</p>
                    </div>
                    <div style="display: table-cell;">
                        <p>Nombre de joueur</p>
                    </div>
                </div>
                <div class="details">                   <!-- table row -->
                    <div style="display: table-cell;">
                        <p><?php echo $party->getGameName(); ?></p>
                    </div>
                    <div style="display: table-cell;">
                        <p><?php echo $party->getScenarioName(); ?></p>
                    </div>
                    <div style="display: table-cell;">
                        <p><?php echo $party->getDate(); ?></p>
                    </div>
                    <div style="display: table-cell;">
                        <p><?php echo $party->getNbPlayerAlreadyIn(); ?>/<?php echo $party->getMaxPlayer(); ?></p>
                    </div>
                </div>
            </div>
            <div class="partyDetails" style="display: none">
                <div style="display: table; width: 100%;">
                    <div style="display: table-row">
                        <div class="label" style="display: table-cell">
                            <p>Adresse : </p>
                        </div>
                        <div class="info" style="display: table-cell">
                            <p><?php echo $party->getAddress(); ?></p>
                        </div>
                        <div class="label" style="display: table-cell">
                            <p>Limite d'âge :</p>
                        </div>
                        <div class="info" style="display: table-cell">
                            <p>De <?php echo $party->getAgeMin(); ?> à <?php echo $party->getAgeMax(); ?></p>
                        </div>
                    </div>
                    <div style="display: table-row">
                        <div class="label" style="display: table-cell">
                            <p>Lieu : </p>
                        </div>
                        <div class="info" style="display: table-cell">
                            <p><?php echo $party->getPlace(); ?></p>
                        </div>
                        <div class="label" style="display: table-cell">
                            <p>Possibilité de fumer :</p>
                        </div>
                        <div class="info" style="display: table-cell">
                            <p><?php echo $party->getSmoker() == 1 ? "Oui" : "Non"; ?></p>
                        </div>
                    </div>
                    <div style="display: table-row">

                        <div class="label" style="display: table-cell">
                            <p>Boisson et nourriture : </p>
                        </div>
                        <div class="info" style="display: table-cell">
                            <p><?php echo $party->getFoodBeverage() < 2 ? $party->getFoodBeverage() == 1 ? "Comme vous le souhaitez" : "Interdit" : "Merci d'amener"; ?></p>
                        </div>
                        <div class="label" style="display: table-cell">
                            <p>Alcool :</p>
                        </div>
                        <div class="info" style="display: table-cell">
                            <p><?php echo $party->getAlcohol() < 2 ? $party->getAlcohol() == 1 ? "Autorisé" : "Prohibé" : "Exigé"; ?></p>
                        </div>
                    </div>
                    <div style="display: table-row">
                        <div class="label" style="display: table-cell">
                            <p>Provenance jeu : </p>
                        </div>
                        <div class="info" style="display: table-cell">
                            <p><?php echo $party->getGameEdition(); ?></p>
                        </div>
                        <div class="label" style="display: table-cell">
                            <p>Provenance scénario : </p>
                        </div>
                        <div class="info" style="display: table-cell">
                            <p><?php echo $party->getScenarioEdition(); ?></p>
                        </div>
                    </div>
                </div> <!-- table -->
                <div class="label">
                    <p style="text-align: left !important;">Description : </p>
                </div>
                <div class="info">
                    <p><?php
                        echo $party->getComment();
                        ?></p>
                </div>
                <button class="contact" onclick="messageTo(<?php echo $party->getIdOwner() ?>)">Contacter le créateur
                </button>
            </div>
        </div>

        <?php
    }
}