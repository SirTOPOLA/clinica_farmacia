<?php
include_once("../config/conexion.php"); // Asegúrate de que la conexión esté aquí

if (!isset($_POST['fecha']) || !isset($_POST['tipo'])) {
    echo json_encode(['error' => 'Parámetros inválidos']);
    exit;
}

$fecha = $_POST['fecha'];
$tipo = $_POST['tipo'];

$where = '';
$params = [];

switch ($tipo) {
    case 'dia':
        $where = 'DATE(fecha) = ?';
        $params[] = $fecha;
        break;
    case 'semana':
        $where = 'YEARWEEK(fecha, 1) = YEARWEEK(?, 1)';
        $params[] = $fecha;
        break;
    case 'mes':
        $where = 'YEAR(fecha) = YEAR(?) AND MONTH(fecha) = MONTH(?)';
        $params[] = $fecha;
        $params[] = $fecha;
        break;
    case 'año':
        $where = 'YEAR(fecha) = YEAR(?)';
        $params[] = $fecha;
        break;
    default:
        echo json_encode(['error' => 'Filtro no reconocido']);
        exit;
}

$sql = "SELECT id_triaje, fecha, precio FROM triaje WHERE $where ORDER BY fecha DESC";
$stmt = $conexion->prepare($sql);
$stmt->execute($params);
$resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calcular el total de precios
$total = 0;
foreach ($resultados as $r) {
    $total += $r['precio'];
}

echo json_encode([
    'registros' => $resultados,
    'total' => $total
]);
