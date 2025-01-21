@if($isModalOpen)
    <div class="fixed inset-0 flex items-center justify-center z-50">
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50"></div>
        <div class="modal-container">
            @if($currentModal == 'crear')
                @include('livewire.api.modal_crear')
            @elseif($currentModal == 'validar')
                @include('livewire.api.modal_validar')
            @endif
        </div>
    </div>
@endif
