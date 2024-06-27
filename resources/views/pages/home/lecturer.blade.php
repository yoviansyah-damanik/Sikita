<x-content>
    <div class="grid gap-4 sm:grid-cols-12">
        <div class="sm:col-span-3">
            <x-notification />
        </div>
        <div class="sm:col-span-9">
            <x-box-grid>
                <x-box color="yellow" icon="i-ph-student" :to="route('lecturer.student')" :title="__('Active Students')" :number="$activeStudents"></x-box>
                <x-box color="green" icon="i-ph-student" :to="route('lecturer.student')" :title="__('Students Passed')" :number="$studentsPassed"></x-box>
                <x-box color="primary" icon="i-ph-student" :to="route('lecturer.student')" :title="__(':total Total', ['total' => __('Guidance\'s Student')])" :number="$guidancesStudent"></x-box>
                <x-box color="oceanBlue" :to="route('lecturer.guidance')" icon="i-ph-book-open-text" :title="__('Guidance')"
                    :number="$guidances"></x-box>
                <x-box color="red" icon="i-ph-book-open-text" :title="__('Revisions')" :number="$revisions"></x-box>
                <x-box color="yellow" icon="i-ph-book-open-text" :title="__('Reviews')" :number="$reviews"></x-box>
            </x-box-grid>
        </div>
    </div>
</x-content>
