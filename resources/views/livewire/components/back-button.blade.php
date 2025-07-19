<div class="{{ isset($position) ? $position : 'fixed z-40 top-4 left-4 sm:top-4 sm:left-4 md:top-24 md:left-4 lg:top-24 lg:left-6' }}">
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


