$(function() {
    var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
    $('.js-switch').each(function() {
        new Switchery($(this)[0], $(this).data());
    });
    obtenerDatos();
    $('#config').addClass("active");
    $('#form').formValidation({
        framework: 'bootstrap',
        excluded: ':disabled',
        fields: {
        }
    }).on('success.form.fv', function(e) {
        // Prevent form submission
        e.preventDefault();
        var $form = $(e.target),
        fv = $form.data('formValidation');

        var parametros = new FormData($('#form')[0]);

        $.ajax({
            url: $('#url').val()+'ajuste/datosistema_crud',
            type: 'POST',
            data: parametros,
            dataType: 'json',
            contentType: false,
            processData: false,
         })
         .done(function(response){
            if(response.success){
                var titulo = 'Proceso Terminado';
                var icono = 'success';
            }else{
                var titulo = 'Proceso No Terminado';
                var icono = 'error';
            }

            Swal.fire({   
                    title: titulo,   
                    text: response.message,
                    icon: icono, 
                    confirmButtonColor: "#34d16e",   
                    confirmButtonText: "Aceptar",
                    allowOutsideClick: false,
                    showCancelButton: false,
                    showConfirmButton: true
                }).then((result) => {
                    obtenerDatos();
                 });
            
        })
        .fail(function(){
            swal('Oops...', 'Problemas con la conexión a internet!', 'error');
        });
    });
});

var obtenerDatos = function(){
    $.ajax({
        type: "POST",
        url: $('#url').val()+"ajuste/datosistema_data",
        dataType: "json",
        success: function(item){

            $('#zona_hora').val(item.zona_hora);
            $('#trib_acr').val(item.trib_acr);
            $('#trib_car').val(item.trib_car);
            $('#di_acr').val(item.di_acr);
            $('#di_car').val(item.di_car);            
            $('#imp_acr').val(item.imp_acr);
            $('#imp_val').val(item.imp_val);
            $('#mon_acr').val(item.mon_acr);
            $('#mon_val').val(item.mon_val);           
            $('#pc_name').val(item.pc_name);           
            $('#pc_ip').val(item.pc_ip);   
            $('#print_com_hidden').val(item.print_com);   
            $('#print_pre_hidden').val(item.print_pre);
            $('#print_cpe_hidden').val(item.print_cpe);
            $('#cod_seg').val(item.cod_seg); 
            $('#opc_01_hidden').val(item.opc_01);
            if(item.print_com == '1'){$('#print_com').prop('checked', true)};
            if(item.print_pre == '1'){$('#print_pre').prop('checked', true)};
            if(item.print_cpe == '1'){$('#print_cpe').prop('checked', true)};
            if(item.opc_01 == '1'){$('#opc_01').prop('checked', true)};
            //agregando opciones tipo operacion
            var opciones = ["Gravado - Operación Onerosa", "Exonerado - Operación Onerosa"];
            var selectOperacion = $("#type_operation");
            selectOperacion.empty();

            $.each(opciones, function (index, value) {
                var option = $("<option>", {
                    value: index + 1,
                    text: value
                });

                if ((index + 1) == item.type_operation) {
                    option.attr("selected", true);
                }
                //console.log(index +1);
                selectOperacion.append(option);
            });
            //fin agregando opciones
        }
    });
}

$('#print_com').on('change', function(event){
    if($(this).prop('checked')){
        $('#print_com_hidden').val('1');
    }else{
        $('#print_com_hidden').val('0');
    }
});

$('#print_pre').on('change', function(event){
    if($(this).prop('checked')){
        $('#print_pre_hidden').val('1');
    }else{
        $('#print_pre_hidden').val('0');
    }
});
$('#print_cpe').on('change', function(event){
    if($(this).prop('checked')){
        $('#print_cpe_hidden').val('1');
    }else{
        $('#print_cpe_hidden').val('0');
    }
});
$('#opc_01').on('change', function(event){
    if($(this).prop('checked')){
        $('#opc_01_hidden').val('1');
    }else{
        $('#opc_01_hidden').val('0');
    }
});