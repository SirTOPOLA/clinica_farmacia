<?php
session_start();
$user = $_SESSION['usuario'] = 'Dr. Santiago Obiang'; 

$rol = $_SESSION['rol'] ?? 'administrador';
$pagina = basename($_SERVER['PHP_SELF']);

function activo($archivo) {
  global $pagina;
  return $pagina === $archivo ? 'active' : '';
}

$menu = [
  'Clínica' => [
    ['listar_paciente.php', 'bi bi-people', 'Pacientes', ['reseccion', 'administrador']],
    ['listar_cita.php', 'bi bi-calendar-event', 'Citas', ['reseccion', 'medico', 'administrador']],
    ['listar_triaje.php', 'bi bi-heart-pulse', 'Triaje', ['enfermera', 'administrador']],
    ['listar_tratamiento.php', 'bi bi-clipboard2-pulse', 'Tratamiento', ['enfermera', 'administrador']],
    ['listar_pruebas.php', 'bi bi-file-earmark-medical', 'Pruebas médicas', ['medico', 'administrador']],
    ['listar_laboratorio.php', 'bi bi-beaker', 'Laboratorio', ['laboratorio', 'medico', 'administrador']],
    ['listar_receta.php', 'bi bi-prescription', 'Recetas', ['medico', 'administrador']],
  ],
  'Farmacia' => [
    ['listar_farmacia.php', 'bi bi-capsule', 'Farmacia', ['reseccion', 'administrador']],
  ],
  'Administración' => [
    ['listar_historial.php', 'bi bi-clock-history', 'Historial', ['administrador']],
    ['listar_empleado.php', 'bi bi-person-badge', 'Empleados', ['administrador']],
    ['listar_usuario.php', 'bi bi-person-gear', 'Usuarios', ['administrador']],
    ['listar_notificaciones.php', 'bi bi-bell', 'Notificaciones', ['administrador']],
    ['#configuracion', 'bi bi-gear', 'Configuración', ['administrador']],
  ]
];
?>

<!-- Botón hamburguesa (para móviles) -->
<button class="toggle-btn" onclick="document.querySelector('.sidebar').classList.toggle('show')">
  <i class="bi bi-list"></i>
</button>

<!-- Sidebar -->
<aside class="sidebar">
  <ul class="nav flex-column">
    <li class="nav-item">
      <a href="index.php" class="nav-link <?= activo('index.php') ?>">
        <i class="bi bi-house-door"></i> Dashboard
      </a>
    </li>

    <?php foreach ($menu as $modulo => $links): ?>
      <?php
        // Verificar si hay enlaces visibles para este rol
        $enlaces_visibles = array_filter($links, fn($link) => in_array($rol, $link[3]));
        if (count($enlaces_visibles) === 0) continue;
      ?>
      <li class="nav-section-title"><?= strtoupper($modulo) ?></li>
      <?php foreach ($enlaces_visibles as [$url, $icon, $texto]): ?>
        <li class="nav-item">
          <a href="<?= $url ?>" class="nav-link <?= activo($url) ?>">
            <i class="<?= $icon ?>"></i> <?= $texto ?>
          </a>
        </li>
      <?php endforeach; ?>
    <?php endforeach; ?>

    <li class="nav-item mt-3">
      <a href="logout.php" class="nav-link text-danger">
        <i class="bi bi-box-arrow-right"></i> Salir
      </a>
    </li>
  </ul>
</aside>
