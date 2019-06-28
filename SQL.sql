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
    created_at TIMESTAMP,
    estatus INTEGER
)