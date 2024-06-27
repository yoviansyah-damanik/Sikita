<div>
    <x-modal.body>
        <x-form.input :loading="$isLoading" :label="__('Title')" block :placeholder="__('Entry :entry', ['entry' => Str::lower(__('Title'))])" type='text'
            error="{{ $errors->first('title') }}" wire:model.blur='title' required :info="__(':Attribute must contain between :min to :max characters.', [
                'Attribute' => __('Title'),
                'min' => 10,
                'max' => 200,
            ])" />
        <x-form.textarea-wysiwyg :loading="$isLoading" :label="__('Explanation')" block :placeholder="__('Entry :entry', ['entry' => Str::lower(__('Explanation'))])"
            error="{{ $errors->first('explanation') }}" wire:model.blur='explanation' required />
    </x-modal.body>
    <x-modal.footer>
        <x-button color="primary" wire:click='update' :loading="$isLoading">
            {{ __('Update') }}
        </x-button>
    </x-modal.footer>
</div>
