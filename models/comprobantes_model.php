<?php Session::init(); ?>

<?php

class Comprobantes_Model extends Model
{
    const CONTENT_TYPE_JSON = 'Content-Type: application/json';
    const CURL_HTTP_VERSION = CURL_HTTP_VERSION_1_1;

    public function __construct()
    {
        parent::__construct();
    }

    public function curl_open($url, $metodo = 'GET', $postfield = '')
    {
        $curl = curl_init();
        $headers = [
            self::CONTENT_TYPE_JSON,
            'Authorization: Bearer ' . Session::get('api_token_pro')
        ];

        curl_setopt_array($curl, array(
            CURLOPT_URL => Session::get('api_url_pro') . $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => self::CURL_HTTP_VERSION,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_CUSTOMREQUEST => $metodo,
            CURLOPT_POSTFIELDS => $postfield,
            CURLOPT_HTTPHEADER => $headers,
        ));

        $response = json_decode(curl_exec($curl));

        curl_close($curl);

        return $response;
    }

    public function RegistrarComprobante($data, $id_venta)
    {
        try
        {
            $response = $this->curl_open('/api/documents','POST',$data);

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

        }catch(Exception $e)
        {
            die($e->getMessage());
        }
    }
    
	public function ListarComprobantes()
    {
        try
        {
			//boleta 1 factura 2 DD-MM-YY
			//estado enviado a sunat 1 sin enviar 2 anulado 3
			$ifecha = date('Ymd',strtotime($_POST['ifecha']));
            $ffecha = date('Ymd',strtotime($_POST['ffecha']));
			$tipo_doc = $_POST['tdoc'];
			$estado = $_POST["estado"];
			$api_url = '/api/documents/lists/'.$ifecha.'/'.$ffecha;

			$response = $this->curl_open($api_url);
			
			//inicio array datos
			$contar = 0;
            foreach($response->data as $valor) {
	            $tiempo = explode(' ',$valor->created_at);
	            $fecha = date('d-m-Y',strtotime($tiempo[0]));
	            $hora = date('g:i A',strtotime($tiempo[1]));
	            if($valor->has_xml == true){$xml_url = $valor->download_xml;}else{$xml_url = null;}
	            if($valor->has_pdf == true){$pdf_url = $valor->download_pdf;}else{$pdf_url = null;}
	            if($valor->has_cdr == true){$cdr_url = $valor->download_cdr;}else{$cdr_url = null;}
	            $series = explode('-',$valor->number);
                $serie_name = $series[0];
                $serie_num = $series[1];

	            //DATOS A MOSTRAR
	            $array = array(
		                        "id" => $valor->id,
		                        "soap_tipo" => $valor->soap_type_id, //01 demo 02 produccion
		                        "doc_id" => $valor->document_type_id,
		                        "name_comp" => $valor->document_type_description,
		                        "serie_completa" => $valor->number,
		                        "serie_name" => $serie_name,
		                        "serie_num" => $serie_num,
		                        "nombre" => $valor->customer_name,
		                        "num_doc" => $valor->customer_number,
		                        "total" => $valor->total,
		                        "estado_doc" => $valor->state_type_id,
		                        "name_estado_doc" => $valor->state_type_description,
		                        "fecha" => $fecha,
		                        "hora" => $hora,
		                        "has_xml" => $valor->has_xml,
		                        "has_pdf" => $valor->has_pdf,
		                        "has_cdr" => $valor->has_cdr,
		                        "xml_url" => $xml_url,
		                        "pdf_url" => $pdf_url,
		                        "cdr_url" => $cdr_url,
		                        "id_externo" => $valor->external_id
		            );
	            //FIN DATOS A MOSTRAR
				$condition1 = ($tipo_doc === 'all' || $tipo_doc === $valor->document_type_id);
				$condition2 = ($estado === 'all' || $estado === $valor->state_type_id);
        
				if ($condition1 && $condition2) {
					$rest_array[] = $array;
				}
			}
		

			$json = !empty($rest_array) ? ["data" => $rest_array] : ["data" => false];

            return $json;
			//print_r(json_encode($json));	
        }
		
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }
	
