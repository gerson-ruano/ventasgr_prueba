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

class SaleExportBox
{
    protected $userid;
    protected $fromDate;
    protected $toDate;
    protected $fileName;

    public function __construct($userid, $fromDate, $toDate)
    {
        $this->userid = $userid;
        $this->fromDate = Carbon::parse($fromDate)->startOfDay();
        $this->toDate = Carbon::parse($toDate)->endOfDay();
        $this->fileName = 'ReporteBox_' . now()->format('h_i__d_m_Y') . '.xlsx';
    }

    public function reportExcel()

    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $statusTranslations = [
            'PAID' => 'Pagado',
            'CANCELLED' => 'Anulado',
            'PENDING' => 'Pendiente'
        ];

        // Definir los encabezados
        $sheet->setCellValue('A1', 'N0. VENTA')
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
        $data = $this->collection();

        // Escribir datos en la hoja
        $row = 2;
        foreach ($data as $sale) {
            //dd($sale);
            $translatedStatus = $statusTranslations[$sale->status] ?? $sale->status;

            $sheet->setCellValue('A' . $row, $sale->id)
                ->setCellValue('B' . $row, $sale->total)
                ->setCellValue('C' . $row, $sale->items)
                ->setCellValue('D' . $row, $translatedStatus)
                ->setCellValue('E' . $row, getNameSeller($sale->seller))
                ->setCellValue('F' . $row, getNameSeller($sale->user_id))
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

    public function collection()
    {
        // Devuelve la colección de ventas
        return Sale::whereBetween('created_at', [$this->fromDate, $this->toDate])
            ->where('status', 'Paid')
            ->where('user_id', $this->userid)
            ->get([
                'id', 'total', 'items', 'status', 'seller', 'user_id', 'created_at'
            ]);
    }
}
