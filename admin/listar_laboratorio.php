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

        <div class="row mb-3 justify-content-center">
          <div class="col-md-6">
            <div class="input-group">
              <input type="text" id="buscar" class="form-control shadow-sm rounded"
                placeholder="🔍 Buscar por paciente, tipo de estudio..."
                oninput="buscarLaboratorio()">
            </div>
          </div>
          <div class="col-md-3">
            <button class="btn btn-outline-success w-100 mt-2 mt-md-0" data-bs-toggle="modal" data-bs-target="#modalImprimir">
              🖨️ Imprimir por paciente
            </button>
          </div>
        </div>

        <div id="tabla-laboratorio" class="table-responsive">
          <table class="table table-striped table-hover shadow-sm rounded">
            <thead class="bg-secondary text-white">
              <tr>
                <th>Código</th>
                <th>Paciente</th>
                <th>Fecha</th>
                <th>Estudio</th>
                <th>Resultado</th>
                <th>Observaciones</th>
                <th>Pagado</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody id="tabla-datos">
              <?php

              $stmt = $conexion->query($sql);
              while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $observaciones = htmlspecialchars(strlen($fila['observaciones']) > 50 ? substr($fila['observaciones'], 0, 50) . '...' : $fila['observaciones']);
                $resultado_span = ($fila['resultado'] == 'Resultado pendiente') ? "<span class='badge bg-danger'>Pendiente</span>" : "<span class='badge bg-success'>Disponible</span>";
                $pagado_span = ($fila['pagado'] == 1) ? "<span class='badge bg-success'>Pagado</span>" : "<span class='badge bg-warning text-dark'>Pendiente</span>";

                $eliminar_button = ($rol_usuario == 'ADMINISTRADOR') ? "<a href='eliminar_laboratorio.php?id=" . $fila['id_resultado'] . "' class='btn btn-sm btn-danger'><i class='material-icons'>delete</i></a>" : "";
                $pagar_button = ($rol_usuario == 'ADMINISTRADOR') ? "<button class='btn btn-sm btn-info text-white' onclick='abrirModalPago(" . json_encode($fila) . ")'><i class='material-icons'>attach_money</i></button>" : "";
                $imprimir_button = ($rol_usuario == 'ADMINISTRADOR' || $rol_usuario == 'MEDICO') ? "<a href='imprimir_resultado.php?id=" . $fila['id_resultado'] . "' class='btn btn-sm btn-success'><i class='material-icons'>print</i></a>" : "";

                echo "<tr>";
                echo "<td>" . htmlspecialchars($fila['codigo']) . "</td>";
                echo "<td>" . htmlspecialchars($fila['paciente_nombre']) . "</td>";
                echo "<td>" . htmlspecialchars($fila['fecha']) . "</td>";
                echo "<td>" . htmlspecialchars($fila['prueba_nombre']) . "</td>";
                echo "<td>" . $resultado_span . "</td>";
                echo "<td>" . $observaciones . "</td>";
                echo "<td>" . $pagado_span . "</td>";
                echo "<td>";
                if ($rol_usuario == 'LABORATORIO') {
                  if ($fila['pagado'] == 1) {
                    if ($fila['resultado'] == 'Resultado pendiente') {
                      echo "<a href='editar_laboratorio.php?id=" . $fila['id_resultado'] . "' class='btn btn-sm btn-warning'><i class='material-icons'>edit</i></a>";
                    }
                    echo "<a href='imprimir_resultado.php?id=" . $fila['id_resultado'] . "' class='btn btn-sm btn-success'><i class='material-icons'>print</i></a>";
                  }
                }
                echo "$eliminar_button $imprimir_button $pagar_button";
                echo "</td>";
                echo "</tr>";
              }
              ?>
            </tbody>
          </table>

        </div>

        <!-- Mensaje fuera de la tabla -->
        <div id="mensaje-vacio" class="text-center text-muted py-3" style="display: none;">
          No se encontraron resultados.
        </div>

        <div id="paginacion" class="d-flex justify-content-center"></div>
      </div>
    </div>
  </div>
</div>

