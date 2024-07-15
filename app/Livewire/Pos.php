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
    public $totalPrice, $itemsQuantity, $efectivo, $change, $tipoPago, $vendedorSeleccionado;
    public $vendedores = [];
    public $revisionVenta = false;
    public $quantityInputs = [];


    public function mount()
    {
        $this->efectivo = number_format($this->efectivo, 2);
        $this->change = 0;
        $this->updateTotalPrice();
        
        //dd($this->tot);
        //dd($this->totalPrice);
        $this->itemsQuantity = Cart::count(); //cantidad de articulos en el carrito
        $this->vendedores = User::where('profile', 'Seller')->pluck('name');
        $this->updateQuantityInputs();
    }

    public function render()
    {

        $valores = $this->EstadoDePago();
        if ($this->revisionVenta) {

        return view('livewire.pos.revision_venta', [
            'denominations' => Denomination::orderBy('value','desc')->get(),
            'cart' => Cart::content(),
            //'cart' => Cart::content(),
            'valores' => $valores,
            ])
        ->extends('layouts.app')
        ->section('content');
        } else {
        return view('livewire.pos.components', [
            'denominations' => Denomination::orderBy('value','desc')->get(),
            'cart' => Cart::content(),
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
        'deleteRow' => 'removeItem',
        'clearcart' => 'clearCart',
        'savesale' => 'saveSale',
        'clearChange' => 'clearChange',
        'redirectPos' => 'redirectToPos'
    ];

    
    public function scanCode($barcode, $cant = 1)
    {
        //dd($barcode);
        $product = Product::where('barcode', $barcode)->first();
        if ($product == null || empty($product)) {
            $this->dispatch('showNotification', 'El producto con codigo ' . $barcode . ' no existe o aun no esta Registrado', 'warning');
        } else {
            if ($this->InCart($product->id)) {
                $this->increaseQty($product->id, $cant);
                return;
            }
            if ($product->stock < $cant) {
                $this->dispatch('showNotification', 'Stock insuficiente para realizar la operación', 'warning');
                return;
            }

            Cart::add($product->id, $product->name, $cant, $product->price, ['image' => $product->image]);
            $this->updateCartSummary();
            $this->dispatch('showNotification', 'Producto ' . $product->name . ' agregado exitosamente', 'success');
        }

    }

    public function updateCartSummary()
    {
        $this->updateTotalPrice();
        $this->itemsQuantity = Cart::count();
        $this->updateQuantityInputs();
        
        $efectivo = is_numeric($this->efectivo) ? (float)$this->efectivo : 0;
        $totalPrice = is_numeric($this->totalPrice) ? (float)$this->totalPrice : 0;

        // Realizar la operación
        $this->change = $efectivo - $totalPrice;

    }

    public function updateQuantityInputs()
    {
        foreach (Cart::content() as $item) {
            $this->quantityInputs[$item->id] = $item->qty;
        }
        return $this->totalPrice;
    }

    public function updateTotalPrice()
{
    //$this->totalPrice = 0; // Reset the total price before calculation
    
    foreach (Cart::content() as $item) {
        $this->totalPrice += $item->price * $item->qty;
    }
    //dd($this->totalPrice);
}

    public function InCart($productId)
    {
        return Cart::search(function ($cartItem, $rowId) use ($productId) {
            return $cartItem->id === $productId;
        })->isNotEmpty();
    }

    public function increaseQty($productId, $cant = 1)
    {
        //dd($productId);
        $product = Product::find($productId);
        $cartItem = Cart::search(function ($cartItem, $rowId) use ($productId) {
            return $cartItem->id === $productId;
        })->first();
    
        if ($cartItem) {
            $newQty = $cartItem->qty + $cant;
            if ($product->stock < $newQty) {
                $this->dispatch('showNotification', 'Stock insuficiente para realizar la operación', 'warning');
                return;
            }
            Cart::update($cartItem->rowId, $newQty);
            $this->dispatch('showNotification', 'Cantidad de productos ' . $cartItem->name . ' actualizada', 'success');
        } else {
            Cart::add($product->id, $product->name, $cant, $product->price, ['image' => $product->image]);
            $this->dispatch('showNotification', 'Producto ' . $cartItem->name . ' agregado Exitosamente', 'success');
        }
        $this->updateCartSummary();
        $this->updateTotalPrice(); 
    }

    public function decreaseQty($productId, $cant = 1)
    {
        $cartItem = Cart::search(function ($cartItem, $rowId) use ($productId) {
            return $cartItem->id === $productId;
        })->first();
        //dd($cartItem);
    if (!$cartItem) {
        $this->dispatch('showNotification', 'Producto no encontrado en el carrito', 'error');
        return;
    }

    // Eliminar el producto del carrito si la cantidad es 0 o menos
    if ($cartItem->qty <= $cant) {
        Cart::remove($cartItem->rowId);
        $this->dispatch('showNotification', 'Producto ' . $cartItem->name . ' fue eliminado del carrito', 'error');
    } else {
        $newQty = $cartItem->qty - 1;
        // Actualizar la cantidad del producto en el carrito
        if (isset($cartItem->attributes[0])) {
            Cart::update($cartItem->rowId, $newQty, $cartItem->attributes[0]);
        } else {
            Cart::update($cartItem->rowId, $newQty);
        }
        $this->dispatch('showNotification', 'Cantidad de productos ' . $cartItem->name . ' actualizada', 'success');
    }

    $this->updateCartSummary(); // Actualizar resumen del carrito
    $this->updateTotalPrice();

    }

    public function updateQty($id, $newQty)
    {
        $productId = (int) $id;
        //dd($productId);


        $cartItem = Cart::search(function ($cartItem, $rowId) use ($productId) {
            return $cartItem->id === $productId;
        })->first();

        //$cartItem = Cart::get($productId);
        
        if (!$cartItem) {
            $this->dispatch('showNotification', 'Producto no encontrado en el carrito', 'error');
            return;
        }

        if ($newQty <= 0) {
            Cart::remove($cartItem->rowId);
            $this->dispatch('showNotification', 'Producto eliminado del carrito', 'error');
        } else {
            Cart::update($cartItem->rowId, $newQty);
            $this->dispatch('showNotification', 'Cantidad actualizada Exitosamente', 'success');
        }

        $this->updateCartSummary();
        $this->updateTotalPrice();

    }

    public function removeItem($id)
    {
    // Buscar el producto en el carrito por su ID
    $productId = (int) $id; // Asumiendo que $id es el ID del producto que quieres eliminar

    // Buscar el producto en el carrito por su ID
    $cartItem = Cart::search(function ($cartItem, $rowId) use ($productId) {
        return $cartItem->id === $productId;
    })->first();

    if ($cartItem) {
        try {
            // Eliminar el producto del carrito utilizando su rowId
            Cart::remove($cartItem->rowId);
            
            // Actualizar resúmenes u otros datos necesarios
            $this->updateCartSummary();
            $this->updateTotalPrice();
            
            // Mostrar notificación de éxito
            $this->dispatch('showNotification', 'Producto eliminado del carrito', 'error');
        } catch (\Exception $e) {
            // Manejar cualquier excepción que pueda ocurrir
            logger()->error("Error al eliminar producto del carrito: " . $e->getMessage());
            $this->dispatch('showNotification', 'Error al eliminar producto del carrito', 'error');
        }
    } else {
        // Manejar el caso donde el producto no se encuentra en el carrito
        $this->dispatch('showNotification', 'El producto no está en el carrito', 'warning');
    }
    }

    public function clearCart()
    {
        //dd("recibiendo evento");
        Cart::clear();
        $this->efectivo = 0;
        $this->change = 0;
        $this->total = Cart::total();
        $this->itemsQuantity = Cart::count();
        $this->tipoPago = 0;
        $this->vendedorSeleccionado = 0;
        $this->dispatch('showNotification', 'Productos eliminados del carrito', 'error');
    }

    public function saveSale()
    {

        if($this->totalPrice <=0)
        {
            $this->dispatch('sale-error','AGREGA PRODUCTOS A LA VENTA');
            return;
        }
        if($this->efectivo <=0)
        {
            $this->dispatch('sale-error','INGRESA EL EFECTIVO');
            return;
        }
        if($this->totalPrice > $this->efectivo)
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
                'total' => $this->totalPrice,
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