<?php
// Iniciar la sesión
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../../login.php"); // Redirigir al login si no está logueado
    exit();
}

// Incluir el archivo de conexión a la base de datos
include('../../conexion.php');

// Variables para los filtros
$prioridad_filter = isset($_GET['prioridad']) ? $_GET['prioridad'] : '';
$departamento_filter = isset($_GET['departamento']) ? $_GET['departamento'] : '';

// Construir la consulta para mostrar solo tareas completadas
$sql = "SELECT t.id, t.descripcion, d.nombre AS departamento, p.descripcion AS prioridad, t.estado, u.nombre AS usuario_asignado
        FROM tareas t
        LEFT JOIN departamentos d ON t.id_departamento = d.id
        LEFT JOIN prioridades p ON t.id_prioridad = p.id
        LEFT JOIN usuarios u ON t.id_usuario_asignado = u.id
        WHERE t.estado = 'completada'"; // Mostrar solo tareas completadas

if ($prioridad_filter) {
    $sql .= " AND t.id_prioridad = $prioridad_filter"; // Filtro de prioridad
}

if ($departamento_filter) {
    $sql .= " AND t.id_departamento = $departamento_filter"; // Filtro de departamento
}

$result = $conn->query($sql);

// Obtener los departamentos para el filtro
$departamentos_sql = "SELECT * FROM departamentos";
$departamentos_result = $conn->query($departamentos_sql);

// Obtener las prioridades para el filtro
$prioridades_sql = "SELECT * FROM prioridades";
$prioridades_result = $conn->query($prioridades_sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tareas Completadas - Informática</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome para iconos -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }
        .navbar {
            background-color: #6c757d;
            color: white;
        }
        .navbar-brand {
            color: white !important;
        }
        .table th, .table td {
            text-align: center;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-success {
            background-color: #28a745;
            border: none;
        }
        .btn-success:hover {
            background-color: #218838;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .no-assign {
            color: red;
        }
        .table-responsive {
            margin-top: 20px;
        }

        /* Fila completada - color verde claro */
        .estado-completada {
            background-color: #d4edda;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <!-- Barra Lateral (Sidebar) -->
        <div class="row">
            <div class="col-md-2 bg-light">
                <div class="sidebar-heading text-center p-4">
                    <h2>Dashboard Informática</h2>
                </div>
                <div class="list-group list-group-flush">
                    <a href="informatica_dashboard.php" class="list-group-item list-group-item-action">Tareas Solicitadas</a>
                    <a href="tareas_completadas.php" class="list-group-item list-group-item-action">Tareas Completadas</a> <!-- Agregado -->
                    <a href="../../../login.php" class="list-group-item list-group-item-action">Cerrar Sesión</a>
                </div>
            </div>

            <!-- Área de Contenido Principal -->
            <div class="col-md-10">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="navbar-brand" href="#">Gestión de Tareas</a>
                </nav>

                <!-- Título y Filtros -->
                <div class="container mt-5">
                    <h2>Tareas Completadas</h2>

                    <!-- Filtros de Prioridad y Departamento -->
                    <form method="GET" class="mb-4">
                        <div class="row">
                            <!-- Filtro de Prioridad -->
                            <div class="col-md-4">
                                <label for="prioridad" class="form-label">Filtrar por Prioridad</label>
                                <select class="form-select" id="prioridad" name="prioridad">
                                    <option value="">Todas</option>
                                    <?php while ($row = $prioridades_result->fetch_assoc()) { ?>
                                        <option value="<?php echo $row['id']; ?>" <?php if ($row['id'] == $prioridad_filter) echo 'selected'; ?>>
                                            <?php echo $row['descripcion']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <!-- Filtro de Departamento -->
                            <div class="col-md-4">
                                <label for="departamento" class="form-label">Filtrar por Departamento</label>
                                <select class="form-select" id="departamento" name="departamento">
                                    <option value="">Todos</option>
                                    <?php while ($row = $departamentos_result->fetch_assoc()) { ?>
                                        <option value="<?php echo $row['id']; ?>" <?php if ($row['id'] == $departamento_filter) echo 'selected'; ?>>
                                            <?php echo $row['nombre']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <!-- Botón de Filtrar -->
                            <div class="col-md-4 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-100">Filtrar</button>
                            </div>
                        </div>
                    </form>

                    <!-- Tabla de tareas completadas -->
                    <div class="table-responsive">
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
                                        echo "<tr class='estado-completada'>
                                            <td>" . $row['id'] . "</td>
                                            <td>" . $row['descripcion'] . "</td>
                                            <td>" . $row['departamento'] . "</td>
                                            <td>" . $row['prioridad'] . "</td>
                                            <td>" . $row['estado'] . "</td>
                                            <td>" . ($row['usuario_asignado'] ? $row['usuario_asignado'] : "<span class='no-assign'>Sin Asignar</span>") . "</td>
                                        </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='6' class='text-center'>No hay tareas completadas.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS & Popper -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Cerrar la conexión
$conn->close();
?>
