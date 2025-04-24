<?php
include '../config/conexion.php';
include_once("../includes/header.php");
include_once("../includes/sidebar.php");

try {
    $sql = "SELECT * FROM empleados ORDER BY id_empleado DESC";
    $stmt = $conexion->query($sql);
    $empleados = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("<div class='alert alert-danger mt-4'>Error al obtener empleados: " . htmlspecialchars($e->getMessage()) . "</div>");
}
?>

<main class="main-content container mt-4">
    <div class="card shadow-sm rounded-4 border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center rounded-top-4">
            <h5 class="mb-0"><i class="bi bi-people-fill me-2"></i> Lista de Empleados</h5>
            <a href="registrar_empleado.php" class="btn btn-light btn-sm">
                <i class="bi bi-person-plus-fill me-1"></i> Nuevo Empleado
            </a>
        </div>
        <div class="card-body p-4 table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Correo</th>
                        <th>Teléfono</th>
                        <th>Dirección</th>
                        <th>Horario</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($empleados)): ?>
                        <?php foreach ($empleados as $emp): ?>
                            <tr>
                                <td><?= htmlspecialchars($emp['id_empleado']) ?></td>
                                <td><?= htmlspecialchars($emp['codigo_empleado']) ?></td>
                                <td><?= htmlspecialchars($emp['nombre']) ?></td>
                                <td><?= htmlspecialchars($emp['apellido']) ?></td>
                                <td><?= htmlspecialchars($emp['correo']) ?></td>
                                <td><?= htmlspecialchars($emp['telefono']) ?></td>
                                <td><?= htmlspecialchars($emp['direccion']) ?></td>
                                <td><?= htmlspecialchars($emp['horario_trabajo']) ?></td>
                                <td class="text-center">
                                    <a href="editar_empleado.php?id=<?= $emp['id_empleado'] ?>" class="btn btn-warning btn-sm me-1" title="Editar">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    <a href="eliminar_empleado.php?id=<?= $emp['id_empleado'] ?>" class="btn btn-danger btn-sm" title="Eliminar" onclick="return confirm('¿Estás seguro de que deseas eliminar este empleado?');">
                                        <i class="bi bi-trash-fill"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center text-muted">No hay empleados registrados.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<!-- JS de Bootstrap 5 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
