<x-content>
    <x-content.title :title="__('Guidance')" :description="__('Manage guidance that has been submitted by students.')" />

    <x-form.input type="search" :placeholder="__('Search by :1 or :2', ['1' => 'NPM', '2' => __(':name Name', ['name' => __('Student')])])" block wire:model.live.debounce.750ms='search' />

    <x-table :columns="[
        '#',
        'NPM',
        __('Fullname'),
        __('Semester'),
        __('Stamp'),
        __('Final Project'),
        __('Supervisors'),
        __('Status'),
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
                    <x-table.td class="w-64">
                        {{ $student['data']['name'] }}
                    </x-table.td>
                    <x-table.td centered>
                        {{ $student['data']['semester'] }}
                    </x-table.td>
                    <x-table.td centered>
                        {{ $student['data']['stamp'] }}
                    </x-table.td>
                    <x-table.td class="w-[24rem]">
                        <div class="mb-1 font-semibold">
                            {{ $student['final_project']['data']['title'] }}
                        </div>
                        <div class="font-light line-clamp-3">
                            {{ $student['final_project']['data']['abstract'] }}
                        </div>
                    </x-table.td>
                    <x-table.td>
                        <div class="flex flex-col gap-3 w-96">
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
                    <x-table.td class="w-28" centered>
                        <x-tooltip :title="__('View :view', ['view' => __('Guidance')])">
                            <x-button size="sm" :href="route('lecturer.guidance.detail', $student['data']['npm'])" color="cyan" icon="i-ph-eye" />
                        </x-tooltip>
                    </x-table.td>
                </x-table.tr>
            @empty
                <x-table.tr>
                    <x-table.td colspan=9>
                        <x-no-data />
                    </x-table.td>
                </x-table.tr>
            @endforelse
        </x-slot>

        <x-slot name="paginate">
            {{ $students->links(data: ['scrollTo' => false]) }}
        </x-slot>
    </x-table>
</x-content>
