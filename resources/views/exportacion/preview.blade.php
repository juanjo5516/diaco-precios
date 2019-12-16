 <div class="content-wrapper container-fluid ">
    <div class="col-md-12 col-lg-12 col-12 col-sm-12">
                <preview-component 
                :categorias="{{ json_encode($categorias)}}"
                :producto="{{ json_encode($producto)}}"
                :correlativo='{{ json_encode($correlativo) }}'
                :user="{{ $user }}"
                :id="{{ $id }}"
                ></preview-component> 
    </div>
</div> 