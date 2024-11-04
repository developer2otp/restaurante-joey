<?php Session::init(); ?>
<?php

class Credito_Model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
    public function credito_compra_list()
    {
        try
        {
            // Validar y formatear las fechas directamente desde el POST
            $ifecha = isset($_POST['ifecha']) ? date('Y-m-d', strtotime($_POST['ifecha'])) : null;
            $ffecha = isset($_POST['ffecha']) ? date('Y-m-d', strtotime($_POST['ffecha'])) : null;
            $id_prov = isset($_POST['id_prov']) ? $_POST['id_prov'] : null;
    
            // Preparar la consulta con parametros para evitar inyecciones SQL
            $sql = "SELECT cc.id_credito, cc.id_compra, cc.total, cc.interes, cc.fecha, vc.id_prov, CONCAT(vc.serie_doc,'-',vc.num_doc) AS numero, vc.desc_td, desc_prov, 
                    (SELECT IFNULL(SUM(importe),0) FROM tm_credito_detalle WHERE id_credito = cc.id_credito) AS Amortizado
                    FROM tm_compra_credito AS cc 
                    INNER JOIN v_compras AS vc ON cc.id_compra = vc.id_compra 
                    WHERE (cc.fecha >= :ifecha AND cc.fecha <= :ffecha) AND vc.id_prov like :id_prov AND cc.estado = 'p' AND vc.estado = 'a' 
                    ORDER BY cc.fecha ASC";
            $stm = $this->db->prepare($sql);
            $stm->bindParam(':ifecha', $ifecha);
            $stm->bindParam(':ffecha', $ffecha);
            $stm->bindParam(':id_prov', $id_prov);
            $stm->execute();
    
            $c = $stm->fetchAll(PDO::FETCH_OBJ);

            return ["data" => $c];
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function Proveedores()
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

    public function credito_compra_det()
    {
        try
        {
            // Obtener los datos del POST de manera segura
            $id_credito = isset($_POST['id_credito']) ? $_POST['id_credito'] : null;

            // Preparar y ejecutar la consulta utilizando parámetros para evitar inyecciones SQL
            $sql = "SELECT cd.*, CONCAT(u.ape_paterno,' ',u.ape_materno,' ',u.nombres) AS Usuario
                    FROM tm_credito_detalle AS cd
                    INNER JOIN v_usuarios AS u ON cd.id_usu = u.id_usu
                    WHERE cd.id_credito = :id_credito";
            $stm = $this->db->prepare($sql);
            $stm->bindParam(':id_credito', $id_credito);
            $stm->execute();

            // Obtener los resultados
            $c = $stm->fetchAll(PDO::FETCH_OBJ);
            return $c;
        }catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function credito_compra_cuota_list($data)
    {
        try
        {
            $stm = $this->db->prepare("
                        SELECT cc.id_credito, cc.id_compra, cc.total, cc.interes, cc.fecha, vc.id_prov, 
                            CONCAT(vc.serie_doc, '-', vc.num_doc) AS numero, vc.desc_td, desc_prov,
                            COALESCE(SUM(tcd.importe), 0) AS Amortizado
                        FROM tm_compra_credito AS cc
                        INNER JOIN v_compras AS vc ON cc.id_compra = vc.id_compra
                        LEFT JOIN tm_credito_detalle AS tcd ON cc.id_credito = tcd.id_credito
                        WHERE cc.id_credito LIKE ? AND cc.estado = 'p'
                        GROUP BY cc.id_credito, cc.id_compra, cc.total, cc.interes, cc.fecha, vc.id_prov, vc.serie_doc, vc.num_doc, vc.desc_td, desc_prov
                    ");
        
            $stm->execute(array($data['id_credito']));
            $c = $stm->fetchAll(PDO::FETCH_OBJ);

            return ['data' => $c];

        }catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function credito_compra_cuota_pago($data)
    {
        try 
        {
            date_default_timezone_set($_SESSION["zona_horaria"]);
            setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
            $fecha = date("Y-m-d H:i:s");
            $id_usu = Session::get('usuid');
            $id_apc = Session::get('apcid');
            $consulta = "call usp_comprasCreditoCuotas( :flag, :id_credito, :id_usu, :id_apc, :importe, :fecha, :egreso, :monto_egreso, :monto_amortizado, :total_credito);";
            $arrayParam =  array(
                ':flag' => 1,
                ':id_credito' =>  $data['id_credito'],
                ':id_usu' =>  $id_usu,
                ':id_apc' => $id_apc,
                ':importe' =>  $data['importe'],
                ':fecha' =>  $fecha,
                ':egreso' =>  $data['egreso'],
                ':monto_egreso' => $data['monto_egreso'],
                ':monto_amortizado' => $data['monto_amortizado'],
                ':total_credito' => $data['total_credito']
            );
            $st = $this->db->prepare($consulta);
            $st->execute($arrayParam);
        }
        catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }

}