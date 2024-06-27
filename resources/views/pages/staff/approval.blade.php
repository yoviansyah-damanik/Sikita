<x-content>
    <x-content.title :title="__('Approval')" :description="__('Manage approval for student thesis title submissions.')" />

    <x-form.input wire:model.live.debounce.750ms='search' type="search" :placeholder="__('Search by :1 or :2', ['1' => 'NPM', '2' => __(':name Name', ['name' => __('Student')])])" block />

    <div class="flex flex-col gap-4">
        <x-table :columns="['#', 'NPM', __('Fullname'), __('Semester'), '', __('Submissions')]">
            <x-slot name="body">
                @forelse ($students as $student)
                    <x-table.tr>
                        <x-table.td centered>
                            {{ $students->perPage() * ($students->currentPage() - 1) + $loop->iteration }}
                        </x-table.td>
                        <x-table.td centered>
                            {{ $student['data']['npm'] }}
                        </x-table.td>
                        <x-table.td class="min-w-64">
                            {{ $student['data']['name'] }}
                        </x-table.td>
                        <x-table.td centered>
                            {{ $student['data']['semester'] }}
                        </x-table.td>
                        <x-table.td>
                            <x-tooltip :title="__('View :view', ['view' => __('Student')])" position="left">
                                <x-button color="cyan" icon="i-ph-plus-duotone" size="sm"
                                    x-on:click="$dispatch('toggle-show-student-data-modal')"
                                    wire:click="$dispatch('setStudent', { student: {{ $student['data']['npm'] }} } )">
                                </x-button>
                            </x-tooltip>
                        </x-table.td>
                        <x-table.td>
                            @forelse ($student['submissions'] as $submission)
                                <div
                                    class="flex gap-3 py-1 mb-3 border-b first:pt-0 sm:p2-4 sm:gap-6 sm:mb-4 last:mb-0 last:border-b-0">
                                    <div class="flex-1">
                                        <div class="font-medium">
                                            {{ $submission['title'] }}
                                        </div>
                                        <div class="font-light line-clamp-2">
                                            {{ $submission['abstract'] }}
                                        </div>
                                    </div>
                                    <div class="flex flex-col items-center justify-center w-32 gap-6">
                                        <x-badge :type="$submission['status'] == 'process'
                                            ? 'info'
                                            : ($submission['status'] == 'approved'
                                                ? 'success'
                                                : ($submission['status'] == 'rejected'
                                                    ? 'error'
                                                    : 'warning'))">
                                            {{ __(Str::ucfirst($submission['status'])) }}
                                        </x-badge>
                                        <div class="flex justify-center gap-1">
                                            <x-tooltip :title="__('View :view', ['view' => __('Submission')])">
                                                <x-button size="sm" icon="i-ph-eye" color="cyan"
                                                    x-on:click="$dispatch('toggle-show-submission-modal')"
                                                    wire:click="showSubmission({{ $submission['id'] }})" />
                                            </x-tooltip>
                                            <x-tooltip :title="__('Action')">
                                                <x-button size="sm" icon="i-ph-list" color="primary"
                                                    x-on:click="$dispatch('toggle-action-submission-modal')"
                                                    wire:click="actionSubmission({{ $submission['id'] }})" />
                                            </x-tooltip>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center">
                                    {{ __('No :data found', ['data' => Str::lower(__('Submission'))]) }}
                                </div>
                            @endforelse
                        </x-table.td>
                    </x-table.tr>
                @empty
                    <x-table.tr>
                        <x-table.td colspan="8">
                            <x-no-data />
                        </x-table.td>
                    </x-table.tr>
                @endforelse
            </x-slot>

            <x-slot name="paginate">
                {{ $students->links(data: ['scrollTo' => 'table']) }}
            </x-slot>
        </x-table>
    </div>

    <x-modal name="show-student-data-modal" size="3xl" :modalTitle="__(':data Data', ['data' => __('Student')])">
        <livewire:student.show-data />
    </x-modal>

    <x-modal name="show-submission-modal" size="3xl" :modalTitle="__(':data Data', ['data' => __('Submission')])">
        <livewire:submission.show />
    </x-modal>

    <x-modal name="action-submission-modal" size="3xl" :modalTitle="__(':data Data', ['data' => __('Submission')])">
        <livewire:submission.action />
    </x-modal>
</x-content>
