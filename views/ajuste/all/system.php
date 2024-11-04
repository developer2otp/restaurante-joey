<?php
$jsonData = file_get_contents('config.json');
$dato = json_decode($jsonData);
?>
<input type="hidden" id="url" value="<?php echo URL; ?>"/>
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h4 class="m-b-0 m-t-0">Ajustes</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo URL; ?>" class="link">Inicio</a></li>
            <li class="breadcrumb-item"><a href="<?php echo URL; ?>ajuste" class="link">Ajuste</a></li>
            <li class="breadcrumb-item active"><?php echo $this->title_page; ?></li>
        </ol>
    </div>
</div>

<form id="form" method="post" enctype="multipart/form-data">
<input type="hidden" name="usuid" id="usuid" value="<?php echo Session::get('usuid'); ?>"/>
<div class="row">
    <div class="col-md-9">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Datos generales</h4>
                <h6 class="card-subtitle">Informaci&oacute;n del sistema restaurante</h6>
                <div class="row floating-labels m-t-40">
                    <div class="col-md-4">
                        <div class="form-group m-b-40">
                            <input type="text" name="nombre_system" id="nombre_system" value="<?php echo $dato->NOMBRE_SOFT;?>" class="form-control input-mayus" autocomplete="off">
                            <span class="bar"></span>
                            <label for="nombre_system">Nombre del sistema</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group m-b-40 ent">
                            <input type="text" name="celular_system" id="celular_system" value="<?php echo $dato->CEL_SYSTEM;?>" class="form-control" autocomplete="off">
                            <span class="bar"></span>
                            <label for="celular_system">Tel&eacute;fono de soporte</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group m-b-40">
                            <input type="text" name="nameNegocio_system" id="nameNegocio_system" value="<?php echo $dato->NAME_NEGOCIO;?>" class="form-control input-mayus" autocomplete="off">
                            <span class="bar"></span>
                            <label for="nameNegocio_system">Nombre del Negocio</label>
                        </div>
                    </div>
                    
                    <div class="col-md-8">
                        <div class="form-group m-b-40">
                            <input type="text" name="token_apiperu" id="token_apiperu" value="<?php echo $dato->API_TOKEN;?>" class="form-control" autocomplete="off">
                            <span class="bar"></span>
                            <label for="token_apiperu">Token APIPERU</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group m-b-40">
                            <input type="text" name="region_system" id="region_system" value="<?php echo $dato->NAME_CIUDAD;?>" class="form-control input-mayus" autocomplete="off">
                            <span class="bar"></span>
                            <label for="region_system">Regi&oacute;n</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group m-b-40">
                            <div class="switch">
                                <label>Descripci&oacute;n de comprobantes<input type="checkbox" name="desComp_system" id="desComp_system" <?php echo (DESCRIPCION_COMPROBANTE != false) ? 'checked' : ''; ?>><span class="lever switch-col-light-green"></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group m-b-40">
                            <div class="switch">
                                <label>URL al finalizar venta rápida<input type="checkbox" name="ventaRap_system" id="ventaRap_system" <?php echo (URL_VENTA_RAPIDA != false) ? 'checked' : ''; ?>><span class="lever switch-col-light-green"></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group m-b-40">
                            <div class="switch">
                                <label>Mostrar precio en comanda<input type="checkbox" name="priceComanda_system" id="priceComanda_system" <?php echo (PRICE_COMANDA != false) ? 'checked' : ''; ?>><span class="lever switch-col-light-green"></span></label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group m-b-40">
                            <div class="switch">
                                <label>Opcion eliminar mesas<input type="checkbox" name="optionDeleteMesa" id="optionDeleteMesa" <?php echo (OPTION_DELETE_MESA != false) ? 'checked' : ''; ?>><span class="lever switch-col-light-green"></span></label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="form-group m-b-40">
                            <input type="text" name="descDel_system" id="descDel_system" value="<?php echo $dato->DESCRIP_NOTA;?>" class="form-control" autocomplete="off">
                            <span class="bar"></span>
                            <label for="descDel_system">Descripci&oacute;n para deivery</label>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group m-b-40">
                            <input type="text" name="horAten_system" id="horAten_system" value="<?php echo $dato->HORARIO_ATENCION;?>" class="form-control" autocomplete="off">
                            <span class="bar"></span>
                            <label for="horAten_system">Horario de Atenci&oacute;n</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group m-b-40">
                            <input type="text" name="passAdmin_system" id="passAdmin_system" placeholder="*********" class="form-control" autocomplete="off">
                            <span class="bar"></span>
                            <label for="passAdmin_system"><span class="text-warning">Contraseña para SUPER-ADMIN <i class="fas fa-info-circle" style="color: #ff0000;" data-toggle="tooltip" data-placement="top" title="Contraseña SuperAdmin"></i></span></label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="input-group input-group-sm mb-3 ">
                            <select class="custom-select" id="inputGroupSelect01">
                                <option selected disabled>Turnos disponibles en caja...</option>
                                <?php
                                foreach($this->Turno as $key => $value){
                                    echo '<option>' . $value['descripcion'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="input-group input-group-sm mb-3">
                            <div class="input-group-prepend">
                            <span class="input-group-text">Nuevo Turno</span>
                        </div>
                        <input id="nombre_turno" type="text" class="form-control form-control-sm border">
                        <div class="input-group-prepend">
                            <button id="turnName" class="input-group-text btn btn-success">Guardar</button>
                        </div>
                    </div>
                    </div>

                </div>
            </div>

            <div class="card-body sunat b-t">
                <div class="m-t-10">
                    <h4 class="card-title">Configuraci&oacute;n Base de Datos</h4>
                    <h6 class="card-subtitle">Datos del servidor MYSQL</h6>

                    <div class="row floating-labels m-t-20">
                        <div class="col-md-3">
                            <div class="form-group m-b-40">
                                <input type="text" name="dbHost_mysql" id="dbHost_mysql" value="<?php echo $dato->DB_HOST;?>" class="form-control" autocomplete="off">
                                <span class="bar"></span>
                                <label for="dbHost_mysql">Host Mysql</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group m-b-40">
                                <input type="text" name="dbName_mysql" id="dbName_mysql" value="<?php echo $dato->DB_NAME;?>" class="form-control" autocomplete="off">
                                <span class="bar"></span>
                                <label for="dbName_mysql">Nombre BD</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group m-b-40">
                                <input type="text" name="dbUser_mysql" id="dbUser_mysql" value="<?php echo $dato->DB_USER;?>" class="form-control" autocomplete="off">
                                <span class="bar"></span>
                                <label for="dbUser_mysql">Usuario Mysql</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group m-b-40">
                                <input type="text" name="dbPass_mysql" id="dbPass_mysql" value="<?php echo $dato->DB_PASS;?>" class="form-control" autocomplete="off">
                                <span class="bar"></span>
                                <label for="dbPass_mysql">Contraseña Usuario Mysql</label>
                            </div>
                        </div>
            
                            <div class="col-md-12 mt-2 m-b-40">
                                <h6 class="border-bottom">URL(s) Redes Sociales <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="top" title="Respetar el formato"></i></h6>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group m-b-40">
                                    <input type="text" name="linkFb_system" id="linkFb_system" value="<?php echo $dato->URL_FB;?>" class="form-control" autocomplete="off" >
                                    <span class="bar"></span>
                                    <label for="linkFb_system">Facebook</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group m-b-40">
                                    <input type="text" name="linkIns_system" id="linkIns_system" value="<?php echo $dato->URL_INS;?>" class="form-control" autocomplete="off" >
                                    <span class="bar"></span>
                                    <label for="linkIns_system">Instagram</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group m-b-40">
                                    <input type="text" name="linkTw_system" id="linkTw_system" value="<?php echo $dato->URL_TW;?>" class="form-control" autocomplete="off" >
                                    <span class="bar"></span>
                                    <label for="linkTw_system">Twiter</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group m-b-40">
                                    <input type="text" name="linkLink_system" id="linkLink_system" value="<?php echo $dato->URL_LINK;?>" class="form-control" autocomplete="off" >
                                    <span class="bar"></span>
                                    <label for="linkLink_system">Linkedin</label>
                                </div>
                            </div>
                      
                    </div>
                        
                    </div>
                </div>

            <div class="card-footer">
                <div class="text-right">
                    <a href="<?php echo URL; ?>ajuste" class="btn btn-secondary">Cancelar</a>
                    <button class="btn btn-success" id="miBoton" type="submit">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
</div>
</form>