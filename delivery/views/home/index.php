<input type="hidden" id="pagina" value="1"/>

<!-- Section - Main -->
<section class="section section-main section-main-4 bg-extra-dark mb-0">
    <!-- Content -->
    <div class="section-main-content container">
        <div class="row">
            <div class="col-md-6">
                <h1 class="display-1 text-white">La mejor comida de la ciudad.</h1>
                <h4 class="mb-5 text-muted">¡Pruébelo ahora con nuestro pedido en línea!</h4>
                <a href="<?php echo URL_DEL; ?>menu" class="btn btn-outline-primary btn-lg animated" data-animation="fadeInUp" data-animation-delay="400"><span class="text-white">Ordenar ahora</span></a>
            </div>
        </div>
    </div>

    <!-- Image -->
    <div class="section-main-image">
        <div class="bg-image"><img src="<?php echo URL_DEL; ?>public/img/posts/bg-portada-1.png" alt=""></div>
    </div>
</section>
<!-- Section - Main -->

<!-- Section - About -->
<section class="section section-bg-edge bg-dark dark">
    <div class="image right col-md-6 push-md-6" style="opacity: 0.5;">
        <div class="bg-image"><img src="<?php echo URL_DEL; ?>public/img/posts/bg-portada-2.png" alt=""></div>
    </div>

    <div class="container">
        <div class="col-lg-5 col-md-9">
            <div class="rate mb-5 rate-lg"><i class="fa fa-star active"></i><i class="fa fa-star active"></i><i class="fa fa-star active"></i><i class="fa fa-star active"></i><i class="fa fa-star active"></i></div>
            <h1 class="display-2">Porque nuestros platos?</h1>

            <!-- Feature -->
            <div class="feature feature-1">
                <div class="feature-icon icon icon-primary"><i class="ti-heart"></i></div>
                <div class="feature-content">
                    <h4 class="mb-2">Sabor perfecto</h4>
                    <p class="text-muted mb-0">Lo mejor de nuestras recetas para el gusto de tu paladar.</p>
                </div>
            </div>

            <!-- Feature -->
            <div class="feature feature-1">
                <div class="feature-icon icon icon-primary"><i class="ti ti-desktop"></i></div>
                <div class="feature-content">
                    <h4 class="mb-2">Pedido en l&iacute;nea</h4>
                    <p class="text-muted mb-0">Una manera r&aacute;pida y sencilla.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section - Steps -->
<section class="section bg-extra-dark dark">

    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <!-- Step -->
                <div class="feature feature-1">
                    <div class="feature-icon icon icon-primary"><i class="ti ti-shopping-cart"></i></div>
                    <div class="feature-content">
                        <h4 class="mb-2">Elige un plato</h4>
                        <p class="text-muted mb-0">De tu preferencia.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <!-- Step -->
                <div class="feature feature-1">
                    <div class="feature-icon icon icon-primary"><i class="ti ti-wallet"></i></div>
                    <div class="feature-content">
                        <h4 class="mb-2">Realizar un pago</h4>
                        <p class="text-muted mb-0">Efectivo, tarjeta o en l&iacute;nea.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <!-- Step -->
                <div class="feature feature-1">
                    <div class="feature-icon icon icon-primary"><i class="ti ti-package"></i></div>
                    <div class="feature-content">
                        <h4 class="mb-2">Recibe tu comida!</h4>
                        <p class="text-muted mb-3">Desde la comodidad de tu casa.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section - Menu -->
<section class="section pb-0 pt-0 protrude">
    <div class="menu-sample-carousel carousel inner-controls category-list" data-slick='{
        "dots": true,
        "slidesToShow": 3,
        "slidesToScroll": 1,
        "infinite": true,
        "responsive": [
            {
                "breakpoint": 991,
                "settings": {
                    "slidesToShow": 2,
                    "slidesToScroll": 1
                }
            },
            {
                "breakpoint": 690,
                "settings": {
                    "slidesToShow": 1,
                    "slidesToScroll": 1
                }
            }
        ]
    }'>
        <!-- Menu Sample -->
    </div>
</section>

<!-- Modal / COVID -->
<?php if(MODAL_COVID_DELIVERY === true) { ?>
<div class="modal fade" id="covid-modal" role="dialog" data-timeout="1000" data-set-cookie="covid-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header modal-header-lg dark bg-dark">
                <div class="bg-image"><img src="<?php echo URL_DEL; ?>public/img/gallery/modal-covid.jpg" alt=""></div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="ti ti-close"></i></button>
            </div>

            <div class="modal-body">
                <h3>Stop! COVID-19</h3>
                <p>La vida te ha retado a una dura batalla, pero no te preocupes. <br><span class="font-bold">¡TÚ puedes vencerla!</span></p>
                <p>No decaigas, todos debemos mantenernos en la lucha para vencer al virus. <br><span class="font-bold">¡Unidos lo venceremos!</span></p>
                <button class="btn btn-secondary" data-dismiss="modal"><span>S&iacute;, se puede!</span></button>
            </div>
        </div>
    </div>
</div>
<?php } ?>