CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_vehiculo_tecnico_Mnt`(in xopcion int)
BEGIN
if xopcion=1 then
		select co.idCOTIZACION,s.DESCRIPCION as sucursal,co.SERIE as SERIEVH,c.RAZON_SOCIAL,a.DESCRIPCION,co.FECHA,co.ESTADO
        from cotizacion co inner join sucursal s on co.idSUCURSAL=s.idSUCURSAL
        inner join cliente c on c.idCLIENTE=co.idCLIENTE
        inner join asesores a on a.idASESORES=co.idASESORES
        where co.ESTADO='1'
        order by idCOTIZACION asc ;
end if;

END