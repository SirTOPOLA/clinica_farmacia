<?php
session_start(); // Inicia la sesión para manejar alertas

// Conexión a la base de datos
require_once '../config/conexion.php';

// Validar que se haya enviado el formulario por POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../admin/listar_empleado.php');
    exit();
}

// Función para sanitizar entradas
function limpiar($cadena) {
    return htmlspecialchars(strip_tags(trim($cadena)));
}
   
// Capturar y limpiar ID
$id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
if ($id <= 0) {
    $_SESSION['alerta'] = ['tipo' => 'error', 'mensaje' => 'ID inválido'];
    header('Location: ../admin/listar_empleado.php');
    exit();
}

// Verificar que el empleado exista
try {
    $stmt = $conexion->prepare("SELECT id_empleado FROM empleados WHERE id_empleado = :id");
    $stmt->execute(['id' => $id]);
    if ($stmt->rowCount() === 0) {
        $_SESSION['alerta'] = ['tipo' => 'error', 'mensaje' => 'Empleado no encontrado'];
        header('Location: ../admin/listar_empleado.php');
        exit();
    }
} catch (PDOException $e) {
    $_SESSION['alerta'] = ['tipo' => 'error', 'mensaje' => 'Error al buscar empleado'];
    header('Location: ../admin/listar_empleado.php');
    exit();
}

// Capturar y sanitizar los demás campos
$nombre = limpiar($_POST['nombre'] ?? '');
$apellido = limpiar($_POST['apellido'] ?? '');
$correo = limpiar($_POST['correo'] ?? '');
$telefono = limpiar($_POST['telefono'] ?? '');
$direccion = limpiar($_POST['direccion'] ?? '');
$horario_trabajo = limpiar($_POST['horario_trabajo'] ?? '');

// Validaciones robustas

// Nombre
if (empty($nombre) || !preg_match('/^[\p{L}\s]{2,100}$/u', $nombre)) {
    $_SESSION['alerta'] = ['tipo' => 'error', 'mensaje' => 'Nombre inválido'];
    header('Location: ../admin/listar_empleado.php');
    exit();
}

// Apellido
if (empty($apellido) || !preg_match('/^[\p{L}\s]{2,100}$/u', $apellido)) {
    $_SESSION['alerta'] = ['tipo' => 'error', 'mensaje' => 'Apellido inválido'];
    header('Location: ../admin/listar_empleado.php');
    exit();
}

// Correo electrónico
if (empty($correo) || !filter_var($correo, FILTER_VALIDATE_EMAIL) || strlen($correo) > 150) {
    $_SESSION['alerta'] = ['tipo' => 'error', 'mensaje' => 'Correo electrónico inválido'];
    header('Location: ../admin/listar_empleado.php');
    exit();
}

// Teléfono
if (empty($telefono) || !preg_match('/^[0-9\-\s\(\)]+$/', $telefono) || strlen($telefono) > 20) {
    $_SESSION['alerta'] = ['tipo' => 'error', 'mensaje' => 'Teléfono inválido'];
    header('Location: ../admin/listar_empleado.php');
    exit();
}

// Dirección
if (empty($direccion) || strlen($direccion) > 255) {
    $_SESSION['alerta'] = ['tipo' => 'error', 'mensaje' => 'Dirección inválida'];
    header('Location: ../admin/listar_empleado.php');
    exit();
}

// Horario de trabajo
if (empty($horario_trabajo) || strlen($horario_trabajo) > 50) {
    $_SESSION['alerta'] = ['tipo' => 'error', 'mensaje' => 'Horario de trabajo inválido'];
    header('Location: ../admin/listar_empleado.php');
    exit();
}

// Si todas las validaciones pasan, actualizar en base de datos
try {
    $sql = "UPDATE empleados SET 
                nombre = :nombre,
                apellido = :apellido,
                correo = :correo,
                telefono = :telefono,
                direccion = :direccion,
                horario_trabajo = :horario_trabajo
            WHERE id_empleado = :id";

    $stmt = $conexion->prepare($sql);
    $stmt->execute([
        'nombre' => $nombre,
        'apellido' => $apellido,
        'correo' => $correo,
        'telefono' => $telefono,
        'direccion' => $direccion,
        'horario_trabajo' => $horario_trabajo,
        'id' => $id
    ]);

    // Redirigir con éxito
    $_SESSION['alerta'] = ['tipo' => 'success', 'mensaje' => 'Empleado actualizado correctamente'];
    header('Location: ../admin/listar_empleado.php');
    exit();

} catch (PDOException $e) {
    $_SESSION['alerta'] = ['tipo' => 'error', 'mensaje' => 'Error al actualizar el empleado'];
    header('Location: ../admin/listar_empleado.php');
    exit();
}
?>
