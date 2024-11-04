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
        }).done(function(data) {
            if (data.length > 0) {
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
            } else {
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
                $('#form-login').formValidation('resetForm', true);
                return;
            }
        }).fail(function() {
            Swal.fire('Oops...', 'Problemas con la conexión a internet!', 'error');
        });
    });

    $('#form-pedido').formValidation({
        framework: 'bootstrap',
        excluded: ':disabled',
        fields: {}
    }).on('success.form.fv', function(e) {
        e.preventDefault();
        var $form = $(e.target),
            fv = $form.data('formValidation');
        var form = $(this);

        //getUsuario = JSON.parse(localStorage.getItem("usuario"));
        getCarrito = JSON.parse(localStorage.getItem("carrito"));

        if (getCarrito.length === 0) {
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
                icon: 'warning',
                title: 'Tu bolsa de compras está vacía'
            });
            return;
        } else {
            if ($('#tipo_pago').val() != 4) {
                guardarPedido('example@email.com');
            } else {
                var total = getCarrito.reduce(function(sum, item) {
                    return sum + parseFloat(item.cantidad) * parseFloat(item.precio);
                }, 0);
                var total_ = total.toFixed(2).toString();
                var amount = total_.replace(".", "");

                Culqi.settings({
                    title: 'Delivery Food',
                    currency: 'PEN',
                    description: 'Pago productos varios',
                    amount: amount
                });
                Culqi.open();
            }
        }
    });
});

var guardarPedido = function(email) {
    getUsuario = JSON.parse(localStorage.getItem("usuario"));
    getCarrito = JSON.parse(localStorage.getItem("carrito"));

    getUsuario.telefono = $('#telefono_cliente').val();
    getUsuario.direccion = $('#direccion_cliente').val();
    getUsuario.referencia = $('#referencia_cliente').val();
    localStorage.setItem("usuario", JSON.stringify(getUsuario));

    var pedido = {
        tipo_entrega: $('input:radio[name="tipo_entrega"]:checked').val(),
        tipo_pago: $('#tipo_pago').val(),
        id_cliente: $('#id_cliente').val(),
        nombre_cliente: $('#nombre_cliente').val(),
        telefono_cliente: $('#telefono_cliente').val(),
        direccion_cliente: $('#direccion_cliente').val(),
        referencia_cliente: $('#referencia_cliente').val(),
        hora_entrega: $('#hora_entrega').val(),
        email_cliente: email,
        detalle_pedido: getCarrito
    };

    if ($('#tipo_pago').val() != 4) {
        html_confirm = '';
        Swal.fire({
            title: 'Necesitamos de tu Confirmación',
            html: html_confirm,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#4aa36b',
            cancelButtonText: "No!",
            confirmButtonText: 'Si, Adelante!',
            showLoaderOnConfirm: true
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: 'POST',
                    url: $('#url').val() + 'checkout/RegistrarPedido',
                    data: pedido,
                    success: function(dato) {
                        $('.section-resumen').hide();
                        $('.section-confirmacion').show();
                        localStorage.setItem('carrito', '[]');
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown + ' ' + textStatus);
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                //$("#modal-facturar").modal('show');
            }
        });
    } else {
        $.ajax({
            type: 'POST',
            url: $('#url').val() + 'checkout/RegistrarPedido',
            data: pedido,
            success: function(dato) {
                $('.section-resumen').hide();
                $('.section-confirmacion').show();
                localStorage.setItem('carrito', '[]');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown + ' ' + textStatus);
            }
        });
    }
};

var validarLogin = function() {
    var filtro = JSON.parse(localStorage.getItem("usuario"));
    if (filtro.telefono != undefined) {
        $('.display-login').css('display', 'none');
        $('.display-informacion').css('display', 'block');
        $('.user-nombre').text(filtro.nombre);
        $('#nombre_cliente').val(filtro.nombre);
        $('#telefono_cliente').val(filtro.telefono);
        $('#direccion_cliente').val(filtro.direccion);
        $('#referencia_cliente').val(filtro.referencia);
        $('.display-nombre').css('display', 'none');
        var b = document.querySelector("#nombre_cliente");
        b.setAttribute("type", "hidden");
        $("#nombre_cliente").attr('disabled', 'true');
        $('#id_cliente').val(filtro.id);
    } else {
        $('.display-login').css('display', 'block');
        $('.display-informacion').css('display', 'none');
    }
};

