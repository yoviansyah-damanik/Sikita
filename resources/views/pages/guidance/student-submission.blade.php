<div class="p-4 shadow bg-primary-50 dark:bg-slate-700">
    <div class="flex items-center gap-6">
        <div class="flex-1">
            <div class="font-semibold">
                {{ $submission->title }}
            </div>
            <div class="text-sm font-light line-clamp-2">
                {{ $submission->description }}
            </div>
            <div class="text-sm font-light">
                {{ $submission->created_at->translatedFormat('d F Y H:i:s') }}
            </div>
        </div>
        <div class="flex items-start gap-1">
            <x-tooltip :title="__('View')">
                <x-button color="cyan" icon="i-ph-eye" x-on:click="$dispatch('toggle-view-pdf-modal')"
                    wire:click="showPdf('{{ $submission->storageFile() }}')" />
            </x-tooltip>
            <x-tooltip :title="__('Download')">
                <x-button color="primary" wire:click='download' icon="i-ph-download" />
            </x-tooltip>
        </div>
    </div>
</div>
