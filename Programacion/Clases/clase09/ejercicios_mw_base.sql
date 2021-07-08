-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-06-2020 a las 13:09:07
-- Versión del servidor: 10.1.38-MariaDB
-- Versión de PHP: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `mi_base`
--
CREATE DATABASE IF NOT EXISTS `mi_base` DEFAULT CHARACTER SET latin1 COLLATE latin1_spanish_ci;
USE `mi_base`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfiles`
--

DROP TABLE IF EXISTS `perfiles`;
CREATE TABLE IF NOT EXISTS `perfiles` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `estado` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `perfiles`
--

INSERT INTO `perfiles` (`id`, `descripcion`, `estado`) VALUES
(1, 'administrador', 1),
(2, 'empleado', 1),
(3, 'invitado', 1),
(4, 'supervisor', 1),
(5, 'super_admin', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `apellido` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `correo` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `foto` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `id_perfil` int(10) UNSIGNED NOT NULL,
  `clave` varchar(10) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `correo`, `foto`, `id_perfil`, `clave`) VALUES
(1, 'juan', 'perez', 'juan@perez.com', '1_20200606100000_perez.jpg', 1, '123456'),
(2, 'pedro', 'gonzalez', 'pedro@gonzalez.com', '2_20200606100001_gonzalez.jpg', 2, '123456'),
(3, 'juana', 'perez', 'juana@perez.com', '3_20200606100003_perez.jpg', 4, '123456'),
(4, 'karina', 'gonzalez', 'karina@gonzalez.com', '4_20200606100004_gonzalez.jpg', 2, '123456'),
(5, 'rosa', 'martinez', 'rosa@martinez.com', '5_20200606100003_martinez.jpg', 2, '123456'),
(6, 'julio', 'sosa', 'julio@sosa.com', '6_20200606100004_sosa.jpg', 3, '123456'),
(7, 'olga', 'suarez', 'olga@suarez.com', '7_20200606100005_suarez.jpg', 3, '123456'),
(8, 'lucio', 'gonzalez', 'lucio@gonzalez.com', '8_20200606100006_gonzalez.com', 5, '123456');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
