<div class="mt-0 mb-0 mr-2 ml-2 flex flex-col items-center">
    <!--label for="search-input" id="codigo" class="text-center block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ $placeholder }}</label-->
    <label class="input input-info input w-full max-w-xs flex items-center ">
        <input id="search-input" type="text" minlength="1" maxlength="5"
               @if(isset($model)) wire:model.live="{{ $model }}"
               @endif name="busqueda" class="grow" placeholder="{{ $placeholder }}"/>
        @if(isset($model))
            <i class="fas fa-search"></i>
        @else
            <i class="fas fa-barcode"></i>
        @endif
    </label>
</div>
