<?php

class Bootstrap {

    const CONTROLLERS_PATH = 'controllers/';
    const MODEL_PATH = 'model/';
    const ERROR_FILE = 'err.php';
    const DEFAULT_FILE = 'home.php';

    private $_url = null;
    private $_controller = null;
    private $_controllerPath = self::CONTROLLERS_PATH;
    private $_modelPath = self::MODEL_PATH;
    private $_errorFile = self::ERROR_FILE;
    private $_defaultFile = self::DEFAULT_FILE;

    public function init() {
        $this->_getUrl();

        if (empty($this->_url[0])) {
            $this->_loadDefaultController();
            return false;
        }

        $this->_loadExistingController();
        $this->_callControllerMethod();
    }

    public function setControllerPath($path) {
        $this->_controllerPath = trim($path, '/') . '/';
    }

    public function setModelPath($path) {
        $this->_modelPath = trim($path, '/') . '/';
    }

    public function setErrorFile($path) {
        $this->_errorFile = trim($path, '/');
    }

    public function setDefaultFile($path) {
        $this->_defaultFile = trim($path, '/');
    }

    private function _getUrl() {
        $this->_url = isset($_GET['url']) ? $_GET['url'] : '';
        $this->_url = str_replace('-', '', $this->_url);
        $this->_url = filter_var($this->_url, FILTER_SANITIZE_URL);
        $this->_url = rtrim($this->_url, '/');
        $this->_url = explode('/', $this->_url);
    }

    private function _loadDefaultController() {
        require $this->_controllerPath . $this->_defaultFile;
        $this->_controller = new Home();
        $this->_callMethodIfExists('index');
    }

    private function _loadExistingController() {
        $file = $this->_controllerPath . $this->_url[0] . '.php';
        if (file_exists($file)) {
            require $file;
            $this->_controller = new $this->_url[0];
            $this->_controller->loadModel($this->_url[0]);
        } else {
            $this->_error();
        }
    }

    private function _callControllerMethod() {
        $length = count($this->_url);

        if ($length > 1 && method_exists($this->_controller, $this->_url[1])) {
            $params = array_slice($this->_url, 2); // Obtener parámetros después del método
            $this->_callMethodIfExists($this->_url[1], $params);
        } else {
            $this->_callMethodIfExists('index');
        }
    }

    private function _callMethodIfExists($method, $params = []) {
        if (method_exists($this->_controller, $method)) {
            call_user_func_array([$this->_controller, $method], $params);
        } else {
            $this->_error();
        }
    }

    private function _error() {
        require $this->_controllerPath . $this->_errorFile;
        $this->_controller = new Err();
        $this->_callMethodIfExists('index');
        exit;
        return false;
    }
}