-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 05-06-2014 a las 22:21:08
-- Versión del servidor: 5.5.35
-- Versión de PHP: 5.3.10-1ubuntu3.11

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `horizon`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalleliquidacion`
--

CREATE TABLE IF NOT EXISTS `detalleliquidacion` (
  `idDetalleLiquidacion` int(11) NOT NULL AUTO_INCREMENT,
  `idLiquidacion` int(11) NOT NULL,
  `idProduct` varchar(15) NOT NULL,
  `carga0` int(11) NOT NULL,
  `carga1` int(11) NOT NULL,
  `carga2` int(11) NOT NULL,
  `carga3` int(11) NOT NULL,
  `carga4` int(11) NOT NULL,
  `venta` double NOT NULL,
  `prestamo` double NOT NULL,
  `bonificacion` double NOT NULL,
  `devolucion` double NOT NULL,
  `estado` tinyint(4) NOT NULL,
  `detalle` text NOT NULL,
  `excepcion` tinyint(4) NOT NULL,
  PRIMARY KEY (`idDetalleLiquidacion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `liquidacion`
--

CREATE TABLE IF NOT EXISTS `liquidacion` (
  `idLiquidacion` int(11) NOT NULL AUTO_INCREMENT,
  `fechaRegistro` date NOT NULL,
  `horaRegistro` time NOT NULL,
  `idUser` int(11) NOT NULL,
  `ruta` int(11) NOT NULL,
  `detalle` text NOT NULL,
  `fechaFin` date NOT NULL,
  `horaFin` time NOT NULL,
  `mark` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  PRIMARY KEY (`idLiquidacion`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `liquidacion`
--

INSERT INTO `liquidacion` (`idLiquidacion`, `fechaRegistro`, `horaRegistro`, `idUser`, `ruta`, `detalle`, `fechaFin`, `horaFin`, `mark`, `status`) VALUES
(1, '2014-06-20', '05:53:00', 10, 5, 'liquidation', '2014-06-20', '05:53:00', '0', ''),
(2, '2014-06-30', '05:56:00', 11, 3, 'looool', '2014-06-30', '05:56:00', '0', ''),
(3, '2014-06-19', '10:40:00', 6, 3, 'lolololo', '2014-06-19', '10:40:00', 'creado', 'active'),
(4, '2014-06-19', '10:38:00', 11, 3, 'yy', '2014-06-19', '10:38:00', 'creado', 'active');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;