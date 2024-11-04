$(document).ready(function() {
    var urlValue = $('#url').val();
    var url2Value = $('#url2').val();
    var categoryList = $('.category-list');

    listarCategorias(urlValue, url2Value, categoryList);
});

function listarCategorias(urlValue, url2Value, categoryList) {
    categoryList.empty();

    $.ajax({
        dataType: 'JSON',
        type: 'POST',
        url: urlValue + 'home/listarCategorias',
        success: function (data) {
            var categories = data.map(function(item) {
                var categoryDescription = (item.descripcion).substr(0,1).toUpperCase() + (item.descripcion).substr(1).toLowerCase();
                var categoryLink = urlValue + 'menu#' + categoryDescription.replace(/ /g, "").toLowerCase();

                return $('<div class="menu-sample"/>').html(
                    '<a href="' + categoryLink + '">'
                    + '<img src="' + url2Value + 'public/images/productos/' + item.imagen + '" alt="" class="image" style="height:400px; opacity: 0.5;">'
                    + '<h6 class="title">' + categoryDescription + '<br><span class="badge badge-success font-16">PÍDELO YA</span></h6>'
                    + '</a>'
                );
            });

            categoryList.append(categories);
        }
    });
}