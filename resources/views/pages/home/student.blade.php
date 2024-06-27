<x-content>
    <x-student-information :student="$student" />

    <div class="grid gap-4 sm:grid-cols-12">
        <div class="order-2 sm:col-span-3 sm:order-1">
            <x-notification />
        </div>
        <div class="order-1 sm:col-span-9 sm:order-2">
            <x-final-project :student="$student" />
        </div>
    </div>
</x-content>
