<?php

class Pedidos extends Controller {

	function __construct() {
		parent::__construct();
	}

	function index(){	
		$this->view->js = array('pedidos/js/pedidos.js?v='.rand());
		$this->view->css = array('pedidos/css/pedidos.css');
		$this->view->render('pedidos/index', false);
	}

	function pedidos_list(){
        print_r(json_encode($this->model->pedidos_list($_POST)));
    }

    function pedidos_productos_list(){
        print_r(json_encode($this->model->pedidos_productos_list($_POST)));
    }

}