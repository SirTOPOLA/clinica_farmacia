
<?php

// Iniciar la sesión para poder usar $_SESSION
session_start();

// Incluir archivo de conexión a la base de datos
include '../config/conexion.php';

// Procesar formulario cuando se envía mediante POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // ---------------------------
    // Sanitización de datos recibidos
    // ---------------------------
    $nombre = htmlspecialchars(trim($_POST['nombre']));
    $apellido = htmlspecialchars(trim($_POST['apellido']));
    $correo = filter_var(trim($_POST['correo']), FILTER_SANITIZE_EMAIL);
    $telefono = htmlspecialchars(trim($_POST['telefono']));
    $direccion = htmlspecialchars(trim($_POST['direccion']));
    $horario_trabajo = htmlspecialchars(trim($_POST['horario_trabajo']));

    // ---------------------------
    // Validaciones de campos
    // ---------------------------

    // Validar nombre
    if (empty($nombre)) {
        $_SESSION['alerta'] = ['tipo' => 'error', 'mensaje' => "El campo nombre es obligatorio."];
        header("Location: ../admin/registrar_empleado.php");
        exit();
    }

    // Validar apellido
    if (empty($apellido)) {
        $_SESSION['alerta'] = ['tipo' => 'error', 'mensaje' => "El campo apellido es obligatorio."];
        header("Location: ../admin/registrar_empleado.php");
        exit();
    }

    // Validar correo
    if (empty($correo)) {
        $_SESSION['alerta'] = ['tipo' => 'error', 'mensaje' => "El campo correo es obligatorio."];
        header("Location: ../admin/registrar_empleado.php");
        exit();
    }

    // Validar formato de correo
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['alerta'] = ['tipo' => 'error', 'mensaje' => "El formato del correo electrónico no es válido."];
        header("Location: ../admin/registrar_empleado.php");
        exit();
    }

    // Validar teléfono
    if (empty($telefono)) {
        $_SESSION['alerta'] = ['tipo' => 'error', 'mensaje' => "El campo teléfono es obligatorio."];
        header("Location: ../admin/registrar_empleado.php");
        exit();
    }

    if (strlen($telefono) < 9) {
        $_SESSION['alerta'] = ['tipo' => 'error', 'mensaje' => "El teléfono debe tener al menos 9 dígitos."];
        header("Location: ../admin/registrar_empleado.php");
        exit();
    }

    // Validar dirección
    if (empty($direccion)) {
        $_SESSION['alerta'] = ['tipo' => 'error', 'mensaje' => "El campo dirección es obligatorio."];
        header("Location: ../admin/registrar_empleado.php");
        exit();
    }

    // Validar horario de trabajo
    if (empty($horario_trabajo)) {
        $_SESSION['alerta'] = ['tipo' => 'error', 'mensaje' => "El campo horario de trabajo es obligatorio."];
        header("Location: ../admin/registrar_empleado.php");
        exit();
    }

    try {
        // ---------------------------
        // Verificar si el correo ya está registrado
        // ---------------------------
        $sql = "SELECT COUNT(*) FROM empleados WHERE correo = :correo";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([':correo' => $correo]);
        $existeCorreo = $stmt->fetchColumn();

        if ($existeCorreo > 0) {
            $_SESSION['alerta'] = ['tipo' => 'error', 'mensaje' => "Este correo ya está registrado."];
            header("Location: ../admin/registrar_empleado.php");
            exit();
        }

        // ---------------------------
        // Generar código de empleado
        // ---------------------------

        // Iniciales del empleado
        $iniciales = strtoupper(substr($nombre, 0, 1) . substr($apellido, 0, 1));
        // Fecha actual en formato YYYYMMDD
        $fecha = date('Ymd');

        // Contar empleados existentes con mismo patrón de código
        $contar = $conexion->prepare("SELECT COUNT(*) FROM empleados WHERE codigo_empleado LIKE :codigo");
        $contar->execute([':codigo' => "{$iniciales}{$fecha}%"]);
        $duplicados = $contar->fetchColumn() + 1; // Incrementar para garantizar unicidad

        // Crear código único del empleado
        $codigo_empleado = "{$iniciales}{$fecha}" . str_pad($duplicados, 3, '0', STR_PAD_LEFT);

        // ---------------------------
        // Insertar nuevo empleado
        // ---------------------------
        $sql = "INSERT INTO empleados (codigo_empleado, nombre, apellido, correo, telefono, direccion, horario_trabajo)
                VALUES (:codigo, :nombre, :apellido, :correo, :telefono, :direccion, :horario)";
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

        // ---------------------------
        // Éxito
        // ---------------------------
        $_SESSION['alerta'] = ['tipo' => 'success', 'mensaje' => "Empleado registrado con éxito. Código: " . $codigo_empleado];
        header("Location: ../admin/listar_empleado.php");
        exit();

    } catch (PDOException $e) {
        // ---------------------------
        // Error de base de datos
        // ---------------------------
        $_SESSION['alerta'] = ['tipo' => 'error', 'mensaje' => "Error en la base de datos: " . $e->getMessage()];
        header("Location: ../admin/registrar_empleado.php");
        exit();
    }
}
?>



