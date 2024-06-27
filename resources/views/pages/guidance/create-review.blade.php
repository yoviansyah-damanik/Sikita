<div class="p-4">
    <div class="mb-6 space-y-3 sm:space-y-4">
        <x-form.textarea :loading="$isLoading || $isFinish" rows="3" :label="__('Review')" block :placeholder="__('Entry :entry', ['entry' => Str::lower(__('Review'))])"
            error="{{ $errors->first('review') }}" :content="$review" limit=400 wire:model.blur='review' required
            :info="__(':Attribute must contain between :min to :max characters.', [
                'Attribute' => __('Review'),
                'min' => 10,
                'max' => 400,
            ])" />
        @if (!$isFinish)
            <div>
                <div class="flex items-center overflow-hidden shadow rounded-xl">
                    @foreach ($allStatus as $idx => $item)
                        <label for="type-{{ $idx + 1 }}"
                            class="relative flex-1 gap-1 overflow-hidden border-r cursor-pointer last:border-r-0">
                            <input name="type" wire:loading.attr='disabled' wire:model.blur='status'
                                class="hidden peer/type" id="type-{{ $idx + 1 }}" type="radio"
                                value="{{ $item }}" @disabled($isLoading) />
                            <div
                                class="w-full px-3 py-2 font-medium text-center text-gray-700 bg-primary-50 peer-checked/type:text-gray-100 peer-checked/type:bg-primary-700 peer-checked/type:opacity-100 ">
                                {{ __(Str::ucfirst($item)) }}
                            </div>
                        </label>
                    @endforeach
                </div>
                @error('type')
                    <div class="mt-1 text-red-700">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        @endif
        <div class="text-sm font-light text-center italic">{{ __('Last Update') }}: {{ $action_time }}</div>
    </div>
    @if (!$isFinish)
        <x-button block wire:click='submit' radius="rounded-xl" color="primary">
            {{ __('Save') }}
        </x-button>
    @endif
</div>
