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


// Consulta para obtener la información de citas con el nombre del cliente, la fecha, la hora de inicio, el tiempo estimado, el nombre del servicio, el nombre del empleado, el precio y el tiempo estimado del servicio
$sql = "SELECT citas.id_cita, citas.cliente, citas.fecha, citas.hora_inicio, servicios.nombre_servicio, servicios.tiempo_estimado, servicios.precio, empleados.nombre as nombre_empleado
        FROM citas
        INNER JOIN servicios ON citas.id_servicio = servicios.id_servicio
        INNER JOIN empleados ON citas.id_empleado = empleados.id_empleado
        ORDER BY citas.id_cita ASC";

// Verificar si se envió una búsqueda
if (isset($_GET['search'])) {
    $search = $_GET['search'];

    // Evitar inyección SQL utilizando prepared statements
    $sql = $conn->prepare("SELECT citas.id_cita, citas.cliente, citas.fecha, citas.hora_inicio, servicios.nombre_servicio, servicios.tiempo_estimado, servicios.precio, empleados.nombre as nombre_empleado
                           FROM citas
                           INNER JOIN servicios ON citas.id_servicio = servicios.id_servicio
                           INNER JOIN empleados ON citas.id_empleado = empleados.id_empleado
                           WHERE citas.cliente LIKE ? OR servicios.nombre_servicio LIKE ?
                           ORDER BY citas.id_cita ASC");

    // Agregar comodines '%' para hacer búsquedas parciales
    $searchTerm = "%$search%";
    $sql->bind_param("ss", $searchTerm, $searchTerm);
    $sql->execute();

    // Obtener resultados de la consulta
    $result = $sql->get_result();
} else {
    // Si no hay término de búsqueda, ejecutar la consulta original
    $result = $conn->query($sql);
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Citas - Sala de Belleza y Spa</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../../public/css/style.css">
    <style>
        .button-space {
            margin-left: 5px;
        }

        /* Hacer la tabla responsiva */
        @media (max-width: 767px) {
            .table-responsive-sm {
                display: block;
                width: 100%;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
                -ms-overflow-style: -ms-autohiding-scrollbar;
            }
        }
    </style>
</head>

<body>
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
                    <a class="nav-link text-gris" href="./cita_select.php">
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
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h1><i class="fas fa-calendar-alt fa-lg mr-1"></i> Citas</h1>
            <a href="./cita_insert.php" class="btn btn-success"><i class="fas fa-plus"></i> Agregar</a>
        </div>

        <!-- Campo de búsqueda -->
        <div class="form-group">
            <input type="search" class="form-control" id="search" placeholder="Ingrese nombre del servicio o nombre del cliente">
        </div>

        <div class="form-group mt-3">
            <!-- Botones para descargar PDF -->
            <div class="row">
                <div class="col-md-4 mb-2">
                    <form action="../../Reportes/Citas/reporte_general.php" method="post" target="_blank">
                        <input type="submit" class="btn btn-info btn-block" value="Descargar Citas General">
                    </form>
                </div>

                <div class="col-md-4 mb-2">
                    <form action="../../Reportes/Citas/reporte_spa.php" method="post" target="_blank">
                        <input type="submit" class="btn btn-info btn-block" value="Descargar Citas Spa">
                    </form>
                </div>

                <div class="col-md-4 mb-2">
                    <form action="../../Reportes/Citas/reporte_spa.php" method="post" target="_blank">
                        <input type="submit" class="btn btn-info btn-block" value="Descargar Citas Sala de Belleza">
                    </form>
                </div>
            </div>
        </div>

        <div class="table-responsive-sm mt-3">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th><i class="fas fa-id-card"></i> ID Cita</th>
                        <th><i class="fas fa-user"></i> Cliente</th>
                        <th><i class="far fa-calendar-alt"></i> Fecha</th>
                        <th><i class="far fa-clock"></i> Hora de Inicio</th>
                        <th><i class="fas fa-spa"></i> Servicio</th>
                        <th><i class="far fa-clock"></i> Tiempo Estimado</th>
                        <th><i class="fas fa-dollar-sign"></i> Precio</th>
                        <th><i class="fas fa-user"></i> Empleado</th>
                        <th><i class="fas fa-cogs"></i> Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Muestra los datos de citas en la tabla
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["id_cita"] . "</td>";
                            echo "<td>" . $row["cliente"] . "</td>";
                            echo "<td>" . $row["fecha"] . "</td>";
                            echo "<td>" . $row["hora_inicio"] . "</td>";
                            echo "<td>" . $row["nombre_servicio"] . "</td>";
                            echo "<td>" . $row["tiempo_estimado"] . "</td>";
                            echo "<td>" . $row["precio"] . "</td>";
                            echo "<td>" . $row["nombre_empleado"] . "</td>"; // Muestra el nombre del empleado
                            echo "<td>";
                            echo "<a href='./cita_delete.php?id=" . $row["id_cita"] . "' class='btn btn-danger'><i class='fas fa-trash'></i> Eliminar</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>No hay citas registradas.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            function searchCitas(search) {
                $.ajax({
                    url: "./buscar_cita.php",
                    type: "GET",
                    data: {
                        search: search
                    },
                    success: function(response) {
                        // Reemplazar el contenido de tbody con las nuevas filas
                        $("tbody").html(response);
                    }
                });
            }

            // Llamada inicial para cargar todas las citas al cargar la página
            searchCitas("");

            $("#search").on("keyup", function() {
                var search = $(this).val();
                searchCitas(search);
            });
        });
    </script>
</body>

</html>
<?php
$conn->close();
?>