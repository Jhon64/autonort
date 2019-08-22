CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_vehiculo_controlador_Mnt`(
in xopcion int,
in xcotizacionID int
)
BEGIN
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