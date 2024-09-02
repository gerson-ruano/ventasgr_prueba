<div class="flex flex-col w-full lg:flex-row lg:space-y-0 mt-1">
    <!--div class="divider lg:divider-horizontal"></div-->
    <div class="lg:w-1/4">
        @include('livewire.reports.partials.filtros')
        {{--<div
            class="grid flex-grow h-32 card bg-base-300 rounded-box place-items-center mb-1 ml-2 lg:mb-2 lg:ml-1 lg:mr-1">
            Contenido de la quinta columna
        </div>--}}

    </div>
    <div class="lg:w-3/4">
        <div>
            @include('livewire.reports.partials.detail')
        </div>
        {{--}}<div class="">
            @include('livewire.reports.partials.sales-detail')
        </div>--}}
    </div>
</div>

@include('livewire.reports.scripts.general')
