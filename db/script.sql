-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS nova_salud;
USE nova_salud;

-- Tabla de usuarios (para login y control de acceso)
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_usuario VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    rol ENUM('admin', 'vendedor') DEFAULT 'vendedor'
);

-- Insertar un usuario por defecto (admin / admin123)
INSERT INTO usuarios (nombre_usuario, password, rol)
VALUES ('admin', SHA2('admin123', 256), 'admin');

-- Tabla de productos
CREATE TABLE productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    stock INT DEFAULT 0,
    precio DECIMAL(10,2) NOT NULL,
    stock_minimo INT DEFAULT 5
);

-- Tabla de clientes (opcional)
CREATE TABLE clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    dni VARCHAR(15),
    telefono VARCHAR(20)
);

-- Tabla de ventas
CREATE TABLE ventas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    total DECIMAL(10,2) NOT NULL
);

-- Tabla de detalle de cada venta
CREATE TABLE detalle_venta (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_venta INT,
    id_producto INT,
    cantidad INT,
    subtotal DECIMAL(10,2),
    FOREIGN KEY (id_venta) REFERENCES ventas(id),
    FOREIGN KEY (id_producto) REFERENCES productos(id)
);

ALTER TABLE detalle_venta ADD COLUMN precio_unitario DECIMAL(10,2) NOT NULL;

-- ====================
-- VENTAS ADICIONALES
-- ====================

-- Ventas en meses anteriores del 2025
INSERT INTO ventas (fecha, total) VALUES 
('2025-04-10 10:30:00', 8.30),     -- Abril 2025
('2025-03-15 12:45:00', 15.60),    -- Marzo 2025
('2025-02-20 14:15:00', 10.00),    -- Febrero 2025
('2025-01-08 09:20:00', 6.70);     -- Enero 2025

-- Ventas del 2024 (diversos meses)
INSERT INTO ventas (fecha, total) VALUES 
('2024-12-05 11:00:00', 14.50),    -- Diciembre 2024
('2024-11-17 13:40:00', 5.80),     -- Noviembre 2024
('2024-10-23 15:30:00', 12.40),    -- Octubre 2024
('2024-09-12 16:00:00', 9.60),     -- Septiembre 2024
('2024-08-25 10:10:00', 7.20),     -- Agosto 2024
('2024-07-18 14:30:00', 11.90),    -- Julio 2024
('2024-06-03 17:20:00', 13.30),    -- Junio 2024
('2024-05-15 09:45:00', 6.00),     -- Mayo 2024
('2024-04-07 13:00:00', 10.50),    -- Abril 2024
('2024-03-29 11:30:00', 8.80),     -- Marzo 2024
('2024-02-10 12:00:00', 9.10);     -- Febrero 2024

-- ====================
-- DETALLE DE VENTAS
-- ====================

-- Requiere saber último ID autoincremental de ventas (empezamos desde 8)
-- Adaptado para productos con IDs 1-3

INSERT INTO detalle_venta (id_venta, id_producto, cantidad, precio_unitario, subtotal) VALUES
-- Ventas 8-11 (2025)
(8, 1, 2, 2.50, 5.00),
(8, 3, 2, 1.65, 3.30),

(9, 2, 2, 5.80, 11.60),
(9, 3, 2, 2.00, 4.00),

(10, 1, 2, 2.50, 5.00),
(10, 3, 2, 2.50, 5.00),

(11, 3, 4, 1.20, 4.80),
(11, 1, 1, 1.90, 1.90);

-- Ventas 12-22 (2024)
INSERT INTO detalle_venta (id_venta, id_producto, cantidad, precio_unitario, subtotal) VALUES
(12, 2, 2, 5.80, 11.60),
(12, 1, 1, 2.90, 2.90),

(13, 3, 3, 1.20, 3.60),
(13, 1, 1, 2.20, 2.20),

(14, 1, 3, 2.50, 7.50),
(14, 2, 1, 4.90, 4.90),

(15, 3, 4, 1.20, 4.80),
(15, 2, 1, 4.80, 4.80),

(16, 1, 2, 2.50, 5.00),
(16, 3, 1, 2.20, 2.20),

(17, 2, 2, 5.80, 11.60),
(17, 3, 1, 2.50, 2.50),

(18, 1, 1, 2.50, 2.50),
(18, 3, 1, 3.50, 3.50),

(19, 3, 3, 1.20, 3.60),
(19, 1, 1, 2.40, 2.40),

(20, 1, 2, 2.50, 5.00),
(20, 2, 1, 5.50, 5.50),

(21, 3, 2, 2.50, 5.00),
(21, 1, 1, 2.50, 2.50),

(22, 1, 2, 2.50, 5.00),
(22, 3, 2, 2.05, 4.10);


-- ====================
-- VENTAS 2025 (Enero a Mayo)
-- ====================
-- Enero 2025 (4 registros)
INSERT INTO ventas (fecha, total) VALUES
('2025-01-05 10:00:00', 6.50),
('2025-01-12 11:15:00', 12.30),
('2025-01-19 14:40:00', 9.90),
('2025-01-28 16:05:00', 8.70);

