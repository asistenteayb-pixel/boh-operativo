<?php
// api/proxy.php
require_once '../config/database.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data['table'])) {
    echo json_encode(['data' => null, 'error' => 'Invalid query']);
    exit;
}

$table = preg_replace('/[^a-zA-Z0-9_]/', '', $data['table']);
$action = $data['action'];
$conditions = $data['conditions'] ?? [];
$orders = $data['orders'] ?? [];
$limit = $data['limitVal'] ?? null;
$payload = $data['data'] ?? null;
$select = $data['select'] ?? '*';

$db = (new Database())->getConnection();

function buildWhereClause($conditions, &$params, $table, $baseAlias = '') {
    $where = [];
    foreach ($conditions as $i => $cond) {
        $rawCol = $cond['col'];
        $col = preg_replace('/[^a-zA-Z0-9_]/', '', $rawCol);
        if ($table === 'detalle_solicitud' && strpos($rawCol, 'solicitudes.') === 0) {
            $col = 's.' . preg_replace('/[^a-zA-Z0-9_]/', '', substr($rawCol, strlen('solicitudes.')));
        } elseif ($table === 'detalle_solicitud' && strpos($rawCol, 'insumos.') === 0) {
            $col = 'i.' . preg_replace('/[^a-zA-Z0-9_]/', '', substr($rawCol, strlen('insumos.')));
        } elseif ($baseAlias) {
            $col = $baseAlias . '.' . $col;
        }

        $pName = ":p$i";
        if ($cond['type'] === 'eq') { $where[] = "$col = $pName"; $params[$pName] = $cond['val']; }
        if ($cond['type'] === 'neq') { $where[] = "$col != $pName"; $params[$pName] = $cond['val']; }
        if ($cond['type'] === 'gte') { $where[] = "$col >= $pName"; $params[$pName] = $cond['val']; }
        if ($cond['type'] === 'lte') { $where[] = "$col <= $pName"; $params[$pName] = $cond['val']; }
        if ($cond['type'] === 'in' && is_array($cond['valArr'])) {
            $inSlots = [];
            foreach($cond['valArr'] as $j => $v) {
                $slot = ":pin_{$i}_{$j}";
                $inSlots[] = $slot;
                $params[$slot] = $v;
            }
            if (count($inSlots) > 0) $where[] = "$col IN (" . implode(',', $inSlots) . ")";
        }
    }
    return $where;
}

// Basic error checking
if (!$db) {
    echo json_encode(['data' => null, 'error' => 'DB Connection failed']);
    exit;
}

