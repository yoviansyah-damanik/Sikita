<hr class="h-px !my-8 border-0 bg-primary-700 dark:bg-gray-700">

<div class="flex flex-col gap-4">
    <div class="w-full p-6 text-center bg-white rounded-lg shadow dark:bg-slate-800 sm:p-8">
        <div class="mb-4 font-semibold text-primary-700 dark:text-primary-300">
            {{ __('Final Project Title') }}
        </div>
        <div class="text-2xl italic font-semibold sm:text-3xl dark:text-gray-100">
            @if ($student['final_project'])
                {{ $student['final_project']['data']['title'] }}
            @else
                -
            @endif
        </div>
    </div>
    <div class="flex flex-col items-start gap-3 sm:gap-4 sm:flex-row">
        <div
            class="relative w-full p-6 overflow-hidden bg-white border-l-[14px] rounded-lg shadow sm:p-8 dark:bg-slate-800 dark:text-gray-100 border-primary-700">
            <div class="w-full mb-4 font-semibold">
                {{ __(':data Data', ['data' => __('Student')]) }}
            </div>
            <div class="flex">
                <div class="w-40 font-semibold">
                    {{ __('NPM') }}
                </div>
                <div class="flex-1">
                    {{ $student['data']['npm'] }}
                </div>
            </div>
            <div class="flex">
                <div class="w-40 font-semibold">
                    {{ __('Name') }}
                </div>
                <div class="flex-1">
                    {{ $student['data']['name'] }}
                </div>
            </div>
            <div class="flex">
                <div class="w-40 font-semibold">
                    {{ __('Gender') }}
                </div>
                <div class="flex-1">
                    {{ $student['data']['gender'] }}
                </div>
            </div>
            <div class="flex">
                <div class="w-40 font-semibold">
                    {{ __('Semester') }}
                </div>
                <div class="flex-1">
                    {{ $student['data']['semester'] }}
                </div>
            </div>
            <div class="flex">
                <div class="w-40 font-semibold">
                    {{ __('Stamp') }}
                </div>
                <div class="flex-1">
                    {{ $student['data']['stamp'] }}
                </div>
            </div>

            <div class="absolute bottom-0 right-0 i-ph-student size-16 text-primary-700"></div>
        </div>

        @forelse ($student['supervisors'] as $supervisor)
            <div @class([
                'relative w-full p-6 bg-white rounded-lg shadow sm:p-8 dark:bg-slate-800 overflow-hidden border-l-[14px] dark:text-gray-100',
                'border-red-700' =>
                    $supervisor['nidn'] == auth()->user()->data->id &&
                    auth()->user()->role == 'lecturer',
                'border-primary-700' =>
                    $supervisor['nidn'] != auth()->user()->data->id ||
                    auth()->user()->role != 'lecturer',
            ])>
                <div @class([
                    'w-full mb-4 font-semibold',
                    'text-red-700' =>
                        $supervisor['nidn'] == auth()->user()->data->id &&
                        auth()->user()->role == 'lecturer',
                ])>
                    {{ __('Supervisor :1', ['1' => Str::substr($supervisor['as'], -1)]) }}
                </div>
                <div class="flex">
                    <div class="w-40 font-semibold">
                        {{ __('NIDN') }}
                    </div>
                    <div class="flex-1">
                        {{ $supervisor['nidn'] }}
                    </div>
                </div>
                <div class="flex">
                    <div class="w-40 font-semibold">
                        {{ __('Name') }}
                    </div>
                    <div class="flex-1">
                        {{ $supervisor['name'] }}
                    </div>
                </div>
                <div class="absolute bottom-0 right-0 i-ph-chalkboard-teacher-fill size-16 text-primary-700"></div>
            </div>
        @empty
            @foreach (range(1, 2) as $idx)
                <div @class([
                    'relative w-full p-6 bg-white rounded-lg shadow sm:p-8 dark:bg-slate-800 overflow-hidden border-l-[14px] border-primary-700',
                ])>
                    <div @class(['w-full mb-4 font-semibold'])>
                        {{ __('Supervisor :1', ['1' => $idx]) }}
                    </div>
                    <div class="flex">
                        <div class="w-40 font-semibold">
                            {{ __('NIDN') }}
                        </div>
                        <div class="flex-1">
                            -
                        </div>
                    </div>
                    <div class="flex">
                        <div class="w-40 font-semibold">
                            {{ __('Name') }}
                        </div>
                        <div class="flex-1">
                            -
                        </div>
                    </div>
                    <div class="absolute bottom-0 right-0 i-ph-chalkboard-teacher-fill size-16 text-primary-700"></div>
                </div>
            @endforeach
        @endforelse
    </div>
</div>

<hr class="h-px !my-8 border-0 bg-primary-700 dark:bg-gray-700">
