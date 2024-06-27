<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Helpers\GeneralHelper;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Configuration extends Component
{
    use LivewireAlert;

    public $app_name;
    public $app_fullname;
    public $is_open;
    public $odd_semester;
    public $even_semester;
    public $start_date;
    public $end_date;

    public array $isOpenTypes;

    public function mount()
    {
        $this->app_name = GeneralHelper::appName();
        $this->app_fullname = GeneralHelper::appFullname();
        $this->odd_semester = GeneralHelper::oddSemester();
        $this->even_semester = GeneralHelper::evenSemester();

        $this->isOpenTypes = [
            [
                'title' => __('Yes'),
                'value' => 1
            ],
            [
                'title' => __('No'),
                'value' => 0
            ]
        ];
    }

    public function render()
    {
        return view('pages.configuration')
            ->title(__('Configuration'));
    }

    public function rules()
    {
        return [
            'app_name' => 'required|string|max:20',
            'app_fullname' => 'required|string|max:100',
            'is_open' => 'required|boolean',
            'odd_semester' => ['required', 'regex:/^([0-9]|0[0-9]|1[0-9]|2[0-9]|3[0-1])-[0-1][1-9]$/'],
            'even_semester' => ['required', 'regex:/^([0-9]|0[0-9]|1[0-9]|2[0-9]|3[0-1])-[0-1][1-9]$/'],
        ];
    }

    public function validationAttributes()
    {
        return [
            'app_name' => __('App Name'),
            'app_fullname' => __('App Fullname'),
            'odd_semester' => __('Odd Semester'),
            'even_semester' => __('Even Semester'),
        ];
    }

    public function updated($attribute)
    {
        $this->validateOnly($attribute);

        DB::beginTransaction();
        try {
            \App\Models\Configuration::where('attribute', $attribute)
                ->update(['value' => $this->{$attribute}]);

            DB::commit();
            $this->alert('success', __('Successfully'), ['text' => __(':attribute updated successfully.', ['attribute' => $this->validationAttributes()[$attribute]])]);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->alert('error', __('Something went wrong'), ['text' => $e->getMessage()]);
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->alert('error', __('Something went wrong'), ['text' => $e->getMessage()]);
        }
    }
}
