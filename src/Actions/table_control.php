<?php
require_once __DIR__ . '/data_model.php';
header('Content-Type: application/json');

$data_model = new data_model();
$params = array_map("utf8_decode", $_POST);

switch ($params['accion']) {
    case 'lista_actas_sinaprobar':
        $result = $data_model->lista_actas_sinaprobar();
        echo json_encode(['data' => $result], JSON_UNESCAPED_UNICODE);
        break;
    case 'lista_actas_config':
        $result = $data_model->lista_actas_config();
        echo json_encode(['data' => $result], JSON_UNESCAPED_UNICODE);
        break;
    case 'lista_actas_aprobadas':
        $result = $data_model->lista_actas_aprobadas($params);
        echo json_encode(['data' => $result], JSON_UNESCAPED_UNICODE);
        break;
    case 'lista_estudio_grado':
        $result = $data_model->lista_estudio_grado();
        echo json_encode(['data' => $result], JSON_UNESCAPED_UNICODE);
        break;
    case 'lista_aptos_grado':
        $result = $data_model->lista_aptos_grado();
        echo json_encode(['data' => $result], JSON_UNESCAPED_UNICODE);
        break;
    default:
        echo json_encode(['respuesta' => false]);
        break;
}
