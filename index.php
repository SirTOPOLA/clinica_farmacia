<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login – FarmaSalud</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
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
            animation: fadeIn 1s forwards;
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
            border-radius: 50px;
            padding: 12px 25px;
            font-size: 16px;
            border: none;
            transition: 0.3s;
        }

        .btn-login:hover {
            background-color: #157347;
        }

        .input-group-text {
            background-color: #f0f9ff;
        }

        .input-group .form-control {
            border-radius: 50px;
        }

        .form-label {
            font-weight: bold;
            color: #4e4e4e;
        }

        #msg {
            font-size: 0.875rem;
            color: red;
            text-align: center;
        }

        /* Animación de fade-in */
        @keyframes fadeIn {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
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

<body>
    <!-- Pantalla de precarga con logo -->
    <div id="loader">
        <img src="img/logo.png" alt="Logo FarmaSalud" class="preloader-logo">
    </div>

    <!-- Formulario de login -->
    <div class="card-login shadow-lg p-4 border-0">
        <div class="logo-circle">
            <img src="https://cdn-icons-png.flaticon.com/512/2936/2936958.png" alt="Logo FarmaSalud" />
        </div>
        <h4 class="text-center mt-4 mb-3">Panel Médico – FarmaSalud</h4>

        <form id="loginForm" action="php/login.php" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Correo Electrónico</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person input-icon text-primary"></i></span>
                    <input type="email" id="username" class="form-control" name="correo" required />
                </div>
                <div class="invalid-feedback">Correo electrónico requerido</div>
                <div class="valid-feedback">✓ Correo válido</div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-shield-lock input-icon text-primary"></i></span>
                    <input type="password" id="password" class="form-control" name="contrasena" required />
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

    <script>
        // Cuando la ventana se carga, ocultar el loader y mostrar el formulario
        window.addEventListener("load", () => {
            const loader = document.getElementById("loader"); // Loader
            const loginCard = document.querySelector(".card-login"); // Formulario de login

            setTimeout(() => {
                loader.style.display = "none";  // Ocultar el loader
                loginCard.style.opacity = "1";  // Mostrar el formulario
            }, 500);  // Retrasar por 500 ms
        });
    </script>
</body>

</html>

