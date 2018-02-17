-- todo: drop, recreate, transfer depuis la base de lucas.
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
  1, 'test', 'test', 'test', NOW()
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
  1, 'test@test.fr', 1, 'c508630359b61efdb2c9912e9188a8db',
  '132e21374bc8ac35487014f7780fe7eb8bfe2e1991433dd8af28768e7ba6dcc2c21d01a1e0c2695c4a642b6190bb8d2c9d8ebd91a79fc3ad6e761fcdbc316125',
  '31-10-2017'
);

# endregion

# region Ajout du compte avec le mail lucas.oms@hotmail.fr necessaires aux tests
INSERT INTO `Utilisateur` (
  `id`, `nom`, `prenom`, `pseudo`, `dateInscription`) VALUES
  (2, 'Nom', 'Prenom', 'Pseudo', '2017-10-26');

INSERT INTO `UtilisateurPrivate` (`id`, `mail`, `etat`, `motDePasse`, `sel`, `dateNaissance`) VALUES
  (2, 'lucas.oms@hotmail.fr', 1,
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
  PRIMARY KEY (`idAnnonce`),
  FOREIGN KEY (`idUtilisateur`) REFERENCES `Utilisateur` (`id`),
  FOREIGN KEY (`edition`) REFERENCES `EditionJeu` (`type`),
  FOREIGN KEY (`editionScenario`) REFERENCES `EditionScenario` (`type`),
  FOREIGN KEY (`zone`) REFERENCES Zone (`id`),
  FOREIGN KEY (`lieu`) REFERENCES `TypeLieu` (`type`)

)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  AUTO_INCREMENT = 1;

CREATE TABLE IF NOT EXISTS `Campagne` (
  `idCampagne`              INT(11)    NOT NULL AUTO_INCREMENT,
  `idAnnonceAssociee`       INT(11)    NOT NULL,
  `sujetChangement`         BOOLEAN    NOT NULL,
  `nbSessions`              TINYINT(2) NOT NULL,
  `libre`                   TINYINT(1) NOT NULL,
  `frequence`               VARCHAR(63),
  `laisserLesGensMeJoindre` BOOLEAN    NOT NULL,
  PRIMARY KEY (`idCampagne`),
  FOREIGN KEY (`idAnnonceAssociee`) REFERENCES `Annonce` (`idAnnonce`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  AUTO_INCREMENT = 1;

CREATE TABLE IF NOT EXISTS `Inscription` (
  `idUtilisateur` INT(11) NOT NULL,
  `idAnnonce`     INT(11) NOT NULL,
  PRIMARY KEY (`idUtilisateur`, `idAnnonce`),
  FOREIGN KEY (`idUtilisateur`) REFERENCES `Utilisateur` (`idUtilisateur`),
  FOREIGN KEY (`idAnnonce`) REFERENCES `Annonce` (`idAnnonce`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

CREATE TABLE IF NOT EXISTS `SeRealisera` (
  `idCampagne` INT(11)      NOT NULL,
  `date`       DATETIME     NOT NULL,
  `lieu`       VARCHAR(255) NOT NULL,
  `heure`      VARCHAR(5)   NOT NULL,
  PRIMARY KEY (`idCampagne`, `date`),
  FOREIGN KEY (`idCampagne`) REFERENCES `Annonce` (`idCampagne`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

CREATE TABLE IF NOT EXISTS `SpecialEvennement` (
  `idEvennement`  INT(11)      NOT NULL AUTO_INCREMENT,
  `idAnnonce`     INT(11)      NOT NULL,
  `nomEvennement` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`idEvennement`, `idAnnonce`),
  FOREIGN KEY (`idAnnonce`) REFERENCES `Annonce` (`idAnnonce`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  AUTO_INCREMENT = 1;

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
  `idMessage`     INT(11) NOT NULL AUTO_INCREMENT,
  `idAnnonce`     INT(11) NOT NULL,
  `idUtilisateur` INT(11) NOT NULL,
  `prive`         BOOLEAN NOT NULL,
  `message`       TEXT    NOT NULL,
  PRIMARY KEY (`idMessage`),
  FOREIGN KEY (`idAnnonce`) REFERENCES `Annonce` (`idAnnonce`),
  FOREIGN KEY (`idUtilisateur`) REFERENCES `Utilisateur` (`id`)
);