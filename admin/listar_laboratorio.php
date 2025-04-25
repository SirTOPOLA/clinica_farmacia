<?php 
include_once("../includes/header.php");
include_once("../includes/sidebar.php");
?>
  <!-- Main Content -->
  <div class="main-content">
  <div id="laboratorio" class="card p-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Resultados de Laboratorio</h4>
    <a href="registrar_laboratorio.php" class="btn btn-primary">
      <i class="bi bi-plus-circle me-1"></i> Nuevo Resultado
    </a>
  </div>
  <table class="table table-hover">
    <thead class="table-light">
      <tr>
        <th>#</th>
        <th>Paciente</th>
        <th>Fecha</th>
        <th>Tipo de Estudio</th>
        <th>Resultado</th>
        <th>Observaciones</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>1</td>
        <td>Juan Pérez</td>
        <td>2025-04-15</td>
        <td>Hemograma Completo</td>
        <td>Normal</td>
        <td>Sin anomalías detectadas</td>
        <td>
          <button class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></button>
          <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
        </td>
      </tr>
      <tr>
        <td>2</td>
        <td>María Gómez</td>
        <td>2025-04-16</td>
        <td>Perfil Lipídico</td>
        <td>Colesterol alto</td>
        <td>Requiere seguimiento</td>
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
