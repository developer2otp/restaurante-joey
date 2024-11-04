<!-- Incluyendo Culqi Checkout -->
<script type="text/javascript" src="https://checkout.culqi.com/js/v3"></script>
<input type="hidden" id="pagina" value="3"/>
<!-- Page Title -->
<div class="page-title bg-dark dark">
    <!-- BG Image -->
    <div class="bg-image bg-parallax"><img src="<?php echo URL; ?>public/img/screens/bg-review.jpg" alt=""></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 push-lg-4">
                <h1 class="mb-0">Checkout</h1>
            </div>
        </div>
    </div>
</div>

<div class="alert alert-warning mb-0" role="alert">
    <span class="font-bold"><i class="ti ti-info-alt"></i> Nuestro Delivery Web atiende de <?php echo horario_atencion; ?></span> Mientras tanto, puedes escoger lo que deseas ordenar hoy y guardarlo en tu bolsa de compras.
</div>

<!-- Section -->
<section class="section bg-light section-resumen">

    <div class="container">
        <div class="row">
            <div class="col-xl-5 push-xl-7 col-lg-5 push-lg-7">
                <div class="shadow bg-white stick-to-content mb-4">
                    <div class="bg-dark dark p-4"><h5 class="mb-0">Resumen de tu orden</h5></div>
                    <table class="cart-table"></table>
                    <div class="cart-summary">
                        <div class="row text-lg">
                            <div class="col-7 text-right text-muted">Total:</div>
                            <div class="col-5 totalCarrito"><strong class="yarita"></strong></div>
                        </div>
                    </div>
                    <div class="cart-empty">
                        <i class="ti ti-bag"></i>
                        <p class="mb-0">Tu bolsa de compras est&aacute; vac&iacute;a</p>
                        <p>Agrega productos ahora</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-7 pull-xl-5 col-lg-7 pull-lg-5">
                <div class="bg-white display-login p-4 p-md-5 mb-4">
                    <form id="form-login" role="form" method="post">
                        <h4 class="border-bottom pb-4"><i class="ti ti-user mr-3 text-primary"></i>Identificaci&oacute;n</h4>
                        <div class="row">
                            <div class="form-group col-sm-6 ent">
                                <label>N&uacute;mero de celular</label>
                                <input type="text" class="form-control" name="userlogin" id="userlogin" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="form-group col-sm-6">
                                <button type="submit" class="btn btn-success btn-md btn-block"><span>Continuar</span></button>
                            </div>
                        </div>
                    </form>
                    <div class="row mb-2">
                        <div class="form-group col-sm-6">
                            <span>Aún no eres cliente?<br>Pues tranquilo. <span class="text-success"><a href="#" class="user-new">¡Continua aqui!</a></span></span>
                        </div>
                    </div>
                </div>
                <form id="form-pedido" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id_cliente" id="id_cliente"/>
                <div class="bg-white display-informacion p-4 p-md-5 mb-4">
                    <div class="mt-2 mb-5 display-bienvenido">
                        <h4 class="mb-2">Hola <span class="user-nombre"></span>!</h4>
                        <h6 class="mb-3">Ya est&aacute;s a un solo paso de ordenar tu pedido.</h6>
                        <span class="font-10">Si deseas continuar con otro usuario <code class="user-refresh" style="cursor: pointer;">¡Hazlo aqu&iacute;!</code></span>
                    </div>
                    <h4 class="border-bottom pb-4"><i class="ti ti-package mr-3 text-primary"></i>Elige tu opci&oacute;n</h4>
                    <div class="row text-lg">
                        <div class="col-md-6 col-sm-6 col-6 form-group">
                            <img src="<?php echo URL ?>public/img/gallery/moto.png" width="100"/>
                            <label class="custom-control custom-radio">
                                <input type="radio" name="tipo_entrega" value="1" class="custom-control-input" checked="checked">
                                <span class="custom-control-indicator"></span>
                                <span class="custom-control-description">Despacho a domicilio</span>
                            </label>
                        </div>
                        <div class="col-md-6 col-sm-6 col-6 form-group">
                            <img src="<?php echo URL ?>public/img/gallery/tienda.png" width="100"/>
                            <label class="custom-control custom-radio">
                                <input type="radio" name="tipo_entrega" value="2" class="custom-control-input">
                                <span class="custom-control-indicator"></span>
                                <span class="custom-control-description">Recoger en tienda</span>
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12 ent">
                            <label>Tel&eacute;fono</label>
                            <input type="text" name="telefono_cliente" id="telefono_cliente" class="form-control" minlength="9" maxlength="9" autocomplete="off" required>
                        </div>
                        <div class="form-group col-sm-12">
                            <label class="display-nombre">Nombre</label>
                            <input type="text" name="nombre_cliente" id="nombre_cliente" class="form-control" required>
                        </div>
                        <div class="form-group col-sm-12 display-despacho">
                            <label>Direcci&oacute;n</label>
                            <input type="text" name="direccion_cliente" id="direccion_cliente" class="form-control" placeholder="Ejm: Av. 28 de Julio #322 Chimbote" required>
                        </div>
                        <div class="form-group col-sm-12 display-despacho">
                            <label>Referencia</label>
                            <input type="text" name="referencia_cliente" id="referencia_cliente" class="form-control" placeholder="Ejm: Casa de 2 pisos color verde frente a bodega" required>
                        </div>
                    </div>
                    <div class="content-despacho-casa" style="display: none;">
                        <div class="alert alert-info" role="alert">
                            <span class="font-bold"><i class="ti ti-direction"></i> <span class="direccion-empresa"></span></span><br>
                            <i class="ti ti-user"></i> El personal del restaurante se comunicar&aacute; contigo, una vez reciba tu pedido.
                        </div>
                    </div>

                    <h4 class="border-bottom mt-5 pb-4">
                        <i class="ti ti-timer mr-3 text-primary"></i>Tiempo de despacho
                    </h4>
                    <div class="row mb-5">
                        <div class="form-group col-sm-6">
                            <div class="select-container">
                                <select class="form-control" name="hora_entrega" id="hora_entrega">
                                    <option value="2">Tan r&aacute;pido como sea posible</option>
                                    <optgroup>
                                        <option value="10:00:00">10:00 AM</option>
                                        <option value="10:30:00">10:30 AM</option>
                                        <option value="11:00:00">11:00 AM</option>
                                        <option value="11:30:00">11:30 AM</option>
                                        <option value="12:00:00">12:00 AM</option>
                                        <option value="12:30:00">12:30 AM</option>
                                        <option value="13:00:00">01:00 PM</option>
                                        <option value="13:30:00">01:30 PM</option>
                                        <option value="14:00:00">02:00 PM</option>
                                        <option value="14:30:00">02:30 PM</option>
                                        <option value="15:00:00">03:00 PM</option>
                                        <option value="15:30:00">03:30 PM</option>
                                        <option value="16:00:00">04:00 PM</option>
                                        <option value="16:30:00">04:30 PM</option>
                                        <option value="17:00:00">05:00 PM</option>
                                        <option value="17:30:00">05:30 PM</option>
                                        <option value="18:00:00">06:00 PM</option>
                                        <option value="18:30:00">06:30 PM</option>
                                        <option value="19:00:00">07:00 PM</option>
                                        <option value="19:30:00">07:30 PM</option>
                                        <option value="20:00:00">08:00 PM</option>
                                        <option value="20:30:00">08:30 PM</option>
                                        <option value="21:00:00">09:00 PM</option>
                                        <option value="21:30:00">09:30 PM</option>
                                        <option value="22:00:00">10:00 PM</option>
                                        <option value="22:30:00">10:30 PM</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!--
                    <h4 class="border-bottom pt-4 pb-2">
                    </h4>
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label>Ingrese una nota a tu pedido</label><span class="text-success font-12"> (Opcional)</span>
                            <input type="text" name="nota_pedido_cliente" id="nota_pedido_cliente" class="form-control" placeholder="Ejm: poco pollo en el chaufa, agua mineral sin helar">
                        </div>
                    </div>
                    -->
                    <h4 class="border-bottom mt-5 pb-4">
                        <i class="ti ti-wallet mr-3 text-primary"></i>Tipo de pago
                    </h4>
                    <div class="row text-lg form-group">
                        <div class="form-group col-sm-6">
                            <div class="select-container">
                                <select class="form-control" name="tipo_pago" id="tipo_pago" required>
                                    <option value="">Seleccionar</option>
                                    <option value="1">Efectivo</option>
                                    <option value="2">Tarjeta</option>
                                    <?php if(codigo_culqi == 1){ ?>
                                    <option value="4">Culqi</option>
                                    <?php } ?>
                                    <?php if(codigo_yape == 1){ ?>
                                    <option value="5">Yape</option>
                                    <?php } ?>
                                    <?php if(codigo_transferencia == 1){ ?>
                                    <option value="7">Transferencia</option>
                                    <?php } ?>
                                    <?php if(codigo_plin == 1){ ?>
                                    <option value="11">Plin</option>
                                    <?php } ?>
                                    <?php if(codigo_tunki == 1){ ?>
                                    <option value="12">Tunki</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <!--
                        <div class="col-md-4 col-sm-4 col-4">
                            <label class="custom-control custom-radio">
                                <input type="radio" name="tipo_pago" value="1" class="custom-control-input" required>
                                <span class="custom-control-indicator"></span>
                                <span class="custom-control-description">Efectivo</span>
                            </label>
                        </div>
                        <div class="col-md-4 col-sm-4 col-4">
                            <label class="custom-control custom-radio">
                                <input type="radio" name="tipo_pago" value="2" class="custom-control-input">
                                <span class="custom-control-indicator"></span>
                                <span class="custom-control-description">Tarjeta</span>
                            </label>
                        </div>
                        <div class="">
                            <label class="custom-control custom-radio">
                                <input type="radio" name="tipo_pago" value="4" class="custom-control-input">
                                <span class="custom-control-indicator"></span>
                                <span class="custom-control-description">Culqi</span>
                            </label>
                        </div>
                        -->
                    </div>
                    <div class="content-efectivo" style="display: none;">
                        <div class="alert alert-success" role="alert">
                            <i class="ti ti-info-alt"></i> El personal motorizado vendr&aacute; a su domicilio, recibir&aacute; el efectivo y le entregar&aacute; el pedido.
                        </div>
                    </div>
                    <div class="content-tarjeta" style="display: none;">
                        <div class="alert alert-info" role="alert">
                            <i class="ti ti-info-alt"></i> El personal motorizado vendr&aacute; a su domicilio con un P.O.S. y le entregar&aacute; el pedido.
                        </div>
                    </div>
                    <div class="content-yape" style="display: none;">
                        <div class="alert alert-info" role="alert">
                            <img src="<?php echo URL ?>public/img/gallery/logo-yape.png" style="max-width: 15%"/> ===> <span class="font-20"><?php echo numero_yape; ?></span>
                        </div>
                    </div>
                    <div class="content-plin" style="display: none;">
                        <div class="alert alert-info" role="alert">
                            <img src="<?php echo URL ?>public/img/gallery/logo-plin.png" style="max-width: 15%"/> ===> <span class="font-20"><?php echo numero_plin; ?></span>
                        </div>
                    </div>
                    <div class="content-tunki" style="display: none;">
                        <div class="alert alert-info" role="alert">
                            <img src="<?php echo URL ?>public/img/gallery/logo-tunki.png" style="max-width: 15%"/> ===> <span class="font-20"><?php echo numero_tunki; ?></span>
                        </div>
                    </div>
                    <div class="content-transferencia" style="display: none;">
                        <div class="alert alert-info" role="alert">
                            <span class="font-20"><?php echo numero_transferencia; ?></span>
                        </div>
                    </div>
                    <div class="content-culqui-mensaje" style="display: none;">
                        <div class="alert alert-info" role="alert">
                            <i class="ti ti-info-alt"></i> Paga con tarjetas VISA, MasterCard, DinersClub, AmericanExpress.
                        </div>
                        <img src="<?php echo URL ?>public/img/gallery/tarjetas-culqi.png"/>
                    </div>                                                    
                </div>
                <div class="text-center display-informacion">
                    <button class="btn btn-success btn-submit btn-lg btn-block"><span>Ordenar ahora!</span></button>
                </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Section -->
<section class="section bg-light section-confirmacion" style="display: none;">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-3">
                <span class="icon icon-xl icon-success"><i class="ti ti-check-box"></i></span>
                <h1 class="mb-2">Gracias por su orden!</h1>
                <h4 class="text-muted mb-5">En unos momentos nos comunicaremos contigo por llamada telef&oacute;nica o al número de WhatsApp ingresado.</h4>
                <a href="<?php echo URL; ?>menu" class="btn btn-outline-secondary"><span>Seguir viendo nuestra carta</span></a>
            </div>
        </div>
    </div>
</section>

<!-- Modal / Cliente -->
<div class="modal fade" id="modal-cliente" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="form-cliente" method="post" enctype="multipart/form-data">
        <div class="modal-content">
            <div class="modal-header bg-inverse text-white">
                <h4 class="modal-title" id="myModalLabel">Bienvenido</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="ti ti-close"></i></button>
            </div>
            <div class="modal-body">
                <div class="row mb-0">
                    <div class="form-group col-sm-6 ent">
                        <label>Documento de identidad</label>
                        <input type="text" name="dni" id="dni" minlength="<?php echo digDoc; ?>" maxlength="<?php echo digDoc; ?>" class="form-control" autocomplete="off" required>
                    </div>
                    <div class="form-group col-sm-6 ent">
                        <label>Tel&eacute;fono celular</label>
                        <input type="text" name="telefono" id="telefono" minlength="9" maxlength="9" class="form-control" autocomplete="off" required>
                    </div>
                    <div class="form-group col-sm-12">
                        <label>Nombres</label>
                        <input type="text" name="nombres" id="nombres" class="form-control" autocomplete="off" required>
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Apellido paterno</label>
                        <input type="text" name="ape_paterno" id="ape_paterno" class="form-control" autocomplete="off" required>
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Apellido materno</label>
                        <input type="text" name="ape_materno" id="ape_materno" class="form-control" autocomplete="off" required>
                    </div>
                    <div class="form-group col-sm-12">
                        <label>Direcci&oacute;n</label>
                        <input type="text" name="direccion" id="direccion" class="form-control" autocomplete="off" required>
                    </div>
                    <div class="form-group col-sm-12">
                        <label>Referencia</label>
                        <input type="text" name="referencia" id="referencia" class="form-control" autocomplete="off" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-dismiss="modal"><span>Cancelar</span></button>
                <button type="submit" class="btn btn-success btn-submit"><span>Aceptar</span></button>
            </div>
        </div>
        </form>
    </div>
</div>