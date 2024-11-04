$(function () {
    let id_areap, id_imp, nombre, estado;

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

    function ajaxRequest(url, data, successCallback, errorCallback) {
        $.ajax({
            dataType: 'JSON',
            type: 'POST',
            url: url,
            data: data,
            success: successCallback,
            error: errorCallback
        });
    }

    function editar(id_areap) {
        $(".f").addClass("focused");
        ajaxRequest(
            $('#url').val() + "ajuste/areaprod_list",
            { id_areap: id_areap },
            function (item) {
                $.each(item.data, function (i, campo) {
                    $('#id_areap').val(campo.id_areap);
                    $('#nombre').val(campo.nombre);
                    $('#estado').selectpicker('val', campo.estado);
                    $('#id_imp').selectpicker('val', campo.id_imp);
                    $('.modal-title').text('Editar');
                    $('#modal').modal('show');
                });
            }
        );
    }

    function listar() {
        function filterGlobal() {
            $('#table').DataTable().search(
                $('#global_filter').val()
            ).draw();
        }

        const table = $('#table').DataTable({
            destroy: true,
            responsive: true,
            dom: "tip",
            bSort: true,
            ajax: {
                method: "POST",
                url: $('#url').val() + "ajuste/areaprod_list",
                data: { id_areap: '%' }
            },
            columns: [
                { data: "nombre" },
                { data: "ImpresoraNombre" },
                {
                    data: null, render: function (data, type, row) {
                        if (data.estado == 'a') {
                            return '<span class="label label-success">ACTIVO</span>';
                        } else if (data.estado == 'i') {
                            return '<span class="label label-danger">INACTIVO</span>';
                        }
                    }
                },
                {
                    data: null, render: function (data, type, row) {
                        return '<div class="text-right"><a href="javascript:void(0)" class="text-info edit" data-id-areap="' + data.id_areap + '"><i data-feather="edit" class="feather-sm fill-white"></i></a></div>';
                    }
                }
            ]
        });

        $('input.global_filter').on('keyup click', function () {
            filterGlobal();
        });

        // Asignar el evento de clic dinámicamente usando jQuery
        $('#table').on('click', '.edit', function () {
            let id_areap = $(this).data('id-areap');
            editar(id_areap);
        });

        table.on("draw", function () {
            feather.replace();
        });
    }

    $('.btn-nuevo').click(function () {
        $(".f").removeClass("focused");
        $('#id_areap').val('');
        $('.modal-title').text('Nuevo');
        $('#modal').modal('show');
    });

    $('#modal').on('hidden.bs.modal', function () {
        $(this).find('form')[0].reset();
        $('#form').formValidation('resetForm', true);
        $('#id_imp').selectpicker('val', '');
        $('#estado').selectpicker('val', 'a');
    });

    $('#form').formValidation({
        framework: 'bootstrap',
        excluded: ':disabled',
        fields: {}
    }).on('success.form.fv', function (e) {
        e.preventDefault();
        var $form = $(e.target),
            fv = $form.data('formValidation');

        id_areap = $('#id_areap').val();
        id_imp = $('#id_imp').val();
        nombre = $('#nombre').val();
        estado = $('#estado').val();

        ajaxRequest(
            $('#url').val() + 'ajuste/areaprod_crud',
            { id_areap: id_areap, nombre: nombre, id_imp: id_imp, estado: estado },
            function (cod) {
                if (cod == 0) {
                    mostrarAlerta('Proceso No Culminado', 'Datos duplicados', 'error');
                } else if (cod == 1) {
                    $('#modal').modal('hide');
                    mostrarAlerta('Proceso Terminado', 'Datos registrados correctamente', 'success');
                    listar();
                } else if (cod == 2) {
                    $('#modal').modal('hide');
                    mostrarAlerta('Proceso Terminado', 'Datos actualizados correctamente', 'success');
                    listar();
                }
            },
            function (jqXHR, textStatus, errorThrown) {
                console.error('Error en la llamada Ajax:', textStatus, errorThrown);
            }
        );

        return false;
    });

    // Inicialización
    listar();
    $('#config').addClass("active");
});