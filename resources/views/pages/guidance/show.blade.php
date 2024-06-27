<div class="p-6 bg-white dark:bg-slate-800 rounded-xl dark:text-gray-100">
    @if ($isShow)
        <div class="font-semibold text-ocean-blue-700 dark:text-ocean-blue-300">
            {{ $guidance->type->name }}
        </div>
        <div class="mb-4 font-light">
            {{ $guidance->type->description }}
        </div>
        <div class="space-y-1 sm:space-y-2">
            @forelse ($guidance->submissions as $submission)
                <livewire:guidance.student-submission :$submission :key="$submission->id" />
            @empty
                <div class="text-center">
                    {{ __('No :data found', ['data' => Str::lower(__('Guidance'))]) }}
                </div>
            @endforelse
        </div>
        @if ($canCreate)
            <x-button :disabled="!$canCreate" base="mt-4" color="primary" block
                x-on:click="$dispatch('toggle-create-guidance-modal')" wire:click="createGuidance">
                {{ __('Add :add', ['add' => __('Guidance')]) }}
            </x-button>
        @endif
    @else
        <div class="text-center">
            {{ __('Please select the guidance you want to display.') }}
        </div>
    @endif
</div>
