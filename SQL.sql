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
