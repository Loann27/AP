-- phpMyAdmin SQL Dump
-- version 5.2.1deb1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : lun. 31 mars 2025 à 07:21
-- Version du serveur : 10.11.6-MariaDB-0+deb12u1
-- Version de PHP : 8.2.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `hopital`
--

-- --------------------------------------------------------

--
-- Structure de la table `Hospitalisation`
--

CREATE TABLE `Hospitalisation` (
  `id_hospitalisation` int(11) NOT NULL,
  `date_hospi` date NOT NULL,
  `nom_medecin` text NOT NULL,
  `id_patient` int(11) DEFAULT NULL,
  `chambre` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Patient`
--

CREATE TABLE `Patient` (
  `id_patient` int(11) NOT NULL,
  `nom_naissance` text NOT NULL,
  `nom_epouse` text DEFAULT NULL,
  `prenom` text NOT NULL,
  `date_naissance` date NOT NULL,
  `adresse` text NOT NULL,
  `CP` int(5) NOT NULL,
  `ville` text NOT NULL,
  `email` text NOT NULL,
  `telephone` int(10) NOT NULL,
  `genre` text NOT NULL,
  `id_sociale` int(11) DEFAULT NULL,
  `id_perspre` int(11) DEFAULT NULL,
  `id_persconf` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Personneconf`
--

CREATE TABLE `Personneconf` (
  `id` int(11) NOT NULL,
  `nom` text NOT NULL,
  `prenom` text NOT NULL,
  `tel` int(10) NOT NULL,
  `adresse` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Personnepre`
--

CREATE TABLE `Personnepre` (
  `id` int(11) NOT NULL,
  `nom` text NOT NULL,
  `prenom` text NOT NULL,
  `tel` int(10) NOT NULL,
  `adresse` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `PieceJointe`
--

CREATE TABLE `PieceJointe` (
  `id` int(11) NOT NULL,
  `recto_verso_identite` longblob NOT NULL,
  `carte_vitale` longblob NOT NULL,
  `carte_mutuelle` longblob NOT NULL,
  `livret_famille` longblob DEFAULT NULL,
  `id_patient` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Preadmi`
--

CREATE TABLE `Preadmi` (
  `id` int(11) NOT NULL,
  `date_preadmi` date NOT NULL,
  `heure` time NOT NULL,
  `id_medecin` int(11) DEFAULT NULL,
  `id_patient` int(11) DEFAULT NULL,
  `type_preadmi` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Professionnel`
--

CREATE TABLE `Professionnel` (
  `id` int(11) NOT NULL,
  `nom` text NOT NULL,
  `prenom` text NOT NULL,
  `identifiant` text NOT NULL,
  `mdp` text NOT NULL,
  `id_role` int(11) NOT NULL,
  `id_service` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Professionnel`
--

INSERT INTO `Professionnel` (`id`, `nom`, `prenom`, `identifiant`, `mdp`, `id_role`, `id_service`) VALUES
(1, 'POIRIER', 'Sabine', 'S.POIRIER', '9ba4850ef21ec1e2b6ff086bff4fc3ccdc76f166', 1, 1),
(2, 'COVILLON', 'Alexandrie', 'A.COVILLON', 'b1452324fcd5119d0738e3df1306121063258775', 2, 2),
(3, 'MARQUIS', 'Françoise', 'F.MARQUIS', '3c568fb114462d348a4efec3ac7832ab0e294588', 3, 3),
(4, 'FAURE', 'Hugues', 'H.FAURE', 'bb25663559fb0a98a6373994b6e78f179caffb77', 3, 4),
(5, 'CAUDRELLIER', 'Edith', 'E.CAUDRELLIER', '69394dd61634ab399f96c035f2dcdb88a527ca77', 4, 5),
(6, 'VALLER', 'Harry', 'H.VALLER', '84605985fe017a47ce26a628f278213c86893718', 4, 5),
(7, 'CLOCHE', 'Hans', 'H.CLOCHE', 'f61c83c678ff37d16f67eb8252dcd83e5a608192', 4, 5);

--
-- Déclencheurs `Professionnel`
--
DELIMITER $$
CREATE TRIGGER `InsProfessionnel` BEFORE INSERT ON `Professionnel` FOR EACH ROW BEGIN
DECLARE Nb integer;
SELECT COUNT(*) INTO Nb
FROM Professionnel
WHERE mdp = NEW.mdp;
IF Nb = 1 THEN
	SIGNAL SQLSTATE "45000"
    SET MESSAGE_TEXT = "Le mot de passe est déjà utilisé par un autre compte";
END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `Roles`
--

CREATE TABLE `Roles` (
  `id_role` int(11) NOT NULL,
  `nom` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Roles`
--

INSERT INTO `Roles` (`id_role`, `nom`) VALUES
(1, 'Admin'),
(2, 'Chirurgien'),
(3, 'Médecin'),
(4, 'Secrétaire');

-- --------------------------------------------------------

--
-- Structure de la table `Services`
--

CREATE TABLE `Services` (
  `id_service` int(11) NOT NULL,
  `nom` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Services`
--

INSERT INTO `Services` (`id_service`, `nom`) VALUES
(1, 'Admin'),
(2, 'Maxillo-facial'),
(3, 'Radiologue'),
(4, 'Neurologue'),
(5, 'Administration');

-- --------------------------------------------------------

--
-- Structure de la table `Sociale`
--

CREATE TABLE `Sociale` (
  `id` int(11) NOT NULL,
  `organisme_secu_sociale` text NOT NULL,
  `num_secu` varchar(15) NOT NULL,
  `assure` text NOT NULL,
  `ALD` text NOT NULL,
  `nom_mutuelle` text NOT NULL,
  `num_adherent` int(8) NOT NULL,
  `chambre_particuliere` text NOT NULL,
  `id_patient` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Hospitalisation`
--
ALTER TABLE `Hospitalisation`
  ADD PRIMARY KEY (`id_hospitalisation`),
  ADD KEY `Hospitalisation_ibfk_1` (`id_patient`);

--
-- Index pour la table `Patient`
--
ALTER TABLE `Patient`
  ADD PRIMARY KEY (`id_patient`),
  ADD KEY `Patient_ibfk_1` (`id_sociale`),
  ADD KEY `Patient_ibfk_2` (`id_perspre`),
  ADD KEY `Patient_ibfk_3` (`id_persconf`);

--
-- Index pour la table `Personneconf`
--
ALTER TABLE `Personneconf`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Personnepre`
--
ALTER TABLE `Personnepre`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `PieceJointe`
--
ALTER TABLE `PieceJointe`
  ADD PRIMARY KEY (`id`),
  ADD KEY `PieceJointe_ibfk_1` (`id_patient`);

--
-- Index pour la table `Preadmi`
--
ALTER TABLE `Preadmi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Preadmi_ibfk_2` (`id_patient`),
  ADD KEY `Preadmi_ibfk_3` (`id_medecin`);

--
-- Index pour la table `Professionnel`
--
ALTER TABLE `Professionnel`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_service` (`id_service`),
  ADD KEY `id_role` (`id_role`);

--
-- Index pour la table `Roles`
--
ALTER TABLE `Roles`
  ADD PRIMARY KEY (`id_role`);

--
-- Index pour la table `Services`
--
ALTER TABLE `Services`
  ADD PRIMARY KEY (`id_service`);

--
-- Index pour la table `Sociale`
--
ALTER TABLE `Sociale`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Sociale_ibfk_1` (`id_patient`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `Hospitalisation`
--
ALTER TABLE `Hospitalisation`
  MODIFY `id_hospitalisation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `Patient`
--
ALTER TABLE `Patient`
  MODIFY `id_patient` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `Personneconf`
--
ALTER TABLE `Personneconf`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `Personnepre`
--
ALTER TABLE `Personnepre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `PieceJointe`
--
ALTER TABLE `PieceJointe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `Preadmi`
--
ALTER TABLE `Preadmi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `Professionnel`
--
ALTER TABLE `Professionnel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `Sociale`
--
ALTER TABLE `Sociale`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `Hospitalisation`
--
ALTER TABLE `Hospitalisation`
  ADD CONSTRAINT `Hospitalisation_ibfk_1` FOREIGN KEY (`id_patient`) REFERENCES `Patient` (`id_patient`) ON DELETE CASCADE;

--
-- Contraintes pour la table `Patient`
--
ALTER TABLE `Patient`
  ADD CONSTRAINT `Patient_ibfk_1` FOREIGN KEY (`id_sociale`) REFERENCES `Sociale` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `Patient_ibfk_2` FOREIGN KEY (`id_perspre`) REFERENCES `Personnepre` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `Patient_ibfk_3` FOREIGN KEY (`id_persconf`) REFERENCES `Personneconf` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `PieceJointe`
--
ALTER TABLE `PieceJointe`
  ADD CONSTRAINT `PieceJointe_ibfk_1` FOREIGN KEY (`id_patient`) REFERENCES `Patient` (`id_patient`) ON DELETE CASCADE;

--
-- Contraintes pour la table `Preadmi`
--
ALTER TABLE `Preadmi`
  ADD CONSTRAINT `Preadmi_ibfk_2` FOREIGN KEY (`id_patient`) REFERENCES `Patient` (`id_patient`) ON DELETE CASCADE,
  ADD CONSTRAINT `Preadmi_ibfk_3` FOREIGN KEY (`id_medecin`) REFERENCES `Professionnel` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `Professionnel`
--
ALTER TABLE `Professionnel`
  ADD CONSTRAINT `Professionnel_ibfk_1` FOREIGN KEY (`id_service`) REFERENCES `Services` (`id_service`),
  ADD CONSTRAINT `Professionnel_ibfk_2` FOREIGN KEY (`id_role`) REFERENCES `Roles` (`id_role`);

--
-- Contraintes pour la table `Sociale`
--
ALTER TABLE `Sociale`
  ADD CONSTRAINT `Sociale_ibfk_1` FOREIGN KEY (`id_patient`) REFERENCES `Patient` (`id_patient`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
