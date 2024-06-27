<x-content>
    <x-content.title :title="__('Students')" :description="__('List of registered student data.')" />

    <div class="hidden gap-3 sm:flex">
        <x-form.input class="flex-1" type="search" :placeholder="__('Search by :1 or :2', ['1' => 'NPM', '2' => __(':name Name', ['name' => __('Student')])])" block wire:model.live.debounce.750ms='search' />
        <x-form.select :items="$activationTypes" wire:model.live='activationType' :loading="$viewActive != 'registered_students'" />
        <x-button color="primary" icon="i-ph-plus"
            x-on:click="$dispatch('toggle-create-student-modal')">{{ __('Add :add', ['add' => __('Student')]) }}</x-button>
    </div>
    <div class="flex flex-col gap-3 sm:hidden">
        <x-form.input block type="search" :placeholder="__('Search by :1 or :2', ['1' => 'NPM', '2' => __(':name Name', ['name' => __('Student')])])" block wire:model.live.debounce.750ms='search' />
        <x-form.select block :items="$activationTypes" wire:model.live='activationType' :loading="$viewActive != 'registered_students'" />
        <x-button block color="primary" icon="i-ph-plus"
            x-on:click="$dispatch('toggle-create-student-modal')">{{ __('Add :add', ['add' => __('Student')]) }}</x-button>
    </div>

    <div>
        <div class="flex overflow-hidden shadow rounded-xl">
            @foreach ($viewList as $idx => $view)
                <label for="view-{{ $idx + 1 }}"
                    class="relative flex-1 gap-1 overflow-hidden border-r cursor-pointer last:border-r-0">
                    <input name="view" wire:loading.attr='disabled' wire:model.live='viewActive'
                        class="hidden peer/view" id="view-{{ $idx + 1 }}" type="radio"
                        value="{{ $view }}" />
                    <div
                        class="w-full h-full px-3 py-2 font-medium text-center text-gray-700 bg-primary-50 peer-checked/view:text-gray-100 peer-checked/view:bg-primary-700 peer-checked/view:opacity-100 ">
                        {{ __(Str::headline($view)) }}
                    </div>
                </label>
            @endforeach
        </div>
        @error('type')
            <div class="mt-1 text-red-700">
                {{ $message }}
            </div>
        @enderror
    </div>

    @if ($viewActive == 'registered_students')
        <x-table :columns="[
            '#',
            'NPM',
            __('Fullname'),
            __('Semester'),
            __('Stamp'),
            __('Gender'),
            __('Supervisors'),
            __('Status'),
            __(':status Status', ['status' => __('User')]),
            '',
        ]">
            <x-slot name="body">
                @forelse ($students as $student)
                    <x-table.tr>
                        <x-table.td class="w-16" centered>
                            {{ $students->perPage() * ($students->currentPage() - 1) + $loop->iteration }}
                        </x-table.td>
                        <x-table.td centered>
                            {{ $student['data']['npm'] }}
                        </x-table.td>
                        <x-table.td>
                            {{ $student['data']['name'] }}
                        </x-table.td>
                        <x-table.td centered>
                            {{ $student['data']['semester'] }}
                        </x-table.td>
                        <x-table.td centered>
                            {{ $student['data']['stamp'] }}
                        </x-table.td>
                        <x-table.td centered>
                            {{ $student['data']['gender'] }}
                        </x-table.td>
                        <x-table.td>
                            <div @class([
                                'mb-3' => !empty($student['final_project'])
                                    ? !collect($student['final_project']['guidances'])->some(
                                        fn($guidance) => collect($guidance['types'])->some(
                                            fn($type) => count($type['submissions']) > 0))
                                    : true,
                            ])>
                                @if ($student['supervisors'])
                                    <div class="flex flex-col gap-3">
                                        @foreach ($student['supervisors'] as $supervisor)
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
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center">
                                        -
                                    </div>
                                @endif
                            </div>
                            @if (
                                !empty($student['final_project'])
                                    ? !collect($student['final_project']['guidances'])->some(
                                        fn($guidance) => collect($guidance['types'])->some(fn($type) => count($type['submissions']) > 0))
                                    : true)
                                <div class="text-center">
                                    <x-button color="yellow" size="sm" icon="i-ph-pen"
                                        x-on:click="$dispatch('toggle-assign-supervisors-modal')"
                                        wire:click="$dispatch('setAssignSupervisors', { student: {{ $student['data']['npm'] }} } )">
                                        {{ __('Assign Supervisors') }}
                                    </x-button>
                                </div>
                            @endif
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
                        <x-table.td centered>
                            <x-badge :type="$student['user']['is_suspended'] ? 'error' : 'success'">
                                {{ $student['user']['is_suspended'] ? __('Suspended') : __('Active') }}
                            </x-badge>
                        </x-table.td>
                        <x-table.td centered class="w-48">
                            <x-tooltip :title="__('View')">
                                <x-button color="cyan" icon="i-ph-eye" size="sm"
                                    x-on:click="$dispatch('toggle-show-student-modal')"
                                    wire:click="$dispatch('setStudent', { student: {{ $student['data']['npm'] }} } )">
                                </x-button>
                            </x-tooltip>
                            <x-tooltip :title="__('Activation Menu')">
                                <x-button size="sm" icon="i-ph-user-check" color="green"
                                    x-on:click="$dispatch('toggle-user-activation-modal')"
                                    wire:click="$dispatch('setUserActivation',{ user: {{ $student['user']['id'] }} })" />
                            </x-tooltip>
                            <x-tooltip :title="__('Guidance Journey')">
                                <x-button size="sm" icon="i-ph-folder-simple-user" color="yellow"
                                    x-on:click="$dispatch('toggle-show-guidance-journey-modal')"
                                    wire:click="$dispatch('setGuidanceJourney',{ studentId: {{ $student['data']['npm'] }} })" />
                            </x-tooltip>
                            <x-tooltip :title="__('Set Pass Status')">
                                <x-button size="sm" icon="i-ph-user-list" color="red"
                                    x-on:click="$dispatch('toggle-set-pass-status-modal')"
                                    wire:click="$dispatch('setPassStatus',{ student: {{ $student['data']['npm'] }}, passType: 'passed' })" />
                            </x-tooltip>
                        </x-table.td>
                    </x-table.tr>
                @empty
                    <x-table.tr>
                        <x-table.td colspan="10">
                            <x-no-data />
                        </x-table.td>
                    </x-table.tr>
                @endforelse
            </x-slot>

            <x-slot name="paginate">
                {{ $students->links(data: ['scrollTo' => 'table']) }}
            </x-slot>
        </x-table>
    @elseif($viewActive == 'student_registration')
        <x-table :columns="['#', 'NPM', __('Fullname'), __('Email'), __('Phone Number'), __('Token'), __('Expired Date'), '']">
            <x-slot name="body">
                @forelse ($students as $student)
                    <x-table.tr>
                        <x-table.td class="w-20" centered>
                            {{ $students->perPage() * ($students->currentPage() - 1) + $loop->iteration }}
                        </x-table.td>
                        <x-table.td centered>
                            {{ $student->student_id }}
                        </x-table.td>
                        <x-table.td>
                            {{ $student->name }}
                        </x-table.td>
                        <x-table.td>
                            {{ $student->email }}
                        </x-table.td>
                        <x-table.td centered>
                            {{ $student->phone_number }}
                        </x-table.td>
                        <x-table.td centered>
                            <x-form.input type="password" :value="$student->token" :readonly="true">
                            </x-form.input>
                        </x-table.td>
                        <x-table.td centered>
                            {{ $student->expired_at ? \Carbon\Carbon::parse($student->expired_at)->translatedFormat('d F Y H:i:s') : '-' }}
                        </x-table.td>
                        <x-table.td centered>
                            <x-tooltip :title="__('Delete')">
                                <x-button size="sm" icon="i-ph-trash" color="red"
                                    x-on:click="$dispatch('toggle-delete-registration-modal')"
                                    wire:click="$dispatch('setDeleteRegistration',{ register: {{ $student->id }} })" />
                            </x-tooltip>
                        </x-table.td>
                    </x-table.tr>
                @empty
                    <x-table.tr>
                        <x-table.td colspan="10">
                            <x-no-data />
                        </x-table.td>
                    </x-table.tr>
                @endforelse
            </x-slot>

            <x-slot name="paginate">
                {{ $students->links(data: ['scrollTo' => false]) }}
            </x-slot>
        </x-table>
    @elseif($viewActive == 'students_passed')
        <x-table :columns="[
            '#',
            'NPM',
            __('Fullname'),
            __('Passed Semester'),
            __('Passed Year'),
            __('Grade'),
            __('Grade in Numbers'),
            __('Supervisors'),
            __('User Status'),
            '',
        ]">
            <x-slot name="body">
                @forelse ($students as $student)
                    <x-table.tr>
                        <x-table.td class="w-16" centered>
                            {{ $students->perPage() * ($students->currentPage() - 1) + $loop->iteration }}
                        </x-table.td>
                        <x-table.td centered>
                            {{ $student['data']['npm'] }}
                        </x-table.td>
                        <x-table.td>
                            {{ $student['data']['name'] }}
                        </x-table.td>
                        <x-table.td centered>
                            {{ $student['is_passed']['data']['semester'] }}
                        </x-table.td>
                        <x-table.td centered>
                            {{ $student['is_passed']['data']['year'] }}
                        </x-table.td>
                        <x-table.td centered>
                            {{ $student['is_passed']['data']['grade'] }}
                        </x-table.td>
                        <x-table.td centered>
                            {{ $student['is_passed']['data']['grade_number'] }}
                        </x-table.td>
                        <x-table.td>
                            <div @class([
                                'mb-3' => !empty($student['final_project'])
                                    ? !collect($student['final_project']['guidances'])->some(
                                        fn($guidance) => collect($guidance['types'])->some(
                                            fn($type) => count($type['submissions']) > 0))
                                    : false,
                            ])>
                                @if ($student['supervisors'])
                                    <div class="flex flex-col gap-3">
                                        @foreach ($student['supervisors'] as $supervisor)
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
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center">
                                        -
                                    </div>
                                @endif
                            </div>
                            @if (
                                !empty($student['final_project'])
                                    ? !collect($student['final_project']['guidances'])->some(
                                        fn($guidance) => collect($guidance['types'])->some(fn($type) => count($type['submissions']) > 0))
                                    : false)
                                <div class="text-center">
                                    <x-button color="yellow" size="sm" icon="i-ph-pen"
                                        x-on:click="$dispatch('toggle-assign-supervisors-modal')"
                                        wire:click="$dispatch('setAssignSupervisors', { student: {{ $student['data']['npm'] }} } )">
                                        {{ __('Assign Supervisors') }}
                                    </x-button>
                                </div>
                            @endif
                        </x-table.td>
                        <x-table.td centered>
                            <x-badge :type="$student['user']['is_suspended'] ? 'error' : 'success'">
                                {{ $student['user']['is_suspended'] ? __('Suspended') : __('Active') }}
                            </x-badge>
                        </x-table.td>
                        <x-table.td centered class="w-48">
                            <x-tooltip :title="__('View')">
                                <x-button color="cyan" icon="i-ph-eye" size="sm"
                                    x-on:click="$dispatch('toggle-show-student-modal')"
                                    wire:click="$dispatch('setStudent', { student: {{ $student['data']['npm'] }} } )">
                                </x-button>
                            </x-tooltip>
                            <x-tooltip :title="__('Activation Menu')">
                                <x-button size="sm" icon="i-ph-user-check" color="green"
                                    x-on:click="$dispatch('toggle-user-activation-modal')"
                                    wire:click="$dispatch('setUserActivation',{ user: {{ $student['user']['id'] }} })" />
                            </x-tooltip>
                            <x-tooltip :title="__('Guidance Journey')">
                                <x-button size="sm" icon="i-ph-folder-simple-user" color="yellow"
                                    x-on:click="$dispatch('toggle-show-guidance-journey-modal')"
                                    wire:click="$dispatch('setGuidanceJourney',{ studentId: {{ $student['data']['npm'] }} })" />
                            </x-tooltip>
                            <x-tooltip :title="__('Set Pass Status')">
                                <x-button size="sm" icon="i-ph-user-list" color="red"
                                    x-on:click="$dispatch('toggle-set-pass-status-modal')"
                                    wire:click="$dispatch('setPassStatus',{ student: {{ $student['data']['npm'] }}, passType: 'passed' })" />
                            </x-tooltip>
                        </x-table.td>
                    </x-table.tr>
                @empty
                    <x-table.tr>
                        <x-table.td colspan="10">
                            <x-no-data />
                        </x-table.td>
                    </x-table.tr>
                @endforelse
            </x-slot>

            <x-slot name="paginate">
                {{ $students->links(data: ['scrollTo' => 'table']) }}
            </x-slot>
        </x-table>
    @endif

    <div wire:ignore>
        <x-modal name="user-activation-modal" size="xl" :modalTitle="__('User Activation')">
            <livewire:users.user-activation />
        </x-modal>
        <x-modal name="show-student-modal" size="3xl" :modalTitle="__(':data Data', ['data' => __('Student')])">
            <livewire:student.show-data />
        </x-modal>
        <x-modal name="create-student-modal" size="3xl" :modalTitle="__('Add :add', ['add' => __('Student')])">
            <livewire:student.create />
        </x-modal>
        <x-modal name="delete-registration-modal" size="xl" :modalTitle="__('Delete Registration')">
            <livewire:student.delete-registration />
        </x-modal>
        <x-modal name="assign-supervisors-modal" size="3xl" :modalTitle="__('Assign Supervisors')">
            <livewire:student.assign-supervisors />
        </x-modal>
        <x-modal name="set-pass-status-modal" size="3xl" :modalTitle="__('Set Pass Status')">
            <livewire:student.set-pass-status />
        </x-modal>
        <x-modal name="show-guidance-journey-modal" size="4xl" :modalTitle="__('Guidance Journey')">
            <livewire:student.guidance-journey-modal />
        </x-modal>
    </div>
</x-content>
