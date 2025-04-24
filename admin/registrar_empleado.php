<?php
include_once("../includes/header.php");
?>
<!-- Main Content -->
<div class="main-content">
    <!-- Sección Registro de Empleados -->
    <div id="registroEmpleado" class="card p-4 mt-4">
        <h4 class="mb-3"><i class="bi bi-person-plus-fill me-2"></i>Registrar Nuevo Empleado</h4>

        <form action="../php/insertar_empleados.php" method="POST">
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="codigo_empleado" class="form-label">Código de Empleado</label>
                    <input type="text" class="form-control" id="codigo_empleado" name="codigo_empleado">
                </div>
                <div class="col-md-4">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
                <div class="col-md-4">
                    <label for="apellido" class="form-label">Apellido</label>
                    <input type="text" class="form-control" id="apellido" name="apellido" required>
                </div>

                <div class="col-md-6">
                    <label for="correo" class="form-label">Correo Electrónico</label>
                    <input type="email" class="form-control" id="correo" name="correo">
                </div>
                <div class="col-md-6">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="tel" class="form-control" id="telefono" name="telefono">
                </div>

                <div class="col-md-8">
                    <label for="direccion" class="form-label">Dirección</label>
                    <input type="text" class="form-control" id="direccion" name="direccion">
                </div>
                <div class="col-md-4">
                    <label for="horario_trabajo" class="form-label">Horario de Trabajo</label>
                    <input type="text" class="form-control" id="horario_trabajo" name="horario_trabajo">
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-1"></i> Registrar Empleado
                </button>
                <a href="#empleados" class="btn btn-secondary ms-2">
                    <i class="bi bi-arrow-left-circle me-1"></i> Volver a la lista
                </a>
            </div>
        </form>
    </div>





</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
setTimeout(() => {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => alert.remove());
}, 5000);
</script>
</body>

</html>