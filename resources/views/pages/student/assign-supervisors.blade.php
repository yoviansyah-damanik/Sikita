<div>
    <x-modal.body>
        @if (!$isLoading)
            @if ($this->supervisor_1 && $this->supervisor_2)
                <div class="space-y-3 sm:space-y-4">
                    <x-alert type="info" :closeButton="false">
                        {{ __('Supervisor 1 and Supervisor 2 cannot be the same.') }}
                    </x-alert>
                    <x-alert :closeButton="false">
                        <div class="space-y-1">
                            <div class="flex">
                                <div class="w-40">
                                    {{ 'NPM' }}
                                </div>
                                <div class="flex-1 font-semibold">
                                    {{ $student->id }}
                                </div>
                            </div>
                            <div class="flex">
                                <div class="w-40">
                                    {{ __('Fullname') }}
                                </div>
                                <div class="flex-1 font-semibold">
                                    {{ $student->name }}
                                </div>
                            </div>
                        </div>
                    </x-alert>
                    <x-form.select-with-search :loading="$isLoading" error="{{ $errors->first('selected_supervisor_1') }}"
                        wire:model.blur='selected_supervisor_1' block :label="__('Supervisor :1', ['1' => 1])" :items="$supervisor_1" />
                    <x-form.select-with-search :loading="$isLoading" error="{{ $errors->first('selected_supervisor_2') }}"
                        wire:model.blur='selected_supervisor_2' block :label="__('Supervisor :1', ['1' => 2])" :items="$supervisor_2" />
                </div>
            @else
                <div class="flex flex-col items-center justify-center gap-4">
                    <x-no-data />

                    {{ __('Please add lecturers first.') }}
                    <x-button color="primary" :href="route('staff.lecturer')" icon="i-ph-plus">
                        {{ __('Add :add', ['add' => __('Lecturer')]) }}
                    </x-button>
                </div>
            @endif
        @else
            <x-loading />
        @endif
    </x-modal.body>
    @if ($this->supervisor_1 && $this->supervisor_2)
        <x-modal.footer>
            <x-button color="primary" wire:click='save' :loading="$isLoading">
                {{ __('Save') }}
            </x-button>
        </x-modal.footer>
    @endif
</div>
