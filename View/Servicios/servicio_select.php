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

// Consulta para obtener la información de servicios con el nombre del tipo de servicio, ordenados por id_servicio de forma ascendente
$sql = "SELECT servicios.id_servicio, servicios.nombre_servicio, tipos_servicio.nombre_tipo, servicios.precio, servicios.tiempo_estimado 
    FROM servicios 
    INNER JOIN tipos_servicio ON servicios.tipo_servicio_id = tipos_servicio.id_tipo";

// Verificar si se envió una búsqueda
if (isset($_GET['search'])) {
    $search = $_GET['search'];

    // Evitar inyección SQL utilizando prepared statements
    $sql .= " WHERE servicios.nombre_servicio LIKE ? OR tipos_servicio.nombre_tipo LIKE ?";

    // Agregar comodines '%' para hacer búsquedas parciales
    $searchTerm = "%$search%";
    $sql .= " ORDER BY servicios.id_servicio ASC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $searchTerm, $searchTerm);
    $stmt->execute();

    // Obtener resultados de la consulta
    $result = $stmt->get_result();
} else {
    // Si no hay término de búsqueda, obtener todos los servicios
    $sql .= " ORDER BY servicios.id_servicio ASC";
    $result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Servicios - Sala de Belleza y Spa</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../../public/css/style.css">
    <style>
        .button-space {
            margin-left: 5px;
        }
    </style>
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

        <div class="d-flex justify-content-between align-items-center mb-2">
            <h1><i class="fas fa-spa fa-lg mr-1"></i> Servicios</h1>
            <a href="./servicio_insert.php"class="btn btn-success"><i class="fas fa-plus"></i> Agregar</a>
        </div>


        <!-- Campo de búsqueda -->
        <div class="form-group">
            <input type="text" class="form-control" id="search" placeholder="Ingrese nombre o tipo de servicio">
        </div>

        <div class="form-group mt-3">
                <!-- Botones para descargar PDF -->
                <div class="row">
                    <div class="col-md-4 mb-2">
                        <form action="../../Reportes/Servicios/reporte_general.php" method="post" target="_blank">
                            <input type="submit" class="btn btn-info btn-block" value="Descargar Servicios General">
                        </form>
                    </div>

                    <div class="col-md-4 mb-2">
                        <form action="../../Reportes/Servicios/reporte_spa.php" method="post" target="_blank">
                            <input type="submit" class="btn btn-info btn-block" value="Descargar Servicios Spa">
                        </form>
                    </div>

                    <div class="col-md-4 mb-2">
                        <form action="../../Reportes/Servicios/reporte_sala.php" method="post" target="_blank">
                            <input type="submit" class="btn btn-info btn-block" value="Descargar Servicios Sala de Belleza">
                        </form>
                    </div>
                </div>
            </div>

        <!-- Tabla de servicios -->
        <div class="table-responsive mt-3">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th><i class="fas fa-id-card"></i> ID Servicio</th>
                        <th><i class="fas fa-file-alt"></i> Nombre</th>
                        <th><i class="fas fa-certificate"></i> Tipo de Servicio</th>
                        <th><i class="fas fa-dollar-sign"></i> Precio</th>
                        <th><i class="far fa-clock"></i> Tiempo estimado</th>
                        <th><i class="fas fa-cogs"></i> Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Muestra los datos de servicios en la tabla
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["id_servicio"] . "</td>";
                            echo "<td>" . $row["nombre_servicio"] . "</td>";
                            echo "<td>" . $row["nombre_tipo"] . "</td>";
                            echo "<td>" . $row["precio"] . "</td>";
                            echo "<td>" . $row["tiempo_estimado"] . "</td>";
                            echo "<td>";
                            echo "<a href='./servicio_edit.php?id=" . $row["id_servicio"] . "' class='btn btn-warning'><i class='fas fa-edit'></i> Editar</a>";
                            echo "<span class='button-space'></span>";
                            echo "<a href='./servicio_delete.php?id=" . $row["id_servicio"] . "' class='btn btn-danger'><i class='fas fa-trash'></i> Eliminar</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No hay servicios disponibles.</td></tr>";
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
    <!-- Script AJAX para búsqueda dinámica -->
    <script>
        $(document).ready(function() {
            function searchServices(search) {
                $.ajax({
                    url: "./buscar_servicio.php",
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

            // Llamada inicial para cargar todos los servicios al cargar la página
            searchServices("");

            $("#search").on("keyup", function() {
                var search = $(this).val();
                searchServices(search);
            });
        });
    </script>

</body>

</html>

<?php
$conn->close();
?>