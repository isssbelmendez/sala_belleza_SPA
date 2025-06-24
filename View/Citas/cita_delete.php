<?php
// Verifica si se recibió el parámetro 'id' en la URL
if (isset($_GET['id'])) {
    // Obtiene el valor del parámetro 'id'
    $id_cita = $_GET['id'];

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

    // Consulta SQL para eliminar el cita con el ID proporcionado
    $sql = "DELETE FROM citas WHERE id_cita = $id_cita";

    if ($conn->query($sql) === TRUE) {
        // Redirige a la página de citas después de eliminar
        header("Location: ./cita_select.php");
        exit();
    } else {
        echo "Error al eliminar cita: " . $conn->error;
    }

    // Cierra la conexión a la base de datos
    $conn->close();
} 
?>
