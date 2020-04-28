select 
    diaco_medida.id_medida as idMedida, 
    diaco_productocba.id_producto as code,
    diaco_productocba.nombre as articulo,
    diaco_medida.nombre as medida,
    getdate() as fecha_Actual,
    avg(diaco_vaciadocba.precioProducto) as price 
from [diaco_vaciadocba] 
    inner join [diaco_productocba] 
        on [diaco_productocba].[id_producto] = [diaco_vaciadocba].[idProducto] 
    inner join [diaco_medida] 
        on [diaco_medida].[id_medida] = [diaco_vaciadocba].[idMedida] 
    inner join [diaco_usuario] 
        on [diaco_usuario].[id_usuario] = [diaco_vaciadocba].[idVerificador] 
    inner join [diaco_sede] 
        on [diaco_sede].[id_diaco_sede] = [diaco_usuario].[id_sede_diaco] 
    inner join [diaco_plantillascba] 
        on [diaco_plantillascba].[idProducto] = [diaco_vaciadocba].[idProducto] 
    inner join [diaco_categoriacba] 
        on [diaco_categoriacba].[id_Categoria] = [diaco_plantillascba].[idCategoria]
where [diaco_vaciadocba].[created_at] <= '2019-08-22 11:58:27.249'
group by 
    [diaco_productocba].[nombre], [diaco_medida].[nombre], [diaco_productocba].[id_producto] , [diaco_medida].[id_medida]
union
select 
    diaco_medida.id_medida as idMedida, 
    diaco_productocba.id_producto as code,
    diaco_productocba.nombre as articulo,
    diaco_medida.nombre as medida,
    getdate() as fecha_Actual,
    avg(diaco_vaciadocba.precioProducto) as price 
from [diaco_vaciadocba] 
    inner join [diaco_productocba] 
        on [diaco_productocba].[id_producto] = [diaco_vaciadocba].[idProducto] 
    inner join [diaco_medida] 
        on [diaco_medida].[id_medida] = [diaco_vaciadocba].[idMedida] 
    inner join [diaco_usuario] 
        on [diaco_usuario].[id_usuario] = [diaco_vaciadocba].[idVerificador] 
    inner join [diaco_sede] 
        on [diaco_sede].[id_diaco_sede] = [diaco_usuario].[id_sede_diaco] 
    inner join [diaco_plantillascba] 
        on [diaco_plantillascba].[idProducto] = [diaco_vaciadocba].[idProducto] 
    inner join [diaco_categoriacba] 
        on [diaco_categoriacba].[id_Categoria] = [diaco_plantillascba].[idCategoria] 
where 
    [diaco_vaciadocba].[created_at] <= '2019-08-22 11:58:27.249'
        and [diaco_categoriacba].[id_Categoria] = 1 
        and [diaco_sede].[id_diaco_sede] = 1 
group by 
    [diaco_productocba].[nombre], [diaco_medida].[nombre], [diaco_productocba].[id_producto] , [diaco_medida].[id_medida]
