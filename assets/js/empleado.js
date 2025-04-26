document.addEventListener("DOMContentLoaded", () => {
    const input = document.querySelector("#buscador-empleados");
    const contenedor = document.querySelector("#resultados-empleados");

    if (!input || !contenedor) return;

    let debounceTimeout;

    // Función para obtener los empleados del backend
    const fetchEmpleados = async (termino = "") => {
        try {
            const formData = new URLSearchParams();
            formData.append("termino", termino.trim());

            const respuesta = await fetch("../php/geteEpleados.php", {
                method: "POST",
                body: formData
            });

            if (!respuesta.ok) {
                throw new Error("Error al obtener los empleados.");
            }

            const empleados = await respuesta.json();
            renderEmpleados(empleados);
        } catch (error) {
            contenedor.innerHTML = `<tr><td colspan="6" class="error">${error.message}</td></tr>`;
        }
    };

    // Función para renderizar los empleados en la tabla
    const renderEmpleados = (empleados) => {
        if (!Array.isArray(empleados) || empleados.length === 0) {
            contenedor.innerHTML = "<tr><td colspan='6'>No se encontraron empleados.</td></tr>";
            return;
        }

        contenedor.innerHTML = empleados
            .map((empleado) => `
                <tr>
                    <td>${escapeHTML(empleado.codigo_empleado)}</td>
                    <td>${escapeHTML(empleado.nombre)}</td>
                    <td>${escapeHTML(empleado.apellido)}</td>
                    <td>${escapeHTML(empleado.correo)}</td>
                    <td>${escapeHTML(empleado.telefono)}</td> 
                    <td class="text-center">
                        <a href="editar_empleado.php?id=${escapeHTML(empleado.id_empleado)}"
                           class="btn btn-warning btn-sm me-1" title="Editar">
                            <i class="bi bi-pencil-fill"></i>
                        </a>
                    </td>
                </tr>
            `)
            .join("");
    };

    // Función para escapar caracteres especiales en el HTML
    const escapeHTML = (str) => {
        return String(str)
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    };

    // Función de debounce para retrasar las solicitudes de búsqueda
    const debounce = (func, delay) => {
        return (...args) => {
            clearTimeout(debounceTimeout);
            debounceTimeout = setTimeout(() => func(...args), delay);
        };
    };

    // Escuchar la entrada del usuario en el campo de búsqueda
    input.addEventListener("input", () => {
        const valor = input.value;
        debounce(fetchEmpleados, 500)(valor); // Llamada debounced
    });

    // Primera carga de empleados sin filtro
    fetchEmpleados();
});
