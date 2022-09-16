<?php

require_once __DIR__ . '/data_model.php';
header('Content-Type: application/json');

$data_model = new data_model();
$params = array_map("utf8_decode", $_POST);

switch ($params['accion']) {
    case 'generar_listado_previo':
        $result = $data_model->generar_listado_previo();
        echo json_encode(['respuesta' => $result]);
        break;
    case 'eliminar_actas_config':
        $result = $data_model->eliminar_actas_config();
        echo json_encode(['respuesta' => $result]);
        break;
    case 'aprobar_listado_previo':
        $result = $data_model->aprobar_listado_previo($params);
        echo json_encode(['respuesta' => $result]);
        break;
    case 'eliminar_listado_previo':
        $result = $data_model->eliminar_listado_previo();
        echo json_encode(['respuesta' => $result]);
        break;
    default:
        echo json_encode(['respuesta' => false]);
        break;
}
