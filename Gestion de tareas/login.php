<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome (para los iconos) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- Google reCAPTCHA -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <style>
        body {
            background: linear-gradient(45deg, #6e7bff, #9c5fd4);
            font-family: Arial, sans-serif;
        }

        .card {
            background: rgba(255, 255, 255, 0.85);
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            text-align: center;
        }

        .card-header {
            background: none;
            border: none;
            display: flex;
            justify-content: center;
        }

        .form-control {
            border-radius: 10px;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }

        .form-check-label {
            font-size: 14px;
        }

        /* Para los dispositivos móviles */
        @media (max-width: 576px) {
            .card {
                width: 90%;
            }
        }

        /* Icono de usuario */
        .avatar {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            margin-bottom: 20px;
            object-fit: cover;
        }
    </style>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4" style="width: 25rem;">
            <!-- Imagen de usuario centrada -->
            <div class="card-header">
                <img src="IMG/login.png" alt="User Avatar" class="avatar">
            </div>

            <div class="card-body">
                <h2 class="mb-4">User Login</h2>

                <!-- Alerta de error de login usando Bootstrap 5 -->
                <?php if (isset($_GET['error']) && $_GET['error'] == '1'): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> La contraseña es incorrecta. Por favor, intente nuevamente.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <!-- Formulario de login -->
                <form action="PHP/login_process.php" method="POST">
    <!-- Campo de Email con icono -->
    <div class="mb-3">
      
        <div class="input-group">
            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
            <input type="email" class="form-control" id="email" name="email" placeholder="Escribe tu correo" required>
        </div>
    </div>

    <!-- Campo de Contraseña con icono -->
    <div class="mb-3">
       
        <div class="input-group">
            <span class="input-group-text"><i class="fas fa-lock"></i></span>
            <input type="password" class="form-control" id="password" name="password" placeholder="Escribe tu contraseña" required>
        </div>
    </div>

    <!-- reCAPTCHA -->
    <div class="mb-3">
        <div class="g-recaptcha" data-sitekey="6Le28iYrAAAAANh6segV7SDXpZ1h77-0hvU_uXOr"></div> <!-- Asegúrate de usar tu clave del sitio -->
    </div>

    <!-- Recordarme -->
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="rememberMe">
        <label class="form-check-label" for="rememberMe">Recordarme</label>
    </div>

    <button type="submit" class="btn btn-success w-100">Login</button>
</form>

            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS & Popper -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
