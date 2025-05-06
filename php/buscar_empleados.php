<?php
include_once("../config/conexion.php"); // Conexión PDO

// Configuración de paginación
$empleados_por_pagina = 10; // Número de empleados por página
$pagina_actual = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;
if ($pagina_actual < 1) {
    $pagina_actual = 1;
}
$offset = ($pagina_actual - 1) * $empleados_por_pagina;

// Validación de la búsqueda
$query = isset($_GET['q']) ? trim($_GET['q']) : '';

// Construir la consulta
$sql = "SELECT * FROM empleados WHERE 
        nombre LIKE :query OR 
        apellido LIKE :query OR 
        correo LIKE :query OR 
        codigo_empleado LIKE :query
        ORDER BY id_empleado DESC
        LIMIT :offset, :limit";

// Preparar la consulta
$stmt = $conexion->prepare($sql);
$stmt->bindValue(':query', "%$query%", PDO::PARAM_STR);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->bindValue(':limit', $empleados_por_pagina, PDO::PARAM_INT);

// Ejecutar la consulta
$stmt->execute();
$empleados = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Contar total de empleados
$total_query = "SELECT COUNT(*) AS total FROM empleados WHERE 
                nombre LIKE :query OR 
                apellido LIKE :query OR 
                correo LIKE :query OR 
                codigo_empleado LIKE :query";
$total_stmt = $conexion->prepare($total_query);
$total_stmt->bindValue(':query', "%$query%", PDO::PARAM_STR);
$total_stmt->execute();
$total_empleados = $total_stmt->fetch(PDO::FETCH_ASSOC)['total'];

// Calcular número total de páginas
$total_paginas = ceil($total_empleados / $empleados_por_pagina);

// Mostrar empleados
if ($empleados) {
     
    foreach ($empleados as $empleado) {
        echo "   <tr>
                <td data-label='🆔 ID'>" . htmlspecialchars($empleado['id_empleado']) . "</td>
                <td data-label='🔑 Código'>" . htmlspecialchars($empleado['codigo_empleado']) . "</td>
                <td data-label='👤 Nombre'>" . htmlspecialchars($empleado['nombre'] . ' ' . $empleado['apellido']) . "</td>
                <td data-label='📧 Correo'>" . htmlspecialchars($empleado['correo']) . "</td>
                <td data-label='📞 Teléfono'>" . htmlspecialchars($empleado['telefono']) . "</td>
                <td data-label='🏠 Dirección'>" . htmlspecialchars($empleado['direccion']) . "</td>
                <td data-label='⏰ Horario'>" . htmlspecialchars($empleado['horario_trabajo']) . "</td>
                <td data-label='⚙️ Acciones'>
                    <a href='editar_empleado.php?id=" . (int)$empleado['id_empleado'] . "' class='btn btn-warning btn-sm rounded'>Editar</a>
                      </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='7' class='text-center'>No se encontraron resultados.</td></tr>";
}

 
?>
