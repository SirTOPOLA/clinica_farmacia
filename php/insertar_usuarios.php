<?php
session_start();
require_once '../config/conexion.php';

// Sanitizar y validar entradas
$codigo_empleado = htmlspecialchars(trim($_POST['codigo_empleado'] ?? ''));
$correo = filter_var(trim($_POST['correo'] ?? ''), FILTER_SANITIZE_EMAIL);
$contrasena = trim($_POST['contrasena'] ?? '');
$id_rol = intval($_POST['id_rol'] ?? 0);

// Inicializar arreglo de errores
$errores = [];

// Validaciones
if (empty($codigo_empleado)) {
    $errores[] = "El código de empleado es obligatorio.";
} elseif (!preg_match('/^[A-Za-z0-9]+$/', $codigo_empleado)) {
    $errores[] = "El código de empleado solo debe contener letras y números.";
}

if (empty($correo)) {
    $errores[] = "El correo es obligatorio.";
} elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    $errores[] = "El correo no tiene un formato válido.";
}

if (empty($contrasena)) {
    $errores[] = "La contraseña es obligatoria.";
} elseif (strlen($contrasena) < 8 || !preg_match('/[A-Za-z]/', $contrasena) || !preg_match('/[0-9]/', $contrasena) || !preg_match('/[\W_]/', $contrasena)) {
    $errores[] = "La contraseña debe tener al menos 8 caracteres, incluir letras, números y un carácter especial.";
}

if ($id_rol <= 0) {
    $errores[] = "Debe seleccionar un rol válido.";
}

// Mostrar errores si existen
if (!empty($errores)) {
    $_SESSION['mensaje'] = implode("<br>", $errores);
    $_SESSION['tipo'] = "error";
    header("Location: ../admin/listar_usuario.php");
    exit;
}

try {
    // Verificar que el empleado exista en la tabla empleados
    $stmtEmp = $conexion->prepare("SELECT COUNT(*) FROM empleados WHERE codigo_empleado = ?");
    $stmtEmp->execute([$codigo_empleado]);
    if ($stmtEmp->fetchColumn() == 0) {
        throw new Exception("El código de empleado no existe en la base de datos.");
    }

    // Verificar que el rol exista
    $stmtRol = $conexion->prepare("SELECT COUNT(*) FROM roles WHERE id_rol = ?");
    $stmtRol->execute([$id_rol]);
    if ($stmtRol->fetchColumn() == 0) {
        throw new Exception("El rol seleccionado no existe.");
    }

    // Verificar duplicados
    $stmtDup = $conexion->prepare("SELECT COUNT(*) FROM usuarios WHERE codigo_empleado = ? OR correo = ?");
    $stmtDup->execute([$codigo_empleado, $correo]);
    if ($stmtDup->fetchColumn() > 0) {
        throw new Exception("Este usuario o correo ya está registrado.");
    }

    // Hashear la contraseña
    $hash = password_hash($contrasena, PASSWORD_BCRYPT);

    // Insertar usuario
    $stmt = $conexion->prepare("INSERT INTO usuarios (codigo_empleado, correo, contrasena, id_rol, activo) 
                                VALUES (?, ?, ?, ?, TRUE)");
    $stmt->execute([$codigo_empleado, $correo, $hash, $id_rol]);

    $_SESSION['mensaje'] = "Usuario registrado correctamente.";
    $_SESSION['tipo'] = "success";
    header("Location: ../admin/listar_usuario.php");
    exit;

} catch (Exception $e) {
    $_SESSION['mensaje'] = "Error: " . $e->getMessage();
    $_SESSION['tipo'] = "error";
    header("Location: ../admin/listar_usuario.php");
    exit;
}
?>
