<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sala_belleza_spa";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verifica si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Procesa el formulario y realiza la actualización del servicio
    $servicio_id = $_POST["servicio_id"];
    $nombre_servicio = $_POST["nombre_servicio"];
    $tipo_servicio_id = $_POST["tipo_servicio_id"];
    $precio = $_POST["precio"];
    $tiempo_estimado = $_POST["tiempo_estimado"];

    // Realiza la actualización en la base de datos
    $sql_update_servicio = "UPDATE servicios SET 
                            nombre_servicio = '$nombre_servicio', 
                            tipo_servicio_id = '$tipo_servicio_id', 
                            precio = '$precio', 
                            tiempo_estimado = '$tiempo_estimado' 
                            WHERE id_servicio = '$servicio_id'";

    if ($conn->query($sql_update_servicio) === TRUE) {
        header("Location: ./servicio_select.php");
        exit();
    } else {
        echo '<div class="alert alert-danger" role="alert">
                Error al actualizar el servicio: ' . $conn->error . '
              </div>';
    }
}

// Obtén el ID del servicio de la URL
if (isset($_GET["id"])) {
    $servicio_id = $_GET["id"];

    // Consulta para obtener los detalles del servicio
    $sql_servicio = "SELECT * FROM servicios WHERE id_servicio = '$servicio_id'";
    $result_servicio = $conn->query($sql_servicio);

    // Verifica si se encontró el servicio
    if ($result_servicio->num_rows > 0) {
        $servicio = $result_servicio->fetch_assoc();
    } else {
        // Puedes redirigir o manejar el error de alguna manera si no se encuentra el servicio
        echo '<div class="alert alert-danger" role="alert">
                Servicio no encontrado.
              </div>';
        exit();
    }
} else {
    // Puedes redirigir o manejar el error de alguna manera si no se proporciona el ID
    echo '<div class="alert alert-danger" role="alert">
            ID de servicio no proporcionado.
          </div>';
    exit();
}

// Consulta para obtener la lista de tipos de servicio
$sql_tipos_servicio = "SELECT id_tipo, nombre_tipo FROM tipos_servicio";
$result_tipos_servicio = $conn->query($sql_tipos_servicio);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Actualizar Servicio -Beauty Salon y Spa</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../../public/css/style.css">
</head>

<body class="bg-light">
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
                    <a class="nav-link text-gris" href="../Empleados/empleado_select.php">
                        <i class="fas fa-users fa-lg mr-1"></i> Empleados
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-gris" href="../Citas/cita_select.php">
                        <i class="fas fa-calendar-alt fa-lg mr-1"></i> Citas
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-gris" href="./servicio_select.php">
                        <i class="fas fa-spa fa-lg mr-1"></i> Servicios
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <h1 class="text-center text-rosa">
                    <i class="fas fa-pencil-alt fa-lg mr-2"></i>
                    Actualizar Servicio
                </h1>
                <form method="post" action="./servicio_edit.php">
                    <input type="hidden" name="servicio_id" value="<?php echo $servicio['id_servicio']; ?>">
                    <div class="form-group">
                        <label for="nombre_servicio" class="text-gris">
                            <i class="fas fa-file-alt fa-lg mr-2"></i>
                            Nombre del Servicio:
                        </label>
                        <input type="text" class="form-control" id="nombre_servicio" name="nombre_servicio" required value="<?php echo $servicio['nombre_servicio']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="tipo_servicio_id" class="text-gris">
                            <i class="fas fa-certificate fa-lg mr-2"></i>
                            Tipo de Servicio:
                        </label>
                        <select class="form-control" id="tipo_servicio_id" name="tipo_servicio_id" required>
                            <?php
                            // Muestra las opciones del menú desplegable y selecciona el tipo actual del servicio
                            while ($tipo_servicio = $result_tipos_servicio->fetch_assoc()) {
                                $selected = ($tipo_servicio['id_tipo'] == $servicio['tipo_servicio_id']) ? 'selected' : '';
                                echo "<option value='{$tipo_servicio['id_tipo']}' $selected>{$tipo_servicio['nombre_tipo']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="precio" class="text-gris">
                            <i class="fas fa-dollar-sign fa-lg mr-2"></i>
                            Precio:
                        </label>
                        <input type="text" class="form-control" id="precio" name="precio" required value="<?php echo $servicio['precio']; ?>">
                    </div>
                  
                    <div class="form-group">
                        <label for="tiempo_estimado" class="text-gris">
                            <i class="far fa-clock fa-lg mr-2"></i>
                            Tiempo Estimado (HH:MM:SS):
                        </label>
                        <input type="text" class="form-control" id="tiempo_estimado" name="tiempo_estimado" pattern="^([0-9]{2}):([0-9]{2}):([0-9]{2})$" placeholder="HH:MM:SS" required>
                        <small id="tiempoHelp" class="form-text text-muted">Formato: HH:MM:SS</small>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-check fa-lg mr-2"></i>
                            Insertar empleado
                        </button>
                        <a href="./servicio_select.php" class="btn btn-secondary">
                            <i class="fas fa-times fa-lg mr-2"></i>
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>