	public function notificacion()
	{
		try
        {
            if(Session::get('f_pro') == 3){
			    $api_url = '/api/documents/notifications';
			    $response = $this->curl_open($api_url);
			    $array = array("total" => $response->data->documents_not_sent);

			    return $array;
            }
		}
		catch(Exception $e)
        {
            die($e->getMessage());
        }
	}
	
	public function ComunicacionBaja()
	{
        try
        {
            $metodo = 'POST';
            //datos a manejar
            $fecha = date('Y-m-d',strtotime($_POST['fecha_val']));
            $motivo = $_POST['motivo'];
            $id_externo = $_POST['id_externo'];
            $tipo_doc = $_POST['doc_id'];

            $documentos []= array(
                "external_id" => $id_externo,
                "motivo_anulacion" => $motivo
            );

            if($tipo_doc == "03")
            {
                $api_url = '/api/summaries';
                
                $datos_documentos = json_encode(array(
                                                "fecha_de_emision_de_documentos" => $fecha,
                                                "codigo_tipo_proceso" => "3",
                                                "documentos" => $documentos));

                $new_url = '/api/summaries/status';

            }else{
                $api_url = '/api/voided';

                $datos_documentos = json_encode(array(
                                                "fecha_de_emision_de_documentos" => $fecha,
                                                "documentos" => $documentos));
                
                $new_url = '/api/voided/status';
            }
            
            $response = $this->curl_open($api_url,$metodo,$datos_documentos);

            if($response->success == true)
            {
                $datos_anular = json_encode(array(
                    "external_id" => $response->data->external_id,
                    "ticket" => $response->data->ticket));

                $new_response = $this->curl_open($new_url,$metodo,$datos_anular);
                
                    if($new_response->success == true)
                    {
                        $idVenta = $this->db->selectOne("SELECT id_venta, id_pedido FROM tm_venta WHERE external_id = :id_externo", ["id_externo" => $id_externo]);
                        /*$sql1 = "UPDATE tm_inventario SET estado = 'i' WHERE id_tipo_ope = 2 AND id_ope = ?";
                        $this->db->prepare($sql1)->execute(array($idVenta["id_venta"]));*/
                        $sql2 = "UPDATE tm_venta SET estado = 'i' WHERE id_venta = ?";
                        $this->db->prepare($sql2)->execute(array($idVenta["id_venta"]));
                        $sql3 = "UPDATE tm_pedido SET estado = 'z' WHERE id_pedido = ?";
                        $this->db->prepare($sql3)->execute(array($idVenta["id_pedido"]));
                        $res = 1;
                        $mensaje = $new_response->response->description;

                    }else{
                        $res = 0;
                        $mensaje = $new_response->message;
                    }
                
            }else{
                $res = 0;
                $mensaje = $response->message;
            }

		    $respuesta = ['enviado_sunat' => $res, 'mensaje' => $mensaje];

            return $respuesta;
        }
            catch(Exception $e)
        {
            die($e->getMessage());
        }
	}

