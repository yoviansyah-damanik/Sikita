<x-content>
    <x-content.title :title="__('Final Project')" :description="__('Monitor the progress of your final assignment.')" />

    <x-student-information :$student />

    <div
        class="relative p-6 sm:p-8 sm:pr-44 rounded-xl dark:bg-slate-800 bg-white border-t-[12px] sm:border-t-0 sm:border-l-[14px] shadow dark:shadow-gray-500 border-primary-700">
        <div class="pb-6 space-y-2 sm:space-y-3 sm:pb-9">
            <div class="flex gap-3">
                <div class="w-40 font-semibold sm:w-56 lg:w-72 text-primary-700 dark:text-primary-300">
                    {{ __(':name Name', ['name' => __('Student')]) }}</div>
                <div class="flex-1 dark:text-gray-100">{{ $student['data']['name'] }}</div>
            </div>
            <div class="flex gap-3">
                <div class="w-40 font-semibold sm:w-56 lg:w-72 text-primary-700 dark:text-primary-300">
                    {{ __('Title') }}
                </div>
                <div class="flex-1 dark:text-gray-100">{{ $student['final_project']['data']['title'] }}</div>
            </div>
            <div class="flex gap-3">
                <div class="w-40 font-semibold sm:w-56 lg:w-72 text-primary-700 dark:text-primary-300">
                    {{ __('Abstract') }}
                </div>
                <div class="flex-1 dark:text-gray-100">{{ $student['final_project']['data']['abstract'] }}</div>
            </div>
            <div class="flex gap-3">
                <div class="w-40 font-semibold sm:w-56 lg:w-72 text-primary-700 dark:text-primary-300">
                    {{ __('Submission Time') }}
                </div>
                <div class="flex-1 dark:text-gray-100">
                    {{ \Carbon\Carbon::parse($student['final_project']['data']['created_at'])->translatedFormat('d F Y H:i:s') }}
                </div>
            </div>
            <div class="flex gap-3">
                <div class="w-40 font-semibold sm:w-56 lg:w-72 text-primary-700 dark:text-primary-300">
                    {{ __('Last History') }}
                </div>
                <div class="flex-1 dark:text-gray-100">
                    <x-submission.latest-history :submission="$student['final_project']['data']" />
                </div>
            </div>
            <div class="flex gap-3">
                <div class="w-40 font-semibold sm:w-56 lg:w-72 text-primary-700 dark:text-primary-300">
                    {{ __('Status') }}
                </div>
                <div class="flex-1 dark:text-gray-100">
                    <x-badge :type="$student['final_project']['data']['status'] == 'process'
                        ? 'info'
                        : ($student['final_project']['data']['status'] == 'approved'
                            ? 'success'
                            : ($student['final_project']['data']['status'] == 'revision'
                                ? 'warning'
                                : 'error'))">
                        {{ __(Str::ucfirst($student['final_project']['data']['status'])) }}
                    </x-badge>
                </div>
            </div>
            <div class="flex gap-3">
                <div class="w-40 font-semibold cursor sm:w-56 lg:w-72 text-primary-700 dark:text-primary-300">
                    {{ __('Action Time') }}
                </div>
                <div class="flex-1 dark:text-gray-100">
                    {{ \Carbon\Carbon::parse($student['final_project']['data']['updated_at'])->translatedFormat('d F Y H:i:s') }}
                </div>
            </div>
            <div class="flex flex-col gap-3 sm:flex-row">
                <div class="w-40 font-semibold cursor sm:w-56 lg:w-72 text-primary-700 dark:text-primary-300">
                    {{ __('Supervisors') }}
                </div>
                <div class="flex-1 dark:text-gray-100">
                    <div class="flex flex-col items-start gap-6 sm:flex-row" @class([
                        'justify-between' => isset($action) && !$action->isEmpty(),
                    ])>
                        <div class="flex flex-col flex-1 gap-3 sm:gap-12 sm:items-center sm:flex-row">
                            @foreach ($student['supervisors'] as $supervisor)
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
            </div>
        </div>
    </div>

    <div class="flex flex-col items-start gap-4 sm:flex-row">
        <div
            class="relative flex-1 p-6 sm:p-8 rounded-xl dark:bg-slate-800 bg-white sm:border-t-0 border-t-[12px] sm:border-l-[14px] shadow dark:shadow-gray-500 border-primary-700">
            <div class="font-semibold mb-9 sm:w-56 lg:w-72 text-primary-700 dark:text-primary-300">
                {{ __('Guidance Journey') }}
            </div>
            <livewire:student.guidance-journey :$student />
        </div>
        <div
            class="relative w-full sm:w-2/5 p-6 sm:p-8 rounded-xl dark:bg-slate-800 bg-white sm:border-t-0 border-t-[12px] sm:border-l-[14px] shadow dark:shadow-gray-500 border-primary-700">
            <div class="font-semibold w-44 mb-9 sm:w-56 lg:w-72 text-primary-700 dark:text-primary-300">
                {{ __('Recap') }}
            </div>
            <div class="space-y-2 sm:space-y-3">
                @foreach ($recap as $item)
                    <div class="flex gap-3">
                        <div class="w-40 font-semibold sm:w-56 lg:w-72 text-primary-700 dark:text-primary-300">
                            {{ $item['title'] }}
                        </div>
                        <div class="flex-1 dark:text-gray-100">
                            {{ $item['value'] }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

</x-content>
