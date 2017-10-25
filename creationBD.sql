CREATE TABLE IF NOT EXISTS `Utilisateur` (
  `id` int(11) NOT NULL,
  `nom` varchar(32) NOT NULL,
  `prenom` varchar(32) NOT NULL,
  `pseudo` varchar(32) NOT NULL,
  `dateInscription` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pseudo` (`pseudo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=0;

CREATE TABLE IF NOT EXISTS `UtilisateurPrivate` (
  `id` int(11),
  `mail` varchar(255) NOT NULL,
  `etat` int(11) NOT NULL,
  `motDePasse` varchar(64) NOT NULL,
  `sel` varchar(32) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=0 ;