<?php
require_once __DIR__ . '/data_model.php';
$data_model = new data_model();

$reporte = $_GET['reporte'];
switch ($reporte) {
    case 'reporte_aptos_grado':
        $data = $data_model->lista_aptos_grado();
        break;
    case 'reporte_estudio_grado':
        $data = $data_model->lista_estudio_grado();
        break;
    default:
        // Error: reporte no existe
        die;
        break;
}

$filename = $_GET['reporte'] .' - '. date('d/m/Y');

header("Content-Disposition: attachment; filename={$filename}");
header("Content-Type: application/vnd.ms-excel");

$flag = false;
foreach ($data as $row) {
    if (!$flag) {
        echo implode("\t", array_keys($row)) . "\n";
        $flag = true;
    }
    echo implode("\t", array_values($row)) . "\n";
}