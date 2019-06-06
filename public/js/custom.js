function addGeneral(form,link,tabla) {
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
                if(response == "1"){
                    $(tabla).DataTable().ajax.reload();
                    $('form :input').val('');
                    $("#snoAlertBox").fadeIn();
                    closeSnoAlertBox("#snoAlertBox");   
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
        "searching": true,
        "destroy": true,
        dom: 'Bfrtip',
        lengthMenu: [
            [ 50, -1 ],
            [ '50 Filas', 'Todo' ]
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

function AddColumna(Djson,producto,medida,precio){
        console.log(Djson);
        var t = $('#TDProductos').DataTable();
        var counter = 1;
        t.row.add( [
            producto +'<input type="hidden" id="' + counter + '" name="producto'+ counter +'" value="'+ Djson.Dproducto +'"/>',
            medida +'<input type="hidden" id="' + counter + '" name="producto'+ counter +'" value="'+ Djson.Dmedida +'"/>',
            precio +'<input type="hidden" id="' + counter + '" name="producto'+ counter +'" value="'+ Djson.Dprecio +'"/>'
        ] ).draw( false );
 
        counter++;
    
 
}

