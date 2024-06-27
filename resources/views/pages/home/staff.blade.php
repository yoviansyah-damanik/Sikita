<x-content>
    <div class="grid gap-4 sm:grid-cols-12">
        <div class="sm:col-span-3">
            <x-notification />
        </div>
        <div class="sm:col-span-9">
            <x-box-grid>
                <x-box color="green" icon="i-ph-student" :to="route('staff.student')" :title="__('Active Students')" :number="$activeStudents"></x-box>
                <x-box color="yellow" icon="i-ph-student" :to="route('staff.student', ['viewActive' => 'students_passed'])" :title="__('Students Passed')" :number="$studentsPassed"></x-box>
                <x-box color="red" icon="i-ph-student" :to="route('staff.student', ['viewActive' => 'student_registration'])" :title="__('Students Not Registered Yet')" :number="$studentsNotRegistered"></x-box>
                <x-box color="primary" icon="i-ph-student" :to="route('staff.student')" :title="__(':total Total', ['total' => __('Student')])"
                    :number="$allStudents"></x-box>
                <x-box color="primary" icon="i-ph-chalkboard-teacher-fill" :to="route('staff.lecturer')" :title="__(':total Total', ['total' => __('Lecturer')])"
                    :number="$lecturers"></x-box>
                <x-box color="primary" icon="i-ph-lego-smiley" :to="route('staff.staff')" :title="__(':total Total', ['total' => __('Staff')])"
                    :number="$staff"></x-box>
                <x-box color="yellow" icon="i-ph-signature" :to="route('staff.approval')" :title="__('Waiting for Approval')"
                    :number="$waitingForApproval"></x-box>
                <x-box color="green" icon="i-ph-signature" :to="route('staff.approval')" :title="__('Submissions Approved')"
                    :number="$submissionsApproval"></x-box>
                <x-box color="primary" icon="i-ph-signature" :title="__(':total Total', ['total' => __('Submission')])" :number="$submissions"></x-box>
                <x-box color="oceanBlue" icon="i-ph-book-open-text" :to="route('staff.guidance-group')" :title="__(':total Total', ['total' => __('Guidance Groups')])"
                    :number="$guidance_groups"></x-box>
                <x-box color="oceanBlue" icon="i-ph-book-open-text" :to="route('staff.guidance-group')" :title="__(':total Total', ['total' => __('Guidance Types')])"
                    :number="$guidance_types"></x-box>
                <x-box color="oceanBlue" icon="i-ph-book-open-text" :title="__('Guidance')" :number="$guidances"></x-box>
            </x-box-grid>
        </div>
    </div>
</x-content>
