<div class="flex justify-center items-start p-2 py-4">
    <div class="card w-full max-w-6xl min-w-[600px] bg-base-100 shadow-xl p-4">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold mb-2">Bienvenido a tu Panel de Configuración</h1>
            <p class="text-blue-800 font-semibold">Selecciona un parámetro.</p>
        </div>

        <div class="p-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach ($meta as $setting)
                    <div class="form-control w-full min-w-[280px]">
                        <label class="label">
                            <span class="label-text">{{ ucwords(str_replace('_', ' ', $setting->key)) }}</span>
                        </label>

                        @switch($setting->type)
                            @case('boolean')
                                <div class="w-16" wire:ignore>
                                    <input type="checkbox" class="toggle w-full" wire:model.lazy="settings.{{ $setting->key }}">
                                </div>
                                @break

                            @case('number')
                                <input type="number" class="input input-bordered w-full min-w-[150px]" wire:model.lazy="settings.{{ $setting->key }}">
                                @break

                            @case('select')
                                <select class="select select-bordered w-full min-w-[150px]" wire:model.lazy="settings.{{ $setting->key }}">
                                    @foreach ($setting->options_array as $option)
                                        <option value="{{ $option }}">{{ ucfirst($option) }}</option>
                                    @endforeach
                                </select>
                                @break

                            @default
                                <input type="text" class="input input-bordered w-full min-w-[150px]" wire:model.lazy="settings.{{ $setting->key }}">
                        @endswitch
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>


