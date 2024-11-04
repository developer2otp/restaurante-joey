<?php 
Session::init(); 
$ver = (Session::get('rol') == 1 OR Session::get('rol') == 2 OR Session::get('rol') == 3) ? '' :  header('location: ' . URL . 'err/danger'); 
?>
<?php

class Api extends Controller {

	function __construct() {
		parent::__construct();
		Auth::handleLogin();
	}
    function dni($dni) 
	{	
        if(strlen($dni) == '8'){
            print_r(json_encode($this->model->dni(API_TOKEN, $dni)));
        }
	}
    function ruc($ruc) 
	{	
        if(strlen($ruc) == '11'){
            print_r(json_encode($this->model->ruc(API_TOKEN, $ruc)));
        }
	}
    function liberarbloqueo(){
        print_r(json_encode($this->model->liberarbloqueo()));
    }
	
}