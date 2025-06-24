  -- phpMyAdmin SQL Dump
  -- version 5.2.1
  -- https://www.phpmyadmin.net/
  --
  -- Servidor: localhost
  -- Tiempo de generación: 04-12-2023 a las 05:40:03
  -- Versión del servidor: 10.4.32-MariaDB
  -- Versión de PHP: 8.0.30

  SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
  START TRANSACTION;
  SET time_zone = "+00:00";


  /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
  /*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
  /*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
  /*!40101 SET NAMES utf8mb4 */;

  --
  -- Base de datos: `sala_belleza_spa`
  --

  -- --------------------------------------------------------

  --
  -- Estructura de tabla para la tabla `citas`
  --

  CREATE TABLE `citas` (
    `id_cita` int(11) NOT NULL,
    `cliente` varchar(100) NOT NULL,
    `fecha` date NOT NULL,
    `hora_inicio` time NOT NULL,
    `id_servicio` int(11) NOT NULL,
    `id_empleado` int(11) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

  --
  -- Volcado de datos para la tabla `citas`
  --

  INSERT INTO `citas` (`id_cita`, `cliente`, `fecha`, `hora_inicio`, `id_servicio`, `id_empleado`) VALUES
  (125, 'Juan RIvera', '2023-12-03', '08:00:00', 11, 16),
  (126, 'Ana Herrera', '2023-12-03', '08:00:00', 10, 17),
  (127, 'Alejandro Rivera', '2023-12-03', '08:00:00', 9, 18),
  (128, 'Patricia Fernandez', '2023-12-03', '08:00:00', 7, 19);

  -- --------------------------------------------------------

  --
  -- Estructura de tabla para la tabla `empleados`
  --

  CREATE TABLE `empleados` (
    `id_empleado` int(11) NOT NULL,
    `nombre` varchar(100) NOT NULL,
    `tipo_empleado_id` int(11) DEFAULT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

  --
  -- Volcado de datos para la tabla `empleados`
  --

  INSERT INTO `empleados` (`id_empleado`, `nombre`, `tipo_empleado_id`) VALUES
  (16, 'Valentina Garcia', 1),
  (17, 'Sebastian Lopez', 1),
  (18, 'Camila Ramirez', 2),
  (19, 'Alejandro Martinez', 2);

  -- --------------------------------------------------------

  --
  -- Estructura de tabla para la tabla `servicios`
  --

  CREATE TABLE `servicios` (
    `id_servicio` int(11) NOT NULL,
    `nombre_servicio` varchar(100) NOT NULL,
    `tipo_servicio_id` int(11) DEFAULT NULL,
    `precio` decimal(10,2) NOT NULL,
    `tiempo_estimado` time NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

  --
  -- Volcado de datos para la tabla `servicios`
  --

  INSERT INTO `servicios` (`id_servicio`, `nombre_servicio`, `tipo_servicio_id`, `precio`, `tiempo_estimado`) VALUES
  (7, 'Masaje relajante', 2, 50.00, '01:30:00'),
  (8, 'Facial de Hidratación Profunda', 2, 65.00, '01:15:00'),
  (9, 'Masaje de Piedras Calientes', 2, 55.00, '01:20:00'),
  (10, 'Manicura', 1, 15.00, '00:30:00'),
  (11, 'Corte de cabello (Caballero)', 1, 20.00, '00:25:00'),
  (12, 'Pedicura', 1, 40.00, '01:00:00');

  -- --------------------------------------------------------

  --
  -- Estructura de tabla para la tabla `tipos_empleado`
  --

  CREATE TABLE `tipos_empleado` (
    `id_tipo` int(11) NOT NULL,
    `nombre_tipo` varchar(50) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

  --
  -- Volcado de datos para la tabla `tipos_empleado`
  --

  INSERT INTO `tipos_empleado` (`id_tipo`, `nombre_tipo`) VALUES
  (1, 'Sala de Belleza'),
  (2, 'Spa');

  -- --------------------------------------------------------

  --
  -- Estructura de tabla para la tabla `tipos_servicio`
  --

  CREATE TABLE `tipos_servicio` (
    `id_tipo` int(11) NOT NULL,
    `nombre_tipo` varchar(50) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

  --
  -- Volcado de datos para la tabla `tipos_servicio`
  --

  INSERT INTO `tipos_servicio` (`id_tipo`, `nombre_tipo`) VALUES
  (1, 'Sala de Belleza'),
  (2, 'Spa');

  --
  -- Índices para tablas volcadas
  --

  --
  -- Indices de la tabla `citas`
  --
  ALTER TABLE `citas`
    ADD PRIMARY KEY (`id_cita`),
    ADD KEY `id_servicio` (`id_servicio`),
    ADD KEY `id_empleado` (`id_empleado`);

  --
  -- Indices de la tabla `empleados`
  --
  ALTER TABLE `empleados`
    ADD PRIMARY KEY (`id_empleado`),
    ADD KEY `tipo_empleado_id` (`tipo_empleado_id`);

  --
  -- Indices de la tabla `servicios`
  --
  ALTER TABLE `servicios`
    ADD PRIMARY KEY (`id_servicio`),
    ADD KEY `tipo_servicio_id` (`tipo_servicio_id`);

  --
  -- Indices de la tabla `tipos_empleado`
  --
  ALTER TABLE `tipos_empleado`
    ADD PRIMARY KEY (`id_tipo`);

  --
  -- Indices de la tabla `tipos_servicio`
  --
  ALTER TABLE `tipos_servicio`
    ADD PRIMARY KEY (`id_tipo`);

  --
  -- AUTO_INCREMENT de las tablas volcadas
  --

  --
  -- AUTO_INCREMENT de la tabla `citas`
  --
  ALTER TABLE `citas`
    MODIFY `id_cita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

  --
  -- AUTO_INCREMENT de la tabla `empleados`
  --
  ALTER TABLE `empleados`
    MODIFY `id_empleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

  --
  -- AUTO_INCREMENT de la tabla `servicios`
  --
  ALTER TABLE `servicios`
    MODIFY `id_servicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

  --
  -- AUTO_INCREMENT de la tabla `tipos_empleado`
  --
  ALTER TABLE `tipos_empleado`
    MODIFY `id_tipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

  --
  -- AUTO_INCREMENT de la tabla `tipos_servicio`
  --
  ALTER TABLE `tipos_servicio`
    MODIFY `id_tipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

  --
  -- Restricciones para tablas volcadas
  --

  --
  -- Filtros para la tabla `citas`
  --
  ALTER TABLE `citas`
    ADD CONSTRAINT `fk_citas_empleado` FOREIGN KEY (`id_empleado`) REFERENCES `empleados` (`id_empleado`),
    ADD CONSTRAINT `fk_citas_servicio` FOREIGN KEY (`id_servicio`) REFERENCES `servicios` (`id_servicio`);

  --
  -- Filtros para la tabla `empleados`
  --
  ALTER TABLE `empleados`
    ADD CONSTRAINT `empleados_ibfk_1` FOREIGN KEY (`tipo_empleado_id`) REFERENCES `tipos_empleado` (`id_tipo`);

  --
  -- Filtros para la tabla `servicios`
  --
  ALTER TABLE `servicios`
    ADD CONSTRAINT `servicios_ibfk_1` FOREIGN KEY (`tipo_servicio_id`) REFERENCES `tipos_servicio` (`id_tipo`);
  COMMIT;

  /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
  /*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
  /*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
