<?php
include_once 'app/model/Parties.php';
function displayParty(Party $party, bool $withMessage, $userConnected)
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
                        <p>Joueurs</p>
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
                        <p class="nbPlayer"><?php echo $party->getNbPlayerAlreadyIn(); ?>
                            /<?php echo $party->getMaxPlayer(); ?></p>
                    </div>
                </div>
            </div>
            <div class="partyDetails" style="display: none">
                <div class="notResponsive" style="display: table; width: 100%;">
                    <div style="display: table-row">
                        <div class="label" style="display: table-cell">
                            <p>Adresse : </p>
                        </div>
                        <div class="info" style="display: table-cell">
                            <p><?php echo $party->getAddress(); ?></p>
                        </div>
                        <div class="label" style="display: table-cell">
                            <p>Limites d'âge :</p>
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
                            <p>Fumer à l'intérieur :</p>
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
                            <p>Provenance du jeu : </p>
                        </div>
                        <div class="info" style="display: table-cell">
                            <p><?php echo $party->getGameEdition(); ?></p>
                        </div>
                        <div class="label" style="display: table-cell">
                            <p>Provenance du scénario : </p>
                        </div>
                        <div class="info" style="display: table-cell">
                            <p><?php echo $party->getScenarioEdition(); ?></p>
                        </div>
                    </div>
                </div> <!-- table -->
                <div class="responsive" style="display: none">

                    <div style="display: table-row">
                        <div class="label" style="display: table-cell">
                            <p>Adresse : </p>
                        </div>
                        <div class="info" style="display: table-cell">
                            <p><?php echo $party->getAddress(); ?></p>
                        </div>

                    </div>
                    <div style="display: table-row">
                        <div class="label" style="display: table-cell">
                            <p>Limites d'âge :</p>
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

                    </div>
                    <div style="display: table-row">
                        <div class="label" style="display: table-cell">
                            <p>Fumer à l'intérieur :</p>
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

                    </div>
                    <div style="display: table-row">
                        <div class="label" style="display: table-cell">
                            <p>Alcool :</p>
                        </div>
                        <div class="info" style="display: table-cell">
                            <p><?php echo $party->getAlcohol() < 2 ? $party->getAlcohol() == 1 ? "Autorisé" : "Prohibé" : "Exigé"; ?></p>
                        </div>
                    </div>
                    <div style="display: table-row">
                        <div class="label" style="display: table-cell">
                            <p>Provenance du jeu : </p>
                        </div>
                        <div class="info" style="display: table-cell">
                            <p><?php echo $party->getGameEdition(); ?></p>
                        </div>

                    </div>
                    <div style="display: table-row">
                        <div class="label" style="display: table-cell">
                            <p>Provenance du scénario : </p>
                        </div>
                        <div class="info" style="display: table-cell">
                            <p><?php echo $party->getScenarioEdition(); ?></p>
                        </div>
                    </div>
                </div>
                <div class="label">
                    <p style="text-align: left !important;">Description : </p>
                </div>
                <div class="info">
                    <p style="text-align: justify !important;"><?php
                        echo $party->getComment();
                        ?></p>
                </div>
                <?php if ($userConnected != null && !$withMessage && $party->getIdOwner() != $userConnected->getId()) { ?>
                    <!--                    <button id="contactParty--><?php //echo $party->getId() ?><!--"-->
                    <!--                            onclick="messageTo(--><?php //echo $party->getId() ?><!--)">-->
                    <!--                        Contacter le-->
                    <!--                        MJ-->
                    <!--                    </button>-->
                    <?php
                    if (!Parties::isRegisteredOn($userConnected->getId(), $party->getId())) {
                        if ($userConnected->getId() != $party->getIdOwner()) {
                            ?>
                            <button class="subButton" onclick="registerTo(<?php echo $party->getId() ?>)">S'inscrire
                            </button>
                        <?php }
                    } else {
                        ?>
                        <button class="unsubButton" onclick="unregisterTo(<?php echo $party->getId() ?>)">Se désinscrire
                        </button>
                    <?php } ?>
                <?php } else if ($userConnected != null && $party->getIdOwner() == $userConnected->getId() && !$withMessage) {
                    ?>
                    <p style="text-align: center;
                                font-family: inherit;
                                color: #503b27;
                                font-style: italic;
                                font-size: 14px;">
                        Vous êtes le créateur de cette partie</p>
                    <?php
                }
                if (!$withMessage) { ?>
                    <div class="divMessage" id="divMessage<?php echo $party->getId(); ?>" style="display: none">
                        <textarea class="messageArea" title="message"></textarea>
                        <button class="sendMessageButton"
                                onclick="sendTo(<?php echo $party->getId() ?>, 1)">Envoyer
                        </button>
                    </div>
                    <?php
                }
                if ($withMessage) {
                    if ($userConnected != null) {
                        ?>
                        <button class="sendMessageButton" style="width: auto !important;"
                                onclick="messageTo(<?php echo $party->getId() ?>)">Envoyer un message à tout le monde
                        </button>
                        <?php
                        if (!Parties::isRegisteredOn($userConnected->getId(), $party->getId())) {
                            if ($userConnected->getId() != $party->getIdOwner()) {
                                ?>
                                <button class="subButton" onclick="registerTo(<?php echo $party->getId() ?>)">S'inscrire
                                </button>
                            <?php }
                        } else {
                            ?>
                            <button class="unsubButton" onclick="unregisterTo(<?php echo $party->getId() ?>)">Se
                                désinscrire
                            </button>
                        <?php } ?>
                        <div class="divMessage" id="divMessage<?php echo $party->getId(); ?>" style="display: none">
                            <textarea class="messageArea" title="message"></textarea>
                            <button class="sendMessageButton"
                                    onclick="sendTo(<?php echo $party->getId() ?>, 0)">Envoyer
                            </button>
                        </div>
                        <?php
                        foreach ($party->getMessages() as $msg)
                            afficherMessage($msg, Session::unserializeConnectedUser()->getId() == $party->getIdOwner(), $party);
                    } else
                        foreach ($party->getMessages() as $msg)
                            afficherMessage($msg, false, $party);
                    if (Session::unserializeConnectedUser()->getId() == $party->getIdOwner()) {
                        ?>
                        <button class="cancelParty"
                                onclick="deleteParty(<?php echo $party->getId() ?>)">Annuler cette partie
                        </button>
                        <?php
                    }
                }
                ?>
            </div>
        </div>

        <?php
    }
}

function afficherMessage(Message $message, bool $isOwner, Party $party)
{
    if (!$message->isPrivate() || $isOwner) {
        ?>
        <div class="message">
            <div class="header">
                <div style="display: table-cell; text-align: left;">
                    <p class="pseudo"
                       style="text-align: left;"><?php echo $message->getUser()->getPseudo(); ?><?php echo $message->getUser()->getId() == $party->getIdOwner() ? '(MJ)' : ''; ?></p>
                </div>
                <div style="display: table-cell; text-align: right;">
                    <p style="text-align: right;"><?php echo date_format(new DateTime($message->getDate()), 'd/m/Y H:i'); ?></p>
                </div>
            </div>
            <div class="messageDisplay">
                <p class="corpsMessage"><?php echo $message->getMessage(); ?></p>
            </div>
        </div>
        <?php
    }
}
