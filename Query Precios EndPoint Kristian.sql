begin
SELECT  
	t1.code,
	t1.articulo,
	t1.idMedida,
	t1.medida,
	t1.fecha_actual,
	t1.Precio_actual,
	t2.fecha_actual as fecha_anterior,
	t2.Precio_actual2 as precio_anterior
 FROM 
(SELECT 
	precio.id_producto as code,
    precio.nombre as articulo,
	medida.id_medida as idMedida,
    medida.nombre as medida,
	CONVERT(DATE,getdate()) as fecha_actual,
    avg(vaciado.precioProducto) as Precio_actual
    FROM diaco_vaciadocba vaciado          
    INNER JOIN diaco_productocba precio
        ON precio.id_producto = vaciado.idProducto 
    INNER JOIN diaco_medida medida
        ON medida.id_medida = vaciado.idMedida
    INNER JOIN diaco_usuario usuario
        ON usuario.id_usuario = vaciado.idVerificador
    INNER JOIN diaco_sede sede
        ON sede.id_diaco_sede = usuario.id_sede_diaco 
	INNER JOIN diaco_plantillascba plantilla
		ON plantilla.idProducto = vaciado.idProducto
	INNER JOIN diaco_categoriacba categorias
		ON categorias.id_Categoria = plantilla.idCategoria
    WHERE convert(date,vaciado.created_at) <= '2019-08-24'
        AND sede.id_diaco_sede = 1
		and categorias.id_Categoria = 1
    GROUP BY precio.nombre, medida.nombre,precio.id_producto, medida.id_medida)  t1
 full outer JOIN 
(SELECT 
	precio.id_producto as code,
    precio.nombre as articulo,
	medida.id_medida as idMedida,
    medida.nombre as medida,
	DATEADD(DAY,-1,CONVERT(DATE,getdate())) as fecha_actual,
    avg(vaciado.precioProducto) as Precio_actual2
    FROM diaco_vaciadocba vaciado          
    INNER JOIN diaco_productocba precio
        ON precio.id_producto = vaciado.idProducto 
    INNER JOIN diaco_medida medida
        ON medida.id_medida = vaciado.idMedida
    INNER JOIN diaco_usuario usuario
        ON usuario.id_usuario = vaciado.idVerificador
    INNER JOIN diaco_sede sede
        ON sede.id_diaco_sede = usuario.id_sede_diaco 
	INNER JOIN diaco_plantillascba plantilla
		ON plantilla.idProducto = vaciado.idProducto
	INNER JOIN diaco_categoriacba categorias
		ON categorias.id_Categoria = plantilla.idCategoria
    WHERE convert(date,vaciado.created_at) <= '2019-08-23'
        AND sede.id_diaco_sede = 1
		and categorias.id_Categoria = 1
    GROUP BY precio.nombre, medida.nombre,precio.id_producto, medida.id_medida
	) t2

	ON t1.code = t2.code
where t1.idMedida = t2.idMedida
end;	

