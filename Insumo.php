<?php
// models/Insumo.php

class Insumo {
    private $conn;
    private $table_name = "insumos";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE activo = 1 ORDER BY nombre";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getByFormato($formato) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE activo = 1 AND formato = :formato ORDER BY nombre";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':formato' => $formato]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPendientesRevision() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE categoria = 'POR_REVISAR' AND activo = 1 ORDER BY id_insumo DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCountPendientes() {
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name . " WHERE categoria = 'POR_REVISAR' AND activo = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

    public function create($data) {
        $query = "INSERT INTO " . $this->table_name . " 
                  (codigo_interno, nombre, categoria, formato, unidad_medida, costo_est, areas_destino, activo) 
                  VALUES (:codigo_interno, :nombre, :categoria, :formato, :unidad_medida, :costo_est, :areas_destino, :activo)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':codigo_interno' => $data['codigo_interno'] ?? null,
            ':nombre' => $data['nombre'],
            ':categoria' => $data['categoria'],
            ':formato' => $data['formato'] ?? 'FAYB',
            ':unidad_medida' => $data['unidad_medida'],
            ':costo_est' => $data['costo_est'] ?? 0,
            ':areas_destino' => $data['areas_destino'] ?? null,
            ':activo' => isset($data['activo']) ? $data['activo'] : 1
        ]);
    }

    public function update($id, $data) {
        $query = "UPDATE " . $this->table_name . " SET 
                  codigo_interno = :codigo_interno, 
                  nombre = :nombre, 
                  categoria = :categoria, 
                  formato = :formato,
                  unidad_medida = :unidad_medida,
                  costo_est = :costo_est
                  WHERE id_insumo = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':codigo_interno' => $data['codigo_interno'],
            ':nombre' => $data['nombre'],
            ':categoria' => $data['categoria'],
            ':formato' => $data['formato'],
            ':unidad_medida' => $data['unidad_medida'] ?? null,
            ':costo_est' => $data['costo_est'] ?? 0,
            ':id' => $id
        ]);
    }

    public function updateStatus($id, $categoria, $activo) {
        $query = "UPDATE " . $this->table_name . " SET categoria = :categoria, activo = :activo WHERE id_insumo = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':categoria' => $categoria,
            ':activo' => $activo,
            ':id' => $id
        ]);
    }
}
?>
