<?php
// Incluir la conexión a la base de datos
include('../../../conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el nombre del departamento
    $nombre_departamento = $_POST['nombre_departamento'];

    // Insertar el nuevo departamento en la base de datos
    $sql = "INSERT INTO departamentos (nombre) VALUES ('$nombre_departamento')";

    if ($conn->query($sql) === TRUE) {
        echo "Departamento creado correctamente.";
        header("Location: ../admin_dashboard.php"); // Redirige al Dashboard
    } else {
        echo "Error al crear el departamento: " . $conn->error;
    }

    $conn->close();
}
?>
