<?php
session_start();
include_once("../config/conexion.php");

$errores = [];
$campos = $_POST;

// Validar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_usuario'])) {
  $_SESSION['alerta'] = ['tipo' => 'danger', 'mensaje' => 'Debe iniciar sesión para registrar triajes.'];
  header('Location: ../login.php');
  exit;
}

$id_usuario = $_SESSION['id_usuario'];

// Validar campos requeridos (agregar el campo 'precio' aquí)
$requeridos = ['id_paciente', 'fecha', 'hora', 'pulso', 'temperatura', 'peso', 'presion_arterial', 'motivo_consulta', 'precio'];
foreach ($requeridos as $campo) {
  if (empty($campos[$campo])) {
    $errores[] = "El campo '$campo' es obligatorio.";
  }
}

// Validar valores
if (!empty($campos['pulso']) && (!is_numeric($campos['pulso']) || $campos['pulso'] <= 0 || $campos['pulso'] > 200)) {
  $errores[] = "El pulso debe ser un número entre 1 y 200.";
}
if (!empty($campos['temperatura']) && (!is_numeric($campos['temperatura']) || $campos['temperatura'] < 30 || $campos['temperatura'] > 45)) {
  $errores[] = "La temperatura debe estar entre 30 y 45 °C.";
}
if (!empty($campos['peso']) && (!is_numeric($campos['peso']) || $campos['peso'] <= 0 || $campos['peso'] > 500)) {
  $errores[] = "El peso debe estar entre 1 y 500 kg.";
}
if (!empty($campos['presion_arterial']) && !preg_match('/^\d{2,3}\/\d{2,3}$/', $campos['presion_arterial'])) {
  $errores[] = "La presión arterial debe estar en formato 120/80.";
}
if (!empty($campos['precio']) && (!is_numeric($campos['precio']) || $campos['precio'] <= 0)) {
  $errores[] = "El precio debe ser un número positivo.";
}

// Validar que el motivo_consulta no sea demasiado largo
if (isset($campos['motivo_consulta']) && strlen($campos['motivo_consulta']) > 500) {
  $errores[] = "El motivo de la consulta no puede superar los 500 caracteres.";
}

// Redireccionar si hay errores
if (!empty($errores)) {
  $_SESSION['errores_triaje'] = $errores;
  $_SESSION['datos_triaje'] = $campos;
  header('Location: ../admin/listar_triaje.php');
  exit;
}

// Guardar en la base de datos
try {
  $stmt = $conexion->prepare("
    INSERT INTO triaje (id_paciente, id_usuario, fecha, hora, pulso, temperatura, peso, presion_arterial, motivo, precio)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
  ");
  $stmt->execute([
    $campos['id_paciente'],
    $id_usuario,
    $campos['fecha'],
    $campos['hora'],
    $campos['pulso'],
    $campos['temperatura'],
    $campos['peso'],
    $campos['presion_arterial'],
    $campos['motivo_consulta'],
    $campos['precio'] // Insertar el precio
  ]);
  $_SESSION['alerta'] = ['tipo' => 'success', 'mensaje' => 'Triaje registrado correctamente.'];
  header('Location: ../admin/listar_triaje.php');
  exit;
} catch (PDOException $e) {
  $_SESSION['alerta'] = ['tipo' => 'danger', 'mensaje' => 'Error al guardar: ' . $e->getMessage()];
  header('Location: ../admin/listar_triaje.php');
  exit;
}

