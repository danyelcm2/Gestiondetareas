<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Departamento - Administrador</title>
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
                <h4 class="ms-auto">Crear Departamento</h4>
            </nav>

            <div class="container-fluid">
                <h1 class="mt-4">Nuevo Departamento</h1>

                <div class="row mt-4">
                    <div class="col-md-6">
                        <form action="ACCIONES/create_department_process.php" method="POST">
                            <div class="mb-3">
                                <label for="nombre_departamento" class="form-label">Nombre del Departamento</label>
                                <input type="text" class="form-control" id="nombre_departamento" name="nombre_departamento" required>
                            </div>
                            <button type="submit" class="btn btn-success">Crear Departamento</button>
                        </form>
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
