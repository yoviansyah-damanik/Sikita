<x-content>
    <x-content.title :title="__('Guidance\'s Review')" :description="__('Review the guidance that students have submitted.')" />

    <x-alert type="info">
        {{ __('Please note the guidance submission that has been submitted by the Student. Submission of guidance starts from the last time it was submitted.') }}
    </x-alert>

    <x-student-information :student="$studentData" />

    @if ($studentData['is_passed']['status'])
        <x-alert type="success">
            {{ __('Congratulation. Your Guidance Student has graduated. You can only see the history of guidance that has been carried out.') }}
        </x-alert>
        <x-student-passed-information :gradeNumber="$studentData['is_passed']['data']['grade_number']" :grade="$studentData['is_passed']['data']['grade']" />
    @endif

    <div class="flex flex-col items-start gap-4 sm:flex-row sm:gap-6">
        <div class="flex-1 w-full space-y-3 sm:flex-none sm:w-1/3 2xl:w-1/4 sm:space-y-4">
            <x-button :href="route('lecturer.guidance.detail', ['student' => $studentData['data']['npm']])" block color="red" icon="i-ph-arrow-left">{{ __('Back') }}</x-button>
            <x-accordion type="fill" :title="__('Review')" open="true">
                <livewire:guidance.create-review :guidance="$guidance" :isFinish="$studentData['is_passed']['status']" :finalProject="$studentData['final_project']['guidances'][0]"
                    :student="$studentData['data']" />
            </x-accordion>
            <x-accordion type="fill" :title="__('Guidance\'s Submission')" open="true">
                <div class="p-2">
                    @forelse ($studentData['final_project']['guidances'][0]['types'][0]['submissions'] as $submission)
                        <livewire:guidance.review-student-submission :$submission :key="$submission['id']" :iteration="$loop->iteration"
                            :activeId="$activeSubmission['id']" />
                    @empty
                        <div class="text-center">
                            {{ __('No :data found', ['data' => Str::lower(__('Guidance'))]) }}
                        </div>
                    @endforelse
                </div>
            </x-accordion>
            <x-accordion type="fill" :title="__('Revision')" open="true">
                <livewire:guidance.review-revision :isFinish="$studentData['is_passed']['status']" :guidance="$studentData['final_project']['guidances'][0]['types'][0]['guidance_id']" />
            </x-accordion>
        </div>
        <div class="flex flex-col flex-1 gap-3 sm:gap-6">
            <div class="p-6 bg-white rounded-lg dark:bg-slate-800 sm:p-8">
                <div class="space-y-1">
                    <div class="font-semibold text-ocean-blue-700 dark:text-ocean-blue-300">
                        {{ $studentData['final_project']['guidances'][0]['types'][0]['name'] }}
                    </div>
                    <div class="font-light">
                        {{ $studentData['final_project']['guidances'][0]['types'][0]['description'] }}
                    </div>

                </div>
            </div>
            <div class="p-6 bg-white rounded-lg dark:bg-slate-800 sm:p-8">
                <div class="mb-6 space-y-1">
                    <div class="font-semibold text-ocean-blue-700 dark:text-ocean-blue-300">
                        {{ $activeSubmission['title'] }}
                    </div>
                    <div class="font-light">
                        {{ $activeSubmission['description'] }}
                    </div>
                </div>
                <embed type="application/pdf" src="{{ $source }}" width="100%" height="600"></embed>
            </div>
        </div>
    </div>

    @if (!$studentData['is_passed']['status'])
        <x-modal name="create-revision-modal" size="3xl" :modalTitle="__('Add :add', ['add' => __('Revision')])">
            <livewire:revision.create />
        </x-modal>
        <x-modal name="edit-revision-modal" size="3xl" :modalTitle="__('Edit :edit', ['edit' => __('Revision')])">
            <livewire:revision.edit />
        </x-modal>
        <x-modal name="set-revision-status-modal" size="xl" :modalTitle="__('Set Revision Status')">
            <livewire:revision.set-status />
        </x-modal>
    @endif
    <x-modal name="show-revision-modal" size="3xl" :modalTitle="__('Show :show', ['show' => __('Revision')])">
        <livewire:revision.show />
    </x-modal>
    <x-modal name="show-guidances-revision-modal" size="4xl" :modalTitle="__('Show :show', ['show' => __('Guidance\'s Revision')])">
        <livewire:guidance.show-revision />
    </x-modal>
</x-content>
