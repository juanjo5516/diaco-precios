
function GetTabla(tabla,link){
    var table =  $(tabla).DataTable( {
        "searching": true,
        "destroy": true,
        responsive: true,
        "serverSide": true,
        "ajax": link,
        "type" : "GET",
        'dataType': 'json',
        "columns": [
            { data: 'ID' , width: 100},
            { data: 'Pnombre' ,width: 600},
        ],
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

function GetTablaSub(tabla,link){
    var table =  $(tabla).DataTable( {
        "searching": true,
        "destroy": true,
        responsive: true,
        "serverSide": true,
        "ajax": link,
        "type" : "GET",
        'dataType': 'json',
        "columns": [
            { data: 'Pnombre' ,width: 600},
        ],
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