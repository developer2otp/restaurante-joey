<?php

class Home extends Controller {

	function __construct() {
		parent::__construct();
	}

	function index() {
		$this->view->js = array('home/js/home.js?v='.rand());
		$this->view->render('home/index',false);
	}

	function listarCategorias(){
        print_r(json_encode($this->model->listarCategorias($_POST)));
    }

    function defaultdata(){
        print_r(json_encode($this->model->defaultdata()));
    }
}