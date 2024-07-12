-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-07-2024 a las 04:09:44
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
  `usuarioPreparacionId` int(11) DEFAULT NULL,
  `tiempoPreparacionEstimado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comanda`
--

INSERT INTO `comanda` (`id`, `numeroPedido`, `estadoComanda`, `usuarioPreparacionId`, `tiempoPreparacionEstimado`) VALUES
(2, 'hjz4i', 'Pendiente', 5, NULL),
(3, 'hjz4i', 'Pendiente', 4, NULL),
(4, 'dyxld', 'Pendiente', 5, NULL),
(5, 'dyxld', 'Pendiente', 4, NULL),
(6, '35knq', 'Pendiente', 5, NULL),
(7, '35knq', 'Pendiente', 4, NULL),
(8, 'm4l58', 'Pendiente', 5, NULL),
(9, 'm4l58', 'Pendiente', 4, NULL),
(10, '481fn', 'Pendiente', 5, NULL),
(11, '481fn', 'Pendiente', 4, NULL),
(12, 'abps6', 'Preparada', 5, NULL),
(13, 'abps6', 'Preparada', 4, NULL),
(14, 'mp41a', 'Pendiente', 5, NULL),
(15, 'mp41a', 'Pendiente', 4, NULL),
(16, 's0hsy', 'Pendiente', 5, NULL),
(17, 's0hsy', 'Pendiente', 4, NULL),
(18, '9ao2i', 'Pendiente', 5, NULL),
(19, '63qup', 'Pendiente', 5, NULL),
(25, 'kl272', 'Pendiente', 5, NULL),
(26, 'd99kg', 'Pendiente', 5, NULL),
(27, 'gn35o', 'Pendiente', 5, NULL),
(28, 'ofdk6', 'Pendiente', 5, NULL),
(29, 'zttmr', 'Pendiente', 5, NULL),
(30, 'gc2aw', 'Pendiente', 5, NULL),
(31, 'j5kl5', 'Pendiente', 5, NULL),
(32, 'i3yip', 'Pendiente', 5, NULL),
(33, 'dj4a6', 'Pendiente', 5, NULL),
(34, '8fsfy', 'Pendiente', 5, NULL),
(35, 'ylev0', 'EnPreparacion', 5, NULL),
(36, 'ylev0', 'Pendiente', 4, NULL),
(37, 'koydu', 'Preparada', NULL, NULL),
(38, 'koydu', 'Pendiente', NULL, NULL),
(39, 'koydu', 'Pendiente', NULL, NULL),
(40, 'pzkq8', 'Preparada', NULL, NULL),
(41, 'pzkq8', 'Pendiente', NULL, NULL),
(42, 'pzkq8', 'Pendiente', NULL, NULL),
(43, 'vcd29', 'Pendiente', 5, NULL),
(44, 'vcd29', 'Pendiente', 4, NULL),
(46, 'y22eg', 'Pendiente', 5, NULL),
(47, 'y22eg', 'Pendiente', 4, NULL),
(49, 'rchwc', 'Preparada', 4, NULL),
(50, 'rchwc', 'EnPreparacion', 8, NULL),
(51, 'rchwc', 'EnPreparacion', 9, NULL),
(52, 'u2whp', 'Preparada', NULL, NULL),
(53, 'u2whp', 'Preparada', 9, NULL),
(54, 'u2whp', 'EnPreparacion', 8, NULL),
(55, 'jb7by', 'EnPreparacion', 12, NULL),
(56, 'jb7by', 'Pendiente', NULL, NULL),
(57, 'jb7by', 'Pendiente', NULL, NULL),
(58, 'qs1jx', 'Pendiente', NULL, NULL),
(59, 'qs1jx', 'Pendiente', NULL, NULL),
(60, 'qs1jx', 'Pendiente', NULL, NULL),
(67, 'fifwl', 'EnPreparacion', 12, NULL),
(68, 'fifwl', 'Pendiente', NULL, NULL),
(69, 'fifwl', 'Pendiente', NULL, NULL),
(70, '4kpb5', 'Pendiente', NULL, NULL),
(71, '4kpb5', 'Pendiente', NULL, NULL),
(72, '4kpb5', 'Pendiente', NULL, NULL),
(73, '9esc3', 'Pendiente', NULL, NULL),
(74, 'ws78g', 'Pendiente', NULL, NULL),
(75, '9paat', 'Pendiente', NULL, NULL),
(76, 'rbqov', 'Pendiente', NULL, NULL),
(77, 'rbqov', 'Pendiente', NULL, NULL),
(78, 'rbqov', 'Pendiente', NULL, NULL),
(79, 'd59pm', 'Pendiente', 5, NULL),
(81, 'dmwg8', 'EnPreparacion', 12, NULL),
(82, 'dmwg8', 'Pendiente', NULL, NULL),
(83, 'dmwg8', 'Pendiente', NULL, NULL),
(84, '0oghs', 'EnPreparacion', 12, NULL),
(85, '0oghs', 'EnPreparacion', 9, NULL),
(86, '0oghs', 'EnPreparacion', 8, NULL),
(87, 'skfq9', 'Preparada', 12, 12),
(88, 'skfq9', 'Preparada', 9, NULL),
(89, 'skfq9', 'Preparada', 8, 15),
(90, '5gn07', 'Preparada', 12, 15),
(91, '5gn07', 'Preparada', 9, 15),
(92, '5gn07', 'Preparada', 8, 15);

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
(51, 16, 1),
(52, 52, 1),
(52, 53, 1),
(52, 53, 1),
(53, 54, 1),
(54, 55, 1),
(58, 52, 1),
(58, 53, 1),
(59, 54, 1),
(60, 55, 1),
(67, 52, 1),
(67, 53, 1),
(68, 54, 1),
(69, 55, 1),
(70, 52, 1),
(70, 53, 1),
(71, 54, 1),
(72, 55, 1),
(73, 52, 1),
(73, 53, 2),
(74, 52, 1),
(74, 53, 2),
(75, 52, 1),
(75, 53, 2),
(76, 52, 1),
(76, 53, 2),
(77, 54, 1),
(78, 55, 1),
(79, 52, 1),
(79, 53, 2),
(81, 52, 1),
(81, 53, 2),
(82, 54, 1),
(83, 55, 1),
(84, 52, 1),
(84, 53, 2),
(85, 54, 1),
(86, 55, 1),
(87, 52, 1),
(87, 53, 2),
(88, 54, 1),
(89, 55, 1),
(90, 52, 1),
(90, 53, 2),
(91, 54, 1),
(92, 55, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encuesta`
--

CREATE TABLE `encuesta` (
  `id` int(11) NOT NULL,
  `puntuacionMesa` int(11) NOT NULL,
  `puntuacionRestaurante` int(11) NOT NULL,
  `puntuacionMozo` int(11) NOT NULL,
  `puntuacionCocinero` int(11) NOT NULL,
  `texto` varchar(66) NOT NULL,
  `experienciaEsBuena` tinyint(1) NOT NULL,
  `numeroPedido` varchar(5) NOT NULL,
  `numeroMesa` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `encuesta`
--

INSERT INTO `encuesta` (`id`, `puntuacionMesa`, `puntuacionRestaurante`, `puntuacionMozo`, `puntuacionCocinero`, `texto`, `experienciaEsBuena`, `numeroPedido`, `numeroMesa`) VALUES
(1, 10, 10, 1, 1, 'La verdad un desastre. ', 0, 'skfq9', '46359'),
(2, 10, 10, 1, 1, 'La verdad un desastre. ', 1, 'skfq9', '46359'),
(3, 7, 9, 8, 6, 'La verdad una excelencia. ', 1, 'skfq9', '46359'),
(4, 10, 9, 10, 10, 'La verdad una excelencia. ', 1, 'skfq9', '46359');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `loginsusuario`
--
-- Error leyendo la estructura de la tabla restaurante.loginsusuario: #1932 - Table &#039;restaurante.loginsusuario&#039; doesn&#039;t exist in engine
-- Error leyendo datos de la tabla restaurante.loginsusuario: #1064 - Algo está equivocado en su sintax cerca &#039;FROM `restaurante`.`loginsusuario`&#039; en la linea 1

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
('2', 'ConClienteEsperandoComida'),
('3', 'Baja'),
('3fdwa', 'ConClienteEsperandoPedido'),
('46359', 'Cerrada'),
('7biuw', 'ConClienteEsperandoPedido'),
('98iow', 'Cerrada'),
('ac8ro', 'Cerrada'),
('bvxxy', 'ConClienteEsperandoPedido'),
('d6kmh', 'ConClienteEsperandoPedido'),
('es387', 'ConClienteEsperandoPedido'),
('q0i46', 'ConClienteEsperandoPedido'),
('vw5vu', 'ConClienteComiendo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `id` int(11) NOT NULL,
  `numeroPedido` varchar(5) NOT NULL,
  `cliente` varchar(255) NOT NULL,
  `fechaHoraInicioPreparacion` datetime NOT NULL DEFAULT current_timestamp(),
  `tiempoEstimadoPreparacion` int(11) DEFAULT NULL,
  `codigoMesa` varchar(50) NOT NULL,
  `estadoPedido` varchar(50) NOT NULL,
  `fechaHoraFinPreparacion` datetime DEFAULT NULL,
  `rutaImagen` varchar(255) DEFAULT NULL,
  `mozoId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`id`, `numeroPedido`, `cliente`, `fechaHoraInicioPreparacion`, `tiempoEstimadoPreparacion`, `codigoMesa`, `estadoPedido`, `fechaHoraFinPreparacion`, `rutaImagen`, `mozoId`) VALUES
