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

    // Evitar inyección SQL utilizando prepared statements
    $sql = $conn->prepare("SELECT servicios.id_servicio, servicios.nombre_servicio, tipos_servicio.nombre_tipo, servicios.precio, servicios.tiempo_estimado 
                           FROM servicios 
                           INNER JOIN tipos_servicio ON servicios.tipo_servicio_id = tipos_servicio.id_tipo
                           WHERE servicios.nombre_servicio LIKE ? OR tipos_servicio.nombre_tipo LIKE ?
                           ORDER BY servicios.id_servicio ASC");

    // Agregar comodines '%' para hacer búsquedas parciales
    $searchTerm = "%$search%";
    $sql->bind_param("ss", $searchTerm, $searchTerm);
    $sql->execute();

    // Obtener resultados de la consulta
    $result = $sql->get_result();
} else {
    // Si no hay término de búsqueda, obtener todos los servicios
    $sql = "SELECT servicios.id_servicio, servicios.nombre_servicio, tipos_servicio.nombre_tipo, servicios.precio, servicios.tiempo_estimado 
            FROM servicios 
            INNER JOIN tipos_servicio ON servicios.tipo_servicio_id = tipos_servicio.id_tipo
            ORDER BY servicios.id_servicio ASC";

    $result = $conn->query($sql);
}

// Mostrar resultados
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

// Cerrar conexión
$conn->close();
?>
