<input type="hidden" id="pagina" value="2"/>
<input type="hidden" id="nombre_local" value="<?php echo NAME_NEGOCIO; ?>"/>

<!-- Page Title -->
<div class="page-title bg-light">
    <div class="bg-image bg-parallax"><img src="<?php echo URL_DEL; ?>public/img/screens/bg-desk.jpg" alt=""></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 push-lg-4">
                <h1 class="mb-0 text-white">Nuestra carta</h1>
                <h4 class="text-white mb-0">Lo mejor de nuestros platos en tus manos</h4>
            </div>
        </div>
    </div>
</div>

<!-- Page Content -->
<div class="page-content bg-light">
    <div class="container">
        <div class="row no-gutters">
            <div class="col-md-3">
                <!-- Menu Navigation -->
                <nav id="menu-navigation" class="stick-to-content card-categoria" data-local-scroll>
                    <ul class="nav nav-menu bg-dark dark">
                        <?php foreach($this->listarCategorias as $key => $data): ?>
                        <li><a href="#<?php echo str_replace(" ", "",strtolower($data['descripcion'])); ?>"><?php echo $data['descripcion']; ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </nav>
            </div>

            <div class="col-md-9" role="tablist" id="catalogo">
                <!-- Menu Category / Burgers -->
                <?php foreach($this->listarCategorias as $key => $data): ?>
                <div id="<?php echo str_replace(" ", "",strtolower($data['descripcion'])); ?>" class="menu-category">
                    <div class="menu-category-title collapse-toggle" role="tab" data-target="#menuContentt<?php echo $data['id_catg']; ?>" data-toggle="collapse" aria-expanded="false" onclick="listarProductos(<?php echo $data['id_catg']; ?>);">
                        <div class="bg-image"><img src="<?php echo URL; ?>public/images/productos/<?php echo $data['imagen']; ?> "alt=""></div>
                        <h2 class="title"><?php echo ucwords(strtolower($data['descripcion'])); ?></h2>
                    </div>

                    <div class="menu-category-content m-t-15 b-0 collapse" id="menuContentt<?php echo $data['id_catg']; ?>">
                        <!-- Menu Item -->
                        <div class="p-0">
                            <div class="row gutters-sm bg-light" id="menuContenttt<?php echo $data['id_catg']; ?>">
                            </div>
                        </div>
                    </div>

                </div>

                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal / Product -->
<div class="modal fade" id="productModal" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="content-producto">
            <div class="modal-header modal-header-lg dark bg-dark">
                <div class="bg-image" id="bg-image"><img id="imagen-producto" src="" alt=""></div>
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="ti-close"></i></button>
            </div>
            <div class="modal-product-details">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h6 class="mb-0 nombre-producto"></h6>
                        <span class="text-muted descripcion-producto"></span>
                    </div>
                    <div class="col-4 text-lg text-right"><?php echo Session::get('moneda'); ?> <span class="precio-producto"></span></div>
                </div>
            </div>

            <div class="modal-body panel-details-container">
                <!-- Panel Details / Other -->
                <div class="panel-details">
                    <h6 class="panel-details-title pt-0">
                        <label class="mb-2"><?php echo DESCRIP_NOTA; ?></label>
                    </h6>
                    <div id="panelDetailsOther">
                        <textarea cols="30" rows="6" class="form-control nota-producto" placeholder="Ingrese aquí"></textarea>
                    </div>
                </div>
            </div>
            <button type="button" class="modal-btn btn btn-secondary btn-block btn-lg" data-dismiss="modal" id="addItem" data-producto=""><span>Agregar</span></button>
        </div>
    </div>
</div>