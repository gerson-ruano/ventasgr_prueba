<div>
    <!-- Header Section -->
    <div class="text-center">
        <h4 class="card-title">
            <b>{{ $componentName }} | {{ $pageTitle }}</b>
        </h4>
    </div>

    <!-- Tabs Section -->
    <div class="text-center">
        <button class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700"
            wire:click="$dispatch('openModal')">Open Modal</button>
    </div>

    <!-- Table Section -->
    <div class="overflow-x-auto bg-base-300">
        <table class="table ">
            <thead>
                <tr class="bg-primary-content dark:bg-gray-800">
                    <th class="text-base-800 dark:text-base-100">No.</th>
                    <th class="text-base-800 dark:text-base-100">Descripción</th>
                    <th class="text-gray-500 dark:text-base-100">Imagen</th>
                    <th class="text-gray-500 dark:text-base-100">Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $index => $category)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $category->name }}</td>
                    <td>
                        {{--<img src="{{ $category->imagen }}" alt="imagen de ejemplo" class="w-16 h-16
                        object-cover">--}}
                    </td>
                    <td class="text-center">
                        <a href="javascript:void(0)" wire:click="editCategory({{ $category->id }})"
                            class="btn btn-dark mtmobile" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <x-primary-button wire:click="editCategory({{ $category->id }})">Editar</x-primary-button>
                        <x-primary-button wire:click="deleteCategory({{ $category->id }})">Eliminar</x-primary-button>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>No.</th>
                    <th>Descripción</th>
                    <th>Imagen</th>
                    <th>Acción</th>
                </tr>
            </tfoot>
        </table>
        {{ $categories->links() }}
    </div>


    <!-- Modals Section -->

    <livewire:reusable-modal />

</div>

</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    Livewire.on('show-modal', () => {
        document.querySelector('.modal').classList.add('modal-open');
    });

    Livewire.on('hide-modal', () => {
        document.querySelector('.modal').classList.remove('modal-open');
    });
});
</script>
@endpush