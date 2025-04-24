<?php 
include_once("../includes/header.php");
?>
  <!-- Main Content -->
  <div class="main-content">
  <div id="usuarios" class="card p-4">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Lista de Usuarios</h4>
        <button class="btn btn-primary" href="registrar_usuario.php">
          <i class="bi bi-person-plus-fill me-1"></i> Nuevo Usuario
        </button>
      </div>
      <table class="table table-hover">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Rol</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td>Juan Pérez</td>
            <td>juan@example.com</td>
            <td>Administrador</td>
            <td>
              <button class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></button>
              <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
            </td>
          </tr>
          <tr>
            <td>2</td>
            <td>Ana Gómez</td>
            <td>ana@example.com</td>
            <td>Recepcionista</td>
            <td>
              <button class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></button>
              <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
 

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
