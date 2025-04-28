<?php
// Incluir la conexión a la base de datos
include('../../../conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $password = $_POST['password'];
    $codigo_departamento = $_POST['codigo_departamento'];
    $role = $_POST['role']; // 'usuario', 'administrador', 'informatico'

    // Cifrar la contraseña
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Insertar el nuevo usuario en la base de datos
    $sql = "INSERT INTO usuarios (nombre, correo, contraseña, codigo_departamento, role) 
            VALUES ('$nombre', '$correo', '$password_hash', '$codigo_departamento', '$role')";

    if ($conn->query($sql) === TRUE) {
        echo "Usuario registrado correctamente.";
        header("Location: ../admin_dashboard.php"); // Redirige al Dashboard
    } else {
        echo "Error al registrar el usuario: " . $conn->error;
    }

    $conn->close();
}
?>
