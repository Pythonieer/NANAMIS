-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-08-2024 a las 15:15:05
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `nanamis`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `banderillas`
--

CREATE TABLE `banderillas` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `banderillas`
--

INSERT INTO `banderillas` (`id`, `order_id`) VALUES
(10, 9),
(11, 10),
(12, 10),
(14, 12),
(15, 15),
(16, 16),
(17, 17),
(18, 18);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `banderilla_personalizada`
--

CREATE TABLE `banderilla_personalizada` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `aderezo` varchar(255) NOT NULL,
  `empanizado` varchar(255) NOT NULL,
  `tipo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `banderilla_personalizada`
--

INSERT INTO `banderilla_personalizada` (`id`, `order_id`, `aderezo`, `empanizado`, `tipo`) VALUES
(10, 9, 'ketchup', 'clasico', 'y la queso'),
(11, 10, 'ketchup', 'clasico', 'y la queso'),
(12, 10, 'ketchup', 'ramen', 'mixta'),
(14, 12, 'ketchup', 'clasico', 'y la queso'),
(15, 15, 'ranch', 'papa', 'mixta'),
(16, 16, 'ketchup', 'ramen', 'entera'),
(17, 17, 'ketchup', 'clasico', 'mixta'),
(18, 18, 'ketchup', 'clasico', 'entera');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `id_prod` int(11) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `stock_actual` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `limonadas`
--

CREATE TABLE `limonadas` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `limonadas`
--

INSERT INTO `limonadas` (`id`, `order_id`) VALUES
(3, 12),
(4, 12),
(5, 19);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `limonada_personalizacion`
--

CREATE TABLE `limonada_personalizacion` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `sabor` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `limonada_personalizacion`
--

INSERT INTO `limonada_personalizacion` (`id`, `order_id`, `sabor`) VALUES
(3, 12, 'lima'),
(4, 12, 'limon'),
(5, 19, 'blue raspberry');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden`
--

CREATE TABLE `orden` (
  `id_orden` int(11) NOT NULL,
  `fecha_orden` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `orden`
--

INSERT INTO `orden` (`id_orden`, `fecha_orden`) VALUES
(9, '2024-08-06 23:02:44'),
(10, '2024-08-17 01:18:51'),
(12, '2024-08-18 16:13:25'),
(13, '2024-08-18 16:26:45'),
(14, '2024-08-18 16:27:23'),
(15, '2024-08-18 16:28:05'),
(16, '2024-08-18 16:50:51'),
(17, '2024-08-19 00:10:47'),
(18, '2024-08-19 00:39:02'),
(19, '2024-08-19 00:50:37');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_user` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Contrasena` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_user`, `Nombre`, `Contrasena`) VALUES
(1, 'Raul', 0x2432792431302434303239786e6846573336654c7841414a397871434f33773530504a2f4f746a732e2f70477450752f6f5037745871756352313743);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `Id` int(11) NOT NULL,
  `id_orden` int(11) NOT NULL,
  `cantidad_banderillas` int(11) NOT NULL,
  `cantidad_limonadas` int(11) NOT NULL,
  `total` float NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`Id`, `id_orden`, `cantidad_banderillas`, `cantidad_limonadas`, `total`, `id_user`) VALUES
(5, 4, 1, 0, 65, 1),
(6, 5, 1, 0, 65, 1),
(7, 6, 1, 0, 65, 1),
(8, 7, 1, 0, 65, 1),
(9, 11, 1, 1, 105, 1),
(10, 20, 1, 1, 105, 1),
(11, 8, 1, 0, 65, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas_user`
--

CREATE TABLE `ventas_user` (
  `id_user` int(11) NOT NULL,
  `total` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `banderillas`
--
ALTER TABLE `banderillas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `banderilla_personalizada`
--
ALTER TABLE `banderilla_personalizada`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`id_prod`);

--
-- Indices de la tabla `limonadas`
--
ALTER TABLE `limonadas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `limonada_personalizacion`
--
ALTER TABLE `limonada_personalizacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `orden`
--
ALTER TABLE `orden`
  ADD PRIMARY KEY (`id_orden`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_user`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `banderillas`
--
ALTER TABLE `banderillas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `banderilla_personalizada`
--
ALTER TABLE `banderilla_personalizada`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `inventario`
--
ALTER TABLE `inventario`
  MODIFY `id_prod` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `limonadas`
--
ALTER TABLE `limonadas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `limonada_personalizacion`
--
ALTER TABLE `limonada_personalizacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `orden`
--
ALTER TABLE `orden`
  MODIFY `id_orden` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
