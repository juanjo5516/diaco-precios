
var counter = 0;
function addGeneral(form,link,tabla,tipo) {
    $(form).submit(function(e) {
        e.preventDefault();
        let parametros = $(this).serialize();
        $.ajax({
            data: parametros,
            url: link,
            type: "get",
            contentType: false,
            cache: true,
            processData: false,
            success: function(response) {
                console.log(response);
                if(response == 1){
                    if (tipo == true) {
                        $(tabla).DataTable().ajax.reload();
                        $('form :input').val('');
                        $("#snoAlertBox").fadeIn();
                        closeSnoAlertBox("#snoAlertBox");
                    }else{
                        $(tabla).DataTable().clear().destroy();
                        counter = 0;
                        TablaVacia(tabla);
                        LimpiarSelect();
                        $("#snoAlertBox").fadeIn();
                        closeSnoAlertBox("#snoAlertBox");
                    }
                       
                }else{
                     console.log(response);
                      $("#snoAlertBoxE").fadeIn();
                      closeSnoAlertBox("#snoAlertBoxE"); 
                }
            }
        })
    })
}

function mensaje(id,Anterior1,Anterior2,actual){
    let aumentoAnterior1 = Anterior1*1.10;
    let aumentoAnterior2 = Anterior2*1.10;

    let aumentonaranja1 = Anterior1*1.15;
    let aumentonaranja2 = Anterior2*1.15;

    actualf = parseFloat(actual);
    // console.log(aumentonaranja1 +'  '+ aumentonaranja1);
    // console.log(aumentoAnterior1 +'  '+ aumentoAnterior2);

    if(actual > 0){

        if(actual >= Anterior1 && actual <= Anterior2){
            $('#'+id).removeClass('bg-danger');
            $('#'+id).removeClass('bg-warning text-dark');
            $('#'+id).addClass('bg-success');
             
        }else if((actual >= aumentoAnterior1 && actual <= aumentoAnterior2  )){
            $('#'+id).removeClass('bg-danger');
            $('#'+id).removeClass('bg-success');
            $('#'+id).addClass('bg-warning text-dark');
        }else if(actual >= aumentonaranja1 && actual <= aumentonaranja2 ){
            $('#'+id).removeClass('bg-warning text-dark');
            $('#'+id).removeClass('bg-success');
            $('#'+id).addClass('bg-danger');
        }else{
            
            $('#'+id).removeClass('bg-warning text-dark');
            $('#'+id).removeClass('bg-success');
            $('#'+id).addClass('bg-danger');
        }
    }
    // else{
    //     $('#'+id).removeClass('bg-warning text-dark');
    //     $('#'+id).removeClass('bg-success');
    //     $('#'+id).addClass('bg-danger');
    // }
    // if ((actual >= Anterior1 && actual <= aumentoAnterior1) || (actual >= Anterior2 && actual <= aumentoAnterior2) ){
   
          
    // }else{
    //     $('#'+id).removeClass('bg-success');
    //     $('#'+id).addClass('bg-danger');
    //     console.log('no'+actualf+'anterior2 '+aumentoAnterior2);
    // }
    

    // if (actual >= Anterior1 && actual <= aumentoAnterior1 || actual >= Anterior2 && actual <= aumentoAnterior2) {
    //     $('#'+id).removeClass('bg-danger');
    //     $('#'+id).addClass('bg-success');
    //     console.log('si'+actual);
       
    // }
    // else{
    //     $('#'+id).removeClass('bg-success');
    //     $('#'+id).addClass('bg-danger');
    //     console.log('no'+actual+'anterior2 '+Anterior2);
    // }



    // let aumento = actual*1.10;
    // if (aumento > Anterior2) {
    //     $('#'+id).removeClass('bg-success');
    //     $('#'+id).addClass('bg-danger');
    // }else{
    //     $('#'+id).removeClass('bg-danger');
    //     $('#'+id).addClass('bg-success');
    // }
}

