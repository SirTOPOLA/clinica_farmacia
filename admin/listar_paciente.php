
<?php 
include_once("../includes/header.php");
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
        <th>Género</th>
        <th>Teléfono</th>
        <th>Correo</th>
        <th>Registro</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <!-- Datos de ejemplo, deben venir desde la BD -->
      <tr>
        <td>1</td>
        <td>PA001</td>
        <td>Laura</td>
        <td>Martínez</td>
        <td>Femenino</td>
        <td>222-456-789</td>
        <td>laura@example.com</td>
        <td>2024-11-10</td>
        <td>
          <button class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></button>
          <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
        </td>
      </tr>
      <tr>
        <td>2</td>
        <td>PA002</td>
        <td>Carlos</td>
        <td>Gómez</td>
        <td>Masculino</td>
        <td>555-123-789</td>
        <td>carlos@example.com</td>
        <td>2025-01-05</td>
        <td>
          <button class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></button>
          <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
        </td>
      </tr>
    </tbody>
  </table>
</div>



</div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
