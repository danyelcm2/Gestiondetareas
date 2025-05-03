<?php
include('../../../conexion.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $sql = "DELETE FROM tareas WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        header("Location: ../admin_dashboard.php?success=2");
    } else {
        header("Location: ../admin_dashboard.php?error=2");
    }
    $stmt->close();
    $conn->close();
}
?>