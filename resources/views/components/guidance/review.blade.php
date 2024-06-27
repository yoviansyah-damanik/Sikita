<div x-data="{ id: $id('review') }" :id="id" @class([
    'relative p-4 text-sm bg-white border rounded-lg overflow-hidden dark:bg-slate-800 dark:text-gray-100 text-center',
    'border-primary-700 text-primary-700' => !$reviewer['status'],
    'border-green-700 text-green-700' => $reviewer['status'] == 'approved',
    'border-yellow-700 text-yellow-700' => $reviewer['status'] == 'revision',
])>
    {{ __('Supervisor :1', ['1' => $iteration]) }}
    <div class="p-4 text-center sm:p-6">
        <span @class([
            'size-8',
            'i-ph-minus-bold' => !$reviewer['status'],
            'i-ph-pencil-simple-line-bold' => $reviewer['status'] == 'revision',
            'i-ph-check-bold' => $reviewer['status'] == 'approved',
        ])></span>
    </div>
    <div class="font-light text-center">
        {{ $reviewer['action_time'] ? \Carbon\Carbon::parse($reviewer['action_time'])->translatedFormat('d F Y H:i:s') : '-' }}
    </div>
    @if (auth()->user()->role == 'lecturer' && $reviewer['nidn'] == auth()->user()->data->id)
        <div @class([
            'absolute bottom-0 left-0 w-8 h-8 rotate-45 -translate-x-1/2 -translate-y-1/2 top-1/2',
            'bg-primary-700 ' => !$reviewer['status'],
            'bg-green-700' => $reviewer['status'] == 'approved',
            'bg-yellow-700' => $reviewer['status'] == 'revision',
        ])>
        </div>
    @endif
</div>
