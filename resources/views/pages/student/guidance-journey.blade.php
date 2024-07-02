<div>
    @if (!empty($student['final_project']))
        <x-table :columns="['#', __('Guidance Group'), '#', __('Guidance Type'), __('Status')]">
            <x-slot:body>
                @foreach ($student['final_project']['guidances'] as $idx => $guidance)
                    <x-table.tr>
                        <x-table.td centered
                            rowspan="{{ count($guidance['types']) > 0 ? count($guidance['types']) + 1 : 2 }}">
                            {{ $idx + 1 }}
                        </x-table.td>
                        <x-table.td rowspan="{{ count($guidance['types']) > 0 ? count($guidance['types']) + 1 : 2 }}">
                            {{ $guidance['name'] }}
                        </x-table.td>
                        @if (count($guidance['types']) > 0)
                            <x-table.td centered>
                                {{ $idx + 1 . '.1' }}
                            </x-table.td>
                            <x-table.td>
                                {{ $guidance['types'][0]['name'] }}
                            </x-table.td>
                            <x-table.td centered>
                                {{ $guidance['types'][0]['is_reviewed'] ? __('Finish') : __('Not Finished Yet') }}
                            </x-table.td>
                        @else
                            <x-table.td colspan=3 centered>
                                {{ __('No data found') }}
                            </x-table.td>
                        @endif
                    </x-table.tr>
                    @if (count($guidance['types']) > 1)
                        @foreach (collect($guidance['types'])->skip(1) as $idx_ => $type)
                            <x-table.tr>
                                <x-table.td centered>
                                    {{ $idx + 1 . '.' . $idx_ + 1 }}
                                </x-table.td>
                                <x-table.td>
                                    {{ $type['name'] }}
                                </x-table.td>
                                <x-table.td centered>
                                    {{ $type['is_reviewed'] ? __('Finish') : __('Not Finished Yet') }}
                                </x-table.td>
                            </x-table.tr>
                        @endforeach
                    @endif
                    <x-table.tr>
                        <x-table.td colspan=3>
                            {{ __(':status Status', ['status' => __('Overall')]) }}:
                            <strong>
                                {{ $guidance['is_finish'] ? __('Finish') : __('Not Finished Yet') }}
                            </strong>
                        </x-table.td>
                    </x-table.tr>
                @endforeach
                <x-table.tr>
                    <x-table.td colspan="5">
                        <div class="flex items-center justify-between">
                            <div>
                                {{ __(':status Status', ['status' => __('Overall')]) }}:
                                <strong>
                                    {{ $student['is_finish'] ? __('Finish') : __('Not Finished Yet') }}
                                </strong>
                            </div>
                            @if ($student['is_finish'])
                                <div class="flex items-center gap-3">
                                    <div wire:loading>
                                        <x-loading />
                                    </div>
                                    <x-button wire:click='print' size="sm" color="primary" :loading="$isLoading"
                                        icon="i-ph-download">{{ __('Download the Guidance Completion Mark') }}</x-button>
                                </div>
                            @endif
                        </div>
                    </x-table.td>
                </x-table.tr>
            </x-slot:body>
        </x-table>
    @else
        {{ __('The student does not yet have a Final Assignment for guidance.') }}
    @endif
</div>
