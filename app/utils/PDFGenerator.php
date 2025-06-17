<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

class PDFGenerator
{
    public static function generar($html, $nombreArchivo = 'reporte.pdf')
    {
        $options = new Options();
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $dompdf->stream($nombreArchivo, ['Attachment' => false]);
    }
}
