<?php

require_once __DIR__ . '/../Model/model.php';
require_once __DIR__ . '/../Utils/FunctionsExcel.php';
require_once __DIR__ . '/../Utils/PrintPdf.php';
require_once __DIR__ . '/../Utils/alert/alert_model.php';

class data_model
{
    private $model;

    public function __construct()
    {
        $this->model = new model();
    }

    public function lista_estudio_grado()
    {
        return $this->model->executeQuery($this->getQuery('SelectAllEstudioParaGrado'));
    }

    public function lista_aptos_grado()
    {
        return $this->model->executeQuery($this->getQuery('SelectAllAptosParaGrado'));
    }

    public function lista_seq()
    {
        return $this->model->executeQuery($this->getQuery('SelectAllSeqActas'));
    }

    public function generar_listado_previo()
    {
        return $this->model->executeUpdate($this->getQuery('ProcGeneracionListadoPreviosActas'));
    }

    public function lista_parametros_print($params)
    {
        return $this->model->executeQuery($this->getQuery($params['query']), array(':periodo_id' => $params['periodo']));
    }

    public function lista_periodos_aprobadas()
    {
        return $this->model->executeQuery($this->getQuery('SelectPeriodoAprobadas'));
    }

    public function lista_fechas_sinaprobar()
    {
        return $this->model->executeQuery($this->getQuery('SelectFechaSinAprobar'));
    }

    public function lista_actas_sinaprobar()
    {
        return $this->model->executeQuery($this->getQuery('SelectAllSinAprobarRC_ACTAS'));
    }

    public function lista_actas_config()
    {
        return $this->model->executeQuery($this->getQuery('SelectAllRC_ACTAS_CONFIG'));
    }

    public function lista_actas_sinaprobar_cantidad($fecha)
    {
        return $this->model->executeQuery($this->getQuery('SelectAllSinAprobarRC_ACTAS_CANTIDAD'), array(':fecha_grado' => $fecha));
    }

    public function lista_actas_config_cantidad($fecha)
    {
        return $this->model->executeQuery($this->getQuery('SelectAllRC_ACTAS_CONFIG_CANTIDAD'), array(':fecha_grado' => $fecha));
    }

    public function lista_actas_aprobadas($params)
    {
        $query = $this->ParametrosSelect($this->clear_empty_params($params), $query = $this->getQuery('SelectAllAprobadasRC_ACTAS'));
        return $this->model->executeQuery($query);
    }

    public function clear_empty_params($params)
    {
        $params = array_filter($params, fn ($value) => !is_null($value) && $value !== '');
        array_pop($params);
        return $params;
    }

    public function eliminar_actas_config()
    {
        $conn = $this->model->getConnection();
        $todeleterows = $this->lista_actas_config();
        $conn->beginTransaction();
        $deletedrows = $this->model->executeUpdateCautious($this->getQuery('DeleteRC_ACTAS_CONFIG'));
        if (COUNT($todeleterows) !== $deletedrows) {
            $conn->rollBack();
            return false;
        }
        $conn->commit();
        return true;
    }

    public function aprobar_listado_previo($params)
    {
        array_pop($params);
        foreach ($params as $key => $value) {
            if (strpos($key, 'fecha_grado') !== false && (empty($value) || !trim($value))) {
                $extension = substr($key, -1);
            }
            if (strpos($key, $extension) !== false) {
                unset($params[$key]);
            }
        }

        $conn = $this->model->getConnection();
        $query = $this->getQuery('UpdateRC_ACTAS_CONFIG');
        $conn->beginTransaction();

        for ($i = 0; $i < COUNT($params) / 3; $i++) {
            $toupdaterows = $this->lista_actas_config_cantidad($params['fecha_grado_' . $i]);

            $updatedrows = $this->model->executeUpdateCautious($query, array(':resolucion_id' => $params['resolucion_id_' . $i], ':fecha_resolucion' => date('d/m/Y', strtotime($params['fecha_resolucion_' . $i])), ':fecha_grado' => $params['fecha_grado_' . $i]));
            if (COUNT($toupdaterows) !== $updatedrows) {
                $conn->rollBack();
                return false;
            }
        }

        $query = $this->getQuery('UpdateRC_ACTAS');

        for ($i = 0; $i < COUNT($params) / 3; $i++) {
            $toupdaterows = $this->lista_actas_sinaprobar_cantidad($params['fecha_grado_' . $i]);

            $updatedrows = $this->model->executeUpdateCautious($query, array(':resolucion_id' => $params['resolucion_id_' . $i], ':fecha_resolucion' => date('d/m/Y', strtotime($params['fecha_resolucion_' . $i])), ':fecha_grado' => $params['fecha_grado_' . $i]));
            if (COUNT($toupdaterows) !== $updatedrows) {
                $conn->rollBack();
                return false;
            }
        }

        $conn->commit();
        $query = $this->getQuery('ProcAprobacionListadoPreviosActas');
        return $this->model->executeUpdate($query);
    }

