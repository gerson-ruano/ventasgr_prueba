<div>
    @if ($visible)
    <div role="alert" class="alert alert-{{ $type }} flex justify-between items-center fixed top-4 right-4 z-50 w-1/2 max-w-xs"
        id="notification-element">
        <div class="flex items-center gap-2">
            @if ($type === 'success')
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            @elseif ($type === 'error')
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
            @elseif ($type === 'warning')
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4m0 4h.01m-6.938 4h13.856C18.627 19.348 20 16.292 20 13 20 7.477 15.523 3 10 3S0 7.477 0 13c0 3.292 1.373 6.348 3.906 8.938z" />
            </svg>
            @elseif ($type === 'info')
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 16h-1v-4h-1m0-4h.01M12 2a10 10 0 100 20 10 10 0 000-20z" />
            </svg>
            @endif
            <span>{{ $message }}</span>
        </div>
        <button wire:click="closeNotification" class="close-btn">&times;</button>
    </div>
    @endif

    <style>
    .alert {
        padding: 10px;
        border-radius: 5px;
    }

    .alert-success {
        background-color: #d1e7dd;
        color: #0f5132;
    }

    .alert-error {
        background-color: #f8d7da;
        color: #842029;
    }

    .alert-warning {
        background-color: #fff3cd;
        color: #856404;
    }

    .alert-info {
        background-color: #d1ecf1;
        color: #0c5460;
    }

    .close-btn {
        background: none;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
    }
    </style>
</div>