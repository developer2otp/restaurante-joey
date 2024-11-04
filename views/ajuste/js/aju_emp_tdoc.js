$(function () {
    $('#config').addClass("active");
    listarTiposDoc();

    var formValidationOptions = {
        framework: 'bootstrap',
        excluded: ':disabled',
        fields: {}
    };

    $('#form').formValidation(formValidationOptions)
        .on('success.form.fv', function (e) {
            e.preventDefault();
            var $form = $(e.target),
                fv = $form.data('formValidation');

            var formData = {
                id_tipo_doc: $('#id_tipo_doc').val(),
                serie: $('#serie').val(),
                numero: $('#numero').val(),
                estado: $('#estado').val()
            };

            $.ajax({
                dataType: 'JSON',
                type: 'POST',
                url: 'tipodoc_crud',
                data: formData,
                success: function (datos) {
                    $('#modal').modal('hide');
                    showSuccessModal(datos.message);
                    listarTiposDoc();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown + ' ' + textStatus);
                }
            });
        });
});

function showSuccessModal(message) {
    Swal.fire({
        title: 'Proceso Terminado',
        text: message,
        icon: "success",
        confirmButtonColor: "#34d16e",
        confirmButtonText: "Aceptar",
        allowOutsideClick: false,
        showCancelButton: false,
        showConfirmButton: true
    });
}

var listarTiposDoc = function () {
    var table = $('#table').DataTable({
        destroy: true,
        responsive: true,
        dom: "tip",
        bSort: true,
        ajax: {
            method: "POST",
            dataType: "JSON",
            url: $('#url').val() + "ajuste/tipodoc_list"
        },
        columns: [
            { data: "descripcion" },
            { data: "serie" },
            { data: "numero" },
            {
                data: null, render: function (data, type, row) {
                    var labelClass = data.estado === 'a' ? 'label-success' : 'label-danger';
                    var labelText = data.estado === 'a' ? 'ACTIVO' : 'INACTIVO';
                    return '<span class="label ' + labelClass + '">' + labelText + '</span>';
                }
            },
            {
                data: null, render: function (data, type, row) {
                    feather.replace();
                    var editLink = '<a href="javascript:void(0)" class="text-info edit" onclick="editar(' +
                        data.id_tipo_doc + ',\'' + data.descripcion + '\',\'' + data.serie + '\',\'' + data.numero +
                        '\',\'' + data.estado + '\');"><i data-feather="edit" class="feather-sm fill-white"></i></a>';
                    return '<div class="text-right">' + editLink + '</div>';
                }
            }
        ]
    });
}

function editar(id_tipo_doc, descripcion, serie, numero, estado) {
    $(".f").addClass("focused");
    $('#id_tipo_doc').val(id_tipo_doc);
    $('#serie').val(serie);
    $('#numero').val(numero);
    $('#estado').selectpicker('val', estado);
    $(".modal-title").html("<center>" + descripcion + "</center>");
    $("#modal").modal('show');
}

$('#modal').on('hidden.bs.modal', function () {
    $(this).find('form')[0].reset();
    $('#form').formValidation('resetForm', true);
    $('#estado').selectpicker('val', 'a');
});