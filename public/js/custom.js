
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

function addvue(form) {
    $(form).submit(function(e) {
        e.preventDefault();
        let parametros = $(this).serialize();
        console.log(parametros);
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


function AddColumnaGeneral(producto2,medida2,tabla){
    var t = $(tabla).DataTable();
    
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