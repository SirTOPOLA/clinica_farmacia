<?php
require_once '../config/conexion.php';

// Comprobar si hay un valor de búsqueda
if (isset($_GET['q'])) {
    $filtro = $_GET['q'];

    // Consulta SQL para buscar pacientes que coincidan con el filtro
    $sql = "
        SELECT p.id_paciente, p.nombre, p.apellido
        FROM pacientes p
        WHERE p.id_paciente LIKE :filtro 
        OR p.nombre LIKE :filtro 
        OR p.apellido LIKE :filtro
        LIMIT 5
    ";

    try {
        // Preparar la consulta
        $stmt = $conexion->prepare($sql);
        $stmt->bindValue(':filtro', '%' . $filtro . '%');
        $stmt->execute();

        // Obtener los resultados
        $pacientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Enviar los resultados en formato JSON
        echo json_encode($pacientes);
    } catch (PDOException $e) {
        echo json_encode([]);
    }
}
?>
