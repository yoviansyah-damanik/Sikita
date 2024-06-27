<x-content>
    <x-content.title :title="__('Submissions')" :description="__('Manage submission of final assignment titles.')" />

    @if (!$student['final_project'])
        <x-alert type="info">
            {{ __('You can only add :max applications with submitted status. You can add applications if one of the applications is rejected and none of the applications are approved.', ['max' => \App\Models\Submission::MAX_SUBMISSIONS]) }}
        </x-alert>

        <div class="flex justify-end">
            <x-button color="primary" icon="i-ph-plus-bold" x-on:click="$dispatch('toggle-create-modal');"
                wire:click="create">
                {{ __('Create :create', ['create' => __('Submission')]) }}
            </x-button>
        </div>
    @else
        <x-alert type="success">
            <div>
                {{ __('Congratulations, your submission has been approved. You can continue to the next stage.') }}
            </div>
            <div class="mt-3">
                <x-button size="sm" :href="route('student.final-project')" color="green">
                    {{ __('Show :show', ['show' => __('Final Project')]) }}
                </x-button>
            </div>
        </x-alert>
    @endif

    <div class="flex flex-col gap-4">
        @forelse ($student['submissions'] as $submission)
            <x-submission lazy :$submission :iteration="$loop->iteration" :student="$student['data']" :supervisors="$student['supervisors']">
                <x-slot:action>
                    <div class="flex items-center justify-center gap-1">
                        <x-tooltip :title="__('View :view', ['view' => __('Submission History')])">
                            <x-button type="button" color="transparent" icon="i-ph-eye-duotone"
                                x-on:click="$dispatch('toggle-view-history-modal')"
                                wire:click="showHistory({{ $submission['id'] }})">
                            </x-button>
                        </x-tooltip>
                        @if (!$student['final_project'])
                            <x-tooltip :title="__('Edit')">
                                <x-button type="button" color="transparent" icon="i-ph-pen-duotone"
                                    x-on:click="$dispatch('toggle-edit-modal')"
                                    wire:click="edit({{ $submission['id'] }})">
                                </x-button>
                            </x-tooltip>
                            <x-tooltip :title="__('Delete')">
                                <x-button type="button" color="transparent" icon="i-ph-trash-duotone"
                                    x-on:click="$dispatch('toggle-delete-modal')"
                                    wire:click="delete({{ $submission['id'] }})">
                                </x-button>
                            </x-tooltip>
                        @endif
                    </div>
                </x-slot:action>
            </x-submission>
        @empty
            <x-no-data />
        @endforelse
    </div>
    <x-modal name="view-history-modal" size="3xl" :modalTitle="__('View :view', ['view' => __('Submission History')])">
        <livewire:submission.show-history />
    </x-modal>
    @if (!$student['final_project'])
        <x-modal name="create-modal" size="3xl" :modalTitle="__('Create :create', ['create' => __('Submission')])">
            <livewire:submission.create />
        </x-modal>
        <x-modal name="edit-modal" size="3xl" :modalTitle="__('Edit :edit', ['edit' => __('Submission')])">
            <livewire:submission.edit />
        </x-modal>
        <x-modal name="delete-modal" size="2xl" :modalTitle="__('Delete :delete', ['delete' => __('Submission')])">
            <livewire:submission.delete />
        </x-modal>
    @endif
</x-content>
