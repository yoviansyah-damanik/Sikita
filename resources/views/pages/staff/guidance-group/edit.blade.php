<div>
    <x-modal.body>
        <x-form.input :loading="$isLoading" :label="$nameLabel" block :placeholder="__('Entry :entry', ['entry' => Str::lower(__('Name'))])" type='text'
            error="{{ $errors->first('name') }}" wire:model.blur='name' required :info="__(':Attribute harus berisi antara :min sampai :max karakter.', [
                'Attribute' => $nameLabel,
                'min' => 5,
                'max' => 200,
            ])" />
        <x-form.textarea :loading="$isLoading" rows="8" :label="__('Description')" block :placeholder="__('Entry :entry', ['entry' => Str::lower(__('Description'))])"
            error="{{ $errors->first('description') }}" limit=500 wire:model.blur='description' required
            :info="__(':Attribute harus berisi antara :min sampai :max karakter.', [
                'Attribute' => __('Description'),
                'min' => 10,
                'max' => 500,
            ])" />
        <x-form.select :label="__('Order')" :items="collect(range(0, 10))->map(fn($x) => ['title' => $x, 'value' => $x])->toArray()" block error="{{ $errors->first('order') }}"
            wire:model.blur='order' :info="__('The same order will be determined according to the date added.')" required />
    </x-modal.body>
    <x-modal.footer>
        <x-button color="yellow" wire:click='update' :loading="$isLoading">
            {{ __('Edit') }}
        </x-button>
    </x-modal.footer>
</div>
