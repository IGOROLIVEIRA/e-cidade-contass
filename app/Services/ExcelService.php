<?php


namespace App\Services;

use PHPExcel_IOFactory;

include("libs/PHPExcel/Classes/PHPExcel.php");

class ExcelService
{
    public function importFile($file_location): array
    {
        $spreadsheet = PHPExcel_IOFactory::load($file_location);
        return $objWorksheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
    }
}
