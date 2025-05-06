<?php
session_start();
require_once '../config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar y limpiar los datos
    $id_paciente  = isset($_POST['id_paciente']) ? intval($_POST['id_paciente']) : 0;
    $id_empleado  = isset($_POST['id_empleado']) ? intval($_POST['id_empleado']) : 0;
    $fecha_cita   = isset($_POST['fecha_cita']) ? trim($_POST['fecha_cita']) : '';
    $hora_cita    = isset($_POST['hora_cita']) ? trim($_POST['hora_cita']) : '';
    $estado       = isset($_POST['estado']) ? trim($_POST['estado']) : '';

    // Verificar campos obligatorios
    if ($id_paciente <= 0 || $id_empleado <= 0 || empty($fecha_cita) || empty($hora_cita) || empty($estado)) {
        $_SESSION['error'] = "Todos los campos son obligatorios.";
        header("Location: ../admin/listar_cita.php");
        exit();
    }

    // Validar estado permitido
    $estados_permitidos = ['pendiente', 'confirmada', 'cancelada', 'completada'];
    if (!in_array($estado, $estados_permitidos)) {
        $_SESSION['error'] = "Estado inválido.";
        header("Location: ../admin/listar_cita.php");
        exit();
    }

    try {
        // Insertar la cita
        $sql = "
            INSERT INTO citas (id_paciente, id_empleado, fecha_cita, hora_cita, estado)
            VALUES (:id_paciente, :id_empleado, :fecha_cita, :hora_cita, :estado)
        ";

        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':id_paciente', $id_paciente, PDO::PARAM_INT);
        $stmt->bindParam(':id_empleado', $id_empleado, PDO::PARAM_INT);
        $stmt->bindParam(':fecha_cita', $fecha_cita);
        $stmt->bindParam(':hora_cita', $hora_cita);
        $stmt->bindParam(':estado', $estado);

        $stmt->execute();

        $_SESSION['exito'] = "Cita registrada correctamente.";
        header("Location: ../admin/listar_cita.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error al guardar la cita: " . $e->getMessage();
        header("Location: ../admin/listar_cita.php");
        exit();
    }
} else {
    // Si se accede directamente al archivo sin POST
    $_SESSION['error'] = "Acceso no permitido.";
    header("Location: ../admin/listar_cita.php");
    exit();
}
?>
