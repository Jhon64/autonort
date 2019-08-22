-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 24-05-2019 a las 04:26:05
-- Versión del servidor: 5.7.24
-- Versión de PHP: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `autotuning`
--


--
-- Procedimientos
--

DELIMITER $$;
DROP PROCEDURE IF EXISTS `sp_cotizacion_Mnt`;
CREATE  PROCEDURE `sp_cotizacion_Mnt` (IN `xopcion` INT, IN `xcotizacionID` INT, IN `xcodigo` CHAR(10), IN `xserievh` CHAR(4), IN `xfechareg` DATETIME, IN `xestado` CHAR(2), IN `xclienteID` INT, IN `xasesorID` INT, IN `xsucursalID` INT, IN `xnota` VARCHAR(60), IN `xfechaPlanificacion` DATETIME, IN `xnotaPlanificacion` VARCHAR(60), IN `xvehiculo` CHAR(10), IN `xdocumento` CHAR(3))  BEGIN
declare xdias date;
declare xfechaPlanificacion date;
if(xopcion=1)
    then
		insert into cotizacion( DOCUMENTO, SERIE,NUMERO, FECHA, ESTADO, idCLIENTE, idASESORES, idSUCURSAL,
         NOTA_TRABAJO, FECHAPLANIFICACION, NOTA_PLANIFICACION,idVEHICULO) 
        values (xdocumento,xserievh,xcodigo,xfechaReg,xestado,xclienteID,xasesorID,xsucursalID,
        xnota,xfechaPlanificacion,xnotaPlanificacion,xvehiculo);
        select last_insert_id() as insercionID;
	
    end if;
    if(xopcion=0)
    then
		select co.idCOTIZACION,s.DESCRIPCION as sucursal,co.SERIE as SERIEVH,c.RAZON_SOCIAL,a.DESCRIPCION,co.FECHA,co.ESTADO
        from cotizacion co inner join sucursal s on co.idSUCURSAL=s.idSUCURSAL
        inner join cliente c on c.idCLIENTE=co.idCLIENTE
        inner join asesores a on a.idASESORES=co.idASESORES
        order by idCOTIZACION asc;
      
    end if;
    if(xopcion=3)then
			
		select co.idCOTIZACION,s.DESCRIPCION as sucursal,co.SERIE as SERIEVH,c.RAZON_SOCIAL,a.DESCRIPCION,co.FECHA,co.ESTADO,
        co.FECHAPLANIFICACION,abs(datediff(CURDATE(),FECHA)) /abs(datediff(FECHAPLANIFICACION,FECHA))*100 as porcentaje  from cotizacion co inner join sucursal s on co.idSUCURSAL=s.idSUCURSAL
        inner join cliente c on c.idCLIENTE=co.idCLIENTE
        inner join asesores a on a.idASESORES=co.idASESORES
        order by idCOTIZACION asc;
        end if;
       
        
END

DROP PROCEDURE IF EXISTS `SP_Mantenedor_Producto`;
CREATE  PROCEDURE `SP_Mantenedor_Producto` (IN `xopcion` INT, IN `xgrupo` INT, IN `xsubgrupo` INT, IN `xestado` INT)  begin
	if(xopcion=0)
		then
			select p.idPRODUCTOS,P.CODIGO,P.DESCRIPCION ,g.DESCRIPCION as GRUPO,s.DESCRIPCION as SUBGRUPO,u.DESCRIPCION as UM from productos p
			INNER JOIN grupo g on g.idGRUPO=p.idGRUPO
			INNER JOIN subgrupo s on s.idSUBGRUPO=P.idSUBGRUPO
			INNER JOIN unidad_medida u on u.idUM=p.idUM
            AND p.ESTADO=xestado order by idPRODUCTOS asc;
	end if;
    
    if(xopcion=1)
		then
select p.idPRODUCTOS,P.CODIGO,P.DESCRIPCION ,g.DESCRIPCION as GRUPO,s.DESCRIPCION as SUBGRUPO,u.DESCRIPCION as UM from productos p
			INNER JOIN grupo g on g.idGRUPO=p.idGRUPO
			INNER JOIN subgrupo s on s.idSUBGRUPO=P.idSUBGRUPO
			INNER JOIN unidad_medida u on u.idUM=p.idUM
            WHERE p.idGRUPO=xgrupo and p.idSUBGRUPO=xsubgrupo and p.ESTADO=1
            order by idPRODUCTOS asc;
            
	end if;
   
end