    public function eliminar_listado_previo()
    {
        $conn = $this->model->getConnection();
        $todeleterows = $this->lista_actas_sinaprobar();
        $conn->beginTransaction();
        $deletedrows = $this->model->executeUpdateCautious($this->getQuery('DeleteRC_ACTAS'));

        if (COUNT($todeleterows) !== $deletedrows) {
            $conn->rollBack();
            return false;
        }

        $this->model->executeUpdate($this->getQuery('UpdateRC_ACTAS_SEQ'));
        $conn->commit();
        return true;
    }

    public function actualizar_agr()
    {
        try {
            $this->model->executeUpdate($this->getQuery('ProcActualizarAptosGrado'));
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return true;
    }

    public function ingresar($params, $file)
    {
        $FunctionsExcel = new FunctionsExcel();
        $query = $this->getQuery('InsertRC_ACTAS_CONFIG');

        if (!$this->validarParamsForm($params, $file)) {
            return false;
        }

        $data_csv = $FunctionsExcel->importcsv($file['excel']['tmp_name']);

        if (is_array($data_csv)) {
            array_shift($data_csv);
            foreach ($data_csv as $key => $value) {
                $this->model->executeUpdate($query, array(':plan_estudio_id' => $value[0], ':cantidad_estudiantes' => $value[1], ':fecha_grado' => date('d/m/Y h:i:s', strtotime($value[2])), ':tipo_grado' => $params['tipo_grado']));
            }
            return true;
        } else {
            return $data_csv;
        }
    }

    public function imprimir($params)
    {
        $filter_params = $this->clear_empty_params($params);
        $creation_params = array('version_acta' => array_shift($filter_params), 'tipo_acta' => end($filter_params));
        array_pop($filter_params);

        if (empty($filter_params)) {
            alert::add(alert::ERROR, "¡Error! No se recibieron parametros de busqueda.");
            header('Location: ../../');
            die;
        }

        $PrintPdf = new PrintPdf();

        $query = $this->ParametrosSelect($filter_params, $this->getQuery("SelectInfoPrintActas"));
        $result = $this->model->executeQuery($query);

        if (empty($result)) {
            alert::add(alert::ERROR, "¡Error! No se encontraron resultados.");
            header('Location: ../../');
            die;
        }

        return $PrintPdf->crear_html($result, $creation_params);
    }

    public function SelectPeriodoPlantillaGrado($params)
    {
        $query = $this->ParametrosSelect($params, $this->getQuery("SelectPeriodoPlantillaPrint"));
        return $this->model->executeQuery($query);
    }

    public function ParametrosSelect($params, $query)
    {
        foreach ($params as $key => $value) {
            if (strpos($key, 'FECHA') === false) {
                $query .= "\r AND A.{$key} = '{$value}'";
            } else {
                $query .= "\r AND TO_CHAR(A.{$key}, 'DD/MM/YYYY') = '{$value}'";
            }
        }
        $query .= "\r ORDER BY A.ACTAS_ID";
        return $query;
    }

    public function validarParamsForm($params, $file)
    {
        if (
            !isset($params['tipo_grado']) || empty($params['tipo_grado'])
            || $file['excel']['error'] != 0 || $file['excel']['size'] > 5000000 || $file['excel']['type'] !== 'application/vnd.ms-excel'
        ) {
            return false;
        }
        return true;
    }

    public function validarParamsTableActas($params)
    {
        if (
            !isset($params['id_resolucion']) || is_int($params['id_resolucion'])
            || !isset($params['fecha_resolucion']) || empty($params['fecha_resolucion'])
        ) {
            return false;
        }
        return true;
    }

    private function getQuery($query)
    {
        $content = file_get_contents(__DIR__ . "/../Database/sql/$query.sql");

        if (!is_string($content)) {
            return '';
        }

        return $content;
    }
}
