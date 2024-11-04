Culqi.publicKey = 'pk_test_f2d77589c8711b40';

function culqi() {
    const html_confirm = '<h4 class="m-t-20 font-bold">Validando sus datos</h4></div>' +
        '<div class="p-0">Espere un momento por favor...</div>';

    Swal.fire({
        html: html_confirm,
        timer: 3000,
        allowOutsideClick: false,
        allowEscapeKey: false,
        showCancelButton: false,
        showConfirmButton: false,
        closeOnConfirm: false,
        closeOnCancel: false,
        onBeforeOpen: () => {
            Swal.showLoading()
        }
    });

    const getCarrito = JSON.parse(localStorage.getItem("carrito"));
    const total = getCarrito.reduce((acc, item) => acc + parseFloat(item.cantidad) * parseFloat(item.precio), 0);

    const total_ = total.toFixed(2).toString();
    const amount = total_.replace(".", "");

    if (Culqi.token) {
        const token = Culqi.token.id;
        const email = Culqi.token.email;

        const data = {
            producto: 'Productos varios',
            precio: amount,
            token: token,
            customer_id: '44827499',
            address: 'Jr Drenaje',
            address_city: 'Ancash - Chimbote',
            first_name: 'Tommy Leonard',
            email: email
        };

        const url = $('#url').val() + "views/checkout/proceso.php";

        $.post(url, data, function(res) {
            if (res === "exito") {
                guardarPedido(email);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'No se pudo realizar el pago!',
                    confirmButtonColor: '#4aa36b'
                });
            }
        });
    } else {
        alert(Culqi.error.user_message);
    }
}