<div class="mt-0 mb-1 mr-2 ml-2">
    <label for="{{$model}}_select" class="text-center block text-sm font-medium text-gray-700 mb-1">{{$title}}</label>
    <select wire:model.blur="{{$model}}" id="{{$model}}_select" class="select select-sm select-info w-full max-w-md">
        <option value="{{$default}}" selected>Elegir</option>
        @if($valores)
        @foreach ($valores as $valor)
        <option value="{{ $valor }}">{{ $valor}}</option>
        {{--<option value="{{ $role->name }}" selected>{{$role->name}}</option>--}}
        @endforeach
        @endif
    </select>
    @error('{{$model}}') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
</div>
