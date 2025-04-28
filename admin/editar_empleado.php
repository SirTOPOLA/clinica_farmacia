<?php 
include_once("../includes/header.php");
include_once("../includes/sidebar.php");

// Aquí deberías obtener los datos del empleado a editar
// Suponiendo que recibes el ID por GET (ej: editar_empleado.php?id=5)
if (isset($_GET['id'])) {
    
    $id = intval($_GET['id']);
    $stmt = $conexion->prepare("SELECT * FROM empleados WHERE id_empleado = ?");
    $stmt->execute([$id]);
    $empleado = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$empleado) {
        // Si no existe el empleado, redirigir
        header("Location: listar_empleado.php");
        exit;
    }
} else {
    header("Location: listar_empleado.php");
    exit;
}
?>

<div class="main-content">
    <?php include_once("../components/alerta.php");?>
    <div class="container-fluid mt-5 pt-2">
        <div class="row justify-content-center">
           
            <div class="card shadow rounded-4 p-4">
                <div class="card-header bg-success text-white rounded-3 mb-4">
                    <h4 class="mb-0 d-flex align-items-center">
                        <i class="bi bi-pencil-square me-2 fs-4"></i>
                        Editar Empleado
                    </h4>
                </div>
                <div class="card-body">
                    <form action="../php/put_empleado.php" method="POST" class="needs-validation" novalidate>
                        <input type="hidden" name="id" value="<?= htmlspecialchars($empleado['id_empleado']) ?>">

                        <div class="row col-12 ">

                            <!-- Nombre -->
                            <div class="mb-4 col-12 col-md-6">
                                <label for="nombre" class="form-label fw-semibold fs-5">
                                    <i class="bi bi-person-circle me-2 text-primary"></i>Nombre <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control shadow-sm form-control-lg" id="nombre"
                                    name="nombre" value="<?= htmlspecialchars($empleado['nombre']) ?>" required>
                                <div class="invalid-feedback">
                                    Por favor ingresa el nombre del empleado.
                                </div>
                            </div>

                            <!-- Apellido -->
                            <div class="mb-4 col-12 col-md-6">
                                <label for="apellido" class="form-label fw-semibold fs-5">
                                    <i class="bi bi-person-circle me-2 text-primary"></i>Apellido <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control shadow-sm form-control-lg" id="apellido"
                                    name="apellido" value="<?= htmlspecialchars($empleado['apellido']) ?>" required>
                                <div class="invalid-feedback">
                                    Por favor ingresa el apellido del empleado.
                                </div>
                            </div>

                            <!-- Correo Electrónico -->
                            <div class="mb-4 col-12 col-md-6">
                                <label for="correo" class="form-label fw-semibold fs-5">
                                    <i class="bi bi-envelope-fill me-2 text-primary"></i>Correo Electrónico <span class="text-danger">*</span>
                                </label>
                                <input type="email" class="form-control shadow-sm form-control-lg" id="correo"
                                    name="correo" value="<?= htmlspecialchars($empleado['correo']) ?>" required>
                                <div class="invalid-feedback">
                                    Ingresa un correo electrónico válido.
                                </div>
                            </div>

                            <!-- Teléfono -->
                            <div class="mb-4 col-12 col-md-6">
                                <label for="telefono" class="form-label fw-semibold fs-5">
                                    <i class="bi bi-telephone-fill me-2 text-primary"></i>Teléfono <span class="text-danger">*</span>
                                </label>
                                <input type="tel" class="form-control shadow-sm form-control-lg" id="telefono"
                                    name="telefono" value="<?= htmlspecialchars($empleado['telefono']) ?>" required>
                                <div class="invalid-feedback">
                                    Ingresa un número de teléfono válido.
                                </div>
                            </div>

                            <!-- Dirección -->
                            <div class="mb-4 col-12 col-md-6">
                                <label for="direccion" class="form-label fw-semibold fs-5">
                                    <i class="bi bi-geo-alt-fill me-2 text-primary"></i>Dirección <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control shadow-sm form-control-lg" id="direccion"
                                    name="direccion" value="<?= htmlspecialchars($empleado['direccion']) ?>" required>
                                <div class="invalid-feedback">
                                    Por favor ingresa una dirección.
                                </div>
                            </div>

                            <!-- Horario de Trabajo -->
                            <div class="mb-4 col-12 col-md-6">
                                <label for="horario_trabajo" class="form-label fw-semibold fs-5">
                                    <i class="bi bi-clock-fill me-2 text-primary"></i>Horario de Trabajo <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control shadow-sm form-control-lg" id="horario_trabajo"
                                    name="horario_trabajo" value="<?= htmlspecialchars($empleado['horario_trabajo']) ?>" required>
                                <div class="invalid-feedback">
                                    Por favor ingresa el horario de trabajo.
                                </div>
                            </div>

                            <!-- Botones -->
                            <div class="d-flex justify-content-between flex-column flex-sm-row gap-3">
                                <a href="listar_empleado.php" class="btn btn-outline-secondary w-100 fs-5 py-2">
                                    <i class="bi bi-arrow-left me-2"></i>Volver
                                </a>
                                <button type="submit" class="btn btn-success text-white w-100 fs-5 py-2">
                                    <i class="bi bi-save2 me-2"></i>Guardar Cambios
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    (() => {
        'use strict'
        const forms = document.querySelectorAll('.needs-validation')
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', e => {
                if (!form.checkValidity()) {
                    e.preventDefault()
                    e.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
    })()
</script>

<script src="../assets/js/alerta.js"></script>
