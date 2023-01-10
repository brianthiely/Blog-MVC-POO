-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mar. 10 jan. 2023 à 17:40
-- Version du serveur : 5.7.33
-- Version de PHP : 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `blog-php`
--

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `chapo` varchar(550) NOT NULL,
  `content` longtext NOT NULL,
  `author` varchar(45) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `post`
--

INSERT INTO `post` (`id`, `userId`, `title`, `chapo`, `content`, `author`, `createdAt`, `updatedAt`) VALUES
(2, 55, 'Comprendre le pattern MVC en dÃ©veloppement web', 'Le pattern MVC (Model-View-Controller) est un modÃ¨le de conception largement utilisÃ© dans le dÃ©veloppement web pour sÃ©parer les diffÃ©rentes couches d\'une application. Dans cet article, nous allons voir en dÃ©tail ce qu\'est le MVC et comment il peut vous aider Ã  structurer votre projet de maniÃ¨re efficace.', '&lt;h2&gt;Introduction&lt;/h2&gt;\r\n  &lt;p&gt;Le pattern MVC a &eacute;t&eacute; initialement d&eacute;velopp&eacute; dans les ann&eacute;es 1970 pour structurer les interfaces utilisateur en deux parties : une partie mod&egrave;le, qui g&egrave;re les donn&eacute;es et les r&egrave;gles de l&#039;application, et une partie vue, qui s&#039;occupe de l&#039;affichage de l&#039;interface utilisateur. Le contr&ocirc;leur sert de pont entre le mod&egrave;le et la vue, en g&eacute;rant les interactions entre ces deux parties et en transmettant les donn&eacute;es du mod&egrave;le &agrave; la vue.&lt;/p&gt;\r\n  &lt;p&gt;Le MVC est un pattern tr&egrave;s populaire en d&eacute;veloppement web car il permet de s&eacute;parer les diff&eacute;rentes parties de l&#039;application de mani&egrave;re claire et logique, ce qui facilite le d&eacute;veloppement et la maintenance de celle-ci. Il est notamment utilis&eacute; dans de nombreux frameworks web tels que Ruby on Rails, Django ou ASP.NET.&lt;/p&gt;\r\n  &lt;h2&gt;Le mod&egrave;le&lt;/h2&gt;\r\n  &lt;p&gt;Le mod&egrave;le est la couche de l&#039;application qui g&egrave;re les donn&eacute;es et les r&egrave;gles m&eacute;tier. Il s&#039;occupe de la gestion de la base de donn&eacute;es, de la validation des donn&eacute;es et de l&#039;application des r&egrave;gles m&eacute;tier. Le mod&egrave;le ne s&#039;occupe pas de l&#039;affichage des donn&eacute;es, mais seulement de leur gestion.&lt;/p&gt;\r\n  &lt;p&gt;Par exemple, dans une application de gestion de t&acirc;ches, le mod&egrave;le g&eacute;rerait la cr&eacute;ation, la modification et la suppression de t&acirc;ches, ainsi que la validation des donn&eacute;es entr&eacute;es par l&#039;utilisateur (titre de la t&acirc;che, date d&#039;&eacute;ch&eacute;ance, etc.). Il ne s&#039;occuperait pas de la mani&egrave;re dont ces t&acirc;ches sont affich&eacute;es &agrave; l&#039;&eacute;cran.&lt;/p&gt;\r\n&lt;h2&gt;La vue&lt;/h2&gt;\r\n  &lt;p&gt;La vue est la couche de l&#039;application qui s&#039;occupe de l&#039;affichage de l&#039;interface utilisateur. Elle re&ccedil;oit les donn&eacute;es du mod&egrave;le et les affiche &agrave; l&#039;&eacute;cran de mani&egrave;re appropri&eacute;e. La vue ne s&#039;occupe pas de la gestion des donn&eacute;es ni de la logique m&eacute;tier de l&#039;application, mais seulement de leur pr&eacute;sentation.&lt;/p&gt;\r\n  &lt;p&gt;Dans notre exemple de gestion de t&acirc;ches, la vue pourrait &ecirc;tre responsable de l&#039;affichage de la liste des t&acirc;ches &agrave; faire, ainsi que de la cr&eacute;ation d&#039;un formulaire pour ajouter de nouvelles t&acirc;ches. Elle utiliserait les donn&eacute;es fournies par le mod&egrave;le pour afficher les informations n&eacute;cessaires, mais ne s&#039;occuperait pas de la validation ou de la gestion de ces donn&eacute;es.&lt;/p&gt;\r\n  &lt;h2&gt;Le contr&ocirc;leur&lt;/h2&gt;\r\n  &lt;p&gt;Le contr&ocirc;leur est la couche de l&#039;application qui g&egrave;re les interactions entre le mod&egrave;le et la vue. Il re&ccedil;oit les requ&ecirc;tes de l&#039;utilisateur (via la vue), utilise le mod&egrave;le pour r&eacute;aliser les actions n&eacute;cessaires et met &agrave; jour la vue en cons&eacute;quence. Le contr&ocirc;leur s&#039;assure que le mod&egrave;le et la vue restent synchronis&eacute;s et qu&#039;il n&#039;y a pas de duplication de code.&lt;/p&gt;\r\n  &lt;p&gt;Dans notre exemple de gestion de t&acirc;ches, le contr&ocirc;leur pourrait &ecirc;tre responsable de la gestion du formulaire d&#039;ajout de t&acirc;ches. Il recevrait la requ&ecirc;te de l&#039;utilisateur, utiliserait le mod&egrave;le pour valider les donn&eacute;es entr&eacute;es et ajouter la t&acirc;che &agrave; la base de donn&eacute;es, puis mettrait &agrave; jour la vue pour afficher la nouvelle t&acirc;che.&lt;/p&gt;\r\n  &lt;h2&gt;Conclusion&lt;/h2&gt;\r\n  &lt;p&gt;Le pattern MVC est un mod&egrave;le de conception tr&egrave;s utile pour structurer les applications web en s&eacute;parant les diff&eacute;rentes couches de mani&egrave;re claire et logique. Il permet de d&eacute;velopper et maintenir des applications de mani&egrave;re plus efficace en s&#039;assurant que chaque couche a une responsabilit&eacute; bien d&eacute;finie. Si vous &ecirc;tes d&eacute;veloppeur web, il est important de comprendre comment fonctionne le MVC et comment l&#039;utiliser dans vos projets.&lt;/p&gt;\r\n  &lt;p&gt;Si vous avez des questions ou des commentaires sur le pattern MVC, n&#039;h&eacute;sitez pas &agrave; les laisser ci-dessous ! Nous serons ravis de r&eacute;pondre &agrave; vos questions et de discuter de ce sujet avec vous.&lt;/p&gt;', 'brian', '2022-12-19 20:20:23', NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`,`userId`),
  ADD KEY `fk_posts_users_idx` (`userId`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `fk_posts_users` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
