<?php

namespace App\Livewire\Staff\GuidanceGroup;

use App\Models\GuidanceGroup;
use App\Models\GuidanceType;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Edit extends Component
{
    use LivewireAlert;
    protected $listeners = ['setEdit', 'setEditSub'];

    public $data;
    public bool $isLoading = true;

    public string $title;
    public string $name;
    public string $nameLabel = "Label";
    public string $description;

    public int $order;

    public function render()
    {
        return view('pages.staff.guidance-group.edit');
    }

    public function rules()
    {
        return [
            'name' => 'required|string|between:5,200',
            'description' => 'required|string|between:10,500',
            'order' => 'required|numeric|min:0|max:10'
        ];
    }

    public function validationAttributes()
    {
        return [
            'name' => $this->nameLabel,
            'description' => __('Description'),
            'order' => __('Order')
        ];
    }

    public function checkForm()
    {
        $this->isLoading = true;
        $this->reset();
        $this->resetValidation();
        $this->isLoading = false;
    }

    public function setEdit(GuidanceGroup $guidanceGroup)
    {
        $this->checkForm();
        $this->data = $guidanceGroup;
        $this->nameLabel = __(':name Name', ['name' => __('Guidance Group')]);
        $this->title = __('Guidance Group');
        $this->name = $guidanceGroup->name;
        $this->description = $guidanceGroup->description;
        $this->order = $guidanceGroup->order;
    }

    public function setEditSub(GuidanceType $guidanceType)
    {
        $this->checkForm();
        $this->data = $guidanceType;
        $this->nameLabel = __(':name Name', ['name' => __('Guidance Type')]);
        $this->title = __('Guidance Type');
        $this->name = $guidanceType->name;
        $this->description = $guidanceType->description;
        $this->order = $guidanceType->order;
    }

    public function update()
    {
        $this->validate();
        try {
            $this->data->update([
                'name' => $this->name,
                'description' => $this->description,
                'order' => $this->order,
            ]);

            $this->alert('success', __('Successfully'), ['text' => __(':attribute updated successfully.', ['attribute' => $this->title])]);
            $this->dispatch('toggle-edit-modal');
            $this->dispatch('refreshGroup');
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
