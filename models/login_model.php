<?php

class Login_Model extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function run()
    {
        try {
            $sql = "SELECT * FROM tm_usuario WHERE usuario = :usuario AND contrasena = :password AND estado = 'a'";

            $data = [
                'usuario' => $_POST['usuario'],
                "password" => base64_encode($_POST['password'])
            ];

            $data_u = $this->db->selectOne($sql, $data);

            if ($data_u) {

                Session::init();

                /*session usuario */
                Session::set('loggedIn', true);
                Session::set('rol', $data_u['id_rol']);
		        Session::set('usuid', $data_u['id_usu']);
		        Session::set('areaid', $data_u['id_areap']);
		        Session::set('nombres', $data_u['nombres']);
		        Session::set('apellidos', $data_u['ape_paterno'].' '.$data_u['ape_materno']);
		        Session::set('imagen', $data_u['imagen']);
                

                /*session empresa */
                $data_e = $this->db->selectOne("SELECT * FROM tm_empresa");

                Session::set('ruc', $data_e['ruc']);
		        Session::set('raz_soc', $data_e['razon_social']);
		        Session::set('modo', $data_e['modo']);

		        if($data_e['sunat'] == 3){
			        Session::set('api_url_pro', $data_e['api_url_pro']);
			        Session::set('api_token_pro', $data_e['api_token_pro']);
			        Session::set('f_pro', $data_e['sunat']);
			    }

                /*session configuracion */
                $data_s = $this->db->selectOne("SELECT * FROM tm_configuracion");

                Session::set('zona_hor', $data_s['zona_hora']);
		        Session::set('moneda', $data_s['mon_val']);
		        Session::set('igv', ($data_s['imp_val']));
		        Session::set('tribAcr', $data_s['trib_acr']);
		        Session::set('tribCar', $data_s['trib_car']);
		        Session::set('diAcr', $data_s['di_acr']);
		        Session::set('diCar', $data_s['di_car']);
		        Session::set('impAcr', $data_s['imp_acr']);
		        Session::set('monAcr', $data_s['mon_acr']);
		        Session::set('pc_name', $data_s['pc_name']);
		        Session::set('pc_ip', $data_s['pc_ip']);
		        Session::set('print_com', $data_s['print_com']);
		        Session::set('print_pre', $data_s['print_pre']);
		        Session::set('print_cpe', $data_s['print_cpe']);
		        Session::set('cod_seg', $data_s['cod_seg']);
		        Session::set('opc_01', $data_s['opc_01']);
		        Session::set('opc_02', $data_s['opc_02']);
		        Session::set('opc_03', $data_s['opc_03']);

                /*seccion blockeo */
                if ($data_u['id_rol'] == 1) {
                    Session::set('bloqueo', '0');
                    Session::set('bloqueo_id', $data_s['bloqueo']);
                } else {
                    Session::set('bloqueo', $data_s['bloqueo']);
                    Session::set('bloqueo_id', $data_s['bloqueo']);
                }

                return $this->checkApertura($data_u['id_usu'], $data_u['id_rol']);

            } else {
                return 4; // Usuario no encontrado
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    private function checkApertura($id_usu, $id_rol)
    {
        if (in_array($id_rol, [1, 2, 3])) {

            $data_a = $this->db->selectOne("SELECT * FROM tm_aper_cierre WHERE id_usu = :id_usu AND estado = 'a'", ['id_usu' => $id_usu]);

            if ($data_a) {
                Session::set('aperturaIn', true);
                Session::set('apcid', $data_a['id_apc']);
            } else {
                Session::set('aperturaIn', false);
            }

            return ($id_rol == 3) ? 3 : 1;

        } elseif ($id_rol == 4 || $id_rol == 5) {
            Session::set('aperturaIn', true);
            return ($id_rol == 4) ? 2 : 3;
        }

    }
}