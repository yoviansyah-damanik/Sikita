<div>
    <x-modal.body>
        <x-form.input :loading="$isLoading" :label="__('Title')" block :placeholder="__('Entry :entry', ['entry' => Str::lower(__('Title'))])" type='text'
            error="{{ $errors->first('title') }}" wire:model.blur='title' required :info="__(':Attribute must contain between :min to :max characters.', [
                'Attribute' => __('Title'),
                'min' => 10,
                'max' => 200,
            ]) .
                ' | ' .
                __('Example') .
                ': Bimbingan BAB 1 / Perubahan BAB 1'" />
        <x-form.file :loading="$isLoading" accept="application/pdf" :label="__('File')" block :placeholder="__('Entry :entry', ['entry' => Str::lower(__('File'))])"
            error="{{ $errors->first('file') }}" wire:model.blur='file' required :info="__('PDF Only') .
                ' | ' .
                __('The :attribute field must not be greater than :max kilobytes.', [
                    'Attribute' => __('File'),
                    'max' => 5 * 1024,
                ])" />
        <x-form.textarea :loading="$isLoading" rows="5" :label="__('Description')" block :placeholder="__('Entry :entry', ['entry' => Str::lower(__('Description'))])"
            error="{{ $errors->first('description') }}" limit=200 wire:model.blur='description' required
            :info="__(':Attribute must contain between :min to :max characters.', [
                'Attribute' => __('Description'),
                'min' => 10,
                'max' => 200,
            ])" />
    </x-modal.body>
    <x-modal.footer>
        <x-button wire:click="refresh" :loading="$isLoading">
            {{ __('Reset') }}
        </x-button>

        <x-button color="primary" wire:click='store' :loading="$isLoading">
            {{ __('Save') }}
        </x-button>
    </x-modal.footer>
</div>
