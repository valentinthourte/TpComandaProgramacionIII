-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-07-2024 a las 21:58:26
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `restaurante`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comanda`
--

CREATE TABLE `comanda` (
  `id` int(11) NOT NULL,
  `numeroPedido` varchar(5) NOT NULL,
  `estadoComanda` varchar(30) NOT NULL,
  `usuarioPreparacionId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comanda`
--

INSERT INTO `comanda` (`id`, `numeroPedido`, `estadoComanda`, `usuarioPreparacionId`) VALUES
(2, 'hjz4i', 'Pendiente', 5),
(3, 'hjz4i', 'Pendiente', 4),
(4, 'dyxld', 'Pendiente', 5),
(5, 'dyxld', 'Pendiente', 4),
(6, '35knq', 'Pendiente', 5),
(7, '35knq', 'Pendiente', 4),
(8, 'm4l58', 'Pendiente', 5),
(9, 'm4l58', 'Pendiente', 4),
(10, '481fn', 'Pendiente', 5),
(11, '481fn', 'Pendiente', 4),
(12, 'abps6', 'Preparada', 5),
(13, 'abps6', 'Preparada', 4),
(14, 'mp41a', 'Pendiente', 5),
(15, 'mp41a', 'Pendiente', 4),
(16, 's0hsy', 'Pendiente', 5),
(17, 's0hsy', 'Pendiente', 4),
(18, '9ao2i', 'Pendiente', 5),
(19, '63qup', 'Pendiente', 5),
(25, 'kl272', 'Pendiente', 5),
(26, 'd99kg', 'Pendiente', 5),
(27, 'gn35o', 'Pendiente', 5),
(28, 'ofdk6', 'Pendiente', 5),
(29, 'zttmr', 'Pendiente', 5),
(30, 'gc2aw', 'Pendiente', 5),
(31, 'j5kl5', 'Pendiente', 5),
(32, 'i3yip', 'Pendiente', 5),
(33, 'dj4a6', 'Pendiente', 5),
(34, '8fsfy', 'Pendiente', 5),
(35, 'ylev0', 'EnPreparacion', 5),
(36, 'ylev0', 'Pendiente', 4),
(37, 'koydu', 'Preparada', NULL),
(38, 'koydu', 'Pendiente', NULL),
(39, 'koydu', 'Pendiente', NULL),
(40, 'pzkq8', 'Preparada', NULL),
(41, 'pzkq8', 'Pendiente', NULL),
(42, 'pzkq8', 'Pendiente', NULL),
(43, 'vcd29', 'Pendiente', 5),
(44, 'vcd29', 'Pendiente', 4),
(46, 'y22eg', 'Pendiente', 5),
(47, 'y22eg', 'Pendiente', 4),
(49, 'rchwc', 'Preparada', 4),
(50, 'rchwc', 'Preparada', 8),
(51, 'rchwc', 'Preparada', 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comandaproducto`
--

