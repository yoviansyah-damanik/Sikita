<div>
    <x-modal.body>
        {{ $message }}
    </x-modal.body>
    <x-modal.footer>
        <x-button color="red" wire:click='destroy' :loading="$isLoading">
            {{ __('Delete') }}
        </x-button>
    </x-modal.footer>
</div>
