<?php
require '../../dompdf/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;

include '../../Conf/conf.php';

$nombrePdf = 'Servicios_Sala_Belleza' . date('Ymd_His') . '.pdf';

$sql = "SELECT servicios.id_servicio, servicios.nombre_servicio, servicios.precio, servicios.tiempo_estimado
        FROM servicios
        INNER JOIN tipos_servicio ON servicios.tipo_servicio_id = tipos_servicio.id_tipo
        WHERE tipos_servicio.nombre_tipo = 'Sala de Belleza'
        ORDER BY servicios.id_servicio ASC";

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
    background-color: #aed581;
    color: #fff;
    border-top: 2px solid #4caf50;
}
h1 {
    text-align: center;
    color: #4caf50;
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
.green-spikes {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 100%;
    background: repeating-linear-gradient(
        to right,
        #aed581,
        #aed581 10px,
        #fff 10px,
        #fff 20px
    );
}
</style>';

$html .= '<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">';

$html .= '<div class="yellow-spikes"></div>';
$html .= '<div class="page-header">
            <h1>Reporte de Servicios de Sala de Belleza</h1>
          </div>';

$html .= '<table class="custom-table">
         <thead>
            <tr>
                <th>Id Servicio</th>
                <th>Nombre Servicio</th>
                <th>Precio</th>
                <th>Tiempo Estimado</th>
            </tr>
         </thead>
         <tbody>';

while ($row = $resultado->fetch_assoc()) {
    $html .= '
        <tr>
            <td>' . $row['id_servicio'] . '</td>
            <td>' . $row['nombre_servicio'] . '</td>
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
