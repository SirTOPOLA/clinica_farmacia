<?php
session_start();
include_once("../config/conexion.php"); // Asegúrate de tener aquí tu conexión PDO

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar campos
    $id_paciente = $_POST['id_paciente'] ?? null;
    $id_empleado = $_POST['id_empleado'] ?? null;
    $fecha = $_POST['fecha'] ?? null;
    $medicamento = trim($_POST['medicamento'] ?? '');
    $dosis = trim($_POST['dosis'] ?? '');
    $duracion = trim($_POST['duracion'] ?? '');
    $indicaciones = trim($_POST['instrucciones'] ?? '');



    if (!$id_paciente || !$id_empleado || !$fecha || empty($medicamento) || empty($duracion) || empty($indicaciones)) {
        $_SESSION['mensaje'] = 'Todos los campos son obligatorios.';
        $_SESSION['tipo_mensaje'] = 'warning';
        header("Location: ../admin/listar_triaje.php");
        exit;
    }

    try {
        $query = "
            INSERT INTO recetas (id_paciente, id_empleado, fecha, medicamento, dosis, duracion, indicaciones)
            VALUES (:id_paciente, :id_empleado, :fecha, :medicamento, :dosis, :duracion, :indicaciones)
        ";

        $stmt = $conexion->prepare($query);
        $stmt->bindParam(':id_paciente', $id_paciente, PDO::PARAM_INT);
        $stmt->bindParam(':id_empleado', $id_empleado, PDO::PARAM_INT);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':medicamento', $medicamento);
        $stmt->bindParam(':dosis', $dosis); // Puedes dejarlo vacío si no se usa aún
        $stmt->bindParam(':duracion', $duracion);
        $stmt->bindParam(':indicaciones', $indicaciones);

        $stmt->execute();

        $_SESSION['mensaje'] = 'Receta guardada correctamente.';
        $_SESSION['tipo_mensaje'] = 'success';
        header("Location: ../admin/listar_triaje.php");
        exit;

    } catch (PDOException $e) {
        $_SESSION['mensaje'] = 'Error al guardar la receta: ' . $e->getMessage();
        $_SESSION['tipo_mensaje'] = 'danger';
        header("Location: ../admin/listar_triaje.php");
        exit;
    }
} else {
    $_SESSION['mensaje'] = 'Acceso no autorizado.';
    $_SESSION['tipo_mensaje'] = 'danger';
    header("Location: ../admin/index.php");
    exit;
}
