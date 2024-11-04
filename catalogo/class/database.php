<?php
class func{
  private $db;

  public function __construct(){
    $this->conectar();
  }

  private function conectar(){
    try {
        $dsn = DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
        $this->db = new PDO($dsn, DB_USER, DB_PASS);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        // Log o manejo de errores más sofisticado
        throw new Exception("Error al conectar a la base de datos: " . $e->getMessage());
    }
}

  public function listar_datos($tabla, $condiciones = "", $orden = "", $method = "fetchAll"){
    try {
        $sql = "SELECT * FROM $tabla";
        if (!empty($condiciones)) {
            $sql .= " WHERE $condiciones";
        }
        if (!empty($orden)) {
            $sql .= " ORDER BY $orden";
        }

        $stm = $this->db->prepare($sql);
        $stm->execute();

        if ($method === "fetchAll") {
            $result = $stm->fetchAll(PDO::FETCH_OBJ);
        } elseif ($method === "fetch") {
            $result = $stm->fetch(PDO::FETCH_OBJ);
        } else {
            throw new Exception("Método de recuperación de datos no válido.");
        }

        return $result;
    } catch(Exception $e) {
        throw new Exception("Error al listar datos: " . $e->getMessage());
    }
  }
}