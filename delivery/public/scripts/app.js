(function(){
    if(!localStorage.getItem("carrito")){
        localStorage.setItem('carrito','[]');
    }
    if(!localStorage.getItem("usuario")){
        localStorage.setItem('usuario','[]');
    }
    function $(selector){
        return document.querySelector(selector);
    }
    function Carrito(){
        this.constructor = function(){
            if(!localStorage.getItem("carrito")){
                localStorage.setItem('carrito','[]');
            }
        }
        this.getCarrito = JSON.parse(localStorage.getItem("carrito"));
        this.agregarItem = function(item,data){
            
            const infoProducto = {
                imagen : data.querySelector('img').src,
                nombre: data.querySelector('.nombre-producto').textContent,
                precio: data.querySelector('.precio-producto').textContent,
                nota: data.querySelector('.nota-producto').value,
                id: item
            }
        
            for (i of this.getCarrito){
                if(i.id === item){
                    i.cantidad++;
                    i.nota = i.nota + ', ' + data.querySelector('.nota-producto').value;
                    localStorage.setItem("carrito",JSON.stringify(this.getCarrito));
                    return;
                }
            }

            infoProducto.cantidad = 1;
            this.getCarrito.push(infoProducto);
            localStorage.setItem("carrito",JSON.stringify(this.getCarrito));
        }
        this.getTotal = function(){
            var total = 0;
            for (i of this.getCarrito) {
                total += parseFloat(i.cantidad) * parseFloat(i.precio);
            }
            return total;
        }
        this.eliminarItem = function(item){
            for (var i in this.getCarrito) {
                if(this.getCarrito[i].id === item){
                    this.getCarrito.splice(i,1);
                }
            }
            localStorage.setItem("carrito",JSON.stringify(this.getCarrito));
        }
        this.addItem = function(item){
            for (i of this.getCarrito){
                if(i.id === item){
                    i.cantidad++;
                    localStorage.setItem("carrito",JSON.stringify(this.getCarrito));
                    return;
                }
            }
        }
        this.minusItem = function(item){
            for (i of this.getCarrito){
                if(i.id === item){
                    if(i.cantidad > 1){
                        i.cantidad = i.cantidad - 1;
                        localStorage.setItem("carrito",JSON.stringify(this.getCarrito));
                        return;
                    }
                    return;
                }
            }
        }
        this.editItem = function(item){
            for (i of this.getCarrito){
                if(i.id === item){
                    i.nota = document.querySelector('.nota-producto-edit').value;
                    localStorage.setItem("carrito",JSON.stringify(this.getCarrito));
                    return;
                }
            }
        }
    }
    function Carrito_View(){
        this.showModal = function(){
            this.renderCarrito();
        }
        this.renderCarrito = function(){
            if(carrito.getCarrito.length <= 0){
                $(".cart-table").innerHTML = "";
                document.querySelector('.cart-empty').style.display = 'block';
                document.querySelector('.cart-summary').style.display = 'none';
            }else{
                $(".cart-table").innerHTML = "";
                var template = ``
                for(i of carrito.getCarrito){
                    var precio = (i.cantidad * i.precio).toFixed(2);
                    var moneda = document.querySelector('#moneda').value;
                   //var nombre = (i.nombre).substr(0,1).toUpperCase()+(i.nombre).substr(1).toLowerCase();
                    template += `
                    <tr>
                        <td class="text-center">
                            <a href="#" id="addProducto" data-producto="${i.id}"><i class="ti-angle-up"></i></a>
                            <p class="item-amount mb-1">${i.cantidad}</p>
                            <a href="#" id="minusProducto" data-producto="${i.id}"><i class="ti-angle-down"></i></a>
                        </td>
                        <td class="title">                            
                            <span class="name">${i.nombre}</span>
                            <span class="caption text-muted">${moneda}${i.precio} Uni | <a href="#" class="action-icon" id="deleteProducto" data-producto="${i.id}"><i class="ti ti-trash"></i></a></span>
                        </td>
                        <td class="price">${precio}</td>
                        <td class="actions">
                            <a href="#editProductModal" data-toggle="modal" class="action-icon" id="editProducto" data-producto="${i.id}"><i class="ti ti-pencil"></i></a
                        </td>
                    </tr>
                    `;
                }
                $(".cart-table").innerHTML = template;
                document.querySelector('.cart-empty').style.display = 'none';
                document.querySelector('.cart-summary').style.display = 'block';
            }
            $(".totalCarrito > strong").innerHTML = document.querySelector('#moneda').value+' '+(carrito.getTotal()).toFixed(2);
        }
        this.totalProductos = function(){
            //var total = carrito.getCarrito.length;
            var cantidad = 0;
            for (i of carrito.getCarrito) {
                cantidad += parseFloat(i.cantidad);
            }
            $(".not1").innerHTML = cantidad;
            $(".not2").innerHTML = cantidad;
            $(".cart-total").innerHTML = document.querySelector('#moneda').value+' '+(carrito.getTotal()).toFixed(2);
        }
    }

    var carrito = new Carrito();
    var carrito_view = new Carrito_View();

    document.addEventListener('DOMContentLoaded',function(){
        carrito.constructor();
        carrito_view.showModal();
        carrito_view.totalProductos();
    });

    if(document.querySelector('#pagina').value == 2){
        $("#content-producto").addEventListener("click",function(ev){
            ev.preventDefault();
            if(screen.width > 767){
                var width = 'auto';
                var position = 'top-end';
            } else if (screen.width < 768){
                var width = '2000px';
                var position = 'bottom';
            }
            if(ev.target.id === "addItem" || ev.target.parentElement.id === "addItem"){
                var info = ev.target.parentElement.parentElement.parentElement;
                var id = replaceUndefined(ev.target.dataset.producto)+''+replaceUndefined(ev.target.parentElement.dataset.producto);
                carrito.agregarItem(id,info);
                const Toast = Swal.mixin({
                    toast: true,
                    position: position,
                    width: width,
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true,
                    onOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });
                Toast.fire({
                    icon: 'success',
                    title: 'Producto agregado'
                });
            }
            carrito_view.showModal();
            carrito_view.totalProductos();
        });

        $("#catalogo").addEventListener("click",function(ev){
            ev.preventDefault();
            if(ev.target.id === "dataItem"){
                var info = ev.target.parentElement.parentElement.parentElement.parentElement.parentElement;
                var id = ev.target.dataset.item;
                document.querySelector('#addItem').setAttribute('data-producto', id);
                document.querySelector('#bg-image').setAttribute('style', 'background-image: url("'+info.querySelector('img').src+'");');
                document.querySelector('#imagen-producto').setAttribute('src', info.querySelector('img').src);
                $(".nombre-producto").innerHTML = info.querySelector('h6').textContent;
                $(".descripcion-producto").innerHTML = info.querySelector('span').textContent;
                $(".precio-producto").innerHTML = info.querySelector('.precio').textContent;
                document.querySelector('.nota-producto').value = '';
            }
        });
    }

    $(".cart-table").addEventListener("click",function(ev){
        //console.log(ev.target.parentElement.dataset.producto);
        ev.preventDefault();
        if(ev.target.parentElement.id === "deleteProducto"){            
            console.log('delete');
            carrito.eliminarItem(ev.target.parentElement.dataset.producto);
            carrito_view.showModal();
            carrito_view.totalProductos();
        }
        else if(ev.target.parentElement.id === "addProducto"){
            console.log('add');
            carrito.addItem(ev.target.parentElement.dataset.producto);
            carrito_view.showModal();
            carrito_view.totalProductos();
        }
        else if(ev.target.parentElement.id === "minusProducto"){
            console.log('minus');
            carrito.minusItem(ev.target.parentElement.dataset.producto);
            carrito_view.showModal();
            carrito_view.totalProductos();
        }
        else if(ev.target.parentElement.id === "editProducto"){
            var id = ev.target.parentElement.dataset.producto;
            //console.log(id);
            var data = carrito.getCarrito;
            for (i of data){
                if(i.id === id){
                    document.querySelector('#editItem').setAttribute('data-producto', id);
                    document.querySelector('#bg-image-edit').setAttribute('style', 'background-image: url("'+i.imagen+'");');
                    document.querySelector('#imagen-producto-edit').setAttribute('src', i.imagen);
                    $(".nombre-producto-edit").innerHTML = i.nombre;
                    document.querySelector('.nota-producto-edit').value = i.nota;
                }
            }
        }
    });

    $("#content-producto-edit").addEventListener("click",function(ev){
        ev.preventDefault();
        if(ev.target.id === "editItem" || ev.target.parentElement.id === "editItem"){
            var id = replaceUndefined(ev.target.dataset.producto)+''+replaceUndefined(ev.target.parentElement.dataset.producto);
            carrito.editItem(id);
        }
    });

    $(".btn-checkout").addEventListener("click",function(ev){
        ev.preventDefault();
        if(carrito.getTotal() > 0){
            window.open(document.querySelector('#url').value+'checkout', '_self');
            //alert(document.querySelector('#url').value);
        } else {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
                onOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            Toast.fire({
                icon: 'warning',
                title: 'Tu bolsa de compras está vacía'
            });
        }
    });

    if(document.querySelector('#pagina').value == 3){
        document.querySelector('.module-cart-1').style.display = 'none';
        document.querySelector('.module-cart-2').style.display = 'none';
    }

})();

function replaceUndefined(valor){
    if(typeof(valor) === "undefined"){
        return ""; // return 0 as replace, and end function execution
    } 
    return valor; // the above state was false, functions continues and return original value
};