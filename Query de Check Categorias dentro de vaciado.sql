--SELECT * FROM DIACO_VACIADOCBA;
--SELECT * FROM diaco_name_template_cba
--SELECT * FROM diaco_asignarsedecba
SELECT * FROM diaco_plantillascba

--Muestra el id de la plantilla que se encuentra dentro del vaciado
SELECT DISTINCT idPlantilla FROM diaco_vaciadocba; 
--obtengo el idPlantilla que se encuentra vaciado
SELECT distinct idPlantilla FROM diaco_vaciadocba 
	WHERE idPlantilla = (SELECT DISTINCT idPlantilla FROM diaco_vaciadocba);

--obtener el nombre de la plantilla que se encuentra dentro de los vaciados
SELECT NombreTemplate FROM diaco_name_template_cba
	WHERE id = (SELECT distinct idPlantilla FROM diaco_vaciadocba 
	WHERE idPlantilla = (SELECT DISTINCT idPlantilla FROM diaco_vaciadocba));

-- obtener el id de la sede que se encuentra activa y que tenga asignada una plantilla dentro de vaciado
SELECT idSede FROM diaco_asignarsedecba
	WHERE idPlantilla = (SELECT distinct idPlantilla FROM diaco_vaciadocba 
							WHERE idPlantilla = (SELECT DISTINCT idPlantilla FROM diaco_vaciadocba))
		and estatus = 1


--obtener el id de la categoria que se encuentra dentro de los vaciados
SELECT distinct categoria.id_Categoria, categoria.nombre FROM diaco_plantillascba plantilla
		INNER JOIN diaco_categoriacba categoria
		ON categoria.id_Categoria = plantilla.idCategoria
	WHERE plantilla.NombrePlantilla = (SELECT NombreTemplate FROM diaco_name_template_cba
								WHERE id = (SELECT distinct idPlantilla FROM diaco_vaciadocba 
												WHERE idPlantilla = (SELECT DISTINCT idPlantilla FROM diaco_vaciadocba))) 

	