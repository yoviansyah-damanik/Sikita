<x-content>
    <x-content.title :title="__('Guidance\'s Detail')" :description="__('Please select the type of guidance that will be reviewed.')" />

    <x-student-information :student="$studentData" />

    @if ($studentData['is_passed']['status'])
        <x-alert type="success">
            {{ __('Congratulation. Your Guidance Student has graduated. You can only see the history of guidance that has been carried out.') }}
        </x-alert>
        <x-student-passed-information :gradeNumber="$studentData['is_passed']['data']['grade_number']" :grade="$studentData['is_passed']['data']['grade']" />
    @endif

    <div id="guidance-group" class="flex-1 order-1 space-y-3 sm:space-y-4 sm:order-0">
        <x-form.select block wire:model.live='group' wire:change="$dispatch('clearShowGuidance')" :items="$this->groups" />

        @forelse ($studentData['final_project']['guidances'] as $group)
            <div class="p-6 bg-white rounded-lg dark:bg-slate-800 sm:p-8">
                <div class="pb-3 mb-6 border-b-4 sm:mb-8 border-ocean-blue-300 dark:border-ocean-blue-100">
                    <div class="text-lg font-semibold text-ocean-blue-700 dark:text-ocean-blue-300">
                        {{ $group['name'] }}
                    </div>
                    <div class="font-lighter dark:text-gray-100">
                        {{ $group['description'] }}
                    </div>
                </div>

                <div class="space-y-3 sm:space-y-4">
                    @forelse ($group['types'] as $type)
                        <div
                            class="flex flex-col gap-4 p-6 sm:flex-row sm:p-4 bg-primary-50 dark:bg-slate-800 dark:border-b dark:last:border-b-0 dark:border-gray-100 sm:gap-6">
                            <div class="flex-1">
                                <div class="flex flex-col items-start gap-3">
                                    <div class="font-semibold text-ocean-blue-700 dark:text-ocean-blue-300">
                                        {{ $type['name'] }}
                                    </div>
                                    <div class="font-light dark:text-gray-100">
                                        {{ $type['description'] }}
                                    </div>
                                </div>

                                <div class="pt-4 my-4 border-t dark:text-gray-100">
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="font-semibold">
                                            {{ __("Guidance's History") }}
                                        </div>
                                        @if (!empty($type['histories']))
                                            <x-button color="transparent" size="sm" base="!font-normal"
                                                x-on:click="$dispatch('toggle-show-guidances-history-modal')"
                                                wire:click="$dispatch('setShowGuidancesHistory', { guidance: {{ $type['guidance_id'] }} })">
                                                {{ __('Show More') }}
                                            </x-button>
                                        @endif
                                    </div>

                                    @if ($type['histories'])
                                        <div class="space-y-3 sm:space-y-4">
                                            @foreach (array_slice($type['histories'], 0, 3) as $history)
                                                <div class="flex gap-3">
                                                    <span @class([
                                                        'size-4 mt-1',
                                                        'i-solar-check-circle-line-duotone text-green-700' =>
                                                            $history['type'] == 'success',
                                                        'i-solar-danger-circle-line-duotone text-yellow-700' =>
                                                            $history['type'] == 'warning',
                                                        'i-solar-bell-bing-bold-duotone text-red-700' =>
                                                            $history['type'] == 'error',
                                                    ])></span>
                                                    <div class="flex-1">
                                                        {{ $history['message'] }}
                                                        <div
                                                            class="flex items-center gap-1 mt-1 text-sm text-gray-700 dark:text-gray-100">
                                                            <span class="i-ph-clock"></span>
                                                            {{ \Carbon\Carbon::parse($history['created_at'])->diffForHumans() }}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <x-no-data />
                                    @endif
                                </div>
                            </div>
                            <div class="flex-1 w-full sm:flex-none sm:w-80 2xl:w-96">
                                @if ($type['guidance_id'] && count($type['submissions']) > 0)
                                    <div class="flex gap-4 justify-evenly">
                                        @foreach ($type['reviewers'] as $reviewer)
                                            <x-guidance.review :$reviewer :iteration="Str::substr($reviewer['as'], -1)" />
                                        @endforeach
                                    </div>
                                    <x-button color="primary" block base="mt-4" :href="route('lecturer.guidance.review', [
                                        'student' => $studentData['data']['npm'],
                                        'guidance' => $type['guidance_id'],
                                    ])">
                                        {{ __('Review') }}
                                    </x-button>
                                @else
                                    <x-button color="inactive" block base="mt-4" disabled=true>
                                        {{ __('No :data found', ['data' => Str::lower(__("Guidance's Submission"))]) }}
                                    </x-button>
                                @endif
                                <div class="pt-4 mt-4 border-t">
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="font-semibold dark:text-gray-100">
                                            {{ __(':status Status', ['status' => __('Revision')]) }}
                                        </div>
                                        <x-button color="transparent" size="sm" base="!font-normal"
                                            x-on:click="$dispatch('toggle-show-guidances-revision-modal')"
                                            wire:click="$dispatch('setShowGuidancesRevision', { guidance: {{ $type['guidance_id'] }} })">
                                            {{ __('Show More') }}
                                        </x-button>
                                    </div>
                                    <div class="flex flex-col justify-between gap-3 mt-3 dark:text-gray-100">
                                        <div class="flex items-center justify-between flex-1">
                                            {{ __('Done') }}
                                            <span
                                                class="font-semibold">{{ !empty($type['revisions']) ? $type['revisions']['count']['done'] : 0 }}</span>
                                        </div>
                                        <div class="flex items-center justify-between flex-1">
                                            {{ __('Not Done') }}
                                            <span
                                                class="font-semibold">{{ !empty($type['revisions']) ? $type['revisions']['count']['on_progress'] : 0 }}</span>
                                        </div>
                                        <div class="flex items-center justify-between flex-1">
                                            {{ __('Total') }}
                                            <span
                                                class="font-semibold">{{ !empty($type['revisions']) ? $type['revisions']['count']['total'] : 0 }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <x-no-data />
                    @endforelse
                </div>
            </div>
        @empty
            <x-no-data />
        @endforelse
    </div>

    <x-modal name="show-guidances-revision-modal" size="4xl" :modalTitle="__('Show :show', ['show' => __('Guidance\'s Revision')])">
        <livewire:guidance.show-revision />
    </x-modal>
    <x-modal name="show-guidances-history-modal" size="4xl" :modalTitle="__('Show :show', ['show' => __('Guidance\'s History')])">
        <livewire:guidance.show-history />
    </x-modal>
</x-content>
