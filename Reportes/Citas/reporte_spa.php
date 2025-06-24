<?php
require '../../dompdf/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;
include '../../Conf/conf.php';

$nombrePdf = 'Citas_Spa' . date('Ymd_His') . '.pdf';

$sql = "SELECT citas.id_cita, citas.cliente, citas.fecha, citas.hora_inicio, 
               servicios.nombre_servicio, servicios.tiempo_estimado, servicios.precio, 
               empleados.nombre as nombre_empleado
        FROM citas
        INNER JOIN servicios ON citas.id_servicio = servicios.id_servicio
        INNER JOIN empleados ON citas.id_empleado = empleados.id_empleado
        WHERE servicios.tipo_servicio_id = 2
        ORDER BY citas.id_cita ASC";

$resultado = mysqli_query($conexion, $sql);

$html = '<style>
body {
    font-family: "Arial, sans-serif";
    background-color: #f5f5f5;
}
.custom-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 1rem;
    color: #333;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
}
.custom-table th,
.custom-table td {
    padding: 1rem;
    text-align: left;
    border-bottom: 1px solid #ddd;
}
.custom-table th {
    background-color: #64b5f6;
    color: #fff;
    border-top: 2px solid #2196f3;
}
h1 {
    text-align: center;
    color: #2196f3;
    margin-top: 40px;
}
.company-logo {
    max-width: 100px;
    border-radius: 50%;
    margin-right: 10px;
}
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}
.blue-spikes {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 100%;
    background: repeating-linear-gradient(
        to right,
        #64b5f6,
        #64b5f6 10px,
        #fff 10px,
        #fff 20px
    );
}
</style>';

$html .= '<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">';

$html .= '<div class="green-spikes"></div>';
$html .= '<div class="page-header">
            <h1>Reporte de Citas de Spa</h1>
          </div>';

$html .= '<table class="custom-table">
         <thead>
            <tr>
                <th>Id Cita</th>
                <th>Cliente</th>
                <th>Fecha</th>
                <th>Hora Inicio</th>
                <th>Servicio</th>
                <th>Empleado</th>
                <th>Precio</th>
                <th>Tiempo Estimado del Servicio</th>
            </tr>
         </thead>
         <tbody>';

while ($row = $resultado->fetch_assoc()) {
    $html .= '
        <tr>
            <td>' . $row['id_cita'] . '</td>
            <td>' . $row['cliente'] . '</td>
            <td>' . $row['fecha'] . '</td>
            <td>' . $row['hora_inicio'] . '</td>
            <td>' . $row['nombre_servicio'] . '</td>
            <td>' . $row['nombre_empleado'] . '</td>
            <td>' . $row['precio'] . '</td>
            <td>' . $row['tiempo_estimado'] . '</td>
        </tr>';
}

$html .= '</tbody></table>';

$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isPhpEnabled', true);
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);

$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream($nombrePdf);
?>
