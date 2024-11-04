<?php Session::init();

date_default_timezone_set($_SESSION["zona_hor"]);
setlocale(LC_ALL, "es_ES@euro", "es_ES", "esp");

class Venta_Model extends Model
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function Salon()
    {
        try
        {
            return $this->db->selectAll('SELECT * FROM tm_salon WHERE estado != "i"');
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function Mozo()
    {
        try
        {   
            return $this->db->selectAll('SELECT id_usu,nombres,ape_paterno,ape_materno FROM v_usuarios WHERE id_rol = 5 AND estado = "a"');
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function Repartidor()
    {
        try
        {   
            return $this->db->selectAll('SELECT * FROM tm_usuario WHERE id_rol = 6 AND estado = "a"');
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function TipoDocumento()
    {
        try
        {   
            return $this->db->selectAll('SELECT * FROM tm_tipo_doc WHERE estado = "a"');
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function TipoPago()
    {
        try
        {   
            return $this->db->selectAll('SELECT * FROM tm_tipo_pago WHERE estado = "a"');
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function Personal()
    {
        try
        {      
            return $this->db->selectAll("SELECT * FROM tm_usuario WHERE id_usu <> 1 AND estado = 'a' GROUP BY dni");
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function mesa_list()
    {
        try
        {   
            $mesa = $this->db->prepare("SELECT * FROM v_listar_mesas ORDER BY id_mesa ASC");
            $mesa->execute();
            $m = $mesa->fetchAll(PDO::FETCH_OBJ);
            $data = array("mesa" => $m);
            return $data;
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function mostrador_list($data)
    {
        try
        {
            $fecha = date('Y-m-d');
            $filtro_fecha = ($data['estado'] == 'd') ? " AND DATE_FORMAT(p.fecha_pedido,'%Y-%m-%d') = ? ORDER BY p.fecha_pedido DESC" : "";

            $stm = $this->db->prepare("
                SELECT
                    tp.*, 
                    p.fecha_pedido, 
                    p.estado, 
                    DATE(p.fecha_pedido) AS fecha, 
                    IFNULL(SUM(vdl.precio * vdl.cantidad), 0) AS total 
                FROM tm_pedido AS p 
                INNER JOIN tm_pedido_llevar AS tp ON p.id_pedido = tp.id_pedido 
                LEFT JOIN v_det_llevar AS vdl ON vdl.id_pedido = p.id_pedido AND vdl.estado != 'z' 
                WHERE p.estado = ? $filtro_fecha 
                GROUP BY p.id_pedido 
                ORDER BY p.fecha_pedido DESC");

            $params = [$data['estado']];

            if ($data['estado'] == 'd') {
                $params[] = $fecha;
            }

            $stm->execute($params);
            $c = $stm->fetchAll(PDO::FETCH_OBJ);

            $ids_pedidos = array_map(function ($item) {
                return $item->id_pedido;
            }, $c);

            if (!empty($ids_pedidos)) {
                $placeholders = implode(',', array_fill(0, count($ids_pedidos), '?'));
                $totals_query = $this->db->prepare("
                    SELECT id_pedido, IFNULL(SUM(precio * cantidad), 0) AS total 
                    FROM v_det_llevar 
                    WHERE estado != 'z' AND id_pedido IN ($placeholders) 
                    GROUP BY id_pedido");
                $totals_query->execute($ids_pedidos);
                $totals = $totals_query->fetchAll(PDO::FETCH_OBJ);
            }

            $c = array_filter($c, function ($item) {
                return isset($item->total) && $item->total !== 0.00 && $item->total !== "0.00";
            });

            return ['data' => array_values($c)];

        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function mostrador_list_c($data)
    {
        try
        {   
            date_default_timezone_set($_SESSION["zona_horaria"]);
            setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
            $fecha = date('Y-m-d');

            if($data['estado'] == 'd'){
                $filtro_fecha = " AND DATE_FORMAT(p.fecha_pedido,'%Y-%m-%d') = '".$fecha."' ORDER BY p.fecha_pedido DESC";
            }else{
                $filtro_fecha = "";
            }

            if(Session::get('rol') == 5){

                $stm = $this->db->prepare("SELECT tp.*,p.fecha_pedido,p.estado,DATE(p.fecha_pedido) AS fecha, v.id_venta, v.id_tipo_pago, IFNULL((v.total+v.comision_delivery-v.descuento_monto),0) AS total FROM tm_pedido AS p INNER JOIN tm_pedido_llevar AS tp ON p.id_pedido = tp.id_pedido INNER JOIN tm_venta AS v ON p.id_pedido = v.id_pedido WHERE p.estado = ? ".$filtro_fecha);
                $stm->execute(array($data['estado']));
                $c = $stm->fetchAll(PDO::FETCH_OBJ);

            } else {

                $stm = $this->db->prepare("SELECT tp.*,p.fecha_pedido,p.estado,DATE(p.fecha_pedido) AS fecha, v.id_venta, v.id_tipo_pago, IFNULL((v.total+v.comision_delivery-v.descuento_monto),0) AS total FROM tm_pedido AS p INNER JOIN tm_pedido_llevar AS tp ON p.id_pedido = tp.id_pedido INNER JOIN tm_venta AS v ON p.id_pedido = v.id_pedido WHERE v.id_apc = ? AND p.estado = ? ".$filtro_fecha);
                $stm->execute(array(Session::get('apcid'),$data['estado']));
                $c = $stm->fetchAll(PDO::FETCH_OBJ);

            }

            foreach($c as $k => $d)
            {
                $c[$k]->{'Tipopago'} = $this->db->query("SELECT descripcion AS nombre FROM tm_tipo_pago WHERE id_tipo_pago = " . $d->id_tipo_pago)
                    ->fetch(PDO::FETCH_OBJ);
            }
      
            $data = array("data" => $c);
            $json = json_encode($data);
            echo $json;
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function delivery_list($data)
    {
        try
        {   
            date_default_timezone_set($_SESSION["zona_horaria"]);
            setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
            $fecha = date('Y-m-d');

            if($data['estado'] == 'd'){
                $filtro_fecha = " AND DATE_FORMAT(p.fecha_pedido,'%Y-%m-%d') = '".$fecha."' ORDER BY p.fecha_pedido DESC";
            }else{
                $filtro_fecha = "";
            }

            $stm = $this->db->prepare("SELECT tp.*,p.fecha_pedido,p.estado,DATE(p.fecha_pedido) AS fecha FROM tm_pedido AS p INNER JOIN tm_pedido_delivery AS tp ON p.id_pedido = tp.id_pedido WHERE p.estado = ? ".$filtro_fecha);
            $stm->execute(array($data['estado']));
            $c = $stm->fetchAll(PDO::FETCH_OBJ);
            foreach($c as $k => $d)
            {
                $c[$k]->{'Tipopago'} = $this->db->query("SELECT descripcion AS nombre FROM tm_tipo_pago WHERE id_tipo_pago = " . $d->tipo_pago)
                    ->fetch(PDO::FETCH_OBJ);
            }
            foreach($c as $k => $d)
            {
                // suma si hay delivery 
                // SELECT comision_delivery FROM `tm_pedido_delivery` WHERE `id_pedido` = 4
                $comisiondelivery   = $this->db->query("SELECT comision_delivery FROM `tm_pedido_delivery` WHERE `id_pedido` =" . $d->id_pedido)->fetch();
                // $row = $result->fetch(PDO::FETCH_ASSOC);
                $ventatotal         = $this->db->query("SELECT IFNULL(SUM(precio*cantidad),0) AS total FROM v_det_delivery WHERE estado <> 'z' AND id_pedido = " . $d->id_pedido)->fetch();

                

                $c[$k]->{'Total'} =  $ventatotal;
            }            
            $data = array("data" => $c);
            $json = json_encode($data);
            echo $json; 
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }
    
    public function delivery_list_c($data)
    {
        try
        {   
            date_default_timezone_set($_SESSION["zona_horaria"]);
            setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
            $fecha = date('Y-m-d');

            if($data['estado'] == 'd'){
                $filtro_fecha = " AND DATE_FORMAT(p.fecha_pedido,'%Y-%m-%d') = '".$fecha."' ORDER BY p.fecha_pedido DESC";
            }else{
                $filtro_fecha = "";
            }

            $stm = $this->db->prepare("SELECT v.id_venta,tp.*,p.fecha_pedido,p.estado,DATE(p.fecha_pedido) AS fecha, v.id_tipo_pago AS tipo_pago_new, IFNULL((v.total+v.comision_delivery-v.descuento_monto),0) AS total FROM tm_pedido AS p INNER JOIN tm_pedido_delivery AS tp ON p.id_pedido = tp.id_pedido INNER JOIN tm_venta AS v ON p.id_pedido = v.id_pedido WHERE v.id_apc = ? AND p.estado = ? ".$filtro_fecha);
            $stm->execute(array(Session::get('apcid'),$data['estado']));
            $c = $stm->fetchAll(PDO::FETCH_OBJ);
            foreach($c as $k => $d)
            {
                $c[$k]->{'Tipopago'} = $this->db->query("SELECT descripcion AS nombre FROM tm_tipo_pago WHERE id_tipo_pago = " . $d->tipo_pago_new)
                    ->fetch(PDO::FETCH_OBJ);
            }
            /*
            foreach($c as $k => $d)
            {
                $c[$k]->{'Total'} = $this->db->query("SELECT IFNULL(SUM(precio*cantidad),0) AS total FROM v_det_delivery WHERE estado <> 'z' AND id_pedido = " . $d->id_pedido)
                    ->fetch(PDO::FETCH_OBJ);
            }            
            */
            $data = array("data" => $c);
            $json = json_encode($data);
            echo $json; 
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }
    /*
    public function delivery_list_b()
    {
        try
        {   
            $stm = $this->db->prepare("SELECT tp.*,p.fecha_pedido,p.estado,DATE(p.fecha_pedido) AS fecha FROM tm_pedido AS p INNER JOIN tm_pedido_delivery AS tp ON p.id_pedido = tp.id_pedido WHERE p.estado = 'x'");
            $stm->execute();
            $c = $stm->fetchAll(PDO::FETCH_OBJ);
            foreach($c as $k => $d)
            {
                $c[$k]->{'Total'} = $this->db->query("SELECT IFNULL(SUM(precio*cantidad),0) AS total FROM v_det_delivery WHERE estado <> 'i' AND id_pedido = " . $d->id_pedido)
                    ->fetch(PDO::FETCH_OBJ);
            }
            foreach($c as $k => $d)
            {
                $c[$k]->{'Repartidor'} = $this->db->query("SELECT descripcion AS nombre FROM tm_repartidor WHERE id_repartidor = " . $d->id_repartidor)
                    ->fetch(PDO::FETCH_OBJ);
            }
            return $c;
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function delivery_list_c()
    {
        try
        {   
            date_default_timezone_set($_SESSION["zona_horaria"]);
            setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
            $fecha = date('Y-m-d');
            $stm = $this->db->prepare("SELECT tp.*,p.fecha_pedido,p.estado,DATE(p.fecha_pedido) AS fecha FROM tm_pedido AS p INNER JOIN tm_pedido_delivery AS tp ON p.id_pedido = tp.id_pedido WHERE p.estado = 'c' AND DATE_FORMAT(p.fecha_pedido,'%Y-%m-%d') = ?");
            $stm->execute(array($fecha));
            $c = $stm->fetchAll(PDO::FETCH_OBJ);
            foreach($c as $k => $d)
            {
                $c[$k]->{'Total'} = $this->db->query("SELECT IFNULL(SUM(precio*cantidad),0) AS total FROM v_det_delivery WHERE estado <> 'i' AND id_pedido = " . $d->id_pedido)
                    ->fetch(PDO::FETCH_OBJ);
            }
            foreach($c as $k => $d)
            {
                $c[$k]->{'Repartidor'} = $this->db->query("SELECT descripcion AS nombre FROM tm_repartidor WHERE id_repartidor = " . $d->id_repartidor)
                    ->fetch(PDO::FETCH_OBJ);
            }
            return $c;
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }
    */

    public function listarPedidos($data)
    {
        try
        {   
            if($data['codpagina'] == '1'){
                $stm = $this->db->prepare("SELECT dp.id_pedido, dp.id_pres, SUM(dp.cantidad) AS cantidad, dp.precio, dp.comentario, dp.estado, p.nombre_mozo FROM tm_detalle_pedido AS dp INNER JOIN v_pedido_mesa AS p ON p.id_pedido = dp.id_pedido WHERE dp.id_pedido = ? AND dp.estado <> 'z' AND dp.cantidad > 0 GROUP BY dp.id_pres, dp.precio ORDER BY dp.fecha_pedido DESC");
            } else {
                $stm = $this->db->prepare("SELECT dp.id_pedido, dp.id_pres, SUM(dp.cantidad) AS cantidad, dp.precio, dp.comentario, dp.estado FROM tm_detalle_pedido AS dp WHERE dp.id_pedido = ? AND dp.estado <> 'z' AND dp.cantidad > 0 GROUP BY dp.id_pres, dp.precio ORDER BY dp.fecha_pedido DESC");
            }
            $stm->execute(array($data['id_pedido']));
            $c = $stm->fetchAll(PDO::FETCH_OBJ);  
            foreach($c as $k => $d)
            {
                $c[$k]->{'Producto'} = $this->db->query("SELECT pro_nom,pro_pre FROM v_productos WHERE id_pres = ". $d->id_pres)
                    ->fetch(PDO::FETCH_OBJ);
            }
            return $c;
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function listarPedidosDetalle($data)
    {
        try
        {   
            if($data['cod_atencion'] == 2) { $tabla = 'v_pedido_llevar'; } elseif($data['cod_atencion'] == 3) { $tabla = 'v_pedido_delivery'; }
            $stm = $this->db->prepare("SELECT * FROM ".$tabla." WHERE id_pedido = ?");
            $stm->execute(array($data['id_pedido']));
            $c = $stm->fetch(PDO::FETCH_OBJ);
            /* Traemos el detalle */
            $c->{'Detalle'} = $this->db->query("SELECT id_pedido,id_pres,SUM(cant) AS cant, precio, comentario, estado FROM tm_detalle_pedido WHERE id_pedido = ".$c->id_pedido." AND estado <> 'z' AND cant > 0 GROUP BY id_pres, precio ORDER BY fecha_pedido DESC")
                ->fetchAll(PDO::FETCH_OBJ);
            foreach($c->Detalle as $k => $d)
            {
                $c->Detalle[$k]->{'Producto'} = $this->db->query("SELECT pro_nom,pro_pre FROM v_productos WHERE id_pres = " . $d->id_pres)
                    ->fetch(PDO::FETCH_OBJ);
            }
            return $c;
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function listarUpdatePedidos($data)
    {
        try
        {   
            date_default_timezone_set($_SESSION["zona_horaria"]);
            setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
            $fecha = date("Y-m-d H:i:s");

            $stm = $this->db->prepare("SELECT p.pro_nom AS producto, p.pro_pre AS presentacion, SUM(d.cant) AS cantidad, d.precio, d.comentario, a.id_areap, i.nombre AS nombre_imp FROM tm_detalle_pedido AS d INNER JOIN v_productos AS p ON d.id_pres = p.id_pres INNER JOIN tm_area_prod AS a ON a.id_areap = p.id_areap INNER JOIN tm_impresora AS i ON i.id_imp = a.id_imp WHERE d.id_pedido = ? AND d.estado = 'y' AND d.cant > 0 GROUP BY d.id_pres ORDER BY d.fecha_pedido DESC");
            $stm->execute(array($data['id_pedido']));
            $c = $stm->fetchAll(PDO::FETCH_OBJ); 
    
            $sql2 = "UPDATE tm_detalle_pedido SET estado = 'a', fecha_pedido = ? WHERE id_pedido = ? AND estado = 'y'";
            $this->db->prepare($sql2)->execute(array($fecha,$data['id_pedido']));

            if($data['estado_pedido'] == 'a'){

                $sql3 = "UPDATE tm_pedido SET id_apc = ?, id_usu = ?, estado = 'b' WHERE id_pedido = ?";
                $this->db->prepare($sql3)->execute(array(Session::get('apcid'),Session::get('usuid'),$data['id_pedido']));

                $sql4 = "UPDATE tm_pedido_delivery SET fecha_preparacion = ? WHERE id_pedido = ?";
                $this->db->prepare($sql4)->execute(array($fecha,$data['id_pedido']));
                /*
                UPDATE tm_pedido SET id_apc = _id_apc, id_usu = _id_usu, estado = 'b' WHERE id_pedido = _id_pedido;
                UPDATE tm_pedido_delivery SET fecha_preparacion = _fecha_venta WHERE id_pedido = _id_pedido;
                */
            }

            return $c;
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function listarPedidosTicket($data)
    {
        try
        {   
            date_default_timezone_set($_SESSION["zona_horaria"]);
            setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
            $fecha = date("Y-m-d H:i:s");

            $stm = $this->db->prepare("SELECT p.pro_nom AS producto, p.pro_pre AS presentacion, SUM(d.cant) AS cantidad, d.precio, d.comentario, 1 AS id_areap, 'CAJA' AS nombre_imp FROM tm_detalle_pedido AS d INNER JOIN v_productos AS p ON d.id_pres = p.id_pres WHERE d.id_pedido = ? AND d.estado = 'a' AND d.cant > 0 GROUP BY d.id_pres ORDER BY d.fecha_pedido DESC");
            $stm->execute(array($data['id_pedido']));
            $c = $stm->fetchAll(PDO::FETCH_OBJ);
    
            return $c;
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function pedidoAccion($data)
    {
        try
        {
            date_default_timezone_set($_SESSION["zona_horaria"]);
            setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
            $fecha = date("Y-m-d H:i:s");

            if($data['cod_accion'] == 1){
                $estado = 'c';
                $tabla = 'tm_pedido_delivery';
                $fecha_campo = 'fecha_envio';
            }else if($data['cod_accion'] == 2){
                $estado = 'd';
                $tabla = 'tm_pedido_delivery';
                $fecha_campo = 'fecha_entrega';
            }else if($data['cod_accion'] == 3){
                $estado = 'd';
                $tabla = 'tm_pedido_llevar';
                $fecha_campo = 'fecha_entrega';
            }

            $sql = "UPDATE tm_pedido SET estado = '".$estado."' WHERE id_pedido = ?";
            $this->db->prepare($sql)->execute(array($data['id_pedido']));
            $sql2 = "UPDATE ".$tabla." SET ".$fecha_campo." = ? WHERE id_pedido = ?";
            $this->db->prepare($sql2)->execute(array($fecha,$data['id_pedido']));
            $sql3 = "UPDATE tm_venta SET codigo_operacion = ? WHERE id_pedido = ?";
            $this->db->prepare($sql3)->execute(array($data['codigo_operacion'],$data['id_pedido']));

        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }

    public function ComboMesaOri($data)
    {
        try
        {   
            $stmm = $this->db->prepare("SELECT * FROM tm_mesa WHERE id_salon = ? AND estado = 'i' ORDER BY nro_mesa ASC");
            $stmm->execute(array($data['cod_salon_origen']));
            $var = $stmm->fetchAll(PDO::FETCH_ASSOC);
            foreach($var as $v){
                echo '<option value="'.$v['id_mesa'].'">'.$v['nro_mesa'].'</option>';
            }
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function ComboMesaDes($data)
    {
        try
        {   
            $stmm = $this->db->prepare("SELECT * FROM tm_mesa WHERE id_salon = ? AND estado = ? ORDER BY nro_mesa ASC");
            $stmm->execute(array($data['cod_salon_destino'],$data['estado']));
            $var = $stmm->fetchAll(PDO::FETCH_ASSOC);
            foreach($var as $v){
                echo '<option value="'.$v['id_mesa'].'">'.$v['nro_mesa'].'</option>';
            }
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }
    
    public function CambiarMesa($data)
    {
        try
        {
            $consulta = "call usp_restOpcionesMesa( :flag, :cod_mesa_origen, :cod_mesa_destino);";
            $arrayParam =  array(
                ':flag' => 1,
                ':cod_mesa_origen' =>  $data['cod_mesa_origen_opc01'],
                ':cod_mesa_destino' => $data['cod_mesa_destino_opc01']
            );
            $st = $this->db->prepare($consulta);
            $st->execute($arrayParam);
            $row = $st->fetch(PDO::FETCH_ASSOC);
            return $row;
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }

    public function MoverPedidos($data)
    {
        try
        {
            $consulta = "call usp_restOpcionesMesa( :flag, :cod_mesa_origen, :cod_mesa_destino);";
            $arrayParam =  array(
                ':flag' => 2,
                ':cod_mesa_origen' =>  $data['cod_mesa_origen_opc02'],
                ':cod_mesa_destino' => $data['cod_mesa_destino_opc02']
            );
            $st = $this->db->prepare($consulta);
            $st->execute($arrayParam);
            $row = $st->fetch(PDO::FETCH_ASSOC);
            return $row;
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }

    public function subPedido($data)
    {
        try
        {   
            if($data['tipo_pedido'] == 1){ $tabla = 'v_pedido_mesa'; } elseif($data['tipo_pedido'] == 2) { $tabla = 'v_pedido_llevar'; } elseif($data['tipo_pedido'] == 3) { $tabla = 'v_pedido_delivery'; }
            $stm = $this->db->prepare("SELECT id_pedido, id_tipo_pedido, estado_pedido FROM ".$tabla." WHERE id_pedido = ?");
            $stm->execute(array($data['id_pedido']));
            $c = $stm->fetch(PDO::FETCH_OBJ);
            /* Traemos el detalle */
            $c->{'Detalle'} = $this->db->query("SELECT id_pres, cantidad, cant, precio, estado, fecha_pedido FROM tm_detalle_pedido WHERE id_pedido = ".$c->id_pedido." AND id_pres = ".$data['id_pres']." AND precio = ".$data['precio']." ORDER BY fecha_pedido DESC")
                ->fetchAll(PDO::FETCH_OBJ);
            foreach($c->Detalle as $k => $d)
            {
                $c->Detalle[$k]->{'Producto'} = $this->db->query("SELECT pro_nom,pro_pre FROM v_productos WHERE id_pres = " . $d->id_pres)
                    ->fetch(PDO::FETCH_OBJ);
            }
            return $c;
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function refrescar_mesas()
    {
        try {
            $stm = $this->db->prepare("UPDATE tm_mesa AS m INNER JOIN v_listar_mesas AS v ON m.id_mesa = v.id_mesa SET m.estado = 'a' WHERE v.estado <> 'a' AND v.estado <> 'm' AND v.id_pedido IS NULL");
            $stm->execute();
            $c = $stm->fetchAll(PDO::FETCH_OBJ);
            return $c;
        } catch (Exception $e) {
            return false;
        }
    }

    public function ValidarEstadoPedido($id_pedido)
    {
        try {
            $consulta = "SELECT count(*) AS cod, id_tipo_pedido AS tipo_pedido FROM tm_pedido WHERE id_pedido = :id_pedido AND (estado = 'a' OR estado = 'b' OR estado ='c')";
            $result = $this->db->prepare($consulta);
            $result->bindParam(':id_pedido',$id_pedido,PDO::PARAM_INT);
            $result->execute();
            $row = $result->fetch(PDO::FETCH_ASSOC);
            return $row;
        } catch (Exception $e) {
            return false;
        }
    }

    // public function ValidarEstadoPedido($id_pedido)
    // {
    //     try {
    //         $consulta = "SELECT count(*) AS cod, id_tipo_pedido AS tipo_pedido FROM tm_pedido WHERE id_pedido = :id_pedido AND (estado = 'a' OR estado = 'b' OR estado ='c')";
    //         $result = $this->db->prepare($consulta);
    //         $result->bindParam(':id_pedido',$id_pedido,PDO::PARAM_INT);
    //         $result->execute();
    //         $row = $result->fetch(PDO::FETCH_ASSOC);
    //         return $row;
    //     } catch (Exception $e) {
    //         return false;
    //     }
    // }



    public function pc1($data)
    {
        try
        {
            date_default_timezone_set($_SESSION["zona_horaria"]);
            setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
            $fecha = date("Y-m-d H:i:s");
            $id_usu = Session::get('usuid');
            if(Session::get('rol') == 5){ $id_mozo = $id_usu; } else { $id_mozo = $data['id_mozo']; };
            $consulta = "call usp_restRegMesa( :flag, :id_tipo_pedido, :id_apc, :id_usu, :fecha_pedido, :id_mesa, :id_mozo, :nomb_cliente, :nro_personas);";
            $arrayParam =  array(
                ':flag' => 1,
                ':id_tipo_pedido' => 1,
                ':id_apc' => Session::get('apcid'),
                ':id_usu' => $id_usu,
                ':fecha_pedido' => $fecha,
                ':id_mesa' => $data['id_mesa'],
                ':id_mozo' => $id_mozo,
                ':nomb_cliente' => $data['nomb_cliente'],
                ':nro_personas' => $data['nro_personas']
            );
            $st = $this->db->prepare($consulta);
            $st->execute($arrayParam);
            $row = $st->fetch(PDO::FETCH_ASSOC);
            return $row;
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }

    public function pc2($data)
    {
        try
        {
            date_default_timezone_set($_SESSION["zona_horaria"]);
            setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
            $fecha = date("Y-m-d H:i:s");
            $id_usu = Session::get('usuid');
            $consulta = "call usp_restRegMostrador( :flag, :id_tipo_pedido, :id_apc, :id_usu, :fecha_pedido, :nomb_cliente);";
            $arrayParam =  array(
                ':flag' => 1,
                ':id_tipo_pedido' => 2,
                ':id_apc' => Session::get('apcid'),
                ':id_usu' =>  $id_usu,
                ':fecha_pedido' => $fecha,
                ':nomb_cliente' => $data['nomb_cliente']
            );
            $st = $this->db->prepare($consulta);
            $st->execute($arrayParam);
            $row = $st->fetch(PDO::FETCH_ASSOC);
            return $row;
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }

    public function pc3($data)
    {
        try
        {
            date_default_timezone_set($_SESSION["zona_horaria"]);
            setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
            $fecha = date("Y-m-d H:i:s");
            $id_usu = Session::get('usuid');
            if($data['tipo_entrega'] == 1){ 
                $id_repartidor = $data['id_repartidor'];
                $direccion_cliente = $data['direccion_cliente'];
                $referencia_cliente = $data['referencia_cliente'];
            } else { 
                $id_repartidor = 1;
                $direccion_cliente = '';
                $referencia_cliente = '';
            };
            $consulta = "call usp_restRegDelivery( :flag, :tipo_canal, :id_tipo_pedido, :id_apc, :id_usu, :fecha_pedido, :id_cliente, :id_repartidor, :tipo_entrega, :tipo_pago, :pedido_programado, :hora_entrega, :nombre_cliente, :telefono_cliente, :direccion_cliente, :referencia_cliente, :email_cliente);";
            $arrayParam =  array(
                ':flag' => 1,
                ':tipo_canal' => 1,
                ':id_tipo_pedido' => 3,
                ':id_apc' => Session::get('apcid'),
                ':id_usu' =>  $id_usu,
                ':fecha_pedido' => $fecha,
                ':id_cliente' => $data['cliente_id'],
                ':id_repartidor' => $id_repartidor,
                ':tipo_entrega' => $data['tipo_entrega'],
                ':tipo_pago' => 1,
                ':pedido_programado' => $data['pedido_programado'],
                ':hora_entrega' => $data['hora_entrega'],
                ':nombre_cliente' => $data['nomb_cliente'],
                ':telefono_cliente' => $data['telefono_cliente'],
                ':direccion_cliente' => $direccion_cliente,
                ':referencia_cliente' => $referencia_cliente,
                ':email_cliente' => 'example@email.com'
            );
            $st = $this->db->prepare($consulta);
            $st->execute($arrayParam);
            $row = $st->fetch(PDO::FETCH_ASSOC);
            return $row;
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }

    public function defaultdata($data)
    {
        try
        {   
            if($data['tipo_pedido'] == 1){ $tabla = 'v_pedido_mesa'; } elseif($data['tipo_pedido'] == 2) { $tabla = 'v_pedido_llevar'; } elseif($data['tipo_pedido'] == 3) { $tabla = 'v_pedido_delivery'; }
            $stm = $this->db->prepare("SELECT * FROM ".$tabla." WHERE id_pedido = ?");
            $stm->execute(array($data['id_pedido']));
            $c = $stm->fetch(PDO::FETCH_OBJ);
            /* Traemos el detalle */
            $c->{'Detalle'} = $this->db->query("SELECT SUM(cantidad) AS cantidad, precio, comentario, estado FROM tm_detalle_pedido WHERE id_pedido = ".$c->id_pedido." AND estado <> 'z' GROUP BY id_pres,precio ORDER BY fecha_pedido DESC")
                ->fetchAll(PDO::FETCH_OBJ);
            return $c;
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function listarCategorias($data)
    {
        try
        {   
            if ($data['codtipoped'] == 3){
                $variable = ' ORDER BY orden ASC';
                //$variable = 'AND delivery = 1';
            } else {
                $variable = ' ORDER BY orden ASC';
            }
            $stm = $this->db->prepare("SELECT * FROM tm_producto_catg WHERE estado = 'a' ".$variable);
            $stm->execute();
            $c = $stm->fetchAll(PDO::FETCH_OBJ);
            return $c;
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }
    
    public function listarProductos($data)
    {
        try
        {   
            if ($data['codtipoped'] == 3){
                if($data['codrepartidor'] == 1){
                    $campo = ',pro_cos';
                    $variable = '';
                } else{
                    $campo = ',pro_cos_del AS pro_cos';
                    $variable = ' AND pro_cos_del > 0';
                }
            } else {
                $campo = ',pro_cos';
                $variable = '';
            }
            $stm = $this->db->prepare("SELECT id_areap,id_pres,pro_nom,pro_pre".$campo.",pro_img FROM v_productos WHERE id_catg = ? AND est_a = 'a'  AND est_b = 'a' AND est_c = 'a' ".$variable);
            $stm->execute(array($data['id_catg']));
            $c = $stm->fetchAll(PDO::FETCH_OBJ);
            foreach($c as $k => $d)
            {
                $c[$k]->{'Impresora'} = $this->db->query("SELECT i.nombre FROM tm_area_prod AS ap INNER JOIN tm_impresora AS i ON ap.id_imp = i.id_imp WHERE ap.id_areap = " . $d->id_areap)
                ->fetch(PDO::FETCH_OBJ);

                $c[$k]->{'Stock'} = $this->db->query("SELECT * FROM v_stock_pedido WHERE id_ins =" . $d->id_pres)
                ->fetch(PDO::FETCH_OBJ);
            }
            return $c;
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function listarProdsMasVend($data)
    {
        try
        {   
            if ($data['codtipoped'] == 3){
                if($data['codrepartidor'] == 1){
                    $campo = ',p.pro_cos';
                    $variable = 'GROUP BY dv.id_prod ORDER BY SUM(cantidad) DESC';
                } else{
                    $campo = ',p.pro_cos_del AS pro_cos';
                    $variable = ' AND p.pro_cos_del > 0 GROUP BY dv.id_prod ORDER BY SUM(cantidad) DESC';
                }
            } else {
                $campo = ',p.pro_cos';
                $variable = 'GROUP BY dv.id_prod ORDER BY SUM(cantidad) DESC';
            }
            $stm = $this->db->prepare("SELECT p.id_areap,p.id_pres,p.pro_nom,p.pro_pre".$campo.",p.pro_img FROM tm_detalle_venta AS dv INNER JOIN v_productos AS p ON dv.id_prod = p.id_pres WHERE p.est_a = 'a' AND p.est_b = 'a' AND p.est_c = 'a' ".$variable);
            $stm->execute();
            $c = $stm->fetchAll(PDO::FETCH_OBJ);
            foreach($c as $k => $d)
            {
                $c[$k]->{'Impresora'} = $this->db->query("SELECT i.nombre FROM tm_area_prod AS ap INNER JOIN tm_impresora AS i ON ap.id_imp = i.id_imp WHERE ap.id_areap = " . $d->id_areap)
                ->fetch(PDO::FETCH_OBJ);

                $c[$k]->{'Stock'} = $this->db->query("SELECT * FROM v_stock_pedido WHERE id_ins =" . $d->id_pres)
                ->fetch(PDO::FETCH_OBJ);
            }
            return $c;
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function RegistrarPedido($data)
{
    try 
    {
        date_default_timezone_set($_SESSION["zona_horaria"]);
        setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
        $fecha = date("Y-m-d H:i:s");
        $id_usu = Session::get('usuid');
        
        if ($data['codtipoped'] == 3) { 
            $estado = 'y';
        } else {
            $estado = 'a';
        } 
        
        foreach ($data['items'] as $d) {
            $sql = "INSERT INTO tm_detalle_pedido (id_pedido, id_usu, id_pres, cantidad, cant, precio, comentario, fecha_pedido, estado) VALUES (?,?,?,?,?,?,?,?,?);";
            
            // Imprimir la consulta SQL para verificación
            //error_log('Consulta SQL: ' . $sql);
            
            if ($this->pedidoStock($d['producto_id'])) {
                $dato = [
                    "id_pres" => $d['producto_id'],
                    "cant" => $d['cantidad'],
                    "estado" => $estado
                ];
                $consultar = $this->saveStockPedido($dato);
            }
            

            $this->db->prepare($sql)->execute(array($data['cod_ped'], $id_usu, $d['producto_id'], $d['cantidad'], $d['cantidad'], $d['precio'], $d['comentario'], $fecha, $estado));
        }
        
        // Devolver un mensaje de éxito
        return true;
    }
    catch (Exception $e) 
    {
        // Imprimir detalles del error en el log del servidor
        error_log('Error en la función RegistrarPedido: ' . $e->getMessage());
        
        // Devolver un mensaje de error
        return false;
    }
}

    public function buscar_producto($data)
    {
        try
        {   
            if ($data['codtipoped'] == 3){
                if($data['codrepartidor'] == 1){
                    $campo = ',pro_cos';
                } else{
                    $campo = ',pro_cos_del AS pro_cos';
                }
                $variable = 'AND del_a = 1 AND del_b = 1 AND del_c = 1';
            } else {
                $variable = '';
                $campo = ',pro_cos';
            }
            $cadena = $data['cadena'];
            $stm = $this->db->prepare("SELECT id_areap,id_pres,pro_nom,pro_pre".$campo.",pro_img FROM v_productos WHERE (pro_cod LIKE '%$cadena%' OR pro_nom LIKE '%$cadena%' OR pro_cat LIKE '%$cadena%') AND est_a = 'a' AND est_b = 'a' AND est_c = 'a' ".$variable);
            $stm->execute();
            $c = $stm->fetchAll(PDO::FETCH_OBJ);
            foreach($c as $k => $d)
            {
                $c[$k]->{'Impresora'} = $this->db->query("SELECT i.nombre FROM tm_area_prod AS ap INNER JOIN tm_impresora AS i ON ap.id_imp = i.id_imp WHERE ap.id_areap = " . $d->id_areap)
                ->fetch(PDO::FETCH_OBJ);

                $c[$k]->{'Stock'} = $this->db->query("SELECT * FROM v_stock_pedido WHERE id_ins =" . $d->id_pres)
                ->fetch(PDO::FETCH_OBJ);
            }
            return $c;
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function ListarDetallePed($data)
    {
        try
        {   
            if($data['tipo_pedido'] == 1){ $tabla = 'v_pedido_mesa'; } elseif($data['tipo_pedido'] == 2) { $tabla = 'v_pedido_llevar'; } elseif($data['tipo_pedido'] == 3) { $tabla = 'v_pedido_delivery'; }
            $stm = $this->db->prepare("SELECT id_pedido FROM ".$tabla." WHERE id_pedido = ?");
            $stm->execute(array($data['id_pedido']));
            $c = $stm->fetch(PDO::FETCH_OBJ);
            /* Traemos el detalle */
            $c->{'Detalle'} = $this->db->query("SELECT id_pres,SUM(cantidad) AS cantidad, precio, estado FROM tm_detalle_pedido WHERE id_pedido = " . $c->id_pedido." AND estado <> 'z' GROUP BY id_pres, precio")
                ->fetchAll(PDO::FETCH_OBJ);
            foreach($c->Detalle as $k => $d)
            {
                $c->Detalle[$k]->{'Producto'} = $this->db->query("SELECT pro_nom, pro_pre FROM v_productos WHERE id_pres = " . $d->id_pres)
                    ->fetch(PDO::FETCH_OBJ);
            }
            return $c;
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function cliente_crud_create($data)
    {
        try 
        {
            $consulta = "call usp_restRegCliente( :flag, @a, :tipo_cliente, :dni, :ruc, :nombres, :razon_social, :telefono, :fecha_nac, :correo, :direccion, :referencia);";
                $arrayParam =  array(
                    ':flag' => 1,
                    ':tipo_cliente' => $data['tipo_cliente'],
                    ':dni' => $data['dni'],
                    ':ruc' => $data['ruc'],
                    ':nombres' => $data['nombres'],
                    ':razon_social' => $data['razon_social'],
                    ':telefono' => $data['telefono'],
                    ':fecha_nac' => date('Y-m-d',strtotime($data['fecha_nac'])),
                    ':correo' => $data['correo'],
                    ':direccion' => $data['direccion'],
                    ':referencia' => $data['referencia']
                  );
                $st = $this->db->prepare($consulta);
                $st->execute($arrayParam);
                $c = $st->fetch(PDO::FETCH_OBJ);
                return $c;
            } catch (Exception $e) 
            {
                die($e->getMessage());
            }
    }

    public function cliente_crud_update($data)
    {
        try 
        {
            $consulta = "call usp_restRegCliente( :flag, :id_cliente, :tipo_cliente, :dni, :ruc, :nombres, :razon_social, :telefono, :fecha_nac, :correo, :direccion, :referencia);";
                $arrayParam =  array(
                    ':flag' => 2,
                    ':id_cliente' => $data['id_cliente'],
                    ':tipo_cliente' => $data['tipo_cliente'],
                    ':dni' => $data['dni'],
                    ':ruc' => $data['ruc'],
                    ':nombres' => $data['nombres'],
                    ':razon_social' => $data['razon_social'],
                    ':telefono' => $data['telefono'],
                    ':fecha_nac' => date('Y-m-d',strtotime($data['fecha_nac'])),
                    ':correo' => $data['correo'],
                    ':direccion' => $data['direccion'],
                    ':referencia' => $data['referencia']
                );
            $st = $this->db->prepare($consulta);
            $st->execute($arrayParam);
            $c = $st->fetch(PDO::FETCH_OBJ);
            return $c;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function buscar_cliente($data)
    {
        try
        {        
            /*nota: para kerlyn quitar el tipo_cliente de la consulta*/
            if($data['tipo_cliente'] == 1 || $data['tipo_cliente'] == 2){
                $stm = $this->db->prepare("SELECT * FROM v_clientes WHERE tipo_cliente = ".$data['tipo_cliente']." AND estado != 'i' AND (dni LIKE '%".$data['cadena']."%' OR ruc LIKE '%".$data['cadena']."%' OR nombre LIKE '%".$data['cadena']."%') ORDER BY dni LIMIT 5");
            } else {
                $stm = $this->db->prepare("SELECT * FROM v_clientes WHERE estado != 'i' AND (dni LIKE '%".$data['cadena']."%' OR ruc LIKE '%".$data['cadena']."%' OR nombre LIKE '%".$data['cadena']."%') ORDER BY dni LIMIT 5");
            }
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ); 
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function buscar_cliente_telefono($data)
    {
        try
        {        
            /*nota: para kerlyn quitar el tipo_cliente de la consulta*/
            $stm = $this->db->prepare("SELECT * FROM v_clientes WHERE estado <> 'i' AND (dni LIKE '%".$data['cadena']."%' OR ruc LIKE '%".$data['cadena']."%' OR nombre LIKE '%".$data['cadena']."%' OR telefono LIKE '%".$data['cadena']."%') ORDER BY dni LIMIT 5");
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ); 
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    /*
    public function buscar_cliente_telefono($data)
    {
        try
        {   
            

            $stm = $this->db->prepare("SELECT p.id_pedido, pd.telefono_cliente, pd.nombre_cliente, pd.direccion_cliente, pd.referencia_cliente FROM tm_pedido_delivery AS pd INNER JOIN tm_pedido AS p ON pd.id_pedido = p.id_pedido WHERE pd.telefono_cliente LIKE '%".$data['cadena']."%' AND pd.id_pedido = (SELECT MAX(id_pedido) FROM tm_pedido_delivery WHERE telefono_cliente LIKE '%".$data['cadena']."%') GROUP BY pd.telefono_cliente LIMIT 5");
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ); 
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }
    */

    public function tags_list($data)
    {
        try
        {        
            $stm = $this->db->prepare("SELECT p.id_prod,p.notas FROM tm_producto AS p INNER JOIN tm_producto_pres AS pp ON p.id_prod = pp.id_prod WHERE pp.id_pres = ?");
            $stm->execute(array($data['id_pres']));
            return $stm->fetch(PDO::FETCH_OBJ); 
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function tags_crud($data)
    {
        try 
        {
            $sql = "UPDATE tm_producto SET notas = ? WHERE id_prod = ?";
            $this->db->prepare($sql)->execute(array($data['notas'],$data['id_prod']));
        }
        catch (Exception $e) 
        {
            return false;
        }
    }

	public function generarCodigo($longitud) {
	    $key = '';
	    $pattern = '1234567890';
	    $max = strlen($pattern)-1;
	    for($i=0;$i < $longitud;$i++){
			$key .= $pattern[mt_rand(0,$max)];
			}
	    return $key;
	}
	
    public function RegistrarVenta($data)
    {
		$new = new Venta_Model;
        try
        {
            if($data['descuento_personal'] == NULL OR $data['descuento_personal'] == '')
            {
                $descuento_personal = 0;
            }
            date_default_timezone_set($_SESSION["zona_horaria"]);
            setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
            $fecha = date("Y-m-d H:i:s");

            $conteo = $this->db->query("SELECT COUNT(*) as conteo FROM tm_detalle_pedido WHERE id_pedido = ".$data['id_pedido'])->fetch(PDO::FETCH_OBJ);

            if( ($conteo->conteo > 0) &&  $data['total'] > 0){    
                $consulta = "call usp_restEmitirVenta(:flag, :dividir_cuenta, :id_pedido, :tipo_pedido, :tipo_entrega, :id_cliente, :id_tipo_doc, :id_tipo_pago, :id_usu, :id_apc, :pago_efe_none, :pago_tar, :descuento_tipo, :descuento_personal, :descuento_monto, :descuento_motivo, :comision_tarjeta, :comision_delivery, :igv, :total, :codigo_operacion, :fecha_venta);";
                $arrayParam = array(
                    ':flag' => 1,
                    ':dividir_cuenta' =>  $data['dividir_cuenta'],
                    ':id_pedido' =>  $data['id_pedido'],
                    ':tipo_pedido' =>  $data['tipo_pedido'],
                    ':tipo_entrega' =>  $data['tipo_entrega'],
                    ':id_cliente' =>  $data['cliente_id'],
                    ':id_tipo_doc' =>  $data['tipo_doc'],
                    ':id_tipo_pago' =>  $data['tipo_pago'],
                    ':id_usu' =>  Session::get('usuid'),
                    ':id_apc' =>  Session::get('apcid'),
                    ':pago_efe_none' => $data['pago_efe'],
                    ':pago_tar' => $data['pago_tar'],
                    ':descuento_tipo' => $data['descuento_tipo'],
                    ':descuento_personal' => $descuento_personal,
                    ':descuento_monto' => $data['descuento_monto'],
                    ':descuento_motivo' => $data['descuento_motivo'],
                    ':comision_tarjeta' => $data['comision_tarjeta'],
                    ':comision_delivery' => $data['comision_delivery'],
                    ':igv' => Session::get('igv'),
                    ':total' =>  $data['total'],
                    ':codigo_operacion' =>  $data['codigo_operacion'],
                    ':fecha_venta' =>  $fecha
                );
                $st = $this->db->prepare($consulta);
                $st->execute($arrayParam);

                while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
                    $id_venta = $row['id_venta'];
                }
				//inicio seccion totales api facturador pro
				if(Session::get('f_pro') == 3){
					//$orden_compra = "012388373";
                    $tipo_comprobante = null;
                    $codigo_documento = null;
                    $serie_documento = null;
                    $cliente_prepare = null;
                    $cliente_resultado = [];
                    $datos_cliente = [];
                    
				$orden_compra = $new->generarCodigo(10);
				if($data['tipo_doc'] == 1){
					$cliente_prepare = preg_replace('/DNI: /m',"", $data['cliente']);
					$tipo_comprobante = "03";
					$codigo_documento = 1;
					$serie_documento = "B001";
                    $cliente_resultado = explode(" | ",$cliente_prepare);
					}
				if($data['tipo_doc'] == 2){
					$cliente_prepare = preg_replace('/RUC: /m',"", $data['cliente']);
					$tipo_comprobante = "01";
					$codigo_documento = 6;
					$serie_documento = "F001";
                    $cliente_resultado = explode(" | ",$cliente_prepare);
					}
				
                    if (isset($cliente_resultado[0]) && isset($cliente_resultado[1]) && isset($cliente_resultado[2]) && isset($cliente_resultado[3])) {
                        $datos_cliente = array(
                            "codigo_tipo_documento_identidad" => $codigo_documento,
                            "numero_documento" => $cliente_resultado[0],
                            "apellidos_y_nombres_o_razon_social" => $cliente_resultado[1],
                            "codigo_pais" => "PE",
                            "direccion" => $cliente_resultado[3],
                            "correo_electronico" => "correo@gmail.com",
                            "telefono" => $cliente_resultado[2]
                        );
                    }
				
				$datos_coprobante = array(
								"serie_documento" => $serie_documento,
								"numero_documento" => "#",
								"fecha_de_emision" => date("Y-m-d"),
								"hora_de_emision" => date("H:i:s"),
								"codigo_tipo_operacion" => "0101",
								"codigo_tipo_documento" => $tipo_comprobante,
								"codigo_tipo_moneda" => "PEN",
								"fecha_de_vencimiento" => date("Y-m-d"),
								"numero_orden_de_compra" => $orden_compra,
								"datos_del_cliente_o_receptor" => $datos_cliente);

				$igv_dec = Session::get('igv')/100;
				$total_subtotal = number_format($data['total']/($igv_dec+1),2,'.','');
				$total_impuesto = $data['total']-$total_subtotal;
				
				$totales = array(
                    "total_operaciones_gravadas" => (Session::get('type_operation') == 2) ? 0.00 : $total_subtotal,
                    "total_operaciones_exoneradas" => (Session::get('type_operation') == 2) ? $data['total'] : 0.00,
                    "total_igv" => (Session::get('type_operation') == 2) ? 0.00 : $total_impuesto,
                    "total_impuestos" => (Session::get('type_operation') == 2) ? 0.00 : $total_impuesto,
                    "total_valor" => (Session::get('type_operation') == 2) ? $data['total'] : $total_subtotal,
                    "total_venta" => $data['total']
                );
                if($data['descuento_monto'] > 0) {
                    $totales["total_descuentos"] = number_format($data['descuento_monto'],2,'.','');
                    $new_total = number_format($totales["total_venta"] - $data['descuento_monto'],2,'.','');
                    $totales["total_venta"] = $new_total;
                }
				}

                $this->db = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS, DB_CHARSET);
                $a = $data['idProd'];
                $b = $data['cantProd'];
                $c = $data['precProd'];
				$d = $data['nameProd'];
				
				
                $count = count($a);

                for ($x = 0; $x < $count; ++$x) {
                    if ($b[$x] > 0) {
                    $sql = "INSERT INTO tm_detalle_venta (id_venta,id_prod,cantidad,precio) VALUES (?,?,?,?);";
                    $this->db->prepare($sql)->execute(array($id_venta, $a[$x], $b[$x], $c[$x]));

                    // Inicio sección items api facturador pro
                        if (Session::get('f_pro') == 3) {
                            $total_c_igv = $b[$x] * $c[$x];
                            $igv = $igv_dec * 100;
                            $total_no_igv = number_format($total_c_igv / ($igv_dec + 1), 2, '.', '');
                            $impuesto = number_format($total_c_igv - $total_no_igv, 2, '.', '');
                            $valor_unitario = number_format($total_no_igv / $b[$x], 2, '.', '');

                            $item = array(
                                "codigo_interno" => $a[$x],
                                "descripcion" => $d[$x],
                                "unidad_de_medida" => "NIU",
                                "cantidad" => $b[$x],
                                "valor_unitario" => (Session::get('type_operation') == 2) ? $total_c_igv / $b[$x] : $valor_unitario,
                                "codigo_tipo_precio" => "01",
                                "precio_unitario" => $total_c_igv / $b[$x],
                                "codigo_tipo_afectacion_igv" => (Session::get('type_operation') == 2) ? "20" : "10",
                                "total_base_igv" => (Session::get('type_operation') == 2) ? $total_c_igv : $total_no_igv,
                                "porcentaje_igv" => $igv,
                                "total_igv" => (Session::get('type_operation') == 2) ? 0.00 : $impuesto,
                                "total_impuestos" => (Session::get('type_operation') == 2) ? 0.00 : $impuesto,
                                "total_valor_item" => (Session::get('type_operation') == 2) ? $total_c_igv : $total_no_igv,
                                "total_item" => $total_c_igv
                            );

                            $items[] = $item;
                        }
                    // Fin sección items api facturador pro
                    }
                }

				if((Session::get('f_pro') == 3) && ($data['tipo_doc'] != 3)){
          
					$api_url = Session::get('api_url_pro');
					$api_token = Session::get('api_token_pro');
					$versiones = $datos_coprobante + array("totales" => $totales,"items" => $items);
					$mijson = json_encode($versiones);
					$curl = curl_init();
					curl_setopt_array($curl, array(
					CURLOPT_URL => $api_url.'/api/documents',
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_ENCODING => '',
					CURLOPT_MAXREDIRS => 10,
					CURLOPT_TIMEOUT => 0,
					CURLOPT_FOLLOWLOCATION => true,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_SSL_VERIFYPEER => false,
					CURLOPT_CUSTOMREQUEST => 'POST',
					CURLOPT_POSTFIELDS =>$mijson,
					CURLOPT_HTTPHEADER => array(
										'Content-Type: application/json',
										'Authorization: Bearer '.$api_token
										),
					));

					$response = json_decode(curl_exec($curl));

					curl_close($curl);   
                    //print_r ($response->data->hash);
                    $response_send = [
                        'code_respuesta_sunat' => $response->data->state_type_id,
                        'name_file_sunat' => $response->data->filename,
                        'hash_cpe' => ($response->data->hash !== null) ? $response->data->hash : 0,
                        'external_id' => $response->data->external_id
                    ];
                    //guardando qr
                    $imagenBinaria = base64_decode($response->data->qr);
                    $nombreArchivo = $response->data->filename . ".png";
                    $rutaDirectorio = "public/qr/";

                    if (!file_exists($rutaDirectorio) && !is_dir($rutaDirectorio)) {
                        mkdir($rutaDirectorio, 0777, true);
                    }
                    
                    // Comprobar nuevamente si el directorio existe antes de intentar guardar la imagen
                    if (file_exists($rutaDirectorio) && is_dir($rutaDirectorio)) {
                        $rutaCompleta = $rutaDirectorio . $nombreArchivo;
                        file_put_contents($rutaCompleta, $imagenBinaria);
                    }

                    $this->db->update('tm_venta', $response_send, 'id_venta = '.$id_venta);
				}
				
				
                $this->db = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS, DB_CHARSET);
                $cons = "call usp_restEmitirVentaDet( :flag, :id_venta, :id_pedido, :fecha );";
                $arrayParam = array(
                    ':flag' => 1,
                    ':id_venta' =>  $id_venta,
                    ':id_pedido' =>  $data['id_pedido'],
                    ':fecha' =>  $fecha
                );
                $stm = $this->db->prepare($cons);
                $stm->execute($arrayParam);

                return $id_venta;
                //return $update;
				//return $items;
            }else{
                return 'error';
            }

        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }

    public function anular_pedido($data)
    {
        try
        {
            if($data['tipo_pedido'] == 1){

                $consulta = "call usp_restDesocuparMesa( :flag, :id_pedido);";
                $arrayParam =  array(
                    ':flag' => 1,
                    ':id_pedido' =>  $data['id_pedido']
                );
                $st = $this->db->prepare($consulta);
                $st->execute($arrayParam);

            } elseif($data['tipo_pedido'] == 2 OR $data['tipo_pedido'] == 3){
                
                $sql = "UPDATE tm_pedido SET estado = 'z' WHERE id_pedido = ?";
                $this->db->prepare($sql)->execute(array($data['id_pedido']));

            }
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }

    public function anular_venta($data)
    {
        try
        {   
            $sql1 = "UPDATE tm_inventario SET estado = 'i' WHERE id_tipo_ope = 2 AND id_ope = ?";
            $this->db->prepare($sql1)->execute(array($data['id_venta']));
            $sql2 = "UPDATE tm_venta SET estado = 'i' WHERE id_venta = ?";
            $this->db->prepare($sql2)->execute(array($data['id_venta']));
            $sql3 = "UPDATE tm_pedido SET estado = 'z' WHERE id_pedido = ?";
            $this->db->prepare($sql3)->execute(array($data['id_pedido']));
        } 
            catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }

    public function pedido_edit($data)
    {
        try 
        {
            $stm = $this->db->prepare("SELECT * FROM tm_pedido_delivery WHERE id_pedido = ?");
            $stm->execute(array($data['id_pedido']));
            $c = $stm->fetchAll(PDO::FETCH_OBJ);
            $data = array("data" => $c);
            $json = json_encode($data);
            echo $json;
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }

    public function pedido_delete($data)
    {
        try 
        {
            //Seleccionar producto
            $stm = $this->db->prepare("SELECT p.pro_nom AS producto, p.pro_pre AS presentacion, d.cant AS cantidad, d.precio, d.comentario, i.nombre AS nombre_imp FROM tm_detalle_pedido AS d INNER JOIN v_productos AS p ON d.id_pres = p.id_pres INNER JOIN tm_area_prod AS a ON a.id_areap = p.id_areap INNER JOIN tm_impresora AS i ON i.id_imp = a.id_imp WHERE d.id_pedido = ? AND d.id_pres = ? AND d.estado <> 'z' AND d.cant > 0 GROUP BY d.id_pres ORDER BY d.fecha_pedido DESC");
            $stm->execute(array($data['id_pedido'],$data['id_pres']));
            $data_producto = $stm->fetchAll(PDO::FETCH_OBJ);

            //Cancelar pedido
            date_default_timezone_set($_SESSION["zona_horaria"]);
            setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
            // $filtro_seguridad = '9'.date('dm').'20';
            $filtro_seguridad = Session::get('cod_seg');
            $fecha_envio = date("Y-m-d H:i:s");
            $consulta = "call usp_restCancelarPedido( :flag, :id_usu, :id_pres, :id_pedido, :estado_pedido, :fecha_pedido, :fecha_envio, :codigo_seguridad, :filtro_seguridad);";
            $arrayParam =  array(
                ':flag' => 1,
                ':id_usu' => Session::get('usuid'),
                ':id_pres' => $data['id_pres'],
                ':id_pedido' =>  $data['id_pedido'],
                ':estado_pedido' =>  $data['estado_pedido'],
                ':fecha_pedido' => $data['fecha_pedido'],
                ':fecha_envio' => $fecha_envio,
                ':codigo_seguridad' => $data['codigo_seguridad'],
                ':filtro_seguridad' => $filtro_seguridad
            );
            $st = $this->db->prepare($consulta);
            $st->execute($arrayParam);
            $codigo_respuesta = $st->fetchAll(PDO::FETCH_OBJ);

            $datos = array("Producto" => $data_producto,"Codigo" => $codigo_respuesta);
            $c = json_encode($datos);
            echo $c;

        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }

    public function pedido_crud_update($data)
    {
        try 
        {
            $sql = "UPDATE tm_pedido_delivery SET id_repartidor = ?, hora_entrega = ?, amortizacion = ?, tipo_pago = ?, paga_con = ?, comision_delivery = ? WHERE id_pedido = ?";
            $this->db->prepare($sql)->execute(array($data['id_repartidor'],$data['hora_entrega'],$data['amortizacion'],
                $data['tipo_pago'],$data['paga_con'],$data['comision_delivery'],$data['id_pedido']));
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }

    public function venta_edit($data)
    {
        try 
        {
            $stm = $this->db->prepare("SELECT id_tipo_pago,id_pedido,id_venta FROM tm_venta WHERE id_venta = ?");
            $stm->execute(array($data['id_venta']));
            $c = $stm->fetchAll(PDO::FETCH_OBJ);
            $data = array("data" => $c);
            $json = json_encode($data);
            echo $json;
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }

    public function venta_edit_pago($data)
    {
        try 
        {
            if($data['tipo_pago'] <> $data['id_tipo_pago']){
                if($data['tipo_pago'] == 1){
                    $sql = "UPDATE tm_venta SET id_tipo_pago = ?, pago_tar = pago_efe, pago_efe = '0.00' WHERE id_venta = ?";
                    $this->db->prepare($sql)->execute(array($data['id_tipo_pago'],$data['id_venta']));
                } else {

                    if($data['id_tipo_pago'] == 1){
                        $sql = "UPDATE tm_venta SET id_tipo_pago = ?, pago_efe = pago_tar, pago_tar = '0.00' WHERE id_venta = ?";
                        $this->db->prepare($sql)->execute(array($data['id_tipo_pago'],$data['id_venta']));
                    } else {
                        $sql = "UPDATE tm_venta SET id_tipo_pago = ? WHERE id_venta = ?";
                        $this->db->prepare($sql)->execute(array($data['id_tipo_pago'],$data['id_venta']));
                    }
                }
            }
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }

    public function venta_edit_documento($data)
    {
        try 
        {
            $consulta = "call usp_restEditarVentaDocumento( :flag, :id_venta, :id_cliente, :id_tipo_documento);";
            $arrayParam =  array(
                ':flag' => 1,
                ':id_venta' =>  $data['id_venta'],
                ':id_cliente' => $data['id_cliente'],
                ':id_tipo_documento' => $data['id_tipo_documento']
            );
            $st = $this->db->prepare($consulta);
            $st->execute($arrayParam);
            $row = $st->fetch(PDO::FETCH_ASSOC);
            return $row;
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }

    /* INICIO COMPROBANTE SIN ENVIAR SUNAT */

    public function contadorSunatSinEnviar()
    {
        try
        {   
            $ds = $this->db->prepare("SELECT bloqueo FROM tm_configuracion");
			$ds->execute();
			$data_s = $ds->fetch();

            if(Session::get('rol') == 1){
				Session::set('bloqueo', '0');
				Session::set('bloqueo_id', $data_s['bloqueo']);
                $status = '';
			}else{
				Session::set('bloqueo', $data_s['bloqueo']); 
				Session::set('bloqueo_id', $data_s['bloqueo']); 
                $status = 'bloqueo';
			}            
        
            $stm = $this->db->prepare("SELECT COUNT(v.id_ven) AS total FROM v_ventas_con AS v INNER JOIN v_caja_aper AS c ON v.id_apc = c.id_apc INNER JOIN tm_tipo_doc AS d ON v.id_tdoc = d.id_tipo_doc WHERE v.ser_doc = d.serie AND v.id_tdoc <> 3 AND v.estado = 'a' AND (v.enviado_sunat = '' OR v.enviado_sunat = '0' OR v.enviado_sunat IS NULL)");
            $stm->execute();        
            $c = $stm->fetch(PDO::FETCH_OBJ);

            if($data_s['bloqueo'] == 0 ){
                $c->{'status'} = '';
            }else{
                $c->{'status'} = $status;
            }  
            return $c;
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    /* FIN COMPROBANTE SIN ENVIAR SUNAT */

    /* INICIO PEDIDOS PREPARADOS */

    public function contadorPedidosPreparados()
{
    try {
        $rol = Session::get('rol');
        $usuid = Session::get('usuid');

        $sql = "SELECT COUNT(id_pedido) AS cantidad FROM v_cocina_me WHERE id_tipo = 1 AND cantidad > 0 AND estado = 'c'";

        if ($rol == 1 || $rol == 2 || $rol == 3) {
            // Admin, Gerente o Supervisor
            $stm = $this->db->prepare($sql);
        } elseif ($rol == 5) {
            // Mozo
            $sql .= " AND id_mozo = ?";
            $stm = $this->db->prepare($sql);
            $stm->execute([$usuid]);
        }

        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_OBJ);

        return $result;
    } catch (Exception $e) {
        die($e->getMessage());
    }
}

    public function listarPedidosPreparados()
    {
        try
        {      
            if(Session::get('rol') == 1 OR Session::get('rol') == 2 OR Session::get('rol') == 3){
                $stm = $this->db->prepare("SELECT * FROM v_cocina_me WHERE id_tipo = 1 AND cantidad > 0 AND estado = 'c'");
                $stm->execute();   
            } elseif(Session::get('rol') == 5){
                $stm = $this->db->prepare("SELECT * FROM v_cocina_me WHERE id_tipo = 1 AND id_mozo = ? AND cantidad > 0 AND estado = 'c'");
                $stm->execute(array(Session::get('usuid')));   
            } 
            $c = $stm->fetchAll(PDO::FETCH_OBJ);
            $data = array("data" => $c);
            $json = json_encode($data);
            echo $json;
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function pedidoEntregado($data)
    {
        try
        {   
            $datos = [
                "id_pres" => $data['id_pres'],
                "estado" => 'd'
            ];
            if ($this->pedidoStock($id_pres)) {
                $result = $this->updateStockPedido($id_pres, $estado);
            }
            
            $sql = "UPDATE tm_detalle_pedido SET estado = 'd' WHERE id_pedido = ? AND id_pres = ? AND fecha_pedido = ?";
            $this->db->prepare($sql)
              ->execute(array(
                $data['id_pedido'],
                $data['id_pres'],
                $data['fecha_pedido']
                ));
                
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function pedido_estado_update($data)
    {
        try 
        {
            if($data['estado']=='i'){$estado='p';}elseif($data['estado']=='p'){$estado='i';};
            $sql = "UPDATE tm_mesa SET estado = ? WHERE id_mesa = ?";
            $this->db->prepare($sql)->execute(array($estado,$data['id_mesa']));
        }
        catch (Exception $e) 
        {
            return false;
        }
    }

    /* FIN PEDIDOS PREPARADOS */

    public function menu_categoria_list()
    {
        try
        {
            $stm = $this->db->prepare("SELECT * FROM tm_producto_catg WHERE delivery = 1");
            $stm->execute();
            $c = $stm->fetchAll(PDO::FETCH_OBJ);
            $data = array("data" => $c);
            $json = json_encode($data);
            echo $json; 
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function menu_plato_list($data)
    {
        try
        {
            $stm = $this->db->prepare("SELECT * FROM v_productos WHERE del_a = 1 AND del_b = 1 AND del_c = 1 AND id_catg = ?");
            $stm->execute(array($data['id_catg']));
            $c = $stm->fetchAll(PDO::FETCH_OBJ);
            $data = array("data" => $c);
            $json = json_encode($data);
            echo $json; 
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function menu_plato_estado($data)
    {
        try 
        {
            if($data['estado']=='a'){$estado='i';}elseif($data['estado']=='i'){$estado='a';};
            $sql = "UPDATE tm_producto_pres SET estado = ? WHERE id_pres = ?";
            $this->db->prepare($sql)->execute(array($estado,$data['id_pres']));
        }
        catch (Exception $e) 
        {
            return false;
        }
    }

    /* INICIO IMPRESION */

    public function impresion_precuenta($id_pedido)
    {
        try
        {      
            $stm = $this->db->prepare("SELECT * FROM v_pedido_mesa WHERE id_pedido = ?");
            $stm->execute(array($id_pedido));
            $c = $stm->fetch(PDO::FETCH_OBJ);
            /* Traemos el detalle */
            $c->{'Detalle'} = $this->db->query("SELECT id_pres,SUM(cantidad) AS cantidad, precio FROM tm_detalle_pedido WHERE id_pedido = " . $c->id_pedido." AND estado != 'z' GROUP BY id_pres")
                ->fetchAll(PDO::FETCH_OBJ);
            foreach($c->Detalle as $k => $d)
            {
                $c->Detalle[$k]->{'Producto'} = $this->db->query("SELECT pro_nom, pro_pre FROM v_productos WHERE id_pres = " . $d->id_pres)
                    ->fetch(PDO::FETCH_OBJ);
            }
            $c->{'host_pc'} = Session::get('host_pc');
            return $c;
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function impresion_reparto($id_venta)
    {
        try
        {      
            $stm = $this->db->prepare("SELECT v.id_ven, v.id_cli, v.desc_tp, v.id_tpag, v.fec_ven, v.pago_efe, v.pago_efe_none, v.pago_tar,IFNULL((v.total+v.comis_del-v.desc_monto),0) AS total, d.nro_pedido FROM v_ventas_con AS v INNER JOIN tm_pedido_delivery AS d ON v.id_ped = d.id_pedido WHERE id_ven = ?");
            $stm->execute(array($id_venta));
            $c = $stm->fetch(PDO::FETCH_OBJ);
            $c->{'Cliente'} = $this->db->query("SELECT * FROM v_clientes WHERE id_cliente = " . $c->id_cli)
                ->fetch(PDO::FETCH_OBJ);
            /* Traemos el detalle */
            $c->{'Detalle'} = $this->db->query("SELECT id_prod,SUM(cantidad) AS cantidad, precio FROM tm_detalle_venta WHERE id_venta = " . $c->id_ven." GROUP BY id_prod, precio")
                ->fetchAll(PDO::FETCH_OBJ);
            foreach($c->Detalle as $k => $d)
            {
                $c->Detalle[$k]->{'Producto'} = $this->db->query("SELECT pro_nom, pro_pre FROM v_productos WHERE id_pres = " . $d->id_prod)
                    ->fetch(PDO::FETCH_OBJ);
            }
            return $c;
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function contador_comanda()
    {
        try
        {   
            $sql = "SELECT id_pedido, fecha_pedido, COUNT(*) AS correlativo 
                FROM tm_detalle_pedido 
                GROUP BY id_pedido, fecha_pedido";

            $stm = $this->db->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll(PDO::FETCH_ASSOC);

            $rowCount = $stm->rowCount();
            $correlativo = str_pad($rowCount, 6, '0', STR_PAD_LEFT);
            return $correlativo;
        }
        catch(PDOException $e)
        {
            die("Error en la consulta: " . $e->getMessage());
        }
    }

    public function alert_pedidos_programados()
    {
        try
        {   
            $stm = $this->db->prepare("SELECT MIN(pd.hora_entrega) AS hora_entrega, pd.id_pedido, pd.nombre_cliente, pd.nro_pedido FROM tm_pedido_delivery AS pd INNER JOIN tm_pedido AS p ON pd.id_pedido = p.id_pedido WHERE pd.pedido_programado = 1 AND p.estado = 'a'");
            $stm->execute();
            $c = $stm->fetch(PDO::FETCH_OBJ);
            return $c;
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }
    /* FIN IMPRESION */
    public function control_stock_pedido($data)
    {
        try {
            $data['id_pres'];

            $consulta = "SELECT * FROM `v_stock_pedido` WHERE `id_ins` = :id_pedido";
            $result = $this->db->prepare($consulta);
            $result->bindParam(':id_pedido',$data['id_pres'],PDO::PARAM_INT);
            $result->execute();
            $row = $result->fetch(PDO::FETCH_OBJ);

            //if (isset($data['cant_pro']) && !empty($data['cant_pro']) && ($data['cant_pro'] - ($row->ent - $row->sal)) == 0) {
                //return 0;
            //}
            
            return $row ?: 0;

        } catch (Exception $e) {
            return false;
        }
    }
    public function stock_list($data)
    {
        try
        {
            $stm = $this->db->prepare("SELECT * FROM v_stock WHERE id_tipo_ins LIKE ? AND debajo_stock LIKE ?");
            $stm->execute(array($data['tipo_ins'],$data['stock_min']));
            $c = $stm->fetchAll(PDO::FETCH_OBJ);
            foreach($c as $k => $d)
            {
                $c[$k]->{'Producto'} = $this->db->query("SELECT * FROM v_insprod WHERE id_tipo_ins = ".$d->id_tipo_ins." AND id_ins = ".$d->id_ins)
                    ->fetch(PDO::FETCH_OBJ);
            }
            $data = array("data" => $c);
            $json = json_encode($data);
            echo $json; 
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function saveStockPedido($datos = []) {
        if (!empty($datos)) {
            $result = $this->db->insert("tm_stock_pedidos", $datos);
            return $result['success'] === true;
        }
        return false;
    }

    public function updateStockPedido($id_pres, $estado) {
        $result = $this->db->update("tm_stock_pedidos", ["estado" => $estado], "id_pres = $id_pres");
        return $result['success'] === true;
    }

    public function pedidoStock($id_pres = null) {
        if (!empty($id_pres)) {
            // Aquí debes ajustar la consulta para verificar si el pedido existe en la tabla correcta
            $consult = $this->db->selectOne("SELECT * FROM tm_producto_pres WHERE id_pres = :idpres AND crt_stock = 1", ["idpres" => $id_pres]);
            return $consult !== false; // Devuelve true si se encuentra el pedido, false si no
        }
        return false;
    }


}