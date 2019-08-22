CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_cotizacion_Mnt`(IN `xopcion` INT,
 IN `xcotizacionID` INT,
 IN `xcodigo` CHAR(10),
 IN `xserievh` CHAR(4), 
 IN `xfechareg` DATETIME, 
 IN `xestado` CHAR(2), 
 IN `xclienteID` INT,
 IN `xasesorID` INT,
 IN `xsucursalID` INT, 
 IN `xnota` VARCHAR(60),
 IN `xfechaPlanificacion` DATETIME,
 IN `xnotaPlanificacion` VARCHAR(60),
 IN `xvehiculo` CHAR(10),
 IN `xdocumento` CHAR(3))
BEGIN
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