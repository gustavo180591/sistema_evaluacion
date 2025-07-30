<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExcelExporter
{
    public static function exportar($data, $headers, $filename = 'export.xlsx')
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Encabezados
        foreach ($headers as $col => $header) {
            $sheet->setCellValueByColumnAndRow($col + 1, 1, $header);
        }

        // Filas de datos
        foreach ($data as $rowIndex => $row) {
            foreach ($row as $colIndex => $value) {
                $sheet->setCellValueByColumnAndRow($colIndex + 1, $rowIndex + 2, $value);
            }
        }

        // Descargar el archivo
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    public function exportarHistorialAtleta($atleta, $resultados)
    {
        $spreadsheet = new Spreadsheet();
        
        // Hoja 1: Información del Atleta
        $sheet1 = $spreadsheet->getActiveSheet();
        $sheet1->setTitle('Información Atleta');
        
        $sheet1->setCellValue('A1', 'INFORMACIÓN DEL ATLETA');
        $sheet1->getCell('A1')->getFont()->setBold(true)->setSize(14);
        
        $sheet1->setCellValue('A3', 'Nombre Completo:');
        $sheet1->setCellValue('B3', $atleta['nombre'] . ' ' . $atleta['apellido']);
        
        $sheet1->setCellValue('A4', 'DNI:');
        $sheet1->setCellValue('B4', $atleta['dni']);
        
        $sheet1->setCellValue('A5', 'Fecha de Nacimiento:');
        $sheet1->setCellValue('B5', date('d/m/Y', strtotime($atleta['fecha_nacimiento'])));
        
        $sheet1->setCellValue('A6', 'Edad:');
        $sheet1->setCellValue('B6', date_diff(date_create($atleta['fecha_nacimiento']), date_create('today'))->y . ' años');
        
        $sheet1->setCellValue('A7', 'Sexo:');
        $sheet1->setCellValue('B7', $atleta['sexo'] === 'M' ? 'Masculino' : 'Femenino');
        
        $sheet1->setCellValue('A8', 'Altura:');
        $sheet1->setCellValue('B8', $atleta['altura_cm'] . ' cm');
        
        $sheet1->setCellValue('A9', 'Peso:');
        $sheet1->setCellValue('B9', $atleta['peso_kg'] . ' kg');
        
        $imc = $atleta['altura_cm'] > 0 && $atleta['peso_kg'] > 0 ? 
               number_format($atleta['peso_kg'] / pow($atleta['altura_cm']/100, 2), 1) : 'N/A';
        $sheet1->setCellValue('A10', 'IMC:');
        $sheet1->setCellValue('B10', $imc);
        
        // Resumen de tests
        $sheet1->setCellValue('A12', 'RESUMEN DE TESTS');
        $sheet1->getCell('A12')->getFont()->setBold(true)->setSize(12);
        
        $sheet1->setCellValue('A14', 'Total de tests realizados:');
        $sheet1->setCellValue('B14', count($resultados));
        
        $sheet1->setCellValue('A15', 'Tipos de test diferentes:');
        $sheet1->setCellValue('B15', count(array_unique(array_column($resultados, 'test_id'))));
        
        $sheet1->setCellValue('A16', 'Lugares de evaluación:');
        $sheet1->setCellValue('B16', count(array_unique(array_column($resultados, 'lugar_id'))));
        
        // Formatear encabezados de información básica
        foreach (['A3', 'A4', 'A5', 'A6', 'A7', 'A8', 'A9', 'A10', 'A14', 'A15', 'A16'] as $cell) {
            $sheet1->getCell($cell)->getFont()->setBold(true);
        }
        
        // Autoajustar columnas de la primera hoja
        foreach (range('A', 'B') as $col) {
            $sheet1->getColumnDimension($col)->setAutoSize(true);
        }
        
        // Hoja 2: Lista de Tests
        $sheet2 = $spreadsheet->createSheet();
        $sheet2->setTitle('Tests Realizados');
        
        // Encabezados
        $headers = ['Fecha', 'Hora', 'Test', 'Descripción', 'Lugar', 'Evaluador', 'Resultados'];
        foreach ($headers as $col => $header) {
            $sheet2->setCellValueByColumnAndRow($col + 1, 1, $header);
            $sheet2->getCellByColumnAndRow($col + 1, 1)->getFont()->setBold(true);
        }
        
        // Datos de los tests
        foreach ($resultados as $rowIndex => $resultado) {
            $row = $rowIndex + 2;
            
            $sheet2->setCellValueByColumnAndRow(1, $row, date('d/m/Y', strtotime($resultado['fecha_test'])));
            $sheet2->setCellValueByColumnAndRow(2, $row, date('H:i', strtotime($resultado['fecha_test'])));
            $sheet2->setCellValueByColumnAndRow(3, $row, $resultado['nombre_test']);
            $sheet2->setCellValueByColumnAndRow(4, $row, $resultado['descripcion'] ?? 'N/A');
            $sheet2->setCellValueByColumnAndRow(5, $row, $resultado['lugar']);
            $sheet2->setCellValueByColumnAndRow(6, $row, $resultado['evaluador_nombre'] ?? 'N/A');
            
            // Procesar resultados JSON
            $resultadoData = json_decode($resultado['resultado_json'], true);
            $resultadoTexto = 'Datos disponibles';
            
            if (is_array($resultadoData)) {
                $valores = [];
                foreach ($resultadoData as $key => $value) {
                    if (is_numeric($value)) {
                        $valores[] = $key . ': ' . $value;
                    }
                }
                if (!empty($valores)) {
                    $resultadoTexto = implode(', ', array_slice($valores, 0, 5));
                }
            }
            
            $sheet2->setCellValueByColumnAndRow(7, $row, $resultadoTexto);
        }
        
        // Autoajustar columnas
        foreach (range('A', 'G') as $col) {
            $sheet2->getColumnDimension($col)->setAutoSize(true);
        }
        
        // Configurar el archivo para descarga
        $filename = 'historial_' . $atleta['id'] . '_' . date('Y-m-d') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"$filename\"");
        header('Cache-Control: max-age=0');
        
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
