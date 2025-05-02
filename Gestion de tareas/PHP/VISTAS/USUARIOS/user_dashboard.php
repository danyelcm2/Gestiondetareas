<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/StyleAdmin.css">
</head>
<body class="bg-light">
    <?php
    session_start();
    if (!isset($_SESSION['usuario_id']) ) {
        header("Location: ../../../login.php");
       exit();
        
    }
    include('../../conexion.php');
    
    // Determinar qué sección mostrar
    $section = isset($_GET['section']) ? $_GET['section'] : 'solicitar';
    ?>

    <div class="d-flex" id="wrapper">
        <!-- Barra Lateral Actualizada -->
        <div class="bg-primary text-white" id="sidebar" style="width: 250px; height: 100vh;">
            <div class="sidebar-heading text-center p-4">
                <h2>Usuario Dashboard</h2>
            </div>
            <div class="list-group list-group-flush">
                <a href="?section=solicitar" class="list-group-item list-group-item-action text-white bg-primary <?php echo ($section === 'solicitar') ? 'active' : ''; ?>">Solicitar Tarea</a>
                <a href="?section=completadas" class="list-group-item list-group-item-action text-white bg-primary <?php echo ($section === 'completadas') ? 'active' : ''; ?>">Tareas Completadas</a>
                <a href="../../../login.php" class="list-group-item list-group-item-action text-white bg-primary">Cerrar Sesión</a>
            </div>
        </div>

        <!-- Contenido Principal -->
        <div id="page-content-wrapper" class="w-100">
            <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
                <button class="btn btn-primary" id="menu-toggle">☰ Menú</button>
                <h4 class="ms-auto">Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?></h4>
            </nav>

            <div class="container-fluid">
                <?php if ($section === 'solicitar'): ?>
                    <!-- Sección de Solicitud de Tareas -->
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <h1 class="mt-4">Solicitar Nueva Tarea</h1>
                            <form action="ACCIONES/solicitar_tarea_process.php" method="POST">
                                <div class="mb-3">
                                    <label for="descripcion" class="form-label">Descripción del Problema</label>
                                    <textarea class="form-control" id="descripcion" name="descripcion" rows="4" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="prioridad" class="form-label">Prioridad</label>
                                    <select class="form-control" id="prioridad" name="prioridad" required>
                                        <option value="">Selecciona una Prioridad</option>
                                        <?php
                                        $sql_prioridades = "SELECT * FROM prioridades";
                                        $result_prioridades = $conn->query($sql_prioridades);
                                        while ($row_prioridad = $result_prioridades->fetch_assoc()) {
                                            echo "<option value='".$row_prioridad['id']."'>".$row_prioridad['descripcion']."</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-success">Enviar Solicitud</button>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <h3>Mis Solicitudes Recientes</h3>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Descripción</th>
                                        <th>Prioridad</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $usuario_id = $_SESSION['usuario_id'];
                                    $sql_tareas = "SELECT t.id, t.descripcion, p.descripcion AS prioridad, t.estado 
                                                   FROM tareas t
                                                   JOIN prioridades p ON t.id_prioridad = p.id
                                                   WHERE t.id_departamento = (SELECT codigo_departamento FROM usuarios WHERE id = $usuario_id)
                                                   ORDER BY t.fecha_solicitud DESC LIMIT 5";
                                    $result_tareas = $conn->query($sql_tareas);
                                    
                                    function getBadgeColor($estado) {
                                        switch ($estado) {
                                            case 'pendiente': return 'warning';
                                            case 'en progreso': return 'primary';
                                            case 'completada': return 'success';
                                            default: return 'secondary';
                                        }
                                    }

                                    if ($result_tareas->num_rows > 0) {
                                        while ($row_tarea = $result_tareas->fetch_assoc()) {
                                            echo "<tr>
                                                    <td>".$row_tarea['id']."</td>
                                                    <td>".htmlspecialchars($row_tarea['descripcion'])."</td>
                                                    <td>".$row_tarea['prioridad']."</td>
                                                    <td><span class='badge bg-".getBadgeColor($row_tarea['estado'])."'>".ucfirst($row_tarea['estado'])."</span></td>
                                                  </tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='4' class='text-center'>No hay solicitudes recientes</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                <?php elseif ($section === 'completadas'): ?>
                    <!-- Sección de Tareas Completadas -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h1 class="mt-4">Tareas Completadas</h1>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Descripción</th>
                                        <th>Prioridad</th>
                                        <th>Fecha Completada</th>
                                        <th>Técnico Asignado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT t.id, t.descripcion, p.descripcion AS prioridad, 
                                                   t.fecha_resolucion, u.nombre AS tecnico
                                            FROM tareas t
                                            JOIN prioridades p ON t.id_prioridad = p.id
                                            LEFT JOIN usuarios u ON t.id_usuario_asignado = u.id
                                            WHERE t.estado = 'completada' 
                                            AND t.id_departamento = (SELECT codigo_departamento 
                                                                    FROM usuarios 
                                                                    WHERE id = ?)";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->bind_param("i", $_SESSION['usuario_id']);
                                    $stmt->execute();
                                    $result = $stmt->get_result();

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>
                                                    <td>".$row['id']."</td>
                                                    <td>".htmlspecialchars($row['descripcion'])."</td>
                                                    <td>".$row['prioridad']."</td>
                                                    <td>".date('d/m/Y H:i', strtotime($row['fecha_resolucion']))."</td>
                                                    <td>".(isset($row['tecnico']) ? $row['tecnico'] : 'Sin asignar')."</td>
                                                  </tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='5' class='text-center'>No hay tareas completadas.</td></tr>";
                                    }
                                    $stmt->close();
                                    $conn->close();
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS & Popper -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>

    <script>
        // Toggle del menú lateral
        document.getElementById('menu-toggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('d-none');
        });
    </script>
</body>
</html>