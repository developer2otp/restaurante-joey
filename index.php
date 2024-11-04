<?php
if (version_compare(PHP_VERSION, '8', '<')) {
    echo 'La versión de PHP es inferior a la requerida para el correcto funcionamiento del sistema. PHP 8+';
    exit;
}
require 'config.php';
require 'util/Auth.php';

// Autoload function
spl_autoload_register(function ($className) {
    $classFile = __DIR__ . '/libs/' . str_replace('\\', '/', $className) . '.php';
    if (file_exists($classFile)) {
        require_once $classFile;
    }
});

$bootstrap = new Bootstrap();
$bootstrap->init();