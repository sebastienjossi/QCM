-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Ven 19 Mai 2017 à 09:24
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
(24, 'Oui.', 1, 12),
(160, 'asd', 1, 123),
(161, 'rtt', 0, 123),
(162, 'dfgdfgdfgdfgdf', 1, 124),
(163, 'dgdfgdfgdfgdf', 0, 124),
(164, 'jfghfg', 0, 124),
(167, 'Oui', 1, 127),
(168, 'Non', 0, 127),
(169, 'En effet', 0, 128),
(170, 'Bonne chance', 1, 128);

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
(5, 3),
(5, 4);

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
(1, 'oui Test', '2017-02-13', 8),
(5, 'TEST2', '2017-05-12', 8),
(8, 'Test 1', '2017-05-19', 8);

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
(12, 'Oui ?', 5),
(123, 'Taille de l''asie?', 1),
(124, 'Lorem Ipsum ?', 1),
(127, 'Cela fonctionne-t''il?', 8),
(128, 'Fucking bug', 8);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id_user`, `name`, `first_name`, `email`, `password`) VALUES
(2, 'oui', 'oui', '', '123'),
(5, 'Cugni', 'Zoé', 'zoe.cugni@gmail.com', '$2y$10$Q/f6Va2RTIaaSc2pgV0ENeyp/40qViPxYMNu/t.Hmty'),
(8, 'Test Eval', 'test', 'test@gmail.com', '$2y$10$bIJk8hjxJAp.yJN1LT3b1uz5g4bNv8JgOKtf.ycUq.Fv6DVOTm9dC');

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
(2, 160),
(2, 164),
(5, 24),
(5, 160),
(5, 163);

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
  MODIFY `id_answer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=177;
--
-- AUTO_INCREMENT pour la table `evaluation`
--
ALTER TABLE `evaluation`
  MODIFY `id_evaluation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `qcm`
--
ALTER TABLE `qcm`
  MODIFY `id_qcm` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT pour la table `question`
--
ALTER TABLE `question`
  MODIFY `id_question` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;
--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
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
-- Contraintes pour la table `qcm`
--
ALTER TABLE `qcm`
  ADD CONSTRAINT `qcm_ibfk_1` FOREIGN KEY (`id_creator`) REFERENCES `user` (`id_user`);

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
  ADD CONSTRAINT `user_has_answer_ibfk_2` FOREIGN KEY (`id_answer`) REFERENCES `answer` (`id_answer`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
