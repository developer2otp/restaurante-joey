<?php 
    Session::init(); 

class Login extends Controller {

	function __construct() {
		parent::__construct();	
		// Auth::handleLogin();
	}

	private function getRedirectURLByRole($rol) {
		switch ($rol) {
			case 3: // cajero y mozo 
			case 5:
				return 'venta';
			case 4: // produccion
				return 'produccion';
			default:
				return 'tablero';
		}
	}
	
	function index() 
	{	
		if (Session::get('loggedIn') != 1) {
			Session::init();
			Session::set('loggedIn', false);
			$this->view->js = array('login/js/login.js');
			$this->view->render('login/index', false);
		} else {
			Session::init();
			$redirectURL = $this->getRedirectURLByRole(Session::get('rol'));
			header('location: ' . URL . $redirectURL);
		}
	}
	
	function run()
	{
		print_r(json_encode($this->model->run($_POST)));
	}
	
}