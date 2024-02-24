-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 24, 2024 at 11:07 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4
drop database if exists bienesraices_crud;
create database bienesraices_crud;
use bienesraices_crud;


SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bienesraices_crud`
--

-- --------------------------------------------------------

--
-- Table structure for table `propiedades`
--

CREATE TABLE `propiedades` (
  `id` int(11) NOT NULL,
  `titulo` varchar(45) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `imagen` varchar(200) DEFAULT NULL,
  `descripcion` longtext DEFAULT NULL,
  `habitaciones` int(1) DEFAULT NULL,
  `wc` int(1) DEFAULT NULL,
  `estacionamiento` int(1) DEFAULT NULL,
  `creado` date DEFAULT NULL,
  `vendedores_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `propiedades`
--

INSERT INTO `propiedades` (`id`, `titulo`, `precio`, `imagen`, `descripcion`, `habitaciones`, `wc`, `estacionamiento`, `creado`, `vendedores_id`) VALUES
(7, 'Casa en Vecindario', 1235455.00, '564af40938a202b9e3bd750ab7b2ed87.jpg', 'Casa con muy buenas vistas y gran terreno para jugar', 9, 4, 5, '2023-10-20', 1),
(8, 'Casa en Moaña', 99999999.99, '98011f2e4fc0dc9cbace6e28a9ecfc74.jpg', 'Casa con muy buenas vistas y gran terreno para jugar', 12, 6, 4, '2023-10-20', 1),
(9, 'Duplex en la paterna', 1000000.00, 'd5bbacdcaf35e5b65b49193bcc4a48e0.jpg', 'Casa con muy buenas vistas y gran terreno para jugar', 3, 1, 2, '2023-10-20', 1),
(10, 'ythjkrtyu', 1235455.00, '033110cfc95d46c9a22c10df4e151c59.jpg', 'Casa con muy buenas vistas y gran terreno para jugar', 10, 12, 1, '2023-10-20', 1),
(11, 'gdsfag', 1235455.00, '5008c9db8b1d058b5d642447c36f99ca.jpg', 'Casa con muy buenas vistas y gran terreno para jugar', 5, 2, 1, '2023-10-20', 1),
(12, 'casa34', 1235455.00, 'fc2ff8f5d9245c00caaad44d986a3ebd.jpg', 'Casa con muy buenas vistas y gran terreno para jugar', 36, 54, 5, '2023-10-20', 1),
(13, 'Casa en vecindario', 1235455.00, 'f84035954c0755d61bce8a57566c5fed.jpg', 'Casa con muy buenas vistas y gran terreno para jugar', 578, 578, 6357, '2023-10-20', 1),
(14, 'Casa 1', 432.00, '1e7ef4360dfb0ea6a9fa80595f6a7796.jpg', 'Casa con muy buenas vistas y gran terreno para jugar', 4, 4, 2, NULL, 1),
(15, 'Casa 2', 43242323.00, 'f6f96c430ba32501886c3267414ff073.jpg', 'Casa con muy buenas vistas y gran terreno para jugar', 54, 3, 34, NULL, 1),
(16, 'Casa 3', 543.00, '4fb73e4ce35e5c205ce262ce4d13c92e.jpg', 'Casa con muy buenas vistas y gran terreno para jugar en Moaña, Galicia', 5342, 23, 231, NULL, 1),
(17, 'Casa 4', 543.00, 'd4cfd5a51a5212814b5c19f8109e0679.jpg', 'Casa con muy buenas vistas y gran terreno para jugar', 3452, 21, 432, NULL, 1),
(18, 'Casa cerca de Moaña', 545.00, 'dd68381d637f8c318f81692aed5a47eb.jpg', 'Casa con muy buenas vistas y gran terreno para jugar en Vigo, Galicia', 567, 567, 567, NULL, 1),
(19, 'Casa 6', 7689.00, '9bf259daf171e34babaacce546ab05e0.jpg', 'Casa con muy buenas vistas y gran terreno para jugar', 67, 698, 897, NULL, 1),
(20, 'Casa 7', 5678.00, '0ceba280fff8a4b1c9f95381be53dff7.jpg', 'Casa con muy buenas vistas y gran terreno para jugar', 6789, 6, 7, NULL, 1),
(21, 'Casa 8', 789.00, 'a126518130ae4478636a17861d59e927.jpg', 'Casa con muy buenas vistas y gran terreno para jugar', 678, 789, 789, NULL, 1),
(22, 'Casa 9', 789.00, 'f7ac270fdb7fcefb537124eb016e6b9d.jpg', 'Casa con muy buenas vistas y gran terreno para jugar', 4567, 6789, 678, NULL, 1),
(23, 'Casa 10', 678.00, 'dfd89601034eb89307742f88f72fd22e.jpg', 'Casa con muy buenas vistas y gran terreno para jugar', 567, 890, 76, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` char(60) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `email`, `password`, `nombre`) VALUES
(1, 'correos@correo.com', '123456', NULL),
(2, 'correos@correo.com', '$2y$10$VqfXfMnD0yILF4OwtxDSIuOPFWHCidz0qqTPF8z4Jf2jh9wE5y/ke', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vendedores`
--

CREATE TABLE `vendedores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `apellidos` varchar(45) DEFAULT NULL,
  `telefono` varchar(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `vendedores`
--

INSERT INTO `vendedores` (`id`, `nombre`, `apellidos`, `telefono`) VALUES
(1, 'Aaron', 'Curro Solla', '673784146');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `propiedades`
--
ALTER TABLE `propiedades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_propiedades_vendedores_idx` (`vendedores_id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendedores`
--
ALTER TABLE `vendedores`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `propiedades`
--
ALTER TABLE `propiedades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `vendedores`
--
ALTER TABLE `vendedores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `propiedades`
--
ALTER TABLE `propiedades`
  ADD CONSTRAINT `fk_propiedades_vendedores` FOREIGN KEY (`vendedores_id`) REFERENCES `vendedores` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
