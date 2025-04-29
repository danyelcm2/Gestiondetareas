<?php
// Iniciar la sesión
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php"); // Redirigir al login si no está logueado
    exit();
}

// Incluir el archivo de conexión a la base de datos
include('../../conexion.php');

$sql = "SELECT t.id, t.descripcion, d.nombre AS departamento, p.descripcion AS prioridad, t.estado, u.nombre AS usuario_asignado
        FROM tareas t
        LEFT JOIN departamentos d ON t.id_departamento = d.id
        LEFT JOIN prioridades p ON t.id_prioridad = p.id
        LEFT JOIN usuarios u ON t.id_usuario_asignado = u.id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Tareas - Administrador</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css"> <!-- Tu archivo CSS personal -->
</head>
<body class="bg-light">

    <!-- Barra Lateral (Sidebar) -->
    <div class="d-flex" id="wrapper">
        <div class="bg-primary text-white" id="sidebar" style="width: 250px; height: 100vh;">
            <div class="sidebar-heading text-center p-4">
                <h2>Admin Dashboard</h2>
            </div>
            <div class="list-group list-group-flush">
                <a href="admin_dashboard.php" class="list-group-item list-group-item-action text-white bg-primary">Crear Usuario</a>
                <a href="create_department.php" class="list-group-item list-group-item-action text-white bg-primary">Crear Departamento</a>
                <a href="view_tasks.php" class="list-group-item list-group-item-action text-white bg-primary">Ver Tareas</a>
                <a href="settings.php" class="list-group-item list-group-item-action text-white bg-primary">Ajustes</a>
                <a href="logout.php" class="list-group-item list-group-item-action text-white bg-primary">Cerrar Sesión</a>
            </div>
        </div>

        <!-- Área de Contenido Principal -->
        <div id="page-content-wrapper" class="w-100">
            <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
                <button class="btn btn-primary" id="menu-toggle">☰ Menú</button>
                <h4 class="ms-auto">Ver Tareas</h4>
            </nav>

            <div class="container-fluid">
                <h1 class="mt-4">Tareas Solicitadas</h1>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Descripción</th>
                            <th>Departamento</th>
                            <th>Prioridad</th>
                            <th>Estado</th>
                            <th>Asignado a</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                // Aplicar color según el estado
                                $estado_class = '';
                                if ($row['estado'] == 'pendiente') {
                                    $estado_class = 'table-warning'; // Amarillo claro para "pendiente"
                                } elseif ($row['estado'] == 'completada') {
                                    $estado_class = 'table-success'; // Verde claro para "completada"
                                }

                                // Asignar valor a usuario (Si no tiene asignado, mostrar "Sin Asignar")
                                $usuario_asignado = $row['usuario_asignado'] ? $row['usuario_asignado'] : "<span class='text-danger'>Sin Asignar</span>";

                                echo "<tr class='$estado_class'>
                                        <td>" . $row['id'] . "</td>
                                        <td>" . $row['descripcion'] . "</td>
                                        <td>" . $row['departamento'] . "</td>
                                        <td>" . $row['prioridad'] . "</td>
                                        <td>" . $row['estado'] . "</td>
                                        <td>" . $usuario_asignado . "</td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6' class='text-center'>No hay tareas solicitadas.</td></tr>";
                        }

                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS & Popper -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
