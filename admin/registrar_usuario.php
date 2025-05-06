<?php
include_once("../includes/header.php");
include_once("../includes/sidebar.php"); 


// Cargar empleados activos
try {
    $stmt = $conexion->prepare("SELECT * FROM empleados ");
    $stmt->execute();
    $empleados = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al cargar empleados: " . $e->getMessage());
}
?>

<div class="main-content">
    <?php include_once("../components/alerta.php");?>
    <div class="container-fluid mt-5 pt-2">
        <div class="row justify-content-center">
            <div class="card shadow rounded-4 p-4">
                <div class="card-header bg-primary text-white rounded-3 mb-4">
                    <h4 class="mb-0 d-flex align-items-center">
                        <i class="bi bi-person-plus-fill me-2 fs-4"></i> Registrar Usuario
                    </h4>
                </div>

                <div class="card-body">
                    <form action="../php/insertar_usuarios.php" method="POST" class="needs-validation" novalidate>

                        <div class="row">

                            <!-- Selección de Empleado -->
                            <div class="mb-4 col-12">
                                <label for="empleado_id" class="form-label fw-semibold fs-5">
                                    <i class="bi bi-person-circle me-2 text-primary"></i>Empleado <span class="text-danger">*</span>
                                </label>
                                <select class="form-select shadow-sm form-select-lg" id="empleado_id" name="empleado_id" required>
                                    <option selected disabled value="">Selecciona un empleado</option>
                                    <?php foreach ($empleados as $empleado): ?>
                                        <option value="<?= htmlspecialchars($empleado['id_empleado']) ?>"
                                            data-correo="<?= htmlspecialchars($empleado['correo']) ?>"
                                            data-codigo="<?= htmlspecialchars($empleado['codigo_empleado']) ?>">
                                            <?= htmlspecialchars($empleado['nombre'] . " " . $empleado['apellido']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback">
                                    Selecciona un empleado válido.
                                </div>
                            </div>

                            <!-- Correo (rellenado automático) -->
                            <div class="mb-4 col-12 col-md-6">
                                <label for="correo" class="form-label fw-semibold fs-5">
                                    <i class="bi bi-envelope-fill me-2 text-primary"></i>Correo Electrónico
                                </label>
                                <input type="text" class="form-control shadow-sm form-control-lg" name="correo" id="correo" disabled>
                            </div>

                            <!-- Código Empleado (rellenado automático) -->
                            <div class="mb-4 col-12 col-md-6">
                                <label for="codigo_empleado" class="form-label fw-semibold fs-5">
                                    <i class="bi bi-card-list me-2 text-primary"></i>Código Empleado
                                </label>
                                <input type="text" class="form-control shadow-sm form-control-lg" name="codigo_empleado" id="codigo_empleado" disabled>
                            </div>

                            <!-- Contraseña -->
                            <div class="mb-4 col-12 col-md-6">
                                <label for="password" class="form-label fw-semibold fs-5">
                                    <i class="bi bi-lock-fill me-2 text-primary"></i>Contraseña <span class="text-danger">*</span>
                                </label>
                                <input type="password" class="form-control shadow-sm form-control-lg" id="password" name="password" placeholder="Nueva contraseña" required disabled minlength="6">
                                <div class="invalid-feedback">
                                    Ingresa una contraseña válida (mínimo 6 caracteres).
                                </div>
                            </div>

                            <!-- Repetir Contraseña -->
                            <div class="mb-4 col-12 col-md-6">
                                <label for="password_repeat" class="form-label fw-semibold fs-5">
                                    <i class="bi bi-lock-fill me-2 text-primary"></i>Repetir Contraseña <span class="text-danger">*</span>
                                </label>
                                <input type="password" class="form-control shadow-sm form-control-lg" id="password_repeat" name="password_repeat" placeholder="Repite la contraseña" required disabled minlength="6">
                                <div class="invalid-feedback">
                                    Repite la contraseña correctamente.
                                </div>
                            </div>

                            <!-- Selección de Rol -->
                            <div class="mb-4 col-12">
                                <label for="rol" class="form-label fw-semibold fs-5">
                                    <i class="bi bi-person-badge-fill me-2 text-primary"></i>Rol <span class="text-danger">*</span>
                                </label>
                                <select class="form-select shadow-sm form-select-lg" id="rol" name="rol" required disabled>
                                    <option selected disabled value="">Selecciona un rol</option>
                                    <option value="1">Administrador</option>
                                    <option value="5">Enfermera</option>
                                    <option value="2">Médico</option>
                                    <option value="3">Recepcion</option>
                                </select>
                                <div class="invalid-feedback">
                                    Selecciona un rol válido.
                                </div>
                            </div>

                        </div>

                        <!-- Botones -->
                        <div class="d-flex justify-content-between flex-column flex-sm-row gap-3">
                            <a href="listar_usuario.php" class="btn btn-outline-secondary w-100 fs-5 py-2">
                                <i class="bi bi-arrow-left me-2"></i>Volver
                            </a>
                            <button type="submit" class="btn btn-primary w-100 fs-5 py-2">
                                <i class="bi bi-person-plus-fill me-2"></i>Registrar Usuario
                            </button>
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
// Activar campos cuando se selecciona un empleado
document.getElementById('empleado_id').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const correo = selectedOption.getAttribute('data-correo');
    const codigo = selectedOption.getAttribute('data-codigo');

    // Rellenar los campos de correo y código automáticamente
    document.getElementById('correo').value = correo;
    document.getElementById('codigo_empleado').value = codigo;

    // Habilitar los campos de correo y código, que estaban inicialmente deshabilitados
    document.getElementById('correo').disabled = false;
    document.getElementById('codigo_empleado').disabled = false;

    // Habilitar los campos de contraseña y rol
    document.getElementById('password').disabled = false;
    document.getElementById('password_repeat').disabled = false;
    document.getElementById('rol').disabled = false;
});

// Validación Bootstrap
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
