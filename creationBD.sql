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
  `ageMin`                    TINYINT(3)   NOT NULL,
  `ageMax`                    TINYINT(3)   NOT NULL,
  `nomJeu`                    VARCHAR(255) NOT NULL,
  `edition`                   VARCHAR(32)  NOT NULL,
  `nomScenario`               VARCHAR(255) NOT NULL,
  `editionScenario`           VARCHAR(32)  NOT NULL,
  `adresse`                   VARCHAR(255) NOT NULL,
  `zone`                      INT(11)      NOT NULL,
  `lieu`                      VARCHAR(32)  NOT NULL,
  `nourritureBoisson`         TINYINT(1)   NOT NULL,
  `alcool`                    TINYINT(1)   NOT NULL,
  `fumer`                     TINYINT(1)   NOT NULL,
  `titreForum`                VARCHAR(255) NOT NULL,
  `commentaire`               TEXT         NOT NULL,
  `date`                      DATETIME     NOT NULL,
  `faitPartieCamapgneOuverte` BOOLEAN      NOT NULL,
  `dateDerniereModif`         TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
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
  'Commercial'
), (
  'Amateur'
), (
  'Personnel'
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
  'Commercial'
), (
  'Internet'
), (
  'Personnel'
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
  'Maison'
), (
  'Salle'
), (
  'Bar'
), (
  'Jardin'
);

#region ============= Zone =============
CREATE TABLE Zone (
  id     INT(11) PRIMARY KEY,
  idPere INT(11) REFERENCES Zone (`id`),
  nom    VARCHAR(32) NOT NULL
);

#region ===== Tuples =====
INSERT INTO Zone VALUES (1, NULL, "Virtuel");

INSERT INTO Zone VALUES (2, NULL, "Ile-De-France");

INSERT INTO Zone VALUES (3, 2, "Paris");

INSERT INTO Zone VALUES (4, 2, "Val-d'Oise");
INSERT INTO Zone VALUES (5, 4, "Cergy");
INSERT INTO Zone VALUES (6, 4, "Franconville");
INSERT INTO Zone VALUES (7, 4, "Sarcelles");
INSERT INTO Zone VALUES (8, 4, "L'Isle-Adam");
INSERT INTO Zone VALUES (9, 4, "Cormeilles-en-Vexin");
INSERT INTO Zone VALUES (10, 4, "Magny-en-Vexin");
INSERT INTO Zone VALUES (11, 4, "Chaussy");

INSERT INTO Zone VALUES (12, 2, "Yvelines");
INSERT INTO Zone VALUES (13, 12, "Versailles");
INSERT INTO Zone VALUES (14, 12, "Saint-Germain-en-Laye");
INSERT INTO Zone VALUES (15, 12, "Conflans-Sainte-Honorine");
INSERT INTO Zone VALUES (16, 12, "Les Mureaux");
INSERT INTO Zone VALUES (17, 12, "Mantes-la-Jolie");
INSERT INTO Zone VALUES (18, 12, "Bréval");
INSERT INTO Zone VALUES (19, 12, "Houdan");
INSERT INTO Zone VALUES (20, 12, "La Boissière-École");
INSERT INTO Zone VALUES (21, 12, "Rambouillet");
INSERT INTO Zone VALUES (22, 12, "Ablis");
INSERT INTO Zone VALUES (23, 12, "Allainville");
INSERT INTO Zone VALUES (24, 12, "Saint-Arnoult-en-Yvelines");
INSERT INTO Zone VALUES (25, 12, "Plaisir");
INSERT INTO Zone VALUES (26, 12, "Thoiry");

