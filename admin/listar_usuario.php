<?php
include_once("../includes/header.php");
include_once("../includes/sidebar.php");
include '../config/conexion.php';

$stmt = $conexion->query("
    SELECT u.id_usuario, u.codigo_empleado, u.correo, u.activo,
           e.nombre AS nombre_empleado, e.apellido AS apellido_empleado,
           r.nombre_rol
    FROM usuarios u
    JOIN empleados e ON u.codigo_empleado = e.codigo_empleado
    JOIN roles r ON u.id_rol = r.id_rol
    ORDER BY u.id_usuario DESC
");
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Main Content -->
<div class="main-content container mt-4">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center rounded-top-4">
            <h5 class="mb-0"><i class="bi bi-people-fill me-2"></i> Lista de Usuarios</h5>
            <a class="btn btn-light btn-sm" href="registrar_usuario.php">
                <i class="bi bi-person-plus-fill me-1"></i> Nuevo Usuario
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light text-center">
                        <tr>
                            <th>#</th>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Rol</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $u): ?>
                            <tr>
                                <td class="text-center"><?= htmlspecialchars($u['id_usuario']) ?></td>
                                <td class="text-center"><?= htmlspecialchars($u['codigo_empleado']) ?></td>
                                <td><?= htmlspecialchars($u['nombre_empleado'] . ' ' . $u['apellido_empleado']) ?></td>
                                <td><?= htmlspecialchars($u['correo']) ?></td>
                                <td class="text-center"><span class="badge bg-info text-dark"><?= htmlspecialchars($u['nombre_rol']) ?></span></td>
                                <td class="text-center">
                                    <span class="badge <?= $u['activo'] ? 'bg-success' : 'bg-secondary' ?>">
                                        <?= $u['activo'] ? 'Activo' : 'Inactivo' ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-warning me-1" onclick="editarUsuario(<?= $u['id_usuario'] ?>)" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </button>

                                    <?php if ($u['activo']): ?>
                                        <button class="btn btn-sm btn-outline-secondary me-1" onclick="confirmarDesactivar(<?= $u['id_usuario'] ?>)" title="Desactivar">
                                            <i class="bi bi-person-dash"></i>
                                        </button>
                                    <?php else: ?>
                                        <button class="btn btn-sm btn-outline-success me-1" onclick="confirmarActivar(<?= $u['id_usuario'] ?>)" title="Activar">
                                            <i class="bi bi-person-check"></i>
                                        </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                        <?php if (empty($usuarios)): ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted">No hay usuarios registrados.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function confirmarDesactivar(idUsuario) {
    if (confirm("¿Estás seguro de que deseas desactivar este usuario?")) {
        window.location.href = '../php/desactivar_usuario.php?id_usuario=' + idUsuario;
    }
}

function confirmarActivar(idUsuario) {
    if (confirm("¿Estás seguro de que deseas activar este usuario?")) {
        window.location.href = '../php/activar_usuario.php?id_usuario=' + idUsuario;
    }
}

function editarUsuario(idUsuario) {
    window.location.href = 'editar_usuario.php?id_usuario=' + idUsuario;
}
</script>
