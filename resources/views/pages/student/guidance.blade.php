<x-content>
    <x-content.title :title="__('Guidance')" :description="__('Manage your guidance process and make sure everything goes well.')" />

    <x-student-information :$student />

    <div class="flex flex-col gap-4 sm:flex-row sm:gap-6">
        <div id="guidance-group" class="flex-1 order-1 space-y-3 sm:space-y-4 sm:order-0">
            <x-form.select block wire:model.live='group' wire:change="$dispatch('clearShowGuidance')" :items="$this->groups" />
            @forelse ($student['final_project']['guidances'] as $group)
                <x-guidance.group :$group />
            @empty
                <x-no-data />
            @endforelse
        </div>
        <div class="flex-1 order-0 sm:order-1 sm:flex-none sm:w-1/3 2xl:w-2/5">
            <livewire:guidance.show />
        </div>
    </div>

    @if (!auth()->user()->data->passed)
        <x-modal name="create-guidance-modal" size="3xl" :modalTitle="__('Add :add', ['add' => __('Guidance')])">
            <livewire:guidance.create />
        </x-modal>
    @endif
    <x-modal name="view-pdf-modal" size="4xl" :modalTitle="__('View :view', ['view' => 'PDF'])">
        <livewire:view-pdf-modal />
    </x-modal>
    <x-modal name="show-guidances-history-modal" size="4xl" :modalTitle="__('Show :show', ['show' => __('Guidance\'s History')])">
        <livewire:guidance.show-history />
    </x-modal>
    <x-modal name="show-guidances-revision-modal" size="4xl" :modalTitle="__('Show :show', ['show' => __('Guidance\'s Revision')])">
        <livewire:guidance.show-revision />
    </x-modal>
</x-content>
