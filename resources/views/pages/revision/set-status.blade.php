<div>
    <x-modal.body>
        @if (!$isLoading)
            @if ($revision)
                <div class="flex items-center overflow-hidden shadow rounded-xl">
                    @foreach ($revisionTypes as $idx => $item)
                        <label for="revision-{{ $idx + 1 }}"
                            class="relative flex-1 gap-1 overflow-hidden border-r cursor-pointer last:border-r-0">
                            <input name="revision" wire:loading.attr='disabled' wire:model.blur='status'
                                class="hidden peer/type" id="revision-{{ $idx + 1 }}" type="radio"
                                value="{{ $item }}" @disabled($isLoading) />
                            <div
                                class="w-full px-3 py-2 font-medium text-center text-gray-700 bg-primary-50 peer-checked/type:text-gray-100 peer-checked/type:bg-primary-700 peer-checked/type:opacity-100 ">
                                {{ __(Str::headline($item)) }}
                            </div>
                        </label>
                    @endforeach
                </div>
                @error('status')
                    <div class="mt-1 text-red-700">
                        {{ $message }}
                    </div>
                @enderror
            @else
                <x-no-data />
            @endif
        @else
            <x-loading />
        @endif
    </x-modal.body>
    <x-modal.footer>
        <x-button color="primary" wire:click='save' :loading="$isLoading">
            {{ __('Save') }}
        </x-button>
    </x-modal.footer>
</div>
