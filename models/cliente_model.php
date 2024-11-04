<?php

class Cliente_Model extends Model {

	public function __construct() {
		parent::__construct();
	}
	
    public function cliente_list($data)
    {
        try
        {   
            $response = $this->db->selectAll("SELECT * FROM v_clientes WHERE id_cliente != 1 AND tipo_cliente = :tipo_cliente", ['tipo_cliente' => $data['tipo_cliente']], PDO::FETCH_OBJ);
            return ["data" => $response];
        } catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function cliente_datos($data)
    {
        try 
        {
            $response = $this->db->selectAll("SELECT * FROM tm_cliente WHERE id_cliente = :id_cliente", ['id_cliente' => $data['id_cliente']], PDO::FETCH_OBJ);
            return ["data" => $response];
        } catch (Exception $e) 
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
                $row = $st->fetch(PDO::FETCH_ASSOC);
                return $row;
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
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function cliente_ventas($data)
    {
        try
        {   
            $response = $this->db->selectAll("SELECT *,IFNULL((pago_efe+pago_tar),0) AS monto_total FROM v_ventas_con WHERE id_cli = :id_cli AND estado = 'a'", ['id_cli' => $data['id_cliente']], PDO::FETCH_OBJ);
            return ["data" => $response];
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function cliente_estado($data)
    {
        try 
        {
            $datos = ["estado" => $data['estado'], "id_cliente" => $data['id_cliente']];
            $response = $this->db->update("tm_cliente", $datos);
            return $response;
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }

    public function cliente_delete($data)
    {
        try 
        {
            $consulta = "DELETE FROM tm_cliente WHERE id_cliente = :id_cliente AND NOT EXISTS (SELECT 1 FROM tm_venta WHERE id_cliente = :id_cliente)";
            $stm = $this->db->prepare($consulta);
            $stm->bindParam(':id_cliente', $data['id_cliente'], PDO::PARAM_INT);
            $stm->execute();
    
            if ($stm->rowCount() > 0) {
                return 1; // Éxito
            } else {
                return 0; // No se encontró el cliente o hay ventas asociadas
            }
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }

}