<?php

namespace App\Exports;

use App\Models\User;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\Sale;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Carbon;

class SaleExport
{
    protected $userId;
    protected $dateFrom;
    protected $dateTo;
    protected $reportType;
    protected $fileName;

    public function __construct($userId, $reportType, $f1, $f2)
    {
        $this->userId = $userId;
        $this->reportType = $reportType;
        $this->dateFrom = $f1;
        $this->dateTo = $f2;
        $this->fileName = 'Reporte_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
    }

    public function reportExcel()

    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Definir los encabezados
        $sheet->setCellValue('A1', 'VENTA')
            ->setCellValue('B1', 'IMPORTE')
            ->setCellValue('C1', 'CANTIDAD')
            ->setCellValue('D1', 'ESTADO')
            ->setCellValue('E1', 'CLIENTE')
            ->setCellValue('F1', 'USUARIO')
            ->setCellValue('G1', 'FECHA/HORA');

        // Aplicar estilos
        $sheet->getStyle('A1:G1')->applyFromArray([
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'D6D6D6',
                ],
            ],
        ]);

        // Obtener datos de ventas
        $data = $this->fetchSalesData();

        // Escribir datos en la hoja
        $row = 2;
        foreach ($data as $sale) {
            $sheet->setCellValue('A' . $row, $sale->id)
                ->setCellValue('B' . $row, $sale->total)
                ->setCellValue('C' . $row, $sale->items)
                ->setCellValue('D' . $row, $sale->status)
                ->setCellValue('E' . $row, $this->obtenerNombreVendedor($sale->seller))
                ->setCellValue('F' . $row, $sale->user)
                ->setCellValue('G' . $row, Date::dateTimeToExcel($sale->created_at));
            $row++;
        }

        // Aplicar formato a las columnas
        $sheet->getStyle('A1:G' . ($row - 1))->applyFromArray([
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ]);

        // Definir los formatos de columnas
        $sheet->getStyle('A')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER);
        $sheet->getStyle('B')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER);
        $sheet->getStyle('C')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER);
        $sheet->getStyle('D')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);
        $sheet->getStyle('E')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);
        $sheet->getStyle('F')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);
        $sheet->getStyle('G')->getNumberFormat()->setFormatCode('dd/mm/yyyy hh:mm');

        // Ajustar el ancho de las columnas
        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(20);

        // Crear el writer y guardar el archivo
        $writer = new Xlsx($spreadsheet);
        $filePath = storage_path('app/public/' . $this->fileName);
        $writer->save($filePath);

        return $filePath;
    }

    protected function fetchSalesData()
    {
        $from = Carbon::parse($this->dateFrom)->format('Y-m-d') . ' 00:00:00';
        $to = Carbon::parse($this->dateTo)->format('Y-m-d') . ' 23:59:59';

        if ($this->reportType == 0) {
            // Si es el tipo de reporte 0, el rango de fechas no debe ser considerado
            $from = Carbon::now()->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::now()->format('Y-m-d') . ' 23:59:59';
        }

        $query = Sale::join('users as u', 'u.id', 'sales.user_id')
            ->select('sales.id', 'sales.total', 'sales.items', 'sales.status', 'sales.seller', 'u.name as user', 'sales.created_at')
            ->whereBetween('sales.created_at', [$from, $to]);

        if ($this->userId != 0) {
            $query->where('user_id', $this->userId);
        }

        return $query->get();
    }

    public function obtenerNombreVendedor($seller)
    {
        $vendedor = User::find($seller);
        return $vendedor ? $vendedor->name : 'C/F';
    }
}