INSERT INTO Zone VALUES (27, 2, "Essonne");
INSERT INTO Zone VALUES (28, 27, "Evry");
INSERT INTO Zone VALUES (29, 27, "Montgeron");
INSERT INTO Zone VALUES (30, 27, "Longjumeau");
INSERT INTO Zone VALUES (31, 27, "Palaiseau");
INSERT INTO Zone VALUES (32, 27, "Orsay");
INSERT INTO Zone VALUES (33, 27, "Gif-sur-Yvette");
INSERT INTO Zone VALUES (34, 27, "Limours");
INSERT INTO Zone VALUES (35, 27, "Dourdan");
INSERT INTO Zone VALUES (36, 27, "Etampes");
INSERT INTO Zone VALUES (37, 27, "Pussay");
INSERT INTO Zone VALUES (38, 27, "Saclas");
INSERT INTO Zone VALUES (39, 27, "Milly-la-Forêt");
INSERT INTO Zone VALUES (40, 27, "Ballancourt-sur-Essonne");
INSERT INTO Zone VALUES (41, 27, "Brétigny-sur-Orge");

INSERT INTO Zone VALUES (42, 2, "Seine-et-Marne");
INSERT INTO Zone VALUES (43, 42, "Nemours");
INSERT INTO Zone VALUES (44, 42, "Montereau-Fault-Yonne");
INSERT INTO Zone VALUES (45, 42, "Provins");
INSERT INTO Zone VALUES (46, 42, "Louan-Villegruis-Fontaine");
INSERT INTO Zone VALUES (47, 42, "La Ferté-Gaucher");
INSERT INTO Zone VALUES (48, 42, "Coulommiers");
INSERT INTO Zone VALUES (49, 42, "La Ferté-sous-Jouarre");
INSERT INTO Zone VALUES (50, 42, "Meaux");
INSERT INTO Zone VALUES (51, 42, "Chessy");
INSERT INTO Zone VALUES (52, 42, "Melun");
INSERT INTO Zone VALUES (53, 42, "Nangis");
INSERT INTO Zone VALUES (54, 42, "Fontainebleau");

INSERT INTO Zone VALUES (55, 2, "Seine-Saint-Denis");
INSERT INTO Zone VALUES (56, 55, "Aubervilliers");
INSERT INTO Zone VALUES (57, 55, "Bobigny");
INSERT INTO Zone VALUES (58, 55, "Rosny-sous-Bois");
INSERT INTO Zone VALUES (59, 55, "Noisy-le-Grand");
INSERT INTO Zone VALUES (60, 55, "Villepinte");
INSERT INTO Zone VALUES (61, 55, "Aulnay-sous-Bois");
INSERT INTO Zone VALUES (62, 55, "Épinay-sur-Seine");
INSERT INTO Zone VALUES (63, 55, "Saint-Denis");

INSERT INTO Zone VALUES (64, 2, "Hauts-de-Seine");
INSERT INTO Zone VALUES (65, 64, "Colombes");
INSERT INTO Zone VALUES (66, 64, "Courbevoie");
INSERT INTO Zone VALUES (67, 64, "Neuilly-sur-Seine");
INSERT INTO Zone VALUES (68, 64, "Nanterre");
INSERT INTO Zone VALUES (69, 64, "Rueil-Malmaison");
INSERT INTO Zone VALUES (70, 64, "Boulogne-Billancourt");
INSERT INTO Zone VALUES (71, 64, "Clamart");
INSERT INTO Zone VALUES (72, 64, "Antony");

INSERT INTO Zone VALUES (73, 2, "Val-de-Marne");
INSERT INTO Zone VALUES (74, 73, "Créteil");
INSERT INTO Zone VALUES (75, 73, "Ivry-sur-Seine");
INSERT INTO Zone VALUES (76, 73, "Orly");
INSERT INTO Zone VALUES (77, 73, "Sucy-en-Brie");
INSERT INTO Zone VALUES (78, 73, "Périgny");
INSERT INTO Zone VALUES (79, 73, "Nogent-sur-Marne");


INSERT INTO Zone VALUES (80, NULL, "Provence-Alpes-Cote d'Azur");

