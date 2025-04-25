<?php 
include_once("../includes/header.php");
include_once("../includes/sidebar.php");
 


// Obtener pacientes
$stmt = $conexion->query("SELECT * FROM pacientes ORDER BY fecha_registro DESC");
$pacientes = $stmt->fetchAll(PDO::FETCH_ASSOC);



?>
<!-- Main Content -->
<div class="main-content">


  <!-- Sección de Pacientes -->
  <div id="pacientes" class="card p-4 mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h4 class="mb-0"><i class="bi bi-person-lines-fill me-2"></i>Lista de Pacientes</h4>
      <a href="registrar_Paciente.php" class="btn btn-primary">
        <i class="bi bi-person-plus-fill me-1"></i> Nuevo Paciente
      </a>
    </div>

    <table class="table table-hover">
      <thead class="table-light">
        <tr>
          <th>#</th>
          <th>Código</th>
          <th>Nombre</th>
          <th>Apellido</th>
          <th>Fecha-Nacimiento</th>
          <th>Género</th>
          <th>Teléfono</th>
          <th>Correo</th>
          <th>Registro</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($pacientes as $p): ?>
          <tr>
          <td><?= htmlspecialchars($p['id_paciente']) ?></td>
            <td><?= htmlspecialchars($p['codigo']) ?></td>
            <td><?= htmlspecialchars($p['nombre']) ?></td>
            <td><?= htmlspecialchars($p['apellido']) ?></td>
            <td><?= htmlspecialchars($p['fecha_nacimiento']) ?></td>
            <td><?= htmlspecialchars($p['genero']) ?></td>
            <td><?= htmlspecialchars($p['telefono']) ?></td>
            <td><?= htmlspecialchars($p['correo']) ?></td>
            <td><?= htmlspecialchars($p['fecha_registro']) ?></td>
            <td>
              <button class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></button>
              <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>



</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>