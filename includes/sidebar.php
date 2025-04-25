<?php

 
// Variables por defecto
$nombre_empleado = "Usuario";
$rol = "administrador"; // Rol por defecto

// Verificamos si existe el id_usuario en sesión
$id_usuario = $_SESSION['id_usuario'] ?? 0;

if ($id_usuario > 0) {
    $sql = "SELECT CONCAT(e.nombre, ' ', e.apellido) AS nombre_empleado, LOWER(r.nombre_rol) AS rol
            FROM usuarios u
            JOIN empleados e ON u.codigo_empleado = e.codigo_empleado
            JOIN roles r ON u.id_rol = r.id_rol
            WHERE u.id_usuario = ? LIMIT 1";

    $stmt = $conn->prepare($sql);
    $stmt->execute([$id_usuario]);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($fila = $resultado->fetch_assoc()) {
        $nombre_empleado = $fila['nombre_empleado'];
        $rol = strtolower($fila['rol']);
    }
}

// Determinar la página actual para resaltar la activa
$pagina = basename($_SERVER['PHP_SELF']);

function activo($archivo) {
  global $pagina;
  return $pagina === $archivo ? 'active' : '';
}

// Menú definido con permisos por rol
$menu = [
  'Clínica' => [
    ['listar_paciente.php', 'bi bi-people', 'Pacientes', ['recepcion', 'administrador']],
    ['listar_cita.php', 'bi bi-calendar-event', 'Citas', ['recepcion', 'medico', 'administrador']],
    ['listar_triaje.php', 'bi bi-heart-pulse', 'Triaje', ['enfermeria', 'administrador']],
    ['listar_tratamiento.php', 'bi bi-clipboard2-pulse', 'Tratamiento', ['enfermeria', 'administrador']],
    ['listar_pruebas.php', 'bi bi-file-earmark-medical', 'Pruebas médicas', ['medico', 'administrador']],
    ['listar_laboratorio.php', 'bi bi-beaker', 'Laboratorio', ['laboratorio', 'medico', 'administrador']],
    ['listar_receta.php', 'bi bi-prescription', 'Recetas', ['medico', 'administrador']],
  ],
  'Farmacia' => [
    ['listar_farmacia.php', 'bi bi-capsule', 'Farmacia', ['recepcion', 'administrador']],
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

<!-- SIDEBAR -->
<div class="d-flex">
  <aside class="sidebar">
    <div class="sidebar-header">
      <strong><?= htmlspecialchars($nombre_empleado) ?></strong><br>
      <small>Rol: <?= ucfirst($rol) ?></small>
    </div>
    <ul class="nav flex-column">
      <li class="nav-item">
        <a href="index.php" class="nav-link <?= activo('index.php') ?>">
          <i class="bi bi-house-door"></i> Dashboard
        </a>
      </li>
      <?php foreach ($menu as $modulo => $links): ?>
        <?php $enlaces_visibles = array_filter($links, fn($link) => in_array($rol, $link[3])); ?>
        <?php if (count($enlaces_visibles) > 0): ?>
          <li class="nav-section-title"><?= strtoupper($modulo) ?></li>
          <?php foreach ($enlaces_visibles as [$url, $icon, $texto]): ?>
            <li class="nav-item">
              <a href="<?= $url ?>" class="nav-link <?= activo($url) ?>">
                <i class="<?= $icon ?>"></i> <?= $texto ?>
              </a>
            </li>
          <?php endforeach; ?>
        <?php endif; ?>
      <?php endforeach; ?>
      <li class="nav-item mt-3">
        <a href="../php/cerrar_sesion.php" class="nav-link text-white">
          <i class="bi bi-box-arrow-right"></i> Salir
        </a>
      </li>
    </ul>
  </aside>
