<div class="flex flex-col w-full lg:flex-row lg:space-y-0 mt-1">
    <div class="lg:w-3/4">
        @include('livewire.pos.partials.detail')
    </div>
    <!--div class="divider lg:divider-horizontal"></div-->
    <div class="lg:w-1/4">
        @include('livewire.pos.partials.filtros')
        
        @include('livewire.pos.partials.coins')
        <div
            class="grid flex-grow h-32 card bg-base-300 rounded-box place-items-center mb-1 ml-2 lg:mb-2 lg:ml-0 lg:mr-2">
            Contenido de la cuarta columna

        </div>
        <div
            class="grid flex-grow h-32 card bg-base-300 rounded-box place-items-center mb-1 ml-2 lg:mb-2 lg:ml-0 lg:mr-2">
            Contenido de la quinta columna

        </div>
        <div
            class="grid flex-grow h-32 card bg-base-300 rounded-box place-items-center mb-1 ml-2 lg:mb-2 lg:ml-0 lg:mr-2">
            Contenido de la tercera columna

        </div>

    </div>
</div>

{{--<script> src="{{ asset('js/keypress.js') }}"</script>--}}
@include('livewire.pos.scripts.shortcuts')
{{--@include('livewire.pos.scripts.events')--}}
@include('livewire.pos.scripts.general')
{{--@include('livewire.pos.scripts.scan')--}}