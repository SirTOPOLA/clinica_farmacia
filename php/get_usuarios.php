<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once '../config/conexion.php';
header('Content-Type: application/json');

// Llamamos a las funciones para obtener los datos
$paginaActual = $_GET['page'] ?? 1;
$terminoBusqueda = $_GET['search'] ?? '';
$registrosPorPagina = 10; // Cantidad de usuarios por página

// Obtener el total de usuarios
$totalSql = "SELECT COUNT(*) FROM usuarios u 
             INNER JOIN roles r ON u.id_rol = r.id_rol 
             WHERE u.codigo_empleado LIKE :search OR u.correo LIKE :search";
$totalStmt = $conexion->prepare($totalSql);
$totalStmt->bindValue(':search', '%' . $terminoBusqueda . '%');
$totalStmt->execute();
$total = $totalStmt->fetchColumn();

// Obtener los usuarios
$usuariosSql = "SELECT u.id_usuario, u.codigo_empleado, u.correo, u.id_rol, r.nombre_rol, u.activo 
                FROM usuarios u 
                INNER JOIN roles r ON u.id_rol = r.id_rol 
                WHERE u.codigo_empleado LIKE :search OR u.correo LIKE :search 
                LIMIT :offset, :limit";
$usuariosStmt = $conexion->prepare($usuariosSql);
$usuariosStmt->bindValue(':search', '%' . $terminoBusqueda . '%');
$usuariosStmt->bindValue(':offset', ($paginaActual - 1) * $registrosPorPagina, PDO::PARAM_INT);
$usuariosStmt->bindValue(':limit', $registrosPorPagina, PDO::PARAM_INT);
$usuariosStmt->execute();
$usuarios = $usuariosStmt->fetchAll(PDO::FETCH_ASSOC);

// Aquí iría el código para devolver los usuarios en formato JSON
echo json_encode([
    'data' => $usuarios,
    'total' => $total,
    'page' => $paginaActual,
    'per_page' => $registrosPorPagina
]);

?>
