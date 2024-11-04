<?php
use Jbsoft\NewRest\Session;

function acceso($users = []) {
    Session::init(); 
    $rol = Session::get('rol');
    $bloqueo = Session::get('bloqueo');

    if (!empty($users)) {
        if (in_array($rol, $users)) {
            header('Location: ' . URL . '../public/pages/user_no_autorizado.php');
            exit;
        }
    }

    if ($bloqueo != 0 && $bloqueo != null) {
        header('Location: ' . URL . '../public/pages/sistema_bloqueado.php');
        exit;
    }
}