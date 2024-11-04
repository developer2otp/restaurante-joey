<?php
include_once('../../config.php');
include_once('../class/database.php');
/*
Sin condiciones ni ordenamiento: $list_pro = $dato->listar_datos("tm_producto", "", "", "fetchAll");
Con condiciones: $list_pro = $dato->listar_datos("tm_producto", "id_catg = $id_catg", "", "fetchAll");
Con ordenamiento: $list_pro = $dato->listar_datos("tm_producto", "", "nombre_producto ASC", "fetchAll");
Con condiciones y ordenamiento: $list_pro = $dato->listar_datos("tm_producto", "id_catg = $id_catg", "nombre_producto ASC", "fetchAll");
*/
$dato = new func();
$id_catg = $_POST['id_catg'];

try {
    $list_pro = $dato->listar_datos("tm_producto", "id_catg = $id_catg", "", "fetchAll");
    $list_pres = [];
    foreach ($list_pro as $producto) {
        $pres = $dato->listar_datos("tm_producto_pres", "id_prod = $producto->id_prod", "", "fetch");
        $list_pres[] = $pres;
    }
    echo json_encode($list_pres);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}