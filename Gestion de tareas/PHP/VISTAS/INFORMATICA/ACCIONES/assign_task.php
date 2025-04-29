<?php
// Incluir el archivo de conexión
include('../../../conexion.php');

// Obtener el ID de la tarea desde la URL
$id_tarea = $_GET['id'];

// Obtener los datos de la tarea
$sql = "SELECT * FROM tareas WHERE id = $id_tarea LIMIT 1";
$result = $conn->query($sql);
$tarea = $result->fetch_assoc();

// Obtener los miembros del departamento de Informática (suponiendo que hay un campo `rol` para "Informático")
$sql_usuarios = "SELECT * FROM usuarios WHERE codigo_departamento = 3";
$usuarios = $conn->query($sql_usuarios);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignar Tarea</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Asignar Tarea</h2>
        
        <form action="assign_task_process.php" method="POST">
            <!-- Enviar el ID de la tarea como un campo oculto -->
            <input type="hidden" name="id_tarea" value="<?php echo $tarea['id']; ?>">
            
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción de la Tarea</label>
                <textarea class="form-control" id="descripcion" rows="3" disabled><?php echo $tarea['descripcion']; ?></textarea>
            </div>
            
            <div class="mb-3">
                <label for="usuario" class="form-label">Asignar a</label>
                <select class="form-control" id="usuario" name="usuario" required>
                    <?php while ($usuario = $usuarios->fetch_assoc()) { ?>
                        <option value="<?php echo $usuario['id']; ?>"><?php echo $usuario['nombre']; ?></option>
                    <?php } ?>
                </select>
            </div>
            
            <button type="submit" class="btn btn-primary">Asignar</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Cerrar la conexión
$conn->close();
?>
