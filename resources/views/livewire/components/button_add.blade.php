

<div class="flex justify-center lg:justify-start mt-2 lg:mt-0">
    <button class="btn btn-{{ $color }} text-sm px-3 py-2 whitespace-nowrap flex items-center gap-2"
            wire:click="{{ $model }}">
        <i class="fas fa-{{ $icon }}"></i>
        <span class="hidden sm:inline">{{ $title }}</span>
    </button>
</div>


