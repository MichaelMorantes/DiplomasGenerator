<?php

require_once __DIR__ . '/data_model.php';
header('Content-Type: application/json');

$data_model = new data_model();
$params = array_map("utf8_decode", $_POST);

switch ($params['accion']) {
    case 'proceso_agr':
        $result = $data_model->actualizar_agr();
        echo json_encode(['respuesta' => $result]);
        break;
    case 'ingreso_excel':
        $result = $data_model->ingresar($params, $_FILES);
        echo json_encode(['respuesta' => $result]);
        break;
    case 'estado_proceso':
        $result = $data_model->lista_actas_sinaprobar();
        $result = empty($result) ? [] : array_map("utf8_encode", $result[0]);
        echo json_encode(['data' => $result], JSON_UNESCAPED_UNICODE);
        break;
    case 'estado_config':
        $result = $data_model->lista_actas_config();
        $result = empty($result) ? [] : array_map("utf8_encode", $result[0]);
        echo json_encode(['data' => $result], JSON_UNESCAPED_UNICODE);
        break;
    case 'lista_seq':
        $result = $data_model->lista_seq();
        echo json_encode(['data' => $result], JSON_UNESCAPED_UNICODE);
        break;
    case 'lista_fechas_sinaprobar':
        $result = $data_model->lista_fechas_sinaprobar();
        echo json_encode(['data' => $result], JSON_UNESCAPED_UNICODE);
        break;
    default:
        echo json_encode(['respuesta' => false]);
        break;
}
