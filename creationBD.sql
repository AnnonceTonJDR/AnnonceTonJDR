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
  `motDePasse` VARCHAR(64)  NOT NULL,
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