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

    // Consulta para obtener la información de empleados con el nombre del tipo de empleado, ordenados por id_empleado de forma ascendente
    $sql = "SELECT empleados.id_empleado, empleados.nombre, tipos_empleado.nombre_tipo 
            FROM empleados 
            INNER JOIN tipos_empleado ON empleados.tipo_empleado_id = tipos_empleado.id_tipo
            ORDER BY empleados.id_empleado ASC";

    $result = $conn->query($sql);
    ?>

    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Empleados - Beauty Salon y Spa</title>
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
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h1><i class="fas fa-users fa-lg mr-1"></i> Empleados</h1>
                <a href="./insert_emp.php" class="btn btn-success"><i class="fas fa-plus"></i> Agregar</a>
            </div>
            <!-- Campo de búsqueda -->
            <div class="form-group">
                <input type="text" class="form-control" id="search" placeholder="Ingrese nombre o tipo de empleado">
            </div>

            <div class="form-group mt-3">
                <!-- Botones para descargar PDF -->
                <div class="row">
                    <div class="col-md-4 mb-2">
                        <form action="../../Reportes/Empleados/reporte_empleados.php" method="post" target="_blank">
                            <input type="submit" class="btn btn-info btn-block" value="Descargar Empleados General">
                        </form>
                    </div>

                    <div class="col-md-4 mb-2">
                        <form action="../../Reportes/Empleados/reporte_spa.php" method="post" target="_blank">
                            <input type="submit" class="btn btn-info btn-block" value="Descargar Empleados Spa">
                        </form>
                    </div>

                    <div class="col-md-4 mb-2">
                        <form action="../../Reportes/Empleados/reporte_sala.php" method="post" target="_blank">
                            <input type="submit" class="btn btn-info btn-block" value="Descargar Empleados Sala de Belleza">
                        </form>
                    </div>
                </div>
            </div>

            <!-- Tabla de empleados -->
            <table id="employeeTable" class="table">
                <thead>
                    <tr>
                        <th><i class="fas fa-id-card"></i> ID Empleado</th>
                        <th><i class="fas fa-user"></i> Nombre</th>
                        <th><i class="fas fa-user-tie"></i> Tipo de Empleado</th>
                        <th><i class="fas fa-cogs"></i> Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Aquí se mostrarán los resultados de la búsqueda -->
                </tbody>
            </table>
        </div>

        <!-- Scripts de jQuery y Bootstrap -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- Script AJAX para búsqueda dinámica -->
        <script>
            $(document).ready(function() {
                function searchEmployees(search) {
                    $.ajax({
                        url: "./buscar_empleados.php",
                        type: "GET",
                        data: {
                            search: search
                        },
                        success: function(response) {
                            $("#employeeTable tbody").html(response);
                        }
                    });
                }

                // Llamada inicial para cargar todos los empleados al cargar la página
                searchEmployees("");

                $("#search").on("keyup", function() {
                    var search = $(this).val();
                    searchEmployees(search);
                });
            });
        </script>

    </body>

    </html>