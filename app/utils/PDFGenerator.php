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

    public function generarHistorialAtleta($atleta, $resultados)
    {
        $html = $this->generarHTMLHistorialAtleta($atleta, $resultados);
        $nombreArchivo = 'historial_' . $atleta['id'] . '_' . date('Y-m-d') . '.pdf';
        self::generar($html, $nombreArchivo);
    }

    public function generarTestIndividual($resultado)
    {
        $html = $this->generarHTMLTestIndividual($resultado);
        $nombreArchivo = 'test_' . $resultado['id'] . '_' . date('Y-m-d') . '.pdf';
        self::generar($html, $nombreArchivo);
    }

    private function generarHTMLHistorialAtleta($atleta, $resultados)
    {
        $edad = date_diff(date_create($atleta['fecha_nacimiento']), date_create('today'))->y;
        
        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Historial de Tests - ' . htmlspecialchars($atleta['nombre'] . ' ' . $atleta['apellido']) . '</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 20px; }
                .atleta-info { margin-bottom: 30px; }
                .atleta-info table { width: 100%; border-collapse: collapse; }
                .atleta-info td { padding: 8px; border: 1px solid #ddd; }
                .atleta-info th { background-color: #f5f5f5; padding: 8px; border: 1px solid #ddd; }
                .resultados-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                .resultados-table th, .resultados-table td { padding: 10px; border: 1px solid #ddd; text-align: left; }
                .resultados-table th { background-color: #007bff; color: white; }
                .resultados-table tr:nth-child(even) { background-color: #f9f9f9; }
                .footer { margin-top: 30px; text-align: center; font-size: 12px; color: #666; }
            </style>
        </head>
        <body>
            <div class="header">
                <h1>📊 Historial de Tests Realizados</h1>
                <h2>' . htmlspecialchars($atleta['nombre'] . ' ' . $atleta['apellido']) . '</h2>
                <p>Generado el: ' . date('d/m/Y H:i') . '</p>
            </div>

            <div class="atleta-info">
                <h3>📋 Información del Atleta</h3>
                <table>
                    <tr>
                        <th>Nombre Completo</th>
                        <td>' . htmlspecialchars($atleta['nombre'] . ' ' . $atleta['apellido']) . '</td>
                        <th>DNI</th>
                        <td>' . htmlspecialchars($atleta['dni']) . '</td>
                    </tr>
                    <tr>
                        <th>Fecha de Nacimiento</th>
                        <td>' . date('d/m/Y', strtotime($atleta['fecha_nacimiento'])) . '</td>
                        <th>Edad</th>
                        <td>' . $edad . ' años</td>
                    </tr>
                    <tr>
                        <th>Sexo</th>
                        <td>' . ($atleta['sexo'] === 'M' ? 'Masculino' : 'Femenino') . '</td>
                        <th>Altura</th>
                        <td>' . $atleta['altura_cm'] . ' cm</td>
                    </tr>
                    <tr>
                        <th>Peso</th>
                        <td>' . $atleta['peso_kg'] . ' kg</td>
                        <th>IMC</th>
                        <td>' . ($atleta['altura_cm'] > 0 && $atleta['peso_kg'] > 0 ? number_format($atleta['peso_kg'] / pow($atleta['altura_cm']/100, 2), 1) : 'N/A') . '</td>
                    </tr>
                </table>
            </div>

            <div class="resumen">
                <h3>📈 Resumen de Tests</h3>
                <p><strong>Total de tests realizados:</strong> ' . count($resultados) . '</p>
                <p><strong>Tipos de test diferentes:</strong> ' . count(array_unique(array_column($resultados, 'test_id'))) . '</p>
                <p><strong>Lugares de evaluación:</strong> ' . count(array_unique(array_column($resultados, 'lugar_id'))) . '</p>
            </div>

            <div class="resultados">
                <h3>🧪 Lista de Tests Realizados</h3>';

        if (empty($resultados)) {
            $html .= '<p>No hay tests registrados para este atleta.</p>';
        } else {
            $html .= '
                <table class="resultados-table">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Test</th>
                            <th>Lugar</th>
                            <th>Evaluador</th>
                            <th>Resultado</th>
                        </tr>
                    </thead>
                    <tbody>';

            foreach ($resultados as $r) {
                $resultadoData = json_decode($r['resultado_json'], true);
                $resultadoTexto = 'Datos disponibles';
                
                if (is_array($resultadoData)) {
                    $valores = [];
                    foreach ($resultadoData as $key => $value) {
                        if (is_numeric($value)) {
                            $valores[] = $key . ': ' . $value;
                        }
                    }
                    if (!empty($valores)) {
                        $resultadoTexto = implode(', ', array_slice($valores, 0, 3));
                    }
                }

                $html .= '
                        <tr>
                            <td>' . date('d/m/Y H:i', strtotime($r['fecha_test'])) . '</td>
                            <td>' . htmlspecialchars($r['nombre_test']) . '</td>
                            <td>' . htmlspecialchars($r['lugar']) . '</td>
                            <td>' . htmlspecialchars($r['evaluador_nombre'] ?? 'N/A') . '</td>
                            <td>' . htmlspecialchars($resultadoTexto) . '</td>
                        </tr>';
            }

            $html .= '
                    </tbody>
                </table>';
        }

        $html .= '
            </div>

            <div class="footer">
                <p>Documento generado automáticamente por el Sistema de Evaluación Deportiva</p>
                <p>Fecha de generación: ' . date('d/m/Y H:i:s') . '</p>
            </div>
        </body>
        </html>';

        return $html;
    }

    private function generarHTMLTestIndividual($resultado)
    {
        $resultadoData = json_decode($resultado['resultado_json'], true);
        
        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Test Individual - ' . htmlspecialchars($resultado['nombre_test']) . '</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 20px; }
                .info-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
                .info-table th, .info-table td { padding: 10px; border: 1px solid #ddd; }
                .info-table th { background-color: #f5f5f5; }
                .resultados { margin-top: 20px; }
                .resultado-item { margin: 10px 0; padding: 10px; background-color: #f9f9f9; border-left: 4px solid #007bff; }
                .footer { margin-top: 30px; text-align: center; font-size: 12px; color: #666; }
            </style>
        </head>
        <body>
            <div class="header">
                <h1>🧪 Resultado de Test Individual</h1>
                <h2>' . htmlspecialchars($resultado['nombre_test']) . '</h2>
                <p>Generado el: ' . date('d/m/Y H:i') . '</p>
            </div>

            <div class="info-general">
                <h3>📋 Información General</h3>
                <table class="info-table">
                    <tr>
                        <th>Atleta</th>
                        <td>' . htmlspecialchars($resultado['atleta_nombre']) . '</td>
                        <th>Test</th>
                        <td>' . htmlspecialchars($resultado['nombre_test']) . '</td>
                    </tr>
                    <tr>
                        <th>Fecha</th>
                        <td>' . date('d/m/Y H:i', strtotime($resultado['fecha_test'])) . '</td>
                        <th>Lugar</th>
                        <td>' . htmlspecialchars($resultado['lugar']) . '</td>
                    </tr>
                    <tr>
                        <th>Evaluador</th>
                        <td>' . htmlspecialchars($resultado['evaluador_nombre'] ?? 'N/A') . '</td>
                        <th>Descripción</th>
                        <td>' . htmlspecialchars($resultado['descripcion'] ?? 'N/A') . '</td>
                    </tr>
                </table>
            </div>

            <div class="resultados">
                <h3>📊 Resultados Detallados</h3>';

        if (is_array($resultadoData)) {
            foreach ($resultadoData as $key => $value) {
                $html .= '
                <div class="resultado-item">
                    <strong>' . htmlspecialchars($key) . ':</strong> ' . htmlspecialchars($value) . '
                </div>';
            }
        } else {
            $html .= '<p>No hay datos de resultados disponibles.</p>';
        }

        $html .= '
            </div>

            <div class="footer">
                <p>Documento generado automáticamente por el Sistema de Evaluación Deportiva</p>
                <p>Fecha de generación: ' . date('d/m/Y H:i:s') . '</p>
            </div>
        </body>
        </html>';

        return $html;
    }
}
