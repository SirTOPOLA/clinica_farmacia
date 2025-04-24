<?php
session_start(); // Iniciar la sesión

// Incluir el archivo de configuración de la base de datos (ajusta según tu configuración)
include '../config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger los datos del formulario
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    // Preparar la consulta SQL para verificar si el usuario existe y está activo
    $sql = "SELECT * FROM usuarios WHERE correo = ? AND activo = 1";

    if ($stmt = $conexion->prepare($sql)) {
        // Ejecutar la consulta con el correo
        $stmt->execute([$correo]);

        // Verificar si se encontró un usuario
        if ($stmt->rowCount() > 0) {
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verificar la contraseña
            if (password_verify($contrasena, $usuario['contrasena'])) {
                // Si la contraseña es correcta, guardar información en la sesión
                $_SESSION['id_usuario'] = $usuario['id_usuario'];
                $_SESSION['nombre_empleado'] = $usuario['nombre_empleado'];
                $_SESSION['id_rol'] = $usuario['id_rol'];
                $_SESSION['correo'] = $usuario['correo'];

                // Redirigir al usuario a la página de inicio (o donde lo desees)
                header("Location: ../admin/index.php");
                exit;
            } else {
                // Si la contraseña es incorrecta
                $_SESSION['mensaje'] = "Correo o contraseña incorrectos.";
                header("Location: ../index.php");
                exit;
            }
        } else {
            // Si el usuario no está activo o no existe
            $_SESSION['mensaje'] = "Este usuario no está activo o no existe.";
            header("Location: ../index.php");
            exit;
        }
    } else {
        // Si hay un error en la consulta
        $_SESSION['mensaje'] = "Error en la consulta de base de datos.";
        header("Location: ../index.php");
        exit;
    }
}
?>
