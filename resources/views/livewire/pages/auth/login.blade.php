<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('pos', absolute: false), navigate: true);
    }
}; ?>

<div>
    @if(session('error'))
        <div
            class="alert flex items-center alert-danger justify-center bg-white border border-gray-300 rounded-lg shadow-lg p-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')"/>


    <h2 class="text-4xl font-bold text-gray-600 text-center mb-6">{{ __('Login') }}</h2>

    <form wire:submit="login" class="space-y-4 ">

        <!--x-application-logo class="absolute w-6 h-6 text-gray-400 dark:text-gray-500 top-3 left-3"/-->

        <!-- Email Address -->
        <div class="relative">
            <x-input-label for="email" :value="__('Email')"/>

            <!--div class="relative"-->
                <x-text-input wire:model.live="form.email" id="email"
                              class="mt-1 input input-info w-full"
                              type="email"
                              name="email" required autofocus autocomplete="username"/>

                <!--i class="fa-solid fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i-->

            <!--/div-->

            <x-input-error :messages="$errors->get('form.email')" class="mt-2"/>
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')"/>

            <x-text-input wire:model.live="form.password" id="password"
                          class="mt-1 input input-info w-full"
                          type="password"
                          name="password"
                          required autocomplete="current-password"/>

            <x-input-error :messages="$errors->get('form.password')" class="mt-2"/>
        </div>

        <!-- Remember Me -->
        {{--<div class="block mt-4">
            <label for="remember" class="inline-flex items-center">
                <input wire:model.live="form.remember" id="remember" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>--}}

        <div class="flex justify-center">
            {{--@if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}" wire:navigate>
                    {{ __('Forgot your password?') }}
                </a>
            @endif--}}

            <x-primary-button
                class="mb-2 mt-3 py-3 bg-blue-600 hover:bg-blue-500 rounded-lg shadow-md text-lg font-semibold transition-all duration-300 transform hover:scale-105">
                {{ __('Login') }}
            </x-primary-button>
        </div>
        <a
            href="{{ route('register') }}"
            class="rounded-md px-3 py-2 text-blue-500 font-bold ring-1 ring-transparent transition
           hover:text-blue-700 focus:outline-none focus-visible:ring-[#FF2D20]
           dark:text-blue-400 dark:hover:text-blue-300 dark:focus-visible:ring-white"
        >
            {{ __('Registrarse') }}
        </a>

    </form>

</div>

