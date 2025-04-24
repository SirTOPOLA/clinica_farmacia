<?php
include_once("../includes/header.php");
?>
<!-- Main Content -->
<div class="main-content">

    <!-- Sección de Empleados -->
    <div id="empleados" class="card p-4 mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0"><i class="bi bi-people-fill me-2"></i>Lista de Empleados</h4>
            <a href="#registroEmpleado" class="btn btn-success">
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
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Ejemplo de datos estáticos -->
                <tr>
                    <td>1</td>
                    <td>EMP001</td>
                    <td>Juan</td>
                    <td>Pérez</td>
                    <td>juan.perez@clinica.com</td>
                    <td>555-123456</td>
                    <td>
                        <button class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></button>
                        <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>EMP002</td>
                    <td>Ana</td>
                    <td>Gómez</td>
                    <td>ana.gomez@clinica.com</td>
                    <td>555-654321</td>
                    <td>
                        <button class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></button>
                        <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>