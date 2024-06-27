<x-content>
    <div class="grid grid-cols-2 gap-3 sm:gap-4 sm:grid-cols-5">
        <x-box color="primary" icon="i-ph-student" :title="__('Student')" :number="rand(100, 100000)"></x-box>
        <x-box color="red" icon="i-ph-chalkboard-teacher-fill" :title="__('Lecturer')" :number="rand(100, 10000)"></x-box>
        <x-box color="green" icon="i-ph-lego-smiley" :title="__('Staff')"
            description="Lorem ipsum dolor, sit amet consectetur adipisicing elit. Temporibus, ullam."
            :number="rand(100, 1000000)"></x-box>
        <x-box color="yellow" icon="i-ph-signature" :title="__('Submission')"
            description="Lorem ipsum dolor, sit amet consectetur adipisicing elit. Temporibus, ullam."
            :number="rand(100, 1000000)"></x-box>
        <x-box color="oceanBlue" icon="i-ph-book-open-text" :title="__('Guidance')"
            description="Lorem ipsum dolor, sit amet consectetur adipisicing elit. Temporibus, ullam."
            :number="rand(100, 1000000)"></x-box>
    </div>

    <x-step />

    <div class="grid gap-4 sm:grid-cols-12">
        <div class="order-2 sm:col-span-3 sm:order-1">
            <x-notification />
        </div>
        <div class="order-1 sm:col-span-9 sm:order-2">
            <x-final-project :student="$student" />
        </div>
    </div>
</x-content>
