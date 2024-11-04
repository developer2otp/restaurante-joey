<?php

class Home_Model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function listarCategorias()
    {
        try
        {   
            $response = $this->db->selectAll("SELECT * FROM tm_producto_catg WHERE estado = 'a' AND delivery = 1", [], PDO::FETCH_OBJ);
            return $response;

            $configData = $this->db->selectOne("SELECT * FROM tm_empresa");
            if($configData){
                Session::init();
                Session::set('moneda', $configData['mon_val']);
                Session::set('digDoc', $configData['di_car']);
            }

        } catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function defaultdata()
    {
        try
        {   
            $response = $this->db->selectOne("SELECT * FROM tm_empresa", [], PDO::FETCH_OBJ);

            return $response;
        } catch(Exception $e){
            die($e->getMessage());
        }
    }

}