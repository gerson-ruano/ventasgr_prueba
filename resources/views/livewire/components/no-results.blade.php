<!-- resources/views/components/no-results-notification.blade.php -->
@if(count($result) < 1)
    <div class="flex items-center justify-center w-full mt-4">
        <div role="alert"
             class="flex items-center justify-center alert alert-warning text-center w-full max-w-lg p-6 bg-gradient-to-r from-yellow-200 via-yellow-300 to-yellow-400 rounded-lg shadow-lg transform transition-transform duration-300 ease-in-out scale-100 hover:scale-105">
            <i class="fas fa-info-circle text-2xl text-yellow-700"></i>
            <div class="mt-2">
                <h3 class="font-bold text-lg text-yellow-800">No se encontraron {{ $name }}!</h3>
                <p class="text-sm text-yellow-700">Intenta buscar con otro NOMBRE o NUMERO</p>
            </div>
        </div>
    </div>
@endif
