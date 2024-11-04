$(function() {
    $('#form')
    .formValidation({
        framework: 'bootstrap',
        excluded: ':disabled',
        fields: {
            // Aquí deberías tener las reglas de validación para los campos del formulario
        }
    })
    .on('success.form.fv', function(e) {
        e.preventDefault();
        var $form = $(e.target),
            fv = $form.data('formValidation');

        // Obtén los valores de los campos del formulario
        var id_pago = $('#id_pago').val();
        var id_tipo_pago = $('#id_tipo_pago').val();
        var nombre = $('#nombre').val();
        var comunicacion = $('#comunicacion').val();
        var color = $('#color').val();
        var delivery = $('#delivery').val();
        var estado = $('#estado').val();
        console.log(id_pago);

        // Realiza la solicitud AJAX a la URL 'ajuste/tipopago_crud'
        $.ajax({
            dataType: 'JSON',
            type: 'POST',
            url: $('#url').val() + 'ajuste/tipopago_crud',
            data: {
                id_pago: id_pago,
                id_tipo_pago: id_tipo_pago,
                nombre: nombre,
                comunicacion: comunicacion,
                color: color,
                delivery: delivery,
                estado: estado
            },
            success: function (cod) {
                // Lógica de manejo de la respuesta JSON
                //console.log(cod);
                if (cod.success == 1){
                    $('#modal').modal('hide');
                    var titulo = 'Proceso Terminado';
                    var icono = 'success';
                    listar();
                } else {
                    var titulo = 'Proceso No Culminado'; 
                    var icono = "error";
                }

                Swal.fire({   
                    title: titulo,
                    text: cod.message,
                    icon: icono, 
                    confirmButtonColor: "#34d16e",   
                    confirmButtonText: "Aceptar",
                    allowOutsideClick: false,
                    showCancelButton: false,
                    showConfirmButton: true
                }, function() {
                    return false
                });
            },
            error: function(jqXHR, textStatus, errorThrown){
                console.log(errorThrown + ' ' + textStatus);
            }   
        });
        return false;
    });

    var table;

    function filterGlobal() {
        table.search($('#global_filter').val()).draw();
    }

    function editar(idPago) {
        $(".f").addClass("focused");
        $.ajax({
            type: "POST",
            url: $('#url').val() + "ajuste/tipopago_list",
            data: {
                id_pago: idPago
            },
            dataType: "json",
            success: function (item) {
                $.each(item.data, function (i, campo) {
                    $('#id_pago').val(campo.id_tipo_pago);
                    $('#nombre').val(campo.descripcion);
                    $('#id_tipo_pago').selectpicker('val', campo.id_pago);
                    $('#estado').selectpicker('val', campo.estado);
                    $('.modal-title').text('Editar');
                    $('#modal').modal('show');
                });
            }
        });
    }

    function abrirModal(titulo) {
        $('.modal-title').text(titulo);
        $('#modal').modal('show');
    }

    function resetearModal() {
        $('#modal').find('form')[0].reset();
        $('#form').formValidation('resetForm', true);
        $('#id_tipo_pago').selectpicker('val', '');
        $('#estado').selectpicker('val', 'a');
        $('#delivery').selectpicker('val', '0');
    }

    function listar() {
        table = $('#table').DataTable({
            order: [[2, "asc"]],
            destroy: true,
            responsive: true,
            dom: "tip",
            bSort: true,
            ajax: {
                method: "POST",
                url: $('#url').val() + "ajuste/tipopago_list",
                data: {
                    id_pago: '%'
                }
            },
            columns: [
                { data: "descripcion" },
                { data: "nombre" },
                {
                    data: null, render: function (data, type, row) {
                        return data.estado == 'a' ? '<span class="label label-success">ACTIVO</span>' :
                            '<span class="label label-danger">INACTIVO</span>';
                    }
                },
                {
                    data: null, render: function (data, type, row) {
                        return '<div class="text-right"><a href="javascript:void(0)" class="text-info edit" data-id="' + data.id_tipo_pago + '"><i data-feather="edit" class="feather-sm fill-white"></i></a></div>';
                    }
                }
            ]
        });

        table.on("draw.dt", function () {
            feather.replace(); // Inicializa Feather Icons después de que el DataTable se haya creado o redibujado
        });

        $('input.global_filter').on('keyup click', function () {
            filterGlobal();
        });

        // Delegación de eventos para elementos dinámicos
        $('#table').on('click', '.edit', function () {
            var idPago = $(this).data('id');
            editar(idPago);
        });

        $('.btn-nuevo').click(function () {
            $(".f").removeClass("focused");
            $('#id_pago').val('');
            abrirModal('Nuevo');
        });

        $('#modal').on('hidden.bs.modal', function () {
            resetearModal();
        });
    }

    listar();
});