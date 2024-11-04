<?php Session::init(); ?>
<?php

class Api_Model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

    public function realizarConsulta($url, $token, $parametro)
    {
        try {
            $urlCompleta = $url . $parametro . '?api_token=' . $token;
            
            $ch = curl_init($urlCompleta);
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_SSL_VERIFYPEER => false,
            ]);
    
            $response = curl_exec($ch);
            $err = curl_error($ch);
            curl_close($ch);
    
            $res = json_decode($response, true);
    
            if (isset($res['success']) && $res['success']) {
                return $res['data'] ?? null;
            } else {
                return null;
            }
        } catch (Exception $e) {
            // Personaliza el manejo de errores según tus necesidades
            die($e->getMessage());
        }
    }
    
    public function dni($token, $dni)
    {
        $urlDNI = 'https://apiperu.dev/api/dni/';
        $parametro = $dni;
        return $this->procesarRespuesta($urlDNI, $token, $parametro, 'DNI');
    }
    
    public function ruc($token, $ruc)
    {
        $urlRUC = 'https://apiperu.dev/api/ruc/';
        $parametro = $ruc;
        return $this->procesarRespuesta($urlRUC, $token, $parametro, 'RUC');
    }
    
    private function procesarRespuesta($url, $token, $parametro, $metodo)
    {
        $respuesta = $this->realizarConsulta($url, $token, $parametro);
        
        if($metodo == 'RUC'){
            if ($respuesta !== null) {
                return [
                    'ruc'               => $respuesta['ruc'] ?? null,
                    'razonSocial'       => $respuesta['nombre_o_razon_social'] ?? null,
                    'nombreComercial'   => null,
                    'estado'            => $respuesta['estado'] ?? null,
                    'condicion'         => $respuesta['condicion'] ?? null,
                    'direccion'         => $respuesta['direccion_completa'] ?? '',
                    'departamento'      => $respuesta['departamento'] ?? '',
                    'provincia'         => $respuesta['provincia'] ?? '',
                    'distrito'          => $respuesta['distrito'] ?? '',
                    'ubigeo'            => $respuesta['ubigeo_sunat'] ?? '',
                ];
            }

        }else{
            if($respuesta !== null){
                return [
                        'dni'               => $respuesta['numero'] ?? null,
                        'nombres'           => $respuesta['nombres'] ?? null,
                        'apellidoPaterno'   => $respuesta['apellido_paterno'] ?? null,
                        'apellidoMaterno'   => $respuesta['apellido_materno'] ?? null,
                        'codVerifica'       => $respuesta['codigo_verificacion'] ?? null,
                        'direccion'         => $respuesta['direccion_completa'] ?? null,
                        'fechaNacimiento'   => $respuesta['fecha_nacimiento'] ?? null,
                ];
            }

        }
    }

    public function liberarbloqueo()
    {
        try
        {    

            $ds = $this->db->prepare("SELECT bloqueo FROM tm_configuracion");
			$ds->execute();
			$data_s = $ds->fetch();

            if(Session::get('rol') == 1){
				Session::set('bloqueo', '0');
				Session::set('bloqueo_id', $data_s['bloqueo']);
			}else{
				Session::set('bloqueo', $data_s['bloqueo']); 
				Session::set('bloqueo_id', $data_s['bloqueo']); 
			}
            if($data_s['bloqueo'] == 0 ){
                return ["status" => "liberado"];
            }else{
                return ["status" => "bloqueado"];
            }

        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }
}