    public function Resumen_boletas_invoice()
    {
        try
        {
            $api_url = '/api/summaries';
            $metodo = 'POST';
            //inicio datos a manejar
            //if(empty($fechita)){$fecha = date('Y-m-d',strtotime($_POST['fecha']));}else{$fecha = date('Y-m-d',strtotime($fechita));}
            $fecha = date('Y-m-d',strtotime($_POST['fecha']));

            $datos_envio = json_encode(array(
                                            "fecha_de_emision_de_documentos" => $fecha,
                                            "codigo_tipo_proceso" => "1"));
            //fin datos a manejar
            $response = $this->curl_open($api_url,$metodo,$datos_envio);
            if($response->success == true)
            {
                $new_url = '/api/summaries/status';

                //inicio manejo de datos
                $new_datos_envio = json_encode(array(
                    "external_id" => $response->data->external_id,
                    "ticket" => $response->data->ticket));
                //fin manejo de datos
                $new_response = $this->curl_open($new_url, $metodo, $new_datos_envio);

                if($new_response->success == true)
                {
                    $res = 1;
                    $mensaje = $new_response->response->description;

                }else{
                    $res = 0;
                    $mensaje = $new_response->message;

                }

            }else{
                $res = 0;
                $mensaje = $response->message;
            }

            return ["enviado_sunat" => $res, "mensaje" => $mensaje];
        }
            catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function Actualiza_comprobante()
    {
        try
        {
            $api_url = '/api/documents/updatedocumentstatus';
            $metodo = 'POST';
            $external_id = $_POST['ext_id'];
            $doc = $_POST['doc'];
            $array_datos = json_encode(array("externail_id" => $external_id,"state_type_id" => "01"));

            $response = $this->curl_open($api_url, $metodo, $array_datos);

            if($response->success == true){
                $mensaje = ["actualizado" => 1,"mensaje" => "El comprobante N°: ".$doc." fué actualizado, enviar a sunat por resumen."];
            }else{
                $mensaje = ["actualizado" => 0,"mensaje" => "Ocurrió un error al intentar actualizar estado del comprobante N°: ".$doc."."];
            }

            return $mensaje;
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function pdf_factura($data)
    {
        try
        {      
            $stm = $this->db->prepare("SELECT * FROM v_ventas_con WHERE id_ven = ?");
            $stm->execute(array($data));
            $c = $stm->fetch(PDO::FETCH_OBJ);
            $c->{'Empresa'} = $this->db->query("SELECT * FROM tm_empresa")
                ->fetch(PDO::FETCH_OBJ);
            $c->{'Cliente'} = $this->db->query("SELECT * FROM v_clientes WHERE id_cliente = " . $c->id_cli)
                ->fetch(PDO::FETCH_OBJ);
            $c->{'Pedido'} = $this->db->query("SELECT vm.desc_salon, vm.nro_mesa  FROM tm_pedido_mesa AS pm INNER JOIN v_mesas AS vm ON pm.id_mesa = vm.id_mesa WHERE pm.id_pedido = " . $c->id_ped)
                ->fetch(PDO::FETCH_OBJ);
            /* Traemos el detalle */
            $c->{'Detalle'} = $this->db->query("SELECT v_productos.pro_cod AS codigo_producto, 
                CONCAT(v_productos.pro_nom,' ',v_productos.pro_pre) AS nombre_producto, 
                IF(v_productos.pro_imp='1','10','20') AS codigo_afectacion, 
                CAST(tm_detalle_venta.cantidad AS DECIMAL(7,2)) AS cantidad, 
                IF(v_productos.pro_imp='1',ROUND((tm_detalle_venta.precio/(1 + 0.18)),2),tm_detalle_venta.precio) AS valor_unitario,
                tm_detalle_venta.precio AS precio_unitario,
                IF(v_productos.pro_imp='1',ROUND((tm_detalle_venta.precio/(1 + 0.18))*tm_detalle_venta.cantidad,2),
                ROUND(tm_detalle_venta.precio*tm_detalle_venta.cantidad,2)) AS valor_venta,
                IF(v_productos.pro_imp='1',ROUND((tm_detalle_venta.precio/(1 + 0.18)*tm_detalle_venta.cantidad)*0.18,2),0) AS total_igv 
                FROM tm_detalle_venta 
                INNER JOIN tm_venta ON tm_detalle_venta.id_venta = tm_venta.id_venta 
                INNER JOIN v_productos ON tm_detalle_venta.id_prod = v_productos.id_pres 
                WHERE tm_venta.id_tipo_doc  IN ('1','2') AND tm_detalle_venta.precio > 0 AND tm_detalle_venta.id_venta = ".$data)
                ->fetchAll(PDO::FETCH_OBJ);
            return $c;
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    /*
    public function ObtenerDatosImp($data)
    {
        try
        {      
            $stm = $this->db->prepare("SELECT * FROM v_ventas_con WHERE id_ven = ?");
            $stm->execute(array($data));
            $c = $stm->fetch(PDO::FETCH_OBJ);
            $c->{'Cliente'} = $this->db->query("SELECT * FROM v_clientes WHERE id_cliente = " . $c->id_cli)
                ->fetch(PDO::FETCH_OBJ);
            $c->{'Detalle'} = $this->db->query("SELECT id_prod,SUM(cantidad) AS cantidad, precio FROM tm_detalle_venta WHERE id_venta = " . $c->id_ven." GROUP BY id_prod")
                ->fetchAll(PDO::FETCH_OBJ);
            foreach($c->Detalle as $k => $d)
            {
                $c->Detalle[$k]->{'Producto'} = $this->db->query("SELECT nombre_prod, pres_prod FROM v_productos WHERE id_pres = " . $d->id_prod)
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
}