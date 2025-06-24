<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sala_belleza_spa";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se envió una búsqueda
if (isset($_GET['search'])) {
    $search = $_GET['search'];

    // Evitar inyección SQL utilizando prepared statements
    $sql = $conn->prepare("SELECT empleados.id_empleado, empleados.nombre, tipos_empleado.nombre_tipo 
            FROM empleados 
            JOIN tipos_empleado ON empleados.tipo_empleado_id = tipos_empleado.id_tipo 
            WHERE empleados.nombre LIKE ? OR tipos_empleado.nombre_tipo LIKE ?");
    
    // Agregar comodines '%' para hacer búsquedas parciales
    $searchTerm = "%$search%";
    $sql->bind_param("ss", $searchTerm, $searchTerm);
    $sql->execute();

    // Obtener resultados de la consulta
    $result = $sql->get_result();
} else {
    // Si no hay término de búsqueda, obtener todos los empleados
    $sql = "SELECT empleados.id_empleado, empleados.nombre, tipos_empleado.nombre_tipo 
            FROM empleados 
            JOIN tipos_empleado ON empleados.tipo_empleado_id = tipos_empleado.id_tipo 
            ORDER BY empleados.id_empleado ASC";

    $result = $conn->query($sql);
}

// Mostrar resultados
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id_empleado"] . "</td>";
        echo "<td>" . $row["nombre"] . "</td>";
        echo "<td>" . $row["nombre_tipo"] . "</td>";
        echo "<td>";
        echo "<a href='./edit_emp.php?id=" . $row["id_empleado"] . "' class='btn btn-warning'><i class='fas fa-edit'></i> Editar</a>";
        echo "<span class='button-space'></span>";
        echo "<a href='./delete_emp.php?id=" . $row["id_empleado"] . "' class='btn btn-danger'><i class='fas fa-trash'></i> Eliminar</a>";
        echo "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='3'>No hay empleados disponibles.</td></tr>";
}

// Cerrar conexión
$conn->close();
?>