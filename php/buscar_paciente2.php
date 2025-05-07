<?php
include_once("../config/conexion.php"); // Asegúrate de incluir tu conexión a la base de datos



header('Content-Type: application/json');

$query = $_GET['q'] ?? '';

if (empty($query)) {
    echo json_encode([]);
    exit;
}

try {
    $stmt = $conexion->prepare("
        SELECT id_paciente, nombre, apellido, codigo 
        FROM pacientes 
        WHERE nombre LIKE :busqueda 
           OR apellido LIKE :busqueda 
           OR codigo LIKE :busqueda 
        LIMIT 5
    ");

    $busqueda = "%$query%";
    $stmt->bindParam(':busqueda', $busqueda);
    $stmt->execute();

    $pacientes = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $pacientes[] = [
            'id_paciente' => $row['id_paciente'],
            'display' => "{$row['nombre']} {$row['apellido']} (Código: {$row['codigo']})"
        ];
    }

    echo json_encode($pacientes);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error en la búsqueda']);
}
