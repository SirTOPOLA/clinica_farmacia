
  </div>
  <!-- Footer -->
  <footer class="bg-light text-center py-3 mt-auto">
    <small>&copy; <?= date('Y') ?> Clínica y Farmacia. Todos los derechos reservados.</small>
  </footer>
  </div>

<script src="">
    document.querySelectorAll('.sidebar .nav-link').forEach(link => {
  link.addEventListener('click', () => {
    if (window.innerWidth <= 768) {
      document.querySelector('.sidebar').classList.remove('show');
    }
  });
});

</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/main.js" defer></script>
</body>

</html>