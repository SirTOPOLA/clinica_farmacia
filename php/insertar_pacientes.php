<?php
session_start();
include '../config/conexion.php';

// Sanitización y normalización
$nombre = ucwords(trim($_POST['nombre']));
$apellido = ucwords(trim($_POST['apellido']));
$fecha_nacimiento = trim($_POST['fecha_nacimiento']);
$genero = $_POST['genero'];
$telefono = trim($_POST['telefono']);
$direccion = trim($_POST['direccion']);
$correo = trim($_POST['correo']);
$fecha_registro = date("Y-m-d");

// Validaciones robustas
$errores = [];

if (empty($nombre)) $errores[] = "El nombre es obligatorio.";
if (empty($apellido)) $errores[] = "El apellido es obligatorio.";
if (empty($fecha_nacimiento)) {
    $errores[] = "La fecha de nacimiento es obligatoria.";
} elseif (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha_nacimiento)) {
    $errores[] = "Formato de fecha inválido (debe ser AAAA-MM-DD).";
}
if (empty($genero) || !in_array($genero, ['Masculino', 'Femenino', 'Otro'])) {
    $errores[] = "El género es inválido.";
}
if (!empty($correo) && !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    $errores[] = "El correo electrónico no es válido.";
}

// Verificar duplicado: mismo nombre + apellido + fecha de nacimiento
$verifica = $conexion->prepare("
    SELECT COUNT(*) FROM pacientes
    WHERE nombre = ? AND apellido = ? AND fecha_nacimiento = ?
");
$verifica->execute([$nombre, $apellido, $fecha_nacimiento]);

if ($verifica->fetchColumn() > 0) {
    $errores[] = "Ya existe un paciente con este nombre y fecha de nacimiento.";
}

// Si hay errores, redirigimos
if (count($errores) > 0) {
    $_SESSION['mensaje'] = implode("<br>", $errores);
    $_SESSION['tipo'] = "error";
    header("Location: ../admin/listar_usuario.php");
    exit;
}

try {
    // Insertamos al paciente sin el código
    $stmt = $conexion->prepare("
        INSERT INTO pacientes (nombre, apellido, fecha_nacimiento, genero, telefono, direccion, correo, fecha_registro)
        VALUES (:nombre, :apellido, :fecha_nacimiento, :genero, :telefono, :direccion, :correo, :fecha_registro)
    ");
    $stmt->execute([
        ':nombre' => $nombre,
        ':apellido' => $apellido,
        ':fecha_nacimiento' => $fecha_nacimiento,
        ':genero' => $genero,
        ':telefono' => $telefono,
        ':direccion' => $direccion,
        ':correo' => $correo,
        ':fecha_registro' => $fecha_registro
    ]);

    // Obtener el ID insertado
    $id_paciente = $conexion->lastInsertId();

    // Generar código: Iniciales + últimos 2 del año + ID
    $iniciales = strtoupper(substr($nombre, 0, 1) . substr($apellido, 0, 1));
    $anio = substr($fecha_nacimiento, 2, 2);
    $codigo = $iniciales . $anio . '-' . $id_paciente;

    // Actualizar campo código
    $update = $conexion->prepare("UPDATE pacientes SET codigo = :codigo WHERE id_paciente = :id");
    $update->execute([
        ':codigo' => $codigo,
        ':id' => $id_paciente
    ]);

    $_SESSION['mensaje'] = "Paciente registrado exitosamente. Código asignado: $codigo";
    $_SESSION['tipo'] = "success";
    header("Location: ../admin/listar_paciente.php");
    exit;

} catch (PDOException $e) {
    $_SESSION['mensaje'] = "Error al registrar paciente: " . $e->getMessage();
    $_SESSION['tipo'] = "error";
    header("Location: ../admin/listar_paciente.php");
    exit;
}
