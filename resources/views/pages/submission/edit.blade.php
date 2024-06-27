<div>
    <x-modal.body>
        <x-form.input :loading="$isLoading" :label="__('Title')" block :placeholder="__('Entry :entry', ['entry' => Str::lower(__('Title'))])" type='text'
            error="{{ $errors->first('title') }}" wire:model.blur='title' required :info="__(':Attribute must contain between :min to :max characters.', [
                'Attribute' => __('Title'),
                'min' => 20,
                'max' => 200,
            ])" />
        <x-form.textarea :loading="$isLoading" rows="8" :label="__('Abstract')" block :placeholder="__('Entry :entry', ['entry' => Str::lower(__('Abstract'))])"
            error="{{ $errors->first('abstract') }}" limit=500 wire:model.blur='abstract' required :info="__(':Attribute must contain between :min to :max characters.', [
                'Attribute' => __('Abstract'),
                'min' => 50,
                'max' => 500,
            ])" />
    </x-modal.body>
    <x-modal.footer>
        <x-button color="primary" wire:click='update' :loading="$isLoading">
            {{ __('Save') }}
        </x-button>
    </x-modal.footer>
</div>
