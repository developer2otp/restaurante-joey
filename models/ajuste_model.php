<?php Session::init();

class Ajuste_Model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

    public function AreaProduccion()
    {
        try
        {      
            return $this->db->selectAll('SELECT * FROM tm_area_prod WHERE estado = "a"');
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function Rol()
    {
        try
        {      
            return $this->db->selectAll('SELECT * FROM tm_rol WHERE id_rol != 1');
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function UnidadMedida()
    {
        try
        {      
            return $this->db->selectAll('SELECT * FROM tm_tipo_medida');
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function Impresora()
    {
        try
        {      
            return $this->db->selectAll('SELECT * FROM tm_impresora WHERE estado = "a"');
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    /* INICIO MODULO EMPRESA */
    //funcion datos_empresa_data actualizado
	public function datosempresa_data()
    {
        try
        {    
            $stm = $this->db->selectOne("SELECT * FROM tm_empresa", [], PDO::FETCH_OBJ);
            return $stm;
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    //funcion datosempresa_crud actualizado
    public function datosempresa_crud($data)
    {
        try 
        {
            /*
            $array = [
                'ruc' => $data['ruc'],
                'razon_social' => $data['razon_social'],
                'ruc' => $data['ruc'],
                'direccion_comercial' => $data['nombre_comercial'],
                'celular' => $data['celular']
            ];
            */

            if($data['usuid'] == 1){
                if (!empty($_FILES['imagen']['name'])) {
                    $ext = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
                    $imagen = date('ymdhis') . '.' . $ext;
                    $rutaImagen = 'public/images/' . $imagen;
        
                $allowedTypes = ['jpeg', 'jpg', 'gif', 'png', 'pdf'];
                    if (in_array(strtolower($ext), $allowedTypes) && move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaImagen)) {
                        $data['logo'] =  $imagen;
                    }
                }else{
                    $imagen = $data['imagen'];
                }

                $fpro = (isset($_POST['f_pro'])) ? 3 : 2;

                $array = [
                    'nombre_comercial' => $data['nombre_comercial'],
                    'direccion_fiscal' => $data['direccion_fiscal'],
                    'ubigeo' => $data['ubigeo'],
                    'departamento' => $data['departamento'],
                    'provincia' => $data['provincia'],
                    'distrito' => $data['distrito'],
                    'client_id' => $data['client_id'],
                    'client_secret' => $data['client_secret'],
                    'logo' => $imagen,
                    'sunat'=> $fpro,
					'api_url_pro' => $data['api_url'],
					'api_token_pro' => $data['api_token'],
                    'ruc' => $data['ruc'],
                    'razon_social' => $data['razon_social'],
                    'direccion_comercial' => $data['direccion_comercial'],
                    'celular' => $data['celular']
                    ];

                    Session::set('f_pro', $fpro);

                if($fpro == 3)
                {
                    Session::set('api_url_pro', $data['api_url']);
				    Session::set('api_token_pro', $data['api_token']);
                }

            }

            $actualizar = $this->db->update('tm_empresa', $array, 'id_de = 1');

            return $actualizar;

        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }
    //sistemaconfig inicial
    public function system_data()
    {
        try
        {   
            $jsonData = file_get_contents('config.json');
            return $jsonData;
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function system_save($data){

        $jsonData = file_get_contents('config.json');
        $config = json_decode($jsonData, true);

        $descCompro = (isset($_POST['desComp_system'])) ? true : false;
        $ventRapida = (isset($_POST['ventaRap_system'])) ? true : false;
        $priceComanda = (isset($_POST['priceComanda_system'])) ? true : false;
        $optionDeletMesa = (isset($_POST['optionDeleteMesa'])) ? true : false;
    
        
        if(empty($data['nombre_system']) || empty($data['dbHost_mysql']) || empty($data['dbName_mysql']) || empty($data['dbUser_mysql']) || empty($data['dbPass_mysql'])){
            return ['success' => false, 'message' => 'Es requerido un nombre del sistema rest y datos de conexión a la BD.'];
        }else{
                if($data['usuid'] == 1){
                    $password = base64_encode($data['passAdmin_system']);
                    $config = [
                        'CEL_SYSTEM' => $data['celular_system'],
                        'NOMBRE_SOFT' => $data['nombre_system'],
                        'DESCRIPCION_COMPROBANTE' => $descCompro,
                        'URL_VENTA_RAPIDA' => $ventRapida,
                        'PRICE_COMANDA'=> $priceComanda,
                        'OPTION_DELETE_MESA'=> $optionDeletMesa,
                        'DB_HOST' => $data['dbHost_mysql'],
                        'DB_NAME' => $data['dbName_mysql'],
                        'DB_USER' => $data['dbUser_mysql'],
                        'DB_PASS' => $data['dbPass_mysql'],
                        'API_TOKEN' => $data['token_apiperu'],
                        'DESCRIP_NOTA' => $data['descDel_system'],
                        'NAME_NEGOCIO' => $data['nameNegocio_system'],
                        'NAME_CIUDAD' => $data['region_system'],
                        'HORARIO_ATENCION' => $data['horAten_system'],
                        'URL_TW' => $data['linkTw_system'],
                        'URL_FB' => $data['linkFb_system'],
                        'URL_INS' => $data['linkIns_system'],
                        'URL_LINK' => $data['linkLink_system']

                    ];

                    $newJsonData = json_encode($config, JSON_PRETTY_PRINT);
                    $exito = file_put_contents('config.json', $newJsonData);
                    $db_admin = 0;
                    if ($exito) {
                        if((!empty($data['passAdmin_system'])) || ($data['passAdmin_system'] != '')){
                            $response = $this->db->update("tm_usuario", ['contrasena' => $password], "id_usu = " .  $data['usuid']);
                            if($response['success']){
                                $db_admin = 1;
                            }
                        }

                        if($db_admin == 1){
                            return ['success' => true, 'message' => 'Contraseña SuperAdmin actualizado, Datos de configuración actualizados correctamente.'];
                        }else{
                            return ['success' => true, 'message' => 'La contraseña SuperAdmin se mantiene. Datos de configuración actualizadas.'];
                        }

                    } else {
                        return ['success' => false, 'message' => 'Error al actualizar el archivo de configuración.'];
                    }
                }
            
        }
    
        //return $estadoCheckbox;
        //return $data;

    }

    //tipo_doc_list actualizado
    public function tipodoc_list()
    {
        try
        {   
            $stm = $this->db->selectAll("SELECT * FROM tm_tipo_doc", $array = array(), PDO::FETCH_OBJ);
            return ['data' => $stm];
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }
    //tipodoc_crud actualizado
    public function tipodoc_crud($data)
    {
        try 
        {
            $sql = $this->db->update("tm_tipo_doc", ['serie' => $data['serie'], 'numero' => $data['numero'], 'estado' => $data['estado']], "id_tipo_doc = " . $data['id_tipo_doc']);
            return $sql;
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }
    //uuario_list optimizado
    public function usuario_list()
    {
        try
        {
            $stm = $this->db->selectAll("SELECT * FROM v_usuarios WHERE id_rol != 1", [], PDO::FETCH_OBJ);
            return ['data' => $stm];
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }
    //usuario_data optiizado
    public function usuario_data($id)
    {
        return $this->db->selectOne("SELECT * FROM v_usuarios WHERE id_usu = :id_usu", ['id_usu' => $id]);
    }
    //funcion optimizada
    public function usuario_crud_create($data)
    {
        try 
        {
            $imagen = $this->subirImagen();

            $area = (isset($data['id_areap'])) ? $data['id_areap'] : 0;

            $consulta = "call usp_configUsuario( :flag, @a, :id_rol, :id_areap, :dni, :ape_paterno, :ape_materno, :nombres, :email, :usuario, :contrasena, :imagen);";
            $arrayParam =  array(
                ':flag' => 1,
                ':id_rol' => $data['id_rol'],
                ':id_areap' => $area,
                ':dni' => $data['dni'],
                ':ape_paterno' => $data['ape_paterno'],
                ':ape_materno' => $data['ape_materno'],
                ':nombres' => $data['nombres'],
                ':email' => $data['email'],
                ':usuario' => $data['usuario'],
                ':contrasena' => base64_encode($data['contrasena']),
                ':imagen' => $imagen
            );
            $st = $this->db->prepare($consulta);
            $st->execute($arrayParam);
            $row = $st->fetch(PDO::FETCH_ASSOC);

            if($row){
                return ['success' => true, 'message' => 'Usuario Registrado Correctamente.'];
            }else{
                return ['success' => false, 'message' => 'Ocurrió un error al intentar registrar el usuario con dni: ' . $data['dni']];
            }
            //return $row;
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }

    public function usuario_crud_update($data)
    {
        try {
            $imagen = $this->subirImagen();

            $area = isset($data['id_areap']) ? $data['id_areap'] : 0;

            $consulta = "CALL usp_configUsuario(:flag, :id_usu, :id_rol, :id_areap, :dni, :ape_paterno, :ape_materno, :nombres, :email, :usuario, :contrasena, :imagen)";
            $arrayParam = array(
                ':flag' => 2,
                ':id_usu' => $data['id_usu'],
                ':id_rol' => $data['id_rol'],
                ':id_areap' => $area,
                ':dni' => $data['dni'],
                ':ape_paterno' => $data['ape_paterno'],
                ':ape_materno' => $data['ape_materno'],
                ':nombres' => $data['nombres'],
                ':email' => $data['email'],
                ':usuario' => $data['usuario'],
                ':contrasena' => base64_encode($data['contrasena']),
                ':imagen' => $imagen
            );

            $st = $this->db->prepare($consulta);
            //$st->execute($arrayParam);
            if($st->execute($arrayParam)){
                return ['success' => true, 'message' => 'Usuario Actualizado Correctamente.'];
            }else{
                return ['success' => false, 'message' => 'Ocurrió un error al intentar actualizar el usuario con dni: ' . $data['dni']];
            }
    } catch (Exception $e) {
        die($e->getMessage());
    }
}

    private function subirImagen()
    {
        if (!empty($_FILES['imagen']['name'])) {
            $ext = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
            $imagen = date('ymdhis') . '.' . $ext;
            $rutaImagen = 'public/images/users/' . $imagen;

        $allowedTypes = ['jpeg', 'jpg', 'gif', 'png', 'pdf'];
            if (in_array(strtolower($ext), $allowedTypes) && move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaImagen)) {
                return $imagen;
            } else {
                return null; // O manejador de error adecuado
            }
        }

        return 'default-avatar.png'; // Si no hay imagen
    }
    //usuario_estado optimizado
    public function usuario_estado($data)
    {
        try 
        {
            $sql = $this->db->update("tm_usuario", ['estado' => $data['estado']], "id_usu = " . $data['id_usu']);
            return $sql;
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }
    //usuario_delete optimizadoo
    public function usuario_delete($data)
    {
    try {
        $tableName = ($data['id_rol'] == 1 || $data['id_rol'] == 2) ? 'tm_pedido' : 'tm_pedido_mesa';
        $consulta = "SELECT COUNT(*) AS total FROM $tableName WHERE " . (($data['id_rol'] == 1 || $data['id_rol'] == 2) ? 'id_usu' : 'id_mozo') . " = ?";
        
        $result = $this->db->prepare($consulta);
        $result->execute([$data['id_usu']]);

        if ($result->fetchColumn() == 0) {
            return $this->db->delete("tm_usuario", "id_usu = " . $data['id_usu']);
        }
    } catch (Exception $e) {
        die($e->getMessage());
    }
    }
    //funcion actualizada
    public function terminos($valor)
    {
        try 
        {
            $sql = $this->db->update("tm_empresa", ['comentario_comprobante' => $valor['dto']], "id_de = 1");

            return $sql;
        }
        catch (Exception $e){
                die($e->getMessage());
        }
    }
    //funcion actualiada
    public function terminos_listar()
    {
        try 
        {
            $stm = $this->db->selectOne("SELECT * FROM tm_empresa WHERE id_de = 1", [], PDO::FETCH_OBJ);

            return $stm;  
        }
        catch (Exception $e){
                die($e->getMessage());
        }
    }

    /* FIN MODULO EMPRESA */
    public function TipoPago()
    {
        try
        {      
            return $this->db->selectAll('SELECT * FROM tm_pago');
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }
    //funcion tipopago_list actualizado
    public function tipopago_list($data)
    {
        try
            {
            // Realizar una consulta única para obtener la información necesaria
            $sql = "SELECT tp.*, p.descripcion AS nombre 
                    FROM tm_tipo_pago tp
                    JOIN tm_pago p ON tp.id_pago = p.id_pago
                    WHERE tp.id_tipo_pago LIKE :id_pago AND tp.id_tipo_pago > 3";

            $params = ['id_pago' => $data['id_pago']];
            $stm = $this->db->selectAll($sql, $params, PDO::FETCH_OBJ);

            return ["data" => $stm];

            }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }
    //funcion actualizada
    public function tipopago_crud_create($data)
    {

        try
        {
            $array = ['id_pago' => $data['id_tipo_pago'], 'descripcion' => $data['nombre'], 'estado' => $data['estado']];
            $sql = $this->db->insert("tm_tipo_pago", $array);

            return $sql;

        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }
    //funcion atualizada
    public function tipopago_crud_update($data)
    {
        try 
        {
            $array = ['id_pago' => $data['id_tipo_pago'], 'descripcion' => $data['nombre'], 'estado' => $data['estado']];
            $sql = $this->db->update("tm_tipo_pago", $array, "id_tipo_pago = " . $data['id_pago']);

            return $sql;

        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }

    /* INICIO MODULO RESTAURANTE */

    public function caja_list()
    {
        try
        {
            $stm = $this->db->selectAll("SELECT * FROM tm_caja", [], PDO::FETCH_OBJ);
            return ["data" => $stm];
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function caja_crud_create($data)
    {
        try
        {
            $consulta = "call usp_configCajas( :flag, @a, :descripcion, :estado);";
            $arrayParam =  array(
                ':flag' => 1,
                ':descripcion' => $data['descripcion'],
                ':estado' => $data['estado']
            );
            $st = $this->db->prepare($consulta);
            $st->execute($arrayParam);
            while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
                return $row['cod'];
            }
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }

    public function caja_crud_update($data)
    {
        try 
        {
            $consulta = "call usp_configCajas( :flag, :id_caja, :descripcion, :estado);";
            $arrayParam =  array(
                ':flag' => 2,
                ':id_caja' => $data['id_caja'],
                ':descripcion' => $data['descripcion'],
                ':estado' => $data['estado']
            );
            $st = $this->db->prepare($consulta);
            $st->execute($arrayParam);
            while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
                return $row['cod'];
            }
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }
    //hasta aqui todo actualizado
    public function areaprod_list($data)
    {
        try {
            $sql = "SELECT ap.*, imp.nombre AS ImpresoraNombre
                    FROM tm_area_prod ap
                    LEFT JOIN tm_impresora imp ON ap.id_imp = imp.id_imp
                    WHERE ap.id_areap LIKE :feo";

            $stm = $this->db->selectAll($sql, ['feo' => $data['id_areap']], PDO::FETCH_OBJ);
            return ["data" => $stm];
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function areaprod_crud_create($data)
    {
        try
        {
            $consulta = "call usp_configAreasProd( :flag, @a, :id_imp, :nombre, :estado);";
            $arrayParam =  array(
                ':flag' => 1,                
                ':id_imp' => $data['id_imp'],
                ':nombre' => $data['nombre'],
                ':estado' => $data['estado']
            );
            $st = $this->db->prepare($consulta);
            $st->execute($arrayParam);
            while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
                return $row['cod'];
            }
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }

    public function areaprod_crud_update($data)
    {
        try 
        {
            $consulta = "call usp_configAreasProd( :flag, :id_areap, :id_imp, :nombre, :estado);";
            $arrayParam =  array(
                ':flag' => 2,
                ':id_areap' => $data['id_areap'],
                ':id_imp' => $data['id_imp'],
                ':nombre' => $data['nombre'],
                ':estado' => $data['estado']                
            );
            $st = $this->db->prepare($consulta);
            $st->execute($arrayParam);
            while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
                return $row['cod'];
            }
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }
    //funcion actualizada
    public function salon_list()
    {
        try {
            $sql = "SELECT s.*, COUNT(m.id_mesa) AS total_mesas
                    FROM tm_salon s
                    LEFT JOIN tm_mesa m ON s.id_salon = m.id_salon
                    GROUP BY s.id_salon
                    ORDER BY s.id_salon ASC";
    
            $stm = $this->db->selectAll($sql, [], PDO::FETCH_OBJ);
    
            return ["data" => $stm];

        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

public function mesa_list($id_salon)
{
    try {
        $sql = "SELECT m.*, s.descripcion AS SalonDescripcion
                FROM tm_mesa m
                LEFT JOIN tm_salon s ON m.id_salon = s.id_salon
                WHERE m.id_salon = :id_salons
                ORDER BY m.nro_mesa ASC";

        $stm = $this->db->selectAll($sql, ['id_salons' => $id_salon['id_salon']], PDO::FETCH_OBJ);

        return ["data" => $stm];

    } catch (Exception $e) {
        die($e->getMessage());
    }
}

    public function salon_crud_create($data)
    {
        try 
        {
            $consulta = "call usp_configSalones( :flag, @a, :descripcion, :estado);";
            $arrayParam =  array(
                ':flag' => 1,
                ':descripcion' => $data['descripcion'],
                ':estado' => $data['estado']
            );
            $st = $this->db->prepare($consulta);
            $st->execute($arrayParam);
            while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
                return $row['cod'];
            }
        }
        catch (Exception $e) 
        {
            return false;
        }
    }

    public function salon_crud_update($data)
    {
        try 
        {
            $consulta = "call usp_configSalones( :flag, :id_salon, :descripcion, :estado);";
            $arrayParam =  array(
                ':flag' => 2,
                ':id_salon' => $data['id_salon'],
                ':descripcion' => $data['descripcion'],
                ':estado' => $data['estado']
            );
            $st = $this->db->prepare($consulta);
            $st->execute($arrayParam);
            while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
                return $row['cod'];
            }
        }
        catch (Exception $e) 
        {
            return false;
        }
    }

    public function salon_crud_delete($data)
    {
        try 
        {
            $consulta = "call usp_configSalones( :flag, :id_salon, @a, @b);";
            $arrayParam =  array(
                ':flag' => 3,
                ':id_salon' => $data['id_salon']
            );
            $st = $this->db->prepare($consulta);
            $st->execute($arrayParam);
            while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
                return $row['cod'];
            }
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }

    public function mesa_crud_create($data)
    {
        try 
        {
            $consulta = "call usp_configMesas( :flag, @a, :id_salon, :nro_mesa, @b);";
            $arrayParam =  array(
                ':flag' => 1,
                ':id_salon' => $data['id_salon'],
                ':nro_mesa' => $data['nro_mesa']
            );
            $st = $this->db->prepare($consulta);
            $st->execute($arrayParam);
            while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
                return $row['cod'];
            }
        }
        catch (Exception $e) 
        {
            return false;
        }
    }

    public function mesa_crud_update($data)
    {
        try 
        {
            $consulta = "call usp_configMesas( :flag, :id_mesa, :id_salon, :nro_mesa, :estado);";
            $arrayParam =  array(
                ':flag' => 2,
                ':id_mesa' => $data['id_mesa'],
                ':id_salon' => $data['id_salon'],
                ':nro_mesa' => $data['nro_mesa'],
                ':estado' => $data['estado']                        
            );
            $st = $this->db->prepare($consulta);
            $st->execute($arrayParam);
            while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
                return $row['cod'];
            }
        }
        catch (Exception $e) 
        {
            return false;
        }
    }

    public function mesa_crud_delete($data)
    {
        try 
        {
            $consulta = "call usp_configMesas( :flag, :id_mesa, @a, @b, @c);";
            $arrayParam =  array(
                ':flag' => 3,
                ':id_mesa' => $data['id_mesa']
            );
            $st = $this->db->prepare($consulta);
            $st->execute($arrayParam);
            while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
                return $row['cod'];
            }
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }

    /*
    public function mesa_estado($data)
    {
        try 
        {
            $sql = "UPDATE tm_mesa SET estado = ? WHERE id_mesa = ?";
            $this->db->prepare($sql)->execute(array($data['est_mesa'],$data['codi_mesa']));    
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }
    */

    /* ===================================== PRODUCTO*/
    public function producto_list()
    {
        try {
            $id_prod = isset($_POST['id_prod']) ? $_POST['id_prod'] : '%'; // Obtener id_prod de $_POST o establecerlo como vacio si no esta definido
            $id_catg = isset($_POST['id_catg']) ? $_POST['id_catg'] : '%'; // Obtener id_catg de $_POST o establecerlo como vacio si no esta definido
        
            $sql = "SELECT * FROM tm_producto WHERE id_prod LIKE :id_pro AND id_catg LIKE :id_catg AND id_catg != 1 ORDER BY id_prod ASC";
            $stm = $this->db->selectAll($sql, ['id_pro' => "%$id_prod%", 'id_catg' => "%$id_catg%"], PDO::FETCH_OBJ);
        
            return ["data" => $stm];
        } catch (Exception $e) {
            // Manejar la excepcion segun tus necesidades
            throw $e;
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function producto_listSolo()
    {
        try {
            $id_prod = isset($_POST['id_prod']) ? $_POST['id_prod'] : '%';
        
            $sql = "SELECT * FROM tm_producto WHERE id_prod = :id_prod";
            $stm = $this->db->selectOne($sql, ['id_prod' => $id_prod], PDO::FETCH_OBJ);
        
            return ["data" => $stm];
        } catch (Exception $e) {
            // Manejar la excepcion segun tus necesidades
            throw $e;
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function producto_pres_list()
    {
        try {
            $id_prod = isset($_POST['id_prod']) ? $_POST['id_prod'] : '%';
            $id_pres = isset($_POST['id_pres']) ? $_POST['id_pres'] : '%';

            $sql = "SELECT pp.*, tp.id_tipo AS TipoProd FROM tm_producto_pres pp 
                                    LEFT JOIN tm_producto tp ON pp.id_prod = tp.id_prod
                                    WHERE pp.id_prod LIKE :id_pro AND pp.id_pres LIKE :id_pre";

            $stm = $this->db->selectAll($sql, ['id_pro' => $id_prod, 'id_pre' => "$id_pres"], PDO::FETCH_OBJ);

            return ["data" => $stm];
        }
        catch(Exception $e){
        die($e->getMessage());
        }
    }

    public function producto_cat_list()
    {
        try
        {
            $stm = $this->db->selectAll("SELECT * FROM tm_producto_catg WHERE id_catg != 1 ORDER BY orden ASC", [], PDO::FETCH_OBJ);

            return ["data" => $stm];

        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }
    //funcion por revisar
    public function producto_pres_ing($data)
    {
        try
        {
            $stm = $this->db->prepare("SELECT * FROM tm_producto_ingr WHERE id_pres = ?");
            $stm->execute(array($data['id_pres']));
            $c = $stm->fetchAll(PDO::FETCH_OBJ);
            foreach($c as $k => $d)
            {
                $c[$k]->{'Insumo'} = $this->db->query("SELECT ins_med,ins_nom,ins_cat FROM v_insprod WHERE id_tipo_ins = ".$d->id_tipo_ins." AND id_ins = ".$d->id_ins)
                ->fetch(PDO::FETCH_OBJ);
            }
            foreach($c as $k => $d)
            {
                $c[$k]->{'Medida'} = $this->db->query("SELECT descripcion FROM tm_tipo_medida WHERE id_med = ".$d->id_med)
                ->fetch(PDO::FETCH_OBJ);
            }
            return $c;
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }
    //actualizado
    public function producto_buscar_ins($data)
    {
        try
        {        
            $cadena = $data['cadena'];
            $tipo = $data['tipo'];
            $array = ['cade' => "%$cadena%", 'cad2' => "%$cadena%", 'tipo' => "$tipo"];
            $sql = "SELECT * FROM v_insprod WHERE (ins_nom LIKE :cade OR ins_cod LIKE :cad2) AND est_b = 'a' AND est_c = 'a' AND id_tipo_ins != :tipo ORDER BY ins_nom LIMIT 5";
            $stm = $this->db->selectAll($sql, $array, PDO::FETCH_OBJ);

            return $stm;
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function producto_cat_crud_create($data)
    {
        try 
        {
            if( !empty( $_FILES['imagen']['name'] ) ){
                switch ($_FILES['imagen']['type']) 
                { 
                    case 'image/jpeg': 
                    $ext = "jpg"; 
                    break;
                    case 'image/gif': 
                    $ext = "gif"; 
                    break; 
                    case 'image/png': 
                    $ext = "png"; 
                    break;
                    case 'application/pdf':
                    $ext = "pdf";
                    break;
                }
                $imagen = date('ymdhis').'.'.$ext;
                move_uploaded_file ($_FILES['imagen']['tmp_name'], 'public/images/productos/'.$imagen);
            } else {
                $imagen = $data['imagen'];
            }
            $consulta = "call usp_configProductoCatgs( :flag, @a, :descripcion, :delivery, :orden, :imagen, :estado);";
            $arrayParam =  array(
                ':flag' => 1,
                ':descripcion' => $data['descripcion_categoria'],
                ':delivery' => $data['hidden_delivery_categoria'],
                ':orden' => 100,
                ':imagen' => $imagen,
                ':estado' => $data['hidden_estado_categoria']
            );
            $st = $this->db->prepare($consulta);
            $st->execute($arrayParam);
            while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
                return $row['cod'];
            }
        }
        catch (Exception $e) 
        {
            return false;
        }
    }

    public function producto_cat_crud_update($data)
    {
        try 
        {
            if( !empty( $_FILES['imagen']['name'] ) ){
                switch ($_FILES['imagen']['type']) 
                { 
                    case 'image/jpeg': 
                    $ext = "jpg"; 
                    break;
                    case 'image/gif': 
                    $ext = "gif"; 
                    break; 
                    case 'image/png': 
                    $ext = "png"; 
                    break;
                    case 'application/pdf':
                    $ext = "pdf";
                    break;
                }
                $imagen = date('ymdhis').'.'.$ext;
                move_uploaded_file ($_FILES['imagen']['tmp_name'], 'public/images/productos/'.$imagen);
            } else {
                $imagen = $data['imagen'];
            }
            $consulta = "call usp_configProductoCatgs( :flag, :id_catg, :descripcion, :delivery, :orden, :imagen, :estado);";
            $arrayParam =  array(
                ':flag' => 2,
                ':id_catg' => $data['id_catg_categoria'],
                ':descripcion' => $data['descripcion_categoria'],
                ':delivery' => $data['hidden_delivery_categoria'],
                ':orden' => $data['orden_categoria'],
                ':imagen' => $imagen,
                ':estado' => $data['hidden_estado_categoria']
            );
            $st = $this->db->prepare($consulta);
            $st->execute($arrayParam);
            while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
                return $row['cod'];
            }
        }
        catch (Exception $e) 
        {
            return false;
        }
    }

    public function producto_crud_create($data)
{
    try
    {
        $consulta = "call usp_configProducto( :flag, @a, :id_tipo, :id_catg, :id_areap, :nombre, :notas, :delivery, @b);";
        $arrayParam =  array(
            ':flag' => 1,
            ':id_tipo' => $data['id_tipo'],
            ':id_catg' => $data['id_catg'],
            ':id_areap' => $data['id_areap'],
            ':nombre' => $data['nombre'],
            ':notas' => $data['notas'],
            ':delivery' => $data['delivery']
        );
        $st = $this->db->prepare($consulta);
        $st->execute($arrayParam);
        
        $row = $st->fetch(PDO::FETCH_ASSOC); // Obtener la fila del resultado
        
        if ($row) {
            return $row['cod']; // Devolver el valor
        } else {
            //return false; // Si no hay resultados
        }
        return $arrayParam;
    } catch (Exception $e) 
    {
        die($e->getMessage());
    }
}

    public function producto_crud_update($data)
    {
        try 
        {
            $consulta = "call usp_configProducto( :flag, :id_prod, :id_tipo, :id_catg, :id_areap, :nombre, :notas, :delivery, :estado);";
            $arrayParam =  array(
                ':flag' => 2,
                ':id_prod' => $data['id_prod'],
                ':id_tipo' => $data['id_tipo'],
                ':id_catg' => $data['id_catg'],
                ':id_areap' => $data['id_areap'],
                ':nombre' => $data['nombre'],
                ':notas' => $data['notas'],
                ':delivery' => $data['delivery'],
                ':estado' => $data['estado']
            );
            $st = $this->db->prepare($consulta);
            $st->execute($arrayParam);
            while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
                return $row['cod'];
            }
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }

    public function producto_pres_crud_create($data)
    {
        try 
        {
            function guardarImagen($file) {
                $extensionesPermitidas = [
                    'image/jpeg' => 'jpg',
                    'image/gif' => 'gif',
                    'image/png' => 'png',
                    'application/pdf' => 'pdf'
                ];
            
                if (!empty($file['name']) && isset($file['type'], $extensionesPermitidas[$file['type']])) {
                    $ext = $extensionesPermitidas[$file['type']];
                    $imagen = date('ymdhis') . '.' . $ext;
                    $carpetaDestino = 'public/images/productos/';
            
                    move_uploaded_file($file['tmp_name'], $carpetaDestino . $imagen);
                    return $imagen;
                } else {
                    // Si no se proporciona un archivo válido, devuelve un valor predeterminado o el valor actual de $data['imagen']
                    return isset($data['imagen']) ? $data['imagen'] : 'default.jpg';
                }
            }


            if (isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])) {
                $imagen = guardarImagen($_FILES['imagen']);
            } else {
                $imagen = isset($data['imagen']) ? $data['imagen'] : 'default.jpg';
            }
            
            $stock_min = 999;
            $stock_lim = 999;

            if($data['precio_delivery'] == ''){$precio_delivery = 0;}else{$precio_delivery = $data['precio_delivery'];}

            $consulta = "call usp_configProductoPres( :flag, @a, :id_prod, :cod_prod, :presentacion, :descripcion, :precio, :precio_delivery, :receta, :stock_min, :stock_limit, :impuesto, :delivery, :margen, :igv, :imagen, :estado);";
            $arrayParam =  array(
                ':flag' => 1,
                ':id_prod' => $data['id_prod_presentacion'],
                ':cod_prod' => $data['cod_prod_presentacion'],
                ':presentacion' => $data['presentacion_presentacion'],
                ':descripcion' => $data['descripcion_presentacion'],
                ':precio' => number_format($data['precio_presentacion'],2),
                ':precio_delivery' => number_format($precio_delivery,2),
                ':receta' => $data['hidden_receta_presentacion'],
                ':stock_min' => $stock_min,
                ':stock_limit' =>  $stock_lim,
                ':impuesto' => $data['hidden_impuesto_presentacion'],
                ':delivery' => $data['hidden_delivery_presentacion'],
                ':margen' => $data['hidden_insumo_principal_presentacion'],
                ':igv' => number_format(Session::get('igv'),2),
                ':imagen' => $imagen,
                ':estado' => $data['hidden_estado_presentacion']
            );

            $st = $this->db->prepare($consulta);
            $st->execute($arrayParam);

            $id_registro = $this->db->lastInsertId();
            while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
                return $row['cod'];
            }
        }

        catch (Exception $e) 
        {
            die($e->getMessage());
            //return $data['cod_prod_presentacion'];
            //return false;
        }
    }

    public function producto_pres_crud_update($data)
    {
        try 
        {
            if( !empty( $_FILES['imagen']['name'] ) ){
                switch ($_FILES['imagen']['type']) 
                { 
                    case 'image/jpeg': 
                    $ext = "jpg"; 
                    break;
                    case 'image/gif': 
                    $ext = "gif"; 
                    break; 
                    case 'image/png': 
                    $ext = "png"; 
                    break;
                    case 'application/pdf':
                    $ext = "pdf";
                    break;
                }
                $imagen = date('ymdhis').'.'.$ext;
                move_uploaded_file ($_FILES['imagen']['tmp_name'],'public/images/productos/'.$imagen);
            } else {
                $imagen = $data['imagen'];
            }

            
            
            $consulta = "call usp_configProductoPres( :flag, :id_pres, :id_prod, :cod_prod, :presentacion, :descripcion, :precio, :precio_delivery, :receta, :stock_min,:stock_limit, :impuesto, :delivery, :margen, :igv, :imagen, :estado);";
            $arrayParam =  array(
                ':flag' => 2,
                ':id_pres' => $data['id_pres_presentacion'],
                ':id_prod' => $data['id_prod_presentacion'],
                ':cod_prod' => $data['cod_prod_presentacion'],
                ':presentacion' => $data['presentacion_presentacion'],
                ':descripcion' => $data['descripcion_presentacion'],
                ':precio' => $data['precio_presentacion'],
                ':precio_delivery' => $data['precio_delivery'],
                ':receta' => $data['hidden_receta_presentacion'],
                ':stock_min' => $data['stock_min_presentacion'],
                ':stock_limit' => $data['hidden_stock_limit'],
                ':impuesto' => $data['hidden_impuesto_presentacion'],
                ':delivery' => $data['hidden_delivery_presentacion'],
                ':margen' => $data['hidden_insumo_principal_presentacion'],
                ':igv' => Session::get('igv'),
                ':imagen' => $imagen,
                ':estado' => $data['hidden_estado_presentacion']
            );
            $st = $this->db->prepare($consulta);
            $st->execute($arrayParam);
            while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
                return $row['cod'];
            }
        }
        catch (Exception $e) 
        {
            return false;
        }
    }

    public function producto_combo_cat()
    {
        try
        {
            $stm = $this->db->selectAll("SELECT * FROM tm_producto_catg WHERE id_catg != 1", [], PDO::FETCH_OBJ);

            return $stm;
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function producto_combo_unimed($data)
    {
        try
        {   
            $sql = "SELECT * FROM tm_tipo_medida WHERE grupo = :group OR grupo = :group2";
            $stm = $this->db->selectAll($sql, ['group' => $data['va1'], 'group2' => $data['va2']], PDO::FETCH_ASSOC);

            foreach($stm as $v){
                echo '<option value="'.$v['id_med'].'">'.$v['descripcion'].'</option>';
            }
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function producto_ingrediente_create($data)
    {
        try 
        {          
            $consulta = "call usp_configProductoIngrs( :flag, @a, :id_pres, :id_tipo_ins, :id_ins, :id_med, :cant);";
            $arrayParam =  array(
                ':flag' => 1,
                ':id_pres' => $data['id_pres'],
                ':id_tipo_ins' => $data['id_tipo_ins'],
                ':id_ins' => $data['id_ins'],
                ':id_med' => $data['id_med'],
                ':cant' => $data['cant']
            );
            $st = $this->db->prepare($consulta);
            $st->execute($arrayParam);
        }
        catch (Exception $e) 
        {
            return false;
        }
    }

    /*
    public function producto_ingrediente_update($data)
    {
        try 
        {
            $consulta = "call usp_configProductoIngrs( :flag, :idPres, :idIns, :cant, :idPi);";
            $arrayParam =  array(
                ':flag' => 2,
                ':idPres' => 1,
                ':idIns' => 1,
                ':cant' => $data['cant'],
                ':idPi' => $data['cod'],
            );
            $st = $this->db->prepare($consulta);
            $st->execute($arrayParam);
        }
        catch (Exception $e) 
        {
            return false;
        }
    }
    */

    public function producto_ingrediente_delete($data)
    {
        try 
        {
            $consulta = "call usp_configProductoIngrs( :flag, :id_pi, @a, @b, @c, @d, @e);";
            $arrayParam =  array(
                ':flag' => 3,
                ':id_pi' => $data['id_pi']
            );
            $st = $this->db->prepare($consulta);
            $st->execute($arrayParam);
        }
        catch (Exception $e) 
        {
            return false;
        }
    }

    public function producto_cat_delete($data)
    {
        try 
        {
            $consulta = "call usp_configEliminarCategoriaProd(:id_catg);";
            $arrayParam =  array(
                ':id_catg' => $data['id_catg']
            );
            $st = $this->db->prepare($consulta);
            $st->execute($arrayParam);
            while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
                return $row['cod'];
            }
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }

    /* ======================= FIN PRODUCTO */

    /* ======================= INCIO COMBO */
    public function combo_list()
    {
        try
        {
            $sql = "SELECT * FROM tm_producto WHERE id_prod like :id_prod AND id_catg = 1 ORDER BY id_prod DESC";
            $stm = $this->db->selectAll($sql, ['id_prod' => $_POST['id_prod']], PDO::FETCH_OBJ);

            return ["data" => $stm];

        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    /* ======================= FIN COMBO */

    /* ======================= INICIO INSUMO */

    public function insumo_cat_list()
    {
        try
        {
            $stm = $this->db->selectAll("SELECT * FROM tm_insumo_catg", [], PDO::FETCH_OBJ);

            return ["data" => $stm];
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function insumo_list()
    {
        try
        {
            $sql = "SELECT * FROM v_insumos WHERE id_ins like :id_ins AND id_catg like :id_catg ORDER BY id_ins DESC";
            $stm = $this->db->selectAll($sql, ['id_ins' => $_POST['id_ins'], 'id_catg' => $_POST['id_catg']], PDO::FETCH_OBJ);

            return ["data" => $stm];
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function insumo_combo_cat()
    {
        try
        {
            $stm = $this->db->selectAll("SELECT * FROM tm_insumo_catg", [], PDO::FETCH_OBJ);

            return $stm;
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function insumo_cat_crud_create($data)
    {
        try 
        {
            $consulta = "call usp_configInsumoCatgs( :flag, :descC, @a);";
            $arrayParam =  array(
                ':flag' => 1,
                ':descC' => $data['descripcion']
            );
            $st = $this->db->prepare($consulta);
            $st->execute($arrayParam);
            while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
                return $row['cod'];
            }
        }
        catch (Exception $e) 
        {
            return false;
        }
    }

    public function insumo_cat_crud_update($data)
    {
        try 
        {
            $consulta = "call usp_configInsumoCatgs( :flag, :descC, :idCatg);";
            $arrayParam =  array(
                ':flag' => 2,
                ':descC' => $data['descripcion'],
                ':idCatg' => $data['id_catg']
            );
            $st = $this->db->prepare($consulta);
            $st->execute($arrayParam);
            while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
                return $row['cod'];
            }
        }
        catch (Exception $e) 
        {
            return false;
        }
    }

    public function insumo_crud_create($data)
    {
        try
        {
            $consulta = "call usp_configInsumo( :flag, :idCatg, :idMed, :cod, :nombre, :stock, :costo, @a, @b);";
            $arrayParam =  array(
                ':flag' => 1,
                ':idCatg' => $data['id_catg'],
                ':idMed' => $data['id_med'],
                ':cod' => $data['cod_ins'],
                ':nombre' => $data['nomb_ins'],
                ':stock' => $data['stock_min'],
                ':costo' => $data['cos_uni']
            );
            $st = $this->db->prepare($consulta);
            $st->execute($arrayParam);
            while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
                return $row['cod'];
            }
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }

    public function insumo_crud_update($data)
    {
        try 
        {
            $consulta = "call usp_configInsumo( :flag, :idCatg, :idMed, :cod, :nombre, :stock, :costo, :estado, :idIns);";
            $arrayParam =  array(
                ':flag' => 2,
                ':idCatg' => $data['id_catg'],
                ':idMed' => $data['id_med'],
                ':cod' => $data['cod_ins'],
                ':nombre' => $data['nomb_ins'],
                ':stock' => $data['stock_min'],
                ':costo' => $data['cos_uni'],
                ':estado' => $data['estado'],
                ':idIns' => $data['id_ins']
            );
            $st = $this->db->prepare($consulta);
            $st->execute($arrayParam);
            while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
                return $row['cod'];
            }
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }

    public function insumo_cat_delete($data)
    {
        try 
        {
            $consulta = "call usp_configEliminarCategoriaIns(:id_catg);";
            $arrayParam =  array(
                ':id_catg' => $data['id_catg']
            );
            $st = $this->db->prepare($consulta);
            $st->execute($arrayParam);
            while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
                return $row['cod'];
            }
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }

    public function print_list($data)
    {
        try
        {
            $stm = $this->db->selectAll("SELECT * FROM tm_impresora WHERE id_imp != 1 AND id_imp LIKE :id_imp", ['id_imp' => $data['id_imp']], PDO::FETCH_OBJ);
            
            return ["data" => $stm];
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function print_crud_create($data)
    {
        try
        {
            $consulta = "call usp_configImpresoras( :flag, @a, :nombre, :estado);";
            $arrayParam =  array(
                ':flag' => 1,
                ':nombre' => $data['nombre'],
                ':estado' => $data['estado']
            );
            $st = $this->db->prepare($consulta);
            $st->execute($arrayParam);
            while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
                return $row['cod'];
            }
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }

    public function print_crud_update($data)
    {
        try 
        {
            $consulta = "call usp_configImpresoras( :flag, :id_imp, :nombre, :estado);";
            $arrayParam =  array(
                ':flag' => 2,
                ':id_imp' => $data['id_imp'],
                ':nombre' => $data['nombre'],
                ':estado' => $data['estado']
            );
            $st = $this->db->prepare($consulta);
            $st->execute($arrayParam);
            while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
                return $row['cod'];
            }
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }

    /* ======================= FIN INSUMO */

    /* FIN MODULO RESTAURANTE */

    public function optimizar_pedidos()
    {
        try
        {
            $consulta = "call usp_optPedidos(:flag);";
            $arrayParam =  array(
                ':flag' => 1
            );
            $st = $this->db->prepare($consulta);
            $st->execute($arrayParam);
            while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
                return $row['cod'];
            }
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }

    public function optimizar_ventas()
    {
        try
        {
            $consulta = "call usp_optPedidos(:flag);";
            $arrayParam =  array(
                ':flag' => 2
            );
            $st = $this->db->prepare($consulta);
            $st->execute($arrayParam);
            while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
                return $row['cod'];
            }
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }

    public function optimizar_productos()
    {
        try
        {
            $consulta = "call usp_optPedidos(:flag);";
            $arrayParam =  array(
                ':flag' => 3
            );
            $st = $this->db->prepare($consulta);
            $st->execute($arrayParam);
            while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
                return $row['cod'];
            }
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }

    public function optimizar_insumos()
    {
        try
        {
            $consulta = "call usp_optPedidos(:flag);";
            $arrayParam =  array(
                ':flag' => 4
            );
            $st = $this->db->prepare($consulta);
            $st->execute($arrayParam);
            while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
                return $row['cod'];
            }
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }

    public function optimizar_clientes()
    {
        try
        {
            $consulta = "call usp_optPedidos(:flag);";
            $arrayParam =  array(
                ':flag' => 5
            );
            $st = $this->db->prepare($consulta);
            $st->execute($arrayParam);
            while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
                return $row['cod'];
            }
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }

    public function optimizar_proveedores()
    {
        try
        {
            $consulta = "call usp_optPedidos(:flag);";
            $arrayParam =  array(
                ':flag' => 6
            );
            $st = $this->db->prepare($consulta);
            $st->execute($arrayParam);
            while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
                return $row['cod'];
            }
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }

    public function optimizar_mesas()
    {
        try
        {
            $consulta = "call usp_optPedidos(:flag);";
            $arrayParam =  array(
                ':flag' => 7
            );
            $st = $this->db->prepare($consulta);
            $st->execute($arrayParam);
            while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
                return $row['cod'];
            }
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }

    public function datosistema_data()
    {
        try
        {   
            $stm = $this->db->selectOne("SELECT * FROM tm_configuracion", [], PDO::FETCH_OBJ);

            return $stm;
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function datosistema_crud($data)
    {
        try 
        {
            $array = [
                'zona_hora' => $data['zona_hora'],
                'trib_acr' => $data['trib_acr'],
                'trib_car' => $data['trib_car'],
                'di_acr' => $data['di_acr'],
                'di_car' => $data['di_car'],
                'imp_acr' => $data['imp_acr'],
                'imp_val' => $data['imp_val'],
                'mon_acr' => $data['mon_acr'],
                'mon_val' => $data['mon_val'],
                'pc_name' => $data['pc_name'],
                'pc_ip' => $data['pc_ip'],
                'print_com' => $data['print_com'],
                'print_pre' => $data['print_pre'],
                'print_cpe' => $data['print_cpe'],
                'cod_seg' => $data['cod_seg'],
                'opc_01' => $data['opc_01'],
                'type_operation' => $data['type_operation']
            ];

            $result = $this->db->update("tm_configuracion", $array, "id_cfg = 1");


            /* ACTUALIZAR DATOS */
            Session::set('moneda', $data['mon_val']);
            Session::set('igv', $data['imp_val']);
            Session::set('tribAcr', $data['trib_acr']);
            Session::set('tribCar', $data['trib_car']);
            Session::set('diAcr', $data['di_acr']);
            Session::set('diCar', $data['di_car']);
            Session::set('impAcr', $data['imp_acr']);
            Session::set('monAcr', $data['mon_acr']);
            Session::set('zona_hor', $data['zona_hora']);
            Session::set('pc_name', $data['pc_name']);
            Session::set('pc_ip', $data['pc_ip']);
            Session::set('print_com', $data['print_com']);
            Session::set('print_pre', $data['print_pre']);
            Session::set('print_cpe', $data['print_cpe']); //funcion impresion directa 
            Session::set('cod_seg', $data['cod_seg']); //funcion codigo de seguridad 
            Session::set('opc_01', $data['opc_01']); //funcion codigo de seguridad 
            Session::set('type_operation', $data['type_operation']);

            return $result;

        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }

    //funcion anularlogo actualizado
    public function anularlogo()
    {
        try
        {    
            $array = ['logo' => null];
            $stm = $this->db->update('tm_empresa', $array, 'id_de = 1');
            if($stm['success'] === 1){
                $mensaje = 'Logo eliminado correctamente.';
            }else{
                $mensaje = 'Ocurrió un problema al eliminar la imagen.';
            }
            return ['success' => $stm['success'], 'message' => $mensaje];
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function bloqueoplataforma($data)
    {
        try
        {
            $stm = $this->db->update("tm_configuracion", ['bloqueo' => $data['tipo_bloqueo']], "id_cfg = 1");

            if($stm){
                Session::set('bloqueo_id', $data['tipo_bloqueo']); 
            }

            return $stm;
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }
    // bloqueoplataforma

    public function importarexcel()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_FILES['file'])) {
                    $archivo = $_FILES['file'];
    
                    // Verificar si se ha subido correctamente y no hay errores
                    if ($archivo['error'] === UPLOAD_ERR_OK) {
                        $rutaTemporal = 'libs/uploads/' . $archivo['name'];

                        if (move_uploaded_file($archivo['tmp_name'], $rutaTemporal)) {
                            require_once "libs/PHPExcel/Classes/PHPExcel.php";

                            $inputFileType = PHPExcel_IOFactory::identify($rutaTemporal);
                            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                            $objPHPExcel = $objReader->load($rutaTemporal);

                            /* iniciio primerlibro productos */
                            $sheet = $objPHPExcel->getSheet(0); 
                            $highestRow = $sheet->getHighestRow(); 
                            $highestColumn = $sheet->getHighestColumn();

                            $response = null;
                            $productosExito = 1;
                            $presentacionExito = 1;

                            for ($row = 2; $row <= $highestRow; $row++){ 
                                $categoria      = trim($sheet->getCell("A".$row)->getValue());
                                $nombreProducto = trim($sheet->getCell("B".$row)->getValue());
                                $codProducto    = trim($sheet->getCell("C".$row)->getValue());
                                $x_area         = trim($sheet->getCell("D".$row)->getValue());
                                $x_trasformado  = trim($sheet->getCell("E".$row)->getValue());
                                $notas        = !empty(trim($sheet->getCell("F".$row)->getValue())) ? trim($sheet->getCell("F".$row)->getValue()) : '';
                                $descripcion  = !empty(trim($sheet->getCell("G".$row)->getValue())) ? trim($sheet->getCell("G".$row)->getValue()) : '';
                                $x_delivery     = trim($sheet->getCell("H".$row)->getValue());

                                $delivery = (strtoupper($x_delivery) == 'SI') ? 1: 0;
                                $trasformado = (strtoupper($x_trasformado) == 'SI') ? 1: 0;

                                if (empty($categoria) || empty($nombreProducto) || empty($codProducto) || empty($x_area)) {
                                    $response = ['success' => false, 'message' => 'Hoja 1: Dato(s) de columna de la Fila: [' . $row . '] se encuentra vacío. Dato(s) guardado(s) hasta la fila: [' . ($row-1) . '].'];
                                    break;
                                }else{
                                    $id_areap = $this->obtenerIdAreaProducto(strtoupper($x_area));
                                    if($id_areap == null){
                                        $response = ['success' => false, 'message' => 'Hoja 1: No existe el área de producción: ' . strtoupper($x_area) . ' de la fila: ['.$row.']. Ningun Dato se registró.'];
                                        break;
                                    }else{
                                        $id_categoria = $this->obtenerIdCategoria(strtoupper($categoria));
                                        $result_productos = $this->obtenerIdProducto($codProducto, $trasformado, $id_categoria, $id_areap, strtoupper($nombreProducto), $notas, $descripcion, $delivery);
                                        if($result_productos == 1){
                                            $productosExito++;
                                        }else{
                                            $response = ['success' => false, 'message' => 'Hoja 1: No se logró registrar desde la fila: [' . $row . '].'];
                                            break;
                                        }
                                    
                                    }
                                
                                }
                            }
                            /* fin primerlibro productos */
                            if($response){
                                return $response;
                            }else{
                                /* iniciio segundolibro productos */
                                $sheetpre = $objPHPExcel->getSheet(1); 
                                $highestRowp = $sheetpre->getHighestRow(); 
                                $highestColumn = $sheetpre->getHighestColumn();
                                for ($row = 2; $row <= $highestRowp; $row++){
                                    $p_cod_producto     = trim($sheetpre->getCell("A".$row)->getValue());
                                    $p_presentacion     = trim($sheetpre->getCell("B".$row)->getValue());
                                    $p_cod_presentacion = trim($sheetpre->getCell("C".$row)->getValue());
                                    $presDescripcion    = !empty(trim($sheetpre->getCell("D".$row)->getValue())) ? trim($sheetpre->getCell("D".$row)->getValue()) : '';
                                    $p_precio           = !empty(trim($sheetpre->getCell("E".$row)->getValue())) ? trim($sheetpre->getCell("E".$row)->getValue()) : 0;
                                    $p_precio_delivery  = !empty(trim($sheetpre->getCell("F".$row)->getValue())) ? trim($sheetpre->getCell("F".$row)->getValue()) : 0;
                                    $stockMin           = !empty(trim($sheetpre->getCell("G".$row)->getValue())) ? trim($sheetpre->getCell("G".$row)->getValue()) : 0;
                                    $p_control_stock    = trim($sheetpre->getCell("H".$row)->getValue());
                                    $p_igv              = trim($sheetpre->getCell("I".$row)->getValue());
                                    $p_delivery         = trim($sheetpre->getCell("J".$row)->getValue());

                                    if((strtoupper($p_delivery) == 'SI') && ($p_precio_delivery == 0)){
                                        $response = ['success' => false, 'message' => 'Hoja 2: El precio de delivery es requerido en la fila: ['.$row.'] debe ser diferente de 0 ó vacío. Dato(s) guardado(s) hasta la fila: ['.($row-1).'].'];
                                        break;
                                    }
                                    if((strtoupper($p_control_stock) == 'SI') && ($stockMin == 0)){
                                        $response = ['success' => false, 'message' => 'Hoja 2: Se requiere un stock minimo en la fila: ['.$row.'] debe ser diferente de 0 ó vacío. Dato(s) guardado(s) hasta la fila: ['.($row-1).'].'];
                                        break;
                                    }
                                    if($p_precio == 0){
                                        $response = ['success' => false, 'message' => 'Hoja 2: Se requiere de un precio válido en la fila: ['.$row.']. Dato(s) guardado(s) hasta la fila: ['.($row-1).'].'];
                                        break;
                                    }
                                    $controlStock    = (strtoupper($p_control_stock) == 'SI') ? 1: 0;
                                    $igv             = (strtoupper($p_igv) == 'SI') ? 1: 0;
                                    $presDelivery    = (strtoupper($p_delivery) == 'SI') ? 1: 0;
                                    $igvMonto        = Session::get('igv');

                                    if (empty($p_cod_producto) || empty($p_presentacion) || empty($p_cod_presentacion) || empty($p_igv)) {
                                        $response = ['success' => false, 'message' => 'Hoja 2: En alguna columna de la Fila: [' . $row . '] se encuentra un dato vacío requerido. No se guardó ningun dato'];
                                        break;
                                    }else{
                                        $result_presentacion = $this->obtenerIdPresentacion($p_cod_producto, $p_cod_presentacion, $p_presentacion, $presDescripcion, $p_precio, $p_precio_delivery, $stockMin, $controlStock, $igv, $presDelivery);
                                        if($result_presentacion == 1){
                                            $presentacionExito++;
                                        }else{
                                            $response = ['success' => false, 'message' => 'Hoja 2: No se logró registrar la fila: [' . $row . ']. Dato(s) guardado(s) hasta la fila: ['.($row-1).'].'];
                                            break;
                                        }
                                    }

                                }
                                if($response){
                                    return $response;
                                }else{
                                    if(($productosExito == $highestRow) && ($presentacionExito == $highestRowp)){
                                        $response = ['success' => true, 'message' => '[' . $productosExito . '] Productos registrados, [' . $presentacionExito . '] Presentaciones registradas.'];
                                    }else{
                                        $response = ['success' => false, 'message' => 'No se agregaron correctamente todas las filas, revisar su formato.'];
                                    }

                                    return $response;
                                }
                            }
                        /* fin segundolibro productos */
            
                        }else{
                            return ['success' => false, 'message' => 'Error al mover el archivo.'];
                        }
                        
                    }else{
                        return ['success' => false, 'message' => 'Error al subir el archivo. Código de error: ' . $archivo['error']];
                    }
                }
                
                
            }
            
        }catch (Exception $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }

    //funcion para obtener el id_catg
    private function obtenerIdCategoria($categoria)
    {
        $sqlCategoria = $this->db->selectOne("SELECT * FROM tm_producto_catg WHERE descripcion = :categoria", ['categoria' => $categoria], PDO::FETCH_OBJ);

        if ($sqlCategoria && isset($sqlCategoria->id_catg)) {
            return $sqlCategoria->id_catg;
        } else {
            $insertCategoria = $this->db->insert("tm_producto_catg", ["descripcion" => $categoria]);
            return $this->db->lastInsertId();
        }
    }

    // Función para insertar o obtener el ID de un área de producto
    private function obtenerIdAreaProducto($area)
    {
        $sqlAreaProd = $this->db->selectOne("SELECT * FROM tm_area_prod WHERE nombre LIKE :area", ['area' => $area], PDO::FETCH_OBJ);
        
        if ($sqlAreaProd && isset($sqlAreaProd->id_areap)) {
            return $sqlAreaProd->id_areap;
        }
        
        return null;
    }
    
    //funcion para obtener e insertar datos
    private function obtenerIdProducto($codProducto, $trasformado, $idCatg, $idAreaProd, $nombre, $notas, $descripcion, $delivery)
    {
        $sqlProducto = $this->db->selectOne("SELECT * FROM tm_producto WHERE cod_pro LIKE :cod_pro", ['cod_pro' => $codProducto]);
    
        if (!$sqlProducto) {
            $insertProducto = "INSERT INTO tm_producto (id_tipo, id_catg, id_areap, nombre, notas, descripcion, delivery, cod_pro) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $arrayProducto = [$trasformado, $idCatg, $idAreaProd, $nombre, $notas, $descripcion, $delivery, $codProducto];
    
            // Comienza la transacción
            $this->db->beginTransaction();
    
            try {
                $this->db->prepare($insertProducto)->execute($arrayProducto);
                $this->db->commit();  // Confirma la transacción
    
                return 1;
            } catch (Exception $e) {
                $this->db->rollBack();  // Revierte la transacción en caso de error
                throw $e;  // Lanza la excepción para manejarla en niveles superiores
            }
        }
    
        return 0;
    }

    // Función para insertar o obtener el ID de una presentación
    private function obtenerIdPresentacion($codProducto, $codPresentacion, $presentacion, $descripcion, $precio, $precioDelivery, $stockMin, $controlStock, $igv, $delivery)
    {
        $sqlProducto = $this->db->selectOne("SELECT * FROM tm_producto WHERE cod_pro LIKE :cod_pro", ['cod_pro' => $codProducto]);
    
        if ($sqlProducto) {
            $idProducto = $sqlProducto['id_prod'];
    
            $sqlPresentacion = $this->db->selectOne("SELECT * FROM tm_producto_pres WHERE cod_prod LIKE :cod_prod", ['cod_prod' => $codPresentacion]);
    
            if (!$sqlPresentacion) {
                $insertPresentacion = "INSERT INTO tm_producto_pres (id_prod, cod_prod, presentacion, descripcion, precio, precio_delivery, receta, stock_min, crt_stock, impuesto, delivery, margen, igv)
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $arrayPresentacion = [$idProducto, $codPresentacion, $presentacion, $descripcion, $precio, $precioDelivery, 0, $stockMin, $controlStock, $igv, $delivery, 0, Session::get('igv')];
    
                // Comienza la transacción
                $this->db->beginTransaction();
    
                try {
                    $this->db->prepare($insertPresentacion)->execute($arrayPresentacion);
                    $this->db->commit();  // Confirma la transacción
    
                    return 1;
                } catch (Exception $e) {
                    $this->db->rollBack();  // Revierte la transacción en caso de error
                    throw $e;  // Lanza la excepción para manejarla en niveles superiores
                }
            }
        }
    
        return 0;
    }

    //exportar ecxel
    public function exportarexcel()
    {
        try {
            require_once "libs/PHPExcel/Classes/PHPExcel.php";

            $response_pro = $this->producto_list();
            $archivo = "public/excel/productos.xlsx";
            $objPHPExcel = PHPExcel_IOFactory::load($archivo);
            $sheet = $objPHPExcel->getSheet(0);

            $prod_contar = count($response_pro['data']);
            //print ($prod_contar);
            for ($i = 2; $i <= $prod_contar + 1; $i++) {
                $id_catg = $response_pro['data'][$i - 2]->id_catg;
                $sql_categoria = $this->db->selectOne("SELECT * FROM tm_producto_catg WHERE id_catg LIKE :id_catg", ['id_catg' => $id_catg]);
            
                if ($sql_categoria) {
                    $nom_catg[] = $sql_categoria['descripcion'];
                }
                
                // Obtener datos y asignar a los arrays correspondientes
                $nombre_pro[] = $response_pro['data'][$i - 2]->nombre;
                $cod_pro[] = $response_pro['data'][$i - 2]->cod_pro;
                $id_areap = $response_pro['data'][$i - 2]->id_areap;
                $sql_areapro = $this->db->selectOne("SELECT * FROM tm_area_prod WHERE id_areap LIKE :id_areap", ['id_areap' => $id_areap]);

                if ($sql_areapro) {
                    $nom_areap[] = $sql_areapro['nombre'];
                }

                $pro_trasformado[] = ($response_pro['data'][$i - 2]->id_tipo == '1') ? 'SI' : 'NO';
                $notas[] = $response_pro['data'][$i - 2]->notas;
                $descripcion[] = $response_pro['data'][$i - 2]->descripcion;
                $pro_delivery[] = ($response_pro['data'][$i - 2]->delivery == '1') ? 'SI' : 'NO';

                // Ingresar los datos al archivo Excel
                $sheet->setCellValue("A$i", $nom_catg[$i - 2] ?? '');
                $sheet->setCellValue("B$i", $nombre_pro[$i - 2] ?? '');
                $sheet->setCellValue("C$i", $cod_pro[$i - 2] ?? '');
                $sheet->setCellValue("D$i", $nom_areap[$i - 2] ?? '');
                $sheet->setCellValue("E$i", $pro_trasformado[$i - 2] ?? '');
                $sheet->setCellValue("F$i", $notas[$i - 2] ?? '');
                $sheet->setCellValue("G$i", $descripcion[$i - 2] ?? '');
                $sheet->setCellValue("H$i", $pro_delivery[$i - 2] ?? '');
            }

            $response_pres = $this->producto_pres_list();

            // Guardar en la segunda hoja
            $sheet2 = $objPHPExcel->getSheet(1);

            $pres_contar = count($response_pres['data']);
            for($e = 2; $e <= $pres_contar+1; $e++){
                $id_prod = $response_pres['data'][$e - 2]->id_prod;
                $sql_cod_pro = $this->db->selectOne("SELECT * FROM tm_producto WHERE id_prod LIKE :id_prod", ['id_prod' => $id_prod]);
                if($sql_cod_pro){
                    $cod_prod[] = $sql_cod_pro['cod_pro'];
                }
                $nom_pres[] = $response_pres['data'][$e - 2]->presentacion;
                $cod_pres[] = $response_pres['data'][$e - 2]->cod_prod;
                $notas_pres[] = $response_pres['data'][$e - 2]->descripcion;
                $precio_pres[] = $response_pres['data'][$e - 2]->precio;
                $precio_deli_pres[] = $response_pres['data'][$e - 2]->precio_delivery;
                $stock_min_pres[] = $response_pres['data'][$e - 2]->stock_min;
                $crt_stock_pres[] = ($response_pres['data'][$e - 2]->crt_stock == '0') ? 'NO' : 'SI';
                $igv_pres[] = ($response_pres['data'][$e - 2]->impuesto == '1') ? 'SI' : 'NO';
                $del_pres[] = ($response_pres['data'][$e - 2]->delivery == '1') ? 'SI' : 'NO';

                // Ingresar los datos al archivo Excel
                $sheet2->setCellValue("A$e", $cod_prod[$e - 2] ?? '');
                $sheet2->setCellValue("B$e", $nom_pres[$e - 2] ?? '');
                $sheet2->setCellValue("C$e", $cod_pres[$e - 2] ?? '');
                $sheet2->setCellValue("D$e", $notas_pres[$e - 2] ?? '');
                $sheet2->setCellValue("E$e", $precio_pres[$e - 2] ?? '');
                $sheet2->setCellValue("F$e", $precio_deli_pres[$e - 2] ?? '');
                $sheet2->setCellValue("G$e", $stock_min_pres[$e - 2] ?? '');
                $sheet2->setCellValue("H$e", $crt_stock_pres[$e - 2] ?? '');
                $sheet2->setCellValue("I$e", $igv_pres[$e - 2] ?? '');
                $sheet2->setCellValue("J$e", $del_pres[$e - 2] ?? '');
            }
            // Guardar el archivo Excel
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header("Content-Disposition: attachment;filename=Reporte_Productos_Totales.xlsx");
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save('php://output');

            exit;

        } catch (Exception $e) {
        die($e->getMessage());
        }
    }

    public function importarexcelinsumos()
    {   
        try {

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_FILES['file'])) {
                    $archivo = $_FILES['file'];
    
                    // Verificar si se ha subido correctamente y no hay errores
                    if ($archivo['error'] === UPLOAD_ERR_OK) {
                        $rutaTemporal = 'libs/uploads/' . $archivo['name'];

                        if (move_uploaded_file($archivo['tmp_name'], $rutaTemporal)) {
                            require_once "libs/PHPExcel/Classes/PHPExcel.php";
                            /*inicio importacion*/
                            $inputFileType = PHPExcel_IOFactory::identify($rutaTemporal);
                            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                            $objPHPExcel = $objReader->load($rutaTemporal);
                            $sheet = $objPHPExcel->getSheet(0); 
                            $highestRow = $sheet->getHighestRow(); 
                            $highestColumn = $sheet->getHighestColumn();

                            $insumosExito = 2;
                            for ($row = 2; $row <= $highestRow; $row++){ 
                                $categoria      = $sheet->getCell("A".$row)->getValue();
                                $x_nombre       = $sheet->getCell("B".$row)->getValue();
                                $x_cod          = $sheet->getCell("C".$row)->getValue();
                                $x_medida       = $sheet->getCell("D".$row)->getValue();
                                $x_stock_min    = $sheet->getCell("E".$row)->getValue();
                                $x_costo_und    = $sheet->getCell("F".$row)->getValue();

                                if (empty($categoria) || empty($x_nombre) || empty($x_cod) || empty($x_medida) || empty($x_stock_min) || empty($x_costo_und)){
                                    $response = ['success' => false, 'message' => 'En alguna columna de la Fila: ' . $row . ' se encuentra un dato vacío. Ningun dato fué guardado.'];
                                    break;
                                }else{
                                    $id_categoria = $this->obtenerIdCategoriaInsumo(trim($categoria));
                                    $id_medida = $this->obtenerIdMedida(trim($x_medida));
                                    if($id_medida == null){
                                        $response = ['success' => false, 'message' => 'No existe la unidad de medida: ' . trim($x_medida) . ' de la fila: ['.$row.']. No se guardó ningun dato.'];
                                        break;
                                    }else{
                                        $insertarInsumo = $this->insertarInsumo($id_categoria, $id_medida, trim($x_cod), trim($x_nombre), $x_stock_min, $x_costo_und);
                                        if($insertarInsumo == 1){
                                            $insumosExito++;
                                        }else{
                                            $response = ['success' => false, 'message' => 'No se logró registrar la fila: ' . $row . ' de insumos. Dato(s) guardado(s) hasta la fila: ['.($row-1).'].'];
                                            break;
                                        }
                                    }

                                }
                                
                            }
                            if($insumosExito == $highestRow){

                                $response = ['success' => true, 'message' => '[' . $insumosExito-2 . '] Insumos registrados.'];
                            }else{
                                $response = ['success' => false, 'message' => 'No se agregaron correctamente todas las filas, revisar su formato.'];
                            }
                            /*fin importacion*/
                            return $response;
                        }else{
                            return ['success' => false, 'message' => 'Error al mover el archivo.'];
                        }
                        
                    }else{
                        return ['success' => false, 'message' => 'Error al subir el archivo. Código de error: ' . $archivo['error']];
                    }
                }       
            }
            
        } catch (Exception $e) 
        {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }

    }

        //funcion para obtener el id_catg
        private function obtenerIdCategoriaInsumo($categoria)
        {
            $sqlCategoria = $this->db->selectOne("SELECT * FROM tm_insumo_catg WHERE descripcion = :categoria", ['categoria' => $categoria], PDO::FETCH_OBJ);
    
            if ($sqlCategoria && isset($sqlCategoria->id_catg)) {
                return $sqlCategoria->id_catg;
            } else {
                $insertCategoria = $this->db->insert("tm_insumo_catg", ["descripcion" => $categoria]);
                return $this->db->lastInsertId();
            }
        }

        private function obtenerIdMedida($descripcion)
    {
        $sqlIdMedida = $this->db->selectOne("SELECT * FROM tm_tipo_medida WHERE descripcion LIKE :descripcion", ['descripcion' => $descripcion], PDO::FETCH_OBJ);
        
        if ($sqlIdMedida && isset($sqlIdMedida->id_med)) {
            return $sqlIdMedida->id_med;
        }
        
        return null;
    }

    private function insertarInsumo($idCatg, $idMedida, $cod, $nombre, $stockMin, $costoUnidad)
    {
        $sqlInsumo = $this->db->selectOne("SELECT * FROM tm_insumo WHERE cod_ins LIKE :cod_ins", ['cod_ins' => $cod]);
    
            if (!$sqlInsumo) {
                $insertInsumo = "INSERT INTO tm_insumo (id_catg, id_med, cod_ins, nomb_ins, stock_min, cos_uni)
                                    VALUES (?, ?, ?, ?, ?, ?)";
                $arrayInsumo = [$idCatg, $idMedida, $cod, $nombre, $stockMin, $costoUnidad];
    
                // Comienza la transacción
                $this->db->beginTransaction();
    
                try {
                    $this->db->prepare($insertInsumo)->execute($arrayInsumo);
                    $this->db->commit();  // Confirma la transacción
    
                    return 1;
                } catch (Exception $e) {
                    $this->db->rollBack();  // Revierte la transacción en caso de error
                    throw $e;  // Lanza la excepción para manejarla en niveles superiores
                }
            }
        
    
        return 0;
    }
        

}