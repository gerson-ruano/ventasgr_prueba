<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Sale;
use App\Models\SaleDetail;
use Livewire\WithPagination;
use Carbon\Carbon;

class Reports extends Component
{

    use WithPagination;

    public $componentName, $details, $sumDetails, $countDetails, $selected_id = 2,
        $reportType, $userId, $dateFrom, $dateTo, $saleId, $selectTipoEstado;

    private $pagination = 4;
    private $data = [];
    public $page = 1;
    public $selectedId;
    public $valoresVentas = [];
    public $vsloresPago = [];

    public function paginationView()
    {
        return 'vendor.livewire.tailwind';
    }

    public function mount()
    {
        $this->componentName = 'Reporte de Ventas';
        $this->pageTitle = 'EDITAR';
        $this->type = 'Elegir';
        $this->data = [];
        $this->details = [];
        $this->sumDetails = 0;
        $this->countDetails = 0;
        $this->reportType = 0;
        $this->userId = 0;
        $this->saleId = 0;
        $this->valoresVentas = $this->tipoReporte();
        $this->valoresPago = $this->tipoPago();

    }

    public function render()
    {
        $this->SalesByDate();
        $valores = $this->tipoPago();


        return view('livewire.reports.components', [
            'users' => User::orderBy('name', 'asc')->get(),
            'data' => $this->data,
            'valores' => $valores,
        ])
            ->extends('layouts.app')
            ->section('content');
    }

    public function SalesByDate()
    {

        if ($this->reportType == 0)  //VENTAS DEL DIA
        {
            $from = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 23:59:59';
        } else {
            $from = Carbon::parse($this->dateFrom)->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse($this->dateTo)->format('Y-m-d') . ' 23:59:59';
        }

        if ($this->reportType == 1 && ($this->dateFrom == '' || $this->dateTo == '')) {
            return;
        }

        $query = Sale::join('users as u', 'u.id', 'sales.user_id')
            ->select('sales.*', 'u.name as user')
            ->whereBetween('sales.created_at', [$from, $to]);

        if ($this->userId != 0) {
            $query->where('user_id', $this->userId);
        }

        if ($this->userId == 0) {

            $this->data = Sale::join('users as u', 'u.id', 'sales.user_id')
                ->select('sales.*', 'u.name as user')
                ->whereBetween('sales.created_at', [$from, $to])
                ->get();
        } else {
            $this->data = Sale::join('users as u', 'u.id', 'sales.user_id')
                ->select('sales.*', 'u.name as user')
                ->whereBetween('sales.created_at', [$from, $to])
                ->where('user_id', $this->userId)
                ->get();//->paginate($this->pagination);
        }

        if ($this->selectTipoEstado) {
            $query->where('sales.status', $this->selectTipoEstado);
        }

        $this->data = $query->paginate($this->pagination, ['*'], 'page', $this->page);


    }

    public function getDetails($saleId)
    {
        $this->details = SaleDetails::join('products as p', 'p.id', 'sale_details.product_id')
            ->select('sale_details.id', 'sale_details.price', 'sale_details.quantity', 'p.name as product')
            ->where('sale_details.sale_id', $saleId)
            ->get();

        //dd($this->details);

        $suma = $this->details->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        $this->sumDetails = $suma;

        $this->countDetails = $this->details->sum('quantity');
        //dd($this->countDetails);

        $this->saleId = $saleId;

        $this->dispatch('show-modal', 'Detalles Cargados');
    }

    public function tipoPago()
    {
        return Sale::pluck('status')->unique()->toArray();
    }

    public function Edit($id)
    {
        // Almacena el ID en la propiedad
        $this->selectedId = $id;

        // Emite un evento para mostrar el modal u otra lógica que tengas
        $this->resetUI();
        $this->dispatch('show', 'show modal!');

        $sale = Sale::find($id);
        $this->selectedStatus = $sale->status;
    }

    public function Update()
    {
        $this->validate([
            'selectedStatus' => 'required|not_in:Elegir', // Asegúrate de que 'Elegir' sea el valor por defecto
        ]);
        // Obtén la venta correspondiente por su ID
        $sale = Sale::find($this->selectedId);

        // Verifica si se encontró la venta
        if ($sale) {
            // Asigna el nuevo estado al modelo de venta
            $sale->status = $this->selectedStatus; // Asumiendo que 'type' contiene el nuevo estado
            $sale->updated_at = now();   //Fecha de actualizacion
            $sale->mod_id = auth()->user()->name; //Nombre del usuario quien lo actualizo

            // Guarda el cambio en la base de datos
            $sale->save();

            // Puedes emitir un evento o realizar alguna acción adicional si es necesario
            $this->resetUI();
            $this->dispatch('venta-updated', 'La venta ha sido actualizada correctamente');
        } else {
            $this->dispatch('sale-error', 'DEBE SELECCIONAR UN TIPO DE ESTADO');
            return;
            // Manejo si la venta no existe
            // Puedes emitir un mensaje de error o realizar alguna acción apropiada
        }
    }

    public function resetUI()
    {
        $this->type = '';
        $this->value = '';
        $this->resetErrorBag();
    }

    public function tipoReporte(){
        return ['VENTAS DE DIA', 'VENTAS POR FECHAS'];
    }
}
