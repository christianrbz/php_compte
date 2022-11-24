-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 24 nov. 2022 à 08:35
-- Version du serveur : 5.7.36
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `php_compte`
--

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

DROP TABLE IF EXISTS `membre`;
CREATE TABLE IF NOT EXISTS `membre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `lastname` varchar(70) NOT NULL,
  `firstname` varchar(70) NOT NULL,
  `email` varchar(255) NOT NULL,
  `status` enum('user','admin') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `membre`
--

INSERT INTO `membre` (`id`, `username`, `password`, `lastname`, `firstname`, `email`, `status`) VALUES
(1, 'Pseudo', '$2y$10$YVRfkYSunTd1cNx3Vf7Kfewiik23wWpycuF4KNv/1DWuyxgCD.CvC', 'Reubrez', 'Christian', 'christian@gmail.com', 'admin'),
(2, 'Random', '$2y$10$lwre4LlloOZ2ndxSZvZhSeb3Hq7jEehXavMYj7HWuWwQxxl31u8wq', 'Salengro', 'Roger', 'exemple@gmail.com', 'user'),
(3, 'Nyme', '$2y$10$OEZY0MLEPSaj.kiep8dSquqllWK2iXAOuHhq3ANiCyU1N8hBDENee', 'Donat', 'Maurice', 'email@gmail.com', 'user'),
(4, 'Alea', '$2y$10$x0ktcvc8K3EkjoMr2yCRE.QoO4eZH3C22Jold9iopDEJJ6eajcMFm', 'Hugo', 'Victor', 'contact@gmail.com', 'user'),
(5, 'Pseudonyme', '$2y$10$N3F0x0zGRGofqq2l/5F2L.DURLRsKKPGSLJbKn8m.H7k2g/FBjgCG', 'Lambda', 'Charles', 'bonjour@gmail.com', 'user');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
