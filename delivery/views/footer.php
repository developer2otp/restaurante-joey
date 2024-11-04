<!-- Footer -->
<footer id="footer" class="bg-dark dark">
    <div class="container">
        <!-- Footer 1st Row -->
        <div class="footer-first-row row">
            <div class="col-lg-3 text-center">
                <a href="index.html"><img src="<?php echo URL_DEL; ?>public/img/logo.png" alt="" width="150" class="mt-5 mb-5"></a>
            </div>

            <div class="col-lg-6 col-md-6">
                <h5 class="text-muted">Contactenos!</h5>
                <ul class="list-posts">
                    <li>
                        <span class="title direccion-empresa"></span>
                        <span class="date ">Dirección</span>
                    </li>
                    <li>
                        <span class="title telefono-empresa"></span>
                        <span class="date">Teléfonos</span>
                    </li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6">
                <h5 class="text-muted mb-3">Social Media</h5>

                <a href="<?php echo URL_FB; ?>" target="_blank" class="icon icon-social icon-circle icon-sm icon-facebook"><i class="fa fa-facebook"></i></a>


                <a href="<?php echo URL_INS; ?>" class="icon icon-social icon-circle icon-sm icon-instagram"><i class="fa fa-instagram"></i></a>
  
            </div>
        </div>

        <!-- Footer 2nd Row -->
        <div class="footer-second-row">
            <span class="text-muted">Desarrollado por <a href="#" target="_blank"><span class="text-danger"><?php echo NOMBRE_SOFT; ?></span></a></span>
        </div>
    </div>
    <!-- Back To Top -->
    <button id="back-to-top" class="back-to-top"><i class="ti ti-angle-up"></i></button>
</footer>

<!-- Footer / End -->

</div>
<!-- Content / End -->

    <!-- Panel Cart -->
    <div id="panel-cart">
        <div class="panel-cart-container">
            <div class="panel-cart-title">
                <h5 class="title">Bolsa de compras</h5>
                <button class="close" data-toggle="panel-cart"><i class="ti ti-close"></i></button>
            </div>

            <div class="panel-cart-content">
                <table class="cart-table"></table>
                <div class="cart-summary">
                    <div class="row text-lg">
                        <div class="col-7 text-right text-muted">Total:</div>
                        <div class="col-5 totalCarrito"><strong></strong></div>
                    </div>
                </div>
                <div class="cart-empty">
                    <i class="ti ti-bag"></i>
                    <p class="mb-0">Tu bolsa de compras est&aacute; vac&iacute;a</p>
                    <p>Agrega productos ahora</p>
                </div>
            </div>
        </div>
        <a href="#" class="panel-cart-action btn btn-secondary btn-block btn-lg btn-checkout"><span>CONTINUAR</span></a>
    </div>



    <!-- Panel Mobile -->
    <nav id="panel-mobile">
        <div class="module module-logo bg-dark dark">
            <a href="#">
                <img src="<?php echo URL_DEL; ?>public/img/logo.png" alt="" style="height: 100px !important;">
            </a>
            <button class="close" data-toggle="panel-mobile"><i class="ti ti-close"></i></button>
        </div>
        <nav class="module module-navigation"></nav>
        <div class="module module-social">
            <h6 class="text-sm mb-3">S&iacute;guenos!</h6>

            <a href="<?php echo URL_FB; ?>" target="_blank" class="icon icon-social icon-circle icon-sm icon-facebook"><i class="fa fa-facebook"></i></a>

            <a href="<?php echo URL_INS; ?>" class="icon icon-social icon-circle icon-sm icon-instagram"><i class="fa fa-instagram"></i></a>

        </div>
    </nav>

    <!-- Modal / Demo -->
    <div class="modal fade" id="modal-user" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Identificaci&oacute;n</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="ti ti-close"></i></button>
                </div>
                <div class="modal-body">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal"><span>Cancelar</span></button>
                    <button type="button" class="btn btn-primary"><span>Aceptar</span></button>
                </div>
            </div>
        </div>
    </div>

    <!-- Body Overlay -->
    <div id="body-overlay"></div>

    <!-- Modal / Product -->
    <div class="modal fade" id="editProductModal" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content" id="content-producto-edit">
                <div class="modal-header modal-header-lg dark bg-dark">
                    <div class="bg-image" id="bg-image-edit"><img id="imagen-producto-edit" src="" alt=""></div>
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="ti-close"></i></button>
                </div>

                <div class="modal-product-details">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <h6 class="mb-0 nombre-producto-edit"></h6>
                            <span class="text-muted descripcion-producto"></span>
                        </div>
                    </div>
                </div>

                <div class="modal-body panel-details-container">
                    <!-- Panel Details / Other -->
                    <div class="panel-details">
                        <h6 class="panel-details-title pt-0">
                            <label class="mb-2">Agregue una nota</label>
                        </h6>
                        <div id="panelDetailsOther">
                            <textarea cols="30" rows="6" class="form-control nota-producto-edit" placeholder="Ingrese una nota o referencia para tu pedido"></textarea>
                        </div>
                    </div>
                </div>
                <button type="button" class="modal-btn btn btn-secondary btn-block btn-lg" data-dismiss="modal" id="editItem" data-producto=""><span>Actualizar</span></button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap tether Core Css -->
