CREATE TABLE PlantillasCBA(

    idPlantilla  INTEGER NOT NULL  IDENTITY(1,1) PRIMARY KEY,
    NombrePlantilla VARCHAR(300),
    idCategoria INTEGER NOT NULL FOREIGN KEY REFERENCES categoriaCBA(id_Categoria),
    idProducto INTEGER NOT NULL FOREIGN KEY REFERENCES productoCBA(id_producto),
    idMedida INTEGER NOT NULL FOREIGN KEY REFERENCES medida(id_medida),
    estado INTEGER,
    create_at TIMESTAMP,
    update_at TIMESTAMP

)

CREATE TABLE NAME_TEMPLATE_CBA(
    id INTEGER NOT NULL IDENTITY(1,1) PRIMARY KEY,
    NombreTemplate VARCHAR(300),
    estado INTEGER
)

CREATE TABLE AsignarSedeCBA(
    id_Asignacion INTEGER NOT NULL IDENTITY(1,1) PRIMARY KEY,
    idPlantilla INTEGER NOT NULL FOREIGN KEY REFERENCES NAME_TEMPLATE_CBA(id),
    idSede INTEGER NOT NULL FOREIGN KEY REFERENCES diaco_sede(id_diaco_sede),
    created_at DATETIME,
    estatus INTEGER
)

CREATE TABLE diaco_vaciadocba(
    correlativo INTEGER NOT NULL IDENTITY(1,1) PRIMARY KEY,
    created_at DATETIME,
    idPlantilla INTEGER NOT NULL FOREIGN KEY REFERENCES diaco_name_template_cba(id),
    idVerificador INTEGER NOT NULL FOREIGN KEY REFERENCES diaco_usuario(id_usuario),
    tipoVerificacion INTEGER NOT NULL FOREIGN KEY REFERENCES diaco_tipoverificacioncba(id_TipoVerificacion),
    idLugarVisita INTEGER,
    idEstablecimientoVisita INTEGER,
    numeroLocal INTEGER,
    idProducto INTEGER NOT NULL FOREIGN KEY REFERENCES diaco_productocba(id_producto),
    idMedida INTEGER NOT NULL FOREIGN KEY REFERENCES diaco_medida(id_medida),
    precioProducto decimal(18,5),
    estado VARCHAR(10)
)



-- ================================================
-- RETORNA LOS DEPARTAMENTOS QUE TIENEN PRECIOS
-- ================================================
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		JUAN JOSE JOLON
-- Description:	RETORNO DE DEPARTAMENTOS
-- =============================================
CREATE PROCEDURE GetDepartamentos

AS
BEGIN

	SET NOCOUNT ON;
	SELECT DISTINCT USUARIO.nombre, SEDE.nombre_sede, MUNI.nombre_municipio, DEPA.nombre_departamento FROM diaco_vaciadocba VACIADO
	INNER JOIN diaco_usuario USUARIO
		ON USUARIO.id_usuario = VACIADO.idVerificador
	INNER JOIN diaco_sede SEDE
		ON SEDE.id_diaco_sede = USUARIO.id_sede_diaco
	INNER JOIN municipio MUNI
		ON MUNI.codigo_municipio = SEDE.codigo_municipio
	INNER JOIN departamento DEPA
		ON DEPA.codigo_departamento = MUNI.codigo_departamento
END
GO


CREATE TABLE diaco_propano_cba(
    id integer not null PRIMARY key IDENTITY,
    name varchar(200),
    state integer not null
)
CREATE TABLE diaco_smercado_cba(
    id integer not null PRIMARY key IDENTITY,
    name varchar(200),
    address varchar(200),
    status integer not null
)

CREATE TABLE diaco_coordenadas_cba(
    id INTEGER NOT NULL PRIMARY KEY IDENTITY,
    id_diaco_sede INTEGER FOREIGN KEY REFERENCES diaco_sede(id_diaco_sede),
    latitut VARCHAR(200),
    longitud VARCHAR(200)
)

INSERT INTO diaco_coordenadas_cba(id_diaco_sede,latitut,longitud)
    VALUES(1,'14.624697','-90.516875'),
          (2,'14.666342','-90.814882'),
          (3,'14.287811','-89.893492'),
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