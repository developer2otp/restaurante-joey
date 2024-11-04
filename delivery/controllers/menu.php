<?php

class Menu extends Controller {

	function __construct() {
		parent::__construct();
	}

	function index() {
		$this->view->listarCategorias = $this->model->listarCategorias();
		$this->view->js = array('menu/js/menu.js?v='.rand());
		$this->view->render('menu/index', false);
	}

    function listarProductos(){
        print_r(json_encode($this->model->listarProductos($_POST)));
    }
}