document.addEventListener("DOMContentLoaded", () => {
  const header = document.querySelector('.header');
  const sidebar = document.querySelector('.sidebar');
  const mainContent = document.querySelector('.main-content');
  const toggleBtn = document.querySelector('.toggle-btn');
  const sidebarOverlay = document.querySelector('.sidebar-overlay');
  const navLinks = document.querySelectorAll('.sidebar .nav-link');

  function toggleSidebar(open = null) {
    const shouldOpen = open !== null ? open : !sidebar.classList.contains('show');
    
    sidebar.classList.toggle('show', shouldOpen);
    sidebarOverlay.classList.toggle('active', shouldOpen);
    document.body.classList.toggle('no-scroll', shouldOpen);
  }

  // 1. Abrir/cerrar desde botón
  if (toggleBtn) {
    toggleBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      toggleSidebar();
    });
  }

  // 2. Cerrar al hacer clic fuera
  if (sidebarOverlay) {
    sidebarOverlay.addEventListener('click', () => toggleSidebar(false));
  }

  // 3. Cerrar al hacer clic en un enlace (en móviles)
  navLinks.forEach(link => {
    link.addEventListener('click', () => {
      if (window.innerWidth <= 992) toggleSidebar(false);
    });
  });

  // 4. Efecto shrink del header
  if (mainContent) {
    mainContent.addEventListener('scroll', () => {
      header.classList.toggle('shrink', mainContent.scrollTop > 50);
    });
  }

  // 5. Scroll del sidebar
  sidebar?.addEventListener('wheel', (e) => {
    sidebar.scrollTop += e.deltaY;
  }, { passive: true });

  // 6. Efecto fade top/bottom
  function updateSidebarFade() {
    const maxScroll = sidebar.scrollHeight - sidebar.clientHeight;
    const currentScroll = sidebar.scrollTop;

    sidebar.classList.toggle('show-fade-top', currentScroll > 0);
    sidebar.classList.toggle('show-fade-bottom', currentScroll < maxScroll);
  }

  sidebar?.addEventListener('scroll', updateSidebarFade);
  window.addEventListener('resize', updateSidebarFade);
  updateSidebarFade();
});
