<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login – FarmaSalud</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
  <!--  <link rel="stylesheet" href="css/login.css"> -->
    <style>
         
body {
    background: linear-gradient(to bottom right, #e6f7ff, #f4ffff);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
}

.card-login {
    position: relative;
    max-width: 420px;
    width: 100%;
    border: none;
    border-radius: 1.5rem;
    padding: 3rem 2rem 2rem;
    box-shadow: 0 5px 20px rgba(0, 100, 150, 0.1);
    opacity: 0;
}

.logo-circle {
    position: absolute;
    top: -50px;
    left: 50%;
    transform: translateX(-50%);
    width: 100px;
    height: 100px;
    border-radius: 50%;
    overflow: hidden;
    border: 4px solid white;
    background: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.logo-circle img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.btn-login {
    background-color: #198754;
    color: #fff;
    transition: 0.3s;
}

.btn-login:hover {
    background-color: #157347;
}

/* Preloader */
#loader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.8);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1050;
}

.preloader-logo {
    width: 100px;
    height: 100px;
    object-fit: contain;
    animation: spin 1.2s linear infinite;
}

@keyframes spin {
    0% {
        transform: rotate(0deg);
    }

    100% {
        transform: rotate(360deg);
    }
}

 
    </style>
</head>

<body class="bg-light">
    <!-- Pantalla de precarga con logo -->
    <div id="loader">
        <img src="img/logo.png" alt="Logo FarmaSalud" class="preloader-logo">
    </div>

    <!-- mejorar colums 2 -->


    <!-- Formulario de login -->
    <div class="login-card card shadow-lg p-4 border-0" id="loginCard">
        <div class="logo-circle">
            <img src="https://cdn-icons-png.flaticon.com/512/2936/2936958.png" alt="Logo Clínica" />
        </div>
        <h4 class="text-center mt-4 mb-3">Panel Médico – FarmaSalud</h4>

        <form id="loginForm" novalidate>
            <div class="mb-3">
                <label for="username" class="form-label">Usuario</label>
                <div class="input-group has-validation">
                    <span class="input-group-text"><i class="bi bi-person input-icon text-primary"></i></span>
                    <input type="email" id="username" class="form-control" required />
                    <span class="input-group-text bg-white border-start-0">
                        <i id="icon-username" class="bi"></i>
                    </span>
                </div>
                <div class="invalid-feedback">Usuario requerido</div>
                <div class="valid-feedback">✓ Usuario válido</div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <div class="input-group has-validation">
                    <span class="input-group-text"><i class="bi bi-shield-lock input-icon text-primary"></i></span>
                    <input type="password" id="password" class="form-control" required />
                    <span class="input-group-text bg-white border-start-0">
                        <i id="icon-password" class="bi"></i>
                    </span>
                </div>
                <div class="invalid-feedback">Contraseña requerida</div>
                <div class="valid-feedback">✓ Contraseña válida</div>
            </div>

            <div id="msg" class="text-danger small mb-3 text-center"></div>

            <div class="d-grid">
                <button type="submit" class="btn btn-login">Iniciar sesión</button>
            </div>
        </form>
    </div>

    <script >
        // Cuando la ventana se carga, ocultar el loader y mostrar el formulario
window.addEventListener("load", () => {
  const loader = document.getElementById("loader"); // Loader
  const loginCard = document.getElementById("loginCard"); // Formulario de login

  setTimeout(() => {
      loader.style.display = "none";  // Ocultar el loader
      loginCard.style.opacity = "1";  // Mostrar el formulario
  }, 500);  // Retrasar por 500 ms
});

// Obtener los elementos del formulario y los iconos
const form = document.getElementById('loginForm');
//const email = document.getElementById('email');
const email = document.getElementById('username');
const password = document.getElementById('password');
const iconU = document.getElementById('icon-username');
const iconP = document.getElementById('icon-password');
const iconE = document.getElementById('icon-email');
const msg = document.getElementById('msg');

// Función para validar campos del formulario y actualizar los iconos
function validateField(input, icon, validationFn) {
  if (validationFn(input.value.trim())) {
      input.classList.add("is-valid");
      input.classList.remove("is-invalid");
      //icon.className = "bi bi-check-circle-fill text-success"; // Ícono de éxito
  } else {
      input.classList.add("is-invalid");
      input.classList.remove("is-valid");
      //icon.className = "bi bi-x-circle-fill text-danger"; // Ícono de error
  }
}

// Función de validación personalizada para email
function validateEmail(value) {
  const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
  return emailPattern.test(value);
}

// Función de validación personalizada para la contraseña
function validatePassword(value) {
  return value.length >= 6;  // Al menos 6 caracteres
}

// Validación al escribir en el campo de email, usuario y contraseña
email.addEventListener("input", () => validateField(email, iconE, validateEmail));
//username.addEventListener("input", () => validateField(username, iconU, (value) => value.trim() !== ""));
password.addEventListener("input", () => validateField(password, iconP, validatePassword));

// Evento para enviar el formulario
form.addEventListener("submit", async (e) => {
  e.preventDefault(); // Evitar el envío del formulario por defecto

  // Validar los campos
  validateField(email, iconE, validateEmail);
  //validateField(username, iconU, (value) => value.trim() !== "");
  validateField(password, iconP, validatePassword);

  // Obtener los valores de los campos
  //const user = username.value.trim();
  const pass = password.value.trim();
  const userEmail = email.value.trim();

  // Verificar si todos los campos son válidos antes de enviar
  if (!userEmail  || !pass) {
      msg.textContent = "Todos los campos son obligatorios.";
      return;
  }

  if (!validateEmail(userEmail)) {
      msg.textContent = "Por favor ingrese un correo electrónico válido.";
      return;
  }

  if (!validatePassword(pass)) {
      msg.textContent = "La contraseña debe tener al menos 6 caracteres.";
      return;
  }

  try {
      // Enviar los datos al servidor para validación
      const res = await fetch("./backend/php/login.php", {
          method: "POST",
          body: new URLSearchParams({  password: pass, email: userEmail }),
      });
      const data = await res.json();

      if (data.success) {
          window.location.href = "./backend/components/key.php?page=index.html"; // Redirigir si el login es exitoso
      } else {
          msg.textContent = "Credenciales incorrectas."; // Mostrar error si las credenciales son incorrectas
          password.classList.add("is-invalid");
          iconP.className = "bi bi-x-circle-fill text-danger";
      }
  } catch (error) {
      msg.textContent = "Error al conectar con el servidor."; // Error al conectar con el servidor
      console.error(error);
  }
});



    </script>
</body>

</html>
