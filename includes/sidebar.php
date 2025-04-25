<?php
// Seguridad básica: iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Variables por defecto
$nombre_empleado = "Usuario";
$rol = "administrador"; // Rol por defecto

// Validamos si existe un ID de usuario en la sesión
$id_usuario = $_SESSION['id_usuario'] ?? 0;

if ($id_usuario > 0 && is_numeric($id_usuario)) {
    try {
        // Consulta segura usando PDO para obtener datos del usuario logueado
        $sql = "SELECT CONCAT(e.nombre, ' ', e.apellido) AS nombre_empleado, LOWER(r.nombre_rol) AS rol
                FROM usuarios u
                JOIN empleados e ON u.codigo_empleado = e.codigo_empleado
                JOIN roles r ON u.id_rol = r.id_rol
                WHERE u.id_usuario = ? LIMIT 1";

        $stmt = $conexion->prepare($sql);
        $stmt->execute([$id_usuario]);

        if ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $nombre_empleado = $fila['nombre_empleado'];
            $rol = strtolower($fila['rol']);
        }
    } catch (PDOException $e) {
        // Log de errores si fuera necesario: error_log($e->getMessage());
        die("Error al obtener los datos del usuario.");
    }
}

// Determina la página actual para marcar la opción activa en el menú
$pagina = basename($_SERVER['PHP_SELF']);

// Función para asignar clase "active" al enlace actual
function activo($archivo) {
    global $pagina;
    return $pagina === $archivo ? 'active' : '';
}

// Menú principal estructurado por módulos, con permisos por rol
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
<aside class="sidebar" aria-label="Menú lateral" >


  <div class="sidebar-fade top"></div>

  <!-- Encabezado del sidebar con el nombre y rol del usuario -->
  <div class="sidebar-header border-bottom">
    <strong><?= htmlspecialchars($nombre_empleado) ?></strong><br>
    <small>Rol: <?= ucfirst(htmlspecialchars($rol)) ?></small>
  </div>

  <!-- Navegación lateral -->
  <ul class="nav flex-column">
    <li class="nav-item">
      <a href="index.php" class="nav-link <?= activo('index.php') ?>">
        <i class="bi bi-house-door"></i> Dashboard
      </a>
    </li>

    <?php foreach ($menu as $modulo => $links): ?>
      <?php
        // Filtrar solo los enlaces visibles para el rol
        $enlaces_visibles = array_filter($links, fn($link) => in_array($rol, $link[3]));
      ?>
      <?php if (!empty($enlaces_visibles)): ?>
        <li class="nav-section-title border-top pt-3"><?= strtoupper(htmlspecialchars($modulo)) ?></li>
        <?php foreach ($enlaces_visibles as [$url, $icon, $texto]): ?>
          <li class="nav-item">
            <a href="<?= htmlspecialchars($url) ?>" class="nav-link <?= activo($url) ?>">
              <i class="<?= htmlspecialchars($icon) ?>"></i> <?= htmlspecialchars($texto) ?>
            </a>
          </li>
        <?php endforeach; ?>
      <?php endif; ?>
    <?php endforeach; ?>

    <!-- Botón de salir -->
    <li class="nav-item mt-4 border-top pt-3">
      <a href="../php/cerrar_sesion.php" class="nav-link nav-link-exit">
        <i class="bi bi-box-arrow-right"></i> Salir
      </a>
    </li>
  </ul>

  <div class="sidebar-fade bottom"></div>
</aside>
<!-- aplica sombra oscura en movil cuando el sidebar esta abierto -->
<div class="sidebar-overlay"></div>