document.addEventListener("DOMContentLoaded", () => {
    const header = document.querySelector('.header');
    const sidebar = document.querySelector('.sidebar'); 
    const mainContent = document.querySelector('.main-content');
    const toggleBtn = document.querySelector('.toggle-btn');
  
    /* ==========================================
       1. TOGGLE DEL SIDEBAR EN DISPOSITIVOS PEQUEÑOS
       ========================================== */
    if (toggleBtn) {
      toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('show');
      });
    }
  
    /* ==========================================
       2. CERRAR SIDEBAR AL CLICAR UN ENLACE EN MÓVIL/TABLET
       ========================================== */
    document.querySelectorAll('.sidebar .nav-link').forEach(link => {
      link.addEventListener('click', () => {
        if (window.innerWidth <= 992) {
          sidebar.classList.remove('show');
        }
      });
    });
  
    /* ==========================================
       3. EFECTO ENCÓGER HEADER AL HACER SCROLL EN MAIN
       ========================================== */
    if (mainContent) {
      mainContent.addEventListener('scroll', () => {
        header.classList.toggle('shrink', mainContent.scrollTop > 50);
      });
    }
  
    /* ==========================================
       4. SCROLL NATURAL Y SUAVE EN EL SIDEBAR
       ========================================== */
    sidebar.addEventListener('wheel', (e) => {
      sidebar.scrollTop += e.deltaY;
    }, { passive: true });
  
    /* ==========================================
       5. EFECTO DEGRADADO ARRIBA/ABAJO AL HACER SCROLL EN SIDEBAR
       ========================================== */
    function updateSidebarFade() {
      const maxScroll = sidebar.scrollHeight - sidebar.clientHeight;
      const currentScroll = sidebar.scrollTop;
  
      sidebar.classList.toggle('show-fade-top', currentScroll > 0);
      sidebar.classList.toggle('show-fade-bottom', currentScroll < maxScroll);
    }
  
    sidebar.addEventListener('scroll', updateSidebarFade);
    window.addEventListener('resize', updateSidebarFade);
    updateSidebarFade(); // Inicial
  });
  