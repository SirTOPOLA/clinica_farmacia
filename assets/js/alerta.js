document.addEventListener("DOMContentLoaded", () => {
    const alerta = document.getElementById('alerta-global');
    if (alerta) {
      // Cerrar manual
      alerta.querySelector('.btn-cerrar')?.addEventListener('click', () => {
        alerta.style.opacity = 0;
        setTimeout(() => alerta.remove(), 300);
      });
  
      // Auto ocultar tras 9 segundos
      setTimeout(() => {
        alerta.style.opacity = 0;
        setTimeout(() => alerta.remove(), 300);
      }, 9000);
    }
  });
  