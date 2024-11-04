<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h4 class="m-b-0 m-t-0">Ajustes</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo URL; ?>ajuste" class="link">Inicio</a></li>
            <li class="breadcrumb-item active">Panel de opciones</li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeIn ng-scope">
    <div class="row">
        <div class="col-lg-4">
            <div class="card card-body p-0">
                <h4 class="card-title p-t-20 p-l-20 p-r-20 m-b-0">Sistema</h4>
                <div class="message-box">
                    <div class="message-widget m-t-10">                        
                        <a href="ajuste/sistema">
                            <div class="m-t-10"></div>
                            <div class="user-img"><span class="round bg-warning"><i class="fas fa-cog"></i></span></div>
                            <div class="mail-contnet">
                                <h5>Configuraci&oacute;n inicial</h5> <span class="mail-desc">Caracter&iacute;sticas, opciones, otros.</span>
                            </div>
                        </a>
                        <a href="ajuste/printer">
                            <div class="m-t-10"></div>
                            <div class="user-img"><span class="round bg-warning"><i class="fas fa-print"></i></span></div>
                            <div class="mail-contnet">
                                <h5>Impresoras</h5> <span class="mail-desc">Creaci&oacute;n, modificaci&oacute;n.</span>
                            </div>
                        </a>
                        <?php if (Session::get('rol') == 1):?> 
                            <!--
                        <a href="ajuste/optimizar">
                            <div class="m-t-10"></div>
                            <div class="user-img"><span class="round bg-warning"><i class="fas fa-random"></i></span></div>
                            <div class="mail-contnet">
                                <h5>Optimizaci&oacute;n de procesos</h5> <span class="mail-desc">Reducir o eliminar la p&eacute;rdida de tiempo y recursos</span>
                            </div>
                        </a>
                        -->
                        <a href="ajuste/system">
                            <div class="m-t-10"></div>
                            <div class="user-img"><span class="round bg-warning"><i class="fas fa-wrench"></i></span></div>
                            <div class="mail-contnet">
                                <h5>Configuraci&oacute;n system</h5> <span class="mail-desc">Configuraci&oacute;nes del sistema principal</span>
                            </div>
                        </a>
                        <a href="javascript:void(0)"  onclick="bloc_desbloc();">
                            <?php if(Session::get('bloqueo_id') == '0'):   ?>
                            <div class="m-t-10"></div>
                            <div class="user-img"><span class="round bg-danger"><i class="fas fa-ban"></i></span></div>
                            <div class="mail-contnet">
                                <h5>Bloquear  Plataforma</h5> <span class="mail-desc">Bloqueo por falta de pago</span>
                            </div>
                            <?php else : ?>
                            <div class="m-t-10"></div>
                            <div class="user-img"><span class="round bg-success"><i class="fas fa-check"></i></span></div>
                            <div class="mail-contnet">                                    
                                <h5>Desbloquear  Plataforma</h5> <span class="mail-desc">Desbloquear su pago fue exitoso</span>
                            </div>
                            <?php endif; ?>
                        </a>
                        
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card card-body p-0">
                <h4 class="card-title p-t-20 p-l-20 p-r-20 m-b-0">Empresa</h4>
                <div class="message-box">
                    <div class="message-widget m-t-10">
                        <a href="ajuste/datosempresa">
                            <div class="m-t-10"></div>
                            <div class="user-img"><span class="round bg-primary"><i class="fas fa-building"></i></span></div>
                            <div class="mail-contnet">
                                <h5>Datos de la empresa</h5> <span class="mail-desc">Modificar los datos de la empresa.</span>
                            </div>
                        </a>                        
                        <a href="ajuste/usuario">
                            <div class="m-t-10"></div>
                            <div class="user-img"> <span class="round bg-primary"><i class="fas fa-user"></i></span></div>
                            <div class="mail-contnet">
                                <h5>Usuarios / Roles</h5> <span class="mail-desc">Creaci&oacute;n, modificaci&oacute;n.</span>
                            </div>
                        </a>
                        <a href="ajuste/tipodoc">
                            <div class="m-t-10"></div>
                            <div class="user-img"><span class="round bg-primary"><i class="fas fa-file-alt"></i></span></div>
                            <div class="mail-contnet">
                                <h5>Tipo de documentos </h5> <span class="mail-desc">Modificar los tipos de documentos.</span>
                            </div>
                        </a>
                        <a href="ajuste/tipopago">
                            <div class="m-t-10"></div>
                            <div class="user-img"><span class="round bg-primary"><i class="fas fa-credit-card"></i></span></div>
                            <div class="mail-contnet">
                                <h5>Tipos de pago </h5> <span class="mail-desc">Modificar los tipos de pagos.</span>
                            </div>
                        </a>
                        <?php if(DESCRIPCION_COMPROBANTE === true){?>
                        <a href="#" data-toggle="modal" data-target="#terminosycondiciones">
                            <div class="m-t-10"></div>
                            <div class="user-img"><span class="round bg-primary"><i class="fas fa-comment"></i></span></div>
                            <div class="mail-contnet">
                                <h5>T&eacute;rminos y condiciones de comprobantes</h5> <span class="mail-desc">Mostrar t&eacute;rminos y codiciones.</span>
                            </div>
                        </a>
                        <?php } ?>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card card-body p-0">
                <h4 class="card-title p-t-20 p-l-20 p-r-20 m-b-0">Restaurante</h4>
                <div class="message-box">
                    <div class="message-widget m-t-10">
                        <a href="ajuste/caja">
                            <div class="m-t-10"></div>
                            <div class="user-img"><span class="round bg-success"><i class="fas fa-desktop"></i></span></div>
                            <div class="mail-contnet">
                                <h5>Cajas</h5> <span class="mail-desc">Creaci&oacute;n, modificaci&oacute;n.</span>
                            </div>
                        </a>
                        <a href="ajuste/areaprod">
                            <div class="m-t-10"></div>
                            <div class="user-img"><span class="round bg-success"><i class="ti-layout-accordion-separated"></i></span></div>
                            <div class="mail-contnet">
                                <h5>&Aacute;reas de Producci&oacute;n</h5> <span class="mail-desc">Creaci&oacute;n, modificaci&oacute;n.</span>
                            </div>
                        </a>
                        <a href="ajuste/salon-mesa">
                            <div class="m-t-10"></div>
                            <div class="user-img"> <span class="round bg-success"><i class="ti-layout-slider-alt"></i></span></div>
                            <div class="mail-contnet">
                                <h5>Salones y mesas</h5> <span class="mail-desc">Creaci&oacute;n, modificaci&oacute;n.</span>
                            </div>
                        </a>
                        <a href="ajuste/producto">
                            <div class="m-t-10"></div>
                            <div class="user-img"> <span class="round bg-success"><i class="fas fa-archive"></i></span></div>
                            <div class="mail-contnet">
                                <h5>Productos</h5> <span class="mail-desc">Creaci&oacute;n, modificaci&oacute;n.</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>        
    </div>
