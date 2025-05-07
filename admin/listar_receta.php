<?php
include_once("../includes/header.php");
include_once("../includes/sidebar.php");


$id_usuario = $_SESSION['id_usuario'];

// Obtener el rol del usuario
$query = "SELECT r.nombre_rol FROM usuarios u JOIN roles r ON u.id_rol = r.id_rol WHERE u.id_usuario = :id_usuario";
$stmt = $conexion->prepare($query);
$stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
$stmt->execute();
$rol = $stmt->fetchColumn();

// Obtener recetas con datos de paciente y empleado
$query = "
  SELECT r.*, p.nombre AS paciente, e.nombre AS empleado
  FROM recetas r
  LEFT JOIN pacientes p ON r.id_paciente = p.id_paciente
  LEFT JOIN empleados e ON r.id_empleado = e.id_empleado
  ORDER BY r.fecha DESC
";
$stmt = $conexion->prepare($query);
$stmt->execute();
$recetas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="main-content">
  <div class="conten-wrapper">
    <div class="card shadow-lg mt-4 border-0">
      <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white rounded-top">
        <h2 class="mb-0"><span class="material-icons">medical_services</span> Gestión de Recetas</h2>
        <button class="btn btn-primary text-white shadow-sm rounded-3" onclick="window.location='listar_triaje.php'">
          <span class="material-icons">add</span> Nueva Receta
        </button>
      </div>

      <div class="card-body bg-light">
        <div class="row mb-3 justify-content-center">
          <div class="col-md-6">
            <div class="input-group">
              <input type="text" id="buscar" class="form-control shadow-sm rounded" placeholder="🔍 Buscar por paciente, medicamento o empleado..." oninput="buscarRecetas()">
            </div>
          </div>
        </div>

        <div id="tabla-recetas" class="table-responsive">
          <table class="table table-striped table-hover shadow-sm rounded">
            <thead class="bg-secondary text-white">
              <tr>
                <th>Paciente</th>
                <th>Empleado</th>
                <th>Fecha</th>
                <th>Medicamento</th>
                <th>Duración</th>
                <th>Indicaciones</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody id="recetas-body">
              <?php foreach ($recetas as $i => $receta): ?>
                <tr class="receta-fila <?= $i >= 8 ? 'd-none' : '' ?>">
                  <td><?= htmlspecialchars($receta['paciente']) ?></td>
                  <td><?= htmlspecialchars($receta['empleado']) ?></td>
                  <td><?= htmlspecialchars($receta['fecha']) ?></td>
                  <td><?= htmlspecialchars($receta['medicamento']) ?></td>
                  <td><?= htmlspecialchars($receta['duracion']) ?></td>
                  <td><?= htmlspecialchars($receta['indicaciones']) ?></td>

                  <td>
                    <a href="imprimir_receta.php?id=<?= $receta['id_receta'] ?>" class="btn btn-secondary btn-sm" target="_blank">
                      <span class="material-icons">print</span> Imprimir
                    </a>
                    <?php if ($rol === 'ADMINISTRADOR'): ?>
                      <a href="eliminar_receta.php?id=<?= $receta['id_receta'] ?>" class="btn btn-danger btn-sm">
                        <span class="material-icons">delete</span> Eliminar
                      </a>
                    <?php endif; ?>
                  </td>

                 
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>

        <!-- Paginación -->
        <div id="paginacion" class="d-flex justify-content-center mt-3"></div>
      </div>
    </div>
  </div>
</div>

<script>
  const filas = document.querySelectorAll(".receta-fila");
  const filasPorPagina = 8;
  const paginacion = document.getElementById("paginacion");

  function mostrarPagina(pagina) {
    const inicio = (pagina - 1) * filasPorPagina;
    const fin = pagina * filasPorPagina;

    filas.forEach((fila, i) => {
      fila.classList.toggle("d-none", i < inicio || i >= fin);
    });

    // Actualizar botones
    paginacion.innerHTML = "";
    const totalPaginas = Math.ceil(filas.length / filasPorPagina);
    for (let i = 1; i <= totalPaginas; i++) {
      const btn = document.createElement("button");
      btn.textContent = i;
      btn.className = "btn btn-outline-primary mx-1";
      if (i === pagina) btn.classList.add("active");
      btn.onclick = () => mostrarPagina(i);
      paginacion.appendChild(btn);
    }
  }

  mostrarPagina(1);

  function buscarRecetas() {
    const filtro = document.getElementById("buscar").value.toLowerCase();
    let contador = 0;

    filas.forEach((fila) => {
      const texto = fila.innerText.toLowerCase();
      const visible = texto.includes(filtro);
      fila.classList.toggle("d-none", !visible || contador >= filasPorPagina);
      if (visible) contador++;
    });

    if (filtro === "") mostrarPagina(1);
    else paginacion.innerHTML = ""; // Ocultar paginación al filtrar
  }
</script>