<div class="content-wrapper container-fluid ">
    <div class="col-md-12 col-lg-12 col-12 col-sm-12">
            <vaciado-component 
                :fecha="{{ json_encode($fecha) }}" 
                :usuario="{{ json_encode($user) }}"
                :coleccion="{{ json_encode($coleccion)}}"
                :categoria="{{ json_encode($categoria)}}"
                :establecimientos="{{ json_encode($establecimiento) }}"
                :idplantilla="{{ $idPlantilla }}"
                :mercados="{{ $mercado }}"
                
                >
            </vaciado-component>
    </div>
</div> 