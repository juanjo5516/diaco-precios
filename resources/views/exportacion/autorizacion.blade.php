 <div class="content-wrapper container ">
    <div class="col-md-12 col-lg-12 col-12 col-sm-12">
        {{-- <div class="card mb-12 border-shadow">
            <div class="card-header text-left">
                Exportación de Datos
            </div>
            <div class="card-body">   --}}
                <authorize-component 
                :categorias="{{ json_encode($categorias)}}"
                :producto="{{ json_encode($producto)}}"
                :correlativo='{{ json_encode($correlativo) }}'
                :user="{{ $user }}"
                :id="{{ $id }}"
                ></authorize-component> 
            {{-- </div> 
            
        </div>  --}}
    </div>
</div> 