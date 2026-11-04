-- =====================================
-- FORMULARIO DE CONTACTO LOGICORE (Guía "Mi primera web con PHP y base de datos")
-- Se ejecuta en la pestaña SQL de phpMyAdmin.
-- Base de datos propia de esta guía, aparte del sistema LogiCore.
-- =====================================

-- PASO 3: base de datos y tabla
CREATE DATABASE IF NOT EXISTS logicore_contacto CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE logicore_contacto;

CREATE TABLE IF NOT EXISTS contactos (
    id      INT AUTO_INCREMENT PRIMARY KEY,
    nombre  VARCHAR(100) NOT NULL,
    email   VARCHAR(150) NOT NULL,
    mensaje TEXT,
    fecha   TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- RETO 1: campo teléfono (opcional)
ALTER TABLE contactos ADD COLUMN IF NOT EXISTS telefono VARCHAR(20) NULL AFTER email;

-- RETO 2: motivo del mensaje (lista desplegable)
ALTER TABLE contactos ADD COLUMN IF NOT EXISTS motivo VARCHAR(20) NOT NULL DEFAULT 'consulta' AFTER telefono;
