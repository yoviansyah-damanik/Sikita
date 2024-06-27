<x-content>
    <x-content.title :title="__('Configurations')" :description="__('Manage system configuration.')" />

    <div class="w-full max-w-4xl p-6 bg-white shadow dark:bg-slate-800 rounded-xl sm:p-8">
        <div class="mb-6 font-semibold text-ocean-blue-700">
            {{ __('Adjust System Configuration') }}
        </div>
        <div class="mb-6 space-y-3 sm:space-y-4">
            <x-form.input :label="__('App Name')" block :placeholder="__('Entry :entry', ['entry' => Str::lower(__('App Name'))])" type='text'
                error="{{ $errors->first('app_name') }}" wire:model.blur='app_name' />
            <x-form.input :label="__('App Fullname')" block :placeholder="__('Entry :entry', ['entry' => Str::lower(__('App Fullname'))])" type='text'
                error="{{ $errors->first('app_fullname') }}" wire:model.blur='app_fullname' />
            <x-form.input :label="__('Odd Semester')" block :placeholder="__('Entry :entry', ['entry' => Str::lower(__('Odd Semester'))])" type='text'
                error="{{ $errors->first('odd_semester') }}" wire:model.blur='odd_semester' :info="__('You will enter an odd semester if you enter the date above. Format: (Date)-(Month)')" />
            <x-form.input :label="__('Even Semester')" block :placeholder="__('Entry :entry', ['entry' => Str::lower(__('Even Semester'))])" type='text'
                error="{{ $errors->first('even_semester') }}" wire:model.blur='even_semester' :info="__('You will enter an even semester if you enter the date above. Format: (Date)-(Month)')" />
        </div>
    </div>

</x-content>
