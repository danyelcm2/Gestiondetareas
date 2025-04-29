<?php
// Iniciar la sesión
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../../../../login.php"); // Redirigir al login si no está logueado
    exit();
}

// Incluir el archivo de conexión
include('../../../conexion.php');

// Obtener el ID de la tarea desde la URL
if (isset($_GET['id'])) {
    $id_tarea = $_GET['id'];

    // Actualizar el estado de la tarea a "Completada"
    $sql = "UPDATE tareas SET estado = 'Completada' WHERE id = $id_tarea";
    if ($conn->query($sql) === TRUE) {
        // Redirigir de nuevo al dashboard de Informática con éxito
        header("Location: ../informatica_dashboard.php?success=1");
    } else {
        // Si hay un error, redirigir de nuevo con error
        header("Location: ../informatica_dashboard.php?error=1");
    }
} else {
    // Si no se pasa un ID de tarea, redirigir a la vista de Informática
    header("Location: ../informatica_dashboard.php");
}

$conn->close();
?>
