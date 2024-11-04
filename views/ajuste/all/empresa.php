<input type="hidden" id="url" value="<?php echo URL; ?>"/>
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h4 class="m-b-0 m-t-0">Ajustes</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo URL; ?>ajuste" class="link">Inicio</a></li>
            <li class="breadcrumb-item"><a href="<?php echo URL; ?>ajuste" class="link">Empresa</a></li>
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
                <h6 class="card-subtitle">Informaci&oacute;n de tu empresa</h6>
                <div class="row floating-labels m-t-40">
                    <div class="col-md-8">
                        <div class="form-group m-b-40">
                            <input type="text" name="nombre_comercial" id="nombre_comercial" class="form-control input-mayus" autocomplete="off">
                            <span class="bar"></span>
                            <label for="nombre_comercial">Nombre comercial</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group m-b-40">
                            <input type="text" name="celular" id="celular" class="form-control" autocomplete="off">
                            <span class="bar"></span>
                            <label for="celular">Tel&eacute;fono</label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group m-b-40">
                            <input type="text" name="direccion_comercial" id="direccion_comercial" class="form-control input-mayus" autocomplete="off" required>
                            <span class="bar"></span>
                            <label for="direccion_comercial">Direcci&oacute;n comercial</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body sunat b-t">
                <div class="m-t-20">
                    <h4 class="card-title">Facturaci&oacute;n electr&oacute;nica (Per&uacute;)</h4>
                    <h6 class="card-subtitle">Informaci&oacute;n Sunat</h6>
                    <div class="row">
                        <div class="col-md-4 text-center">
                        <a href="javascript:void(0)" class="text-danger delete ms-2" onclick="anularlogo();"><i data-feather="trash-2" class="feather-sm fill-white"></i></a>
                            <div class="ct-wizard-azzure" id="wizardProfile">
                                <div class="picture-container">
                                    <div class="picture" style="width: 150px; height:150px">
                                        <img src="<?php echo URL; ?>public/images/productos/default.png" class="picture-src" id="wizardPicturePreview-2"/>
                                        <input type="hidden" name="imagen" id="imagen" value="default.png" />
                                        <input type="file" name="imagen" id="wizard-picture-2">
                                    </div>      
                                    <h6>Cambiar Imagen</h6>
                                    <!-- <a href="javascript:void(0)" class="text-danger delete ms-2" onclick="anular();"><i data-feather="trash-2" class="feather-sm fill-white"></i></a> -->
                                </div>
                            </div>
                        </div>
						
						
						
						
						<div class="col-md-8">
                            <div class="table-responsive">
                                <table class="table table-condensed table-hover" width="100%">
                                    <tbody>
                                        <tr>
                                            <td style="width:50px;">
                                                <span class="round round-warning"><i class="ti-ticket"></i></span>
                                            </td>
                                            <td>
                                                <h5 class="m-t-5 m-b-0">Conectar con API Facturador PRO > 5, 6, X (Compatible con Facturador Smart) </h5><h6 class="text-muted">Activar la conexi&oacute;n con facturador.</h6>
                                            </td>
                                            <td class="text-right p-r-0" style="vertical-align: middle;">
                                                <div class="switch">
                                                    <label><input type="checkbox" name="f_pro" id="f_pro"><span class="lever switch-col-light-green"></span></label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            
                                            <td colspan="3">
												<label for="api_url">API URL</label>
												<input type="text" name="api_url" id="api_url" placeholder="https://demo.facturador.test" class="form-control" autocomplete="off">
												<span class="bar"></span>
                                            </td>
                                        </tr>
										
										<tr>
                                            
                                            <td colspan="3">
												<label for="api_token">TOKEN API</label>
												<input type="text" name="api_token" id="api_token" placeholder="uif7fd77rweewe@@/$5fksdksRFFsoosdnnsdsdnsdsd47392" class="form-control" autocomplete="off">
												<span class="bar"></span>
                                            </td>
                                        </tr>
										
                                    </tbody>
                                </table>
                            </div>
                        </div>
						
                    </div>
                    <div class="row floating-labels m-t-20">
                        <div class="col-md-4">
                            <div class="form-group m-b-40 ent">
                                <input type="text" name="ruc" id="ruc" value="" class="form-control" maxlength="<?php echo Session::get('tribCar'); ?>" autocomplete="off" required>
                                <span class="bar"></span>
                                <label for="ruc" class="lblruc"><?php echo Session::get('tribAcr'); ?></label>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group m-b-40">
                                <input type="text" name="razon_social" id="razon_social" class="form-control input-mayus" autocomplete="off" required>
                                <span class="bar"></span>
                                <label for="razon_social">Raz&oacute;n social</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group m-b-40">
                                <input type="text" name="direccion_fiscal" id="direccion_fiscal" class="form-control input-mayus" autocomplete="off" required>
                                <span class="bar"></span>
                                <label for="direccion_fiscal">Direcci&oacute;n fiscal</label>
                            </div>
                        </div>
                        <div class="col-lg-6 b-r">
                            <div class="row m-t-40">
                                <div class="col-md-6">
                                    <div class="form-group m-b-40 ent">
                                        <input type="text" name="ubigeo" id="ubigeo" value="" class="form-control sunat" autocomplete="off" required>
                                        <span class="bar"></span>
                                        <label for="ubigeo">Ubigeo</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group m-b-40">
                                        <input type="text" name="departamento" id="departamento" value="" class="form-control input-mayus sunat" autocomplete="off" required>
                                        <span class="bar"></span>
                                        <label for="departamento">Departamento</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group m-b-40">
                                        <input type="text" name="provincia" id="provincia" value="" class="form-control input-mayus sunat" autocomplete="off" required>
                                        <span class="bar"></span>
                                        <label for="provincia">Provincia</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group m-b-40">
                                        <input type="text" name="distrito" id="distrito" value="" class="form-control input-mayus sunat" autocomplete="off" required>
                                        <span class="bar"></span>
                                        <label for="distrito">Distrito</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                                <div class="col-md-12 mt-2 m-b-40">
                                    <h6 class="border-bottom">Consulta integrada de CPE - Validador de documentos <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="top" title="Validador en producción"></i></h6>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group m-b-40">
                                        <input type="text" name="client_id" id="client_id" value="" class="form-control sunat" autocomplete="off" >
                                        <span class="bar"></span>
                                        <label for="client_id">Client ID</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group m-b-40">
                                        <input type="text" name="client_secret" id="client_secret" value="" class="form-control sunat" autocomplete="off" >
                                        <span class="bar"></span>
                                        <label for="client_secret">Client Secret (Clave)</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-right">
                    <a href="<?php echo URL; ?>ajuste" class="btn btn-secondary">Cancelar</a>
                    <button class="btn btn-success" type="submit">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
</div>
</form>