<x-modal.body>
    @if (!empty($students))
        <div class="mb-4">
            <x-form.input type="search" :placeholder="__('Search by :1 or :2', ['1' => 'NPM', '2' => __(':name Name', ['name' => __('Student')])])" block wire:model.live.debounce.750ms='search' />
        </div>
        @if ($students->count())
            <x-table :columns="['#', __('NPM'), __('Fullname'), __('Gender'), __('Stamp'), __('Semester'), __('Status')]" thClass="!py-2 !px-3">
                <x-slot name="body">
                    @forelse ($students as $student)
                        <x-table.tr>
                            <x-table.td class="w-14" centered>
                                {{ $students->perPage() * ($students->currentPage() - 1) + $loop->iteration }}
                            </x-table.td>
                            <x-table.td centered>
                                {{ $student['data']['npm'] }}
                            </x-table.td>
                            <x-table.td>
                                {{ $student['data']['name'] }}
                            </x-table.td>
                            <x-table.td centered>
                                {{ $student['data']['gender'] }}
                            </x-table.td>
                            <x-table.td centered>
                                {{ $student['data']['stamp'] }}
                            </x-table.td>
                            <x-table.td centered>
                                {{ $student['data']['semester'] }}
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
                        </x-table.tr>
                    @empty
                        <x-table.tr>
                            <x-table.td centered colspan=3>
                                {{ __('No data found') }}
                            </x-table.td>
                        </x-table.tr>
                    @endforelse
                </x-slot>
            </x-table>

            {{ $students->links() }}
        @else
            <x-no-data />
        @endif
    @else
        <x-loading />
    @endif
</x-modal.body>
