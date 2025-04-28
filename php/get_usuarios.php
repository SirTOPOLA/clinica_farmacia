<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Conexión a base de datos
require_once '../config/conexion.php'; // Aquí tu conexión PDO

header('Content-Type: application/json');

// Recibir parámetros
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$limit = 10; // Registros por página
$offset = ($page - 1) * $limit;

// Contar total de registros filtrados
$sqlCount = "SELECT COUNT(*) 
             FROM usuarios u
             INNER JOIN roles r ON u.id_rol = r.id_rol
             WHERE u.codigo_empleado LIKE :search OR u.correo LIKE :search";
$stmtCount = $conexion->prepare($sqlCount);
$stmtCount->execute(['search' => "%$search%"]);
$total = $stmtCount->fetchColumn();

// Obtener registros paginados con nombre de rol
$sql = "SELECT u.id_usuario, u.codigo_empleado, u.correo, r.nombre_rol, u.activo
        FROM usuarios u
        INNER JOIN roles r ON u.id_rol = r.id_rol
        WHERE u.codigo_empleado LIKE :search OR u.correo LIKE :search
        ORDER BY u.id_usuario DESC 
        LIMIT :offset, :limit";

$stmt = $conexion->prepare($sql);
$stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->execute();

$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Respuesta
echo json_encode([
    'data' => $usuarios,
    'total' => $total,
    'page' => $page,
    'per_page' => $limit
]);
?>
