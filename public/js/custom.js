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

var counter = 0;
function AddColumna(producto2,medida){
        var t = $('#TDProductos').DataTable();
        
        t.row.add( [
            '',
            '<select name="Dproducto'+ counter +'" id="Dproducto'+ counter +'" class="form-control">'+producto2+'</select>',
            medida,
            '<input type="text" class="form-control" id="' + counter + '" name="precio'+ counter +'" value=""/>'
        ] ).draw( false );
 
        counter++;

        t.on( 'order.dt search.dt', function () {
            t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();
    
 
}

/*'<input type="text" class="form-control" id="' + counter + '" name="producto'+ counter +'" value="'+ counter +'"/>',
'<input type="text" class="form-control" id="' + counter + '" name="medida'+ counter +'" value="'+ counter +'"/>', */