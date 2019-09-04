-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-09-2019 a las 05:50:24
-- Versión del servidor: 10.1.31-MariaDB
-- Versión de PHP: 7.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `planner_assetcloud_integracion`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `frm_formularios`
--

CREATE TABLE `frm_formularios` (
  `form_id` int(11) NOT NULL,
  `nombre` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `descripcion` varchar(300) CHARACTER SET latin1 DEFAULT NULL,
  `empr_id` int(11) DEFAULT NULL,
  `fec_alta` datetime DEFAULT CURRENT_TIMESTAMP,
  `eliminado` tinyint(4) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `frm_formularios`
--

INSERT INTO `frm_formularios` (`form_id`, `nombre`, `descripcion`, `empr_id`, `fec_alta`, `eliminado`) VALUES
(1, 'Formulario Usuario', '-', 1, '2019-08-17 14:24:38', 0),
(2, 'Formulario Arbolado', NULL, 1, '2019-09-03 23:52:30', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `frm_instancias_formularios`
--

CREATE TABLE `frm_instancias_formularios` (
  `id` int(11) NOT NULL,
  `label` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `name` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `valor` varchar(500) COLLATE utf8_spanish_ci DEFAULT NULL,
  `requerido` tinyint(4) DEFAULT NULL,
  `tida_id` int(11) DEFAULT NULL,
  `valo_id` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `info_id` int(11) DEFAULT NULL,
  `form_id` int(11) DEFAULT NULL,
  `orden` int(11) DEFAULT NULL,
  `aux` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fec_alta` datetime DEFAULT CURRENT_TIMESTAMP,
  `eliminado` tinyint(4) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `frm_instancias_formularios`
--

INSERT INTO `frm_instancias_formularios` (`id`, `label`, `name`, `valor`, `requerido`, `tida_id`, `valo_id`, `info_id`, `form_id`, `orden`, `aux`, `fec_alta`, `eliminado`) VALUES
(164, 'Nombre', 'nombre', 'Fernando Emmanuel', 1, 3, NULL, 1, 1, 2, NULL, '2019-08-21 11:37:35', 0),
(165, 'Apellido', 'apellido', 'Leiva Silva', 1, 3, NULL, 1, 1, 3, NULL, '2019-08-21 11:37:35', 0),
(166, 'Fecha Nacimiento', 'fecha_nacimiento', '23/11/1994', 1, 5, NULL, 1, 1, 4, NULL, '2019-08-21 11:37:35', 0),
(167, 'Email', 'email', 'fer_17916@hotmail.com', 1, 3, NULL, 1, 1, 5, NULL, '2019-08-21 11:37:35', 0),
(168, 'Seleccionar Provincia', 'provincia', 'San Luis', 1, 4, 'provincias', 1, 1, 6, NULL, '2019-08-21 11:37:35', 0),
(169, 'Seleccionar Sexo', 'sexo', 'Hombre', 1, 7, 'sexos', 1, 1, 7, NULL, '2019-08-21 11:37:35', 0),
(170, 'Seleccionar Opcion', 'contrato', '', 1, 6, 'contratos', 1, 1, 8, NULL, '2019-08-21 11:37:35', 0),
(171, 'Adjuntar Archivo', 'pdf', 'fer_dump.sql', 1, 8, NULL, 1, 1, 9, NULL, '2019-08-21 11:37:35', 0),
(172, 'Observaciones', 'observaciones', 'aaaaaa', 1, 9, NULL, 1, 1, 10, NULL, '2019-08-21 11:37:35', 0),
(173, 'Complete todos los campos del formulario *', NULL, NULL, NULL, 2, NULL, 1, 1, 1, NULL, '2019-08-21 11:37:35', 0),
(174, 'Complete todos los campos del formulario *', NULL, NULL, NULL, 2, NULL, 2, 1, 1, NULL, '2019-08-22 19:02:57', 0),
(175, 'Nombre', 'nombre', 'Eliana ', 1, 3, NULL, 2, 1, 2, NULL, '2019-08-22 19:02:57', 0),
(176, 'Apellido', 'apellido', 'Bernaldez', 1, 3, NULL, 2, 1, 3, NULL, '2019-08-22 19:02:57', 0),
(177, 'Fecha Nacimiento', 'fecha_nacimiento', '01/01/1994', 1, 5, NULL, 2, 1, 4, NULL, '2019-08-22 19:02:57', 0),
(178, 'Email', 'email', 'elianabernaldez03@gmail.com', 1, 3, NULL, 2, 1, 5, NULL, '2019-08-22 19:02:57', 0),
(179, 'Seleccionar Provincia', 'provincia', 'Mendoza', 1, 4, 'provincias', 2, 1, 6, NULL, '2019-08-22 19:02:57', 0),
(180, 'Seleccionar Sexo', 'sexo', 'Mujer', 1, 7, 'sexos', 2, 1, 7, NULL, '2019-08-22 19:02:57', 0),
(181, 'Seleccionar Opcion', 'contrato', 'Acepto los Terminos y Condiciones del Servicio-Enviar Emails', 1, 6, 'contratos', 2, 1, 8, NULL, '2019-08-22 19:02:57', 0),
(182, 'Adjuntar Archivo', 'pdf', 'ejemplo.png', 1, 8, NULL, 2, 1, 9, NULL, '2019-08-22 19:02:57', 0),
(183, 'Observaciones', 'observaciones', 'Berta', 1, 9, NULL, 2, 1, 10, NULL, '2019-08-22 19:02:57', 0),
(184, 'Complete todos los campos del formulario *', NULL, NULL, NULL, 2, NULL, 3, 1, 1, NULL, '2019-08-22 19:03:09', 0),
(185, 'Nombre', 'nombre', 'eeee', 1, 3, NULL, 3, 1, 2, NULL, '2019-08-22 19:03:09', 0),
(186, 'Apellido', 'apellido', 'eeeee', 1, 3, NULL, 3, 1, 3, NULL, '2019-08-22 19:03:09', 0),
(187, 'Fecha Nacimiento', 'fecha_nacimiento', '', 1, 5, NULL, 3, 1, 4, NULL, '2019-08-22 19:03:09', 0),
(188, 'Email', 'email', 'bernaldezmoralez@gmail.com', 1, 3, NULL, 3, 1, 5, NULL, '2019-08-22 19:03:09', 0),
(189, 'Seleccionar Provincia', 'provincia', 'San Juan', 1, 4, 'provincias', 3, 1, 6, NULL, '2019-08-22 19:03:09', 0),
(190, 'Seleccionar Sexo', 'sexo', 'Mujer', 1, 7, 'sexos', 3, 1, 7, NULL, '2019-08-22 19:03:09', 0),
(191, 'Seleccionar Opcion', 'contrato', '', 1, 6, 'contratos', 3, 1, 8, NULL, '2019-08-22 19:03:09', 0),
(192, 'Adjuntar Archivo', 'pdf', NULL, 1, 8, NULL, 3, 1, 9, NULL, '2019-08-22 19:03:09', 0),
(193, 'Observaciones', 'observaciones', 'eeeeeeeeeeee', 1, 9, NULL, 3, 1, 10, NULL, '2019-08-22 19:03:09', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `frm_items`
--

CREATE TABLE `frm_items` (
  `item_id` int(11) NOT NULL,
  `label` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `name` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `requerido` tinyint(4) DEFAULT NULL,
  `tida_id` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `valo_id` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `form_id` int(11) DEFAULT NULL,
  `orden` int(11) DEFAULT NULL,
  `fec_alta` datetime DEFAULT CURRENT_TIMESTAMP,
  `eliminado` tinyint(4) DEFAULT '0',
  `aux` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `frm_items`
--

INSERT INTO `frm_items` (`item_id`, `label`, `name`, `requerido`, `tida_id`, `valo_id`, `form_id`, `orden`, `fec_alta`, `eliminado`, `aux`) VALUES
(1, 'Complete todos los campos del formulario *', NULL, NULL, '2', NULL, 1, 1, '2019-08-17 14:27:38', 0, NULL),
(2, 'Nombre', 'nombre', 1, '3', NULL, 1, 2, '2019-08-17 14:28:46', 0, NULL),
(3, 'Apellido', 'apellido', 1, '3', NULL, 1, 3, '2019-08-17 14:28:46', 0, NULL),
(4, 'Fecha Nacimiento', 'fecha_nacimiento', 1, '5', NULL, 1, 4, '2019-08-17 14:32:37', 0, NULL),
(5, 'Email', 'email', 1, '3', NULL, 1, 5, '2019-08-17 14:34:08', 0, NULL),
(6, 'Seleccionar Provincia', 'provincia', 1, '4', 'provincias', 1, 6, '2019-08-17 14:34:57', 0, NULL),
(7, 'Seleccionar Sexo', 'sexo', 1, '7', 'sexos', 1, 7, '2019-08-17 15:40:06', 0, NULL),
(8, 'Seleccionar Opcion', 'contrato', 1, '6', 'contratos', 1, 8, '2019-08-17 15:40:06', 0, NULL),
(9, 'Adjuntar Archivo', 'pdf', 1, '8', NULL, 1, 9, '2019-08-17 15:42:37', 0, NULL),
(10, 'Observaciones', 'observaciones', 1, '9', NULL, 1, 10, '2019-08-17 15:42:37', 0, NULL),
(11, 'Complete Datos de Manzana:', NULL, NULL, '26', NULL, 2, 1, '2019-09-03 23:52:39', 0, NULL),
(12, 'Calle', 'calle', NULL, '4', 'calles', 2, 2, '2019-09-03 23:56:01', 0, NULL),
(13, 'Calle', 'calle_manual', NULL, '3', NULL, 2, 3, '2019-09-03 23:56:47', 0, NULL),
(14, 'Número', 'numero_calle', NULL, '3', NULL, 2, 4, '2019-09-03 23:57:44', 0, NULL),
(15, 'Barrio', 'barrio', NULL, '3', NULL, 2, 5, '2019-09-03 23:59:09', 0, NULL),
(16, 'Taza', 'taza', NULL, '4', 'tazas', 2, 6, '2019-09-04 00:11:39', 0, NULL),
(17, 'Nombre Cientifíco/Común', 'nombre', NULL, '4', 'nombres_arboles', 2, 7, '2019-09-04 00:13:39', 0, NULL),
(18, 'Otro', 'otro_nombre', NULL, '3', NULL, 2, 8, '2019-09-04 00:14:21', 0, NULL),
(19, 'Alineación del Árbol', 'alineacion', NULL, '4', 'alineacion_arbol', 2, 9, '2019-09-04 00:15:57', 0, NULL),
(20, 'Estado Físico', NULL, NULL, '26', NULL, 2, 10, '2019-09-04 00:20:30', 0, NULL),
(21, 'Raíces', 'estado_raices', NULL, '7', 'estado_raices', 2, 11, '2019-09-04 00:22:53', 0, NULL),
(22, 'Seleccione Daño', 'dano', NULL, '4', 'danos', 2, 12, '2019-09-04 00:31:51', 0, NULL),
(23, 'Fuste', 'fuste', NULL, '7', 'fuste', 2, 13, '2019-09-04 00:33:26', 0, NULL),
(24, 'Cavidad expuesta', 'cavidad_expuesta', NULL, '7', 'cavidad', 2, 14, '2019-09-04 00:40:28', 0, NULL),
(25, 'Tamaño', 'cavidad_tamano', NULL, '4', 'cavidad_tamano', 2, 15, '2019-09-04 00:43:44', 0, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `utl_tablas`
--

CREATE TABLE `utl_tablas` (
  `tabl_id` int(11) NOT NULL,
  `tabla` varchar(50) COLLATE utf8_turkish_ci DEFAULT NULL,
  `valor` varchar(50) COLLATE utf8_turkish_ci DEFAULT NULL,
  `descripcion` varchar(200) COLLATE utf8_turkish_ci DEFAULT NULL,
  `fec_alta` datetime DEFAULT CURRENT_TIMESTAMP,
  `eliminado` tinyint(4) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Volcado de datos para la tabla `utl_tablas`
--

INSERT INTO `utl_tablas` (`tabl_id`, `tabla`, `valor`, `descripcion`, `fec_alta`, `eliminado`) VALUES
(1, 'tipos_datos', 'titulo1', NULL, '2019-08-21 13:50:49', 0),
(2, 'tipos_datos', 'comentario', NULL, '2019-08-21 13:50:49', 0),
(3, 'tipos_datos', 'input', NULL, '2019-08-21 13:50:49', 0),
(4, 'tipos_datos', 'select', NULL, '2019-08-21 13:50:49', 0),
(5, 'tipos_datos', 'date', NULL, '2019-08-21 13:50:49', 0),
(6, 'tipos_datos', 'check', NULL, '2019-08-21 13:50:49', 0),
(7, 'tipos_datos', 'radio', NULL, '2019-08-21 13:50:49', 0),
(8, 'tipos_datos', 'file', NULL, '2019-08-21 13:50:49', 0),
(9, 'tipos_datos', 'textarea', NULL, '2019-08-21 13:50:49', 0),
(10, 'provincias', 'San Juan', NULL, '2019-08-17 15:33:52', 0),
(11, 'provincias', 'Mendoza', NULL, '2019-08-17 15:33:52', 0),
(12, 'provincias', 'San Luis', NULL, '2019-08-17 15:33:52', 0),
(13, 'sexos', 'Hombre', NULL, '2019-08-17 16:28:10', 0),
(14, 'sexos', 'Mujer', NULL, '2019-08-17 16:28:10', 0),
(15, 'sexos', 'No Binario', NULL, '2019-08-17 16:28:10', 0),
(16, 'contratos', 'Acepto los Terminos y Condiciones del Servicio', NULL, '2019-08-17 17:01:22', 0),
(17, 'contratos', 'Enviar Emails', NULL, '2019-08-17 17:01:22', 0),
(21, 'unidad', 'KM', 'KILOMETROS', '2019-04-23 18:25:47', 0),
(22, 'unidad', 'UN', 'UNIDAD', '2019-05-24 00:56:16', 1),
(23, 'unidad', NULL, 'asd', '2019-06-04 17:04:45', 0),
(24, 'unidad', NULL, 'dfg', '2019-06-04 17:05:34', 1),
(25, 'tipos_datos', 'titulo2', NULL, '2019-09-03 23:50:28', 0),
(26, 'tipos_datos', 'titulo3', NULL, '2019-09-03 23:50:28', 0),
(27, 'estado_raices', 'Descubiertas', NULL, '2019-09-04 00:30:25', 0),
(28, 'estado_raices', 'Cuello Visible', NULL, '2019-09-04 00:30:25', 0),
(29, 'estado_raices', 'Lev. Veredas', NULL, '2019-09-04 00:30:25', 0),
(30, 'estado_raices', 'Lev. Pavimento', NULL, '2019-09-04 00:30:25', 0),
(31, 'danos', 'Leve', NULL, '2019-09-04 00:32:17', 0),
(32, 'danos', 'Moderado', NULL, '2019-09-04 00:32:17', 0),
(33, 'danos', 'Grave', NULL, '2019-09-04 00:32:17', 0),
(34, 'fuste', 'Único', NULL, '2019-09-04 00:36:18', 0),
(35, 'fuste', 'Bifurcado', NULL, '2019-09-04 00:36:18', 0),
(36, 'fuste', 'Inclinación Mayor a 45°', NULL, '2019-09-04 00:36:18', 0),
(37, 'fuste', 'Descortezamiento', NULL, '2019-09-04 00:36:18', 0),
(38, 'fuste', 'Codominicancia', NULL, '2019-09-04 00:36:18', 0),
(39, 'fuste', 'Deformación', NULL, '2019-09-04 00:36:18', 0),
(40, 'fuste', 'Fructificación', NULL, '2019-09-04 00:36:18', 0),
(41, 'cavidad', 'Basal', NULL, '2019-09-04 00:42:22', 0),
(42, 'cavidad', 'Media', NULL, '2019-09-04 00:42:22', 0),
(43, 'cavidad', 'Alta', NULL, '2019-09-04 00:42:22', 0),
(44, 'cavidad_tamano', 'Chica', NULL, '2019-09-04 00:44:18', 0),
(45, 'cavidad_tamano', 'Mediana', NULL, '2019-09-04 00:44:18', 0),
(46, 'cavidad_tamano', 'Grande', NULL, '2019-09-04 00:44:18', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `frm_formularios`
--
ALTER TABLE `frm_formularios`
  ADD PRIMARY KEY (`form_id`);

--
-- Indices de la tabla `frm_instancias_formularios`
--
ALTER TABLE `frm_instancias_formularios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `frm_items`
--
ALTER TABLE `frm_items`
  ADD PRIMARY KEY (`item_id`);

--
-- Indices de la tabla `utl_tablas`
--
ALTER TABLE `utl_tablas`
  ADD PRIMARY KEY (`tabl_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `frm_formularios`
--
ALTER TABLE `frm_formularios`
  MODIFY `form_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `frm_instancias_formularios`
--
ALTER TABLE `frm_instancias_formularios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=194;

--
-- AUTO_INCREMENT de la tabla `frm_items`
--
ALTER TABLE `frm_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `utl_tablas`
--
ALTER TABLE `utl_tablas`
  MODIFY `tabl_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
