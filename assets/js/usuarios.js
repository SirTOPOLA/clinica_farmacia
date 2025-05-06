document.addEventListener('DOMContentLoaded', () => {
    const tablaBody = document.getElementById('tabla-body');
    const paginacion = document.getElementById('paginacion');
    const filtroInput = document.getElementById('buscar');

    let paginaActual = 1;
    let terminoBusqueda = '';

    // Función para cargar los usuarios
    function cargarUsuarios(page = 1, search = '') {
        terminoBusqueda = search;

        // Realizar la solicitud Fetch para obtener los usuarios
        fetch(`../php/get_usuarios.php?page=${page}&search=${encodeURIComponent(search)}`)
            .then(response => response.json())
            .then(data => {
                tablaBody.innerHTML = '';

                // Si hay usuarios, los mostramos
                if (data.data.length > 0) {
                    data.data.forEach(usuario => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td data-label='🆔 ID'>${usuario.id_usuario}</td>
                            <td data-label='🔑 Código Empleado'>${usuario.codigo_empleado}</td>
                            <td data-label='📧 Correo'>${usuario.correo}</td>
                            <td data-label='🛠 Rol'>${usuario.nombre_rol}</td>
                            <td data-label='🔒 Activo'>
                                <button class="btn btn-${usuario.activo ? 'success' : 'danger'} btn-sm toggle-status" data-id="${usuario.id_usuario}" data-status="${usuario.activo}">
                                    ${usuario.activo ? 'Activo' : 'Inactivo'}
                                </button>
                            </td>
                            <td data-label='⚙️ Acciones'>
                                <a href='editar_usuario.php?id=${usuario.id_usuario}' class='btn btn-success btn-sm rounded'>
                                    <i class="bi bi-pencil-circle"></i> Editar
                                </a>
                            </td>
                        `;
                        tablaBody.appendChild(tr);
                    });

                    // Agregar el evento a los botones de activar/desactivar
                    const botonesToggle = document.querySelectorAll('.toggle-status');
                    botonesToggle.forEach(btn => {
                        btn.addEventListener('click', () => {
                            const idUsuario = btn.getAttribute('data-id');
                            const estadoActual = btn.getAttribute('data-status') === 'true';

                            // Cambiar el estado del usuario (activo/inactivo)
                            cambiarEstadoUsuario(idUsuario, estadoActual, btn);
                        });
                    });
                } else {
                    tablaBody.innerHTML = '<tr><td colspan="6" class="text-center">No se encontraron resultados.</td></tr>';
                }

                // Crear la paginación
                crearPaginacion(data.total, data.per_page, data.page, search);
            })
            .catch(error => {
                console.error('Error al cargar usuarios:', error);
            });
    }

    // Función para cambiar el estado de un usuario (activo/inactivo)
    function cambiarEstadoUsuario(id, estadoActual, boton) {
        // Realizar la solicitud Fetch para cambiar el estado
        fetch(`../php/activar_usuario.php?id=${id}&activo=${!estadoActual}`, {
            method: 'GET',
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Cambiar el estado del usuario en la interfaz
                    const nuevoEstado = !estadoActual;
                    // Cambiar el texto y el color del botón
                    boton.textContent = nuevoEstado ? 'Activo' : 'Inactivo';
                    boton.classList.remove(nuevoEstado ? 'btn-danger' : 'btn-success');
                    boton.classList.add(nuevoEstado ? 'btn-success' : 'btn-danger');
                    boton.setAttribute('data-status', nuevoEstado); // Actualizamos el atributo 'data-status'
                } else {
                    alert('Error al cambiar el estado del usuario.');
                }
            })
            .catch(error => {
                console.error('Error al cambiar el estado del usuario:', error);
            });
    }

    // Función para crear la paginación
    function crearPaginacion(total, perPage, currentPage, search) {
        paginacion.innerHTML = '';
        const totalPages = Math.ceil(total / perPage);

        // Botón "Anterior"
        const btnAnterior = document.createElement('button');
        btnAnterior.textContent = 'Anterior';
        btnAnterior.className = `btn ${currentPage === 1 ? 'btn-secondary' : 'btn-outline-primary'} btn-sm mx-1`;
        btnAnterior.disabled = currentPage === 1;
        btnAnterior.onclick = () => {
            if (currentPage > 1) {
                cargarUsuarios(currentPage - 1, search);
            }
        };
        paginacion.appendChild(btnAnterior);

        // Páginas numéricas
        for (let i = 1; i <= totalPages; i++) {
            const btn = document.createElement('button');
            btn.textContent = i;
            btn.className = `btn ${i === currentPage ? 'btn-primary' : 'btn-outline-primary'} btn-sm mx-1`;
            btn.onclick = () => {
                cargarUsuarios(i, search);
            };
            paginacion.appendChild(btn);
        }

        // Botón "Siguiente"
        const btnSiguiente = document.createElement('button');
        btnSiguiente.textContent = 'Siguiente';
        btnSiguiente.className = `btn ${currentPage === totalPages ? 'btn-secondary' : 'btn-outline-primary'} btn-sm mx-1`;
        btnSiguiente.disabled = currentPage === totalPages;
        btnSiguiente.onclick = () => {
            if (currentPage < totalPages) {
                cargarUsuarios(currentPage + 1, search);
            }
        };
        paginacion.appendChild(btnSiguiente);
    }

    // Filtrado en tiempo real
    filtroInput.addEventListener('input', () => {
        paginaActual = 1;  // Resetear la paginación al primer página al buscar
        cargarUsuarios(paginaActual, filtroInput.value);
    });

    // Primera carga de usuarios
    cargarUsuarios(); 
});
