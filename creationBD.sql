SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS Utilisateur;
DROP TABLE IF EXISTS UtilisateurPrivate;
DROP TABLE IF EXISTS Annonce;
DROP TABLE IF EXISTS Inscription;
DROP TABLE IF EXISTS EditionJeu;
DROP TABLE IF EXISTS EditionScenario;
DROP TABLE IF EXISTS TypeLieu;
DROP TABLE IF EXISTS Message;
DROP TABLE IF EXISTS Inscription;
DROP TABLE IF EXISTS Campagne;
DROP TABLE IF EXISTS RecupMDP;
DROP TABLE IF EXISTS SeRealisera;
DROP TABLE IF EXISTS SpecialEvennement;

CREATE TABLE IF NOT EXISTS `Utilisateur` (
  `id`              INT(11)     NOT NULL,
  `nom`             VARCHAR(32) NOT NULL,
  `prenom`          VARCHAR(32) NOT NULL,
  `pseudo`          VARCHAR(32) NOT NULL,
  `dateInscription` DATE        NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pseudo` (`pseudo`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  AUTO_INCREMENT = 0;

CREATE TABLE IF NOT EXISTS `UtilisateurPrivate` (
  `id`            INT(11),
  `mail`          VARCHAR(255) NOT NULL,
  `etat`          INT(11)      NOT NULL,
  `motDePasse`    VARCHAR(128) NOT NULL,
  `sel`           VARCHAR(32)  NOT NULL,
  `dateNaissance` DATETIME
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  AUTO_INCREMENT = 0;

ALTER TABLE `UtilisateurPrivate`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `UtilisateurPrivate`
  ADD FOREIGN KEY (`id`) REFERENCES `Utilisateur` (
  `id`
)
  ON DELETE CASCADE
  ON UPDATE CASCADE;


CREATE TABLE IF NOT EXISTS `RecupMDP` (
  `code`          VARCHAR(32),
  `idUtilisateur` INT(11) NOT NULL,
  `dateDemande`   TIMESTAMP
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

ALTER TABLE `RecupMDP`
  ADD PRIMARY KEY (`code`);

ALTER TABLE `RecupMDP`
  ADD FOREIGN KEY (`idUtilisateur`) REFERENCES `Utilisateur` (
  `id`
)
  ON DELETE NO ACTION
  ON UPDATE CASCADE;

ALTER TABLE `RecupMDP`
  ADD UNIQUE (
  `idUtilisateur`
);

# region Ajout d'un compte de test pour la connection
INSERT INTO `Utilisateur` (
  `id`,
  `nom`,
  `prenom`,
  `pseudo`,
  `dateInscription`
)
VALUES (
  2, 'test', 'test', 'test', NOW()
);

INSERT INTO `UtilisateurPrivate` (
  `id`,
  `mail`,
  `etat`,
  `motDePasse`,
  `sel`,
  `dateNaissance`
)
VALUES (
  2, 'test@test.fr', 1, 'c508630359b61efdb2c9912e9188a8db',
  '132e21374bc8ac35487014f7780fe7eb8bfe2e1991433dd8af28768e7ba6dcc2c21d01a1e0c2695c4a642b6190bb8d2c9d8ebd91a79fc3ad6e761fcdbc316125',
  '31-10-2017'
);

# endregion

# region Ajout du compte avec le mail lucas.oms@hotmail.fr necessaires aux tests
INSERT INTO `Utilisateur` (
  `id`, `nom`, `prenom`, `pseudo`, `dateInscription`) VALUES
  (1, 'Nom', 'Prenom', 'Pseudo', '2017-10-26');

INSERT INTO `UtilisateurPrivate` (`id`, `mail`, `etat`, `motDePasse`, `sel`, `dateNaissance`) VALUES
  (1, 'lucas.oms@hotmail.fr', 1,
   'e2b094ca683fddd60663df9a0bafecfc62445e21f66e4ffe7affa66e40b5a08a850da342d0928df41758fa3b4d3b2eb9582336434e64c0498e60c0094292cf46',
   '7b1f6eae3c92d2665f033008ba974b20', '2017-11-22');

# endregion

CREATE TABLE IF NOT EXISTS `Annonce` (
  `idAnnonce`                 INT(11)        NOT NULL AUTO_INCREMENT,
  `idUtilisateur`             INT(11)        NOT NULL,
  `lienAssocie`               VARCHAR(255),
  `joueurMax`                 TINYINT(2)     NOT NULL,
  `joueurDejaInscrits`        TINYINT(2)     NOT NULL,
  `ageMin`                    TINYINT(3)     NOT NULL,
  `ageMax`                    TINYINT(3)     NOT NULL,
  `nomJeu`                    VARCHAR(255)   NOT NULL,
  `edition`                   VARCHAR(32)    NOT NULL,
  `nomScenario`               VARCHAR(255)   NOT NULL,
  `editionScenario`           VARCHAR(32)    NOT NULL,
  `adresse`                   VARCHAR(255)   NOT NULL,
  `longitude`                 DECIMAL(11, 8) NOT NULL,
  `latitude`                  DECIMAL(10, 8) NOT NULL,
  `lieu`                      VARCHAR(32)    NOT NULL,
  `nourritureBoisson`         TINYINT(1)     NOT NULL,
  `alcool`                    TINYINT(1)     NOT NULL,
  `fumer`                     TINYINT(1)     NOT NULL,
  `titreForum`                VARCHAR(255)   NOT NULL,
  `commentaire`               TEXT           NOT NULL,
  `date`                      DATETIME       NOT NULL,
  `faitPartieCamapgneOuverte` BOOLEAN        NOT NULL,
  `dateDerniereModif`         TIMESTAMP      NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idAnnonce`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  AUTO_INCREMENT = 1;

ALTER TABLE Annonce
  ADD CONSTRAINT `annonce_user` FOREIGN KEY (`idUtilisateur`) REFERENCES `Utilisateur` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE,
  ADD CONSTRAINT `annonce_editionJeu` FOREIGN KEY (`edition`) REFERENCES `EditionJeu` (`type`)
  ON DELETE CASCADE
  ON UPDATE CASCADE,
  ADD CONSTRAINT `annonce_editionScenario` FOREIGN KEY (`editionScenario`) REFERENCES `EditionScenario` (`type`)
  ON DELETE CASCADE
  ON UPDATE CASCADE,
  ADD CONSTRAINT `annonce_typeLieu` FOREIGN KEY (`lieu`) REFERENCES `TypeLieu` (`type`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;

CREATE TABLE IF NOT EXISTS `Campagne` (
  `idCampagne`              INT(11)    NOT NULL AUTO_INCREMENT,
  `idAnnonceAssociee`       INT(11)    NOT NULL,
  `sujetChangement`         BOOLEAN    NOT NULL,
  `nbSessions`              TINYINT(2) NOT NULL,
  `libre`                   TINYINT(1) NOT NULL,
  `frequence`               VARCHAR(63),
  `laisserLesGensMeJoindre` BOOLEAN    NOT NULL,
  PRIMARY KEY (`idCampagne`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  AUTO_INCREMENT = 1;

ALTER TABLE Campagne
  ADD CONSTRAINT `campagne_annonce` FOREIGN KEY (`idAnnonceAssociee`) REFERENCES `Annonce` (`idAnnonce`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;

CREATE TABLE IF NOT EXISTS `Inscription` (
  `idUtilisateur` INT(11) NOT NULL,
  `idAnnonce`     INT(11) NOT NULL,
  PRIMARY KEY (`idUtilisateur`, `idAnnonce`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

ALTER TABLE Inscription
  ADD CONSTRAINT `inscription_user` FOREIGN KEY (`idUtilisateur`) REFERENCES `Utilisateur` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE,
  ADD CONSTRAINT `inscription_annonce` FOREIGN KEY (`idAnnonce`) REFERENCES `Annonce` (`idAnnonce`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;

CREATE TABLE IF NOT EXISTS `SeRealisera` (
  `idCampagne` INT(11)      NOT NULL,
  `date`       DATETIME     NOT NULL,
  `lieu`       VARCHAR(255) NOT NULL,
  `heure`      VARCHAR(5)   NOT NULL,
  PRIMARY KEY (`idCampagne`, `date`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;
ALTER TABLE SeRealisera
  ADD CONSTRAINT `serealisera_idCampagne` FOREIGN KEY (`idCampagne`) REFERENCES `Campagne` (`idCampagne`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;

CREATE TABLE IF NOT EXISTS `SpecialEvennement` (
  `idEvennement`  INT(11)      NOT NULL AUTO_INCREMENT,
  `idAnnonce`     INT(11)      NOT NULL,
  `nomEvennement` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`idEvennement`, `idAnnonce`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  AUTO_INCREMENT = 1;
ALTER TABLE SpecialEvennement
  ADD CONSTRAINT `specialevent_idAnnonce` FOREIGN KEY (`idAnnonce`) REFERENCES `Annonce` (`idAnnonce`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;

CREATE TABLE IF NOT EXISTS `EditionJeu` (
  `type` VARCHAR(32),
  PRIMARY KEY (`type`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

INSERT INTO `EditionJeu` (
  `type`
)
VALUES (
  'commercial'
), (
  'amateur'
), (
  'personnel'
);

CREATE TABLE IF NOT EXISTS `EditionScenario` (
  `type` VARCHAR(32),
  PRIMARY KEY (`type`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

INSERT INTO `EditionScenario` (
  `type`
)
VALUES (
  'du commerce'
), (
  'd\'internet'
), (
  'de moi ou d\'un proche'
);

CREATE TABLE IF NOT EXISTS `TypeLieu` (
  `type` VARCHAR(32),
  PRIMARY KEY (`type`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

INSERT INTO `TypeLieu` (
  `type`
)
VALUES (
  'chez moi'
), (
  'dans un bar/café'
), (
  'dans une salle'
), (
  'à l\'extérieur'
);

CREATE TABLE IF NOT EXISTS `Message` (
  `idMessage`     INT(11)   NOT NULL AUTO_INCREMENT,
  `idAnnonce`     INT(11)   NOT NULL,
  `idUtilisateur` INT(11)   NOT NULL,
  `prive`         BOOLEAN   NOT NULL,
  `message`       TEXT      NOT NULL,
  `datePost`      TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idMessage`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;
ALTER TABLE Message
  ADD CONSTRAINT `message_annonce` FOREIGN KEY (`idAnnonce`) REFERENCES `Annonce` (`idAnnonce`)
  ON DELETE CASCADE
  ON UPDATE CASCADE,
  ADD CONSTRAINT `message_user` FOREIGN KEY (`idUtilisateur`) REFERENCES `Utilisateur` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;

SET FOREIGN_KEY_CHECKS = 1;