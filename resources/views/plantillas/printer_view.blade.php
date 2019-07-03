<div class="content-wrapper container-fluid ">
    <div class="col-md-12 col-lg-12 col-12 col-sm-12">
        <printer-component 
            :fecha="{{ json_encode($fecha) }}" 
            :usuario = "{{ json_encode($usuario)}}" 
            :coleccion = "{{ json_encode($coleccion) }}"
            :categoria = "{{ json_encode($categoria) }}"
            ></printer-component>
    </div>
</div> 