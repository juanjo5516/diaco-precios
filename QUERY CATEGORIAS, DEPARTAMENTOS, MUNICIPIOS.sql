---Query Solo categorias que estan en precios.


SELECT DISTINCT PLANTILLA.idCategoria, CATEGORIA.nombre FROM diaco_vaciadocba VACIADO
	INNER JOIN diaco_asignarsedecba ASIGNACION
		ON ASIGNACION.idPlantilla = VACIADO.idPlantilla
	INNER JOIN diaco_name_template_cba TEMPLATE
		ON TEMPLATE.id = ASIGNACION.idPlantilla
	INNER JOIN diaco_plantillascba PLANTILLA
		ON PLANTILLA.NombrePlantilla = TEMPLATE.NombreTemplate
	INNER JOIN diaco_categoriacba CATEGORIA
		ON CATEGORIA.id_Categoria = PLANTILLA.idCategoria;

---***************************************************************************************

--DEPARTAMENTOS QUE SE HA LLENADO EN PRECIOS

SELECT DISTINCT 

	DEPA.codigo_departamento,
	DEPA.nombre_departamento
	FROM diaco_vaciadocba VACIADO
	INNER JOIN diaco_usuario USUARIO
		ON USUARIO.id_usuario = VACIADO.idVerificador
	INNER JOIN diaco_sede SEDE
		ON SEDE.id_diaco_sede = USUARIO.id_sede_diaco
	INNER JOIN municipio MUNI
		ON MUNI.codigo_municipio = SEDE.codigo_municipio
	INNER JOIN departamento DEPA
		ON DEPA.codigo_departamento = MUNI.codigo_departamento

	INNER JOIN diaco_asignarsedecba ASIGNACION
		ON ASIGNACION.idPlantilla = VACIADO.idPlantilla
	INNER JOIN diaco_name_template_cba TEMPLATE
		ON TEMPLATE.id = ASIGNACION.idPlantilla
	INNER JOIN diaco_plantillascba PLANTILLA
		ON PLANTILLA.NombrePlantilla = TEMPLATE.NombreTemplate

	GROUP BY DEPA.codigo_departamento, DEPA.nombre_departamento
--*****************************************************************************************

--- MUNICIPIOS QUE CONTTENGAS CATEGORIAS

 SELECT DISTINCT 
	CATEGORIA.id_Categoria,
	CATEGORIA.nombre,
	MUNI.codigo_municipio
	FROM diaco_vaciadocba VACIADO
	INNER JOIN diaco_usuario USUARIO
		ON USUARIO.id_usuario = VACIADO.idVerificador
	INNER JOIN diaco_sede SEDE
		ON SEDE.id_diaco_sede = USUARIO.id_sede_diaco
	INNER JOIN municipio MUNI
		ON MUNI.codigo_municipio = SEDE.codigo_municipio
	INNER JOIN departamento DEPA
		ON DEPA.codigo_departamento = MUNI.codigo_departamento

	INNER JOIN diaco_asignarsedecba ASIGNACION
		ON ASIGNACION.idPlantilla = VACIADO.idPlantilla
	INNER JOIN diaco_name_template_cba TEMPLATE
		ON TEMPLATE.id = ASIGNACION.idPlantilla
	INNER JOIN diaco_plantillascba PLANTILLA
		ON PLANTILLA.NombrePlantilla = TEMPLATE.NombreTemplate
	INNER JOIN diaco_categoriacba CATEGORIA
		ON CATEGORIA.id_Categoria = PLANTILLA.idCategoria
	WHERE MUNI.codigo_municipio = 1
	GROUP BY CATEGORIA.id_Categoria, CATEGORIA.nombre, MUNI.codigo_municipio
	


select * from diaco_asignarsedecba
SELECT * FROM diaco_name_template_cba

SELECT * FROM diaco_vaciadocba
SELECT * FROM diaco_usuario
SELECT * FROM diaco_sede
SELECT * FROM municipio

exec GetDepartamentos;

select * from municipio