function addvue(form,link) {
    // let parametros = $(form).serializeObject();
    // console.log(parametros);
    $(form).submit(function(e) { 
        //console.log( $( this ).serializeArray() );
        e.preventDefault();
        let parametros = $(this).serialize();
        var serializedForm = $(form).serializeArray().reduce(function(result, field){
            if (result.hasOwnProperty(field.name)) {
                if (Array.isArray(result[field.name])) {
                    result[field.name].push(field.value);
                } else {
                    result[field.name] = [result[field.name], field.value];
                }
            } else {
                result[field.name] = field.value;
            }
            return result;
        }, {});
        var jsonForm = JSON.stringify(serializedForm);

                // Agrego el tipo MIME del archivo y la codificación de caracteres
                var jsonFileData = 'data:application/json;charset=UTF-8,';

                // Codifico la cadena JSON con la función "encodeURIComponent" para que pueda ser parte del atributo "href" y luego lo agrego.
                jsonFileData += encodeURIComponent(jsonForm);
        
        console.log(serializedForm);
        
        $.ajax({
            data: serializedForm,
            url: link,
            type: "post",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            contentType: "json",
            contentType: false,
            cache: true,
            processData: false,
            success: function(response) {
                if(response == "1"){
                    // $(tabla).DataTable().destroy();
                    // $('form :input').val('');
                    console.log("exito")
                      
                }else{
                    //   $("#snoAlertBoxE").fadeIn();
                    //   closeSnoAlertBox("#snoAlertBoxE"); 
                    console.log('fallo');
                    
                }
            }
        })
        
    })
}


function LimpiarText(){
    $('form :input').val('');
}

function LimpiarSelect(){
    // $('select').each(function(){ 
    //     $(this).find('option:first').prop('selected', 'selected'); 
    // });
    $('#categoriaVaciado').find('option:first').prop('selected', 'selected'); 
    $('#mercadoVaciado').find('option:first').prop('selected', 'selected'); 
    $('#establecimientoVaciado').find('option:first').prop('selected', 'selected'); 
    $('#direccionMercadoVaciado').val('');
    $('#direccionEstablecimientoVaciado').val('');
}
function Vaciado(form,link,tabla) {
    $(form).submit(function(e) {
        e.preventDefault();
        let parametros = $(this).serialize();
        console.log(parametros);
        $.ajax({
            data: parametros,
            url: link,
            type: "get",
            contentType: false,
            cache: true,
            processData: false,
            success: function(response) {
                if(response == "1"){
                    $(tabla).DataTable().destroy();
                    $('form :input').val('');
                      
                }else{
                      $("#snoAlertBoxE").fadeIn();
                      closeSnoAlertBox("#snoAlertBoxE"); 
                }
            }
        })
    })
}



function closeSnoAlertBox(divAlert){
    window.setTimeout(function () {
      $(divAlert).fadeOut("show")
    }, 1000);
}


function TablaVacia(table){
    let T = $(table).DataTable({
        "columnDefs": [ {
            "searchable": false,
            "orderable": false,
            "targets": 0
        } ],
        "order": [[ 1, 'asc' ]],
        "searching": false,
        "destroy": true,
        "pagingType": "full_numbers",
        "paging": false,
        "language": {
            "lengthMenu": "Display _MENU_ records",
            "info": "_TOTAL_ registros",
            "search": "Buscar",
            "paginate": {
                "next": ">>",
                "previous": "<<",
            },
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "emptyTable": "No hay datos",
            "zeroRecords": "No hay coincidencias",
            "infoEmpty": "Mostrando registros del …un total de 0 registros",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)"
        
        }       
    });
}

function TablaVue(table){
    let T = $(table).DataTable({
        "columnDefs": [ {
            "searchable": false,
            "orderable": false,
            "targets": 0
        } ],
        "order": [[ 1, 'asc' ]],
        "searching": false,
        "destroy": true,
        "pagingType": "full_numbers",
        "paging": false,
        "language": {
            "lengthMenu": "Display _MENU_ records",
            "info": "_TOTAL_ registros",
            "search": "Buscar",
            "paginate": {
                "next": ">>",
                "previous": "<<",
            },
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "emptyTable": "No hay datos",
            "zeroRecords": "No hay coincidencias",
            "infoEmpty": "Mostrando registros del …un total de 0 registros",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)"
        
        }       
    });
}


