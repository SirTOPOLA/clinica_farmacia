<?php
include_once("../includes/header.php");

include '../config/conexion.php';


try {
    $sql = "SELECT * FROM empleados ORDER BY id_empleado DESC";
    $stmt = $conexion->query($sql);
    $empleados = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al obtener empleados: " . $e->getMessage());
}



?>
<!-- Main Content -->
<div class="main-content">

    <!-- Sección de Empleados -->
    <div id="empleados" class="card p-4 mt-4">



        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0"><i class="bi bi-people-fill me-2"></i>Lista de Empleados</h4>
            <a href="registrar_empleado.php" class="btn btn-success">
                <i class="bi bi-person-plus-fill me-1"></i> Nuevo Empleado
            </a>
        </div>

        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Direccion</th>
                    <th>Horacio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>


                <?php if (count($empleados) > 0): ?>
                    <?php foreach ($empleados as $emp): ?>
                        <tr>
                            <td><?= $emp['id_empleado'] ?></td>
                            <td><?= $emp['codigo_empleado'] ?></td>
                            <td><?= htmlspecialchars($emp['nombre']) ?></td>
                            <td><?= htmlspecialchars($emp['apellido']) ?></td>
                            <td><?= htmlspecialchars($emp['correo']) ?></td>
                            <td><?= htmlspecialchars($emp['telefono']) ?></td>
                            <td><?= htmlspecialchars($emp['direccion']) ?></td>
                            <td><?= htmlspecialchars($emp['horario_trabajo']) ?></td>
                            <td>
                                <button class="btn btn-sm btn-warning" title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" title="Eliminar">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" style="text-align:center;">No hay empleados registrados.</td>
                    </tr>
                <?php endif; ?>


            </tbody>
        </table>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>