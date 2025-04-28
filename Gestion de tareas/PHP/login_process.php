<?php
// Incluir el archivo de conexión
include('conexion.php');

// Tu clave secreta de Google reCAPTCHA
$secret_key = '6Le28iYrAAAAAPciCPgLoXysl-vdhz81QmHSos6v'; // Reemplaza con tu clave secreta

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $email = $_POST['email'];
    $password = $_POST['password'];
    $recaptcha_response = $_POST['g-recaptcha-response']; // Respuesta del reCAPTCHA

    // Verificar la respuesta del reCAPTCHA
    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = [
        'secret' => $secret_key,
        'response' => $recaptcha_response
    ];

    // Iniciar cURL para enviar la solicitud de verificación
    $options = [
        'http' => [
            'method'  => 'POST',
            'content' => http_build_query($data),
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n"
        ]
    ];

    $context  = stream_context_create($options);
    $response = file_get_contents($url, false, $context);
    $result = json_decode($response);

    // Si reCAPTCHA no es válido, mostrar error
    if (!$result->success) {
        header("Location: ../login.php?error=2"); // Redirige con un error de captcha
        exit();
    }

    // Validar si el correo existe en la base de datos
    $sql = "SELECT * FROM usuarios WHERE correo = '$email' LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Verificar la contraseña
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['contraseña'])) {
            // Contraseña correcta, redirigir al usuario
            session_start();
            $_SESSION['usuario_id'] = $row['id'];
            $_SESSION['usuario_nombre'] = $row['nombre'];
            $_SESSION['usuario_departamento'] = $row['codigo_departamento']; // Guardar el departamento en la sesión

            // Redirigir según el departamento
            switch ($row['codigo_departamento']) {
                case 1: // Departamento de Finanzas
                    header("Location: finanzas_dashboard.php"); // Página específica para Finanzas
                    break;
                case 2: // Departamento de Administración
                    header("Location: VISTAS/ADMINISTRACION/admin_dashboard.php"); // Página específica para Administración
                    break;
                case 3: // Departamento de Informática
                    header("Location: informatica_dashboard.php"); // Página específica para Informática
                    break;
                default:
                    header("Location: default_dashboard.php"); // Redirige a una página predeterminada si el departamento no se encuentra
                    break;
            }
        } else {
            // Si la contraseña es incorrecta, redirige al login con error
            header("Location: ../login.php?error=1");
        }
    } else {
        // Si el correo no existe, redirige al login con error
        header("Location: ../login.php?error=1");
    }
} else {
    echo "Por favor ingresa tus datos.";
}
$conn->close();
?>
