<?php 
    Session::init(); 
    $ver = (Session::get('bloqueo') == 0 OR Session::get('bloqueo') == null) ? '' :  header('location: ' . URL . 'err/bloqueo');
?>
<?php
require_once 'public/lib/print/num_letras.php';
require_once 'mailer/send.php';

class Comprobantes extends Controller {

	function __construct() {
		parent::__construct();
		Auth::handleLogin();
	}

	function Index(){
        $this->view->title_page = 'API Facturador PRO | Comprobantes';
        $this->view->js = array('comprobantes/js/comprobantes.js');
		$this->view->render('comprobantes/index', false);
    }

    function ListarComprobantes(){
        print_r(json_encode($this->model->ListarComprobantes($_POST)));
    }
	function notificacion(){
		print_r(json_encode($this->model->notificacion()));
	}	

    function ComunicacionBaja(){
		print_r(json_encode($this->model->ComunicacionBaja($_POST)));
    }

    function Resumen_boletas_invoice(){
        print_r(json_encode($this->model->Resumen_boletas_invoice($_POST)));   
    }

    function Actualiza_comprobante(){
        print_r(json_encode($this->model->Actualiza_comprobante($_POST)));   
    }

    function send_mailer(){

        $negocio = NAME_NEGOCIO;
        $datos_factura = $this->model->pdf_factura($_POST['id_venta']);
        $api = new Email();
        $api->sendEmail($_POST['correo_cliente'],$_POST['documento_cliente'],json_encode($datos_factura),$negocio);
    }   
}