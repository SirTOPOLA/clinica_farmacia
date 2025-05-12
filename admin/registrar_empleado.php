<?php 
include_once("../includes/header.php");
include_once("../includes/sidebar.php");
?>

<div class="main-content">
    <?php include_once("../components/alerta.php");?>
    <div class="container-fluid mt-5 pt-2">
        <div class="row justify-content-center">
            
            <div class="card shadow rounded-4 p-4">
                <div class="card-header bg-primary text-white rounded-3 mb-4">
                    <h4 class="mb-0 d-flex align-items-center">
                        <i class="bi bi-person-plus-fill me-2 fs-4"></i>
                        Registrar Empleado
                    </h4>
                </div>
                <div class="card-body">
                    <form action="../php/post_empleados.php" method="POST" class="needs-validation" novalidate>
                        <div class="row col-12 ">

                            <!-- Código de Empleado -->
                            <!--  <div class="mb-4 col-12 col-md-6">
                                    <label for="codigo_empleado" class="form-label fw-semibold fs-5">
                                        <i class="bi bi-key me-2 text-primary"></i>Código de Empleado <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control shadow-sm form-control-lg" id="codigo_empleado" name="codigo_empleado" placeholder="Ej. EMP123456" required>
                                    <div class="invalid-feedback">
                                        Por favor ingresa el código del empleado.
                                    </div>
                                </div> -->

                            <!-- Nombre -->
                            <div class="mb-4 col-12 col-md-6">
                                <label for="nombre" class="form-label fw-semibold fs-5">
                                    <i class="bi bi-person-circle me-2 text-primary"></i>Nombre <span
                                        class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control shadow-sm form-control-lg" id="nombre"
                                    name="nombre" placeholder="Ej. Juan"  >
                                <div class="invalid-feedback">
                                    Por favor ingresa el nombre del empleado.
                                </div>
                            </div>

                            <!-- Apellido -->
                            <div class="mb-4 col-12 col-md-6">
                                <label for="apellido" class="form-label fw-semibold fs-5">
                                    <i class="bi bi-person-circle me-2 text-primary"></i>Apellido <span
                                        class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control shadow-sm form-control-lg" id="apellido"
                                    name="apellido" placeholder="Ej. Pérez" required>
                                <div class="invalid-feedback">
                                    Por favor ingresa el apellido del empleado.
                                </div>
                            </div>

                            <!-- Correo Electrónico -->
                            <div class="mb-4 col-12 col-md-6">
                                <label for="correo" class="form-label fw-semibold fs-5">
                                    <i class="bi bi-envelope-fill me-2 text-primary"></i>Correo Electrónico <span
                                        class="text-danger">*</span>
                                </label>
                                <input type="email" class="form-control shadow-sm form-control-lg" id="correo"
                                    name="correo" placeholder="Ej. juan.perez@correo.com" required>
                                <div class="invalid-feedback">
                                    Ingresa un correo electrónico válido.
                                </div>
                            </div>

                            <!-- Teléfono -->
                            <div class="mb-4 col-12 col-md-6">
                                <label for="telefono" class="form-label fw-semibold fs-5">
                                    <i class="bi bi-telephone-fill me-2 text-primary"></i>Teléfono <span
                                        class="text-danger">*</span>
                                </label>
                                <input type="tel" class="form-control shadow-sm form-control-lg" id="telefono"
                                    name="telefono" placeholder="Ej. 123-456-7890" required>
                                <div class="invalid-feedback">
                                    Ingresa un número de teléfono válido.
                                </div>
                            </div>

                            <!-- Dirección -->
                            <div class="mb-4 col-12 col-md-6">
                                <label for="direccion" class="form-label fw-semibold fs-5">
                                    <i class="bi bi-geo-alt-fill me-2 text-primary"></i>Dirección <span
                                        class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control shadow-sm form-control-lg" id="direccion"
                                    name="direccion" placeholder="Ej. Calle Ficticia 123" required>
                                <div class="invalid-feedback">
                                    Por favor ingresa una dirección.
                                </div>
                            </div>

                            <!-- Horario de Trabajo -->
                            <div class="mb-4 col-12 col-md-6">
                                <label for="horario_trabajo" class="form-label fw-semibold fs-5">
                                    <i class="bi bi-clock-fill me-2 text-primary"></i>Horario de Trabajo <span
                                        class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control shadow-sm form-control-lg" id="horario_trabajo"
                                    name="horario_trabajo" placeholder="Ej. 9:00 AM - 6:00 PM" required>
                                <div class="invalid-feedback">
                                    Por favor ingresa el horario de trabajo.
                                </div>
                            </div>



                            <!-- Botones -->
                            <div class="d-flex justify-content-between flex-column flex-sm-row gap-3">
                                <a href="listar_empleado.php" class="btn btn-outline-secondary w-100 fs-5 py-2">
                                    <i class="bi bi-arrow-left me-2"></i>Volver
                                </a>
                                <button type="submit" class="btn btn-primary w-100 fs-5 py-2">
                                    <i class="bi bi-person-plus-fill me-2"></i>Registrar
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
<script src="../assets/js/bootstrap.bundle.min.js"></script>
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