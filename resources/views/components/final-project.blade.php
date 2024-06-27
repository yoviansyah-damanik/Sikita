<div class="flex flex-col sm:flex-row rounded-xl min-h-[28rem] overflow-hidden">
    <div
        class="bg-gradient-to-br sm:bg-gradient-to-tr text-base from-primary-500 to-primary-700 p-2 [writing-mode:horizontal-tb] sm:[writing-mode:vertical-rl] text-center font-semibold text-white sm:tracking-[0.25em]">
        {{ __('Final Project') }}
    </div>
    @if ($student['final_project'])
        <div
            class="flex-1 p-4 space-y-4 sm:p-6 sm:space-y-6 bg-gradient-to-br to-primary-100 dark:from-slate-700 from-white">
            <div class="text-lg font-bold sm:text-xl text-primary-700 dark:text-primary-100">
                {{ $student['final_project']['data']['title'] }}
            </div>
            <div class="text-base font-normal text-gray-700 dark:text-primary-50 line-clamp-4">
                {{ $student['final_project']['data']['abstract'] }}
            </div>
            @if ($student['supervisors'])
                <div class="flex flex-col gap-3 sm:gap-12 sm:items-center sm:flex-row">
                    @foreach ($student['supervisors'] as $supervisor)
                        <div class="flex items-center gap-3">
                            <div class="w-12 py-3 text-4xl font-semibold text-white bg-primary-700 text-end">1</div>
                            <div>
                                <div class="font-semibold dark:text-primary-100">{{ $supervisor['name'] }}
                                </div>
                                <div class="font-light dark:text-primary-50">NIDN. {{ $supervisor['nidn'] }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div>
                    {{ __('No supervisors found. Please confirm with the staff to assign a supervisor.') }}
                </div>
            @endif
            <div
                class="flex px-3 overflow-hidden rounded-2xl bg-gradient-to-br from-primary-50 to-primary-100 dark:bg-slate-300">
                <div class="relative flex items-start gap-3 py-2" aria-hidden="true">
                    <span @class([
                        'size-4 mt-1',
                        'i-solar-check-circle-line-duotone text-green-700' =>
                            $student['final_project']['data']['histories'][0]['status'] ==
                            'success',
                        'i-solar-danger-circle-line-duotone text-yellow-700' =>
                            $student['final_project']['data']['histories'][0]['status'] ==
                            'warning',
                        'i-solar-bell-bing-bold-duotone text-cyan-700' =>
                            $student['final_project']['data']['histories'][0]['status'] ==
                            'information',
                    ])></span>
                    <div class="flex-1">
                        {{ $student['final_project']['data']['histories'][0]['message'] }}
                    </div>
                </div>
            </div>
            <div class="relative overflow-hidden rounded-xl bg-primary-100 dark:bg-slate-300">
                <div class="w-full h-5 text-sm text-center text-white min-w-16 bg-gradient-to-r from-primary-500 to-primary-700 rounded-xl"
                    style="max-width: {{ $student['percentage'] }}%">
                    {{ $student['percentage'] }}%
                </div>
            </div>
            <div class="text-center sm:text-end">
                <x-button :href="route('student.final-project')" color="primary" radius="rounded-full"
                    base="inline-flex gap-3 items-center px-6" icon="i-solar-arrow-right-line-duotone"
                    iconPosition="right">
                    {{ __('Show') }}
                </x-button>
            </div>
        </div>
    @else
        <div
            class="flex-1 p-4 space-y-4 sm:p-6 sm:space-y-6 bg-gradient-to-br to-primary-100 dark:from-slate-700 from-white">
            <div class="grid w-full h-full place-items-center">
                <x-not-found class="w-64 max-w-full mx-auto" :text="__('Final Project')" />
            </div>
        </div>
    @endif
</div>
