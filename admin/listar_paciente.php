<?php
include_once("../includes/header.php");
include_once("../includes/sidebar.php");


$stmt = $conexion->query("SELECT * FROM pacientes");
$pacientes = $stmt->fetchAll(PDO::FETCH_ASSOC);




// Verificar si el usuario está autenticado
if (!isset($_SESSION['id_usuario'])) {
  echo "<div class='alert alert-danger'>No estás autenticado. Por favor, inicia sesión.</div>";
  exit;
}

$id_usuario = $_SESSION['id_usuario'];

// Obtener el rol del usuario
$sql = "SELECT r.nombre_rol AS roles FROM usuarios u
        JOIN roles r ON u.id_rol = r.id_rol
        WHERE u.id_usuario = ?";
$stmt = $conexion->prepare($sql);
$stmt->execute([$id_usuario]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);
$rol_usuario = $usuario ? $usuario['roles'] : '';
?>

<!-- Main Content -->
<div class="main-content">
  <div class="conten-wrapper">
    <div class="card shadow-lg mt-4 border-0">
      <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white rounded-top">
        <h2 class="mb-0"><span class="material-icons">group</span> Gestión de Pacientes</h2>
        <button class="btn btn-primary text-white shadow-sm rounded-3" onclick="window.location='registrar_paciente.php'">
          <span class="material-icons"> add</span>
        </button>
      </div>

      <!-- para las elertas -->
      <!-- para las alertas -->
      <div id="alert-container" class="mb-3">
        <?php include_once("../includes/sidebar.php"); ?>
      </div>

      <div class="card-body bg-light">
        <div class="row mb-3 justify-content-center">
          <div class="col-md-6">
            <div class="input-group">
              <input type="text" id="buscar" class="form-control shadow-sm rounded" placeholder="🔍 Buscar por nombre, código, género, correo..."
                oninput="buscarPacientes()">
            </div>
          </div>
        </div>

        <div id="tabla-pacientes" class="table-responsive">
          <!-- Aquí se cargará la tabla con los pacientes -->
          <table class="table table-striped table-hover shadow-sm rounded">
            <thead class="bg-secondary text-white">
              <tr>
              <th><span class="material-icons"></span> Id</th>
                <th><span class="material-icons">fingerprint</span> Código</th>
                <th><span class="material-icons">person</span> Nombre</th>
                <th><span class="material-icons">cake</span> Nacimiento</th>
                <th><span class="material-icons">transgender</span> Género</th>
                <th><span class="material-icons">phone</span> Teléfono</th>
                <th><span class="material-icons">email</span> Correo</th>
                <th><span class="material-icons">home</span> Dirección</th>
                <th><span class="material-icons">date_range</span> Registro</th>
                <th><span class="material-icons">settings</span> Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($pacientes as $paciente): ?>
                <tr>
                <td><?= htmlspecialchars($paciente['id_paciente']) ?></td>
                  <td><?= htmlspecialchars($paciente['codigo']) ?></td>
                  <td><?= htmlspecialchars($paciente['nombre'] . ' ' . $paciente['apellido']) ?></td>
                  <td><?= htmlspecialchars($paciente['fecha_nacimiento']) ?></td>
                  <td><?= htmlspecialchars($paciente['genero']) ?></td>
                  <td><?= htmlspecialchars($paciente['telefono']) ?></td>
                  <td><?= htmlspecialchars($paciente['correo']) ?></td>
                  <td><?= htmlspecialchars($paciente['direccion']) ?></td>
                  <td><?= htmlspecialchars($paciente['fecha_registro']) ?></td>
                  

                    <td>
  <button class="btn btn-sm btn-primary">Editar</button>
  <?php if ($rol_usuario !== 'RECEPCION'): ?>
    <button class="btn btn-sm btn-danger">Eliminar</button>
  <?php endif; ?>
</td>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>

        <!-- Paginación -->
        <div id="paginacion" class="d-flex justify-content-center">
          <!-- Los enlaces de paginación se cargarán aquí -->
        </div>
      </div>
    </div>
  </div>
</div>



</body>

</html>