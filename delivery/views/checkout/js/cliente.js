$(function() {
    $('#form-cliente').formValidation({
        framework: 'bootstrap',
        excluded: ':disabled',
        fields: {
            dni: {
                validators: {
                    stringLength: {
                        message: 'El documento debe tener ' + $("#dni").attr("maxlength") + ' dígitos'
                    }
                }
            },
            telefono: {
                validators: {
                    stringLength: {
                        message: 'El teléfono debe tener ' + $("#telefono").attr("maxlength") + ' dígitos'
                    }
                }
            }
        }
    }).on('success.form.fv', function(e) {
        e.preventDefault();
        var $form = $(e.target);
        var fv = $form.data('formValidation');

        var dni = $('#dni').val();
        var nombres = $('#nombres').val();
        var ape_paterno = $('#ape_paterno').val();
        var ape_materno = $('#ape_materno').val();
        var telefono = $('#telefono').val();
        var direccion = $('#direccion').val();
        var referencia = $('#referencia').val();

        $.ajax({
            type: 'POST',
            dataType: 'json',
            data: {
                dni: dni,
                nombres: nombres,
                ape_paterno: ape_paterno,
                ape_materno: ape_materno,
                telefono: telefono,
                direccion: direccion,
                referencia: referencia
            },
            url: $('#url').val() + 'checkout/cliente_crud',
            success: function(data) {
                console.log(data.cod);
                if (data.cod === 1) {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true,
                        onOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    });
                    Toast.fire({
                        icon: 'error',
                        title: 'El cliente ya existe'
                    });
                    return;
                } else {
                    var infoUsuario = {
                        id: data.id_cliente,
                        dni: dni,
                        nombres: nombres,
                        ape_paterno: ape_paterno,
                        ape_materno: ape_materno,
                        direccion: direccion,
                        referencia: referencia,
                        telefono: telefono
                    }
                    localStorage.setItem("usuario", JSON.stringify(infoUsuario));
                    validarLogin();
                    $('#modal-cliente').modal('hide');
                    return;
                }
            }
        });
        return false;
    });
});

$("#dni").keyup(function(event) {
    var value = $(this).val();
    if (value.length === $("#dni").attr("maxlength")) {
        $.getJSON("https://dniruc.apisperu.com/api/v1/dni/" + $("#dni").val() + "?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6InRvbW15ZGVsZ2Fkb3JvZHJpZ3VlekBnbWFpbC5jb20ifQ.ZUOOpJcgrZ2zDZuNO3OoBC8ViItUZLn3zixVsWMeq8c", {
            format: "json"
        }).done(function(data) {
            $("#dni").val(data.dni);
            $("#nombres").val(data.nombres);
            $("#ape_paterno").val(data.apellidoPaterno);
            $("#ape_materno").val(data.apellidoMaterno);
            $('#form-cliente').formValidation('revalidateField', 'dni');
            $('#form-cliente').formValidation('revalidateField', 'nombres');
            $('#form-cliente').formValidation('revalidateField', 'ape_paterno');
            $('#form-cliente').formValidation('revalidateField', 'ape_materno');
        });
    } else if ($("#dni").val() === "") {
        $('#form-cliente')[0].reset();
        $('#form-cliente').formValidation('resetForm', true);
    }
});

$('#modal-cliente').on('hidden.bs.modal', function() {
    $(this).find('#form-cliente')[0].reset();
    $('#form-cliente').formValidation('resetForm', true);
});