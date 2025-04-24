<?php
include '../config/conexion.php';

// Sanitizar entradas
$nombre = htmlspecialchars(trim($_POST['nombre']));
$apellido = htmlspecialchars(trim($_POST['apellido']));
$correo = filter_var(trim($_POST['correo']), FILTER_SANITIZE_EMAIL);
$telefono = htmlspecialchars(trim($_POST['telefono']));
$direccion = htmlspecialchars(trim($_POST['direccion']));
$horario_trabajo = htmlspecialchars(trim($_POST['horario_trabajo']));

$errores = [];

// Validaciones
if (empty($nombre)) $errores[] = "El nombre es obligatorio.";
if (empty($apellido)) $errores[] = "El apellido es obligatorio.";
if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) $errores[] = "Correo no válido.";

if (!empty($errores)) {
    foreach ($errores as $error) {
        echo "<div class='alert error'>$error</div>";
    }
    exit;
}

try {
    // Verificar duplicado
    $verificar = $conexion->prepare("SELECT COUNT(*) FROM empleados WHERE nombre = ? AND apellido = ? AND correo = ?");
    $verificar->execute([$nombre, $apellido, $correo]);

    if ($verificar->fetchColumn() > 0) {
        echo "<div class='alert error'>Este empleado ya está registrado.</div>";
        exit;
    }

    // Generar código
    $iniciales = strtoupper(substr($nombre, 0, 1) . substr($apellido, 0, 1));
    $fecha = date('Ymd');

    // Contar empleados registrados hoy
    $contar = $conexion->prepare("SELECT COUNT(*) FROM empleados WHERE codigo_empleado LIKE ?");
    $contar->execute(["{$iniciales}{$fecha}%"]);
    $contador = $contar->fetchColumn() + 1;

    $codigo_empleado = "{$iniciales}{$fecha}" . str_pad($contador, 3, '0', STR_PAD_LEFT);

    // Insertar empleado
    $sql = "INSERT INTO empleados 
            (codigo_empleado, nombre, apellido, correo, telefono, direccion, horario_trabajo)
            VALUES 
            (:codigo, :nombre, :apellido, :correo, :telefono, :direccion, :horario)";
    
    $stmt = $conexion->prepare($sql);
    $stmt->execute([
        ':codigo' => $codigo_empleado,
        ':nombre' => $nombre,
        ':apellido' => $apellido,
        ':correo' => $correo,
        ':telefono' => $telefono,
        ':direccion' => $direccion,
        ':horario' => $horario_trabajo
    ]);

    echo "<div class='alert success'>Empleado registrado con éxito. Código: <strong>$codigo_empleado</strong></div>";

} catch (PDOException $e) {
    echo "<div class='alert error'>Error: " . $e->getMessage() . "</div>";
}
?>
