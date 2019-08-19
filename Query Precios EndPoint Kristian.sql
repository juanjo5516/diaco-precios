SELECT 
		precio.nombre as articulo,
		medida.nombre as medida,
		convert(time,vaciado.created_at) as fecha_actual,
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
	WHERE convert(time,vaciado.created_at) between DATEADD(hour,-2,convert(time,vaciado.created_at)) and  convert(time,vaciado.created_at)
		AND sede.id_diaco_sede = 21
	GROUP BY precio.nombre, medida.nombre,vaciado.created_at
ORDER BY precio.nombre


SELECT 
			precio.nombre as articulo,
			avg(vaciado.precioProducto) as actual
				FROM diaco_vaciadocba vaciado
					INNER JOIN diaco_productocba precio
						ON precio.id_producto = vaciado.idProducto 
					INNER JOIN diaco_medida medida
						ON medida.id_medida = vaciado.idMedida
					INNER JOIN diaco_usuario usuario
						ON usuario.id_usuario = vaciado.idVerificador
					INNER JOIN diaco_sede sede
						ON sede.id_diaco_sede = usuario.id_sede_diaco 
				WHERE convert(time,vaciado.created_at) between DATEADD(hour,-2,convert(time,vaciado.created_at)) and  convert(time,vaciado.created_at)
					AND sede.id_diaco_sede = 21
				GROUP BY precio.nombre










