@if($isModalOpen)
    <div class="fixed inset-0 flex items-center justify-center z-50">
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50"></div>
            @if($currentModal == 'edit')
                @include('livewire.reports.partials.modal_edit')
            @elseif($currentModal == 'detail')
                @include('livewire.reports.partials.modal_detail')
            @endif
        </div>
    </div>
@endif

