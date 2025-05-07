<?php
session_start();
require_once '../config/conexion.php';

$id_usuario = $_SESSION['id_usuario'] ?? null;

if (!$id_usuario) {
    echo json_encode(['error' => 'Usuario no autenticado']);
    exit;
}

try {
    // Paso 1: Obtener codigo_empleado desde usuarios
    $queryUsuario = "SELECT codigo_empleado FROM usuarios WHERE id_usuario = :id_usuario LIMIT 1";
    $stmtUsuario = $conexion->prepare($queryUsuario);
    $stmtUsuario->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
    $stmtUsuario->execute();
    $usuario = $stmtUsuario->fetch(PDO::FETCH_ASSOC);

    if (!$usuario || empty($usuario['codigo_empleado'])) {
        echo json_encode(['error' => 'Código de empleado no encontrado']);
        exit;
    }

    $codigo_empleado = $usuario['codigo_empleado'];

    // Paso 2: Obtener id_empleado desde empleados
    $queryEmpleado = "SELECT id_empleado FROM empleados WHERE codigo_empleado = :codigo_empleado LIMIT 1";
    $stmtEmpleado = $conexion->prepare($queryEmpleado);
    $stmtEmpleado->bindParam(':codigo_empleado', $codigo_empleado);
    $stmtEmpleado->execute();
    $empleado = $stmtEmpleado->fetch(PDO::FETCH_ASSOC);

    if ($empleado) {
        echo json_encode($empleado);
    } else {
        echo json_encode(['error' => 'Empleado no encontrado']);
    }

} catch (PDOException $e) {
    echo json_encode(['error' => 'Error en la consulta: ' . $e->getMessage()]);
}

