<?php
session_start();
include_once("../config/conexion.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['id_resultado']) && !empty($_POST['resultado'])) {
        $id_resultado = $_POST['id_resultado'];
        $resultado = trim($_POST['resultado']);

        try {
            $stmt = $conexion->prepare("UPDATE laboratorio SET resultado = :resultado WHERE id_resultado = :id_resultado");
            $stmt->bindParam(':resultado', $resultado, PDO::PARAM_STR);
            $stmt->bindParam(':id_resultado', $id_resultado, PDO::PARAM_INT);

            if ($stmt->execute()) {
                $_SESSION['success'] = "Resultado actualizado correctamente.";
                header("Location: ../admin/listar_laboratorio.php");
                exit;
            } else {
                $_SESSION['error'] = "No se pudo actualizar el resultado. Inténtalo de nuevo.";
                header("Location: ../admin/listar_laboratorio.php");
                exit;
            }
        } catch (PDOException $e) {
            $_SESSION['error'] = "Error de base de datos: " . $e->getMessage();
            header("Location: ../admin/listar_laboratorio.php");
            exit;
        }
    } else {
        $_SESSION['error'] = "Datos incompletos. Por favor, rellene el formulario correctamente.";
        header("Location: ../admin/editar_laboratorio.php");
        exit;
    }
} else {
    $_SESSION['error'] = "Acceso no permitido.";
    header("Location: ../admin/index.php");
    exit;
}
