<x-content>
    <x-content.title :title="__('Guidance\'s Student')" :description="__('Guidance student status information.')" />

    <x-form.input type="search" :placeholder="__('Search by :1 or :2', ['1' => 'NPM', '2' => __(':name Name', ['name' => __('Student')])])" block wire:model.live.debounce.750ms='search' />

    <x-table :columns="[
        '#',
        'NPM',
        __('Fullname'),
        __('Semester'),
        __('Stamp'),
        __('Gender'),
        __('Address'),
        __('Supervisors'),
        __('Status'),
        __(':status Status', ['status' => __('Passed')]),
        '',
    ]">
        <x-slot name="body">
            @forelse ($students as $student)
                <x-table.tr>
                    <x-table.td centered>
                        {{ $students->perPage() * ($students->currentPage() - 1) + $loop->iteration }}
                    </x-table.td>
                    <x-table.td centered>
                        {{ $student['data']['npm'] }}
                    </x-table.td>
                    <x-table.td>
                        {{ $student['data']['name'] }}
                    </x-table.td>
                    <x-table.td centered>
                        {{ $student['data']['semester'] }}
                    </x-table.td>
                    <x-table.td centered>
                        {{ $student['data']['stamp'] }}
                    </x-table.td>
                    <x-table.td centered>
                        {{ $student['data']['gender'] }}
                    </x-table.td>
                    <x-table.td>
                        {{ $student['data']['address'] }}
                    </x-table.td>
                    <x-table.td>
                        <div class="flex flex-col gap-3">
                            @foreach ($student['supervisors'] as $supervisor)
                                <div class="flex items-center flex-1 gap-3">
                                    <div @class([
                                        'w-12 py-3 text-4xl font-semibold text-white text-end',
                                        'bg-red-700' => $supervisor['nidn'] == auth()->user()->data->id,
                                        'bg-primary-700' => $supervisor['nidn'] != auth()->user()->data->id,
                                    ])>
                                        {{ Str::substr($supervisor['as'], -1) }}
                                    </div>
                                    <div>
                                        <div @class([
                                            'font-semibold',
                                            'text-red-700 dark:text-red-300' =>
                                                $supervisor['nidn'] == auth()->user()->data->id,
                                            'dark:text-primary-100' => $supervisor['nidn'] != auth()->user()->data->id,
                                        ])>
                                            {{ $supervisor['name'] }}
                                        </div>
                                        <div class="font-light dark:text-primary-50">NIDN.
                                            {{ $supervisor['nidn'] }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </x-table.td>
                    <x-table.td centered>
                        <x-badge :type="$student['status']['code'] == 0
                            ? 'error'
                            : ($student['status']['code'] == 1
                                ? 'warning'
                                : 'success')">
                            {{ $student['status']['message'] }}
                        </x-badge>
                    </x-table.td>
                    <x-table.td centered>
                        <x-badge :type="$student['is_passed']['status'] ? 'success' : 'warning'">
                            {{ $student['is_passed']['message'] }}
                        </x-badge>
                        @if ($student['is_passed']['status'])
                            <div class="mt-3 font-bold text-center">
                                {{ $student['is_passed']['data']['grade_number'] }}
                                ({{ $student['is_passed']['data']['grade'] }})
                            </div>
                        @endif
                    </x-table.td>
                    <x-table.td class="w-28" centered>
                        <x-tooltip :title="__('View')">
                            <x-button color="cyan" icon="i-ph-eye" size="sm"
                                x-on:click="$dispatch('toggle-show-student-modal')"
                                wire:click="$dispatch('setStudent', { student: {{ $student['data']['npm'] }} } )">
                            </x-button>
                        </x-tooltip>
                        <x-tooltip :title="__('Guidance Journey')">
                            <x-button size="sm" icon="i-ph-folder-simple-user" color="yellow"
                                x-on:click="$dispatch('toggle-show-guidance-journey-modal')"
                                wire:click="$dispatch('setGuidanceJourney',{ studentId: {{ $student['data']['npm'] }} })" />
                        </x-tooltip>
                    </x-table.td>
                </x-table.tr>
            @empty
                <x-table.tr>
                    <x-table.td colspan="10">
                        <x-no-data />
                    </x-table.td>
                </x-table.tr>
            @endforelse
        </x-slot>

        <x-slot name="paginate">
            {{ $students->links(data: ['scrollTo' => false]) }}
        </x-slot>
    </x-table>

    <div wire:ignore>
        <x-modal name="show-student-modal" size="3xl" :modalTitle="__(':data Data', ['data' => __('Student')])">
            <livewire:student.show-data />
        </x-modal>
        <x-modal name="show-guidance-journey-modal" size="4xl" :modalTitle="__('Guidance Journey')">
            <livewire:student.guidance-journey-modal />
        </x-modal>
    </div>
</x-content>
