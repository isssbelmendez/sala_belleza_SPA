<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sala_belleza_spa";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("La conexión falló: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Variables recibidas del formulario
    $cliente = $_POST["cliente"];
    $fecha = $_POST["fecha"];
    $hora_inicio = $_POST["hora_inicio"];
    $id_servicio = $_POST["id_servicio"];

    // Validar que la hora de inicio esté entre las 8:00 am y las 4:00 pm
    $hora_inicio_valida = strtotime($hora_inicio);
    $hora_inicio_limite1 = strtotime("08:00:00");
    $hora_inicio_limite2 = strtotime("16:00:00");

    if ($hora_inicio_valida < $hora_inicio_limite1 || $hora_inicio_valida > $hora_inicio_limite2) {
        echo "<script>
                alert('Error: Las citas solo pueden ser agendadas entre las 8:00 am y las 4:00 pm.');
                window.location.href = './cita_insert.php';
              </script>";
        exit();
    }


    // Obtener el tipo de servicio del nuevo pedido
    $sqlTipoServicio = "SELECT tipo_servicio_id, tiempo_estimado FROM servicios WHERE id_servicio = $id_servicio";
    $resultTipoServicio = $conn->query($sqlTipoServicio);

    if ($resultTipoServicio->num_rows > 0) {
        $rowTipoServicio = $resultTipoServicio->fetch_assoc();
        $tipo_servicio_id = $rowTipoServicio["tipo_servicio_id"];
        $tiempo_estimado = $rowTipoServicio["tiempo_estimado"];
    } else {
        echo "<script>
        alert('Error: Error: No se pudo obtener el tipo de servicio.');
        window.location.href = './cita_insert.php';
      </script>";
        exit();
    }

    // Obtener el primer empleado disponible para el nuevo pedido
    $sqlEmpleado = "SELECT id_empleado
    FROM empleados
    WHERE tipo_empleado_id = $tipo_servicio_id
      AND NOT EXISTS (
          SELECT 1
          FROM citas
          INNER JOIN servicios ON citas.id_servicio = servicios.id_servicio
          WHERE citas.fecha = '$fecha'
            AND citas.id_empleado = empleados.id_empleado
            AND (
              ('$hora_inicio' BETWEEN citas.hora_inicio AND ADDTIME(citas.hora_inicio, servicios.tiempo_estimado))
              OR ('$hora_inicio' BETWEEN ADDTIME(citas.hora_inicio, servicios.tiempo_estimado) AND ADDTIME(citas.hora_inicio, '01:00:00'))
              OR ('$hora_inicio' < citas.hora_inicio AND ADDTIME('$hora_inicio', '01:00:00') > citas.hora_inicio)
            )
        )
    ORDER BY (
        SELECT COALESCE(
            MAX(ADDTIME(citas.hora_inicio, servicios.tiempo_estimado)),
            '00:00:00'
        )
        FROM citas
        INNER JOIN servicios ON citas.id_servicio = servicios.id_servicio
        WHERE citas.fecha = '$fecha' 
          AND citas.id_empleado = empleados.id_empleado
          AND citas.hora_inicio < '$hora_inicio'
    ) ASC
    LIMIT 1;
    
    ";

    $resultEmpleado = $conn->query($sqlEmpleado);

    if ($resultEmpleado === false) {
        echo "<script>
        alert('Error en la consulta SQL para obtener empleado disponible:');
        window.location.href = './cita_insert.php';
      </script>";
        exit();
    }

    if ($resultEmpleado->num_rows > 0) {
        $rowEmpleado = $resultEmpleado->fetch_assoc();
        $id_empleado = $rowEmpleado["id_empleado"];

        // Insertar datos en la tabla `citas`
        $sql = "INSERT INTO citas (cliente, fecha, hora_inicio, id_servicio, id_empleado)
        VALUES ('$cliente', '$fecha', '$hora_inicio', $id_servicio, $id_empleado)";

        if ($conn->query($sql) === TRUE) {
            header("Location: ./cita_select.php");
        } else {
            echo "<script>
        alert('Error al registrar la cita:');
        window.location.href = './cita_insert.php';
      </script>";
        }
    } else {
        echo "<script>
        alert('Error: No hay empleados disponibles para la cita en el horario especificado.');
        window.location.href = './cita_insert.php';
      </script>";
    }

    // Cerrar la conexión
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Citas</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../../public/css/style.css">
</head>

<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-light bg-rosa">
        <a class="navbar-brand text-gris" href="#">
            <i class="fas fa-spa fa-lg mr-2"></i>
            Sala de Belleza y Spa
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
                    <a class="nav-link text-gris" href="../Servicios/servicio_select.php">
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
                    <i class="fas fa-calendar-plus fa-lg mr-2"></i>
                    Agendar Cita
                </h1>
                <form method="post" action="./cita_insert.php">
                    <div class="form-group">
                        <label for="cliente" class="text-gris">
                            <i class="fas fa-user fa-lg mr-2"></i>
                            Cliente:
                        </label>
                        <input type="text" class="form-control" id="cliente" name="cliente" required>
                    </div>
                    <div class="form-group">
                        <label for="fecha" class="text-gris">
                            <i class="fas fa-calendar-alt fa-lg mr-2"></i>
                            Fecha:
                        </label>
                        <input type="date" class="form-control" id="fecha" name="fecha" min="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="hora_inicio" class="text-gris">
                            <i class="fas fa-clock fa-lg mr-2"></i>
                            Hora de inicio:
                        </label>
                        <input type="time" class="form-control" id="hora_inicio" name="hora_inicio" required>
                    </div>
                    <div class="form-group">
                        <label for="id_servicio" class="text-gris">
                            <i class="fas fa-spa fa-lg mr-2"></i>
                            Servicio:
                        </label>
                        <select class="form-control" id="id_servicio" name="id_servicio" required>
                            <?php
                            // Obtener servicios desde la base de datos
                            $sqlServicios = "SELECT id_servicio, nombre_servicio FROM servicios";
                            $resultServicios = $conn->query($sqlServicios);

                            while ($servicio = $resultServicios->fetch_assoc()) {
                                echo "<option value='{$servicio['id_servicio']}'>{$servicio['nombre_servicio']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-check fa-lg mr-2"></i>
                            Agregar Servicio
                        </button>
                        <a href="./cita_select.php" class="btn btn-secondary">
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