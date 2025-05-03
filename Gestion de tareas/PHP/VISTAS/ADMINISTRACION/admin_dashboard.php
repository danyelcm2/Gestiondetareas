<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Administrador</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/StyleAdmin.css"> <!-- Tu archivo CSS personal -->
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
                <a href="../../../login.php" class="list-group-item list-group-item-action text-white bg-primary">Cerrar Sesión</a>
            </div>
        </div>

        <!-- Área de Contenido Principal -->
        <div id="page-content-wrapper" class="w-100">
            <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
                <button class="btn btn-primary" id="menu-toggle">☰ Menú</button>
                <h4 class="ms-auto">Bienvenido, Administrador</h4>
            </nav>

            <div class="container-fluid">
                <h1 class="mt-4">Crear Nuevo Usuario</h1>

                <div class="row mt-4">
                    <div class="col-md-6">
                        <form action="ACCIONES/create_user_process.php" method="POST">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="mb-3">
                                <label for="correo" class="form-label">Correo</label>
                                <input type="email" class="form-control" id="correo" name="correo" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="mb-3">
                                <label for="codigo_departamento" class="form-label">Departamento</label>
                                <select class="form-control" id="codigo_departamento" name="codigo_departamento" required>
                                    <option value="">Selecciona un Departamento</option>
                                    <?php
                                    // Conexión a la base de datos
                                    include('../../conexion.php');

                                    // Consulta para obtener los departamentos
                                    $sql = "SELECT * FROM departamentos";
                                    $result = $conn->query($sql);

                                    // Mostrar los departamentos en el select
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value='" . $row['id'] . "'>" . $row['nombre'] . "</option>";
                                        }
                                    } else {
                                        echo "<option>No hay departamentos disponibles</option>";
                                    }

                                    $conn->close();
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="role" class="form-label">Rol</label>
                                <select class="form-control" id="role" name="role" required>
                                    <option value="usuario">Usuario</option>
                                    <option value="administrador">Administrador</option>
                                    <option value="informatico">Informático</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success">Crear Usuario</button>
                        </form>
                    </div>

                    <!-- Vista de Tareas Solicitadas -->
                    <div class="col-md-6">
                <h3>Tareas Solicitadas</h3>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Descripción</th>
                            <th>Departamento</th>
                            <th>Prioridad</th>
                            <th>Estado</th>
                            <th>Acciones</th> <!-- Nueva columna para botones -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include('../../conexion.php');

                        $sql = "SELECT t.id, t.descripcion, d.nombre AS departamento, 
                                       p.descripcion AS prioridad, t.estado, 
                                       t.id_departamento, t.id_prioridad
                                FROM tareas t
                                JOIN departamentos d ON t.id_departamento = d.id
                                JOIN prioridades p ON t.id_prioridad = p.id";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td>" . $row['id'] . "</td>
                                        <td>" . $row['descripcion'] . "</td>
                                        <td>" . $row['departamento'] . "</td>
                                        <td>" . $row['prioridad'] . "</td>
                                        <td>" . $row['estado'] . "</td>
                                        <td>
                                            <button class='btn btn-warning btn-sm' 
                                                    data-bs-toggle='modal' 
                                                    data-bs-target='#editarModal'
                                                    onclick=\"cargarDatosEdicion(
                                                        " . $row['id'] . ",
                                                        '" . $row['descripcion'] . "',
                                                        " . $row['id_departamento'] . ",
                                                        " . $row['id_prioridad'] . ",
                                                        '" . $row['estado'] . "'
                                                    )\">Modificar</button>
                                            <a href='ACCIONES/delete_task.php?id=" . $row['id'] . "' 
                                               class='btn btn-danger btn-sm'
                                               onclick=\"return confirm('¿Estás seguro de eliminar esta tarea?')\">Eliminar</a>
                                        </td>
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

    <!-- Modal para Editar Tarea -->
    <div class="modal fade" id="editarModal" tabindex="-1" aria-labelledby="editarModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarModalLabel">Editar Tarea</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="ACCIONES/update_task_process.php" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="id_tarea" id="id_tarea">
                        <div class="mb-3">
                            <label for="descripcion_editar" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcion_editar" name="descripcion" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="departamento_editar" class="form-label">Departamento</label>
                            <select class="form-control" id="departamento_editar" name="id_departamento" required>
                                <?php
                                include('../../conexion.php');
                                $sql = "SELECT * FROM departamentos";
                                $result = $conn->query($sql);
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row['id'] . "'>" . $row['nombre'] . "</option>";
                                }
                                $conn->close();
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="prioridad_editar" class="form-label">Prioridad</label>
                            <select class="form-control" id="prioridad_editar" name="id_prioridad" required>
                                <option value="1">Baja</option>
                                <option value="2">Media</option>
                                <option value="3">Alta</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="estado_editar" class="form-label">Estado</label>
                            <select class="form-control" id="estado_editar" name="estado" required>
                                <option value="Pendiente">Pendiente</option>
                                <option value="En Progreso">En Progreso</option>
                                <option value="Completada">Completada</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        function cargarDatosEdicion(id, descripcion, departamento, prioridad, estado) {
            document.getElementById('id_tarea').value = id;
            document.getElementById('descripcion_editar').value = descripcion;
            document.getElementById('departamento_editar').value = departamento;
            document.getElementById('prioridad_editar').value = prioridad;
            document.getElementById('estado_editar').value = estado;
        }
    </script>
</body>
</html>