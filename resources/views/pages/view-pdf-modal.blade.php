<x-modal.body>
    @if (!$isLoading)
        <embed type="application/pdf" src="{{ $source }}" width="100%" height="600"></embed>
    @else
        <x-loading />
    @endif
</x-modal.body>