(1, 'hjz4i', 'Valentin Thourte', '2024-06-14 18:59:26', 15, '2', 'ListoParaServir', NULL, NULL, 7),
(2, 'dyxld', 'Valentin Thourte', '2024-06-14 19:00:54', 15, '2', 'Pendiente', NULL, NULL, 7),
(3, '35knq', 'Valentin Thourte', '2024-06-14 19:01:29', 15, '2', 'Pendiente', NULL, NULL, 7),
(4, 'm4l58', 'Valentin Thourte', '2024-06-14 19:27:08', 15, '2', 'Pendiente', NULL, NULL, 7),
(5, '481fn', 'Valentin Thourte', '2024-06-14 19:28:50', 15, '2', 'Pendiente', NULL, NULL, 7),
(6, 'abps6', 'Valentin Thourte', '2024-06-14 19:32:19', 15, '2', 'ListoParaServir', NULL, NULL, 7),
(7, 'mp41a', 'Valentin Thourte', '2024-06-14 19:32:41', 15, '2', 'Pendiente', NULL, NULL, 7),
(8, 's0hsy', 'Valentin Thourte', '2024-06-14 19:33:03', 15, '2', 'Pendiente', NULL, NULL, 7),
(9, '9ao2i', 'Valentin Thourte', '2024-06-14 19:34:04', 15, '2', 'Pendiente', NULL, NULL, 7),
(10, '63qup', 'Valentin Thourte', '2024-06-14 19:34:35', 15, '2', 'Pendiente', NULL, NULL, 7),
(11, 'ihw3d', 'Valentin Thourte', '2024-06-14 19:42:12', 15, '2', 'Pendiente', NULL, NULL, 7),
(12, '4bjr2', 'Valentin Thourte', '2024-06-14 19:46:20', 15, '2', 'Pendiente', NULL, NULL, 7),
(13, 'lp7u9', 'Valentin Thourte', '2024-06-14 19:46:40', 15, '2', 'Pendiente', NULL, NULL, 7),
(14, 'zi4y2', 'Valentin Thourte', '2024-06-14 19:51:39', 15, '2', 'Pendiente', NULL, NULL, 7),
(15, '3yphh', 'Valentin Thourte', '2024-06-14 19:53:00', 15, '2', 'Pendiente', NULL, NULL, 7),
(16, 'kl272', 'Valentin Thourte', '2024-06-14 19:54:51', 15, '2', 'Pendiente', NULL, NULL, 7),
(17, 'd99kg', 'Valentin Thourte', '2024-06-14 19:57:24', 15, '2', 'Pendiente', NULL, NULL, 7),
(18, 'gn35o', 'Valentin Thourte', '2024-06-14 19:57:51', 15, '2', 'Pendiente', NULL, NULL, 7),
(19, 'ofdk6', 'Valentin Thourte', '2024-06-14 19:58:10', 15, '2', 'Pendiente', NULL, NULL, 7),
(20, 'zttmr', 'Valentin Thourte', '2024-06-14 20:01:15', 15, '2', 'Pendiente', NULL, NULL, 7),
(21, 'gc2aw', 'Valentin Thourte', '2024-06-14 20:09:36', 15, '2', 'Pendiente', NULL, NULL, 7),
(22, 'j5kl5', 'Valentin Thourte', '2024-06-14 20:10:42', 15, '2', 'Pendiente', NULL, NULL, 7),
(23, 'i3yip', 'Valentin Thourte', '2024-06-14 20:11:44', 15, '2', 'Pendiente', NULL, NULL, 7),
(24, 'dj4a6', 'Valentin Thourte', '2024-06-14 20:12:14', 15, '2', 'Pendiente', NULL, NULL, 7),
(25, '8fsfy', 'Valentin Thourte', '2024-06-14 20:14:17', 15, '2', 'Pendiente', NULL, NULL, 7),
(26, 'ylev0', 'Valentin Thourte', '2024-06-14 20:15:39', 15, '2', 'EnPreparacion', NULL, NULL, 7),
(27, 'i08if', 'Valentin Thourte', '2024-07-05 10:50:56', 15, '2', 'Pendiente', NULL, NULL, 7),
(28, 'pncvw', 'Valentin Thourte', '2024-07-05 10:51:44', 15, '2', 'Pendiente', NULL, NULL, 7),
(29, 'zv4sf', 'Valentin Thourte', '2024-07-05 10:52:12', 15, '2', 'Pendiente', NULL, NULL, 7),
(30, 'koydu', 'Valentin Thourte', '2024-07-05 10:52:41', 15, '2', 'Pendiente', NULL, NULL, 7),
(31, 'pzkq8', 'Valentin Thourte', '2024-07-05 11:35:01', 15, '2', 'Pendiente', NULL, NULL, 7),
(32, 'vcd29', 'Valentin Thourte', '2024-07-05 11:39:18', 15, '2', 'Pendiente', NULL, NULL, 7),
(33, 'y22eg', 'Valentin Thourte', '2024-07-05 11:40:41', 15, '2', 'Pendiente', NULL, NULL, 7),
(34, 'rchwc', 'Valentin Thourte', '2024-07-05 11:42:11', 15, '2', 'Servido', '2024-07-05 16:31:03', NULL, 7),
(35, 'qs1jx', 'Valentin Thourte', '2024-07-09 12:38:26', NULL, '2', 'Pendiente', NULL, NULL, 7),
(38, 'fifwl', 'Valentin Thourte', '2024-07-09 12:52:15', NULL, '2', 'Pendiente', NULL, 'C:\\xampp\\htdocs\\TP_ProgramacionIII_ValentinThourte\\app/ImagenesDePedido/2024/Pedido-fifwl.jpg', 7),
(39, '4kpb5', 'Valentin Thourte', '2024-07-09 12:54:43', NULL, '2', 'Pendiente', NULL, NULL, 7),
(40, 'uwub6', 'Valentin Thourte', '2024-07-11 19:39:14', NULL, '2', 'Pendiente', NULL, NULL, 7),
(41, '7odpi', 'Valentin Thourte', '2024-07-11 19:39:59', NULL, '2', 'Pendiente', NULL, NULL, 7),
(42, 'lqt95', 'Valentin Thourte', '2024-07-11 19:40:19', NULL, '2', 'Pendiente', NULL, NULL, 7),
(43, 'sxiwx', 'Valentin Thourte', '2024-07-11 19:40:30', NULL, '2', 'Pendiente', NULL, NULL, 7),
(44, '9esc3', 'Valentin Thourte', '2024-07-11 19:42:03', NULL, '2', 'Pendiente', NULL, NULL, 7),
(45, 'ws78g', 'Valentin Thourte', '2024-07-11 19:42:19', NULL, '2', 'Pendiente', NULL, NULL, 7),
(46, '9paat', 'Valentin Thourte', '2024-07-11 19:43:49', NULL, '2', 'Pendiente', NULL, NULL, 7),
(47, 'rbqov', 'Valentin Thourte', '2024-07-11 19:44:34', NULL, '2', 'Pendiente', NULL, 'C:\\xampp\\htdocs\\TP_ProgramacionIII_ValentinThourte\\app/ImagenesDePedido/2024/Pedido-rbqov.jpg', 7),
(48, 'd59pm', 'Valentin Thourte', '2024-07-11 19:50:27', NULL, '2', 'Pendiente', NULL, NULL, 7),
(49, 'dmwg8', 'Valentin Thourte', '2024-07-11 20:04:35', NULL, '2', 'Pendiente', NULL, 'C:\\xampp\\htdocs\\TP_ProgramacionIII_ValentinThourte\\app/ImagenesDePedido/2024/Pedido-dmwg8.jpg', 7),
(50, '0oghs', 'Valentin Thourte', '2024-07-11 20:09:14', NULL, '3fdwa', 'Pendiente', NULL, 'C:\\xampp\\htdocs\\TP_ProgramacionIII_ValentinThourte\\app/ImagenesDePedido/2024/Pedido-0oghs.jpg', 7),
(51, 'skfq9', 'Valentin Thourte', '2024-07-11 20:21:33', NULL, '46359', 'Servido', '2024-07-11 21:05:59', 'C:\\xampp\\htdocs\\TP_ProgramacionIII_ValentinThourte\\app/ImagenesDePedido/2024/Pedido-skfq9.jpg', 7),
(52, '5gn07', 'Valentin Thourte', '2024-07-11 23:02:02', NULL, 'vw5vu', 'Servido', '2024-07-11 23:07:31', 'C:\\xampp\\htdocs\\TP_ProgramacionIII_ValentinThourte\\app/ImagenesDePedido/2024/Pedido-5gn07.jpg', 7);

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
(51, 'Cerveza IPA Artesanal', 5, 7, 3),
(52, 'Milanesa a caballo', 2000, 5, 5),
(53, 'Hamburguesa de garbanzo', 1500, 10, 5),
(54, 'Cerveza corona', 1250, 3, 3),
(55, 'Daikiri', 1400, 4, 4);

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
(6, 'Pastelero'),
(7, 'cliente');

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
(11, 'Cervecero2', '1234', 3, NULL),
(12, 'Cocinero1', '1234', 5, NULL),
(13, 'Socio1', '1234', 2, NULL),
(14, 'Cliente1', '1234', 7, NULL),
(15, 'Pastelero1', '1234', 6, NULL);

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
-- Indices de la tabla `encuesta`
--
ALTER TABLE `encuesta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_NumeroMesa_Mesa.numeroMesa` (`numeroMesa`);

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
  ADD KEY `FK_codigoMesa_Mesa.numeroMesa` (`codigoMesa`),
  ADD KEY `FK_mozoId_Usuario.id` (`mozoId`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT de la tabla `encuesta`
--
ALTER TABLE `encuesta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT de la tabla `tipousuario`
--
ALTER TABLE `tipousuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comanda`
--
ALTER TABLE `comanda`
  ADD CONSTRAINT `FK_comanda.usuarioPreparacionId-Usuario.Id` FOREIGN KEY (`usuarioPreparacionId`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `comandaproducto`
--
ALTER TABLE `comandaproducto`
  ADD CONSTRAINT `FK_comandaProducto.comandaId-comanda.id` FOREIGN KEY (`comandaId`) REFERENCES `comanda` (`id`),
  ADD CONSTRAINT `FK_comandaProducto.productoId-producto.id` FOREIGN KEY (`productoId`) REFERENCES `producto` (`id`);

--
-- Filtros para la tabla `encuesta`
--
ALTER TABLE `encuesta`
  ADD CONSTRAINT `FK_NumeroMesa_Mesa.numeroMesa` FOREIGN KEY (`numeroMesa`) REFERENCES `mesa` (`numeroMesa`);

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `FK_codigoMesa_Mesa.numeroMesa` FOREIGN KEY (`codigoMesa`) REFERENCES `mesa` (`numeroMesa`),
  ADD CONSTRAINT `FK_mozoId_Usuario.id` FOREIGN KEY (`mozoId`) REFERENCES `usuario` (`id`);

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
