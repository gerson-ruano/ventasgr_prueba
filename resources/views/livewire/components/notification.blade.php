<div>
    @if ($visible)
    <div role="alert"
        class="alert alert-{{ $type }} flex justify-between items-center fixed top-4 right-4 z-50 w-1/2 max-w-xs transition-transform transform"
        id="notification-element">
        <div class="flex items-center gap-4">
            @if ($type === 'success')
            <i class="fas fa-check-circle fa-2x text-green-500"></i>
            @elseif ($type === 'error')
            <i class="fas fa-eraser fa-2x text-red-500"></i>
            @elseif ($type === 'warning')
            <i class="fas fa-exclamation-triangle fa-2x text-yellow-500"></i>
            @elseif ($type === 'info')
            <i class="fas fa-info fa-2x text-blue-500"></i>
            @elseif ($type === 'dark')
            <i class="fas fa-exclamation-circle fa-2x text-blue-500"></i>
            @endif
            <span>{{ $message }}</span>
        </div>
        <button wire:click="closeNotification" class="close-btn">&times;</button>
    </div>
    @endif

    <style>
        .alert {
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.5s ease-in-out, opacity 0.5s ease-in-out;
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

        .alert-dark {
            background-color: #343a40;
            color: #ffffff;
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: inherit;
        }
    </style>
</div>
