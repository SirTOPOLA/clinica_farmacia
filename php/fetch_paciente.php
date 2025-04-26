<?php
// Iniciar la sesión o configurar el entorno necesario
include('../config/conexion.php'); // Si necesitas cargar configuraciones adicionales

// Configuración para responder con JSON
header('Content-Type: application/json');

// Verificar si se reciben los datos correctamente
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Recuperar los datos enviados desde el frontend

    // Consulta SQL
    $sql = "SELECT id_paciente, codigo, nombre, apellido, fecha_nacimiento, genero, telefono, direccion, correo, fecha_registro FROM pacientes";

    // Preparar y ejecutar la consulta
    $stmt = $conexion->prepare($sql);
    $stmt->execute();

    // Obtener los resultados
    $pacientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Mostrar los resultados
    echo json_encode($pacientes); // Retornar los resultados en formato JSON
 
    //echo json_encode(['success' => true, 'message' => 'Paciente registrado con éxito.']);
} else {
    // Si no se ha hecho una solicitud POST, enviar error
    echo json_encode(['success' => false, 'error' => 'Método de solicitud no permitido.']);
}
?>