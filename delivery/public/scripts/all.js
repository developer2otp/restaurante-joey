$(function() {
    // document.oncontextmenu=function(){return!1},document.onselectstart=function(){return"text"!=event.srcElement.type&&"textarea"!=event.srcElement.type&&"password"!=event.srcElement.type?!1:!0},window.sidebar&&(document.onmousedown=function(e){var t=e.target;return"SELECT"==t.tagName.toUpperCase()||"INPUT"==t.tagName.toUpperCase()||"TEXTAREA"==t.tagName.toUpperCase()||"PASSWORD"==t.tagName.toUpperCase()?!0:!1}),document.ondragstart=function(){return!1};
    // $(document).keydown(function(e){return 123!=e.keyCode&&((!e.ctrlKey||!e.shiftKey||73!=e.keyCode)&&void 0)});
    moment.locale('es');
    defaultdata();
});

var defaultdata = function(){
    $.ajax({
        async: false,
        dataType: 'JSON',
        type: 'POST',
        url: $('#url').val()+'home/defaultdata',
        success: function (data) {
            $('.direccion-empresa').text(data.direccion_comercial);
            $('.telefono-empresa').text(data.celular);
        }
    });
};


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

function formatNumber(num) {
    if (!num || num == 'NaN') return '0.00';
    if (num == 'Infinity') return '&#x221e;';
    num = num.toString().replace(/\$|\,/g, '');
    if (isNaN(num))
        num = "0";
    sign = (num == (num = Math.abs(num)));
    num = Math.floor(num * 100 + 0.50000000001);
    cents = num % 100;
    num = Math.floor(num / 100).toString();
    if (cents < 10)
        cents = "0" + cents;
    for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3) ; i++)
        num = num.substring(0, num.length - (4 * i + 3)) + ',' + num.substring(num.length - (4 * i + 3));
    return (((sign) ? '' : '-') + num + '.' + cents);
}