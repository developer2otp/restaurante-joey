<?php

class Checkout extends Controller {

	function __construct() {
		parent::__construct();
	}

	function index(){	
		$this->view->js = array('checkout/js/checkout.js?v='.rand(),'checkout/js/culqi.js?v='.rand(),'checkout/js/cliente.js?v='.rand());
		$this->view->render('checkout/index', false);
	}

	function run(){
		print_r(json_encode($this->model->run($_POST)));
	}

	function cliente_crud(){
        print_r(json_encode($this->model->cliente_crud_create($_POST)));
    }

    function RegistrarPedido(){
        $this->model->RegistrarPedido($_POST);
	}

	/*
	function procesoCulqi(){
		// Cargamos Requests y Culqi PHP
		require 'requests/library/Requests.php';
		Requests::register_autoloader();
		require 'culqi/lib/culqi.php';

		// Configurar tu API Key y autenticación
		$SECRET_KEY = "sk_test_zBWxHYk3Jv7k4cRm";
		$culqi = new Culqi\Culqi(array('api_key' => $SECRET_KEY));

		$culqi->Charges->create(
			array(
				"amount" => $_POST['precio'],
				"capture" => true,
				"currency_code" => "PEN",
				"description" => $_POST['producto'],
				"customer_id" => $_POST['customer_id'],
				"address" => $_POST['address'],
				"address_city" => $_POST['address_city'],
				"first_name" => $_POST['first_name'],
				"email" => $_POST['email'],
				"installments" => 0,
				"source_id" => $_POST['token']
			)
		);
		echo "exito";
		exit();
	}
	*/
}