<?php
session_start(); // ¡IMPORTANTE! Iniciar la sesión al principio

include './config/conexion.php';

// Cargar roles para el select
$roles = [];
try {
    $stmt = $conexion->query("SELECT id_rol, nombre_rol FROM roles");
    $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $_SESSION['alerta'] = [
        'tipo' => 'danger',
        'mensaje' => 'Error al cargar roles: ' . $e->getMessage()
    ];
}

// Procesar formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo_empleado = $_POST["codigo_empleado"];
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $correo = $_POST["correo"];
    $telefono = $_POST["telefono"];
    $direccion = $_POST["direccion"];
    $horario_trabajo = $_POST["horario_trabajo"];
    $contrasena = password_hash($_POST["contrasena"], PASSWORD_BCRYPT);
    $id_rol = $_POST["id_rol"];

    try {
        $conexion->beginTransaction();

        // Insertar en empleados
        $sql1 = "INSERT INTO empleados (codigo_empleado, nombre, apellido, correo, telefono, direccion, horario_trabajo)
                 VALUES (:codigo, :nombre, :apellido, :correo, :telefono, :direccion, :horario)";
        $stmt1 = $conexion->prepare($sql1);
        $stmt1->execute([
            ":codigo" => $codigo_empleado,
            ":nombre" => $nombre,
            ":apellido" => $apellido,
            ":correo" => $correo,
            ":telefono" => $telefono,
            ":direccion" => $direccion,
            ":horario" => $horario_trabajo
        ]);

        // Insertar en usuarios
        $sql2 = "INSERT INTO usuarios (codigo_empleado, correo, contrasena, id_rol)
                 VALUES (:codigo, :correo, :contrasena, :rol)";
        $stmt2 = $conexion->prepare($sql2);
        $stmt2->execute([
            ":codigo" => $codigo_empleado,
            ":correo" => $correo,
            ":contrasena" => $contrasena,
            ":rol" => $id_rol
        ]);

        $conexion->commit();

        $_SESSION['alerta'] = [
            'tipo' => 'success',
            'mensaje' => '¡Registro exitoso!'
        ];

        header("Location: " . $_SERVER['PHP_SELF']); // Recargar la página
        exit;
    } catch (PDOException $e) {
        $conexion->rollBack();
        $_SESSION['alerta'] = [
            'tipo' => 'error',
            'mensaje' => 'Error al registrar: ' . $e->getMessage()
        ];
    }
}
?>

<!-- HTML DEL FORMULARIO -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Empleado</title>
<link rel="stylesheet" href="./assets/css/alerta.css">
   <script src="./assets/js/alerta.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Registrar Empleado y Usuario</h4>
        </div>
        <div class="card-body">
            
                <?php include_once('./components/alerta.php');?>

            <form method="POST"  >
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Código de Empleado</label>
                        <input type="text" name="codigo_empleado" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Apellido</label>
                        <input type="text" name="apellido" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Correo</label>
                        <input type="email" name="correo" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Teléfono</label>
                        <input type="text" name="telefono" class="form-control">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Dirección</label>
                        <input type="text" name="direccion" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Horario de Trabajo</label>
                        <input type="text" name="horario_trabajo" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Contraseña</label>
                        <input type="password" name="contrasena" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Rol</label>
                        <select name="id_rol" class="form-select" required>
                            <option value="">Seleccione un rol</option>
                            <?php foreach ($roles as $rol): ?>
                                <option value="<?= $rol['id_rol'] ?>"><?= htmlspecialchars($rol['nombre_rol']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-success">Registrar</button>
                    <button type="reset" class="btn btn-secondary">Limpiar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
