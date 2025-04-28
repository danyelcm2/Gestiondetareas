<?php
$host = "localhost"; // O el servidor de tu base de datos
$username = "root"; // Tu usuario de la base de datos
$password = ""; // Tu contraseña de la base de datos
$dbname = "gestion_tareas"; // El nombre de tu base de datos

// Conexión a la base de datos
$conn = new mysqli($host, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexion fallida: " . $conn->connect_error);
}
?>
