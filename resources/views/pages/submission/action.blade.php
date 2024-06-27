<div>
    <x-modal.body>
        @if (!$isLoading)
            <div class="flex flex-col divide-y">
                <div class="space-y-3 sm:space-y-4">
                    <div class="mb-4 space-y-2 sm:space-y-3">
                        <div class="flex">
                            <div class="w-24 font-semibold sm:w-48 text-primary-700 dark:text-primary-300">
                                {{ __(':name Name', ['name' => __('Student')]) }}</div>
                            <div class="flex-1 dark:text-gray-100">{{ $submission->student->name }}</div>
                        </div>
                        <div class="flex">
                            <div class="w-24 font-semibold sm:w-48 text-primary-700 dark:text-primary-300">
                                {{ __('Title') }}</div>
                            <div class="flex-1 dark:text-gray-100">{{ $submission->title }}</div>
                        </div>
                        <div class="flex">
                            <div class="w-24 font-semibold sm:w-48 text-primary-700 dark:text-primary-300">
                                {{ __('Abstract') }}</div>
                            <div class="flex-1 break-all dark:text-gray-100">{{ $submission->abstract }}</div>
                        </div>
                        <div class="flex">
                            <div class="w-24 font-semibold cursor sm:w-48 text-primary-700 dark:text-primary-300">
                                {{ __('Submission Time') }}
                            </div>
                            <div class="flex-1 dark:text-gray-100">
                                {{ $submission->created_at->translatedFormat('d F Y H:i:s') }}</div>
                        </div>
                        <div class="flex">
                            <div class="w-24 font-semibold sm:w-48 text-primary-700 dark:text-primary-300">
                                {{ __('Status') }}</div>
                            <div class="flex-1 dark:text-gray-100">
                                <x-badge :type="$submission['status'] == 'process'
                                    ? 'info'
                                    : ($submission['status'] == 'approved'
                                        ? 'success'
                                        : ($submission['status'] == 'rejected'
                                            ? 'error'
                                            : 'warning'))">
                                    {{ __(Str::ucfirst($submission['status'])) }}
                                </x-badge>
                            </div>
                        </div>
                        @if ($submission['status'] != 'process')
                            <div class="flex">
                                <div class="w-24 font-semibold cursor sm:w-48 text-primary-700 dark:text-primary-300">
                                    {{ __('Action Time') }}
                                </div>
                                <div class="flex-1 dark:text-gray-100">
                                    {{ $submission->updated_at->translatedFormat('d F Y H:i:s') }}</div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="pt-3 sm:pt-4">
                    <div class="flex items-center overflow-hidden shadow rounded-xl">
                        @foreach ($types as $idx => $item)
                            <label for="type-{{ $idx + 1 }}"
                                class="relative flex-1 gap-1 overflow-hidden border-r cursor-pointer last:border-r-0">
                                <input name="type" wire:loading.attr='disabled' wire:model.live='type'
                                    class="hidden peer/type" id="type-{{ $idx + 1 }}" type="radio"
                                    value="{{ $item }}" />
                                <div
                                    class="w-full px-3 py-2 font-medium text-center text-gray-700 bg-primary-50 peer-checked/type:text-gray-100 peer-checked/type:bg-primary-700 peer-checked/type:opacity-100 ">
                                    {{ __(Str::ucfirst($item)) }}
                                </div>
                            </label>
                        @endforeach
                    </div>

                    @if ($type == 'revision')
                        <div class="mt-3 sm:mt-4">
                            <x-form.textarea :loading="$isLoading" rows="8" :label="__('Revision')" block :placeholder="__('Entry :entry', ['entry' => Str::lower(__('Revision'))])"
                                error="{{ $errors->first('revisionText') }}" limit=300 wire:model.blur='revisionText'
                                required :info="__(':Attribute harus berisi antara :min sampai :max karakter.', [
                                    'Attribute' => __('Revision'),
                                    'min' => 10,
                                    'max' => 300,
                                ])" />
                        </div>
                    @endif
                </div>
            </div>
        @else
            <x-loading />
        @endif
    </x-modal.body>
    <x-modal.footer>
        <x-button color="green" wire:click='submit' :loading="$isLoading">
            {{ __('Save') }}
        </x-button>
    </x-modal.footer>
</div>
