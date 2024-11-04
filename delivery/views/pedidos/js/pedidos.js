$(function() {
    validarLogin();

    $('#form-login').formValidation({
        framework: 'bootstrap',
        excluded: ':disabled',
        fields: {}
    }).on('success.form.fv', function(e) {
        e.preventDefault();
        var $form = $(e.target),
            fv = $form.data('formValidation');
        var form = $(this);

        var formdata = new FormData($('#form-login')[0]);

        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            data: formdata,
            url: $('#url').val() + 'checkout/run',
            contentType: false,
            processData: false,
        })
        .then(function(data) {
            if (data.length > 0) {
                guardarInformacionUsuario(data);
            } else {
                mostrarErrorToast();
                $('#form-login').formValidation('resetForm', true);
                return;
            }
        })
        .fail(function() {
            mostrarErrorConexionToast();
        });
    });

    var pedidosList = function(estado, telefono_cliente) {
        var table = $('#table')
            .DataTable({
                "destroy": true,
                "dom": "tp",
                "bSort": false,
                "ajax": {
                    "method": "POST",
                    "url": $('#url').val() + "pedidos/pedidos_list",
                    "data": {
                        estado: estado,
                        telefono_cliente: telefono_cliente
                    }
                },
                "columns": [
                    // ... Columnas
                ]
            });

        $('.dataTables_wrapper').css('padding', '0');
    };

    // Resto del código...
});

function guardarInformacionUsuario(data) {
    $.each(data, function(i, item) {
        var infoUsuario = {
            id: item.id_cliente,
            nombre: item.nombre_cliente,
            direccion: item.direccion_cliente,
            referencia: item.referencia_cliente,
            telefono: item.telefono_cliente
        };

        localStorage.setItem("usuario", JSON.stringify(infoUsuario));
        $('#id_cliente').val(item.id_cliente);
    });

    validarLogin();
}

function mostrarErrorToast() {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true,
        onOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });

    Toast.fire({
        icon: 'error',
        title: 'El número ingresado no existe'
    });
}

function mostrarErrorConexionToast() {
    Swal.fire('Oops...', 'Problemas con la conexión a internet!', 'error');
}

$(".user-refresh").click(function() {
    localStorage.setItem('usuario', '[]');
    $('#form-login').formValidation('resetForm', true);
    validarLogin();
});

$(".list-recientes").click(function() {
    $('.text-pedidos').text('Recientes');
    var filtro = JSON.parse(localStorage.getItem("usuario"));
    pedidosList('a', filtro.telefono);
});

$(".list-anteriores").click(function() {
    $('.text-pedidos').text('Anteriores');
    var filtro = JSON.parse(localStorage.getItem("usuario"));
    pedidosList('d', filtro.telefono);
});