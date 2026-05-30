<?php
// models/Configuracion.php

class Configuracion {
    private $conn;
    private $table_name = "configuraciones";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        $configs = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $configs[$row['clave']] = $row['valor'];
        }
        return $configs;
    }

    public function upsert($clave, $valor) {
        $query = "INSERT INTO " . $this->table_name . " (clave, valor) VALUES (:clave, :valor)
                  ON DUPLICATE KEY UPDATE valor = :valor2";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':clave' => $clave,
            ':valor' => $valor,
            ':valor2' => $valor
        ]);
    }
}
?>
