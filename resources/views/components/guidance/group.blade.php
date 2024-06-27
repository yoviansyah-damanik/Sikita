<div x-data="{ id: $id('group') }" class="p-6 bg-white rounded-lg dark:bg-slate-800 sm:p-8" :id="id">
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
            <x-guidance.type :$type />
        @empty
            <x-no-data />
        @endforelse
    </div>
</div>
