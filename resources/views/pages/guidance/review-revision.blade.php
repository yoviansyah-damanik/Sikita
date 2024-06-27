<div id="review-revisions" class="p-2">
    <div class="flex gap-3 mb-4">
        <x-button icon="i-ph-list" color="transparent" x-on:click="$dispatch('toggle-show-guidances-revision-modal');"
            wire:click="$dispatch('setShowGuidancesRevision',{ guidance: {{ $guidance->id }} })" />
        <x-button block color="primary" base="flex-1" radius="rounded-xl" :loading="$isFinish"
            x-on:click="$dispatch('toggle-create-revision-modal')"
            wire:click="$dispatch('setCreateRevision',{ guidanceId: {{ $guidance->id }} })">{{ __('Add :add', ['add' => __('Revision')]) }}</x-button>
    </div>
    @forelse ($guidance->revisions->where('lecturer_id', auth()->user()->data->id) as $revision)
        <div class="relative p-4 rounded-lg group/review-revision sm:p-6 hover:bg-primary-50">
            <div class="space-y-1">
                <div class="font-semibold">
                    {{ $revision->title }}
                </div>
                <div class="block">
                    <x-badge class="mr-3" size="sm" :type="$revision->status == 'onProgress' ? 'warning' : 'success'">
                        {{ __(Str::ucfirst($revision->status)) }}
                    </x-badge>
                    <div
                        class="inline-flex items-center gap-1 mt-1 mr-3 text-sm font-light text-gray-700 dark:text-gray-100">
                        <span class="i-ph-chalkboard-teacher-fill"></span>
                        {{ $revision->lecturer->name }}
                    </div>
                    <div
                        class="inline-flex items-center gap-1 mt-1 mr-3 text-sm font-light text-gray-700 dark:text-gray-100">
                        <span class="i-ph-clock"></span>
                        {{ $revision->created_at->translatedFormat('d F Y H:i:s') }}
                    </div>
                    <div
                        class="inline-flex items-center gap-1 mt-1 text-sm font-light text-gray-700 dark:text-gray-100">
                        <span class="i-ph-check"></span>
                        {{ $revision->updated_at->translatedFormat('d F Y H:i:s') }}
                    </div>
                </div>
            </div>
            <div
                class="absolute inset-y-0 right-0 flex items-center justify-center invisible gap-1 p-4 group-hover/review-revision:visible">
                <x-tooltip :title="__('Show')">
                    <x-button size="sm" color="cyan" icon="i-ph-eye"
                        x-on:click="$dispatch('toggle-show-revision-modal')"
                        wire:click="$dispatch('setShowRevision',{ revision: {{ $revision->id }} })" />
                </x-tooltip>
                @if ($revision->lecturer_id == auth()->user()->data->id && !$isFinish)
                    <x-tooltip :title="__('Edit')">
                        <x-button size="sm" color="yellow" icon="i-ph-pen"
                            x-on:click="$dispatch('toggle-edit-revision-modal')"
                            wire:click="$dispatch('setEditRevision',{ revision: {{ $revision->id }} })" />
                    </x-tooltip>
                    <x-tooltip :title="__('Set Revision Status')">
                        <x-button size="sm" color="green" icon="i-ph-check"
                            x-on:click="$dispatch('toggle-set-revision-status-modal')"
                            wire:click="$dispatch('setRevisionStatus',{ revision: {{ $revision->id }} })" />
                    </x-tooltip>
                @endif
            </div>
        </div>
    @empty
        <x-no-data />
    @endforelse
</div>
