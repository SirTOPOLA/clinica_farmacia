<?php
include_once("../includes/header.php");
include_once("../includes/sidebar.php");

// Cargar pacientes desde la base de datos
try {
  $stmt = $conexion->query("SELECT codigo, nombre, apellido FROM pacientes ORDER BY nombre");
  $pacientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  echo "<div class='alert alert-danger'>Error al cargar pacientes: " . $e->getMessage() . "</div>";
  $pacientes = [];
}

// Cargar médicos activos desde la base de datos
try {
  // Consulta SQL para obtener médicos activos
  $sql = "
      SELECT e.id_empleado, e.nombre, e.apellido
      FROM empleados e
      INNER JOIN usuarios u ON e.codigo_empleado = u.codigo_empleado
      INNER JOIN roles r ON u.id_rol = r.id_rol
      WHERE r.nombre_rol = 'MEDICO' AND u.activo = TRUE
      ORDER BY e.nombre
  ";
  $stmt = $conexion->query($sql);
  $medicos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  echo "<div class='alert alert-danger'>Error al cargar médicos: " . $e->getMessage() . "</div>";
  $medicos = [];
}
?>

<!-- Main Content -->
<div class="main-content container mt-4">
  <div class="card shadow-sm border-0 rounded-4">
    <div class="card-header bg-primary text-white rounded-top-4">
      <h5 class="mb-0"><i class="bi bi-calendar-plus me-2"></i> Registrar Nueva Cita</h5>
    </div>

    <div class="card-body">


    <form action="guardar_cita.php" method="POST" class="needs-validation" novalidate>

<!-- Campo para filtrar pacientes -->
<div class="mb-3">
  <label for="filtroPaciente" class="form-label">Buscar Paciente</label>
  <input type="text" class="form-control" id="filtroPaciente" placeholder="Buscar por nombre, apellido o código...">
</div>

<!-- Lista dinámica de pacientes con radio buttons, oculta inicialmente -->
<div class="mb-3" id="listaPacientesContainer" style="display: none;">
  <label class="form-label">Seleccione un paciente</label>
  <div class="list-group" id="listaPacientes">
    <!-- Pacientes se cargarán dinámicamente aquí -->
  </div>
  <div class="invalid-feedback">Seleccione un paciente.</div>
</div>

<!-- Empleado (Doctor) -->
<div class="mb-3">
  <label for="empleado" class="form-label">Empleado (Doctor)</label>
  <select class="form-select" id="empleado" name="id_empleado" required>
    <option selected disabled value="">Seleccione un médico</option>
    <?php foreach ($medicos as $medico): ?>
      <option value="<?php echo $medico['id_empleado']; ?>" style="background-color: #f0f8ff;">
        <?php echo $medico['nombre'] . ' ' . $medico['apellido']; ?>
      </option>
    <?php endforeach; ?>
  </select>
  <div class="invalid-feedback">Seleccione un médico responsable.</div>
</div>

<!-- Fecha de la cita -->
<div class="mb-3">
  <label for="fecha_cita" class="form-label">Fecha de la Cita</label>
  <input type="date" class="form-control" id="fecha_cita" name="fecha_cita" required>
  <div class="invalid-feedback">Ingrese una fecha válida.</div>
</div>

<!-- Hora de la cita -->
<div class="mb-3">
  <label for="hora_cita" class="form-label">Hora de la Cita</label>
  <input type="time" class="form-control" id="hora_cita" name="hora_cita" required>
  <div class="invalid-feedback">Ingrese una hora válida.</div>
</div>

<!-- Estado de la cita -->
<div class="mb-3">
  <label for="estado" class="form-label">Estado</label>
  <select class="form-select" id="estado" name="estado" required>
    <option value="pendiente" selected>Pendiente</option>
    <option value="confirmada">Confirmada</option>
    <option value="cancelada">Cancelada</option>
    <option value="completada">Completada</option>
  </select>
  <div class="invalid-feedback">Seleccione el estado de la cita.</div>
</div>

<!-- Botones -->
<div class="d-flex justify-content-between">
  <a href="listar_cita.php" class="btn btn-secondary">
    <i class="bi bi-arrow-left"></i> Volver
  </a>
  <button type="submit" class="btn btn-primary px-4">
    <i class="bi bi-save me-1"></i> Guardar Cita
  </button>
</div>

</form>

   



    </div>
  </div>
</div>


<!-- Script para búsqueda de pacientes -->
<!-- Script para búsqueda de pacientes -->
<script>
  document.getElementById('filtroPaciente').addEventListener('input', function () {
    const filtro = this.value.toLowerCase();
    const pacientes = <?php echo json_encode($pacientes); ?>;
    const filteredPacientes = pacientes.filter(paciente => 
      paciente.codigo.toLowerCase().includes(filtro) || 
      paciente.nombre.toLowerCase().includes(filtro) || 
      paciente.apellido.toLowerCase().includes(filtro)
    ).slice(0, 5);  // Solo mostrar los primeros 5

    const listaPacientesContainer = document.getElementById('listaPacientesContainer');
    const listaPacientes = document.getElementById('listaPacientes');

    listaPacientes.innerHTML = ''; // Limpiar resultados previos

    // Mostrar u ocultar la lista de pacientes según si hay coincidencias
    if (filtro.trim() === '') {
      listaPacientesContainer.style.display = 'none'; // Ocultar si no hay texto
    } else if (filteredPacientes.length > 0) {
      listaPacientesContainer.style.display = 'block'; // Mostrar la lista
      filteredPacientes.forEach(paciente => {
        const label = document.createElement('label');
        label.classList.add('list-group-item');
        label.style.backgroundColor = '#ADD8E6'; // Azul claro para diferenciar

        label.innerHTML = `
          <input class="form-check-input me-1" type="radio" name="codigo" value="${paciente.codigo}" required>
          ${paciente.codigo} - ${paciente.nombre} ${paciente.apellido}
        `;
        listaPacientes.appendChild(label);
      });
    } else {
      listaPacientesContainer.style.display = 'none'; // Ocultar si no hay coincidencias
    }
  });
</script>

<!-- Bootstrap JS y validación -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  (() => {
    'use strict';
    const forms = document.querySelectorAll('.needs-validation');
    Array.from(forms).forEach(form => {
      form.addEventListener('submit', event => {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  })();
</script>