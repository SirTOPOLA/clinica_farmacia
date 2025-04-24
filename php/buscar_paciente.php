<?php
include_once("../config/conexion.php"); // Asegúrate de tener una conexión a la BD aquí

$term = isset($_GET['q']) ? trim($_GET['q']) : '';

$sql = "SELECT id_paciente, CONCAT(codigo, ' - ', nombre, ' ', apellido) AS display 
        FROM pacientes 
        WHERE codigo LIKE ? OR nombre LIKE ? OR apellido LIKE ? 
        ORDER BY nombre ASC 
        LIMIT 10";

$stmt = $conn->prepare($sql);
$like = "%{$term}%";
$stmt->bind_param("sss", $like, $like, $like);
$stmt->execute();
$result = $stmt->get_result();

$pacientes = [];
while ($row = $result->fetch_assoc()) {
    $pacientes[] = $row;
}

header('Content-Type: application/json');
echo json_encode($pacientes);
