<?php

class Checkout_Model extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function run($data)
    {
        $sql = "SELECT id_cliente, nombre AS nombre_cliente, telefono AS telefono_cliente, direccion AS direccion_cliente, referencia AS referencia_cliente FROM v_clientes WHERE estado != 'i' AND telefono = :telefono";
        $response = $this->db->selectAll($sql, ['telefono' => $data['userlogin']], PDO::FETCH_OBJ);

        return $response;
    }

    public function cliente_crud_create($data)
    {
        try 
        {
            $consulta = "call usp_restRegCliente( :flag, @a, :tipo_cliente, :dni, :ruc, :ape_paterno, :ape_materno, :nombres, :razon_social, :telefono, :fecha_nac, :correo, :direccion, :referencia);";

            $arrayParam =  array(
                ':flag' => 1,
                ':tipo_cliente' => 1,
                ':dni' => $data['dni'],
                ':ruc' => '',
                ':ape_paterno' => $data['ape_paterno'],
                ':ape_materno' => $data['ape_materno'],
                ':nombres' => $data['nombres'],
                ':razon_social' => '',
                ':telefono' => $data['telefono'],
                ':fecha_nac' => '',
                ':correo' => '',
                ':direccion' => $data['direccion'],
                ':referencia' => $data['referencia']
            );

            $row = $this->db->executeProcedure($consulta, $arrayParam);

            return $row;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function RegistrarPedido($data)
    {
        try
        {
            date_default_timezone_set('America/Lima');
            setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
            $fecha = date("Y-m-d H:i:s");

            $pedido_programado = ($data['hora_entrega'] == 2) ? '' : 1;
            $hora_entrega = ($data['hora_entrega'] == 2) ? '00:00:00' : $data['hora_entrega'];

            $consulta = "call usp_restRegDelivery( :flag, :tipo_canal, :id_tipo_pedido, :id_apc, :id_usu, :fecha_pedido, :id_cliente, :id_repartidor, :tipo_entrega, :tipo_pago, :pedido_programado, :hora_entrega, :nombre_cliente, :telefono_cliente, :direccion_cliente, :referencia_cliente, :email_cliente);";

            $arrayParam =  array(
                ':flag' => 1,
                ':tipo_canal' => 2,
                ':id_tipo_pedido' => 3,
                ':id_apc' => '',
                ':id_usu' => 1,
                ':fecha_pedido' => $fecha,
                ':id_cliente' => $data['id_cliente'],
                ':id_repartidor' => 1,
                ':tipo_entrega' => $data['tipo_entrega'],
                ':tipo_pago' => $data['tipo_pago'],
                ':pedido_programado' => $pedido_programado,
                ':hora_entrega' => $hora_entrega,
                ':nombre_cliente' => $data['nombre_cliente'],
                ':telefono_cliente' => $data['telefono_cliente'],
                ':direccion_cliente' => $data['direccion_cliente'],
                ':referencia_cliente' => $data['referencia_cliente'],
                ':email_cliente' => $data['email_cliente']
            );

            $row = $this->db->executeProcedure($consulta, $arrayParam);

            foreach ($data['detalle_pedido'] as $d)
            {
                $sql = "INSERT INTO tm_detalle_pedido (id_pedido, id_usu, id_pres, cantidad, cant, precio, comentario, fecha_pedido, estado) VALUES (?,?,?,?,?,?,?,?,?);";
                $this->db->prepare($sql)->execute(array(
                    $row['id_pedido'],
                    1,
                    $d['id'],
                    $d['cantidad'],
                    $d['cantidad'],
                    $d['precio'],
                    $d['nota'],
                    $fecha,
                    'y'));
            }

            return;

        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}