-- Febrero 2025 (5 registros)
INSERT INTO ventas (fecha, total) VALUES
('2025-02-03 09:45:00', 7.60),
('2025-02-10 13:10:00', 13.90),
('2025-02-17 12:00:00', 10.20),
('2025-02-22 16:25:00', 9.80),
('2025-02-28 15:35:00', 14.50);

-- Marzo 2025 (6 registros)
INSERT INTO ventas (fecha, total) VALUES
('2025-03-03 11:50:00', 8.40),
('2025-03-09 13:25:00', 10.60),
('2025-03-14 10:20:00', 7.50),
('2025-03-21 09:00:00', 11.00),
('2025-03-25 15:45:00', 9.10),
('2025-03-30 12:30:00', 6.30);

-- Abril 2025 (3 registros)
INSERT INTO ventas (fecha, total) VALUES
('2025-04-05 13:00:00', 7.00),
('2025-04-14 10:45:00', 10.80),
('2025-04-25 17:20:00', 12.60);

-- Mayo 2025 (hasta el 9 de mayo, incluyendo 2 de esta semana)
INSERT INTO ventas (fecha, total) VALUES
('2025-05-01 09:30:00', 7.70),
('2025-05-03 11:50:00', 8.90),
('2025-05-06 10:10:00', 6.40),  -- semana actual
('2025-05-08 14:00:00', 12.10), -- semana actual
('2025-05-09 08:30:00', 10.00);

-- ====================
-- DETALLE DE VENTAS (IDs 23 al 45)
-- ====================

-- Ventas 23-45
INSERT INTO detalle_venta (id_venta, id_producto, cantidad, precio_unitario, subtotal) VALUES
-- Enero
(23, 1, 2, 2.50, 5.00), (23, 3, 1, 1.50, 1.50),
(24, 2, 1, 5.80, 5.80), (24, 3, 1, 6.50, 6.50),
(25, 3, 3, 1.20, 3.60), (25, 1, 2, 3.15, 6.30),
(26, 1, 3, 2.50, 7.50), (26, 2, 1, 1.20, 1.20),

-- Febrero
(27, 2, 2, 5.80, 11.60), (27, 1, 1, 2.50, 2.50),
(28, 3, 2, 1.20, 2.40), (28, 1, 1, 3.00, 3.00),
(29, 2, 2, 4.60, 9.20), (29, 3, 1, 1.00, 1.00),
(30, 1, 3, 2.50, 7.50),
(31, 3, 2, 1.20, 2.40), (31, 2, 1, 4.60, 4.60),

-- Marzo
(32, 1, 1, 2.50, 2.50), (32, 3, 2, 2.95, 5.90),
(33, 2, 2, 5.80, 11.60),
(34, 3, 3, 1.20, 3.60), (34, 1, 1, 2.70, 2.70),
(35, 1, 2, 2.50, 5.00), (35, 3, 1, 2.20, 2.20),
(36, 2, 1, 5.80, 5.80), (36, 3, 1, 1.50, 1.50),
(37, 1, 2, 2.50, 5.00), (37, 2, 1, 4.10, 4.10),

-- Abril
(38, 2, 2, 5.80, 11.60),
(39, 3, 3, 1.20, 3.60), (39, 1, 1, 2.20, 2.20),
(40, 1, 1, 2.50, 2.50), (40, 3, 2, 5.05, 10.10),

-- Mayo
(41, 2, 2, 5.80, 11.60),
(42, 3, 2, 1.20, 2.40), (42, 1, 2, 3.25, 6.50),
(43, 2, 1, 5.80, 5.80),
(44, 3, 3, 1.20, 3.60), (44, 2, 1, 4.50, 4.50),
(45, 1, 2, 2.50, 5.00), (45, 3, 2, 2.50, 5.00);


-- nuevas ventas
INSERT INTO productos (id, nombre, descripcion, precio, stock) VALUES
(4, 'Loratadina 10mg', 'Antihistamínico para alergias, caja x10 tabletas', 3.80, 90),
(5, 'Omeprazol 20mg', 'Inhibidor de ácido estomacal, caja x14 cápsulas', 4.50, 75),
(6, 'Jarabe para la tos', 'Jarabe expectorante para adultos 120ml', 6.90, 50),
(7, 'Alcohol 70%', 'Frasco de alcohol medicinal 250ml', 2.80, 60),
(8, 'Algodón absorbente', 'Bolsa de algodón 100g', 1.90, 100),
(9, 'Termómetro digital', 'Termómetro clínico digital con pila incluida', 12.50, 25),
(10, 'Vitamina C 1g', 'Tabletas efervescentes x10 unidades', 5.00, 70),
(11, 'Crema antibiótica', 'Tubo de crema para heridas leves', 7.80, 30),
(12, 'Pañales descartables M', 'Paquete de 10 pañales para adulto mediano', 15.00, 20),
(13, 'Protector solar SPF50', 'Protección solar facial y corporal 100ml', 18.90, 15);

-- ACTUALIZAR USUARIO
UPDATE `usuarios` SET `nombre_usuario` = 'David Cruz' WHERE `usuarios`.`id` = 1;