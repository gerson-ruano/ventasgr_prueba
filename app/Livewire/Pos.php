<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Sale;
use App\Models\User;
use Exception;
use App\Models\Denomination;
use App\Models\Product;
use App\Models\SaleDetail;
use DB;
use Gloudemans\Shoppingcart\Facades\Cart;

class Pos extends Component
{
    public $total, $itemsQuantity, $efectivo, $change, $tipoPago, $vendedorSeleccionado;
    public $vendedores = [];
    public $revisionVenta = false;


    public function mount()
    {
        $this->efectivo = number_format($this->efectivo, 2);
        $this->change = 0;
        $this->total = Cart::total();
        $this->itemsQuantity = Cart::count();
        $this->vendedores = User::where('profile', 'Seller')->pluck('name');
    }

    public function render()
    {

        $valores = $this->EstadoDePago();
        if ($this->revisionVenta) {

        return view('livewire.pos.revision_venta', [
            'denominations' => Denomination::orderBy('value','desc')->get(),
            'cart' => Cart::content()->sortBy('name'),
            //'cart' => Cart::content(),
            'valores' => $valores,
            ])
        ->extends('layouts.app')
        ->section('content');
        } else {
        return view('livewire.pos.components', [
            'denominations' => Denomination::orderBy('value','desc')->get(),
            'cart' => Cart::content()->sortBy('name'),
            'valores' => $valores,
        ])
        ->extends('layouts.app')
        ->section('content');
        }
    }

    public function EstadoDePago()
    {
    //return Sale::pluck('status')->unique()->toArray();
    
    $valores = ['PAID', 'PENDING', 'CANCELLED'];
    return $valores;
    }

    public function revisarVenta() //Indica que vista utiliza para el index
    {
        $this->revisionVenta = true;
    }

    public function clearChange()
    {
        $this->efectivo = 0;
        $this->change = 0;
    }

    public function ACash($value)
    {
        $this->efectivo += ($value == 0 ? $this->total : (float)$value);
        $this->change = ($this->efectivo - $this->total);
    }

    protected $listeners =[
        'scan-code' => 'scanCode',
        'removeitem' => 'removeItem',
        'clearcart' => 'clearCart',
        'savesale' => 'saveSale',
        'clearChange' => 'clearChange',
        'redirectPos' => 'redirectToPos'
    ];

    
    public function scanCode($barcode, $cant = 1)
    //public function scanCode($barcode)
    {
        //dd($barcode);
        $product = Product::where('barcode', $barcode)->first();

        if ($product == null || empty($product)) {
            $this->dispatch('showNotification', 'El producto no esta Registrado', 'warning');
        } else {
            if ($this->InCart($product->id)) {
                $this->increaseQty($product->id);
                return;
            }
            if ($product->stock < 1) {
                $this->dispatch('showNotification', 'Stock insuficiente para realizar la operación', 'warning');
                return;
            }

            Cart::add($product->id, $product->name, $product->price, $cant, $product->image);
            $this->total = Cart::total();
            $this->itemsQuantity = Cart::count();
            $this->change = ($this->efectivo - $this->total);

            $this->dispatch('showNotification', 'Producto Agregado exitosamente', 'success');
        }

    }

    public function InCart($productId)
    {
        $exist = Cart::get($productId);
        if($exist)
            return true;
        else
            return false;
    }

    public function increaseQty($productId, $cant = 1)
    {
        $title='';
        $product = Product::find($productId);
        $exist = Cart::get($productId);
        if($exist)
            $title = 'Cantidad Actualizada';
        else
            $title = 'Producto agregado';
        if($exist)
        {
            if($product->stock < ($cant + $exist->quantity))
            {
                $this->dispatch('showNotification', 'Stock insuficiente para realizar la operación', 'warning');
                return;
            }
        }

        Cart::add($product->id, $product->name, $product->price, $cant, $product->image);

        $this->total = Cart::total();
        $this->itemsQuantity = Cart::count();
        $this->change = ($this->efectivo - $this->total);
        $this->dispatch('scan-ok','Cantidad Actualizada');
    }

