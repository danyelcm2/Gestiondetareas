<?php
session_start();
include('../../../conexion.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener datos del formulario
    $descripcion = $conn->real_escape_string($_POST['descripcion']);
    $prioridad = intval($_POST['prioridad']);
    $departamento_id = $_SESSION['usuario_departamento']; // Obtenido del login

    // Insertar tarea
    $sql = "INSERT INTO tareas (descripcion, id_departamento, id_prioridad, estado) 
            VALUES ('$descripcion', $departamento_id, $prioridad, 'pendiente')";

    if ($conn->query($sql)) {
        header("Location: ../user_dashboard.php?success=1");
    } else {
        header("Location: ../user_dashboard.php?error=1");
    }
    exit();
} 
?>