<x-modal.body>
    @if (!$isLoading)
        @if ($revisions->count() > 0)
            <x-table :columns="['#', __('Revision')]" thClass="!py-2 !px-3">
                <x-slot name="body">
                    @forelse ($revisions as $revision)
                        <x-table.tr>
                            <x-table.td class="w-14" centered>
                                {{ $revisions->perPage() * ($revisions->currentPage() - 1) + $loop->iteration }}
                            </x-table.td>
                            <x-table.td>
                                <div class="space-y-1">
                                    <div class="font-semibold">
                                        {{ $revision->title }}
                                    </div>
                                    <div class="explanation">
                                        {!! $revision->explanation !!}
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

            {{ $revisions->links() }}
        @else
            <x-no-data />
        @endif
    @else
        <x-loading />
    @endif
</x-modal.body>
