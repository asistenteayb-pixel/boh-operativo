-- Compatibilidad MySQL/MariaDB con la estructura usada originalmente en Supabase.
-- Este archivo es idempotente para XAMPP/MariaDB y conserva datos existentes.

CREATE DATABASE IF NOT EXISTS boh_operativo CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE boh_operativo;

ALTER TABLE usuarios
    ADD COLUMN IF NOT EXISTS pass VARCHAR(255) NULL AFTER usuario_login,
    ADD COLUMN IF NOT EXISTS turno_cocinero VARCHAR(80) NULL AFTER area,
    ADD COLUMN IF NOT EXISTS creado_en TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP AFTER activo;

UPDATE usuarios SET pass = COALESCE(NULLIF(pass, ''), pwd) WHERE pass IS NULL OR pass = '';
UPDATE usuarios SET turno_cocinero = COALESCE(turno_cocinero, turno) WHERE turno_cocinero IS NULL OR turno_cocinero = '';
UPDATE usuarios SET area = COALESCE(area, 'General'), turno_cocinero = COALESCE(turno_cocinero, 'N/A') WHERE usuario_login = 'admin';
UPDATE usuarios SET pwd = pass WHERE pwd IS NULL OR pwd = '' OR pwd <> pass;

ALTER TABLE usuarios
    MODIFY COLUMN pass VARCHAR(255) NOT NULL,
    MODIFY COLUMN rol VARCHAR(50) NOT NULL;

ALTER TABLE insumos
    ADD COLUMN IF NOT EXISTS costo_unitario DECIMAL(12,2) NULL DEFAULT 0 AFTER formato,
    ADD COLUMN IF NOT EXISTS stock_actual DECIMAL(12,2) NULL DEFAULT 0 AFTER costo_unitario,
    ADD COLUMN IF NOT EXISTS ultima_actualizacion TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP AFTER activo;

UPDATE insumos SET costo_unitario = COALESCE(costo_unitario, costo_est, 0);

ALTER TABLE recetas
    ADD COLUMN IF NOT EXISTS servicio VARCHAR(100) NULL AFTER id_receta,
    ADD COLUMN IF NOT EXISTS categoria VARCHAR(150) NULL AFTER servicio,
    ADD COLUMN IF NOT EXISTS rinde INT NULL DEFAULT 100 AFTER nombre,
    ADD COLUMN IF NOT EXISTS alergenos TEXT NULL AFTER rinde,
    ADD COLUMN IF NOT EXISTS procedimiento TEXT NULL AFTER alergenos,
    ADD COLUMN IF NOT EXISTS creado_en TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP;

ALTER TABLE menu_programado
    ADD COLUMN IF NOT EXISTS preparacion TEXT NULL AFTER servicio,
    ADD COLUMN IF NOT EXISTS categoria TEXT NULL AFTER preparacion,
    ADD COLUMN IF NOT EXISTS notas TEXT NULL AFTER categoria,
    ADD COLUMN IF NOT EXISTS creado_por INT NULL AFTER notas,
    ADD COLUMN IF NOT EXISTS creado_en TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    ADD COLUMN IF NOT EXISTS actualizado_en TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP;

ALTER TABLE solicitudes
    ADD COLUMN IF NOT EXISTS comentarios_novedad TEXT NULL AFTER estado;

ALTER TABLE formularios_historial
    ADD COLUMN IF NOT EXISTS creado_en TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP;

ALTER TABLE bitacora
    ADD COLUMN IF NOT EXISTS id_novedad INT NULL,
    ADD COLUMN IF NOT EXISTS fecha_registro TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP;

INSERT INTO usuarios (nombre_completo, usuario_login, pass, pwd, rol, area, turno_cocinero, activo)
VALUES
    ('Cocinero Solicitante', 'cocina', 'cocina123', 'cocina123', 'cocinero', 'General', 'N/A', TRUE),
    ('Bodeguero Control', 'bodega', 'bodega123', 'bodega123', 'control_cocina', 'Bodega General', 'N/A', TRUE)
ON DUPLICATE KEY UPDATE
    pass = VALUES(pass),
    pwd = VALUES(pwd),
    rol = VALUES(rol),
    area = VALUES(area),
    turno_cocinero = VALUES(turno_cocinero),
    activo = TRUE;
