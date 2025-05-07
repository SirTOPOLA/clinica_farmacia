<?php
include_once("../includes/header.php");
include_once("../includes/sidebar.php");

// Validar y obtener ID del paciente
if (!isset($_GET['id_paciente']) || !is_numeric($_GET['id_paciente'])) {
  echo "<div class='alert alert-danger'>ID de paciente no válido.</div>";
  exit;
}
$id_paciente = $_GET['id_paciente'];
$id_triaje = $_GET['id_triaje'];

// Obtener nombre del paciente
$stmt = $conexion->prepare("SELECT nombre FROM pacientes WHERE id_paciente = ?");
$stmt->execute([$id_paciente]);
$paciente = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$paciente) {
  echo "<div class='alert alert-danger'>Paciente no encontrado.</div>";
  exit;
}

// Obtener pruebas médicas
$stmt = $conexion->prepare("SELECT id_prueba, nombre FROM pruebas_medicas ORDER BY nombre ASC");
$stmt->execute();
$pruebas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="main-content">
  <div class="conten-wrapper">
    <div class="card shadow-lg mt-4 border-0">
      <div class="card-header bg-primary text-white rounded-top d-flex justify-content-between align-items-center">
        <h2 class="mb-0"><span class="material-icons">science</span> Asignar Pruebas Médicas</h2>
        <button class="btn btn-outline-light" onclick="window.history.back()">
          <span class="material-icons">arrow_back</span> Volver
        </button>
      </div>

      <div class="card-body bg-light">
        <form action="../php/insertar_lab.php" method="POST">
          <input type="hidden" name="id_paciente" value="<?= htmlspecialchars($id_paciente) ?>">
          <input type="hidden" name="id_triaje" value="<?= htmlspecialchars($id_triaje) ?>">

          <div class="mb-3">
            <label class="form-label fw-bold">Nombre del Paciente</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($paciente['nombre']) ?>" disabled>
          </div>

          <div class="mb-3">
            <label class="form-label fw-bold">Fecha de Asignación</label>
            <input type="date" name="fecha_asignacion" class="form-control" value="<?= date('Y-m-d') ?>" readonly>
          </div>

          <div class="mb-3">
            <label class="form-label fw-bold">Observaciones</label>
            <textarea name="observaciones" id="observaciones" class="form-control" rows="3"></textarea>
            <div id="error-observaciones" class="invalid-feedback" style="display: none;">
              Las observaciones no pueden estar vacías.
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label fw-bold">Buscar Prueba Médica</label>
            <input type="text" id="buscador" class="form-control" placeholder="🔍 Escribe para buscar...">
          </div>

          <div class="mb-3">
            <label class="form-label fw-bold">Seleccionar Pruebas</label>
            <div id="lista-pruebas" class="border rounded p-3 bg-white" style="max-height: 200px; overflow-y: auto; display: none;">
              <?php foreach ($pruebas as $prueba): ?>
                <div class="form-check">
                  <input class="form-check-input prueba-checkbox" type="checkbox" value="<?= $prueba['id_prueba'] ?>" id="prueba<?= $prueba['id_prueba'] ?>">
                  <label class="form-check-label" for="prueba<?= $prueba['id_prueba'] ?>">
                    <?= htmlspecialchars($prueba['nombre']) ?>
                  </label>
                </div>
              <?php endforeach; ?>
            </div>
          </div>

          <div class="mb-4">
            <label class="form-label fw-bold">Pruebas Seleccionadas</label>
            <ul id="seleccionadas" class="list-group"></ul>
            <div id="error-pruebas" class="invalid-feedback" style="display: none;">
              Debes seleccionar al menos una prueba.
            </div>
          </div>

          <div class="text-end">
            <button type="submit" class="btn btn-primary">
              <span class="material-icons">check_circle</span> Asignar Pruebas
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  const buscador = document.getElementById('buscador');
  const lista = document.getElementById('lista-pruebas');
  const seleccionadas = document.getElementById('seleccionadas');

  // Mostrar la lista de pruebas solo cuando el usuario busque
  buscador.addEventListener('input', () => {
    const filtro = buscador.value.toLowerCase();
    if (filtro.length > 0) {
      lista.style.display = 'block'; // Mostrar la lista de pruebas
    } else {
      lista.style.display = 'none'; // Ocultar la lista si el campo de búsqueda está vacío
    }

    // Filtrar pruebas según el texto introducido
    const items = lista.querySelectorAll('.form-check');
    items.forEach(item => {
      const texto = item.textContent.toLowerCase();
      item.style.display = texto.includes(filtro) ? '' : 'none';
    });
  });

  // Manejar la selección de pruebas
  lista.addEventListener('change', () => {
    seleccionadas.innerHTML = '';
    lista.querySelectorAll('.prueba-checkbox:checked').forEach(checkbox => {
      const li = document.createElement('li');
      li.classList.add('list-group-item', 'd-flex', 'justify-content-between', 'align-items-center');
      li.textContent = checkbox.nextElementSibling.textContent;
      const btn = document.createElement('button');
      btn.classList.add('btn', 'btn-sm', 'btn-danger');
      btn.innerHTML = '<span class="material-icons" style="font-size:16px;">close</span>';
      btn.onclick = () => {
        checkbox.checked = false;
        li.remove();
      };
      li.appendChild(btn);
      seleccionadas.appendChild(li);

      const input = document.createElement('input');
      input.type = 'hidden';
      input.name = 'pruebas[]';
      input.value = checkbox.value;
      li.appendChild(input);
    });
  });

  // Validación al enviar el formulario
  document.querySelector('form').addEventListener('submit', function (e) {
    const observaciones = document.getElementById('observaciones');
    const errorObservaciones = document.getElementById('error-observaciones');
    const errorPruebas = document.getElementById('error-pruebas');
    const seleccionadas = document.querySelectorAll('#seleccionadas li');

    // Validar campo de observaciones
    if (observaciones.value.trim() === '') {
      e.preventDefault();
      observaciones.classList.add('is-invalid');
      errorObservaciones.style.display = 'block';
      observaciones.focus();
    } else {
      observaciones.classList.remove('is-invalid');
      errorObservaciones.style.display = 'none';
    }

    // Validar pruebas seleccionadas
    if (seleccionadas.length === 0) {
      e.preventDefault();
      errorPruebas.style.display = 'block';
    } else {
      errorPruebas.style.display = 'none';
    }
  });
</script>

</body>
</html>
