<?php

namespace App\Livewire;

use App\Models\Sale;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Carbon\Carbon;

class Cashout extends Component
{
    use WithPagination;

    public $fromDate, $toDate, $userid, $total, $items;
    public $details = [];
    private $pagination = 10;
    private $sales = [];
    public $isModalOpen = false;

    public function paginationView()
    {
        return 'vendor.livewire.tailwind';
    }

    public function mount()
    {
        $this->fromDate = null;
        $this->toDate = null;
        $this->userid = 0;
        $this->total = 0;
        $this->sales = [];
        $this->details = [];
    }

    public function render()
    {
        return view('livewire.cashout.components', [
            'users' => User::orderBy('name', 'asc')->get(),
            'sales' => $this->sales,
        ])
            ->extends('layouts.app')
            ->section('content');
    }

    public function openModal()
    {
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    public function Consultar()
    {
        $this->currentPage = 1;

        $fi= Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00';
        $ff= Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59';

        $this->sales = Sale::whereBetween('created_at', [$fi, $ff])
            ->where('status','Paid')
            ->where('user_id', $this->userid)
            //->get();
            ->paginate($this->pagination);

        $this->total = $this->sales ? $this->sales->sum('total') : 0;
        $this->items = $this->sales ? $this->sales->sum('items') : 0;
        $this->closeModal();
    }
    public function viewDetails(Sale $sale)
    {
        $fi= Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00';
        $ff= Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59';

        $this->details = Sale::join('sale_details as d', 'd.sale_id','sales.id')
            ->join('products as p', 'p.id','d.product_id')
            ->select('d.sale_id','p.name as product','d.quantity','d.price')
            ->whereBetween('sales.created_at', [$fi, $ff])
            ->where('sales.status', 'Paid')
            ->where('sales.user_id', $this->userid)
            ->where('sales.id', $sale->id)
            ->get();

        $this->openModal();
    }

    public function obtenerNombreVendedor($seller)
    {
        $vendedor = User::find($seller);
        return $vendedor ? $vendedor->name : 'C/F';
    }

}
