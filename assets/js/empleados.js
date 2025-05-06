document.addEventListener('DOMContentLoaded', () => {
  const tablaBody = document.getElementById('tabla-body');
  const paginacion = document.getElementById('paginacion');
  const filtroInput = document.getElementById('buscar');

  let paginaActual = 1;
  let terminoBusqueda = '';

  function cargarEmpleados(page = 1, search = '') {
      // Guardamos el término de búsqueda para usarlo más tarde
      terminoBusqueda = search;

      fetch(`../php/get_empleados.php?page=${page}&search=${encodeURIComponent(search)}`)
          .then(response => response.json())
          .then(data => {
              tablaBody.innerHTML = '';

              // Si hay empleados, los mostramos
              if (data.data.length > 0) {
                  data.data.forEach(emp => {
                      const tr = document.createElement('tr');
                      tr.innerHTML = `
                         <td data-label='🆔 ID'>${emp.id_empleado}</td>
                         <td data-label='🔑 Código'>${emp.codigo_empleado}</td>
                         <td data-label='👤 Nombre'>${emp.nombre}</td>
                         <td data-label='👤 Apellido'>${emp.apellido}</td>
                         <td data-label='📧 Correo'>${emp.correo}</td>
                         <td data-label='📞 Teléfono'>${emp.telefono}</td>
                         <td data-label='🏠 Dirección'>${emp.direccion}</td>
                         <td data-label='⏰ Horario'>${emp.horario_trabajo}</td>
                         <td data-label='⚙️ Acciones'> 
                            <a href='editar_empleado.php?id=${emp.id_empleado}' class='btn btn-success btn-sm rounded'> <i class="bi bi-pencil-circle"></i> Editar</a>
                         </td>
                      `;
                      tablaBody.appendChild(tr);
                  });
              } else {
                  tablaBody.innerHTML = '<tr><td colspan="9" class="text-center">No se encontraron resultados.</td></tr>';
              }

              // Creamos la paginación
              crearPaginacion(data.total, data.per_page, data.page, search);
          })
          .catch(error => {
              console.error('Error al cargar empleados:', error);
          });
  }

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
              cargarEmpleados(currentPage - 1, search);
          }
      };
      paginacion.appendChild(btnAnterior);

      // Páginas numéricas
      for (let i = 1; i <= totalPages; i++) {
          const btn = document.createElement('button');
          btn.textContent = i;
          btn.className = `btn ${i === currentPage ? 'btn-primary' : 'btn-outline-primary'} btn-sm mx-1`;
          btn.onclick = () => {
              cargarEmpleados(i, search);
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
              cargarEmpleados(currentPage + 1, search);
          }
      };
      paginacion.appendChild(btnSiguiente);
  }

  // Filtrado en tiempo real
  filtroInput.addEventListener('input', () => {
      paginaActual = 1;  // Resetear la paginación al primer página al buscar
      cargarEmpleados(paginaActual, filtroInput.value);
  });

  // Primera carga
  cargarEmpleados(); 
});
