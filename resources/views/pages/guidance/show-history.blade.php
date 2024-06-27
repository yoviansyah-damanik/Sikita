<div>
    <x-modal.body>
        @if (!$isLoading)
            @if ($histories->count())
                <x-table :columns="['#', __('Message')]" thClass="!py-2 !px-3">
                    <x-slot name="body">
                        @forelse ($histories as $history)
                            <x-table.tr>
                                <x-table.td class="w-14" centered>
                                    {{ $histories->perPage() * ($histories->currentPage() - 1) + $loop->iteration }}
                                </x-table.td>
                                <x-table.td>
                                    <div class="flex gap-3">
                                        <span @class([
                                            'size-4 mt-1',
                                            'i-solar-check-circle-line-duotone text-green-700' =>
                                                $history->type == 'success',
                                            'i-solar-danger-circle-line-duotone text-yellow-700' =>
                                                $history->type == 'warning',
                                            'i-solar-bell-bing-bold-duotone text-red-700' => $history->type == 'error',
                                        ])></span>
                                        <div class="flex-1">
                                            {{ $history->message }}
                                            <div
                                                class="flex items-center gap-1 mt-1 text-sm text-gray-700 dark:text-gray-100">
                                                <span class="i-ph-clock"></span>
                                                {{ $history->created_at->diffForHumans() }}
                                            </div>
                                        </div>
                                    </div>
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

                {{ $histories->links() }}
            @else
                <x-no-data />
            @endif
        @else
            <x-loading />
        @endif
    </x-modal.body>
</div>
