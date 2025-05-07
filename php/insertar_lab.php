<?php
session_start();
include_once("../config/conexion.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['id_paciente']) || !is_numeric($_POST['id_paciente'])) {
        $_SESSION['mensaje'] = 'ID de paciente no válido.';
        $_SESSION['tipo_mensaje'] = 'danger';
        header('Location: ../admin/listar_laboratorio.php');
        exit;
    }
    if (!isset($_POST['id_triaje']) || !is_numeric($_POST['id_triaje'])) {
        $_SESSION['mensaje'] = 'ID de triaje no válido.';
        $_SESSION['tipo_mensaje'] = 'danger';
        header('Location: ../admin/listar_laboratorio.php');
        exit;
    }

    $id_paciente = $_POST['id_paciente'];
    $id_triaje = $_POST['id_triaje'];
    $observaciones = trim($_POST['observaciones'] ?? '');

    if (empty($observaciones)) {
        $_SESSION['mensaje'] = 'El campo de observaciones es obligatorio.';
        $_SESSION['tipo_mensaje'] = 'danger';
        header('Location: ../admin/listar_laboratorio.php');
        exit;
    }

    if (!isset($_POST['pruebas']) || empty($_POST['pruebas'])) {
        $_SESSION['mensaje'] = 'Debes seleccionar al menos una prueba médica.';
        $_SESSION['tipo_mensaje'] = 'danger';
        header('Location: ../admin/listar_laboratorio.php');
        exit;
    }

    $pruebas = array_map('intval', $_POST['pruebas']);

    // Verificar existencia del paciente
    $stmt = $conexion->prepare("SELECT nombre FROM pacientes WHERE id_paciente = ?");
    $stmt->execute([$id_paciente]);
    if (!$stmt->fetch(PDO::FETCH_ASSOC)) {
        $_SESSION['mensaje'] = 'Paciente no encontrado.';
        $_SESSION['tipo_mensaje'] = 'danger';
        header('Location: ../admin/listar_laboratorio.php');
        exit;
    }

    // Verificar existencia del triaje
    $stmt = $conexion->prepare("SELECT * FROM triaje WHERE id_triaje = ?");
    $stmt->execute([$id_triaje]);
    if (!$stmt->fetch(PDO::FETCH_ASSOC)) {
        $_SESSION['mensaje'] = 'Triaje no encontrado.';
        $_SESSION['tipo_mensaje'] = 'danger';
        header('Location: ../admin/listar_laboratorio.php');
        exit;
    }

    try {
        $conexion->beginTransaction();

        // Actualizar observaciones
        $stmt = $conexion->prepare("UPDATE triaje SET observaciones = ? WHERE id_triaje = ?");
        $stmt->execute([$observaciones, $id_triaje]);

        // Insertar pruebas
        foreach ($pruebas as $id_prueba) {
            $stmt = $conexion->prepare("INSERT INTO laboratorio 
                (id_paciente, fecha, tipo_prueba, resultado, observaciones, pagado, id_triaje)
                VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $id_paciente,
                date('Y-m-d'),
                $id_prueba,
                'Resultado pendiente',
                $observaciones,
                0,
                $id_triaje
            ]);
        }

        $conexion->commit();
        $_SESSION['mensaje'] = 'Pruebas asignadas correctamente.';
        $_SESSION['tipo_mensaje'] = 'success';
        header('Location: ../admin/listar_laboratorio.php');
        exit;
    } catch (Exception $e) {
        $conexion->rollBack();
        $_SESSION['mensaje'] = 'Hubo un error al guardar la información.';
        $_SESSION['tipo_mensaje'] = 'danger';
        header('Location: ../admin/listar_laboratorio.php');
        exit;
    }
} else {
    $_SESSION['mensaje'] = 'Acceso no autorizado.';
    $_SESSION['tipo_mensaje'] = 'warning';
    header('Location: ../admin/listar_laboratorio.php');
    exit;
}
?>
