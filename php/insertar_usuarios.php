<?php
session_start();
include '../config/conexion.php';

// Sanitizar entradas
$codigo_empleado = htmlspecialchars(trim($_POST['codigo_empleado']));
$correo = filter_var(trim($_POST['correo']), FILTER_SANITIZE_EMAIL);
$contrasena = trim($_POST['contrasena']);
$id_rol = intval($_POST['id_rol']);

// Validaciones
$errores = [];

if (empty($codigo_empleado)) {
    $errores[] = "El código de empleado es obligatorio.";
} elseif (!preg_match('/^[A-Za-z0-9]+$/', $codigo_empleado)) {
    $errores[] = "El código de empleado solo puede contener letras y números.";
}

if (empty($correo)) {
    $errores[] = "El correo electrónico es obligatorio.";
} elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    $errores[] = "El correo electrónico no es válido.";
}

if (empty($contrasena)) {
    $errores[] = "La contraseña es obligatoria.";
} elseif (strlen($contrasena) < 8) {
    $errores[] = "La contraseña debe tener al menos 8 caracteres.";
} elseif (!preg_match('/[A-Za-z]/', $contrasena) || !preg_match('/[0-9]/', $contrasena) || !preg_match('/[\W_]/', $contrasena)) {
    $errores[] = "La contraseña debe contener al menos una letra, un número y un carácter especial.";
}

if (empty($id_rol)) {
    $errores[] = "El rol es obligatorio.";
}

if (count($errores) > 0) {
    $_SESSION['mensaje'] = implode("<br>", $errores);
    $_SESSION['tipo'] = "error";
    header("Location: ../admin/listar_usuario.php");
    exit;
}

try {
    // Verificar duplicados
    $verificar = $conexion->prepare("SELECT COUNT(*) FROM usuarios WHERE codigo_empleado = ? OR correo = ?");
    $verificar->execute([$codigo_empleado, $correo]);

    if ($verificar->fetchColumn() > 0) {
        $_SESSION['mensaje'] = "Este empleado o correo ya está registrado.";
        $_SESSION['tipo'] = "error";
        header("Location: ../admin/listar_usuario.php");
        exit;
    }

    // Verificar rol válido
    $verificar_rol = $conexion->prepare("SELECT COUNT(*) FROM roles WHERE id_rol = ?");
    $verificar_rol->execute([$id_rol]);

    if ($verificar_rol->fetchColumn() == 0) {
        $_SESSION['mensaje'] = "El rol seleccionado no es válido.";
        $_SESSION['tipo'] = "error";
        header("Location: ../admin/listar_usuario.php");
        exit;
    }

    // Encriptar contraseña
    $contrasena_hash = password_hash($contrasena, PASSWORD_BCRYPT);

    // Insertar en BD
    $sql = "INSERT INTO usuarios (codigo_empleado, correo, contrasena, id_rol, activo) 
            VALUES (:codigo_empleado, :correo, :contrasena, :id_rol, TRUE)";
    
    $stmt = $conexion->prepare($sql);
    $stmt->execute([
        ':codigo_empleado' => $codigo_empleado,
        ':correo' => $correo,
        ':contrasena' => $contrasena_hash,
        ':id_rol' => $id_rol
    ]);

    $_SESSION['mensaje'] = "Usuario registrado con éxito.";
    $_SESSION['tipo'] = "success";
    header("Location: ../admin/listar_usuario.php");
    exit;

} catch (PDOException $e) {
    $_SESSION['mensaje'] = "Error: " . $e->getMessage();
    $_SESSION['tipo'] = "error";
    header("Location: ../admin/listar_usuario.php");
    exit;
}
