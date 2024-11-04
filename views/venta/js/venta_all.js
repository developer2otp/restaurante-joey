$(function(){
    $('body').css('padding-right','0px');
    container();

    var card_height = function () {
        var topOffset = 87;
        var height = ((window.innerHeight > 0) ? window.innerHeight : this.screen.height) - 1;
        height = height - topOffset;
        /*$(".card_height").css("height", (height) + "px");*/
    };
    $(window).ready(card_height);
    $(window).on("resize", card_height);

    $('.scroll_subitems').slimscroll({
        height: 300
    });

    $('.scroll_categorias').slimscroll({
        height: '100%',
        disableFadeOut: true
    });
    var scroll_categorias = function () {
        var topOffset = 150;
        var height = ((window.innerHeight > 0) ? window.innerHeight : this.screen.height) - 1;
        height = height - topOffset;
        height = 84;
        $(".scroll_categorias").css("height", (height) + "px");
        $(".scroll_categorias").css("width", "100% !important;");
    };
    $(window).ready(scroll_categorias);
    $(window).on("resize", scroll_categorias);

    $('.scroll_mesas').slimscroll({
        height: '100%',
        width: '100%',
        disableFadeOut: true
    });
    var scroll_mesas = function () {
        var topOffset = ($('#rol_usr').val() == 5) ? 170 : 240;
        var height = ((window.innerHeight > 0) ? window.innerHeight : this.screen.height) - 40;
        height = height - topOffset;
        $(".scroll_mesas").css("height", (height) + "px");
        $(".scroll_mesas").css("width", "100% !important;");
    };
    $(window).ready(scroll_mesas);
    $(window).on("resize", scroll_mesas);

    $('.scroll_mostrador').slimscroll({
        height: '100%'
    });
    var scroll_mostrador = function () {
        var topOffset = 271;
        var height = ((window.innerHeight > 0) ? window.innerHeight : this.screen.height) - 1;
        height = height - topOffset;
        $(".scroll_mostrador").css("height", (height) + "px");
    };
    $(window).ready(scroll_mostrador);
    $(window).on("resize", scroll_mostrador);

    $('.scroll_content_pedidos').slimscroll({
        height: '100%'
    });
    var scroll_content_pedidos = function () {
        var topOffset = 360;
        var height = ((window.innerHeight > 0) ? window.innerHeight : this.screen.height) - 1;
        height = height - topOffset;
        $(".scroll_content_pedidos").css("height", (height) + "px");
    };
    $(window).ready(scroll_content_pedidos);
    $(window).on("resize", scroll_content_pedidos);

    $('.scroll_pedidos').slimscroll({
        height: '100%',
        disableFadeOut: true
    });
    var scroll_pedidos = function () {
        var topOffset = 275;
        var height = ((window.innerHeight > 0) ? window.innerHeight : this.screen.height) - 1;
        height = height - topOffset;
        $(".scroll_pedidos").css("height", (height) + "px");
    };
    $(window).ready(scroll_pedidos);
    $(window).on("resize", scroll_pedidos);

    $('.scroll_productos').slimscroll({
        height: '100%',
        wheelStep : 10,
        touchScrollStep :75
    });
    var scroll_productos = function () {
        if(screen.width > 767){
            var topOffset = 100;
        } else if (screen.width < 768){
            var topOffset = 78;
        }
        var height = ((window.innerHeight > 0) ? window.innerHeight : this.screen.height) - 1;
        height = height - (topOffset + 95);
        /*height = 590;*/
        $(".scroll_productos").css("height", (height) + "px");
    };
    $(window).ready(scroll_productos);
    $(window).on("resize", scroll_productos);

    $('.scroll_orden').slimscroll({
        height: '100%'
    });
    var scroll_orden = function () {
        if(screen.width > 767){
            var topOffset = 249;
        } else if (screen.width < 768){
            var topOffset = 232;
        }
        var height = ((window.innerHeight > 0) ? window.innerHeight : this.screen.height) - 1;
        height = height - topOffset;
        $(".scroll_orden").css("height", (height) + "px");
    };
    $(window).ready(scroll_orden);
    $(window).on("resize", scroll_orden);
});

var container = function(){
    if($('#rol_usr').val() == 5){
        $('.u4-2-1').addClass('p-0 col-lg-8');
    }
}

