//archivo actualizado
var app = {
    init: function () {
        this.setupUI();
        this.listarUsuarios();
    },
    setupUI: function () {
        $('#config').addClass("active");
        $('#global_filter').on('keyup click', this.filterGlobal.bind(this));
    },
    listarUsuarios: function () {
        var self = this;

        var table = $('#table').DataTable({
            "destroy": true,
            "responsive": true,
            "ajax": {
                "method": "POST",
                "url": $('#url').val() + "ajuste/usuario_list"
            },
            "columns": [
                {"data":"nombres"},
                {"data":"ape_paterno"},
                {"data":"ape_materno"},
                { "data": null, "render": function (data, type, row) {
                    return self.renderRole(data);
                }},
                {"data": null, "render": function (data, type, row) {
                    return self.renderEstado(data);
                }},
                {"data": null, "render": function (data, type, row) {
                    return self.renderAcciones(data);
                }}
            ]
        });

        table.on("draw", function () {
            feather.replace();
        });

        // Manejar clic enlaces de estado
        $('#table').on('click', '.estado-link', function (e) {
            e.preventDefault();
            var id_usu = $(this).data('id');
            var estado = $(this).data('estado');
            var nombre = $(this).data('nombre');
        
            app.confirmDialog(`Se pondrá ${estado === 'a' ? 'ACTIVO' : 'INACTIVO'} al usuario:<br>${nombre}`)
                .then(function (isConfirmed) {
                    if (isConfirmed.value === true) {
                        return app.actualizarEstado(id_usu, estado);
                    }
                })
                .catch(function (error) {
                    console.error('Error en confirmación o actualización:', error);
                });
        });

        // Manejar clic enlaces de eliminar
        $('#table').on('click', '.eliminar-link', function (e) {
            e.preventDefault();
            var id_usu = $(this).data('id');
            var id_rol = $(this).data('rol');
            var nombre = $(this).data('nombre');
            
            app.confirmDialog(`Se procederá a eliminar al usuario:<br>${nombre}`)
                .then(function (isConfirmed) {
                    if (isConfirmed.value === true) {
                        return app.eliminarUsuario(id_usu, id_rol);
                    }
                })
                .then(function () {
                    app.listarUsuarios();
                })
                .catch(function (error) {
                    console.error('Error en confirmación:', error);
                });
        });
    },
    renderRole: function (data) {
        var roles = {
            1: 'label-light-primary',
            2: 'label-light-info',
            3: 'label-light-warning',
            4: 'label-light-success',
            5: 'label-light-success',
            6: 'label-light-success'
        };

        return '<span class="label ' + roles[data.id_rol] + '">' + data.desc_r + '</span>';
    },
    renderEstado: function (data) {
        var estadoHtml = '';
        if (data.estado == 'a') {
            estadoHtml = '<div class="text-center"><a href="#" data-id="' + data.id_usu + '" data-estado="i" data-nombre="' + data.nombres + ' ' + data.ape_paterno + ' ' + data.ape_materno + '" class="estado-link"><span class="label label-success">ACTIVO</span></a></div>';
        } else if (data.estado == 'i') {
            estadoHtml = '<div class="text-center"><a href="#" data-id="' + data.id_usu + '" data-estado="a" data-nombre="' + data.nombres + ' ' + data.ape_paterno + ' ' + data.ape_materno + '" class="estado-link"><span class="label label-danger">INACTIVO</span></a></div>';
        }
        return estadoHtml;
    },
    renderAcciones: function (data) {
        return '<div class="text-right">' +
            '<a href="usuario_edit/' + data.id_usu + '" class="text-info edit"><i data-feather="edit" class="feather-sm fill-white"></i></a>' +
            '&nbsp;<a href="#" class="text-danger delete ms-2 eliminar-link" data-id="' + data.id_usu + '" data-rol="' + data.id_rol + '" data-nombre="' + data.nombres + ' ' + data.ape_paterno + ' ' + data.ape_materno + '"><i data-feather="trash-2" class="feather-sm fill-white"></i></a>' +
            '</div>';
    },
    filterGlobal: function () {
        $('#table').DataTable().search($('#global_filter').val()).draw();
    },
    confirmDialog: function (htmlContent) {
        return Swal.fire({
            title: 'Necesitamos de tu Confirmación',
            html: htmlContent,
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#34d16e',
            confirmButtonText: 'Si, Adelante!',
            cancelButtonText: "No!",
            showLoaderOnConfirm: true,
            preConfirm: function (isConfirmed) {
                return new Promise(function (resolve) {
                    resolve(isConfirmed);
                });
            },
            allowOutsideClick: false
        });
    },
    actualizarEstado: function (id_usu, estado) {
        var self = this;
        var url = $('#url').val() + 'ajuste/usuario_estado';
        
        return $.ajax({
            url: url,
            type: 'POST',
            data: { id_usu: id_usu, estado: estado },
            dataType: 'json'
        })
        .done(function (response) {
            var titulo = response.success ? 'Proceso Terminado' : 'Proceso no Culminado';
            var icono = response.success ? 'success' : 'error';
            self.mostrarMensaje(titulo, response.message, icono);
            app.listarUsuarios();
        })
        .fail(function () {
            self.mostrarMensaje('Error', 'Problemas con la conexión a internet!', 'error');
        });
    },
    eliminarUsuario: function (id_usu, id_rol) {
        var self = this;
    
        return $.ajax({
            url: $('#url').val() + 'ajuste/usuario_delete',
            type: 'POST',
            data: {
                id_usu: id_usu,
                id_rol: id_rol
            },
            dataType: 'json'
        })
        .done(function (response) {
            var titulo = response.success ? 'Proceso Terminado' : 'Proceso no Culminado';
            var icono = response.success ? 'success' : 'error';
            self.mostrarMensaje(titulo, response.message, icono);
            app.listarUsuarios();
        })
        .fail(function () {
            self.mostrarMensaje('Error', 'Problemas con la conexión a internet!', 'error');
        });
    },
    mostrarMensaje: function (title, text, icon) {
        Swal.fire({
            title: title,
            text: text,
            icon: icon,
            confirmButtonColor: "#34d16e",
            confirmButtonText: "Aceptar"
        });
    }
    };
    

$(function () {
    app.init();
});