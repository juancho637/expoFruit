-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-06-2015 a las 04:44:23
-- Versión del servidor: 5.6.21
-- Versión de PHP: 5.5.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `bd_expofruits`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_categoria_producto`
--

CREATE TABLE IF NOT EXISTS `tb_categoria_producto` (
  `id_categoria` varchar(1) NOT NULL,
  `nombre_categoria` varchar(50) NOT NULL,
  `descripcion_categoria` varchar(5000) NOT NULL,
  `fecha_creacion` varchar(100) NOT NULL,
  `disponible_categoria` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='categoria de cada producto flor/fruta';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_ciudades`
--

CREATE TABLE IF NOT EXISTS `tb_ciudades` (
  `cod_ciudad` varchar(5) NOT NULL COMMENT 'identificador de cada ciudad',
  `nombre_ciudad` varchar(100) NOT NULL,
  `cod_pais` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='paises generales.';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_compras_usuario`
--

CREATE TABLE IF NOT EXISTS `tb_compras_usuario` (
`id_compra` int(11) NOT NULL COMMENT 'identificador temporal',
  `id_factura` varchar(10) NOT NULL,
  `id_usuario_comun` varchar(10) NOT NULL,
  `fecha_compra` varchar(50) NOT NULL,
  `id_pago_elec` varchar(100) NOT NULL COMMENT 'referencia al registro de pago realizado.'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='registro de compras por usuario comun.';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_factura`
--

CREATE TABLE IF NOT EXISTS `tb_factura` (
`id_factura` int(10) NOT NULL COMMENT 'identificador de cada factura',
  `fecha_factura` varchar(50) NOT NULL,
  `id_usuario_comun` varchar(10) NOT NULL,
  `total_factura` int(10) NOT NULL,
  `pais_envio` varchar(100) NOT NULL,
  `ciudad_envio` varchar(100) NOT NULL,
  `comentarios` varchar(3000) NOT NULL,
  `direccion_envio` varchar(300) NOT NULL,
  `estado_factura` varchar(1) NOT NULL COMMENT 'indica si la venta fue concretada con finalizacion del pago.'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='descripcion de la factura ';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_pagos_electronicos`
--

CREATE TABLE IF NOT EXISTS `tb_pagos_electronicos` (
`id_pago_elec` int(11) NOT NULL COMMENT 'identifcador interno',
  `ref_pago` varchar(100) NOT NULL COMMENT 'referencia de paypal',
  `valor_pago` varchar(100) NOT NULL,
  `fecha_pago` varchar(100) NOT NULL,
  `id_factura` varchar(100) NOT NULL COMMENT 'referencia a factura',
  `estado_pago` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='pagos electronicos.';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_pais`
--

CREATE TABLE IF NOT EXISTS `tb_pais` (
  `cod_pais` varchar(5) NOT NULL COMMENT 'codigo de cada pais.',
  `nombre_pais` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='paises en general';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_productos`
--

CREATE TABLE IF NOT EXISTS `tb_productos` (
`id_producto` int(11) NOT NULL COMMENT 'identificador de cada producto',
  `nombre_producto` varchar(50) NOT NULL,
  `valor_producto` int(10) NOT NULL,
  `categoria_producto` varchar(1) NOT NULL,
  `imagen1_producto` varchar(500) NOT NULL,
  `imagen2_producto` varchar(500) DEFAULT NULL,
  `imagen3_producto` varchar(500) DEFAULT NULL,
  `imagen4_producto` varchar(500) DEFAULT NULL,
  `cantidad_producto` int(10) NOT NULL,
  `compra_minima_producto` int(5) NOT NULL COMMENT 'minima compra permitida por producto.',
  `descripcion_producto` varchar(5000) NOT NULL,
  `fecha_ingreso_producto` varchar(100) NOT NULL,
  `disponible_producto` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='descripcion de cada producto.';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_recibo`
--

CREATE TABLE IF NOT EXISTS `tb_recibo` (
`id_ident` int(11) NOT NULL COMMENT 'identificador temporal para carro de compra.',
  `id_usuario_comun` varchar(10) NOT NULL,
  `id_producto` varchar(5) NOT NULL,
  `fecha_compra` varchar(50) NOT NULL,
  `cant_seleccionado` float NOT NULL,
  `valor_producto` float NOT NULL,
  `tipo_cantidad` varchar(1) NOT NULL COMMENT 'define si es kilo, libro y otro seudonimo.',
  `estado_recibo` varchar(1) NOT NULL COMMENT 'establece que el recibo ya fue facturado.'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='tabla temporal para realizar el recibo del carrito de compra.';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_roles`
--

CREATE TABLE IF NOT EXISTS `tb_roles` (
  `id_role` varchar(1) NOT NULL COMMENT 'identificador de cada role',
  `nombre_role` varchar(50) NOT NULL,
  `descrip_role` varchar(500) NOT NULL,
  `disponible_role` varchar(1) NOT NULL COMMENT '1=Disponible 0=No disponible'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='roles para cada usuarios administrativo.';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_tipo_cant`
--

CREATE TABLE IF NOT EXISTS `tb_tipo_cant` (
`id_tipo_cant` int(1) NOT NULL,
  `nombre_cant` varchar(50) NOT NULL,
  `valor_libras` float NOT NULL COMMENT 'valor del tipo cantidad en libras(valor global)'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='tipo de medida para cada articulo';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_usuarios`
--

CREATE TABLE IF NOT EXISTS `tb_usuarios` (
`id_usuario` int(11) NOT NULL COMMENT 'identificador de cada cliente',
  `nickname_usuario` varchar(100) NOT NULL,
  `pass_usuario` varchar(100) NOT NULL,
  `nombre_usuario` varchar(50) NOT NULL,
  `apellido_usuario` varchar(50) NOT NULL,
  `role_usuarios` varchar(1) NOT NULL COMMENT 'identificador para secciones de cada usuario.',
  `email_usuarios` varchar(100) NOT NULL,
  `ciudad_usuario` varchar(5) NOT NULL,
  `pais_usuario` varchar(5) NOT NULL,
  `disponible_usuario` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='usuarios administrativos';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_usuarios_comun`
--

CREATE TABLE IF NOT EXISTS `tb_usuarios_comun` (
`id_usuarios_comun` int(11) NOT NULL COMMENT 'identificador unico de usuario',
  `nickname_usuario_comun` varchar(100) NOT NULL,
  `password_usuario` varchar(100) NOT NULL,
  `imagen_perfil` varchar(100) DEFAULT NULL,
  `nombre_usuario_comun` varchar(50) NOT NULL,
  `apellido_usuario_comun` varchar(100) NOT NULL,
  `tel1_usuario_comun` varchar(10) NOT NULL,
  `tel2_usuario_comun` varchar(10) NOT NULL,
  `pais_usuario_comun` varchar(5) NOT NULL,
  `ciudad_usuario_comun` varchar(5) NOT NULL,
  `direccion_usuario_comun` varchar(100) DEFAULT NULL,
  `email_usuario_comun` varchar(50) NOT NULL,
  `fecha_registro` varchar(100) NOT NULL,
  `fecha_de_baja` varchar(100) DEFAULT NULL,
  `usuario_comun_activo` varchar(1) NOT NULL,
  `contacto_usuario_comun` varchar(1) NOT NULL COMMENT 'permitir enviar o no correos privilegiados',
  `tipo_role` varchar(1) NOT NULL COMMENT 'para verficiar al logearse  si es admin o no.'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='tabla de usuarios comunes que acceden a la pagina.';

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tb_categoria_producto`
--
ALTER TABLE `tb_categoria_producto`
 ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `tb_ciudades`
--
ALTER TABLE `tb_ciudades`
 ADD PRIMARY KEY (`cod_ciudad`);

--
-- Indices de la tabla `tb_compras_usuario`
--
ALTER TABLE `tb_compras_usuario`
 ADD PRIMARY KEY (`id_compra`);

--
-- Indices de la tabla `tb_factura`
--
ALTER TABLE `tb_factura`
 ADD PRIMARY KEY (`id_factura`);

--
-- Indices de la tabla `tb_pagos_electronicos`
--
ALTER TABLE `tb_pagos_electronicos`
 ADD PRIMARY KEY (`id_pago_elec`);

--
-- Indices de la tabla `tb_pais`
--
ALTER TABLE `tb_pais`
 ADD PRIMARY KEY (`cod_pais`);

--
-- Indices de la tabla `tb_productos`
--
ALTER TABLE `tb_productos`
 ADD PRIMARY KEY (`id_producto`);

--
-- Indices de la tabla `tb_recibo`
--
ALTER TABLE `tb_recibo`
 ADD PRIMARY KEY (`id_ident`);

--
-- Indices de la tabla `tb_roles`
--
ALTER TABLE `tb_roles`
 ADD PRIMARY KEY (`id_role`);

--
-- Indices de la tabla `tb_tipo_cant`
--
ALTER TABLE `tb_tipo_cant`
 ADD PRIMARY KEY (`id_tipo_cant`);

--
-- Indices de la tabla `tb_usuarios`
--
ALTER TABLE `tb_usuarios`
 ADD PRIMARY KEY (`id_usuario`);

--
-- Indices de la tabla `tb_usuarios_comun`
--
ALTER TABLE `tb_usuarios_comun`
 ADD PRIMARY KEY (`id_usuarios_comun`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tb_compras_usuario`
--
ALTER TABLE `tb_compras_usuario`
MODIFY `id_compra` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador temporal';
--
-- AUTO_INCREMENT de la tabla `tb_factura`
--
ALTER TABLE `tb_factura`
MODIFY `id_factura` int(10) NOT NULL AUTO_INCREMENT COMMENT 'identificador de cada factura';
--
-- AUTO_INCREMENT de la tabla `tb_pagos_electronicos`
--
ALTER TABLE `tb_pagos_electronicos`
MODIFY `id_pago_elec` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identifcador interno';
--
-- AUTO_INCREMENT de la tabla `tb_productos`
--
ALTER TABLE `tb_productos`
MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador de cada producto';
--
-- AUTO_INCREMENT de la tabla `tb_recibo`
--
ALTER TABLE `tb_recibo`
MODIFY `id_ident` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador temporal para carro de compra.';
--
-- AUTO_INCREMENT de la tabla `tb_tipo_cant`
--
ALTER TABLE `tb_tipo_cant`
MODIFY `id_tipo_cant` int(1) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `tb_usuarios`
--
ALTER TABLE `tb_usuarios`
MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador de cada cliente';
--
-- AUTO_INCREMENT de la tabla `tb_usuarios_comun`
--
ALTER TABLE `tb_usuarios_comun`
MODIFY `id_usuarios_comun` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador unico de usuario';
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
