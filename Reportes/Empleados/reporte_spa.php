<?php
require '../../dompdf/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;
include '../../Conf/conf.php';

$nombrePdf = 'Empleados_Spa' . date('Ymd_His') . '.pdf';

$sql = "SELECT empleados.id_empleado, empleados.nombre, tipos_empleado.nombre_tipo 
        FROM empleados 
        INNER JOIN tipos_empleado ON empleados.tipo_empleado_id = tipos_empleado.id_tipo
        WHERE tipos_empleado.nombre_tipo = 'Spa'
        ORDER BY empleados.id_empleado ASC";

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

$html .= '<div class="blue-spikes"></div>';
$html .= '<div class="page-header">
            <h1>Reporte de Empleados - Spa</h1>
          </div>';

$html .= '<table class="custom-table">
         <thead>
            <tr>
                <th>Id empleado</th>
                <th>Nombre</th>
                <th>Tipo empleado</th>
            </tr>
         </thead>
         <tbody>';

while ($row = $resultado->fetch_assoc()) {
    $html .= '
        <tr>
            <td>' . $row['id_empleado'] . '</td>
            <td>' . $row['nombre'] . '</td>
            <td>' . $row['nombre_tipo'] . '</td>
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
