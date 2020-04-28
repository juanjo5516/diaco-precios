/*****************************************************************************/
/********** DEPARTAMENTOS Y SEDES QUE SOLO TENGAN PRECIOS*********************/

--Departamento y codigo
SELECT distinct 
	depa.codigo_departamento,
	depa.nombre_departamento,
	muni.codigo_municipio
	FROM diaco_vaciadocba vaciado
	INNER JOIN diaco_usuario usuario
		on usuario.id_usuario = vaciado.idVerificador
	INNER JOIN diaco_sede sede
		ON sede.id_diaco_sede = usuario.id_sede_diaco
	INNER JOIN municipio muni
		ON muni.codigo_municipio = sede.codigo_municipio
	INNER JOIN departamento depa
		ON depa.codigo_departamento = muni.codigo_departamento
-- sede y codigo
SELECT distinct 
	sede.id_diaco_sede,
	sede.nombre_sede,
	sede.codigo_municipio,
	coordenada.latitut,
	coordenada.longitud
	FROM diaco_vaciadocba vaciado
	INNER JOIN diaco_usuario usuario
		on usuario.id_usuario = vaciado.idVerificador
	INNER JOIN diaco_sede sede
		ON sede.id_diaco_sede = usuario.id_sede_diaco
	INNER JOIN municipio muni
		ON muni.codigo_municipio = sede.codigo_municipio
	INNER JOIN departamento depa
		ON depa.codigo_departamento = muni.codigo_departamento
	INNER JOIN diaco_coordenadas_cba coordenada
		ON coordenada.id_sede = sede.id_diaco_sede

-- categorias y codigo
SELECT distinct 
	plantilla.idCategoria,
	categoria.nombre
	FROM diaco_vaciadocba vaciado
	INNER JOIN diaco_usuario usuario
		on usuario.id_usuario = vaciado.idVerificador
	INNER JOIN diaco_name_template_cba template
		ON template.id = vaciado.idPlantilla
	INNER JOIN diaco_plantillascba plantilla
		ON plantilla.NombrePlantilla = template.NombreTemplate
	INNER JOIN diaco_categoriacba categoria 
		ON categoria.id_Categoria = plantilla.idCategoria




/*sede.nombre_sede,muni.nombre_municipio*/
SELECT * FROM diaco_sede
select * from diaco_coordenadas_cba
select * from diaco_name_template_cba
select * from diaco_plantillascba
