<?php
// Iniciar la sesión
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php"); // Redirigir al login si no está logueado
    exit();
}

// Incluir el archivo de conexión
include('../../../conexion.php');

// Obtener los datos del formulario
$id_tarea = $_POST['id_tarea'];
$id_usuario = $_POST['usuario'];  // ID del usuario asignado

// Actualizar el estado de la tarea y asignar el usuario
$sql = "UPDATE tareas SET id_usuario_asignado = $id_usuario, estado = 'En Progreso' WHERE id = $id_tarea";

// Verificar si la consulta fue exitosa
if ($conn->query($sql) === TRUE) {
    // Redirigir al dashboard de Informática con éxito
    header("Location: ../informatica_dashboard.php?success=1");
} else {
    // Si hay un error, redirigir de nuevo con error
    header("Location: ../informatica_dashboard.php?error=1");
}

$conn->close();
?>
