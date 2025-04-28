

<?php

// Incluir la conexión a la base de datos
require_once '../config/conexion.php';

header('Content-Type: application/json');

// Obtener los parámetros
$idUsuario = isset($_GET['id']) ? intval($_GET['id']) : 0;
$estado = isset($_GET['activo']) ? filter_var($_GET['activo'], FILTER_VALIDATE_BOOLEAN) : null;

if ($idUsuario && $estado !== null) {
    // Actualizar el estado del usuario
    $sql = "UPDATE usuarios SET activo = :activo WHERE id_usuario = :id_usuario";
    $stmt = $conexion->prepare($sql);
    $stmt->bindValue(':activo', $estado, PDO::PARAM_BOOL);
    $stmt->bindValue(':id_usuario', $idUsuario, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No se pudo actualizar el estado.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Faltan parámetros.']);
}

?>
