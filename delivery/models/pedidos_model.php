<?php

class Pedidos_Model extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function pedidos_list($data)
    {
        try
        {
            $estado = ($data['estado'] == 'd') ? " AND estado_pedido = 'd'" : " AND estado_pedido != 'd'";
            $sql = "SELECT *, (SELECT IFNULL(SUM(precio*cantidad),0) FROM v_det_delivery WHERE estado != 'z' AND id_pedido = tm_pedido.id_pedido) AS Monto FROM v_pedido_delivery WHERE telefono_cliente = :telefono_cliente".$estado;
            $response = $this->db->selectAll($sql, ['telefono_cliente' => $data['telefono_cliente']], PDO::FETCH_OBJ);

            return ["data" => $response];

        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function pedidos_productos_list($data)
    {
        try
        {
            $sql = "SELECT d.cantidad, d.precio, d.nombre_prod, d.pres_prod, p.estado FROM v_det_delivery AS d INNER JOIN tm_pedido AS p ON d.id_pedido = p.id_pedido WHERE d.id_pedido = :id_pedido";
            $response = $this->db->selectAll($sql, ['id_pedido' => $data['id_pedido']], PDO::FETCH_OBJ);
            
            return $response;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}