try {
    if ($action === 'select') {
        if ($table === 'detalle_solicitud' && (strpos($select, 'solicitudes!') !== false || strpos($select, 'insumos(') !== false)) {
            $sql = "SELECT d.* FROM detalle_solicitud d";
            if (strpos($select, 'solicitudes!') !== false) $sql .= " LEFT JOIN solicitudes s ON d.id_solicitud = s.id_solicitud";
            if (strpos($select, 'insumos(') !== false) $sql .= " LEFT JOIN insumos i ON d.id_insumo = i.id_insumo";

            $params = [];
            $where = buildWhereClause($conditions, $params, $table, 'd');
            if (count($where) > 0) $sql .= " WHERE " . implode(' AND ', $where);
            if ($limit) $sql .= " LIMIT " . intval($limit);

            $stmt = $db->prepare($sql);
            $stmt->execute($params);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($result as &$row) {
                if (strpos($select, 'insumos(') !== false) {
                    $stmtI = $db->prepare("SELECT * FROM insumos WHERE id_insumo = ?");
                    $stmtI->execute([$row['id_insumo']]);
                    $row['insumos'] = $stmtI->fetch(PDO::FETCH_ASSOC);
                }
                if (strpos($select, 'solicitudes!') !== false) {
                    $stmtS = $db->prepare("SELECT * FROM solicitudes WHERE id_solicitud = ?");
                    $stmtS->execute([$row['id_solicitud']]);
                    $row['solicitudes'] = $stmtS->fetch(PDO::FETCH_ASSOC);
                }
            }

            echo json_encode(['data' => $result, 'error' => null]);
            exit;
        }

        // Handle joins loosely for our specific case if needed, but standard select
        // In the original, there are some selects like "*, usuarios!..." which are complex joins.
        // For this proxy, let's keep it simple. If it has complex joins, we might need custom logic.
        $sql = "SELECT * FROM $table"; // ignoring complex select for now to avoid sql injection and parsing complexity, most are *
        
        $params = [];
        $where = buildWhereClause($conditions, $params, $table);
        
        if (count($where) > 0) {
            $sql .= " WHERE " . implode(' AND ', $where);
        }
        
        if (count($orders) > 0) {
            $orderStrings = [];
            foreach ($orders as $ord) {
                $col = preg_replace('/[^a-zA-Z0-9_]/', '', $ord['col']);
                $dir = (isset($ord['opts']['ascending']) && !$ord['opts']['ascending']) ? 'DESC' : 'ASC';
                $orderStrings[] = "$col $dir";
            }
            $sql .= " ORDER BY " . implode(', ', $orderStrings);
        }
        
        if ($limit) {
            $sql .= " LIMIT " . intval($limit);
        }

        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Custom join logic specifically for this app
        if ($table === 'solicitudes' && strpos($select, 'usuarios!') !== false) {
            foreach ($result as &$row) {
                $stmtU = $db->prepare("SELECT nombre_completo FROM usuarios WHERE id_usuario = ?");
                $stmtU->execute([$row['id_cocinero']]);
                $row['solicitante'] = $stmtU->fetch(PDO::FETCH_ASSOC);
                $row['usuarios'] = $row['solicitante'];

                if ($row['id_ctrl_cocina']) {
                    $stmtU2 = $db->prepare("SELECT nombre_completo FROM usuarios WHERE id_usuario = ?");
                    $stmtU2->execute([$row['id_ctrl_cocina']]);
                    $row['autorizador'] = $stmtU2->fetch(PDO::FETCH_ASSOC);
                } else {
                    $row['autorizador'] = null;
                }

                if (strpos($select, 'detalle_solicitud') !== false) {
                    $stmtD = $db->prepare("SELECT d.*, i.nombre, i.unidad_medida FROM detalle_solicitud d LEFT JOIN insumos i ON d.id_insumo = i.id_insumo WHERE d.id_solicitud = ?");
                    $stmtD->execute([$row['id_solicitud']]);
                    $detalles = $stmtD->fetchAll(PDO::FETCH_ASSOC);
                    foreach($detalles as &$det) {
                        $det['insumos'] = ['nombre' => $det['nombre'], 'unidad_medida' => $det['unidad_medida']];
                    }
                    $row['detalle_solicitud'] = $detalles;
                }
            }
        } else if ($table === 'formularios_historial' && strpos($select, 'usuarios(') !== false) {
             foreach ($result as &$row) {
                $stmtU = $db->prepare("SELECT nombre_completo FROM usuarios WHERE id_usuario = ?");
                $stmtU->execute([$row['id_usuario']]);
                $row['usuarios'] = $stmtU->fetch(PDO::FETCH_ASSOC);
             }
        } else if ($table === 'detalle_formularios' && strpos($select, 'insumos(') !== false) {
             foreach ($result as &$row) {
                $stmtU = $db->prepare("SELECT * FROM insumos WHERE id_insumo = ?");
                $stmtU->execute([$row['id_insumo']]);
                $row['insumos'] = $stmtU->fetch(PDO::FETCH_ASSOC);
             }
        }

        // if single limit is 1, original supabase sometimes returns object, sometimes array. 
        // original `limit(1)` with `.select()` returns array in supabase v2, but .single() returns object.
        // We'll just return the array to be safe, standard supabase returns array for limit(1) unless .single() is called.
        // Wait, original code uses `limit(1)` and then gets `data[0]` usually, or just `data`.

        echo json_encode(['data' => $result, 'error' => null]);
    }
    
    else if ($action === 'insert') {
        $isBulk = is_array($payload) && array_keys($payload) === range(0, count($payload) - 1);
        $items = $isBulk ? $payload : [$payload];
        
        $insertedRows = [];
        
        foreach($items as $item) {
            if ($table === 'usuarios') {
                if (isset($item['pass']) && !isset($item['pwd'])) $item['pwd'] = $item['pass'];
                if (isset($item['pwd']) && !isset($item['pass'])) $item['pass'] = $item['pwd'];
            }
            $cols = array_keys($item);
            $safeCols = array_map(function($c) { return preg_replace('/[^a-zA-Z0-9_]/', '', $c); }, $cols);
            $placeholders = array_map(function($c) { return ":".$c; }, $safeCols);
            
            $sql = "INSERT INTO $table (" . implode(', ', $safeCols) . ") VALUES (" . implode(', ', $placeholders) . ")";
            $stmt = $db->prepare($sql);
            
            $params = [];
            foreach($cols as $i => $col) {
                $params[$placeholders[$i]] = $item[$col];
            }
            $stmt->execute($params);
            
            $id = $db->lastInsertId();
            if ($id) {
                // Fetch the inserted row
                $pkMap = [
                    'usuarios' => 'id_usuario',
                    'insumos' => 'id_insumo',
                    'recetas' => 'id_receta',
                    'solicitudes' => 'id_solicitud',
                    'detalle_solicitud' => 'id_detalle',
                    'menu_programado' => 'id_menu',
                    'formularios_historial' => 'id_form',
                    'detalle_formularios' => 'id_detalle',
                    'bitacora' => 'id_novedad'
                ];
                $pk = $pkMap[$table] ?? ("id_" . rtrim($table, "s"));
                
                try {
                    $st = $db->query("SELECT * FROM $table WHERE $pk = $id");
                    $insertedRows[] = $st->fetch(PDO::FETCH_ASSOC);
                } catch(Exception $e) {
                    $insertedRows[] = $item;
                }
            } else {
                $insertedRows[] = $item;
            }
        }
        
        echo json_encode(['data' => $insertedRows, 'error' => null]);
    }
    
    else if ($action === 'update') {
        if ($table === 'usuarios' && isset($payload['pass']) && !isset($payload['pwd'])) {
            $payload['pwd'] = $payload['pass'];
        }
        $cols = array_keys($payload);
        $safeCols = array_map(function($c) { return preg_replace('/[^a-zA-Z0-9_]/', '', $c); }, $cols);
        $setClauses = [];
        $params = [];
        
        foreach($safeCols as $i => $col) {
            $setClauses[] = "$col = :val_$col";
            $params[":val_$col"] = $payload[$cols[$i]];
        }
        
        $sql = "UPDATE $table SET " . implode(', ', $setClauses);
        
        $where = [];
        foreach ($conditions as $i => $cond) {
            $col = preg_replace('/[^a-zA-Z0-9_]/', '', $cond['col']);
            $pName = ":cond_$i";
            if ($cond['type'] === 'eq') { $where[] = "$col = $pName"; $params[$pName] = $cond['val']; }
        }
        if (count($where) > 0) $sql .= " WHERE " . implode(' AND ', $where);
        
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        
        echo json_encode(['data' => null, 'error' => null]);
    }

    else if ($action === 'delete') {
        $sql = "DELETE FROM $table";
        $where = [];
        $params = [];
        foreach ($conditions as $i => $cond) {
            $col = preg_replace('/[^a-zA-Z0-9_]/', '', $cond['col']);
            $pName = ":cond_$i";
            if ($cond['type'] === 'eq') { $where[] = "$col = $pName"; $params[$pName] = $cond['val']; }
        }
        if (count($where) > 0) $sql .= " WHERE " . implode(' AND ', $where);
        
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        echo json_encode(['data' => null, 'error' => null]);
    }
    
    else if ($action === 'upsert') {
        // Simpler upsert for configuraciones
        if ($table === 'configuraciones') {
            $items = (is_array($payload) && array_keys($payload) === range(0, count($payload) - 1)) ? $payload : [$payload];
            foreach($items as $item) {
                $sql = "INSERT INTO configuraciones (clave, valor) VALUES (:c, :v) ON DUPLICATE KEY UPDATE valor = :v2";
                $stmt = $db->prepare($sql);
                $stmt->execute([':c' => $item['clave'], ':v' => $item['valor'], ':v2' => $item['valor']]);
            }
        } else if ($table === 'usuarios') {
             // Upsert on usuarios, mainly for save
             $isBulk = is_array($payload) && array_keys($payload) === range(0, count($payload) - 1);
             $items = $isBulk ? $payload : [$payload];
             foreach($items as $item) {
                 if (isset($item['id_usuario'])) {
                      $sql = "UPDATE usuarios SET nombre_completo=:n, usuario_login=:l, rol=:r, area=:a, turno_cocinero=:t WHERE id_usuario=:id";
                      $p = [':n'=>$item['nombre_completo'], ':l'=>$item['usuario_login'], ':r'=>$item['rol'], ':a'=>$item['area']??null, ':t'=>$item['turno_cocinero']??($item['turno']??null), ':id'=>$item['id_usuario']];
                      if(!empty($item['pass']) || !empty($item['pwd'])) {
                          $sql = "UPDATE usuarios SET nombre_completo=:n, usuario_login=:l, rol=:r, area=:a, turno_cocinero=:t, pass=:pass, pwd=:pwd WHERE id_usuario=:id";
                          $pass = $item['pass'] ?? $item['pwd'];
                          $p[':pass'] = $pass;
                          $p[':pwd'] = $pass;
                      }
                      $stmt = $db->prepare($sql);
                      $stmt->execute($p);
                 } else {
                      $pass = $item['pass'] ?? $item['pwd'];
                      $sql = "INSERT INTO usuarios (nombre_completo, usuario_login, pass, pwd, rol, area, turno_cocinero, activo) VALUES (:n, :l, :pass, :pwd, :r, :a, :t, :activo)";
                      $stmt = $db->prepare($sql);
                      $stmt->execute([':n'=>$item['nombre_completo'], ':l'=>$item['usuario_login'], ':pass'=>$pass, ':pwd'=>$pass, ':r'=>$item['rol'], ':a'=>$item['area']??null, ':t'=>$item['turno_cocinero']??($item['turno']??null), ':activo'=>$item['activo']??1]);
                 }
             }
        }
        echo json_encode(['data' => null, 'error' => null]);
    }

} catch (Exception $e) {
    echo json_encode(['data' => null, 'error' => $e->getMessage()]);
}
?>
