<?php

namespace App\Livewire\Staff\GuidanceGroup;

use Livewire\Component;
use App\Models\GuidanceType;
use App\Models\GuidanceGroup;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Delete extends Component
{
    use LivewireAlert;
    protected $listeners = ['setDelete', 'setDeleteSub', 'clearModal' => 'checkForm'];

    public $data;
    public $activeClass;

    public bool $isLoading = true;

    public string $nameLabel;
    public string $message;
    public string $title;

    public function render()
    {
        return view('pages.staff.guidance-group.delete');
    }

    public function checkForm()
    {
        $this->isLoading = true;
        $this->reset();
        $this->resetValidation();
        $this->isLoading = false;
    }

    public function setDelete(GuidanceGroup $guidanceGroup)
    {
        $this->checkForm();
        $this->data = $guidanceGroup;
        $this->nameLabel = __(':name Name', ['name' => __('Guidance Group')]);
        $this->message = __('You will delete all guidance groups along with the types contained in the group.');
        $this->title = __('Guidance Group');
        $this->activeClass = new GuidanceGroup();
    }

    public function setDeleteSub(GuidanceType $guidanceType)
    {
        $this->checkForm();
        $this->data = $guidanceType;
        $this->nameLabel = __(':name Name', ['name' => __('Guidance Type')]);
        $this->message = __('You will delete all types of guidance.');
        $this->title = __('Guidance Type');
        $this->activeClass = new GuidanceType();
    }

    public function destroy()
    {
        try {
            if ($this->activeClass == new GuidanceType()) {
                $this->data->delete();
            } else {
                $this->data->types()->delete();
                $this->data->delete();
            }

            $this->alert('success', __('Successfully'), ['text' => __(':attribute deleted successfully.', ['attribute' => $this->title])]);
            $this->dispatch('refreshGroup');
            $this->dispatch('toggle-delete-modal');
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
