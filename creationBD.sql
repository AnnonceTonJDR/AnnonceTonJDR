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
  `id`         INT(11),
  `mail`       VARCHAR(255) NOT NULL,
  `etat`       INT(11)      NOT NULL,
  `motDePasse` VARCHAR(128) NOT NULL,
  `sel`        VARCHAR(32)  NOT NULL
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


/* Ajout d'un compte de test pour la connection */
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
  '2', 'test@test.fr', '1', 'c508630359b61efdb2c9912e9188a8db',
  '132e21374bc8ac35487014f7780fe7eb8bfe2e1991433dd8af28768e7ba6dcc2c21d01a1e0c2695c4a642b6190bb8d2c9d8ebd91a79fc3ad6e761fcdbc316125',
  '31-10-2017'
);

CREATE TABLE IF NOT EXISTS `Annonce` (
  `idAnnonce`                 INT(11)      NOT NULL AUTO_INCREMENT,
  `idUtilisateur`             INT(11)      NOT NULL,
  `lienAssocie`               VARCHAR(255),
  `joueurMax`                 TINYINT(2)   NOT NULL,
  `ageMin`                    TINYTEXT     NOT NULL,
  `ageMax`                    TINYTEXT     NOT NULL,
  `nomJeu`                    VARCHAR(255) NOT NULL,
  `edition`                   TINYINT(2)   NOT NULL,
  `nomScenario`               VARCHAR(255) NOT NULL,
  `editionScenario`           TINYINT(2)   NOT NULL,
  `adresse`                   VARCHAR(255) NOT NULL,
  `zone`                      INT(11)      NOT NULL,
  `lieu`                      TINYINT(2)   NOT NULL,
  `nourritureBoisson`         TINYTEXT     NOT NULL,
  `alcool`                    TINYINT(4)   NOT NULL,
  `fumer`                     TINYINT(4)   NOT NULL,
  `titreForum`                VARCHAR(255) NOT NULL,
  `considerForumThread`       TINYINT(1)   NOT NULL,
  `commentaire`               TEXT         NOT NULL,
  `date`                      DATETIME     NOT NULL,
  `faitPartieCamapgneOuverte` TINYINT(1)   NOT NULL,
  `dateDerniereModif`         TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idAnnonce`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  AUTO_INCREMENT = 1;

CREATE TABLE IF NOT EXISTS `Campagne` (
  `idCampagne`              INT(11)     NOT NULL AUTO_INCREMENT,
  `sujetChangement`         TINYINT(1)  NOT NULL,
  `nbSessions`              TINYINT(2)  NOT NULL,
  `nom`                     INT(11)     NOT NULL,
  `libre`                   TINYINT(1)  NOT NULL,
  `frequence`               VARCHAR(63) NOT NULL,
  `laisserLesGensMeJoindre` INT(11)     NOT NULL,
  `idAnnonceAssociee`       INT(11)     NOT NULL,
  PRIMARY KEY (`idCampagne`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  AUTO_INCREMENT = 1;

CREATE TABLE IF NOT EXISTS `Inscription` (
  `idUtilisateur` INT(11) NOT NULL,
  `idAnnonce`     INT(11) NOT NULL,
  PRIMARY KEY (`idUtilisateur`, `idAnnonce`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

CREATE TABLE IF NOT EXISTS `SeRealisera` (
  `idCampagne` INT(11)      NOT NULL,
  `date`       DATETIME     NOT NULL,
  `lieu`       VARCHAR(255) NOT NULL,
  `heure`      VARCHAR(5)   NOT NULL,
  PRIMARY KEY (`idCampagne`, `date`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

CREATE TABLE IF NOT EXISTS `SpecialEvennement` (
  `idEvennement`  INT(11)      NOT NULL AUTO_INCREMENT,
  `idAnnonce`     INT(11)      NOT NULL,
  `nomEvennement` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`idEvennement`, `idAnnonce`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  AUTO_INCREMENT = 1;