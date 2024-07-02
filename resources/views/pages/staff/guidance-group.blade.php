<x-content>
    <x-content.title :title="__('Guidance Group')" :description="__('Manage guidance groups that include types of guidance.')" />

    <x-alert type="info">
        {{ __('Changing the guidance group or types of guidance groups will affect the percentage of students\' readiness for guidance.') }}
    </x-alert>
    <div class="flex justify-end">
        <x-button color="primary" icon="i-ph-plus-bold" x-on:click="$dispatch('toggle-create-modal');" wire:click="create">
            {{ __('Add :add', ['add' => __('Guidance Group')]) }}
        </x-button>
    </div>

    <div id="guidance-group" class="space-y-3 sm:space-y-4">
        @forelse ($this->groups as $group)
            <div class="p-3 bg-white rounded-lg dark:bg-slate-800 sm:p-8" id="group-{{ $loop->iteration }}">
                <div
                    class="flex items-start justify-between gap-3 pb-3 mb-6 border-b-4 sm:mb-8 border-ocean-blue-300 dark:border-ocean-blue-100">
                    <div class="flex-none">
                        <div class="text-lg font-bold text-ocean-blue-700 dark:text-ocean-blue-300">
                            {{ $group->name }}
                        </div>
                        <div class="font-lighter dark:text-gray-100">
                            {{ $group->description }}
                        </div>
                    </div>
                    <div>
                        <x-tooltip :title="__('Create Sub')">
                            <x-button size="sm" color="transparent" icon="i-ph-plus"
                                wire:click='createSub({{ $group->id }})'
                                x-on:click="$dispatch('toggle-create-modal');" />
                        </x-tooltip>
                        <x-tooltip :title="__('Edit')">
                            <x-button size="sm" color="transparent" icon="i-ph-pen"
                                wire:click='edit({{ $group->id }})' x-on:click="$dispatch('toggle-edit-modal');" />
                        </x-tooltip>
                        <x-tooltip :title="__('Delete')">
                            <x-button size="sm" color="transparent" icon="i-ph-trash"
                                wire:click='delete({{ $group->id }})'
                                x-on:click="$dispatch('toggle-delete-modal');" />
                        </x-tooltip>
                    </div>
                </div>

                <div class="space-y-3 sm:space-y-4">
                    @forelse ($group->types as $type)
                        <div
                            class="flex flex-col items-start gap-3 p-6 bg-primary-50 dark:bg-slate-600 dark:hover:bg-slate-500 hover:bg-sky-100">
                            <div class="flex items-start justify-between w-full gap-3">
                                <div class="flex-1 font-semibold text-ocean-blue-700 dark:text-ocean-blue-300">
                                    {{ $type->name }}
                                </div>
                                <div>
                                    <x-tooltip :title="__('Edit')">
                                        <x-button size="sm" color="transparent" icon="i-ph-pen"
                                            wire:click='editSub({{ $type->id }})'
                                            x-on:click="$dispatch('toggle-edit-modal');" />
                                    </x-tooltip>
                                    <x-tooltip :title="__('Delete')">
                                        <x-button size="sm" color="transparent" icon="i-ph-trash"
                                            wire:click='deleteSub({{ $type->id }})'
                                            x-on:click="$dispatch('toggle-delete-modal');" />
                                    </x-tooltip>
                                </div>
                            </div>
                            <div class="flex flex-col gap-1 font-lighter dark:text-gray-100">
                                {{ $type->description }}
                                <div class="text-sm">
                                    {{ __('Order') }}: {{ $type->order }} | {{ __('Used') }}:
                                    {{ $type->students()->count() }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <x-no-data />
                    @endforelse
                </div>
            </div>
        @empty
            <x-no-data />
        @endforelse
    </div>

    <x-modal name="create-modal" size="2xl" :modalTitle="__(':data Data', ['data' => __('Guidance Group')])">
        <livewire:staff.guidance-group.create />
    </x-modal>

    <x-modal name="edit-modal" size="2xl" :modalTitle="__(':data Data', ['data' => __('Guidance Group')])">
        <livewire:staff.guidance-group.edit />
    </x-modal>

    <x-modal name="delete-modal" size="2xl" :modalTitle="__(':data Data', ['data' => __('Guidance Group')])">
        <livewire:staff.guidance-group.delete />
    </x-modal>
</x-content>
