<!-- resources/views/components/no-results-notification.blade.php -->
@if(count($result) < 1) 
<tr>
    <td colspan="8">
        <div class="card bg-neutral text-neutral-content w-96 mx-auto">
            <div class="card-body items-center text-center">
                <i class="fas fa-exclamation-triangle fa-3x text-danger"></i>
                <h4 class="card-title mt-2">No se encontraron {{ $name }}</h4>
            </div>
        </div>
    </td>
</tr>
@endif