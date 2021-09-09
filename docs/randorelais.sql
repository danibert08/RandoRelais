-- phpMyAdmin SQL Dump
-- version OVH
-- https://www.phpmyadmin.net/
--
-- Hôte : franceexuzdani08.mysql.db
-- Généré le : mer. 11 août 2021 à 11:38
-- Version du serveur :  5.6.50-log
-- Version de PHP : 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `franceexuzdani08`
--
DROP DATABASE IF EXISTS `franceexuzdani08`;
CREATE DATABASE IF NOT EXISTS `franceexuzdani08` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `franceexuzdani08`;

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20210716143433', '2021-07-26 08:32:14', 407),
('DoctrineMigrations\\Version20210717082404', '2021-07-26 08:32:14', 22),
('DoctrineMigrations\\Version20210717122636', '2021-07-26 08:32:14', 10),
('DoctrineMigrations\\Version20210717123813', '2021-07-26 08:32:14', 33),
('DoctrineMigrations\\Version20210720134433', '2021-07-26 08:32:14', 33),
('DoctrineMigrations\\Version20210721141316', '2021-07-26 08:32:14', 14),
('DoctrineMigrations\\Version20210728085436', '2021-07-28 11:11:09', 58),
('DoctrineMigrations\\Version20210728095313', '2021-07-29 10:40:41', 63),
('DoctrineMigrations\\Version20210729102949', '2021-08-02 10:15:54', 401),
('DoctrineMigrations\\Version20210731104549', '2021-08-02 10:15:54', 29),
('DoctrineMigrations\\Version20210802122217', '2021-08-03 09:05:55', 774);

-- --------------------------------------------------------

--
-- Structure de la table `reset_password_request`
--

CREATE TABLE `reset_password_request` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `selector` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hashed_token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requested_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `expires_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `review`
--

CREATE TABLE `review` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` smallint(6) NOT NULL,
  `comment` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `author_id` int(11) NOT NULL,
  `status` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `review`
--

INSERT INTO `review` (`id`, `user_id`, `rating`, `comment`, `created_at`, `author_id`, `status`) VALUES
(1, 37, 3, 'Il est trop fort !!!*', '2021-07-26 10:31:14', 41, 1),
(2, 22, 4, 'trop fort', '2021-07-26 10:39:35', 41, 0),
(4, 24, 5, 'Céline est très accueillante !', '2021-07-29 21:25:52', 41, 1),
(5, 26, 5, 'Très sympa!', '2021-07-30 10:04:08', 45, 0),
(6, 21, 5, 'Margot est super sympa et accueillante !', '2021-07-30 20:13:52', 41, 0),
(7, 21, 5, 'Margot est super sympa et accueillante !', '2021-07-30 20:15:21', 41, 0),
(9, 36, 3, 'Trè sympa', '2021-08-03 10:58:44', 48, 1),
(10, 48, 5, 'Tu es vraiment au top !!!!', '2021-08-03 11:01:18', 48, 0),
(11, 36, 5, 'Grégoire est très sympa !', '2021-08-03 11:31:07', 55, 0),
(12, 36, 5, 'Grégoire est au top !', '2021-08-03 11:58:36', 62, 0),
(13, 36, 4, 'Hello Greg, ça va bien ?', '2021-08-03 13:11:16', 66, 0),
(14, 38, 5, 'Roger est au top !!!', '2021-08-03 15:33:15', 73, 1),
(15, 39, 5, 'Parfait !', '2021-08-03 17:27:12', 74, 0),
(16, 39, 5, 'Elle est tip top !', '2021-08-03 17:47:22', 55, 0),
(17, 39, 4, 'Super emplacement pour ma tente !', '2021-08-03 17:48:58', 74, 0),
(18, 39, 5, 'Tip top !', '2021-08-04 10:46:47', 76, 0),
(22, 39, 5, 'Tip top la marmotte !', '2021-08-05 10:02:54', 77, 0),
(23, 39, 4, 'Bien !', '2021-08-05 13:55:22', 78, 0);

-- --------------------------------------------------------

--
-- Structure de la table `service`
--

CREATE TABLE `service` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `slug` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `service`
--

