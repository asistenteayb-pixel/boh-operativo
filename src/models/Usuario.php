<?php
// models/Usuario.php

class Usuario {
    private $conn;
    private $table_name = "usuarios";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function login($username, $password) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE usuario_login = :username LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Asumiendo que la contraseña original no estaba hasheada en Supabase según el script,
        // En un entorno de producción debería usarse password_verify.
        $storedPassword = $user['pass'] ?? $user['pwd'] ?? null;
        if ($user && $storedPassword === $password && $user['activo'] == 1) {
            unset($user['pass'], $user['pwd']); // Removemos la contraseña de la respuesta
            return $user;
        }
        return false;
    }

    public function getAll() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY nombre_completo";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $query = "INSERT INTO " . $this->table_name . " (nombre_completo, usuario_login, pass, pwd, rol, area, turno_cocinero) 
                  VALUES (:nombre, :login, :pass, :pwd, :rol, :area, :turno)";
        $stmt = $this->conn->prepare($query);
        $pass = $data['pass'] ?? $data['pwd'];
        return $stmt->execute([
            ':nombre' => $data['nombre_completo'],
            ':login' => $data['usuario_login'],
            ':pass' => $pass,
            ':pwd' => $pass,
            ':rol' => $data['rol'],
            ':area' => $data['area'] ?? null,
            ':turno' => $data['turno_cocinero'] ?? ($data['turno'] ?? null)
        ]);
    }

    public function update($id, $data) {
        $query = "UPDATE " . $this->table_name . " SET 
                    nombre_completo = :nombre, 
                    usuario_login = :login, 
                    rol = :rol, 
                    area = :area, 
                    turno_cocinero = :turno";
        
        if (!empty($data['pass']) || !empty($data['pwd'])) {
            $query .= ", pass = :pass, pwd = :pwd";
        }
        $query .= " WHERE id_usuario = :id";

        $stmt = $this->conn->prepare($query);
        $params = [
            ':nombre' => $data['nombre_completo'],
            ':login' => $data['usuario_login'],
            ':rol' => $data['rol'],
            ':area' => $data['area'] ?? null,
            ':turno' => $data['turno_cocinero'] ?? ($data['turno'] ?? null),
            ':id' => $id
        ];
        if (!empty($data['pass']) || !empty($data['pwd'])) {
            $pass = $data['pass'] ?? $data['pwd'];
            $params[':pass'] = $pass;
            $params[':pwd'] = $pass;
        }
        return $stmt->execute($params);
    }

    public function toggleStatus($id, $activo) {
        $query = "UPDATE " . $this->table_name . " SET activo = :activo WHERE id_usuario = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([':activo' => $activo, ':id' => $id]);
    }
}
?>