function AddColumna(producto2,medida2){
        var t = $('#TDProductos').DataTable();
        
        t.row.add( [
            '',
            '<select name="Dproducto['+ counter +']" id="Dproducto['+ counter +']" class="form-control">'+producto2+'</select>',
            '<select name="Dmedida['+ counter +']" id="Dmedida['+ counter +']" class="form-control">'+ medida2 +'</select>', 
            '<input type="text" class="form-control" id="precio[' + counter + ']" name="precio['+ counter +']" value=""/>'
            
        ] ).draw( false );
 
        counter++;

        t.on( 'order.dt search.dt', function () {
            t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();
    
 
}

function AddColumnavue(tabla){
    var t = $(tabla);
    
    t.row.add( [
        '',
        '<select name="Dproducto['+ counter +']" id="Dproducto['+ counter +']" class="form-control">'+1+'</select>',
        '<select name="Dmedida['+ counter +']" id="Dmedida['+ counter +']" class="form-control">'+ 2 +'</select>', 
        '<input type="text" class="form-control" id="precio[' + counter + ']" name="precio['+ counter +']" value=""/>'
    ] ).draw( false );

    counter++;

    t.on( 'order.dt search.dt', function () {
        t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();


}


function AddColumnaGeneral(producto2,medida2,tabla){
    var t = $(tabla).DataTable();
    
    t.row.add( [
        '',
        '<select name="Dproducto['+ counter +']" id="Dproducto['+ counter +']" class="form-control select">'+producto2+'</select>',
        '<select name="Dmedida['+ counter +']" id="Dmedida['+ counter +']" class="form-control select">'+ medida2 +'</select>', 
        // '<input type="text" class="form-control" id="precio[' + counter + ']" name="precio['+ counter +']" value=""/>',
        '<button  type="button" class="btn btn-outline-primary ">Delete</button>'
    ] ).draw( false );

    counter++;

    t.on( 'order.dt search.dt', function () {
        t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();


}

function ChangeAddress(parametros,link,textbox){
    $.ajax({
        url: link, 
        type: 'get',
        dataType: 'json',
        data: parametros
    })
      .done(function(respuesta) {
          $(textbox).val(respuesta[0]['direccion']);
          })
        .fail(function() {
            $(textbox).val("sin dirección");
            console.log("error");
        })
}

function GetTablaAsede(tabla,link){
    var table =  $(tabla).DataTable( {
        "searching": true,
        "destroy": true,
        responsive: false,
        "serverSide": true,
        "ajax": link,
        "type" : "GET",
        'dataType': 'json',
        "columns": [
            { data: 'NombreTemplate', width: "35%"},
            { data: 'nombre_sede', width: "35%"},
            { data: 'estatus', width: "5%"},
            {
                data: null,
                className: "center",
                defaultContent: '<a href="" class="editor_edit">Edit</a> / <a href="" class="editor_remove">Delete</a>'
            }
        ], 
        "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            if (aData["estatus"] == "1") {
                $("td:eq(2)", nRow).html("Activo");
            }else{
                $("td:eq(2)", nRow).html("Inactivo");
            }
            return nRow;
        },
        dom: 'Bfrtip',
        lengthMenu: [
            [ 5,10, 25, 50, -1 ],
            [ '5 Filas','10 Filas', '25 Filas', '50 Filas', 'Todo' ]
        ],
        buttons: [
            {
                extend:'excel',
                className: 'btn-success',
                init: function(api, node, config) {
                $(node).removeClass('btn-secondary')
                }
            },
            {
                extend:'pageLength',
                className: 'btn-primary',
                init: function(api, node, config) {
                $(node).removeClass('btn-secondary')
                }
            }
        ],
        "language": {
            buttons: {
            pageLength: {
                _: "Mostrar %d Registros",
                '-1': "Todos"
                }
            },
            "lengthMenu": "Display _MENU_ records",
            "info": "_TOTAL_ registros",
            "search": "Buscar",
            "paginate": {
                "next": ">>",
                "previous": "<<",
            },
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "emptyTable": "No hay datos",
            "zeroRecords": "No hay coincidencias",
            "infoEmpty": "Mostrando registros del …un total de 0 registros",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)"
        
        }       
    });
}