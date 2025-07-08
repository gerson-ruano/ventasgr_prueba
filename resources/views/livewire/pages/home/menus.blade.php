@extends('layouts.app')
@section('title', 'Module')
@section('content')

    <livewire:components.back-button route="{{ route('home') }}"/>

    @if(count($children) > 0)
        <div class="flex justify-center items-center p-4">
            <div class="card w-full max-w-4xl p-6">
                <div class="text-center mb-6 mt-4">
                    <h1 class="text-2xl font-bold mb-1">Opciones de {{ $moduleLabel }}</h1>
                    <p class="text-gray-300 font-semibold mb-2">Selecciona una opción para comenzar...</p>
                </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 p-6">
                @foreach($children as $child)

                    <div class="card bg-base-100 shadow-lg p-4 text-center">
                        <a href="{{ $child['route'] }}" class="btn btn-xs sm:btn-sm md:btn-md lg:btn-lg xl:btn-xl text-lg flex justify-center items-center gap-2 text-gray-600 hover:bg-gray-400 transition-colors duration-300">
                            <i class="fa fa-arrow-right mr-1"></i> <i
                                class="{{ $child['icon'] }} text-xl leading-none"></i> {{ $child['label'] }}
                        </a>
                    </div>
                @endforeach
            </div>

    @else
        <div class="flex items-center justify-center min-h-screen px-4">
            <div
                class="card w-full max-w-md p-6 bg-gradient-to-r from-blue-200 via-blue-300 to-blue-400 rounded-lg shadow-lg text-center">
                <i class="fas fa-lock text-4xl text-yellow-700 mb-4"></i>
                <h3 class="text-lg font-bold text-yellow-800 mb-1">No tienes <strong>MODULOS</strong> asignados por el
                    momento</h3>
                <p class="text-sm text-yellow-700">Verifica con tu administrador o soporte.</p>
            </div>
        </div>
    @endif
@endsection