<?php
    if (isset($this->css)){
        foreach ($this->css as $css)
            echo '<link rel="stylesheet" href="'.URL_DEL. 'views/' .$css.'"></link>';
    }
?>

<!-- Bootstrap tether Core JavaScript -->
<?php
    if (isset($this->js)){
        foreach ($this->js as $js)
            echo '<script type="text/javascript" src="'.URL_DEL. 'views/' .$js.'"></script>';
    }
?>

<!-- JS Plugins -->
<script src="<?php echo URL_DEL; ?>public/plugins/tether/dist/js/tether.min.js"></script>
<script src="<?php echo URL_DEL; ?>public/plugins/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?php echo URL_DEL; ?>public/plugins/slick-carousel/slick/slick.min.js"></script>
<script src="<?php echo URL_DEL; ?>public/plugins/jquery.appear/jquery.appear.js"></script>
<script src="<?php echo URL_DEL; ?>public/plugins/jquery.scrollto/jquery.scrollTo.min.js"></script>
<script src="<?php echo URL_DEL; ?>public/plugins/jquery.localscroll/jquery.localScroll.min.js"></script>
<script src="<?php echo URL_DEL; ?>public/plugins/jquery.mb.ytplayer/dist/jquery.mb.YTPlayer.min.js"></script>
<script src="<?php echo URL_DEL; ?>public/plugins/twitter-fetcher/js/twitterFetcher_min.js"></script>
<script src="<?php echo URL_DEL; ?>public/plugins/skrollr/dist/skrollr.min.js"></script>
<script src="<?php echo URL_DEL; ?>public/plugins/animsition/dist/js/animsition.min.js"></script>
<script src="<?php echo URL_DEL; ?>public/plugins/datatables/js/jquery.dataTables.min.js"></script>
<script src="<?php echo URL_DEL; ?>public/plugins/moment/moment.js"></script>
<script src="<?php echo URL_DEL; ?>public/plugins/moment/moment-with-locales.js"></script>

<!-- This is formvalidation -->
<script src="<?php echo URL_DEL; ?>public/plugins/formvalidation/formValidation.min.js"></script>
<script src="<?php echo URL_DEL; ?>public/plugins/formvalidation/framework/bootstrap.min.js"></script>

<!-- Sweet-Alert  -->
<script src="<?php echo URL_DEL; ?>public/plugins/sweetalert/sweetalert.min.js"></script>

<!-- JS Core -->
<script src="<?php echo URL_DEL; ?>public/js/core.js"></script>

<!-- JS Stylewsitcher -->
<script src="<?php echo URL_DEL; ?>public/styleswitcher/styleswitcher.js"></script>

<!--Personal JavaScript -->
<script src="<?php echo URL_DEL; ?>public/scripts/all.js?v=<?php echo(rand()); ?>"></script>
<script src="<?php echo URL_DEL; ?>public/scripts/app.js?v=<?php echo(rand()); ?>"></script>

</body>
</html>