INSERT INTO Zone VALUES (81, 80, "Alpes-de-Haute-Provence");
INSERT INTO Zone VALUES (82, 81, "Barcelonnette");
INSERT INTO Zone VALUES (83, 81, "Seyne");
INSERT INTO Zone VALUES (84, 81, "Sisteron");
INSERT INTO Zone VALUES (85, 81, "Forcalquier");
INSERT INTO Zone VALUES (86, 81, "Manosque");
INSERT INTO Zone VALUES (87, 81, "Castellane");
INSERT INTO Zone VALUES (88, 81, "Entrevaux");
INSERT INTO Zone VALUES (89, 81, "Allos");
INSERT INTO Zone VALUES (90, 81, "Digne-les-Bains");

INSERT INTO Zone VALUES (91, 80, "Hautes-Alpes");
INSERT INTO Zone VALUES (92, 91, "Briancon");
INSERT INTO Zone VALUES (93, 91, "Le Dévoluy");
INSERT INTO Zone VALUES (94, 91, "Veynes");
INSERT INTO Zone VALUES (95, 91, "Serre");
INSERT INTO Zone VALUES (97, 91, "Laragne-Mantéglin");
INSERT INTO Zone VALUES (98, 91, "Tallard");
INSERT INTO Zone VALUES (99, 91, "Briancon");
INSERT INTO Zone VALUES (100, 91, "Gap");
INSERT INTO Zone VALUES (101, 91, "Les Orres");
INSERT INTO Zone VALUES (102, 91, "Risoul");
INSERT INTO Zone VALUES (103, 91, "Briancon");

INSERT INTO Zone VALUES (104, 80, "Alpes-Maritimes");
INSERT INTO Zone VALUES (105, 104, "Nice");
INSERT INTO Zone VALUES (106, 104, "Cannes");
INSERT INTO Zone VALUES (107, 104, "Roubion");
INSERT INTO Zone VALUES (108, 104, "La Brigue");
INSERT INTO Zone VALUES (109, 104, "Menton");
INSERT INTO Zone VALUES (110, 104, "Monaco");

INSERT INTO Zone VALUES (111, 80, "Bouches-du-Rhône");
INSERT INTO Zone VALUES (112, 111, "Marseille");
INSERT INTO Zone VALUES (113, 111, "Aubagne");
INSERT INTO Zone VALUES (114, 111, "Aix-en-Provence");
INSERT INTO Zone VALUES (115, 111, "Salon-de-Provence");
INSERT INTO Zone VALUES (116, 111, "Les Baux-de-Provence");
INSERT INTO Zone VALUES (117, 111, "Arles");
INSERT INTO Zone VALUES (118, 111, "Saintes-Maries-de-la-Mer");
INSERT INTO Zone VALUES (119, 111, "Martigues");

INSERT INTO Zone VALUES (120, 80, "Var");
INSERT INTO Zone VALUES (121, 120, "Toulon");
INSERT INTO Zone VALUES (122, 120, "Hyères");
INSERT INTO Zone VALUES (123, 120, "Sainte-Maxime");
INSERT INTO Zone VALUES (124, 120, "Frejus");
INSERT INTO Zone VALUES (125, 120, "Tourrettes");
INSERT INTO Zone VALUES (126, 120, "Draguignan");
INSERT INTO Zone VALUES (127, 120, "Brignoles");

INSERT INTO Zone VALUES (128, 80, "Var");
INSERT INTO Zone VALUES (129, 128, "Orange");
INSERT INTO Zone VALUES (130, 128, "Avignon");
INSERT INTO Zone VALUES (131, 128, "Gordes");
INSERT INTO Zone VALUES (132, 128, "Pertuis");
INSERT INTO Zone VALUES (133, 128, "Sault");
INSERT INTO Zone VALUES (134, 128, "Vaison-la-Romaine");
INSERT INTO Zone VALUES (135, 128, "Bollène");
INSERT INTO Zone VALUES (136, 128, "Carpentras");

#endregion

#endregion

