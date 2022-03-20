-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : Dim 20 mars 2022 à 23:30
-- Version du serveur :  10.4.17-MariaDB
-- Version de PHP : 7.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ftf1`
--

-- --------------------------------------------------------

--
-- Structure de la table `arbitre`
--

CREATE TABLE `arbitre` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `id_role` int(11) NOT NULL,
  `image` varchar(100) NOT NULL,
  `age` int(11) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `arbitre`
--

INSERT INTO `arbitre` (`id`, `nom`, `prenom`, `id_role`, `image`, `age`, `email`) VALUES
(1, 'selmi ', 'sadek', 2, 'C:\\Users\\moham\\Desktop\\equipe\\src\\Images\\khalil2.png', 55, 'fjfjfy'),
(2, 'srayri', 'youssef', 3, 'C:\\Users\\moham\\Desktop\\equipe\\src\\Images\\aymen2.png', 22, 'rr@esprit.tn'),
(3, 'guirat', 'haythem', 2, 'C:\\Users\\moham\\Desktop\\equipe\\src\\Images\\houssemGui.PNG', 12, '2'),
(4, 'hosni', 'naim', 2, 'C:\\Users\\moham\\Desktop\\equipe\\src\\Images\\hosni.jpg', 12, '2'),
(6, 'houssem', 'charef', 4, '1223', 12, '20');

-- --------------------------------------------------------

--
-- Structure de la table `avis`
--

CREATE TABLE `avis` (
  `id_avis` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_produit` int(11) NOT NULL,
  `avis` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `avis`
--

INSERT INTO `avis` (`id_avis`, `id_user`, `id_produit`, `avis`) VALUES
(13, 91, 46, 4),
(14, 91, 49, 3),
(15, 89, 46, 3),
(16, 89, 51, 4);

-- --------------------------------------------------------

--
-- Structure de la table `billet`
--

CREATE TABLE `billet` (
  `id` int(11) NOT NULL,
  `id_match` int(11) NOT NULL,
  `bloc` varchar(500) NOT NULL,
  `prix` float NOT NULL,
  `id_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `billet`
--

INSERT INTO `billet` (`id`, `id_match`, `bloc`, `prix`, `id_user`) VALUES
(7, 27343, 'B', 25, 89);

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id`, `nom`) VALUES
(4, 'Maillot'),
(5, 'Short'),
(6, 'Casquette'),
(7, 'Bande');

-- --------------------------------------------------------

--
-- Structure de la table `classment`
--