CREATE TABLE `comandaproducto` (
  `comandaId` int(11) NOT NULL,
  `productoId` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comandaproducto`
--

INSERT INTO `comandaproducto` (`comandaId`, `productoId`, `cantidad`) VALUES
(35, 1, 1),
(36, 14, 1),
(37, 1, 1),
(37, 15, 1),
(38, 14, 1),
(39, 16, 1),
(40, 1, 1),
(40, 15, 1),
(41, 14, 1),
(42, 16, 1),
(43, 1, 1),
(43, 15, 1),
(44, 14, 1),
(46, 1, 1),
(46, 15, 1),
(47, 14, 1),
(49, 1, 1),
(49, 15, 1),
(50, 14, 1),
(51, 16, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `loginsusuario`
--

CREATE TABLE `loginsusuario` (
  `usuarioId` int(11) NOT NULL,
  `fechaLogin` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `loginsusuario`
--

INSERT INTO `loginsusuario` (`usuarioId`, `fechaLogin`) VALUES
(6, '2024-07-05 14:55:29'),
(4, '2024-07-05 14:55:45'),
(9, '2024-07-05 14:55:55'),
(6, '2024-07-05 14:56:29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesa`
--

CREATE TABLE `mesa` (
  `numeroMesa` varchar(255) NOT NULL,
  `estado` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mesa`
--

INSERT INTO `mesa` (`numeroMesa`, `estado`) VALUES
('2', 'Baja'),
('3', 'Baja'),
('7biuw', 'Cerrada'),
('bvxxy', 'Cerrada'),
('d6kmh', 'Cerrada'),
('es387', 'Cerrada'),
('q0i46', 'Cerrada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `id` int(11) NOT NULL,
  `numeroPedido` varchar(5) NOT NULL,
  `cliente` varchar(255) NOT NULL,
  `fechaHoraInicioPreparacion` datetime NOT NULL DEFAULT current_timestamp(),
  `tiempoEstimadoPreparacion` int(11) NOT NULL,
  `codigoMesa` int(11) NOT NULL,
  `estadoPedido` varchar(50) NOT NULL,
  `fechaHoraFinPreparacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`id`, `numeroPedido`, `cliente`, `fechaHoraInicioPreparacion`, `tiempoEstimadoPreparacion`, `codigoMesa`, `estadoPedido`, `fechaHoraFinPreparacion`) VALUES
(1, 'hjz4i', 'Valentin Thourte', '2024-06-14 18:59:26', 15, 1, 'ListoParaServir', NULL),
(2, 'dyxld', 'Valentin Thourte', '2024-06-14 19:00:54', 15, 1, 'Pendiente', NULL),
(3, '35knq', 'Valentin Thourte', '2024-06-14 19:01:29', 15, 1, 'Pendiente', NULL),
(4, 'm4l58', 'Valentin Thourte', '2024-06-14 19:27:08', 15, 1, 'Pendiente', NULL),
(5, '481fn', 'Valentin Thourte', '2024-06-14 19:28:50', 15, 1, 'Pendiente', NULL),
(6, 'abps6', 'Valentin Thourte', '2024-06-14 19:32:19', 15, 1, 'ListoParaServir', NULL),
(7, 'mp41a', 'Valentin Thourte', '2024-06-14 19:32:41', 15, 1, 'Pendiente', NULL),
(8, 's0hsy', 'Valentin Thourte', '2024-06-14 19:33:03', 15, 1, 'Pendiente', NULL),
(9, '9ao2i', 'Valentin Thourte', '2024-06-14 19:34:04', 15, 1, 'Pendiente', NULL),
(10, '63qup', 'Valentin Thourte', '2024-06-14 19:34:35', 15, 1, 'Pendiente', NULL),
(11, 'ihw3d', 'Valentin Thourte', '2024-06-14 19:42:12', 15, 1, 'Pendiente', NULL),
(12, '4bjr2', 'Valentin Thourte', '2024-06-14 19:46:20', 15, 1, 'Pendiente', NULL),
(13, 'lp7u9', 'Valentin Thourte', '2024-06-14 19:46:40', 15, 1, 'Pendiente', NULL),
(14, 'zi4y2', 'Valentin Thourte', '2024-06-14 19:51:39', 15, 1, 'Pendiente', NULL),
(15, '3yphh', 'Valentin Thourte', '2024-06-14 19:53:00', 15, 1, 'Pendiente', NULL),
(16, 'kl272', 'Valentin Thourte', '2024-06-14 19:54:51', 15, 1, 'Pendiente', NULL),
(17, 'd99kg', 'Valentin Thourte', '2024-06-14 19:57:24', 15, 1, 'Pendiente', NULL),
(18, 'gn35o', 'Valentin Thourte', '2024-06-14 19:57:51', 15, 1, 'Pendiente', NULL),
(19, 'ofdk6', 'Valentin Thourte', '2024-06-14 19:58:10', 15, 1, 'Pendiente', NULL),
(20, 'zttmr', 'Valentin Thourte', '2024-06-14 20:01:15', 15, 1, 'Pendiente', NULL),
(21, 'gc2aw', 'Valentin Thourte', '2024-06-14 20:09:36', 15, 1, 'Pendiente', NULL),
(22, 'j5kl5', 'Valentin Thourte', '2024-06-14 20:10:42', 15, 1, 'Pendiente', NULL),
(23, 'i3yip', 'Valentin Thourte', '2024-06-14 20:11:44', 15, 1, 'Pendiente', NULL),
(24, 'dj4a6', 'Valentin Thourte', '2024-06-14 20:12:14', 15, 1, 'Pendiente', NULL),
(25, '8fsfy', 'Valentin Thourte', '2024-06-14 20:14:17', 15, 1, 'Pendiente', NULL),
(26, 'ylev0', 'Valentin Thourte', '2024-06-14 20:15:39', 15, 1, 'EnPreparacion', NULL),
(27, 'i08if', 'Valentin Thourte', '2024-07-05 10:50:56', 15, 2, 'Pendiente', NULL),
(28, 'pncvw', 'Valentin Thourte', '2024-07-05 10:51:44', 15, 2, 'Pendiente', NULL),
(29, 'zv4sf', 'Valentin Thourte', '2024-07-05 10:52:12', 15, 2, 'Pendiente', NULL),
(30, 'koydu', 'Valentin Thourte', '2024-07-05 10:52:41', 15, 2, 'Pendiente', NULL),
(31, 'pzkq8', 'Valentin Thourte', '2024-07-05 11:35:01', 15, 2, 'Pendiente', NULL),
(32, 'vcd29', 'Valentin Thourte', '2024-07-05 11:39:18', 15, 2, 'Pendiente', NULL),
(33, 'y22eg', 'Valentin Thourte', '2024-07-05 11:40:41', 15, 2, 'Pendiente', NULL),
(34, 'rchwc', 'Valentin Thourte', '2024-07-05 11:42:11', 15, 2, 'Servido', '2024-07-05 16:31:03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `precio` double NOT NULL,
  `tiempoPreparacionBase` int(11) NOT NULL,
  `tipoUsuarioPreparacionId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id`, `nombre`, `precio`, `tiempoPreparacionBase`, `tipoUsuarioPreparacionId`) VALUES
(1, 'Milanesa con papas fritas', 5000, 15, 5),
(14, 'Vino Malbec', 4500, 2, 4),
(15, '6 empanadas de carne', 6000, 12, 5),
(16, 'Cerveza artesanal', 2000, 5, 3),
(17, 'Hamburguesa', 8.99, 15, 5),
(18, 'Pizza Margherita', 10.5, 20, 5),
(19, 'Ensalada César', 7, 10, 5),
(25, 'Tarta de Queso', 5.5, 30, 6),
(27, 'Cóctel Margarita', 7.5, 7, 4),
(28, 'Brownie', 3.5, 25, 6),
(29, 'Pasta Alfredo', 9.5, 25, 5),
(30, 'Limonada', 2.5, 3, 4),
(31, 'Café Espresso', 2, 2, 4),
(32, 'Milanesa a la Napolitana', 12.5, 20, 5),
(33, 'Sushi Variado', 15.99, 30, 5),
(34, 'Cóctel Piña Colada', 8, 5, 4),
(35, 'Tiramisú', 6.5, 25, 6),
(36, 'Vino Tinto Reserva', 20, 10, 3),
(47, 'Parrillada Argentina', 25, 40, 5),
(48, 'Pasta Carbonara', 11.5, 20, 5),
(49, 'Mojito Clásico', 7.5, 5, 4),
(50, 'Cheesecake de Frutos Rojos', 8.5, 30, 6),
(51, 'Cerveza IPA Artesanal', 5, 7, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipousuario`
--

CREATE TABLE `tipousuario` (
  `id` int(11) NOT NULL,
  `tipo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipousuario`
--

INSERT INTO `tipousuario` (`id`, `tipo`) VALUES
(1, 'Mozo'),
(2, 'Socio'),
(3, 'Cervecero'),
(4, 'Bartender'),
(5, 'Cocinero'),
(6, 'Pastelero');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `clave` varchar(255) NOT NULL,
  `tipoUsuarioId` int(11) NOT NULL,
  `fechaBaja` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `nombre`, `clave`, `tipoUsuarioId`, `fechaBaja`) VALUES
(4, 'ValentinThourte', '1234', 5, NULL),
(5, 'JimenaT', 'abcd', 1, '2024-07-05 13:10:22'),
(6, 'PrimerSocio', '1234', 2, NULL),
(7, 'Mozo1', '1234', 1, NULL),
(8, 'Bartender1', '1234', 4, NULL),
(9, 'Cervecero1', '1234', 3, NULL),
(11, 'Cervecero2', '1234', 3, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comanda`
--
ALTER TABLE `comanda`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_comanda.numeroPedido-pedido.numeroPedido` (`numeroPedido`),
  ADD KEY `FK_comanda.usuarioPreparacionId-Usuario.Id` (`usuarioPreparacionId`);

--
-- Indices de la tabla `comandaproducto`
--
ALTER TABLE `comandaproducto`
  ADD KEY `FK_comandaProducto.comandaId-comanda.id` (`comandaId`),
  ADD KEY `FK_comandaProducto.productoId-producto.id` (`productoId`);

--
-- Indices de la tabla `loginsusuario`
--
ALTER TABLE `loginsusuario`
  ADD KEY `FK_usuarioId_Usuario.Id` (`usuarioId`);

--
-- Indices de la tabla `mesa`
--
ALTER TABLE `mesa`
  ADD PRIMARY KEY (`numeroMesa`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `numeroPedido` (`numeroPedido`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UK_NombreProducto` (`nombre`),
  ADD KEY `FK_tipoUsuarioPreparacionID-TipoUsuario` (`tipoUsuarioPreparacionId`);

--
-- Indices de la tabla `tipousuario`
--
ALTER TABLE `tipousuario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`),
  ADD KEY `FK_TipoUsuario` (`tipoUsuarioId`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comanda`
--
ALTER TABLE `comanda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de la tabla `tipousuario`
--
ALTER TABLE `tipousuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comanda`
--
ALTER TABLE `comanda`
  ADD CONSTRAINT `FK_comanda.numeroPedido-pedido.numeroPedido` FOREIGN KEY (`numeroPedido`) REFERENCES `pedido` (`numeroPedido`),
  ADD CONSTRAINT `FK_comanda.usuarioPreparacionId-Usuario.Id` FOREIGN KEY (`usuarioPreparacionId`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `comandaproducto`
--
ALTER TABLE `comandaproducto`
  ADD CONSTRAINT `FK_comandaProducto.comandaId-comanda.id` FOREIGN KEY (`comandaId`) REFERENCES `comanda` (`id`),
  ADD CONSTRAINT `FK_comandaProducto.productoId-producto.id` FOREIGN KEY (`productoId`) REFERENCES `producto` (`id`);

--
-- Filtros para la tabla `loginsusuario`
--
ALTER TABLE `loginsusuario`
  ADD CONSTRAINT `FK_usuarioId_Usuario.Id` FOREIGN KEY (`usuarioId`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `FK_tipoUsuarioPreparacionID-TipoUsuario` FOREIGN KEY (`tipoUsuarioPreparacionId`) REFERENCES `tipousuario` (`id`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `FK_TipoUsuario` FOREIGN KEY (`tipoUsuarioId`) REFERENCES `tipousuario` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