INSERT INTO `service` (`id`, `name`, `description`, `image`, `created_at`, `updated_at`, `slug`) VALUES
(1, 'Emplacement de tente', 'Un morceau de terrain ou de jardin vous est mis à disposition.', 'tent.png', '2021-07-26 08:43:22', '2021-07-26 08:43:22', 'my-slug'),
(2, 'Lit', 'Un bon lit dans une pièce disponible, ou chambre d\'ami.', 'bedroom.png', '2021-07-26 08:43:22', '2021-07-26 08:43:22', 'my-slug'),
(3, 'Abri', 'Auvent, une terrasse couverte, à l\'abri de la pluie', 'shelter.png', '2021-07-26 08:43:22', '2021-07-26 08:43:22', 'my-slug'),
(4, 'Réception de colis', 'Réception de vos colis afin de pouvoir récupérer du matériel en cours de route', 'delivery.png', '2021-07-26 08:43:22', '2021-07-26 08:43:22', 'my-slug'),
(5, 'Douche', 'En intérieur, ou en extérieur, une douche est accessible.', 'shower.png', '2021-07-26 08:43:22', '2021-07-26 08:43:22', 'my-slug'),
(6, 'Eau', 'Un ravitaillement en eau potable : source, robinet ou bouteilles d\'eau.', 'water.png', '2021-07-26 08:43:22', '2021-07-26 08:43:22', 'my-slug'),
(7, 'Petit-déjeuner', 'Un petit-déjeuner pour démarrer la journée le ventre plein. (pas de commande ni de réservation)', 'breakfast.png', '2021-07-26 08:43:22', '2021-07-26 08:43:22', 'my-slug'),
(8, 'Sandwich', 'Sandwich élaboré par l\'ange avec les produits disponibles.', 'sandwich.png', '2021-07-26 08:43:22', '2021-07-26 08:43:22', 'my-slug'),
(9, 'Dîner', 'Dîner maison à la table de l\'Ange', 'diner.png', '2021-07-26 08:43:22', '2021-07-26 08:43:22', 'my-slug'),
(10, 'Prise électrique', 'Recharger vos appreils électroniques sur votre parcours.', 'power.png', '2021-07-26 08:43:22', '2021-07-26 08:43:22', 'my-slug'),
(12, 'Feu de camp', 'Mise à disposition d\'un espace sécurisé pour faire un feu de camp', 'feu-de-camp.png', '2021-07-29 14:59:10', '2021-07-29 14:59:10', 'feu-de-camp');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `first_name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip_code` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `picture` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` int(11) DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `status` smallint(6) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `activation_token` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `first_name`, `last_name`, `email`, `password`, `city`, `zip_code`, `picture`, `phone_number`, `latitude`, `longitude`, `status`, `created_at`, `updated_at`, `roles`, `activation_token`) VALUES
(21, 'Margot', 'Daniel', 'dpruvost@sfr.fr', '$2y$13$/n7NpzmCMp8g2p9RaBrjwe.QoG24DLERDjjfrLPAP8Amltr3aStge', 'LUGARDE', '15190', 'margot-daniel.jpg', 173140533, 45.277018, 2.759346, 2, '2021-07-26 08:43:22', '2021-07-26 08:43:22', '[\"ROLE_USER\"]', NULL),
(22, 'Jean', 'Guilbert', 'martine.chartier@laposte.net', '$2y$13$vn5wnAD0UIPVVcvUCPVpSONyB2bW6Bgc4vHxRf75X0X2NtnUc5PFC', 'HoarauBourg', '51106', NULL, 17314053, NULL, NULL, 1, '2021-07-26 08:43:23', '2021-07-26 08:43:23', '[\"ROLE_USER\"]', NULL),
(23, 'Frédéric', 'Rossi', 'hamel.franck@brunet.com', '$2y$13$7FzrCLQX5vYyH7prytFdc.vABRJPOKsDe58aIKrHMgOhv8nIexMS.', 'LE CLAUX', '15400', NULL, 17314053, NULL, NULL, 1, '2021-07-26 08:43:23', '2021-07-26 08:43:23', '[\"ROLE_USER\"]', NULL),
(24, 'Céline', 'Leconte', 'georges44@boutin.com', '$2y$13$cgk2eNMxowRe4pdVb1FubeJkzISWgwY9a3H8gkPkSlZLxpqk5uqsW', 'Saint-Saturnin', '15190', 'cecile-lecomte.jpg', 173140533, 45.227, 2.798, 2, '2021-07-26 08:43:24', '2021-07-26 08:43:24', '[\"ROLE_USER\"]', NULL),
(25, 'Tristan', 'Hoarau', 'ines27@hotmail.fr', '$2y$13$BZI2p/Q80R7sgegwpc6LTe5U495d/CAegV4bsQGBQEaQpjR7XcmZq', 'LE CLAUX', '15400', 'tristan-hoarau.jpg', 173140534, 45.157885, 2.704844, 2, '2021-07-26 08:43:24', '2021-07-26 08:43:24', '[\"ROLE_USER\"]', NULL),
(26, 'Élodie', 'Leconte', 'julien.chauvin@sfr.fr', '$2y$13$7nPJSnNXXEqZq8yyT1WCMOAgvdgPN9BCGoiXqqL5FTinglsOBu9tq', 'GUISSENY', '29880', 'elodie-leconte.jpg', 173140535, 48.617214, -4.399634, 2, '2021-07-26 08:43:25', '2021-07-26 08:43:25', '[\"ROLE_USER\"]', NULL),
(27, 'Anouk', 'Delattre', 'irey@gmail.com', '$2y$13$Lydmqh3gXTCQVz2nUtinXeggV4jFwE14/ex6EzKog1gh0mSoUaK12', 'Da Silva-la-Forêt', '86054', NULL, 17314053, NULL, NULL, 1, '2021-07-26 08:43:25', '2021-07-26 08:43:25', '[\"ROLE_USER\"]', NULL),
(28, 'Christiane', 'Jean', 'eparent@cordier.fr', '$2y$13$k0EaiJGE0FKKTJ4NMEbRP.tpYR7RO92bM.B5bA1n1CB3ZzgvlBJj6', 'LANILDUT', '29840', 'christiane-jean.jpg', 173140536, 48.478632, -4.739105, 2, '2021-07-26 08:43:26', '2021-07-26 08:43:26', '[\"ROLE_USER\"]', NULL),
(29, 'Jacqueline', 'Mendes', 'dias.jeannine@club-internet.fr', '$2y$13$lwComqFnfVtyY0YQ3h/yHeIdY2G2vB00.t52oeER5s3kbxOJ4D6sa', 'Arnaud', '64851', NULL, 17314053, NULL, NULL, 1, '2021-07-26 08:43:26', '2021-07-26 08:43:26', '[\"ROLE_USER\"]', NULL),
(30, 'Anouk', 'Da Silva', 'henri.besnard@laposte.net', '$2y$13$rtOeJXRBZx9npSbnb/1jE.883JfDyG6XhNqANGMPkegGDbXYnlg7S', 'Mathieu', '58223', NULL, 17314053, NULL, NULL, 1, '2021-07-26 08:43:26', '2021-07-26 08:43:26', '[\"ROLE_USER\"]', NULL),
(31, 'Roger', 'Hamel', 'noel.jacqueline@club-internet.fr', '$2y$13$gUoKRcvLmlRnfZ/heJl5qONDMXW2HiE/Vm.ZCdQ3Bujo8kNH8p09m', 'Da Costa', '60400', NULL, 17314053, NULL, NULL, 1, '2021-07-26 08:43:27', '2021-07-26 08:43:27', '[\"ROLE_USER\"]', NULL),
(32, 'Alexandrie', 'Lacroix', 'hamel.maryse@lejeune.com', '$2y$13$xlui8JPcG7085GryXG/4ae6Cq.PKFu5jCa20KhT/W84gdujQ.WX3u', 'LucasVille', '34336', NULL, 17314053, NULL, NULL, 1, '2021-07-26 08:43:27', '2021-07-26 08:43:27', '[\"ROLE_USER\"]', NULL),
(33, 'François', 'Charles', 'clerc.xavier@allain.fr', '$2y$13$sterWnSUZi0fTaFlgkUHveA3TD3yMmELNZUVwByJWcCAL3DWOJhCW', 'Benardnec', '43960', NULL, 17314053, NULL, NULL, 1, '2021-07-26 08:43:28', '2021-07-26 08:43:28', '[\"ROLE_USER\"]', NULL),
(34, 'Matthieu', 'Garnier', 'ypeltier@tele2.fr', '$2y$13$jCIjLxb2g5UQxow3xGcHZeNmxwr/WjWZ265YHwgrFeaHcxMNdIdWS', 'GimenezVille', '59393', NULL, 17314053, NULL, NULL, 0, '2021-07-26 08:43:28', '2021-07-26 08:43:28', '[\"ROLE_USER\"]', NULL),
(35, 'Marine', 'Boulay', 'margaud06@jean.fr', '$2y$13$mYSHXG.GJaHmtidII6SuY.7lAVf90.uETtHsZYEOfOyLJTnEPUItS', 'Fournier-les-Bains', '52622', NULL, 17314053, NULL, NULL, 1, '2021-07-26 08:43:29', '2021-07-26 08:43:29', '[\"ROLE_USER\"]', NULL),
(36, 'Grégoire', 'Da Costa', 'etienne.bourgeois@aubry.com', '$2y$13$ImpZez3NzoH97OD62CoASOEjxY.X5N/vwIcViiYfZSe4wfTaBsWRm', 'LE CONQUET', '29217', 'gregoire-dacosta.jpg', 173140537, 48.356591, -4.76405, 2, '2021-07-26 08:43:29', '2021-07-26 08:43:29', '[\"ROLE_USER\"]', NULL),
(37, 'Jacques', 'Mallet', 'yrodriguez@bernier.fr', '$2y$13$HGQBQ6TywX/hnu/ZFXyfNO696ye0BdkThlzROfcq3PEec9AUKB5HK', 'SARE', '64310', 'jacques-mallet.jpg', 173140538, 43.311756, -1.576886, 2, '2021-07-26 08:43:30', '2021-07-26 08:43:30', '[\"ROLE_USER\"]', NULL),
(38, 'Roger', 'Joubert', 'alex97@tele2.fr', '$2y$13$x78B1tj4l9moLtnqLsMasu09bMamqedDH47QJIdAH6A/XI58t9l/a', 'BIDARRY', '64780', 'roger.jpg', 173140539, 43.2664, -1.347532, 2, '2021-07-26 08:43:30', '2021-07-26 08:43:30', '[\"ROLE_USER\"]', NULL),
(39, 'Manon', 'Marie', 'fperez@munoz.org', '$2y$13$UYY8Gg6iS4GCpenuvqLlUek0qprFCtwMPaUEo62OJZJ2AoG4sRoiy', 'SAINT-JEAN-PIED-DE-PORT', '64220', 'marie-manon.jpg', 173140531, 43.160233, -1.234526, 2, '2021-07-26 08:43:30', '2021-07-26 08:43:30', '[\"ROLE_USER\"]', NULL),
(40, 'Anne', 'Leleu', 'louise.royer@blanc.fr', '$2y$13$HiTgVncKBvTj02tEKl06lu3kdcbeViAkvAWjdSNmqz9VsyeCfNtF6', 'Germain', '58569', NULL, 17314053, NULL, NULL, 0, '2021-07-26 08:43:31', '2021-07-26 08:43:31', '[\"ROLE_USER\"]', NULL),
(45, 'Timothy', 'Gomis', 'tim@tim.fr', '$2y$13$k.57Oh7FFcu9..q.WFgVHevskijhEUrkEHsnXYBg/YZPpBdOx.mVq', 'Saint-Denis', '97490', 'timothy.jpg', 692222222, NULL, NULL, 1, '2021-07-28 11:18:52', '2021-07-28 11:18:52', '[\"ROLE_USER\",\"ROLE_ADMIN\"]', NULL),
(48, 'Daniel', 'BERTHIER', 'berthida34@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$3//XBOTahJzy7IcotVGd5g$pnM9aMsxsq/ZVEIv/XgmHGNQNpzGxhDbvvQOq/kVLs4', 'Bois-Ratier', '18290', 'avatar.png', 658012358, 46.962027, 2.214285, 2, '2021-07-30 10:38:32', '2021-07-30 10:38:32', '[\"ROLE_USER\",\"ROLE_ADMIN\"]', NULL),
(52, 'Arnaud', 'Testeur', 'goham28968@aline9.com', '$2y$13$ZwPNfUAPgpgGbZTTalcKZObw8zDEJ7IbdjFrQPUAn6C3gCj1CubNm', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-07-30 20:39:55', '2021-07-30 20:39:55', '[]', NULL),
(53, 'Aimerick', 'FERAL', 'feralaimerick@gmail.com', '$2y$13$9zjMrCFHH76ZV8dbHRlFVuE3RGVbhJHbTQc5Rj6huLAShsXXzquUm', NULL, NULL, 'avatar-200x200.png', NULL, NULL, NULL, 1, '2021-07-31 10:28:53', '2021-07-31 10:28:53', '[\"ROLE_USER\",\"ROLE_ADMIN\"]', NULL),
(54, 'Esteban', 'Berthier', 'berthier.est@gmail.com', '$2y$13$0s/NqNd2yM26F6AhWXzbSOoTOqk.Zlxavu2L338/CtST/027WEY6G', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-07-31 14:01:03', '2021-07-31 14:01:03', '[]', NULL),
(55, 'Alex', 'Dupont', 'alexadmin@rando-relais.fr', '$argon2id$v=19$m=65536,t=4,p=1$2kTuN2KINQJDvewP6Bn7ag$LDc+sWZKEZRFBOi51FuyrUWxCX4Rl8hfXSsNb2fXie4', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-08-02 10:02:24', '2021-08-02 10:02:24', '[\"ROLE_USER\",\"ROLE_ADMIN\"]', NULL),
(79, 'Larry', 'BAMBELLE', 'test300721@gmail.com', '$2y$13$Fw5FN6Iu2Ml0J9Q5hxtX2.l5DSizsOqEoSckzUjSlaeaocag8zDf2', NULL, NULL, 'Jean-Marcheur.png', NULL, NULL, NULL, 1, '2021-08-06 16:44:17', '2021-08-06 16:44:17', '[]', NULL),
(80, 'Isabelle', 'BOUET-WILLAUMEZ', 'isabelle.bw@orange.fr', '$argon2id$v=19$m=65536,t=4,p=1$gAg0veX/7tfQkv8xP6lbpA$YxlEDJXNVqZGeQps6fx1idH+AHqn/SXIMtRZ0AnsTFw', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-08-06 20:42:47', '2021-08-06 20:42:47', '[]', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `user_service`
--

CREATE TABLE `user_service` (
  `user_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user_service`
--

INSERT INTO `user_service` (`user_id`, `service_id`) VALUES
(21, 4),
(21, 5),
(21, 10),
(22, 10),
(23, 10),
(24, 3),
(24, 6),
(24, 7),
(24, 8),
(25, 1),
(25, 4),
(25, 6),
(26, 3),
(26, 7),
(26, 10),
(27, 10),
(28, 5),
(28, 8),
(28, 10),
(29, 10),
(30, 10),
(31, 10),
(32, 10),
(33, 10),
(34, 10),
(35, 10),
(36, 1),
(36, 8),
(37, 1),
(37, 4),
(37, 6),
(37, 10),
(38, 2),
(38, 4),
(38, 5),
(38, 6),
(38, 9),
(38, 10),
(39, 1),
(39, 4),
(39, 6),
(39, 8),
(39, 10),
(40, 10),
(48, 1),
(48, 4);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `reset_password_request`
--
ALTER TABLE `reset_password_request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_7CE748AA76ED395` (`user_id`);

--
-- Index pour la table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_794381C6A76ED395` (`user_id`);

--
-- Index pour la table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- Index pour la table `user_service`
--
ALTER TABLE `user_service`
  ADD PRIMARY KEY (`user_id`,`service_id`),
  ADD KEY `IDX_B99084D8A76ED395` (`user_id`),
  ADD KEY `IDX_B99084D8ED5CA9E6` (`service_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `reset_password_request`
--
ALTER TABLE `reset_password_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `review`
--
ALTER TABLE `review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT pour la table `service`
--
ALTER TABLE `service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `reset_password_request`
--
ALTER TABLE `reset_password_request`
  ADD CONSTRAINT `FK_7CE748AA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `FK_794381C6A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `user_service`
--
ALTER TABLE `user_service`
  ADD CONSTRAINT `FK_B99084D8A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_B99084D8ED5CA9E6` FOREIGN KEY (`service_id`) REFERENCES `service` (`id`) ON DELETE CASCADE;