$(".user-new").click(function() {
    $('#id_cliente').val('1');
    $('.display-login').css('display', 'none');
    $('.display-informacion').css('display', 'block');
    $('.display-nombre').css('display', 'block');
    var b = document.querySelector("#nombre_cliente");
    b.setAttribute("type", "text");
    $("#nombre_cliente").removeAttr('disabled');
    $('#form-pedido').formValidation('resetForm', true);
    $('.user-nombre').text('');
    $('.content-efectivo').hide();
    $('.content-tarjeta').hide();
});

$(".user-refresh").click(function() {
    localStorage.setItem('usuario', '[]');
    $('#form-login').formValidation('resetForm', true);
    validarLogin();
});

$("input[name=tipo_entrega]").click(function() {
    if ($(this).val() == 1) {
        $('.display-despacho').show();
        $('.content-despacho-casa').hide();
        if ($('#tipo_pago').val() == 1) {
            $('.content-efectivo').show();
        } else if ($('#tipo_pago').val() == 2) {
            $('.content-tarjeta').show();
        }
        $("#direccion_cliente").removeAttr('disabled');
        $("#referencia_cliente").removeAttr('disabled');
    } else if ($(this).val() == 2) {
        $('.display-despacho').hide();
        $('.content-despacho-casa').show();
        if ($('#tipo_pago').val() == 1) {
            $('.content-efectivo').hide();
        } else if ($('#tipo_pago').val() == 2) {
            $('.content-tarjeta').hide();
        }
        $("#direccion_cliente").attr('disabled', 'true');
        $("#referencia_cliente").attr('disabled', 'true');
    }
});

$('#tipo_pago').change(function() {
    var x = document.getElementById("tipo_pago").selectedIndex;

    if (this.value == 1) {
        $('.content-tarjeta').hide();
        $('.content-yape').hide();
        $('.content-transferencia').hide();
        $('.content-plin').hide();
        $('.content-tunki').hide();
        $('.content-culqui-mensaje').hide();
        $('.btn-submit > span').text('Ordenar ahora!');
        if ($('input:radio[name="tipo_entrega"]:checked').val() == 1) {
            $('.content-efectivo').show();
        } else if ($('input:radio[name="tipo_entrega"]:checked').val() == 2) {
            $('.content-efectivo').hide();
        }
    } else if (this.value == 2) {
        $('.content-efectivo').hide();
        $('.content-yape').hide();
        $('.content-transferencia').hide();
        $('.content-plin').hide();
        $('.content-tunki').hide();
        $('.content-culqui-mensaje').hide();
        $('.btn-submit > span').text('Ordenar ahora!');
        if ($('input:radio[name="tipo_entrega"]:checked').val() == 1) {
            $('.content-tarjeta').show();
        } else if ($('input:radio[name="tipo_entrega"]:checked').val() == 2) {
            $('.content-tarjeta').hide();
        }
    } else if (this.value == 4) {
        $('.content-efectivo').hide();
        $('.content-tarjeta').hide();
        $('.content-culqui-mensaje').show();
        $('.btn-submit > span').text('Pagar y Ordenar ahora!');
    } else if (this.value == 5) {
        $('.content-efectivo').hide();
        $('.content-tarjeta').hide();
        $('.content-yape').show();
        $('.content-transferencia').hide();
        $('.content-plin').hide();
        $('.content-tunki').hide();
        $('.content-culqui-mensaje').hide();
    } else if (this.value == 7) {
        $('.content-efectivo').hide();
        $('.content-tarjeta').hide();
        $('.content-yape').hide();
        $('.content-transferencia').show();
        $('.content-plin').hide();
        $('.content-tunki').hide();
        $('.content-culqui-mensaje').hide();
    } else if (this.value == 11) {
        $('.content-efectivo').hide();
        $('.content-tarjeta').hide();
        $('.content-yape').hide();
        $('.content-transferencia').hide();
        $('.content-plin').show();
        $('.content-tunki').hide();
        $('.content-culqui-mensaje').hide();
    } else if (this.value == 12) {
        $('.content-efectivo').hide();
        $('.content-tarjeta').hide();
        $('.content-yape').hide();
        $('.content-transferencia').hide();
        $('.content-plin').hide();
        $('.content-tunki').show();
        $('.content-culqui-mensaje').hide();
    }
});