DROP PROCEDURE IF EXISTS `sp_planificacion_Mnt`;
CREATE PROCEDURE `sp_planificacion_Mnt` (IN `xopcion` INT, IN `xasesor` INT, IN `xsucursal` INT, IN `xserievh` CHAR(4), IN `xdesde` DATE, IN `xhasta` DATE)  BEGIN
if xopcion=1 then
		select co.idCOTIZACION,s.DESCRIPCION as sucursal,co.SERIE as SERIEVH,c.RAZON_SOCIAL,a.DESCRIPCION,co.FECHA,co.ESTADO,
        co.FECHAPLANIFICACION, IF((datediff(CURDATE(),co.FECHA)/datediff(co.FECHAPLANIFICACION,co.FECHA))*100>100,100, datediff(CURDATE(),co.FECHA)/datediff(co.FECHAPLANIFICACION,co.FECHA)*100) as PORCENTAJE
        from cotizacion co inner join sucursal s on co.idSUCURSAL=s.idSUCURSAL
        inner join cliente c on c.idCLIENTE=co.idCLIENTE
        inner join asesores a on a.idASESORES=co.idASESORES
        where co.ESTADO='1' or co.ESTADO='3'
        order by idCOTIZACION asc ;
end if;
if xopcion=2 then
	select co.idCOTIZACION,s.DESCRIPCION as sucursal,co.SERIE as SERIEVH,c.RAZON_SOCIAL,a.DESCRIPCION,co.FECHA,co.ESTADO,
        co.FECHAPLANIFICACION, IF((datediff(CURDATE(),co.FECHA)/datediff(co.FECHAPLANIFICACION,co.FECHA))*100>100,100, datediff(CURDATE(),co.FECHA)/datediff(co.FECHAPLANIFICACION,co.FECHA)*100) as PORCENTAJE
        from cotizacion co inner join sucursal s on co.idSUCURSAL=s.idSUCURSAL
        inner join cliente c on c.idCLIENTE=co.idCLIENTE
        inner join asesores a on a.idASESORES=co.idASESORES
        where (co.idASESORES=xasesor and
        co.idSUCURSAL=xsucursal and
        co.FECHA between xdesde and xhasta and
         co.ESTADO='1') or( co.idASESORES=xasesor and
        co.idSUCURSAL=xsucursal and
        co.FECHA between xdesde and xhasta and
         co.ESTADO='3')
        order by idCOTIZACION asc ;
end if;
if xopcion=3 then
	select co.idCOTIZACION,s.DESCRIPCION as sucursal,co.SERIE as SERIEVH,c.RAZON_SOCIAL,a.DESCRIPCION,co.FECHA,co.ESTADO,
        co.FECHAPLANIFICACION, IF((datediff(CURDATE(),co.FECHA)/datediff(co.FECHAPLANIFICACION,co.FECHA))*100>100,100, datediff(CURDATE(),co.FECHA)/datediff(co.FECHAPLANIFICACION,co.FECHA)*100) as PORCENTAJE
        from cotizacion co inner join sucursal s on co.idSUCURSAL=s.idSUCURSAL
        inner join cliente c on c.idCLIENTE=co.idCLIENTE
        inner join asesores a on a.idASESORES=co.idASESORES
        where (co.idASESORES=xasesor and
        co.idSUCURSAL=xsucursal and
         co.SERIE=xserievh and
        co.FECHA between xdesde and xhasta and
         co.ESTADO='1') or (co.idASESORES=xasesor and
        co.idSUCURSAL=xsucursal and
         co.SERIE=xserievh and
        co.FECHA between xdesde and xhasta and
         co.ESTADO='3')
        order by idCOTIZACION asc ;
end if;
END

DROP PROCEDURE IF EXISTS `sp_vehiculo_controlador_Mnt`;
CREATE  PROCEDURE `sp_vehiculo_controlador_Mnt` (IN `xopcion` INT, IN `xcotizacionID` INT)  BEGIN
if xopcion=1 then
		select co.idCOTIZACION,s.DESCRIPCION as sucursal,co.SERIE as SERIEVH,c.RAZON_SOCIAL,a.DESCRIPCION,co.FECHA,co.ESTADO,
        co.FECHAPLANIFICACION,co.FECHACULMINACION, IF((datediff(CURDATE(),co.FECHA)/datediff(co.FECHAPLANIFICACION,co.FECHA))*100>100,100, datediff(CURDATE(),co.FECHA)/datediff(co.FECHAPLANIFICACION,co.FECHA)*100) as PORCENTAJE
        from cotizacion co inner join sucursal s on co.idSUCURSAL=s.idSUCURSAL
        inner join cliente c on c.idCLIENTE=co.idCLIENTE
        inner join asesores a on a.idASESORES=co.idASESORES
        where co.ESTADO='1' or co.ESTADO='3'
        order by idCOTIZACION asc ;
