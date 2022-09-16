<?php

require_once __DIR__ . '/data_model.php';
header('Content-Type: application/json');

$data_model = new data_model();
$params = array_map("utf8_decode", $_POST);

switch ($params['accion']) {
    case 'imprimir_actas':
        $result = $data_model->imprimir($params);
        echo json_encode(['respuesta' => $result]);
        break;
    case 'lista_parametros_print':
        $result = $data_model->lista_parametros_print($params);
        echo json_encode(['data' => $result], JSON_UNESCAPED_UNICODE);
        break;
    case 'lista_periodos_aprobadas':
        $result = $data_model->lista_periodos_aprobadas();
        echo json_encode(['data' => $result], JSON_UNESCAPED_UNICODE);
        break;
    default:
        echo json_encode(['respuesta' => false]);
        break;
}
