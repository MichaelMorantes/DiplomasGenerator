<?php
require_once __DIR__ . '/../../../../../src/Utils/PrintPdf.php';

class crear_acta_v2
{
    private const url = "D:/actas/public/assets/file/Plantillas/V2";
    
    public function asignar_info_duplicado_ceremonia_hmtl($params)
    {
        return false;
    }

    public function asignar_info_duplicado_ventanilla_hmtl($params)
    {
        return false;
    }

    public function asignar_info_ceremonia_hmtl($params)
    {
        $PrintPdf = new PrintPdf();

        return sprintf(
            file_get_contents(self::url . "/Plantilla-Ceremonia.txt"),
            $params['carrera_actas_id'],
            $params['hora_grado'],
            $params['dia_grado'],
            strtolower($params['mes_grado']), 
            $params['ano_grado'],
            $params['resolucion_id'],
            $params['dia_resolucion'],
            strtolower($params['mes_resolucion']),
            $params['ano_resolucion'],
            $params['resolucion_id'],
            $params['desc_tecnologo'],
            $params['proconsecutivo_id'],
            $params['nombre'],
            $params['tipo_docident_abrev'],
            $params['doc_ident'],
            $params['municipio_docident'],
            date('h:i', strtotime($params['hora_fin_grado'])),
            $PrintPdf->calcular_hora_fin(date('H', strtotime($params['hora_fin_grado']))),
            $params['dia_expedicion'],
            strtolower($params['mes_expedicion']),
            $params['ano_expedicion'],
        );
    }

    public function asignar_info_ventanilla_hmtl($params)
    {
        return sprintf(
            file_get_contents(self::url . "/Plantilla-Ventanilla.txt"),
            $params['carrera_actas_id'],
            $params['dia_grado'],
            strtolower($params['mes_grado']), 
            $params['ano_grado'],
            $params['resolucion_id'],
            $params['dia_resolucion'],
            strtolower($params['mes_resolucion']),
            $params['ano_resolucion'],
            $params['resolucion_id'],
            $params['desc_tecnologo'],
            $params['proconsecutivo_id'],
            $params['nombre'],
            $params['tipo_docident_abrev'],
            $params['doc_ident'],
            $params['municipio_docident'],
            $params['dia_grado'],
            strtolower($params['mes_grado']), 
            $params['ano_grado'],
            $params['dia_expedicion'],
            strtolower($params['mes_expedicion']),
            $params['ano_expedicion'],
        );
    }
}