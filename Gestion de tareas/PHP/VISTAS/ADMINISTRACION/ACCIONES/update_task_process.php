<?php
include('../../../conexion.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id_tarea'];
    $descripcion = $_POST['descripcion'];
    $departamento = $_POST['id_departamento'];
    $prioridad = $_POST['id_prioridad'];
    $estado = $_POST['estado'];

    $sql = "UPDATE tareas SET
            descripcion = ?,
            id_departamento = ?,
            id_prioridad = ?,
            estado = ?
            WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siisi", $descripcion, $departamento, $prioridad, $estado, $id);
    
    if ($stmt->execute()) {
        header("Location: ../admin_dashboard.php?success=1");
    } else {
        header("Location: ../admin_dashboard.php?error=1");
    }
    $stmt->close();
    $conn->close();
}
?>