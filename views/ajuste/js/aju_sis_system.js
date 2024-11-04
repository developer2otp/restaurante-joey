const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: false,
    didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
    }
});
$(document).ready(function() {
    $("#turnName").on("click", function() {
        var formData = new FormData();
        formData.append('turn_name', $('#nombre_turno').val());

        fetch(document.getElementById('url').value + 'caja/InsertTurno', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la solicitud');
            }
            return response.json();
        })
        .then(data => {
            // Manejar la respuesta aquí
            //var titulo = data.message;
            if(data.success == 1){
                var titulo = 'Dtos insertados';
                var icono = 'success';
            }else{
                var titulo = data.message;
                var icono = 'error';
            }
            Toast.fire({
                icon: icono,
                title: titulo
            });
            setTimeout(function () {
                location.reload(); // Recargar la página
            }, 3000);
            // console.log(data);
        })
        .catch(error => {
            // Manejar errores aquí
            console.error('Error:', error);
            Swal.fire('Error', 'Ha ocurrido un error al procesar la solicitud.', 'error');
        });
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const miBoton = document.getElementById('miBoton');

    // Agrega un listener de evento al botón
    miBoton.addEventListener('click', function (event) {
        event.preventDefault(); // Evita el comportamiento predeterminado del botón (enviar el formulario)

        // Obtener los datos del formulario
        var formData = new FormData(document.getElementById('form'));

        // Realizar la petición AJAX usando fetch
        fetch(document.getElementById('url').value + 'ajuste/system_save', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la solicitud');
            }
            return response.json();
        })
        .then(data => {
            // Manejar la respuesta aquí
            if(data.success == 1){
                var titulo = 'Datos actualizados';
                var icono = 'success';
            }else{
                var titulo = 'Ocurrió un problema';
                var icono = 'error';
            }
            Toast.fire({
                icon: icono,
                title: titulo
            });
            setTimeout(function () {
                location.reload(); // Recargar la página
            }, 3000);
            // console.log(data);
        })
        .catch(error => {
            // Manejar errores aquí
            console.error('Error:', error);
            Swal.fire('Error', 'Ha ocurrido un error al procesar la solicitud.', 'error');
        });
    });
});