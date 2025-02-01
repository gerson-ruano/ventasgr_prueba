<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;
use App\Services\ApiAuthService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;


class ApiIntegration extends Component
{
    public $baseUrl;
    protected $apiAuthService;
    public $selected_id, $reference_code, $observation, $municipality_id, $document_number, $payment_method_code, $documentos;
    public $isModalOpen = false;
    public $currentModal = '';
    public $datos = [];
    public $pagination = [];
    public $customer = [];
    public $items = [];
    public $factura = [];
    public $municipalitys = [];
    public $searchTerm = '';


    public function mount(ApiAuthService $apiAuthService)
    {
        if ($apiAuthService) {
            $this->apiAuthService = $apiAuthService;
            $this->baseUrl = config('factus.base_url');
        } else {
            throw new \Exception('El servicio ApiAuthService no está disponible.');
        }
        try {
            $this->documentos = $this->index();
        } catch (\Exception $e) {
            $this->dispatch('noty-api-error', [
                'type' => 'ERROR',
                'name' => 'al visualizar las facturas',
                'details' => $e->getMessage()
            ]);
        }

        $jsonPath = storage_path('app/data/municipalitys.json');

        $this->municipalitys = Cache::remember('municipalitys', 3600, function () use ($jsonPath) {
            if (!file_exists($jsonPath)) {
                abort(404, "El archivo JSON no fue encontrado.");
            }

            $jsonContent = file_get_contents($jsonPath);
            if ($jsonContent === false) {
                abort(500, "No se pudo leer el archivo JSON.");
            }

            $muni = json_decode($jsonContent, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                abort(500, "Error al decodificar JSON: " . json_last_error_msg());
            }
            return $muni['data'] ?? [];
        });
    }

    protected $rules = [
        'reference_code' => 'required|string|max:255',
        'observation' => 'nullable|string|max:500',
        'payment_method_code' => 'required|integer',
        'customer.identification' => 'required|string|max:50',
        'customer.names' => 'required|string|max:255',
        'customer.municipality_id' => 'required|string|max:255',
        'customer.address' => 'required|string|max:255',
        'customer.email' => 'nullable|email|max:255',
        'customer.phone' => 'nullable|string|max:20',
        'items.0.code_reference' => 'required|string|max:255',
        'items.0.name' => 'required|string|max:255',
        'items.0.quantity' => 'required|integer|min:1',
        'items.0.price' => 'required|numeric|min:0',
    ];

    protected $messages = [
        'reference_code.required' => 'Codigo de Ref. de Factura requerido',
        'payment_method_code.required' => 'Metodo de Pago requerido',
        'customer.identification.required' => 'Identificacion requerido',
        'customer.names.required' => 'Nombre requerido',
        'customer.municipality_id.required' => 'Municipio requerido',
        'customer.address.required' => 'Dirección requerido',
        'customer.email.required' => 'Correo electronico requerido',
        'customer.phone.required' => 'Telefono requerido',
        'item.0.quantity.min' => 'La cantidad del producto tiene que tener por lo menos 1',
        'items.0.code_reference.required' => 'El codigo de Ref. de producto es requerido',
        'price.required' => 'El precio es requerido',
        'items.0.name.required' => 'El nombre del producto es requerido',
        'items.0.quantity.required' => 'Ingresa al menos un producto',
        'items.0.price.required' => 'El precio es requerido',
    ];

    public function render()
    {
        return view('livewire.api.api-integration')
            ->extends('layouts.app')
            ->section('content');
    }

    public function openModal($modal)
    {
        $this->isModalOpen = true;
        $this->currentModal = $modal;

    }