<!-- Modal de Pago -->
<div class="modal fade" id="modalPago" tabindex="-1" aria-labelledby="modalPagoLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content shadow-lg rounded-4" method="POST" action="../php/procesar_pago.php">
      <div class="modal-header bg-primary text-white rounded-top">
        <h5 class="modal-title" id="modalPagoLabel"><i class="material-icons me-1">payment</i> Confirmar Pago de Laboratorio</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body bg-light">
        <input type="hidden" name="id_resultado" id="modal_id_resultado">
        <div class="mb-3">
          <label class="form-label">Paciente</label>
          <input type="text" id="modal_paciente" class="form-control" readonly>
        </div>

        <div class="mb-3">
          <label class="form-label">Tipo de Estudio</label>
          <input type="text" id="modal_prueba" class="form-control" readonly>
        </div>

        <div class="mb-3">
          <label class="form-label">Precio</label>
          <input type="number" id="modal_precio" class="form-control bg-white" readonly>
        </div>

        <div class="mb-3">
          <label class="form-label">Monto a Pagar</label>
          <input type="number" name="monto" id="modal_monto" class="form-control" required>
          <div class="form-text text-danger d-none" id="monto-error">El monto debe coincidir con el precio.</div>
        </div>
      </div>

      <div class="modal-footer bg-light rounded-bottom">
        <button type="submit" class="btn btn-success w-100"><i class="material-icons">check_circle</i> Confirmar y Registrar Pago</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Imprimir Resultados -->
<div class="modal fade" id="modalImprimir" tabindex="-1" aria-labelledby="modalImprimirLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content shadow rounded-4" method="GET" action="imprimir_resultados_paciente.php" target="_blank">
      <div class="modal-header bg-primary text-white rounded-top">
        <h5 class="modal-title" id="modalImprimirLabel">🖨️ Imprimir Resultados por Paciente</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body bg-light">
        <div class="mb-3">
          <label for="codigo_paciente" class="form-label">Código del Paciente</label>
          <input type="text" class="form-control" name="codigo_paciente" id="codigo_paciente" required>
        </div>
        <div class="mb-3">
          <label for="fecha_resultado" class="form-label">Fecha de las pruebas(opcional)</label>
          <input type="date" class="form-control" name="fecha" id="fecha_resultado" required>
        </div>
      </div>
      <div class="modal-footer bg-light rounded-bottom">
        <button type="submit" class="btn btn-success w-100">Imprimir</button>
      </div>
    </form>
  </div>
</div>

<script>
  const registrosPorPagina = 8;
  let paginaActual = 1;
  let todasLasFilas = [];
  let filasFiltradas = [];

  document.addEventListener('DOMContentLoaded', () => {
    const tbody = document.querySelector('#tabla-datos');
    todasLasFilas = Array.from(tbody.querySelectorAll('tr'));
    filasFiltradas = [...todasLasFilas];

    mostrarPagina(paginaActual);
    agregarEventosBusqueda();
  });

  function mostrarPagina(pagina) {
    const inicio = (pagina - 1) * registrosPorPagina;
    const fin = inicio + registrosPorPagina;

    todasLasFilas.forEach(fila => fila.style.display = 'none');

    if (filasFiltradas.length === 0) {
      document.getElementById('mensaje-vacio').style.display = 'block';
    } else {
      document.getElementById('mensaje-vacio').style.display = 'none';
      filasFiltradas.forEach((fila, i) => {
        if (i >= inicio && i < fin) fila.style.display = '';
      });
    }

    mostrarPaginacion();
  }

  function mostrarPaginacion() {
    const totalPaginas = Math.ceil(filasFiltradas.length / registrosPorPagina);
    const paginacionDiv = document.getElementById('paginacion');
    paginacionDiv.innerHTML = '';

    if (totalPaginas <= 1) return;

    for (let i = 1; i <= totalPaginas; i++) {
      const boton = document.createElement('button');
      boton.className = 'btn btn-outline-primary mx-1';
      boton.textContent = i;
      if (i === paginaActual) boton.classList.add('active');
      boton.addEventListener('click', () => {
        paginaActual = i;
        mostrarPagina(i);
      });
      paginacionDiv.appendChild(boton);
    }
  }

  function agregarEventosBusqueda() {
    const inputBusqueda = document.getElementById('buscar');
    inputBusqueda.addEventListener('input', () => {
      const valor = inputBusqueda.value.toLowerCase();

      if (valor === '') {
        filasFiltradas = [...todasLasFilas];
      } else {
        filasFiltradas = todasLasFilas.filter(fila =>
          fila.textContent.toLowerCase().includes(valor)
        );
      }

      paginaActual = 1;
      mostrarPagina(paginaActual);
    });
  }
</script>

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

<!-- Enlazar Bootstrap JS y dependencias -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>

</html>