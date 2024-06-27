<div class="flex gap-3">
    @if (!empty($submission['histories']))
        <span @class([
            'size-4 mt-1',
            'i-solar-check-circle-line-duotone text-green-700' =>
                $submission['histories'][0]['status'] == 'success',
            'i-solar-danger-circle-line-duotone text-yellow-700' =>
                $submission['histories'][0]['status'] == 'warning',
            'i-solar-bell-bing-bold-duotone text-cyan-700' =>
                $submission['histories'][0]['status'] == 'information',
        ])></span>
        <div class="flex-1">
            {{ $submission['histories'][0]['message'] }}
        </div>
    @else
        -
    @endif
</div>
