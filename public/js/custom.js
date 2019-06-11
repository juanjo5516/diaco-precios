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
                if(response == 1){
                    if (tipo) {
                        $(tabla).DataTable().ajax.reload();
                        LimpiarSelect();
                        $("#snoAlertBox").fadeIn();
                        closeSnoAlertBox("#snoAlertBox");
                    }else{
                        $(tabla).DataTable().clear().destroy();
                        counter = 0;
                        TablaVacia('#TDProductos');
                        LimpiarSelect();
                        $("#snoAlertBox").fadeIn();
                        closeSnoAlertBox("#snoAlertBox");
                    }
                       
                }else{
                      $("#snoAlertBoxE").fadeIn();
                      closeSnoAlertBox("#snoAlertBoxE"); 
                }
            }
        })
    })
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