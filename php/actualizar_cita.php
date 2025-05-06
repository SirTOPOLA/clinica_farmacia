<?php
session_start();
require_once("../config/conexion.php");

// Verificar si se recibieron todos los datos necesarios
if (
    isset($_POST['id_cita'], $_POST['id_paciente'], $_POST['id_empleado'],
          $_POST['fecha_cita'], $_POST['hora_cita'], $_POST['estado']) &&
    !empty($_POST['id_cita']) && !empty($_POST['id_paciente']) &&
    !empty($_POST['id_empleado']) && !empty($_POST['fecha_cita']) &&
    !empty($_POST['hora_cita']) && !empty($_POST['estado'])
) {
    $id_cita = $_POST['id_cita'];
    $id_paciente = $_POST['id_paciente'];
    $id_empleado = $_POST['id_empleado'];
    $fecha_cita = $_POST['fecha_cita'];
    $hora_cita = $_POST['hora_cita'];
    $estado = $_POST['estado'];

    try {
        $sql = "UPDATE citas SET
                    id_paciente = :id_paciente,
                    id_empleado = :id_empleado,
                    fecha_cita = :fecha_cita,
                    hora_cita = :hora_cita,
                    estado = :estado
                WHERE id_cita = :id_cita";

        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':id_paciente', $id_paciente);
        $stmt->bindParam(':id_empleado', $id_empleado);
        $stmt->bindParam(':fecha_cita', $fecha_cita);
        $stmt->bindParam(':hora_cita', $hora_cita);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':id_cita', $id_cita);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Cita actualizada correctamente.";
        } else {
            $_SESSION['error'] = "Error al actualizar la cita.";
        }

    } catch (PDOException $e) {
        $_SESSION['error'] = "Error en la base de datos: " . $e->getMessage();
    }

} else {
    $_SESSION['error'] = "Todos los campos son obligatorios.";
}

header("Location: ../admin/listar_cita.php");
exit();
