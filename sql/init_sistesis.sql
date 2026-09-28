CREATE DATABASE IF NOT EXISTS sistesis_db;
USE sistesis_db;

CREATE TABLE usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  correo VARCHAR(100) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  rol ENUM('estudiante', 'docente', 'comision') DEFAULT 'estudiante',
  login_intentos_fallidos TINYINT UNSIGNED NOT NULL DEFAULT 0,
  login_bloqueado TINYINT(1) NOT NULL DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE tesis (
  id INT AUTO_INCREMENT PRIMARY KEY,
  titulo VARCHAR(255) NOT NULL,
  descripcion TEXT,
  estado ENUM('propuesta', 'aprobado', 'rechazado', 'finalizado') DEFAULT 'propuesta',
  estudiante_id INT,
  FOREIGN KEY (estudiante_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

CREATE TABLE revisiones (
  id INT AUTO_INCREMENT PRIMARY KEY,
  tesis_id INT,
  revisor_id INT,
  comentario TEXT,
  fecha_revision TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (tesis_id) REFERENCES tesis(id),
  FOREIGN KEY (revisor_id) REFERENCES usuarios(id)
);

-- Usuario inicial solicitado en la guía (password: admin123).
-- Se almacena como hash porque AuthController usa password_verify().
INSERT INTO usuarios (nombre, correo, password, rol)
VALUES ('Comisión Académica', 'comision@uni.edu.ni', '$2y$12$7fWGcLFgJdGVRiqFgDK72OgA8DezHdp7GZ/4NV6S/udFBxcZXXLYy', 'comision');

-- Estudiante de apoyo para probar el listado MVC y la API sin alterar las credenciales de la guía.
INSERT INTO usuarios (nombre, correo, password, rol)
VALUES ('Estudiante Demo', 'estudiante@uni.edu.ni', '$2y$12$7fWGcLFgJdGVRiqFgDK72OgA8DezHdp7GZ/4NV6S/udFBxcZXXLYy', 'estudiante');

INSERT INTO tesis (titulo, descripcion, estudiante_id)
VALUES ('Tesis de demostración', 'Registro inicial para verificar el listado del estudiante.', 2);
