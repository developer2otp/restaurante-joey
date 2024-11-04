<?php
//REGISTRO DE ERRORES NO TOCAR
ini_set('log_errors', 1);
$logFile = 'logs/debug.log';
ini_set('error_log', $logFile);
$protocolo = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];
$url_actual = "$protocolo://$host";
$configFile = $url_actual . '/config.json';
$config = json_decode(file_get_contents($configFile), true);

//*************************************ADMIN DEL SISTEMA************************************//
define('CEL_SYSTEM', $config['CEL_SYSTEM']);//numero de cel para soporte
define('NOMBRE_SOFT', $config['NOMBRE_SOFT']);//nombre del software
define('DESCRIPCION_COMPROBANTE', $config['DESCRIPCION_COMPROBANTE']);//si deseamos que en el cliente se muestre terminos y condiciones
define('URL_VENTA_RAPIDA', $config['URL_VENTA_RAPIDA']);//link impresion por red en venta rapida
define('PRICE_COMANDA', $config['PRICE_COMANDA']);//precio en comanda solo venta rapida
define('OPTION_DELETE_MESA', $config['OPTION_DELETE_MESA']);

//CONFIGURACION BASE DE DATOS
define('DB_TYPE', 'mysql');
//define('DB_HOST', '198.54.121.169');
define('DB_HOST', $config['DB_HOST']);
//define('DB_NAME', 'siscoperu_burgernorte');
define('DB_NAME', $config['DB_NAME']);
//define('DB_USER', 'siscoperu_jb2409');
define('DB_USER', $config['DB_USER']);
//define('DB_PASS', '@admin123adm@');
define('DB_PASS', $config['DB_PASS']);
define('DB_CHARSET', 'utf8');

//API DNI RUC
define('API_TOKEN', $config['API_TOKEN']);

//PAGINA DELIVERY
define('DESCRIP_NOTA', $config['API_TOKEN']);

//URLS
define('URL', $url_actual . '/');
define('LIBS', 'libs/');
define('URL_DEL', $url_actual . '/delivery/');
define('MODAL_COVID_DELIVERY', true);
//*********************************************************************************************//

// CONFIGURAR DATOS DEL CLIENTE
define('NAME_NEGOCIO', $config['NAME_NEGOCIO']);
define('NAME_CIUDAD', $config['NAME_CIUDAD']);
define('HORARIO_ATENCION', $config['HORARIO_ATENCION']);

//REDES SOCIALES
//twiter
define('URL_TW', $config['URL_TW']);
//facebook
define('URL_FB', $config['URL_FB']);
//instagram
define('URL_INS', $config['URL_INS']);
//linkedin
define('URL_LINK', $config['URL_LINK']);

define('MENSAJE_WHATSAPP', 'Su comprobante de pago electrónico ha sido generado correctamente, puede revisarlo en el siguiente enlace:');

//configuracion del logo print 
define('L_DIMENSION','30'); // dimenciona en largo como alto 
define('L_CENTER', '20'); // DE IZQUIERDA A DERECHA PARA PODER CENTRARL LA IMAGEN 
define('L_ESPACIO', '20'); // DARA EL ESPACIO ENTRE EL LOGO Y EL NOMBRE COMERCIAL 
define('L_FORMATO' , 'png'); // png, jpg, gif

//constants
define('HASH_GENERAL_KEY', 'MixitUp200');
define('HASH_PASSWORD_KEY', 'catsFLYhigh2000miles');