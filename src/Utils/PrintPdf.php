<?php
require_once __DIR__ . '/dompdf/autoload.inc.php';
require_once __DIR__ . '/../../public/assets/file/Plantillas/V1/crear_acta.php';
require_once __DIR__ . '/../../public/assets/file/Plantillas/V2/crear_acta.php';
require_once __DIR__ . '/alert/alert_model.php';
session_start();

use Dompdf\Dompdf;
use Dompdf\Options;

class PrintPdf extends Dompdf
{
    private const url = "D:/actas/public/assets/file/Plantillas";
    public function __construct()
    {
        parent::__construct();
    }

    public function crear_html($params, $creation_params)
    {

        $html = sprintf(
            <<<HTML
        <html>
            %s
            <body>
        HTML,
            file_get_contents(self::url . "/Plantilla-Estilos.txt")
        );

        if ($creation_params['version_acta'] == 'V1') {
            $crear_acta = new crear_acta_v1();
        } elseif ($creation_params['version_acta'] == 'V2') {
            $crear_acta = new crear_acta_v2();
        } else {
            alert::add(alert::ERROR, "¡Error! No se ha encuentra la versión del acta solicitada.");
            header('Location: ../../');
            die;
        }

        for ($i = 0; $i < count($params); $i++) {
            if ($params[$i]['tipo_grado'] == 'ceremonia' && $creation_params['tipo_acta'] == 'acta_base') {
                $info_acta = $crear_acta->asignar_info_ceremonia_hmtl($params[$i]);
            } elseif ($params[$i]['tipo_grado'] == 'ventanilla' && $creation_params['tipo_acta'] == 'acta_base') {
                $info_acta = $crear_acta->asignar_info_ventanilla_hmtl($params[$i]);
            } elseif ($params[$i]['tipo_grado'] == 'ceremonia' && $creation_params['tipo_acta'] == 'duplicado') {
                $info_acta = $crear_acta->asignar_info_duplicado_ceremonia_hmtl($params[$i]);
            } elseif ($params[$i]['tipo_grado'] == 'ventanilla' && $creation_params['tipo_acta'] == 'duplicado') {
                $info_acta = $crear_acta->asignar_info_duplicado_ventanilla_hmtl($params[$i]);
            }

            if (!$info_acta) {
                alert::add(alert::ERROR, "¡Error! No se ha establecido plantilla de acta '{$creation_params['version_acta']}' para el tipo de acta '{$creation_params['tipo_acta']}'.");
                header('Location: ../../');
                die;
            }

            if ($i === 0) {
                $html .= $info_acta;
                continue;
            }
            $html .= '<div class="plantilla">';
            $html .= $info_acta;
            $html .= '</div>';
        }

        $html .= '</body></html>';
        return $this->exportpdf($html);
    }

    public function exportpdf($html)
    {
        $this->loadHtml($html);
        $this->render();
        $this->stream('Actas de grado' );
    }

    public function calcular_hora_fin($hora)
    {
        if ($hora < 12) {
            return 'mañana';
        } elseif ($hora >= 12 && $hora < 17) {
            return 'tarde';
        } elseif ($hora >= 17 && $hora < 19) {
            return 'noche';
        }
    }
}