    public function updateQty($productId, $cant = 1)
    {
        $title='';
        $product = Product::find($productId);
        $exist = Cart::get($productId);
        if($exist)
            $title = 'Cantidad Actualizada';
        else
            $title = 'Producto agregado';
        if($exist)
        {
            if($product->stock < $cant)
            {
                $this->dispatch('showNotification', 'Stock insuficiente para realizar la operación', 'warning');
                return;
            }
        }

        $this->removeItem($productId);

        if($cant > 0)
        {
            Cart::add($product->id, $product->name, $product->price, $cant, $product->image);

            $this->total = Cart::total();
            $this->itemsQuantity = Cart::count();

            $this->dispatch('scan-ok', $title);
        }

        //definir else para notificar al usuario que debe ser mayor a 0
    }

    public function removeItem($productId)
    {
        //dd("Evento recibido con exito");
        Cart::remove($productId);
        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();
        $this->dispatch('scan-ok', 'Producto Eliminado');
    }

    public function decreaseQty($productId)
    {
        $item = Cart::get($productId);
        Cart::remove($productId);

        $newQty = ($item->quantity) - 1;
        if($newQty > 0)

        if (isset($item->attributes[0])) {
            Cart::add($item->id, $item->name, $item->price, $newQty, $item->attributes[0]);
        } else {
            Cart::add($item->id, $item->name, $item->price, $newQty);
        }

        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();
        $this->change = ($this->efectivo - $this->total); //actualiza la cantidad de CAMBIO O CHANGE
        $this->dispatch('scan-ok', 'Cantidad Actualizada');

    }

    public function clearCart()
    {
        //dd("recibiendo evento");
        Cart::clear();
        $this->efectivo = 0;
        $this->change = 0;
        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();
        $this->tipoPago = 0;
        $this->vendedorSeleccionado = 0;
        $this->dispatch('scan-ok', 'Carrito vacio');
    }

    public function saveSale()
    {

        if($this->total <=0)
        {
            $this->dispatch('sale-error','AGREGA PRODUCTOS A LA VENTA');
            return;
        }
        if($this->efectivo <=0)
        {
            $this->dispatch('sale-error','INGRESA EL EFECTIVO');
            return;
        }
        if($this->total > $this->efectivo)
        {
            $this->dispatch('sale-error','EL EFECTIVO DEBE SER MAYOR O IGUAL AL TOTAL');
            return;
        }
        if($this->tipoPago > 0)
        {
            $tipoPagoSeleccionado = $this->tipoPago;
        }
        if($this->tipoPago == 0)
        {
            $this->dispatch('sale-error','DEBE SELECCIONAR UN TIPO DE PAGO');
            return;
        }
        if(isset($this->vendedorSeleccionado)) {
            $vendedorAgregado = $this->vendedorSeleccionado;
            if($vendedorAgregado == 0){
                $vendedorAgregado = 'Cliente Final';
            }
        }else{
            $vendedorAgregado = 'Cliente Final';

            //$this->emit('sale-error','DEBE SELECCIONAR UN VENDEDOR O CLIENTE FINAL');
            //return;
        }

        DB::beginTransaction();

        try {
            $sale = Sale::create([
                'total' => $this->total,
                'items' => $this->itemsQuantity,
                'cash' => $this->efectivo,
                'status' => $tipoPagoSeleccionado,
                'change' => $this->change,
                'vendedor' => $vendedorAgregado,
                'user_id' => Auth()->user()->id
            ]);

            if($sale)
            {
                $items = Cart::getContent();
                //dd($items);
                foreach ($items as $item){
                    SaleDetail::create([
                        'price' => $item->price,
                        'quantity' => $item->quantity,
                        'product_id' => $item->id,
                        'sale_id' => $sale->id,
                    ]);

                    $product = Product::find($item->id);
                    $product->stock = $product->stock - $item->quantity;
                    $product->save();
                }

            }

            DB::commit();

            Cart::clear();
            $this->efectivo =0;
            $this->change =0;
            $this->total = Cart::getTotal();
            $this->itemsQuantity = Cart::getTotalQuantity();
            $this->tipoPago = 0;
            $this->vendedorSeleccionado = 0;
            $this->dispatch('sale-ok','Venta registrada con exito');
            //return redirect()->to('pos');
            //$this->emit('print-ticket', $sale->id);

        }catch (Exception $e){
            DB::rollback();
            $this->dispatch('sale-error', $e->getMessage());
        }
    }

}