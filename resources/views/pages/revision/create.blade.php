<div>
    <x-modal.body>
        <x-form.input :loading="$isLoading" :label="__('Title')" block :placeholder="__('Entry :entry', ['entry' => Str::lower(__('Title'))])" type='text'
            error="{{ $errors->first('title') }}" wire:model.blur='title' required :info="__(':Attribute must contain between :min to :max characters.', [
                'Attribute' => __('Title'),
                'min' => 10,
                'max' => 200,
            ])" />
        <x-form.textarea-wysiwyg :loading="$isLoading" :label="__('Explanation')" block :placeholder="__('Entry :entry', ['entry' => Str::lower(__('Explanation'))])"
            error="{{ $errors->first('explanation') }}" wire:model.live='explanation' required />
    </x-modal.body>
    <x-modal.footer>
        <x-button wire:click="refresh" :loading="$isLoading">
            {{ __('Reset') }}
        </x-button>

        <x-button color="primary" wire:click='store' :loading="$isLoading">
            {{ __('Create') }}
        </x-button>
    </x-modal.footer>
</div>
