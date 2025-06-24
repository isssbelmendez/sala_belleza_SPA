<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sala_belleza_spa";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se envió una búsqueda
if (isset($_GET['search'])) {
    $search = $_GET['search'];

    // Dividir los términos de búsqueda
    $searchTerms = explode(',', $search);
    
    // Evitar inyección SQL utilizando prepared statements
    $sql = $conn->prepare("SELECT citas.id_cita, citas.cliente, citas.fecha, citas.hora_inicio, servicios.nombre_servicio, servicios.tiempo_estimado, servicios.precio, empleados.nombre as nombre_empleado
                           FROM citas
                           INNER JOIN servicios ON citas.id_servicio = servicios.id_servicio
                           INNER JOIN empleados ON citas.id_empleado = empleados.id_empleado
                           WHERE citas.cliente LIKE ? OR servicios.nombre_servicio LIKE ? OR citas.fecha LIKE ?
                           ORDER BY citas.id_cita ASC");

    // Agregar comodines '%' para hacer búsquedas parciales
    $searchTerm = "%{$searchTerms[0]}%";
    $sql->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);

    $sql->execute();

    // Obtener resultados de la consulta
    $result = $sql->get_result();
} else {
    // Si no hay término de búsqueda, mostrar un mensaje de error o devolver resultados vacíos
    echo "<tr><td colspan='9'>Error en la búsqueda.</td></tr>";
    exit();
}

// Mostrar resultados
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
    echo "<tr><td colspan='9'>No hay citas disponibles.</td></tr>";
}

// Cerrar conexión
$conn->close();
?>