<?php
// Verifica si se recibió el parámetro 'id' en la URL
if (isset($_GET['id'])) {
    // Obtiene el valor del parámetro 'id'
    $id_servicio = $_GET['id'];

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

    // Consulta SQL para eliminar el empleado con el ID proporcionado
    $sql = "DELETE FROM servicios WHERE id_servicio = $id_servicio";

    if ($conn->query($sql) === TRUE) {
        // Redirige a la página de empleados después de eliminar
        header("Location: ./servicio_select.php");
        exit();
    } else {
        echo "Error al eliminar empleado: " . $conn->error;
    }

    // Cierra la conexión a la base de datos
    $conn->close();
} 
?>
