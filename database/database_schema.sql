-- Esquema maestro BOH Operativo para MySQL/MariaDB (XAMPP).
-- Basado en la estructura original de Supabase entregada por el usuario.

CREATE DATABASE IF NOT EXISTS boh_operativo CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE boh_operativo;

CREATE TABLE IF NOT EXISTS usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre_completo VARCHAR(150) NOT NULL,
    usuario_login VARCHAR(50) NOT NULL UNIQUE,
    pass VARCHAR(255) NOT NULL,
    pwd VARCHAR(255) NOT NULL,
    rol VARCHAR(50) NOT NULL,
    area VARCHAR(100),
    turno_cocinero VARCHAR(80),
    turno VARCHAR(80),
    activo BOOLEAN DEFAULT TRUE,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS configuraciones (
    clave VARCHAR(80) PRIMARY KEY,
    valor TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS bitacora (
    id_novedad INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    mensaje TEXT NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);

CREATE TABLE IF NOT EXISTS insumos (
    id_insumo INT AUTO_INCREMENT PRIMARY KEY,
    codigo_interno VARCHAR(80) NOT NULL UNIQUE,
    nombre VARCHAR(180) NOT NULL,
    unidad_medida VARCHAR(40) NOT NULL,
    categoria VARCHAR(120) NOT NULL,
    formato VARCHAR(30) NOT NULL,
    costo_unitario DECIMAL(12,2) DEFAULT 0,
    costo_est DECIMAL(12,2) DEFAULT 0,
    stock_actual DECIMAL(12,2) DEFAULT 0,
    areas_destino TEXT,
    activo BOOLEAN DEFAULT TRUE,
    ultima_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS recetas (
    id_receta INT AUTO_INCREMENT PRIMARY KEY,
    servicio VARCHAR(100) NOT NULL,
    categoria VARCHAR(150),
    nombre VARCHAR(180) NOT NULL,
    rinde INT DEFAULT 100,
    alergenos TEXT,
    procedimiento TEXT,
    ingredientes JSON NOT NULL,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS menu_programado (
    id_menu BIGINT AUTO_INCREMENT PRIMARY KEY,
    fecha DATE NOT NULL,
    servicio VARCHAR(80) NOT NULL,
    preparacion TEXT NOT NULL,
    categoria TEXT,
    notas TEXT,
    creado_por INT,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    actualizado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (creado_por) REFERENCES usuarios(id_usuario)
);

CREATE TABLE IF NOT EXISTS solicitudes (
    id_solicitud INT AUTO_INCREMENT PRIMARY KEY,
    radicado VARCHAR(80) NOT NULL UNIQUE,
    id_cocinero INT NOT NULL,
    servicio VARCHAR(80) NOT NULL,
    area_solicitante VARCHAR(120) NOT NULL,
    turno_cocinero VARCHAR(80) NOT NULL,
    hora_solicitud TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    id_ctrl_cocina INT,
    hora_aceptacion TIMESTAMP NULL,
    hora_proceso TIMESTAMP NULL,
    hora_despacho TIMESTAMP NULL,
    hora_confirmacion TIMESTAMP NULL,
    estado VARCHAR(50) DEFAULT 'PENDIENTE',
    comentarios_novedad TEXT,
    FOREIGN KEY (id_cocinero) REFERENCES usuarios(id_usuario),
    FOREIGN KEY (id_ctrl_cocina) REFERENCES usuarios(id_usuario)
);

CREATE TABLE IF NOT EXISTS detalle_solicitud (
    id_detalle INT AUTO_INCREMENT PRIMARY KEY,
    id_solicitud INT NOT NULL,
    id_insumo INT NOT NULL,
    cantidad_solicitada DECIMAL(12,2) NOT NULL,
    cantidad_despachada DECIMAL(12,2),
    FOREIGN KEY (id_solicitud) REFERENCES solicitudes(id_solicitud) ON DELETE CASCADE,
    FOREIGN KEY (id_insumo) REFERENCES insumos(id_insumo)
);

CREATE TABLE IF NOT EXISTS formularios_historial (
    id_form INT AUTO_INCREMENT PRIMARY KEY,
    tipo_form VARCHAR(50) NOT NULL,
    fecha_registro DATE DEFAULT (CURRENT_DATE),
    id_usuario INT,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);

CREATE TABLE IF NOT EXISTS detalle_formularios (
    id_det INT AUTO_INCREMENT PRIMARY KEY,
    id_detalle INT,
    id_form INT NOT NULL,
    id_insumo INT NOT NULL,
    toma_fisica DECIMAL(12,2) DEFAULT 0,
    pedido DECIMAL(12,2) DEFAULT 0,
    FOREIGN KEY (id_form) REFERENCES formularios_historial(id_form) ON DELETE CASCADE,
    FOREIGN KEY (id_insumo) REFERENCES insumos(id_insumo)
);

CREATE TABLE IF NOT EXISTS stg_insumos_excel (
    id_stg BIGINT AUTO_INCREMENT PRIMARY KEY,
    lote TEXT NOT NULL,
    fuente_archivo TEXT,
    codigo_interno TEXT,
    nombre TEXT NOT NULL,
    unidad_medida TEXT,
    categoria TEXT,
    formato TEXT,
    areas_destino TEXT,
    costo_unitario DECIMAL(12,2),
    cargado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS turnos (
    id_turno BIGINT AUTO_INCREMENT PRIMARY KEY,
    fecha DATE NOT NULL,
    id_usuario INT,
    nombre_colaborador TEXT NOT NULL,
    cargo TEXT,
    area TEXT,
    turno TEXT,
    hora_inicio TIME,
    hora_fin TIME,
    observaciones TEXT,
    origen_archivo TEXT,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    actualizado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);

INSERT INTO usuarios (nombre_completo, usuario_login, pass, pwd, rol, area, turno_cocinero, activo)
VALUES
    ('Administrador del Sistema', 'admin', 'admin123', 'admin123', 'admin', 'General', 'N/A', TRUE),
    ('Cocinero Solicitante', 'cocina', 'cocina123', 'cocina123', 'cocinero', 'General', 'N/A', TRUE),
    ('Bodeguero Control', 'bodega', 'bodega123', 'bodega123', 'control_cocina', 'Bodega General', 'N/A', TRUE)
ON DUPLICATE KEY UPDATE
    pass = VALUES(pass),
    pwd = VALUES(pwd),
    rol = VALUES(rol),
    area = VALUES(area),
    turno_cocinero = VALUES(turno_cocinero),
    activo = TRUE;
