<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use App\Models\Sale;
use Dompdf\Options;
use App\Exports\SaleExport;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{

    public function reportPDF($userId, $reportType, $dateFrom = null, $dateTo = null){

        $data = [];

        if($reportType == 0)  //VENTAS DEL DIA
        {
            $from = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 23:59:59';

        }else{
            $from = Carbon::parse($dateFrom)->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse($dateTo)->format('Y-m-d') . ' 23:59:59';
        }

        if($userId == 0){
            $data = Sale::join('users as u','u.id','sales.user_id')
                ->select('sales.*','u.name as user')
                ->whereBetween('sales.created_at', [$from, $to])
                ->get();
        }else{
            $data = Sale::join('users as u', 'u.id','sales.user_id')
                ->select('sales.*','u.name as user')
                ->whereBetween('sales.created_at', [$from, $to])
                ->where('user_id', $userId)
                ->get();
        }

        $user = $userId == 0 ? 'Todos' : User::find($userId)->name;
        //$seller = $this->obtenerNombreVendedor($seller_selected);
        $pdf = PDF\Pdf::loadView('pdf.reporte', compact('data', 'reportType','user','dateFrom','dateTo'));

        return $pdf->stream('salesReport.pdf'); //visualizar
        //return $pdf->download('salesReport.pdf'); //descargar
    }


    public function reportExcel($userId, $reportType, $dateFrom = null, $dateTo = null)
    {
        /*$export = new SaleExport();
        $filePath = $export->reportExcel();

        // Crear una respuesta para descargar el archivo
        return response()->download($filePath)->deleteFileAfterSend(true);*/

        $export = new SaleExport($userId, $reportType, $dateFrom, $dateTo );
        $filePath = $export->reportExcel();

        // Descargar el archivo y eliminarlo después de la descarga
        return response()->download($filePath)->deleteFileAfterSend(true);

    }


    /*public function obtenerNombreVendedor($seller)
    {
        $vendedor = User::find($seller);
        return $vendedor ? $vendedor->name : 'C/F';
    }*/


}
