<x-modal.body>
    @if (!$isLoading)
        @if (!empty($student))
            <livewire:student.guidance-journey :$student />
        @else
            <x-no-data />
        @endif
    @else
        <x-loading />
    @endif
</x-modal.body>
