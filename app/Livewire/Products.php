<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use App\Models\Category;
use App\Models\SaleDetail;
use Illuminate\Support\Facades\Storage;


class Products extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $name, $barcode, $cost, $price, $stock, $alerts, $categoryid, $search, $image, $imageUrl, $selected_id, $pageTitle, $componentName;
    public $isModalOpen = false;
    private $pagination = 7;

    protected $rules = [
        'name' => 'required|unique:products|min:3',
            'cost' => 'required',
            'barcode' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'alerts' => 'required',
            'categoryid' => 'required|not_in:Elegir'
    ];

    protected $messages = [
        'name.required' => 'Nombre del producto requerido',
            'name.unique' => 'Ya existe el nombre del producto',
            'name.min' => 'El nombre del producto tiene que tener por lo menos 3 caracteres',
            'barcode.required' => 'El codigo es requerido',
            'price.required' => 'El precio es requerido',
            'cost.required' => 'El costo es requerido',
            'stock.required' => 'El stock es requerido',
            'alerts.required' => 'Ingresa el valor minimo de existencia',
            'categoryid.required' => 'Elige una categoria',
            'categoryid.not_in' => 'Elige un nombre de categoria diferente a Elegir'
    ];

    public function paginationView()
    {
        return 'vendor.livewire.tailwind';
    }

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Productos';
        $this->categoryid = 'Elegir';
    }
    public function render()
    {
        $query = Product::orderBy('id', 'desc');

        // Aplicar filtro de búsqueda por nombre
        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        // Obtener productos paginados
        $products = $query->paginate($this->pagination);


        return view('livewire.products.components', [
            'products' => $products,
            'categories' => Category::orderBy('name','asc')->get()])
        ->extends('layouts.app')
        ->section('content');

    }

    public function openModal()
    {
        $this->isModalOpen = true;
    }

    #[On('noty-updated')]
    #[On('noty-added')]
    #[On('noty-deleted')]
    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetUI();
        $this->resetValidation();
    }
        public function store()
    {
        // Validación de reglas
        $this->validate();

        $product = Product::create([
            'name' => $this->name,
            'cost' => $this->cost,
            'price' => $this->price,
            'barcode' => $this->barcode,
            'stock' => $this->stock,
            'alerts' => $this->alerts,
            'category_id' => $this->categoryid,

        ]);

        if($this->image)
        {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/products', $customFileName);
            $product->image = $customFileName;
            $product->save();
        }

        $this->dispatch('noty-added', type: 'PRODUCTO', name: $product->name);
    }

    public function edit($id)
    {
        $product = Product::find($id, ['id', 'name', 'barcode','cost','price','stock','alerts','category_id','image']);
        $this->name = $product->name;
        $this->selected_id = $product->id;
        $this->barcode = $product->barcode;
        $this->cost = $product->cost;
        $this->price = $product->price;
        $this->stock = $product->stock;
        $this->alerts = $product->alerts;
        $this->categoryid = $product->category_id;
        $this->imageUrl = $product->image ? Storage::url('products/' . $product->image) : null;
        $this->image = null;

        $this->openModal();
    }

    public function update()
    {
        // Actualización de reglas de validación para la edición
        $this->rules['name'] = "required|min:3|unique:products,name,{$this->selected_id}";

        // Validación
        $this->validate();

        $product = Product::find($this->selected_id);

        $product->update([
            'name' => $this->name,
            'cost' => $this->cost,
            'price' => $this->price,
            'barcode' => $this->barcode,
            'stock' => $this->stock,
            'alerts' => $this->alerts,
            'category_id' => $this->categoryid,

        ]);

        if($this->image)
        {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/products', $customFileName);
            $imageTemp = $product->image; //image Temporal
            $product->image = $customFileName;
            $product->save();

            if($imageTemp !=null)
            {
                if(file_exists('storage/products/' . $imageTemp)){
                    unlink('storage/products/' . $imageTemp);
                }
            }
        }

        $this->dispatch('noty-updated', type: 'PRODUCTO', name: $product->name);
    }

    public function resetUI()
    {
        $this->name ='';
        $this->barcode ='';
        $this->cost ='';
        $this->cost ='';
        $this->price ='';
        $this->stock ='';
        $this->alerts ='';
        $this->imageUrl = null;
        $this->search ='';
        $this->categoryid ='Elegir';
        $this->image = null;
        $this->selected_id = 0;

    }

    protected $listeners = [
        'deleteRow' => 'destroy',
        'searchUpdated' => 'updateSearch',
    ];

    public function destroy($id)
    {

        /*$imageTemp = $product->image;
        $product->delete();

        if($imageTemp !=null){
            if(file_exists('storage/products/' . $imageTemp)){
                unlink('storage/products/' . $imageTemp);
            }
        }

        //$this->resetUI();
        $this->dispatch('noty-deleted', type: 'PRODUCTO', name: $product->name);
    }*/

        $product = Product::find($id);

        if ($product) {
            // Verificar si el producto tiene ventas asociadas
            $hasSales = SaleDetail::where('product_id', $id)->exists();

            if ($hasSales) {
                // Notificar que el producto tiene ventas asociadas
                $this->dispatch('noty-warning', type: 'PRODUCTO', name: $product->name);
                return;
            }

            // Si no tiene ventas, eliminar el producto
            $imageName = $product->image;
            $product->delete();

            if ($imageName != null && file_exists(storage_path('app/public/products/' . $imageName))) {
                unlink(storage_path('app/public/products/' . $imageName));
            }

            $this->dispatch('noty-deleted', type: 'PRODUCTO', name: $product->name);
        } else {
            $this->dispatch('noty-not-found', [
                'type' => 'PRODUCTO',
                'name' => $id,
            ]);
        }
    }

    public function updateSearch($search)
    {
        $this->search = $search;
    }
}
