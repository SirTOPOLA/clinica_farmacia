function cargarPacientes() {
  fetch(`../php/fetch_paciente.php?pagina=${paginaActual}&items_por_pagina=${itemsPorPagina}`)
    .then(response => response.json())
    .then(data => {
      // Cargar pacientes en la tabla
      const pacientesBody = document.getElementById('tabla-pacientes-body');
      pacientesBody.innerHTML = ''; // Limpiar tabla antes de actualizar
      data.pacientes.forEach(paciente => {
        const row = `
          <tr>
            <td>${paciente.codigo}</td>
            <td>${paciente.nombre} ${paciente.apellido}</td>
            <td>${paciente.fecha_nacimiento}</td>
            <td>${paciente.genero}</td>
            <td>${paciente.telefono}</td>
            <td>${paciente.correo}</td>
            <td>${paciente.direccion}</td>
            <td>${paciente.fecha_registro}</td>
            <td>
              <div class="btn-group">
                <button class="btn btn-warning btn-sm rounded-3 shadow-sm" onclick="window.location.href='editar_paciente.php?id=${paciente.id_paciente}'">
                  <span class="material-icons">edit</span> Editar
                </button>
              </div>
            </td>
          </tr>
        `;
        pacientesBody.innerHTML += row;
      });

      // Paginación
      const totalPaginas = Math.ceil(data.total_pacientes / itemsPorPagina);
      const paginacion = document.getElementById('paginacion');
      paginacion.innerHTML = ''; // Limpiar paginación antes de actualizar

      // Enlaces de paginación
      if (paginaActual > 1) {
        paginacion.innerHTML += `<a href="#" onclick="cambiarPagina(${paginaActual - 1})" class="btn btn-outline-primary">Anterior</a>`;
      }
      for (let i = 1; i <= totalPaginas; i++) {
        paginacion.innerHTML += `<a href="#" onclick="cambiarPagina(${i})" class="btn btn-outline-primary mx-1">${i}</a>`;
      }
      if (paginaActual < totalPaginas) {
        paginacion.innerHTML += `<a href="#" onclick="cambiarPagina(${paginaActual + 1})" class="btn btn-outline-primary">Siguiente</a>`;
      }
    });
}
