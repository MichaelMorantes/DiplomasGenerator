<?php
require_once __DIR__ . '/../../../../../src/Utils/PrintPdf.php';

class crear_acta_v1
{
    private const url = "D:/actas/public/assets/file/Plantillas/V1";

    public function asignar_info_ceremonia_hmtl($params)
    {
        return false;
    }

    public function asignar_info_ventanilla_hmtl($params)
    {
        return false;
    }

    public function asignar_info_duplicado_ceremonia_hmtl($params)
    {
        $fmt = new NumberFormatter('es', NumberFormatter::SPELLOUT);

        return sprintf(
            file_get_contents(self::url . "/Plantilla-Ceremonia.txt"),
            $params['desc_plan'],
            $params['resolucion_id'],
            strtoupper($params['mes_resolucion']),
            $params['dia_resolucion'],
            $params['ano_resolucion'],
            $params['carrera_actas_id'],
            strtoupper($fmt->format(intval(date('H', strtotime($params['hora_grado']))))),
            date('H', strtotime($params['hora_grado'])),
            strtoupper($fmt->format(intval($params['dia_grado']))),
            $params['dia_grado'],
            strtoupper($params['mes_grado']),
            strtoupper($fmt->format(intval($params['ano_grado']))),
            $params['ano_grado'],
            $params['nombre'],
            $params['tipo_docident_desc'],
            $params['doc_ident'],
            $params['municipio_docident'],
            $params['nombre'],
            $params['desc_plan'],
            $params['nombre'],
            $params['desc_tecnologo'],
            $fmt->format(intval(date('H', strtotime($params['dia_expedicion'])))),
            $params['dia_expedicion'],
            strtoupper($params['mes_expedicion']),
            strtoupper($fmt->format(intval($params['ano_expedicion']))),
            $params['ano_expedicion'],
            $params['dia_expedicion'],
            strtoupper($params['mes_expedicion']),
            $params['ano_expedicion'],
        );
    }

    public function asignar_info_duplicado_ventanilla_hmtl($params)
    {
        $fmt = new NumberFormatter('es', NumberFormatter::SPELLOUT);

        return sprintf(
            file_get_contents(self::url . "/Plantilla-Ventanilla.txt"),
            $params['desc_plan'],
            $params['resolucion_id'],
            $params['carrera_actas_id'],
            $fmt->format(intval(date('H', strtotime($params['hora_grado'])))),
            date('H', strtotime($params['hora_grado'])),
            $fmt->format(intval($params['dia_grado'])),
            $params['dia_grado'],
            strtoupper($fmt->format($params['mes_grado'])),
            strtoupper($fmt->format(intval($params['ano_grado']))),
            $params['ano_grado'],
            $params['nombre'],
            $params['tipo_docident_desc'],
            $params['doc_ident'],
            $params['municipio_docident'],
            $params['nombre'],
            $params['desc_plan'],
            $params['nombre'],
            $params['desc_tecnologo'],
            $fmt->format(intval(date('H', strtotime($params['dia_expedicion'])))),
            $params['dia_expedicion'],
            strtoupper($params['mes_expedicion']),
            strtoupper($fmt->format(intval($params['ano_expedicion']))),
            $params['ano_expedicion'],
            $params['dia_expedicion'],
            strtoupper($params['mes_expedicion']),
            $params['ano_expedicion'],
        );
    }
}
