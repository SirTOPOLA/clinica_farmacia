<?php
session_start();
include_once("../config/conexion.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = trim($_POST['nombre']);
    $precio = $_POST['precio'];

    // Validación robusta para 'nombre'
    if (empty($nombre)) {
        $_SESSION['alerta'] = [
            'tipo' => 'warning',
            'mensaje' => "El nombre de la prueba no puede estar vacío."
        ];
    } elseif (strlen($nombre) < 3) {
        $_SESSION['alerta'] = [
            'tipo' => 'warning',
            'mensaje' => "El nombre de la prueba debe tener al menos 3 caracteres."
        ];
    } elseif (!preg_match("/^[a-zA-Z0-9\s]+$/", $nombre)) {
        $_SESSION['alerta'] = [
            'tipo' => 'warning',
            'mensaje' => "El nombre de la prueba solo puede contener letras, números y espacios."
        ];
    }
    // Validación robusta para 'precio'
    elseif (empty($precio) || !is_numeric($precio) || $precio <= 0) {
        $_SESSION['alerta'] = [
            'tipo' => 'warning',
            'mensaje' => "El precio debe ser un número mayor a cero."
        ];
    }
    // Si los campos son válidos, guardar en la base de datos
    else {
        try {
            $sql = "INSERT INTO pruebas_medicas (nombre, precio) VALUES (:nombre, :precio)";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':precio', $precio);
            $stmt->execute();

            $_SESSION['alerta'] = [
                'tipo' => 'success',
                'mensaje' => "Prueba médica registrada correctamente."
            ];
        } catch (PDOException $e) {
            $_SESSION['alerta'] = [
                'tipo' => 'danger',
                'mensaje' => "Error al registrar: " . $e->getMessage()
            ];
        }
    }

    header("Location: ../admin/listar_pruebas.php"); // Redirige para evitar reenvíos
    exit();
}
?>
