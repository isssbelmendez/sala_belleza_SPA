<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sala_belleza_spa";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verifica si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Procesa el formulario y actualiza el empleado

    $id_empleado = $_POST["id_empleado"];
    $nombre = $_POST["nombre"];
    $tipo_empleado_id = $_POST["tipo_empleado_id"];

    // Realiza la actualización en la base de datos
    $sql_update = "UPDATE empleados SET nombre='$nombre', tipo_empleado_id='$tipo_empleado_id' WHERE id_empleado='$id_empleado'";

    if ($conn->query($sql_update) === TRUE) {
        header("Location: ./empleado_select.php");
        exit();
    } else {
        echo "Error al actualizar el empleado: " . $conn->error;
    }
}

// ID del empleado a editar (se obtiene de la URL)
if (isset($_GET["id"])) {
    $id_empleado = $_GET["id"];

    // Consulta para obtener la información del empleado seleccionado
    $sql_select = "SELECT * FROM empleados WHERE id_empleado=$id_empleado";
    $result_select = $conn->query($sql_select);

    // Consulta para obtener la lista de tipos de empleados
    $sql_tipos_empleado = "SELECT id_tipo, nombre_tipo FROM tipos_empleado";
    $result_tipos_empleado = $conn->query($sql_tipos_empleado);

    // Verifica si se encontró el empleado
    if ($result_select->num_rows > 0) {
        $row = $result_select->fetch_assoc();
    } else {
        echo "Empleado no encontrado";
        exit();
    }
} else {
    echo "ID de empleado no proporcionado";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Editar Empleado - Sala de Belleza y Spa</title>
    <!-- Agrega la referencia a Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../../public/css/style.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-rosa">
        <a class="navbar-brand text-gris" href="#">
            <i class="fas fa-spa fa-lg mr-2"></i>
            Beauty Salon y Spa
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link text-gris" href="../../index.php">
                        <i class="fas fa-home fa-lg mr-1"></i> Inicio
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-gris" href="./empleado_select.php">
                        <i class="fas fa-users fa-lg mr-1"></i> Empleados
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-gris" href="../Citas/cita_select.php">
                        <i class="fas fa-calendar-alt fa-lg mr-1"></i> Citas
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-gris" href="../Servicios/servicio_select.php">
                        <i class="fas fa-spa fa-lg mr-1"></i> Servicios
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container mt-5">
        <h1><i class="fas fa-user-edit fa-lg mr-2"></i>Editar Empleado</h1>
        <form method="post" action="./edit_emp.php?id=<?php echo $row["id_empleado"]; ?>">
            <input type="hidden" name="id_empleado" value="<?php echo $row["id_empleado"]; ?>">
            <div class="form-group">
                <label for="nombre">
                    <i class="fas fa-user fa-lg mr-2"></i>
                    Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $row["nombre"]; ?>" required>
            </div>
            <div class="form-group">
                <label for="tipo_empleado_id">
                    <i class="fas fa-briefcase fa-lg mr-2"></i>
                    Tipo de Empleado:</label>
                <select class="form-control" id="tipo_empleado_id" name="tipo_empleado_id" required>
                    <?php
                    // Muestra las opciones del menú desplegable
                    while ($tipo_empleado = $result_tipos_empleado->fetch_assoc()) {
                        $selected = ($tipo_empleado['id_tipo'] == $row['tipo_empleado_id']) ? 'selected' : '';
                        echo "<option value='{$tipo_empleado['id_tipo']}' $selected>{$tipo_empleado['nombre_tipo']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-check fa-lg mr-2"></i>
                    Insertar empleado
                </button>
                <a href="./empleado_select.php" class="btn btn-secondary">
                    <i class="fas fa-times fa-lg mr-2"></i>
                    Cancelar
                </a>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>

<?php
$conn->close();
?>