var subPedido = function(cod,id_pedido,id_pres,precio){
    console.log(cod);
    $('#list-subitems').empty();
    var tipo_pedido = $('#codtipoped').val();
    /*
    if($('#rol_usr').val() == 4){
        disp = 'none';
    }else{
        disp = 'block';
    }
    */
    $.ajax({
        dataType: 'JSON',
        type: 'POST',
        url: $("#url").val()+'venta/subPedido',
        data: {
            tipo_pedido: tipo_pedido, 
            id_pedido: id_pedido, 
            id_pres: id_pres,
            precio: precio
        },
        success: function (data) {
            $.each(data.Detalle, function(i, item) {
                $('.title-subitems').html('Detalle por orden de pedido:<br>'+item.Producto.pro_nom+' <span class="label label-warning text-uppercase">'+item.Producto.pro_pre+'</span>');
                var opc = item.estado;
                switch(opc){
                    case 'a':
                        estado = '<span class="label label-success">PENDIENTE</span>';     
                    break;
                    case 'b':
                        estado = '<span class="label label-warning">EN PREPARACION</span>'
                    break;
                    case 'c':
                        estado = '<span class="label label-info">PREPARADO</span>'
                    break;
                    case 'd':
                        estado = '<span class="label label-primary">ENTREGADO</span>'
                    break;
                    case 'z':
                        estado = '<span class="label label-danger">ANULADO</span>'
                    break;
                    case 'y':
                        estado = '<span class="label label-inverse">ESPERANDO CONFIRMACION</span>'
                    break;
                }

                if(data.estado_pedido == 'a'){
                    switch(opc){
                        case 'a':   
                            boton_anular = 'block';
                        break;
                        case 'b':
                            boton_anular = 'block';
                        break;
                        case 'c':
                            boton_anular = 'block';
                        break;
                        case 'd':
                            boton_anular = 'block';
                        break;
                        case 'z':
                            boton_anular = 'none';
                        break;
                        case 'y':
                            boton_anular = 'block';
                        break;
                    }
                } else if(data.estado_pedido == 'b'){

                    if(data.id_tipo_pedido == 2){
                        switch(opc){
                            case 'a':   
                                boton_anular = 'block';
                            break;
                            case 'b':
                                boton_anular = 'block';
                            break;
                            case 'c':
                                boton_anular = 'block';
                            break;
                            case 'd':
                                boton_anular = 'block';
                            break;
                            case 'z':
                                boton_anular = 'none';
                            break;
                            case 'y':
                                boton_anular = 'block';
                            break;
                        }
                    } else if(data.id_tipo_pedido == 3){
                        switch(opc){
                            case 'a':   
                                boton_anular = 'block';
                            break;
                            case 'b':
                                boton_anular = 'block';
                            break;
                            case 'c':
                                boton_anular = 'block';
                            break;
                            case 'd':
                                boton_anular = 'block';
                            break;
                            case 'z':
                                boton_anular = 'none';
                            break;
                            case 'y':
                                boton_anular = 'block';
                            break;
                        }
                    } 

                } else if(data.estado_pedido == 'c'){
                    boton_anular = 'none';
                } else if(data.estado_pedido == 'd'){
                    boton_anular = 'none';
                }

                if (item.estado != 'z'){
                    //var cantidad = (cod == 1) ? item.cantidad : item.cant;
                    $('#list-subitems')
                    .append(
                        $('<div class="d-flex flex-row comment-row comment-list"/>')
                        .append('<div class="comment-text w-100 p-0 m-b-10n"><span style="display: inline-block;">'
                        +'<h6 class="m-b-5"><i class="ti-calendar"></i> '+moment(item.fecha_pedido).format('DD-MM-Y')+' <i class="ti-time"></i> '+moment(item.fecha_pedido).format('h:mm:ss A')+'</span></h6>'
                        +'<p class="m-b-0 font-13">'+estado+' :: '+item.cant+' Unidad(es)</p></span>'
                        +'<span class="price" style="display: '+boton_anular+'">'
                        +'<button type="button" class="btn btn-xs btn-danger pull-right"'
                        +'onclick="anularPedido('+id_pedido+','+item.id_pres+','+item.cant+',\''+item.Producto.pro_nom+'\',\''+item.Producto.pro_pre+'\',\''+item.fecha_pedido+'\',\''+item.estado+'\')">'
                        +'<i class="fas fa-trash"></i></button></span></div>'));
                } else {
                    $('#list-subitems')
                    .append(
                        $('<div class="d-flex flex-row comment-row comment-list"/>')
                        .append('<div class="comment-text w-100 p-0 m-b-10n"><span style="display: inline-block;">'
                        +'<h6 class="m-b-5"><i class="ti-calendar"></i> '+moment(item.fecha_pedido).format('DD-MM-Y')+' <i class="ti-time"></i> '+moment(item.fecha_pedido).format('h:mm:ss A')+'</span></h6>'
                        +'<p class="m-b-0 font-13">'+estado+' :: '+item.cantidad+' Unidad(es)</p></span>'
                        +'</div>'));
                }
            });
        },
        error: function(jqXHR, textStatus, errorThrown){
            console.log(errorThrown + ' ' + textStatus);
        }   
    });
    $("#modal-sub-pedido").modal('show');
}

