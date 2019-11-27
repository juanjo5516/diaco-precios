<div class="content-wrapper container-fluid ">
    <div class="col-md-12 col-lg-12 col-12 col-sm-12">
        <div class="card mb-12 border-shadow">
            <div class="card-header text-left">
                Editar Plantillas
            </div>
            <div class="card-body">
                {{-- <asignacion-component :coleccion="{{ $Plantillas }}" :Sedes="{{ $Sedes }}"></asignacion-component> --}}
                <editarplantilla-componente 
                    :id="{{ $id }}" 
                    :fecha="{{ $fecha }}" 
                    :usuario="{{ $usuario }}" 
                    :coleccion= "{{ json_encode($coleccion) }}" 
                    :categoria="{{ json_encode($categoria) }}" ></editarplantilla-componente>
            </div>

        </div>
    </div>
</div> 