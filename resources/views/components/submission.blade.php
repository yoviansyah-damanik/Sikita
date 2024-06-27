<div x-data='{ id: $id("submission") }' :id="id" @class([
    'relative flex-col sm:flex-row flex items-start gap-6 p-6 sm:p-8 rounded-xl dark:bg-slate-800 bg-white border-t-[12px] sm:border-t-0 sm:border-l-[14px] shadow dark:shadow-gray-500',
    'border-yellow-300',
])>
    <div class="flex-1 order-1 sm:order-0">
        <div class="pb-6 space-y-2 sm:space-y-3 sm:pb-9">
            <div class="flex">
                <div class="w-24 font-semibold sm:w-48 text-primary-700 dark:text-primary-300">
                    {{ __(':name Name', ['name' => __('Student')]) }}</div>
                <div class="flex-1 dark:text-gray-100">{{ $student['name'] }}</div>
            </div>
            <div class="flex">
                <div class="w-24 font-semibold sm:w-48 text-primary-700 dark:text-primary-300">{{ __('Title') }}
                </div>
                <div class="flex-1 dark:text-gray-100">{{ $submission['title'] }}</div>
            </div>
            <div class="flex">
                <div class="w-24 font-semibold sm:w-48 text-primary-700 dark:text-primary-300">{{ __('Abstract') }}
                </div>
                <div class="flex-1 dark:text-gray-100">{{ $submission['abstract'] }}</div>
            </div>
            <div class="flex">
                <div class="w-24 font-semibold sm:w-48 text-primary-700 dark:text-primary-300">
                    {{ __('Submission Time') }}
                </div>
                <div class="flex-1 dark:text-gray-100">
                    {{ \Carbon\Carbon::parse($submission['created_at'])->translatedFormat('d F Y H:i:s') }}
                </div>
            </div>
            <div class="flex">
                <div class="w-24 font-semibold sm:w-48 text-primary-700 dark:text-primary-300">
                    {{ __('Last History') }}
                </div>
                <div class="flex-1 dark:text-gray-100">
                    <x-submission.latest-history :$submission />
                </div>
            </div>
            <div class="flex">
                <div class="w-24 font-semibold sm:w-48 text-primary-700 dark:text-primary-300">{{ __('Status') }}
                </div>
                <div class="flex-1 dark:text-gray-100">
                    <x-badge :type="$submission['status'] == 'process'
                        ? 'info'
                        : ($submission['status'] == 'approved'
                            ? 'success'
                            : ($submission['status'] == 'revision'
                                ? 'warning'
                                : 'error'))">
                        {{ __(Str::ucfirst($submission['status'])) }}
                    </x-badge>
                </div>
            </div>
            @if ($submission['status'] != 'process')
                <div class="flex">
                    <div class="w-24 font-semibold cursor sm:w-48 text-primary-700 dark:text-primary-300">
                        {{ __('Action Time') }}
                    </div>
                    <div class="flex-1 dark:text-gray-100">
                        {{ \Carbon\Carbon::parse($submission['updated_at'])->translatedFormat('d F Y H:i:s') }}
                    </div>
                </div>
            @endif
        </div>

        <div class="flex flex-col items-start gap-6 sm:flex-row" @class([
            'justify-between' => isset($action) && !$action->isEmpty(),
        ])>
            <div class="flex flex-col flex-1 gap-3 sm:gap-12 sm:items-center sm:flex-row">
                @foreach ($supervisors as $supervisor)
                    <div class="flex items-center gap-3">
                        <div class="w-12 py-3 text-4xl font-semibold text-white bg-primary-700 text-end">
                            {{ Str::substr($supervisor['as'], -1) }}
                        </div>
                        <div>
                            <div class="font-semibold dark:text-primary-100">
                                {{ $supervisor['name'] }}
                            </div>
                            <div class="font-light dark:text-primary-50">NIDN.
                                {{ $supervisor['nidn'] }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="flex flex-row items-center gap-6 divide-x sm:divide-x-0 sm:divide-y sm:flex-col order-0 sm:order-1">
        @if ($iteration)
            <div class="text-[7rem] text-center leading-none font-bold text-yellow-300 pointer-events-none">
                {{ $iteration }}
            </div>
        @endif
        @if (isset($action) && !$action->isEmpty())
            <div class="w-full min-w-32">
                {{ $action }}
            </div>
        @endif
    </div>
</div>