/* Cancelar pedido de la lista */
var anularPedido = function(id_pedido,id_pres,cant_ped,prod_nom,prod_pre,fecha_pedido,estado_pedido){
    $("#modal-sub-pedido").modal('hide');
    $('body').css('padding-right','0px'); 
    var html_confirm = '<div>Se anulará el siguiente pedido:<br><label class="text-danger font-bold">'+cant_ped+' UNI</label> '+prod_nom+' <span class="label label-warning">'+prod_pre+'</span></label><br><br>Ingrese código de seguridad</div>\
    <form><input class="form-control text-center w-50" type="password" id="codigo_seguridad" autocomplete="off"/></form><br>\
    <div><span class="text-success" style="font-size: 17px;">¿Está Usted de Acuerdo?</span></div>';
    Swal.fire({
        title: 'Necesitamos de tu Confirmación',
        html: html_confirm,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#34d16e',
        confirmButtonText: 'Si, Adelante!',
        cancelButtonText: "No!",
        showLoaderOnConfirm: true,
        preConfirm: function() {
            return new Promise(function(resolve) {
                $.ajax({
                    url: $("#url").val()+'venta/pedido_delete',
                    type: 'POST',
                    data: {
                        id_pedido : id_pedido,
                        id_pres : id_pres,
                        fecha_pedido : fecha_pedido,
                        estado_pedido: estado_pedido,
                        codigo_seguridad : $("#codigo_seguridad").val()
                    },
                    dataType: 'json'
                })
                .done(function(item){
                    $.each(item['Codigo'], function(i, dato) {
                        //aqui es codigo 1
                        var procesarProductos = async function(item) {
                            // Obtener el correlativo_imp de manera asincrónica
                            var correlativo = await obtenerCorrelativoImp();
                        
                            // Iterar sobre cada producto en 'item["Producto"]'
                            $.each(item['Producto'], async function(i, producto) {
                                var nuevopedido = {
                                    pedido_tipo: $('#codtipoped').val(),
                                    pedido_numero: $('.pedido-numero').text().toUpperCase(),
                                    pedido_cliente: $('.pedido-cliente').text(),
                                    pedido_mozo: $('#nombre_mozo').val(),
                                    correlativo_imp: correlativo, // Usar el correlativo_imp obtenido
                                    nombre_imp: producto.nombre_imp,
                                    nombre_pc: $('#pc_name').val(),
                                    codigo_anulacion: 1,
                                    items: item['Producto']
                                };
                        
                                // Abrir la ventana de impresión de comanda con los datos de nuevopedido si es necesario
                                if ($('#print_com').val() == 1) {
                                    window.open('http://' + $('#pc_ip').val() + '/imprimir/comanda.php?data=' + JSON.stringify(nuevopedido), '_blank');
                                }
                        
                                console.log(nuevopedido); // Mostrar el objeto nuevopedido en la consola
                            });
                        
                            // Redireccionar según la condición 'codpagina'
                            if ($('#codpagina').val() == 1) {
                                window.open($("#url").val() + 'venta', '_self');
                            } else {
                                window.open($("#url").val() + 'venta/orden/' + id_pedido, '_self');
                            }
                        };
                        
                        // Verificar la condición 'dato.cod == 1' antes de procesar productos
                        if (dato.cod == 1) {
                            // Llamar a la función para procesar productos
                            procesarProductos(item);
                        } else if(dato.cod == 0) {
                            Swal.fire({
                                title: 'Proceso No Culminado',
                                text: 'El código ingresado es incorrecto',
                                icon: 'error',
                                confirmButtonColor: '#34d16e',
                                confirmButtonText: "Aceptar"
                            });
                            //aqui es codigo 2
                        } else if(dato.cod == 2) {
                            Swal.fire({
                                title: 'Proceso No Culminado',
                                text: 'El pedido se encuentra en estado de preparación o ya ha sido preparado',
                                icon: 'error',
                                confirmButtonColor: '#34d16e',
                                confirmButtonText: "Aceptar"
                            });
                        } 
                    });     
                })
                .fail(function(){
                    Swal.fire('Oops...', 'Problemas con la conexión a internet!', 'error');
                });
            });
        }             
    });
}

