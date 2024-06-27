<x-modal.body>
    @if (!$isLoading)
        @if ($submission)
            <div class="space-y-3 sm:space-y-4">
                <div class="mb-4 space-y-2 sm:space-y-3">
                    <div class="flex">
                        <div class="w-24 font-semibold sm:w-48 text-primary-700 dark:text-primary-300">
                            {{ __(':name Name', ['name' => __('Student')]) }}</div>
                        <div class="flex-1 dark:text-gray-100">{{ $submission->student->name }}</div>
                    </div>
                    <div class="flex">
                        <div class="w-24 font-semibold sm:w-48 text-primary-700 dark:text-primary-300">
                            {{ __('Title') }}</div>
                        <div class="flex-1 dark:text-gray-100">{{ $submission->title }}</div>
                    </div>
                    <div class="flex">
                        <div class="w-24 font-semibold sm:w-48 text-primary-700 dark:text-primary-300">
                            {{ __('Abstract') }}</div>
                        <div class="flex-1 break-all dark:text-gray-100">{{ $submission->abstract }}</div>
                    </div>
                    <div class="flex">
                        <div class="w-24 font-semibold cursor sm:w-48 text-primary-700 dark:text-primary-300">
                            {{ __('Submission Time') }}
                        </div>
                        <div class="flex-1 dark:text-gray-100">
                            {{ $submission->created_at->translatedFormat('d F Y H:i:s') }}</div>
                    </div>
                    <div class="flex">
                        <div class="w-24 font-semibold sm:w-48 text-primary-700 dark:text-primary-300">
                            {{ __('Status') }}</div>
                        <div class="flex-1 dark:text-gray-100">
                            <x-badge :type="$submission->status == 'process'
                                ? 'info'
                                : ($submission->status == 'approved'
                                    ? 'success'
                                    : 'error')">
                                {{ __(Str::ucfirst($submission->status)) }}
                            </x-badge>
                        </div>
                    </div>
                    @if ($submission->status != 'process')
                        <div class="flex">
                            <div class="w-24 font-semibold cursor sm:w-48 text-primary-700 dark:text-primary-300">
                                {{ __('Action Time') }}
                            </div>
                            <div class="flex-1 dark:text-gray-100">
                                {{ $submission->updated_at->translatedFormat('d F Y H:i:s') }}</div>
                        </div>
                    @endif
                </div>
                <div class="flex">
                    <div class="w-24 font-semibold cursor sm:w-48 text-primary-700 dark:text-primary-300">
                        {{ __('Submission History') }}
                    </div>
                </div>
                <x-table :columns="['#', __('Message')]" thClass="!py-2 !px-3">
                    <x-slot name="body">
                        @forelse ($submission->histories as $history)
                            <x-table.tr>
                                <x-table.td class="w-14" centered>
                                    {{ $loop->iteration }}
                                </x-table.td>
                                <x-table.td>
                                    <div class="flex gap-3">
                                        <span @class([
                                            'size-4 mt-1',
                                            'i-solar-check-circle-line-duotone text-green-700' =>
                                                $history->status == 'finish',
                                            'i-solar-danger-circle-line-duotone text-yellow-700' =>
                                                $history->status == 'warning',
                                            'i-solar-bell-bing-bold-duotone text-cyan-700' =>
                                                $history->status == 'information',
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
            </div>
        @endif
    @else
        <x-loading />
    @endif
</x-modal.body>
