<div>
    <x-modal.body>
        <x-form.input :loading="$isLoading" :label="__('Title')" block :placeholder="__('Entry :entry', ['entry' => Str::lower(__('Title'))])" type='text'
            error="{{ $errors->first('title') }}" wire:model.blur='title' required :info="__(':Attribute must contain between :min to :max characters.', [
                'Attribute' => __('Title'),
                'min' => 10,
                'max' => 200,
            ])" />
        <x-form.textarea :loading="$isLoading" rows="8" :label="__('Abstract')" block :placeholder="__('Entry :entry', ['entry' => Str::lower(__('Abstract'))])"
            error="{{ $errors->first('abstract') }}" limit=400 wire:model.blur='abstract' required :info="__(':Attribute must contain between :min to :max characters.', [
                'Attribute' => __('Abstract'),
                'min' => 10,
                'max' => 400,
            ])" />
    </x-modal.body>
    <x-modal.footer>
        <x-button wire:click="refresh" :loading="$isLoading">
            {{ __('Reset') }}
        </x-button>

        <x-button color="primary" wire:click='save' :loading="$isLoading">
            {{ __('Save') }}
        </x-button>
    </x-modal.footer>
</div>