CREATE TABLE `classment` (
  `id_classment` int(11) NOT NULL,
  `id_equipe` int(11) NOT NULL,
  `nb_totale_but` int(11) NOT NULL DEFAULT 0,
  `nb_totale_but_recu` int(11) NOT NULL DEFAULT 0,
  `nb_point` int(11) NOT NULL DEFAULT 0,
  `saison` varchar(8) NOT NULL,
  `nb_win` int(11) NOT NULL DEFAULT 0,
  `nb_draw` int(11) NOT NULL DEFAULT 0,
  `nb_lose` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `classment`
--

INSERT INTO `classment` (`id_classment`, `id_equipe`, `nb_totale_but`, `nb_totale_but_recu`, `nb_point`, `saison`, `nb_win`, `nb_draw`, `nb_lose`) VALUES
(1, 3, 0, 0, 0, '20212022', 0, 0, 0),
(2, 26, 0, 0, 0, '20212022', 0, 0, 0),
(3, 28, 0, 0, 0, '20212022', 0, 0, 0),
(4, 29, 0, 0, 0, '20212022', 0, 0, 0),
(5, 30, 0, 0, 0, '20212022', 0, 0, 0),
(6, 31, 0, 0, 0, '20212022', 0, 0, 0),
(7, 32, 0, 0, 0, '20212022', 0, 0, 0),
(8, 33, 0, 0, 0, '20212022', 0, 0, 0),
(9, 3, 0, 0, 0, '20202021', 0, 0, 0),
(10, 26, 0, 0, 0, '20202021', 0, 0, 0),
(11, 28, 0, 0, 0, '20202021', 0, 0, 0),
(12, 29, 0, 0, 0, '20202021', 0, 0, 0),
(13, 30, 0, 0, 0, '20202021', 0, 0, 0),
(14, 31, 0, 0, 0, '20202021', 0, 0, 0),
(15, 32, 0, 0, 0, '20202021', 0, 0, 0),
(16, 33, 0, 0, 0, '20202021', 0, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `equipe`
--

CREATE TABLE `equipe` (
  `id` int(11) NOT NULL,
  `nomeq` varchar(100) NOT NULL,
  `logo` varchar(100) NOT NULL,
  `nom_entreneur` varchar(100) NOT NULL,
  `niveau` varchar(100) NOT NULL,
  `stade` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `equipe`
--

INSERT INTO `equipe` (`id`, `nomeq`, `logo`, `nom_entreneur`, `niveau`, `stade`) VALUES
(3, 'ess', 'C:\\Users\\moham\\Desktop\\equipe\\src\\Images\\ess.png', 'lassad jarda', 'ligue1', 'sousse'),
(26, 'css', 'C:\\Users\\moham\\Desktop\\equipe\\src\\Images\\css.gif', 'lili chiheb', 'ligue1', 'taieb mhiri'),
(28, 'ca', 'C:\\Users\\moham\\Desktop\\equipe\\src\\Images\\ca.png', 'louhichi', 'ligue1', 'Rades'),
(29, 'est', 'C:\\Users\\moham\\Desktop\\equipe\\src\\Images\\est.png', 'jaydi radhi', 'ligue1', 'Menzah'),
(30, 'usm', 'C:\\Users\\moham\\Desktop\\equipe\\src\\Images\\Usm.png', 'benzarti', 'ligue1', 'stade de monastir'),
(31, 'esz', 'C:\\Users\\moham\\Desktop\\equipe\\src\\Images\\zarzis.png', 'mondher kbayer', 'ligue1', 'stade zarzis'),
(32, 'ST', 'C:\\Users\\moham\\Desktop\\equipe\\src\\Images\\stadetunisien.png', 'chaabani', 'ligue1', 'stade tunis'),
(33, 'cab', 'C:\\Users\\moham\\Desktop\\equipe\\src\\Images\\cabb.png', 'mejdi traoui', 'ligue1', '15October');

-- --------------------------------------------------------

--
-- Structure de la table `joueur`
--

CREATE TABLE `joueur` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `poste` varchar(100) NOT NULL,
  `nationalite` varchar(100) NOT NULL,
  `date_naiss` date NOT NULL,
  `taille` float NOT NULL,
  `poids` float NOT NULL,
  `image` varchar(200) NOT NULL,
  `id_equipe` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `joueur`
--

INSERT INTO `joueur` (`id`, `nom`, `prenom`, `poste`, `nationalite`, `date_naiss`, `taille`, `poids`, `image`, `id_equipe`) VALUES
(14, 'khazri', 'wahbi', 'attaquant', 'tunisien', '2022-01-06', 1.82, 80, 'C:\\Users\\moham\\Desktop\\equipe\\src\\Images\\khazri.jpg', 3),
(18, 'ifa', 'bilel', 'defenseur', 'tunisien', '1987-03-10', 180, 80, 'C:\\Users\\moham\\Desktop\\equipe\\src\\Images\\ifa.png', 28),
(19, 'chamakhi', 'yassine', 'attaquant', 'tunisienne', '1992-03-12', 165, 70, 'C:\\Users\\moham\\Desktop\\equipe\\src\\Images\\yassine.jpg', 28),
(20, 'khalifa', 'saber', 'attaquant', 'tunisienne', '1986-03-10', 183, 80, 'C:\\Users\\moham\\Desktop\\equipe\\src\\Images\\saber.png', 28),
(21, 'lahmer', 'hamza', 'milieu', 'tunisien', '1992-05-22', 172, 77, 'C:\\Users\\moham\\Desktop\\equipe\\src\\Images\\hamza.jpg', 28),
(22, 'coulibali', 'fossini', 'mileu', 'cote dvoire', '1990-01-10', 190, 90, 'C:\\Users\\moham\\Desktop\\equipe\\src\\Images\\colibali.png.crdownload', 29),
(23, 'elhouni', 'hamdou', 'attaquant', 'libyien', '1991-03-16', 170, 75, 'C:\\Users\\moham\\Desktop\\equipe\\src\\Images\\elhouni.jpg', 29),
(24, 'chamam', 'khelil', 'defenseur', 'tunisien', '1986-08-16', 183, 85, 'C:\\Users\\moham\\Desktop\\equipe\\src\\Images\\chamam.jpg', 29),
(25, 'rjaibi', 'adam', 'attaquant', 'tunisien', '1991-10-10', 160, 70, 'C:\\Users\\moham\\Desktop\\equipe\\src\\Images\\adam.jpg', 33),
(26, 'bguir', 'saad', 'attaquant', 'tunisien', '1993-07-07', 180, 76, 'C:\\Users\\moham\\Desktop\\equipe\\src\\Images\\bguir.png', 33),
(27, 'msakni', 'youssef', 'attaquant', 'tunisien', '1991-06-12', 175, 80, 'C:\\Users\\moham\\Desktop\\equipe\\src\\Images\\msakni.png', 26),
(28, 'maaloul', 'ali', 'defenseur', 'tunisien', '1989-02-09', 177, 73, 'C:\\Users\\moham\\Desktop\\equipe\\src\\Images\\ali.png', 26),
(29, 'jaziri', 'saif', 'attaquant', 'tunisien', '1992-01-21', 176, 74, 'C:\\Users\\moham\\Desktop\\equipe\\src\\Images\\saifff.jpg', 26),
(30, 'amri', 'ali', 'milieu', 'tunisien', '1989-03-18', 183, 90, 'C:\\Users\\moham\\Desktop\\equipe\\src\\Images\\amri.jpg', 30),
(31, 'kom', 'frank', 'milieu', 'cameron', '1989-01-07', 188, 98, 'C:\\Users\\moham\\Desktop\\equipe\\src\\Images\\frankom.png', 30);

-- --------------------------------------------------------

--
-- Structure de la table `matchjoueur`
--

CREATE TABLE `matchjoueur` (
  `id` int(11) NOT NULL,
  `id_joueur` int(11) NOT NULL,
  `id_match` int(11) NOT NULL,
  `carton_jaune` int(11) NOT NULL,
  `carton_rouge` int(11) NOT NULL,
  `nb_but` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `matchjoueur`
--

INSERT INTO `matchjoueur` (`id`, `id_joueur`, `id_match`, `carton_jaune`, `carton_rouge`, `nb_but`) VALUES
(2, 28, 27331, 0, 1, 3);

-- --------------------------------------------------------

--
-- Structure de la table `matchs`
--

CREATE TABLE `matchs` (
  `id` int(11) NOT NULL,
  `equipe1` int(11) NOT NULL,
  `equipe2` int(11) NOT NULL,
  `nb_but1` int(11) NOT NULL,
  `nb_but2` int(11) NOT NULL,
  `stade` varchar(100) NOT NULL DEFAULT '',
  `id_arbitre1` int(11) DEFAULT NULL,
  `id_arbitre2` int(11) DEFAULT NULL,
  `id_arbitre3` int(11) DEFAULT NULL,
  `id_arbitre4` int(11) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `nb_spectateur` int(11) NOT NULL,
  `saison` varchar(8) NOT NULL,
  `round` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `matchs`
--

INSERT INTO `matchs` (`id`, `equipe1`, `equipe2`, `nb_but1`, `nb_but2`, `stade`, `id_arbitre1`, `id_arbitre2`, `id_arbitre3`, `id_arbitre4`, `date`, `nb_spectateur`, `saison`, `round`) VALUES
(27330, 3, 33, -1, -1, 'sousse', 1, 2, 3, 4, '2022-03-01 23:00:00', 10000, '20202021', 1),
(27331, 26, 32, -1, -1, 'taieb mhiri', 1, 2, 3, 4, '2022-03-01 23:00:00', 10000, '20202021', 1),
(27332, 28, 31, -1, -1, 'Rades', 1, 2, 3, 4, '2022-03-02 01:00:00', 10000, '20202021', 1),
(27333, 29, 30, -1, -1, 'Menzah', 1, 2, 3, 4, '2022-03-02 03:00:00', 10000, '20202021', 1),
(27334, 3, 32, -1, -1, 'sousse', 1, 2, 3, 4, '2022-03-08 23:00:00', 10000, '20202021', 2),
(27335, 33, 31, -1, -1, 'stade bizerte', 1, 2, 3, 4, '2022-03-08 23:00:00', 10000, '20202021', 2),
(27336, 26, 30, -1, -1, 'taieb mhiri', 1, 2, 3, 4, '2022-03-09 01:00:00', 10000, '20202021', 2),
(27337, 28, 29, -1, -1, 'Rades', 1, 2, 3, 4, '2022-03-09 03:00:00', 10000, '20202021', 2),
(27338, 3, 31, -1, -1, 'sousse', 1, 2, 3, 4, '2022-03-15 23:00:00', 10000, '20202021', 3),
(27339, 32, 30, -1, -1, 'stade tunis', 1, 2, 3, 4, '2022-03-15 23:00:00', 10000, '20202021', 3),
(27340, 33, 29, -1, -1, 'stade bizerte', 1, 2, 3, 4, '2022-03-16 01:00:00', 10000, '20202021', 3),
(27341, 26, 28, -1, -1, 'taieb mhiri', 1, 2, 3, 4, '2022-03-16 03:00:00', 10000, '20202021', 3),
(27342, 3, 30, -1, -1, 'sousse', 1, 2, 3, 4, '2022-03-22 23:00:00', 10000, '20202021', 4),
(27343, 31, 29, -1, -1, 'stade zarzis', 1, 2, 3, 4, '2022-03-22 23:00:00', 10000, '20202021', 4),
(27344, 32, 28, -1, -1, 'stade tunis', 1, 2, 3, 4, '2022-03-23 01:00:00', 10000, '20202021', 4),
(27345, 33, 26, -1, -1, 'stade bizerte', 1, 2, 3, 4, '2022-03-23 03:00:00', 10000, '20202021', 4),
(27346, 3, 29, -1, -1, 'sousse', 1, 2, 3, 4, '2022-03-29 23:00:00', 10000, '20202021', 5),
(27347, 30, 28, -1, -1, 'stade de monastir', 1, 2, 3, 4, '2022-03-29 23:00:00', 10000, '20202021', 5),
(27348, 31, 26, -1, -1, 'stade zarzis', 1, 2, 3, 4, '2022-03-30 01:00:00', 10000, '20202021', 5),
(27349, 32, 33, -1, -1, 'stade tunis', 1, 2, 3, 4, '2022-03-30 03:00:00', 10000, '20202021', 5),
(27350, 3, 28, -1, -1, 'sousse', 1, 2, 3, 4, '2022-04-05 23:00:00', 10000, '20202021', 6),
(27351, 29, 26, -1, -1, 'Menzah', 1, 2, 3, 4, '2022-04-05 23:00:00', 10000, '20202021', 6),
(27352, 30, 33, -1, -1, 'stade de monastir', 1, 2, 3, 4, '2022-04-06 01:00:00', 10000, '20202021', 6),
(27353, 31, 32, -1, -1, 'stade zarzis', 1, 2, 3, 4, '2022-04-06 03:00:00', 10000, '20202021', 6),
(27354, 3, 26, -1, -1, 'sousse', 1, 2, 3, 4, '2022-04-12 23:00:00', 10000, '20202021', 7),
(27355, 28, 33, -1, -1, 'Rades', 1, 2, 3, 4, '2022-04-12 23:00:00', 10000, '20202021', 7),
(27356, 29, 32, -1, -1, 'Menzah', 1, 2, 3, 4, '2022-04-13 01:00:00', 10000, '20202021', 7),
(27357, 30, 31, -1, -1, 'stade de monastir', 1, 2, 3, 4, '2022-04-13 03:00:00', 10000, '20202021', 7),
(27358, 31, 30, -1, -1, 'stade de monastir', 1, 2, 3, 4, '2022-08-31 03:00:00', 10000, '20202021', 14),
(27359, 32, 29, -1, -1, 'Menzah', 1, 2, 3, 4, '2022-08-31 01:00:00', 10000, '20202021', 14),
(27360, 33, 28, -1, -1, 'Rades', 1, 2, 3, 4, '2022-08-30 23:00:00', 10000, '20202021', 14),
(27361, 26, 3, -1, -1, 'sousse', 1, 2, 3, 4, '2022-08-30 23:00:00', 10000, '20202021', 14),
(27362, 32, 31, -1, -1, 'stade zarzis', 1, 2, 3, 4, '2022-08-24 03:00:00', 10000, '20202021', 13),
(27363, 33, 30, -1, -1, 'stade de monastir', 1, 2, 3, 4, '2022-08-24 01:00:00', 10000, '20202021', 13),
(27364, 26, 29, -1, -1, 'Menzah', 1, 2, 3, 4, '2022-08-23 23:00:00', 10000, '20202021', 13),
(27365, 28, 3, -1, -1, 'sousse', 1, 2, 3, 4, '2022-08-23 23:00:00', 10000, '20202021', 13),
(27366, 33, 32, -1, -1, 'stade tunis', 1, 2, 3, 4, '2022-08-17 03:00:00', 10000, '20202021', 12),
(27367, 26, 31, -1, -1, 'stade zarzis', 1, 2, 3, 4, '2022-08-17 01:00:00', 10000, '20202021', 12),
(27368, 28, 30, -1, -1, 'stade de monastir', 1, 2, 3, 4, '2022-08-16 23:00:00', 10000, '20202021', 12),
(27369, 29, 3, -1, -1, 'sousse', 1, 2, 3, 4, '2022-08-16 23:00:00', 10000, '20202021', 12),
(27370, 26, 33, -1, -1, 'stade bizerte', 1, 2, 3, 4, '2022-08-10 03:00:00', 10000, '20202021', 11),
(27371, 28, 32, -1, -1, 'stade tunis', 1, 2, 3, 4, '2022-08-10 01:00:00', 10000, '20202021', 11),
(27372, 29, 31, -1, -1, 'stade zarzis', 1, 2, 3, 4, '2022-08-09 23:00:00', 10000, '20202021', 11),
(27373, 30, 3, -1, -1, 'sousse', 1, 2, 3, 4, '2022-08-09 23:00:00', 10000, '20202021', 11),
(27374, 28, 26, -1, -1, 'taieb mhiri', 1, 2, 3, 4, '2022-08-03 03:00:00', 10000, '20202021', 10),
(27375, 29, 33, -1, -1, 'stade bizerte', 1, 2, 3, 4, '2022-08-03 01:00:00', 10000, '20202021', 10),
(27376, 30, 32, -1, -1, 'stade tunis', 1, 2, 3, 4, '2022-08-02 23:00:00', 10000, '20202021', 10),
(27377, 31, 3, -1, -1, 'sousse', 1, 2, 3, 4, '2022-08-02 23:00:00', 10000, '20202021', 10),
(27378, 29, 28, -1, -1, 'Rades', 1, 2, 3, 4, '2022-07-27 03:00:00', 10000, '20202021', 9),
(27379, 30, 26, -1, -1, 'taieb mhiri', 1, 2, 3, 4, '2022-07-27 01:00:00', 10000, '20202021', 9),
(27380, 31, 33, -1, -1, 'stade bizerte', 1, 2, 3, 4, '2022-07-26 23:00:00', 10000, '20202021', 9),
(27381, 32, 3, -1, -1, 'sousse', 1, 2, 3, 4, '2022-07-26 23:00:00', 10000, '20202021', 9),
(27382, 30, 29, -1, -1, 'Menzah', 1, 2, 3, 4, '2022-07-20 03:00:00', 10000, '20202021', 8),
(27383, 31, 28, -1, -1, 'Rades', 1, 2, 3, 4, '2022-07-20 01:00:00', 10000, '20202021', 8),
(27384, 32, 26, -1, -1, 'taieb mhiri', 1, 2, 3, 4, '2022-07-19 23:00:00', 10000, '20202021', 8),
(27385, 33, 3, -1, -1, 'sousse', 1, 2, 3, 4, '2022-07-19 23:00:00', 10000, '20202021', 8);

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `state` varchar(20) NOT NULL DEFAULT 'pending',
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `state`, `date`) VALUES
(99, 91, 'Placed', '2022-03-09'),
(100, 91, 'pending', '2022-03-09'),
(101, 89, 'Placed', '2022-03-10'),
(102, 89, 'Placed', '2022-03-10'),
(103, 89, 'pending', '2022-03-10');

-- --------------------------------------------------------

--
-- Structure de la table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`) VALUES
(278, 99, 50, 2),
(279, 101, 46, 1),
(281, 102, 46, 1),
(282, 102, 51, 1),
(285, 103, 46, 1);

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE `produit` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `image` varchar(500) NOT NULL,
  `prix` float NOT NULL,
  `description` varchar(500) NOT NULL,
  `id_cat` int(11) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id`, `nom`, `image`, `prix`, `description`, `id_cat`, `stock`, `code`) VALUES
(46, 'short', 'C:\\Users\\moham\\Desktop\\equipe\\src\\Images\\SHORT KOMBAT RYDER TUNISIE BLANC HOMME.png', 20, 'maillot', 5, 160, 0),
(49, 'short', 'C:\\Users\\moham\\Desktop\\equipe\\src\\Images\\SHORT ARAWA TUNISIE NOIR HOMME.png', 20, 'short', 5, 80, 0),
(51, 'Maillot', 'C:\\Users\\moham\\Desktop\\equipe\\src\\Images\\MAILLOT KOMBAT PRO 2022 HOME TUNISIE ROUGE.png', 40, 'mailot', 4, 100, 51072),
(52, 'survetements', 'C:\\Users\\moham\\Desktop\\equipe\\src\\Images\\SURVÊTEMENT ASTEOD TUNISIE NOIR HOMME.png', 80, 'survettements', 5, 70, 52072),
(53, 'test', 'C:\\Users\\moham\\Desktop\\equipe\\src\\Images\\T-SHIRT ARARI SLIM TUNISIE NOIR HOMME.png', 20, 'test', 6, 0, 53072);

-- --------------------------------------------------------

--
-- Structure de la table `role_arbitre`
--

CREATE TABLE `role_arbitre` (
  `id` int(11) NOT NULL,
  `role` varchar(100) NOT NULL,
  `description` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `role_arbitre`
--

INSERT INTO `role_arbitre` (`id`, `role`, `description`) VALUES
(2, 'arbitre1', 'arb1'),
(3, 'juge1', 'juge'),
(4, 'juge2', 'juge');

-- --------------------------------------------------------

--
-- Structure de la table `taille`
--

CREATE TABLE `taille` (
  `id` int(255) NOT NULL,
  `nom` varchar(500) NOT NULL,
  `id_produit` int(11) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `taille`
--

INSERT INTO `taille` (`id`, `nom`, `id_produit`, `stock`) VALUES
(15, 'XL', 46, 50),
(16, 'm', 46, 20),
(17, 'S', 46, 20),
(18, 'L', 50, 20);

-- --------------------------------------------------------

--
-- Structure de la table `transfert`
--

CREATE TABLE `transfert` (
  `id` int(11) NOT NULL,
  `id_ancieneq` int(11) NOT NULL,
  `id_nouveaueq` int(11) NOT NULL,
  `id_joueur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `transfert`
--

INSERT INTO `transfert` (`id`, `id_ancieneq`, `id_nouveaueq`, `id_joueur`) VALUES
(1, 3, 28, 21);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `tel` int(11) NOT NULL,
  `ban` tinyint(1) NOT NULL DEFAULT 0,
  `block` date DEFAULT NULL,
  `forgetpassCode` varchar(50) DEFAULT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `nom`, `prenom`, `email`, `pass`, `tel`, `ban`, `block`, `forgetpassCode`, `role`) VALUES
(85, 'admin', '2020', 'admin@esprit.tn', '4a7d1ed414474e4033ac29ccb8653d9b', 7775862, 1, '2022-03-03', NULL, 'user'),
(89, 'Aouichaoui', 'hamdi', 'hamdi.aouichaoui@esprit.tn', '81dc9bdb52d04dc20036dbd8313ed055', 785566, 0, NULL, NULL, 'user'),
(91, 'houssemcharef', 'amine', 'charef.houssem@esprit.tn', '4a7d1ed414474e4033ac29ccb8653d9b', 5566225, 0, NULL, NULL, 'admin');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `arbitre`
--
ALTER TABLE `arbitre`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_role` (`id_role`);

--
-- Index pour la table `avis`
--
ALTER TABLE `avis`
  ADD PRIMARY KEY (`id_avis`),
  ADD KEY `fk_avis` (`id_produit`),
  ADD KEY `fk_user` (`id_user`);

--
-- Index pour la table `billet`
--
ALTER TABLE `billet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `forien_key` (`id_match`),
  ADD KEY `user_fk` (`id_user`);

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `classment`
--
ALTER TABLE `classment`
  ADD PRIMARY KEY (`id_classment`),
  ADD KEY `equipe_classment` (`id_equipe`);

--
-- Index pour la table `equipe`
--
ALTER TABLE `equipe`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `joueur`
--
ALTER TABLE `joueur`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_equipe` (`id_equipe`);

--
-- Index pour la table `matchjoueur`
--
ALTER TABLE `matchjoueur`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_joueur` (`id_joueur`),
  ADD KEY `id_match` (`id_match`);

--
-- Index pour la table `matchs`
--
ALTER TABLE `matchs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `arbitre_FK2` (`id_arbitre2`),
  ADD KEY `arbitre_FK3` (`id_arbitre3`),
  ADD KEY `arbitre_FK4` (`id_arbitre4`),
  ADD KEY `arbitre_FK1` (`id_arbitre1`),
  ADD KEY `equipe_FK1` (`equipe1`),
  ADD KEY `equipe_FK2` (`equipe2`);

--
-- Index pour la table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_user_FK` (`user_id`);

--
-- Index pour la table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_ibfk_1` (`order_id`);

--
-- Index pour la table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk` (`id_cat`);

--
-- Index pour la table `role_arbitre`
--
ALTER TABLE `role_arbitre`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `taille`
--
ALTER TABLE `taille`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fx_produit` (`id_produit`);

--
-- Index pour la table `transfert`
--
ALTER TABLE `transfert`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_ancieneq` (`id_ancieneq`),
  ADD KEY `id_nouveaueq` (`id_nouveaueq`),
  ADD KEY `id_joueur` (`id_joueur`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `t_unique` (`tel`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `arbitre`
--
ALTER TABLE `arbitre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `avis`
--
ALTER TABLE `avis`
  MODIFY `id_avis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `billet`
--
ALTER TABLE `billet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `classment`
--
ALTER TABLE `classment`
  MODIFY `id_classment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `equipe`
--
ALTER TABLE `equipe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT pour la table `joueur`
--
ALTER TABLE `joueur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT pour la table `matchjoueur`
--
ALTER TABLE `matchjoueur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `matchs`
--
ALTER TABLE `matchs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27386;

--
-- AUTO_INCREMENT pour la table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT pour la table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=286;

--
-- AUTO_INCREMENT pour la table `produit`
--
ALTER TABLE `produit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT pour la table `role_arbitre`
--
ALTER TABLE `role_arbitre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `taille`
--
ALTER TABLE `taille`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `transfert`
--
ALTER TABLE `transfert`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `arbitre`
--
ALTER TABLE `arbitre`
  ADD CONSTRAINT `arbitre_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `role_arbitre` (`id`) ON UPDATE NO ACTION;

--
-- Contraintes pour la table `avis`
--
ALTER TABLE `avis`
  ADD CONSTRAINT `fk_avis` FOREIGN KEY (`id_produit`) REFERENCES `produit` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Contraintes pour la table `billet`
--
ALTER TABLE `billet`
  ADD CONSTRAINT `forien_key` FOREIGN KEY (`id_match`) REFERENCES `matchs` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_fk` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Contraintes pour la table `classment`
--
ALTER TABLE `classment`
  ADD CONSTRAINT `equipe_classment` FOREIGN KEY (`id_equipe`) REFERENCES `equipe` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Contraintes pour la table `joueur`
--
ALTER TABLE `joueur`
  ADD CONSTRAINT `joueur_ibfk_1` FOREIGN KEY (`id_equipe`) REFERENCES `equipe` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Contraintes pour la table `matchjoueur`
--
ALTER TABLE `matchjoueur`
  ADD CONSTRAINT `matchjoueur_ibfk_1` FOREIGN KEY (`id_joueur`) REFERENCES `joueur` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `matchjoueur_ibfk_2` FOREIGN KEY (`id_match`) REFERENCES `matchs` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Contraintes pour la table `matchs`
--
ALTER TABLE `matchs`
  ADD CONSTRAINT `arbitre_FK1` FOREIGN KEY (`id_arbitre1`) REFERENCES `arbitre` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `arbitre_FK2` FOREIGN KEY (`id_arbitre2`) REFERENCES `arbitre` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `arbitre_FK3` FOREIGN KEY (`id_arbitre3`) REFERENCES `arbitre` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `arbitre_FK4` FOREIGN KEY (`id_arbitre4`) REFERENCES `arbitre` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `equipe_FK1` FOREIGN KEY (`equipe1`) REFERENCES `equipe` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `equipe_FK2` FOREIGN KEY (`equipe2`) REFERENCES `equipe` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Contraintes pour la table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `order_user_FK` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Contraintes pour la table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `produit`
--
ALTER TABLE `produit`
  ADD CONSTRAINT `fk` FOREIGN KEY (`id_cat`) REFERENCES `categorie` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Contraintes pour la table `transfert`
--
ALTER TABLE `transfert`
  ADD CONSTRAINT `transfert_ibfk_1` FOREIGN KEY (`id_ancieneq`) REFERENCES `equipe` (`id`),
  ADD CONSTRAINT `transfert_ibfk_2` FOREIGN KEY (`id_nouveaueq`) REFERENCES `equipe` (`id`),
  ADD CONSTRAINT `transfert_ibfk_3` FOREIGN KEY (`id_joueur`) REFERENCES `joueur` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
