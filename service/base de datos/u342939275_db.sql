
-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 14-03-2016 a las 00:22:57
-- Versión del servidor: 10.0.23-MariaDB
-- Versión de PHP: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `u342939275_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias_reportes`
--

CREATE TABLE IF NOT EXISTS `categorias_reportes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `categorias_reportes`
--

INSERT INTO `categorias_reportes` (`id`, `categoria`) VALUES
(1, 'Alumbrado Público'),
(2, 'Limpia'),
(3, 'Bacheo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuentas`
--

CREATE TABLE IF NOT EXISTS `cuentas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cuenta` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `cuentas`
--

INSERT INTO `cuentas` (`id`, `cuenta`) VALUES
(1, 'Default'),
(2, 'Facebook');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamentos`
--

CREATE TABLE IF NOT EXISTS `departamentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `departamento` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `descripcion` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `departamentos`
--

INSERT INTO `departamentos` (`id`, `departamento`, `descripcion`) VALUES
(1, 'Dirección General de Alumbrado Público', 'alumbrado, cables y postes dañados'),
(2, 'Dirección General de Limpia', 'calles sucias, escombros en las calles'),
(3, 'Dirección de Obras Públicas', 'bacheo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direcciones_reporte`
--

CREATE TABLE IF NOT EXISTS `direcciones_reporte` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `latitud` float NOT NULL,
  `longitud` float NOT NULL,
  `descripcion` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `cp` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `calle_avenida` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `numero` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `colonia` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=12 ;

--
-- Volcado de datos para la tabla `direcciones_reporte`
--

INSERT INTO `direcciones_reporte` (`id`, `latitud`, `longitud`, `descripcion`, `cp`, `calle_avenida`, `numero`, `colonia`) VALUES
(1, 31.6938, -106.429, ' Av Prof Ramon Rivera Lara 6620, Ramón Rivera Lara, 32605 Cd Juárez, Chih., México', '32605', 'Av Prof Ramon Rivera Lara', '6620', 'Constituyentes'),
(2, 31.6795, -106.448, 'Calle Prof. Elisa Griensen 307, Constituyentes, 32675 Cd Juárez, Chih., México', '32675', 'Calle Prof. Elisa Griensen', '307', 'Constituyentes'),
(3, 31.6768, -106.454, 'Ponciano Arriaga 1411, Revolución Mexicana, 32670 Cd Juárez, Chih., México', '32670', 'Ponciano Arriaga', '1411', 'Revolución Mexicana'),
(4, 31.6635, -106.491, 'Perif. Camino Real, Chihuahua, México', 'undefined', 'Ponciano Arriaga', '12345', 'Colonia Ladrillera'),
(5, 31.6642, -106.478, 'Priv. Pino Suárez 327-391, Santa María, 32676 Cd Juárez, Chih., México', '32676', 'Privada Pino Suárez', '327-391', 'Santa María'),
(6, 31.6642, -106.478, 'Priv. Pino Suárez 327-391, Santa María, 32676 Cd Juárez, Chih., México', '32676', 'Privada Pino Suárez', '327-391', 'Santa María'),
(7, 31.6642, -106.478, 'Priv. Pino Suárez 327-391, Santa María, 32676 Cd Juárez, Chih., México', '32605', 'Privada Pino Suárez', '327-391', 'Santa María'),
(8, 31.6642, -106.478, 'Priv. Pino Suárez 327-391, Santa María, 32676 Cd Juárez, Chih., México', '32605', 'Privada Pino Suárez', '327-391', 'Santa María'),
(9, 31.6642, -106.478, 'Priv. Pino Suárez 327-391, Santa María, 32676 Cd Juárez, Chih., México', '32605', 'Privada Pino Suárez', '327-391', 'Santa María'),
(10, 31.6928, -106.439, 'Bulevar Oscar Flores San 3929, Fundidora, Cd Juárez, Chih., México', 'undefined', 'Bulevar Oscar Flores San', '3929', 'Fundidora'),
(11, 31.669, -106.476, 'Cor. Primitivo Uro 8517, Santa María, 32676 Cd Juárez, Chih., México', '32676', 'Coronel Primitivo Uro', '8517', 'Santa María');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estatus_reportes`
--

CREATE TABLE IF NOT EXISTS `estatus_reportes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `estatus` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `estatus_reportes`
--

INSERT INTO `estatus_reportes` (`id`, `estatus`) VALUES
(1, 'Pendiente'),
(2, 'En ejecución'),
(3, 'Resuelta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagenes`
--

CREATE TABLE IF NOT EXISTS `imagenes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `src` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=12 ;

--
-- Volcado de datos para la tabla `imagenes`
--

INSERT INTO `imagenes` (`id`, `src`) VALUES
(1, 'http://www.denunciaciudadana.esy.es/data/img/1.jpg'),
(2, 'http://www.denunciaciudadana.esy.es/data/img/2.jpg'),
(3, 'http://www.denunciaciudadana.esy.es/data/img/3.jpg'),
(4, 'http://www.denunciaciudadana.esy.es/data/img/camino_real.jpg'),
(5, 'http://www.denunciaciudadana.esy.es/data/img/dreganaje.png'),
(6, 'http://www.denunciaciudadana.esy.es/data/img/Bache-traga-camioneta.jpg'),
(7, 'http://www.denunciaciudadana.esy.es/data/img/image.png'),
(8, 'http://www.denunciaciudadana.esy.es/data/img/1457504924183.jpg'),
(9, 'http://www.denunciaciudadana.esy.es/data/img/1457505392327.jpg'),
(10, 'http://www.denunciaciudadana.esy.es/data/img/bache2.jpg'),
(11, 'http://www.denunciaciudadana.esy.es/data/img/1457917651042.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reportes`
--

CREATE TABLE IF NOT EXISTS `reportes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_estatus` int(11) NOT NULL,
  `id_categoria_rep` int(11) NOT NULL,
  `id_direccion` int(11) NOT NULL,
  `id_imagen` int(11) NOT NULL,
  `descripcion` text COLLATE utf8_unicode_ci NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_rep_user_fk` (`id_usuario`),
  KEY `id_rep_estatus_fk` (`id_estatus`),
  KEY `id_rep_cat_fk` (`id_categoria_rep`),
  KEY `id_rep_img_fk` (`id_imagen`),
  KEY `id_rep_direccion_fk` (`id_direccion`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla `reportes`
--

INSERT INTO `reportes` (`id`, `id_usuario`, `id_estatus`, `id_categoria_rep`, `id_direccion`, `id_imagen`, `descripcion`, `fecha`) VALUES
(1, 2, 1, 1, 1, 1, 'En muy mal estado', '2016-03-06 03:04:49'),
(2, 2, 2, 1, 2, 2, 'Muy mal', '2016-03-06 03:10:21'),
(3, 2, 3, 1, 3, 3, 'Alumbrado en mal estado', '2016-03-06 03:12:55'),
(4, 1, 1, 2, 4, 4, 'Es muy peligroso transitar por el Camino Real a altura del km 20 ya que hay unas rocas gigantes que cubren la calle', '2016-03-07 00:05:10'),
(5, 2, 2, 2, 9, 5, 'Test', '2016-03-07 00:08:35'),
(6, 7, 3, 3, 10, 6, 'Bache Tragacamioneta En La Oscar Flores', '2016-03-07 05:51:52'),
(7, 1, 1, 3, 11, 10, 'Bache', '2016-03-11 00:11:08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles_usuarios`
--

CREATE TABLE IF NOT EXISTS `roles_usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rol` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `descripcion` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `roles_usuarios`
--

INSERT INTO `roles_usuarios` (`id`, `rol`, `descripcion`) VALUES
(1, 'Administrador', 'Administrador del sistema web'),
(2, 'Usuario General', 'Usuarios Generales, ciudadano, trabajador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tabla_ejemplo2`
--

CREATE TABLE IF NOT EXISTS `tabla_ejemplo2` (
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rol` int(11) NOT NULL,
  `id_cuenta` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `user` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `estatus` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user_rol_fk` (`id_rol`),
  KEY `id_user_registrado_por_fk` (`id_cuenta`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=12 ;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `id_rol`, `id_cuenta`, `name`, `user`, `password`, `estatus`) VALUES
(1, 1, 1, 'Angel Montelongo', 'angelmh.am@gmail.com', 'abc123', 1),
(2, 2, 1, 'Edwin Morales', 'edwin@gmail.com', 'abc123', 1),
(3, 2, 1, 'Emilio Perez', 'emilio@gmail.com', 'abc123', 1),
(4, 2, 1, 'trabajador2', 'trabajador2@gmail.com', 'abc123', 1),
(5, 2, 2, 'trabajador3', 'trabajador3@gmail.com', 'password_aleatorio', 0),
(6, 2, 2, 'ciudadano2', 'ciudadano2@gmail.com', 'password_aleatorio', 0),
(7, 2, 1, 'ciudadano3', 'ciudadano3@gmail.com', 'abc123', 1),
(8, 2, 1, 'ciudadano4', 'ciudadano4@gmail.com', 'abc123', 1),
(9, 2, 1, 'ciudadano5', 'ciudadano5@gmail.com', 'abc123', 1),
(10, 2, 1, 'trabajador4', 'trabajador4@gmail.com', 'abc123', 1),
(11, 2, 1, 'trabajador5', 'trabajador5@gmail.com', 'abc123', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_ciudadano`
--

CREATE TABLE IF NOT EXISTS `usuario_ciudadano` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user_ciud_fk` (`id_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `usuario_ciudadano`
--

INSERT INTO `usuario_ciudadano` (`id`, `id_usuario`) VALUES
(1, 2),
(2, 6),
(3, 7),
(4, 8),
(5, 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_trabajador`
--

CREATE TABLE IF NOT EXISTS `usuario_trabajador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_dpto` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user_trab_fk` (`id_usuario`),
  KEY `id_trab_dpto_fk` (`id_dpto`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Volcado de datos para la tabla `usuario_trabajador`
--

INSERT INTO `usuario_trabajador` (`id`, `id_usuario`, `id_dpto`) VALUES
(1, 3, 1),
(2, 4, 2),
(3, 5, 3),
(5, 10, 1),
(6, 11, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `votos`
--

CREATE TABLE IF NOT EXISTS `votos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_reporte` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `fecha_creacion_v` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_modificacion_v` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_voto_rep_fk` (`id_reporte`),
  KEY `id_voto_user_fk` (`id_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=12 ;

--
-- Volcado de datos para la tabla `votos`
--

INSERT INTO `votos` (`id`, `id_reporte`, `id_usuario`, `cantidad`, `fecha_creacion_v`, `fecha_modificacion_v`) VALUES
(1, 1, 2, 1, '2016-03-07 21:33:48', '2016-03-07 21:52:54'),
(2, 1, 6, 1, '2016-03-07 21:33:48', '2016-03-07 21:52:54'),
(3, 1, 7, 1, '2016-03-07 21:33:48', '2016-03-07 21:52:54'),
(4, 2, 8, 1, '2016-03-07 21:33:48', '2016-03-07 21:52:54'),
(5, 2, 9, 1, '2016-03-07 21:33:48', '2016-03-07 21:52:54'),
(6, 2, 2, 1, '2016-03-07 21:33:48', '2016-03-07 21:52:54'),
(7, 3, 1, 1, '2016-03-07 21:33:48', '2016-03-07 21:52:54'),
(8, 4, 1, 1, '2016-03-07 21:48:59', '2016-03-07 21:53:59'),
(9, 5, 1, 0, '2016-03-08 00:12:05', '2016-03-11 00:08:27'),
(10, 2, 1, 0, '2016-03-08 00:50:37', '2016-03-08 01:00:34'),
(11, 1, 1, 0, '2016-03-08 01:02:22', '2016-03-08 01:02:29');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `reportes`
--
ALTER TABLE `reportes`
  ADD CONSTRAINT `id_rep_cat_fk` FOREIGN KEY (`id_categoria_rep`) REFERENCES `categorias_reportes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_rep_direccion_fk` FOREIGN KEY (`id_direccion`) REFERENCES `direcciones_reporte` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_rep_estatus_fk` FOREIGN KEY (`id_estatus`) REFERENCES `estatus_reportes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_rep_img_fk` FOREIGN KEY (`id_imagen`) REFERENCES `imagenes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_rep_user_fk` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `id_user_registrado_por_fk` FOREIGN KEY (`id_cuenta`) REFERENCES `cuentas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_user_rol_fk` FOREIGN KEY (`id_rol`) REFERENCES `roles_usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuario_ciudadano`
--
ALTER TABLE `usuario_ciudadano`
  ADD CONSTRAINT `id_user_ciud_fk` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_user_ciudadano_fk` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuario_trabajador`
--
ALTER TABLE `usuario_trabajador`
  ADD CONSTRAINT `id_trab_dpto_fk` FOREIGN KEY (`id_dpto`) REFERENCES `departamentos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_user_trab_fk` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `votos`
--
ALTER TABLE `votos`
  ADD CONSTRAINT `id_voto_rep_fk` FOREIGN KEY (`id_reporte`) REFERENCES `reportes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_voto_user_fk` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
