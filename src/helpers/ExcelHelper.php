<?php

namespace infotech\components\helpers;

use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Exception as ReaderException;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\Exception as WriterException;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use RuntimeException;

class ExcelHelper
{
    /**
     * @param array $data
     * @return Spreadsheet
     */
    public static function getSpreadsheet(array $data): Spreadsheet
    {
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()->setCreated(time());

        if ($title = ($data['title'] ?? null)) {
            $spreadsheet->getProperties()->setTitle($title);
        }

        if ($company = ($data['company'] ?? null)) {
            $spreadsheet->getProperties()->setCompany($company);
        }

        return $spreadsheet;
    }

    /**
     * @param Spreadsheet $excel
     * @param $filename
     * @throws WriterException
     */
    public static function saveExcelFile(Spreadsheet $excel, $filename): void
    {
        $writer = new Xlsx($excel);
        $writer->save($filename);
    }

    /**
     * @param Worksheet $sheet
     * @param array $data
     * @param int $row
     * @throws Exception
     */
    public static function fillSheetFromData(Worksheet $sheet, array $data, &$row = 1): void
    {
        foreach (array_values($data['headers']) as $col => $header) {
            $cell = $sheet->getCellByColumnAndRow($col + 1, $row);
            $cell->setValue($header);
            $cell->getStyle()->applyFromArray(
                [
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'color' => ['rgb' => 'E6E6FA'],
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => 'D3D3D3'],
                        ],
                    ],
                    'font' => [
                        'bold' => true,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                        'wrapText' => true,
                    ],
                ]
            );
        }
        if ($r = $sheet->getRowDimension('1')) {
            $r->setRowHeight(30);
        }

        $multilineColumns = $data['options']['wrapText'] ?? [];
        $datetimeColumns = $data['options']['dateTime'] ?? [];
        $dateColumns = $data['options']['date'] ?? [];
        $yearMonthColumns = $data['options']['yearMonth'] ?? [];
        $notFormulaColumns = $data['options']['notFormula'] ?? [];
        $percentColumns = $data['options']['percent'] ?? [];
        $codes = array_keys($data['headers']);
        // fixed using generator
        $rows = is_array($data['rows']) ? array_values($data['rows']) : $data['rows'];
        $row++;
        foreach ($rows as $rowData) {
            $color = $rowData['highlight'] ?? null;
            if ($color) {
                $sheet->getStyle((string)($row))
                    ->applyFromArray(
                        [
                            'fill' => [
                                'fillType' => Fill::FILL_SOLID,
                                'color' => ['rgb' => $color],
                            ],
                        ]
                    );
            }
            foreach ($codes as $col => $itemCode) {
                $value = $rowData[$itemCode] ?? null;
                if (null === $value) {
                    continue;
                }

                $cell = $sheet->getCellByColumnAndRow($col + 1, $row);
                switch (true) {
                    case in_array($itemCode, $datetimeColumns):
                        $value = Date::PHPToExcel($value);
                        $format = 'dd.mm.yyyy hh:mm';
                        break;
                    case in_array($itemCode, $dateColumns):
                        $value = Date::PHPToExcel($value);
                        $format = 'dd.mm.yyyy';
                        break;
                    case in_array($itemCode, $yearMonthColumns):
                        $value = Date::PHPToExcel($value);
                        $format = 'mmmm yyyy';
                        break;
                    case in_array($itemCode, $percentColumns):
                        if (is_int($value)) {
                            $format = NumberFormat::FORMAT_PERCENTAGE;
                        } elseif (is_float($value)) {
                            $format = NumberFormat::FORMAT_PERCENTAGE_00;
                        } else {
                            $format = null;
                        }
                        break;
                    case !in_array($itemCode, $notFormulaColumns):
                        if (is_int($value)) {
                            $format = NumberFormat::FORMAT_NUMBER;
                        } elseif (is_float($value)) {
                            $format = NumberFormat::FORMAT_NUMBER_00;
                        } else {
                            $format = null;
                        }
                        break;
                    default:
                        $format = null;
                }

                $cell->setValue($value);
                $cellStyle = $cell->getStyle();

                if ($format) {
                    $cellStyle
                        ->getNumberFormat()
                        ->setFormatCode($format);
                }
                if (in_array($itemCode, $multilineColumns)) {
                    $cellStyle->getAlignment()->setWrapText(true);
                }
                if (in_array($itemCode, $notFormulaColumns)) {
                    $cellStyle->setQuotePrefix(true);
                }
            }
            if ($r = $sheet->getRowDimension($row)) {
                $r->setRowHeight(-1);
            }
            $row++;
        }
        $col = 1;
        foreach ($data['headers'] as $itemCode => $header) {
            $column = $sheet->getColumnDimensionByColumn($col);
            if (!$column) {
                throw new RuntimeException();
            }
            if (!in_array($itemCode, $multilineColumns)) {
                $column->setAutoSize(true);
            } else {
                $column->setWidth(60);
            }
            $col++;
        }
    }

    /**
     * @param Spreadsheet $excel
     * @param array $data
     * @throws Exception
     */
    public static function addSheet(Spreadsheet $excel, array $data): void
    {
        $sheet = $excel->createSheet();
        if ($title = ($data['title'] ?? null)) {
            $sheet->setTitle($title);
        }

        static::fillSheetFromData($sheet, $data);
    }

    /**
     * @param $path
     * @return Spreadsheet
     * @throws ReaderException
     */
    public static function readPhpExcelFile($path): Spreadsheet
    {
        $inputFileType = IOFactory::identify($path);
        $reader = IOFactory::createReader($inputFileType);
        $reader->setReadDataOnly(false);

        return $reader->load($path);
    }

    /**
     * @param array $data
     * @param $fileName
     * @throws Exception
     * @throws WriterException
     */
    public static function getRenderedExcel(array $data, $fileName): void
    {
        $excel = static::getSpreadsheet($data);
        $excel->removeSheetByIndex(0);

        $isAssociative = false;
        foreach ($data as $key => $value) {
            if (!is_string($key)) {
                continue;
            }
            $isAssociative = true;
            break;
        }

        if ($isAssociative) {
            $data = [$data];
        }
        $activeSheetIndex = null;
        foreach ($data as $index => $sheetData) {
            static::addSheet($excel, $sheetData);
            if ($sheetData['active'] ?? false) {
                $activeSheetIndex = $index;
            }
        }
        if ($activeSheetIndex !== null) {
            $excel->setActiveSheetIndex($activeSheetIndex);
        }
        static::saveExcelFile($excel, $fileName);
    }
}
