<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;
use App\Services\ApiAuthService;
use Illuminate\Support\Facades\Http;

class ApiIntegration extends Component
{
    public $selected_id;
    public $isModalOpen = false;
    public $datos = [];
    protected $apiAuthService;
    public $facturas;
    public $currentModal = '';
    public $customer = [];
    public $items = [];

    public function mount(ApiAuthService $apiAuthService)
    {
        if ($apiAuthService) {
            $this->apiAuthService = $apiAuthService;
        } else {
            throw new \Exception('El servicio ApiAuthService no está disponible11.');
        }
        try {
            // Solo llamar a show() después de que el servicio se haya configurado
            $this->facturas = $this->show();
        } catch (\Exception $e) {
            //\Log::error('Error al obtener facturas: ' . $e->getMessage());
            //session()->flash('error', 'Error al obtener las facturas.');
            $this->dispatch('noty-api-error', type: 'ERROR', name: 'al visualizar las facturas', details: $response->body());
        }
    }

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
        $this->resetUI();
        $this->resetValidation();
    }

    public function crear($modal = 'crear')
    {
        $this->openModal($modal);
    }

    public function validar($modal = 'validar')
    {
        $this->openModal($modal);
    }

    public function store()
    {
        $this->apiAuthService = app(ApiAuthService::class);
        if ($this->apiAuthService) {
            $token = $this->apiAuthService->getAccessToken();
            //dd($token);
            if ($token) {
                // Establecer valores predeterminados para `customer` y `items`
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
                    'municipality_id' => 980,
                ];

                $defaultItem = [
                    'code_reference' => '',
                    'name' => '',
                    'quantity' => 0,
                    'discount_rate' => 20.00,
                    'price' => 0.00,
                    'tax_rate' => 19.00,
                    'unit_measure_id' => 70,
                    'standard_code_id' => 1,
                    'is_excluded' => 0,
                    'tribute_id' => 1,
                    'withholding_taxes' => [],
                ];

                // Rellenar datos faltantes con valores predeterminados
                $this->customer = array_merge($defaultCustomer, $this->customer);

                foreach ($this->items as &$item) {
                    $item = array_merge($defaultItem, $item);
                }

                // Construir la factura
                $datosFactura = [
                    "numbering_range_id" => 8,
                    "reference_code" => "12345931AT",
                    "observation" => "Esta es la descripción default",
                    "payment_method_code" => 10,
                    "customer" => $this->customer,
                    "items" => $this->items,
                ];

                // Realizar la solicitud POST a la API
                $response = Http::withToken($token)->post('https://api-sandbox.factus.com.co/v1/bills/store', $datosFactura);

                if ($response->successful()) {
                    //session()->flash('message', 'Factura creada exitosamente.');
                    $this->dispatch('noty-done', type: 'success', message: 'Documento creado con éxito');
                } else {
                    //session()->flash('error', 'Error al crear la factura: ' . $response->body());
                    $this->dispatch('noty-api-error', type: 'ERROR', name: 'al crear la factura', details: $response->body());
                    //$this->dispatch('noty-done', type: 'info', message: 'Error al crear la factura: ' . $response->body());
                }
            } else {
                session()->flash('error', 'Token no válido.');
            }
        } else {
            session()->flash('error', 'El servicio de autenticación no está disponible.');
        }
    }

    public function show()
    {
        $this->apiAuthService = app(ApiAuthService::class);
        //dd($this->apiAuthService);
        // Verificar si el servicio de autenticación está disponible antes de realizar cualquier acción
        if (!$this->apiAuthService) {
            session()->flash('error', 'El servicio de autenticación no está disponible...');
            return;
        }
        $token = $this->apiAuthService->getAccessToken();
        //dd($token);

        if ($token) {
            $response = Http::withToken($token)->get('https://api-sandbox.factus.com.co/v1/bills');

            if ($response->successful()) {
                $this->datos = $this->formatearDatos($response->json());
            } else {
                //session()->flash('error', 'No se pudieron obtener los datos.');
                $this->dispatch('noty-api-error', type: 'ERROR', name: 'al visualizar las facturas', details: $response->body());
            }
        } else {
            session()->flash('error', 'Token no válido.');
        }

    }

    private function formatearDatos($datos)
    {
        // Accedemos a los datos relevantes y los formateamos
        $formateados = [];

        if (isset($datos['data']['data'])) {
            foreach ($datos['data']['data'] as $item) {
                //dd($item);

                try {
                    // Si la fecha no es válida, utilizar un valor por defecto
                    $fecha = \Carbon\Carbon::createFromFormat('d-m-Y h:i:s A', $item['created_at']);
                    $createdAt = $fecha->format('Y-m-d H:i:s');
                } catch (\Exception $e) {
                    // Si hay un error en el formato de fecha, asigna un valor por defecto o vacío
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

// Obtener el nombre del estado (por ejemplo, 1 -> 'Activo')
    private function getStatusName($status)
    {
        $statuses = [
            1 => 'Enviado',
            0 => 'No enviado',
        ];

        return $statuses[$status] ?? 'Desconocido';
    }

    public function resetUI()
    {
        $this->resetErrorBag();
    }

}
