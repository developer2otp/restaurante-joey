<?php Session::init(); ?>
<?php

class Compra_Model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

    /* INICIO MODULO COMPRA*/
    public function compra_list($data)
    {
        try
        {
            $ifecha = date('Y-m-d',strtotime($data['ifecha']));
            $ffecha = date('Y-m-d',strtotime($data['ffecha']));
            $sql = "SELECT * FROM v_compras WHERE ((DATE_FORMAT(fecha_r,'%Y-%m-%d')) >= :ifecha AND (DATE_FORMAT(fecha_r,'%Y-%m-%d')) <= :ffecha) AND id_prov LIKE :id_prov AND id_tipo_compra LIKE :id_tipo_compra AND id_tipo_doc LIKE :id_tipo_doc AND estado LIKE :estado GROUP BY id_compra";
            $datos = ['ifecha' => $ifecha, 'ffecha' => $ffecha, 'id_prov' => $data['id_prov'], 'id_tipo_compra' => $data['id_tipo_compra'], 'id_tipo_doc' => $data['id_tipo_doc'], 'estado' => $data['estado']];
            $response = $this->db->selectAll($sql, $datos, PDO::FETCH_OBJ);
            return ["data" => $response];
            echo $json;
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function Proveedor()
    {
        try
        {      
            return $this->db->selectAll('SELECT id_prov,ruc,razon_social FROM tm_proveedor');
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function compra_det()
    {
        try
        {
            $idCompra = $_POST['id_compra'];

            $query = "SELECT td.*, ip.ins_cod, ip.ins_nom, ip.ins_med, ip.ins_cat 
                      FROM tm_compra_detalle td
                      JOIN v_insprod ip ON td.id_tp = ip.id_tipo_ins AND td.id_pres = ip.id_ins
                      WHERE td.id_compra = :id_compra";

            $result = $this->db->selectAll($query, ['id_compra' => $idCompra], PDO::FETCH_OBJ);

            return $result;
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function compra_crud_create($data)
    {
        try
        {   
            date_default_timezone_set($_SESSION["zona_horaria"]);
            setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
            $fecha_reg = date("Y-m-d H:i:s");
            $igv = Session::get('igv');
            $id_usu = Session::get('usuid');
            $fecha_c = date('Y-m-d',strtotime($data['fecha_c']));
            
            $dato = [
                'id_prov' => $data['id_prov'],
                'id_tipo_compra' => $data['id_tipo_compra'],
                'id_tipo_doc' => $data['id_tipo_doc'],
                'id_usu' => $id_usu,
                'fecha_c' => $fecha_c,
                'hora_c' =>$data['hora_c'],
                'serie_doc' => $data['serie_doc'],
                'num_doc' => $data['num_doc'],
                'igv' => $igv,
                'total' => $data['monto_total'],
                'descuento' => $data['descuento'],
                'fecha_reg' => $fecha_reg
            ];
            $response = $this->db->insert("tm_compra", $dato);
            /* El ultimo ID que se ha generado */
            $compra_id = $this->db->lastInsertId();

            if ($data['id_tipo_compra'] == 2) {
                $a = $data['monto_cuota'];
                $c = $data['fecha_cuota'];
            
                $sql = "INSERT INTO tm_compra_credito (id_compra, total, fecha) VALUES (?, ?, ?);";
                $statement = $this->db->prepare($sql);

                for ($x = 0; $x < sizeof($a); ++$x) {
                    $statement->execute(array($compra_id, $a[$x], date('Y-m-d', strtotime($c[$x]))));
                }
            }

            /* Recorremos el detalle para insertar */
            foreach($data['items'] as $d)
            {
                $sqll = "INSERT INTO tm_compra_detalle (id_compra,id_tp,id_pres,cant,precio) VALUES (?,?,?,?,?)";
                $this->db->prepare($sqll)->execute(array($compra_id,$d['id_tipo_ins_insumo'],$d['id_ins_insumo'],$d['cantidad_insumo'],$d['precio_insumo']));

                $sql = "INSERT INTO tm_inventario (id_tipo_ope,id_ope,id_tipo_ins,id_ins,cos_uni,cant,fecha_r) VALUES (?,?,?,?,?,?,?)";
                $this->db->prepare($sql)->execute(array(1,$compra_id,$d['id_tipo_ins_insumo'],$d['id_ins_insumo'],$d['precio_insumo'],$d['cantidad_insumo'],$fecha_reg));
            }

            return true;
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function compra_delete($data)
    {
        try 
        {
            $consulta = "call usp_comprasAnular( :flag, :id_compra);";
            $arrayParam =  array(
                ':flag' => 1,
                ':id_compra' => $data['id_compra']
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

    public function compra_proveedor_buscar($data)
    {
        try
        {   
            $stm = $this->db->prepare("SELECT id_prov,ruc,razon_social FROM tm_proveedor WHERE estado != 'i' AND (ruc LIKE '%$data%' OR razon_social LIKE '%$data%') ORDER BY ruc LIMIT 5");
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        
        } catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function compra_insumo_buscar($data)
    {
        try
        {   
            $sql = "SELECT id_tipo_ins,id_ins,ins_cod,ins_nom,ins_cat,ins_med FROM v_insprod WHERE (ins_cod LIKE '%$data%' OR ins_nom LIKE '%$data%') AND id_tipo_ins != 3 AND est_b = 'a' AND est_c = 'a' ORDER BY ins_nom LIMIT 5";
            return $this->db->selectAll($sql, [], PDO::FETCH_OBJ);
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function compra_proveedor_nuevo($data)
    {
        try
        {
            $consulta = "call usp_comprasRegProveedor( :flag, @a, :ruc, :razon_social, :direccion, :telefono, :email, :contacto);";
            $arrayParam =  array(
                ':flag' => 1,
                ':ruc' => $data['ruc'],
                ':razon_social' => $data['razon_social'],
                ':direccion' => $data['direccion'],
                ':telefono' => $data['telefono'],
                ':email' => $data['email'],
                ':contacto' => $data['contacto']
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

    /* FIN MODULO COMPRA*/

    /* INICIO MODULO PROVEEDOR */

    public function proveedor_list()
    {
        try
        {   
            $sql = $this->db->selectAll("SELECT * FROM tm_proveedor", [], PDO::FETCH_OBJ);
            return ["data" => $sql];
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function proveedor_datos($data)
    {
        try 
        {
            $response = $this->db->selectAll("SELECT * FROM tm_proveedor WHERE id_prov = :id_prov", ['id_prov', $data['id_prov']], PDO::FETCH_OBJ);
            return ["data" => $response];

        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }

    public function proveedor_crud_create($data)
    {
        try 
        {
            $consulta = "call usp_comprasRegProveedor( :flag, @a, :ruc, :razon_social, :direccion, :telefono, :email, :contacto);";
            $arrayParam =  array(
                ':flag' => 1,
                ':ruc' => $data['ruc'],
                ':razon_social' => $data['razon_social'],
                ':direccion' => $data['direccion'],
                ':telefono' => $data['telefono'],
                ':email' => $data['email'],
                ':contacto' => $data['contacto']
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

    public function proveedor_crud_update($data)
    {
        try 
        {   
            $consulta = "call usp_comprasRegProveedor( :flag, :id_prov, :ruc, :razon_social, :direccion, :telefono, :email, :contacto);";
            $arrayParam =  array(
                ':flag' => 2,
                ':id_prov' => $data['id_prov'],
                ':ruc' => $data['ruc'],
                ':razon_social' => $data['razon_social'],
                ':direccion' => $data['direccion'],
                ':telefono' => $data['telefono'],
                ':email' => $data['email'],
                ':contacto' => $data['contacto']
            );
            $st = $this->db->prepare($consulta);
            $st->execute($arrayParam);
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }

    public function proveedor_estado($data)
    {
        try 
        {
            $array = ['estado' => $data['estado'], 'id_prov' => $data['id_prov']];
            $sql = $this->db->update("tm_proveedor", $array);
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }

    /* FIN MODULO PROVEEDOR */
}