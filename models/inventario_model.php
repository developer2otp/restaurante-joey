<?php Session::init(); ?>
<?php

class Inventario_Model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

    private function insertarEntSalida($data, $fecha)
    {
        $entSalData = [
            "id_tipo" => $data['id_tipo'],
            "id_usu" => Session::get('usuid'),
            "id_responsable" => $data['id_responsable'],
            "motivo" => $data["motivo"],
            "fecha" => $fecha
        ];

        $this->db->insert("tm_inventario_entsal", $entSalData);

        return $this->db->lastInsertId();
    }

    private function insertarInventario($items, $entSalId, $tipo, $fecha)
    {
        foreach ($items as $d)
        {
            $inventarioData = [
                "id_tipo_ope" => $tipo,
                "id_ope" => $entSalId,
                "id_tipo_ins" => $d['id_tipo_ins_insumo'],
                "id_ins" => $d['id_ins_insumo'],
                "cos_uni" => $d['precio_insumo'],
                "cant" => $d['cantidad_insumo'],
                "fecha_r" => $fecha
            ];

            $this->db->insert("tm_inventario", $inventarioData);
        }
        if(count($items) > 0){
            return ['success' => true, 'message' => 'Datos Correctamente Guardados.'];
        }else{
            return ['success' => false, 'message' => 'Ocurrió un error en los datos enviados.'];
        }
    }

    public function Responsable()
    {
        try
        {      
            return $this->db->selectAll('SELECT * FROM tm_usuario WHERE id_usu != 1 GROUP BY dni');
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }
	
    /* AJUSTE DE STOCK */
    public function ajuste_list()
    {
        try
        {
            $ifecha = date('Y-m-d',strtotime($_POST['ifecha']));
            $ffecha = date('Y-m-d',strtotime($_POST['ffecha']));

            $stm = $this->db->prepare("SELECT i.*,IF(i.id_tipo=3,'ENTRADA','SALIDA') AS tipo, CONCAT(u.nombres,' ',u.ape_paterno,' ',u.ape_materno) AS responsable FROM tm_inventario_entsal AS i INNER JOIN tm_usuario AS u ON i.id_responsable = u.id_usu WHERE ((DATE_FORMAT(i.fecha,'%Y-%m-%d')) >= ? AND (DATE_FORMAT(i.fecha,'%Y-%m-%d')) <= ?)");
            $stm->execute(array($ifecha,$ffecha));
            $c = $stm->fetchAll(PDO::FETCH_OBJ);

            return ['data' => $c];

        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function ajuste_crud_create($data)
    {
        try 
        {
            date_default_timezone_set($_SESSION["zona_horaria"]);
            setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
            $fecha = date("Y-m-d H:i:s");

            $entSalId = $this->insertarEntSalida($data, $fecha);
            $result = $this->insertarInventario($data['items'], $entSalId, $data['id_tipo'], $fecha);

            //return true;
            return $result;
        }catch (Exception $e){
            return ['success' => false, 'message' => 'Ocurrió un error al insertar datos.'];
        }
    }

    public function ajuste_det($data)
    {
        try
        {
            $sql = "SELECT i.*, p.* FROM tm_inventario i
                    JOIN v_insprod p ON i.id_tipo_ins = p.id_tipo_ins AND i.id_ins = p.id_ins
                    WHERE i.id_tipo_ope = :id_tipo AND i.id_ope = :id_ope";

            $datos = [
                "id_tipo" => $data['id_tipo'],
                "id_ope" => $data['id_es']
            ];

            $result = $this->db->selectAll($sql, $datos, PDO::FETCH_OBJ);

            return $result;

        }catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function ajuste_delete($data)
    {
        try 
        {
            $consulta = "call usp_invESAnular( :flag, :id_es, :id_tipo);";
            $arrayParam =  array(
                ':flag' => 1,
                ':id_es' => $data['id_es'],
                ':id_tipo' => $data['id_tipo']
            );
            $st = $this->db->prepare($consulta);
            $st->execute($arrayParam);
            $row = $st->fetch(PDO::FETCH_ASSOC);

            return $row;

        }catch (Exception $e){
            die($e->getMessage());
        }
    }

    public function ajuste_insumo_buscar($data)
    {
        try
        {
            $cadena = '%' . $data['cadena'] . '%';

            // Utilizamos CONVERT para forzar la conversión de cotejo
            $stmt = $this->db->prepare("SELECT * FROM v_insprod 
                                        WHERE (CONVERT(ins_cod USING utf8mb4) LIKE :cadena OR CONVERT(ins_nom USING utf8mb4) LIKE :cadena) 
                                            AND CONVERT(est_b USING utf8mb4) = 'a' 
                                            AND CONVERT(est_c USING utf8mb4) = 'a' 
                                            AND (CONVERT(crt_stock USING utf8mb4) = '1' OR CONVERT(ins_rec USING utf8mb4) = '1') 
                                        ORDER BY ins_nom LIMIT 5");
        
            $stmt->bindParam(':cadena', $cadena, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);

            return $result;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function combomedida($data)
    {
        try
        {  
            $data = [
                "grupo" => $data['va1'],
                "grupo1" => $data['va2']
            ];

            $var = $this->db->selectAll("SELECT * FROM tm_tipo_medida WHERE grupo = :grupo OR grupo = :grupo1", $data); 

            foreach($var as $v){
                echo '<option value="'.$v['id_med'].'">'.$v['descripcion'].'</option>';
            }

        }catch(Exception $e){
            die($e->getMessage());
        }
    }

    /* STOCK */
    public function stock_list($data)
{
    try
    {
        $data = [
            "tipo_ins" => $data['tipo_ins'],
            "stock_min" => $data['stock_min']
        ];

        $sql = "SELECT s.*, p.* FROM v_stock s
                LEFT JOIN v_insprod p ON s.id_tipo_ins = p.id_tipo_ins AND s.id_ins = p.id_ins
                WHERE s.id_tipo_ins LIKE :tipo_ins AND s.debajo_stock LIKE :stock_min";

        $result = $this->db->selectAll($sql, $data, PDO::FETCH_OBJ);

        return ['data' => $result];

    }catch(Exception $e){
        die($e->getMessage());
    }
}

    /* KARDEX VALORIZADO */
    public function kardex_list()
    {
        try
        {
            $tipo_ip = $_POST['tipo_ip'];
            $id_ip = $_POST['id_ip'];
            $ifecha = date('Y-m-d',strtotime($_POST['ifecha']));
            $ffecha = date('Y-m-d',strtotime($_POST['ffecha']));

            $stm = $this->db->prepare("SELECT id_inv,id_tipo_ope,id_ope,id_tipo_ins,id_ins,cos_uni,cant,fecha_r,estado,
                    IF(id_tipo_ope = 1 OR id_tipo_ope = 3,FORMAT(cant,6),0) AS cantidad_entrada, 
                    IF(id_tipo_ope = 1 OR id_tipo_ope = 3,cos_uni,0) AS costo_entrada, 
                    IF(id_tipo_ope = 1 OR id_tipo_ope = 3,(cant*cos_uni),0) AS total_entrada, 
                    IF(id_tipo_ope = 2 OR id_tipo_ope = 4,FORMAT(cant,6),0) AS cantidad_salida, 
                    IF(id_tipo_ope = 2 OR id_tipo_ope = 4,cos_uni,'-') AS costo_salida, 
                    IF(id_tipo_ope = 2 OR id_tipo_ope = 4,(cant*cos_uni),0) AS total_salida
                FROM tm_inventario WHERE id_tipo_ins = ? AND id_ins = ? AND (date(fecha_r) >= ? AND date(fecha_r) <= ?)");
            $stm->execute(array($tipo_ip,$id_ip,$ifecha,$ffecha));
            $c = $stm->fetchAll(PDO::FETCH_OBJ);
            foreach($c as $k => $d)
            {
                $c[$k]->{'Precio'} = $this->db->query("SELECT ROUND(AVG(cos_uni),2) AS cos_pro FROM tm_inventario WHERE id_tipo_ins = ".$d->id_tipo_ins." AND id_ins = ".$d->id_ins)
                    ->fetch(PDO::FETCH_OBJ);

                $c[$k]->{'Medida'} = $this->db->query("SELECT ins_med FROM v_insprod WHERE id_tipo_ins = ".$d->id_tipo_ins." AND id_ins = ".$d->id_ins)
                    ->fetch(PDO::FETCH_OBJ);

                $c[$k]->{'Stock'} = $this->db->query("SELECT SUM(ent - sal) AS total FROM v_stock WHERE id_ins = ".$id_ip)
                    ->fetch(PDO::FETCH_OBJ);

                if($d->id_tipo_ope == 1){
                    $c[$k]->{'Comp'} = $this->db->query("SELECT serie_doc AS ser_doc,num_doc AS nro_doc,desc_td FROM v_compras WHERE id_compra = ".$d->id_ope)
                    ->fetch(PDO::FETCH_OBJ);
                } else if($d->id_tipo_ope == 2){
                    $c[$k]->{'Comp'} = $this->db->query("SELECT ser_doc,nro_doc,desc_td FROM v_ventas_con WHERE id_ven = ".$d->id_ope)
                    ->fetch(PDO::FETCH_OBJ);
                } else if($d->id_tipo_ope == 3 OR $d->id_tipo_ope == 4){
                    $c[$k]->{'Comp'} = $this->db->query("SELECT i.motivo, CONCAT(u.nombres,' ',u.ape_paterno,' ',u.ape_materno) AS responsable FROM tm_inventario_entsal AS i INNER JOIN tm_usuario AS u ON i.id_responsable = u.id_usu WHERE i.id_es = ".$d->id_ope)
                    ->fetch(PDO::FETCH_OBJ);
                }
            }
            
            $data = array("data" => $c);
            $json = json_encode($data);
            echo $json; 
        }catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function ComboInsumoProducto($data)
    {
        try
        {   
            $data = [
                "id_tipo_ins" => $data['id_tipo_ins']
            ];

            $sql = "SELECT id_ins,ins_cod,ins_nom,ins_cat FROM v_insprod WHERE id_tipo_ins = :id_tipo_ins AND est_b = 'a' AND est_c = 'a'";

            $var = $this->db->selectAll($sql, $data);

            foreach($var as $v){
                echo '<option value="'.$v['id_ins'].'">'.$v['ins_cod'].' | '.$v['ins_cat'].' | '.$v['ins_nom'].'</option>';
            }
        }catch(Exception $e){
            die($e->getMessage());
        }
    }
        public function impresion_stock($data)
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

            return $c;

        }catch(Exception $e){
            die($e->getMessage());
        }
    }
}