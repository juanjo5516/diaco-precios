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