<?php
include_once("../includes/header.php");
include_once("../includes/sidebar.php");

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




if ($rol_usuario == 'LABORATORIO') {
  $sql = "SELECT l.*, p.nombre AS paciente_nombre, p.codigo, pr.nombre AS prueba_nombre, pr.precio
          FROM laboratorio l
          JOIN pacientes p ON l.id_paciente = p.id_paciente
          JOIN pruebas_medicas pr ON l.tipo_prueba = pr.id_prueba
          WHERE l.pagado = 1
          ORDER BY l.fecha DESC";
  $stmt = $conexion->query($sql);
} else {
  $sql = "SELECT l.*, p.nombre AS paciente_nombre, p.codigo, pr.nombre AS prueba_nombre, pr.precio
          FROM laboratorio l
          JOIN pacientes p ON l.id_paciente = p.id_paciente
          JOIN pruebas_medicas pr ON l.tipo_prueba = pr.id_prueba
          ORDER BY l.fecha DESC";
  $stmt = $conexion->query($sql);
}
?>

<div class="main-content">
  <div class="conten-wrapper">
    <div class="card shadow-lg mt-4 border-0">
      <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white rounded-top">
        <h2 class="mb-0"><span class="material-icons">science</span> Resultados de Laboratorio</h2>
       <?php if ($rol_usuario != 'LABORATORIO') : ?>
  <button class="btn btn-primary text-white shadow-sm rounded-3" onclick="window.location='listar_triaje.php'">
    <span class="material-icons">add</span>
  </button>
<?php endif; ?>

     
      </div>

      <div class="card-body bg-light">

        <!-- Alertas con sesión -->
        <div id="alert-container" class="mb-3">
          <?php if (isset($_SESSION['mensaje'])): ?>
            <div class="alert alert-<?= $_SESSION['tipo_mensaje'] ?? 'info' ?> alert-dismissible fade show" role="alert">
              <?= htmlspecialchars($_SESSION['mensaje']) ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
            <?php
            unset($_SESSION['mensaje']);
            unset($_SESSION['tipo_mensaje']);
            ?>
          <?php endif; ?>
        </div>

        

        <div class="row">
  <!-- Filtros -->
  <div class="col-md-12 mb-4">
    <div class="card shadow-sm border-0">
      <div class="card-body">
        <h5 class="card-title"><i class="material-icons">filter_alt</i> Filtros de Reporte</h5>
        <div class="row g-3">
          <div class="col-md-3">
            <label class="form-label">Filtrar por</label>
            <select id="tipo_filtro" class="form-select" onchange="actualizarFiltro()">
              <option value="dia">Día</option>
              <option value="semana">Semana</option>
              <option value="mes">Mes</option>
              <option value="año">Año</option>
            </select>
          </div>
          <div class="col-md-4">
            <label class="form-label">Fecha</label>
            <input type="date" id="fecha_filtro" class="form-control">
          </div>
          <div class="col-md-3">
            <label class="form-label d-block">Acción</label>
            <button class="btn btn-primary w-100" onclick="generarReporte()">Generar Reporte</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Reporte Consultas -->
  <div class="col-md-6">
    <div class="card shadow-sm border-0">
      <div class="card-body">
        <h5 class="card-title"><i class="material-icons">medical_services</i> Consultas Médicas</h5>
        <div id="reporte_consultas">
          <!-- Aquí se llenarán las consultas médicas filtradas -->
          <p class="text-muted">Sin datos hasta que se filtre.</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Reporte Pruebas -->
  <div class="col-md-6">
    <div class="card shadow-sm border-0">
      <div class="card-body">
        <h5 class="card-title"><i class="material-icons">science</i> Pruebas Médicas</h5>
        <div id="reporte_pruebas">
          <!-- Aquí se llenarán las pruebas médicas filtradas -->
          <p class="text-muted">Sin datos hasta que se filtre.</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Resumen de Ingresos -->
  <div class="col-md-12 mt-4">
    <div class="card bg-success text-white shadow-sm border-0">
      <div class="card-body d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0"><i class="material-icons">attach_money</i> Total Generado</h5>
        <h3 class="mb-0" id="total_generado">S/. 0.00</h3>
      </div>
    </div>
  </div>
</div>


      

      

      
      </div>
    </div>
  </div>
</div>







<!-- Ocultar alertas automáticamente -->
<script>
  setTimeout(() => {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
      alert.classList.remove('show');
      alert.classList.add('fade');
      setTimeout(() => alert.remove(), 500);
    });
  }, 10000);
</script>



<script>

function generarReporte() {
  const fecha = document.getElementById('fecha_filtro').value;
  const tipo = document.getElementById('tipo_filtro').value;

  if (!fecha) {
    alert('Por favor, selecciona una fecha.');
    return;
  }

  fetch('reporte_triaje.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: `fecha=${encodeURIComponent(fecha)}&tipo=${encodeURIComponent(tipo)}`
  })
  .then(response => response.json())
  .then(data => {
    if (data.error) {
      alert(data.error);
      return;
    }

    // Mostrar resultados en el div reporte_consultas
    const reporteConsultas = document.getElementById('reporte_consultas');
    reporteConsultas.innerHTML = '';

    if (data.registros.length === 0) {
      reporteConsultas.innerHTML = '<p class="text-muted">No se encontraron registros.</p>';
    } else {
      let html = '<ul class="list-group">';
      data.registros.forEach(registro => {
        html += `<li class="list-group-item d-flex justify-content-between align-items-center">
                  ${registro.id_triaje} - ${registro.fecha}
                  <span class="badge bg-primary rounded-pill">XAF/. ${parseFloat(registro.precio).toFixed(2)}</span>
                </li>`;
      });
      html += '</ul>';
      reporteConsultas.innerHTML = html;
    }

    // Mostrar el total
    document.getElementById('total_generado').textContent = `XAF/. ${parseFloat(data.total).toFixed(2)}`;

  })
  .catch(error => {
    console.error('Error al generar reporte:', error);
    alert('Error al generar reporte');
  });
}


</script>



<!-- Enlazar Bootstrap JS y dependencias -->

<script src="../assets/js/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>

</body>

</html>