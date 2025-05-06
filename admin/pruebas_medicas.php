<?php 
session_start();
include '../config/conexion.php'; 
try {
  // Número de registros por página
  $limit = 8;

  // Obtener la página actual desde la solicitud AJAX
  $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
  $start = ($page - 1) * $limit; // Calcular el punto de inicio

  // Obtener el término de búsqueda desde la solicitud AJAX
  $search = isset($_GET['search']) ? $_GET['search'] : '';

  // Si hay un término de búsqueda, filtrar los resultados
  if ($search) {
    $sql = "SELECT id_prueba, nombre, precio FROM pruebas_medicas WHERE nombre LIKE :search LIMIT :start, :limit";
    $stmt = $conexion->prepare($sql);
    $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
    $stmt->bindValue(':start', $start, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    $pruebas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Obtener el total de registros para la paginación con el filtro de búsqueda
    $sqlTotal = "SELECT COUNT(*) FROM pruebas_medicas WHERE nombre LIKE :search";
    $stmtTotal = $conexion->prepare($sqlTotal);
    $stmtTotal->bindValue(':search', "%$search%", PDO::PARAM_STR);
    $stmtTotal->execute();
    $totalRecords = $stmtTotal->fetchColumn();
  } else {
    // Si no hay término de búsqueda, traer todos los registros
    $sql = "SELECT id_prueba, nombre, precio FROM pruebas_medicas LIMIT :start, :limit";
    $stmt = $conexion->prepare($sql);
    $stmt->bindValue(':start', $start, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    $pruebas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Obtener el total de registros para la paginación sin filtro de búsqueda
    $sqlTotal = "SELECT COUNT(*) FROM pruebas_medicas";
    $stmtTotal = $conexion->prepare($sqlTotal);
    $stmtTotal->execute();
    $totalRecords = $stmtTotal->fetchColumn();
  }

  // Calcular el número total de páginas
  $totalPages = ceil($totalRecords / $limit);

  // Devolver los resultados como JSON
  echo json_encode([
    'pruebas' => $pruebas,
    'totalPages' => $totalPages,
    'currentPage' => $page
  ]);
} catch (PDOException $e) {
  // En caso de error, devolver un mensaje de error
  echo json_encode(['error' => 'Error al cargar las pruebas médicas: ' . $e->getMessage()]);
}
?>

