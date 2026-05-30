<?php
// models/Solicitud.php

class Solicitud {
    private $conn;
    private $table_name = "solicitudes";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getActivas() {
        $query = "SELECT s.*, u.nombre_completo as solicitante_nombre 
                  FROM " . $this->table_name . " s
                  LEFT JOIN usuarios u ON s.id_cocinero = u.id_usuario
                  WHERE s.estado != 'CONFIRMADO_COMPL' 
                  ORDER BY s.hora_solicitud ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $solicitudes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Fetch details for each
        foreach($solicitudes as &$sol) {
            $sol['detalle_solicitud'] = $this->getDetalles($sol['id_solicitud']);
        }
        return $solicitudes;
    }

    public function getMisSolicitudes($id_usuario) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_cocinero = :id_usuario ORDER BY id_solicitud DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':id_usuario' => $id_usuario]);
        $solicitudes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach($solicitudes as &$sol) {
            $sol['detalle_solicitud'] = $this->getDetalles($sol['id_solicitud']);
        }
        return $solicitudes;
    }

    private function getDetalles($id_solicitud) {
        $query = "SELECT ds.*, i.nombre, i.unidad_medida 
                  FROM detalle_solicitud ds
                  LEFT JOIN insumos i ON ds.id_insumo = i.id_insumo
                  WHERE ds.id_solicitud = :id_solicitud";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':id_solicitud' => $id_solicitud]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data, $detalles) {
        try {
            $this->conn->beginTransaction();

            $query = "INSERT INTO " . $this->table_name . " 
                      (radicado, id_cocinero, servicio, area_solicitante, turno_cocinero, estado) 
                      VALUES (:radicado, :id_cocinero, :servicio, :area_solicitante, :turno_cocinero, 'PENDIENTE')";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([
                ':radicado' => $data['radicado'],
                ':id_cocinero' => $data['id_cocinero'],
                ':servicio' => $data['servicio'],
                ':area_solicitante' => $data['area_solicitante'],
                ':turno_cocinero' => $data['turno_cocinero']
            ]);

            $id_solicitud = $this->conn->lastInsertId();

            $queryDet = "INSERT INTO detalle_solicitud (id_solicitud, id_insumo, cantidad_solicitada) 
                         VALUES (:id_solicitud, :id_insumo, :cantidad)";
            $stmtDet = $this->conn->prepare($queryDet);

            foreach($detalles as $det) {
                $stmtDet->execute([
                    ':id_solicitud' => $id_solicitud,
                    ':id_insumo' => $det['id_insumo'],
                    ':cantidad' => $det['req']
                ]);
            }

            $this->conn->commit();
            return $id_solicitud;
        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    public function updateEstado($id_solicitud, $estado, $id_ctrl = null) {
        $updates = "estado = :estado";
        $params = [':estado' => $estado, ':id_solicitud' => $id_solicitud];
        
        if ($estado === 'ACEPTADO') {
            $updates .= ", id_ctrl_cocina = :id_ctrl, hora_aceptacion = CURRENT_TIMESTAMP";
            $params[':id_ctrl'] = $id_ctrl;
        } elseif ($estado === 'EN_DESPACHO') {
            $updates .= ", hora_proceso = CURRENT_TIMESTAMP";
        } elseif ($estado === 'DESPACHADO') {
            $updates .= ", hora_despacho = CURRENT_TIMESTAMP";
        } elseif (strpos($estado, 'CONFIRMADO') !== false) {
            $updates .= ", hora_confirmacion = CURRENT_TIMESTAMP";
        }

        $query = "UPDATE " . $this->table_name . " SET $updates WHERE id_solicitud = :id_solicitud";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute($params);
    }
}
?>
