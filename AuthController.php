<?php
// controllers/AuthController.php
require_once '../config/database.php';
require_once '../models/Usuario.php';

class AuthController {
    public function login() {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: POST");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

        $data = json_decode(file_get_contents("php://input"));

        if (!empty($data->usuario_login) && !empty($data->pwd)) {
            $database = new Database();
            $db = $database->getConnection();
            $usuario = new Usuario($db);

            $result = $usuario->login($data->usuario_login, $data->pwd);

            if ($result) {
                http_response_code(200);
                echo json_encode(array(
                    "status" => "success",
                    "data" => $result
                ));
            } else {
                http_response_code(401);
                echo json_encode(array("status" => "error", "message" => "Credenciales incorrectas o usuario inactivo."));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("status" => "error", "message" => "Datos incompletos."));
        }
    }
}
?>
