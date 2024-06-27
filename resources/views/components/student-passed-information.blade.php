<div class="flex gap-3">
    <div class="flex-1">
        <div
            class="p-6 text-center bg-white border-b-8 rounded-lg shadow dark:bg-slate-800 sm:p-8 border-primary-700 dark:border-primary-300">
            <div class="mb-4 font-semibold text-primary-700 dark:text-primary-300">
                {{ __('Grade') }}
            </div>
            <div class="font-bold text-8xl dark:text-ocean-blue-100">
                {{ $grade }}
            </div>
        </div>
    </div>
    <div class="flex-1">
        <div
            class="p-6 text-center bg-white border-b-8 rounded-lg shadow dark:bg-slate-800 sm:p-8 border-primary-700 dark:border-primary-300">
            <div class="mb-4 font-semibold text-primary-700 dark:text-primary-300">
                {{ __('Grade in Numbers') }}
            </div>
            <div class="font-bold text-8xl dark:text-ocean-blue-100">
                {{ $gradeNumber }}
            </div>
        </div>
    </div>
</div>
