<?php
require 'C:/wamp64/www/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

function generateExcelFile() {
    // Turn off error reporting
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(0);

    // Clear any output buffer
    if (ob_get_length()) ob_end_clean();

    // Create new Spreadsheet object
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Set header values
    $headers = ['Employee Id', 'Name', 'Department'];
    $column = 'A';

    foreach ($headers as $header) {
        $sheet->setCellValue($column . '1', $header);
        $column++;
    }

    // Apply header styling
    $headerStyle = [
        'font' => ['bold' => true],
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
        ],
    ];
    $sheet->getStyle('A1:C1')->applyFromArray($headerStyle);

    // Set output headers
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Staff_Details.xlsx"');
    header('Cache-Control: max-age=0');

    // Save file to output
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');

    // End the script to prevent extra output
    exit;
}

// Call the function to generate the file
generateExcelFile();
