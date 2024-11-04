<?php
//namespace App;

class Bootstrap {
    private $_url = [];
    private $_controller = null;
    private $_controllerPath = 'controllers/'; // Always include trailing slash
    private $_errorFile = 'err.php';
    private $_defaultFile = 'login.php';

    public function init() {
        $this->_getUrl();

        if (empty($this->_url[0])) {
            $this->_loadDefaultController();
        } else {
            $this->_loadExistingController();
            $this->_callControllerMethod();
        }
    }

    private function _getUrl() {
        $url = isset($_GET['url']) ? $_GET['url'] : '';
        $url = str_replace('-', '', $url);
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $url = rtrim($url, '/');
        $this->_url = explode('/', $url) ?: [];
    }

    private function _loadDefaultController() {
        $defaultController = $this->_controllerPath . $this->_defaultFile;
        $this->_controller = $this->_loadController($defaultController, 'Login');
        $this->_controller->index();
    }

    private function _loadExistingController() {
        $controllerFile = $this->_controllerPath . $this->_url[0] . '.php';

        if (file_exists($controllerFile)) {
            $this->_controller = $this->_loadController($controllerFile, $this->_url[0]);
            $this->_controller->loadModel($this->_url[0]);
        } else {
            $this->_error();
        }
    }

    private function _callControllerMethod() {
        $length = count($this->_url);

        if ($length > 1 && method_exists($this->_controller, $this->_url[1])) {
            $methodName = $this->_url[1];
            $params = array_slice($this->_url, 2);
            call_user_func_array([$this->_controller, $methodName], $params);
        } else {
            $this->_controller->index();
        }
    }

    private function _loadController($file, $className) {
        require_once $file;
        return new $className();
    }

    private function _error() {
        $errorFile = $this->_controllerPath . $this->_errorFile;
        require_once $errorFile;
        $errorController = new Err();
        $errorController->index();
        exit;
    }
}