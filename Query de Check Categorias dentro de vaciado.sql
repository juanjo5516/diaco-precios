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


--obtener el id y el nombre de la categoria que se encuentra dentro de los vaciados
SELECT distinct categoria.id_Categoria, categoria.nombre FROM diaco_plantillascba plantilla
		INNER JOIN diaco_categoriacba categoria
		ON categoria.id_Categoria = plantilla.idCategoria
	WHERE plantilla.NombrePlantilla = (SELECT NombreTemplate FROM diaco_name_template_cba
								WHERE id = (SELECT distinct idPlantilla FROM diaco_vaciadocba 
												WHERE idPlantilla = (SELECT DISTINCT idPlantilla FROM diaco_vaciadocba))) 

	

select sede.id_diaco_sede,sede.codigo_municipio,sede.nombre_sede,muni.nombre_municipio,
	depa.codigo_departamento,depa.nombre_departamento,
	coordenada.latitut, coordenada.longitud
 from diaco_sede sede
	INNER JOIN municipio muni
		ON muni.codigo_municipio = sede.codigo_municipio
	INNER JOIN departamento depa
		ON depa.codigo_departamento = muni.codigo_departamento
	INNER JOIN diaco_coordenadas_cba coordenada
		ON coordenada.id_diaco_sede = sede.id_diaco_sede
	WHERE id_diaco_sede in (SELECT idSede FROM diaco_asignarsedecba
	WHERE idPlantilla = (SELECT distinct idPlantilla FROM diaco_vaciadocba 
							WHERE idPlantilla = (SELECT DISTINCT idPlantilla FROM diaco_vaciadocba))
		and estatus = 1)	


select id_diaco_sede,nombre_sede from diaco_sede;
select * from diaco_coordenadas_cba;

CREATE TABLE diaco_coordenadas_cba(
    id INTEGER NOT NULL PRIMARY KEY IDENTITY,
    id_diaco_sede INTEGER FOREIGN KEY REFERENCES diaco_sede(id_diaco_sede),
    latitut VARCHAR(200),
    longitud VARCHAR(200)
)

INSERT INTO diaco_coordenadas_cba(id_diaco_sede,latitut,longitud)
    VALUES(3,'14.287811','-89.893492'),
          (4,'14.967276','-91.780001'),
          (5,'14.536437','-91.503565'),
          (6,'14.632954','-89.985261'),
          (8,'14.803152','-89.542758'),
          (9,'14.300901','-90.785616'),
          (10,'15.321514','-91.470337'),
          (11,'15.729171','-88.602117'),
          (12,'16.919717','-89.883773'),
          (13,'14.849042','-91.536263'),
          (14,'15.030291','-91.148609'),
          (15,'14.914007','-91.366589'),
          (16,'14.971821','-89.537696'),
          (17,'14.563621','-90.735444'),
          (18,'15.101471','-90.322105'),
          (19,'14.769231','-91.183423'),
          (20,'14.538429','-91.678703'),
          (21,'14.631856','-90.608051'),
          (22,'14.573761','-90.603341'),
          (23,'14.851395','-90.070321'),
          (24,'14.279221','-90.301012')