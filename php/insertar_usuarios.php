<?php
session_start();  // Asegurarse de que la sesión esté iniciada
/* var_dump($_POST); // Mostrar los datos enviados para verificar
exit();
  */
// Conexión a la base de datos
include_once("../config/Conexion.php");
 

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $empleado_id = $_POST['empleado_id'];
    $correo = $_POST['correo'];
    $codigo_empleado = $_POST['codigo_empleado'];
    $password = $_POST['password'];
    $rol = $_POST['rol'];

    // Verificar si los campos no están vacíos
    if (empty($empleado_id) || empty($correo) || empty($codigo_empleado) || empty($password) || empty($rol)) {
        $_SESSION['alerta'] = ['tipo' => 'warning', 'mensaje' => "Todos los campos son obligatorios."];
        header("Location: ../admin/registrar_usuario.php");
        exit();
    }

    try {
        // Preparar la consulta para insertar el nuevo usuario
        $stmt = $conexion->prepare("INSERT INTO usuarios (  codigo_empleado, correo, contrasena, id_rol) VALUES (   :codigo_empleado, :correo, :password, :rol)");

        // Encriptar la contraseña
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Vincular los parámetros con el valor ;
        $stmt->bindParam(':codigo_empleado', $codigo_empleado);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':rol', $rol);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            $_SESSION['alerta'] = ['tipo'=> 'success', 'mensaje' => "Usuario registrado correctamente."];
        } else {
            // Obtener el error de la base de datos si algo salió mal
            $errorInfo = $stmt->errorInfo();
            $_SESSION['alerta'] = ['tipo' => 'error' , 'mensaje' =>"Error al registrar el usuario: " . $errorInfo[2]];
        }

        // Redirigir a la página de listado de usuarios
        header("Location: ../admin/listar_usuario.php");
        exit();

    } catch (PDOException $e) {
        // Manejar excepciones y almacenar el mensaje de error
        $_SESSION['alerta'] = ['tipo' => 'error', 'mensaje' => "Error al registrar el usuario: " . $e->getMessage()];
        header("Location: ../admin/registrar_usuario.php");
        exit();
    }
}
?>
