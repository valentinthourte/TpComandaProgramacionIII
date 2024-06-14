-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-06-2024 a las 01:37:23
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
-- Base de datos: `comandas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comanda`
--

CREATE TABLE `comanda` (
  `id` int(11) NOT NULL,
  `numeroPedido` varchar(5) NOT NULL,
  `estadoComanda` varchar(30) NOT NULL,
  `tipoUsuarioPreparacionId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comanda`
--

INSERT INTO `comanda` (`id`, `numeroPedido`, `estadoComanda`, `tipoUsuarioPreparacionId`) VALUES
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
(12, 'abps6', 'Pendiente', 5),
(13, 'abps6', 'Pendiente', 4),
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
(35, 'ylev0', 'Pendiente', 5),
(36, 'ylev0', 'Pendiente', 4);

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
(36, 14, 1);

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
  `estadoPedido` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`id`, `numeroPedido`, `cliente`, `fechaHoraInicioPreparacion`, `tiempoEstimadoPreparacion`, `codigoMesa`, `estadoPedido`) VALUES
(1, 'hjz4i', 'Valentin Thourte', '2024-06-14 18:59:26', 15, 1, 'Pendiente'),
(2, 'dyxld', 'Valentin Thourte', '2024-06-14 19:00:54', 15, 1, 'Pendiente'),
(3, '35knq', 'Valentin Thourte', '2024-06-14 19:01:29', 15, 1, 'Pendiente'),
(4, 'm4l58', 'Valentin Thourte', '2024-06-14 19:27:08', 15, 1, 'Pendiente'),
(5, '481fn', 'Valentin Thourte', '2024-06-14 19:28:50', 15, 1, 'Pendiente'),
(6, 'abps6', 'Valentin Thourte', '2024-06-14 19:32:19', 15, 1, 'Pendiente'),
(7, 'mp41a', 'Valentin Thourte', '2024-06-14 19:32:41', 15, 1, 'Pendiente'),
(8, 's0hsy', 'Valentin Thourte', '2024-06-14 19:33:03', 15, 1, 'Pendiente'),
(9, '9ao2i', 'Valentin Thourte', '2024-06-14 19:34:04', 15, 1, 'Pendiente'),
(10, '63qup', 'Valentin Thourte', '2024-06-14 19:34:35', 15, 1, 'Pendiente'),
(11, 'ihw3d', 'Valentin Thourte', '2024-06-14 19:42:12', 15, 1, 'Pendiente'),
(12, '4bjr2', 'Valentin Thourte', '2024-06-14 19:46:20', 15, 1, 'Pendiente'),
(13, 'lp7u9', 'Valentin Thourte', '2024-06-14 19:46:40', 15, 1, 'Pendiente'),
(14, 'zi4y2', 'Valentin Thourte', '2024-06-14 19:51:39', 15, 1, 'Pendiente'),
(15, '3yphh', 'Valentin Thourte', '2024-06-14 19:53:00', 15, 1, 'Pendiente'),
(16, 'kl272', 'Valentin Thourte', '2024-06-14 19:54:51', 15, 1, 'Pendiente'),
(17, 'd99kg', 'Valentin Thourte', '2024-06-14 19:57:24', 15, 1, 'Pendiente'),
(18, 'gn35o', 'Valentin Thourte', '2024-06-14 19:57:51', 15, 1, 'Pendiente'),
(19, 'ofdk6', 'Valentin Thourte', '2024-06-14 19:58:10', 15, 1, 'Pendiente'),
(20, 'zttmr', 'Valentin Thourte', '2024-06-14 20:01:15', 15, 1, 'Pendiente'),
(21, 'gc2aw', 'Valentin Thourte', '2024-06-14 20:09:36', 15, 1, 'Pendiente'),
(22, 'j5kl5', 'Valentin Thourte', '2024-06-14 20:10:42', 15, 1, 'Pendiente'),
(23, 'i3yip', 'Valentin Thourte', '2024-06-14 20:11:44', 15, 1, 'Pendiente'),
(24, 'dj4a6', 'Valentin Thourte', '2024-06-14 20:12:14', 15, 1, 'Pendiente'),
(25, '8fsfy', 'Valentin Thourte', '2024-06-14 20:14:17', 15, 1, 'Pendiente'),
(26, 'ylev0', 'Valentin Thourte', '2024-06-14 20:15:39', 15, 1, 'Pendiente');

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
(14, 'Vino Malbec', 4500, 2, 4);

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
(5, 'Cocinero');

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
(4, 'ValentinThourte', '1234', 1, NULL),
(5, 'JimenaT', 'abcd', 1, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comanda`
--
ALTER TABLE `comanda`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_comanda.tipoUsuarioPreparacionId-TipoUsuario.id` (`tipoUsuarioPreparacionId`),
  ADD KEY `FK_comanda.numeroPedido-pedido.numeroPedido` (`numeroPedido`);

--
-- Indices de la tabla `comandaproducto`
--
ALTER TABLE `comandaproducto`
  ADD KEY `FK_comandaProducto.comandaId-comanda.id` (`comandaId`),
  ADD KEY `FK_comandaProducto.productoId-producto.id` (`productoId`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `tipousuario`
--
ALTER TABLE `tipousuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comanda`
--
ALTER TABLE `comanda`
  ADD CONSTRAINT `FK_comanda.numeroPedido-pedido.numeroPedido` FOREIGN KEY (`numeroPedido`) REFERENCES `pedido` (`numeroPedido`),
  ADD CONSTRAINT `FK_comanda.tipoUsuarioPreparacionId-TipoUsuario.id` FOREIGN KEY (`tipoUsuarioPreparacionId`) REFERENCES `tipousuario` (`id`);

--
-- Filtros para la tabla `comandaproducto`
--
ALTER TABLE `comandaproducto`
  ADD CONSTRAINT `FK_comandaProducto.comandaId-comanda.id` FOREIGN KEY (`comandaId`) REFERENCES `comanda` (`id`),
  ADD CONSTRAINT `FK_comandaProducto.productoId-producto.id` FOREIGN KEY (`productoId`) REFERENCES `producto` (`id`);

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
