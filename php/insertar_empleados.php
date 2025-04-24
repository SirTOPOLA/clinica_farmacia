<?php
session_start(); // Para usar sesiones
include '../config/conexion.php';

// Sanitizar entradas
$nombre = htmlspecialchars(trim($_POST['nombre']));
$apellido = htmlspecialchars(trim($_POST['apellido']));
$correo = filter_var(trim($_POST['correo']), FILTER_SANITIZE_EMAIL);
$telefono = htmlspecialchars(trim($_POST['telefono']));
$direccion = htmlspecialchars(trim($_POST['direccion']));
$horario_trabajo = htmlspecialchars(trim($_POST['horario_trabajo']));

$errores = [];

if (empty($nombre)) $errores[] = "El nombre es obligatorio.";
if (empty($apellido)) $errores[] = "El apellido es obligatorio.";
if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) $errores[] = "Correo no válido.";

if (!empty($errores)) {
    $_SESSION['mensaje'] = implode("<br>", $errores);
    $_SESSION['tipo'] = "error";
    header("Location: ../admin/listar_empleado.php");
    exit;
}

try {
    // Verificar duplicado
    $verificar = $conexion->prepare("SELECT COUNT(*) FROM empleados WHERE nombre = ? AND apellido = ? AND correo = ?");
    $verificar->execute([$nombre, $apellido, $correo]);

    if ($verificar->fetchColumn() > 0) {
        $_SESSION['mensaje'] = "Este empleado ya está registrado.";
        $_SESSION['tipo'] = "error";
        header("Location: ../admin/listar_empleado.php");
        exit;
    }

    // Generar código
    $iniciales = strtoupper(substr($nombre, 0, 1) . substr($apellido, 0, 1));
    $fecha = date('Ymd');
    $contar = $conexion->prepare("SELECT COUNT(*) FROM empleados WHERE codigo_empleado LIKE ?");
    $contar->execute(["{$iniciales}{$fecha}%"]);
    $contador = $contar->fetchColumn() + 1;

    $codigo_empleado = "{$iniciales}{$fecha}" . str_pad($contador, 3, '0', STR_PAD_LEFT);

    // Insertar
    $sql = "INSERT INTO empleados 
            (codigo_empleado, nombre, apellido, correo, telefono, direccion, horario_trabajo)
            VALUES 
            (:codigo, :nombre, :apellido, :correo, :telefono, :direccion, :horario)";
    
    $stmt = $conexion->prepare($sql);
    $stmt->execute([
        ':codigo' => $codigo_empleado,
        ':nombre' => $nombre,
        ':apellido' => $apellido,
        ':correo' => $correo,
        ':telefono' => $telefono,
        ':direccion' => $direccion,
        ':horario' => $horario_trabajo
    ]);

    $_SESSION['mensaje'] = "Empleado registrado con éxito. Código: <strong>$codigo_empleado</strong>";
    $_SESSION['tipo'] = "success";
    header("Location: ../admin/listar_empleado.php");
    exit;

} catch (PDOException $e) {
    $_SESSION['mensaje'] = "Error: " . $e->getMessage();
    $_SESSION['tipo'] = "error";
    header("Location: ../admin/listar_empleado.php");
    exit;
}


?>