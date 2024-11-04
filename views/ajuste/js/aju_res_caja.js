function editar(id_caja, descripcion, estado) {
    $(".f").addClass("focused");
    $('#id_caja').val(id_caja);
    $('#descripcion').val(descripcion);
    $('#estado').selectpicker('val', estado);
    $('.modal-title').text('Editar');
    $('#modal').modal('show');
}

$(function () {
    let id_caja, descripcion, estado;

    function listar() {
        function filterGlobal() {
            $('#table').DataTable().search($('#global_filter').val()).draw();
        }

        const table = $('#table').DataTable({
            destroy: true,
            responsive: true,
            dom: "tip",
            bSort: true,
            ajax: {
                method: "POST",
                url: $('#url').val() + "ajuste/caja_list"
            },
            columns: [
                { data: "descripcion" },
                {
                    data: null, render: function (data, type, row) {
                        if (data.estado === 'a') {
                            return '<span class="label label-success">ACTIVO</span>';
                        } else if (data.estado === 'i') {
                            return '<span class="label label-danger">INACTIVO</span>';
                        }
                    }
                },
                {
                    data: null, render: function (data, type, row) {
                        return '<div class="text-right"><a href="javascript:void(0)" class="text-info edit" onclick="editar(' + data.id_caja + ',\'' + data.descripcion + '\',\'' + data.estado + '\');"><i data-feather="edit" class="feather-sm fill-white"></i></a></div>';
                    }
                }
            ]
        });

        $('input.global_filter').on('keyup click', function () {
            filterGlobal();
        });

        table.on("draw", function () {
            feather.replace();
        });
    }

    $('.btn-nuevo').click(function () {
        $(".f").removeClass("focused");
        $('#id_caja').val('');
        $('.modal-title').text('Nuevo');
        $('#modal').modal('show');
    });

    $('#modal').on('hidden.bs.modal', function () {
        $(this).find('form')[0].reset();
        $('#form').formValidation('resetForm', true);
        $('#estado').selectpicker('val', 'a');
    });

    // Inicialización
    listar();
    $('#config').addClass("active");

    $('#form').formValidation({
        framework: 'bootstrap',
        excluded: ':disabled',
        fields: {}
    }).on('success.form.fv', function (e) {
        e.preventDefault();
        var $form = $(e.target),
            fv = $form.data('formValidation');

        id_caja = $('#id_caja').val();
        descripcion = $('#descripcion').val();
        estado = $('#estado').val();

        $.ajax({
            dataType: 'JSON',
            type: 'POST',
            url: $('#url').val() + 'ajuste/caja_crud',
            data: {
                id_caja: id_caja,
                descripcion: descripcion,
                estado: estado
            },
            success: function (cod) {
                if (cod === 0) {
                    mostrarAlerta('Proceso No Culminado', 'Datos duplicados', 'error');
                } else if (cod === 1) {
                    $('#modal').modal('hide');
                    mostrarAlerta('Proceso Terminado', 'Datos registrados correctamente', 'success');
                    listar();
                } else if (cod === 2) {
                    $('#modal').modal('hide');
                    mostrarAlerta('Proceso Terminado', 'Datos actualizados correctamente', 'success');
                    listar();
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('Error en la llamada Ajax:', textStatus, errorThrown);
            }
        });

        return false;
    });

    function mostrarAlerta(title, text, icon) {
        Swal.fire({
            title: title,
            text: text,
            icon: icon,
            confirmButtonColor: "#34d16e",
            confirmButtonText: "Aceptar",
            allowOutsideClick: false,
            showCancelButton: false,
            showConfirmButton: true
        }, function () {
            return false;
        });
    }
});