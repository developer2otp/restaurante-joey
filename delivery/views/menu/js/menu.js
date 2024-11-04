$(function() {
    $("#sucursal option[value='" + $('#nombre_local').val() + "']").prop("selected", true);
});

var listarProductos = function(id_catg) {
    var menuContent = $('#menuContenttt' + id_catg).empty();

    $.ajax({
        dataType: 'JSON',
        type: 'POST',
        url: $('#url').val() + 'menu/listarProductos',
        data: {
            id_catg: id_catg
        },
        success: function(data) {
            $.each(data, function(i, item) {
                var boton;

                if (item.est_c == 'a') {
                    boton = '<div class="col-sm-5 col-5 text-right mt-2 mt-sm-0"><button class="btn btn-outline-success btn-sm" id="dataItem" data-item="' + item.id_pres + '" data-target="#productModal" data-toggle="modal"><span id="dataItem" data-item="' + item.id_pres + '">Agregar</span></button></div>';
                } else {
                    boton = '<div class="col-sm-5 col-5 text-right mt-2 mt-sm-0"><span class="badge badge-danger font-12">AGOTADO</span></div>';
                }

                var pro_nom = (item.pro_nom.charAt(0).toUpperCase() + item.pro_nom.slice(1).toLowerCase());
                var pro_pre = (item.pro_pre.charAt(0).toUpperCase() + item.pro_pre.slice(1).toLowerCase());

                menuContent.append(
                    $('<div class="col-md-4 col-6"/>').append(
                        $('<div class="card m-b-15" style="background: #fff; border: 1px solid #ececec;"/>').html(
                            '<div class="card-image">' +
                            '<img src="' + $("#url2").val() + 'public/images/productos/' + item.pro_img + '" alt="">' +
                            '</div>' +
                            '<div class="card-body">' +
                            '<h6 class="mb-0">' + pro_nom + ' | ' + pro_pre + '</h6>' +
                            '<span class="text-muted text-sm">' + item.pro_des + '</span>' +
                            '<div class="row align-items-center mt-4">' +
                            '<div class="col-sm-7 col-12"><span class="text-md mr-4 font-20">' + $('#moneda').val() + ' <span data-product-base-price class="precio">' + item.pro_cos + '</span></span></div>' +
                            boton +
                            '</div>' +
                            '</div>'
                        )
                    )
                );
            });
        }
    });
};