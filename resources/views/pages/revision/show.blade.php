<x-modal.body>
    @if (!$isLoading)
        @if ($revision)
            <div class="space-y-2 sm:space-y-3">
                <div class="flex">
                    <div class="w-24 font-semibold sm:w-48 text-primary-700 dark:text-primary-300">
                        {{ __('Lecturer') }}</div>
                    <div class="flex-1 dark:text-gray-100">{{ $revision->lecturer->name }}</div>
                </div>
                <div class="flex">
                    <div class="w-24 font-semibold sm:w-48 text-primary-700 dark:text-primary-300">
                        {{ __('Action Time') }}</div>
                    <div class="flex-1 dark:text-gray-100">
                        {{ $revision->updated_at->translatedFormat('d F Y H:i:s') }}</div>
                </div>
                <div class="flex">
                    <div class="w-24 font-semibold sm:w-48 text-primary-700 dark:text-primary-300">
                        {{ __('Status') }}</div>
                    <div class="flex-1 dark:text-gray-100">
                        <x-badge :type="$revision->status == 'onProgress' ? 'warning' : 'success'">
                            {{ __(Str::ucfirst($revision->status)) }}
                        </x-badge>
                    </div>
                </div>
                <div class="flex">
                    <div class="w-24 font-semibold sm:w-48 text-primary-700 dark:text-primary-300">
                        {{ __('Title') }}</div>
                    <div class="flex-1 dark:text-gray-100">{{ $revision->title }}</div>
                </div>
                <div class="flex min-h-32">
                    <div class="w-24 font-semibold sm:w-48 text-primary-700 dark:text-primary-300">
                        {{ __('Explanation') }}</div>
                    <div class="flex-1 dark:text-gray-100 explanation">{!! $revision->explanation !!}</div>
                </div>
            </div>
        @endif
    @else
        <x-loading />
    @endif
</x-modal.body>
