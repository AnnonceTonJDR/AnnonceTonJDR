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
  `motDePasse` VARCHAR(128)  NOT NULL,
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

ALTER TABLE  `RecupMDP` ADD UNIQUE (
  `idUtilisateur`
);


/* Ajout d'un compte de test pour la connection */
INSERT INTO  `Utilisateur` (
`id` ,
`nom` ,
`prenom` ,
`pseudo` ,
`dateInscription`
)
VALUES (
1, 'test','test','test', NOW()
);

INSERT INTO  `UtilisateurPrivate` (
`id` ,
`mail` ,
`etat` ,
`motDePasse` ,
`sel` ,
`dateNaissance`
)
VALUES (
'2',  'test@test.fr',  '1',  'c508630359b61efdb2c9912e9188a8db',  '132e21374bc8ac35487014f7780fe7eb8bfe2e1991433dd8af28768e7ba6dcc2c21d01a1e0c2695c4a642b6190bb8d2c9d8ebd91a79fc3ad6e761fcdbc316125', '31-10-2017'
);