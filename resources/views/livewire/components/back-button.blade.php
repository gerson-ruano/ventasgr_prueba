<div class="{{ isset($position) ? $position : 'fixed top-16 left-4 z-40' }}">
    {{-- The route to go back to --}}
    <a href="{{ $route }}"
       class="inline-flex items-center px-4 py-2
              bg-gray-200 dark:bg-gray-800
              text-gray-800 dark:text-white
              hover:bg-gray-300 dark:hover:bg-gray-700
              text-sm font-semibold rounded-md shadow-sm
              transition duration-200 ease-in-out">
        <i class="fas fa-arrow-left mr-2"></i> {{ !empty($label) ? $label : 'Regresar' }}

    </a>
</div>

