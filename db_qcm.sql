-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Ven 12 Mai 2017 à 08:13
-- Version du serveur :  10.1.16-MariaDB
-- Version de PHP :  5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `db_qcm`
--

-- --------------------------------------------------------

--
-- Structure de la table `answer`
--

CREATE TABLE `answer` (
  `id_answer` int(11) NOT NULL,
  `answer` text NOT NULL,
  `right_answer` tinyint(1) NOT NULL,
  `id_question` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `answer`
--

INSERT INTO `answer` (`id_answer`, `answer`, `right_answer`, `id_question`) VALUES
(1, '2 km2', 0, 1),
(2, '100 000km2', 1, 1),
(5, 'Iffset Latin', 1, 2),
(6, 'Señor !', 0, 2),
(9, 'tata !', 1, 3),
(10, 'Titi..', 0, 3),
(11, 'vader retro satanas', 0, 4),
(12, 'welcome', 1, 4);

-- --------------------------------------------------------

--
-- Structure de la table `evaluation`
--

CREATE TABLE `evaluation` (
  `id_evaluation` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `access_code` varchar(50) NOT NULL,
  `id_qcm` int(11) NOT NULL,
  `id_creator` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `evaluation`
--

INSERT INTO `evaluation` (`id_evaluation`, `name`, `access_code`, `id_qcm`, `id_creator`) VALUES
(3, 'Plop', '58e730321e409', 1, 2),
(4, 'Test 2.0', '58e7304f6c0de', 1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `evaluation_has_user`
--

CREATE TABLE `evaluation_has_user` (
  `id_user` int(11) NOT NULL,
  `id_evaluation` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `evaluation_has_user`
--

INSERT INTO `evaluation_has_user` (`id_user`, `id_evaluation`) VALUES
(2, 3),
(2, 4),
(5, 3);

-- --------------------------------------------------------

--
-- Structure de la table `qcm`
--

CREATE TABLE `qcm` (
  `id_qcm` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `creation_date` date NOT NULL,
  `id_creator` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `qcm`
--

INSERT INTO `qcm` (`id_qcm`, `name`, `creation_date`, `id_creator`) VALUES
(1, 'oui', '2017-02-13', 2);

-- --------------------------------------------------------

--
-- Structure de la table `question`
--

CREATE TABLE `question` (
  `id_question` int(11) NOT NULL,
  `question` text NOT NULL,
  `id_qcm` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `question`
--

INSERT INTO `question` (`id_question`, `question`, `id_qcm`) VALUES
(1, 'Taille de l''asie?', 1),
(2, 'Lorem Ipsum ?', 1),
(3, 'TOTO?', 1),
(4, 'Hi ?', 1);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id_user`, `name`, `first_name`, `email`, `password`) VALUES
(2, 'oui', 'oui', '', '123'),
(5, 'Cugni', 'Zoé', 'zoe.cugni@gmail.com', '$2y$10$Q/f6Va2RTIaaSc2pgV0ENeyp/40qViPxYMNu/t.Hmty');

-- --------------------------------------------------------

--
-- Structure de la table `user_has_answer`
--

CREATE TABLE `user_has_answer` (
  `id_user` int(11) NOT NULL,
  `id_answer` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `user_has_answer`
--

INSERT INTO `user_has_answer` (`id_user`, `id_answer`) VALUES
(2, 2),
(2, 6),
(2, 9),
(2, 11),
(5, 2),
(5, 6),
(5, 10),
(5, 12);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `answer`
--
ALTER TABLE `answer`
  ADD PRIMARY KEY (`id_answer`),
  ADD KEY `id_question` (`id_question`);

--
-- Index pour la table `evaluation`
--
ALTER TABLE `evaluation`
  ADD PRIMARY KEY (`id_evaluation`),
  ADD UNIQUE KEY `access_code` (`access_code`),
  ADD KEY `id_creator` (`id_creator`),
  ADD KEY `id_qcm` (`id_qcm`);

--
-- Index pour la table `evaluation_has_user`
--
ALTER TABLE `evaluation_has_user`
  ADD PRIMARY KEY (`id_user`,`id_evaluation`),
  ADD KEY `id_evaluation` (`id_evaluation`);

--
-- Index pour la table `qcm`
--
ALTER TABLE `qcm`
  ADD PRIMARY KEY (`id_qcm`),
  ADD KEY `id_creator` (`id_creator`);

--
-- Index pour la table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`id_question`),
  ADD KEY `id_qcm` (`id_qcm`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- Index pour la table `user_has_answer`
--
ALTER TABLE `user_has_answer`
  ADD PRIMARY KEY (`id_user`,`id_answer`),
  ADD KEY `id_answer` (`id_answer`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `answer`
--
ALTER TABLE `answer`
  MODIFY `id_answer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT pour la table `evaluation`
--
ALTER TABLE `evaluation`
  MODIFY `id_evaluation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `qcm`
--
ALTER TABLE `qcm`
  MODIFY `id_qcm` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `question`
--
ALTER TABLE `question`
  MODIFY `id_question` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `answer`
--
ALTER TABLE `answer`
  ADD CONSTRAINT `answer_ibfk_1` FOREIGN KEY (`id_question`) REFERENCES `question` (`id_question`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `evaluation`
--
ALTER TABLE `evaluation`
  ADD CONSTRAINT `evaluation_ibfk_2` FOREIGN KEY (`id_creator`) REFERENCES `user` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `evaluation_ibfk_3` FOREIGN KEY (`id_qcm`) REFERENCES `qcm` (`id_qcm`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `evaluation_has_user`
--
ALTER TABLE `evaluation_has_user`
  ADD CONSTRAINT `evaluation_has_user_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `evaluation_has_user_ibfk_2` FOREIGN KEY (`id_evaluation`) REFERENCES `evaluation` (`id_evaluation`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `question_ibfk_1` FOREIGN KEY (`id_qcm`) REFERENCES `qcm` (`id_qcm`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `user_has_answer`
--
ALTER TABLE `user_has_answer`
  ADD CONSTRAINT `user_has_answer_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_has_answer_ibfk_2` FOREIGN KEY (`id_answer`) REFERENCES `answer` (`id_answer`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
