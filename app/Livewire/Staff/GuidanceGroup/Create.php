<?php

namespace App\Livewire\Staff\GuidanceGroup;

use Livewire\Component;
use App\Models\GuidanceType;
use App\Models\GuidanceGroup;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Create extends Component
{
    use LivewireAlert;
    protected $listeners = ['setCreate', 'setCreateSub', 'clearModal'];

    public bool $isLoading = true;

    public $activeClass;
    public $guidance_group;

    public string $name;
    public string $description;
    public string $nameLabel;
    public string $title;

    public int $order = 0;

    public function render()
    {
        return view('pages.staff.guidance-group.create');
    }

    public function rules()
    {
        $rules = [
            'name' => 'required|string|between:5,200',
            'description' => 'required|string|between:10,500',
            'order' => 'required|numeric|min:0|max:10'
        ];

        if ($this->activeClass == new GuidanceType()) {
            $rules = [
                ...$rules,
                'guidance_group' => Rule::in(GuidanceGroup::get('id')->pluck('id')->toArray())
            ];
        }

        return $rules;
    }

    public function validationAttributes()
    {
        return [
            'name' => $this->nameLabel,
            'description' => __('Description'),
            'order' => __('Order'),
            'guidance_group' => __('Guidance Group'),
        ];
    }

    public function checkForm()
    {
        $this->isLoading = true;
        $this->resetValidation();
        $this->isLoading = false;
    }

    public function setCreate()
    {
        $this->checkForm();
        $this->activeClass = new GuidanceGroup();
        $this->nameLabel = __(':name Name', ['name' => __('Guidance Group')]);
        $this->title = __('Guidance Group');
    }

    public function setCreateSub(GuidanceGroup $guidanceGroup)
    {
        $this->checkForm();
        $this->guidance_group = $guidanceGroup->id;
        $this->activeClass = new GuidanceType();
        $this->nameLabel = __(':name Name', ['name' => __('Guidance Type')]);
        $this->title = __('Guidance Type');
    }

    public function store()
    {
        $this->validate();
        try {
            if ($this->activeClass == new GuidanceType()) {
                $this->activeClass::create([
                    'guidance_group_id' => $this->guidance_group,
                    'name' => $this->name,
                    'description' => $this->description,
                    'order' => $this->order,
                ]);
            } else {
                $this->activeClass::create([
                    'name' => $this->name,
                    'description' => $this->description,
                    'order' => $this->order,
                ]);
            }

            $this->alert('success', __('Successfully'), ['text' => __(':attribute created successfully.', ['attribute' => $this->title])]);
            $this->dispatch('refreshGroup');
            $this->dispatch('toggle-create-modal');
            $this->reset('name', 'description');
            $this->isLoading = false;
        } catch (\Exception $e) {
            $this->alert('error', __('Something went wrong'), ['text' => $e->getMessage()]);
            $this->isLoading = false;
        } catch (\Throwable $e) {
            $this->alert('error', __('Something went wrong'), ['text' => $e->getMessage()]);
            $this->isLoading = false;
        }
    }
}