end if;
if xopcion=2 then
	select co.idCOTIZACION,s.DESCRIPCION as sucursal,co.SERIE as SERIEVH,c.RAZON_SOCIAL,a.DESCRIPCION,co.FECHA,co.ESTADO,
        co.FECHAPLANIFICACION, IF((datediff(CURDATE(),co.FECHA)/datediff(co.FECHAPLANIFICACION,co.FECHA))*100>100,100, datediff(CURDATE(),co.FECHA)/datediff(co.FECHAPLANIFICACION,co.FECHA)*100) as PORCENTAJE
        from cotizacion co inner join sucursal s on co.idSUCURSAL=s.idSUCURSAL
        inner join cliente c on c.idCLIENTE=co.idCLIENTE
        inner join asesores a on a.idASESORES=co.idASESORES
        where co.idASESORES=xasesor and
        co.idSUCURSAL=xsucursal and
        co.FECHA between xdesde and xhasta and
         co.ESTADO='1' or co.ESTADO='3'
        order by idCOTIZACION asc ;
end if;
if xopcion=3 then
	select co.idCOTIZACION,s.DESCRIPCION as sucursal,co.SERIE as SERIEVH,c.RAZON_SOCIAL,a.DESCRIPCION,co.FECHA,co.ESTADO,
        co.FECHAPLANIFICACION, IF((datediff(CURDATE(),co.FECHA)/datediff(co.FECHAPLANIFICACION,co.FECHA))*100>100,100, datediff(CURDATE(),co.FECHA)/datediff(co.FECHAPLANIFICACION,co.FECHA)*100) as PORCENTAJE
        from cotizacion co inner join sucursal s on co.idSUCURSAL=s.idSUCURSAL
        inner join cliente c on c.idCLIENTE=co.idCLIENTE
        inner join asesores a on a.idASESORES=co.idASESORES
        where co.idASESORES=xasesor and
        co.idSUCURSAL=xsucursal and
         co.SERIE=xserievh and
        co.FECHA between xdesde and xhasta and
         co.ESTADO='1' or co.ESTADO='3'
        order by idCOTIZACION asc ;
end if;
if xopcion=4 then
	select co.idCOTIZACION,s.DESCRIPCION as sucursal,co.SERIE as SERIEVH,c.RAZON_SOCIAL,a.DESCRIPCION,co.FECHA,co.ESTADO,
        co.FECHAPLANIFICACION, IF((datediff(CURDATE(),co.FECHA)/datediff(co.FECHAPLANIFICACION,co.FECHA))*100>100,100, datediff(CURDATE(),co.FECHA)/datediff(co.FECHAPLANIFICACION,co.FECHA)*100) as PORCENTAJE
        from cotizacion co inner join sucursal s on co.idSUCURSAL=s.idSUCURSAL
        inner join cliente c on c.idCLIENTE=co.idCLIENTE
        inner join asesores a on a.idASESORES=co.idASESORES
        where co.idCOTIZACION=xcotizacionID 
        order by idCOTIZACION asc ;
end if;
END

DROP PROCEDURE IF EXISTS `sp_vehiculo_tecnico_Mnt`;
CREATE PROCEDURE `sp_vehiculo_tecnico_Mnt` (IN `xopcion` INT)  BEGIN
if xopcion=1 then
		select co.idCOTIZACION,s.DESCRIPCION as sucursal,co.SERIE as SERIEVH,c.RAZON_SOCIAL,a.DESCRIPCION,co.FECHA,co.ESTADO
        from cotizacion co inner join sucursal s on co.idSUCURSAL=s.idSUCURSAL
        inner join cliente c on c.idCLIENTE=co.idCLIENTE
        inner join asesores a on a.idASESORES=co.idASESORES
        where co.ESTADO='1'
        order by idCOTIZACION asc ;
end if;

END



-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividades`
--
DELIMITER ;
DROP TABLE IF EXISTS `actividades`
CREATE TABLE IF NOT EXISTS `actividades` (
  `idACTIVIDADES` int(11) NOT NULL AUTO_INCREMENT,
  `DESCRIPCION` varchar(45) DEFAULT NULL,
  `ESTADO` char(1) DEFAULT NULL,
  PRIMARY KEY (`idACTIVIDADES`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `actividades`
--

INSERT INTO `actividades` (`idACTIVIDADES`, `DESCRIPCION`, `ESTADO`) VALUES
(1, 'PINTADO', '1'),
(2, 'AUTOMATIZADO', '1'),
(3, 'PLANCHADO', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asesores`
--

