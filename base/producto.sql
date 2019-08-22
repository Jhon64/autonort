CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_Mantenedor_Producto`(
in xopcion int,
in xgrupo int,
in xsubgrupo int,
in xestado int
)
begin
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