    #[On('noty-done')]
    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->currentModal = '';
        $this->document_number = '';
        $this->observation = '';
        $this->reference_code = '';
        $this->payment_method_code = '';
        $this->factura = [];
        $this->customer = [];
        $this->items = [];
        $this->resetUI();
        $this->resetValidation();
    }

    public function crear($modal = 'add')
    {
        $this->openModal($modal);
    }

    public function validar($modal = 'validar')
    {
        $this->openModal($modal);
    }

    public function index($page = 1)
    {
        $this->apiAuthService = app(ApiAuthService::class);
        if (!$this->apiAuthService) {
            session()->flash('error', 'El servicio de autenticación no está disponible...');
            return;
        }

        $token = $this->apiAuthService->getAccessToken();
        if ($token) {

            $params = [
                'page' => $page,
            ];

            if (!empty($this->searchTerm)) {
                $params['filter'] = $this->searchTerm;
            }

            $url = $this->baseUrl . 'bills?';
            $response = Http::withToken($token)->get($url, $params);
            if ($response->successful()) {
                $data = $response->json();
                $this->datos = $data['data']['data'] ?? [];
                $this->pagination = $data['data']['pagination']['links'] ?? [];
            } else {
                $this->dispatch('noty-api-error', type: 'ERROR', name: 'al visualizar las facturas', details: $response->body());
            }
        } else {
            session()->flash('error', 'Token no válido.');
        }
    }

    public function store()
    {
        $this->validate();
        $this->apiAuthService = app(ApiAuthService::class);
        if ($this->apiAuthService) {
            $token = $this->apiAuthService->getAccessToken();
            if ($token) {

                $defaultCustomer = [
                    'identification' => '',
                    'dv' => 3,
                    'names' => '',
                    'address' => '',
                    'email' => '',
                    'phone' => '',
                    'legal_organization_document_id' => 3,
                    'tribute_id' => 21,
                    'identification_document_id' => 3,
                    'municipality_id' => '',];
                $defaultItem = [
                    'code_reference' => '',
                    'name' => '',
                    'quantity' => 0,
                    'discount_rate' => 20.00,
                    'price' => 0,
                    'tax_rate' => 19.00,
                    'unit_measure_id' => 70,
                    'standard_code_id' => 1,
                    'is_excluded' => 0,
                    'tribute_id' => 1,
                    'withholding_taxes' => [],
                ];

                if (!is_array($this->customer)) {
                    throw new \Exception('El atributo customer no es un array.');
                }
                $this->customer = array_merge($defaultCustomer, $this->customer);
                foreach ($this->items as $index => &$item) {
                    if (!is_array($item)) {
                        throw new \Exception("El elemento items[$index] no es un array.");
                    }
                    $item = array_merge($defaultItem, $item);
                }

                $datosFactura = [
                    "numbering_range_id" => 8,
                    "reference_code" => $this->reference_code,
                    "observation" => $this->observation,
                    "payment_method_code" => $this->payment_method_code,
                    "customer" => $this->customer,
                    "items" => $this->items,
                ];

                //dd($datosFactura);

                $url = $this->baseUrl . 'bills/validate';
                $response = Http::withToken($token)->post($url, $datosFactura);
                if ($response->successful()) {
                    $this->dispatch('noty-done', type: 'success', message: 'Documento creado con éxito');
                } else {
                    $this->dispatch('noty-api-error', type: 'ERROR', name: 'al crear la factura', details: $response->body());
                }
            } else {
                session()->flash('error', 'Token no válido.');
            }
        } else {
            session()->flash('error', 'El servicio de autenticación no está disponible.');
        }
    }


    public function validates($number, $modal = 'view')
    {
        $documentNumber = $number;
        if (empty($documentNumber)) {
            session()->flash('error', 'Debe ingresar un número de documento para validar.');
            return;
        }

        $this->apiAuthService = app(ApiAuthService::class);
        if (!$this->apiAuthService) {
            session()->flash('error', 'El servicio de autenticación no está disponible...');
            return;
        }
        $token = $this->apiAuthService->getAccessToken();
        if ($token) {
            $url = $this->baseUrl . "bills/send/{$documentNumber}";
            $response = Http::withToken($token)->post($url);
            if ($response->successful()) {
                $this->dispatch('noty-done', type: 'success', message: 'Validacion creada con éxito');
                return $response->json();
            } else {
                $this->dispatch('noty-api-error', type: 'ERROR', name: 'validación de factura', details: $response->body());
            }
        } else {
            session()->flash('error', 'Token no válido.');
        }
    }

    public function show($number, $modal = 'view')
    {
        $documentNumber = $number;
        if (empty($documentNumber)) {
            session()->flash('error', 'Debe ingresar un número de documento para validar.');
            return;
        }
        $this->apiAuthService = app(ApiAuthService::class);
        if (!$this->apiAuthService) {
            session()->flash('error', 'El servicio de autenticación no está disponible...');
            return;
        }

        $token = $this->apiAuthService->getAccessToken();
        if ($token) {
            $url = $this->baseUrl . "bills/show/{$documentNumber}";
            $response = Http::withToken($token)->get($url); // Cambiar a POST si es necesario
            if ($response->successful()) {
                $factura = $response->json();
                if (!empty($factura['data'])) {
                    $this->factura = $factura['data'];
                    $this->dispatch('showNotification', 'Factura encontrada con exito', 'success');
                    $this->isModalOpen = true;
                    $this->openModal($modal);
                    return $this->factura;
                } else {
                    $this->dispatch('noty-api-error', type: 'ERROR', name: 'validación de factura', details: 'No se encontraron datos para este documento.');
                }
            } else {
                $this->dispatch('noty-api-error', type: 'ERROR', name: 'validación de factura', details: $response->body());
            }
        } else {
            session()->flash('error', 'Token no válido.');
        }
    }

    private function formatearDatos($datos)
    {

        $formateados = [];

        if (isset($datos['data']['data'])) {
            foreach ($datos['data']['data'] as $item) {

                try {
                    $fecha = \Carbon\Carbon::createFromFormat('d-m-Y h:i:s A', $item['created_at']);
                    $createdAt = $fecha->format('Y-m-d H:i:s');
                } catch (\Exception $e) {
                    $createdAt = 'No validado en DIAN';
                }
                $referenceCode = isset($item['reference_code']) && !empty($item['reference_code'])
                    ? $item['reference_code']
                    : 'sin codigo';

                $formateados[] = [
                    'id' => $item['id'],
                    'number' => $item['number'],
                    'client_name' => $item['api_client_name'],
                    'reference_code' => $referenceCode,
                    'identification' => $item['identification'],
                    'total' => number_format($item['total'], 2), // Formatear el total a dos decimales
                    'status' => $this->getStatusName($item['status']),
                    'created_at' => $createdAt,
                    'payment_form' => $item['payment_form']['name'],
                ];
            }
        }
        return $formateados;
    }

    public function resetUI()
    {
        $this->resetErrorBag();
    }
}