DROP TABLE IF EXISTS `asesores`;
CREATE TABLE IF NOT EXISTS `asesores` (
  `idASESORES` int(11) NOT NULL,
  `DESCRIPCION` varchar(45) DEFAULT NULL,
  `ESTADO` varchar(45) DEFAULT NULL,
  `idSUCURSAL` int(11) NOT NULL,
  PRIMARY KEY (`idASESORES`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `asesores`
--

INSERT INTO `asesores` (`idASESORES`, `DESCRIPCION`, `ESTADO`, `idSUCURSAL`) VALUES
(1, 'LUCIANO GUTIERREZ BURGOS1', '1', 1),
(2, 'OMAR TORRES', '1', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargo`
--

DROP TABLE IF EXISTS `cargo`;
CREATE TABLE IF NOT EXISTS `cargo` (
  `idCARGO` int(11) NOT NULL,
  `DESCRIPCION` varchar(45) DEFAULT NULL,
  `ESTADO` char(1) DEFAULT NULL,
  PRIMARY KEY (`idCARGO`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cargo`
--

INSERT INTO `cargo` (`idCARGO`, `DESCRIPCION`, `ESTADO`) VALUES
(1, 'TECNICO', '1'),
(2, 'LAVADOR', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

DROP TABLE IF EXISTS `cliente`;
CREATE TABLE IF NOT EXISTS `cliente` (
  `idCLIENTE` int(11) NOT NULL,
  `RAZON_SOCIAL` varchar(45) DEFAULT NULL,
  `DIRECCION` varchar(45) DEFAULT NULL,
  `TELEFONO` varchar(45) DEFAULT NULL,
  `EMAIL` varchar(45) DEFAULT NULL,
  `idTIPO_DOCUMENTO` int(11) NOT NULL,
  `DNI` char(8) DEFAULT NULL,
  `RUC` varchar(12) DEFAULT NULL,
  `idTIPO_CLIENTE` int(11) NOT NULL,
  PRIMARY KEY (`idCLIENTE`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`idCLIENTE`, `RAZON_SOCIAL`, `DIRECCION`, `TELEFONO`, `EMAIL`, `idTIPO_DOCUMENTO`, `DNI`, `RUC`, `idTIPO_CLIENTE`) VALUES
(1, 'JUAN PEREZ', 'TRUJILLO', NULL, NULL, 1, '45772493', NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cotizacion`
--

DROP TABLE IF EXISTS `cotizacion`;
CREATE TABLE IF NOT EXISTS `cotizacion` (
  `idCOTIZACION` int(11) NOT NULL AUTO_INCREMENT,
  `DOCUMENTO` char(3) DEFAULT NULL,
  `SERIE` char(4) DEFAULT NULL,
  `NUMERO` char(7) DEFAULT NULL,
  `FECHA` datetime DEFAULT NULL,
  `ESTADO` char(10) DEFAULT NULL,
  `idCLIENTE` int(11) NOT NULL,
  `idASESORES` int(11) NOT NULL,
  `idSUCURSAL` int(11) NOT NULL,
  `NOTA_TRABAJO` varchar(60) DEFAULT NULL,
  `FECHAPLANIFICACION` datetime DEFAULT NULL,
  `NOTA_PLANIFICACION` varchar(60) DEFAULT NULL,
  `idVEHICULO` char(10) NOT NULL,
  `FECHACULMINACION` date DEFAULT NULL,
  PRIMARY KEY (`idCOTIZACION`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cotizacion`
--

INSERT INTO `cotizacion` (`idCOTIZACION`, `DOCUMENTO`, `SERIE`, `NUMERO`, `FECHA`, `ESTADO`, `idCLIENTE`, `idASESORES`, `idSUCURSAL`, `NOTA_TRABAJO`, `FECHAPLANIFICACION`, `NOTA_PLANIFICACION`, `idVEHICULO`, `FECHACULMINACION`) VALUES
(1, 'dos', '12', '123', '2000-01-01 00:00:00', '3', 1, 1, 1, '1', '2019-04-20 12:12:00', '2000/1/1', 'xxxxx', '2019-04-23'),
(2, 'xxx', '12', '123', '2000-01-01 00:00:00', '3', 1, 1, 1, '1', '2019-04-01 12:00:00', '2000/1/1', 'xxxxx', NULL),
(3, 'res', '1', '485', '2019-03-03 00:00:00', '1', 1, 1, 1, NULL, NULL, NULL, 'redf', NULL),
(4, 'res', '1', '485', '2019-03-08 03:04:21', '3', 1, 1, 1, NULL, '2019-04-21 02:00:00', NULL, 'redf', NULL),
(5, '2', 'asd', 'jmh', '2019-03-07 22:04:26', '3', 1, 2, 1, NULL, '2019-05-04 12:00:00', NULL, 'asd', NULL),
(6, '1', 'df', 'ghf', '2019-03-07 22:05:43', '3', 1, 2, 1, NULL, '2019-04-27 21:02:00', NULL, 'dg', NULL),
(7, '1', 'cfsd', 'edd', '2019-03-07 22:09:44', '1', 1, 1, 1, NULL, NULL, NULL, 'redfsx', NULL),
(8, '2', 'asd', 'das', '2019-03-07 22:50:11', '1', 1, 2, 2, NULL, NULL, NULL, 'asd', NULL),
(9, 'res', 'asd', '485', '2019-03-08 05:43:36', '1', 1, 2, 1, NULL, NULL, NULL, 'redf', NULL),
(10, '1', '234', '323', '2019-03-08 00:40:43', '2', 1, 1, 1, NULL, NULL, NULL, 'fdsfc', NULL),
(11, '1', '12', '534', '2019-03-08 00:44:53', '2', 1, 2, 1, NULL, NULL, NULL, 'dsad', NULL),
(12, 'res', 'asd', '485', '2019-03-08 16:51:34', '1', 1, 2, 1, NULL, NULL, NULL, 'redf', NULL),
(13, '1', 'xxxx', 'xxx', '2019-03-08 12:15:53', '2', 1, 1, 1, NULL, NULL, NULL, 'xxxxxxxxxx', NULL),
(14, '1', 'yyyy', 'yyy', '2019-03-08 12:16:47', '2', 1, 1, 1, NULL, NULL, NULL, 'yyyyyyyyyy', NULL),
(15, '1', 'bbbb', 'bbb', '2019-03-08 12:18:02', '2', 1, 1, 1, NULL, NULL, NULL, 'bbbbbbbbbb', NULL),
(16, 'COV', 'xxxx', '0000001', '2019-03-08 12:44:15', '2', 1, 1, 1, NULL, NULL, NULL, 'xxxxxxxxxx', NULL),
(17, 'COV', 'xxxx', '0000001', '2019-03-13 16:18:28', '2', 1, 2, 1, NULL, NULL, NULL, 'null', NULL),
(18, 'COV', 'cccc', '0000001', '2019-03-13 16:22:21', '2', 1, 1, 1, NULL, NULL, NULL, 'null', NULL),
(19, '1', '12', '1', '2010-12-12 00:00:00', '2', 1, 1, 1, 'null', NULL, '12', 'null', NULL),
(20, 'COV', '12', '0000010', '2019-04-19 17:58:41', '2', 1, 1, 1, NULL, NULL, NULL, 'null', NULL),
(21, 'COV', '12', '0000010', '2019-04-19 18:02:52', '2', 1, 1, 1, NULL, NULL, NULL, 'null', NULL),
(22, 'COV', '1', '0000010', '2019-04-19 19:34:12', '1', 1, 1, 1, NULL, NULL, NULL, 'null', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_cotizacion`
--

DROP TABLE IF EXISTS `detalle_cotizacion`;
CREATE TABLE IF NOT EXISTS `detalle_cotizacion` (
  `idDETALLE_COTIZACION` int(11) NOT NULL AUTO_INCREMENT,
  `item` char(3) DEFAULT NULL,
  `DESCRIPCION` varchar(45) DEFAULT NULL,
  `CANTIDAD` decimal(9,2) DEFAULT NULL,
  `PRECIO` decimal(9,2) DEFAULT NULL,
  `SUBTOTAL` decimal(9,2) DEFAULT NULL,
  `IMPUESTO` decimal(9,2) DEFAULT NULL,
  `IMPORTE` decimal(9,2) DEFAULT NULL,
  `idCOTIZACION` int(11) NOT NULL,
  `idPRODUCTOS` int(11) NOT NULL,
  PRIMARY KEY (`idDETALLE_COTIZACION`,`idCOTIZACION`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `detalle_cotizacion`
--

INSERT INTO `detalle_cotizacion` (`idDETALLE_COTIZACION`, `item`, `DESCRIPCION`, `CANTIDAD`, `PRECIO`, `SUBTOTAL`, `IMPUESTO`, `IMPORTE`, `idCOTIZACION`, `idPRODUCTOS`) VALUES
(1, '0', 'SENSOR YARIS BEIGE', '13.00', '13.00', '169.00', '13.00', '169.13', 0, 1),
(2, '0', 'SENSOR YARIS BEIGE', '123.00', '123.00', '15129.00', '123.00', '15130.23', 6, 1),
(3, '0', 'SENSOR YARIS BEIGE', '12.00', '12.00', '144.00', '12.00', '144.12', 10, 1),
(4, '0', 'SENSOR YARIS BEIGE', '123.00', '123.00', '15129.00', '12.00', '15129.12', 11, 1),
(5, '0', 'prueba', '142.00', '12.00', '1704.00', '12.00', '1704.12', 15, 0),
(6, '0', 'prueba', '12.00', '12.00', '144.00', '12.00', '144.12', 16, 0),
(7, '0', 'prueba', '12.00', '12.00', '144.00', '12.00', '144.12', 17, 0),
(8, '1', 'prueba', '12.00', '12.00', '144.00', '12.00', '144.12', 18, 0),
(9, '1', '', '0.00', '0.00', '0.00', '0.00', '0.00', 0, 0),
(10, '1', 'prueba', '12.00', '12.00', '144.00', '25.92', '169.92', 22, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_programacion`
--

DROP TABLE IF EXISTS `detalle_programacion`;
CREATE TABLE IF NOT EXISTS `detalle_programacion` (
  `idDETALLE_PROGRAMACION` int(11) NOT NULL AUTO_INCREMENT,
  `idACTIVIDADES` int(11) NOT NULL,
  `idTECNICOS` int(11) NOT NULL,
  `FECHAINICIO` date DEFAULT NULL,
  `HORAINICIO` time DEFAULT NULL,
  `FECHAFINAL` date DEFAULT NULL,
  `HORAFINAL` time DEFAULT NULL,
  `NOTA` varchar(45) DEFAULT NULL,
  `FECHAREGISTRO` datetime DEFAULT NULL,
  `idPROGRAMACION` int(11) NOT NULL,
  PRIMARY KEY (`idDETALLE_PROGRAMACION`,`idPROGRAMACION`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `detalle_programacion`
--

INSERT INTO `detalle_programacion` (`idDETALLE_PROGRAMACION`, `idACTIVIDADES`, `idTECNICOS`, `FECHAINICIO`, `HORAINICIO`, `FECHAFINAL`, `HORAFINAL`, `NOTA`, `FECHAREGISTRO`, `idPROGRAMACION`) VALUES
(1, 1, 1, '2019-05-09', '01:00:00', '2019-05-09', '02:00:00', NULL, NULL, 0),
(2, 2, 3, '2019-05-09', '01:00:00', '2019-05-09', '02:00:00', NULL, NULL, 0),
(3, 1, 1, '2019-05-09', '01:00:00', '2019-05-09', '02:00:00', NULL, NULL, 0),
(4, 2, 3, '2019-05-09', '01:00:00', '2019-05-09', '02:00:00', NULL, NULL, 0),
(5, 3, 1, '2019-05-09', '01:00:00', '2019-05-09', '02:00:00', NULL, NULL, 0),
(6, 3, 3, '2019-05-09', '01:00:00', '2019-05-09', '02:00:00', NULL, NULL, 0),
(7, 2, 1, '2019-05-09', '01:00:00', '2019-05-09', '02:00:00', NULL, NULL, 0),
(8, 2, 3, '2019-05-09', '01:00:00', '2019-05-09', '02:00:00', NULL, NULL, 0),
(9, 1, 1, '2019-05-09', '01:00:00', '2019-05-09', '02:00:00', NULL, NULL, 0),
(10, 2, 3, '2019-05-09', '01:00:00', '2019-05-09', '02:00:00', NULL, NULL, 0),
(11, 3, 1, '2019-05-09', '01:00:00', '2019-05-09', '02:00:00', NULL, NULL, 5),
(12, 3, 3, '2019-05-09', '01:00:00', '2019-05-09', '02:00:00', NULL, NULL, 5),
(13, 1, 1, '2019-05-09', '01:00:00', '2019-05-09', '02:00:00', NULL, NULL, 6),
(14, 3, 3, '2019-05-09', '01:00:00', '2019-05-09', '02:00:00', NULL, NULL, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo`
--

DROP TABLE IF EXISTS `grupo`;
CREATE TABLE IF NOT EXISTS `grupo` (
  `idGRUPO` int(11) NOT NULL,
  `DESCRIPCION` varchar(45) DEFAULT NULL,
  `ESTADO` char(1) DEFAULT NULL,
  PRIMARY KEY (`idGRUPO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `grupo`
--

INSERT INTO `grupo` (`idGRUPO`, `DESCRIPCION`, `ESTADO`) VALUES
(1, 'ACCESORIOS CAMPAÑAS', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marca`
--

DROP TABLE IF EXISTS `marca`;
CREATE TABLE IF NOT EXISTS `marca` (
  `idMARCA` int(11) NOT NULL,
  `DESCRIPCION` varchar(45) DEFAULT NULL,
  `ESTADO` char(1) DEFAULT NULL,
  PRIMARY KEY (`idMARCA`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modelo`
--

DROP TABLE IF EXISTS `modelo`;
CREATE TABLE IF NOT EXISTS `modelo` (
  `idMODELO` int(11) NOT NULL,
  `DESCRIPCION` varchar(45) DEFAULT NULL,
  `ESTADO` varchar(45) DEFAULT NULL,
  `idMARCA` int(11) NOT NULL,
  PRIMARY KEY (`idMODELO`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

DROP TABLE IF EXISTS `productos`;
CREATE TABLE IF NOT EXISTS `productos` (
  `idPRODUCTOS` int(11) NOT NULL,
  `CODIGO` varchar(45) DEFAULT NULL,
  `DESCRIPCION` varchar(45) DEFAULT NULL,
  `FOTO` varchar(45) DEFAULT NULL,
  `ESTADO` char(1) DEFAULT NULL,
  `idGRUPO` int(11) NOT NULL,
  `idSUBGRUPO` int(11) NOT NULL,
  `idUM` int(11) NOT NULL,
  PRIMARY KEY (`idPRODUCTOS`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`idPRODUCTOS`, `CODIGO`, `DESCRIPCION`, `FOTO`, `ESTADO`, `idGRUPO`, `idSUBGRUPO`, `idUM`) VALUES
(0, '123', 'prueba', 'images.png', '1', 1, 1, 1),
(1, 'GVPS06E0', 'SENSOR YARIS BEIGE', NULL, '1', 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `programacion`
--

DROP TABLE IF EXISTS `programacion`;
CREATE TABLE IF NOT EXISTS `programacion` (
  `idPROGRAMACION` int(11) NOT NULL,
  `idCOTIZACION` int(11) NOT NULL,
  `FECHAREGISTRO` datetime DEFAULT NULL,
  `idTECNICOS` int(11) NOT NULL,
  PRIMARY KEY (`idPROGRAMACION`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `programacion`
--

INSERT INTO `programacion` (`idPROGRAMACION`, `idCOTIZACION`, `FECHAREGISTRO`, `idTECNICOS`) VALUES
(1, 2, '2019-09-05 23:09:00', 0),
(2, 2, '2019-09-05 23:06:54', 0),
(3, 2, '2019-09-05 23:12:43', 0),
(4, 2, '2019-09-05 23:13:06', 0),
(5, 2, '2019-09-05 23:17:09', 0),
(6, 2, '2019-09-05 23:18:14', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `series`
--

DROP TABLE IF EXISTS `series`;
CREATE TABLE IF NOT EXISTS `series` (
  `DOCUMENTO` char(3) NOT NULL,
  `SERIES` char(4) NOT NULL,
  `NUMERO` char(7) DEFAULT NULL,
  `ESTADO` char(1) DEFAULT NULL,
  PRIMARY KEY (`DOCUMENTO`,`SERIES`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `series`
--

INSERT INTO `series` (`DOCUMENTO`, `SERIES`, `NUMERO`, `ESTADO`) VALUES
('COV', '0001', '0000001', '1'),
('COV', '0002', '0000002', '1'),
('COV', '0003', '0000003', '1'),
('COV', '0004', '0000004', '1'),
('COV', '0005', '0000005', '1'),
('COV', '0006', '0000006', '1'),
('COV', '0007', '0000007', '1'),
('COV', '0008', '0000008', '1'),
('COV', '0009', '0000009', '1'),
('COV', '0010', '0000010', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subgrupo`
--

DROP TABLE IF EXISTS `subgrupo`;
CREATE TABLE IF NOT EXISTS `subgrupo` (
  `idSUBGRUPO` int(11) NOT NULL,
  `DESCRIPCION` varchar(45) DEFAULT NULL,
  `ESTADO` varchar(45) DEFAULT NULL,
  `idGRUPO` int(11) NOT NULL,
  PRIMARY KEY (`idSUBGRUPO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `subgrupo`
--

INSERT INTO `subgrupo` (`idSUBGRUPO`, `DESCRIPCION`, `ESTADO`, `idGRUPO`) VALUES
(1, 'ACC. CAMPAÑA TDP      ', '1', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sucursal`
--

DROP TABLE IF EXISTS `sucursal`;
CREATE TABLE IF NOT EXISTS `sucursal` (
  `idSUCURSAL` int(11) NOT NULL,
  `DESCRIPCION` varchar(45) DEFAULT NULL,
  `ESTADO` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idSUCURSAL`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `sucursal`
--

INSERT INTO `sucursal` (`idSUCURSAL`, `DESCRIPCION`, `ESTADO`) VALUES
(1, 'TRUJILLO', '1'),
(2, 'CHIMBOTE', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `taller`
--

DROP TABLE IF EXISTS `taller`;
CREATE TABLE IF NOT EXISTS `taller` (
  `idTALLER` int(11) NOT NULL,
  `DESCRIPCION` varchar(45) DEFAULT NULL,
  `ESTADO` char(1) DEFAULT NULL,
  `idSUCURSAL` int(11) NOT NULL,
  PRIMARY KEY (`idTALLER`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `taller`
--

INSERT INTO `taller` (`idTALLER`, `DESCRIPCION`, `ESTADO`, `idSUCURSAL`) VALUES
(1, 'SEDE TRUJILLO', '1', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tecnicos`
--

DROP TABLE IF EXISTS `tecnicos`;
CREATE TABLE IF NOT EXISTS `tecnicos` (
  `idTECNICOS` int(11) NOT NULL,
  `CODIGO` char(10) DEFAULT NULL,
  `NOMBRE` varchar(45) DEFAULT NULL,
  `ESTADO` char(1) DEFAULT NULL,
  `idTALLER` int(11) NOT NULL,
  `idCARGO` int(11) NOT NULL,
  PRIMARY KEY (`idTECNICOS`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tecnicos`
--

INSERT INTO `tecnicos` (`idTECNICOS`, `CODIGO`, `NOMBRE`, `ESTADO`, `idTALLER`, `idCARGO`) VALUES
(1, '12345', 'ALEXANDER ALVARADO MORENO', '1', 1, 1),
(2, '98765', 'OMAR CHAPARRO', '1', 1, 2),
(3, '34567', 'OZUNA BEIBY', '1', 1, 2),
(4, '67575', 'VALENTINO LIBERTY', '1', 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_cliente`
--

DROP TABLE IF EXISTS `tipo_cliente`;
CREATE TABLE IF NOT EXISTS `tipo_cliente` (
  `idTIPO_CLIENTE` int(11) NOT NULL,
  `DESCRIPCION` varchar(45) DEFAULT NULL,
  `ESTADO` char(1) DEFAULT NULL,
  PRIMARY KEY (`idTIPO_CLIENTE`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipo_cliente`
--

INSERT INTO `tipo_cliente` (`idTIPO_CLIENTE`, `DESCRIPCION`, `ESTADO`) VALUES
(1, 'NATURAL', '1'),
(2, 'JURIDICO', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_documento`
--

DROP TABLE IF EXISTS `tipo_documento`;
CREATE TABLE IF NOT EXISTS `tipo_documento` (
  `idTIPO_DOCUMENTO` int(11) NOT NULL,
  `DESCRIPCION` varchar(45) DEFAULT NULL,
  `ESTADO` char(1) DEFAULT NULL,
  PRIMARY KEY (`idTIPO_DOCUMENTO`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipo_documento`
--

INSERT INTO `tipo_documento` (`idTIPO_DOCUMENTO`, `DESCRIPCION`, `ESTADO`) VALUES
(1, 'DNI', '1'),
(2, 'RUC', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidad_medida`
--

DROP TABLE IF EXISTS `unidad_medida`;
CREATE TABLE IF NOT EXISTS `unidad_medida` (
  `idUM` int(11) NOT NULL,
  `DESCRIPCION` varchar(45) DEFAULT NULL,
  `ESTADO` char(1) DEFAULT NULL,
  PRIMARY KEY (`idUM`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `unidad_medida`
--

INSERT INTO `unidad_medida` (`idUM`, `DESCRIPCION`, `ESTADO`) VALUES
(1, 'UNIDAD', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculo`
--

DROP TABLE IF EXISTS `vehiculo`;
CREATE TABLE IF NOT EXISTS `vehiculo` (
  `idVEHICULO` char(10) NOT NULL,
  `PLACA` char(10) DEFAULT NULL,
  `NROMOTOR` varchar(45) DEFAULT NULL,
  `ANIOFABRICACION` char(4) DEFAULT NULL,
  `idMODELO` int(11) NOT NULL,
  `idMARCA` int(11) NOT NULL,
  PRIMARY KEY (`idVEHICULO`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
