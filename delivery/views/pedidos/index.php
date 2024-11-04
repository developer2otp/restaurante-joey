<input type="hidden" id="pagina" value="4"/>

<!-- Page Title -->
<div class="page-title bg-light">
    <div class="bg-image bg-parallax"><img src="<?php echo URL_DEL; ?>public/img/screens/bg-croissant.jpg" alt=""></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-4">
                <h1 class="mb-0" style="color: #fff;">Mis pedidos</h1>
            </div>
        </div>
    </div>
</div>

<!-- Section -->
<section class="section">
    <div class="container">
        <div class="row">
        </div>

        <div class="row">
            <div class="col-md-4 display-login">
                <form id="form-login" role="form" method="post" class="display-login">
                    <h4 class="border-bottom pb-4"><i class="ti ti-receipt mr-3 text-primary"></i>Seguimiento de mi orden</h4>
                    <div class="row">
                        <div class="form-group col-sm-10 ent">
                            <label>N&uacute;mero de celular</label>
                            <input type="text" class="form-control" name="userlogin" id="userlogin" autocomplete="off" required>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="form-group col-sm-10">
                            <button type="submit" class="btn btn-success btn-md btn-block"><span>Continuar</span></button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-md-3 display-informacion">             
                <!-- Side Navigation -->
                <div class="display-informacion">
                    <nav id="side-navigation" class="stick-to-content pt-4 mb-5" data-local-scroll>
                        <h5 class="mb-3"><i class="ti ti-receipt mr-3 text-primary"></i>Mis pedidos:</h5>
                        <ul class="nav nav-vertical">
                            <li class="nav-item">
                                <a href="#faq1" class="nav-link list-recientes">Recientes</a>
                            </li>

                            <li class="nav-item">
                                <a href="#faq1" class="nav-link list-anteriores">Anteriores</a>
                            </li>
                        </ul>
                        <span class="font-10">Si deseas continuar con otro usuario <code class="user-refresh" style="cursor: pointer;">¡Hazlo aqu&iacute;!</code>
                        </span>
                    </nav>
                </div>
            </div>

            <div class="col-md-8 offset-md-1 display-informacion">
                <div class="alert alert-info mb-0" role="alert">
                    <span class="font-bold"><i class="ti ti-info-alt"></i> Seleccione un pedido</span> para poder visualizar en que estado se encuentra.
                </div>

                <div class="shadow">
                    <h6 class="p-20 mb-0 bg-dark text-white"><i class="ti ti-align-justify mr-4"></i><span class="text-pedidos">Recientes</span></h6>
                    <div id="faq1">
                        <div class="p-0">
                            <div class="table-responsive mb-0">
                                <table class="table table-hover stylish-table b-t p-0" width="100%" id="table">
                                    <thead class="table-head">
                                        <tr>
                                            <th>Pedido</th>
                                            <th>Hora</th>
                                            <th>Monto</th>
                                            <th class="text-right">Despacho</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table> 
                            </div>                     
                        </div>
                    </div>
                    <br>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal / Detalle pedido -->
<div class="modal inmodal fade" id="modal-pedido" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-inverse text-white">
                <h4 class="modal-title" id="myModalLabel">Detalle</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="ti ti-close"></i></button>
            </div>

            <div class="modal-body p-0">
                <div id="step-pedidos" class="mt-5">
                    <ol >
                        <li class="step step1">Solicitud<br> recibida</li>
                        <li class="step step2">Orden en <br>preparacion</li>
                        <li class="step step3">Orden en <br>camnino</li>
                        <li class="step step4">Orden<br> entregada</li>
                    </ol>
                </div>

                <p class="bg-success dark p-2 mt-5 mb-0">Productos</p>
                <div class="table-responsive mt-0 mb-0">
                    <table class="table table-hover stylish-table b-t b-b p-0" width="100%">
                        <thead class="table-head">
                            <tr>
                                <th>Cant</th>
                                <th>Producto</th>
                                <th>P.U.</th>
                                <th class="text-right">Importe</th>
                            </tr>
                        </thead>
                        <tbody class="tb-st" id="table-productos"></tbody>
                    </table>
                </div>
                <div class="text-right p-10 mb-1 font-14 font-bold pedidos-total"></div>
            </div>
        </div>
    </div>
</div>