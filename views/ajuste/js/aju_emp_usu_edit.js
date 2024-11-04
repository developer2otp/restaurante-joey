$(function () {
    $('#config').addClass("active");
    DatosGrles();
    comboAreaProd();
    $('#form').formValidation({
        framework: 'bootstrap',
        excluded: ':disabled',
        fields: {
            dni: {
                validators: {
                    stringLength: {
                        message: 'El ' + $(".c-dni").text() + ' debe tener ' + $("#dni").attr("maxlength") + ' digitos'
                    }
                }
            }
        }
    }).on('success.form.fv', function (e) {
        e.preventDefault();
        var $form = $(e.target),
            fv = $form.data('formValidation');
        var form = $(this);

        var parametros = new FormData($('#form')[0]);
        console.log(parametros);
        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            data: parametros,
            url: $('#url').val() + 'ajuste/usuario_crud',
            contentType: false,
            processData: false,
        })
            .done(function (response) {
                if(response.success == 1){
                    var titulo = 'Proceso Terminado';
                    var icono = 'success';
                }else{
                    var titulo = 'Proceso No Culminado';
                    var icono = 'error';
                }
                Swal.fire({
                    title: titulo,
                    html: response.message,
                    icon: icono,
                    confirmButtonColor: "#34d16e",
                    confirmButtonText: "Aceptar",
                    showConfirmButton: true
                }).then((result) => {
                   //console.log("then block executed");
                    window.location.href = $("#url").val() + "ajuste/usuario";
                });

            })
            .fail(function () {
                Swal.fire('Oops...', 'Problemas con la conexión a internet!', 'error');
            });
    });
});

    var DatosGrles = function () {
        $('#id_rol').selectpicker('refresh').selectpicker('val', $('#cod_rol').val());
        $('#id_areap').selectpicker('refresh').selectpicker('val', $('#cod_area').val());
    }

    var comboAreaProd = function () {
        if ($("#id_rol").selectpicker('val') == 4) {
            $('#col-areap').css('display', 'block');
            $("#id_areap").prop('disabled', false);
        } else {
            $('#col-areap').css('display', 'none');
            $("#id_areap").prop('disabled', true);
        }
    }

    $('#id_rol').change(function () {
        if ($("#id_rol").selectpicker('val') == 4) {
            $('#col-areap').css('display', 'block');
            $("#id_areap").prop('disabled', false);
            $('#form').formValidation('revalidateField', 'id_areap');
        } else {
            $('#col-areap').css('display', 'none');
            $("#id_areap").val('').selectpicker('refresh').prop('disabled', true);
        }
    });

    $("#dni").keyup(function(event) {
        var that = this,
        value = $(this).val();
        if (value.length == $("#dni").attr("maxlength")) {
            $.getJSON($('#url').val()+"api/dni/"+$("#dni").val(), {
                format: "json"
            })
            .done(function(data) {
                $("#dni").val(data.dni);
                $("#nombres").val(data.nombres);
                $("#ape_paterno").val(data.apellidoPaterno);
                $("#ape_materno").val(data.apellidoMaterno);
                $('#form').formValidation('revalidateField', 'nombres');
                $('#form').formValidation('revalidateField', 'ape_paterno');
                $('#form').formValidation('revalidateField', 'ape_materno');
            });
        } else if($("#dni").val() == "") {
            $('#dni').val("");
            $('#nombres').val("");
            $('#ape_paterno').val("");
            $('#ape_materno').val("");
            $('#form').formValidation('resetForm', true);
        }
    });