var impresion_ticket = function(id_pedido){
    var print_blank = $('#printVentaRapida').val();
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: $('#url').val()+'venta/listarPedidosTicket',
        data: {
            id_pedido: id_pedido
        },
        success: async function(data) {
            var array = data;
            var contador = [];
            var nuevoarray = [];
            var i, y, z;

            for (i = 0; i < array.length; i++) {
                contador.push(array[i].id_areap);
            }

            var cont = [...new Set(contador)];

            for (y = 0; y < cont.length; y++) {
                nuevoarray = [];
                for (z = 0; z < array.length; z++) {
                    if (array[z].id_areap == cont[y]) {
                        nuevoarray.push(array[z]);
                        nombre_impresora = array[z].nombre_imp;
                    }
                }

                // Obtener el correlativo_imp de manera asincrónica
                var correlativo = await obtenerCorrelativoImp();

                // Construir el objeto nuevopedido con correlativo_imp obtenido
                var nuevopedido = {
                    pedido_tipo: $('#codtipoped').val(),
                    pedido_numero: $('.pedido-numero').text(),
                    pedido_cliente: $('.pedido-cliente').text(),
                    pedido_mozo: $('#nombre_mozo').val(),
                    correlativo_imp: correlativo,
                    nombre_imp: nombre_impresora,
                    nombre_pc: $('#pc_name').val(),
                    codigo_anulacion: 0,
                    items: nuevoarray
                };

                // Abrir la ventana de impresión de comanda si es necesario
                if (print_blank == 1) {
                    window.open('http://' + $('#pc_ip').val() + '/imprimir/comanda.php?data=' + JSON.stringify(nuevopedido), '_blank');
                }

                // Reiniciar nuevoarray para la siguiente iteración
                nuevoarray = [];
            }
        },
        error: function(jqXHR, textStatus, errorThrown){
            console.log(errorThrown + ' ' + textStatus);
        }   
    });
}

var impresion_comanda = function(id_pedido,estado_pedido){
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: $('#url').val()+'venta/listarUpdatePedidos',
        data: {
            id_pedido: id_pedido, 
            estado_pedido: estado_pedido
        },
        success: async function (data) {

            var array = data; //3
            var contador = new Array();
            var nuevoarray = new Array();
            var i,y,z;

            for(i=0; i < array.length; i++){
                contador.push(array[i].id_areap); // selecciona las impresoras asi sean duplicadas
            }

            cont = [...new Set(contador)]; // fiktra impresoras sin repetirse

            for(y=0; y < cont.length; y++){
                for(z=0; z < array.length; z++){
                    if(array[z].id_areap == cont[y]){
                        nuevoarray.push(array[z]);
                        nombre_impresora = array[z].nombre_imp;
                    }
                }

                var correlativo = await obtenerCorrelativoImp();

                var nuevopedido = {
                    pedido_tipo : $('#codtipoped').val(),
                    pedido_numero : $('.pedido-numero').text(),
                    pedido_cliente : $('.pedido-cliente').text(),
                    pedido_mozo : $('#nombre_mozo').val(),
                    correlativo_imp : correlativo,  
                    nombre_imp : nombre_impresora,
                    nombre_pc : $('#pc_name').val(),
                    host_pc : $('#host_pc').val(),
                    codigo_anulacion : 0,
                    items : nuevoarray
                }

                if($('#print_com').val() == 1){
                    window.open('http://'+$('#pc_ip').val()+'/imprimir/comanda.php?data='+JSON.stringify(nuevopedido)+'','_blank');
                }
                var nuevoarray = new Array();

                //console.log(nuevopedido);
            }
        },
        error: function(jqXHR, textStatus, errorThrown){
            console.log(errorThrown + ' ' + textStatus);
        }   
    });
}

var obtenerCorrelativoImp = async function() {
    try {
        const data = await $.ajax({
            type: 'POST',
            dataType: 'json', // Esperamos una respuesta de texto
            url: $('#url').val() + 'venta/contador_comanda'
        });
        return data.trim(); // Devolver el correlativo_imp obtenido y eliminar espacios en blanco
    } catch (error) {
        console.log('Error al obtener el correlativo_imp:', error);
        return ''; // Devolver un valor predeterminado en caso de error
    }
};

$('#tipo_pago').change( function() {
    if($("#tipo_pago").val() == 1 || $("#tipo_pago").val() == 3){
        $("#pago_e").focus();
    }else{
        $("#pago_t").focus();
    }
});

$('.btn-up').on("click", function(){
    var posicion = $('#card1').offset().top;
    $('html,body').animate({
        scrollTop: posicion
    }, 500);
});

$('.btn-down').on("click", function(){
    var posicion = $('#card2').offset().top;
    $('html,body').animate({
        scrollTop: posicion
    }, 500);
});

