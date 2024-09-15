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
    public $totalPrice, $itemsQuantity, $change, $tipoPago, $vendedorSeleccionado;
    public $vendedores = [];
    public $valores = [];
    public $quantityInputs = [];
    public $efectivo = 0.00;
    public $revisionVenta = false;
    public $nextSaleNumber;

    public function mount()
    {
        //$this->efectivo = number_format($this->efectivo, 2);
        $this->efectivo = 0000.00;
        $this->change = 0;
        $this->tipoPago = null;
        $this->updateTotalPrice();
        $this->itemsQuantity = Cart::count(); //cantidad de articulos en el carrito
        $this->vendedores = $this->ListaVendedores();
        $this->valores = $this->ListaPagos();
        $this->updateQuantityProducts();
        $this->getNextSaleNumber();
    }

    public function render()
    {
        if ($this->revisionVenta) {

            return view('livewire.pos.revision_venta', [
                'denominations' => Denomination::orderBy('value', 'desc')->get(),
                'cart' => Cart::content(),
            ])
                ->extends('layouts.app')
                ->section('content');
        } else {
            return view('livewire.pos.components', [
                'denominations' => Denomination::orderBy('value', 'desc')->get(),
                'cart' => Cart::content(),
            ])
                ->extends('layouts.app')
                ->section('content');
        }
    }

    public function ListaPagos()
    {
        $reportTypes = [
            (object)['id' => '1', 'name' => 'PAGADO'],
            (object)['id' => '2', 'name' => 'PENDIENTE'],
            //(object)['id' => '3', 'name' => 'CANCELADO'],
        ];

        return $reportTypes;

    }

    public function translateTipoPago($tipoPago)
    {
        $traslation = [
            'PAGADO' => 'PAID',
            'PENDIENTE' => 'PENDING',
            'CANCELADO' => 'CANCELLED',
        ];
        return $traslation[$tipoPago] ?? $tipoPago;
    }

    public function obtenerTipoPago($tipoPagoId) //Obtiene el 'TIPO DE PAGO' y lo muestra en la vista de IMPRESION
    {
        $reportTypes = $this->ListaPagos();

        foreach ($reportTypes as $reportType) {
            if ($reportType->id == $tipoPagoId) {
                return $reportType->name;
            }
        }

        return 'Tipo de pago no encontrado';
    }

    public function ListaVendedores()

    {
        $sellerProfiles = User::where('profile', 'seller')
            ->pluck('name', 'id')
            ->map(function ($name, $id) {
                return (object)['id' => $id, 'name' => $name];
            })
            ->values()
            ->toArray();

        return $sellerProfiles;
    }

    public function obtenerNombreVendedor($id) //Obtiene el 'NOMBRE DE VENDEDOR' y lo muestra en la vista de IMPRESION
    {
        $vendedor = User::find($id);
        return $vendedor ? $vendedor->name : 'No disponible';
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
        if ($value == 0) {
            $value = $this->totalPrice - $this->efectivo;
        }
        $this->efectivo += (float)$value;
        $this->change = ($this->efectivo - $this->totalPrice);
    }

    public function getNextSaleNumber()
    {
        // Obtener el último número de venta
        $lastSale = Sale::latest('id')->first();
        $lastSaleNumber = $lastSale ? $lastSale->id : 0;
        // Incrementar el número para la próxima venta
        $this->nextSaleNumber = $lastSaleNumber + 1;
    }

    protected $listeners = [
        'scan-code' => 'scanCode',
        'deleteRow' => 'removeItem',
        'deleteAllConfirmed' => 'deleteAllConfirmedCart',
        'clearChange' => 'clearChange',
        //'redirectPos' => 'redirectToPos'
    ];

    public function scanCode($barcode, $cant = 1)
    {
        $product = Product::where('barcode', $barcode)->first();

        if (!$product) {
            $this->dispatch('showNotification', 'El producto con código ' . $barcode . ' no existe o aún no está registrado', 'dark');
            return;
        }

        $cartItem = $this->getCartItem($product->id);

        if ($cartItem) {
            $this->increaseQty($product->id, $cant);
            return;
        }

        if ($product->stock < $cant) {
            $this->dispatch('showNotification', 'Stock insuficiente para realizar la operación', 'warning');
            return;
        }

        Cart::add($product->id, $product->name, $cant, $product->price, ['image' => $product->image]);
        $this->updateCartSummary();
        $this->updateTotalPrice();
        $this->dispatch('showNotification', 'Producto ' . $product->name . ' agregado exitosamente', 'success');

    }

    public function updateCartSummary()
    {
        // Actualiza el precio total antes de cualquier cálculo
        $this->updateTotalPrice();

        // Actualiza la cantidad total de artículos en el carrito
        $this->itemsQuantity = Cart::count();

        // Actualiza la cantidad de cada producto en el carrito
        $this->updateQuantityProducts();

        // Calcula el cambio
        $this->change = (float)$this->efectivo - (float)$this->totalPrice;

    }

    public function updateQuantityProducts()
    {
        foreach (Cart::content() as $item) {
            $this->quantityInputs[$item->id] = $item->qty;
        }
        return $this->totalPrice;
    }

    public function updateTotalPrice()
    {
        $this->totalPrice = 0; // Reset the total price before calculation

        foreach (Cart::content() as $item) {
            $this->totalPrice += $item->price * $item->qty;
        }
    }

    protected function getCartItem($productId)
    {
        $cartItem = Cart::search(function ($cartItem, $rowId) use ($productId) {
            return $cartItem->id === $productId;
        })->first();
        if (!$cartItem) {
            $this->dispatch('showNotification', 'Producto no encontrado en el carrito', 'warning');
            return null;
        }
        return $cartItem;
    }

    public function increaseQty($productId, $cant = 1)
    {
        //dd($productId);
        $product = Product::find($productId);
        $cartItem = $this->getCartItem($productId);
        if (!$cartItem) return; // Termina si el producto no fue encontrado

        if ($cartItem) {
            $newQty = $cartItem->qty + $cant;
            if ($product->stock < $newQty) {
                $this->dispatch('showNotification', 'Stock insuficiente para realizar la operación', 'warning');
                return;
            }
            Cart::update($cartItem->rowId, $newQty);
            $this->dispatch('showNotification', 'Cantidad de productos ' . $cartItem->name . ' actualizada', 'info');
        } else {
            Cart::add($product->id, $product->name, $cant, $product->price, ['image' => $product->image]);
            $this->dispatch('showNotification', 'Producto ' . $cartItem->name . ' agregado Exitosamente', 'success');
        }
        $this->updateCartSummary();
        $this->updateTotalPrice();
    }

    public function decreaseQty($productId, $cant = 1)
    {
        $cartItem = $this->getCartItem($productId);
        if (!$cartItem) return; // Termina si el producto no fue encontrado

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
            $this->dispatch('showNotification', 'Cantidad de productos ' . $cartItem->name . ' actualizada', 'info');
        }

        $this->updateCartSummary(); // Actualizar resumen del carrito
        $this->updateTotalPrice();

    }

    public function updateQty($id, $newQty)
    {
        $productId = (int)$id;

        $cartItem = $this->getCartItem($productId);
        if (!$cartItem) return; // Termina si el producto no fue encontrado

        if ($newQty <= 0) {
            Cart::remove($cartItem->rowId);
            $this->dispatch('showNotification', 'Producto eliminado del carrito', 'error');
        } else {
            Cart::update($cartItem->rowId, $newQty);
            $this->dispatch('showNotification', 'Cantidad actualizada Exitosamente', 'info');
        }

        $this->updateCartSummary();
        $this->updateTotalPrice();

    }

    public function removeItem($id)
    {
        // Buscar el producto en el carrito por su ID
        $productId = (int)$id; // Asumiendo que $id es el ID del producto que quieres eliminar

        $cartItem = $this->getCartItem($productId);
        if (!$cartItem) return; // Termina si el producto no fue encontrado

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
                $this->dispatch('showNotification', 'Error al eliminar producto del carrito', 'warning');
            }
        } else {
            // Manejar el caso donde el producto no se encuentra en el carrito
            $this->dispatch('showNotification', 'El producto no está en el carrito', 'dark');
        }
    }

    public function clearCart()
    {

        //const $total = parseFloat(document.getElementById('hiddenTotal').value)
        if ($this->totalPrice <= 0) {
            $this->dispatch('showNotification', 'Agregar productos al carrito', 'warning');
            return;
        } else {
            $this->dispatch('confirmClearCart', type: 'Eliminar', name: 'PRODUCTOS');
        }

    }

    public function deleteAllConfirmedCart()
    {
        Cart::destroy();
        $this->efectivo = 0;
        $this->change = 0;
        $this->updateTotalPrice();
        $this->itemsQuantity = Cart::count();
        $this->tipoPago = 0;
        $this->vendedorSeleccionado = 0;
        $this->dispatch('showNotification', 'Se eliminaron Todos los Productos del carrito', 'error');
    }


    public function saveSale()
    {

        if ($this->totalPrice <= 0) {
            $this->dispatch('showNotification', 'Agregar Productos a la venta', 'dark');
            return;
        }
        if ($this->efectivo <= 0) {
            $this->dispatch('showNotification', 'Debes ingresar el EFECTIVO ', 'warning');
            return;
        }
        if ($this->totalPrice > $this->efectivo) {
            $this->dispatch('showNotification', 'El efectivo debe ser MAYOR o IGUAL al total', 'warning');
            return;
        }
        if (isset($this->tipoPago) && !empty($this->tipoPago)) {
            $tipoPagoSeleccionado = $this->translateTipoPago($this->tipoPago);
        } else {
            $this->dispatch('showNotification', 'Debe seleccionar el TIPO DE PAGO que utilizará', 'warning');
            return;
        }
        if (isset($this->vendedorSeleccionado)) {
            $vendedorAgregado = $this->vendedorSeleccionado;
            if ($vendedorAgregado == 0) {
                $vendedorAgregado = 'Cliente Final';
            }
        } else {
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
                'seller' => $vendedorAgregado,
                'user_id' => Auth()->user()->id
            ]);

            if ($sale) {
                $items = Cart::content();
                //dd($items);
                foreach ($items as $item) {
                    SaleDetail::create([
                        'price' => $item->price,
                        'quantity' => $item->qty,
                        'product_id' => $item->id,
                        'sale_id' => $sale->id,
                    ]);

                    $product = Product::find($item->id);
                    $product->stock = $product->stock - $item->quantity;
                    $product->save();
                }

            }

            DB::commit();

            Cart::destroy();
            $this->efectivo = 0;
            $this->change = 0;
            $this->updateTotalPrice();
            $this->itemsQuantity = Cart::count();
            $this->tipoPago = 0;
            $this->vendedorSeleccionado = 0;
            $this->getNextSaleNumber();
            $this->dispatch('noty-done', type: 'success', message: 'Venta realizada con éxito');
            //return redirect()->to('pos');
            //$this->emit('print-ticket', $sale->id);

        } catch (Exception $e) {
            DB::rollback();
            //$this->dispatch('sale-error', $e->getMessage());
            $this->dispatch('showNotification', $e->getMessage(), 'error');
        }
    }

}
