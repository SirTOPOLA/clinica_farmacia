drop database if exists clinica_farmacia;

create database clinica_farmacia;

use clinica_farmacia;

-- Tabla: roles
CREATE TABLE roles (
    id_rol INT AUTO_INCREMENT PRIMARY KEY,
    nombre_rol ENUM('RECEPCION', 'ADMINISTRADOR', 'ENFERMERIA', 'LABORATORIO', 'MEDICO') UNIQUE
);

-- Tabla: empleados
CREATE TABLE empleados (
    id_empleado INT AUTO_INCREMENT PRIMARY KEY,
    codigo_empleado VARCHAR(20) UNIQUE NOT NULL,
    nombre VARCHAR(50),
    apellido VARCHAR(50),
    correo VARCHAR(100),
    telefono VARCHAR(20),
    direccion VARCHAR(100),
    horario_trabajo VARCHAR(100)
);

-- Tabla: usuarios
CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    codigo_empleado VARCHAR(20) UNIQUE NOT NULL,
    correo VARCHAR(100) UNIQUE NOT NULL,
    contrasena VARCHAR(255) NOT NULL,
    id_rol INT,
    activo BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (codigo_empleado) REFERENCES empleados(codigo_empleado),
    FOREIGN KEY (id_rol) REFERENCES roles(id_rol)
);

-- Tabla: pacientes
CREATE TABLE pacientes (
    id_paciente INT AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(10) UNIQUE NOT NULL,
    nombre VARCHAR(50),
    apellido VARCHAR(50),
    fecha_nacimiento DATE,
    genero ENUM('Masculino', 'Femenino', 'Otro'),
    telefono VARCHAR(20),
    direccion VARCHAR(100),
    correo VARCHAR(100),
    fecha_registro DATE
);

-- Tabla: citas
CREATE TABLE citas (
    id_cita INT AUTO_INCREMENT PRIMARY KEY,
    id_paciente INT,
    id_empleado INT,
    fecha_cita DATE,
    hora_cita TIME,
    estado ENUM('pendiente', 'confirmada', 'cancelada', 'completada'),
    recordatorio_enviado BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (id_paciente) REFERENCES pacientes(id_paciente),
    FOREIGN KEY (id_empleado) REFERENCES empleados(id_empleado)
);

-- Tabla: historial_medico
CREATE TABLE historial_medico (
    id_historial INT AUTO_INCREMENT PRIMARY KEY,
    id_paciente INT,
    id_empleado INT,
    fecha DATE,
    descripcion TEXT,
    diagnostico TEXT,
    tratamiento_recomendado TEXT,
    FOREIGN KEY (id_paciente) REFERENCES pacientes(id_paciente),
    FOREIGN KEY (id_empleado) REFERENCES empleados(id_empleado)
);

-- Tabla: recetas
CREATE TABLE recetas (
    id_receta INT AUTO_INCREMENT PRIMARY KEY,
    id_paciente INT,
    id_empleado INT,
    fecha DATE,
    medicamento VARCHAR(100),
    dosis VARCHAR(100),
    duracion VARCHAR(100),
    indicaciones TEXT,
    FOREIGN KEY (id_paciente) REFERENCES pacientes(id_paciente),
    FOREIGN KEY (id_empleado) REFERENCES empleados(id_empleado)
);

-- Tabla: tratamientos
CREATE TABLE tratamientos (
    id_tratamiento INT AUTO_INCREMENT PRIMARY KEY,
    id_paciente INT,
    id_empleado INT,
    descripcion TEXT,
    fecha_inicio DATE,
    fecha_fin DATE,
    observaciones TEXT,
    FOREIGN KEY (id_paciente) REFERENCES pacientes(id_paciente),
    FOREIGN KEY (id_empleado) REFERENCES empleados(id_empleado)
);

-- Tabla: laboratorio
CREATE TABLE laboratorio (
    id_resultado INT AUTO_INCREMENT PRIMARY KEY,
    id_paciente INT,
    fecha DATE,
    tipo_estudio VARCHAR(100),
    resultado TEXT,
    observaciones TEXT,
    FOREIGN KEY (id_paciente) REFERENCES pacientes(id_paciente)
);

-- Tabla: farmacia
CREATE TABLE farmacia (
    id_medicamento INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    descripcion TEXT,
    stock INT,
    fecha_caducidad DATE,
    precio DECIMAL(10,2)
);

-- Tabla: notificaciones
CREATE TABLE notificaciones (
    id_notificacion INT AUTO_INCREMENT PRIMARY KEY,
    mensaje TEXT,
    fecha_creacion DATETIME,
    tipo ENUM('caducidad_medicamento', 'recordatorio_cita'),
    leido BOOLEAN DEFAULT FALSE
);

-- Tabla: triaje
CREATE TABLE triaje (
    id_triaje INT AUTO_INCREMENT PRIMARY KEY,
    id_paciente INT,
    id_usuario INT,
    fecha DATE,
    hora TIME,
    pulso INT,
    temperatura DECIMAL(4,2),
    peso DECIMAL(5,2),
    presion_arterial VARCHAR(20),
    FOREIGN KEY (id_paciente) REFERENCES pacientes(id_paciente),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);

-- Tabla: pruebas_medicas
CREATE TABLE pruebas_medicas (
    id_prueba INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) UNIQUE NOT NULL,
    precio DECIMAL(10,2) NOT NULL
);

-- Tabla: log_usuarios
CREATE TABLE log_usuarios (
    id_log INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    accion TEXT,
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    ip_usuario VARCHAR(45),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);
