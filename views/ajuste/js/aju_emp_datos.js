//archivo actualizado
$(function() {
    obtenerDatos();
    $('#config').addClass("active");
    $('#form').formValidation({
        framework: 'bootstrap',
        excluded: ':disabled',
        fields: {
        }
    }).on('success.form.fv', function(e) {

        e.preventDefault();
        var $form = $(e.target),
        fv = $form.data('formValidation');

        var parametros = new FormData($('#form')[0]);
        console.log(parametros);

        $.ajax({
            url: $('#url').val()+'ajuste/datosempresa_crud',
            type: 'POST',
            data: parametros,
            dataType: 'json',
            contentType: false,
            processData: false,
         })
         .done(function(response){
            console.log(response);
            if(response.success == 1){
                var titulo = 'Proceso Terminado';
                var icono = 'success';
                obtenerDatos();
            }else{
                var titulo = 'Proceso No Culminado';
                var icono = 'error';
            }
            Swal.fire({
                title: titulo,
                html: response.message,
                icon: icono,
        
            })
            setTimeout(function () {
                location.reload(); // Recargar la página
            }, 2000);
        })
        .fail(function(){
            swal('Oops...', 'Problemas con la conexión a internet!', 'error');
        });
    });
});

var obtenerDatos = function(){
    $.ajax({
        type: "POST",
        url: $('#url').val()+"ajuste/datosempresa_data",
        dataType: "json",
        success: function(item){
            $('#tribAcr').val(item.trib_acr);
            $('#ruc').val(item.ruc);
            $('#razon_social').val(item.razon_social);
            if(item.logo == null || item.logo == ''){
                $('#wizardPicturePreview-2').attr('src',$("#url").val()+'public/images/productos/default.png');
            }else{
                $('#wizardPicturePreview-2').attr('src',$("#url").val()+'public/images/'+item.logo+'');  
            }

            $('#imagen').val(item.logo);
            $('#nombre_comercial').val(item.nombre_comercial);
            $('#direccion_comercial').val(item.direccion_comercial);
            $('#direccion_fiscal').val(item.direccion_fiscal);
            $('#celular').val(item.celular);        
            $('#ubigeo').val(item.ubigeo);        
            $('#departamento').val(item.departamento);        
            $('#provincia').val(item.provincia);        
            $('#distrito').val(item.distrito);       
            $('#client_id').val(item.client_id);       
            $('#client_secret').val(item.client_secret);
            $('#f_pro_hidden').val(item.sunat);
			$('#api_url').val(item.api_url_pro);
			$('#api_token').val(item.api_token_pro);

			if(item.sunat == '3'){$('#f_pro').prop('checked', true)};      
        }
    });
}

$("#ruc").keyup(function(event) {
    var that = this,
    value = $(this).val();
    if (value.length == $("#ruc").attr("maxlength")) {
        $.getJSON($('#url').val()+"api/ruc/"+$("#ruc").val(), {
            format: "json"
        })
        .done(function(data) {
            //$("#dni").val(data.ruc);
            $("#ruc").val(data.ruc);
            $("#razon_social").val(data.razonSocial);
            $("#nombre_comercial").val(data.nombreComercial);
            $("#direccion_fiscal").val(data.direccion);
            $("#celular").val(data.telefonos);
            //$("#ubigeo").val(data.ubigeo);
            $("#departamento").val(data.departamento);
            $("#provincia").val(data.provincia);
            $("#distrito").val(data.distrito);
            $('#form').formValidation('revalidateField', 'razon_social');
            $('#form').formValidation('revalidateField', 'nombreComercial');
            $('#form').formValidation('revalidateField', 'direccion');
            $('#form').formValidation('revalidateField', 'telefonos');
            $('#form').formValidation('revalidateField', 'departamento');
            $('#form').formValidation('revalidateField', 'provincia');
            $('#form').formValidation('revalidateField', 'distrito');
        });
    }
});


var anularlogo = function(){

    var html_confirm = '<div>Se procederá a eliminar el logo</div><br>\
        <div><span class="text-success" style="font-size: 17px;">¿Está Usted de Acuerdo?</span></div>';

    Swal.fire({
        title: 'Necesitamos de tu Confirmación',
        html: html_confirm,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#34d16e',
        confirmButtonText: 'Si, Adelante!',
        cancelButtonText: "No!",
        showLoaderOnConfirm: true,
        preConfirm: function() {
          return new Promise(function(resolve) {
             $.ajax({
                url: $('#url').val()+'ajuste/anularlogo',
                dataType: 'json'
             })
             .done(function(response){
                if(response.success == 1){
                    var titulo = 'Proceso Terminado';
                    var icono = 'success';
                    obtenerDatos();
                }else{
                    var titulo = 'Proceso No Culminado';
                    var icono = 'error';
                }
                Swal.fire({
                    title: titulo,
                    text: response.message,
                    icon: icono,
                    confirmButtonColor: "#34d16e",   
                    confirmButtonText: "Aceptar"
                })
            })
             .fail(function(){
                Swal.fire('Oops...', 'Problemas con la conexión a internet!', 'error');
             });
          });
        },
        allowOutsideClick: false              
    });
}