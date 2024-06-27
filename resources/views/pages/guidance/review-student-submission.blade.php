<div @class([
    'relative p-4 rounded-lg group/student-submission sm:p-6',
    'hover:bg-primary-50/40 cursor-pointer' => !$isActive,
    'pointer-events-none bg-primary-50' => $isActive,
]) wire:click="setSubmission({{ $submission['id'] }})">
    <div class="flex-1">
        <div @class([
            'font-semibold line-clamp-2',
            'text-primary-700' => $isActive,
        ])>
            {{ $submission['title'] }}
        </div>
        <div class="text-sm font-light">
            {{ \Carbon\Carbon::parse($submission['created_at'])->translatedFormat('d F Y H:i:s') }}
        </div>
    </div>
</div>
