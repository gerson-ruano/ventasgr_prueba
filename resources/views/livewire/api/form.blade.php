@if($isModalOpen)
    <div class="fixed inset-0 flex items-center justify-center z-50">
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50"></div>
        <div class="modal-container">
            @if($currentModal == 'add')
                @include('livewire.api.modal_add')
            @elseif($currentModal == 'view')
                @include('livewire.api.modal_view')
            @endif
        </div>
    </div>
@endif
