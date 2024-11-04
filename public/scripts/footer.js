$(function() {
    feather.replace();
    changeThemeColor();
    contadorSunatSinEnviar();
    contadorPedidosPreparados();
    setInterval(contadorPedidosPreparados, 10000);
    moment.locale('es');
    $('.scroll_pedpre').slimscroll({
        height: 300
    });
    $(".s").addClass("focused");

    var goAtraz = function(event) {
        event.preventDefault();
        window.history.back();
    }

    var goAdelante = function(event) {
        event.preventDefault();
        window.history.forward();
    }

    $('#goAtraz').on('click', goAtraz);
    $('#goAdelante').on('click', goAdelante);
});

var label = function(){
    $(".s").addClass("focused");
}

$(".listar-pedidos-preparados").on("click", function(){
    listarPedidosPreparados();
});

var contadorSunatSinEnviar = function(){
    $.ajax({     
        type: "post",
        dataType: "json",
        url: $("#url").val()+'comprobantes/notificacion',
        success: function (data){
            if(data != null){
                var variable = (data.total > 0) ? data.total : '<i class="ti ti-check"></i>';
                $('.cont-sunat').html(variable);
            }
			
        }
    })
}

var contadorPedidosPreparados = function(){
    $('.t-notify').removeClass('notify');
    $.ajax({     
        type: "post",
        dataType: "json",
        url: $("#url").val()+'venta/contadorPedidosPreparados',
        success: function (data){
            $.each(data, function(i, item) {
                var cantidadPedido = parseInt(item.cantidad);
                if(parseInt(cantidadPedido) > 0){
                    $('.t-notify').addClass('notify');
                    var sound = new buzz.sound("assets/sound/ding_ding", {
                        formats: [ "ogg", "mp3", "aac" ]
                    });
                    sound.play();
                }
            });
        }
    })
}

var listarPedidosPreparados = function(){
    $('.lista-pedidos-preparados').empty();
    $.ajax({
        dataType: 'JSON',
        type: 'POST',
        url: $("#url").val()+'venta/listarPedidosPreparados',
        success: function (item) {
            if (item.data.length != 0) {
                $.each(item.data, function(i, campo) {
                    $('.lista-pedidos-preparados')
                    .append('<a href="javascript:void(0)" onclick="pedidoEntregado('+campo.id_pedido+','+campo.id_pres+',\''+campo.fecha_pedido+'\')">'
                        +'<div class="btn btn-success btn-circle"><i class="ti-check"></i></div> '
                        +'<div class="mail-contnet"><h5>'+campo.cantidad+' '+campo.nombre_prod+' <span class="label label-warning">'+campo.pres_prod+'</span></h5>'
                        +'<span class="mail-desc">'+campo.desc_salon+' - Mesa: '+campo.nro_mesa+'</span> <span class="time">'+moment(campo.fecha_envio).fromNow()+'</span>'
                        +'</div></a>');
                });
            } else {
                $('.lista-pedidos-preparados').html('<div class="col-sm-12 p-t-20 text-center"><h6>No tiene pedidos preparados</h6></div>');
            }
        }
    });
}

var pedidoEntregado = function(id_pedido,id_pres,fecha_pedido){
    $.ajax({
        dataType: 'JSON',
        type: 'POST',
        url: 'venta/pedidoEntregado',
        data: {
            id_pedido: id_pedido,
            id_pres: id_pres,
            fecha_pedido: fecha_pedido
        },
        success: function (data) {
            contadorPedidosPreparados();
            listarPedidosPreparados();
        },
        error: function(jqXHR, textStatus, errorThrown){
            console.log(errorThrown + ' ' + textStatus);
        }   
    });
}

function formatNumber(num) {
    num = Number(num);
    if (!isFinite(num)) return '&#x221e;';
    
    return num.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

//BLOQUEO DE CARACTERES
$(".letMay input").keypress(function(event) {
    var valueKey=String.fromCharCode(event.which);
    var keycode=event.which;
    if(valueKey.search('[A-ZÁÉÍÓÚÑ ]')!=0 && keycode!=8 && keycode!=20){
        return false;
    }
});

$(".letNumMay input").keypress(function(event) {
    var valueKey=String.fromCharCode(event.which);
    var keycode=event.which;
    if(valueKey.search('[0-9,A-ZÁÉÍÓÚÑ ]')!=0 && keycode!=8 && keycode!=20){
        return false;
    }
});

$(".letMin input").keypress(function(event) {
    var valueKey=String.fromCharCode(event.which);
    var keycode=event.which;
    if(valueKey.search('[a-záéíóúñ ]')!=0 && keycode!=8 && keycode!=20){
        return false;
    }
});

$(".letNumMin input").keypress(function(event) {
    var valueKey=String.fromCharCode(event.which);
    var keycode=event.which;
    if(valueKey.search('[0-9,a-záéíóúñ ]')!=0 && keycode!=8 && keycode!=20){
        return false;
    }
});

$(".letMayMin input").keypress(function(event) {
    var valueKey=String.fromCharCode(event.which);
    var keycode=event.which;
    if(valueKey.search('[aA-zZáÁéÉíÍóÓúÚñÑ ]')!=0 && keycode!=8 && keycode!=20){
        return false;
    }
});

$(".letNumMayMin input").keypress(function(event) {
    var valueKey=String.fromCharCode(event.which);
    var keycode=event.which;
    if(valueKey.search('[0-9,aA-zZáÁéÉíÍóÓúÚñÑ/ ]')!=0 && keycode!=8 && keycode!=20){
        return false;
    }
});

$(".letNumMayMin textarea").keypress(function(event) {
    var valueKey=String.fromCharCode(event.which);
    var keycode=event.which;
    if(valueKey.search('[0-9,aA-zZáÁéÉíÍóÓúÚñÑ/ ]')!=0 && keycode!=8 && keycode!=20){
        return false;
    }
});

$(".dec input").keypress(function(event) {
    var valueKey=String.fromCharCode(event.which);
    var keycode=event.which;
    if(valueKey.search('[0-9.]')!=0 && keycode!=8){
        return false;
    }
});

$(".ent input").keypress(function(event) {
    var valueKey=String.fromCharCode(event.which);
    var keycode=event.which;
    if(valueKey.search('[0-9]')!=0 && keycode!=8){
        return false;
    }
});

$(".input-mayus").keyup(function(e) {
    $(this).val($(this).val().toUpperCase());
});

function mayus(e) {
    e.value = e.value.toUpperCase();
}

function mayusPrimera(string){
    return string.charAt(0).toUpperCase() + string.slice(1);
}

function changeThemeColor() {
    var metaThemeColor = document.querySelector("meta[name=theme-color]");
    metaThemeColor.setAttribute("content", "#444");
    setTimeout(function() {
        changeThemeColor();
    }, 3000);
}

var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
};