</div>
<!-- modal terminos y condicones -->
                        <!-- Modal -->
                        <div class="modal fade" id="terminosycondiciones" tabindex="-1" role="dialog" aria-labelledby="terminosycondicionesLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="terminosycondicionesLabel">Agregar texto al comprobante</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div class="modal-body">
      <textarea class="summernote" name="body_comentario" id="body_comentario" placeholder="Escribir texto a mostrar en el comprobante!."></textarea>
      <!--<spam id="body_comentario"></spam>-->
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onClick="guardar_termino();">Guardar</button>
      </div>
    </div>
  </div>
</div>
                        <!-- fin modal terminos y condiciones -->
<script type="text/javascript">
    $('#navbar-c').addClass("white-bg");
    $('#config').addClass("active");

    var bloc_desbloc = function(){

        var html_confirm = '<div><?php print (Session::get('bloqueo_id') == '1')? 'Se procederá a desbloquear la plataforma' : 'Se procederá a bloquear la plataforma'; ?></div><br>\
            <div><span class="text-success" style="font-size: 17px;">¿Está Usted de Acuerdo?</span></div>';
        Swal.fire({
            title: 'Necesitamos de tu Confirmación',
            html: html_confirm,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#34d16e',
            confirmButtonText: 'Si, Adelante!',
            cancelButtonText: "No!",
            showLoaderOnConfirm: true,
            preConfirm: function() {
            return new Promise(function(resolve) {
                $.ajax({
                    url: $('#url').val()+'ajuste/bloqueo',
                    type: 'POST',
                    data: {
                        tipo_bloqueo  : <?php print (Session::get('bloqueo_id') == '0')? '1' : '0';      ?>,
                        },
                    dataType: 'json'
                })
                .done(function(response){
                    if(response.success == 1){
                        var titulo = 'Proceso Terminado';
                        var icono = 'success';

                    //location.reload();
                    }else{
                        var titulo = 'Proceso No Culminado';
                        var icono = 'error';
                        
                    }

                    Swal.fire({
                            title: titulo,
                            text: response.message,
                            icon: icono,
                            confirmButtonColor: "#34d16e",     
                            confirmButtonText: "Aceptar",
                            allowOutsideClick: false,
                            showCancelButton: false,
                            showConfirmButton: true
                            }, function() {
                                return false
                        });
                        setTimeout(function(){
                            location.reload();
                        }, 2000);
                })
                .fail(function(){
                    Swal.fire('Oops...', 'Problemas con la conexión a internet!', 'error');
                });
            });
            },
            allowOutsideClick: false              
        });
    }


//exaple
$(document).ready(function() {
  $('.summernote').summernote({
    lang: 'es-ES',
    toolbar: [
        ['style', ['bold', 'italic', 'underline', 'clear']],
        ['fontsize', ['fontsize']],
        ['height', ['height']]
    ]
    });

    $.ajax({
        url: $('#url').val()+'ajuste/terminos_listar',
        dataType: 'json'
    }).done(function(response){
                    var html_code = response.comentario_comprobante;

                    $('.summernote').summernote('code', html_code);
            })
});

function guardar_termino()
{
    var dato = $('.summernote').summernote('code');
    $.ajax({
                    url: $('#url').val()+'ajuste/terminos',
                    type: 'POST',
                    data: {dto: dato},
                    dataType: 'json'
                })
                .done(function(response){
                    if(response.success == 1){
                        var titulo = 'Proceso Terminado';
                        var icono = 'success';
                    }else{
                        var titulo = 'Proceso No Culminado';
                        var icono = 'error';
                    }
                    Swal.fire({
                            title: titulo,
                            text: response.message,
                            icon: icono,
                            confirmButtonColor: "#34d16e",   
                            confirmButtonText: "Aceptar",
                            allowOutsideClick: false,
                            showCancelButton: false,
                            showConfirmButton: true
                            }, function() {
                                return false
                        });

                })
                .fail(function(){
                    Swal.fire('Oops...', 'Problemas con la conexión a internet!', 'error');
                });
                return false;

}
</script>
<!--Personal sumernote -->
<script src="<?php echo URL; ?>public/plugins/summernote/dist/summernote.min.js"></script>