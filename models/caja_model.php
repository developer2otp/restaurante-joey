<?php Session::init(); ?>
<?php

class Caja_Model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

    public function Cajero()
    {
        try
        {      
            return $this->db->selectAll("SELECT id_usu,CONCAT(ape_paterno,' ',ape_materno,' ',nombres) AS nombres FROM tm_usuario WHERE (id_rol = 1 OR id_rol = 2 OR id_rol = 3) AND id_usu != 1 AND estado = 'a'");
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function Caja()
    {
        try
        {      
            return $this->db->selectAll("SELECT * FROM tm_caja WHERE estado = 'a'");
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function Turno()
    {
        try
        {      
            return $this->db->selectAll("SELECT * FROM tm_turno");
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function InsertTurno($data)
    {
        try
        {
            if(empty($data['turn_name'])){
                return ['success' => false, 'message' => 'Dato vacío.'];
            }else{
                return $this->db->insert("tm_turno", ['descripcion' => $data['turn_name']]);
            }
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
            return $this->db->selectAll("SELECT * FROM tm_usuario WHERE id_usu != 1 AND estado = 'a' GROUP BY dni");
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
    public function TipoPedido()
    {
        try
        {      
            return $this->db->selectAll('SELECT * FROM tm_tipo_pedido');
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

    /* INICIO MODULO APERTURA Y CIERRE */
    public function apercie_list()
    {
        try
        {
            $stm = $this->db->selectOne("SELECT * FROM v_caja_aper WHERE id_usu = :id_usu AND estado = 'a'", ['id_usu' => Session::get('usuid')], PDO::FETCH_OBJ);
            return $stm;
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function apercie_montosist($data)
    {
        try
        {
            // Consulta principal
            $sql = "SELECT 
                    IFNULL(SUM(pago_efe), 0) AS pago_efe, 
                    IFNULL(SUM(pago_tar), 0) AS pago_tar, 
                    IFNULL(SUM(desc_monto), 0) AS descu, 
                    IFNULL(SUM(total - desc_monto), 0) AS total 
                    FROM v_ventas_con 
                    WHERE id_apc = :id_apc AND estado != 'i'";

            $c = $this->db->selectOne($sql, ['id_apc' => $data['id_apc']], PDO::FETCH_OBJ);

            // Consulta para 'Apertura'
            $sql = "SELECT * FROM v_caja_aper WHERE id_apc = :id_apc";
            $c->{'Apertura'} = $this->db->selectOne($sql, ['id_apc' => $data['id_apc']], PDO::FETCH_OBJ);

            // Consulta para 'Ingresos'
            $sql = "SELECT IFNULL(SUM(importe), 0) AS total FROM tm_ingresos_adm WHERE id_apc = :id_apc AND estado = 'a'";
            $c->{'Ingresos'} = $this->db->selectOne($sql, ['id_apc' => $data['id_apc']], PDO::FETCH_OBJ);

            // Consulta para 'EgresosA'
            $sql = "SELECT IFNULL(SUM(importe), 0) AS total FROM v_gastosadm WHERE id_apc = :id_apc AND (id_tg IN (1, 2, 3)) AND estado = 'a'";
            $c->{'EgresosA'} = $this->db->selectOne($sql, ['id_apc' => $data['id_apc']], PDO::FETCH_OBJ);

            // Consulta para 'EgresosB'
            $sql = "SELECT IFNULL(SUM(importe), 0) AS total FROM v_gastosadm WHERE id_apc = :id_apc AND id_tg = 4 AND estado = 'a'";
            $c->{'EgresosB'} = $this->db->selectOne($sql, ['id_apc' => $data['id_apc']], PDO::FETCH_OBJ);

            return $c;
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }
/*
    public function stock_pollo()
    {
        try
        {
            $st = $this->db->prepare("SELECT (ent-sal) AS total FROM v_stock WHERE id_tipo_ins = 1 AND id_ins = 1");
            $st->execute();
            $row = $st->fetch(PDO::FETCH_OBJ);
            return $row;
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }
*/
    public function aperturar_caja($data)
    {
        try
        {
            date_default_timezone_set($_SESSION["zona_horaria"]);
            setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
            $fecha = date("Y-m-d H:i:s");
            $consulta = "call usp_cajaAperturar( :flag, :id_usu, :id_caja, :id_turno, :fecha_aper, :monto_aper);";
            $arrayParam =  array(
                ':flag' => 1,
                ':id_usu' => Session::get('usuid'),
                ':id_caja' => $data['id_caja'],
                ':id_turno' => $data['id_turno'],
                ':fecha_aper' =>  $fecha,
                ':monto_aper' => $data['monto_aper']
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

    public function cerrar_caja($data)
    {
        try
        {
            date_default_timezone_set($_SESSION["zona_horaria"]);
            setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
            $fecha = date("Y-m-d H:i:s");
            $consulta = "call usp_cajaCerrar( :flag, :id_apc, :fecha_cierre, :monto_cierre, :monto_sistema, :stock_pollo);";
            $arrayParam =  array(
                ':flag' => 1,
                ':id_apc' => $data['id_apc'],
                ':fecha_cierre' => $fecha,
                ':monto_cierre' => $data['monto_cierre'],
                ':monto_sistema' => $data['monto_sistema'],
                ':stock_pollo' => $data['stock_pollo']
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
    /* FIN MODULO APERTURA Y CIERRE */

    /* INICIO MODULO INGRESO */
    public function ingreso_list($data)
    {
        try
        {   
            date_default_timezone_set($_SESSION["zona_horaria"]);
            setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
            $fecha = date("Y-m-d");
            $id_usu = Session::get('usuid');
            $array = ['fecha_reg' => $fecha, 'id_usu' => $id_usu, 'estado' => $data['estado']];
            $c = $this->db->selectAll("SELECT * FROM tm_ingresos_adm WHERE DATE(fecha_reg) = :fecha_reg AND id_usu = :id_usu AND estado like :estado", $array, PDO::FETCH_OBJ);
            
            return ["data" => $c];
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function ingreso_crud_create($data)
    {
        try
        {
            date_default_timezone_set($_SESSION["zona_horaria"]);
            setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
            $fecha = date("Y-m-d H:i:s");
            $id_usu = Session::get('usuid');
            $id_apc = Session::get('apcid');
            $datos = ['id_usu' => $id_usu, 'id_apc' => $id_apc, 'importe' => $data['importe'], 'responsable' => $data['responsable'], 'motivo' => $data['motivo'], 'fecha_reg' => $fecha];
            
            $response = $this->db->insert("tm_ingresos_adm", $datos);

            return $response;
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }

    public function ingreso_estado($data)
    {
        try 
        {
            $response = $this->db->update("tm_ingresos_adm", ['estado' => 'i'], "id_ing = ".$data['id_ing']);

            return $response;

        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }

    /* FIN MODULO INGRESO */


    /* INICIO MODULO EGRESO */
    public function egreso_list($data)
    {
        try
        {   
            date_default_timezone_set($_SESSION["zona_horaria"]);
            setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
            $fecha = date("Y-m-d");
            $id_usu = Session::get('usuid');
            $sql = "SELECT * FROM v_gastosadm WHERE DATE(fecha_re) = :fecha_re AND id_usu = :id_usu AND id_tg LIKE :id_tg AND estado like :estado";
            $datos = ['fecha_re' => $fecha, 'id_usu' => $id_usu, 'id_tg' => $data['tipo_gasto'], 'estado' => $data['estado']];
            $c = $this->db->selectAll($sql, $datos, PDO::FETCH_OBJ);

            return ["data" => $c];
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function egreso_crud_create($data)
    {
        try
        {
            date_default_timezone_set($_SESSION["zona_horaria"]);
            setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
            $fecha = date("Y-m-d H:i:s");
            $id_usu = Session::get('usuid');
            $id_apc = Session::get('apcid');
            $data = [
                'id_tipo_gasto' => $data['id_tipo_gasto'],
                'id_per' => $data['id_per'],
                'id_usu' => $id_usu,
                'id_apc' => $id_apc,
                'fecha_registro' => $fecha,
                'motivo' => $data['motivo'],
                'responsable' => $data['responsable'],
                'importe' => $data['importe']
            ];

            $response = $this->db->insert("tm_gastos_adm", $data);

            return $response;

        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }

    public function egreso_estado($data)
    {
        try 
        {
            $response = $this->db->update("tm_gastos_adm", ['estado' => 'i'], "id_ga = " . $data['id_ga']);

            return $response;

        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }

    /* FIN MODULO EGRESO */

    /* INICIO MODULO MONITOR DE VENTAS */

    public function monitor_list()
    {
        try
        {
            $data = $this->db->selectAll("SELECT * FROM v_caja_aper WHERE estado != 'c'", [], PDO::FETCH_OBJ);

            $response = ["data" => $data];

            return $response;
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function monitor_ventas_list()
    {
        try
        {
            $ifecha = date('Y-m-d H:i:s', strtotime($_POST['ifecha']));
            $ffecha = date('Y-m-d H:i:s', strtotime($_POST['ffecha']));

            $consulta = (Session::get('rol') == 1 || Session::get('rol') == 2) ? "" : " AND id_apc = " . Session::get('apcid');

            $sql = "SELECT *, IFNULL((pago_efe + pago_tar), 0) AS monto_total 
                    FROM v_ventas_con 
                    WHERE (fec_ven >= ? AND fec_ven <= ?) 
                    AND id_tped LIKE ? 
                    AND id_tdoc LIKE ? $consulta";

            $stm = $this->db->prepare($sql);
            $stm->execute([$ifecha, $ffecha, $_POST['tped'], $_POST['tdoc']]);
            $c = $stm->fetchAll(PDO::FETCH_OBJ);

            foreach ($c as &$d) {
                $d->{'Pedido'} = $this->db->query("SELECT vm.desc_salon, vm.nro_mesa 
                                                    FROM tm_pedido_mesa AS pm 
                                                    INNER JOIN v_mesas AS vm ON pm.id_mesa = vm.id_mesa 
                                                    WHERE pm.id_pedido = " . $d->id_ped)
                                            ->fetch(PDO::FETCH_OBJ);

                $d->{'Cliente'} = $this->db->query("SELECT nombre FROM v_clientes WHERE id_cliente = " . $d->id_cli)
                                            ->fetch(PDO::FETCH_OBJ);

                $d->{'Tipopago'} = $this->db->query("SELECT descripcion AS nombre 
                                                        FROM tm_tipo_pago 
                                                        WHERE id_tipo_pago = " . $d->id_tpag)
                                            ->fetch(PDO::FETCH_OBJ);
            }

            return ["data" => $c];

            //$data = array("data" => $c);
            //$json = json_encode($data);
            //echo $json;
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function monitor_mesas_list()
    {
        try
        {
            $c = $this->db->selectAll("SELECT id_pedido, desc_salon, nro_mesa FROM v_listar_mesas WHERE estado = 'i' OR estado = 'p'", [], PDO::FETCH_OBJ);

            foreach($c as $k => $d)
            {
                $c[$k]->{'Total'} = $this->db->query("SELECT SUM(precio*cant) AS total FROM tm_detalle_pedido WHERE id_pedido = ".$d->id_pedido." AND estado != 'z'")
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
    public function impresion_ingreso($id_pedido)
    {
        try
        {    
            // SELECT * FROM tm_ingresos_adm WHERE id_ing = ?
            $c = $this->db->selectOne("SELECT * FROM tm_ingresos_adm WHERE id_ing = :id_ing", ['id_ing' => $id_pedido], PDO::FETCH_OBJ);
            // SELECT * FROM tm_usuario WHERE id_usu = 2
            $c->{'usuario'} = $this->db->selectAll("SELECT * FROM tm_usuario WHERE id_usu = :id_usu", ['id_usu' => $c->id_usu], PDO::FETCH_OBJ);
            /* Traemos el detalle */
            return $c;
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }
    public function impresion_egreso($id_pedido)
    {
        try
        {    
            // SELECT * FROM tm_gastos_adm WHERE id_ga = ?
            $c = $this->db->selectOne("SELECT * FROM tm_gastos_adm WHERE id_ga = :id_ga", ['id_ga' => $id_pedido], PDO::FETCH_OBJ);
            // if(!$c->id_per== 0){
            //     // $c->{'trabajador'} = $this->db->query("SELECT * FROM tm_usuario WHERE id_usu = " . $c->id_usu."")->fetchAll(PDO::FETCH_OBJ);
            // }
            // SELECT * FROM tm_usuario WHERE id_usu = 2
            // SELECT * FROM tm_tipo_gasto WHERE id_tipo_gasto = 3
            $c->{'tipogasto'} = $this->db->selectAll(" SELECT * FROM tm_tipo_gasto WHERE id_tipo_gasto = ".$c->id_tipo_gasto."", [], PDO::FETCH_OBJ);

            $c->{'usuario'} = $this->db->selectAll("SELECT * FROM tm_usuario WHERE id_usu = " . $c->id_usu."", [], PDO::FETCH_OBJ);
            /* Traemos el detalle */
            return $c;
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    /*
    public function monitor_ventas_porcobrar()
    {
        try
        {   
            $stm = $this->db->prepare("SELECT id_pedido FROM v_listar_mesas WHERE estado = 'i'");
            $stm->execute();
            $c = $stm->fetchAll(PDO::FETCH_OBJ);
            foreach($c as $k => $d)
            {
                $c[$k]->{'VentasPorCobrar'} = $this->db->query("SELECT SUM(precio*cant) AS total FROM tm_detalle_pedido WHERE id_pedido = ".$d->id_pedido." AND estado <> 'z'")
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

    /* FIN MODULO MONITOR DE VENTAS */

}