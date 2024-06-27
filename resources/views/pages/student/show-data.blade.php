<x-modal.body>
    @if (!$isLoading)
        @if (!empty($student))
            <div class="space-y-3 text-gray-700 sm:space-y-4 dark:text-gray-100">
                <div class="flex items-start">
                    <div class="w-44">
                        {{ __('NPM') }}
                    </div>
                    <div class="flex-1 font-semibold">
                        @if (auth()->user()->role == 'staff')
                            <a href="{{ route('staff.student', ['search' => $student['data']['npm'] ?? '-']) }}"
                                wire:navigate>{{ $student['data']['npm'] ?? '-' }}</a>
                        @elseif(auth()->user()->role == 'lecturer')
                            <a href="{{ route('lecturer.student', ['search' => $student['data']['npm'] ?? '-']) }}"
                                wire:navigate>{{ $student['data']['npm'] ?? '-' }}</a>
                        @else
                            {{ $student['data']['npm'] ?? '-' }}
                        @endif
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="w-44">
                        {{ __('Name') }}
                    </div>
                    <div class="flex-1">
                        {{ $student['data']['name'] ?? '-' }}
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="w-44">
                        {{ __('Address') }}
                    </div>
                    <div class="flex-1">
                        {{ $student['data']['address'] ?? '-' }}
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="w-44">
                        {{ __('Place of Birth') }}
                    </div>
                    <div class="flex-1">
                        {{ $student['data']['place_of_birth'] ?? '-' }}
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="w-44">
                        {{ __('Date of Birth') }}
                    </div>
                    <div class="flex-1">
                        {{ !empty($student['data']['date_of_birth']) ? \Carbon\Carbon::parse($student['data']['date_of_birth'])->translatedFormat('d F Y') : '-' }}
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="w-44">
                        {{ __('Stamp') }}
                    </div>
                    <div class="flex-1">
                        {{ $student['data']['stamp'] ?? '-' }}
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="w-44">
                        {{ __('Semester') }}
                    </div>
                    <div class="flex-1">
                        {{ $student['data']['semester'] ?? '-' }}
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="w-44">
                        {{ __('Phone Number') }}
                    </div>
                    <div class="flex-1">
                        {{ $student['data']['phone_number'] ?? '-' }}
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="w-44">
                        {{ __('Email') }}
                    </div>
                    <div class="flex-1 break-all">
                        {{ $student['user']['email'] ?? '-' }}
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="w-44">
                        {{ __('Supervisors') }}
                    </div>
                    <div class="flex flex-col flex-1 gap-3 sm:flex-row">
                        @forelse ($student['supervisors'] as $supervisor)
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
                        @empty
                            {{ __('Supervisor has not yet been appointed') }}
                        @endforelse
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="w-44">
                        {{ __('Status') }}
                    </div>
                    <div class="flex-1">
                        <x-badge :type="$student['status']['code'] == 0
                            ? 'error'
                            : ($student['status']['code'] == 1
                                ? 'warning'
                                : 'success')">
                            {{ $student['status']['message'] }}
                        </x-badge>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="w-44">
                        {{ __('User Status') }}
                    </div>
                    <div class="flex-1">
                        <x-badge :type="$student['user']['is_suspended'] ? 'error' : 'success'">
                            {{ $student['user']['is_suspended'] ? __('Suspended') : __('Active') }}
                        </x-badge>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="w-44">
                        {{ __(':status Status', ['status' => __('Passed')]) }}
                    </div>
                    <div class="flex-1">
                        <x-badge :type="$student['is_passed']['status'] ? 'success' : 'warning'">
                            {{ $student['is_passed']['message'] }}
                        </x-badge>
                    </div>
                </div>
                @if ($student['is_passed']['status'])
                    <div class="flex items-start">
                        <div class="w-44">
                            {{ __('Grade') }}
                        </div>
                        <div class="flex-1">
                            {{ $student['is_passed']['data']['grade'] }}
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="w-44">
                            {{ __('Grade in Numbers') }}
                        </div>
                        <div class="flex-1">
                            {{ $student['is_passed']['data']['grade_number'] }}
                        </div>
                    </div>
                @endif

                @if (auth()->user()->role == 'lecturer')
                    <div class="flex items-start">
                        <div class="w-44">
                            {{ __('Guidance') }}
                        </div>
                        <div class="flex-1">
                            <x-button color="primary" size="sm" :href="route('lecturer.guidance.detail', ['student' => $student['data']['npm']])">
                                {{ __('View :view', ['view' => __('Guidance')]) }}
                            </x-button>
                        </div>
                    </div>
                @endif
            </div>
        @else
            <x-no-data />
        @endif
    @else
        <x-loading />
    @endif
</x-modal.body>
